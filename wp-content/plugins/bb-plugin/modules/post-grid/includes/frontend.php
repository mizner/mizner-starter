<?php

// Get the query data.
$query = FLBuilderLoop::query($settings);

// Render the posts.
if($query->have_posts()) :

do_action( 'fl_builder_posts_module_before_posts', $settings, $query );

$paged = ( FLBuilderLoop::get_paged() > 0 ) ? ' fl-paged-scroll-to' : '';

?>
<div class="fl-post-<?php echo $module->get_layout_slug() . $paged; ?>" itemscope="itemscope" itemtype="http://schema.org/Blog">
	<?php

	while($query->have_posts()) {

		$query->the_post();

		include apply_filters( 'fl_builder_posts_module_layout_path', $module->dir . 'includes/post-' . $module->get_layout_slug() . '.php', $settings->layout, $settings );
	}

	?>
	<?php if ( 'grid' == $settings->layout ) : ?>
	<div class="fl-post-grid-sizer"></div>
	<?php endif; ?>
</div>
<div class="fl-clear"></div>
<?php endif; ?>
<?php

do_action( 'fl_builder_posts_module_after_posts', $settings, $query );

// Render the pagination.
if($settings->pagination != 'none' && $query->have_posts()) :

?>
<div class="fl-builder-pagination"<?php if($settings->pagination == 'scroll') echo ' style="display:none;"'; ?>>
	<?php FLBuilderLoop::pagination($query); ?>
</div>
<?php endif; ?>
<?php

do_action( 'fl_builder_posts_module_after_pagination', $settings, $query );

// Render the empty message.
if(!$query->have_posts()) :

?>
<div class="fl-post-grid-empty">
	<p><?php echo $settings->no_results_message; ?></p>
	<?php if ( $settings->show_search ) : ?>
	<?php get_search_form(); ?>
	<?php endif; ?>
</div>

<?php

endif;

wp_reset_postdata();

?>
