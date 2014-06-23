<?php
/*
	Template Name: PBR Category Page
*/

get_header(); ?>
</div>

<div>
<section id="slider-wrapper">
  <?php $sliderCategory = "pbr"; ?>
  <?php include_once(TEMPLATEPATH . '/slider.php'); ?>
</section>
</div>

<div class="row" id="artistContent" style="margin-top:20px;margin-botom:20px;">
    <div class="grid_8">
        <div class="artist-content-area">
            <?php if( !dynamic_sidebar( 'PBR Content Area')) : ?>
              <!--Widgetized 'PBR Content Area' for the pbr category page-->
            <?php endif ?>
        </div>
    </div><!-- end grid_9 --> 
    <div class="grid_4">
        <div class="artist-content-ad">
        		
        		<div id="text-4">			<div class="textwidget"><div id="div-gpt-ad-1385349410056-0" style="width:300px; height:250px;">
        		<script type="text/javascript">
        		googletag.cmd.push(function() { googletag.display('div-gpt-ad-1385349410056-0'); });
        		</script>
        		<div id="google_ads_iframe_/4429510/WranglerNetwork300x250_0__container__" class="adTv"><iframe id="google_ads_iframe_/4429510/WranglerNetwork300x250_0" name="google_ads_iframe_/4429510/WranglerNetwork300x250_0" width="300" height="250" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="javascript:&quot;<html><body style='background:transparent'></body></html>&quot;" style="border: 0px; vertical-align: bottom;"></iframe></div><iframe id="google_ads_iframe_/4429510/WranglerNetwork300x250_0__hidden__" name="google_ads_iframe_/4429510/WranglerNetwork300x250_0__hidden__" width="0" height="0" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" src="javascript:&quot;<html><body style='background:transparent'></body></html>&quot;" style="border: 0px; vertical-align: bottom; visibility: hidden; display: none;"></iframe></div>
        		<br></div>
        				</div>
        		
            <!--<?php if( !dynamic_sidebar( 'PBR Content Ad')) : ?>
              <!--Widgetized 'PBR Content Ad' for the pbr category page--*>
            <?php endif ?>-->
        </div>
    </div>
</div>
<div>
<br clear="all">
<h2>Most Popular</h2>
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
        'wn_tags' => 'pbr',
        'wn_cat' => 'popular'
    );
    $wn_carousel = new MY_CarouselWidget();
    $wn_carousel->widget($wn_args, $wn_instance); 
?>
<br clear="all" />
<div align="right">
<span class="channelAllVideosLink"><a href="/videos">All PBR Videos &raquo;</a></span>
</div>
<div style="margin-top:20px;margin-bottom:20px;">
    <?php if ( !dynamic_sidebar( 'PBR Footer Content Area' ) ) : ?>
      <!--Widgetized 'PBR Footer Content Area' for the pbr category page-->
    <?php endif ?>
      
</div>

<br clear="all" />

<div class="row rowdark">
	<div class="grid_7">
		<div class="left-content-area">
			<?php if ( ! dynamic_sidebar( 'PBR Left Footer Content Area' ) ) : ?>
			  <!--Widgetized 'Right Content Left' for the home page-->
			<?php endif ?>
		</div>
	</div>
	<div class="grid_5">
		<div class="right-content-area">
			<?php if ( ! dynamic_sidebar( 'PBR Right Footer Content Area' ) ) : ?>
			  <!--Widgetized 'Right Content Area' for the home page-->
			<?php endif ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
