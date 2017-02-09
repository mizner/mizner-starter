<?php
/*
 * Making jQuery Google API
 */
add_action( 'wp_enqueue_scripts', 'load_cdn_jquery' );
function load_cdn_jquery() {
	if ( ! is_user_logged_in() ) {
		// comment out the next two lines to load the local copy of jQuery
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', false, '1.12.4' );
	}
}

add_action( 'wp_enqueue_scripts', [ 'Enqueues', 'general' ] );

add_action( 'get_footer', [ 'Enqueues', 'footer_styles' ] );

class Enqueues {

	public static function general() {

		wp_register_script( 'flickity', THEME_BASE_URI . '/js/flickity.min.js', null, '2.0.5', true );

		wp_enqueue_style( PROJECT, THEME_BUILD_URI . PROJECT . '.min.css', [], THEME_VERSION, 'all' );

		wp_enqueue_script( PROJECT . '-js', THEME_BUILD_URI . PROJECT . '.min.js', [ 'jquery' ], THEME_VERSION, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	public static function footer_styles() {

		if ( defined( 'GOOGLE_FONTS' ) ) {
			wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=' . GOOGLE_FONTS );
		}

		wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css' );

		wp_enqueue_style( PROJECT . '-info', get_stylesheet_uri() );
	}

}