<?php
/**
 * Build handson table for ajax call return
 *
 * @author jeff
 */
class handsonTableHelper {
    
    private $eventId;
    private $perfEventId;
    private $model;
    
    public function __construct() {
        $this->model = new bmStatsModel();
        
    }
    
    
    public function saveStatsData($postData) {
        $this->eventId = $postData['event_id'];
        $this->perfEventId = $postData['perf_event_id'];
        
        // wipe everything currently in this performance
        $this->model->deletePerformanceStats($postData['perf_event_id']);
        
        // get template data and store in an ordered array, just in 
        // case order gets fouled up somewhere
        $statsMetaIdOrdered = $this->model->getOrderedStatsMetaId($this->perfEventId);
        //echo 'smo: '; print_r($statsMetaIdOrdered);
        //echo 'data: '; print_r($postData['data']); exit;   
        
        foreach($postData['data'] as $rowIndex => $stats) {
            $rowId = $rowIndex + 1;
            
            foreach($stats as $recordIndex => $stat) {
                $recordId = $recordIndex + 1;
                
                $this->model->insertStatsRow($this->perfEventId, $rowId, $statsMetaIdOrdered[$recordIndex]->stats_meta_id, $stat);
            }
            
            /*
            // check row existence for insert vs update
            $exists = $this->model->statsRowExists($this->perfEventId, $rowId);
            //echo 'stats: '; print_r($stats);
            if(is_object($exists) && count($exists) == count($stats)) {
                
                // do the updatea
                foreach($stats as $stat) {
                    $this->model->updateStatsRow($this->perfEventId, $rowId, $statsMetaIdOrdered[$rowIndex]->stats_meta_id, $stat);
                    
                }
                
            }
            else {
                foreach($stats as $stat) {
                    if(!empty($stat)) {
                        // insert new record
                        $this->model->insertStatsRow($this->perfEventId, $rowId, $statsMetaIdOrdered[$rowIndex]->stats_meta_id, $stat);
                    }
                }
            }
            
             * 
             */
        }
    }
    
    
    public function saveStatsData_original($postData) {
        $this->eventId = $postData['event_id'];
        $this->perfEventId = $postData['perf_event_id'];
        
        // get template data and store in an ordered array, just in 
        // case order get fouled up somewhere
        $statsMetaIdOrdered = $this->model->getOrderedStatsMetaId($this->perfEventId);
        //echo 'smo: '; print_r($statsMetaIdOrdered);
        //echo 'data: '; print_r($postData['data']);    
        
        foreach($postData['data'] as $rowIndex => $stats) {
            $rowId = $rowIndex + 1;
            
            foreach($stats as $recordIndex => $stat) {
                $recordId = $recordIndex + 1;
                
                // check row existence for insert vs update
                $exists = $this->model->statsRowExists($this->perfEventId, $rowId, $statsMetaIdOrdered[$recordIndex]->stats_meta_id);
                if(!empty($exists)) {
                    // update
                    $this->model->updateStatsRow($this->perfEventId, $rowId, $statsMetaIdOrdered[$recordIndex]->stats_meta_id, $stat);
                }
                else {
                    // insert unless it's an empty record
                    if(!empty($stat)) {
                        $this->model->insertStatsRow($this->perfEventId, $rowId, $statsMetaIdOrdered[$recordIndex]->stats_meta_id, $stat);
                    }
                }
            }
            
            /*
            // check row existence for insert vs update
            $exists = $this->model->statsRowExists($this->perfEventId, $rowId);
            //echo 'stats: '; print_r($stats);
            if(is_object($exists) && count($exists) == count($stats)) {
                
                // do the updatea
                foreach($stats as $stat) {
                    $this->model->updateStatsRow($this->perfEventId, $rowId, $statsMetaIdOrdered[$rowIndex]->stats_meta_id, $stat);
                    
                }
                
            }
            else {
                foreach($stats as $stat) {
                    if(!empty($stat)) {
                        // insert new record
                        $this->model->insertStatsRow($this->perfEventId, $rowId, $statsMetaIdOrdered[$rowIndex]->stats_meta_id, $stat);
                    }
                }
            }
            
             * 
             */
        }
    }
    
    
    
