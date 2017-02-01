<?php get_header(); ?>

<?php get_template_part( 'components/posts-slider' ) ?>

<section id="content">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'components/hero' ); ?>

        <section class="about">
            <div class="container">
                <div class="box featurette">
                    <article>
                        <h3> <?php the_field( 'about_title' ); ?></h3>
						<?php the_field( 'about_sub_title' ); ?>
                    </article>
                    <aside class="embed-container">
						<?php the_field( 'about_video' ); ?>
                    </aside>
                </div>
            </div>
        </section>

	<?php endwhile; ?>

</section>

<?php get_footer(); ?>

