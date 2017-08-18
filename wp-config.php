<?php

/**
 * This uses config.json for environment variables
 *
 * @param string $json
 *
 * @return array|mixed|object|string
 */
function get_config( $json = '/config.json' ) {
	$raw  = file_get_contents( __DIR__ . $json );
	$json = json_decode( $raw );

	return $json;
}

$config = get_config();

/**
 * WP CLI Support
 * 1. DB_HOST: Doesn't like `$_SERVER['HTTP_HOST']` so we have to use a static URL.
 * 2. HTTP_HOST: To run WP CLI locally without having to SSH, we can statically define.
 * https://github.com/timber/timber/issues/215/#issuecomment-42204328
 * http://local.getflywheel.com/community/t/wp-cli-question/97/7
 */

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	define( 'DB_HOST', $config->DevHost . ':' . $config->DevPort );
	define( 'HTTP_HOST', $config->DevSite );
} else {
	define( 'DB_HOST', 'localhost' );
	define( 'HTTP_HOST', $_SERVER['HTTP_HOST'] );
}

define( 'DB_NAME', 'local' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'root' );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

define( 'AUTH_KEY', 'fqj6PAFQKKOol3qKDsOHL1wJc2J82shlk55R2QcyAF23BODbVWKG5bX2pQUppBJX4F4H6J9ILAY2r9jP46DyBw==' );
define( 'SECURE_AUTH_KEY', 'snNx7J8CrUWIf5iveKqwvBg99YqtM24rmoOnPNZNMoUxex2ZqFSqwR5YAkNsFkFANpgrYf8DLHo8alMShz99dQ==' );
define( 'LOGGED_IN_KEY', 'cqjEIBzW35pVcPaWpUptsH5ZWGcOvNNehcUMKAeL/QAD8CFNOKbjjVGL1onl/nTATixKprddUz3LKv03CDq7wg==' );
define( 'NONCE_KEY', 'm0XGnm+L7OBUfsSkr/TF2TpKdh2G0Rb3vSEKCeA0E+ce52CehI1LpF9yx0dijZc4DmQ7shD5x9wY4gmFqmw2Hg==' );
define( 'AUTH_SALT', 'GCiqAO7e8tqiFqkTp0yqv9Ax3B2BgkRRYnt1s8Hh9Ohl7EHpegK8nyyDW/wU2X8QSXNfKxWb8NI3cqXPSppIwg==' );
define( 'SECURE_AUTH_SALT', 'y4I20/KSEZi+3ZhHCZysifFBqizCdDPpLnrKRNdoTiA7P+OKcsyEsqSTtvnqSbzqx8CQxj6oE/Wny/5lNWUPLw==' );
define( 'LOGGED_IN_SALT', 'UqSMwYNb1hqEOg8hRHQVGIL0Rf5/F6NRJKrvZ3o+eImKhhD+CAUoqLMkoumwPIUR1Dc/BWLvzOPf7mKFcJ3X4w==' );
define( 'NONCE_SALT', 'CW0fCZoCMMjNHRXYx/8yso1b1T+DbuKYrMN8Iq2GhmhC8D/hzn5bgejrs6O02cGd4uedn0h3hVcchYFxtx9ozA==' );

$table_prefix = 'wp_';

define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'JETPACK_DEV_DEBUG', true );

function _log( $message ) {
	if ( WP_DEBUG === true ) {
		error_log( "*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*" );
		foreach ( func_get_args() as $arg ) {
			if ( is_array( $arg ) || is_object( $arg ) ) {
				error_log( print_r( $arg, true ) );
			} else {
				error_log( $arg );
			}
		}
		error_log( "*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*" );
	}
}


// Define Site URL: WordPress in a subdirectory.
defined( 'WP_SITEURL' ) or define( 'WP_SITEURL', 'http://' . HTTP_HOST . '/wordpress' );
defined( 'WP_HOME' ) or define( 'WP_HOME', 'http://' . HTTP_HOST );

// Define path and url for wp-content
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/content' );
define( 'WP_CONTENT_URL', WP_HOME . '/content' );

// Define path and url for must use plugins.
define( 'WPMU_PLUGIN_DIR', dirname( __FILE__ ) . '/content/mu-plugins' );
define( 'WPMU_PLUGIN_URL', WP_HOME . '/content/mu-plugins' );

// Define the default theme.
define( 'WP_DEFAULT_THEME', $config->DefaultTheme );

/* Inserted by Local by Flywheel. See: http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy */
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
	$_SERVER['HTTPS'] = 'on';
}
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';


if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
	ini_set( 'error_log', __DIR__ . '/logs/wp-error.log' );
}
