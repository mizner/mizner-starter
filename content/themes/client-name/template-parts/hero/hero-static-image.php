<?php
$image       = get_field( 'hero_image' );
$image_url   = ( $image == null ? 'https://placehold.it/1920x700' : $image['url'] ); // If there's no image, use placeholder image
$image_alt   = ( $image == null ? 'Placeholder' : $image['alt'] ); // and placeholder text
$title       = get_field( 'hero_title' );
$subtitle    = get_field( 'hero_sub_title' );
$button_text = get_field( 'hero_button_text' );
$button_text = ( $button_text == '' ? 'Click Here' : $button_text ); // Backup for no text
$button_link = get_field( 'hero_button_link' );
?>

<div class="hero-static">
    <div class="object-fit-fix hero-static-background">
        <img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>">
    </div>
    <article class="hero-text">
        <h1><?php echo $title; ?></h1>
		<?php echo $subtitle; ?>
        <a href="<?php echo $button_link; ?>">
            <button class="button"><?php echo $button_text; ?></button>
        </a>
    </article>
</div>