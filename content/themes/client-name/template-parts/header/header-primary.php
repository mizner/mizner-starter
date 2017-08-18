<div class="the-header-primary">
	<?php if ( is_front_page() ): ?>
        <h1 rel="home" id="logo"><?php get_template_part( 'template-parts/logo' ); ?></h1>
	<?php else: ?>
        <div rel="home" id="logo"><?php get_template_part( 'template-parts/logo' ); ?></div>
	<?php endif; ?>
</div>