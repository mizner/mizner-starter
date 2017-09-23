<?php
add_action( 'init', 'codex_testimonial_init' );
/**
 * Register a testimonial post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function codex_testimonial_init() {
	$labels = array(
		'name'               => _x( 'Testimonials', 'post type general name', 'testimonials-cpt' ),
		'singular_name'      => _x( 'Testimonial', 'post type singular name', 'testimonials-cpt' ),
		'menu_name'          => _x( 'Testimonials', 'admin menu', 'testimonials-cpt' ),
		'name_admin_bar'     => _x( 'Testimonial', 'add new on admin bar', 'testimonials-cpt' ),
		'add_new'            => _x( 'Add New', 'testimonial', 'testimonials-cpt' ),
		'add_new_item'       => __( 'Add New Testimonial', 'testimonials-cpt' ),
		'new_item'           => __( 'New Testimonial', 'testimonials-cpt' ),
		'edit_item'          => __( 'Edit Testimonial', 'testimonials-cpt' ),
		'view_item'          => __( 'View Testimonial', 'testimonials-cpt' ),
		'all_items'          => __( 'All Testimonials', 'testimonials-cpt' ),
		'search_items'       => __( 'Search Testimonials', 'testimonials-cpt' ),
		'parent_item_colon'  => __( 'Parent Testimonials:', 'testimonials-cpt' ),
		'not_found'          => __( 'No testimonials found.', 'testimonials-cpt' ),
		'not_found_in_trash' => __( 'No testimonials found in Trash.', 'testimonials-cpt' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.', 'testimonials-cpt' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'testimonial' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-format-quote',
		'supports'           => array(
			'title',
			'editor',
			//'author',
			'thumbnail',
			//'excerpt',
			//'comments'
			'page-attributes'
		)
	);

	register_post_type( 'testimonial', $args );
}

add_filter( 'enter_title_here', 'testimonials_cpt_title' );

function testimonials_cpt_title( $input ) {
	global $post_type;

	if ( 'testimonial' === $post_type ) {
		return __( 'Enter the customer\'s name here', 'testimonials-cpt' );
	}

	return $input;
}


add_action( 'pre_get_posts', 'create_new_posts_order' );

function create_new_posts_order( $query ) {

	if ( $query->is_main_query() )

		$query->set( 'orderby', 'menu_order' );

}