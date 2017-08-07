<?php
// -------------------------------
// Instance of Login & Logout (called manually)
// -------------------------------
add_shortcode( 'login-module', 'wplt_login_logout_module' );
function wplt_login_logout_module() {
	ob_start();
	if ( is_user_logged_in() ) :?>
        <a href="<?php wp_logout_url() ?>">Logout</a>
	<?php else : ?>
        <a id="loginLink" class="popupTrigger" name="loginform" href="#">Login</a>
		<?php
	endif;

	return ob_get_clean();
}