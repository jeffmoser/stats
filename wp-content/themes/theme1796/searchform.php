<form method="get" id="searchform" action="<?php bloginfo('home'); ?>">

<input type="text" class="searching" placeholder="Search" value="<?php the_search_query(); ?>" name="s" id="s" />
<input class="submit submitTv" type="submit" value="<?php _e('Search', 'theme1796'); ?>" />

</form>
