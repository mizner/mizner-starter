<?php

use Mizner\Theme\Query;

$query = new Query;
$posts = $query->recent_posts();
?>
    <section class="recent-content">
        <header>
            <h3><?php _e( 'Recent Posts' ); ?></h3>
        </header>
        <div class="recent-content-singles">
			<?php foreach ( $posts as $post ): ?>
                <article>
                    <header>
                        <a href="<?php echo esc_url( $post->link ) ?>">
							<?php // custom_featured_image( $the_query->post->ID, "medium" ); ?>
                        </a>
                    </header>
                    <a href="<?php echo esc_url( $post->link ) ?>">
                        <h4><?php _e( $post->title ) ?></h4>
                    </a>
                    <p><?php _e( $post->excerpt ) ?></p>
                    <a href="<?php echo esc_url( $post->link ) ?>">
                        <?php _e( 'Read More' ) ?>
                    </a>

                </article>
			<?php endforeach; ?>
        </div>
    </section>
<?php

