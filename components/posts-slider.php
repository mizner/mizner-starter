<?php
$args      = [
	'post_type'      => 'post',
	'posts_per_page' => 3,
	'meta_query'     => [
		// [
		// 	'key' => '_is_featured',
		// 	'compare' => '=',
		// 	'value' => 'yes',
		// 	//'type' => 'DATE',
		// ]
	],
];
$the_query = new WP_Query( $args );
?>
<div id="theCarousel" class="carousel slide carousel-fade" data-ride="carousel">
	<ol class="carousel-indicators">
		<?php
		$z = 0;
		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			if ( $z === 0 ) {
				$active = "active";
			}
			echo "<li data-target='#theCarousel' data-slide-to='{$z}' class='{$active}'></li>";
			$z ++;
		endwhile;
		wp_reset_postdata(); ?>
	</ol>

	<div class="carousel-inner" role="listbox">
		<?php
		$i = 0;
		while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			<div class="carousel-item <?php if ( $i === 0 ) {
				echo "active";
			} ?>">

				<img class="item-background" src="<?php the_post_thumbnail_url() ?>"/>
				<div class="carousel-caption">
					<h3><?php the_title(); ?></h3>
					<?php the_content(); ?>
				</div>
			</div>
			<?php
			$i ++;
		endwhile;
		?>
		<?php wp_reset_postdata(); ?>
	</div>

	<a class="left carousel-control" href="#theCarousel" role="button" data-slide="prev">
		<span class="icon-prev"></span>
	</a>
	<a class="right carousel-control" href="#theCarousel" role="button" data-slide="next">
		<span class="icon-next"></span>
	</a>
</div>