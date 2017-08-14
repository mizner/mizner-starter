=== Error Log Monitor ===
Contributors: whiteshadow
Tags: dashboard widget, administration, error reporting, admin, maintenance, php
Requires at least: 3.4
Tested up to: 4.7-alpha
Stable tag: 1.5

Adds a Dashboard widget that displays the latest messages from your PHP error log. It can also send logged errors to email.

== Description ==

This plugin adds a Dashboard widget that displays the latest messages from your PHP error log. It can also send you email notifications about newly logged errors.

**Features**

* Automatically detects error log location.
* Explains how to configure PHP error logging if it's not enabled yet.
* The number of displayed log entries is configurable.
* Sends you email notifications about logged errors (optional).
* Configurable email address and frequency.
* You can easily clear the log file.
* The dashboard widget is only visible to administrators.
* Optimized to work well even with very large log files.

**Usage**

Once you've installed the plugin, go to the Dashboard and enable the "PHP Error Log" widget through the "Screen Options" panel. The widget should automatically display the last 20 lines from your PHP error log. If you see an error message like "Error logging is disabled" instead, follow the displayed instructions to configure error logging.

Email notifications are disabled by default. To enable them, click the "Configure" link in the top-right corner of the widget and enter your email address in the "Periodically email logged errors to:" box. If desired, you can also change email frequency by selecting the minimum time interval between emails from the "How often to send email" drop-down.

== Installation ==

Follow these steps to install the plugin on your site: 

1. Download the .zip file to your computer.
2. Go to *Plugins -> Add New* and select the "Upload" option.
3. Upload the .zip file.
4. Activate the plugin through the *Plugins -> Installed Plugins" page.
5. Go to the Dashboard and enable the "PHP Error Log" widget through the "Screen Options" panel.
6. (Optional) Click the "Configure" link in the top-right of the widget to configure the plugin.

== Screenshots ==

1. The "PHP Error Log" widget added by the plugin. 
2. Dashboard widget configuration screen.

== Changelog ==

= 1.5 =
* Added a severity filter. For example, you could use this feature to make the plugin send notifications about fatal errors but not warnings or notices.
* Added limited support for XDebug stack traces. The stack trace will show up as part of the error message instead of as a bunch of separate entries. Also, stack trace items no longer count towards the line limit.

= 1.4.2 =
* Hotfix for a parse error that was introduced in version 1.4.1.

= 1.4.1 =
* Fixed a PHP compatibility issue that caused a parse error in Plugin.php on sites using an old version of PHP.

= 1.4 =
* Added an option to send an email notification when the log file size exceeds the specified threshold.
* Fixed a minor translation bug.
* The widget now shows the full path of the WP root directory along with setup instructions. This should make it easier to figure out the absolute path of the log file.
* Tested with WP 4.6-beta3.

= 1.3.3 =
* Added i18n support.
* Added an `elm_show_dashboard_widget` filter that lets other plugins show or hide the error log widget.
* Tested with WP 4.5.1 and WP 4.6-alpha.

= 1.3.2 =
* Tested up to WP 4.5 (release candidate).

= 1.3.1 =
* Added support for Windows and Mac style line endings.

= 1.3 =
* Added an option to display log entries in reverse order (newest to oldest).
* Added a different error message for the case when the log file exists but is not accessible.
* Only load the plugin in the admin panel and when running cron jobs.
* Fixed the error log sometimes extending outside the widget.
* Tested up to WP 4.4 (alpha version).

= 1.2.4 =
* Tested up to WP 4.2 (final release).
* Added file-based exclusive locking to prevent the plugin occasionally sending duplicate email notifications.

= 1.2.3 =
* Tested up to WP 4.2-alpha.
* Refreshing the page after clearing the log will no longer make the plugin to clear the log again.

= 1.2.2 = 
* Updated Scb Framework to the latest revision.
* Tested up to WordPress 4.0 beta.

= 1.2.1 = 
* Tested up to WordPress 3.9.

= 1.2 = 
* Tested up to WordPress 3.7.1.

= 1.1 = 
* Fixed plugin homepage URL.
* Fix: If no email address is specified, simply skip emailing the log instead of throwing an error.
* Tested with WordPress 3.4.2.

= 1.0 =
* Initial release.
