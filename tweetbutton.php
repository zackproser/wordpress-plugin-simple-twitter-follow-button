<?php 

  /*
   Plugin Name: Simple Twitter Follow Me Button
   Plugin URI: http://www.a-placeholder.com
   Description: A dead-simple plugin that adds a Twitter follow button to the end of every post
   Version: 1.0
   Author: Zack Proser
   Author URI: http://a-placeholder.com
   License: GPL2
   */

add_action('admin_init', 'stb_init');
add_filter('the_content', 'stb_render_twitter_button');


function stb_init() {

	add_settings_section(
  		'stb_settings_section',
  		'Simple Twitter Button Settings', 
  		'stb_settings_section_callback', 
  		'reading'
	);

	add_settings_field(
		'stb_username',
		'Twitter Username', 
		'stb_username_callback',
		'reading',
		'stb_settings_section'
	);

	add_settings_field(
		'stb_button_size', 
		'Twitter Button Size', 
		'stb_button_callback', 
		'reading',
		'stb_settings_section'
	);

	register_setting('reading', 'stb_username');
	register_setting('reading', 'stb_button_size');

}



function stb_settings_section_callback() {
	echo '<p>Update the Twitter Username for the follow button.</p>';
}

function stb_username_callback() {
	echo '<input name="stb_username" id="stb_username" value="' . get_option('stb_username') . '" placeholder="Don\'t Include the @"/>';
}

/*function stb_button_callback() {
	echo '<input type="radio" id="radio_small" name="stb_button_size[]"'
} */

function stb_render_twitter_button($content) {

	if(is_singular() && get_option('stb_username')) {
		
	$username = get_option('stb_username');

	$script = '<a href="https://twitter.com/'. $username . '" class="twitter-follow-button" data-show-count="false" data-size="large">Follow ' . $username . '</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+\'://platform.twitter.com/widgets.js\';fjs.parentNode.insertBefore(js,fjs);}}(document, \'script\', \'twitter-wjs\');</script>';

	return $content . $script;
	
	}
}








?>