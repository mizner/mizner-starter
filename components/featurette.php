<?php
$prefix      = 'featurette_';
$title       = get_field( $prefix . 'title' );
$subtitle    = get_field( $prefix . 'sub_title' );
$button_link = get_field( $prefix . 'button_link' );
$button_text = get_field( $prefix . 'button_text' );
$option      = get_field( $prefix . 'asset_option' );
$image       = get_field( $prefix . 'image' );
$image_url   = $image['url'];
$image_alt   = $image['alt'];
$video       = get_field( $prefix . 'video' );
$icon        = get_field( $prefix . 'icon' );
?>
<section class="featurette">
    <div class="container">
        <div class="box">
            <header>
                <h3> <?php echo $title; ?></h3>
				<?php echo $subtitle; ?>
				<?php if ( $button_link ): ?>
                    <a href="<?php echo $button_link ?>">
                        <button class="button"><?php echo $button_text; ?></button>
                    </a>
				<?php endif; ?>
            </header>
            <aside>
				<?php if ( $option == 'image' ): ?>
                    <div class="object-fit-fix">
                        <img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>">
                    </div>
				<?php elseif ( $option == 'video' ): ?>
                    <div class="embed-container">
						<?php echo $video; ?>
                    </div>
				<?php elseif ( $option == 'icon' ): ?>
					<?php echo $icon; ?>
				<?php endif; ?>
            </aside>
        </div>
    </div>
</section>
