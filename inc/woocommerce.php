<?php
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

// remove woocommerce scripts on unnecessary pages
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

// remove woocommerce styles, then add woo styles back in on woo-related pages
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


add_action( 'woocommerce_before_shop_loop_item', 'before_shop_image', - 11 );
function before_shop_image() {
	echo '<div class="loop_product_wrapper">';
}

add_action( 'woocommerce_before_shop_loop_item_title', 'before_shop_loop', 99 );
function before_shop_loop() {
	echo '<div class="product_meta_info">';
}

add_action( 'woocommerce_after_shop_loop_item_title', 'after_shop_loop', 99 );
function after_shop_loop() {
	echo '</div></div>';
}

add_action( 'init', 'remove_button_from_archive_page' );
function remove_button_from_archive_page() {
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}

/*
 * Wrapper
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );

add_action( 'woocommerce_before_main_content', 'my_content_wrapper_start', 10 );

function my_content_wrapper_start() {

	echo '<section id="content">';

}

remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_after_main_content', 'my_content_wrapper_end', 10 );

function my_content_wrapper_end() {

	echo '</section>';

}