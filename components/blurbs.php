<section class="blurbs">
	<?php if ( have_rows( 'blurbs' ) ): ?>
        <article class="blurb">
			<?php while ( have_rows( 'blurbs' ) ) : the_row();
				$image        = get_sub_field( 'blurb_image' );
				$blurb_option = get_sub_field( 'blurb_option' );
				?>
                <div class="blurb-top">
					<?php if ( $blurb_option == 'icon' ) : ?>
						<?php $icon = get_sub_field( 'blurb_icon' ); ?>
					<?php else: ?>
                        <div class="object-fit-fix">
                            <img src="<?php echo $image['sizes']['medium'] ?>" alt="<?php echo $image['alt'] ?>">
                        </div>
					<?php endif; ?>
                </div>
                <div class="blurb-bottom">
                    <h3><?php the_sub_field( 'blurb_title' ); ?></h3>
					<?php the_sub_field( 'blurb_content' ); ?>
                    <li><?php the_sub_field( 'blurb_link' ); ?></li>
                </div>
			<?php endwhile; ?>
        </article>
	<?php endif; ?>
</section>
