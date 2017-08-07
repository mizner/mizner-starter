<?php if ( isset($settings->click_action) && $settings->click_action == 'lightbox' ) : ?>
(function($){
	$('.fl-node-<?php echo $id; ?> .fl-button-lightbox').magnificPopup({
		<?php if ($settings->lightbox_content_type == 'video') : ?>
		type: 'iframe',		
		mainClass: 'fl-button-lightbox-wrap',
		<?php endif; ?>
		
		<?php if ($settings->lightbox_content_type == 'html') : ?>
		type: 'inline',
		items: {
			src: $('.fl-node-<?php echo $id; ?> .fl-button-lightbox-content')[0]
		},
		callbacks: {
		    open: function() {
		    	var divWrap = $( $(this.content)[0] ).find('> div');
		    	divWrap.css('display', 'block');

		    	// Triggers select change in we have multiple forms in a page 
		    	if ( divWrap.find('form select').length > 0 ) {
		    		divWrap.find('form select').trigger('change');
		    	}
		    },
		},
		<?php endif; ?>
		closeBtnInside: true,
		tLoading: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
	});
})(jQuery);
<?php endif; ?>
