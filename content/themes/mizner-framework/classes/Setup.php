<?php

namespace Mizner\Theme;

use Mizner\Theme as Core;

class Setup {
	public function init() {
		$this->content_width();
		$this->menus();
		$this->general();
		$this->sidebars();
		add_action( 'customize_register', [ $this, 'customizer_options' ], 99 );
	}

	public function content_width() {
		if ( ! isset( $content_width ) ) {
			$content_width = 1080; /* pixels */
		}
	}

	public function customizer_options( $wp_customize ) {
		$wp_customize->remove_section( 'themes' );
		$wp_customize->remove_section( 'custom_css' );
	}

	public function general() {

		add_theme_support( 'title-tag' );

		add_theme_support( 'automatic-feed-links' );

		add_theme_support( "post-thumbnails" );

		add_theme_support( 'html5', [
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			]
		);

		add_theme_support( 'custom-header',
			apply_filters( 'custom_header_args', array(
				'default-image' => '',
				'width'         => 1400,
				'height'        => 450,
				'flex-height'   => true,
			) )
		);

		add_theme_support( 'custom-logo' );

	}

	public function menus() {

		register_nav_menus( [
			'primary_menu'   => __( 'Primary Menu', Core\TEXTDOMAIN ),
			'secondary_menu' => __( 'Secondary Menu', Core\TEXTDOMAIN ),
			'footer_menu'    => __( 'Footer Menu', Core\TEXTDOMAIN ),
		] );

	}

	public function sidebars() {

		register_sidebar( [
			'name'          => esc_html__( 'Sidebar', Core\TEXTDOMAIN ),
			'id'            => 'sidebar',
			'description'   => esc_html__( 'Add widgets here.', Core\TEXTDOMAIN ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		] );

		register_sidebar( [
			'id'    => 'footer-one',
			'class' => 'footer-widget',
			'name'  => __( 'Footer One', Core\TEXTDOMAIN ),
		] );

		register_sidebar( [
			'id'    => 'footer-two',
			'class' => 'footer-widget',
			'name'  => __( 'Footer Two', Core\TEXTDOMAIN ),
		] );

		register_sidebar( [
			'id'    => 'footer-three',
			'class' => 'footer-widget',
			'name'  => __( 'Footer Three', Core\TEXTDOMAIN ),
		] );

		register_sidebar( [
			'id'    => 'footer-four',
			'class' => 'footer-widget',
			'name'  => __( 'Footer Four', Core\TEXTDOMAIN ),
		] );

	}
}