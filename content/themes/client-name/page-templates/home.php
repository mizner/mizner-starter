<?php
/**
 * Template Name: Home
 */

get_header();


// get_template_part( 'template-parts/custom-banner' );
get_template_part( 'components/posts-slider' );

while ( have_posts() ) : the_post();

	the_content();
	the_content();
	the_content();

//		get_template_part( 'components/hero/hero' );
//
//		get_template_part( 'components/featurette' );
//
//		get_template_part( 'components/blurbs' );
//
//		get_template_part( 'components/ghost-blurbs' );
//
	get_template_part( 'components/recent-content' );

endwhile;

get_footer();

