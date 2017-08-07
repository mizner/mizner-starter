<?php if($settings->layout == 'collage') : ?>
.fl-node-<?php echo $id; ?> .fl-mosaicflow {
	margin-left: -<?php echo $settings->photo_spacing; ?>px;
}
.fl-mosaicflow-item {
	margin: 0 0 <?php echo $settings->photo_spacing; ?>px <?php echo $settings->photo_spacing; ?>px;
}
<?php endif; ?>
<?php if($settings->click_action == 'lightbox' && !empty($settings->show_captions)) : ?>
.mfp-gallery img.mfp-img {
	padding: 40px 0;
}	
<?php endif; ?>