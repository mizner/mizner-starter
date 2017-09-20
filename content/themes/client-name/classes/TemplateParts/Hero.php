<?php

namespace Mizner\Theme\TemplateParts;

class Hero {

	public function __construct() {
		if ( ! function_exists( 'the_field' ) ) {
			return;
		}
		$this->fields();
	}

	public function locations() {
		$locations = [
			[
				'param'    => 'page_template',
				'operator' => '==',
				'value'    => 'page-templates/homepage.php',
			],
		];

		return $locations;
	}

	public function fields() {

		acf_add_local_field_group( array(
			'key'                   => 'group_homepage_hero',
			'title'                 => 'Hero',
			'fields'                => array(
				array(
					'key'               => 'field_58a5c35d7df7d',
					'label'             => 'Type',
					'name'              => 'hero_type',
					'type'              => 'select',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'multiple'          => 0,
					'allow_null'        => 0,
					'choices'           => array(
						'static'        => 'Static',
						'rotate-images' => 'Rotate Images',
						'rotate-all'    => 'Rotate All',
					),
					'default_value'     => array(
						0 => 'static',
					),
					'ui'                => 0,
					'ajax'              => 0,
					'placeholder'       => '',
					'return_format'     => 'value',
				),
				array(
					'key'               => 'field_58a5c35d7decd',
					'label'             => 'Title',
					'name'              => 'hero_title',
					'type'              => 'text',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => array(
						array(
							array(
								'field'    => 'field_58a5c35d7df7d',
								'operator' => '!=',
								'value'    => 'rotate-all',
							),
						),
					),
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '',
					'maxlength'         => '',
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
				),
				array(
					'key'               => 'field_58a5c35d7dfea',
					'label'             => 'Sub Title',
					'name'              => 'hero_sub_title',
					'type'              => 'textarea',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => array(
						array(
							array(
								'field'    => 'field_58a5c35d7df7d',
								'operator' => '!=',
								'value'    => 'rotate-all',
							),
						),
					),
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '',
					'new_lines'         => 'wpautop',
					'maxlength'         => '',
					'placeholder'       => '',
					'rows'              => '',
				),
				array(
					'key'               => 'field_58a5c3db54b64',
					'label'             => 'Image',
					'name'              => 'hero_image',
					'type'              => 'image',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => array(
						array(
							array(
								'field'    => 'field_58a5c35d7df7d',
								'operator' => '==',
								'value'    => 'static',
							),
						),
					),
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
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
				),
				array(
					'key'               => 'field_58a5d058cd9ee',
					'label'             => 'Button Text',
					'name'              => 'hero_button_text',
					'type'              => 'text',
					'instructions'      => 'Defaults to "Click Here"',
					'required'          => 0,
					'conditional_logic' => array(
						array(
							array(
								'field'    => 'field_58a5c35d7df7d',
								'operator' => '!=',
								'value'    => 'rotate-all',
							),
						),
					),
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '',
					'maxlength'         => '',
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
				),
				array(
					'key'               => 'field_58a5d071cd9ef',
					'label'             => 'Button Link',
					'name'              => 'hero_button_link',
					'type'              => 'text',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => array(
						array(
							array(
								'field'    => 'field_58a5c35d7df7d',
								'operator' => '!=',
								'value'    => 'rotate-all',
							),
						),
					),
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => '',
					'maxlength'         => '',
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
				),
				array(
					'key'               => 'field_58a5c35d7e0b9',
					'label'             => 'Transition Speed',
					'name'              => 'hero_images_speed',
					'type'              => 'number',
					'instructions'      => 'e.g. 3000 = 3 seconds',
					'required'          => 0,
					'conditional_logic' => array(
						array(
							array(
								'field'    => 'field_58a5c35d7df7d',
								'operator' => '==',
								'value'    => 'rotate-images',
							),
						),
						array(
							array(
								'field'    => 'field_58a5c35d7df7d',
								'operator' => '==',
								'value'    => 'rotate-all',
							),
						),
					),
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'default_value'     => 3000,
					'min'               => '',
					'max'               => '',
					'step'              => '',
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
				),
				array(
					'key'               => 'field_58a5dda9cede8',
					'label'             => 'Images',
					'name'              => 'hero_images',
					'type'              => 'gallery',
					'instructions'      => 'Please note: this is set to a maximum of 5 to avoid performance problems',
					'required'          => 0,
					'conditional_logic' => array(
						array(
							array(
								'field'    => 'field_58a5c35d7df7d',
								'operator' => '==',
								'value'    => 'rotate-images',
							),
						),
					),
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'library'           => 'all',
					'min'               => '',
					'max'               => 5,
					'min_width'         => '',
					'min_height'        => '',
					'min_size'          => '',
					'max_width'         => '',
					'max_height'        => '',
					'max_size'          => '',
					'mime_types'        => '',
					'insert'            => 'append',
				),
				array(
					'key'               => 'field_58a5c40054b65',
					'label'             => 'Slider',
					'name'              => 'hero_slider',
					'type'              => 'repeater',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => array(
						array(
							array(
								'field'    => 'field_58a5c35d7df7d',
								'operator' => '==',
								'value'    => 'rotate-all',
							),
						),
					),
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'min'               => 0,
					'max'               => 0,
					'layout'            => 'row',
					'button_label'      => 'Add Slide',
					'collapsed'         => '',
					'sub_fields'        => array(
						array(
							'key'               => 'field_58a5c42e2f883',
							'label'             => 'Title',
							'name'              => 'hero_slider_title',
							'type'              => 'text',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => '',
							'maxlength'         => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
						),
						array(
							'key'               => 'field_58a5c9d52f884',
							'label'             => 'Subtitle',
							'name'              => 'hero_slider_subtitle',
							'type'              => 'textarea',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => '',
							'new_lines'         => 'wpautop',
							'maxlength'         => '',
							'placeholder'       => '',
							'rows'              => '',
						),
						array(
							'key'               => 'field_58a5c9e72f885',
							'label'             => 'Image',
							'name'              => 'hero_slider_image',
							'type'              => 'image',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
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
						),
						array(
							'key'               => 'field_58a5e32a1e22c',
							'label'             => 'Button Text',
							'name'              => 'hero_slider_button_text',
							'type'              => 'text',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => '',
							'maxlength'         => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
						),
						array(
							'key'               => 'field_58a5e33b1e22d',
							'label'             => 'Button Link',
							'name'              => 'hero_slider_button_link',
							'type'              => 'text',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => '',
							'maxlength'         => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
						),
					),
				),
			),
			'location'              => [ $this->locations() ],
			'menu_order'            => 1,
			'position'              => 'acf_after_title',
			'style'                 => 'default',
			'label_placement'       => 'left',
			'instruction_placement' => 'label',
			'active'                => 1,
			'description'           => '',
		) );
	}
}