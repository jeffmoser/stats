<?php
/**
 * Description of frontTableView
 *
 * @author jeff
 */

class frontTableView {

    private $headerData;
    private $statsMetaData;
    private $eventData;
    private $perfData;
    private $perfCount;
    private $selectedPerf;
    private $perfEventsData;
    private $output;
    private $model;
    private $isAjaxCall = false;

    public function __construct($headerArr, $eventInfo, $perfInfo, $selectedPerf) {
        $this->headerData = $headerArr;
        //$this->statsMetaData = $statsMetaData;
        $this->eventData = $eventInfo;
        $this->perfData = $perfInfo;
        $this->selectedPerf = $selectedPerf;
        $this->output = '';

        $this->perfCount = count($this->perfData);

        $this->model = new bmStatsModel();
    }
    
    public function buildFrontView() {

        if (!empty($this->selectedPerf)) {
            // get stats data for the chosen fields
            $this->statsMetaData = $this->model->getFrontStatsData($this->selectedPerf['selectedPerfEvent']);

            // get specific perf data
            $this->perfData = $this->model->getSingleEventPerformances(1, $this->selectedPerf['selectedPerf']);

            $this->perfEventsData = $this->model->getPerformanceEvents($this->eventData->event_id, $this->selectedPerf['selectedPerf'], $this->selectedPerf['selectedPerfEvent']);
            
            $this->render();
        } else {
            //echo 'pedata: '; print_r($this->perfEventsData);
            $this->showPerformances();
        }
    }

    public function render() {
        if(!$this->isAjaxCall) {  
            //$preTableCode = '<h3>Performance #' . $this->selectedPerf['selectedPerfNum'] . '  ' . $this->perfData[0]->date . ' - ' . $this->perfEventsData[0]->type_name . '</h3>';
            $preTableCode = '<h3>Performance #' . $this->selectedPerf['selectedPerfNum'] . '   - ' . $this->perfEventsData[0]->type_name . '</h3>';
            $this->layoutStart($preTableCode);
        }


        $this->output .= '
                            <div id="statsFrontContainer">';

        $this->output .= $this->buildLiveStats();
        
        
        $this->output .= '
                            </div> <!-- ./statsFrontContainer -->';
        
        if(!$this->isAjaxCall) {
            $this->layoutEnd();
                
            // refresh the data every 60(?) seconds
            $this->output .= '
                                <script type="text/javascript">
                                    setInterval("refreshScores();",60000);
                                </script>';
        
        }

    }
    
    
    
    public function getOutput() {
        return $this->output;
    }
    
    public function setAjax() {
        $this->isAjaxCall = true;
    }
    
    

    private function showPerformances() {
        $this->layoutStart();

        $this->output .= '
                        <h4>Select a performance</h4>
                                <div id="bm-admin-accordion">';

        $accLoop = 1;
        while ($accLoop <= $this->perfCount) {
            $perfIndex = $accLoop - 1;

            $this->output .= '
                            <h3>Performance #' . $accLoop . ' - ' . date("m-d-Y g:i a", strtotime($this->perfData[$perfIndex]->date)) . '</h3>
                            <div>';

            // get the event types associated with the chosen performance
            $this->perfEventsData = $this->model->getPerformanceEvents($this->eventData->event_id, $this->perfData[$perfIndex]->perf_id);

            foreach ($this->perfEventsData as $ped) {
                $this->output .= '
                                <input class="button" type="submit" name="button_' . $accLoop . '" onClick="selectFrontPerf(' . $this->perfData[$perfIndex]->perf_id . ', ' . $ped->perf_event_id . ')" value="' . $ped->type_name . '" />';
            }

            $this->output .= '
                            </div>';

            //<div style="margin:2em; padding:5px !important"><input class="button" type="submit" name="button_'.$accLoop.'" onClick="selPerf('.$this->perfData[$perfIndex]->perf_id.')" value="Performance #'.$accLoop.' - '.$this->perfData[$perfIndex]->date.'" /></div>

            $accLoop++;
        }

        $this->output .= '
                                </div>
                            
                            <script type="text/javascript">
                                var selPerf = function(pid, peid) {
                                    jQuery(\'#selectedPerf\').val(pid);
                                    jQuery(\'#selectedPerfEvent\').val(peid);
                                    jQuery(\'#stats_perf_form\').submit();
                                }
                            </script>';

        $this->layoutEnd();
    }

    private function layoutStart($extra = '') {
        $this->output .= '
                
            <div class="columnLayout" style="min-height: 0;">
                <div class="rowLayout">
                    <div class="descLayout">
                        <h2>' . stripslashes($this->eventData->name) . '</h2>
                            ' . $extra . '
                        <img class="ajax-loader" src="'.BMLIVESTATS_URL.'/images/ajax-loader.gif" />
                    </div>';
    }

    private function layoutEnd() {
        $this->output .= '
                </div><!-- ./rowLayout -->
            </div><!-- ./columnLayout -->';
    }
    
    
    
    /**
     * Separate the build of the actual data table so it can be called via ajax
     * 
     * @return string
     */
    private function buildLiveStats() {
        
        $output = '
            <table>
                <tr>';

        $headerCount = count($this->headerData);
        $i = 1;
        $colHeaderStr = $colStr = '';
        $dataTypeArr = array();
        foreach ($this->headerData as $header) {
            $dataTypeArr[] = $header->slug; // store for td class
            $output .= '
                    <td><strong>' . $header->name . '</strong></td>';
        }

        $output .= '
                </tr>';
        
        
        foreach ($this->statsMetaData as $stats) {
            $i = 0; // counter for data type arr
            
            $output .= '
                                    <tr>';
            
        
            foreach ($stats as $record) {
                $output .= '
                                        <td class="'.$dataTypeArr[$i].'">'.stripslashes($record->value).'</td>';
                
                $i++;
                
            }
        
            
            $output .= '
                                    </tr>';
        }
        
        $output .= '
                </table>';
        
        return $output;
    }

}

