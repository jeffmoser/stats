<?php
/*
Plugin Name: Facebook Thumb Fixer
Plugin URI: http://www.thatwebguyblog.com/post/facebook-thumb-fixer-for-wordpress/
Description: Fixes the problem of the missing (or wrong) thumbnail when a post is shared on Facebook.
Author: Michael Ott
Version: 1.4
Author URI: http://www.thatwebguyblog.com
*/

// Add HELP link from the plugin page
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'link_action_on_plugin' );
function link_action_on_plugin( $links ) {
	return array_merge(array('settings' => '<a href="' . admin_url( '/options-general.php' ) . '">' . __( 'Settings', 'domain' ) . '</a> | <a href="' . admin_url( '/options-general.php?page=facebook-thumb-fixer' ) . '">' . __( 'Help', 'domain' ) . '</a>'), $links);
}

// Add field into the general settings page
$general_setting_default_fb_thumb = new general_setting_default_fb_thumb();
 
class general_setting_default_fb_thumb {
    function general_setting_default_fb_thumb( ) {
        add_filter( 'admin_init' , array( &$this , 'register_fields' ) );
    }
    function register_fields() {
        register_setting( 'general', 'default_fb_thumb', 'esc_attr' );
        add_settings_field('fav_color', '<label for="default_fb_thumb">'.__('Default Facebook Thumb' , 'default_fb_thumb' ).'</label>' , array(&$this, 'fields_html') , 'general' );
    }
    function fields_html() {
        $fbt_value = get_option( 'default_fb_thumb', '' );
		if ($fbt_value) {
        echo '<input type="text" id="default_fb_thumb" class="regular-text ltr" name="default_fb_thumb" value="' . $fbt_value . '" />';
		} else {
		echo '<input type="text" id="default_fb_thumb" class="regular-text ltr" name="default_fb_thumb" style="border:solid 1px #ff0000;" value="' . $fbt_value . '" />';
		}
		if ($fbt_value) {
		echo '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABUAAAAVCAYAAACpF6WWAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyBpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBXaW5kb3dzIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjE4NDFDNDFEQzgwMjExRTI5MUZGQzg5MzA4ODM1MEFBIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjE4NDFDNDFFQzgwMjExRTI5MUZGQzg5MzA4ODM1MEFBIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MTg0MUM0MUJDODAyMTFFMjkxRkZDODkzMDg4MzUwQUEiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MTg0MUM0MUNDODAyMTFFMjkxRkZDODkzMDg4MzUwQUEiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz6VyfjPAAABLElEQVR42qyVMYrCQBSGx4dHELyB2O1W1mKTyhOIYGHl1p5hC2uxSbFNLrBWNsHaylJSbC94BvF/8mcZYoaZSfzhI4TJ+5KQNy+d1e+HcSQBYzACQ9AHV3ABJ3AEh7rCTo10AhZgBsS4cwcZ+AG5vVAtWoIdmHuEZe2c1y/thW5F+A16Ji4D1mlS+0n1ldcNhGV6rJ/Y0gXv2CYDep7ShB/lHVFPImwbiancTs9PHB9vLOzDKKEnI2FjBwns86/9p6tsKNwpTmH16BFq+sKt9xK7MEKouQr3svGJA4Wai3A4GJ84UKg5CafNPUQcEPUcheMre1Pzq+dQNr2Or6KlsKDnfyfpPNyAW0PhjfV5dfSlPK4jh0tBYVo3T0vxX9vJ3625OCdZ03/UQ4ABAPf1Uw2qATa2AAAAAElFTkSuQmCC" style="position:relative; top:6px; left:5px;" />';
		}
		echo '<p class="description">This is the full path to your default Facebook thumb (Ideally 200 x 200px. Go <a href="' . admin_url( '/options-general.php?page=facebook-thumb-fixer' ) . '">here</a> for more information.)</p>';
		if ($fbt_value) {
		echo '<p style="font-family:Georgia;font-style:italic;color:#666;">(Note: The image shown below is scaled down. The real dimensions are actually ';
		list($width, $height) = getimagesize($fbt_value); echo $width . ' x ' . $height . ')</p>';
		echo '<img src="' . $fbt_value . '" title="Default Facebook Thumb" style="max-width:75px;" />';
		}
    }
}


// Add object type selection into the general settings page
$general_setting_object_type = new general_setting_object_type();
 
