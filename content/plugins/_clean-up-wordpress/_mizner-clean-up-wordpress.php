<?php
/**
 * Plugin Name: (Mizner) Clean Up WordPress
 * Plugin URI: http://mizner.io
 * Description: Removes stuff WordPress shouldn't be doing anyways
 * Version: 1.0
 * Author: Michael Mizner
 * Author URI: http://mizner.io
 * License: GPL
 */

namespace Mizner\CleanWP;

defined( 'WPINC' ) || die;

define( __NAMESPACE__ . '\TEXTDOMAIN', 'clean-wp' );
define( __NAMESPACE__ . '\PATH', plugin_dir_path( __FILE__ ) );
define( __NAMESPACE__ . '\URI', plugin_dir_url( __FILE__ ) );

require_once 'lib/autoload.php';

function run() {
	new Remove();
	new Security();
}

run();