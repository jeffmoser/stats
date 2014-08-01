<?php
/**
 * Singleton view of events list
 *
 * @author jeff
 */
class frontEventsView {


    public function showEvents($eventsArr) {
        $output = '
                <h3>View an event</h3>
                <table>
                    <tr>
                        <td>Event</td>
                        <td>City</td>
                        <td>State</td>
                        <td>Dates</td>
                    </tr>
';
        
        foreach($eventsArr as $event) {
            $rawStartDate = strtotime($event->start_date);
            $rawEndDate = strtotime($event->end_date);
            
            $output .= '
                    <tr>
                        <td><a href="#" onClick="bmstatsSelectEvent('.$event->event_id.')">'.stripslashes($event->name).'</a></td>
                        <td>'.$event->location.'</td>
                        <td>'.$event->state.'</td>
                        <td>'.date("m/d/Y", $rawStartDate).' - '.date("m/d/Y", $rawEndDate).'</td>
                    </tr>';
        }
        
        $output .= '
                </table>';
        
        return $output;
    }

}
