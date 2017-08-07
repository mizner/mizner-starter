<?php

/**
 * User defined templates for the builder.
 *
 * @since 1.8
 */
final class FLBuilderUserTemplates {

	/**
	 * Initialize hooks.
	 *
	 * @since 1.8
	 * @return void
	 */
	static public function init()
	{
		/* Actions */
		add_action( 'plugins_loaded',                                  __CLASS__ . '::init_ajax' );
		add_action( 'after_setup_theme',                               __CLASS__ . '::register_user_access_settings' );
		add_action( 'init',                                            __CLASS__ . '::load_settings', 1 );
		add_action( 'wp_footer',                                       __CLASS__ . '::render_ui_js_templates' );
		add_action( 'fl_builder_ui_panel_after_modules',               __CLASS__ . '::render_ui_panel_node_templates' );
		add_action( 'fl_builder_template_selector_content',            __CLASS__ . '::render_selector_content' );

		/* Filters */
		add_filter( 'template_include',                                __CLASS__ . '::template_include', 999 );
		add_filter( 'fl_builder_has_templates',                        __CLASS__ . '::has_templates', 10, 2 );
		add_filter( 'fl_builder_template_selector_data',               __CLASS__ . '::selector_data', 999 );
		add_filter( 'fl_builder_template_selector_filter_data',        __CLASS__ . '::selector_filter_data' );
		add_filter( 'fl_builder_ui_bar_title',                         __CLASS__ . '::ui_bar_title' );
		add_filter( 'fl_builder_ui_bar_buttons',                       __CLASS__ . '::ui_bar_buttons' );
		add_filter( 'fl_builder_ui_js_config',                         __CLASS__ . '::ui_js_config' );
		add_filter( 'fl_builder_settings_form_config',                 __CLASS__ . '::settings_form_config' );
		add_filter( 'fl_builder_content_classes',                      __CLASS__ . '::content_classes' );
		add_filter( 'fl_builder_render_nodes',                         __CLASS__ . '::render_nodes' );
		add_filter( 'fl_builder_row_attributes',                       __CLASS__ . '::row_attributes', 10, 2 );
		add_filter( 'fl_builder_column_attributes',                    __CLASS__ . '::column_attributes', 10, 2 );
		add_filter( 'fl_builder_module_attributes',                    __CLASS__ . '::module_attributes', 10, 2 );
	}

	/**
	 * Initialize AJAX actions.
	 *
	 * @since 1.8
	 * @return void
	 */
	static public function init_ajax()
	{
		FLBuilderAJAX::add_action( 'render_user_template_settings',    __CLASS__ . '::render_settings' );
		FLBuilderAJAX::add_action( 'render_node_template_settings',    __CLASS__ . '::render_node_settings', array( 'node_id' ) );
		FLBuilderAJAX::add_action( 'save_user_template',               'FLBuilderModel::save_user_template', array( 'settings' ) );
		FLBuilderAJAX::add_action( 'delete_user_template',             'FLBuilderModel::delete_user_template', array( 'template_id' ) );
		FLBuilderAJAX::add_action( 'save_node_template',               'FLBuilderModel::save_node_template', array( 'node_id', 'settings' ) );
		FLBuilderAJAX::add_action( 'delete_node_template',             'FLBuilderModel::delete_node_template', array( 'template_id' ) );
	}

	/**
	 * Registers the user access settings for user templates.
	 *
	 * @since 1.10
	 * @return void
	 */
	static public function register_user_access_settings()
	{
		FLBuilderUserAccess::register_setting( 'builder_admin', array(
			'default'     => false,
			'group'       => __( 'Admin', 'fl-builder' ),
			'label'       => __( 'Builder Admin', 'fl-builder' ),
			'description' => __( 'The selected roles will be able to access the builder admin menu.', 'fl-builder' ),
			'order'       => '100'
		) );

		FLBuilderUserAccess::register_setting( 'global_node_editing', array(
			'default'     => 'all',
			'group'       => __( 'Frontend', 'fl-builder' ),
			'label'       => __( 'Global Rows and Modules Editing', 'fl-builder' ),
			'description' => __( 'The selected roles will be able to edit global rows and modules.', 'fl-builder' ),
			'order'       => '10'
		) );
	}

