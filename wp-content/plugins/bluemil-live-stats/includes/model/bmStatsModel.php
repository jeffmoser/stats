<?php

/**
 * Model for bmLiveStats
 *
 * @author jeff
 */
class bmStatsModel {

    private $message;

    /**
     * WP database object
     * 
     * @var $dbx object
     */
    private $dbx;

    /*
     * Value for today's date
     */
    private $today;

    
    
    public function __construct() {
        global $wpdb;
        $this->dbx = $wpdb;

        // defalut values
        $this->mode = 'index';
        $this->today = date("Y-m-d");
    }
    
    public function getEventsById($id) {
        return $this->getEvents(false, false, $id);
    }

    public function getEvents($pastDate=false, $limitToPublished=false, $adminId=0) {
        $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'date'; //If no sort, default to title
        $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
        
        // only show published?
        $where = '';
        if($limitToPublished) {
            $where = 'WHERE is_published = 1';
        }
        else if($adminId > 0) {
            $where = "WHERE created_by = $adminId";
        }
        
        
        $dateSwitch = '>';
        if($pastDate) {
            $dateSwitch = '<=';
            $orderby = 'date';
            $order = 'desc';
        }

        // join on performance table for the date
        $query = "SELECT * 
                        FROM {$this->dbx->bmlivestats_events} events
                        JOIN {$this->dbx->bmlivestats_performance} perf ON perf.event_id = events.event_id
                        $where
                        ORDER BY $orderby $order";
                        //WHERE perf.date $dateSwitch CAST('{$this->today}' AS DATE) ORDER BY $orderby $order";

                        
        $results = $this->dbx->get_results($query);

        // group events together
        if (count($results) > 1) {
            $lastEventId = $arrayCount = 0;
            $groupedResults = $existingEventArr = array();
            foreach ($results as $row) {
                if(!in_array($row->event_id, $existingEventArr)) { // only show one event, even with multiple performances
                    $arrayCount++;
                    $groupedResults[$arrayCount] = new stdClass();

                    $groupedResults[$arrayCount]->event_id = $row->event_id;
                    $groupedResults[$arrayCount]->name = $row->name;
                    $groupedResults[$arrayCount]->location = $row->location;
                    $groupedResults[$arrayCount]->created = $row->created;
                    $groupedResults[$arrayCount]->created_by = $row->created_by;
                    $groupedResults[$arrayCount]->is_published = $row->is_published;
                    $groupedResults[$arrayCount]->start_date = $row->date;
                    $groupedResults[$arrayCount]->end_date = $row->date;
                    $groupedResults[$arrayCount]->perf_count = 1;
                } else {
                    $groupedResults[$arrayCount]->perf_count += 1; // = intval($groupedResults[$arrayCount]perf_count']) + 1;
                    $groupedResults[$arrayCount]->end_date = $row->date;
                }
                $existingEventArr[] = $row->event_id;
            }

        

            return $groupedResults;
        }
        
        if(empty($groupedResults))
            return false;
        
        
        $groupedResults[0] = new stdClass();
        $groupedResults[0]->event_id = $results[0]->event_id;
        $groupedResults[0]->name = $results[0]->name;
        $groupedResults[0]->location = $results[0]->location;
        $groupedResults[0]->created = $results[0]->created;
        $groupedResults[0]->created_by = $results[0]->created_by;
        $groupedResults[0]->is_published = $results[0]->is_published;
        $groupedResults[0]->start_date = $results[0]->date;
        $groupedResults[0]->end_date = $results[0]->date;
        $groupedResults[0]->perf_count = 1;
        return $groupedResults;
    }
    
    public function getPastEvents() {
        
    }

    public function getSingleEvent($id) {
        $results = $this->dbx->get_row("SELECT * FROM {$this->dbx->bmlivestats_events} WHERE event_id = $id");
        return $results;
    }

