    <?php $post_meta = of_get_option('post_meta'); ?>
		<?php if ($post_meta=='true' || $post_meta=='') { ?>
			<div class="post-meta">
				<time datetime="<?php the_time('Y-m-d\TH:i'); ?>"><?php the_time(get_option( 'date_format' )); ?></time>
				<?php //_e('By', 'theme1796'); ?> <?php //the_author_posts_link() ?>
			</div><!--.post-meta-->
		<?php } ?>		
