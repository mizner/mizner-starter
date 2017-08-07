<?php
// Add Capabilities
add_action( 'wp_loaded', 'client_add_theme_caps' );
function client_add_theme_caps() {
	$capabilities = [
		// General
		'edit_dashboard'                 => true,
		'export'                         => true,
		'import'                         => true,
		'manage_categories'              => true,
		'manage_options'                 => true,
		'moderate_comments'              => true,
		'read'                           => true,
		'unfiltered_upload'              => true,
		'update_core'                    => true,
		'upload_files'                   => true,

		// Themes
		'delete_themes'                  => true,
		'edit_theme_options'             => true,
		'edit_themes'                    => true,
		'install_themes'                 => true,
		'switch_themes'                  => true,
		'update_themes'                  => true,

		// Posts
		'create_posts'                   => true,
		'delete_others_posts'            => true,
		'delete_posts'                   => true,
		'delete_private_posts'           => true,
		'delete_published_posts'         => true,
		'edit_others_posts'              => true,
		'edit_posts'                     => true,
		'edit_private_posts'             => true,
		'edit_published_posts'           => true,
		'manage_categories'              => true,
		'moderate_comments'              => true,
		'publish_posts'                  => true,
		'read_private_posts'             => true,

		// Pages
		'create_pages'                   => true,
		'delete_others_pages'            => true,
		'delete_pages'                   => true,
		'delete_private_pages'           => true,
		'delete_published_pages'         => true,
		'edit_others_pages'              => true,
		'edit_pages'                     => true,
		'edit_private_pages'             => true,
		'edit_published_pages'           => true,
		'publish_pages'                  => true,
		'read_private_pages'             => true,

		// Plugins
		'activate_plugins'               => true,
		'delete_plugins'                 => true,
		'edit_plugins'                   => true,
		'install_plugins'                => true,
		'update_plugins'                 => true,

		// Users
		'create_users'                   => true,
		'delete_users'                   => true,
		'edit_users'                     => true,
		'list_users'                     => true,
		'promote_users'                  => true,
		'remove_users'                   => true,

		// WooCommerce Products
		'delete_others_products'         => true,
		'delete_private_products'        => true,
		'delete_products'                => true,
		'delete_published_products'      => true,
		'edit_others_products'           => true,
		'edit_private_products'          => true,
		'edit_products'                  => true,
		'edit_published_products'        => true,
		'publish_products'               => true,
		'read_private_products'          => true,

		// WooCommerce Variations
		'edit_others_products'           => true,
		'edit_products'                  => true,
		'publish_products'               => true,
		'read_private_products'          => true,

		// WooCommerce Orders
		'delete_others_shop_orders'      => true,
		'delete_private_shop_orders'     => true,
		'delete_published_shop_orders'   => true,
		'delete_shop_orders'             => true,
		'edit_others_shop_orders'        => true,
		'edit_private_shop_orders'       => true,
		'edit_published_shop_orders'     => true,
		'edit_shop_orders'               => true,
		'publish_shop_orders'            => true,
		'read_private_shop_orders'       => true,

		// Woocommerce Refunds
		'edit_others_shop_orders'        => true,
		'edit_shop_orders'               => true,
		'publish_shop_orders'            => true,
		'read_private_shop_orders'       => true,

		// WooCommerce Coupons
		'delete_others_shop_coupons'     => true,
		'delete_private_shop_coupons'    => true,
		'delete_published_shop_coupons'  => true,
		'delete_shop_coupons'            => true,
		'edit_others_shop_coupons'       => true,
		'edit_private_shop_coupons'      => true,
		'edit_published_shop_coupons'    => true,
		'edit_shop_coupons'              => true,
		'publish_shop_coupons'           => true,
		'read_private_shop_coupons'      => true,

		// WooCommerce Webhooks
		'delete_others_shop_webhooks'    => true,
		'delete_private_shop_webhooks'   => true,
		'delete_published_shop_webhooks' => true,
		'delete_shop_webhooks'           => true,
		'edit_others_shop_webhooks'      => true,
		'edit_private_shop_webhooks'     => true,
		'edit_published_shop_webhooks'   => true,
		'edit_shop_webhooks'             => true,
		'publish_shop_webhooks'          => true,
		'read_private_shop_webhooks'     => true,

		// WooCommerce Misc
		'view_woocommerce_reports'       => true,


		// Misc
		'assign_product_terms'           => true,
		'assign_shop_coupon_terms'       => true,
		'assign_shop_order_terms'        => true,
		'assign_shop_webhook_terms'      => true,
		'delete_product'                 => true,
		'delete_product_terms'           => true,
		'delete_shop_coupon'             => true,
		'delete_shop_coupon_terms'       => true,
		'delete_shop_order'              => true,
		'delete_shop_order_terms'        => true,
		'delete_shop_webhook'            => true,
		'delete_shop_webhook_terms'      => true,
		'edit_product'                   => true,
		'edit_product_terms'             => true,
		'edit_shop_coupon'               => true,
		'edit_shop_coupon_terms'         => true,
		'edit_shop_order'                => true,
		'edit_shop_order_terms'          => true,
		'edit_shop_webhook'              => true,
		'edit_shop_webhook_terms'        => true,
		'gravityforms_api'               => true,
		'gravityforms_api_settings'      => true,
		'gravityforms_create_form'       => true,
		'gravityforms_delete_entries'    => true,
		'gravityforms_delete_forms'      => true,
		'gravityforms_edit_entries'      => true,
		'gravityforms_edit_entry_notes'  => true,
		'gravityforms_edit_forms'        => true,
		'gravityforms_edit_settings'     => true,
		'gravityforms_export_entries'    => true,
		'gravityforms_preview_forms'     => true,
		'gravityforms_uninstall'         => true,
		'gravityforms_view_addons'       => true,
		'gravityforms_view_entries'      => true,
		'gravityforms_view_entry_notes'  => true,
		'gravityforms_view_settings'     => true,
		'gravityforms_view_updates'      => true,
		'manage_product_terms'           => true,
		'manage_shop_coupon_terms'       => true,
		'manage_shop_order_terms'        => true,
		'manage_shop_webhook_terms'      => true,
		'manage_woocommerce'             => true,
		'read_product'                   => true,
		'read_shop_coupon'               => true,
		'read_shop_order'                => true,
		'read_shop_webhook'              => true,
		'ure_create_capabilities'        => true,
		'ure_create_roles'               => true,
		'ure_delete_capabilities'        => true,
		'ure_delete_roles'               => true,
		'ure_edit_roles'                 => true,
		'ure_manage_options'             => true,
		'ure_reset_roles'                => true,

		// Deprecated
		'level_0'                        => true,

	];
	add_role( 'owner', 'Owner', $capabilities );
}