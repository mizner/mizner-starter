<?php
function remove_core_updates() {
	global $wp_version;

	return (object) array( 'last_checked' => time(), 'version_checked' => $wp_version, );
}

add_filter( 'pre_site_transient_update_core', 'remove_core_updates' );
add_filter( 'pre_site_transient_update_plugins', 'remove_core_updates' );
add_filter( 'pre_site_transient_update_themes', 'remove_core_updates' );
