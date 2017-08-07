<div class="fl-number fl-number-<?php echo $settings->layout ?>">
<?php if( $settings->layout == 'circle' ) : ?>
	<div class="fl-number-circle-container">	
		<div class="fl-number-text">
			<?php if( !empty( $settings->before_number_text ) ) : ?>
				<span class="fl-number-before-text"><?php echo $settings->before_number_text; ?></span>
			<?php endif; ?>

			<?php $module->render_number(); ?>

			<?php if( !empty( $settings->after_number_text ) ) : ?>
				<span class="fl-number-after-text"><?php echo $settings->after_number_text; ?></span>
			<?php endif; ?>		
		</div>
		<?php $module->render_circle_bar(); ?>
	</div>
<?php elseif( $settings->layout == 'bars' ) : ?>
	<div class="fl-number-text fl-number-position-<?php echo esc_attr( $settings->number_position );?>">
		<?php if( !empty( $settings->before_number_text ) ) : ?>
			<span class="fl-number-before-text"><?php echo $settings->before_number_text; ?></span>
		<?php endif; ?>
	
		<?php
		$position = $settings->number_position ? $settings->number_position : 'default';	
		?>
	
		<?php if( $position == 'above' ): ?>

			<?php $module->render_number(); ?>
			<div class="fl-number-bars-container">
				<div class="fl-number-bar"></div>
			</div>
		<?php 

		elseif ( $position == 'below' ): ?>

			<div class="fl-number-bars-container">
				<div class="fl-number-bar"></div>
			</div>
			<?php 
			$module->render_number(); 

		else: ?>

			<div class="fl-number-bars-container">
				<div class="fl-number-bar">
					<?php $module->render_number(); ?>
				</div>
			</div>

		<?php endif; ?>

		<?php if( !empty( $settings->after_number_text ) ) : ?>
			<span class="fl-number-after-text"><?php echo $settings->after_number_text; ?></span>
		<?php endif; ?>

	</div>
<?php else : ?>
	<div class="fl-number-text">
		<?php if( !empty( $settings->before_number_text ) ) : ?>
			<span class="fl-number-before-text"><?php echo $settings->before_number_text; ?></span>
		<?php endif; ?>

		<?php $module->render_number(); ?>

		<?php if( !empty( $settings->after_number_text ) ) : ?>
			<span class="fl-number-after-text"><?php echo $settings->after_number_text; ?></span>
		<?php endif; ?>		
	</div>
<?php endif; ?>
</div>