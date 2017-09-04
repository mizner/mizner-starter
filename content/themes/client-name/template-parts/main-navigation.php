<?php

use Mizner\Theme\NavWalker;

?>
<nav id="mainNavigation" class="main_navigation" aria-expanded="false" role="navigation" itemscope
     itemtype="//schema.org/SiteNavigationElement">
    <button id="mainNavigationButton">
        <i>
            <span></span>
            <span></span>
            <span></span>
        </i>
        <span><?php _e( 'Menu' ); ?></span>
    </button>
	<?php
	wp_nav_menu( [
		'theme_location' => 'primary-menu',
		'walker'         => new NavWalker(),
		'container'      => false,
		'items_wrap'     => '<ul>%3$s</ul>'
	] );
	?>

</nav>
