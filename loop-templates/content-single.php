<article class="post">
	<a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">See all</a>
	<div class="image_container object_fit">
		<a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'medium' ); ?>
		</a>
	</div>
	<h1><?php the_title(); ?></h1>
	<?php the_content(); ?>
</article>