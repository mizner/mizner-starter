<?php if ( have_rows( 'slide_repeater' ) ): ?>
	<div id="acf_slider<?php module_count( $m ) ?>" class="carousel slide carousel-fade" data-ride="carousel">
		<ol class="carousel-indicators">
			<?php
			$z = 0;
			while ( have_rows( 'slide' ) ) : the_row();
				if ( $z === 0 ) {
					$active = "active";
				}
				else {
					$active = "";
				}
				echo "<li data-target='#flexCarousel' data-slide-to='{$z}' class='{$active}'></li>";
				$z ++;
			endwhile; ?>
		</ol>

		<div class="carousel-inner" role="listbox">
			<?php
			$i = 0;
			while ( have_rows( 'slide_repeater' ) ) : the_row();
				?>
				<div class="carousel-item <?php if ( $i === 0 ) {
					echo "active";
				} ?>">

					<?php
					$image = get_sub_field( 'slide_image' );
					?>

					<img class="item-background" alt="<?php echo $image['alt'] ?>" src="<?php echo $image['url'] ?>"/>
					<div class="carousel-caption">
						<h3><?php the_sub_field( 'slide_title' ); ?></h3>
						<?php the_sub_field( 'slide_sub_title' ); ?>
					</div>
				</div>
				<?php
				$i ++;
			endwhile;
			?>
		</div>

		<a class="left carousel-control" href="#flexCarousel<?php module_count($m) ?>" role="button" data-slide="prev">
			<span class="icon-prev"></span>
		</a>
		<a class="right carousel-control" href="#flexCarousel<?php module_count($m) ?>" role="button" data-slide="next">
			<span class="icon-next"></span>
		</a>
	</div>

<?php endif; ?>
