<?php
// ------------------------------------------------------------
// HTML Wrapper Helpers
// ------------------------------------------------------------

add_action( 'after_the_header', 'theme_content_open' );
function theme_content_open() {
	echo '<main id="content" class="content-area">';
}

add_action( 'before_the_footer', 'theme_content_close' );
function theme_content_close() {
	echo '</main><!--main-->';
}

add_action( 'before_the_header', 'theme_wrapper_open' );
function theme_wrapper_open() {
	echo '<div id="wrapper">';
}

add_action( 'after_the_footer', 'theme_wrapper_close' );
function theme_wrapper_close() {
	echo '</div><!--wrapper-->';
}