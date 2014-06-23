<?php
/**
 * performanceHelper - UI for admin user to define performance events
 *
 * @author jeff
 */

class performanceHelper {
    
    private $model;
    
    private $perfObj;
    
    public function __construct($perf) {
        $this->model = new bmStatsModel();
        $this->perfObj = $perf;
        
        $this->showForm();
    }
    
    
    /**
     * Build interface for defining performances
     * 
     */
    private function showForm() {
        // get list of events for display
        $eTypes = $this->model->getEventTypes();
        
        echo '
        <div>
            <h3>Select events for each performance</h3>
        
            <form name="event_form" method="post" action="admin.php?page=bmlivestats-events&action=enterStats&eventId='.$this->perfObj[0]->event_id.'">
                <input type="hidden" name="action" value="savePerfEvents" />
                <input type="hidden" name="event_id" value="'.$this->perfObj[0]->event_id.'" />';
                
        
        foreach($this->perfObj as $perf) {
            echo '
                <div class="bm-form-field">
                    <h4>Performance #'.$perf->perf_num.'</h4>';
            
            foreach($eTypes as $type) {
                // IMPORTANT: Parsing of this data depends on the name prefix being '_add_perf_' Do not change!
                echo '
                    <div class="checkboxInput"><input type="checkbox" name="_add_perf_'.$perf->perf_id.'[]" value="'.$type->event_type_id.'" /> &nbsp; '.$type->type_name.'</div>';
            }
            
            echo '
                </div>';
        }
        
        echo '
                <div class="bm-form-label">
                    <p class="submit"><input type="submit" name="addPerfEvent" id="addPerfEvent" class="button button-primary" value="Save"  /></p>
                </div>
            </form>
        </div>';
        
        
    }
    
    
}

