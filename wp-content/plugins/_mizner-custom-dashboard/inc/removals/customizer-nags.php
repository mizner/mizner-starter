<?php
add_action( 'customize_register', 'client_remove_customizer_nags', 20 );
function client_remove_customizer_nags() {
	global $wp_customize;
	$wp_customize->remove_section( get_template() . '_theme_info' );
}