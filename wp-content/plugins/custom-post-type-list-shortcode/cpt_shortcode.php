<?php
/*
	Plugin Name: Custom Post Type Shortcode
	Plugin URI: http://blog.blackbirdi.com/
	Description: List custom post type posts using shortcode with any page or post. For documentation on how to use this plugin please visit the <a href="http://blog.blackbirdi.com" title="Blackbird Interactive">Blackbird Interactive Blog</a>
	Version: 1.4.3
	Author: Blackbird Interactive
	Author URI: http://blackbirdi.com
	License: GPL2



    Copyright 2012 Blackbird Interactive (email : cpt_shortcode@blackbirdi.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

# Compatibilty checks
# -----------------------------------------------------

// get wordpress version number and fill it up to 9 digits
$int_wp_version = preg_replace('#[^0-9]#', '', get_bloginfo('version'));
while(strlen($int_wp_version) < 9){
	
	$int_wp_version .= '0'; 
}

// get php version number and fill it up to 9 digits
$int_php_version = preg_replace('#[^0-9]#', '', phpversion());
while(strlen($int_php_version) < 9){
	
	$int_php_version .= '0'; 
}

// Check overall plugin compatibility
if(	$int_wp_version >= 300000000 && 		// Wordpress version > 2.7
	$int_php_version >= 520000000 && 		// PHP version > 5.2
	defined('ABSPATH') && 					// Plugin is not loaded directly
	defined('WPINC')) {						// Plugin is not loaded directly
		
	// Load plugin class file
	require_once(dirname(__FILE__).'/assets/lib/class.main.php');
	
	// Intialize the plugin class by calling initialize on our class
	add_action('init',array('cpt_shortcode','initialize'));
	
}

// Plugin is not compatible with current configuration
else {
	
	// Display incompatibility information
	add_action('admin_notices', 'cpt_shortcode_incompatibility_notification');
}

// Display incompatibility notification
function cpt_shortcode_incompatibility_notification(){
	
	echo '<div id="message" class="error">
	
	<p><b>The &quot;Custom Post Type List&quot; Plugin does not work on this WordPress installation!</b></p>
	<p>Please check your WordPress installation for following minimum requirements:</p>
	
	<p>
	- WordPress version 3.0 or higer<br />
	- PHP version 5.2 or higher<br />
	</p>
	
	<p>Do you need help? Contact <a href="mailto:justin@blackbirdi.com">Blackbird Interactive</a></p>
	
	</div>';
}
?>