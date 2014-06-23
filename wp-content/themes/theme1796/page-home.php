<?php
/**
 * Template Name: Home Page
 */

get_header(); ?>
	<div class="grid_12">	
		<div class="before-content-area">
            <div id="video-nav-link">
                <ul class="video-nav-button" style="list-style: none outside none">
                    <li id="popular-nav-link" class="active">POPULAR</li>
                    <li id="recent-nav-link">RECENT</li>
                    <li id="upcoming-nav-link">UPCOMING</li>
                </ul>
            </div>
            <div id="videoNavContainer">
                <script type="text/javascript">videoNavSwitch('popular', '#videoNavContainer');</script>
            </div>
            
		</div><!-- end bca -->
	</div><!-- end gr12 -->
</div>

<div class="row" id="artistContent">
    <div class="grid_8">
        <div class="artist-content-area">
            <?php if( !dynamic_sidebar( 'Artist Content Area')) : ?>
              <!--Widgetized 'Artist Content Area' for the home page-->
            <?php endif ?>
        </div>
    </div><!-- end grid_9 --> 
    <div class="grid_4">
        <div class="artist-content-ad">
            <?php if( !dynamic_sidebar( 'Artist Content Ad')) : ?>
              <!--Widgetized 'Artist Content Ad' for the home page-->
            <?php endif ?>
        </div>
    </div>
</div>
<br clear="all" />
            
<div class="row rowdark">
	<div class="grid_7">
		<div class="left-content-area">
			<?php if ( ! dynamic_sidebar( 'Left Content Area' ) ) : ?>
			  <!--Widgetized 'Right Content Left' for the home page-->
			<?php endif ?>
		</div>
	</div>
	<div class="grid_5">
		<div class="right-content-area">
			<?php if ( ! dynamic_sidebar( 'Right Content Area' ) ) : ?>
			  <!--Widgetized 'Right Content Area' for the home page-->
			<?php endif ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>