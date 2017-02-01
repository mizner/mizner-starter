<?php
/**
 * Template Name: Builder
 */
get_header();

if ( have_rows( 'module' ) ): $m = 0;
	// This function is helper for giving numbered classes to the modules
	function module_count( $m ) {
		echo '_' . $m;
	}

	// The loop through flexible content fields
	while ( have_rows( 'module' ) ) : the_row();
		if ( get_row_layout() == 'slider_layout' ):
			include( THEME_BASE_PATH . '/components/builder/slider.php' );
		elseif ( get_row_layout() == 'blurb_layout' ):
			include( THEME_BASE_PATH . '/components/builder/blurb.php' );
		elseif ( get_row_layout() == 'featurette_layout' ):
			include( THEME_BASE_PATH . '/components/builder/featurette.php' );
		elseif ( get_row_layout() == 'cta_layout' ):
			include( THEME_BASE_PATH . '/components/builder/cta.php' );
		elseif ( get_row_layout() == 'text_layout' ):
			include( THEME_BASE_PATH . '/components/builder/wysiwyg.php' );
		elseif ( get_row_layout() == 'gallery_layout' ):
			include( THEME_BASE_PATH . '/components/builder/gallery.php' );
		endif;
		$m ++;
	endwhile;
else :

endif;

get_footer();