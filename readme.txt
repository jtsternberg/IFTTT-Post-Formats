=== Plugin Name ===
IFTTT Post Formats & Post Types

Contributors: jtsternberg  
Plugin Name: IFTTT Post Formats & Post Types  
Plugin URI: http://dsgnwrks.pro/plugins/ifttt-post-formats  
Tags: ifttt, post formats, post types, if this then that, automation  
Author URI: http://jtsternberg.com/about  
Author: Jtsternberg  
Donate link: http://j.ustin.co/rYL89n  
Requires at least: 3.1  
Tested up to: 4.2.0  
Version: 0.1.2  
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

Feel free to [contribute to or fork this plugin on github](https://github.com/jtsternberg/IFTTT-Post-Formats).

== Installation ==

1. Upload the `ifttt-post-formats` directory to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= How do I set the post type with this plugin? =
* This was added in version [0.1.1](https://wordpress.org/plugins/ifttt-post-formats/changelog/). To set the new post to a custom post type, you can do so by setting the category in IFTTT to one that matches this pattern: **`ifttt-posttype-{post_type_slug}`**. So if you wanted to create new WordPress pages with IFTTT, you would add the **`ifttt-posttype-page`** category.

= How can I change the taxonomy for the IFTTT categories? =
* This ability was added in version [0.1.2](https://wordpress.org/plugins/ifttt-post-formats/changelog/). You can hook into the `ifttt_pfpt_taxonomy_to_save_as` filter like so:
`function ifttt_pfpt_save_as_custom_taxonomy( $taxonomy ) {
	$taxonomy = 'custom-taxonomy-slug';
	return $taxonomy;
}
add_filter( 'ifttt_pfpt_taxonomy_to_save_as', 'ifttt_pfpt_save_as_custom_taxonomy' );`

= ?? =
* If you run into a problem or have a question, contact me ([contact form](http://j.ustin.co/scbo43) or [@jtsternberg on twitter](http://j.ustin.co/wUfBD3)). I'll add them here.


== Changelog ==

= 0.1.2 =
* New filter, `ifttt_pfpt_taxonomy_to_save_as`, to override which taxonomy the terms should be saved to (if not category).
* New action, `ifttt_pfpt_set_post_format`, called when a ifttt post format has been found and set.
* New action, `ifttt_pfpt_set_post_type`, called when a ifttt post type has been found and set.
* New action, `ifttt_pfpt_handle_format_post_type`, called when either a ifttt post format or ifttt post type has been found and set.

= 0.1.1 =
* Add custom post type support

= 0.1.0 =
* First Release

== Upgrade Notice ==

= 0.1.2 =
* New filter, `ifttt_pfpt_taxonomy_to_save_as`, to override which taxonomy the terms should be saved to (if not category).
* New action, `ifttt_pfpt_set_post_format`, called when a ifttt post format has been found and set.
* New action, `ifttt_pfpt_set_post_type`, called when a ifttt post type has been found and set.
* New action, `ifttt_pfpt_handle_format_post_type`, called when either a ifttt post format or ifttt post type has been found and set.

= 0.1.1 =
* Add custom post type support

= 0.1.0 =
* First Release
