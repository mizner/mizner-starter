<?php get_header(); ?>
	<section id="content">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'loop-templates/content', 'single' ); ?>
			<?php endwhile; ?>
		<?php else : ?>
			<?php get_template_part( 'loop-templates/content', 'none' ); ?>
		<?php endif; ?>
	</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>