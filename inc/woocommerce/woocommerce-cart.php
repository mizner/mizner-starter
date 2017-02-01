<?php
add_filter( 'wp_nav_menu_items', 'add_woo_cart', 10, 2 );
function add_woo_cart( $items, $args ) {
	ob_start();
	include_once "images/cart-icon.svg";
	$cart_icon = ob_get_clean();
	if ( $args->theme_location == 'top' ) {
		$qty  = WC()->cart->get_cart_contents_count();
		$text = "Items";
		$url  = get_permalink( wc_get_page_id( 'shop' ) );
		if ( $qty === 1 ) :
			$text = "Item";
		elseif ( $qty > 0 ):
			$url = wc_get_cart_url();
		else :

		endif;

		$items .= "<li><a href='{$url}' title='{$text}'>{$cart_icon} <span id='cartQty'>{$qty}</span> {$text}</a></li>";
	}


	return $items;
}

