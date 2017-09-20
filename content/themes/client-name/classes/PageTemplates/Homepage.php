<?php

namespace Mizner\Theme\PageTemplates;

class Homepage {

	const TEMPLATE_FILE_NAME = 'homepage.php';

	public function __construct() {

		add_action( 'admin_head', [ $this, 'remove_content_editor' ] );

	}

	public function remove_content_editor() {
		if ( self::TEMPLATE_FILE_NAME === basename( get_page_template() ) ) {
			remove_post_type_support('page', 'editor');
		}
	}

}