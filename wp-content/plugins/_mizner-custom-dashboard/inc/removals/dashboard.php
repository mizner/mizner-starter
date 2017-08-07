<?php
/*
 *  ## Remove "Welcome to WordPress"
 */
add_action( 'load-index.php', 'remove_welcome_panel' );
function remove_welcome_panel() {
	remove_action( 'welcome_panel', 'wp_welcome_panel' );
	$user_id = get_current_user_id();
	if ( 0 !== get_user_meta( $user_id, 'show_welcome_panel', true ) ) {
		update_user_meta( $user_id, 'show_welcome_panel', 0 );
	}
}

/*
 * Remove Dashboard Widgets
 */

// Function not working? Can't seem to get a hook to work :(
add_action( 'admin_init', 'client_remove_meta_boxes' );
function client_remove_meta_boxes() {
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	remove_meta_box( 'tribe_dashboard_widget', 'dashboard', 'normal' ); // Modern Tribe News
}


/*
 * ##  Remove from Dashboard Footer (Look into this?)
 */
remove_filter( 'update_footer', 'core_update_footer' );




