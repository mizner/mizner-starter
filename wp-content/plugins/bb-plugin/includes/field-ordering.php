<?php

// Make sure we have an options array.
if ( empty( $field['options'] ) ) {
	$field['options'] = array();
}

// Set the default value if we don't have one.
if ( empty( $value ) ) {
	$value = array_keys( $field['options'] );
}

// Make sure any new options are added to the value.
foreach ( $field['options'] as $key => $label ) {
	if ( ! in_array( $key, $value) ) {
		$value[] = $key;
	}
}
	
?>
<div class="fl-ordering-field-options<?php if ( isset( $field['class'] ) ) echo ' '. $field['class']; ?>">
	<?php foreach ( $value as $key ) : ?>
	<div class="fl-ordering-field-option" data-key="<?php echo $key; ?>"><?php echo $field['options'][ $key ]; ?><i class="fa fa-arrows"></i> </div>
	<?php endforeach; ?>
</div>
<input type="hidden" name="<?php echo $name; ?>" value='<?php echo json_encode( $value ); ?>' />