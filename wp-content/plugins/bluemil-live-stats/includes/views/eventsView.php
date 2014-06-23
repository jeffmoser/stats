<?php
// TODO - trash this if possible, as it's now only a wrapper for a form

// singleton...
if( !class_exists( 'eventsView') ):
 
    /**
     * Singleton class to display events view
     * 
     * @author jeff moser
     */
    class eventsView {
    
        
        public static function renderPreForm() {
            echo '
                <form id="events-filter" method="get">
                    <input type="hidden" name="page" value="'.$_REQUEST['page'].'" />';
        }
        
        public static function renderPostForm() {
            echo '
                    </form>';
        }
        
    }

endif;