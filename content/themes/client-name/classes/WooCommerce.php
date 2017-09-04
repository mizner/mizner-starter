<?php

namespace Mizner\Theme;

class WooCommerce {

	public function init() {
		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			return;
		}
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
		$this->enqueues();
		// $this->markup();
	}

	public function markup() {
		add_action( 'woocommerce_before_shop_loop_item', [ $this, 'before_shop_image' ], - 11 );
		add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'before_shop_loop' ], 99 );
		add_action( 'woocommerce_after_shop_loop_item_title', [ $this, 'after_shop_loop' ], 99 );

		remove_action( 'woocommerce_before_main_content', [ $this, 'woocommerce_output_content_wrapper' ], 10 );
		add_action( 'woocommerce_before_main_content', [ $this, 'before_main_content' ], 10 );

		remove_action( 'woocommerce_after_main_content', [ $this, 'content_wrapper_end' ], 10 );
		add_action( 'woocommerce_after_main_content', [ $this, 'after_main_content' ], 10 );
	}

	static function before_shop_image() {
		echo '<div class="loop-product-wrapper"><div class="product-image-wrapper">';
	}

	static function before_shop_loop() {
		echo '</div><div class="product-meta-info">';
	}

	static function after_shop_loop() {
		echo '</div></div>';
	}

	static function before_main_content() {
		get_template_part( 'template-parts/custom-banner' );
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 ); // Removes sidebar
		echo "<section id='woocommerce-wrapper' class='container'>";
	}

	public function after_main_content() {
		echo "</section>";
	}


	public function enqueues() {
		add_action( 'wp_print_scripts', [ $this, 'dequeue_non_woo_pages' ], 99 );
		add_action( 'wp_enqueue_scripts', [ $this, 'remove_woocommerce_generator' ], 99 );
	}


	public function dequeue_non_woo_pages() {
		if ( function_exists( 'is_woocommerce' ) ) {
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() && ! is_account_page() ) {
				// If we're not on a Woocommerce page, dequeue all of these scripts.
				wp_dequeue_script( 'wc-add-to-cart' );
				wp_dequeue_script( 'jquery-blockui' );
				wp_dequeue_script( 'jquery-placeholder' );
				wp_dequeue_script( 'woocommerce' );
				wp_dequeue_script( 'jquery-cookie' );
				wp_dequeue_script( 'wc-cart-fragments' );

				// If we're not on a Woocommerce page, dequeue all of these styles.
				wp_dequeue_style( 'woocommerce-layout' );
				wp_dequeue_style( 'woocommerce-smallscreen' );
				wp_dequeue_style( 'woocommerce-general' );
			}
		}
	}

	public function remove_woocommerce_generator() {
		if ( function_exists( 'is_woocommerce' ) ) {
			if ( ! is_woocommerce() ) { // if we're not on a woo page, remove the generator tag
				remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
			}
		}
	}


}