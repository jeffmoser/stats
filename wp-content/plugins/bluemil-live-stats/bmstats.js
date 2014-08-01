
var showPerformanceForm = function(eventId) {
    var perfCount = jQuery('#performance_count').val();
    var origPerfCount = jQuery('#perfCount').val();
    var lastSavedPerf = 0;
    
    if(perfCount < origPerfCount) {
        // ask user to confirm
        var okToDelete = confirm('You are changing the number of performances. Doing this may delete data. Would you like to continue?');
        
        if(!okToDelete) {
            jQuery('#performance_count').val('2');
            return false;
        }
    }
    
    jQuery.post(
        ajaxurl, 
        {
            'action': 'show_performance_form',
            'perfCount':   perfCount,
            'eventId': eventId,
            'deletePerfAfter': lastSavedPerf
        }, 
        function(response){
            jQuery('#form-performance-block').html(response);
        }
    );
}




var refreshScores = function() {
    var eventId = jQuery('#event_id').val();
    var perfId = jQuery('#perf_id').val();
    var perfEventId = jQuery('#perf_event_id').val();
    
    // show spinner
    jQuery('img.ajax-loader').css({ visibility: 'visible' });
    
    jQuery.post(
        '/wp-admin/admin-ajax.php',
        {
            'action': 'update_stats_table',
            'event_id': eventId,
            'perf_id': perfId,
            'perf_event_id': perfEventId
        },
        function(response) {
            // hide spinner
            jQuery('img.ajax-loader').css({ visibility: 'hidden' });
            jQuery('#statsFrontContainer').html(response);
        }
    );
}

                                        

var showHandsonTable = function(perfId, targetDiv) {
    jQuery.post(
        ajaxurl, 
        {
            'action': 'show_handson_table',
            'perfId': perfId
        }, 
        function(response){
            jQuery('#'+targetDiv).html(response);
        }
    );
}


// capture event selection, store in hidden var and submit form
var bmstatsSelectEvent = function(eid) {
    jQuery('#event_id').val(eid);
    jQuery('#events_select').submit();
}

var selectFrontPerf = function(perfId, perfEventId) {
    jQuery('#perf_id').val(perfId);
    jQuery('#perf_event_id').val(perfEventId);
    jQuery('#events_select').submit();
}


jQuery(document).ready(function($) {
        $( "#bm-admin-accordion" ).accordion({
			collapsible: true,
            header: "h3"
		});
        
        
        // getter
        var header = $( ".selector" ).accordion( "option", "header" );
        // setter
        $( ".selector" ).accordion( "option", "header", "h3" );
        
	});

