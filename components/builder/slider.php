<?php
if ( get_sub_field( 'slide_speed' ) ):
	$speed = get_sub_field( 'slide_speed' );
else:
	$speed = '3000';
endif;
$class = get_sub_field( 'slide_class' );


$slider = flickity_settings();

wp_enqueue_script( 'flickity' );

?>
<?php if ( have_rows( 'slide_repeater' ) ): ?>
	<?php /*
 "prevNextButtons": false,
 "contain": true,
 "wrapAround": true
    */ ?>
    <section id="slider<?php module_count( $m ) ?>" class="builder-slider carousel js-flickity <?php echo $class ?>"
             data-flickity='{"autoPlay": "<?php echo $speed; ?> ", "wrapAround": true }'>
		<?php while ( have_rows( 'slide_repeater' ) ) : the_row(); ?>
            <div class="carousel-cell">
				<?php
				$image = get_sub_field( 'slide_image' );
				?>
                <div class="object-fit-fix">
                    <img class="item-background" src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>"/>
                </div>
                <div class="carousel-cell-inner">
                    <h2><?php the_sub_field( 'slide_title' ); ?></h2>
					<?php the_sub_field( 'slide_sub_title' ); ?>
                </div>

            </div>
		<?php endwhile; ?>
    </section>
<?php endif; ?>