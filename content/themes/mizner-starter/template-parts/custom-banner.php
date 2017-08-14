<?php

use Mizner\Theme\Banner;
use function Mizner\Theme\title;

$banner = new Banner();

var_dump( $banner );

?>

<header class="object-fit-fix custom-header">
    <img src="<?php ?>" alt="<?php _e( title() ); ?>">
    <div class="container">
		<?php if ( is_singular() ): ?>
            <a class="see-all" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">See all</a>
		<?php endif; ?>
        <h1 class="entry-title"><?php _e( title() ); ?></h1>
    </div>
</header>