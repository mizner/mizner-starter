<?php

// -------------------------------
// Page Slug Body Class
// -------------------------------

add_filter( 'body_class', 'add_slug_body_class' );
function add_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}

	return $classes;
}

// -------------------------------
// Limit words in excerpt
// -------------------------------

add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function custom_excerpt_length( $length ) {
	return 20;
}

// -------------------------------
// Replaces the excerpt "Read More" text by a link
// -------------------------------

add_filter( 'excerpt_more', 'new_excerpt_more' );
function new_excerpt_more( $more ) {
	global $post;

	return '... <div class="read-more"><a href="' . get_permalink( $post->ID ) . '"> Read More</a></div>';
}

// -------------------------------
// Schema
// -------------------------------

function html_schema() {
	$schema = 'http://schema.org/';

	// Is single post
	if ( is_single() ) {
		$type = "Article";
	} // Is blog home, archive or category
	else if ( is_home() || is_archive() || is_category() ) {
		$type = "Blog";
	} // Is static front page
	else if ( is_front_page() ) {
		$type = "Website";
	} // Is a general page
	else {
		$type = 'WebPage';
	}

	echo 'itemscope="itemscope" itemtype="' . $schema . $type . '"';
}

function blog_schema() {
	// Only checking for default post type by default
	// Feel free to add more (via elseif) and don't forget to use it on custom single templates
	if ( 'post' == get_post_type() ) :
		$blog_schema = 'itemscope itemtype="http://schema.org/BlogPosting" itemprop="blogPost"';
	else :
		$blog_schema = '';
	endif;
	echo $blog_schema;
}

add_filter( 'nav_menu_link_attributes', 'add_attribute', 10, 3 );
function add_attribute( $atts, $item, $args ) {
	// Note doesn't work for custom menu calls, only general "wp_nav_menu()" with no params
	$atts['itemprop'] = 'url';

	return $atts;
}


// -------------------------------
// Featured Image Comment
// -------------------------------

add_filter( 'admin_post_thumbnail_html', 'add_featured_image_instruction' );
function add_featured_image_instruction( $content ) {
	return $content = '<div class="acf-field"><label class="acf-label"><p class="description">This image is the representative image for Posts or Pages. Can be important for social media sharing and SEO.</p></label></div>' . $content;
}


// -------------------------------
// Browser detection body_class() output
// -------------------------------
add_filter( 'body_class', 'alx_browser_body_class' );
function alx_browser_body_class( $classes ) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if ( $is_lynx ) {
		$classes[] = 'lynx';
	} elseif ( $is_gecko ) {
		$classes[] = 'gecko';
	} elseif ( $is_opera ) {
		$classes[] = 'opera';
	} elseif ( $is_NS4 ) {
		$classes[] = 'ns4';
	} elseif ( $is_safari ) {
		$classes[] = 'safari';
	} elseif ( $is_chrome ) {
		$classes[] = 'chrome';
	} elseif ( $is_IE ) {
		$browser = $_SERVER['HTTP_USER_AGENT'];
		$browser = substr( "$browser", 25, 8 );
		if ( $browser == "MSIE 7.0" ) {
			$classes[] = 'ie7';
			$classes[] = 'ie';
		} elseif ( $browser == "MSIE 6.0" ) {
			$classes[] = 'ie6';
			$classes[] = 'ie';
		} elseif ( $browser == "MSIE 8.0" ) {
			$classes[] = 'ie8';
			$classes[] = 'ie';
		} elseif ( $browser == "MSIE 9.0" ) {
			$classes[] = 'ie9';
			$classes[] = 'ie';
		} else {
			$classes[] = 'ie';
		}
	} else {
		$classes[] = 'unknown';
	}

	if ( $is_iphone ) {
		$classes[] = 'iphone';
	}

	return $classes;
}

// -------------------------------
// YouTube Embed Helper
// -------------------------------
add_filter( 'oembed_result', 'my_plugin_enable_js_api', 10, 3 );
function my_plugin_enable_js_api( $html, $url, $args ) {

	/*
	 * Modify video parameters.
	 * This allows interacting with the youtube videos via javascript. See: https://css-tricks.com/play-button-youtube-and-vimeo-api/
	 */
	if ( strstr( $html, 'youtube.com/embed/' ) ) {
		$html = str_replace( '?feature=oembed', '?feature=oembed&enablejsapi=1', $html );
	}

	return $html;
}

// -------------------------------
// SVG Support Function
// -------------------------------

function the_svg( $path ) {
	ob_start();
	include_once THEME_BASE_PATH . $path;
	echo ob_get_clean();
}