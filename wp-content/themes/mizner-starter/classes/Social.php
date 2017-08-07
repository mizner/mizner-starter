<?php

namespace Mizner\Theme;

use Mizner\Theme as Core;
use WP_Customize_Control;

Class Social {

	const PLATFORMS = [
		'facebook'  => 'icon-facebook', // fa-facebook-square
		'twitter'   => 'icon-twitter', // fa-twitter-square
		'linkedin'  => 'icon-linkedin', // fa-linkedin-square
		'google'    => 'icon-google', // fa-google-plus-square
		'youtube'   => 'icon-youtube-play', // fa-youtube-square
		'pinterest' => 'icon-pinterest-p', //  fa-pinterest-square
		'yelp'      => 'icon-yelp',
		'instagram' => 'icon-instagram',
	];

	public function init() {
		add_action( 'customize_register', [ $this, 'register_platforms' ], 10, 1 );
		add_action( 'customize_register', [ $this, 'register_phone' ], 10, 1 );
	}

	public function platforms() {
		$data = [];
		foreach ( self::PLATFORMS as $platform => $icon ) {
			$link = get_theme_mod( $platform );
			if ( $link ) {
				$data[ $icon ] = $link;
			}

		}

		return $data;
	}

	public function phone() {
		$phone_number = get_theme_mod( 'phone' );
		if ( ! get_theme_mod( 'phone' ) ) {
			return false;
		}

		return $phone_number;
	}

	public function register_phone( $wp_customize ) {
		$wp_customize->add_section( 'phone-field', array(
			'title'    => __( 'Phone Number', Core\TEXTDOMAIN ),
			'priority' => 1,
			//'description' => __( 'Enter details here.', Core\TEXTDOMAIN )
		) );

		$wp_customize->add_setting(
			'phone',
			[
				'default' => ''
			]
		);
		$wp_customize->add_control( new WP_Customize_Control(
				$wp_customize,
				'phone',
				[
					'label'    => __( 'Enter Phone Number', Core\TEXTDOMAIN ),
					'section'  => 'phone-field',
					'settings' => 'phone',
				]
			)
		);
	}


	public function register_platforms( $wp_customize ) {
		// Add Social Media Section
		$wp_customize->add_section( 'social-media', array(
			'title'       => __( 'Social Media', Core\TEXTDOMAIN ),
			'priority'    => 1,
			'description' => __( 'Enter details here.', Core\TEXTDOMAIN )
		) );

		foreach ( self::PLATFORMS as $platform => $icon ) {
			$wp_customize->add_setting(
				$platform,
				[
					'default' => ''
				]
			);
			$wp_customize->add_control(
				new WP_Customize_Control(
					$wp_customize,
					$platform,
					[
						'label'    => __( ucfirst( $platform ), Core\TEXTDOMAIN ),
						'section'  => 'social-media',
						'settings' => $platform,
					]
				)
			);
		}
	}
}