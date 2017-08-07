<?php get_header(); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'loop-templates/content', 'page' ); ?>

		<?php endwhile; ?>

<?php get_footer(); ?>