<?php
add_action( 'woocommerce_before_shop_loop_item', 'before_shop_image', - 11 );
function before_shop_image() {
	echo '<div class="loop-product-wrapper"><div class="product-image-wrapper">';
}

add_action( 'woocommerce_before_shop_loop_item_title', 'before_shop_loop', 99 );
function before_shop_loop() {
	echo '</div><div class="product-meta-info">';
}

add_action( 'woocommerce_after_shop_loop_item_title', 'after_shop_loop', 99 );
function after_shop_loop() {
	echo '</div></div>';
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
add_action( 'woocommerce_before_main_content', 'theme_woocommerce_before_main_content', 10 );
function theme_woocommerce_before_main_content() {
	get_template_part( 'components/custom-header' );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 ); // Removes sidebar
	echo "<section id='woocommerce-wrapper' class='container'>";
}

remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_after_main_content', 'theme_woocommerce_after_main_content', 10 );
function theme_woocommerce_after_main_content() {
	echo "</section>";
}
