<?php
/*
	Plugin Name: IFTTT Post Formats & Post Types
	Plugin URI: http://dsgnwrks.pro/plugins/ifttt-post-formats
	Description: Set a post format or post type for your IFTTT-created posts, by adding a post format category, or the "ifttt-posttype-{post_type_slug}" category.
	Author URI: http://jtsternberg.com/about
	Author: Jtsternberg
	Donate link: http://dsgnwrks.pro/give/
	Version: 0.1.1
*/


class IFTTT_WP_Post_Formats {

	protected $iftt_format_cats = array( 'ifttt-aside', 'ifttt-gallery', 'ifttt-link', 'ifttt-image', 'ifttt-quote', 'ifttt-status', 'ifttt-video', 'ifttt-audio', 'ifttt-chat' );
	protected $post_id = null;

	function __construct() {
		add_action( 'save_post', array( $this, 'check_edit' ), 5, 2 );
	}

	/**
	 * Check if this post is one we need to check for ifttt categories
	 * @since 0.1.1
	 */
	public function check_edit( $post_id, $post ) {

		if (
			! ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			&& 'post' == $post->post_type
			&& current_user_can( 'edit_post', $post_id )
			&& ! wp_is_post_revision( $post )
			&& is_null( $this->post_id )
		) {
			$this->post_id = $post_id;
			add_action( 'save_post', array( $this, 'ifttt_formats_post_types' ), 18 );
		}

	}

	/**
	 * Set post format based on category, and remove category
	 * @since 0.1.0
	 */
	function ifttt_formats_post_types() {

		$cats          = get_the_terms( $this->post_id, 'category' );
		$filtered_cats = array();
		$format        = false;
		$post_type     = false;

		// No categories? bail
		if ( ! $cats ) {
			return;
		}

		// Loop through
		foreach ( $cats as $key => $cat ) {
			// if our cat slug matches one of our ifttt formats,
			if ( in_array( $cat->slug, $this->iftt_format_cats ) ) {
				// Set the post format
				$format = str_replace( 'ifttt-', '', $cat->slug );
				continue;
			}

			if ( 0 === strpos( $cat->slug, 'ifttt-posttype-' ) ) {
				// Set the post-type
				$post_type = str_replace( 'ifttt-posttype-', '', $cat->slug );
				continue;
			}

			// Otherwise, add the term to the list of terms to be re-applied to the post
			$filtered_cats[] = $cat->name;
		}

		// If we found no post-format or post-type categories, bail
		if ( ! $format && ! $post_type ) {
			return;
		}

		// If we found a post-format category...
		if ( $format && ! get_post_format( $this->post_id ) ) {
			$this->set_post_format( $format, $filtered_cats );
		}

		// If we found a post-type
		if ( $post_type && post_type_exists( $post_type ) ) {
			$this->set_post_type( $post_type, $filtered_cats );
		}
	}

	/**
	 * Set post format for a post and update the terms to remove the post-format term
	 *
	 * @since 0.1.1
	 *
	 * @param string $format        Post format to set
	 * @param array  $filtered_cats Array of categories to re-apply to the post
	 */
	public function set_post_format( $format, $filtered_cats ) {
		// set the post format
		set_post_format( $this->post_id , $format );

		// Reset terms minus ifttt post format terms
		wp_set_object_terms( $this->post_id, $filtered_cats, 'category' );
	}

	/**
	 * Set post post_type for a post and update the terms to remove the post-type term
	 *
	 * @since 0.1.1
	 *
	 * @param string $post_type     post_type to set
	 * @param array  $filtered_cats Array of categories to re-apply to the post
	 */
	public function set_post_type( $post_type, $filtered_cats ) {
		// Reset terms minus ifttt post-type term
		wp_set_object_terms( $this->post_id, $filtered_cats, 'category' );

		// set the post-type
		set_post_type( $this->post_id, $post_type );
	}

}

new IFTTT_WP_Post_Formats();
