<?php
/**
 * Template Name: ACF Base
 */

get_header(); ?>
	<section id="content">
		<?php
		if ( have_rows( 'module' ) ): $m = 0;

			/*
			 *  This function is helper for giving numbered classes to the modules
			 */
			function module_count( $m ) {
				echo '_' . $m;
			}

			/*
			 * The loop through flexible content fields
			 */

			while ( have_rows( 'module' ) ) : the_row();
				if ( get_row_layout() == 'slider_layout' ):
					include( THEME_BASE_PATH . '/components/acf-flex-modules/slider.php' );
				elseif ( get_row_layout() == 'blurb_layout' ):
					include( THEME_BASE_PATH . '/components/acf-flex-modules/blurb.php' );
				elseif ( get_row_layout() == 'featurette_layout' ):
					include( THEME_BASE_PATH . '/components/acf-flex-modules/featurette.php' );
				elseif ( get_row_layout() == 'cta_layout' ):
					include( THEME_BASE_PATH . '/components/acf-flex-modules/cta.php' );
				elseif ( get_row_layout() == 'text_layout' ):
					include( THEME_BASE_PATH . '/components/acf-flex-modules/wysiwyg.php' );
				elseif ( get_row_layout() == 'gallery_layout' ):
					include( THEME_BASE_PATH . '/components/acf-flex-modules/gallery.php' );
				endif;
				$m ++;
			endwhile;
		else :

		endif;
		?>
	</section>
<?php

get_footer();