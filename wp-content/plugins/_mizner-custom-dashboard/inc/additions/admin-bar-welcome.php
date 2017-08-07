<?php
/*
 * ## Change the WordPress welcome message
 */
add_filter( 'gettext', 'change_howdy', 10, 3 );
function change_howdy( $translated, $text, $domain ) {
	if ( ! is_admin() || 'default' != $domain ) {
		return $translated;
	}
	if ( false !== strpos( $translated, 'Howdy' ) ) {
		return str_replace( 'Howdy', 'Hi there', $translated );
	}

	return $translated;
}