    private function updateStat($stats, $rowId) {
        foreach($stats as $row) {
            
        }
            
            
    }
    
    
    private function insertStat($row, $rowId) {
        
    }
    
    
    private function showHandsonTable($accLoop, $perfIndex) {
        //echo '<pre>'; print_r($perfIndex); echo '</pre>';
        echo '
                        <h3>Performance #' . $accLoop . ' - ' . $this->perfData[$perfIndex]->date . '</h3>
                            <div>
                            <div id="liveStatsEvent_'.$perfIndex.'"></div>
                            <script type="text/javascript" data-jsfiddle="liveStatsEvent_'.$perfIndex.'">
                                var data = [';

        $statsCount = count($this->statsData);
        $i = 1;
        foreach ($this->statsData as $stats) {
            $endComma1 = '';
            if ($i < $statsCount) {
                $endComma1 = ',';
            }
            echo '
                                    {';

            $recordCount = count($stats);
            $j = 1;
            foreach ($stats as $record) {
                $endComma2 = '';
                if ($j < $recordCount) {
                    $endComma2 = ',';
                }
                $j++;
                echo '
                        ' . $record->slug . ': "' . $record->value . '"' . $endComma2;
            }
            echo '
                                    }' . $endComma1;
        }

        echo '
                                ];';


        $headerCount = count($this->headerData);
        $i = 1;
        $colHeaderStr = $colStr = '';
        foreach ($this->headerData as $header) {
            $endComma = '';
            if ($i < $headerCount) {
                $endComma = ',';
            }
            $colHeaderStr .= '"<strong>' . $header->name . '</strong>"' . $endComma;

            $render = '';
            if ($$header->slug == 'score' || $header->slug == 'time') {
                $render = ', renderer: scoreRenderer';
            }
            $colStr .= '            
                                        {data: "' . $header->slug . '" ' . $render . '}' . $endComma;
        }


        echo '
                                var $container = jQuery("#liveStatsEvent_'.$perfIndex.'");
                                
                                var maxed = false
                                    , resizeTimeout
                                    , availableWidth
                                    , availableHeight
                                    , $window = jQuery(window)
                                    , $liveStatsEvent = $container;
                                    
                                var calculateSize = function () {
                                    var offset = $container.offset();
                                    availableHeight = $window.height() - offset.top + $window.scrollTop();
                                };
                                $window.on(\'resize\', calculateSize);
                                
                                var scoreRenderer = function (instance, td, row, col, prop, value, cellProperties) {
                                    var escaped = Handsontable.helper.stringify(value);
                                    escaped = strip_tags(escaped, \'<div>\');
                                    td.innerHTML = escaped;
                                    return td;
                                };

                                
                                    $container.handsontable({
                                      data: data,
                                      colWidths: [120, 200, 120, 80],
                                      //colHeaders: [' . $colHeaderStr . '],
                                      columns: [' . $colStr . '],
                                      minSpareRows: 10,
                                      contextMenu: true,
                                      height: function () {
                                        if (maxed && availableHeight === void 0) {
                                          calculateSize();
                                        }
                                        return maxed ? availableHeight : 300;
                                      }
                                    });


                                var strip_tags = function(input, allowed) {
                                    allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(\'\'); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
                                    var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
                                      commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
                                    return input.replace(commentsAndPhpTags, \'\').replace(tags, function ($0, $1) {
                                      return allowed.indexOf(\'<\' + $1.toLowerCase() + \'>\') > -1 ? $0 : \'\';
                                    });
                                }
                                
                                jQuery(\'.maximize\').on(\'click\', function () {
                                  maxed = !maxed;
                                  $container.handsontable(\'render\');
                                });



                            </script>
                            </div>';
    }
}

