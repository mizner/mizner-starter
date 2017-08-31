<?php

namespace Mizner\Theme;

class ImageSizes {
	public function init() {
		// add_action( 'intermediate_image_sizes_advanced', [ $this, 'remove_defaults' ], 20 );
//		add_action( 'admin_menu', [ $this, 'remove_menu_item' ] );
//		$this->update_default_sizes();
	}

	public function update_default_sizes() {
		update_option( 'thumbnail_size_w', 300 );
		update_option( 'thumbnail_size_h', 165 );

		update_option( 'medium_size_w', 600 );
		update_option( 'medium_size_h', 600 );

		update_option( 'large_size_w', 1920 );
		update_option( 'large_size_h', 600 );
	}

	public function remove_menu_item() {
		remove_submenu_page( 'options-general.php', 'options-media.php' );
	}

	public function remove_defaults( $sizes ) {
		unset( $sizes['thumbnail'] );
		unset( $sizes['medium'] );
		unset( $sizes['large'] );

		return $sizes;
	}
}