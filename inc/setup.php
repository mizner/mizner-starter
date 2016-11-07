<?php
if ( ! isset( $content_width ) ) {
	$content_width = 1080; /* pixels */
}

add_action( 'after_setup_theme', 'the_setup' );
function the_setup() {

	add_theme_support( 'title-tag' );

	add_theme_support( 'automatic-feed-links' );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', PROJECT ),
		'secondary' => __( 'Secondary Menu', PROJECT ),
		'footer' => __( 'Footer Menu', PROJECT ),
	) );

	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	add_theme_support( "post-thumbnails" );
}

