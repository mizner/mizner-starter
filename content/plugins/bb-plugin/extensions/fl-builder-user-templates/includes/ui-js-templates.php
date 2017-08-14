<script type="text/html" id="tmpl-fl-node-template-block">
	<span class="fl-builder-block fl-builder-block-saved-{{data.type}}<# if ( data.global ) { #> fl-builder-block-global<# } #>" data-id="{{data.id}}">
		<span class="fl-builder-block-title">{{data.name}}</span>
		<# if ( data.global ) { #>
		<div class="fl-builder-badge fl-builder-badge-global">
			<?php _ex( 'Global', 'Indicator for global node templates.', 'fl-builder' ); ?>
		</div>
		<# } #>
		<# if ( data.global && FLBuilderConfig.userCanEditGlobalTemplates ) { #>
		<span class="fl-builder-node-template-actions">
			<a class="fl-builder-node-template-edit" href="{{data.link}}" target="_blank">
				<i class="fa fa-wrench"></i>
			</a>
			<a class="fl-builder-node-template-delete" href="javascript:void(0);">
				<i class="fa fa-times"></i>
			</a>
		</span>
		<# } #>
	</span>
</script>
<!-- #tmpl-fl-node-template-block -->