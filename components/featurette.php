<section class="featurette">
    <div class="container">
        <div class="box">
            <header>
                <h3> <?php the_field( 'featurette_title' ); ?></h3>
				<?php the_field( 'featurette_sub_title' ); ?>
                <a href="<?php the_field( 'featurette_button_link' ); ?>">
                    <button class="button"><?php the_field( 'featurette_button_text' ); ?></button>
                </a>
            </header>
            <aside>
				<?php $option = get_field( 'featurette_asset_option' ); ?>
				<?php if ( $option == 'image' ):
					var_dump( $option );
					?>
					<?php $image = get_field( 'featurette_image' ); ?>
                    <div class="object-fit-fix">
                        <img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>">
                    </div>
				<?php elseif ( $option == 'video' ): ?>
                    <div class="embed-container">
						<?php the_field( 'featurette_video' ); ?>
                    </div>
				<?php elseif ( $option == 'icon' ): ?>
					<?php the_field( 'featurette_icon' ); ?>
				<?php else: ?>
				<?php endif; ?>
            </aside>
        </div>
    </div>
</section>
