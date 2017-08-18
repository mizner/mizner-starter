<?php

namespace Mizner\Theme;

class WooCommerce {

	public function init() {
		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			return;
		}
	}


}