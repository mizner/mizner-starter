<?php
/*
 * ## Add Admin-Bar Logo
 */

add_action( 'admin_bar_menu', 'add_toolbar_items', - 1 );
function add_toolbar_items( $admin_bar ) {
	ob_start();
	include( CLIENT_PATH . 'images/logo.svg' );
	$the_logo = ob_get_clean();

	$admin_bar->add_menu( array(
		'id'    => 'logo',
		'title' => $the_logo,
		//'href'  => 'knoxweb.com',
		'meta'  => array(
			'title' => __( '' ),
		),
	) );
}