<?php
define( 'PROJECT', 'starter' );
define( 'THEME_BASE_PATH', get_template_directory() );
define( 'THEME_BASE_URI', get_template_directory_uri() );
define( 'THEME_ASSETS_URI', THEME_BASE_URI . '/assets/' );
define( 'THEME_BUILD_URI', THEME_BASE_URI . '/dist/' );
define( 'GOOGLE_FONTS', 'Noto+Sans|Noto+Serif' );
define( 'THEME_VERSION', '1.0' );

add_action( 'after_setup_theme', 'the_setup' );
function the_setup() {

	$theme_includes = [
		'inc/setup.php',
		'inc/extras.php',
		'inc/widgets.php',
		'inc/markup-helpers.php',
		'inc/enqueues.php',
		'inc/customizer/phone.php',
		'inc/customizer/social-media.php',
		'inc/customizer/logo.php',
		'inc/customizer/removals.php',
		'acf/acf-index.php',
		'inc/custom-header-functions.php',
		'inc/sitewide-cta-functions.php',
		'inc/custom-featured-image.php',
	];

	foreach ( $theme_includes as $file ) {
		if ( ! $filepath = locate_template( $file ) ) {
			trigger_error( sprintf( __( 'Error locating %s for inclusion', PROJECT ), $file ), E_USER_ERROR );
		}
		require_once $filepath;
	}
	unset( $file, $filepath );

	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		require_once THEME_BASE_PATH . '/inc/woocommerce/woocommerce.php';
	}

}

