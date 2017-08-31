<?php

namespace Mizner\Theme;

use Mizner\Theme as Core;

class MarkupHelper {
	public function init() {
		add_action( 'before_the_header', [ $this, 'font_awesome_svg' ] );
		add_action( 'after_the_header', [ $this, 'theme_content_open' ] );
		add_action( 'before_the_footer', [ $this, 'theme_content_close' ] );
		add_action( 'before_the_header', [ $this, 'theme_wrapper_open' ] );
		add_action( 'after_the_footer', [ $this, 'theme_wrapper_close' ] );
	}

	public function font_awesome_svg(){
		include_once Core\PATH . '/images/font-awesome-sprites.svg';
	}

	public function theme_content_open() {
		echo '<main id="content">';
	}

	public function theme_content_close() {
		echo '</main><!-- #theContent-->';
	}

	public function theme_wrapper_open() {
		echo '<div id="wrapper">';
	}

	public function theme_wrapper_close() {
		echo '</div><!-- #wrapper-->';
	}
}
