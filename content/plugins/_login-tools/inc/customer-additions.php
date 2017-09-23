<?php
add_action( 'customize_register', 'wplt_customizer_additions', 10, 1 );
function wplt_customizer_additions( $wp_customize ) {
	$wp_customize->add_section( 'choose_menu_for_login', [
		'title'       => __( 'Login Tools', 'textdomain' ),
		'description' => '',
		'priority'    => 500,
	] );
	$wp_customize->add_setting( 'menu_choice', [
	] );
	$wp_customize->add_control( 'menu_choice', [
		'label'   => 'Which Menu:',
		'section' => 'choose_menu_for_login',
		'type'    => 'select',
		'choices' => get_registered_nav_menus(),
	] );
}
