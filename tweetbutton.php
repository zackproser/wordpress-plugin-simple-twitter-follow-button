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

	register_setting('reading', 'stb_username', 'stb_twitter_username_validation');
	register_setting('reading', 'stb_button_size');

}


function stb_settings_section_callback() {
	echo '<p>Update the Twitter Username for the follow button.</p>';
}

function stb_username_callback() {
	echo '<input name="stb_username" id="stb_username" value="' . get_option('stb_username') . '" placeholder="Don\'t Include the @"/>';
}

function stb_button_callback() {
	$options = get_option('stb_button_size');

	$html =  '<input type="radio" id="radio_small" name="stb_button_size[size]" value="1" ' . checked(1, $options['size'], false ) . '/>';
	$html .= '<label for="radio_small">Small</label>';

	$html .= '<br><br>'; //buttons should be on separate lines

	$html .= '<input type="radio" id="radio_large" name="stb_button_size[size]" value="2" ' . checked(2, $options['size'], false ) . '/>';
	$html .= '<label for="radio_large">Large</label>';

	echo $html;
} 

function stb_twitter_username_validation($input) {

	$username_regex = '/^\@?([a-zA-Z0-9_-]{1,16}$)/';

	if(preg_match($username_regex, $input, $matches)) {

		return strip_tags( stripslashes($input) );

	} else {
		add_settings_error(
			'stb_username',
			'stb_bad_username',
			'Oops, your Twitter Username appears invalid. Please try again.'
		);
	}

}

function stb_render_twitter_button($content) {

	if(is_singular() && get_option('stb_username')) {
		
	$username = get_option('stb_username');
	$size_setting = get_option('stb_button_size');

	if($size_setting['size'] == 1) {
		$button_size = 'small';
	} else {
		$button_size = 'large';
	}

	$script = '<a href="https://twitter.com/'. $username . '" class="twitter-follow-button" data-show-count="false" data-size="' . $button_size . '">Follow ' . $username . '</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+\'://platform.twitter.com/widgets.js\';fjs.parentNode.insertBefore(js,fjs);}}(document, \'script\', \'twitter-wjs\');</script>';

	return $content . $script;
	
	}
}








?>