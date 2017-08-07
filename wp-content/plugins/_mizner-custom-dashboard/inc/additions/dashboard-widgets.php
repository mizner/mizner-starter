<?php
/*
 * ## Add theme info box into WordPress Dashboard
 */
add_action( 'wp_dashboard_setup', 'add_dashboard_widgets' );
function add_dashboard_widgets() {
	wp_add_dashboard_widget( 'wp_dashboard_widget', 'Support Details', 'add_theme_info' );
}

function add_theme_info() {
	echo "<ul>
		  <li><strong>Developed By: </strong>Mizner</li>
		  <li><strong>Website:</strong> <a href='mizner.io'>www.mizner.io</a></li>
		  <li><strong>Contact:</strong> <a href='mailto:mike@mizner.io'>mike@mizner.io</a></li>
	  </ul>";
}