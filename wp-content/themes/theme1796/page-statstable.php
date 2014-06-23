<?php
/**
 * Template Name: Stats Table
 */


get_header(); ?>
	<div class="bg-video-player clearfix">
		<div id="content" class="grid_9 <?php echo of_get_option('blog_sidebar_pos') ?>">
		<h1 class="sp-title"><?php the_title(); ?></h1>
		
			<?php 
	                
				if (have_posts()) : while (have_posts()) : the_post(); 
				
                
                    // JM - I don't think the format lines below are needed. If it gets quirky, uncomment to include format.
						// The following determines what the post format is and shows the correct file accordingly
						//$format = get_post_format();

						//get_template_part( 'includes/post-formats/'.$format );
                
                the_content();
						
			?>
						
			<?php get_template_part( 'includes/post-formats/related-posts' ); ?>
			
			<?php comments_template('', true); ?>
						
			<?php endwhile; endif; ?>
	    

		</div><!--#content-->
<?php get_sidebar(); ?>
	</div>

	<br clear="all">
	

<?php get_footer(); ?>
