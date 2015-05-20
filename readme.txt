=== nerd Social Share Buttons ===
Contributors: Neon Emmanuel
Tags: facebook, twitter, google+, social, share
Requires at least: 3.0.1
Tested up to: 3.8.2
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A set of very simple social sharing buttons- important in your social media network.

== Description ==
Simple and fast to load social share buttons , fancy and bold enough to get a share from your visitors, it's written in PHP, HTML and CSS. 

There's an option to show the buttons on posts and pages. You can also put the buttons anywhere in your template using this template tag:

`<?php nd_social_share_tag(); ?>`

You can also display using this shortcode in single posts and pages:

`[nd-social]`

Please note: That The Plugin do not show stats or share counter. The essence of the whole thing is to keep it very simplified.

The only button that requires a little snippet of JS to work is the Pinterest button but this does not slow down your site in anyway. A demo of the plugin can be seen here: http://shoutershub.ng/

== Installation ==
1. Upload 'plugin-name.php' to the '/wp-content/plugins/' directory
2. Activate the plugin through the "Plugins" menu in WordPress

You can also upload directly from Wordpress dashboard > Plugins > Add New > Upload. Activate the plugin and you're good to go.

== Frequently Asked Questions ==

= How do I show share counts? =

This plugin isn't meant to do that. The essence of the whole thing is to keep it simplified? 

= How do I show the buttons in certain areas of my websites not available through the plugin settings... for example, above posts? =

You can use the template tag below:

`<?php nd_social_share_tag(); ?>`

You can also use this shortcode:

`[nd-social]`

= Can I change the "Like this article?" text? =

Yes, you can use any custom text. You can set that through the settings page. If you're also using the template tag, you can simply write it this way:

`<?php nd_social_share_tag('Custom Text Here'); ?>`

== Screenshots ==
1. Share buttons appearance at the frontend 
2. Plugin backend settings

== Changelog ==
Version 1.0

Initial release.