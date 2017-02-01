<?php
if ( ! isset( $content_width ) ) {
	$content_width = 1080; /* pixels */
}

add_theme_support( 'title-tag' );

add_theme_support( 'automatic-feed-links' );

register_nav_menus( [
	'primary-menu'   => __( 'Primary Menu', PROJECT ),
	'secondary-menu' => __( 'Secondary Menu', PROJECT ),
	'footer-menu'    => __( 'Footer Menu', PROJECT ),
] );

add_theme_support( 'html5', array(
	'search-form',
	'comment-form',
	'comment-list',
	'gallery',
	'caption',
) );

add_theme_support( "post-thumbnails" );


