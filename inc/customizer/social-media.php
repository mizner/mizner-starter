<?php
add_action( 'customize_register', [ 'SocialMedia', 'register' ], 10, 1 );

Class SocialMedia {

	const PLATFORMS  = [
		'facebook'  => 'fa-facebook', // fa-facebook-square
		'twitter'   => 'fa-twitter', // fa-twitter-square
		'linkedin'  => 'fa-linkedin', // fa-linkedin-square
		'google'    => 'fa-google', // fa-google-plus-square
		'youtube'   => 'fa-youtube-play', // fa-youtube-square
		'pinterest' => 'fa-pinterest-p', //  fa-pinterest-square
		'yelp'      => 'fa-yelp',
		'instagram' => 'fa-instagram',
	];

	public static function show() {
		$social_media_args = self::PLATFORMS;
		echo "<ul class='social-icons'>";
		foreach ( (array) $social_media_args as $platform => $fa_icon ) {
			$link = get_theme_mod( $platform );
			if ( $link ) {
				echo "<li class='icon'><a href='{$link}' itemprop='url'><i class='fa {$fa_icon}' aria-hidden='true'></i></a></li>";
			}
		}
		echo "</ul>";
	}


	public static function register( $wp_customize ) {
		// Add Social Media Section
		$wp_customize->add_section( 'social-media', array(
			'title'       => __( 'Social Media', 'knoxweb' ),
			'priority'    => -1,
			'description' => __( 'Enter details here.', 'knoxweb' )
		) );

		$social_media_args = self::PLATFORMS;

		foreach ( (array) $social_media_args as $platform => $icon ) {
			$wp_customize->add_setting( $platform, array( 'default' => '' ) );
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $platform, array(
				'label'    => __( ucfirst( $platform ), 'knoxweb' ),
				'section'  => 'social-media',
				'settings' => $platform,
			) ) );
		}
	}
}

function the_social_media() {
	SocialMedia::show();
}