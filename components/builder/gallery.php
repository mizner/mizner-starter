<section id="gallery<?php module_count( $m ) ?>" class="builder-gallery">
		<?php

		$image_ids = get_sub_field( 'gallery_images', false, false );

		$shortcode = '[gallery size="medium" ids="' . implode( ',', $image_ids ) . '"]';

		/*
		 * type="rectangular"
		 * Gallery Types: "thumbnail", "rectangular", "square", "circle" or "slideshow".
		 * @link https://en.support.wordpress.com/gallery/
		 */

		echo do_shortcode( $shortcode );

		?>
</section>

