<?php
/**
 * Template Name: ACF Homepage
 */

get_header();


get_template_part( 'template-parts/custom-banner' );
get_template_part( 'components/posts-slider' );

while ( have_posts() ) : the_post();

//		get_template_part( 'components/hero/hero' );
//
//		get_template_part( 'components/featurette' );
//
//		get_template_part( 'components/blurbs' );
//
//		get_template_part( 'components/ghost-blurbs' );
//
	get_template_part( 'components/recent-content' );

endwhile; ?>

<?php get_footer(); ?>

