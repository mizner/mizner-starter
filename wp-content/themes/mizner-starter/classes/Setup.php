<?php

namespace Mizner\Theme;

use Mizner\Theme as Core;

class Setup {
	public function init() {
		if ( ! isset( $content_width ) ) {
			$content_width = 1080; /* pixels */
		}
		$this->menus();
		$this->general();
		$this->sidebars();
	}

	public function general() {

		add_theme_support( 'title-tag' );

		add_theme_support( 'automatic-feed-links' );

		add_theme_support(
			'html5',
			[
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			]
		);

		add_theme_support( "post-thumbnails" );

	}

	public function menus() {

		register_nav_menus( [
			'primary-menu'   => __( 'Primary Menu', Core\TEXTDOMAIN ),
			'secondary-menu' => __( 'Secondary Menu', Core\TEXTDOMAIN ),
			'footer-menu'    => __( 'Footer Menu', Core\TEXTDOMAIN ),
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