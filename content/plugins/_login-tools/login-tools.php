<?php
/**
 * Plugin Name: WordPress Login Tools
 * Plugin URI: http://mizner.io
 * Description: Developer toolkit for custom login forms
 * Version: 1.0
 * Author: Michael Mizner
 * Author URI: http://mizner.io
 * License:
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'WPLT', 'wp-login-tools' );
define( 'WPLT_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPLT_URI', plugin_dir_url( __FILE__ ) );

require_once WPLT_PATH . 'inc/customer-additions.php';
require_once WPLT_PATH . "inc/login-redirects.php";
require_once WPLT_PATH . "inc/menu-items.php";
require_once WPLT_PATH . "inc/shortcode-login-button.php";
require_once WPLT_PATH . "inc/svg-icons.php";

// -------------------------------
// Login Form
// -------------------------------
add_action( 'get_footer', 'wplt_login_form', 100 );
function wplt_login_form() {
	ob_start(); ?>
    <div class="popupWrapper loginform">
        <div class="popupInner">
            <div class="login-wrapper">
                <section class="options">
                    <button button-value="sign-in">Sign In</button>
                    <button button-value="register">Register</button>
                </section>
                <section class="options-container">
                    <div class="option-wrapper" form-link="loginLink">
		                <?php include_once WPLT_PATH . "templates/login-form.php"; ?>
                    </div>
                    <div class="option-wrapper" form-link="registerLink">
		                <?php include_once WPLT_PATH . "templates/register-form.php"; ?>
                    </div>
                </section>
            </div>
        </div>
    </div> <?php
	echo ob_get_clean();
}

// -------------------------------
// Add Forgot Password Link
// -------------------------------
add_action( 'login_form_bottom', 'wplt_add_lost_password_link' );
function wplt_add_lost_password_link() {
	return '<p class="login-lostpassword"><a href="/wp-login.php?action=lostpassword">Lost Password?</a></p>';
}