    public function getSingleEventPerformances($id, $peid = 0) {
        $select = "SELECT * FROM {$this->dbx->bmlivestats_performance} WHERE ";

        $where = "event_id = $id";
        if ($peid) {
            $where = "perf_id = $peid";
        }
        $select .= $where;

        $results = $this->dbx->get_results($select);
        return $results;
    }

    public function addEvent($params) {
        // format the strings and just store everything else needed in the array
        $dataArr = array(
            'name' => sanitize_text_field(str_replace('+', ' ', $params['event_name'])),
            'location' => sanitize_text_field(str_replace('+', ' ', $params['event_location'])),
            'created' => date('Y-m-d H:i:s'),
            'created_by' => absint($params['event_creator']),
            'is_published' => intval($params['is_published'])
        );
        $dataTypeArr = array('%s', '%s', '%s', '%d', '%d');
        $results = $this->dbx->insert($this->dbx->bmlivestats_events, $dataArr, $dataTypeArr);

        if (!$results) {
            return $results;
        }

        $eventId = $this->dbx->insert_id;

        // parse and format date/time for each performance
        $i = 1;
        while ($i <= $params['perfCount']) {
            $perfdateName = 'perf_date_' . $i;
            $datetime = explode(' ', $params[$perfdateName]);
            $rawDate = explode('/', $datetime[0]);
            $formattedDate = $rawDate[2] . '-' . $rawDate[0] . '-' . $rawDate[1] . ' ' . $datetime[1] . ':00';


            $dataArr = array(
                'event_id' => $eventId,
                'date' => $formattedDate,
                'perf_num' => $i
            );

            $dataTypeArr = array('%d', '%s', '%d');
            $results = $this->dbx->insert($this->dbx->bmlivestats_performance, $dataArr, $dataTypeArr);

            $i++;
        }

        return $results;
    }

    public function editEvent($params) {
        // format the strings and just store everything else needed in the array
        $dataArr = array(
            'name' => sanitize_text_field(str_replace('+', ' ', $params['event_name'])),
            'location' => sanitize_text_field(str_replace('+', ' ', $params['event_location'])),
            'created' => date('Y-m-d H:i:s'),
            'created_by' => absint($params['event_creator']),
            'is_published' => intval($params['is_published'])
        );
        $dataTypeArr = array('%s', '%s', '%s', '%d', '%d');

        $where = array('event_id' => absint($params['event_id']));

        $results = $this->dbx->update($this->dbx->bmlivestats_events, $dataArr, $where, $dataTypeArr);

        // parse and format date/time for each performance
        $i = 1;
        while ($i <= $params['perfCount']) {
            $perfdateName = 'perf_date_' . $i;
            $perfIdName = 'perf_id_' . $i;
            $datetime = explode(' ', $params[$perfdateName]);
            $rawDate = explode('/', $datetime[0]);
            $formattedDate = $rawDate[2] . '-' . $rawDate[0] . '-' . $rawDate[1] . ' ' . $datetime[1] . ':00';


            $dataArr = array(
                'event_id' => $params['event_id'],
                'date' => $formattedDate,
                'perf_num' => $i
            );
            $dataTypeArr = array('%d', '%s', '%d');

            if (isset($params[$perfIdName])) {
                $where = array('perf_id' => $params[$perfIdName]);
                $results = $this->dbx->update($this->dbx->bmlivestats_performance, $dataArr, $where, $dataTypeArr);
            } else {
                $results = $this->dbx->insert($this->dbx->bmlivestats_performance, $dataArr, $dataTypeArr);
            }
            $i++;
        }

        return $results;
    }

    public function deleteEvent($params) {
        $where = array('event_id' => absint($params['event_id']));
        $results = $this->dbx->delete($this->dbx->bmlivestats_events, $where);

        return $results;
    }

