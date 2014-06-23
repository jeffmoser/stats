			
			<article id="post-<?php the_ID(); ?>" <?php post_class('post-holder'); ?>>

				<?php if(!is_singular()) : ?>
				
					<?php get_template_part('includes/post-formats/post-thumb'); ?>
					
					<header class="entry-header">
						
						<?php get_template_part('includes/post-formats/post-meta'); ?>
						
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php _e('Permalink to:', 'theme1796');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>

					</header>
					
					<div class="post-content">
						<div class="excerpt">
							<?php 
							if (has_excerpt()) {
                                the_excerpt();
                            }
                            ?>
                        </div>
					
						<?php $post_excerpt = of_get_option('post_excerpt'); ?>
						<?php /*if ($post_excerpt=='true' || $post_excerpt=='') { ?>
						
							<div class="excerpt">
							
							
							<?php 
							
							$content = get_the_content();
							$excerpt = get_the_excerpt();

							if (has_excerpt()) {

									the_excerpt();

							} else {
							
									if(!is_search()) {

									echo my_string_limit_words($content,65);
									
									} else {
									
									echo my_string_limit_words($excerpt,65);
									
									}

							}
							
							
							?>
							
							</div>
							
							
						<?php } */ ?>
						<footer class="post-footer">
							<?php //comments_popup_link('No Comments', '<span>1</span> Comment', '<span>%</span> Comments', 'comments-link', 'Comments are closed'); ?>
							<?php if(is_category(7)) : ?>
                            <a href="<?php the_permalink() ?>" class="link"><?php _e('LISTEN »', 'theme1796'); ?></a>
                            <?php else : ?>
                            <a href="<?php the_permalink() ?>" class="link"><?php _e('READ MORE »', 'theme1796'); ?></a>
                            <?php endif; ?>
						</footer>
					</div>
				
				<?php else :?>
				
				<header class="entry-header">
					
					<?php get_template_part('includes/post-formats/post-meta'); ?>
					
					<h1 class="entry-title"><?php the_title(); ?></h1>
					
				</header>
				
				<?php get_template_part('includes/post-formats/post-thumb'); ?>
				
				<div class="content">
				
					<?php the_content(''); ?>
					
				<!--// .content -->
				</div>
				<div class="social-share">

								<div class="fb-share-button" data-href="<?php the_permalink(); ?>" data-width="100" data-type="button"></div>

								<div class="twitter-share-button"><a href="https://twitter.com/share" class="twitter-share-button" data-lang="en" data-count="none">Tweet</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></div>	

							</div>
				<?php endif; ?>
			 
			</article>
