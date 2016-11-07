<?php
/**
 * Template Name: Home Page
 */

get_header(); ?>

<?php get_template_part( 'components/posts-slider' ) ?>

<section id="content">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php the_title(); ?>

		<?php the_content(); ?>

	<?php endwhile; ?>

</section>

<?php get_sidebar(); ?>

<?php get_footer(); ?>

