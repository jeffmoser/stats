<?php

/**
 * eventsHelper - Aid in gathering/manipulation of a list of events
 *
 * @author jeff
 */
class eventsHelper extends WP_List_Table {

    private $model;
    
    
    public function __construct() {
        parent::__construct(array(
            'singular' => 'event', //singular name of the listed records
            'plural' => 'events', //plural name of the listed records
            'ajax' => false        //does this table support ajax?
        ));
        
        $this->model = new bmStatsModel();
        
    }

    /**
     * Default column handling
     * 
     * @param array $item
     * @param string $column_name
     * @return string
     */
    public function column_default($item, $column_name) {
        return $item->$column_name;
        switch ($column_name) {
            case 'date': // format for display
                $formattedDate = date("m-d-Y H:i", strtotime($item->$column_name));
                return $formattedDate;
            default:
                return $item->$column_name;
        }
    }
    
    function column_name($item){
        //Build row actions
        $actions = array(
            'stats'      => sprintf('<a href="?page=%s&action=%s&event_id=%s">Enter Stats</a>',$_REQUEST['page'],'enterStats',$item->event_id),
            'edit'      => sprintf('<a href="?page=%s&action=%s&event_id=%s">Edit</a>',$_REQUEST['page'],'editEvent',$item->event_id),
            'delete'    => sprintf('<a href="?page=%s&action=%s&event_id=%s">Trash</a>',$_REQUEST['page'],'deleteEvent',$item->event_id),
        );
        
        //Return the event name contents
        $perfText = ' Performance';
        if($item->perf_count > 1) {
            $perfText .= 's';
        }
        return sprintf('%1$s %2$s',
            /*$1%s*/ stripslashes($item->name).' - '.$item->perf_count.$perfText,
            /*$3%s*/ $this->row_actions($actions)
        );
    }
    
    
    public function column_date($item) {
        //echo 'item received: '.$item->date;
        if($item->start_date == $item->end_date) {
            $formattedDate = date("m-d-Y g:i a", strtotime($item->start_date));
        }
        else {
            $formattedDate = date("m-d-Y g:i a", strtotime($item->start_date)).' - '.date("m-d-Y g:i a", strtotime($item->end_date));
        }
        //$formattedDate = date("m-d-Y H:i", strtotime($item->date));
        return $formattedDate;
    }
    
    public function column_is_published($item) {
        if($item->is_published == 1) {
            return 'Yes';
        }
        return 'No';
    }

    
    
    /**
     * Handle checkbox columns
     * 
     * @param array $item
     * @return string
     */
    public function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="$s" value="$s" />',
                /* $1%s */ $this->_args['singular'], // repurpose the table's singular label
                /* $2%s */ $item->event_id               // The value of the checkbox should be the record's id
        );
    }

    
    
    public function get_columns() {
        $columns = array(
            'cb'            => '<input type="checkbox" />', //Render a checkbox instead of text
            'name'          => 'Event',
            'date'          => 'Date',
            'location'      => 'Location',
            'is_published'  => 'Published'
        );
        return $columns;
    }

    
    
    /**
     * 
     * @return array An associative array containing all the columns that should be sortable: 'slugs'=>array('data_values',bool)
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            'name' => array('name', false), //true means it's already sorted
            'date' => array('date', true),
            'location' => array('location', false)
        );
        return $sortable_columns;
    }
    
    
    
    
    
    
    
    
    
    
    public function prepare_items() {
        global $wpdb; //This is used only if making any database queries

        /**
         * First, lets decide how many records per page to show
         */
        $per_page = 5;
        
        
        /**
         * REQUIRED. Now we need to define our column headers. This includes a complete
         * array of columns to be displayed (slugs & titles), a list of columns
         * to keep hidden, and a list of columns that are sortable. Each of these
         * can be defined in another method (as we've done here) before being
         * used to build the value for our _column_headers property.
         */
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
        
        /**
         * REQUIRED. Finally, we build an array to be used by the class for column 
         * headers. The $this->_column_headers property takes an array which contains
         * 3 other arrays. One for all columns, one for hidden columns, and one
         * for sortable columns.
         */
        $this->_column_headers = array($columns, $hidden, $sortable);
        
        
        /**
         * Optional. You can handle your bulk actions however you see fit. In this
         * case, we'll handle them within our package just to keep things clean.
         */
        //$this->process_bulk_action();
        
        
             
        /**
         * Pull events data only for this user
         */
        $userId = get_current_user_id();
        $data = $this->model->getEventsById($userId);
        
        
        /**
         * REQUIRED for pagination. Let's figure out what page the user is currently 
         * looking at. We'll need this later, so you should always include it in 
         * your own package classes.
         */
        $current_page = $this->get_pagenum();
        
        /**
         * REQUIRED for pagination. Let's check how many items are in our data array. 
         * In real-world use, this would be the total number of items in your database, 
         * without filtering. We'll need this later, so you should always include it 
         * in your own package classes.
         */
        $total_items = count($data);
        
        
        /**
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to 
         */
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        
        
        
        /**
         * REQUIRED. Now we can add our *sorted* data to the items property, where 
         * it can be used by the rest of the class.
         */
        $this->items = $data;
        
        
        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
    
    

}
