<?php 
	global $wp_locale;

	// set defaults
	$layout = isset( $settings->layout ) ? $settings->layout : 'default';
	$type   = isset( $settings->number_type ) ? $settings->number_type : 'percent';
	$speed  = !empty( $settings->animation_speed ) && is_numeric( $settings->animation_speed ) ? $settings->animation_speed * 1000 : 1000;
	$number = !empty( $settings->number ) && is_numeric( $settings->number ) ? $settings->number : 100;
	$max    = !empty( $settings->max_number ) && is_numeric( $settings->max_number ) ? $settings->max_number : $number;
	$delay  = !empty( $settings->delay ) && is_numeric( $settings->delay ) && $settings->delay > 0 ? $settings->delay : 0;
	$format_decimal 	= '.';
	$format_thousands 	= ',';

	// Checking for i18n number format
	if ( $wp_locale ) {
	$i18n_decimal = str_replace(array(' ', '&nbsp;'), '', $wp_locale->number_format['decimal_point']);
	$i18n_thousand = str_replace(array(' ', '&nbsp;'), '', $wp_locale->number_format['thousands_sep']);
	if ( !empty( $i18n_decimal ) ) {
		$format_decimal = $i18n_decimal;
		}

	if ( !empty( $i18n_thousand ) ) {
		$format_thousands = $i18n_thousand;
		}
	}

 ?>

(function($) {

	$(function() {

	    new FLBuilderNumber({
	    	id: '<?php echo $id ?>',
	    	layout: '<?php echo $layout ?>',
	    	type: '<?php echo $type ?>',
	    	number: <?php echo $number ?>,
	    	max: <?php echo $max ?>,
	    	speed: <?php echo $speed ?>,
	    	delay: <?php echo $delay ?>,
	    	format: { decimal: '<?php echo $format_decimal ?>', thousands_sep: '<?php echo $format_thousands ?>' }
	    });

	});

})(jQuery);