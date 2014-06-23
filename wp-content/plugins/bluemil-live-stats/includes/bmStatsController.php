<?php
/**
 * Main controller for bmLiveStats plugin
 *
 * @author jeff
 */

// include common view files
require_once(BMLIVESTATS_PATH . '/includes/views/headerView.php');
require_once(BMLIVESTATS_PATH . '/includes/views/footerView.php');
require_once(BMLIVESTATS_PATH . '/includes/model/bmStatsModel.php');

class bmStatsController {
    
    
    
    private $getParams;
    private $postParams;
    private $eventId;
    private $perfEventId;
    private $model;
    
   
    public function __construct() {
        
        if( is_admin() ) { // for admin users...
            require_once( ABSPATH . 'wp-admin/includes/template.php' );
		
            add_action('admin_print_scripts', array(&$this, 'loadScripts') );
            add_action('admin_print_styles', array(&$this, 'loadStyles') );
		
            add_action( 'admin_menu', array(&$this, 'menu') );
            
            
        }
        else {  // not an adimin user...
            // do this after wp action
            add_action( 'wp', array( $this, 'init' ) );
        
        }
        
        $this->model = new bmStatsModel();
        
        $this->init();
    }
    
    
    /**
     * Set up class vars; grab any globals of use and store them locally
     */
    public function init() {
        
        $this->postParams = $_POST;
        $this->getParams = $_GET; //TODO: revisit this idea later
        
        if(isset($_GET['event_id'])) {
            $this->eventId = $_GET['event_id'];
        }
        else if(isset($_POST['event_id'])) {
            $this->eventId = $_POST['event_id'];
        }
        
        if(isset($_POST['selectedPerfEvent'])) {
            $this->perfEventId = $_POST['selectedPerfEvent'];
        }
        
    }
    
    
   
	
	
	/**
	 * adds menu to the admin interface
	 *
	 * @param none
	 */
	public function menu() {
		//$plugin = 'bluemil-live-stats/bluemil-live-stats.php';

		//$page = 
        add_menu_page( 'Live Stats', 'Live Stats', 'manage_options', 'bmlivestats-events', array( &$this, 'displayEvents'), BMLIVESTATS_URL.'/admin/images/table16.png' );
        //add_menu_page( 'Live Stats', 'Live Stats', 'manage_options', 'bm-live-stats', array( &$this, 'displayMain'), BMLIVESTATS_URL.'/admin/images/table16.png' );
        //add_submenu_page('bm-live-stats', 'Live Stats', 'Live Stats','manage_options', 'bm-live-stats', array( $this, 'displayMain' ));
        //add_submenu_page('bm-live-stats', 'Events', 'Events','manage_options', 'bmlivestats-events', array( $this, 'displayEvents' ));
		
	}
	
	
	


	
    
    
    public function displayMain() {
        if(isset($this->getParams['event_id'])) {
            // show an event table for edit
            require_once(BMLIVESTATS_PATH . '/includes/views/tableView.php');
            //$eventData = new 
            eventsHeader::render();
            $table = new tableView();
            $content = $table->render();
            eventsFooter::render();
        }
        else {
            // show a list of events
            require_once(BMLIVESTATS_PATH . '/includes/views/eventsListView.php');
            //TODO:  get data...
            eventsHeader::render();
            //$content = eventsView::render();
            eventsFooter::render();
        }
            
        
    }
    
    public function displayEvents() {
        
        // If an event ID is set, check against the current user's id
        if($this->eventId) {
            $validEventsArr = $this->model->getValidEventsByUserId();
            
            if(!in_array($this->eventId, $validEventsArr)) {
                echo '<br /><h3>You do not have sufficient privileges to edit this event.</h3>';
                return false;
            }
        }
        
        // any action requested on this page?
        if(isset($this->getParams['action'])) {
            $showEventList = false;
            switch($this->getParams['action']) {
                case 'editEvent':
                    $this->editEvent();
                    break;
                case 'addEvent':
                    $this->addEvent();
                    break;
                case 'saveEvent':
                    $result = $this->saveEvent();
                    ($result) ? $this->showMessage('Event saved!') : $this->showMessage('Event not saved!', 1);
                    $showEventList = true;
                    break;
                case 'deleteEvent':
                    $result = $this->deleteEvent();
                    ($result) ? $this->showMessage('Event deleted!') : $this->showMessage('Event not deleted!', 1);
                    $showEventList = true;
                    break;
                case 'enterStats':
                    $this->showTable();
                    break;
                default:
                    $showEventList = true;
            }
            
            if(!$showEventList) {
                return; // don't run anything below here
            }
        }
        
        require_once(BMLIVESTATS_PATH . '/includes/views/eventsView.php');
        require_once(BMLIVESTATS_PATH . '/includes/eventsHelper.php');
        
        $eventsData = new eventsHelper();
        $eventsData->prepare_items();
        
        eventsHeader::render();
        $eventsData->display();
        eventsFooter::render();
    }
    
    public function addEvent() {
        require_once(BMLIVESTATS_PATH . '/includes/views/eventsView.php');
        require_once(BMLIVESTATS_PATH . '/includes/singleEventHelper.php');
        
        $eventData = new singleEventHelper();
        eventsView::renderPreForm(); // true = this 'view' has a form of its own...
        
        $eventData->addEvent();
        eventsView::renderPostForm(); // true = this 'view' has a form of its own...
        
    }
    
