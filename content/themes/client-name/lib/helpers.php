<?php

namespace Mizner\Theme;

use Mizner\Theme as Core;

function in_array_r( $needle, $haystack, $strict = false ) {
	/**
	 * Example: use to check active plugins
	 */
	foreach ( $haystack as $item ) {
		if ( ( $strict ? $item === $needle : $item == $needle ) || ( is_array( $item ) && in_array_r( $needle, $item, $strict ) ) ) {
			return true;
		}
	}

	return false;
}

function title() {

	if ( 'product' === get_post_type() ): // is_post_type_archive( 'product' )
		// WooCommerce Support
		if ( is_shop() ):
			$title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
		elseif ( is_archive() ):
			$title = single_term_title();
		else:
			$title = get_the_title();
		endif;

	elseif ( is_singular() ) :
		$title = get_the_title();

	elseif ( is_archive() ) :
		$title = single_term_title( '', false );
		if ( is_post_type_archive() ):
			$title = str_replace( 'Archives:', '', get_the_archive_title() );
		endif;

	elseif ( is_home() ):
		$blog  = get_option( 'page_for_posts' );
		$title = get_the_title( $blog );
	elseif ( is_search() ):
		$title = 'Search Results for: ' . get_search_query();
	else:
		$title = null;
	endif;

	return $title;
}

function get_svg( $path ) {
	ob_start();
	include Core\PATH . $path;

	return ob_get_clean();
}


function the_svg( $path ) {
	echo get_svg( $path );
}

function featured_image( $post_id, $size ) {
	$image_id = get_post_thumbnail_id( $post_id );
	if ( $image_id ) {
		$image_src = get_the_post_thumbnail_url( $post_id, $size );
		$image_alt = get_post( $image_id )->post_title;
	} else {
		$image_src = Core\URI . '/images/featured-image-backup.jpg';
		$image_alt = get_bloginfo( 'name' );
	}
	echo "<img src='{$image_src}' alt='{$image_alt}'>";
}