<?php

// singleton...
if( !class_exists( 'eventsHeader') ):
 
    /**
     * Singleton class to display header view
     * 
     * @author jeff moser
     */
    class eventsHeader {
        
        public static function render($msg=false) {
            
            
            echo '
        <div id="container">
            <div class="wrap">

                <div id="icon-bmlivestats" class="icon32"><img src="'.BMLIVESTATS_URL.'/admin/images/table32.png" /><br/></div>
                <h2>Live Stats - Events <a href="/wp-admin/admin.php?page=bmlivestats-events&action=addEvent" class="add-new-h2">Add New Event</a></h2>';
            
            if($msg) {
                echo '
                <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
                    <p>'.$msg.'</p> 
                </div>';
            }
/*
            <div class="centerLayout">
                <h1>Live Stats</h1>
                <span class="ver small"> by Blue Million, version <?php echo '.BMLIVESTATS_VERSION.'</span>
            </div>';
 * 
 */
            
            
        }
        
    }

endif;