<?php get_header(); ?>

<?php get_template_part( 'template-parts/custom-banner' ); ?>

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'loop-templates/content' ); ?>

			<?php endwhile; ?>

		<?php else: ?>

			<?php get_template_part( 'loop-templates/content', 'none' ); ?>

		<?php endif; ?>

<?php get_footer(); ?>