<?php
/*
	Plugin Name: IFTTT Post Formats & Post Types
	Plugin URI: http://dsgnwrks.pro/plugins/ifttt-post-formats
	Description: Set a post format or post type for your IFTTT-created posts, by adding a post format category, or the "ifttt-posttype-{post_type_slug}" category.
	Author URI: http://jtsternberg.com/about
	Author: Jtsternberg
	Donate link: http://dsgnwrks.pro/give/
	Version: 0.1.2
*/


class IFTTT_Post_Formats_Post_Types {

	/**
	 * White-listed post-format categories to check for when a post is saved
	 *
	 * @var array
	 */
	protected $iftt_format_cats = array( 'ifttt-aside', 'ifttt-gallery', 'ifttt-link', 'ifttt-image', 'ifttt-quote', 'ifttt-status', 'ifttt-video', 'ifttt-audio', 'ifttt-chat' );

	/**
	 * The post ID of the saved-post to check
	 *
	 * @var int
	 */
	protected $post_id = 0;

	/**
	 * Be default, the categories will be re-applied back to the category taxonomy,
	 * but this is filterable (with the 'ifttt_pfpt_taxonomy_to_save_as' filter)
	 *
	 * @var string
	 */
	protected $taxonomy_to_save_as = 'category';

	/**
	 * Array of categories to re-apply to the post
	 *
	 * @var array
	 */
	protected $filtered_cats = array();

	/**
	 * The specified post format (if found)
	 *
	 * @var string
	 */
	protected $format = '';

	/**
	 * The specified post type (if found)
	 *
	 * @var string
	 */
	protected $post_type = '';

	/**
	 * Adds our hooks.
	 *
	 * @since 0.1.2
	 */
	function hooks() {
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
			&& 0 === $this->post_id
		) {
			$this->post_id = $post_id;

			add_action( 'save_post', array( $this, 'filter_categories' ), 18 );
		}

	}

	/**
	 * Loops through categories to determine any actionable IFTTT categories
	 * @since 0.1.0
	 */
	function filter_categories() {

		$cats = get_the_terms( $this->post_id, 'category' );

		// No categories? bail
		if ( ! $cats ) {
			return;
		}

		// Loop through
		foreach ( $cats as $key => $cat ) {

			// if our cat slug matches one of our ifttt formats,
			if ( in_array( $cat->slug, $this->iftt_format_cats ) ) {
				// Set the post format
				$this->format = str_replace( 'ifttt-', '', $cat->slug );
				continue;
			}

			if ( 0 === strpos( $cat->slug, 'ifttt-posttype-' ) ) {
				// Set the post-type
				$this->post_type = str_replace( 'ifttt-posttype-', '', $cat->slug );
				continue;
			}

			// Otherwise, add the term to the list of terms to be re-applied to the post
			$this->filtered_cats[] = $cat->name;
		}

		// If we found a post-format or post-type category, let's act on them
		if ( $this->format || $this->post_type ) {
			$this->handle_format_post_type();
		}

	}

	/**
	 * Set post format for a post and update the terms to remove the post-format term
	 *
	 * @since 0.1.1
	 */
	public function handle_format_post_type() {

		// If we found a post-format category...
		if ( $this->format ) {
			$this->set_post_format();
		}

		// If we found a post-type
		if ( $this->post_type && post_type_exists( $this->post_type ) ) {
			$this->set_post_type();
		}

		do_action( 'ifttt_pfpt_handle_format_post_type', $this->post_id, $this->filtered_cats, $this->post_type, $this->format );
	}

	/**
	 * Set post format for a post and update the terms to remove the post-format term
	 *
	 * @since 0.1.1
	 */
	public function set_post_format() {
		// set the post format
		set_post_format( $this->post_id, $this->format );

		// Reset terms minus ifttt post format terms
		wp_set_object_terms( $this->post_id, $this->filtered_cats, $this->taxonomy_to_save_as() );

		do_action( 'ifttt_pfpt_set_post_format', $this->post_id, $this->format, $this->filtered_cats );
	}

	/**
	 * Set post post_type for a post and update the terms to remove the post-type term
	 *
	 * @since 0.1.1
	 */
	public function set_post_type() {
		// Reset terms minus ifttt post-type term
		wp_set_object_terms( $this->post_id, $this->filtered_cats, $this->taxonomy_to_save_as() );

		// set the post-type
		set_post_type( $this->post_id, $this->post_type );

		do_action( 'ifttt_pfpt_set_post_type', $this->post_id, $this->post_type, $this->filtered_cats );
	}

	/**
	 * Retrieves the filtered taxonomy_to_save_as property. Defaults to 'category'
	 *
	 * @since  0.1.2
	 *
	 * @return string  Filtered value
	 */
	public function taxonomy_to_save_as() {
		return apply_filters( 'ifttt_pfpt_taxonomy_to_save_as', $this->taxonomy_to_save_as, $this->post_id, $this->filtered_cats, $this->post_type, $this->format );
	}

}

function ifttt_pfpt_object() {
	static $object = null;
	if ( is_null( $object ) ) {
		$object = new IFTTT_Post_Formats_Post_Types();
		$object->hooks();
	}

	return $object;
}

// Initiate
ifttt_pfpt_object();