class general_setting_object_type {
    function general_setting_object_type( ) {
        add_filter( 'admin_init' , array( &$this , 'register_object_type' ) );
    }
    function register_object_type() {
        register_setting( 'general', 'homepage_object_type', 'esc_attr' );
        add_settings_field('object_type', '<label for="homepage_object_type">'.__('Homepage Object Type' , 'homepage_object_type' ).'</label>' , array(&$this, 'ot_fields_html') , 'general' );
    }
    function ot_fields_html() { ?>
       	
        <?php	// Object Types 
				// TODO: additional fields for specific object types (commented out below).
		?>
		<select value="homepage_object_type" name="homepage_object_type"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "") { echo " style='border:solid 1px red;'"; } ?>>
        	<option></option>
            <option value="article"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "article") { echo " selected"; } ?>>article</option>
            <option value="book"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "book") { echo " selected"; } ?>>book</option>
            <option value="books.author"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "books.author") { echo " selected"; } ?>>books.author</option>
            <!--option value="books.book"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "books.book") { echo " selected"; } ?>>books.book</option-->
            <!--option value="books.genre"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "books.genre") { echo " selected"; } ?>>books.genre</option-->
            <!--option value="business.business"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "business.business") { echo " selected"; } ?>>business.business</option-->
            <option value="fitness.course"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "fitness.course") { echo " selected"; } ?>>fitness.course</option>
            <option value="fitness.unit"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "fitness.unit") { echo " selected"; } ?>>fitness.unit</option>
            <option value="music.album"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "music.album") { echo " selected"; } ?>>music.album</option>
            <option value="music.playlist"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "music.playlist") { echo " selected"; } ?>>music.playlist</option>
            <option value="music.radio_station"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "music.radio_station") { echo " selected"; } ?>>music.radio_station</option>
            <option value="music.song"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "music.song") { echo " selected"; } ?>>music.song</option>
            <option value="object"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "object") { echo " selected"; } ?>>object</option>
            <!--option value="place"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "place") { echo " selected"; } ?>>place</option-->
            <option value="product"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "product") { echo " selected"; } ?>>product</option>
            <option value="product.group"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "product.group") { echo " selected"; } ?>>product.group</option>
            <!--option value="product.item"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "product.item") { echo " selected"; } ?>>product.item</option-->
            <option value="profile"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "profile") { echo " selected"; } ?>>profile</option>
            <!--option value="restaurant.menu"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "restaurant.menu") { echo " selected"; } ?>>restaurant.menu</option-->
            <!--option value="restaurant.menu_item"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "restaurant.menu_item") { echo " selected"; } ?>>restaurant.menu_item</option-->
            <!--option value="restaurant.menu_section"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "restaurant.menu_section") { echo " selected"; } ?>>restaurant.menu_section</option-->
            <option value="restaurant.restaurant"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "restaurant.restaurant") { echo " selected"; } ?>>restaurant.restaurant</option>
            <option value="video.episode"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "video.episode") { echo " selected"; } ?>>video.episode</option>
            <option value="video.movie"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "video.movie") { echo " selected"; } ?>>video.movie</option>
            <option value="video.other"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "video.other") { echo " selected"; } ?>>video.other</option>
            <option value="video.tv_show"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "video.tv_show") { echo " selected"; } ?>>video.tv_show</option>
            <option value="website"<?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "website") { echo " selected"; } ?>>website</option>
		</select>
        <p>Which Object Type should your home page be? Learn about Object Types <a href="https://developers.facebook.com/docs/reference/opengraph" target="_blank">here</a>.</p>
        <?php $hpot = get_option( 'homepage_object_type', ''); if($hpot == "") { ?>
        	<p class="howto"><strong>Note:</strong> When no selction is made, the Object Type for your home page will be 'website'.</p>
        <?php } ?>

<?php }
}

// Add metabox for Object Types
class ftf_otmeta {

    var $plugin_dir;
    var $plugin_url;
    
    function  __construct() {

        add_action( 'add_meta_boxes', array( $this, 'ftf_open_type_post_meta_box' ) );
		add_action( 'add_meta_boxes', array( $this, 'ftf_open_type_page_meta_box' ) );
        add_action( 'save_post', array($this, 'save_data') );
    }

	// Add the meta box to the POSTS sidebar
    function ftf_open_type_post_meta_box(){
        add_meta_box(
             'object_type'
            ,'Open Graph Object Type'
            ,array( &$this, 'meta_box_content' )
            ,'post'
            ,'side'
            ,'default'
        );
    }
	
