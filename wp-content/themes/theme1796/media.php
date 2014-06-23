<style>
	@media all and (max-width: 788px) {
		.container {
			display: none;
		}	
		#tv-media {
			display: inherit;
		}
		#main {
			background: none;
		}
		#tv-media {
			padding: 0 15px;
		}
		.tvLogo {
			display: block;
			width: 100%;
			text-align: center;
			float: none;
			margin: 70px 0 25px;
		}
		#top-search {
			position: relative;
			right: 0;
			top: 0;
			max-width: 320px;
			padding-bottom: 15px;
		}
		#top-search .input-search {
			height: 36px;
			font-size: 18px;
			line-height: 24px;
			border: none;
			width: 100%;
			box-shadow: none;
		}
		#top-search .input-search:focus {
			border: 2px solid #FECC0C;
			box-shadow: none;
		}
		#top-search #submit {
			background-position: center;
			background-repeat: no-repeat;
			background-size: 24px;
			height: 36px;
			width: 36px;
			position: absolute;
			right: 0;
			top: 0;
			float: none;
			margin: 0;
		}
		.clear {
			width: 100%;
			display: block;
			clear: both;
		}
		.tvLinks {
			text-align: center;
		}
		.tvLinks a {
			display: block;
			padding: 25px 20px;
			margin: 15px 0;
			background: #092E54 url(/wp-content/themes/theme1796/images/blueGrad.png) repeat-x top left;
			background-size: contain;
			text-decoration: none;
			font-size: 2em;
			font-weight: 600;
			font-family: Open Sans;
			border: 1px solid #011c42;
			text-transform: uppercase;
		}
		.tvLinks a:nth-child(3), .tvLinks a:nth-child(4), .tvLinks a:nth-child(5), .tvLinks a:nth-child(6) {
			display: inline-block;
			width: 48%;
			box-sizing: border-box;
			margin-top: 0;
		}
		.tvLinks a:nth-child(5), .tvLinks a:nth-child(3) {
			float: left;
		}
		.tvLinks a:nth-child(6), .tvLinks a:nth-child(4) {
			float: right;
		}
	}
</style>

<div style="border-bottom:1px solid #fbd010; height:30px; background-color: #023469; position: absolute; top: 0; left: 0; width: 100%; z-index: 999;">
	<div style="position: relative; max-width: 1120px; margin: 0px auto; text-align: center;">
	
		<div style="display:inline-block; margin: 0px auto; border:1px solid #fff; border-top: none; height:35px; width:150px; background-color:#023469; text-align:center;padding-top:7px;">
			<span class="shopWrangler">SHOP NOW AT:</span><br>
			<span class="shopWranglerLink">
				<a target="_new" href="http://www.wrangler.com">WRANGLER.COM</a>
			</span>
		</div>
		
	</div>
</div>

<div class="tvLogo">
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
</div>

<div id="top-search">
	<form method="get" action="/">
		<input type="text" name="s" placeholder="Search" class="input-search">
		<input type="submit" value="Search" id="submit">
		<div class="clear"></div>
	</form>
</div>

<img src="/wp-content/themes/theme1796/images/iPhoneStatic.jpg" alt="Long Live The Life We Love." />

<div class="tvLinks">
	<a href="/videos">Videos</a>
	<a href="/category/music">Music</a>
	<a href="/category/prca">PRCA</a>
	<a href="/category/pbr">PBR</a>
	<a href="/category/news">News</a>
	<a href="/category/blog">Blog</a>
	<div class="clear"></div>
</div>