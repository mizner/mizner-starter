<?php
$category  = get_field( 'recent_posts_category' );
$the_query = new WP_Query( [
	'post_type'      => 'post',
	'posts_per_page' => 4,
	'category_name'  => $category
] ); ?>
<?php if ( $the_query->have_posts() ): ?>
    <section class="recent-content">
        <div class="container">
            <div class="box">
                <header>
                    <h3><?php the_field( 'recent_posts_title' ); ?></h3>
                </header>
                <div class="recent-content-singles">
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                        <article>
                            <a href="<?php the_permalink(); ?>">
                                <header>
									<?php custom_featured_image( $the_query->post->ID, "medium" ); ?>
                                </header>
                                <h4><?php the_title(); ?></h4>
								<?php the_excerpt(); ?>
								<?php if ( get_field( 'recent_posts_link' ) ) : ?>
                                    <a href="<?php the_field( 'recent_posts_link' ); ?>">
                                        <button class="button"><?php the_field( 'recent_posts_button_text' ); ?></button>
                                    </a>
								<?php endif; ?>
                            </a>
                        </article>
					<?php endwhile; ?>
                </div>
            </div>
        </div>
    </section>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>
