<?php
// Dashboard Styles and Scripts
$client_view = new ClientView();

add_action( 'admin_enqueue_scripts', [ $client_view, 'enqueues' ] );

class ClientView {
	public static function enqueues() {
		wp_enqueue_style( CLIENT_VIEW_NAME . '_dashboard_css', CLIENT_URI . '/dist/' . CLIENT_VIEW_NAME . '.min.css' );
		wp_enqueue_script( CLIENT_VIEW_NAME . '_JS', CLIENT_URI . '/dist/' . CLIENT_VIEW_NAME . '.min.js' );
	}
}