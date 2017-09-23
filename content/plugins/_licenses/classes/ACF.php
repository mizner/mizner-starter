<?php

namespace Mizner\Licenses;

class ACF {

	private static $key = 'b3JkZXJfaWQ9Njc3Mjd8dHlwZT1kZXZlbG9wZXJ8ZGF0ZT0yMDE1LTEwLTMwIDA2OjE4OjQz';

	public function __construct() {

		if ( ! is_admin() ) {
			return;
		}

		add_action( 'wp_loaded', [ $this, 'update_key' ] );
	}

	public function update_key() {

		$key = get_option( 'acf_pro_license' );

		if ( $key ) {
			return;
		}

		self::acf_pro_update_license( self::$key );

	}

	public function acf_pro_update_license( $key = '' ) {

		// vars
		$value = '';

		// key
		if ( $key ) {

			// vars
			$data = [
				'key' => $key,
				'url' => home_url(),
			];


			// encode
			$value = base64_encode( maybe_serialize( $data ) );

		}


		// re-register update (key has changed)
		acf_register_plugin_update( [
			'id'       => 'pro',
			'key'      => $key,
			'slug'     => acf_get_setting( 'slug' ),
			'basename' => acf_get_setting( 'basename' ),
			'version'  => acf_get_setting( 'version' ),
		] );


		// update
		return update_option( 'acf_pro_license', $value );

	}
}