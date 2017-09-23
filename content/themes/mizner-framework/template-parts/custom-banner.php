<?php

use Mizner\Theme\Banner;
use function Mizner\Theme\title;

$banner = new Banner();

?>

<section class="custom-banner">
    <div class="custom-banner_image">
        <img src="<?php echo esc_url( $banner->uri ) ?>" alt="<?php _e( title() ); ?>">
    </div>
    <header>
        <div class="container">
			<?php if ( is_singular() && ! is_page() ): ?>
                <a class="see-all" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">See all</a>
			<?php endif; ?>
            <h1 class="entry-title"><?php _e( title() ); ?></h1>
        </div>
    </header>
</section>