	/**
	 * Loads files for the template settings.
	 *
	 * @since 1.8
	 * @return void
	 */
	static public function load_settings()
	{
		require_once FL_BUILDER_USER_TEMPLATES_DIR . 'includes/user-template-settings.php';
		require_once FL_BUILDER_USER_TEMPLATES_DIR . 'includes/node-template-settings.php';
	}

	/**
	 * Trys to load page.php for editing a builder template.
	 *
	 * @since 1.0
	 * @param string $template The current template to be loaded.
	 * @return string
	 */
	static public function template_include( $template )
	{
		global $post;

		if ( 'string' == gettype( $template ) && $post && $post->post_type == 'fl-builder-template' ) {

			$page = locate_template( array( 'page.php' ) );

			if ( ! empty( $page ) ) {
				return $page;
			}
		}

		return $template;
	}

	/**
	 * Hook into the fl_builder_has_templates filter and always return true
	 * so the template selector shows even if there are no core templates
	 * or third party theme templates available.
	 *
	 * @since 1.8
	 * @param bool $has_templates
	 * @return bool
	 */
	static public function has_templates( $has_templates )
	{
		$enabled_templates = FLBuilderModel::get_enabled_templates();

		if ( 'core' == $enabled_templates )  {
			$templates = FLBuilderModel::get_template_selector_data();
			return ( count( $templates['templates'] ) > 0 );
		}
		else if ( 'user' == $enabled_templates )  {
			return true;
		}
		else if ( 'enabled' == $enabled_templates )  {
			return true;
		}
		else if ( 'disabled' == $enabled_templates )  {
			return false;
		}

		return true;
	}

	/**
	 * Disables core or third party templates if all templates are disabled
	 * or only user templates are enabled.
	 *
	 * @since 1.8
	 * @param array $data
	 * @return array
	 */
	static public function selector_data( $data )
	{
		if ( in_array( FLBuilderModel::get_enabled_templates(), array( 'user', 'disabled' ) ) )  {
			$data = array(
				'templates'   => array(),
				'categorized' => array()
			);
		}

		return $data;
	}

	/**
	 * Returns data needed for the template selector's category filter.
	 *
	 * @since 1.8
	 * @param array $data
	 * @return array
	 */
	static public function selector_filter_data( $data )
	{
		$enabled_templates = FLBuilderModel::get_enabled_templates();

		if ( 'user' == $enabled_templates )  {
			$data = array( 'yours' => __( 'Your Templates', 'fl-builder' ) );
		}
		else if ( 'enabled' == $enabled_templates )  {
			$data['yours'] = __( 'Your Templates', 'fl-builder' );
		}
		else if ( 'disabled' == $enabled_templates )  {
			$data = array();
		}

		return $data;
	}

	/**
	 * Renders user defined templates in the template selector.
	 *
	 * @since 1.8
	 * @return void
	 */
	static public function render_selector_content()
	{
		if ( in_array( FLBuilderModel::get_enabled_templates(), array( 'user', 'enabled' ) ) )  {

			$user_templates = FLBuilderModel::get_user_templates();

			require_once FL_BUILDER_USER_TEMPLATES_DIR . 'includes/template-selector.php';
		}
	}

	/**
	 * Sets the UI bar title to the current template name.
	 *
	 * @since 1.8
	 * @param string $title
	 * @return string
	 */
	static public function ui_bar_title( $title )
	{
		global $wp_the_query;

		if( FLBuilderModel::is_post_user_template() ) {
			$title = sprintf( __( 'Row/Module: %s', 'fl-builder' ), get_the_title( $wp_the_query->post->ID ) );
		}

		return $title;
	}

