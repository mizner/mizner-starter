<?php

define( 'ACF_PATH', THEME_BASE_PATH . '/acf/acf-pro/' );
define( 'ACF_URI', THEME_BASE_URI . '/acf/acf-pro/' );


add_filter( 'body_class', 'custom_class' );
function custom_class( $classes ) {
	if ( is_page_template( 'templates/acf-base.php' ) ) {
		$classes[] = 'acf-modules';
	}

	return $classes;
}

// 1. customize ACF path
add_filter( 'acf/settings/path', 'my_acf_settings_path' );

function my_acf_settings_path( $path ) {

	// update path
	$path = ACF_PATH;

	// return
	return $path;
}


// 2. customize ACF dir
add_filter( 'acf/settings/dir', 'my_acf_settings_dir' );

function my_acf_settings_dir( $dir ) {

	// update path
	$dir = ACF_URI;

	// return
	return $dir;
}


// 3. Hide ACF field group menu item
// add_filter( 'acf/settings/show_admin', '__return_false' );


// 4. Include ACF
include_once( ACF_PATH . 'acf.php' );


// 5. Local JSON
add_filter( 'acf/settings/save_json', 'my_acf_json_save_point' );

function my_acf_json_save_point( $path ) {

	// update path
	$path = THEME_BASE_PATH . '/acf/acf-json';


	// return
	return $path;

}

// 6. Load JSON
add_filter( 'acf/settings/load_json', 'my_acf_json_load_point' );

function my_acf_json_load_point( $paths ) {

	// remove original path (optional)
	unset( $paths[0] );


	// append path
	$paths[] = THEME_BASE_PATH . '/acf/acf-json';


	// return
	return $paths;

}