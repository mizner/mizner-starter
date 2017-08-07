<?php
add_action( 'manage_users_columns', 'remove_user_posts_column');
function remove_user_posts_column( $column_headers ) {

	unset( $column_headers['posts'] );
	unset( $column_headers['role'] );

	return $column_headers;
}