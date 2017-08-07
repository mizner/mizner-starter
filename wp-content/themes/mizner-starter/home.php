<?php get_header(); ?>

<?php get_template_part( 'components/custom-header' ); ?>

    <div class="container content-area-wrapper">

        <section class="post-list">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'loop-templates/content' ); ?>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'loop-templates/content', 'none' ); ?>

			<?php endif; ?>

        </section>

		<?php get_sidebar(); ?>

    </div>

<?php get_footer(); ?>