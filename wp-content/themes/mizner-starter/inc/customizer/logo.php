<?php
add_theme_support( 'custom-logo' );

function logo_markup( $data ) {
	if ( $data['type'] == 'svg' ) :
		$logo = "<div id='logo'><a href='{$data['uri']}' itemprop='url'>{$data['file']}</a></div>";

	elseif ( in_array( $data['type'], [ 'png', 'media-library', 'jpg' ] ) ):
		$logo = "<div id='logo'><a href='{$data['uri']}' itemprop='url'><img src='{$data['src']}' alt='{$data['alt']}'></a></div>";

	else :
		$logo = "<div id='logo'><a href='{$data['uri']}' itemprop='url'><h1>{$data['alt']}</h1></a></div>";

	endif;

	return $logo;
}

function the_logo() {

	$logo = [
		'type' => null,
		'uri'  => esc_url( home_url( '/' ) ),
		'alt'  => get_bloginfo( 'name' ),
		'src'  => null,
		'file' => null
	];

	if ( file_exists( $svg = THEME_BASE_PATH . '/images/logo.svg' ) ):
		ob_start();
		include( THEME_BASE_PATH . '/images/logo.svg' );
		$logo['file'] = ob_get_clean();
		$logo['type'] = 'svg';
		remove_theme_support( 'custom-logo' );

	elseif ( file_exists( THEME_BASE_PATH . '/images/logo.png' ) ):
		$logo['src']  = get_template_directory_uri() . '/images/logo.png';
		$logo['type'] = 'png';
		remove_theme_support( 'custom-logo' );

	elseif ( file_exists( THEME_BASE_PATH . '/images/logo.jpg' ) ):
		$logo['src']  = get_template_directory_uri() . '/images/logo.jpg';
		$logo['type'] = 'jpg';
		remove_theme_support( 'custom-logo' );
	elseif ( has_custom_logo() ):
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$logo['src']    = wp_get_attachment_image_src( $custom_logo_id, 'full' )[0];
		$logo['type']   = 'media-library';
	else:
		$logo['type'] = 'text';
	endif;
	echo logo_markup( $logo );
}