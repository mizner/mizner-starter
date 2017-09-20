<?php

$images      = get_field( 'hero_images' );
$title       = get_field( 'hero_title' );
$subtitle    = get_field( 'hero_sub_title' );
$button_text = get_field( 'hero_button_text' );
$button_text = ( $button_text == '' ? 'Click Here' : $button_text ); // Backup for no text
$button_link = get_field( 'hero_button_link' );

$speed           = get_field( 'hero_images_speed' );
$slider_settings = [
	'autoPlay'        => $speed,
	'wrapAround'      => true,
	'pageDots'        => false,
	'prevNextButtons' => false,
];
?>
<div class="hero-rotate-images">
	<?php if ( $images ): ?>
        <div class="carousel js-flickity"
             data-flickity='<?php esc_attr_e( json_encode( $slider_settings ) ); ?>'>
			<?php foreach ( $images as $key => $image ):
				$image_url = $image['url'];
				$image_alt = $image['alt'];
				?>
                <div class="carousel-cell" style="background: url(<?php echo $image_url; ?>)">

                </div>
			<?php endforeach; ?>
        </div>
	<?php else: ?>
		<?php get_template_part( 'components/hero/hero-static-image' ); ?>
	<?php endif; ?>
</div>

<article class="hero-text">
    <h1><?php echo $title; ?></h1>
	<?php echo $subtitle; ?>
    <a href="<?php echo $button_link; ?>">
        <button class="button"><?php echo $button_text; ?></button>
    </a>
</article>