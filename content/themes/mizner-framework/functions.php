<?php

namespace Mizner\Theme;

require_once 'lib/helpers.php';
require_once 'lib/autoload.php';

define( __NAMESPACE__ . '\PROJECT', 'client-name' );
define( __NAMESPACE__ . '\TEXTDOMAIN', 'mizner-theme' );
define( __NAMESPACE__ . '\PATH', get_template_directory() );
define( __NAMESPACE__ . '\URI', get_template_directory_uri() );
define( __NAMESPACE__ . '\VERSION', '1.0' );

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
	$woocommerce = new Compatibility\WooCommerce();
	// ACF Support
	$acf = new Compatibility\ACF();

	// ACF Meta
	$banner = new Banner();
	new TemplateParts\Hero();
	new PageTemplates\Homepage();

	new Fonts();


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
	$banner->init();
} );
