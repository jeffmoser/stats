<?php
/**
 * Template Name: PRCA Category Page
 */

get_header(); ?>
</div>

<div>
<section id="slider-wrapper">
  <?php $sliderCategory = "prca"; ?>
  <?php include_once(TEMPLATEPATH . '/slider.php'); ?>
</section>
</div>

<div class="row" id="artistContent" style="margin-top:20px;margin-botom:20px;">
    <div class="grid_8">
        <div class="artist-content-area">
            <?php if( !dynamic_sidebar( 'PRCA Content Area')) : ?>
              <!--Widgetized 'PRCA Content Area' for the PRCA category page-->
            <?php endif ?>
        </div>
    </div><!-- end grid_9 --> 
    <div class="grid_4">
        <div class="artist-content-ad">
            <?php if( !dynamic_sidebar( 'PRCA Content Ad')) : ?>
              <!--Widgetized 'PRCA Content Ad' for the PRCA category page-->
            <?php endif ?>
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
        'wn_tags' => 'prca',
        'wn_cat' => 'popular'
    );
    $wn_carousel = new MY_CarouselWidget();
    $wn_carousel->widget($wn_args, $wn_instance); 
?>
<h2>Most Recent</h2>
<?php
    $wn_args2 = array(
        'name' => 'Before Content Area 2',
        'id' => 'before-content-area-2',
        'description' => 'Located at the top of the content',
        'class' => 'my-carousel2',
        'after_widget' => '</div>',
        'before_widget' => '<div id="my_carouselwidget-2">',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
        'widget_id' => 'my_carouselwidget-2',
        'widget_name' => 'My - Carousel - 2'
        );
    $wn_instance2 = array(
        'title' => '',
        'divid' => 'carousel2',
        'limit' => '',
        'category' => 'portfolio',
        'count' => '',
        'wn_tags' => 'prca',
        'wn_cat' => 'recent'
    );
    $wn_carousel2 = new MY_CarouselWidget();
    $wn_carousel2->widget($wn_args2, $wn_instance2);
?>
<h2>Upcoming</h2>
<?php
    $wn_args3 = array(
        'name' => 'Before Content Area 3',
        'id' => 'before-content-area-3',
        'description' => 'Located at the top of the content',
        'class' => 'my-carousel3',
        'after_widget' => '</div>',
        'before_widget' => '<div id="my_carouselwidget-3">',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
        'widget_id' => 'my_carouselwidget-3',
        'widget_name' => 'My - Carousel - 3'
        );
    $wn_instance3 = array(
        'title' => '',
        'divid' => 'carousel3',
        'limit' => '',
        'category' => 'portfolio',
        'count' => '',
        'wn_tags' => 'prca',
        'wn_cat' => 'upcoming'
    );
    $wn_carousel3 = new MY_CarouselWidget();
    $wn_carousel3->widget($wn_args3, $wn_instance3);
?>
<br clear="all" />
<div align="right">
<span class="channelAllVideosLink"><a href="/videos">All PRCA Videos &raquo;</a></span>
</div>
<div style="margin-top:20px;margin-bottom:20px;">
    <?php if ( ! dynamic_sidebar( 'PRCA Footer Content Area' ) ) : ?>
      <!--Widgetized 'PRCA Footer Content Area' for the PRCA category page-->
    <?php endif ?>
</div>
<?php get_footer(); ?>
