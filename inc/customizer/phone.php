<?php
add_action( 'customize_register', [ 'PhoneNumber', 'register' ] );

Class PhoneNumber {
	public static function register( $wp_customize ) {
		$wp_customize->add_section( 'phone-field', array(
			'title'    => __( 'Phone Number', 'knoxweb' ),
			'priority' => -1,
			//'description' => __( 'Enter details here.', 'knoxweb' )
		) );

		$wp_customize->add_setting( 'phone', array( 'default' => '' ) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'phone', array(
			'label'    => __( 'Enter Phone Number', 'knoxweb' ),
			'section'  => 'phone-field',
			'settings' => 'phone',
		) ) );
	}

	public static function show() {
		if ( get_theme_mod( 'phone' ) ) {
			$phone_number = get_theme_mod( 'phone' );
			echo "<div itemprop='telephone'><a class='phone-number' href='tel:+1{$phone_number}'><i class='fa fa-phone'></i> {$phone_number}</a></div>";
		}
	}
}

function the_phone() {
	PhoneNumber::show();
}