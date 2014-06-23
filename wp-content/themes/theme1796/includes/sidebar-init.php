<?php
function elegance_widgets_init() {
	// Header Widget
	// Location: right after the navigation
	register_sidebar(array(
		'name'					=> 'Header',
		'id' 						=> 'header-sidebar',
		'description'   => __( 'Located at the top of pages.'),
		'before_widget' => '<div id="%1$s" class="widget-header">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	// Before Content Area
	// Location: at the top of the content
	register_sidebar(array(
		'name'					=> 'Before Content Area',
		'id' 						=> 'before-content-area',
		'description'   => __( 'Located at the top of the content.'),
		'before_widget' => '<div id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
        // Artist Content Area
	// Location: above the left/right content
	register_sidebar(array(
		'name'					=> 'Artist Content Area',
		'id' 						=> 'artist-content-area',
		'description'   => __( 'Located above the left/right content areas.'),
		'before_widget' => '<div id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
	// Artist Content Ad
	// Location: ad above the left/right content
	register_sidebar(array(
		'name'					=> 'Artist Content Ad',
		'id' 						=> 'artist-content-ad',
		'description'   => __( 'Ad located above the left/right content areas.'),
		'before_widget' => '<div id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
    // PRCA Content Area
	// Location: above the video list on PRCA category page
	register_sidebar(array(
		'name'					=> 'PRCA Content Area',
		'id' 						=> 'prca-content-area',
		'description'   => __( 'Located above the video list on PRCA category page.'),
		'before_widget' => '<div id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
	// PRCA Content Ad
	// Location: ad above the video list on PRCA category page
	register_sidebar(array(
		'name'					=> 'PRCA Content Ad',
		'id' 						=> 'prca-content-ad',
		'description'   => __( 'Ad located above the video list on PRCA category page.'),
		'before_widget' => '<div id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
	// PRCA Footer Content Area
	// Location: below the video list on PRCA category page
	register_sidebar(array(
		'name'					=> 'PRCA Footer Content Area',
		'id' 						=> 'prca-footer-content-area',
		'description'   => __( 'Located below the video list on PRCA category page.'),
		'before_widget' => '<div id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
	// Left Content Area
	// Location: at the left of the content
	register_sidebar(array(
		'name'					=> 'Left Content Area',
		'id' 						=> 'left-content-area',
		'description'   => __( 'Located at the left of the content.'),
		'before_widget' => '<div id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
	// Right Content Area
	// Location: at the right of the content
	register_sidebar(array(
		'name'					=> 'Right Content Area',
		'id' 						=> 'right-content-area',
		'description'   => __( 'Located at the right of the content.'),
		'before_widget' => '<div id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
	// Sidebar Widget
	// Location: the sidebar
	register_sidebar(array(
		'name'					=> 'Sidebar',
		'id' 						=> 'main-sidebar',
		'description'   => __( 'Located at the right side of pages.'),
		'before_widget' => '<div id="%1$s" class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
    
    // PBR Content Area
	// Location: above the video list on PBR category page
	register_sidebar(array(
		'name'					=> 'PBR Content Area',
		'id' 						=> 'pbr-content-area',
		'description'   => __( 'Located above the video list on PBR category page.'),
		'before_widget' => '<div id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
    // PBR Left Footer Content Area
	// Location: below the video list on PBR category page
	register_sidebar(array(
		'name'					=> 'PBR Left Footer Content Area',
		'id' 						=> 'pbr-left-footer-content-area',
		'description'   => __( 'Located below the video list on PBR category page.'),
		'before_widget' => '<div id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
    // PBR Right Footer Content Area
	// Location: below the video list on PBR category page
	register_sidebar(array(
		'name'					=> 'PBR Right Footer Content Area',
		'id' 						=> 'pbr-right-footer-content-area',
		'description'   => __( 'Located below the video list on PBR category page.'),
		'before_widget' => '<div id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
	
	

}
/** Register sidebars by running elegance_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'elegance_widgets_init' );
?>
