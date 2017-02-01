<?php get_header(); ?>

<?php get_template_part( 'components/custom-header' ) ?>

<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'loop-templates/content', 'search' ); ?>


	<?php endwhile; ?>

<?php else : ?>

	<?php get_template_part( 'loop-templates/content', 'none' ); ?>

<?php endif; ?>

<?php get_footer(); ?>