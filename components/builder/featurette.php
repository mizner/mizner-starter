<?php if ( have_rows( 'featurette_repeater' ) ): ?>
	<section class="featurettes">
		<?php while ( have_rows( 'featurette_repeater' ) ) : the_row(); ?>
			<div class="featurette">
				<?php the_sub_field( 'featurette_icon' ); ?>
				<h3><?php the_sub_field( 'featurette_title' ); ?></h3>
				<p><?php the_sub_field( 'featurette_sub_title' ); ?></p>
			</div>
		<?php endwhile; ?>
	</section>
<?php endif; ?>