    public function getStatsHeaders($perfEventId) {
        $select = "SELECT sm.stats_meta_id, t.name, t.slug 
                        FROM {$this->dbx->bmlivestats_stats_meta} sm
                        JOIN {$this->dbx->bmlivestats_template} t ON sm.template_id = t.template_id
                        WHERE perf_event_id = $perfEventId ORDER BY `order`";

        $results = $this->dbx->get_results($select);

        return $results;
    }

    public function getFrontStatsData($perfEventId) {
        return $this->getStatsData($perfEventId, 'group');
    }
    
    
    public function getStatsData($perfEventId, $group=false) {
        $select = "SELECT st.stats_meta_id, st.value, st.row_id, t.slug
                        FROM {$this->dbx->bmlivestats_stats} st
                        JOIN {$this->dbx->bmlivestats_stats_meta} m ON st.stats_meta_id = m.stats_meta_id
                        JOIN {$this->dbx->bmlivestats_template} t ON m.template_id = t.template_id
                        WHERE st.perf_event_id = $perfEventId ORDER BY st.row_id, st.stats_meta_id";
        //JOIN {$this->dbx->bmlivestats_athlete} ath ON ath.athlete_id = st.athlete_id

        $results = $this->dbx->get_results($select);

        // group results by athlete (row)
        $retArr = array();
        $lastRow = $rowNum = 0;
        foreach ($results as $row) {
            if ($lastRow != $row->row_id) {
                $lastRow = $row->row_id;
                $rowNum++;
            }
            $retArr[$rowNum][] = $row;
        }

        return $retArr;
    }

    /**
     * Return all event types
     * @return obj
     */
    public function getEventTypes() {
        $select = "SELECT *
                        FROM {$this->dbx->bmlivestats_event_type}";
        $results = $this->dbx->get_results($select);

        return $results;
    }

    public function savePerformanceEvents($data) {


        foreach ($data as $perfId => $perfData) {
            foreach ($perfData as $eventTypeId) {
                $dataArr = array(
                    'perf_id' => $perfId,
                    'event_type_id' => $eventTypeId
                );
                $dataTypeArr = array('%d', '%d');
                $results = $this->dbx->insert($this->dbx->bmlivestats_perf_event, $dataArr, $dataTypeArr);

                if (!$results) {
                    return false;
                }

                $perfEventId = $this->dbx->insert_id;


                // get event type template data
                $select = "SELECT * FROM {$this->dbx->bmlivestats_template}
                        WHERE event_type_id = $eventTypeId";
                $templateData = $this->dbx->get_results($select);

                // write records to stats_meta table
                foreach ($templateData as $t) {
                    $dataArr = array(
                        'perf_event_id' => $perfEventId,
                        'template_id' => $t->template_id
                    );
                    $dataTypeArr = array('%s', '%s', '%d', '%d');
                    $results = $this->dbx->insert($this->dbx->bmlivestats_stats_meta, $dataArr, $dataTypeArr);
                }
            }
        }
    }

    public function getEventTypeIdByEventId($eventId) {
        $select = "SELECT p.perf_id, pe.event_type_id
                        FROM {$this->dbx->bmlivestats_performance} p
                        JOIN {$this->dbx->bmlivestats_perf_event} pe ON p.perf_id = pe.perf_id
                        WHERE p.event_id = $eventId";
        $results = $this->dbx->get_results($select);

        return $results;
    }

    public function getPerformanceEvents($eventId, $perfId, $perfEventId = 0) {
        $peClause = "AND pe.perf_id = $perfId";
        if ($perfEventId) {
            $peClause = "AND pe.perf_event_id = $perfEventId";
        }
        $select = "SELECT p.perf_id, pe.perf_event_id, pe.event_type_id, et.type_name
                        FROM {$this->dbx->bmlivestats_performance} p
                        JOIN {$this->dbx->bmlivestats_perf_event} pe ON p.perf_id = pe.perf_id
                            $peClause
                        JOIN {$this->dbx->bmlivestats_event_type} et ON pe.event_type_id = et.event_type_id
                        WHERE p.event_id = $eventId";

        $results = $this->dbx->get_results($select);

        return $results;
    }

