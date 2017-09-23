<?php
/**
 * Plugin Name: Testimonials
 * Plugin URI: http://mizner.io
 * Description: Basic Testimonials
 * Version: 99.0
 * Author: Michael Mizner
 * Author URI: http://mizner.io
 * License:
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'TST', 'testimonials-cpt' );
define( 'TST_PATH', plugin_dir_path( __FILE__ ) );
define( 'TST_URI', plugin_dir_url( __FILE__ ) );

require_once 'inc/custom-post-type.php';

