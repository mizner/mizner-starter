<?php
add_action( 'init', 'client_remove_gotdang_nags' );
function client_remove_gotdang_nags() {
	remove_action( 'admin_notices', 'woothemes_updater_notice' );
}