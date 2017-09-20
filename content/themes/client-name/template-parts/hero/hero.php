<?php
$type = get_field( 'hero_type' );
?>

<section class="hero container">

	<?php if ( 'thing' ): ?>
	<?php endif; ?>

	<?php if ( 'rotate-images' == $type ): ?>

		<?php get_template_part( 'template-parts/hero/hero-rotate-images' ); ?>

		<?php wp_enqueue_script( 'flickity' ); ?>
		<?php wp_enqueue_style( 'flickity-css' ); ?>

	<?php elseif ( 'rotate-all' == $type ): ?>

		<?php get_template_part( 'template-parts/hero/hero-rotate-all' ); ?>

		<?php wp_enqueue_script( 'flickity' ); ?>
		<?php wp_enqueue_style( 'flickity-css' ); ?>

	<?php else: ?>

		<?php get_template_part( 'template-parts/hero/hero-static-image' ); ?>

	<?php endif; ?>

</section>