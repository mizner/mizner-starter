<?php

/**
 * This is an example module with only the basic
 * setup necessary to get it working.
 *
 * @class FLPhotoBlurbModule
 */
class FLPhotoBlurbModule extends FLBuilderModule {

    /** 
     * Constructor function for the module. You must pass the
     * name, description, dir and url in an array to the parent class.
     *
     * @method __construct
     */  
    public function __construct()
    {
        parent::__construct(array(
            'name'          => __('Photo Blurb', 'fl-builder'),
            'description'   => __('An Photo Blurb.', 'fl-builder'),
            'category'		=> __('Advanced Modules', 'fl-builder'),
            'dir'           => FL_KNOXWEB_MODULE_PATH . 'photo-blurb/',
            'url'           => FL_KNOXWEB_MODULE_URL . 'photo-blurb/',
            'editor_export' => true, // Defaults to true and can be omitted.
            'enabled'       => true, // Defaults to true and can be omitted.
        ));

	    $this->add_css('example-lib', $this->url . 'css/photo-blurb.css');
    }

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLPhotoBlurbModule', array(
    'general'       => array( // Tab
        'title'         => __('General', 'fl-builder'), // Tab title
        'sections'      => array( // Tab Sections
            'general'       => array( // Section
                'title'         => __('Section Title', 'fl-builder'), // Section Title
                'fields'        => array( // Section Fields
	                'photo_blurb_heading' => array(
		                'type'          => 'text',
		                'label'         => __('Heading', 'fl-builder'),
		                'default'       => '',
		                'placeholder'   => __('', 'fl-builder'),
		                'rows'          => '6',
		                'preview'         => array(
			                'type'             => 'text',
			                'selector'         => '.fl-photo-blurb-heading'
		                )
	                ),
                    'photo_blurb_paragraph' => array(
                        'type'          => 'textarea',
                        'label'         => __('Subheading', 'fl-builder'),
                        'default'       => '',
                        'placeholder'   => __('', 'fl-builder'),
                        'rows'          => '6',
                        'preview'         => array(
                            'type'             => 'text',
                            'selector'         => '.fl-photo-blurb-paragraph'
                        )
                    ),
	                'photo_blurb_link'     => array(
		                'type'          => 'link',
		                'label'         => __('Link Field', 'fl-builder')
	                ),
	                'photo_blurb_photo_background'    => array(
		                'type'          => 'photo',
		                'label'         => __('Photo Background', 'fl-builder')
	                ),
	                'photo_blurb_overlay_color'    => array(
		                'type'          => 'color',
		                'label'         => __('Overlay Color', 'fl-builder'),
		                'default'       => '333333',
		                'show_reset'    => true,
		                'preview'         => array(
			                'type'            => 'css',
			                'selector'        => '.fl-example-text',
			                'property'        => 'color'
		                )
	                ),
	                'photo_blurb_overlay_transparency' => array(
		                'type'          => 'text',
		                'label'         => __('Overlay transparency', 'fl-builder'),
		                'default'       => '50',
		                'placeholder'   => __('', 'fl-builder'),
		                'preview'         => array(
			                'type'             => 'text',
			                'selector'         => '.fl-photo-blurb-heading'
		                )
	                ),
                )
            )
        )
    )
));