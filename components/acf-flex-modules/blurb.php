<?php $blurb_section_class = get_sub_field( 'blurb_class' ); ?>
<?php if ( have_rows( 'blurb_repeater' ) ): ?>
	<section id="acf_blurb<?php module_count( $m ) ?>" class="blurbs <?php echo $blurb_section_class ?>">
		<?php while ( have_rows( 'blurb_repeater' ) ) : the_row(); ?>
			<div class="blurb">
				<div class="blurb-top">
					<?php
					$blurb_option = get_sub_field( 'blurb_option' );
					if ( $blurb_option == 'fa-icon' ): ?>
						<i class="fa <?php the_sub_field( 'blurb_icon' ); ?>" aria-hidden="true"></i>
					<?php elseif ( $blurb_option == 'image' ): ?>
						<div class="image_container object_fit">
							<?php $image_field = get_sub_field( 'blurb_image' ); ?>
							<?php echo wp_get_attachment_image( $image_field['ID'], 'large' ); ?>
						</div>
					<?php endif; ?>
				</div>
				<div class="blurb-bottom">
					<h3><?php the_sub_field( 'blurb_title' ); ?></h3>
					<?php the_sub_field( 'blurb_sub_title' ); ?>
				</div>
			</div>
		<?php endwhile; ?>
	</section>
<?php endif; ?>