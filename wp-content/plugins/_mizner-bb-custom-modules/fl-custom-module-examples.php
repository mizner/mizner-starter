<?php
/**
 * Plugin Name: Beaver Builder Custom Modules
 * Plugin URI: http://www.wpbeaverbuilder.com
 * Description: Knoxweb's custom builder modules.
 * Version: 1.0
 * Author: The Beaver Builder Team
 * Author URI: http://www.wpbeaverbuilder.com
 */
define( 'FL_KNOXWEB_MODULE_PATH', plugin_dir_path( __FILE__ ) );
define( 'FL_KNOXWEB_MODULE_URL', plugins_url( '/', __FILE__ ) );

/**
 * Custom modules
 */
add_action( 'init', 'fl_load_module_examples' );
function fl_load_module_examples() {
	if ( class_exists( 'FLBuilder' ) ) {
	    require_once 'photo-blurb/photo-blurb.php';
	}
}

/**
 * Custom field styles and scripts
 */
function fl_my_custom_field_assets() {
    if ( class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_active() ) {
        wp_enqueue_style( 'my-custom-fields', FL_KNOXWEB_MODULE_URL . 'assets/css/fields.css', array(), '' );
        wp_enqueue_script( 'my-custom-fields', FL_KNOXWEB_MODULE_URL . 'assets/js/fields.js', array(), '', true );
    }
}
add_action( 'wp_enqueue_scripts', 'fl_my_custom_field_assets' );