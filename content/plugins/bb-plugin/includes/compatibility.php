<?php

/**
 * Misc functions for compatibility with other plugins.
 */

/**
 * Support for tinyPNG.
 *
 * Runs cropped photos stored in cache through tinyPNG.
 */
function fl_builder_tinypng_support( $cropped_path ) {

	if ( class_exists( 'Tiny_Settings' ) ) {
		try{
			$settings = new Tiny_Settings();
			$settings->xmlrpc_init();
			$compressor = $settings->get_compressor();
			if ( $compressor ) {
				$compressor->compress_file( $cropped_path['path'], false, false );
			}
		} catch( Exception $e ) {
			//
		}
	}
}
add_action( 'fl_builder_photo_cropped', 'fl_builder_tinypng_support' );

/**
 * Support for WooCommerce Memberships.
 *
 * Makes sure builder content isn't rendered for protected posts.
 */
function fl_builder_wc_memberships_support() {

	if ( function_exists( 'wc_memberships_is_post_content_restricted' ) ) {

		function fl_builder_wc_memberships_maybe_render_content( $do_render, $post_id ) {

			if ( wc_memberships_is_post_content_restricted() ) {

				// check if user has access to restricted content
				if ( ! current_user_can( 'wc_memberships_view_restricted_post_content', $post_id ) ) {
					$do_render = false;
				}
				// check if user has access to delayed content
				else if ( ! current_user_can( 'wc_memberships_view_delayed_post_content', $post_id ) ) {
					$do_render = false;
				}
			}

			return $do_render;
		}
		add_filter( 'fl_builder_do_render_content', 'fl_builder_wc_memberships_maybe_render_content', 10, 2 );
	}
}
add_action( 'plugins_loaded', 'fl_builder_wc_memberships_support', 11 );

/**
 * Support for Option Tree.
 *
 * Older versions of Option Tree don't declare the ot_get_media_post_ID
 * function on the frontend which is needed for the media uploader and
 * throws an error if it doesn't exist.
 */
function fl_builder_option_tree_support() {

	if ( !function_exists( 'ot_get_media_post_ID' ) ) {

		function ot_get_media_post_ID() {

			// Option ID
			$option_id = 'ot_media_post_ID';

			// Get the media post ID
			$post_ID = get_option( $option_id, false );

			// Add $post_ID to the DB
			if ( $post_ID === false ) {

				global $wpdb;

				// Get the media post ID
				$post_ID = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE `post_title` = 'Media' AND `post_type` = 'option-tree' AND `post_status` = 'private'" );

				// Add to the DB
				add_option( $option_id, $post_ID );
			}

			return $post_ID;
		}
	}
}
add_action('after_setup_theme', 'fl_builder_option_tree_support');

/**
 * If FORCE_SSL_ADMIN is enabled but the frontend is not SSL fixes a CORS error when trying to upload a photo.
 * `add_filter( 'fl_admin_ssl_upload_fix', '__return_false' );` will disable.
 *
 * @since 1.10.2
 */
function fl_admin_ssl_upload_fix() {
	if( defined( 'FORCE_SSL_ADMIN' ) && ! is_ssl() && is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		if( isset( $_POST['action'] ) && 'upload-attachment' === $_POST['action'] && true === apply_filters( 'fl_admin_ssl_upload_fix', true ) ) {
			force_ssl_admin(false);
		}
	}
}
add_action( 'plugins_loaded', 'fl_admin_ssl_upload_fix', 11 );

/**
 * Disable support Buddypress pages since it's causing conflicts with `the_content` filter
 *
 * @param bool $is_editable Wether the post is editable or not
 * @param $post The post to check from
 * @return bool
 */
function fl_builder_bp_pages_support( $is_editable, $post = false ){

	// Frontend check
	if ( !is_admin() && class_exists( 'BuddyPress' ) && ! bp_is_blog_page() ) {
		$is_editable = false;
	}

	// Admin rows action link check and applies to page list
	if ( is_admin() && class_exists( 'BuddyPress' ) && $post && 'page' == $post->post_type ) {

		$bp = buddypress();
		if ( $bp->pages ) {
			foreach( $bp->pages as $page ) {
				if ( $post->ID == $page->id ) {
					$is_editable = false;
					break;
				}
			}
		}
	}

	return $is_editable;
}
add_filter( 'fl_builder_is_post_editable', 'fl_builder_bp_pages_support', 11, 2 );

/**
 * There is an issue with Jetpack Photon and circle cropped photo module
 * returning the wrong image sizes from the bb cache folder.
 * This filter disables photon for circle cropped photo module images.
 */
function fl_photo_photon_exception( $val, $src, $tag ) {

	// Make sure its a bb cached image.
	if ( false !== strpos( $src, 'bb-plugin/cache' ) ) {

		// now make sure its a circle cropped image.
		if( false !== strpos( basename( $src ), '-circle' ) ) {
			return apply_filters( 'fl_photo_photon_exception', true );
		}

	}
	// return original val
	return $val;
}
add_filter( 'jetpack_photon_skip_image', 'fl_photo_photon_exception', 10, 3 );

/**
 * WordPress pre 4.5 we need to make sure that ui-core|widget|mouse are loaded before sortable.
 */
function fl_before_sortable_enqueue_callback() {

  if(version_compare( get_bloginfo( 'version' ), '4.5', '<') ) {
    wp_deregister_script( 'jquery-ui-widget' );
    wp_deregister_script( 'jquery-ui-mouse' );
    wp_deregister_script( 'jquery-ui-core' );
    wp_enqueue_script( 'jquery-ui-core', site_url(  '/wp-includes/js/jquery/ui/core.min.js' ), array('jquery'), '1.8.12' );
    wp_enqueue_script( 'jquery-ui-widget', site_url(  '/wp-includes/js/jquery/ui/widget.min.js' ), array('jquery'), '1.8.12' );
    wp_enqueue_script( 'jquery-ui-mouse', site_url(  '/wp-includes/js/jquery/ui/mouse.min.js' ), array('jquery'), '1.8.12' );
  }
}
add_action( 'fl_before_sortable_enqueue', 'fl_before_sortable_enqueue_callback' );

/**
 * Try to unserialize data normally.
 * Uses a preg_callback to fix broken data caused by serialized data that has broken offsets.
 *
 * @since 1.10.6
 * @param string $data unserialized string
 * @return array
 */
function fl_maybe_fix_unserialize( $data ) {
	// @codingStandardsIgnoreStart
	$unserialized = @unserialize( $data );
	// @codingStandardsIgnoreEnd
	if( ! $unserialized ) {
		$unserialized = unserialize( preg_replace_callback( '!s:(\d+):"(.*?)";!', 'fl_maybe_fix_unserialize_callback', $data ) );
	}
	return $unserialized;
}

/**
 * Callback function for fl_maybe_fix_unserialize()
 *
 * @since 1.10.6
 */
function fl_maybe_fix_unserialize_callback( $match ) {
	return ($match[1] == strlen($match[2])) ? $match[0] : 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
}
