<?php
class Elm_Plugin {
	const MB_IN_BYTES = 1048576; //= 1024 * 1024

	/**
	 * @var scbOptions $settings Plugin settings.
	 */
	private $settings;
	private $emailCronJob = null;
	private $pluginFile = '';

	/**
	 * @var scbCron
	 */
	private $sizeNotificationCronJob = null;

	public function __construct($pluginFile) {
		$this->pluginFile = $pluginFile;

		$this->settings = new scbOptions(
			'ws_error_log_monitor_settings',
			$pluginFile,
			array(
				'widget_line_count' => 20,
				'strip_wordpress_path' => false,
				'send_errors_to_email' => '',
				'email_line_count' => 100,
				'email_interval' => 3600, //seconds
				'email_last_line_timestamp' => 0,
				'timestamp_format' => 'M d, H:i:s',
				'sort_order' => 'chronological',
				'extra_filter_line_count' => 1000,

				'enable_log_size_notification' => false,
				'log_size_notification_threshold' => self::MB_IN_BYTES, //bytes
				'log_size_check_interval' => 3600, //seconds,
				'log_size_notification_sent' => false,

				'dashboard_message_filter' => 'all',
				'dashboard_message_filter_groups' => Elm_SeverityFilter::getAvailableOptions(),
				'email_message_filter' => 'same_as_dashboard',
				'email_message_filter_groups' => Elm_SeverityFilter::getAvailableOptions(),
			)
		);

		if ( did_action('plugins_loaded') > 0 ) {
			$this->loadTextDomain();
		} else {
			add_action('plugins_loaded', array($this, 'loadTextDomain'));
		}

		Elm_DashboardWidget::getInstance($this->settings, $this);
		add_action('elm_settings_changed', array($this, 'updateEmailSchedule'));

		$this->emailCronJob = new scbCron(
			$pluginFile,
			array(
				'interval' => $this->settings->get('email_interval'),
				'callback' => array($this, 'emailErrors'),
			)
		);

		$this->sizeNotificationCronJob = new scbCron(
			$pluginFile,
			array(
				'interval' => $this->settings->get('log_size_check_interval'),
				'callback' => array($this, 'checkLogFileSize')
			)
		);
	}

	public function loadTextDomain() {
		load_plugin_textdomain('error-log-monitor', false, basename(dirname($this->pluginFile)));
	}

	/**
	 * @param scbOptions $newSettings
	 */
	public function updateEmailSchedule($newSettings) {
		if ( $newSettings->get('send_errors_to_email') == '' ) {
			$this->emailCronJob->unschedule();
		} else {
			$this->emailCronJob->reschedule(array('interval' => $newSettings->get('email_interval')));
		}

		if ( !$newSettings->get('enable_log_size_notification') ) {
			$this->sizeNotificationCronJob->unschedule();
		} else {
			$this->sizeNotificationCronJob->reschedule(array('interval' => $newSettings->get('log_size_check_interval')));
		}
	}

	public function emailErrors() {
		if ( $this->settings->get('send_errors_to_email') == '' ) {
			//Can't send errors to email if no email address is specified.
			return;
		}

		$lock = new Elm_ExclusiveLock('elm-email-errors');
		$lock->acquire();
		//Note: Locking failures are intentionally ignored. Most of them are likely to be caused by file permissions,
		//which are either intentional (making "/wp-content/uploads" non-writable) or not easily fixed by the user.
		//It's better to occasionally send multiple email notifications than to never send any.

		$log = Elm_PhpErrorLog::autodetect();
		if ( is_wp_error($log) ) {
			trigger_error('Error log not detected', E_USER_WARNING);
			$lock->release();
			return;
		}

		$filteredLog = $this->getEmailEntries($log);

		if ( is_wp_error($filteredLog) ) {
			trigger_error('Error log is not accessible', E_USER_WARNING);
			$lock->release();
			return;
		}

		$lines = $filteredLog->readLastEntries($this->settings->get('email_line_count'));

		//Only include messages logged since the previous email.
		$logEntries = array();
		$foundNewMessages = false;

		$lastEmailTimestamp = $this->settings->get('email_last_line_timestamp');
		$lastEntryTimestamp = time(); //Fall-back value in case none of the new entries have a timestamp.

		foreach($lines as $line) {
			$foundNewMessages = $foundNewMessages || ($line['timestamp'] > $lastEmailTimestamp);
			if ( $foundNewMessages ) {
				$logEntries[] = $line;
			}
			if ( !empty($line['timestamp']) ) {
				$lastEntryTimestamp = $line['timestamp'];
			}
		}

		if ( !empty($logEntries) ) {
			$subject = sprintf(
				__('PHP errors logged on %s', 'error-log-monitor'),
				site_url()
			);
			$body = sprintf(
				/* translators: 1: Site URL, 2: Number of log entries, 3: Log file name */
				__("New PHP errors have been logged on %1\$s\nHere are the last %2\$d entries from %3\$s:\n\n", 'error-log-monitor'),
				site_url(),
				count($logEntries),
				$log->getFilename()
			);

			if ($this->settings->get('sort_order') === 'reverse-chronological') {
				$logEntries = array_reverse($logEntries);
			}

			$stripWordPressPath = $this->settings->get('strip_wordpress_path');
			foreach($logEntries as $logEntry) {
				if ( $stripWordPressPath ) {
					$logEntry['message'] = $this->stripWpPath($logEntry['message']);
				}
				if ( !empty($logEntry['timestamp']) ) {
					$body .= '[' . $this->formatTimestamp($logEntry['timestamp']). '] ';
				}
				$body .= $logEntry['message'] . "\n";

				//Include the stack trace. Note how this doesn't count towards the line limit.
				if ( !empty($logEntry['stacktrace']) ) {
					foreach($logEntry['stacktrace'] as $traceItem) {
						$body .= "\t" . $traceItem . "\n";
					}
				}
			}

			if ( $filteredLog->getSkippedEntryCount() > 0 ) {
				$body .= "\n\n" . $filteredLog->formatSkippedEntryCount() . "\n\n";
			}

			if ( wp_mail($this->settings->get('send_errors_to_email'), $subject, $body) ) {
				$this->settings->set('email_last_line_timestamp', $lastEntryTimestamp);
			} else{
				trigger_error('Failed to send an email, wp_mail() returned FALSE', E_USER_WARNING);
			}
		}

		$lock->release();
	}

