<?php

namespace Mizner\Theme;

class Admin {
	public function init() {
		add_filter( 'admin_post_thumbnail_html', [ $this, 'add_featured_image_instruction' ] );

	}

	public function add_featured_image_instruction( $content ) {
		return $content = '<div class="acf-field"><label class="acf-label"><p class="description">This image is the representative image for Posts or Pages. Can be important for social media sharing and SEO.</p></label></div>' . $content;
	}
}