<?php

namespace Mizner\Theme;

class ThemeOptions {

	const MENU_TITLE = 'Options';
	const PAGE_SLUG = 'theme_options';

	public function init() {

		if ( ! function_exists( 'the_field' ) ) {
			return;
		}

		$this->add_page();
		$this->custom_fields();

	}

	public function add_page() {

		acf_add_options_page( [

			'page_title'  => 'Theme Options',
			'menu_title'  => 'Options',
			'menu_slug'   => self::PAGE_SLUG,
			'capability'  => 'manage_options',
			'position'    => 2,
			'parent_slug' => '',
			'icon_url'    => false,
			'redirect'    => true,
			'post_id'     => self::PAGE_SLUG,
			'autoload'    => false,

		] );

	}

	public function custom_fields() {

		acf_add_local_field_group( [
			'key'                   => self::PAGE_SLUG . '_metabox',
			'title'                 => 'Options Fields',
			'fields'                => [
				[
					'label'             => 'Image',
					'name'              => 'background_image',
					'type'              => 'image',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => [
						'width' => '',
						'class' => '',
						'id'    => '',
					],
					'return_format'     => 'array',
					'preview_size'      => 'large',
					'library'           => 'all',
					'min_width'         => '',
					'min_height'        => '',
					'min_size'          => '',
					'max_width'         => '',
					'max_height'        => '',
					'max_size'          => '',
					'mime_types'        => '',
				],
			],
			'location'              => [
				[
					[
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => self::PAGE_SLUG,
					],
				],
			],
			'menu_order'            => 0, // Metabox placement
			'style'                 => 'default',
			'label_placement'       => 'left',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => 1,
		] );
	}
}