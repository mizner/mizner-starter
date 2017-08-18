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

	public function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
		$classes = [];
		if ( ! empty( $item->classes ) ) {
			$classes = (array) $item->classes;
		}

		$active_class = '';
		if ( in_array( 'current-menu-item', $classes ) ) {
			$active_class = ' class="active"';
		} else if ( in_array( 'current-menu-parent', $classes ) ) {
			$active_class = ' class="active-parent"';
		} else if ( in_array( 'current-menu-ancestor', $classes ) ) {
			$active_class = ' class="active-ancestor"';
		}

		$url = '';
		if ( ! empty( $item->url ) ) {
			$url = $item->url;
		}

		$output .= '<li' . $active_class . '><a href="' . $url . '">' . $item->title . '</a></li>';
	}

	public function end_el( &$output, $item, $depth = 0, $args = [] ) {
		$output .= '</li>';
	}
}