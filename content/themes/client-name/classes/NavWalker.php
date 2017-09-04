<?php

namespace Mizner\Theme;

// https://www.microdot.io/simpler-wp-nav-menu-markup/

use Walker_Nav_Menu;

class NavWalker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = [] ) {
		$output .= '<ul>';
	}

	public function end_lvl( &$output, $depth = 0, $args = [] ) {
		$output .= '</ul>';
	}

	public function start_el( &$output, $item, $depth = 1, $args = [], $id = 0 ) {

		$classes = [];
		if ( ! empty( $item->classes ) ) {
			$classes = (array) $item->classes;
		}

		$classes_array = [];

		if ( in_array( 'current-menu-item', $classes ) ) {
			array_push( $classes_array, 'active' );
		} else if ( in_array( 'current-menu-parent', $classes ) ) {
			array_push( $classes_array, 'active-parent' );

		} else if ( in_array( 'current-menu-ancestor', $classes ) ) {
			array_push( $classes_array, 'active-ancestor' );

		}

		$toggle_button = '';
		if ( in_array( 'menu-item-has-children', $classes ) ) {
			array_push( $classes_array, 'has-children' );
			$toggle_button = '<button><svg class="fa_svg"><use xlink:href="#icon-angle-down"></use></svg></button>';
		}

		$url = '';
		if ( ! empty( $item->url ) ) {
			$url = $item->url;
		}

		$classes_output = ( $classes_array ? ' class="' . implode( " ", $classes_array ) . '"' : '' );

		$output .= '<li' . $classes_output . '><a href="' . $url . '">' . $item->title . $toggle_button . '</a>';

	}

	public function end_el( &$output, $item, $depth = 0, $args = [] ) {

		$output .= '</li>';
	}

}