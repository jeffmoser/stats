<?php

// singleton...
if( !class_exists( 'eventsFooter') ):
 
    /**
     * Singleton class to display footer view
     * 
     * @author jeff moser
     */
    class eventsFooter {
        
        public static function render() {
            
            
            echo '
            </div><!-- ./wrap -->
        </div> <!--  ./container -->';
            
            
        }
    }

endif;