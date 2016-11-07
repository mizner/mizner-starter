<!doctype html>
<html>
<?php include_once( 'components/head.php' ) ?>
<body <?php body_class(); ?>>
<main id="wrapper">
	<header id="header" class="banner">
		<div id="headerContainer">
			<div id="headerPrimary">
				<?php the_logo(); ?>
			</div>
			<div id="headerSecondary">

				<div id="headerSecondaryTop">
					<?php echo get_search_form(); ?>
				</div>

				<div id="headerSecondaryMiddle">
					<?php the_phone(); ?>
					<?php the_social_media(); ?>
					<?php
					$args = [
						'theme_location'  => 'secondary-menu',
						'container'       => '',
						'container_class' => '',
						'menu_class'      => 'top-menu site-menu',
						'menu_id'         => 'topMenu'
					];
					if ( has_nav_menu( 'secondary-menu' ) ) {
						wp_nav_menu( $args );
					}
					?>
				</div>
				<div id="headerSecondaryBottom">
					<nav id="topMenuNav" aria-expanded="false" class="main-navigation" role="navigation">

						<button id="menuButton">
							<div id="menuIcon">
								<a class="navicon-button x">
									<div class="navicon"></div>
								</a>
							</div>
							<div class="navText">
								<p>Menu</p>
							</div>
						</button>


						<?php
						$args = [
							'theme_location'  => 'primary-menu',
							'container'       => '',
							'container_class' => '',
							'menu_class'      => 'primary-menu site-menu',
							'menu_id'         => 'primaryMenu'
						];
						wp_nav_menu( $args );
						?>
					</nav>



				</div>
			</div>
		</div>

	</header> <!-- #main-header -->

<?php do_action( 'after_the_header' ) ?>