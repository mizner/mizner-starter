<?php

/**
 * This file should be used to render each module instance.
 * You have access to two variables in this file:
 *
 * $module An instance of your module class.
 * $settings The module's settings.
 *
 * Example:
 */

?>
<div class="fl-photo-blurb obj-fit-fix">
    <a href="<?php echo $settings->photo_blurb_link; ?>">
        <img src="<?php echo $settings->photo_blurb_photo_background_src; ?>" alt="">
		<?php _log( $settings ); ?>
        <div class="fl-photo-blurb-text-wrapper">
           <div class="fl-photo-blurb-text">
               <h3 class="fl-photo-blurb-heading"><?php echo $settings->photo_blurb_heading; ?></h3>
               <p class="fl-photo-blurb-paragraph"><?php echo $settings->photo_blurb_paragraph; ?></p>
           </div>
        </div>
    </a>
</div>
