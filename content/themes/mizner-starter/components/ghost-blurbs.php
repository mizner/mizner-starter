<?php if ( have_rows( 'ghost_blurbs' ) ): ?>
	<section class="ghost-blurbs">

		<?php while ( have_rows( 'ghost_blurbs' ) ) : the_row();
			$image          = get_sub_field( 'ghost_blurb_image' );
			$ghost_blurb_option = get_sub_field( 'ghost_blurb_option' );
			$ghost_blurb_link   = get_sub_field( 'ghost_blurb_link' );
			?>
			<article class="ghost-blurb dark">
				<?php echo( ! $ghost_blurb_link == null ? "<a href='{$ghost_blurb_link}'>" : "" ); ?>
				<div class="object-fit-fix ghost-blurb-image">
					<img src="<?php echo $image['sizes']['medium'] ?>"
					     alt="<?php echo $image['alt'] ?>">
				</div>
				<div class="ghost-blurb-text-container">
					<div class="ghost-blurb-text">
						<h3><?php the_sub_field( 'ghost_blurb_title' ); ?></h3>
						<?php the_sub_field( 'ghost_blurb_content' ); ?>
					</div>
				</div>
				<?php echo( ! $ghost_blurb_link == null ? "</a>" : "" ); ?>
			</article>
		<?php endwhile; ?>

	</section>
<?php endif; ?>