<?php get_header(); ?>
	<section id="content" class="has-sidebar">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'loop-templates/content' ); ?>
			<?php endwhile; ?>
		<?php else: ?>
			<?php get_template_part( 'loop-templates/content', 'none' ); ?>
		<?php endif; ?>
	</section>
<?php get_sidebar( 'sidebar' ); ?>
<?php get_footer(); ?>