<?php get_header(); ?>

<?php get_template_part( 'components/posts-slider' ) ?>

<section id="content">

	<?php while ( have_posts() ) : the_post(); ?>

        <section class="hero">
			<?php get_template_part( 'components/hero' ); ?>
        </section>

        <section class="featurette">
            <div class="container">
                <div class="box">
	                <?php get_template_part( 'components/featurette' ); ?>
                </div>
            </div>
        </section>

        <section class="blurbs">
            <div class="container">
                <div class="box">
	                <?php get_template_part( 'components/blurbs' ); ?>
                </div>
            </div>
        </section>

	<?php endwhile; ?>

</section>

<?php get_footer(); ?>

