<?php

namespace Mizner\Theme;

use Mizner\Theme as Core;

class Enqueues {

	const DIST = Core\URI . '/dist/';

	public function init() {

		add_action( 'wp_enqueue_scripts', [ $this, 'general' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'load_cdn_jquery' ] );
		add_action( 'get_footer', [ $this, 'footer_styles' ] );

		add_action( 'admin_enqueue_scripts', [ $this, 'admin_styles' ] );

	}

	/**
	 * Swap jQuery from WordPress to CDN
	 */
	public function load_cdn_jquery() {
		if ( ! is_user_logged_in() ) {
			// comment out the next two lines to load the local copy of jQuery
			wp_deregister_script( 'jquery' );
			wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', false, '1.12.4' );
		}
	}

	public function general() {

		wp_register_script( 'flickity', self::DIST . '/js/flickity.min.js', null, '2.0.5', true );

		wp_enqueue_style( Core\PROJECT, self::DIST . Core\PROJECT . '.min.css', [], Core\VERSION, 'all' );

		wp_enqueue_script( Core\PROJECT . '-js', self::DIST . Core\PROJECT . '.min.js', [ 'jquery' ], Core\VERSION, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	public function footer_styles() {

		if ( defined( __NAMESPACE__ . '\GOOGLE_FONTS' ) ) {
			wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=' . Core\GOOGLE_FONTS );
			/**
			 * @link https://github.com/typekit/webfontloader
			 */
			wp_enqueue_script( 'webfontloader', '//ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js', [], '1.26', true );
		}

		wp_enqueue_style( Core\TEXTDOMAIN . '-info', get_stylesheet_uri() );
	}

	public function admin_styles() {

		wp_enqueue_style( Core\TEXTDOMAIN . '-admin', Core\URI . '/admin/css/admin.css' );

	}

}