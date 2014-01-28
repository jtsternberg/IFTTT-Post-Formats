<?php
/*
	Plugin Name: IFTTT Post Formats
	Plugin URI: http://dsgnwrks.pro/plugins/ifttt-post-formats
	Description: Set a post format for your IFTTT-created posts, by adding a post format category.
	Author URI: http://jtsternberg.com/about
	Author: Jtsternberg
	Donate link: http://dsgnwrks.pro/give/
	Version: 0.1.0
*/


class IFTTT_WP_Post_Formats {

	function __construct() {
		add_action( 'save_post', array( $this, 'ifttt_formats' ), 18 );
	}

	/**
	 * Set post format based on category, and remove category
	 * @since 0.1.0
	 */
	function ifttt_formats( $post_id ) {

		$cats          = get_the_terms( $post_id, 'category' );
		$formats       = array( 'ifttt-aside', 'ifttt-gallery', 'ifttt-link', 'ifttt-image', 'ifttt-quote', 'ifttt-status', 'ifttt-video', 'ifttt-audio', 'ifttt-chat' );
		$filtered_cats = array();
		$share         = array();
		$format        = false;

		if ( $cats ) {
			// Loop through
			foreach ( $cats as $key => $cat ) {
				// if our cat slug matches one of our ifttt formats,
				if ( in_array( $cat->slug, $formats ) ) {
					// Set the post format
					$format = str_replace( 'ifttt-', '', $cat->slug );
					continue;
				}
				// Otherwise, add the term to the list of terms to be re-applied to the post
				$filtered_cats[] = $cat->name;
			}
		}

		// If we found a post-format category...
		if ( $format && ! get_post_format( $post_id ) ) {
			// set the post format
			set_post_format( $post_id , $format );
		}
		// Reset terms minus ifttt post format terms
		wp_set_object_terms( $post_id, $filtered_cats, 'category' );
	}

}

new IFTTT_WP_Post_Formats();
