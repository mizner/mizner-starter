<?php

namespace Mizner\CleanWP;

class Remove {

	public function __construct() {
		if ( ! is_admin() ) {
			add_action( 'wp_default_scripts', [ $this, 'jquery_migrate' ] );
			add_action( 'wp_footer', [ $this, 'wp_embed' ] );
			add_action( 'init', [ $this, 'emojicons' ] );
			add_filter( 'tiny_mce_plugins', [ $this, 'emojicons_tinymce' ] );
			add_action( 'widgets_init', [ $this, 'recent_comments_style' ] );
		}
	}

	function wp_embed() {
		wp_deregister_script( 'wp-embed' );
	}

	function jquery_migrate( $scripts ) {
		if ( ! is_admin() && ! empty( $scripts->registered['jquery'] ) ) {
			$jquery_dependencies                 = $scripts->registered['jquery']->deps;
			$scripts->registered['jquery']->deps = array_diff( $jquery_dependencies, array( 'jquery-migrate' ) );
		}
	}

	function emojicons() {
		// all actions related to emojis
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

	}

	function emojicons_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}

	function recent_comments_style() {
		global $wp_widget_factory;
		remove_action( 'wp_head', array(
			$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
			'recent_comments_style'
		) );
	}
}