=== Plugin Name ===
IFTTT Post Formats

Contributors: jtsternberg  
Plugin Name: IFTTT Post Formats  
Plugin URI: http://dsgnwrks.pro/plugins/ifttt-post-formats  
Tags: ifttt, post formats, post types, if this then that, automation  
Author URI: http://jtsternberg.com/about  
Author: Jtsternberg  
Donate link: http://j.ustin.co/rYL89n  
Requires at least: 3.1  
Tested up to: 4.2.0  
Version: 0.1.1  
Stable tag: trunk  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html  

Set a post format or post type for your IFTTT-created posts via a post format or post type category.

== Description ==

IFTTT (if this, then that) is one of the coolest web services available, and allows you to connect your different web service accounts to create 'recipes'. An example of a recipe that I have is to create a new WordPress post on my blog whenever I favorite a YouTube video.

Unfortunately IFTTT doesn't have a way to specify a post format or a custom post type, so this plugin provides a couple ways to update them.

To set the post format, you need to set the category in IFTTT to one of the following categories:

* `ifttt-aside`
* `ifttt-gallery`
* `ifttt-link`
* `ifttt-image`
* `ifttt-quote`
* `ifttt-status`
* `ifttt-video`
* `ifttt-audio`
* `ifttt-chat`

So for my YouTube -> WordPress recipe, I have it adding the 'ifttt-video' category, and voilà, when it's published, the format has been set.

If you want to instead set the new post to a custom post type, you can do so by setting the category in IFTTT to one that matches this pattern: **`ifttt-posttype-{post_type_slug}`**. So if you wanted to create new WordPress pages with IFTTT, you would add the **`ifttt-posttype-page`** category.

Hope you find this useful.


== Installation ==

1. Upload the `ifttt-post-formats` directory to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= ?? =
* If you run into a problem or have a question, contact me ([contact form](http://j.ustin.co/scbo43) or [@jtsternberg on twitter](http://j.ustin.co/wUfBD3)). I'll add them here.


== Changelog ==

= 0.1.1 =
* Add custom post type support

= 0.1.0 =
* First Release


== Upgrade Notice ==

= 0.1.1 =
* Add custom post type support

= 0.1.0 =
* First Release
