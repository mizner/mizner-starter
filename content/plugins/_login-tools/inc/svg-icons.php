<?php
// -------------------------------
// SVG Icon
// -------------------------------
ob_start();
include_once WPLT_PATH . "images/close-icon.svg";
$power_icon = ob_get_clean();
define( 'POWER_ICON', $power_icon );