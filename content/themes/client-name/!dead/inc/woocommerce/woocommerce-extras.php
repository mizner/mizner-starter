<?php
// ------------------------------------------------------------
//  Display $var products per page.
// ------------------------------------------------------------
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 50;' ), 20 );

// ------------------------------------------------------------
// Change number or products per row
// ------------------------------------------------------------
add_filter( 'loop_shop_columns', 'loop_columns' );
if ( ! function_exists( 'loop_columns' ) ) {
	function loop_columns() {
		return -1;
	}
}

// ------------------------------------------------------------
// Override default image
// ------------------------------------------------------------
add_filter( 'woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder', 10 );
function custom_woocommerce_placeholder( $image_url ) {
	$image_url = get_template_directory_uri() . "/inc/woocommerce/images/woo-product-default.png";  // change this to the URL to your custom placeholder

	return $image_url;
}


add_action( 'init', 'remove_button_from_archive_page' );
function remove_button_from_archive_page() {
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}

add_filter( 'woocommerce_show_page_title', 'override_page_title' );
function override_page_title() {
		return false;
}

