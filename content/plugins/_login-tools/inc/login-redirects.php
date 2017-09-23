<?php
add_filter( 'login_redirect', 'wplt_login_redirect', 10, 3 );
function wplt_login_redirect( $redirect_to, $request, $user ) {
	// is there a user to check?
	if ( isset( $user->roles ) && is_array( $user->roles ) ) :
		// Check if Admin
		if ( in_array( 'administrator', $user->roles ) ) :
			// redirect them to the default place
			return $redirect_to;

		elseif ( in_array( 'customer', $user->roles ) ):
			return "/my-account";
		else :
			return home_url();
		endif;
	else :
		return $redirect_to;
	endif;
}

// On logout go to homepage
add_action( 'wp_logout', 'go_home' );
function go_home() {
	wp_redirect( home_url() );
	exit();
}