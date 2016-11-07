<?php get_header(); ?>
	<section id="content">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'loop-templates/content', 'page' ); ?>
		<?php endwhile; ?>
	</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>