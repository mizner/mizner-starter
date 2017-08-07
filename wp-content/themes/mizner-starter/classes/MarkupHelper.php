<?php

namespace Mizner\Theme;

class MarkupHelper {
	public function init() {
		add_action( 'after_the_header', [ $this, 'theme_content_open' ] );
		add_action( 'before_the_footer', [ $this, 'theme_content_close' ] );
		add_action( 'before_the_header', [ $this, 'theme_wrapper_open' ] );
		add_action( 'after_the_footer', [ $this, 'theme_wrapper_close' ] );
	}

	public function theme_content_open() {
		echo '<main id="content" class="content-area">';
	}

	public function theme_content_close() {
		echo '</main><!--main-->';
	}

	public function theme_wrapper_open() {
		echo '<div id="wrapper">';
	}

	public function theme_wrapper_close() {
		echo '</div><!--wrapper-->';
	}

}
