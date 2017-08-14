<?php

use Mizner\Theme\Logo;

$logo = new Logo();

?>
    <a href="<?php echo $logo->uri; ?>" itemprop="url">
		<?php if ( 'svg' === $logo->type ) : ?>
			<?php echo $logo->file ?>
		<?php elseif ( 'jpg' === $logo->type || 'png' === $logo->type ) : ?>
            <img src="<?php echo $logo->src; ?>" alt="<?php echo $logo->alt; ?>">
		<?php elseif ( 'text' === $logo->type ) : ?>
            <span class="site-title"><?php esc_html_e( $logo->alt ); ?></span>
		<?php endif; ?>
    </a>
<?php
