<?php
/**
 * Front-end controller for bmLiveStats plugin
 *
 * @author jeff
 */

// include common view files
require_once(BMLIVESTATS_PATH . '/includes/model/bmStatsModel.php');
require_once(BMLIVESTATS_PATH . '/includes/views/frontEventsView.php');

class bmStatsFrontController {
    
    private $getParams;
    private $postParams;
    private $eventId;
    private $performanceId;
    private $perfEventId;
    private $model;
    private $output;
    private $frontView;
    
   
    public function __construct() {
        
        // do this after wp action
        add_action( 'wp', array( $this, 'init' ) );
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
        
        if(isset($_GET['perf_id']) && $_GET['perf_id'] != '') {
            $this->performanceId = $_GET['perf_id'];
        }
        else if(isset($_POST['perf_id'])) {
            $this->performanceId = $_POST['perf_id'];
        }
        
        if(isset($_GET['perf_event_id']) && $_GET['perf_event_id'] != '') {
            $this->perfEventId = $_GET['perf_event_id'];
        }
        else if(isset($_POST['perf_event_id'])) {
            $this->perfEventId = $_POST['perf_event_id'];
        }
        
        $this->model = new bmStatsModel();
        $this->frontView = new frontEventsView();
        
        $this->output = '';
        
    }
    
    
   
    
    public function setEventId($id) {
        $this->eventId = $id;
    }
	
	
	
    /**
     * Called from shortcode handler, shows initial display not from ajax call.
     * @return str
     */
    public function displayRouter() {
        /*
        if(isset($this->perfEventId)) {
            // ready to show the stats
        }
        else if(isset($this->performanceId)) {
            // ready to show perf events
        }
         * 
         */
        if(isset($this->eventId)) {
            // ready to show performances
            $this->showTable();
        }
        else {
            // show list of upcoming events
            $this->displayEvents();
        }
            
        return $this->output;
    }
    
    public function displayEvents() {
        $eventsArr = $this->model->getEvents('past', 'publishedOnly');
        //echo '<pre>here? :: '; print_r($eventsArr); echo '</pre>';
        $this->output .= $this->frontView->showEvents($eventsArr);
        
    }
    
	
	
	
	
    public function showTable($isAjaxCall=false) {
        $model = new bmStatsModel();
            
        // get event data
        $eventInfo = $model->getSingleEvent($this->eventId);
        //echo '<pre>event: '; print_r($eventInfo); echo '</pre>';
        
        // get performance data
        $perfInfo = $model->getSingleEventPerformances($this->eventId);
        
        
        // get table header data
        $headerFields = null;
        if(isset($this->perfEventId)) {
            $headerFields = $model->getStatsHeaders($this->perfEventId);
        }
        
        // does the user need to select a performance? Already selected?
        $selPerf = array();
        
        if(isset($this->performanceId)) {
            $pn = $model->getPerformanceNum($this->performanceId);
            
            $selPerf = array(
                'selectedPerf' => $this->performanceId,
                'selectedPerfEvent' => $this->perfEventId,
                'selectedPerfNum' => $pn->perf_num
            );
            
            
        }
        
        
        
        //require_once(BMLIVESTATS_PATH . '/includes/views/eventsView.php');
        
        //eventsHeader::render();
        require_once BMLIVESTATS_PATH . '/includes/views/frontTableView.php';
        $table = new frontTableView($headerFields, $eventInfo, $perfInfo, $selPerf);
        if($isAjaxCall) {
            $table->setAjax();
            $table->buildFrontView();
            return $table->getOutput();
        }
        $table->buildFrontView();
        
        if($isAjaxCall) {
            return $table->getOutput();
        }
        echo $table->getOutput();
            
    }
    
  
}