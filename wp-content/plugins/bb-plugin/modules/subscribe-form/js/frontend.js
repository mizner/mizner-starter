( function( $ ) {

	window.onLoadFLReCaptcha = function() {
		var reCaptchaFields = $( '.fl-grecaptcha' ),
			widgetID;

		if ( reCaptchaFields.length > 0 ) {
			reCaptchaFields.each(function(){
				var self 		= $( this ),
				 	attrWidget 	= self.attr('data-widgetid');

				// Avoid re-rendering as it's throwing API error
				if ( (typeof attrWidget !== typeof undefined && attrWidget !== false) ) {
					return;
				}
				else {
					widgetID = grecaptcha.render( $(this).attr('id'), { 
						sitekey : self.data( 'sitekey' ),
						theme	: 'light',
						callback: function( response ){
							if ( response != '' ) {
								self.attr( 'data-fl-grecaptcha-response', response );
							}							
						}
					});
					
					self.attr( 'data-widgetid', widgetID );					
				}							
			});
		}
	};

	FLBuilderSubscribeForm = function( settings )
	{
		this.settings	= settings;
		this.nodeClass	= '.fl-node-' + settings.id;
		this.form 		= $( this.nodeClass + ' .fl-subscribe-form' );
		this.button		= this.form.find( 'a.fl-button' );
		this._init();
	};

	FLBuilderSubscribeForm.prototype = {
	
		settings	: {},
		nodeClass	: '',
		form		: null,
		button		: null,
		
		_init: function()
		{
			this.button.on( 'click', $.proxy( this._submitForm, this ) );
			this.form.find( 'input[type="email"]' ).on( 'keypress', $.proxy( this._onEnterKey, this) );
		},
		
		_submitForm: function( e )
		{
			var postId      	= this.form.closest( '.fl-builder-content' ).data( 'post-id' ),
				templateId		= this.form.data( 'template-id' ),
				templateNodeId	= this.form.data( 'template-node-id' ),
				nodeId      	= this.form.closest( '.fl-module' ).data( 'node' ),
				buttonText  	= this.button.find( '.fl-button-text' ).text(),
				waitText    	= this.button.closest( '.fl-form-button' ).data( 'wait-text' ),
				name        	= this.form.find( 'input[name=fl-subscribe-form-name]' ),
				email       	= this.form.find( 'input[name=fl-subscribe-form-email]' ),
				recaptcha 		= this.form.find( '.fl-grecaptcha' ),
				reCaptchaValue	= recaptcha.data( 'fl-grecaptcha-response' ),
				re          	= /\S+@\S+\.\S+/,
				valid       	= true,
				ajaxData 		= null;
				
			e.preventDefault();

			if ( this.button.hasClass( 'fl-form-button-disabled' ) ) {
				return; // Already submitting
			}
			if ( name.length > 0 && name.val() == '' ) {
				name.addClass( 'fl-form-error' );
				name.siblings( '.fl-form-error-message' ).show();
				valid = false;
			}
			if ( '' == email.val() || ! re.test( email.val() ) ) {
				email.addClass( 'fl-form-error' );
				email.siblings( '.fl-form-error-message' ).show();
				valid = false;
			}

			if ( recaptcha.length > 0 ) {
				if ( 'undefined' === typeof reCaptchaValue || reCaptchaValue === false ) {
					valid = false;
					recaptcha.addClass( 'fl-form-error' );
					recaptcha.siblings( '.fl-form-error-message' ).show();
				} else {
					recaptcha.removeClass( 'fl-form-error' );
					recaptcha.siblings( '.fl-form-error-message' ).hide();
				}
			}

			if ( valid ) {
				
				this.form.find( '> .fl-form-error-message' ).hide();
				this.button.find( '.fl-button-text' ).text( waitText );
				this.button.data( 'original-text', buttonText );
				this.button.addClass( 'fl-form-button-disabled' );
				
				ajaxData = {
					action  			: 'fl_builder_subscribe_form_submit',
					name    			: name.val(),
					email   			: email.val(),
					post_id 			: postId,
					template_id 		: templateId,
					template_node_id 	: templateNodeId,
					node_id 			: nodeId
				};

				if ( reCaptchaValue ) {
					ajaxData.recaptcha = reCaptchaValue;
				}

				$.post( FLBuilderLayoutConfig.paths.wpAjaxUrl, ajaxData, $.proxy( this._submitFormComplete, this ) );
			}
		},
		
		_submitFormComplete: function( response )
		{
			var data        = JSON.parse( response ),
				buttonText  = this.button.data( 'original-text' );
				
			if ( data.error ) {
				
				if ( data.error ) {
					this.form.find( '> .fl-form-error-message' ).text( data.error );
				}
				
				this.form.find( '> .fl-form-error-message' ).show();
				this.button.removeClass( 'fl-form-button-disabled' );
				this.button.find( '.fl-button-text' ).text( buttonText );
			}
			else if ( 'message' == data.action ) {
				this.form.find( '> *' ).hide();
				this.form.append( '<div class="fl-form-success-message">' + data.message + '</div>' );
			}
			else if ( 'redirect' == data.action ) {
				window.location.href = data.url;
			}
		},

		_onEnterKey: function( e )
		{
			if (e.which == 13) {
		    	this.button.trigger( 'click' );
		  	}
		}
	}
	
})( jQuery );