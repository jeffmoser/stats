<?php

/**
 * Singleton class to display events view
 * 
 * @author jeff moser
 */
class tableView {

    private $headerData;
    private $statsMetaData;
    private $eventData;
    private $perfData;
    private $perfCount;
    private $selectedPerf;
    private $perfEventsData;
    private $model;

    public function __construct($headerArr, $eventInfo, $perfInfo, $selectedPerf) {
        $this->headerData = $headerArr;
        //$this->statsMetaData = $statsMetaData;
        $this->eventData = $eventInfo;
        $this->perfData = $perfInfo;
        $this->selectedPerf = $selectedPerf;

        $this->perfCount = count($this->perfData);

        $this->model = new bmStatsModel();

        if (!empty($selectedPerf)) {
            // get stats data for the chosen fields
            $this->statsMetaData = $this->model->getStatsData($this->selectedPerf['selectedPerfEvent']);

            // get specific perf data
            $this->perfData = $this->model->getSingleEventPerformances(1, $this->selectedPerf['selectedPerf']);

            $this->perfEventsData = $this->model->getPerformanceEvents($eventInfo->event_id, $selectedPerf['selectedPerf'], $selectedPerf['selectedPerfEvent']);
            //echo 'pedata: '; print_r($eventInfo);

            $this->render();
        } else {
            //echo 'pedata: '; print_r($this->perfEventsData);
            $this->showPerformances();
        }
    }

