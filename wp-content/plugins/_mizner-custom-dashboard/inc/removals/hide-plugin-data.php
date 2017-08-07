<?php
/*
 *  Hide Must Use Plugins
 *  https://developer.wordpress.org/reference/hooks/show_advanced_plugins/
 */
function return_false() {
	return false;
}

add_filter( 'show_advanced_plugins', 'return_false' );


/*
 * Hide Plugin Meta
 */
add_filter( 'plugin_row_meta', 'client_hide_plugin_details', 10, 2 );
function client_hide_plugin_details( $links, $file ) {
	$links = array();

	return $links;
}

/*
 * Hide Plugins
 */
add_filter( 'all_plugins', 'client_filter_plugins' );
function client_filter_plugins( $plugins ) {
	$excluded_plugins = [
		'Disable Comments',
		'WooCommerce',
		//'The SEO Framework'
	];

	function plugin_list( $plugins_data, $excluded_plugins ) {
		$plugin_list = [];
		foreach ( $plugins_data as $plugin ) {
			foreach ( $plugin as $key => $value ) {
				if ( $key === 'Name' && ! in_array( $value, $excluded_plugins ) ) {
					$plugin_list[] = $value;
				}
			}
		}

		return $plugin_list;
	}

	if ( ! isset( $_GET['seeplugins'] ) || $_GET['seeplugins'] !== 'fisho' ) {
		foreach ( $plugins as $key => &$plugin ) {
			if ( in_array( $plugin["Name"], plugin_list( $plugins, $excluded_plugins ) ) ) {
				unset( $plugins[ $key ] );
			}
		}
	}

	return $plugins;
}

/*
 * Hide Deactivate Links
 * Might be able to individually restrict with something like:
 * 'plugin_action_links_disable-comments/disable-comments.php' as the hook
 */

add_filter( 'plugin_action_links_woocommerce/woocommerce.php', 'client_hide_plugin_links' );
function client_hide_plugin_links( $links ) {
	if ( ! empty( $links['deactivate'] ) ) {
		$links = array(
			'deactivate' => ''
		);
	}

	return $links;
}