	/**
	 * @param Elm_PhpErrorLog $log
	 * @return Elm_SeverityFilter|WP_Error
	 */
	public function getWidgetEntries(Elm_PhpErrorLog $log) {
		return $this->getFilteredEntries(
			$log,
			$this->getIncludedGroupsForDashboard(),
			$this->settings->get('widget_line_count')
		);
	}

	/**
	 * @param Elm_PhpErrorLog $log
	 * @return Elm_SeverityFilter|WP_Error
	 */
	private function getEmailEntries(Elm_PhpErrorLog $log) {
		return $this->getFilteredEntries(
			$log,
			$this->getIncludedGroupsForEmail(),
			$this->settings->get('email_line_count')
		);
	}

	/**
	 * Get a filtering iterator over log entries.
	 *
	 * @param Elm_PhpErrorLog $log
	 * @param array $includedGroups
	 * @param int $desiredEntryCount
	 * @return Elm_SeverityFilter|WP_Error
	 */
	private function getFilteredEntries(Elm_PhpErrorLog $log, $includedGroups, $desiredEntryCount) {
		$maxLinesToRead = $desiredEntryCount + $this->settings->get('extra_filter_line_count');

		$logIterator = $log->getIterator($maxLinesToRead);
		if ( is_wp_error($logIterator) ) {
			return $logIterator;
		}

		$filteredLog = new Elm_SeverityFilter($logIterator, $includedGroups);
		return $filteredLog;
	}

	private function getIncludedGroupsForDashboard() {
		if ( $this->settings->get('dashboard_message_filter') === 'all' ) {
			return Elm_SeverityFilter::getAvailableOptions();
		} else {
			return $this->settings->get('dashboard_message_filter_groups');
		}
	}

	private function getIncludedGroupsForEmail() {
		if ( $this->settings->get('email_message_filter') === 'same_as_dashboard' ) {
			return $this->getIncludedGroupsForDashboard();
		} else {
			return $this->settings->get('email_message_filter_groups');
		}
	}

	public function stripWpPath($string) {
		return str_replace(rtrim(ABSPATH, '/\\'), '', $string);
	}

	public function formatTimestamp($timestamp) {
		return gmdate($this->settings->get('timestamp_format'), $timestamp);
	}

	public function checkLogFileSize() {
		if ( !$this->settings->get('enable_log_size_notification') ) {
			return;
		}

		$log = Elm_PhpErrorLog::autodetect();
		if ( is_wp_error($log) ) {
			return;
		}

		$lock = new Elm_ExclusiveLock('elm-email-errors');
		$lock->acquire();

		//Don't send multiple notifications about log size.
		if ( $this->settings->get('log_size_notification_sent') ) {
			return;
		}

		if ( $log->getFileSize() >= $this->settings->get('log_size_notification_threshold') ) {
			$subject = sprintf(
				/* translators: 1: File size limit, 2: Site URL */
				__('PHP error log file size has exceeded %1$s on %2$s', 'error-log-monitor'),
				self::formatByteCount($this->settings->get('log_size_notification_threshold'), 0),
				site_url()
			);
			$body = sprintf(
				/* translators: 1: Site URL, 2: Log file name, 3: Log file size */
				__("Site URL: %1\$s\nLog file: %2\$s\nSize: %3\$s\n", 'error-log-monitor'),
				site_url(),
				$log->getFilename(),
				self::formatByteCount($log->getFileSize())
			);

			if ( wp_mail($this->settings->get('send_errors_to_email'), $subject, $body) ) {
				$this->settings->set('log_size_notification_sent', true);
			} else{
				trigger_error('Failed to send an email, wp_mail() returned FALSE', E_USER_WARNING);
			}
		}

		$lock->release();
	}

	/**
	 * Convert an amount of data in bytes to a more human-readable format like KiB or MiB.
	 *
	 * @link http://www.php.net/manual/en/function.filesize.php#91477
	 * @param int $bytes
	 * @param int $precision
	 * @return string
	 */
	public static function formatByteCount($bytes, $precision = 2) {
		$units = array('bytes', 'KiB', 'MiB', 'GiB', 'TiB'); //SI units.

		$bytes = max($bytes, 0);
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);

		$size = $bytes / pow(1024, $pow);

		return round($size, $precision) . ' ' . $units[$pow];
	}

	public function getPluginFile() {
		return $this->pluginFile;
	}
}