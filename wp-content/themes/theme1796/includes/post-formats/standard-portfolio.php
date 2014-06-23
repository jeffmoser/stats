			
			<article id="post-<?php the_ID(); ?>" <?php post_class('post-holder'); ?> style="border-bottom: none;">

				<?php if(!is_singular()) : ?>
				
					<?php get_template_part('includes/post-formats/post-thumb'); ?>
					
					<header class="entry-header">
						
						<?php get_template_part('includes/post-formats/post-meta'); ?>
						
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php _e('Permalink to:', 'theme1796');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>

					</header>
					
					<div class="post-content">
						
					
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
							<a href="<?php the_permalink() ?>" class="link"><?php _e('READ MORE »', 'theme1796'); ?></a>
						</footer>
					</div>
				
				<?php else :?>				

				<div class="video">
				
					<?php 
					/**
					Here, I'm declaring a regex string for video, extracting the content with short codes processed, then removing the iframe from the string and displaying it. 
					Ideally, every video would be embeded through the same method, WP short codes preferrably. We'd then create a custom field to identify videos and place them in the design of the player. 
					This code will handle most things embedded with < iframe > (parsing HTML with regex is generally frowned upon because there are always exceptions to the original case) or using WP short codes (also parsing HTML with regex, but after extracting the short code). 
					Doing it this way does, however, significantly limit our ability to customize the design of the player and, in the future, embed it with other applications.
					SA 12-30-2013
					*/
					$videoMatchString = "#<iframe[^>]+>.*?</iframe>#is";
					$allContent = do_shortcode(get_the_content('')); 
					$videoMatches = preg_match($videoMatchString, $allContent, $videoContent);
					
					if($videoMatches) {
						echo $videoContent[0];
						$textContent = preg_replace($videoMatchString, "", $allContent);
					}

					?>
					
				<!--// .content -->
				<!--

				<?php the_content(); ?>

				-->

				</div>

				<header class="entry-header">
					<div id="video-meta">
						<div id="video-teaser">				
							<h1 class="entry-title"><?php the_title(); ?></h1>
							<?php get_template_part('includes/post-formats/post-meta'); ?>

							<div class="video-excerpt">
								<?php the_excerpt(); ?>
							</div>
							
							<div class="social-share">

								<div class="fb-share-button" data-href="<?php the_permalink(); ?>" data-width="100" data-type="button"></div>

								<div class="twitter-share-button"><a href="https://twitter.com/share" class="twitter-share-button" data-lang="en" data-count="none">Tweet</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></div>	

							</div>

							<div class="clearfix">&nbsp;</div>

						</div>
					</div>
				</header>

				<?php endif; ?>
			 
			</article>