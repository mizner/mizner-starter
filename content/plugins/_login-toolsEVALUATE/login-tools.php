<?php
/**
 * Plugin Name: WordPress Login Tools
 * Plugin URI: http://mizner.io
 * Description: Developer toolkit for custom login forms
 * Version: 1.0
 * Author: Michael Mizner
 * Author URI: http://mizner.io
 * License:
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


ob_start(); ?>
	<svg version="1.1" id="Layer_1" class="headerIcon" xmlns="http://www.w3.org/2000/svg"
	     xmlns:xlink="http://www.w3.org/1999/xlink"
	     x="0px" y="0px"
	     viewBox="0 0 500 500" style="enable-background:new 0 0 500 500;" xml:space="preserve">
<g>
	<path d="M202.3,254.2c-8.1-8.1-21.3-8.1-29.4,0c-4.1,4.1-6.1,9.4-6.1,14.7c0,5.3,2,10.6,6.1,14.7l62.4,62.4c0.5,0.5,1,0.9,1.5,1.4
		c0.1,0.1,0.2,0.2,0.4,0.3c0.4,0.3,0.8,0.7,1.3,0.9c0.1,0.1,0.2,0.1,0.4,0.2c0.5,0.3,0.9,0.6,1.4,0.8c0.1,0,0.2,0.1,0.3,0.1
		c0.5,0.3,1,0.5,1.6,0.8c0.1,0,0.1,0,0.2,0.1c0.6,0.2,1.2,0.4,1.7,0.6c0.1,0,0.1,0,0.2,0.1c0.6,0.2,1.2,0.3,1.8,0.4
		c0.2,0,0.3,0.1,0.5,0.1c0.5,0.1,1,0.2,1.5,0.2c0.7,0.1,1.4,0.1,2.1,0.1c0.7,0,1.4,0,2.1-0.1c0.5-0.1,1-0.1,1.5-0.2
		c0.2,0,0.3,0,0.5-0.1c0.6-0.1,1.2-0.3,1.8-0.4c0.1,0,0.1,0,0.2,0c0.6-0.2,1.2-0.4,1.8-0.6c0,0,0.1,0,0.2-0.1
		c0.5-0.2,1.1-0.5,1.6-0.8c0.1,0,0.2-0.1,0.2-0.1c0.5-0.3,0.9-0.5,1.4-0.8c0.1-0.1,0.2-0.1,0.3-0.2c0.4-0.3,0.9-0.6,1.3-0.9
		c0.1-0.1,0.2-0.2,0.4-0.3c0.5-0.4,1-0.9,1.5-1.4l62.4-62.4c8.1-8.1,8.1-21.3,0-29.4c-8.1-8.1-21.3-8.1-29.4,0l-26.9,26.9V40
		c0-11.5-9.3-20.8-20.8-20.8c-11.5,0-20.8,9.3-20.8,20.8v241.1L202.3,254.2z M202.3,254.2"/>
	<path d="M420.2,306.8c0-56.8-28.2-109.7-75.4-141.4c-9.5-6.4-22.5-3.9-28.9,5.7c-6.4,9.5-3.9,22.5,5.7,28.9
		c35.7,24,57,63.9,57,106.8c0,70.9-57.7,128.6-128.6,128.6c-70.9,0-128.6-57.7-128.6-128.6c0-42.8,21.2-82.7,56.7-106.7
		c9.5-6.4,12-19.4,5.6-28.9c-6.4-9.5-19.4-12-28.9-5.6c-47,31.8-75,84.5-75,141.2C79.8,400.6,156.1,477,250,477
		S420.2,400.6,420.2,306.8L420.2,306.8z M420.2,306.8"/>
</g>
</svg>
<?php
$power_icon = ob_get_clean();
define( 'POWER_ICON', $power_icon );

add_action( 'get_footer', 'miz_login_form', 100 );
function miz_login_form() {
	$args = [
		'echo'           => true,
		'remember'       => true,
		//'redirect'       => '/my-account',
		'form_id'        => 'loginForm',
		'id_username'    => 'user_login',
		'id_password'    => 'user_pass',
		'id_remember'    => 'rememberme',
		'id_submit'      => 'wp-submit',
		'label_username' => __( 'Email' ),
		'label_password' => __( 'Password' ),
		'label_remember' => __( 'Remember Me' ),
		'label_log_in'   => __( 'Log In' ),
		'value_username' => '',
		'value_remember' => false
	];
	ob_start();
	?>
	<div class="popupWrapper loginform">
		<div class="popupInner">
			<?php wp_login_form( $args ); ?>
			</div>
	</div>
	<?php
	$form = ob_get_clean();
	echo $form;
}

// Login Redirect
add_filter( 'login_redirect', 'miz_login_redirect', 10, 3 );
function miz_login_redirect( $redirect_to, $request, $user ) {
	//is there a user to check?
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'administrator', $user->roles ) ) :
			// redirect them to the default place
			return $redirect_to;

		elseif ( in_array( 'customer', $user->roles ) ):
			return "/my-account";
		else :
			return home_url();
		endif;
	} else {
		return $redirect_to;
	}
}


// On logout go to homepage
add_action( 'wp_logout', 'go_home' );
function go_home() {
	wp_redirect( home_url() );
	exit();
}

// Add Forgot Password Link
add_action( 'login_form_bottom', 'add_lost_password_link' );
function add_lost_password_link() {
	return '<p class="login-lostpassword"><a href="/wp-login.php?action=lostpassword">Lost Password?</a></p>';
}

// Add Login & Logout
add_filter( 'wp_nav_menu_items', 'miz_add_loginout_link', 10, 2 );
function miz_add_loginout_link( $items, $args ) {
	if ( is_user_logged_in() && $args->theme_location == 'primary-menu' ) {
		$items .= '<li class="menu-item"><a href="' . wp_logout_url() . '">Logout</a></li>';
	} elseif ( ! is_user_logged_in() && $args->theme_location == 'primary-menu' ) {
		$items .= '<li class="menu-item"><a id="loginLink" class="popupTrigger" name="loginform" href="#">Login</a></li>';
	}

	return $items;
}


// Instance of Login & Logout (called manually)
function miz_login_logout_module() {
	ob_start();
	if ( is_user_logged_in() ) {
		?>
		<a href="<?php wp_logout_url() ?>">
			<?php echo POWER_ICON; ?>
			<p>Logout</p>
		</a>
		<?php
	} else {
		?>
		<a id="loginLink" class="popupTrigger" name="loginform" href="#">
			<?php echo POWER_ICON; ?>
			<p>Login</p>
		</a>
		<?php
	}

	$content = ob_get_clean();

	return $content;
}