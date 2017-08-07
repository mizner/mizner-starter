<?php

use Mizner\Theme\Social;

$social = new Social();

?>
<ul class="social-media">
	<?php foreach ( $social->platforms() as $icon => $link ): ?>
        <li class="fa_svg_wrapper">
            <a href="<?php echo esc_url( $link ) ?>" itemprop="url">
                <svg class="fa_svg">
                    <use xlink:href="#<?php echo $icon ?>"></use>
                </svg>
            </a>
        </li>
	<?php endforeach; ?>
</ul>