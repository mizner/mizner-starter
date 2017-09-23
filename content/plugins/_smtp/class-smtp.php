<?php

namespace Mizner\SMTP;

/**
 * Class SMTP
 */
class SMTP {

	/**
	 * Postmark API Key
	 */
	public $postmark_api;
	/**
	 * From Email
	 */
	public $from_email;
	/**
	 * From Name
	 */
	public $from_name;

	/**
	 * SMTP constructor.
	 */
	public function __construct() {
		$this->settings();
		add_action( 'phpmailer_init', [ $this, 'mailer' ] );
		add_filter( 'wp_mail_content_type', [ $this, 'content_type' ] );
	}

	/**
	 * Settings
	 */
	function settings() {
		$this->postmark_api = '92b7d8f8-d916-4603-aa83-bff967ba59e3';
		$this->from_email   = 'no-reply@knoxweb.com';
		$this->from_name    = 'Knoxweb';
	}

	/**
	 * PHP Mailer
	 */
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

	/**
	 * Content Type.
	 * Consider using 'multipart/mixed' or 'text/html' in return statement.
	 */
	function content_type( $content_type ) {
		return 'text/plain';
	}
}