	// Add the meta box to the PAGES sidebar
    function ftf_open_type_page_meta_box(){
        add_meta_box(
             'object_type'
            ,'Open Graph Object Type'
            ,array( &$this, 'meta_box_content' )
            ,'page'
            ,'side'
            ,'default'
        );
    }

    function meta_box_content(){
        global $post;
        // Use nonce for verification
        wp_nonce_field( plugin_basename( __FILE__ ), 'ftf_open_type__nounce' ); ?>

        <?php	// Object Types 
				// TODO: additional fields for specific object types (commented out below).
		?>
		<select value="ftf_open_type_field" name="ftf_open_type_field" style="width:100%;">
        	<option></option>
            <option value="article"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "article") { echo " selected"; } ?>>article</option>
            <option value="book"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "book") { echo " selected"; } ?>>book</option>
            <option value="books.author"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "books.author") { echo " selected"; } ?>>books.author</option>
            <!--option value="books.book"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "books.book") { echo " selected"; } ?>>books.book</option-->
            <!--option value="books.genre"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "books.genre") { echo " selected"; } ?>>books.genre</option-->
            <!--option value="business.business"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "business.business") { echo " selected"; } ?>>business.business</option-->
            <option value="fitness.course"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "fitness.course") { echo " selected"; } ?>>fitness.course</option>
            <option value="fitness.unit"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "fitness.unit") { echo " selected"; } ?>>fitness.unit</option>
            <option value="music.album"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "music.album") { echo " selected"; } ?>>music.album</option>
            <option value="music.playlist"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "music.playlist") { echo " selected"; } ?>>music.playlist</option>
            <option value="music.radio_station"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "music.radio_station") { echo " selected"; } ?>>music.radio_station</option>
            <option value="music.song"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "music.song") { echo " selected"; } ?>>music.song</option>
            <option value="object"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "object") { echo " selected"; } ?>>object</option>
            <!--option value="place"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "place") { echo " selected"; } ?>>place</option-->
            <option value="product"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "product") { echo " selected"; } ?>>product</option>
            <option value="product.group"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "product.group") { echo " selected"; } ?>>product.group</option>
            <!--option value="product.item"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "product.item") { echo " selected"; } ?>>product.item</option-->
            <option value="profile"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "profile") { echo " selected"; } ?>>profile</option>
            <!--option value="restaurant.menu"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "restaurant.menu") { echo " selected"; } ?>>restaurant.menu</option-->
            <!--option value="restaurant.menu_item"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "restaurant.menu_item") { echo " selected"; } ?>>restaurant.menu_item</option-->
            <!--option value="restaurant.menu_section"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "restaurant.menu_section") { echo " selected"; } ?>>restaurant.menu_section</option-->
            <option value="restaurant.restaurant"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "restaurant.restaurant") { echo " selected"; } ?>>restaurant.restaurant</option>
            <option value="video.episode"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "video.episode") { echo " selected"; } ?>>video.episode</option>
            <option value="video.movie"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "video.movie") { echo " selected"; } ?>>video.movie</option>
            <option value="video.other"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "video.other") { echo " selected"; } ?>>video.other</option>
            <option value="video.tv_show"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "video.tv_show") { echo " selected"; } ?>>video.tv_show</option>
            <option value="website"<?php $ot = get_post_meta($post->ID, "ftf_open_type", TRUE); if($ot == "website") { echo " selected"; } ?>>website</option>
		</select>
        <p>Which Object Type should you select? Learn about Object Types <a href="https://developers.facebook.com/docs/reference/opengraph" target="_blank">here</a>.</p>
        <p class="howto"><strong>Note: </strong>If no selction is made, the Object Type for this post/page will be 'article'.</p>
<?php  }
	

    function save_data($post_id){
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;

        if ( !wp_verify_nonce( $_POST['ftf_open_type__nounce'], plugin_basename( __FILE__ ) ) )
            return;

        // Check permissions
        if ( 'page' == $_POST['post_type'] ){
            if ( !current_user_can( 'edit_page', $post_id ) )
                return;
        }else{
            if ( !current_user_can( 'edit_post', $post_id ) )
                return;
        }
        $data = $_POST['ftf_open_type_field'];
        update_post_meta($post_id, 'ftf_open_type', $data, get_post_meta($post_id, 'ftf_open_type', TRUE));
        return $data;
    }
}
$ftf_otmeta = new ftf_otmeta;