	/**
	 * Modifies the UI bar buttons for user templates if needed.
	 *
	 * @since 1.8
	 * @param array $buttons
	 * @return array
	 */
	static public function ui_bar_buttons( $buttons )
	{
		$is_template        = FLBuilderModel::is_post_user_template();
		$is_row_template    = FLBuilderModel::is_post_user_template( 'row' );
		$is_module_template = FLBuilderModel::is_post_user_template( 'module' );
		$enabled_templates  = FLBuilderModel::get_enabled_templates();

		if ( isset( $buttons['tools'] ) && $is_module_template ) {
			$buttons['tools']['show'] = false;
		}
		if ( isset( $buttons['templates'] ) && ( $is_row_template || $is_module_template || 'disabled' == $enabled_templates ) ) {
			$buttons['templates']['show'] = false;
		}
		if ( isset( $buttons['add-content'] ) && $is_module_template ) {
			$buttons['add-content']['show'] = false;
		}

		return $buttons;
	}

	/**
	 * Sets the JS config variables for user templates.
	 *
	 * @since 1.8
	 * @param array $config
	 * @return array
	 */
	static public function ui_js_config( $config )
	{
		return array_merge( $config, array(
			'enabledTemplates'              => FLBuilderModel::get_enabled_templates(),
			'isUserTemplate'                => FLBuilderModel::is_post_user_template() ? true : false,
			'userCanEditGlobalTemplates'    => FLBuilderUserAccess::current_user_can( 'global_node_editing' ) ? true : false,
			'userTemplateType'              => FLBuilderModel::get_user_template_type()
		) );
	}

	/**
	 * Renders the UI panel for node templates.
	 *
	 * @since 1.6.3
	 * @return void
	 */
	static public function render_ui_panel_node_templates()
	{
		if ( FLBuilderModel::node_templates_enabled() ) {

			$saved_rows    = FLBuilderModel::get_node_templates( 'row' );
			$saved_modules = FLBuilderModel::get_node_templates( 'module' );
			$node_template = FLBuilderModel::is_post_node_template();
			$can_edit      = FLBuilderUserAccess::current_user_can( 'global_node_editing' );

			// Don't show global rows for node templates.
			foreach ( $saved_rows as $key => $val ) {
				if ( $node_template && $val['global'] ) {
					unset( $saved_rows[ $key ] );
				}
			}

			// Don't show global modules for node templates.
			foreach ( $saved_modules as $key => $val ) {
				if ( $node_template && $val['global'] ) {
					unset( $saved_modules[ $key ] );
				}
			}

			include FL_BUILDER_USER_TEMPLATES_DIR . 'includes/ui-panel-node-templates.php';
		}
	}

	/**
	 * Renders the markup for the JavaScript UI templates.
	 *
	 * @since 1.8
	 * @return void
	 */
	static public function render_ui_js_templates()
	{
		if ( FLBuilderModel::is_builder_active() ) {
			include FL_BUILDER_USER_TEMPLATES_DIR . 'includes/ui-js-templates.php';
		}
	}

	/**
	 * Modifies the config of settings forms for user templates if needed.
	 *
	 * @since 1.8
	 * @param array $config
	 * @return array
	 */
	static public function settings_form_config( $config )
	{
		$is_row    = stristr( $config['class'], 'fl-builder-row-settings' );
		$is_col    = stristr( $config['class'], 'fl-builder-col-settings' );
		$is_module = stristr( $config['class'], 'fl-builder-module-settings' );

		if ( $is_row || $is_col || $is_module ) {

			$post_data = FLBuilderModel::get_post_data();
			$global    = false;

			if ( isset( $post_data['node_id'] ) ) {
				$global = FLBuilderModel::is_node_global( FLBuilderModel::get_node( $post_data['node_id'] ) );
			}
			else if ( isset( $post_data['template_id'] ) ) {
				$template_post_id = FLBuilderModel::get_node_template_post_id( $post_data['template_id'] );
				$global = ! $template_post_id ? false : FLBuilderModel::is_post_global_node_template( $template_post_id );
			}

			if ( $global ) {
				$config['badges']['global'] = _x( 'Global', 'Indicator for global node templates.', 'fl-builder' );
			}
			if ( ( $is_row || $is_module ) && ! $global && ! FLBuilderModel::is_post_node_template() && FLBuilderModel::node_templates_enabled() ) {
				$config['buttons'][] = 'save-as';
			}
		}

		return $config;
	}

