<?php
// Register Footer Widget Sidebars
function footer_widgets() {
	$args = [
		'name'          => esc_html__( 'Sidebar', 'knoxweb' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'knoxweb' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	];
	register_sidebar( $args );

	$args = [
		'id'    => 'footer-one',
		'class' => 'footer-widget',
		'name'  => __( 'Footer One', 'text_domain' ),
	];
	register_sidebar( $args );

	$args = [
		'id'    => 'footer-two',
		'class' => 'footer-widget',
		'name'  => __( 'Footer Two', 'text_domain' ),
	];
	register_sidebar( $args );

	$args = [
		'id'    => 'footer-three',
		'class' => 'footer-widget',
		'name'  => __( 'Footer Three', 'text_domain' ),
	];
	register_sidebar( $args );

	$args = [
		'id'    => 'footer-four',
		'class' => 'footer-widget',
		'name'  => __( 'Footer Four', 'text_domain' ),
	];
	register_sidebar( $args );

}

add_action( 'widgets_init', 'footer_widgets' );