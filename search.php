<?php get_header(); ?>
	<section id="content">
		<header>
			<h1 class="page-title">Search Results for: <?php the_search_query() ?></h1>
		</header>
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'loop-templates/content', 'search' ); ?>
			<?php endwhile; ?>
		<?php else : ?>
			<?php get_template_part( 'loop-templates/content', 'none' ); ?>
		<?php endif; ?>
	</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>