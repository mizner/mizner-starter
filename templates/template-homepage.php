<?php
/**
 * Template Name: ACF Homepage
 */

get_header(); ?>

<?php get_template_part( 'components/posts-slider' ) ?>

<section id="content">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'components/hero/hero' ); ?>

		<?php get_template_part( 'components/featurette' ); ?>

		<?php get_template_part( 'components/blurbs' ); ?>

		<?php get_template_part( 'components/ghost-blurbs' ); ?>

		<?php get_template_part( 'components/recent-content' ); ?>

	<?php endwhile; ?>

</section>

<?php get_footer(); ?>

