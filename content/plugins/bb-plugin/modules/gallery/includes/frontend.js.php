(function($) {
	
	$(function() {
		
		<?php if($settings->click_action == 'lightbox') : ?>
		if (typeof $.fn.magnificPopup !== 'undefined') {
			$('.fl-node-<?php echo $id; ?> .fl-mosaicflow-content, .fl-node-<?php echo $id; ?> .fl-gallery').magnificPopup({
				delegate: '.fl-photo-content a',
				closeBtnInside: false,
				type: 'image',
				gallery: {
					enabled: true,
					navigateByImgClick: true,
				},
				'image': {
					titleSrc: function(item) {
						<?php if($settings->show_captions == 'below') : ?>
							return item.el.parent().next('.fl-photo-caption').text();
						<?php elseif($settings->show_captions == 'hover') : ?>
							return item.el.next('.fl-photo-caption').text();
						<?php endif; ?>
					}
				},
				callbacks: {
					open: function(){
						<?php if($settings->layout == 'collage') : ?>
						if ( this.items.length > 0 ) {
							var parent,
								item,
								newIndex = 0,
								newItems = [];
	
							$(this.items).each(function(i, data){
								item = $(this);
								if ( 'undefined' !== typeof this.el ) {
									item = this.el;
								}							
								parent = item.parents('.fl-mosaicflow-item');
								
								newIndex = $(parent).attr('id').split('-').pop();
								newIndex = newIndex > 0 ? newIndex - 1 : 0;
								newItems[newIndex] = this;
							});
	
							this.items = newItems;
						}
						<?php endif; ?>
					}
				}
			});
		}
		<?php endif; ?>
		
		<?php if($settings->layout == 'collage') : ?>
		$('.fl-node-<?php echo $id; ?> .fl-mosaicflow-content').one( 'filled', function(){
			var hash = window.location.hash.replace( '#', '' );
			if ( hash != '' ) {
				FLBuilderLayout._scrollToElement( $( '#' + hash ) );
			}
			if ( 'undefined' != typeof Waypoint ) {
				Waypoint.refreshAll();
			}
		}).mosaicflow({
			itemSelector: '.fl-mosaicflow-item',
			columnClass: 'fl-mosaicflow-col',
			minItemWidth: <?php echo $settings->photo_size; ?>
		});
		<?php else : ?>
		$('.fl-node-<?php echo $id; ?> .fl-gallery-item').wookmark({
			align: 'center',
			autoResize: true,
			container: $('.fl-node-<?php echo $id; ?> .fl-gallery'),
			offset: <?php echo $settings->photo_spacing; ?>,
			itemWidth: 150
		});
		<?php endif; ?>
	});
	
})(jQuery);