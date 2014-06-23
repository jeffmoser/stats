<?php get_header(); ?>
	<div class="bg-video-player clearfix">
		<div id="content" class="grid_9 <?php echo of_get_option('blog_sidebar_pos') ?>">

			<?php 
	                
				if (have_posts()) : while (have_posts()) : the_post(); 
				
						// The following determines what the post format is and shows the correct file accordingly
						$format = get_post_format();

						get_template_part( 'includes/post-formats/'.$format );
						
						if($format == '')
						get_template_part( 'includes/post-formats/standard-portfolio' ); ?>
						
			<?php get_template_part( 'includes/post-formats/related-posts' ); ?>
			
			<?php comments_template('', true); ?>
						
			<?php endwhile; endif; ?>
	    

		</div><!--#content-->
<?php get_sidebar(); ?>
	</div>

	<br clear="all">
	<?php 
	    $wn_args = array(
	        'name' => 'Before Content Area',
	        'id' => 'before-content-area',
	        'description' => 'Located at the top of the content',
	        'class' => 'my-carousel',
	        'after_widget' => '</div>',
	        'before_widget' => '<div id="my_carouselwidget">',
	        'before_title' => '<h2>',
	        'after_title' => '</h2>',
	        'widget_id' => 'my_carouselwidget',
	        'widget_name' => 'My - Carousel'
	        );
	    $wn_instance = array(
	        'title' => '',
	        'divid' => 'carousel1',
	        'limit' => '',
	        'category' => 'portfolio',
	        'count' => '',
	        'wn_tags' => 'prca',
	        'wn_cat' => 'popular'
	    );
	    $wn_carousel = new MY_CarouselWidget();
	    $wn_carousel->widget($wn_args, $wn_instance); 
	?>

<?php get_footer(); ?>
