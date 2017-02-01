<header class="object-fit-fix custom-header">
    <img src="<?php echo banner_image()['url']; ?>" alt="<?php title(); ?>">
    <div class="container">
        <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">See all</a>
        <h1 class="entry-title"><?php title(); ?></h1>
    </div>
</header>