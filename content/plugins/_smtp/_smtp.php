<?php
/**
 * Plugin Name: (custom) SMTP Mailer
 * Plugin URI: http://mizner.io
 * Description:
 * Version: 1.0
 * Author: Michael Mizner
 * Author URI: http://mizner.io
 * License: GPL2
 *
 * @package SMTP Mailer
 * @author Mizner
 */

namespace Mizner\SMTP;

defined( 'WPINC' ) || die;

require_once 'class-smtp.php';

new SMTP();

