			</div><!--.row-->
			</div><!--.primary_content_wrap-->
			<footer id="footer">
			<div align="center" class="bg-banner">
			
				<!-- Small Ad -->
				<div id='div-gpt-ad-1385349410056-1' class="adTv smallAd" style='width:320px; height:50px;'>
				<script type='text/javascript'>
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-1385349410056-1'); });
				</script>
				</div>
			
				<!-- Large Ad -->
				<div id='div-gpt-ad-1385349410056-2' class="adTv largeAd" style='width: auto; margin-top: 5%;'>
				<script type='text/javascript'>googletag.cmd.push(function() { googletag.display('div-gpt-ad-1385349410056-2'); });</script>
			</div>
			</div>
			<br>
		</footer>
	</div><!--.container-->
</div><!--#main-->

<div class="row" style="max-width: 100%; 	background-color: #023469;">
	<div class="grid_12">
		<div id="copyright" class="clearfix">
			<?php if ( of_get_option('footer_menu') == 'true') { ?>  
				<nav class="footer">
					<?php wp_nav_menu( array(
						'container'       => 'ul', 
						'menu_class'      => 'footer-nav', 
						'depth'           => 0,
						'theme_location' => 'footer_menu' 
						)); 
					?>
				</nav>
			<?php } ?>
			<div id="footer-text">
				<?php $myfooter_text = of_get_option('footer_text'); ?>
				
				<?php if($myfooter_text){?>
					<?php echo of_get_option('footer_text'); ?>
				<?php } else { ?>
					<a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>" class="site-name"><?php bloginfo('name'); ?></a> <?php _e('is proudly powered by', 'theme1796'); ?> <a href="http://wordpress.org">WordPress</a> <a href="<?php if ( of_get_option('feed_url') != '' ) { echo of_get_option('feed_url'); } else bloginfo('rss2_url'); ?>" rel="nofollow" title="<?php _e('Entries (RSS)', 'theme1796'); ?>"><?php _e('Entries (RSS)', 'theme1796'); ?></a> and <a href="<?php bloginfo('comments_rss2_url'); ?>" rel="nofollow"><?php _e('Comments (RSS)', 'theme1796'); ?></a>
				<?php } ?>
				<?php if( is_front_page() ) { ?>
				<!--More <a rel="nofollow" href="http://www.templatemonster.com/category/fashion-wordpress-templates/" target="_blank">Fashion WordPress Templates at TemplateMonster.com</a>-->
				<?php } ?>
			</div>
		</div><!--#copyright-->
	</div>
</div><!--.row-->

<?php wp_footer(); ?> <!-- this is used by many Wordpress features and for plugins to work properly -->
<?php if(of_get_option('ga_code')) { ?>
	<script type="text/javascript">
		<?php echo stripslashes(of_get_option('ga_code')); ?>
	</script>
  <!-- Show Google Analytics -->	
<?php } ?>
</body>
</html>
