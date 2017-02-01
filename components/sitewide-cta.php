<?php
$override = get_field( 'call_to_action_override_option' );

$title        = get_field( 'call_to_action_sitewide_title', 'option' );
$content      = get_field( 'call_to_action_sitewide_content', 'option' );
$gravity_form = get_field( 'call_to_action_sitewide_gf', 'option' );
$cta_option   = get_field( 'call_to_action_sitewide_type', 'option' );
$button_text  = get_field( 'call_to_action_sitewide_button_text', 'option' );
$button_link  = get_field( 'call_to_action_sitewide_button_link', 'option' );
$image        = get_field( 'call_to_action_sitewide_background_image', 'option' );

if ( $override == 'hide' ): ?>

    <!-- no CTA on this page -->

<?php else: ?>


	<?php if ( $override == 'yes' ): ?>
		<?php
		$title        = get_field( 'call_to_action_override_title' );
		$content      = get_field( 'call_to_action_override_content' );
		$gravity_form = get_field( 'call_to_action_override_gf' );
		$cta_option   = get_field( 'call_to_action_override_type' );
		$button_text  = get_field( 'call_to_action_override_button_text' );
		$button_link  = get_field( 'call_to_action_override_button_link' );
		$image        = get_field( 'call_to_action_override_background_image' );
		?>
	<?php endif; ?>
    <section class="call-to-action">
		<?php if ( ! $image == null ): ?>
            <div class="call-to-action-background object-fit-fix">
                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
            </div>
		<?php endif; ?>
        <div class="container">
            <div class="box">
                <article class="call-to-action-content">
                    <h2><?php echo $title; ?></h2>
					<?php echo $content ?>
					<?php if ( $cta_option == 'form' ): ?>
						<?php gravity_form( $gravity_form['id'], false, false, false, '', false ); ?>
					<?php else: ?>
                        <a href="<?php echo $button_link ?>">
                            <button class="button"><?php echo $button_text ?></button>
                        </a>
					<?php endif; ?>
                </article>
            </div>
        </div>
    </section>

<?php endif; ?>
