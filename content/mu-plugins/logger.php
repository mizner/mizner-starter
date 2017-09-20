<?php
/**
 * Plugin Name: Logger
 * Plugin URI: http://mizner.io
 * Description:
 * Version: 1.0
 * Author: Michael Mizner
 * Author URI: http://mizner.io
 * License: GPL
 */

function _log( $message ) {
	if ( true === WP_DEBUG ) {
		error_log( '----------------------------------' );
		foreach ( func_get_args() as $arg ) {
			if ( is_array( $arg ) || is_object( $arg ) ) {
				error_log( print_r( $arg, true ) );
			} else {
				error_log( $arg );
			}
		}
		error_log( '----------------------------------' );
	}
}
