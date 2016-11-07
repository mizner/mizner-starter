<?php
// Page Slug Body Class
add_filter( 'body_class', 'add_slug_body_class' );
function add_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}

	return $classes;
}

// Better Get Excerpt
function get_excerpt( $limit, $source = null ) {

	if ( $source == "content" ? ( $excerpt = get_the_content() ) : ( $excerpt = get_the_excerpt() ) ) {
		;
	}
	$excerpt = preg_replace( " (\[.*?\])", '', $excerpt );
	$excerpt = strip_shortcodes( $excerpt );
	$excerpt = strip_tags( $excerpt );
	$excerpt = substr( $excerpt, 0, $limit );
	$excerpt = substr( $excerpt, 0, strripos( $excerpt, " " ) );
	$excerpt = trim( preg_replace( '/\s+/', ' ', $excerpt ) );
	//$excerpt = $excerpt . '... <a href="' . get_permalink( $post->ID ) . '">more</a>';
	$excerpt = $excerpt . '';

	return $excerpt;
}