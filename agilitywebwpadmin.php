<?php
/*
Plugin Name: AgilityWeb WP Admin
Description: All of the important functionality of your site belongs in this.

Version: 0.1
License: GPL
Author: Caspar Kennerdale
Author URI: http://agilityweb.co.uk
*/

// CLEAN UP HEAD
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);


// REMOVE 3.1 ADMIN BAR
add_filter( 'show_admin_bar', '__return_false' );



// ADMIN FAVICON
function admin_favicon() {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.plugins_url('', __FILE__ ).'/images/favicon.ico" />';

}

add_action('admin_head', 'admin_favicon');


// REMOVE WP VER FROM FEED
function complete_version_removal() {
	return '';
}

add_filter('the_generator', 'complete_version_removal');


// REPLACE HOWDY
add_filter('gettext', 'change_howdy', 10, 3);
function change_howdy($translated, $text, $domain) {
    if (!is_admin() || 'default' != $domain)
        return $translated;

    if (false !== strpos($translated, 'Howdy'))
       return str_replace('Howdy', 'Welcome', $translated);
    return $translated;
}

// REMOVE NOFOLLOW FROM COMMENTS
function xwp_dofollow($str) {
        $str = preg_replace(

                '~<a ([^>]*)\s*(["|\']{1}\w*)\s*nofollow([^>]*)>~U',
                '<a ${1}${2}${3}>', $str);
        return str_replace(array(' rel=""', " rel=''"), '', $str);
}
remove_filter('pre_comment_content',     'wp_rel_nofollow');

add_filter   ('get_comment_author_link', 'xwp_dofollow');
add_filter   ('post_comments_link',      'xwp_dofollow');
add_filter   ('comment_reply_link',      'xwp_dofollow');
add_filter   ('comment_text',            'xwp_dofollow');



// CUSTOM DASHBOARD

add_action('wp_dashboard_setup', 'custom_dashboard_widgets');


function custom_dashboard_widgets(){

	//first parameter is the ID of the widget (the div holding the widget will have that ID)

	//second parameter is title (shown in the header of the widget) 

	//third parameter is the function name we are calling to get the content of our widget

	wp_add_dashboard_widget('my_custom_widget_id', 'AgilityWeb', 'agilityweb_info_widget');

}

function agilityweb_info_widget() {
	//the content of our custom widget

	echo '

	Put something here


	';

}





?>
