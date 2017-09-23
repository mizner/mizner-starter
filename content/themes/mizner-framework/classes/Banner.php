<?php

namespace Mizner\Theme;

use Mizner\Theme as Core;

class Banner {

	public $title;

	public $uri;

	public function __construct() {
		$this->uri   = $this->image_uri();
		$this->title = title();
	}

	public function init() {
		if ( ! function_exists( 'the_field' ) ) {
			return;
		}
		$this->custom_fields();

	}

	public function image_uri() {

		$fallback = ( has_header_image() ? get_header_image() : Core\URI . '/images/banner-default.jpg' );

		if ( is_home() ) {
			$blog_id    = get_option( 'page_for_posts' );
			$banner_id  = get_post_meta( $blog_id, 'banner_image', true );
			$banner_uri = wp_get_attachment_image_src( $banner_id, 'full' );

			return ( $banner_id ? $banner_uri[0] : $fallback );

		} elseif ( is_singular() ) {

			$post_id    = get_the_ID();
			$banner_id  = get_post_meta( $post_id, 'banner_image', true );
			$banner_uri = wp_get_attachment_image_src( $banner_id, 'full' );

			return ( $banner_id ? $banner_uri[0] : $fallback );

		} else {

			$uri = $fallback;

		}

		return ( $uri === null ? $fallback : $uri );
	}

	public function custom_fields() {

		acf_add_local_field_group( [
			'key'                   => 'group_587e0b469feb7',
			'title'                 => 'Banner Image',
			'fields'                => [
				[
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
					'key'               => 'field_587e0b5f351a9',
					'label'             => '',
					'name'              => 'banner_image',
					'type'              => 'image',
					'instructions'      => 'This image will replace the site-wide banner image at the top of your page or post',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => [
						'width' => '',
						'class' => '',
						'id'    => '',
					],
				],
			],
			'location'              => [
				[
					[
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'post',
					]
				],
				[
					[
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'page',
					]
				],
			],
			'menu_order'            => 98,
			'position'              => 'side',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => 1,
			'description'           => '',
		] );

	}
}