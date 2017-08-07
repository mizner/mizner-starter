<?php

// First, make sure Jetpack doesn't concatenate all its CSS
add_filter( 'jetpack_implode_frontend_css', '__return_false' );

// Then, remove each CSS file, one at a time
add_action( 'wp_print_styles', 'jetpack_remove_unnecessary_css', 99 );
function jetpack_remove_unnecessary_css() {
	$jetpack_stylesheet = [
		'AtD_style', // After the Deadline
		'jetpack_likes', // Likes
		'jetpack_related-posts', //Related Posts
		'jetpack-carousel', // Carousel
		'grunion.css', // Grunion contact form
		'the-neverending-homepage', // Infinite Scroll
		'infinity-twentyten', // Infinite Scroll - Twentyten Theme
		'infinity-twentyeleven', // Infinite Scroll - Twentyeleven Theme
		'infinity-twentytwelve', // Infinite Scroll - Twentytwelve Theme
		'noticons', // Notes
		'post-by-email', // Post by Email
		'publicize', // Publicize
		'sharedaddy', // Sharedaddy
		'sharing', // Sharedaddy Sharing
		'stats_reports_css', // Stats
		'jetpack-widgets', // Widgets
		'jetpack-slideshow', // Slideshows
		'presentations', // Presentation shortcode
		'jetpack-subscriptions', // Subscriptions
		'tiled-gallery', // Tiled Galleries
		'widget-conditions', // Widget Visibility
		'jetpack_display_posts_widget', // Display Posts Widget
		'gravatar-profile-widget', // Gravatar Widget
		'widget-grid-and-list', // Top Posts widget
		'jetpack-widgets', // Widgets
		'jetpack-social-menu'
	];

	foreach ( $jetpack_stylesheet as $stylesheet ) {
		wp_deregister_style( $stylesheet );
	}
}

// -------------------------------
// Dequeue JavaScripts
// -------------------------------
add_action( 'wp_print_scripts', 'jetpack_remove_unnecessary_js' );
function jetpack_remove_unnecessary_js() {
	$jetpack_scripts = [
		'jquery-cycle',
		'devicepx',
		'wpgroho',
		'grofiles-cards',
	];
	foreach ( $jetpack_scripts as $script ) {
		wp_dequeue_script( $script );
		wp_deregister_script( $script );
	}
}