    public function getPerformanceNum($perfId) {
        $select = "SELECT perf_num
                        FROM {$this->dbx->bmlivestats_performance}
                        WHERE perf_id = $perfId";

        $result = $this->dbx->get_row($select);

        return $result;
    }
    
    
    /**
     * Delete row from stats table in preparation for new data.
     * 
     * @param int $perfEventId
     * @param int $rowId
     */
    public function wipeStatsRowsById($perfEventId, $rowId) {
        $query = "DELETE FROM {$this->dbx->bmlivestats_stats}
                    WHERE perf_event_id = %d 
                    AND row_id = %d";
        
        $this->dbx->query(
                $this->dbx->prepare($query, $perfEventId, $rowId)
                );
        
    }
    
    /** No longer used
    public function statsRowExists($perfEventId, $rowId, $statsMetaId) {
        $select = "SELECT count(*) FROM {$this->dbx->bmlivestats_stats}
                    WHERE perf_event_id = $perfEventId 
                    AND row_id = $rowId
                    AND stats_meta_id = $statsMetaId";  
                
        $result = $this->dbx->get_results($select);
        
        return $result;
    }
     *
     */
    
    
    public function getOrderedStatsMetaId($perfEventId) {
        $select = "SELECT stats_meta_id FROM {$this->dbx->bmlivestats_stats_meta} sm "
        . "JOIN {$this->dbx->bmlivestats_template} t ON sm.template_id = t.template_id "
        . "WHERE sm.perf_event_id = $perfEventId "
        . "ORDER BY t.order";
        
        $result = $this->dbx->get_results($select);
        
        return $result;
    }


    /**
     * Wipe clean the stats table for the given perf_event so
     * new data can be recorded.
     * @param int $perfEventId
     * @return void
     */
    public function deletePerformanceStats($perfEventId) {
        $where = array('perf_event_id' => $perfEventId);
        $results = $this->dbx->delete($this->dbx->bmlivestats_stats, $where);
    }
    
    /**
     * Write a new record to stats table
     * @param array $data
     */
    public function insertStatsRow($perfEventId, $rowId, $statsMetaId, $statVal) {
        $data = array(
            'perf_event_id' => $perfEventId,
            'row_id'        => $rowId,
            'stats_meta_id' => $statsMetaId,
            'value'         => $statVal,
            'created'       => date("Y-m-d H:i:s")
        );
        $this->dbx->insert($this->dbx->bmlivestats_stats, $data);
    }
    
    
    
    
    public function updateStatsRow($perfEventId, $rowId, $statsMetaId, $statVal) {
        $data = array('value' => $statVal);
        $where = array(
            'perf_event_id' => $perfEventId,
            'row_id'        => $rowId,
            'stats_meta_id' => $statsMetaId
        );
        $success = $this->dbx->update($this->dbx->bmlivestats_stats, $data, $where);
        
        // send feedback if this gets fouled up
        //if(!$success || $success > 1)
            //mail('jeff@jeffmoser.com', 'wranglernetwork db update', 'data in order: '.$perfEventId.':'.$rowId.':'.$statsMetaId.':'.$statVal, 'From:script@wranglernetwork.com');
        
    }
    
    
    /**
     * Return an array of event id numbers owned by the current user
     * @param int $id
     */
    public function getValidEventsByUserId() {
        $userId = get_current_user_id();
        
        $select = "SELECT event_id"
                . " FROM {$this->dbx->bmlivestats_events}"
                . " WHERE created_by = $userId";
        
        $result = $this->dbx->get_results($select);
        
        // format as plain array
        $retArr = array();
        foreach($result as $row) {
            $retArr[] = $row->event_id;
        }
        
        return $retArr;
                
    }

}
