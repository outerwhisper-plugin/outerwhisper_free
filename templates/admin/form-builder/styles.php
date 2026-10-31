<?php
if (!defined('ABSPATH')) {
	exit;
}
?>

<section class="outerwhisper-builder-view outerwhisper-config-screen-layout" id="outerwhisper-view-styles" aria-label="<?php esc_attr_e('admin.builder.styles.title', 'outerwhisper'); ?>">

	<div class="outerwhisper-builder-section-col">
		<!-- Header -->
		<div class="outerwhisper-builder-section-header">
			<h3 class="outerwhisper-builder-section-title"><i class="fas fa-palette"></i> <?php esc_html_e('admin.builder.styles.title', 'outerwhisper'); ?></h3>
		</div>

		<div class="outerwhisper-builder-section">
			<div style="background-color: #f1f5f9; padding: 12px 16px; border-radius: 6px; font-size: 11.5px; color: var(--outerwhisper-text-secondary); line-height: 1.45; margin-bottom: 20px;">
				<?php esc_html_e('admin.builder.styles.description', 'outerwhisper'); ?>
			</div>

			<div class="outerwhisper-form-group">
				<label for="outerwhisper-style-accent-color"><?php esc_html_e('admin.builder.styles.accent_color.label', 'outerwhisper'); ?></label>
				<div class="outerwhisper-color-picker-row">
					<input type="color" id="outerwhisper-style-accent-color" class="outerwhisper-form-input" style="width: 60px; height: 36px; padding: 2px; cursor: pointer;" value="#000000" />
					<input type="text" id="outerwhisper-style-accent-hex" class="outerwhisper-form-input" value="#000000" style="width: 120px;" />
					<span class="outerwhisper-settings-text"><?php esc_html_e('admin.builder.styles.accent_color.description', 'outerwhisper'); ?></span>
				</div>
			</div>
			<div class="outerwhisper-form-group">
				<label for="outerwhisper-style-secondary-color"><?php esc_html_e('admin.builder.styles.secondary_color.label', 'outerwhisper'); ?></label>
				<div class="outerwhisper-color-picker-row">
					<input type="color" id="outerwhisper-style-secondary-color" class="outerwhisper-form-input" style="width: 60px; height: 36px; padding: 2px; cursor: pointer;" value="#555555" />
					<input type="text" id="outerwhisper-style-secondary-hex" class="outerwhisper-form-input" value="#555555" style="width: 120px;" />
					<span class="outerwhisper-settings-text"><?php esc_html_e('admin.builder.styles.secondary_color.description', 'outerwhisper'); ?></span>
				</div>
			</div>

			<div class="outerwhisper-form-group">
				<label><?php esc_html_e('admin.builder.styles.gap.label', 'outerwhisper'); ?></label>
				<div class="outerwhisper-color-picker-row">
					<div class="outerwhisper-form-builder-input-suffix">
						<input type="number" id="outerwhisper-style-gap-all" class="outerwhisper-form-input" style="min-width: 160px;" placeholder="<?php esc_attr_e('admin.builder.styles.gap.all.placeholder', 'outerwhisper'); ?>" title="<?php esc_attr_e('admin.builder.styles.gap.all.title', 'outerwhisper'); ?>" value="15" min="0" max="50">
						<span>px</span>
					</div>
					<span class="outerwhisper-settings-text"><?php esc_html_e('admin.builder.styles.gap.all.title', 'outerwhisper'); ?></span>
				</div>

				<div class="outerwhisper-color-picker-row">
					<div class="outerwhisper-form-builder-input-suffix">
						<input type="number" id="outerwhisper-style-gap-step1" class="outerwhisper-form-input" style="min-width: 160px;" placeholder="<?php esc_attr_e('admin.builder.styles.gap.step1.placeholder', 'outerwhisper'); ?>" title="<?php esc_attr_e('admin.builder.styles.gap.step1.title', 'outerwhisper'); ?>" value="15" min="0" max="50">
						<span>px</span>
					</div>
					<span class="outerwhisper-settings-text"><?php esc_html_e('admin.builder.styles.gap.step1.title', 'outerwhisper'); ?></span>
				</div>

				<div class="outerwhisper-color-picker-row">
					<div class="outerwhisper-form-builder-input-suffix">
						<input type="number" id="outerwhisper-style-gap-step2" class="outerwhisper-form-input" style="min-width: 160px;" placeholder="<?php esc_attr_e('admin.builder.styles.gap.step2.placeholder', 'outerwhisper'); ?>" title="<?php esc_attr_e('admin.builder.styles.gap.step2.title', 'outerwhisper'); ?>" value="15" min="0" max="50">
						<span>px</span>
					</div>
					<span class="outerwhisper-settings-text"><?php esc_html_e('admin.builder.styles.gap.step2.title', 'outerwhisper'); ?></span>
				</div>

			</div>

		</div>
	</div>
</section>
