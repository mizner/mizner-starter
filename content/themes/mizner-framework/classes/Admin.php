<?php

namespace Mizner\Theme;

/**
 * Class Admin
 *
 * @package Mizner\Theme
 */
class Admin {

	/**
	 * Initializer
	 */
	public function init() {
		add_filter( 'admin_post_thumbnail_html', [ $this, 'add_featured_image_instruction' ] );

	}

	/**
	 * @param $content
	 *
	 * @return string
	 */
	public function add_featured_image_instruction( $content ) {
		$text    = __( 'This image is the representative image for Posts or Pages. Can be important for social media sharing and SEO.' );
		$content = '<p class="description">' . $text . '</p>' . $content;

		return $content;
	}
}