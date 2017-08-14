<?php

namespace Mizner\Theme;

class Admin {
	public function init() {
		add_filter( 'admin_post_thumbnail_html', [ $this, 'add_featured_image_instruction' ] );

	}

	public function add_featured_image_instruction( $content ) {
		$text = _( 'This image is the representative image for Posts or Pages. Can be important for social media sharing and SEO.' );

		return $content = '<p class="description">' . $text . '</p>' . $content;
	}
}