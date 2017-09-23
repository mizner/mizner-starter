<?php

namespace Mizner\Theme;

class Schema {

	function init() {
		add_filter( 'nav_menu_link_attributes', [ $this, 'add_attribute' ], 10, 3 );
	}

	function body() {

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

		return 'itemscope="itemscope" itemtype="' . $schema . $type . '"';
	}

	function blog() {
		// Only checking for default post type by default
		// Feel free to add more (via elseif) and don't forget to use it on custom single templates
		if ( 'post' == get_post_type() ) :
			$blog_schema = 'itemscope itemtype="http://schema.org/BlogPosting" itemprop="blogPost"';
		else :
			$blog_schema = '';
		endif;

		return $blog_schema;
	}


	function add_attribute( $atts, $item, $args ) {
		// Note doesn't work for custom menu calls, only general "wp_nav_menu()" with no params
		$atts['itemprop'] = 'url';

		return $atts;
	}

}