// Add page into the SETTINGS menu
add_action( 'admin_menu', 'ftfixer_menu' );
function ftfixer_menu() {
	add_options_page( 'Facebook Thumb Fixer Help', 'Facebook Thumb Fixer', 'manage_options', 'facebook-thumb-fixer', 'myfbft_plugin_options' );
}
function myfbft_plugin_options() {
	if ( !current_user_can( 'read' ) )  { // This help page is accessible to anyone
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
} ?>

<div style="float:right; width:250px; padding:0 20px 180px 20px; background:#fff url(<?php echo get_option('home'); ?>/wp-content/plugins/facebook-thumb-fixer/images/tr-promo-background.png) no-repeat bottom; box-shadow: rgba(0, 0, 0, 0.0980392) 0px 1px 1px 0px; margin:55px 25px 0 0;">
    <h3>Introducing Task Rocket</h3>
    <p style="text-align:center;"><img src="<?php echo get_option('home'); ?>/wp-content/plugins/facebook-thumb-fixer/images/task-rocket.png" /></p>
    <p>Task Rocket is a simple front-end task management tool built on Wordpress.</p>
    <p><a href="http://taskrocket.info/" target="_blank" style="display:block; color:#fff; background:#74c33f; padding:10px; text-decoration:none; text-align:center; border-radius:2px;">Take it for a test flight</a></p>
</div>
	
<div class="wrap" style="margin:0 340px 0 0 !important;">
    <h2>Facebook Thumb Fixer - General Information</h2>
	<?php 
    $fbt_value = get_option( 'default_fb_thumb', '' );
    if ($fbt_value) { ?>
    <p style="border-left:solid 4px #7ad03a; padding:8px; background:#fff; border-radius:2px; box-shadow: rgba(0, 0, 0, 0.0980392) 0px 1px 1px 0px;">Well done! You currently have a default Facebook thumbnail set. You can change the default image <a href="<?php echo get_admin_url(); ?>/options-general.php">here</a>.</p>
    <p style="font-family:Georgia, 'Times New Roman', Times, serif; font-style:italic;color:#666;">(Note: The image shown below is scaled down. The real dimensions are actually <?php list($width, $height) = getimagesize($fbt_value); echo $width . " x " . $height; ?>)</p>
    <img src="<?php echo $fbt_value; ?>" alt="" style="max-width:75px;" />
    <?php } else { ?>
    <p style="border-left:solid 4px #ff0000; padding:8px; background:#fff; border-radius:2px; box-shadow: rgba(0, 0, 0, 0.0980392) 0px 1px 1px 0px;">You currently do not have a Default Facebook Thumbnail set. Set one <a href="<?php echo get_admin_url(); ?>/options-general.php">here</a>. Ideally this would be a 200 x 200px image of your logo or brand.</p>
    <?php } ?>
    <h3 style="border-top:solid 1px #ccc; margin:20px 0; padding:20px 0 0 0;">Help Topics</h3>
    <ul>
    	<li><a href="#topic01">What does this plug-in do?</a></li>
        <li><a href="#topic02">How does it work?</a></li>
        <li><a href="#topic03">How do I specify Object Types?</a></li>
        <li><a href="#topic04">What if you don't use Featured Images on your pages or posts?</a></li>
        <li><a href="#topic05">Conflicts with other plug-ins</a></li>
        <li><a href="#topic06">What if some posts use featured images and some don't?</a></li>
        <li><a href="#topic07">Occasionally it doesn't work. What's going on?</a></li>
        <li><a href="#topic08">Where can I get support and discuss this plug-in?</a></li>
    </ul>
    
    <h3 id="topic01" style="border-top:solid 1px #ccc; margin:20px 0; padding:20px 0 0 0;">What does this plug-in do?</h3>
    <p>This plug-in will place the appropriate  <a href="http://ogp.me/" target="_blank">Open Graph</a> meta properties into the &lt;head&gt; of your web pages, so that when someone links to your page on Facebook (or any other service that utilises the Open Graph protocol) the correct thumbnail and other information will show.</p>
    <p>This includes:</p>
    <p><strong>og:title</strong><br />
    The open graph title is automatically determined by the page or post title.</p>
    <p><strong>og:type</strong><br />
    The open graph type (Object Type) <a href="#topic03">can be specified</a> for the homepage, posts, and pages. By default they will be 'webpage' for the home page and 'article' for all posts and pages.</p>
    <p><strong>og:url</strong><br />
    The open graph URL is automatically determined by the permalink for the current web page.</p>
    <p><strong>og:description</strong><br />
    The open graph description is automatically determined by the post/page excerpt for internal pages, and the website tag-line when on the homepage. Be sure to add a suitable website description into the tag-line field <a href="options-general.php">here</a>, and excerpts to your pages and posts.</p>
    <p><strong>og:site_name</strong><br />
    The open graph site name 
    is automatically determined by the site title. Be sure to add a suitable title into the Site Title field <a href="options-general.php">here</a>.</p>
    <p><strong>og:image</strong><br />
    The thumbnail is derived from the featured image of your post (or page). Example:</p>
    <p><img src="<?php echo get_option('home'); ?>/wp-content/plugins/facebook-thumb-fixer/images/sample-post.png" alt="" /></p>
    <p>If your post does not have a featured image, then the default thumbnail will take over. Example:</p>
    <p><img src="<?php echo get_option('home'); ?>/wp-content/plugins/facebook-thumb-fixer/images/sample-post-default.png" alt="" /></p>
    <p>If someone links to your home page (which traditionally doesn't have a featured image) then the default image is also used here. Example:</p>
    <p><img src="<?php echo get_option('home'); ?>/wp-content/plugins/facebook-thumb-fixer/images/sample-home.png" alt="" /></p>
    
    <h3 id="topic02" style="border-top:solid 1px #ccc; margin:20px 0; padding:20px 0 0 0;">How does it work?</h3>
    <p>Whenever anyone posts a website link to Facebook, the Facebook system searches the source code for the <a href="https://developers.facebook.com/docs/concepts/opengraph/" target="_blank">Open Graph</a>  meta properties. If they are not found, then it will instead pull (several) images (if any) contained within the web page. If there are multiple images pulled then the user can select one of the many presented (though the one they choose might not be the one you are happy to have as the primary image shown on Facebook, hence this plug-in).</p>
    <p>This plug-in gets around that problem but taking  that choice away from the Facebook user, so only the thumbnail you want is displayed. This is also good in a situation where - for example - many different Facebook users share your web page,  you can trust the same thumbnail will always be used (the thumbnail might be of your brand for example).</p>
    
    <h3 id="topic03" style="border-top:solid 1px #ccc; margin:20px 0; padding:20px 0 0 0;">How do I specify Object Types?</h3>
	<h4>Posts and Pages</h4>
    <p>On each page or post you edit there is an 'Open Graph Object Type' meta box. Simply make a section from there to specify what Object Type the page or post is. Example: If the it's an article, then choose 'article'. If it's a product, choose 'product'. To help you decide what Object Type to choose, go <a href="https://developers.facebook.com/docs/reference/opengraph" target="_blank">here</a> to learn the differences between them all.</p>
    <p><strong>Note: </strong>If no selection is made for posts or pages then the Object Type will be 'article'.</p>
    <h4>Homepage</h4>
    <p>To specify what Object Type your homepage is, go to the Wordpress<strong> Settings -&gt; General</strong> page <a href="<?php echo get_admin_url(); ?>options-general.php">here</a> and make a selection from the 'Homepage Object Type' field.</p>
    <p><strong>Note: </strong>If no selection is made for the homepage then the Object Type will be 'webpage'.</p>  
        
  	<h3 id="topic04" style="border-top:solid 1px #ccc; margin:20px 0; padding:20px 0 0 0;">What if you don't use Featured Images on your pages or posts?</h3>
    <p>If you don't have featured images attached to your posts, then you can still use this plug-in just to show a default thumbnail on Facebook (as opposed to no thumbnail). This plug-in has been engineered so that if you don't use a featured image on posts then a default thumbnail is used instead. You can set a <strong>Default Facebook Thumb</strong> in the Wordpress<strong> Settings -&gt; General</strong> page <a href="<?php echo get_admin_url(); ?>options-general.php">here</a>.</p>
    
    <h3 id="topic05" style="border-top:solid 1px #ccc; margin:20px 0; padding:20px 0 0 0;">Conflicts with other plug-ins</h3>
    <p>Any other plug-in that inserts the open graph properties into the &lt;head&gt; of your website may cause a conflict and failure to work properly.</p>
    <p>To test if you have a conflict, simply view the source code of your home page and search for any instances of <strong>og:</strong> within. Typically a plug-in will output the meta tags into it's own group. For this plug-in, they will be directly below the comment <strong>&lt;!--/ Facebook Thumb Fixer Open Graph /--&gt;</strong> but other plug-ins will output differently.</p>
    <p>The only solution to resolve a conflict is to disable one of the plug-ins.</p>
    
    <h3 id="topic06" style="border-top:solid 1px #ccc; margin:20px 0; padding:20px 0 0 0;">What if some posts or pages use featured images and some don't?</h3>
    <p>The <strong>Default Facebook Thumb</strong> is used  to fall back on in the event your post doesn't have a featured image. Ideally the <strong>Default Facebook Thumb</strong> image would be of your logo or brand. You can set a <strong>Default Facebook Thumb</strong> in the Wordpress <strong>Settings -&gt; General</strong> page <a href="<?php echo get_admin_url(); ?>options-general.php">here</a>.</p>
    
    <h3 id="topic07" style="border-top:solid 1px #ccc; margin:20px 0; padding:20px 0 0 0;">Occasionally it doesn't work. What's going on?</h3>
    <p>Blame Facebook for that. Even though their system searches for the og:image meta property, for different reasons (outside the control of this plug-in) sometimes  the thumbnail doesn't load on the Facebook post.</p>
    <p>But don't fret, it's easy to get around. Using the official <a href='http://developers.facebook.com/tools/debug' target='_blank'>Facebook debugger</a> tool, paste in the URL of your post and see if the image thumb loads (scroll down to <strong>Object Properties</strong>). If it does, it should be good from now on.</p>
    
    <h3 id="topic08" style="border-top:solid 1px #ccc; margin:20px 0; padding:20px 0 0 0;">Where can I get support and discuss this plug-in?</h3>
    <p>The best place to discuss this plug-in and reach out to me for support is at <a href="http://www.thatwebguyblog.com/post/facebook-thumb-fixer-for-wordpress/" target="_blank">this page</a> on my blog.</p>
</div>

<?php }
add_action('wp_head', 'fbfixhead');
function fbfixhead() { 
	if ( !is_home() ) { // If not the homepage
	
	// If there is a post image...
	if (has_post_thumbnail()) {
	// Set '$featuredimg' variable for the featured image.
	$featuredimg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), "Full");
	$ftf_description = get_the_excerpt($post->ID);
	global $post;
	$ot = get_post_meta($post->ID, 'ftf_open_type', true);
	if($ot == "") { $default = "article"; } else $default = get_post_meta($post->ID, 'ftf_open_type', true);
	$ftf_head = '
	<!--/ Facebook Thumb Fixer Open Graph /-->
	<meta property="og:title" content="' . wp_kses_data(get_the_title($post->ID)) . '" />
	<meta property="og:type" content="'. $default . '" />
	<meta property="og:url" content="' . get_permalink() . '" /> 
	<meta property="og:description" content="' . wp_kses($ftf_description, array ()) . '" />
	<meta property="og:site_name" content="' . wp_kses_data(get_bloginfo('name')) . '" />
	<meta property="og:image" content="' . $featuredimg[0] . '" />
	';
	} else { //...otherwise, if there is no post image.
	$ftf_description = get_the_excerpt($post->ID);
	global $post;
	$ot = get_post_meta($post->ID, 'ftf_open_type', true);
	if($ot == "") { $default = "article"; } else $default = get_post_meta($post->ID, 'ftf_open_type', true);
	$ftf_head = '
	<!--/ Facebook Thumb Fixer Open Graph /-->
	<meta property="og:title" content="' . wp_kses_data(get_the_title($post->ID)) . '" />
	<meta property="og:type" content="'. $default . '" />
	<meta property="og:url" content="' . get_permalink() . '" />
	<meta property="og:description" content="' . wp_kses($ftf_description, array ()) . '" />
	<meta property="og:site_name" content="' . wp_kses_data(get_bloginfo('name')) . '" />
	<meta property="og:image" content="' . get_option('default_fb_thumb') . '" />
	';
	}
	} else { //...otherwise, it must be the homepage so do this:
	$ftf_name = get_bloginfo('name');
	$ftf_description = get_bloginfo('description');
	$ot = get_option( 'homepage_object_type', '');
	if($ot == "") { $default = "website"; } else $default = get_option( 'homepage_object_type', '');
	$ftf_head = '
	<!--/ Facebook Thumb Fixer Open Graph /-->
	<meta property="og:title" content="' . wp_kses($ftf_name, array ()) . '" />
	<meta property="og:type" content="' . $default . '" />
	<meta property="og:url" content="' . get_option('home') . '" />
	<meta property="og:description" content="' . wp_kses_data($ftf_description, array ()) . '" />
	<meta property="og:site_name" content="' . wp_kses($ftf_name, array ()) . '" />
	<meta property="og:image" content="' . get_option('default_fb_thumb') . '" />
	';
}
  echo $ftf_head;
  print "\n";
}