<?php

namespace Mizner\CleanWP;

class Security {
	public function __construct() {
		if ( ! is_admin() ) {
			add_filter( 'the_generator', [ $this, 'no_generator' ] );
			add_action( 'template_redirect', [ $this, 'remove_head_items' ] );
			add_filter( 'style_loader_src', [ $this, 'remove_asset_version' ], 9999, 2 );
			add_filter( 'script_loader_src', [ $this, 'remove_asset_version' ], 9999, 2 );
			add_filter( 'login_errors', [ $this, 'show_less_login_info' ] );
		}
		add_action( 'wp_loaded', [ $this, 'remove_file_editor' ] );
	}

	/**
	 * Do not generate and display WordPress version
	 */
	function no_generator() {
		return '';
	}

	/**
	 * Clean up wp_head() from unused or unsecure stuff
	 */
	function remove_head_items() {

		/*
		 * Rest API header links
		 */
		remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

		/**
		 * Remove the next and previous post links
		 */
		remove_action( 'wp_head', 'adjacent_posts_rel_link', 10 );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );

		/**
		 * Remove rss feed links (make sure you add them in yourself if youre using feedblitz or an rss service)
		 */
		remove_action( 'wp_head', 'feed_links', 2 );

		/**
		 * Removes all extra rss feed links
		 */
		remove_action( 'wp_head', 'feed_links_extra', 3 );

		/**
		 * Remove link to index page
		 */
		remove_action( 'wp_head', 'index_rel_link' );

		/**
		 * Remove parent post link
		 */
		remove_action( 'wp_head', 'parent_post_rel_link', 10 );

		/**
		 * Weblog Client Link (nonsense)
		 */
		remove_action( 'wp_head', 'rsd_link' );

		/**
		 * Remove random post link
		 */
		remove_action( 'wp_head', 'start_post_rel_link', 10 );

		/**
		 * Windows Live Writer Manifest Link. (nonsense)
		 */
		remove_action( 'wp_head', 'wlwmanifest_link' );

		/**
		 * WordPress Generator. (security)
		 */
		remove_action( 'wp_head', 'wp_generator' );

		/**
		 *
		 */
		remove_action( 'wp_head', 'wp_resource_hints', 2 );

		/**
		 * WordPress Page/Post Shortlinks. (nonsense)
		 */
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );

	}

	/**
	 * Pick out the version number from scripts and styles
	 */
	function remove_asset_version( $src, $handle ) {
		$handles_with_version = [ 'style' ]; // <-- Adjust to your needs!
		if ( strpos( $src, 'ver=' ) && ! in_array( $handle, $handles_with_version, true ) ) {
			$src = remove_query_arg( 'ver', $src );
		}

		return $src;
	}

	/**
	 * Show less info to users on failed login for security.
	 * (Will not let a valid username be known.)
	 */
	function show_less_login_info() {
		return _( "<strong>Incorrect</strong>: Sorry, please try again or reset your password." );
	}

	function remove_file_editor() {
		define( 'DISALLOW_FILE_EDIT', true );
	}
}