	/**
	 * Renders the settings form for saving a user defined template.
	 *
	 * @since 1.0
	 * @return array
	 */
	static public function render_settings()
	{
		$defaults = FLBuilderModel::get_settings_form_defaults( 'user_template' );
		$form     = FLBuilderModel::get_settings_form( 'user_template' );

		return FLBuilder::render_settings(array(
			'class'   => 'fl-builder-user-template-settings',
			'title'   => $form['title'],
			'tabs'    => $form['tabs']
		), $defaults);
	}

	/**
	 * Renders the settings form for saving a node template.
	 *
	 * @since 1.6.3
	 * @param string $node_id The node whose template settings to load.
	 * @return array
	 */
	static public function render_node_settings( $node_id = null )
	{
		$defaults 	= FLBuilderModel::get_settings_form_defaults( 'node_template' );
		$form     	= FLBuilderModel::get_settings_form( 'node_template' );
		$node 		= FLBuilderModel::get_node( $node_id );

		return FLBuilder::render_settings(array(
			'class'   => 'fl-builder-node-template-settings',
			'attrs'   => 'data-node="'. $node->node .'"',
			'title'   => str_replace( '%s', ucwords( $node->type ), $form['title'] ),
			'tabs'    => $form['tabs']
		), $defaults);
	}

	/**
	 * Adds template classes to the builder's content classes.
	 *
	 * @since 1.8
	 * @param string $classes
	 * @return string
	 */
	static public function content_classes( $classes )
	{
		// Add template classes to the content class.
		if ( FLBuilderModel::is_post_user_template() ) {
			$classes .= ' fl-builder-template';
			$classes .= ' fl-builder-' . FLBuilderModel::get_user_template_type() . '-template';
		}

		// Add the global templates locked class.
		if ( ! FLBuilderUserAccess::current_user_can( 'global_node_editing' ) ) {
			$classes .= ' fl-builder-global-templates-locked';
		}

		return $classes;
	}

	/**
	 * Short circuits node rendering and renders modules if this
	 * is a module template.
	 *
	 * @since 1.8
	 * @param bool $render
	 * @return bool
	 */
	static public function render_nodes( $render )
	{
		if ( FLBuilderModel::is_post_user_template( 'module' ) ) {
			FLBuilder::render_modules();
			return false;
		}

		return $render;
	}

	/**
	 * Adds template specific attributes for rows.
	 *
	 * @since 1.8
	 * @param array $attrs
	 * @param object $row
	 * @return array
	 */
	static public function row_attributes( $attrs, $row )
	{
		$global = FLBuilderModel::is_node_global( $row );
		$active = FLBuilderModel::is_builder_active();

		if ( $global && $active ) {
			$attrs['class'][] = 'fl-node-global';
		}
		if ( $global && $active ) {
			$attrs['data-template'] = $row->template_id;
			$attrs['data-template-node'] = $row->template_node_id;
			$attrs['data-template-url'] = FLBuilderModel::get_node_template_edit_url( $row->template_id );
		}

		return $attrs;
	}

	/**
	 * Adds template specific attributes for columns.
	 *
	 * @since 1.8
	 * @param array $attrs
	 * @param object $col
	 * @return array
	 */
	static public function column_attributes( $attrs, $col )
	{
		$global = FLBuilderModel::is_node_global( $col );
		$active = FLBuilderModel::is_builder_active();

		if ( $global && $active ) {
			$attrs['class'][] = 'fl-node-global';
		}
		if ( $global && $active ) {
			$attrs['data-template'] = $col->template_id;
			$attrs['data-template-node'] = $col->template_node_id;
		}

		return $attrs;
	}

	/**
	 * Adds template specific attributes for modules.
	 *
	 * @since 1.8
	 * @param array $attrs
	 * @param object $module
	 * @return array
	 */
	static public function module_attributes( $attrs, $module )
	{
		$global = FLBuilderModel::is_node_global( $module );
		$active = FLBuilderModel::is_builder_active();

		if ( $global && $active ) {
			$attrs['class'][] = 'fl-node-global';
		}
		if ( $global && $active ) {
			$attrs['data-template'] = $module->template_id;
			$attrs['data-template-node'] = $module->template_node_id;
		}

		return $attrs;
	}
}

FLBuilderUserTemplates::init();
