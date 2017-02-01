<?php
add_action( 'customize_register', 'unset_customizer_options', 999 );
function unset_customizer_options( $wp_customize ) {
	$wp_customize->remove_section( 'themes' );
	$wp_customize->remove_section( 'title_tagline' );
	$wp_customize->add_section( 'title_tagline', array(
		'title'    => esc_html__( 'Site Identity', PROJECT ),
		'priority' => - 2,
	) );
}