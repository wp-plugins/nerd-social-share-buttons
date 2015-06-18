<?php
/*
Plugin Name: Nerd Social Share Buttons
Plugin URI: http://shoutershub.com
Description: A set of very simple light load social sharing buttons - featuring important social media in your network
Author: Neon Emmanuel
Version: 1.0
Author URI: http://shoutershub.com
*/

// Initialize setting options on activation
register_activation_hook( __FILE__, 'nd_install_activate_default_values' );
function nd_install_activate_default_values() {
$nd_plugin_options = array(
'label' => 'Seriously !! we love Social Media :)',
'post' => 'ok',
'page' => '',
);
update_option( 'nerd_social_plugin', $nd_plugin_options );
}


// get option value from the database
$option = get_option( 'nerd_social_plugin' );
$label = $option['label'];
	$displaypost = $option['post'];
	$displaypage = $option['page'];

// social share code obsolete
$plugin_code = '<div id="menu-holder">

<div class="set-1">
<ul>
<li><a href="http://twitter.com/home?status='. the_title('', '', FALSE) .': '. get_permalink() .'" title="Share this post on Twitter!" target="_blank" rel="nofollow" class="twitter-big">Twitter</a></li>
<li><a href="http://www.facebook.com/sharer.php?u='. get_permalink() .'&amp;t='. the_title('', '', FALSE) .'" rel="nofollow" title="Share this post on Facebook!" onclick="window.open(this.href); return false;" class="facebook-big">Facebook</a></li>
<li><a href="http://www.pinterest.com/pin/create/button/?url='. get_permalink() .' class="pinterest-big" class="pinterest-big">Pinterest</a></li>
<li><a href="https://plus.google.com/share?url='. get_permalink() .'" rel="nofollow" class="gplus-big">GPlus</a></li>
<li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url='. get_permalink() .'" rel="nofollow" class="linkedin-big">Linkedin</a></li>
<li><a href="http://reddit.com/submit?url='. get_permalink() .'&amp;title='. the_title('', '', FALSE) .'" rel="nofollow" class="flickr-big">Reddit</a></li>
</ul>
</div>'."
</div>
</div>";


add_action( 'admin_menu', 'nd_social_share_plugin' );

// Adding Submenu to settings
function nd_social_share_plugin() {
	add_options_page( 'Don Caprio\'s Social Share Plugin', 'Don Caprio\'s Social Share',
'manage_options', 'nerd-social-plugin-nd', 'nerd_social_plugin_nd' );
}

