<?php
/*
 * ## Remove Wordpress Admin Menu Bar info
 */
add_action( 'wp_before_admin_bar_render', 'annointed_admin_bar_remove', 0 );
function annointed_admin_bar_remove() {
	global $wp_admin_bar;

	// Remove Wordpress Logo stuff
	$wp_admin_bar->remove_menu( 'wp-logo' );
}