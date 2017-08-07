jQuery(function($) {
	var widget = $('#ws_php_error_log'),

		dashboardNoFilterOption = widget.find('#elm_dashboard_message_filter_all'),
		dashboardCustomFilterOption = widget.find('#elm_dashboard_message_filter_selected'),

		emailMatchFilterOption = widget.find('#elm_email_message_filter_same'),
		emailCustomFilterOption = widget.find('#elm_email_message_filter_selected'),

		dashboardFilterOptions = widget.find('input[name^="ws_php_error_log[dashboard_severity_option-"]'),
		emailFilterOptions = widget.find('input[name^="ws_php_error_log[email_severity_option-"]');

	function updateDashboardOptions() {
		dashboardFilterOptions.prop('disabled', !dashboardCustomFilterOption.is(':checked'))
	}
	function updateEmailOptions() {
		emailFilterOptions.prop('disabled', !emailCustomFilterOption.is(':checked'));
	}

	//First enable/disable the checkboxes when the page loads.
	updateDashboardOptions();
	updateEmailOptions();

	//Then refresh them when the user changes filter settings.
	dashboardCustomFilterOption.add(dashboardNoFilterOption).on('change', function() {
		updateDashboardOptions();
	});
	emailCustomFilterOption.add(emailMatchFilterOption).on('change', function() {
		updateEmailOptions();
	});
});
