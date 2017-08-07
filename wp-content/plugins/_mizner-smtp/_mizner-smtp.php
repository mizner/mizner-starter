<?php
/**
 * Plugin Name: (Mizner) - SMTP Mailer
 * Plugin URI: http://mizner.io
 * Description:
 * Version: 1.0
 * Author: Michael Mizner
 * Author URI: http://mizner.io
 * License:
 */

namespace Mizner\SMTP;

defined( 'WPINC' ) || die;

class SMTP {

	public $postmark_api;
	public $from_email;
	public $from_name;


	public function __construct() {
		$this->settings();
		add_action( 'phpmailer_init', [ $this, 'mailer' ] );
		add_filter( 'wp_mail_content_type', [ $this, 'content_type' ] );
	}

	function settings() {
		$this->postmark_api = '92b7d8f8-d916-4603-aa83-bff967ba59e3';
		$this->from_email   = 'no-reply@knoxweb.com';
		$this->from_name    = 'Knoxweb';
	}

	function mailer( $phpmailer ) {

		$phpmailer->isSMTP();
		$phpmailer->Host     = 'smtp.postmarkapp.com';
		$phpmailer->SMTPAuth = true; // Force it to use Username and Password to authenticate
		$phpmailer->Port     = 2525;
		$phpmailer->Username = $this->postmark_api;
		$phpmailer->Password = $this->postmark_api;
		// Additional settings
		// $phpmailer->SMTPSecure = 'SSL'; // Choose SSL or TLS, if necessary for your server
		$phpmailer->From     = $this->from_email;
		$phpmailer->FromName = $this->from_name;

	}

	function content_type( $content_type ) {
		// return 'multipart/mixed';
		// return 'text/html';
		return 'text/plain';
	}
}

new SMTP();

