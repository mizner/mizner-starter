<?php

namespace Mizner\Theme;

define( __NAMESPACE__ . '\TEXTDOMAIN', 'starter' );
define( __NAMESPACE__ . '\PATH', get_template_directory() );
define( __NAMESPACE__ . '\URI', get_template_directory_uri() );
define( __NAMESPACE__ . '\VERSION', '1.0' );
define( __NAMESPACE__ . '\GOOGLE_FONTS', 'Noto+Sans|Noto+Serif' );

require_once 'lib/autoload.php';

add_action( 'after_setup_theme', function () {

	$setup       = new Setup();
	$extras      = new Extras();
	$admin       = new Admin();
	$markup_helper = new MarkupHelper();
	$schema      = new Schema();
	$social      = new Social();
	$enqueues    = new Enqueues();
	$woocommerce = new WooCommerce();

	$setup->init();
	$extras->init();
	$admin->init();
	$markup_helper->init();
	$schema->init();
	$social->init();
	$enqueues->init();
	$woocommerce->init();

} );


// add_action( 'after_setup_theme', 'the_setup' );
function the_setup() {

	$theme_includes = [
//		'inc/setup.php',
//		'inc/extras.php',
//		'inc/widgets.php',
//		'inc/markup-helpers.php',
//		'inc/enqueues.php',
//		'inc/customizer/phone.php',
//		'inc/customizer/social-media.php',
//		'inc/customizer/logo.php',
//		'inc/customizer/removals.php',
//		'acf/acf-index.php',
//		'inc/custom-header-functions.php',
//		'inc/sitewide-cta-functions.php',
//		'inc/custom-featured-image.php',
	];

//	foreach ( $theme_includes as $file ) {
//		if ( ! $filepath = locate_template( $file ) ) {
//			trigger_error( sprintf( __( 'Error locating %s for inclusion', PROJECT ), $file ), E_USER_ERROR );
//		}
//		require_once $filepath;
//	}
//	unset( $file, $filepath );


}



