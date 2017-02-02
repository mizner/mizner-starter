<?php
function custom_featured_image( $post_id, $size ) {
	$image_id = get_post_thumbnail_id( $post_id );
	if ( $image_id ) {
		$image_src = get_the_post_thumbnail_url( $post_id, $size );
		$image_alt = get_post( get_post_thumbnail_id() )->post_title;
	} else {
		$image_src = THEME_BASE_URI . '/images/featured-image-backup.jpg';
		$image_alt = get_bloginfo( 'name' );
	}
	echo "<img src='{$image_src}' alt='{$image_alt}'>";
}