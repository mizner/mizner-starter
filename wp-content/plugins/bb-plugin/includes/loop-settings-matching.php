<select name="<?php echo $name ?>_matching">
	<option value="1" <?php selected( $settings->{ $name . '_matching' }, '1' ); ?>><?php printf( _x( 'Match these %s', '%s is an object like posts or taxonomies.', 'fl-builder' ), $field['label'] ); ?></option>
	<option value="0" <?php selected( $settings->{ $name . '_matching' }, '0' ); ?>><?php printf( _x( 'Do not match these %s', '%s is an object like posts or taxonomies.', 'fl-builder' ), $field['label'] ); ?></option>
</select>