    public function render() {
        /*
          echo '<pre>';
          echo 'header: '; print_r($this->headerData);
          echo 'stats: '; print_r($this->statsMetaData);
          echo 'event: '; print_r($this->eventData);
          echo 'perf events data: '; print_r($this->perfEventsData);
          echo 'perf data: '; print_r($this->perfData);
          echo 'selected perf: '; print_r($this->selectedPerf);
          echo '</pre>';
         * 
         * <button title="Prints current data source to Firebug/Chrome Dev Tools" data-dump="#example1" name="dump"> Dump data to console </button>
         */

          
        $preTableCode = '<h3>Performance #' . $this->selectedPerf['selectedPerfNum'] . '  ' . date("m-d-Y g:i a", strtotime($this->perfData[0]->date)) . ' - ' . $this->perfEventsData[0]->type_name . '</h3>
            <p>
            <label><input type="checkbox" name="autosave" checked="checked" autocomplete="off"> Autosave</label>
          </p>';
        $this->layoutStart($preTableCode);


        $this->layoutEnd();

        echo '
                            <script data-jsfiddle="liveStatsEvent">
                                var tableData = [';

        $statsCount = count($this->statsMetaData);
        $i = 1;
        foreach ($this->statsMetaData as $stats) {
            $endComma1 = '';
            if ($i < $statsCount) {
                $endComma1 = ',';
            }
            
            echo '
                                    [';
            
            $i++;

            $recordCount = count($stats);
            $j = 1;
            foreach ($stats as $record) {
                $endComma2 = '';
                if ($j < $recordCount) {
                    $endComma2 = ',';
                }
                $j++;
                
                echo '
                                "'.$record->value.'"'.$endComma2;
                
            }
            echo '
                                    ]' . $endComma1;
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
            $i++;

            $colHeaderStr .= '"<strong>' . $header->name . '</strong>"' . $endComma;

            $render = '';
            if ($header->slug == 'total_score' || $header->slug == 'score') {
                $render = ', renderer: scoreRenderer';
            }
            
            $colStr .= '            
                                        {tableData: "' . $header->slug . '" ' . $render . '}' . $endComma;
             
        }

        echo '
                                var container = jQuery("#liveStatsEvent");
                                var $parent = container.parent();
                                var autosaveNotification;
                                    container.handsontable({
                                        data: tableData,
                                        colWidths: [80, 150, 150, 120, 80, 200],
                                        colHeaders: ['.$colHeaderStr.'],
                                        columns: ['.$colStr.'],
                                        minSpareRows: 5,
                                        contextMenu: true,
                                        width: 780,
                                        height: function () {
                                          if (maxed && availableHeight === void 0) {
                                            calculateSize();
                                          }
                                          return maxed ? availableHeight : 300;
                                        },
                                      contextMenu: true,
                                      afterChange: function (change, source) {
                                        if (source === \'loadData\') {
                                          return; //don\'t save this change
                                        }
                                        if ($parent.find(\'input[name=autosave]\').is(\':checked\')) {
                                          clearTimeout(autosaveNotification);
                                          
                                          //tableData.forEach(function(jsobj) {
                                          //    alert(\'jsobj: \' + jsobj.toString());
                                          //});
                                          
                                          //var jsonStr = JSON.stringify(tableData);

                                            jQuery.post(
                                                ajaxurl,
                                                {
                                                    "action": "save_handson_table",
                                                    "perf_event_id": '.$this->perfEventsData[0]->perf_event_id.',
                                                    "event_id": '.$this->eventData->event_id.',
                                                    "data":   tableData
                                                    
                                                }, 
                                                function(response){
                                                    //jQuery("#form-performance-block").html(response);
                                                    //alert(\'response: \' + ajaxurl);
                                                }
                                            );  

                                            



                                        }
                                      }
                                    });

                                
                                var maxed = false
                                    , resizeTimeout
                                    , availableWidth
                                    , availableHeight
                                    , $window = jQuery(window);
                                    
                                var calculateSize = function () {
                                    var offset = container.offset();
                                    availableHeight = $window.height() - offset.top + $window.scrollTop();
                                };
                                $window.on(\'resize\', calculateSize);
                                
                                var scoreRenderer = function (instance, td, row, col, prop, value, cellProperties) {
                                    var escaped = Handsontable.helper.stringify(value);
                                    escaped = strip_tags(escaped, \'<div>\');
                                    td.innerHTML = escaped;
                                    return td;
                                };
                                
                                

                                var strip_tags = function(input, allowed) {
                                    allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(\'\'); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
                                    var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
                                      commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
                                    return input.replace(commentsAndPhpTags, \'\').replace(tags, function ($0, $1) {
                                      return allowed.indexOf(\'<\' + $1.toLowerCase() + \'>\') > -1 ? $0 : \'\';
                                    });
                                }; 
                                
                                jQuery(\'.maximize\').on(\'click\', function () {
                                  maxed = !maxed;
                                  $container.handsontable(\'render\');
                                });


                                jQuery(\'body\').on(\'click\', \'button[name=dump]\', function () {
                                var dump = jQuery(this).data(\'dump\');
                                var container = jQuery(dump);
                                var theData = container.handsontable(\'getData\');
                                alert(\'data: \' + theData);
                                //console.log(\'data of \' + dump, container.handsontable(\'getData\'));
                              });

                            </script>';


    }

    private function showPerformances() {
        $this->layoutStart();

        echo '
                        <h4>Select a performance</h4>
                            <form name="stats_perf_form" id="stats_perf_form" method="post" action="admin.php?page=bmlivestats-events&action=enterStats&event_id=' . $this->eventData->event_id . '">
                                <input type="hidden" id="selectedPerf" name="selectedPerf" value="0" />
                                <input type="hidden" id="selectedPerfEvent" name="selectedPerfEvent" value="0" />
                                <div id="bm-admin-accordion">';

        $accLoop = 1;
        while ($accLoop <= $this->perfCount) {
            $perfIndex = $accLoop - 1;

            echo '
                            <h3>Performance #' . $accLoop . ' - ' . date("m-d-Y g:i a", strtotime($this->perfData[$perfIndex]->date)) . '</h3>
                            <div>';

            // get the event types associated with the chosen performance
            $this->perfEventsData = $this->model->getPerformanceEvents($this->eventData->event_id, $this->perfData[$perfIndex]->perf_id);

            foreach ($this->perfEventsData as $ped) {
                echo '
                                <input class="button" type="submit" name="button_' . $accLoop . '" onClick="selPerf(' . $this->perfData[$perfIndex]->perf_id . ', ' . $ped->perf_event_id . ')" value="' . $ped->type_name . '" />';
            }

            echo '
                            </div>';

            //<div style="margin:2em; padding:5px !important"><input class="button" type="submit" name="button_'.$accLoop.'" onClick="selPerf('.$this->perfData[$perfIndex]->perf_id.')" value="Performance #'.$accLoop.' - '.$this->perfData[$perfIndex]->date.'" /></div>

            $accLoop++;
        }

        echo '
                                </div>
                            </form>
                            
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
        echo '
                
            <div class="columnLayout" style="min-height: 0;">
                <div class="rowLayout">
                    <div class="descLayout">
                        <div class="pad" data-jsfiddle="liveStatsEvent">
                            <h2>' . stripslashes($this->eventData->name) . '</h2>
                                ' . $extra . '
                            <div id="liveStatsEvent"></div>
                        </div>
                    </div>
                    <div class="codeLayout">
                        <div class="pad">';
    }

    private function layoutEnd() {
        echo '
                            
                        </div><!-- ./pad -->
                    </div><!-- ./codeLayout -->
                </div><!-- ./rowLayout -->



            </div><!-- ./columnLayout -->';
    }

}


