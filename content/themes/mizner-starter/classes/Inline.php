<?php

namespace Mizner\Theme;

class Inline {

	public function __construct() {
		add_action( 'after_the_header', [ $this, 'inline_header_javascript' ], 20 );
		add_action( 'wp_head', [ $this, 'render_blocking_css' ] );
	}

	public function render_blocking_css() {
		$file = THEME_BASE_PATH . '/dist/' . PROJECT . '.inline.min.css';
		if ( file_exists( stream_resolve_include_path( $file ) ) ) {
			ob_start();
			include_once( $file );
			$inline_css = ob_get_clean();
			echo '<style type="text/css">' . $inline_css . '</style>';
		}
	}

	public function inline_header_javascript() {
		$file = THEME_BASE_PATH . '/dist/' . PROJECT . '.inline.min.js';
		if ( file_exists( stream_resolve_include_path( $file ) ) ) {
			ob_start();
			include_once( $file );
			$inline_javascript = ob_get_clean();
			echo '<script>' . $inline_javascript . '</script>';
		}
	}
}