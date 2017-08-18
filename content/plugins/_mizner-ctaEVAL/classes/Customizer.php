<?php

namespace Mizner\CTA;

use Mizner\CTA as Core;

use WP_Customize_Control;

class Customizer {

	public function __construct() {
		add_action( 'customize_register', [ $this, 'register' ] );
	}

	function register( $wp_customize ) {
		$wp_customize->add_section(
			'call-to-action-section',
			array(
				'title'    => __( 'Call to Action', Core\TEXTDOMAIN ),
				'priority' => 4,
				//'description' => __( 'Enter details here.', $this->textdomain )
			) );

		$wp_customize->add_setting(
			'call-to-action-button',
			array( 'default' => '' )
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'call-to-action-button',
				array(
					'label'    => __( 'Button Text', Core\TEXTDOMAIN ),
					'section'  => 'call-to-action-section',
					'settings' => 'call-to-action-button',
					'type'     => 'text',
				)
			)
		);

		$wp_customize->add_setting(
			'call-to-action-textarea',
			array( 'default' => '' )
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'call-to-action-textarea',
				array(
					'label'    => __( 'Content', Core\TEXTDOMAIN ),
					'section'  => 'call-to-action-section',
					'settings' => 'call-to-action-textarea',
					'type'     => 'textarea',
				)
			)
		);
	}
}