<?php
// Add Login & Logout
add_filter( 'wp_nav_menu_items', 'wplt_add_loginout_link', 10, 2 );
function wplt_add_loginout_link( $items, $args ) {
	if ( is_user_logged_in() && $args->theme_location == get_theme_mod( 'menu_choice' ) ) {
		$items .= '<li class="menu-item"><a href="' . wp_logout_url() . '">Logout</a></li>';
	} elseif ( ! is_user_logged_in() && $args->theme_location == 'primary-menu' ) {
		$items .= '<li class="menu-item"><a id="loginLink" class="popupTrigger" name="loginform" href="#">Sign In</a></li>';
		$items .= '<li class="menu-item"><a id="registerLink" class="popupTrigger" name="loginform" href="#">Register</a></li>';
	}

	return $items;
}
