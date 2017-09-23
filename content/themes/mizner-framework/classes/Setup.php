<?php

namespace Mizner\Theme;

class Setup {

	/**
	 * Initializer.
	 */
	public function init() {
		$this->menus();
		$this->general();
		$this->register_sidebars();
		add_action( 'customize_register', [ $this, 'customizer_options' ], 99 );
	}

	/**
	 * Customizer options.
	 *
	 * @param $wp_customize
	 */
	public function customizer_options( $wp_customize ) {
		$wp_customize->remove_section( 'themes' );
		$wp_customize->remove_section( 'custom_css' );
	}

	/**
	 * General.
	 */
	public function general() {

		add_theme_support( 'title-tag' );

		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'post-thumbnails' );

		add_theme_support( 'html5',
			[
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			]
		);

		add_theme_support( 'custom-header',
			apply_filters( 'custom_header_args', [
				'default-image' => '',
				'width'         => 1400,
				'height'        => 450,
				'flex-height'   => true,
			] )
		);

		add_theme_support( 'custom-logo' );

	}

	/**
	 * Menus
	 */
	public function menus() {

		register_nav_menus( [
			'primary_menu'   => __( 'Primary Menu', 'mizner-framework' ),
			'secondary_menu' => __( 'Secondary Menu', 'mizner-framework' ),
			'footer_menu'    => __( 'Footer Menu', 'mizner-framework' ),
		] );

	}

	/**
	 * Register Sidebars.
	 */
	public function register_sidebars() {

		register_sidebar( [
			'name'          => esc_html__( 'Sidebar', 'mizner-framework' ),
			'id'            => 'sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'mizner-framework' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		] );

		register_sidebar( [
			'id'    => 'footer-one',
			'class' => 'footer-widget',
			'name'  => __( 'Footer One', 'mizner-framework' ),
		] );

		register_sidebar( [
			'id'    => 'footer-two',
			'class' => 'footer-widget',
			'name'  => __( 'Footer Two', 'mizner-framework' ),
		] );

		register_sidebar( [
			'id'    => 'footer-three',
			'class' => 'footer-widget',
			'name'  => __( 'Footer Three', 'mizner-framework' ),
		] );

		register_sidebar( [
			'id'    => 'footer-four',
			'class' => 'footer-widget',
			'name'  => __( 'Footer Four', 'mizner-framework' ),
		] );

	}
}