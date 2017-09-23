<?php
add_action( 'admin_head', 'client_profile_subject_start' );
add_action( 'admin_footer', 'client_profile_subject_end' );
if ( ! function_exists( 'client_remove_personal_options' ) ) {
	/**
	 * Removes the leftover 'Visual Editor', 'Keyboard Shortcuts' and 'Toolbar' options.
	 */
	function client_remove_personal_options( $subject ) {
		$subject = preg_replace( '#<h2>Personal Options</h2>.+?/table>#s', '', $subject, 1 );

		return $subject;
	}

	function client_profile_subject_start() {
		ob_start( 'client_remove_personal_options' );
	}

	function client_profile_subject_end() {
		ob_end_flush();
	}
}

