<?php get_template_part( 'components/head' ); ?>
<?php do_action( 'before_the_header' ); ?>
    <header id="the-header">
        <div class="the-header-top-bar">
            <div class="the-header-top-bar-container">
                <i class="fa fa-phone"></i>
            </div>
        </div>
        <div class="the-header-container">
            <div class="the-header-primary">
				<?php the_logo(); ?>
            </div>
            <div class="the-header-secondary">
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
		                wp_nav_menu( [
			                'theme_location'  => 'primary-menu',
			                'container'       => '',
			                'container_class' => '',
			                'menu_class'      => 'primary-menu site-menu',
			                'menu_id'         => 'primaryMenu',
		                ] );
		                ?>
                    </nav>
                </div>
                <div class="the-header-secondary-bottom">
	                <?php the_social_media(); ?>
	                <?php the_phone(); ?>

                </div>
            </div>
        </div>
    </header> <!-- #main-header -->

<?php do_action( 'after_the_header' ) ?>


