<?php $type = get_field( 'hero_type' ); ?>

<section class="hero">

	<?php if ( 'static' == $type ): ?>

		<?php get_template_part( 'components/hero/hero-static-image' ); ?>

	<?php elseif ( 'rotate-images' == $type ): ?>

		<?php get_template_part( 'components/hero/hero-rotate-images' ); ?>

		<?php wp_enqueue_script( 'flickity' ); ?>

	<?php elseif ( 'rotate-all' == $type ): ?>

		<?php get_template_part( 'components/hero/hero-rotate-all' ); ?>

		<?php wp_enqueue_script( 'flickity' ); ?>

	<?php endif; ?>

</section>