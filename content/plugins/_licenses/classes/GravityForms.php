<?php

namespace Mizner\Licenses;

class GravityForms {

	/**
	 * @var string
	 */
	static $license_key = '2e42d97eb7491081a04b20a70f3bc4ea';

	/**
	 * GravityForms constructor.
	 */
	public function __construct() {
		if ( ! is_admin() ) {
			return;
		}
		self::save_key( self::$license_key );
	}

	/**
	 * Update Key
	 */
	public static function save_key( $new_key ) {

		define( 'GF_LICENSE_KEY', self::$license_key );

	}
}