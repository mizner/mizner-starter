<div class="fl-widget">
<?php

// Get builder post data.
$post_data = FLBuilderModel::get_post_data();

// Widget class
if(isset($settings->widget)) {
	$widget_class = $settings->widget;
}
else if(isset($post_data['widget']) && FLBuilderModel::is_builder_active()) {
	$widget_class = $post_data['widget'];
}

if(isset($widget_class) && class_exists($widget_class)) {

	// Widget instance
	$widget_instance    = new $widget_class();

	// Widget settings
	$settings_key       = 'widget-' . $widget_instance->id_base;
	$widget_settings    = isset($settings->$settings_key) ? (array)$settings->$settings_key : array();

	// Render the widget
	the_widget($widget_class, $widget_settings, array('widget_id' => 'fl_builder_widget_' . $module->node));
}
else if(isset($widget_class) && FLBuilderModel::is_builder_active()) {

	// Widget doesn't exist!
	printf( _x( '%s no longer exists.', '%s stands for widget slug.', 'fl-builder' ), $widget_class );

}

?>
</div>