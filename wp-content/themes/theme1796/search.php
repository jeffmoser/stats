<?php get_header(); ?>
<div id="content" class="grid_9 <?php echo of_get_option('blog_sidebar_pos') ?>">

  <h1 class="sp-title">Search for: <span>"<?php the_search_query(); ?>"</span></h1>
  
	<?php 
                
		if (have_posts()) : while (have_posts()) : the_post(); 
		
				// The following determines what the post format is and shows the correct file accordingly
				$format = get_post_format();
				get_template_part( 'includes/post-formats/'.$format );
				
				if($format == '')
				get_template_part( 'includes/post-formats/standard' );
				
		 endwhile; else:
		 
		 ?>
		 
		 <div class="no-results">
			<?php echo '<p>' . __('Oops, looks we don\'t have anything for this term. Maybe check your spelling?', 'theme1796') . '</p>'; ?>
			<!--<p><?php _e('We apologize for any inconvenience, please', 'theme1796'); ?> <a class="link" style="padding: 0; border-bottom: 1px solid;" href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>"><?php _e('return to the home page', 'theme1796'); ?></a> <?php _e('or search for something else.', 'theme1796'); ?></p>-->
			<?php get_search_form(); /* outputs the default Wordpress search form */ ?>
		</div><!--no-results-->
		
	<?php endif; ?>
    
  <?php get_template_part('includes/post-formats/post-nav'); ?>

</div><!-- #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>