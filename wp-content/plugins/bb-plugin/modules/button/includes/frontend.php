<div class="<?php echo $module->get_classname(); ?>">
	<?php if ( isset($settings->click_action) && $settings->click_action == 'lightbox' ) : ?>
		<a href="<?php echo $settings->lightbox_content_type == 'video' ? $settings->lightbox_video_link : '#'; ?>" class="fl-button fl-button-lightbox<?php if ('enable' == $settings->icon_animation): ?> fl-button-icon-animation<?php endif; ?>" role="button">
	<?php else : ?>
		<a href="<?php echo $settings->link; ?>" target="<?php echo $settings->link_target; ?>" class="fl-button<?php if ('enable' == $settings->icon_animation): ?> fl-button-icon-animation<?php endif; ?>" role="button"<?php if ( isset( $settings->link_nofollow ) && 'yes' == $settings->link_nofollow ) echo ' rel="nofollow"'; ?>>
	<?php endif; ?>
		<?php if ( ! empty( $settings->icon ) && ( 'before' == $settings->icon_position || ! isset( $settings->icon_position ) ) ) : ?>
		<i class="fl-button-icon fl-button-icon-before fa <?php echo $settings->icon; ?>"></i>
		<?php endif; ?>
		<?php if ( ! empty( $settings->text ) ) : ?>
		<span class="fl-button-text"><?php echo $settings->text; ?></span>
		<?php endif; ?>
		<?php if ( ! empty( $settings->icon ) && 'after' == $settings->icon_position ) : ?>
		<i class="fl-button-icon fl-button-icon-after fa <?php echo $settings->icon; ?>"></i>
		<?php endif; ?>
	</a>
</div>
<?php if ( $settings->click_action == 'lightbox' && $settings->lightbox_content_type == 'html' && isset($settings->lightbox_content_html) ) : ?>
	<div class="fl-node-<?php echo $id; ?> fl-button-lightbox-content mfp-hide">
		<?php echo $settings->lightbox_content_html; ?>
	</div>
<?php endif; ?>