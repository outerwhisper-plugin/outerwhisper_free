<?php
if (!defined('ABSPATH')) {
	exit;
}
?>

<section class="outerwhisper-builder-view outerwhisper-config-screen-layout" id="outerwhisper-view-general" aria-label="<?php esc_attr_e('admin.builder.general.title', 'outerwhisper'); ?>">

	<div class="outerwhisper-builder-section-col">
		<!-- Header -->
		<div class="outerwhisper-builder-section-header">
			<h3 class="outerwhisper-builder-section-title"><i class="fas fa-sliders-h"></i> <?php esc_html_e('admin.builder.general.title', 'outerwhisper'); ?></h3>
		</div>

		<div class="outerwhisper-builder-section">
			<div class="outerwhisper-form-group">
				<label for="outerwhisper-setting-form-id"><?php esc_html_e('admin.builder.general.form_id.label', 'outerwhisper'); ?> <span style="color: var(--outerwhisper-text-secondary);">(<?php esc_html_e('admin.builder.general.form_id.hint', 'outerwhisper'); ?>)</span></label>
				<input type="text" id="outerwhisper-setting-form-id" class="outerwhisper-form-input" value="<?php echo (int) $formId ?>" readonly style="background-color: #f1f5f9; cursor: not-allowed;" />
				<p class="outerwhisper-settings-text"><?php echo sprintf(esc_html__('admin.builder.general.form_id.description', 'outerwhisper'), '<code>[outerwhisper_form id="' . (int) $formId . '"]</code>'); ?></p>
			</div>

			<div class="outerwhisper-form-group">
				<label for="outerwhisper-setting-form-name"><?php esc_html_e('admin.builder.general.form_name.label', 'outerwhisper'); ?></label>
				<input type="text" id="outerwhisper-setting-form-name" class="outerwhisper-form-input" value="<?php esc_html_e('admin.builder.general.form_name.default', 'outerwhisper'); ?>" />
				<p class="outerwhisper-settings-text"><?php esc_html_e('admin.builder.general.form_name.description', 'outerwhisper'); ?></p>
			</div>

			<div class="outerwhisper-form-group">
				<label for="outerwhisper-setting-custom-classes"><?php esc_html_e('admin.builder.general.custom_classes.label', 'outerwhisper'); ?></label>
				<input type="text" id="outerwhisper-setting-custom-classes" class="outerwhisper-form-input" value="<?php esc_html_e('admin.builder.general.custom_classes.default', 'outerwhisper'); ?>" placeholder="<?php esc_html_e('admin.builder.general.custom_classes.placeholder', 'outerwhisper'); ?>" />
				<p class="outerwhisper-settings-text"><?php esc_html_e('admin.builder.general.custom_classes.description', 'outerwhisper'); ?></p>
			</div>

			<div class="outerwhisper-switch-group">
	      <span class="outerwhisper-switch-label">
	        <i class="fas fa-shield-alt"></i> <?php esc_html_e('admin.builder.general.honeypot.label', 'outerwhisper'); ?>
	      </span>
				<label class="outerwhisper-switch-wrapper" for="outerwhisper-setting-honeypot">
					<input type="checkbox" id="outerwhisper-setting-honeypot" checked />
					<span class="outerwhisper-switch-slider"></span>
				</label>
			</div>
		</div>

	</div>

</section>
