<?php

namespace Mizner\CTA;

use Mizner\CTA as Core;

class Enqueues {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'styles' ], 15 );
		add_action( 'wp_enqueue_scripts', [ $this, 'scripts' ], 15 );
	}

	public function styles() {
		wp_enqueue_style( Core\TEXTDOMAIN, Core\URI . '/dist/' . Core\TEXTDOMAIN . '.min.css' );
	}

	public function scripts() {
		wp_enqueue_script( Core\TEXTDOMAIN, Core\URI . '/dist/' . Core\TEXTDOMAIN . '.min.js', null, null, true );
	}
}