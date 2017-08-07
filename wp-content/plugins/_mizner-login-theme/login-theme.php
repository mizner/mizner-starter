<?php
/**
 * Plugin Name: Login Theme
 * Plugin URI: http://mizner.io
 * Description:
 * Version: 1.0
 * Author: Michael Mizner
 * Author URI: http://mizner.io
 * License:
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'LOGIN_VIEW', 'login' );
define( 'LOGIN_VIEW_PATH', plugin_dir_path( __FILE__ ) );
define( 'LOGIN_VIEW_URI', plugin_dir_url( __FILE__ ) );

add_action( 'login_enqueue_scripts', 'client_login_styles' );

function client_login_styles() {
	wp_enqueue_style( 'client_login_css', LOGIN_VIEW_URI . '/dist/login.min.css' );
}

// Changing the wp-login.php Logo
add_action( 'login_head', 'client_login_logo' );
function client_login_logo() {
	ob_start(); ?>
	<style type="text/css">
		h1 a {
			background-image: url('<?php echo LOGIN_VIEW_URI . '/images/logo.png'?>') !important;
		}

		.login {
			background: url('<?php echo LOGIN_VIEW_URI . '/images/background.jpg'?>') !important;
		}
	</style>';
	<?php
	$styles = ob_get_clean();
	echo $styles;
}


// Change the login page URL
add_filter( 'login_headerurl', 'put_my_url' );
function put_my_url() {
	return ( '' ); // putting my URL in place of the WordPress one
}


// Change the login page URL hover text
add_filter( 'login_headertitle', 'put_my_title' );
function put_my_title() {
	return ( '' ); // changing the title from "Powered by WordPress" to whatever you wish
}