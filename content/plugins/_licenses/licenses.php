<?php
/**
 * Plugin Name: (custom) Licenses
 * Plugin URI: http://mizner.io
 * Description:
 * Version: 1.0
 * Author: Michael Mizner
 * Author URI: http://mizner.io
 * License: GPL
 */

namespace Mizner\Licenses;

defined( 'WPINC' ) || die;

define( __NAMESPACE__ . '\PATH', plugin_dir_path( __FILE__ ) );
define( __NAMESPACE__ . '\URI', plugin_dir_url( __FILE__ ) );

require_once 'classes/ACF.php';

add_action( 'plugins_loaded', function () {
	new ACF();
} );
