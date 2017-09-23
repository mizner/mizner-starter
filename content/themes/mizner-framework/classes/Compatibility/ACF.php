<?php

namespace Mizner\Theme\Compatibility;

use function Mizner\Theme\check_installed_plugins_by_name;

class ACF {

	static $name = 'Advanced Custom Fields PRO';

	public function __construct() {

		if ( ! is_admin() ) {
			return;
		}

		add_action( 'admin_init', [ $this, 'init' ] );
	}

	public function init() {

		if ( class_exists( 'acf' ) ) {
			return;
		}

		$acf_is_installed = check_installed_plugins_by_name( self::$name, get_plugins() );

		if ( $acf_is_installed ) {
			add_action( 'admin_notices', [ $this, 'not_active' ] );
		} else {
			add_action( 'admin_notices', [ $this, 'not_installed' ] );
		}

	}

	public function not_installed() {
		$class       = 'notice notice-error';
		$message     = __( 'This theme requires:', 'mizner-framework' );
		$plugin_link = '//advancedcustomfields.com/pro';
		$plugin_name = __( 'Advanced Custom Fields PRO' );
		$message_end = __( 'You may need to contact your developer.', 'mizner-framework' );

		printf(
			'<div class="%1$s"><p>%2$s <a target="_blank" href="%3$s"><strong>%4$s</strong></a> %5$s</p></div>',
			esc_attr( $class ),
			esc_html( $message ),
			$plugin_link,
			esc_html( $plugin_name ),
			$message_end
		);
	}

	public function not_active() {

		$class       = 'notice notice-error';
		$message     = __( 'Please Activate:', 'mizner-framework' );
		$plugin_link = get_site_url() . '/wp-admin/plugins.php';
		$plugin_name = __( 'Advanced Custom Fields PRO' );
		$message_end = __( 'You may need to contact your developer.', 'mizner-framework' );

		printf(
			'<div class="%1$s"><p>%2$s <a href="%3$s"><strong>%4$s</strong></a> %5$s</p></div>',
			esc_attr( $class ),
			esc_html( $message ),
			$plugin_link,
			esc_html( $plugin_name ),
			$message_end
		);

	}
}