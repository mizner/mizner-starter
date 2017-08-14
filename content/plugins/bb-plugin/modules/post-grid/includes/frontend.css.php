<?php
	
$layout = $module->get_layout_slug();
$file   = $module->dir . 'includes/post-' . $layout;	
$custom = isset( $settings->post_layout ) && 'custom' == $settings->post_layout;

if ( file_exists( $file . '-common.css.php' ) ) {
	include $file . '-common.css.php';
}
if ( ! $custom && file_exists( $file . '.css.php' ) ) {
	include $file . '.css.php';
}