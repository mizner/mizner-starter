<?php
/*
 * Making jQuery Google API
 */
add_action( 'template_loaded', 'modify_jquery' );
function modify_jquery() {
	if ( ! is_admin() ) {
		// comment out the next two lines to load the local copy of jQuery
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js', false, '1.12.4' );
	}
}

$enqueues = new Enqueues();

add_action( 'wp_enqueue_scripts', [ $enqueues, 'general' ] );

add_action( 'get_footer', [ $enqueues, 'footer_styles' ] );

class Enqueues {

	public static function general() {

		wp_enqueue_script( PROJECT . '-js', THEME_BUILD_URI . PROJECT . '.min.js', [ 'jquery' ], THEME_VERSION, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	public static function footer_styles() {
		wp_enqueue_style( PROJECT . '-css', THEME_BUILD_URI . PROJECT . '.min.css', array(), THEME_VERSION, 'all' );

		if ( defined( 'GOOGLE_FONTS' ) ) {
			wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=' . GOOGLE_FONTS );
		}
		wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css' );
		wp_enqueue_style( PROJECT . '-info', get_stylesheet_uri() );
	}

}