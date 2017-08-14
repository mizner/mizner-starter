( function( $ ) {

	FLBuilder.registerModuleHelper( 'subscribe-form', {

		rules: {
			btn_text: {
				required: true
			},
			btn_font_size: {
				required: true,
				number: true
			},
			btn_padding: {
				required: true,
				number: true
			},
			btn_border_radius: {
				required: true,
				number: true
			},
			service: {
				required: true
			}
		},
		
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
			$( 'select[name=show_recaptcha]' ).on( 'change', $.proxy( this._toggleReCaptcha, this ) );
			$( 'input[name=recaptcha_site_key]' ).on( 'change', $.proxy( this._toggleReCaptcha, this ) );

			// Render reCAPTCHA after layout rendered via AJAX
			if ( window.onLoadFLReCaptcha ) {
				$( FLBuilder._contentClass ).on( 'fl-builder.layout-rendered', onLoadFLReCaptcha );
			}
		},
		
		submit: function()
		{
			var form       = $( '.fl-builder-settings' ),
				service    = form.find( '.fl-builder-service-select' ),
				serviceVal = service.val(),
				account    = form.find( '.fl-builder-service-account-select' ),
				list       = form.find( '.fl-builder-service-list-select' );
				
			if ( 0 === account.length ) {
				FLBuilder.alert( FLBuilderStrings.subscriptionModuleConnectError );
				return false;
			}
			else if ( '' == account.val() || 'add_new_account' == account.val() ) {
				FLBuilder.alert( FLBuilderStrings.subscriptionModuleAccountError );
				return false;
			}
			else if ( ( 0 === list.length || '' == list.val() ) && 'email-address' != serviceVal && 'sendy' != serviceVal ) {
				
				if ( 'drip' == serviceVal || 'hatchbuck' == serviceVal ) {
					FLBuilder.alert( FLBuilderStrings.subscriptionModuleTagsError );	
				}
				else {
					FLBuilder.alert( FLBuilderStrings.subscriptionModuleListError );
				}
				
				return false;
			}
			
			return true;
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
				toggle    	= form.find( 'select[name=show_recaptcha]' ),
				captchaKey	= form.find( 'input[name=recaptcha_site_key]' ).val(),
				reCaptcha 	= $( '.fl-node-'+ nodeId ).find( '.fl-grecaptcha' ),
				reCaptchaId = nodeId +'-fl-grecaptcha',
				target		= typeof event !== 'undefined' ? $(event.currentTarget) : null,
				inputEvent	= target != null && typeof target.attr('name') !== typeof undefined && target.attr('name') === 'recaptcha_site_key',
				selectEvent	= target != null && typeof target.attr('name') !== typeof undefined && target.attr('name') === 'show_recaptcha',
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
				if ( 0 === reCaptcha.length ) {
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
			else if ( 'show' === toggle.val() && 0 === captchaKey.length && reCaptcha.length > 0 ) {
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
			var captchaField	= $( '<div class="fl-form-field fl-form-recaptcha">' ),
				captchaElement 	= $( '<div id="'+ reCaptchaId +'" class="fl-grecaptcha">' ),
				form 			= $( '.fl-node-'+ nodeId ).find( '.fl-subscribe-form' ),
				widgetID;

			// Append recaptcha element
			captchaElement.attr('data-sitekey', reCaptchaKey);
			captchaField.html(captchaElement);

			if ( form.hasClass('fl-subscribe-form-stacked') ) {
				captchaField.insertBefore( form.find('.fl-form-button') );
			}
			else if ( form.hasClass('fl-subscribe-form-inline') ) {
				captchaField.insertAfter( form.find('.fl-form-button') );
			}

			// to an appended element
			widgetID = grecaptcha.render( reCaptchaId, { 
				sitekey : reCaptchaKey,
				theme	: 'light'
			});
			captchaElement.attr('data-widgetid', widgetID);
		}
	});

})(jQuery);