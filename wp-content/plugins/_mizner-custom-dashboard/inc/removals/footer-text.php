<?php
/*
 * ## Remove Footer Info
 */
add_filter( 'admin_footer_text', 'change_footer_admin');
function change_footer_admin() {
	echo '';
}

add_filter( 'update_footer', '__return_empty_string' );

