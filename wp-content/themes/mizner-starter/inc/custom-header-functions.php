<?php
add_theme_support( 'custom-header', apply_filters( 'custom_header_args', array(
	'default-image' => '',
	'width'         => 1000,
	'height'        => 250,
	'flex-height'   => true,
) ) );

function banner_image() {
	$image = [];
	if ( is_home() ):
		$blog_id = get_option( 'page_for_posts' );
		$banner  = get_field( 'banner_image', $blog_id );
		$image['url'] = $banner['url'];
	elseif ( $banner = get_field( 'banner_image' ) ):
		$image['url'] = $banner['url'];
	elseif ( has_header_image() ):
		$image['url'] = get_header_image();
	else:
		$image['url'] = THEME_BASE_URI . '/images/banner-default.jpg';
	endif;

	return $image;
}

function title() {
	if ( 'product' === get_post_type() ): // is_post_type_archive( 'product' )
		// -------------------------------
		// WooCommerce Support
		// -------------------------------
		if ( is_shop() ):
			$shop_page = get_option( 'woocommerce_shop_page_id' );
			// _log( 'is shop!' );
			$title = get_the_title( $shop_page );
		elseif ( is_archive() ):
			$title = single_term_title();
		else:
			$title = get_the_title();
		endif;

	elseif ( is_singular() ) :
		$title = get_the_title();

	elseif ( is_archive() ) :
		$title = single_term_title('', false);
		if ( is_post_type_archive() ):
			$title = str_replace( 'Archives:', '', get_the_archive_title());
		endif;


	elseif ( is_home() ):
		$blog  = get_option( 'page_for_posts' );
		$title = get_the_title( $blog );
	elseif ( is_search() ):
		$title = 'Search Results for: ' . get_search_query();
	else:
		$title = '';
	endif;

	echo $title;
}

if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group(array (
		'key' => 'group_587e0b469feb7',
		'title' => 'Banner Image',
		'fields' => array (
			array (
				'return_format' => 'array',
				'preview_size' => 'large',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
				'key' => 'field_587e0b5f351a9',
				'label' => '',
				'name' => 'banner_image',
				'type' => 'image',
				'instructions' => 'This image will replace the site-wide banner image at the top of your page or post',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
				),
			),
		),
		'menu_order' => 98,
		'position' => 'side',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

endif;
