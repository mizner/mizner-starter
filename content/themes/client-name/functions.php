<?php

namespace Mizner\Theme;

require_once 'lib/helpers.php';
require_once 'lib/autoload.php';

define( __NAMESPACE__ . '\PROJECT', 'client-name' );
define( __NAMESPACE__ . '\TEXTDOMAIN', 'mizner-theme' );
define( __NAMESPACE__ . '\PATH', get_template_directory() );
define( __NAMESPACE__ . '\URI', get_template_directory_uri() );
define( __NAMESPACE__ . '\VERSION', '1.0' );
// define( __NAMESPACE__ . '\GOOGLE_FONTS', 'Noto+Sans|Noto+Serif' );

add_action( 'after_setup_theme', function () {

	$setup         = new Setup();
	$critical      = new Critical();
	$extras        = new Extras();
	$image_sizes   = new ImageSizes();
	$admin         = new Admin();
	$markup_helper = new MarkupHelper();
	$schema        = new Schema();
	$social        = new Social();
	$enqueues      = new Enqueues();
	// WooCommerce Support
	$woocommerce = new WooCommerce();
	// ACF Support
	$acf    = new ACF();
	$banner = new Banner();

	$critical->init();
	$setup->init();
	$extras->init();
	$image_sizes->init();
	$admin->init();
	$markup_helper->init();
	$schema->init();
	$social->init();
	$enqueues->init();
	$woocommerce->init();
	$acf->init();
	$banner->init();
} );
