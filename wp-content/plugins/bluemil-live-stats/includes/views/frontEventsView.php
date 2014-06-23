<?php
/**
 * Singleton view of events list
 *
 * @author jeff
 */
class frontEventsView {


    public function showEvents($eventsArr) {
        $output = '
                <h3>View an event</h3>';
        
        foreach($eventsArr as $event) {
            $output .= '
                <div><a href="#" onClick="bmstatsSelectEvent('.$event->event_id.')">'.stripslashes($event->name).'</a></div>';
        }
        
        return $output;
    }

}
