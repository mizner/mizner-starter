<?php get_template_part( 'template-parts/head' ); ?>
<?php do_action( 'before_the_header' ); ?>
<header id="masthead" class="main-header">
    <div class="container">
		<?php // get_template_part( 'template-parts/top-bar' ); ?>
		<?php get_template_part( 'template-parts/header/header-primary' ); ?>
		<?php get_template_part( 'template-parts/header/header-secondary' ); ?>
    </div>
</header>
<!-- #theHeader -->
<?php do_action( 'after_the_header' ) ?>


