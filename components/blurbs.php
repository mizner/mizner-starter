<?php if ( have_rows( 'blurbs' ) ): ?>
    <section class="blurbs">
        <div class="container">
            <div class="box">
				<?php while ( have_rows( 'blurbs' ) ) : the_row();
					$image        = get_sub_field( 'blurb_image' );
					$blurb_option = get_sub_field( 'blurb_option' );
					$blurb_link   = get_sub_field( 'blurb_link' );
					?>
                    <article class="blurb">
						<?php echo( ! $blurb_link == null ? "<a href='{$blurb_link}'>" : "" ); ?>
                        <div class="blurb-top">
							<?php if ( $blurb_option == 'icon' ) : ?>
								<?php the_sub_field( 'blurb_icon' ); ?>
							<?php else: ?>
                                <div class="object-fit-fix">
                                    <img src="<?php echo $image['sizes']['medium'] ?>"
                                         alt="<?php echo $image['alt'] ?>">
                                </div>
							<?php endif; ?>
                        </div>
                        <div class="blurb-bottom">
                            <h3><?php the_sub_field( 'blurb_title' ); ?></h3>
							<?php the_sub_field( 'blurb_content' ); ?>
                        </div>
						<?php echo( ! $blurb_link == null ? "</a>" : "" ); ?>
                    </article>
				<?php endwhile; ?>
            </div>
        </div>
    </section>
<?php endif; ?>