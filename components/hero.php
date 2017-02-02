<?php
$speed = get_field( 'hero_images_speed' );
wp_enqueue_script( 'flickity' ); // The slider JavaScript
?>
<?php if ( have_rows( 'hero_images' ) ): ?>
    <div class="carousel js-flickity"
         data-flickity='{"autoPlay": "<?php echo $speed ?>", "wrapAround": true }'>
		<?php while ( have_rows( 'hero_images' ) ) : the_row(); ?>
            <div class="carousel-cell">
				<?php $image = get_sub_field( 'hero_image' ); ?>
                <div class="object-fit-fix">
                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                </div>
            </div>
		<?php endwhile; ?>
    </div>
<?php endif; ?>
<article class="dark">
    <h1><?php the_field( 'hero_title' ); ?></h1>
	<?php the_field( 'hero_sub_title' ); ?>
</article>
