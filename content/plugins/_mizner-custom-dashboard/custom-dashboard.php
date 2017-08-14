<?php
/**
 * Plugin Name: Custom Dashboard
 * Plugin URI: http://mizner.io
 * Description: Creates a slightly better user experience for our clients
 * Version: 9.0
 * Author: Michael Mizner
 * Author URI: http://mizner.io
 * License: GPL
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Disable Theme & Plugin Editor
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	define( 'DISALLOW_FILE_EDIT', true );
}

define( 'CLIENT_VIEW_NAME', 'custom-dashboard' );
define( 'CLIENT_PATH', plugin_dir_path( __FILE__ ) );
define( 'CLIENT_URI', plugin_dir_url( __FILE__ ) );


// "Owner" Role Specifics
add_action( 'init', 'custom_dashboard_includes' );
function custom_dashboard_includes() {

	// Enqueues
	include( 'inc/enqueues.php' );

	// Global Removals
	include( 'inc/removals/dashboard.php' );
	include( 'inc/removals/clear-default-roles.php' );
	include( 'inc/removals/admin-bar.php' );
	include( 'inc/removals/admin-color-picker.php' );

	// Global Additions
	include( 'inc/additions/admin-bar-logo.php' );
	include( 'inc/additions/admin-bar-welcome.php' );

	// Add New Role, "Owner" w/ Permissions
	include( 'inc/additions/owner-role.php' );


	$user = new WP_User( get_current_user_id() );
	if ( ! in_array( 'administrator', $user->roles ) ) :
		// -------------------------------
		// Removals
		// -------------------------------
		include( 'inc/removals/update-notifications.php' );
		include( 'inc/removals/user-profiles.php' );
		include( 'inc/removals/screen-options.php' );
		include( 'inc/removals/hide-plugin-data.php' );
		include( 'inc/removals/woocommerce_nags.php' );
		include( 'inc/removals/menu-pages.php' );
		include( 'inc/removals/users.php' );
		include( 'inc/removals/customizer-nags.php' );
		include( 'inc/removals/footer-text.php' );
		include( 'inc/removals/meta-boxes.php' );

		// -------------------------------
		// Additions
		// -------------------------------
		include( 'inc/additions/dashboard-widgets.php' );

	endif;

}


// Example Notice
//add_action( 'admin_notices', 'sample_admin_notice__success' );
function sample_admin_notice__success() {
	echo "<div class='notice notice-success is-dismissible'><p>Test</p></div>";
}


add_action( 'admin_head', 'hide_update_notice_to_all_but_admin_users', 1 );
function hide_update_notice_to_all_but_admin_users() {
	if ( ! current_user_can( 'update_core' ) ) {
		remove_action( 'admin_notices', 'update_nag', 3 );
	}
}