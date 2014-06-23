<?php
// =============================== My Carousel widget ======================================
class MY_CarouselWidget extends WP_Widget {
    /** constructor */
    function MY_CarouselWidget() {
        parent::WP_Widget(false, $name = 'My - Carousel');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {	
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
				$limit = apply_filters('widget_limit', $instance['limit']);
				$category = apply_filters('widget_category', $instance['category']);
				$count = apply_filters('widget_count', $instance['count']);
                
                
                if(!isset($instance['divid'])) {
                    $instance['divid'] = 'carousel';
                }
                
                $wp_cat = '';
                if(isset($instance['wn_cat'])) {
                    $wp_cat = '&portfolio_category='.$instance['wn_cat'];
                    
                }
                
                $wp_tag = '';
                if(isset($instance['wn_tags'])) {
                    $wp_tag = '&portfolio_tags='.$instance['wn_tags'];
                    
                }
        ?>
				<?php echo $before_widget; ?>
					<?php if ( $title )
								echo $before_title . $title . $after_title; ?>
							
							<!-- Elastislide Carousel -->
							<div id="<?php echo $instance['divid']; ?>" class="es-carousel-wrapper">
								<div class="es-carousel">
									<ul>
										<?php $limittext = $limit;?>
										<?php global $more;	$more = 0;?>
										<?php query_posts("posts_per_page=". $count ."&post_type=" . $category.$wp_cat.$wp_tag);?>
										<?php while (have_posts()) : the_post(); ?>
										
										<?php
										$thumb = get_post_thumbnail_id();
										$img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
										$image = aq_resize( $img_url, 211, 109, true ); //resize & crop img
										?>
										
										<li>
										
										<?php if(has_post_thumbnail()) { ?>
											<figure class="thumbnail"><a href="<?php the_permalink(); ?>"><img src="<?php echo $image ?>" alt="<?php the_title(); ?>" /><span class="play"></span></a></figure>
										<?php } ?>
										
											<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
										
										<?php if($limittext!="" || $limittext!=0){ ?>
										
											<div class="excerpt"><?php $excerpt = get_the_excerpt(); echo my_string_limit_words($excerpt,$limittext); ?></div>
										
										<?php } ?>
											<a href="<?php the_permalink() ?>" class="link"><?php _e('Watch Now &raquo;', 'theme1796'); ?></a>
											
										</li>
										
										
										 <?php endwhile; ?>
										<?php wp_reset_query(); ?>
									</ul>
								</div>
							</div>
							<script type="text/javascript">
								jQuery('#<?php echo $instance['divid']; ?>').elastislide({
									imageW 	: 205,
									minItems	: 4,
									onClick		: function() {}
								});
							</script>
							<!-- End Elastislide Carousel -->
			
			
				<?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
			$title = esc_attr($instance['title']);
			$limit = esc_attr($instance['limit']);
			$category = esc_attr($instance['category']);
			$count = esc_attr($instance['count']);
    ?>
      <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'theme1796'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>

      <p><label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Limit Text:', 'theme1796'); ?> <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label></p>
      <p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Posts per page:', 'theme1796'); ?><input class="widefat" style="width:30px; display:block; text-align:center" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" /></label></p>

      <p><label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Post type:', 'theme1796'); ?><br />

      <select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" style="width:150px;" > 
      <option value="testi" <?php echo ($category === 'testi' ? ' selected="selected"' : ''); ?>>Testimonials</option>
      <option value="portfolio" <?php echo ($category === 'portfolio' ? ' selected="selected"' : ''); ?> >Portfolio</option>
      <option value="" <?php echo ($category === '' ? ' selected="selected"' : ''); ?>>Blog</option>
      </select>
      </label></p>
       
      <?php 
    }
    
    
} // class Carousel Widget



// jm - added to support ajax calls
function enqueue_scripts_styles_init() {
	wp_enqueue_script( 'ajax-script', get_stylesheet_directory_uri().'/js/script.js', array('jquery'), 1.0 ); // jQuery will be included automatically
	// get_template_directory_uri() . '/js/script.js'; // Inside a parent theme
	// get_stylesheet_directory_uri() . '/js/script.js'; // Inside a child theme
	// plugins_url( '/js/script.js', __FILE__ ); // Inside a plugin
	wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) ); // setting ajaxurl
}
add_action('init', 'enqueue_scripts_styles_init');
 
function ajax_action_stuff() {
	$cat = $_GET['cat']; // getting variables from ajax post
	// doing ajax stuff
	// manual call to carousel widget
    $wn_args = array(
        'name' => 'Before Content Area',
        'id' => 'before-content-area',
        'description' => 'Located at the top of the content',
        'class' => '',
        'after_widget' => '</div>',
        'before_widget' => '<div id="my_carouselwidget-2">',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
        'widget_id' => 'my_carouselwidget-2',
        'widget_name' => 'My - Carousel'
        );
    $wn_instance = array(
        'title' => '',
        'limit' => '',
        'category' => 'portfolio',
        'count' => '',
        'wn_cat' => $cat
    );
    $wn_carousel = new MY_CarouselWidget();
    $wn_carousel->widget($wn_args, $wn_instance);
    
    
    
	die(); // stop executing script
}
add_action( 'wp_ajax_ajax_action', 'ajax_action_stuff' ); // ajax for logged in users
add_action( 'wp_ajax_nopriv_ajax_action', 'ajax_action_stuff' ); // ajax for not logged in users
