<?php
define( 'PROJECT', 'clone' );
define( 'THEME_BASE_PATH', get_template_directory() );
define( 'THEME_BASE_URI', get_template_directory_uri() );
define( 'THEME_ASSETS_URI', THEME_BASE_URI . '/assets/' );
define( 'THEME_BUILD_URI', THEME_BASE_URI . '/dist/' );
define( 'GOOGLE_FONTS', 'Noto+Sans|Noto+Serif' );
define( 'THEME_VERSION', '1.0' );

$theme_includes = [
	'inc/setup.php',
	'inc/extras.php',
	'inc/widgets.php',
	'inc/enqueues.php',
	'inc/phone.php',
	'inc/social-media.php',
	'inc/logo.php',
	'inc/customizer-options.php',
	'inc/divi-builder-support.php',
	'acf/acf-pro/acf.php',
	'acf/acf-settings.php',
	'acf/acf-options.php',
	'acf/acf-font-awesome/acf-font-awesome.php',
	'inc/woocommerce.php',
];

foreach ( $theme_includes as $file ) {
	if ( ! $filepath = locate_template( $file ) ) {
		trigger_error( sprintf( __( 'Error locating %s for inclusion', PROJECT ), $file ), E_USER_ERROR );
	}
	require_once $filepath;
}
unset( $file, $filepath );
