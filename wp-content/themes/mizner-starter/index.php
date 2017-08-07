<?php get_header(); ?>

<?php get_template_part( 'components/custom-header' ); ?>

    <div class="container">

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'loop-templates/content' ); ?>

			<?php endwhile; ?>

		<?php else: ?>

			<?php get_template_part( 'loop-templates/content', 'none' ); ?>

		<?php endif; ?>

    </div>

<?php get_footer(); ?>