    private function saveEvent() {
        // no view elements here, just let the events listing handle it.
        if(isset($this->postParams['event_id'])) {
            $result = $this->model->editEvent($this->postParams);
        }
        else {
            $result = $this->model->addEvent($this->getParams);
        }
        
        return $result;
    }
    
    private function deleteEvent() {
        // no view elements here, just let the events listing handle it.
        
        if(isset($this->getParams['event_id'])) {
            $result = $this->model->deleteEvent($this->getParams); 
            return $result;
        }
        
        
    }
    
    public function editEvent() {
        require_once(BMLIVESTATS_PATH . '/includes/views/eventsView.php');
        require_once(BMLIVESTATS_PATH . '/includes/singleEventHelper.php');
        
        $eventData = new singleEventHelper($this->getParams['event_id']);
        $eventData->showEvent();
        /*
        eventsHeader::render();
        eventsView::renderPreData();
        $eventsData->displayEventForm();
        eventsView::renderPostData();
        eventsFooter::render();
         * 
         */
    }
    
    public function displayAthletes() {
        //TODO:  get data...
        eventsHeader::render();
        require_once(BMLIVESTATS_PATH . '/includes/views/athletesView.php');
        $content = athletesView::render();
        eventsFooter::render();
    }
    
	
	
	
	
	
    private function showTable() {
        // get event data
        $eventInfo = $this->model->getSingleEvent($this->eventId);
        //echo '<pre>event: '; print_r($eventInfo); echo '</pre>';
        
        // get performance data
        $perfInfo = $this->model->getSingleEventPerformances($this->eventId);
        
        
        // make sure there are performance events defined
        $perfCheck = $this->model->getEventTypeIdByEventId($this->eventId);
        
        
        if(isset($this->postParams['action']) && $this->postParams['action'] == 'savePerfEvents') {
            // save performance data
            
            // parse input and save perf event data
            $saveArr = array();
            foreach($this->postParams as $key => $val) {
                if('_add_perf_' == substr($key, 0, 10)) {
                    $nameArr = explode('_add_perf_', $key);
                    $saveArr[$nameArr[1]] = $val; // store perf id in key
                }
            }
            
            // save perf events
            $this->model->savePerformanceEvents($saveArr);
            
        }
        //if no header fields exist, the performance hasn't been defined
        else if(empty($perfCheck)) {
            eventsHeader::render('<h3>Performance not defined</h3>');
            require_once BMLIVESTATS_PATH . '/includes/performanceHelper.php';
            $perf = new performanceHelper($perfInfo);
            
            // end here...
            eventsFooter::render();
            return true;
            
        }
        
        // get table header data
        $headerFields = null;
        if(isset($this->perfEventId)) {
            $headerFields = $this->model->getStatsHeaders($this->perfEventId);
        }
        /**
        echo '<pre>headerFields: '; print_r($headerFields); 
        echo '<br />post: '; print_r($_POST);
        echo '</pre>';
         * 
         */
        
        
        
        
        
        
        // does the user need to select a performance? Already selected?
        $selPerf = '';
        if(isset($this->postParams['selectedPerf'])) {
            $pn = $this->model->getPerformanceNum($this->postParams['selectedPerf']);
            
            $selPerf = array(
                'selectedPerf' => $this->postParams['selectedPerf'],
                'selectedPerfEvent' => $this->postParams['selectedPerfEvent'],
                'selectedPerfNum'   => $pn->perf_num
            );
            
        }
        
        
        eventsHeader::render();
        require_once BMLIVESTATS_PATH . '/includes/views/tableView.php';
        $table = new tableView($headerFields, $eventInfo, $perfInfo, $selPerf);
        eventsFooter::render();
        
            
    }
    
    
    
	
	
	
	/**
	 * Checks if a particular user has a role. 
	 * Returns true if a match was found.
	 *
	 * @param string $role Role name.
	 * @param int $user_id (Optional) The ID of a user. Defaults to the current user.
	 * @return bool
	 *
	 */
	public function checkUserRole( $role, $user_id = null ) {
	 
		if ( is_numeric( $user_id ) )
			$user = get_userdata( $user_id );
		else
			$user = wp_get_current_user();
	 
		if ( empty( $user ) )
			return false;
	 
		return in_array( $role, (array) $user->roles );
	}

    
    
    /**
	 * load scripts
	 *
	 * @param none
	 * @return void
	 */
	public function loadScripts()
	{
		wp_register_script( 'bmlivestats-stats', BMLIVESTATS_URL.'/dist/jquery.handsontable.full.js', array('jquery'), BMLIVESTATS_VERSION );
		wp_enqueue_script('bmlivestats-stats');
	}
	
	
	/**
	 * load styles
	 *
	 * @param none
	 * @return void
	 */
	public function loadStyles()
	{
		wp_enqueue_style('bmlivestats', BMLIVESTATS_URL . "/dist/jquery.handsontable.full.css", false, '1.0', 'screen');
	}
    
    
    
    
    private function showMessage($msg, $error=false) {
        $class = 'updated fade';
        if($error) {
            $class = 'error';
        }
        echo '<div id="message" class="'.$class.'">'.$msg.'</div>';
    }
    
   
   
}

// instantiate the controller
$controller = new bmStatsController();