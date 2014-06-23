// Rewritten version
// By @mathias, @cheeaun and @jdalton


(function(doc) {

var addEvent = 'addEventListener',
type = 'gesturestart',
qsa = 'querySelectorAll',
scales = [1, 1],
meta = qsa in doc ? doc[qsa]('meta[name=viewport]') : [];

function fix() {
meta.content = 'width=device-width,minimum-scale=' + scales[0] + ',maximum-scale=' + scales[1];
doc.removeEventListener(type, fix, true);
}

if ((meta = meta[meta.length - 1]) && addEvent in doc) {
fix();
scales = [.25, 1.6];
doc[addEvent](type, fix, true);
}

}(document));

jQuery(document).ready(function(){
													 
// ---------------------------------------------------------
// Tabs
// ---------------------------------------------------------
jQuery(".tabs").each(function(){

		jQuery(this).find(".tab").hide();
		jQuery(this).find(".tab-menu li:first a").addClass("active").show();
		jQuery(this).find(".tab:first").show();

});

jQuery(".tabs").each(function(){

		jQuery(this).find(".tab-menu a").click(function() {

				jQuery(this).parent().parent().find("a").removeClass("active");
				jQuery(this).addClass("active");
				jQuery(this).parent().parent().parent().parent().find(".tab").hide();
				var activeTab = jQuery(this).attr("href");
				jQuery(activeTab).fadeIn();
				return false;

		});

});


// ---------------------------------------------------------
// Toggle
// ---------------------------------------------------------

jQuery(".toggle").each(function(){

		jQuery(this).find(".box").hide();

});

jQuery(".toggle").each(function(){

		jQuery(this).find(".trigger").click(function() {

				jQuery(this).toggleClass("active").next().stop(true, true).slideToggle("normal");

				return false;

		});

});



jQuery(".recent-posts.team li:nth-child(3n)").addClass("nomargin");



// ---------------------------------------------------------
// Social Icons
// ---------------------------------------------------------

jQuery(".social-networks li a").tooltip({ effect: 'slide', position: 'bottom center', opacity: .9 });



// ---------------------------------------------------------
// Back to Top
// ---------------------------------------------------------

// fade in #back-top
jQuery(function () {
	jQuery(window).scroll(function () {
		if (jQuery(this).scrollTop() > 100) {
			jQuery('#back-top').fadeIn();
		} else {
			jQuery('#back-top').fadeOut();
		}
	});

	// scroll body to 0px on click
	jQuery('#back-top a').click(function () {
		jQuery('body,html').stop(false, false).animate({
			scrollTop: 0
		}, 800);
		return false;
	});
});


    // jm support video nav
     $('#popular-nav-link').click(function(){
         videoNavSwitch('popular');
         jQuery('#popular-nav-link').addClass('active');
         jQuery('#recent-nav-link').removeClass('active');
         jQuery('#upcoming-nav-link').removeClass('active');
     });
     $('#recent-nav-link').click(function(){
         videoNavSwitch('recent');
         jQuery('#popular-nav-link').removeClass('active');
         jQuery('#recent-nav-link').addClass('active');
         jQuery('#upcoming-nav-link').removeClass('active');
     });
     $('#upcoming-nav-link').click(function(){
         videoNavSwitch('upcoming');
         jQuery('#popular-nav-link').removeClass('active');
         jQuery('#recent-nav-link').removeClass('active');
         jQuery('#upcoming-nav-link').addClass('active');
     });

});


// jm video nav
var videoNavSwitch = function(category, container) {
    if(undefined === container) {
        container = '#videoNavContainer';
    }
    // or...
    // var containerType = container || '#videoNavContainer';
    
    //$.get(ajax_object.ajaxurl, {
    $.get('/wp-admin/admin-ajax.php', {
			action: 'ajax_action',
			cat: category
	}, function(data) {
        $(container).html(data);
    });
        
        
};