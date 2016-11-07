<article>

	<header>

		<div class="image_container object_fit">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'thumbnail' ); ?>
			</a>
		</div>

		<a href="<?php the_permalink(); ?>">

			<h1><?php the_title(); ?></h1>

		</a>

	</header>

	<div class="post-meta">
		<?php the_date(); ?>
		<?php the_category(); ?>
	</div>
	<p><?php echo get_excerpt( 40 ); ?></p>

</article>



