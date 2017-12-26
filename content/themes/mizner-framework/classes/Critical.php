<?php

namespace Mizner\Theme;

/**
 * Class Critical
 *
 * @package Mizner\Theme
 */
class Critical {

	static $uri = PATH . '/dist/';

	public function init() {
		// Inline our styles.
		add_action( 'critical_styles', [ $this, 'critical_styles' ] );
	}

	public function critical_styles() {
		// todo: switch back for dev environments.
		if ( ! strpos( $_SERVER['HTTP_HOST'], '.dev' ) || strpos( $_SERVER['HTTP_HOST'], 'localhost' ) ) {
			return;
		}

		$file = PATH . '/dist/crit.min.css';
		if ( file_exists( stream_resolve_include_path( $file ) ) ) {
			ob_start();
			include_once( $file );
			$inline_css = ob_get_clean();
			echo '<style type="text/css" data-type="critical-styles">' . $inline_css . '</style>';
		}
	}
}