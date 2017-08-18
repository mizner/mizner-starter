<?php

namespace Mizner\Theme;

use Mizner\Theme as Core;
use function Mizner\Theme\in_array_r as in_array_r;

class ACF {

	public function init() {

		if ( ! function_exists( 'the_field' ) && is_admin() ) {

			add_action( 'admin_notices', [ $this, 'admin_notice' ] );

			return;
		}

	}

	public function admin_notice() {

		if ( in_array_r( 'Advanced Custom Fields PRO', get_plugins() ) ) {
			$this->not_active();
		} else {
			$this->not_installed();
		}
	}

	public function not_installed() {
		$class       = 'notice notice-error';
		$message     = __( 'This theme requires:', Core\TEXTDOMAIN );
		$plugin_link = '//advancedcustomfields.com/pro';
		$plugin_name = __( 'Advanced Custom Fields PRO' );
		$message_end = __( 'You may need to contact your developer.', Core\TEXTDOMAIN );

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
		$message     = __( 'Please Activate:', Core\TEXTDOMAIN );
		$plugin_link = get_site_url() . '/wp-admin/plugins.php';
		$plugin_name = __( 'Advanced Custom Fields PRO' );
		$message_end = __( 'You may need to contact your developer.', Core\TEXTDOMAIN );

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