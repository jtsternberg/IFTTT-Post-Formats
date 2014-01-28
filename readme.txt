=== Plugin Name ===
IFTTT Post Formats

Contributors      : jtsternberg
Plugin Name       : IFTTT Post Formats
Plugin URI        : http://dsgnwrks.pro/plugins/ifttt-post-formats
Tags              : ifttt, post formats, if this then that, automation
Author URI        : http://jtsternberg.com/about
Author            : Jtsternberg
Donate link       : http://j.ustin.co/rYL89n
Requires at least : 3.1
Tested up to      : 3.8
Version           : 0.1.0
Stable tag        : trunk
License           : GPLv2 or later
License URI       : http://www.gnu.org/licenses/gpl-2.0.html

Set a post format for your IFTTT-created posts via a post format category.

== Description ==

IFTTT (if this, then that) is one of the coolest web services available, and allows you to connect your different web service accounts to create 'recipes'. An example of a recipe that I have is to create a new WordPress post on my blog whenever I favorite a YouTube video.

Unfortunately IFTTT doesn't have a way to specify a post format, so this allows you to have the post format added by using a specific category. Just add a category with 'ifttt-' + your post format, and when the post is created, it will set the post format and remove the faux category.

So for my YouTube->WordPress recipe, I have it adding the 'ifttt-video' category, and voilà, when it's published, the format has been set.

Hope you find this useful.


== Installation ==

1. Upload the `ifttt-post-formats` directory to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= ?? =
* If you run into a problem or have a question, contact me ([contact form](http://j.ustin.co/scbo43) or [@jtsternberg on twitter](http://j.ustin.co/wUfBD3)). I'll add them here.


== Changelog ==

= 0.1.0 =
* First Release


== Upgrade Notice ==

= 0.1.0 =
* First Release
