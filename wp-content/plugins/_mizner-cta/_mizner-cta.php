<?php
/**
 * Plugin Name: (Mizner) - Call To Action
 * Plugin URI: http://mizner.io
 * Description:
 * Version: 1.0
 * Author: Michael Mizner
 * Author URI: http://mizner.io
 * License:
 */

namespace Mizner\CTA;

defined( 'WPINC' ) || die;

define( __NAMESPACE__ . '\TEXTDOMAIN', 'call-to-action' );
define( __NAMESPACE__ . '\PATH', plugin_dir_path( __FILE__ ) );
define( __NAMESPACE__ . '\URI', plugin_dir_url( __FILE__ ) );

require_once 'lib/autoload.php';

function run() {
	new Customizer();
	new Enqueues();
	new Content();
}

run();