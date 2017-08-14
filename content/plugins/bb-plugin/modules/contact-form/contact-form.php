<?php

/**
 * @class FLHtmlModule
 */
class FLContactFormModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct(array(
			'name'				=> __('Contact Form', 'fl-builder'),
			'description'		=> __('A very simple contact form.', 'fl-builder'),
			'category'			=> __('Advanced Modules', 'fl-builder'),
			'editor_export'		=> false,
			'partial_refresh'	=> true
		));

		add_action('wp_ajax_fl_builder_email', array($this, 'send_mail'));
		add_action('wp_ajax_nopriv_fl_builder_email', array($this, 'send_mail'));
		add_filter('script_loader_tag', array($this, 'add_async_attribute'), 10, 2);
	}
	
	/**
	 * @method enqueue_scripts
	 */
	public function enqueue_scripts()
	{
		$settings = $this->settings;
		if ( isset($settings->recaptcha_toggle) && $settings->recaptcha_toggle == 'show' 
			&& isset($settings->recaptcha_site_key) && !empty($settings->recaptcha_site_key)
			){

			$site_lang = substr( get_locale(), 0, 2 );
			$post_id    = FLBuilderModel::get_post_id();
			
			$this->add_js(
				'g-recaptcha', 
				'https://www.google.com/recaptcha/api.js?onload=onLoadFLReCaptcha&render=explicit&hl='.$site_lang, 
				array('fl-builder-layout-'. $post_id), 
				'2.0', 
				true
			);
		}
	}

	/**
	 * @method  add_async_attribute for the enqueued `g-recaptcha` script
	 * @param string $tag    Script tag
	 * @param string $handle Registered script handle
	 */
	public function add_async_attribute($tag, $handle) {
		if ( ('g-recaptcha' !== $handle) || ('g-recaptcha' === $handle && strpos($tag, 'g-recaptcha-api') !== false ) ) {
	        return $tag;
		}

	    return str_replace( ' src', ' id="g-recaptcha-api" async="async" defer="defer" src', $tag );
	}
	
	/**
	 * @method send_mail
	 */
	public function send_mail() {	  
		 global $fl_contact_from_name, $fl_contact_from_email;

		// Get the contact form post data
		$node_id			= isset( $_POST['node_id'] ) ? sanitize_text_field( $_POST['node_id'] ) : false;
		$template_id	 	= isset( $_POST['template_id'] ) ? sanitize_text_field( $_POST['template_id'] ) : false;
		$template_node_id	  = isset( $_POST['template_node_id'] ) ? sanitize_text_field( $_POST['template_node_id'] ) : false;
		$recaptcha_response	= isset( $_POST['recaptcha_response'] ) ? $_POST['recaptcha_response'] : false;

		$subject 			= (isset($_POST['subject']) ? $_POST['subject'] : __('Contact Form Submission', 'fl-builder'));
		$mailto 			= get_option('admin_email');
		$response 			= array('error' => true, 'message' => __( 'Message failed. Please try again.', 'fl-builder' ));
		
		if ( $node_id ) {

			// Get the module settings.
			if ( $template_id ) {
				$post_id  = FLBuilderModel::get_node_template_post_id( $template_id );
				$data		= FLBuilderModel::get_layout_data( 'published', $post_id );
				$settings = $data[ $template_node_id ]->settings;
			}
			else {
				$module	  = FLBuilderModel::get_module( $node_id );
				$settings = $module->settings;
			}

			if ( isset($settings->mailto_email) && !empty($settings->mailto_email) ) {
				$mailto	  = $settings->mailto_email;
			}
			if ( isset($settings->subject_toggle) && ($settings->subject_toggle == 'hide') && isset($settings->subject_hidden) && !empty($settings->subject_hidden) ) {
				$subject   = $settings->subject_hidden;
			}

			// Validate reCAPTCHA if enabled
			if ( isset($settings->recaptcha_toggle) && $settings->recaptcha_toggle == 'show' && $recaptcha_response ) {
				if ( !empty($settings->recaptcha_secret_key) && !empty($settings->recaptcha_site_key) ) {
					if ( version_compare( phpversion(), '5.3', '>=' ) ) {
						include $module->dir . 'includes/validate-recaptcha.php';
					}
					else {
						$response['error'] = false;
					}
				}
				else {
					$response = array('error' => true, 'message' => __('Your reCAPTCHA Site or Secret Key is missing!', 'fl-builder'));
				}
			}
			else {
				$response['error'] = false;
			}

			$fl_contact_from_email = (isset($_POST['email']) ? sanitize_email($_POST['email']) : null);
			$fl_contact_from_name = (isset($_POST['name']) ? $_POST['name'] : null);
			
			add_filter('wp_mail_from', 'FLContactFormModule::mail_from');
			add_filter('wp_mail_from_name', 'FLContactFormModule::from_name');
			 
			// Build the email
			$template = "";

			if (isset($_POST['name']))  $template .= "Name: $_POST[name] \r\n";
			if (isset($_POST['email'])) $template .= "Email: $_POST[email] \r\n";
			if (isset($_POST['phone'])) $template .= "Phone: $_POST[phone] \r\n";

			$template .= __('Message', 'fl-builder') . ": \r\n" . $_POST['message'];

			// Double check the mailto email is proper and no validation error found, then send.
			if ( $mailto && $response['error'] === false ) {
				wp_mail($mailto, $subject, $template);
				$response['message'] = __('Sent!', 'fl-builder');				
			}

			wp_send_json($response);
		}
	}

	static public function mail_from($original_email_address) {
		global $fl_contact_from_email;
		return ($fl_contact_from_email != '') ? $fl_contact_from_email : $original_email_address;
	}

	static public function from_name($original_name) {
		global $fl_contact_from_name;
		return ($fl_contact_from_name != '') ? $fl_contact_from_name : $original_name;
	}
	
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLContactFormModule', array(
	'general'		 => array(
		'title'		  => __('General', 'fl-builder'),
		'sections'	  => array(
			'general'	   => array(
				'title'			=> '',
				'fields'		=> array(
					'mailto_email'		=> array(
						'type'		  => 'text',
						'label'		  => __('Send To Email', 'fl-builder'),
						'default'		  => '',
						'placeholder'	  => __('example@mail.com', 'fl-builder'),
						'help'		  => __('The contact form will send to this e-mail. Defaults to the admin email.', 'fl-builder'),
						'preview'		  => array(
							'type'		   => 'none'
						),
						'connections'   => array( 'custom_field' )
					),
					'name_toggle'	 => array(
						'type'		  => 'select',
						'label'		  => __('Name Field', 'fl-builder'),
						'default'		  => 'show',
						'options'		  => array(
							'show'	   => __('Show', 'fl-builder'),
							'hide'	   => __('Hide', 'fl-builder'),
						)
					),
					'subject_toggle'	=> array(
						'type'		  => 'select',
						'label'		  => __('Subject Field', 'fl-builder'),
						'default'		  => 'hide',
						'options'		  => array(
							'show'	   => __('Show', 'fl-builder'),
							'hide'	   => __('Hide', 'fl-builder'),
						),
						'toggle'		=> array(
							'hide'			=> array(
								'fields'		=> array( 'subject_hidden' )
							)	
						)
					),
					'subject_hidden'   => array(
						'type'		  => 'text',
						'label'		  => __('Email Subject', 'fl-builder'),
						'default'		=> 'Contact Form Submission',
						'help'			=> __('You can choose the subject of the email. Defaults to Contact Form Submission.', 'fl-builder'),
					),
					'email_toggle'	  => array(
						'type'		  => 'select',
						'label'		  => __('Email Field', 'fl-builder'),
						'default'		  => 'show',
						'options'		  => array(
							'show'	   => __('Show', 'fl-builder'),
							'hide'	   => __('Hide', 'fl-builder'),
						)
					),
					'phone_toggle'	  => array(
						'type'		  => 'select',
						'label'		  => __('Phone Field', 'fl-builder'),
						'default'		  => 'hide',
						'options'		  => array(
							'show'	   => __('Show', 'fl-builder'),
							'hide'	   => __('Hide', 'fl-builder'),
						)
					)
				)
			),
			'success'	   => array(
				'title'			=> __( 'Success', 'fl-builder' ),
				'fields'		=> array(
					'success_action' => array(
						'type'		  => 'select',
						'label'		  => __( 'Success Action', 'fl-builder' ),
						'options'		  => array(
							'none'		   => __( 'None', 'fl-builder' ),
							'show_message'  => __( 'Show Message', 'fl-builder' ),
							'redirect'	   => __( 'Redirect', 'fl-builder' )
						),
						'toggle'		  => array(
							'show_message'		=> array(
								'fields'		=> array( 'success_message' )
							),
							'redirect'	   => array(
								'fields'		=> array( 'success_url' )
							)
						),
						'preview'		  => array(
							'type'			  => 'none'	 
						)
					),
					'success_message' => array(
						'type'		  => 'editor',
						'label'		  => '',
						'media_buttons' => false,
						'rows'          => 8,
						'default'       => __( 'Thanks for your message! We’ll be in touch soon.', 'fl-builder' ),
						'preview'       => array(
							'type'             => 'none'  
						),
						'connections'   => array( 'string' )
					),
					'success_url'  => array(
						'type'          => 'link',
						'label'         => __( 'Success URL', 'fl-builder' ),
						'preview'       => array(
							'type'             => 'none'  
						),
						'connections'   => array( 'url' )
					)
				)
			)
		)
	),
	'button'		 => array(
		'title'		  => __( 'Button', 'fl-builder' ),
		'sections'	  => array(
			'btn_general'   => array(
				'title'			=> '',
				'fields'		=> array(
					'btn_text'		 => array(
						'type'		  => 'text',
						'label'		  => __( 'Button Text', 'fl-builder' ),
						'default'		  => __( 'Send', 'fl-builder' )
					),
					'btn_icon'		 => array(
						'type'		  => 'icon',
						'label'		  => __( 'Button Icon', 'fl-builder' ),
						'show_remove'	  => true
					),
					'btn_icon_position' => array(
						'type'		  => 'select',
						'label'		  => __('Icon Position', 'fl-builder'),
						'default'		  => 'after',
						'options'		  => array(
							'before'		   => __('Before Text', 'fl-builder'),
							'after'		   => __('After Text', 'fl-builder')
						)
					),
					'btn_icon_animation' => array(
						'type'		  => 'select',
						'label'		  => __('Icon Visibility', 'fl-builder'),
						'default'		  => 'disable',
						'options'		  => array(
							'disable'		=> __('Always Visible', 'fl-builder'),
							'enable'			=> __('Fade In On Hover', 'fl-builder')
						)
					)
				)
			),
			'btn_colors'		=> array(
				'title'			=> __( 'Button Colors', 'fl-builder' ),
				'fields'		=> array(
					'btn_bg_color'	 => array(
						'type'		  => 'color',
						'label'		  => __( 'Background Color', 'fl-builder' ),
						'default'		  => '',
						'show_reset'	  => true
					),
					'btn_bg_hover_color' => array(
						'type'		  => 'color',
						'label'		  => __( 'Background Hover Color', 'fl-builder' ),
						'default'		  => '',
						'show_reset'	  => true,
						'preview'		  => array(
							'type'		   => 'none'
						)
					),
					'btn_text_color' => array(
						'type'		  => 'color',
						'label'		  => __( 'Text Color', 'fl-builder' ),
						'default'		  => '',
						'show_reset'	  => true
					),
					'btn_text_hover_color' => array(
						'type'		  => 'color',
						'label'		  => __( 'Text Hover Color', 'fl-builder' ),
						'default'		  => '',
						'show_reset'	  => true,
						'preview'		  => array(
							'type'		   => 'none'
						)
					)
				)
			),
			'btn_style'	   => array(
				'title'			=> __( 'Button Style', 'fl-builder' ),
				'fields'		=> array(
					'btn_style'	 => array(
						'type'		  => 'select',
						'label'		  => __( 'Style', 'fl-builder' ),
						'default'		  => 'flat',
						'options'		  => array(
							'flat'		   => __( 'Flat', 'fl-builder' ),
							'gradient'	   => __( 'Gradient', 'fl-builder' ),
							'transparent'   => __( 'Transparent', 'fl-builder' )
						),
						'toggle'		  => array(
							'transparent'   => array(
								'fields'		=> array( 'btn_bg_opacity', 'btn_bg_hover_opacity', 'btn_border_size' )
							)
						)
					),
					'btn_border_size' => array(
						'type'		  => 'text',
						'label'		  => __( 'Border Size', 'fl-builder' ),
						'default'		  => '2',
						'description'	  => 'px',
						'maxlength'	  => '3',
						'size'		  => '5',
						'placeholder'	  => '0'
					),
					'btn_bg_opacity' => array(
						'type'		  => 'text',
						'label'		  => __( 'Background Opacity', 'fl-builder' ),
						'default'		  => '0',
						'description'	  => '%',
						'maxlength'	  => '3',
						'size'		  => '5',
						'placeholder'	  => '0'
					),
					'btn_bg_hover_opacity' => array(
						'type'		  => 'text',
						'label'		  => __('Background Hover Opacity', 'fl-builder'),
						'default'		  => '0',
						'description'	  => '%',
						'maxlength'	  => '3',
						'size'		  => '5',
						'placeholder'	  => '0'
					),
					'btn_button_transition' => array(
						'type'		  => 'select',
						'label'		  => __('Transition', 'fl-builder'),
						'default'		  => 'disable',
						'options'		  => array(
							'disable'		=> __('Disabled', 'fl-builder'),
							'enable'			=> __('Enabled', 'fl-builder')
						)
					)
				)  
			),
			'btn_structure' => array(
				'title'			=> __( 'Button Structure', 'fl-builder' ),
				'fields'		=> array(
					'btn_width'	 => array(
						'type'		  => 'select',
						'label'		  => __('Width', 'fl-builder'),
						'default'		  => 'auto',
						'options'		  => array(
							'auto'		   => _x( 'Auto', 'Width.', 'fl-builder' ),
							'full'		   => __('Full Width', 'fl-builder')
						)
					),
					'btn_align'		=> array(
						'type'		  => 'select',
						'label'		  => __('Alignment', 'fl-builder'),
						'default'		  => 'left',
						'options'		  => array(
							'left'		   => __('Left', 'fl-builder'),
							'center'		=> __('Center', 'fl-builder'),
							'right'		   => __('Right', 'fl-builder'),
						)
					),
					'btn_font_size' => array(
						'type'		  => 'text',
						'label'		  => __( 'Font Size', 'fl-builder' ),
						'default'		  => '14',
						'maxlength'	  => '3',
						'size'		  => '4',
						'description'	  => 'px'
					),
					'btn_padding'	 => array(
						'type'		  => 'text',
						'label'		  => __( 'Padding', 'fl-builder' ),
						'default'		  => '10',
						'maxlength'	  => '3',
						'size'		  => '4',
						'description'	  => 'px'
					),
					'btn_border_radius' => array(
						'type'		  => 'text',
						'label'		  => __( 'Round Corners', 'fl-builder' ),
						'default'		  => '4',
						'maxlength'	  => '3',
						'size'		  => '4',
						'description'	  => 'px'
					)
				)
			)
		)
	),
	'reCAPTCHA'	=> array(
		'title'		  => __( 'reCAPTCHA', 'fl-builder' ),
		'sections'	  => array(
			'recaptcha_general' => array(
				'title'			=> '',
				'fields'		=> array(
					'recaptcha_toggle' => array(
						'type' 			=> 'select',
						'label' 		=> 'reCAPTCHA Field',
						'default'		  => 'hide',
						'options'		  => array(
							'show'	   => __('Show', 'fl-builder'),
							'hide'	   => __('Hide', 'fl-builder'),
						),
						'help' 			=> __('If you want to show this field, please provide valid Site and Secret Keys.', 'fl-builder'),
						'preview'		  => array(
							'type'		   => 'none'
						)
					),
					'recaptcha_site_key'		=> array(
						'type'			=> 'text',
						'label' 		=> __('Site Key', 'fl-builder'),
						'default'		  => '',
						'preview'		  => array(
							'type'		   => 'none'
						)
					),
					'recaptcha_secret_key'	=> array(
						'type'			=> 'text',
						'label' 		=> __('Secret Key', 'fl-builder'),
						'default'		  => '',
						'preview'		  => array(
							'type'		   => 'none'
						)						
					)
				),
			)
		),
		'description'	  => sprintf( __( 'Please register keys for your website at the <a%s>Google Admin Console</a>.', 'fl-builder' ), ' href="https://www.google.com/recaptcha/admin" target="_blank"' ),
	)	
));
