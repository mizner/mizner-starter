<?php
if ( get_role( 'subscriber' ) ) {
	remove_role( 'subscriber' );
}
if ( get_role( 'contributor' ) ) {
	remove_role( 'contributor' );
}
if ( get_role( 'editor' ) ) {
	remove_role( 'editor' );
}
if ( get_role( 'author' ) ) {
	remove_role( 'author' );
}