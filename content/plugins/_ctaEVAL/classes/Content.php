<?php

namespace Mizner\CTA;

use Mizner\CTA as Core;

class Content {

	public function __construct() {
		add_action( 'wp_footer', [ $this, 'content' ] );
	}

	public function content() {
		include_once Core\PATH . 'templates/cta-wrapper.php';
	}
}