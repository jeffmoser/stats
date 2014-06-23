<?php
/**
 * Plugin Name: Blue Million Live Stats
 * Plugin URI: 
 * Description: Dynamic live stats from Blue Million
 * Version: 0.8
 * Author: Blue Million LLC
 * Author URI: www.bluemillion.com
 * License: 
 */

/**
 * (The MIT License)

  Copyright (c) 2012 Marcin Warpechowski <marcin@nextgen.pl>

  Permission is hereby granted, free of charge, to any person obtaining
  a copy of this software and associated documentation files (the
  'Software'), to deal in the Software without restriction, including
  without limitation the rights to use, copy, modify, merge, publish,
  distribute, sublicense, and/or sell copies of the Software, and to
  permit persons to whom the Software is furnished to do so, subject to
  the following conditions:

  The above copyright notice and this permission notice shall be
  included in all copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND,
  EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
  MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
  IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
  CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
  TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
  SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
class BlueMillonStatsLoader {
    
    /**
	 * plugin version
	 *
	 * @var string
	 */
	var $version = '1.0';
	
	
	/**
	 * database version
	 *
	 * @var string
	 */
	var $dbVersion = '1.1';
	
		
	/**
	 * admin Panel object
	 *
	 * @var object
	 */
	var $adminPanel;
    
    
    /**
     * Stored options
     * 
     * @var mixed
     */
    var $options;
    
    
    /**
     *
     * @var object
     */
    var $displayPage;
    
    
    /**
     *
     * @var bool
     */
    var $activationRun = false;
    
    
    
    /**
	 * constructor
	 *
	 * @param none
	 * @return void
	 */
	function __construct()
	{
		global $wpdb; //, $bmStatsPage;
        
        //$this->displayPage = $bmStatsPage;
        
        
		$wpdb->show_errors();
		$this->loadOptions();
		$this->defineConstants();
		$this->defineTables();
		//$this->loadLibraries();

   		register_activation_hook(__FILE__, array(&$this, 'activate') );

        
        add_action('init', array(&$this, 'loadController') );
        add_action('init', array(&$this, 'loadFrontEndScripts'));
		add_action('init', array(&$this, 'loadStyles') );
        
			
		if (function_exists('register_deactivation_hook'))
			register_deactivation_hook(__FILE__, array( $this, 'uninstall'));

        add_action('plugins_loaded', array(&$this, 'updateCheck'));
        
        if(!$this->activationRun) {
            add_shortcode('bmLiveStats', array(&$this, 'handleShortcode'));
        }
        
        
        add_action( 'wp_ajax_show_performance_form', array(&$this, 'show_performance_form') );
        add_action( 'wp_ajax_save_handson_table', array(&$this, 'save_handson_table') );
        add_action( 'wp_ajax_update_stats_table', array(&$this, 'update_stats_table') );
        add_action( 'wp_ajax_nopriv_update_stats_table', array(&$this, 'update_stats_table') );

	}
    
    
    
    
    /**
	 * Activate plugin
	 *
	 * @param none
	 */
	function activate()
	{
        update_option( 'bmlivestats-version', $this->version );
        update_option( 'bmlivestats-db-version', $this->dbVersion );
        //add_option( 'bmlivestats_widget', array(), 'BM Live Stats Widget Options', 'yes' );
		
        /*
		* Set Capabilities
		*/
		$role = get_role('administrator');
		$role->add_cap('manage_events');
		$role->add_cap('manage_athletes');
        $role->add_cap('bm-live-stats');
	
		$role = get_role('editor');
		$role->add_cap('bm-live-stats');
    
		$this->install();
        
        $this->activationRun = true;
	}
		
		
    
    
    

    /**
     * Install the database tables 
     */
    public function install() {
        global $wpdb;

        //include_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

        $charset_collate = '';
        if ($wpdb->has_cap('collation')) {
            if (!empty($wpdb->charset))
                $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
            if (!empty($wpdb->collate))
                $charset_collate .= " COLLATE $wpdb->collate";
        }
        
        
        
        $eventsSql = "CREATE TABLE {$wpdb->bmlivestats_events} (
                        `event_id` int(11) NOT NULL AUTO_INCREMENT,
                        `name` varchar(50) NOT NULL,
                        `location` varchar(50) NOT NULL,
                        `created` datetime NOT NULL,
                        `created_by` varchar(20) NOT NULL,
                        `is_published` tinyint(1) NOT NULL,
                        PRIMARY KEY (`event_id`)
                      )  $charset_collate;";  
                      
        $wpdb->query( $eventsSql );
        
        $eventTypeSql = "CREATE TABLE {$wpdb->bmlivestats_event_type} (
                        `event_type_id` int(11) NOT NULL AUTO_INCREMENT,
                        `type_name` varchar(100) NOT NULL,
                        PRIMARY KEY (`event_type_id`)
                    )  $charset_collate;";
        $eventTypeData = "INSERT INTO `{$wpdb->bmlivestats_event_type}` (`event_type_id`, `type_name`) VALUES
                            (NULL, 'Bareback'),
                            (NULL, 'Bareback Broncs'),
                            (NULL, 'Steer Wrestling'),
                            (NULL, 'Barrel Racing'),
                            (NULL, 'Tie-Down Roping'),
                            (NULL, 'Team Roping'),
                            (NULL, 'Bull Riding')";  
                      
        $wpdb->query( $eventTypeSql );
        $wpdb->query( $eventTypeData );
        
        
        $perfSql = "CREATE TABLE {$wpdb->bmlivestats_performance} (
                        `perf_id` int(11) NOT NULL AUTO_INCREMENT,
                        `event_id` int(11) NOT NULL,
                        `date` datetime NULL,
                        `perf_num` tinyint(4) NOT NULL,
                        PRIMARY KEY (`perf_id`)
                      )  $charset_collate;";  
                      
        $wpdb->query( $perfSql );
        
        
        $perfEventSql = "CREATE TABLE {$wpdb->bmlivestats_perf_event} (
                        `perf_event_id` int(11) NOT NULL AUTO_INCREMENT,
                        `perf_id` int(11) NOT NULL,
                        `event_type_id` int(11) NOT NULL,
                        PRIMARY KEY (`perf_event_id`)
                      )  $charset_collate;";  
                      
        $wpdb->query( $perfEventSql );
        
        
        $statsSql = "CREATE TABLE {$wpdb->bmlivestats_stats} (
                        `perf_event_id` int(11) NOT NULL,
                        `row_id` int(11) NOT NULL,
                        `stats_meta_id` int(11) NOT NULL,
                        `value` varchar(50) NOT NULL,
                        `created` datetime NOT NULL,
                        `created_by` int(11) NOT NULL
                      )  $charset_collate;";  
        
        $wpdb->query( $statsSql );
        
        
        $statsMetaSql = "CREATE TABLE {$wpdb->bmlivestats_stats_meta} (
                            `stats_meta_id` int(11) NOT NULL AUTO_INCREMENT,
                            `perf_event_id` int(11) NOT NULL,
                            `template_id` int(11) NOT NULL,
                            PRIMARY KEY (`stats_meta_id`)
                          )  $charset_collate;";  
        
        $wpdb->query($statsMetaSql);
        
        
        $templateSql = "CREATE TABLE {$wpdb->bmlivestats_template} (
                        `template_id` int(11) NOT NULL AUTO_INCREMENT,
                        `event_type_id` int(11) NOT NULL,
                        `name` varchar(100) NOT NULL,
                        `slug` varchar(100) NOT NULL,
                        `order` tinyint(4) NOT NULL,
                        PRIMARY KEY (`template_id`)
                      )  $charset_collate;";
        
        $templateDataSql = "INSERT INTO `{$wpdb->bmlivestats_template}` (`template_id`, `event_type_id`, `name`, `slug`, `order`) VALUES
                            (NULL, 1, 'No.', 'number', 1),
                            (NULL, 1, 'Contestant', 'contestant', 2),
                            (NULL, 1, 'Hometown', 'hometown', 3),
                            (NULL, 1, 'Stock', 'stock', 4),
                            (NULL, 1, 'Score', 'score', 5),
                            (NULL, 1, 'Notes', 'notes', 6),
                            (NULL, 2, 'No.', 'number', 1),
                            (NULL, 2, 'Contestant', 'contestant', 2),
                            (NULL, 2, 'Hometown', 'hometown', 3),
                            (NULL, 2, 'Stock', 'stock', 4),
                            (NULL, 2, 'Score', 'score', 5),
                            (NULL, 2, 'Notes', 'notes', 6),
                            (NULL, 3, 'No.', 'number', 1),
                            (NULL, 3, 'Contestant', 'contestant', 2),
                            (NULL, 3, 'Hometown', 'hometown', 3),
                            (NULL, 3, 'Time', 'time', 4),
                            (NULL, 3, 'Notes', 'notes', 5),
                            (NULL, 4, 'No.', 'number', 1),
                            (NULL, 4, 'Contestant', 'contestant', 2),
                            (NULL, 4, 'Hometown', 'hometown', 3),
                            (NULL, 4, 'Time', 'time', 4),
                            (NULL, 4, 'Notes', 'notes', 5),
                            (NULL, 5, 'No.', 'number', 1),
                            (NULL, 5, 'Contestant', 'contestant', 2),
                            (NULL, 5, 'Hometown', 'hometown', 3),
                            (NULL, 5, 'Score', 'score', 4),
                            (NULL, 5, 'Notes', 'notes', 5),
                            (NULL, 6, 'No.', 'number', 1),
                            (NULL, 6, 'Contestant', 'contestant', 2),
                            (NULL, 6, 'Hometown', 'hometown', 3),
                            (NULL, 6, 'Time', 'time', 4),
                            (NULL, 6, 'Notes', 'notes', 5),
                            (NULL, 7, 'No.', 'number', 1),
                            (NULL, 7, 'Contestant', 'contestant', 2),
                            (NULL, 7, 'Hometown', 'hometown', 3),
                            (NULL, 7, 'Stock', 'stock', 4),
                            (NULL, 7, 'Score', 'score', 5),
                            (NULL, 7, 'Notes', 'notes', 6);";  
                      
        $wpdb->query( $templateSql );
        $wpdb->query( $templateDataSql );
        
        
        
    }
    
    
    
    /** TODO: direct these to safe update functions */
    public function updateCheck() {
        $version = get_option( 'bmlivestats-version' );
        $dbVersion = get_option( 'bmlivestats-db-version' );
        
		// Update Plugin Version
		if ( $version != $this->version ) {
			update_option('bmlivestats-version', $this->version);
		}

		// Update database
		if( $dbVersion != $this->dbVersion ) {
			//include_once ( dirname (__FILE__) . '/upgrade.php' );
			//leaguemanager_upgrade_page();
            update_option('bmlivestats-db-version', $this->dbVersion);
			return;
		}
    }

    
    
    
    
    

    
    
    
    /**
	 * load options
	 *
	 * @param none
	 * @return void
	 */
	function loadOptions()
	{
		$this->options = get_option('bmlivestats');
	}
    
    
    
    
    /**
	 * define constants
	 *
	 * @param none
	 * @return void
	 */
	function defineConstants() {
		if ( !defined( 'WP_CONTENT_URL' ) )
			define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
		if ( !defined( 'WP_PLUGIN_URL' ) )
			define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
		if ( !defined( 'WP_CONTENT_DIR' ) )
			define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
		if ( !defined( 'WP_PLUGIN_DIR' ) )
			define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
			
		define( 'BMLIVESTATS_VERSION', $this->version );
		define( 'BMLIVESTATS_DBVERSION', $this->dbVersion );
		define( 'BMLIVESTATS_URL', WP_PLUGIN_URL.'/bluemil-live-stats' );
		define( 'BMLIVESTATS_PATH', WP_PLUGIN_DIR.'/bluemil-live-stats' );
	}
    
    
    
    
    /**
	 * define database tables
	 *
	 * @param none
	 * @return void
	 */
	function defineTables() {
		global $wpdb;
		$wpdb->bmlivestats_events = $wpdb->prefix . 'bmlivestats_events';
		$wpdb->bmlivestats_stats = $wpdb->prefix . 'bmlivestats_stats';
		$wpdb->bmlivestats_stats_meta = $wpdb->prefix . 'bmlivestats_stats_meta';
        $wpdb->bmlivestats_performance = $wpdb->prefix . 'bmlivestats_performance';
        $wpdb->bmlivestats_perf_event = $wpdb->prefix . 'bmlivestats_perf_event';
        $wpdb->bmlivestats_event_type = $wpdb->prefix . 'bmlivestats_event_type';
        $wpdb->bmlivestats_template = $wpdb->prefix . 'bmlivestats_template';
        
	}
    
    
    
    
    /**
	 * load libraries
	 *
	 * @param none
	 * @return void
	 */
	function loadController() {
        
        //require_once('bmLiveStats.php');
        
		/** TODO: Set up admin functionality. */
		if ( is_admin() ) {
            require_once (dirname (__FILE__) . '/includes/bmStatsController.php');
        }
        else {
            // any non-admin specific libraries to add?
            require_once (dirname (__FILE__) . '/includes/bmStatsFrontController.php');
        }
        
        
			
		
	}
	
	
    /**
    * Uninstall Plugin
    *
    * @param none
    */
   function uninstall() {
       global $wpdb;

       $wpdb->query( "DROP TABLE {$wpdb->bmlivestats_events}" );
       $wpdb->query( "DROP TABLE {$wpdb->bmlivestats_performance}" );
       $wpdb->query( "DROP TABLE {$wpdb->bmlivestats_stats}" );
       $wpdb->query( "DROP TABLE {$wpdb->bmlivestats_stats_meta}" );
       $wpdb->query( "DROP TABLE {$wpdb->bmlivestats_perf_event}" );
       $wpdb->query( "DROP TABLE {$wpdb->bmlivestats_event_type}" );
       $wpdb->query( "DROP TABLE {$wpdb->bmlivestats_template}" );

       delete_option( 'bmlivestats' );
   }

	
   
   
   
   public function handleShortcode($atts) {
       extract(shortcode_atts(array('event_id' => 0), $atts));
       
       $front = new bmStatsFrontController();
       
       if($event_id) {
           $front->setEventId($event_id);
       }
       else if(isset($_GET['event_id'])) {
           $front->setEventId($_GET['event_id']);
           $event_id = $_GET['event_id'];
       }
       
       $perf_id = (isset($_GET['perf_id'])) ? $_GET['perf_id'] : '';
       $perf_event_id = (isset($_GET['perf_event_id'])) ? $_GET['perf_event_id'] : '';
       
       echo '
                <form id="events_select" method="get">
                    <input type="hidden" id="event_id" name="event_id" value="'.$event_id.'" />
                    <input type="hidden" id="perf_id" name="perf_id" value="'.$perf_id.'" />
                    <input type="hidden" id="perf_event_id" name="perf_event_id" value="'.$perf_event_id.'" />
                
                                <div id="bmStatsDisplay">';
       
       
       // show a list of upcoming events
       echo $front->displayRouter();
       
       echo '
                    </form>



                </div>';
   }
   
   
   
   public function loadFrontEndScripts() {
       wp_enqueue_script( 'bmlivestats-stats', BMLIVESTATS_URL.'/bmstats.js', array('jquery', 'jquery-ui-core', 'jquery-ui-accordion', 'jquery-ui-datepicker') );
       wp_enqueue_script( 'bmlivestats-handson', BMLIVESTATS_URL.'/dist/jquery.handsontable.full.js', array('jquery'), BMLIVESTATS_VERSION );
       wp_enqueue_script( 'bmlivestats-timepicker', BMLIVESTATS_URL.'/extensions/jquery.timepicker.js', array('jquery'), BMLIVESTATS_VERSION );
    
   }
   
   public function loadStyles() {
       wp_enqueue_style('bmlivestats', BMLIVESTATS_URL . "/dist/jquery.handsontable.full.css", false, '1.0', 'screen');
       wp_enqueue_style( 'bm_style', BMLIVESTATS_URL.'/bm_style.css' );
       wp_enqueue_style( 'bm_datepick_style', BMLIVESTATS_URL.'/extensions/jquery-ui-1.10.4.custom.css' );
   }
   
   
   
   
   /*****  Ajax handlers ********/
    public function show_performance_form() {
        require_once(BMLIVESTATS_PATH . '/includes/singleEventHelper.php');
        $eventData = new singleEventHelper();
        
        $bmModel = new bmStatsModel();
        $data = '';
        if(isset($_POST['eventId'])) {
            $data = $bmModel->getSingleEventPerformances($_POST['eventId']);
        }
        
        $output = $eventData->showPerformanceForm($_POST['perfCount'], $data);
        
        
        
        echo $output;
        
        exit;
    }
    
    
    public function show_handson_table() {
        /** Not currently used...
        require_once(BMLIVESTATS_PATH . '/includes/handsonTableHelper.php');
        $output = new handsonTableHelper(); 
        echo $output;
         * 
         */
        
    }
    
    public function save_handson_table() {
        require_once(BMLIVESTATS_PATH . '/includes/handsonTableHelper.php');
        $ht = new handsonTableHelper($_POST);
        $ht->saveStatsData($_POST);
        //echo 'post: ';  print_r($_POST);
    }

    
    public function update_stats_table() {
        require_once(BMLIVESTATS_PATH . '/includes/bmStatsFrontController.php');
        $front = new bmStatsFrontController();
        $output = $front->showTable('ajaxCall');
        echo $output;
        exit;
        
    }
    

    
   

} // ./BlueMillonStatsLoader()





// Run the Plugin
$bmstatsLoader = new BlueMillonStatsLoader();