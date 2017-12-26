<?php

namespace Mizner\Theme;

/**
 * Class Fonts
 *
 * @package Mizner\Theme
 */
class Fonts {
	/**
	 * Fonts constructor.
	 */
	public function __construct() {
		if ( is_admin() ) {
			return;
		}
		add_action( 'critical_styles', [ $this, 'load_font' ] );
	}

	/**
	 * Font Markup.
	 */
	public function load_font() {
		ob_start();
		?>
		<style type="text/css" data-type="critical-fonts">
			<?php include_once PATH . '/css/fonts.css'; ?>
		</style>
		<?php
		echo ob_get_clean();
	}
}