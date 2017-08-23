<?php

use Mizner\Theme\NavWalker;

?>

<div class="the-header-secondary-middle">
    <nav id="main-navigation" aria-expanded="false" role="navigation" itemscope
         itemtype="http://schema.org/SiteNavigationElement">
        <button id="mobile-menu-button">
            <div id="menu-icon">
                <a class="navicon-button x">
                    <div class="navicon"></div>
                </a>
            </div>
            <div class="navText">
                <p>Menu</p>
            </div>
        </button>

		<?php
		//		wp_nav_menu( [
		//			'theme_location'  => 'primary-menu',
		//			'container'       => '',
		//			'container_class' => '',
		//			'menu_class'      => 'primary-menu site-menu',
		//			'menu_id'         => 'primaryMenu',
		//		] );
		wp_nav_menu( [
			'theme_location' => 'primary-menu',
			// 'walker'         => new NavWalker(),
			'container'      => false,
			'items_wrap'     => '<nav id="%1$s"><ul>%3$s</ul></nav>'
		] );
		?>
    </nav>
</div>