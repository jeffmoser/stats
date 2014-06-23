<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes();?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes();?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes();?>> <![endif]-->
<!--[if IE 9 ]><html class="ie ie9" <?php language_attributes();?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes();?>> <!--<![endif]-->
<head>
	<title><?php if ( is_category() ) {
		echo __('Category Archive for &quot;', 'theme1796'); single_cat_title(); echo __('&quot; | ', 'theme1796'); bloginfo( 'name' );
	} elseif ( is_tag() ) {
		echo __('Tag Archive for &quot;', 'theme1796'); single_tag_title(); echo __('&quot; | ', 'theme1796'); bloginfo( 'name' );
	} elseif ( is_archive() ) {
		wp_title(''); echo __(' Archive | ', 'theme1796'); bloginfo( 'name' );
	} elseif ( is_search() ) {
		echo __('Search for &quot;', 'theme1796').wp_specialchars($s).__('&quot; | ', 'theme1796'); bloginfo( 'name' );
	} elseif ( is_home() || is_front_page()) {
		bloginfo( 'name' ); echo ' | '; bloginfo( 'description' );
	}  elseif ( is_404() ) {
		echo __('Error 404 Not Found | ', 'theme1796'); bloginfo( 'name' );
	} elseif ( is_single() ) {
		wp_title('');
	} else {
		echo wp_title( ' | ', false, 'right' ); bloginfo( 'name' );
	} ?></title>
	<meta name="description" content="<?php wp_title(); echo ' | '; bloginfo( 'description' ); ?>" />
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<?php if(of_get_option('favicon') != ''){ ?>
	<link rel="icon" href="<?php echo of_get_option('favicon', "" ); ?>" type="image/x-icon" />
	<?php } else { ?>
	<link rel="icon" href="<?php bloginfo( 'template_url' ); ?>/favicon.ico" type="image/x-icon" />
	<?php } ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'rss2_url' ); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'atom_url' ); ?>" />
	<?php /* The HTML5 Shim is required for older browsers, mainly older versions IE */ ?>
	<!--[if lt IE 8]>
		<div style=' clear: both; text-align:center; position: relative;'>
			<a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" alt="" /></a>
		</div>
	<![endif]-->
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/normalize.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/prettyPhoto.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/cameraslideshow.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/1140.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/touchTouch.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/media-queries.css" />
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700' rel='stylesheet' type='text/css'>
	<!--[if lt IE 10]>
  		<link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/css/ie.css"> 
	<![endif]-->
	<?php
		/* We add some JavaScript to pages with the comment form
		 * to support sites with threaded comments (when in use).
		 */
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );
	
		/* Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
		wp_head();
	?>
	<!--[if lt IE 9]>
		<style type="text/css">
			#back-top span  {
				behavior:url(<?php bloginfo('stylesheet_directory'); ?>/PIE.php)
			}
		</style>
		<script src="<?php bloginfo( 'template_url' ); ?>/js/css3-mediaqueries.js" type="text/javascript"></script>
	<![endif]-->
	<!--[if (gt IE 9)|!(IE)]><!-->
		<script src="<?php bloginfo( 'template_url' ); ?>/js/jquery.mobile.customized.min.js" type="text/javascript"></script>
	<!--<![endif]-->
  
	<script type="text/javascript">
  	// initialise plugins
		jQuery(function(){
			// main navigation init
			jQuery('ul.sf-menu').superfish({
				delay:       <?php echo of_get_option('sf_delay'); ?>, 		// one second delay on mouseout 
				animation:   {opacity:'<?php echo of_get_option('sf_f_animation'); ?>'<?php if (of_get_option('sf_sl_animation')=='show') { ?>,height:'<?php echo of_get_option('sf_sl_animation'); ?>'<?php } ?>}, // fade-in and slide-down animation
				speed:       '<?php echo of_get_option('sf_speed'); ?>',  // faster animation speed 
				autoArrows:  <?php echo of_get_option('sf_arrows'); ?>,   // generation of arrow mark-up (for submenu)
				dropShadows: false
			});
			
			// Mobile-menu init
			jQuery('.sf-menu').mobileMenu();
			
			// prettyphoto init
			jQuery("a[rel^='prettyPhoto']").prettyPhoto({
				animation_speed:'normal',
				slideshow:5000,
				autoplay_slideshow: false,
				overlay_gallery: true
			});
			
			// Initialize the gallery
			jQuery("#gallery .touch-item").touchTouch();
			
			
		});
		
		// Init for audiojs
		audiojs.events.ready(function() {
			var as = audiojs.createAll();
		});
		
		// Init for si.files
		SI.Files.stylizeAll();
		$(function(){
			$('.sf-menu > li').append('<span class="bg-menu"></span>');
			$('.before-content-area .latestpost li:nth-child(4n), .recent-posts.services li:nth-child(4n), .recent-posts.collections li:nth-child(3n)').addClass('nomargin');
			$('.featured-thumbnail a').append('<span class="stroke"></span>');
			$('.featured-thumbnail a').hover(
				function(){$(this).find('.stroke').stop().animate({opacity:1.0}, 350)},
				function(){$(this).find('.stroke').stop().animate({opacity:0}, 350)}
			);
			if ($.browser.msie && $.browser.version < 10) {
				jQuery('input[type="submit"], input[type="reset"]').hover(function(){
				  	jQuery(this).addClass('submit-hover')
				 },
					 function(){
					  jQuery(this).removeClass('submit-hover')
				 });
			}	
		});	
		
	</script>
  
  
	
	<!-- Custom CSS -->
	<?php if(of_get_option('custom_css') != ''){?>
		<style type="text/css">
		<?php echo of_get_option('custom_css' ) ?>
		</style>
	<?php }?>
  
  
  
  
	<style type="text/css">
		<?php $background = of_get_option('body_background');
			if ($background != '') {
				if ($background['image'] != '') {
					echo 'body { background-image:url('.$background['image']. '); background-repeat:'.$background['repeat'].'; background-position:'.$background['position'].';  background-attachment:'.$background['attachment'].'; }';
				}
				if($background['color'] != '') {
					echo 'body { background-color:'.$background['color']. '}';
				}
			};
		?>
		
		<?php $header_styling = of_get_option('header_color'); 
			if($header_styling != '') {
				echo '#header {background-color:'.$header_styling.'}';
			}
		?>
		
		<?php $links_styling = of_get_option('links_color'); 
			if($links_styling) {
				echo 'a{color:'.$links_styling.'}';
				echo '.button {background:'.$links_styling.'}';
			}
		?>

	</style>
<script type='text/javascript'>
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
var gads = document.createElement('script');
gads.async = true;
gads.type = 'text/javascript';
var useSSL = 'https:' == document.location.protocol;
gads.src = (useSSL ? 'https:' : 'http:') + '//www.googletagservices.com/tag/js/gpt.js';
var node = document.getElementsByTagName('script')[0];
node.parentNode.insertBefore(gads, node);
})();
</script>

<script type='text/javascript'>
googletag.cmd.push(function() {
googletag.defineSlot('/4429510/WranglerNetwork300x250', [300, 250], 'div-gpt-ad-1385349410056-0').addService(googletag.pubads());
googletag.defineSlot('/4429510/WranglerNetwork325x50', [320, 50], 'div-gpt-ad-1385349410056-1').addService(googletag.pubads());
googletag.defineSlot('/4429510/WranglerNetwork728x90', [728, 90], 'div-gpt-ad-1385349410056-2').addService(googletag.pubads());
googletag.defineSlot('/4429510/WranglerNetworkPreRoll', [300, 250], 'div-gpt-ad-1385349410056-3').addService(googletag.companionAds()).addService(googletag.pubads());
googletag.pubads().enableSingleRequest();
googletag.companionAds().setRefreshUnfilledSlots(true);
googletag.pubads().enableVideoAds();
googletag.enableServices();
});
</script>

<!-- fonts were wonky.. so I included this muself. -Tv -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600' rel='stylesheet' type='text/css'>
</head>

<body <?php body_class(); ?>>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=156393707718188";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<div id="main"><!-- this encompasses the entire Web site -->

	<?php if( is_front_page() ) { ?>
		<div id="tv-media">
			<?php include('media.php'); ?>
		</div>	
	<?php } ?>

	<div class="container">
	
		<div style="border-bottom:1px solid #fbd010; height:30px; background-color: #023469; position: absolute; top: 0; left: 0; width: 100%; z-index: 999;">
			<div style="position: relative; margin: 0px auto; max-width: 1140px;">
				
				<span class="getSocial">GET SOCIAL&nbsp;
					<a href="https://twitter.com/WranglerWestern">
						<img src="http://wranglernetwork.com/wp-content/uploads/2013/12/social-twitter.png" style="width:15px;">
					</a>
					<a href="https://www.facebook.com/wranglerwestern">
						<img src="http://wranglernetwork.com/wp-content/uploads/2013/12/social-facebook.png" style="width:15px;">
					</a>
				</span>
								
				<div class="shopNow" style="display:inline-block; position:absolute; top:0px; right:30px; border:1px solid #fff; border-top: none; height:35px; width:150px; background-color:#023469; text-align:center;padding-top:7px;"><span class="shopWrangler">SHOP NOW AT:</span><br><span class="shopWranglerLink"><a target="_new" href="http://www.wrangler.com">WRANGLER.COM</a></span></div>
			</div>
		</div>
		
		<header id="header">
			<div class="row-logo clearfix" style="padding-top: 30px;">
				<div class="logo">
				  <?php if(of_get_option('logo_type') == 'text_logo'){?>
					<?php if( is_front_page() || is_home() || is_404() ) { ?>
					  <h1><a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a></h1>
					<?php } else { ?>
					  <h2><a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a></h2>
					<?php } ?>
				  <?php } else { ?>
					<?php if(of_get_option('logo_url') != ''){ ?>
						<a href="<?php bloginfo('url'); ?>/" id="logo"><img src="<?php echo of_get_option('logo_url', "" ); ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('description'); ?>"></a>
					<?php } else { ?>
						<a href="<?php bloginfo('url'); ?>/" id="logo"><img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('description'); ?>"></a>
					<?php } ?>
				  <?php }?>
				  <p class="tagline"><?php bloginfo('description'); ?></p>
                  <?php $portfolioTag = bm_get_portfolio_tags(get_the_ID()); ?>
                  
				  <div class="topLinks topLinks-desktop" style="display:inline-block;margin-top:30px;margin-left:30px;">
				  	<a href="/prca-channel" <?php if (strpos($_SERVER['REQUEST_URI'], 'prca') || ( strpos($_SERVER['REQUEST_URI'], 'portfolio-view') && $portfolioTag == 'prca' ) ) : ?> class="cat-active"<?php endif; ?>>PRCA</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="/pbr-channel" <?php if (strpos($_SERVER['REQUEST_URI'], 'pbr') || ( strpos($_SERVER['REQUEST_URI'], 'portfolio-view') && $portfolioTag == 'pbr' ) ) : ?> class="cat-active"<?php endif; ?>>PBR</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            <a href="/category/music" <?php if (strpos($_SERVER['REQUEST_URI'], 'music/')) : ?> class="cat-active"<?php endif; ?>>Music</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     
				    <a href="/videos" <?php if (strpos($_SERVER['REQUEST_URI'], 'videos/')) : ?> class="cat-active"<?php endif; ?>>Videos</a>
        	</div>
        	
        	<div class="topLinks topLinks-mobile" style="display:inline-block;margin-top:30px;margin-left:30px;">
        		<a href="/category/prca" <?php if (strpos($_SERVER['REQUEST_URI'], 'prca') || ( strpos($_SERVER['REQUEST_URI'], 'portfolio-view') && $portfolioTag == 'prca' ) ) : ?> class="cat-active"<?php endif; ?>>PRCA</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        	  <a href="/category/pbr" <?php if (strpos($_SERVER['REQUEST_URI'], 'pbr') || ( strpos($_SERVER['REQUEST_URI'], 'portfolio-view') && $portfolioTag == 'pbr' ) ) : ?> class="cat-active"<?php endif; ?>>PBR</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        	  <a href="/category/music" <?php if (strpos($_SERVER['REQUEST_URI'], 'music/')) : ?> class="cat-active"<?php endif; ?>>Music</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     
        	  <a href="/videos" <?php if (strpos($_SERVER['REQUEST_URI'], 'videos/')) : ?> class="cat-active"<?php endif; ?>>Videos</a>
        	</div> 
        	
				</div>
				<div class="fright"><!--
					<ul class="meta">
						<?php wp_register(); ?>
						<li><?php wp_loginout(); ?></li>
					</ul>-->
					<div id="widget-header">
						<?php if ( ! dynamic_sidebar( 'Header' ) ) : ?><!-- Wigitized Header --><?php endif ?>
					</div><!--#widget-header-->
				</div>
			</div>
			<!--<div class="row-menu">
				<nav class="primary">
				  <?php wp_nav_menu( array(
					'container'       => 'ul', 
					'menu_class'      => 'sf-menu', 
					'menu_id'         => 'topnav',
					'depth'           => 0,
					'theme_location' => 'header_menu' 
					)); 
				  ?>
				</nav><!--.primary-->
				<?php if ( of_get_option('g_search_box_id') == 'yes') { ?>  
					<!--<div id="top-search">
						<form method="get" action="<?php echo get_option('home'); ?>/">
							<input type="submit" value="<?php _e('GO', 'theme1796'); ?>" id="submit"><input type="text" name="s"  class="input-search"/>
						</form>
					</div> 
				<?php } ?>
			</div>-->
		</header>
		<?php if( is_front_page() ) { ?>
			<section id="slider-wrapper">
				<?php $sliderCategory = "home"; ?>
				<?php include_once(TEMPLATEPATH . '/slider.php'); ?>
			</section><!--#slider-->
		<?php } ?>
		<div class="primary_content_wrap clearfix">
			<div class="row">
