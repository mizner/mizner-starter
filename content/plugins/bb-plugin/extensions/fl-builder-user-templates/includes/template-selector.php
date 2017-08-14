<div id="fl-builder-settings-tab-yours" class="fl-builder-settings-tab">

	<div class="fl-builder-settings-section">

		<p class="fl-builder-settings-message fl-user-templates-message"><?php _e('You haven\'t saved any templates yet! To do so, create a layout and save it as a template under <strong>Tools &rarr; Save Template</strong>.', 'fl-builder'); ?></p>

		<?php if(count($user_templates['templates']) > 0) : ?>
		<div class="fl-user-templates">
			<div class="fl-user-template" data-id="blank">
				<span class="fl-user-template-name"><?php _ex( 'Blank', 'Template name.', 'fl-builder' ); ?></span>
				<div class="fl-clear"></div>
			</div>
			<?php foreach($user_templates['categorized'] as $category) : ?>
			
			<div class="fl-user-template-category">
				<?php if ( count( $user_templates['categorized'] ) > 1 ) : ?>
				<div class="fl-user-template-category-name"><?php echo $category['name']; ?></div>
				<?php endif; ?>
				<?php foreach($category['templates'] as $template) : ?>
				<div class="fl-user-template" data-id="<?php echo $template['id']; ?>">
					<div class="fl-user-template-actions">
						<a class="fl-user-template-edit" href="<?php echo add_query_arg('fl_builder', '', get_permalink($template['id'])); ?>"><?php _e('Edit', 'fl-builder'); ?></a>
						<a class="fl-user-template-delete" href="javascript:void(0);" onclick="return false;"><?php _e('Delete', 'fl-builder'); ?></a>
					</div>
					<span class="fl-user-template-name"><?php echo $template['name']; ?></span>
					<div class="fl-clear"></div>
				</div>
				<?php endforeach; ?>
			</div>
				
			<?php endforeach; ?>
			<div class="fl-clear"></div>
		</div>
		<?php endif; ?>

	</div>
</div>