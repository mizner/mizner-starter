<?php
/*
 * Custom Logo
 * This function checks for a logo set via Customize.
 * If none is set, will default to a .png file in the theme.
 */

add_theme_support( 'custom-logo' );

function logo_markup( $src, $alt, $uri ) {
	if ( $src === false ) {
		$logo = "<div id='logo'><a href='{$uri}'>{$alt}</a></div>";
	} else {
		$logo = "<div id='logo'><a href='{$uri}'><img src='{$src}' alt='{$alt}'></a></div>";
	}

	return $logo;
}

function the_logo() {
	$alt = get_bloginfo( 'name' );
	$uri = esc_url( home_url( '/' ) );

	if ( has_custom_logo() ):
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$custom_logo_img = wp_get_attachment_image_src( $custom_logo_id, 'full' );
		$src             = $custom_logo_img[0];
	elseif ( file_exists( get_template_directory() . '/images/logo.png' ) ):
		$src = get_template_directory_uri() . '/images/logo.png';
	else:
		$src = false;
	endif;
	echo logo_markup( $src, $alt, $uri );
}