// plugin settings form
function nerd_social_plugin_nd() {

	?>
<div class="wrap">
<?php screen_icon(); ?>
<h2>nerd's social share buttons</h2>
<form action="options.php" method="post">
<table class="form-table">
<?php settings_fields('nerd_social_plugin'); ?>
<?php do_settings_sections('nerd-social-plugin-nd'); ?>
<div>
<input name="Submit" class="button-primary" type="submit" value="Save Changes" />
</div>

</form>
</table>

<br />
<h2>Documentation</h2>
<h3>Template Tags</h3>
<table><tr valign='top'>
<td scope='row'><p style="list-style:circle"></p>To include this plugin in any location of your theme, <br />
use this template tag</p></td>
<td style="margin: 5px"><textarea cols='30' rows='1'>&lt;?php nd_social_share_tag(); ?&gt;</textarea></td>
</tr>

<tr valign='top'>
<td scope='row'><p style="list-style:circle"></p>To add a <b>Share label</b> using the template tag,<br />
pass the text as the function argument like this: </p></td>
<td><textarea cols='45' rows='1'>&lt;?php nd_social_share_tag('Share this article'); ?&gt;</textarea></td>
</tr></table>

<h3>Shortcodes</h3>
<table><tr valign='top'>
<td scope='row'><p style="list-style:circle"></p>To include this plugin within a post or page,<br />
use this Shortcodes</p></td>
<td style="margin: 5px"><textarea cols='30' rows='1'>[nd-social]</textarea></td>
</tr>

<tr valign='top'>
<td scope='row'><p style="list-style:circle"></p>To add a <b>share label</b> using shortcodes,<br />
do it like this: </p></td>
<td><textarea cols='45' rows='1'>[nd-social label="Share this article"]</textarea></td>
</tr></table>
</div>

<?php }

	// Register and define the settings
	add_action('admin_init', 'nerd_social_plugin_init');
	function nerd_social_plugin_init(){
	register_setting(
	'nerd_social_plugin',
	'nerd_social_plugin',
	''
	);

	add_settings_section(
	'nerd-social-plugin-main',
	'',
	'',
	'nerd-social-plugin-nd'
	);
	add_settings_field(
	'nerd-social-plugin-nd',
	'Text to display before social buttons 	',
	'nd_social_share_plugin_setting_input',
	'nerd-social-plugin-nd',
	'nerd-social-plugin-main'
	);
	}

	// Display and fill the form field
	function nd_social_share_plugin_setting_input() {
	// Retrieve the settings values form DB and make them global
	global $label, $displaypost, $displaypage;
	echo "
	<tr valign='top'>
	<th scope='row'><label for='read_more'> <strong>Sharing label</strong></label></th>";
	echo "<td><textarea cols='60' rows='2' id='label' name='nerd_social_plugin[label]'>$label</textarea></td>
	</tr>"; ?>
	<tr valign='top'>
	<th scope='row'><label for='display'> <strong>Where to be shown?</strong></label></th>
	<td><b>Post</b><br/><input type='checkbox' name='nerd_social_plugin[post]' value="ok" <?php checked($displaypost, 'ok')?> /><br/>
	<br/><b>Page</b><br/><input type='checkbox' name='nerd_social_plugin[page]' value="ok" <?php checked($displaypage, 'ok')?> /><br/>
	</td><br/><br/>
	</tr>
	<?php
	}

	/**
	* Enqueue plugin font and css
	*/
	function nd_social_share_css() {
	wp_enqueue_style( 'nd-social-share', plugins_url('nd-social-share.css', __FILE__) );
	wp_enqueue_style( 'nd-social-font', 'http://fonts.googleapis.com/css?family=Pacifico' );
	}
	add_action( 'wp_enqueue_scripts', 'nd_social_share_css' );

	add_action('the_content', 'nd_social_share_plugin_display');

	/**
	* Displays social button function
	* @param string $content post content
	*/
	function nd_social_share_plugin_display($content) {
	global $plugin_code, $label, $displaypost, $displaypage;
	
	if ($displaypost == 'ok') {
	if (is_single()) {
	$content.= '<div class="myclass" align="center">
	<div class="social"><div class="thetext">'. $label . '<div id="menu-holder">

<div class="set-1">
<ul>
<li><a href="http://twitter.com/home?status='. the_title('', '', FALSE) .': '. get_permalink() .'" title="Share this post on Twitter!" target="_blank" rel="nofollow" class="twitter-big">Twitter</a></li>
<li><a href="http://www.facebook.com/sharer.php?u='. get_permalink() .'&amp;t='. the_title('', '', FALSE) .'" rel="nofollow" title="Share this post on Facebook!" onclick="window.open(this.href); return false;" class="facebook-big">Facebook</a></li>
<li><a href="http://www.pinterest.com/pin/create/button/?url='. get_permalink() .' class="pinterest-big" class="pinterest-big">Pinterest</a></li>
<li><a href="https://plus.google.com/share?url='. get_permalink() .'" rel="nofollow" class="gplus-big">GPlus</a></li>
<li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url='. get_permalink() .'" rel="nofollow" class="linkedin-big">Linkedin</a></li>
<li><a href="http://reddit.com/submit?url='. get_permalink() .'&amp;title='. the_title('', '', FALSE) .'" rel="nofollow" class="flickr-big">Reddit</a></li>
</ul>
</div>'."
</div>
</div>
</div>";
	}	
	}
if ($displaypage == 'ok') {
	if (is_page()) {
	$content.= '<div class="myclass" align="center">
	<div class="social"><div class="thetext">'. $label  . '</div>
       <div id="menu-holder">

<div class="set-1">
<ul>
<li><a href="http://twitter.com/home?status='. the_title('', '', FALSE) .': '. get_permalink() .'" title="Share this post on Twitter!" target="_blank" rel="nofollow" class="twitter-big">Twitter</a></li>
<li><a href="http://www.facebook.com/sharer.php?u='. get_permalink() .'&amp;t='. the_title('', '', FALSE) .'" rel="nofollow" title="Share this post on Facebook!" onclick="window.open(this.href); return false;" class="facebook-big">Facebook</a></li>
<li><a href="http://www.pinterest.com/pin/create/button/?url='. get_permalink() .' class="pinterest-big" class="pinterest-big">Pinterest</a></li>
<li><a href="https://plus.google.com/share?url='. get_permalink() .'" rel="nofollow" class="gplus-big">GPlus</a></li>
<li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url='. get_permalink() .'" rel="nofollow" class="linkedin-big">Linkedin</a></li>
<li><a href="http://reddit.com/submit?url='. get_permalink() .'&amp;title='. the_title('', '', FALSE) .'" rel="nofollow" class="flickr-big">Reddit</a></li>
</ul>
</div>
</div>'."
</div>";
	}	
	}

	return $content;
	}

	/**
	* Shortcode function ish
	*/
	add_shortcode( 'nd-social', 'nd_social_share_plugin_shortcode' );
	function nd_social_share_plugin_shortcode( $attr ) {
	global $plugin_code;
	echo '<div class="myclass" align="center">';
	if (!empty($attr['label'])) {
	echo '<div class="social"><div class="thetext">'. $attr['label'] . '</div>';
	}
	else {
	echo '<div class="social">';
	}
	echo '<!--Facebook-->
 <div id="menu-holder">

<div class="set-1">
<ul>
<li><a href="http://twitter.com/home?status='. the_title('', '', FALSE) .': '. get_permalink() .'" title="Share this post on Twitter!" target="_blank" rel="nofollow" class="twitter-big">Twitter</a></li>
<li><a href="http://www.facebook.com/sharer.php?u='. get_permalink() .'&amp;t='. the_title('', '', FALSE) .'" rel="nofollow" title="Share this post on Facebook!" onclick="window.open(this.href); return false;" class="facebook-big">Facebook</a></li>
<li><a href="http://www.pinterest.com/pin/create/button/?url='. get_permalink() .' class="pinterest-big" class="pinterest-big">Pinterest</a></li>
<li><a href="https://plus.google.com/share?url='. get_permalink() .'" rel="nofollow" class="gplus-big">GPlus</a></li>
<li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url='. get_permalink() .'" rel="nofollow" class="linkedin-big">Linkedin</a></li>
<li><a href="http://reddit.com/submit?url='. get_permalink() .'&amp;title='. the_title('', '', FALSE) .'" rel="nofollow" class="flickr-big">Reddit</a></li>
</ul>
</div>
</div>
' . " 
</div>
</div>";
	}

	/**
	* Template tag for adding plugin to templates
	* @param string $read_more Share plugin label
	*/
	function nd_social_share_tag( $read_more = '') {
	global $plugin_code;
	echo '<div class="myclass" align="center">
	<div class="social"><div class="thetext">'. $read_more . '</div>
	  <div id="menu-holder">

<div class="set-1">
<ul>
<li><a href="http://twitter.com/home?status='. the_title('', '', FALSE) .': '. get_permalink() .'" title="Share this post on Twitter!" target="_blank" rel="nofollow" class="twitter-big">Twitter</a></li>
<li><a href="http://www.facebook.com/sharer.php?u='. get_permalink() .'&amp;t='. the_title('', '', FALSE) .'" rel="nofollow" title="Share this post on Facebook!" onclick="window.open(this.href); return false;" class="facebook-big">Facebook</a></li>
<li><a href="http://www.pinterest.com/pin/create/button/?url='. get_permalink() .' class="pinterest-big" class="pinterest-big">Pinterest</a></li>
<li><a href="https://plus.google.com/share?url='. get_permalink() .'" rel="nofollow" class="gplus-big">GPlus</a></li>
<li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url='. get_permalink() .'" rel="nofollow" class="linkedin-big">Linkedin</a></li>
<li><a href="http://reddit.com/submit?url='. get_permalink() .'&amp;title='. the_title('', '', FALSE) .'" rel="nofollow" class="flickr-big">Reddit</a></li>
</ul>
</div>	' .
		"
</div>
</div>
</div>";

	}