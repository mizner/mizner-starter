<?php
/*
 * ## Remove Admin Bar Links
 */
add_action( 'wp_before_admin_bar_render', 'knoxweb_remove_admin_bar_links' );
function knoxweb_remove_admin_bar_links() {

	global $wp_admin_bar;

	$wp_admin_bar->remove_menu( 'w3tc-faq' );

	$wp_admin_bar->remove_menu( 'w3tc-support' );
}