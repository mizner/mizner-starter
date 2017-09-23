<?php
// -------------------------------
// Do not generate and display WordPress version
// -------------------------------
add_filter( 'the_generator', 'no_generator' );
function no_generator() {
	return '';
}

// -------------------------------
// Clean up wp_head() from unused or unsecure stuff
// -------------------------------
add_action( 'template_redirect', 'remove_head_items' );
function remove_head_items() {
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
}

// -------------------------------
// Pick out the version number from scripts and styles
// -------------------------------
add_filter( 'style_loader_src', 'remove_asset_version', 9999, 2 );
add_filter( 'script_loader_src', 'remove_asset_version', 9999, 2 );
function remove_asset_version( $src, $handle ) {
	$handles_with_version = [ 'style' ]; // <-- Adjust to your needs!
	if ( strpos( $src, 'ver=' ) && ! in_array( $handle, $handles_with_version, true ) ) {
		$src = remove_query_arg( 'ver', $src );
	}

	return $src;
}

// -------------------------------
// Show less info to users on failed login for security.
// (Will not let a valid username be known.)
// -------------------------------
add_filter( 'login_errors', 'show_less_login_info' );
function show_less_login_info() {
	return "<strong>Incorrect</strong>: Sorry, please try again or reset your password.";
}

// -------------------------------
// Remove Theme Editor
// -------------------------------
define( 'DISALLOW_FILE_EDIT', true );