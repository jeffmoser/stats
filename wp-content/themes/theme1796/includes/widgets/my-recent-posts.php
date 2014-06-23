<?php
// =============================== My Recent Posts (News widget) ======================================
class MY_PostWidget extends WP_Widget {
    /** constructor */
    function MY_PostWidget() {
        parent::WP_Widget(false, $name = 'My - Recent Posts');	
    }

  /** @see WP_Widget::widget */
    function widget($args, $instance) {	
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
				$category = apply_filters('widget_category', $instance['category']);
				$post_format = apply_filters('widget_post_format', $instance['post_format']);
				$linktext = apply_filters('widget_linktext', $instance['linktext']);
				$linkurl = apply_filters('widget_linkurl', $instance['linkurl']);
				$count = apply_filters('widget_count', $instance['count']);
				$excerpt_count = apply_filters('widget_excerpt_count', $instance['excerpt_count']);
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
						
						
						
						<?php if($post_format == 'post-format-standard') { 
						
							$args = array(
										'showposts' => $count,
										'category_name' => $category,
										'tax_query' => array(
										 'relation' => 'AND',
											array(
												'taxonomy' => 'post_format',
												'field' => 'slug',
												'terms' => array('post-format-aside', 'post-format-gallery', 'post-format-link', 'post-format-image', 'post-format-quote', 'post-format-audio', 'post-format-video'),
												'operator' => 'NOT IN'
											)
										)
										);
						
						} else { 
						
							$args = array(
								'showposts' => $count,
								'category_name' => $category,
								'tax_query' => array(
								 'relation' => 'AND',
									array(
										'taxonomy' => 'post_format',
										'field' => 'slug',
										'terms' => array($post_format)
									)
								)
								);
						
						} ?>
						
						
						
						
						<div class="latestpost-container">
							<?php $wp_query = new WP_Query( $args ); ?>
								<ul class="latestpost">
								
								<?php if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();?>
								
								<li class="clearfix">
									<?php if(has_post_thumbnail()) { ?>
										<?php
										$thumb = get_post_thumbnail_id();
										$img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
										$image = aq_resize( $img_url, 252, 189, true ); //resize & crop img
										?>
										<figure class="featured-thumbnail">
											<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $img_url ?>" alt="<?php the_title(); ?>" /></a>
										</figure>
									<?php } ?>
										
                                        <h4><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'theme1796');?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
										<div class="post-meta">
											<time datetime="<?php the_time('Y-m-d\TH:i'); ?>"><?php the_time(get_option( 'date_format' )); ?></time>
											<?php //_e('By', 'theme1796'); ?> <?php //the_author_posts_link() ?>
										</div>
									<?php if($excerpt_count!="") { ?>
										<div class="excerpt">
											<?php //$excerpt = get_the_excerpt(); echo my_string_limit_words($excerpt,$excerpt_count);?>
                                            <?php $excerpt = get_the_excerpt(); echo my_string_limit_char($excerpt,225);?>
										</div>
                                        <div class="social-share">
                                            <div class="fb-share-button" data-href="<?php the_permalink(); ?>" data-width="500" data-type="button"></div>
                                            <div class="twitter-share-button"><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-text="<?php the_title(); ?>" data-lang="en" data-count="none">Tweet</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></div>
                                        </div>
                                        <div class="post-footer">
											<?php //comments_popup_link('No Comments', '<span>1</span> Comment', '<span>%</span> Comments', 'comments-link', 'Comments are closed'); ?>
											<a href="<?php the_permalink() ?>" class="link"><?php _e('READ MORE', 'theme1796'); ?> »</a>
										</div>
                                        
									<?php }
                                        else { ?>
                                        <div class="post-footer">
											<?php //comments_popup_link('No Comments', '<span>1</span> Comment', '<span>%</span> Comments', 'comments-link', 'Comments are closed'); ?>
											<a href="<?php the_permalink() ?>" class="link"><?php _e('READ MORE', 'theme1796'); ?> »</a>
										</div>
                                        <?php } ?>
								</li>
                                
								<?php endwhile; ?>
								</ul>
								<?php endif; ?>
								
								<?php $wp_query = null; $wp_query = $temp;?>
								
								<!-- Link under post cycle -->
								<?php if($linkurl !=""){?>
									<a href="<?php echo $linkurl; ?>" class="link"><?php echo $linktext; ?></a>
								<?php } ?>
						
						</div>						
								
								

								
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
			$category = esc_attr($instance['category']);
			$post_format = esc_attr($instance['post_format']);
			$linktext = esc_attr($instance['linktext']);
			$linkurl = esc_attr($instance['linkurl']);
			$count = esc_attr($instance['count']);
			$excerpt_count = esc_attr($instance['excerpt_count']);
        ?>
      <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'theme1796'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>

      <p><label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category Slug:', 'theme1796'); ?> <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo $category; ?>" /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('post_format'); ?>"><?php _e('Post format:', 'theme1796'); ?><br />

      <select id="<?php echo $this->get_field_id('post_format'); ?>" name="<?php echo $this->get_field_name('post_format'); ?>" style="width:150px;" > 
			<option value="post-format-standard" <?php echo ($post_format === 'post-format-standard' ? ' selected="selected"' : ''); ?>>Standard</option>
      <option value="post-format-aside" <?php echo ($post_format === 'post-format-aside' ? ' selected="selected"' : ''); ?>>Aside</option>
			<option value="post-format-quote" <?php echo ($post_format === 'post-format-quote' ? ' selected="selected"' : ''); ?> >Quote</option>
			<option value="post-format-link" <?php echo ($post_format === 'post-format-link' ? ' selected="selected"' : ''); ?> >Link</option>
			<option value="post-format-image" <?php echo ($post_format === 'post-format-image' ? ' selected="selected"' : ''); ?> >Image</option>
      <option value="post-format-gallery" <?php echo ($post_format === 'post-format-gallery' ? ' selected="selected"' : ''); ?> >Gallery</option>
			<option value="post-format-audio" <?php echo ($post_format === 'post-format-audio' ? ' selected="selected"' : ''); ?> >Audio</option>
			<option value="post-format-video" <?php echo ($post_format === 'post-format-video' ? ' selected="selected"' : ''); ?> >Video</option>
      </select>
      </label></p>
      
      <p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Posts per page:'); ?><input class="widefat" style="width:30px; display:block; text-align:center" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" /></label></p>
			
			<p><label for="<?php echo $this->get_field_id('excerpt_count'); ?>"><?php _e('Excerpt length (words):'); ?><input class="widefat" style="width:30px; display:block; text-align:center" id="<?php echo $this->get_field_id('excerpt_count'); ?>" name="<?php echo $this->get_field_name('excerpt_count'); ?>" type="text" value="<?php echo $excerpt_count; ?>" /></label></p>
			
			 <p><label for="<?php echo $this->get_field_id('linktext'); ?>"><?php _e('Link Text:', 'theme1796'); ?> <input class="widefat" id="<?php echo $this->get_field_id('linktext'); ?>" name="<?php echo $this->get_field_name('linktext'); ?>" type="text" value="<?php echo $linktext; ?>" /></label></p>
			 
			 <p><label for="<?php echo $this->get_field_id('linkurl'); ?>"><?php _e('Link Url:', 'theme1796'); ?> <input class="widefat" id="<?php echo $this->get_field_id('linkurl'); ?>" name="<?php echo $this->get_field_name('linkurl'); ?>" type="text" value="<?php echo $linkurl; ?>" /></label></p>
        <?php 
    }

} // class Widget
?>
