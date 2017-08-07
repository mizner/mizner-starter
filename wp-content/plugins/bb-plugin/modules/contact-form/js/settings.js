(function($){

	FLBuilder.registerModuleHelper('contact-form', {
    
		init: function()
		{
			var form      = $( '.fl-builder-settings' ),
				action    = form.find( 'select[name=success_action]' );
				
			this._actionChanged();
			
			action.on( 'change', this._actionChanged );

			// Button background color change
			$( 'input[name=btn_bg_color]' ).on( 'change', this._bgColorChange );			
			this._bgColorChange();

			// Toggle reCAPTCHA display
			this._toggleReCaptcha();
			$( 'select[name=recaptcha_toggle]' ).on( 'change', $.proxy( this._toggleReCaptcha, this ) );
			$( 'input[name=recaptcha_site_key]' ).on( 'change', $.proxy( this._toggleReCaptcha, this ) );

			// Render reCAPTCHA after layout rendered via AJAX
			if ( window.onLoadFLReCaptcha ) {
				$( FLBuilder._contentClass ).on( 'fl-builder.layout-rendered', onLoadFLReCaptcha );
			}			
		},
    
		_actionChanged: function()
		{
			var form      = $( '.fl-builder-settings' ),
				action    = form.find( 'select[name=success_action]' ).val(),
				url       = form.find( 'input[name=success_url]' );
				
			url.rules('remove');
				
			if ( 'redirect' == action ) {
				url.rules( 'add', { required: true } );
			}
		},

		_bgColorChange: function()
		{
			var bgColor = $( 'input[name=btn_bg_color]' ),
				style   = $( '#fl-builder-settings-section-btn_style' );
			

			if ( '' == bgColor.val() ) {
				style.hide();
			}
			else {
				style.show();
			}
		},

		/**
		 * Custom preview method for reCAPTCHA settings
		 * 
		 * @param  object event  The event type of where this method been called
		 * @since 1.9.5
		 */
		_toggleReCaptcha: function(event)
		{
			var form      	= $( '.fl-builder-settings' ),
				nodeId    	= form.attr( 'data-node' ),
				toggle    	= form.find( 'select[name=recaptcha_toggle]' ),
				captchaKey	= form.find( 'input[name=recaptcha_site_key]' ).val(),
				reCaptcha 	= $( '.fl-node-'+ nodeId ).find( '.fl-grecaptcha' ),
				reCaptchaId = nodeId +'-fl-grecaptcha',
				target		= typeof event !== 'undefined' ? $(event.currentTarget) : null,
				inputEvent	= target != null && typeof target.attr('name') !== typeof undefined && target.attr('name') === 'recaptcha_site_key',
				selectEvent	= target != null && typeof target.attr('name') !== typeof undefined && target.attr('name') === 'recaptcha_toggle',
				scriptTag 	= $('<script>');

			// Add library if not exists		
			if ( 0 === $( 'script#g-recaptcha-api' ).length ) {
				scriptTag
					.attr('src', 'https://www.google.com/recaptcha/api.js?onload=onLoadFLReCaptcha&render=explicit')
					.attr('type', 'text/javascript')
					.attr('id', 'g-recaptcha-api')
					.attr('async', 'async')
					.attr('defer', 'defer')
					.appendTo('body');
			}

			if ( 'show' === toggle.val() && captchaKey.length ) {

				// reCAPTCHA is not yet exists
				if ( reCaptcha.length === 0 ) {
					this._renderReCaptcha( nodeId, reCaptchaId, captchaKey );					
				}
				// If reCAPTCHA element exists, then reset reCAPTCHA if existing key does not matched with the input value
				else if ( ( inputEvent || selectEvent ) && reCaptcha.data('sitekey') != captchaKey ) {
					reCaptcha.parent().remove();
					this._renderReCaptcha( nodeId, reCaptchaId, captchaKey );
				}
				else {
					reCaptcha.parent().show();
				}
			}
			else if ( 'show' === toggle.val() && captchaKey.length === 0 && reCaptcha.length > 0 ) {
				reCaptcha.parent().remove();
			}
			else if ( 'hide' === toggle.val() && reCaptcha.length > 0 ) {
				reCaptcha.parent().hide();
			}
		},

		/**
		 * Render Google reCAPTCHA  
		 * 
		 * @param  string nodeId  		The current node ID
		 * @param  string reCaptchaId  	The element ID to render reCAPTCHA
		 * @param  string reCaptchaKey  The reCAPTCHA Key
		 * @since 1.9.5
		 */
		_renderReCaptcha: function( nodeId, reCaptchaId, reCaptchaKey )
		{
			var captchaField	= $( '<div class="fl-input-group fl-recaptcha">' ),
				captchaElement 	= $( '<div id="'+ reCaptchaId +'" class="fl-grecaptcha">' ),
				widgetID;

			// Append recaptcha element
			captchaElement.attr('data-sitekey', reCaptchaKey);
			captchaField
				.html(captchaElement)
				.insertAfter( $('.fl-node-'+ nodeId ).find('.fl-contact-form > .fl-message') );

			// to an appended element
			widgetID = grecaptcha.render( reCaptchaId, { 
				sitekey : reCaptchaKey,
				theme	: 'light'
			});
			captchaElement.attr('data-widgetid', widgetID);
		}    
    
	});

})(jQuery);