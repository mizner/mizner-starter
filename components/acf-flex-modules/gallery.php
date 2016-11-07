<section id="acf_gallery<?php module_count( $m ) ?>">
	<?php

	$image_ids = get_sub_field( 'gallery_images', false, false );

	$shortcode = '[gallery type="square" ids="' . implode( ',', $image_ids ) . '"]';

	/*
	 * Gallery Types: "thumbnail","rectangular", "square", "circle" or "slideshow".
	 * @link https://en.support.wordpress.com/gallery/
	 */

	echo do_shortcode( $shortcode );

	?>
</section>

