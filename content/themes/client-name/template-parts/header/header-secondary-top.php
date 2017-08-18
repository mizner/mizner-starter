<div class="the-header-secondary-top">

	<?php echo get_search_form(); ?>
	<?php if ( has_nav_menu( 'secondary-menu' ) ) : ?>
		<?php
		wp_nav_menu( [
			'theme_location'  => 'secondary-menu',
			'container'       => 'nav',
			'container_class' => 'secondary-menu-container',
			'menu_class'      => 'secondary-menu site-menu',
			'menu_id'         => 'secondaryMenu'
		] );
		?>
	<?php endif; ?>
</div>