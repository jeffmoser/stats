<?php

/**
 * singleEventHelper - add or edit a single event
 *
 * @author jeff
 */
class singleEventHelper {
    
    
    private $model;
    
    private $eventId;
    
    private $actionText;
    
    private $perfCountOptions = 300;
    
    
    public function __construct($eventId=0) {
        $this->model = new bmStatsModel();
        
        $this->eventId = $eventId;
        
        $this->actionText = 'Add Event';
        if($eventId) {
            $this->actionText = 'Edit Event';
        }
        
    }
    
    
    public function showEvent() {
        if($this->eventId) {
            $eventData = $this->model->getSingleEvent($this->eventId);
            $performanceData = $this->model->getSingleEventPerformances($this->eventId);
        }
        
        
        $pubChecked = '';
        $notPubChecked = ' CHECKED';
        if($eventData->is_published == 1) {
            $pubChecked = ' CHECKED';
            $notPubChecked = '';
        }
        
    
        //how many performances?
        $perfCount = count($performanceData);
        
        $formData = '
        <div>    
        <form name="event_form" method="post" action="admin.php?page=bmlivestats-events&action=saveEvent&eventId='.$eventData->event_id.'">
                <input type="hidden" name="action" value="saveEvent" />
                <input type="hidden" name="event_creator" value="'.$eventData->created_by.'" />
                <input type="hidden" name="event_id" value="'.$eventData->event_id.'" />
        <h3>'.$this->actionText.'</h3>
        
        <div class="bm-form-label-block">
        
            <div class="bm-form-label"><label for="event_name">Event Name <span class="description">(required)</span></label></div>
            <div class="bm-form-label"><label for="event_location">Event Location</label></div>
            <div class="bm-form-label"><label for="event_location">Number of Performances</label></div>
            <div class="bm-form-label"><label for="is_published">Publish?</label></div>
        </div>


        <div class="bm-form-field-block">
            <div class="bm-form-field"><input name="event_name" type="text" id="event_name" value="'.stripslashes($eventData->name).'" size="50" /></div>
            <div class="bm-form-field"><input name="event_location" type="text" id="event_location" value="'.stripslashes($eventData->location).'" size="50" /></div>
            <div class="bm-form-field">
                <select name="performance_count" id="performance_count" onChange="showPerformanceForm('.$eventData->event_id.')">'; 
        
        $i=1;
        while($i <= $this->perfCountOptions) {
            $sel = '';
            if($i == $perfCount) {
                $sel = ' selected'; 
            }
            
            $formData .= '
                    <option value="'.$i.'"'.$sel.'>'.$i.'</option>';
            
            $i++;
        }
                 
        $formData .= '
                </select>
            </div>

            <div class="bm-form-field">
                    <label for="is_published"><input type="radio" name="is_published" id="is_published_1" value="1"'.$pubChecked.' /> Yes</label> <br />
                    <label for="is_published"><input type="radio" name="is_published" id="is_published_0" value="0"'.$notPubChecked.' /> No</label>

            </div>
        </div>



        <div id="form-performance-block">';
        
        $formData .= $this->showPerformanceForm($perfCount, $performanceData);
        
        $formData .= '
        </div>

            <div class="bm-form-label">
                <p class="submit"><input type="submit" name="addEvent" id="addEvent" class="button button-primary" value="'.$this->actionText.' "  /></p>
            </div>


    </form>
    </div>
    <div class="clear"></div>';
        
        
        echo $formData;
        
    }
    
    
    public function addEvent() {
        $thisUser = get_current_user_id();
        
        $formData = '
        <div>    
        <form name="event_form" method="post" action="'.$_REQUEST['page'].'">
                <input type="hidden" name="action" value="saveEvent" />
                <input type="hidden" name="event_creator" value="'.$thisUser.'" />
        <h3>'.$this->actionText.'</h3>
        
        <div class="bm-form-label-block">
        
            <div class="bm-form-label"><label for="event_name">Event Name <span class="description">(required)</span></label></div>
            <div class="bm-form-label"><label for="event_location">Event Location</label></div>
            <div class="bm-form-label"><label for="event_location">Number of Performances</label></div>
            <div class="bm-form-label"><label for="is_published">Publish?</label></div>
        </div>


        <div class="bm-form-field-block">
            <div class="bm-form-field"><input name="event_name" type="text" id="event_name" value="" size="50" /></div>
            <div class="bm-form-field"><input name="event_location" type="text" id="event_location" value="" size="50" /></div>
            <div class="bm-form-field">
                <select name="performance_count" id="performance_count" onChange="showPerformanceForm()">
                    <option value="">-- Select --</option>';
        
        $i = 1;
        while($i <= $this->perfCountOptions) {
            $formData .= '
                    <option value="'.$i.'">'.$i.'</option>';
            
            $i++;
        }
        
        $formData .= '
                </select>
            </div>

            <div class="bm-form-field">
                    <label for="is_published"><input type="radio" name="is_published" id="is_published_1" value="1" /> Yes</label> <br />
                    <label for="is_published"><input type="radio" name="is_published" id="is_published_0" value="0" CHECKED /> No</label>

            </div>
        </div>



        <div id="form-performance-block"></div>

            <div class="bm-form-label">
                <p class="submit"><input type="submit" name="addEvent" id="addEvent" class="button button-primary" value="'.$this->actionText.' "  /></p>
            </div>


    


    </form>
    </div>
    <div class="clear"></div>';
        
        
        echo $formData;
        
    }
    
    
    
    
   
   
   
   public function showPerformanceForm($num, $data='') {
       $labels = '
            <div class="bm-form-label-block">';
       $fields = '
            <div class="bm-form-field-block">';
       $jsList = $hidden = '';
       $i=1;
       
       while($i <= $num) {
           $dateTimeVal = $perfId = '';
           $showHidden = false;
           $index = $i - 1;
           if(!empty($data[$index])) {
               $date = new DateTime($data[$index]->date);
               $dateTimeVal = $date->format('m/d/Y H:i');
               $perfId = $data[$index]->perf_id;
               $showHidden = true;
           }
           $labels .= '
               <div class="bm-form-label bm-performance"><label for="event_date">Event Date/Time for Performance #'.$i.'</label></div>';
           $fields .= '
               <div class="bm-form-field bm-performance">
                 <input type="text" name="perf_date_'.$i.'" id="perf_date_'.$i.'" value="'.$dateTimeVal.'" />
               </div>';
           $jsList .= '
               jQuery( "#perf_date_'.$i.'" ).datetimepicker({changeYear:true, changeMonth:true, yearRange:"c:+3"});';
               
           if($showHidden) {
               $hidden .= '
                 <input type="hidden" name="perf_id_'.$i.'" id="perf_id_'.$i.'" value="'.$perfId.'" />';
           }
           
           $i++;
       }
       $labels .= '
            </div>';
       $fields .= '
            </div>';
       
       $output = $labels . $fields . $hidden;
       
       $output .= '
           <input type="hidden" id="perfCount" name="perfCount" value="'.$num.'" />
           <input type="hidden" name="okToDelete" value="0" />
           <script>
                /* Bind the performance date fields to the datepicker function  */
                '.$jsList.'
           </script>';
       
       
       return $output;
   }

    
}

