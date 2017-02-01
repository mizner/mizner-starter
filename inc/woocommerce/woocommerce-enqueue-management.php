<?php
// ------------------------------------------------------------
// Remove woocommerce scripts on unnecessary pages
// ------------------------------------------------------------
add_action( 'wp_print_scripts', 'woocommerce_de_script', 100 );
function woocommerce_de_script() {
	if ( function_exists( 'is_woocommerce' ) ) {
		if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() && ! is_account_page() ) { // if we're not on a Woocommerce page, dequeue all of these scripts
			wp_dequeue_script( 'wc-add-to-cart' );
			wp_dequeue_script( 'jquery-blockui' );
			wp_dequeue_script( 'jquery-placeholder' );
			wp_dequeue_script( 'woocommerce' );
			wp_dequeue_script( 'jquery-cookie' );
			wp_dequeue_script( 'wc-cart-fragments' );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'remove_woocommerce_generator', 99 );
function remove_woocommerce_generator() {
	if ( function_exists( 'is_woocommerce' ) ) {
		if ( ! is_woocommerce() ) { // if we're not on a woo page, remove the generator tag
			remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
		}
	}
}

// ------------------------------------------------------------
// Remove woocommerce styles, then add woo styles back in on woo-related pages
// ------------------------------------------------------------

add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_css' );
function child_manage_woocommerce_css() {
	if ( function_exists( 'is_woocommerce' ) ) {
		if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() && ! is_account_page() ) {
			wp_dequeue_style( 'woocommerce-layout' );
			wp_dequeue_style( 'woocommerce-smallscreen' );
			wp_dequeue_style( 'woocommerce-general' );
		}
	}
}