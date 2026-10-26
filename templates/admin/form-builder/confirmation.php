<?php
if (!defined('ABSPATH')) {
	exit;
}
?>

<section class="outerwhisper-builder-view outerwhisper-config-screen-layout" id="outerwhisper-view-confirmation" aria-label="<?php esc_attr_e('admin.builder.confirmation.aria_label', 'outerwhisper'); ?>">

	<div class="outerwhisper-builder-section-col">
		<!-- Header -->
		<div class="outerwhisper-builder-section-header">
			<h3 class="outerwhisper-builder-section-title"><i class="fas fa-check-circle"></i> <?php esc_html_e('admin.builder.confirmation.title', 'outerwhisper'); ?></h3>
		</div>

		<div class="outerwhisper-builder-section">
			<div style="background-color: #f1f5f9; padding: 12px 16px; border-radius: 6px; font-size: 11.5px; color: var(--outerwhisper-text-secondary); line-height: 1.45;">
				<?php esc_html_e('admin.builder.confirmation.description', 'outerwhisper'); ?>
			</div>

			<div class="outerwhisper-form-group">
				<label for="outerwhisper-style-confirm-type"><?php esc_html_e('admin.builder.confirmation.confirm_type.label', 'outerwhisper'); ?></label>
				<select id="outerwhisper-style-confirm-type" class="outerwhisper-form-select">
					<option value="message" selected><?php esc_html_e('admin.builder.confirmation.confirm_type.message', 'outerwhisper'); ?></option>
					<option value="url"><?php esc_html_e('admin.builder.confirmation.confirm_type.url', 'outerwhisper'); ?></option>
				</select>
			</div>

			<!-- WYSIWYG Message setting container (Matches reference image) -->
			<div class="outerwhisper-form-group">
				<label for="outerwhisper-style-confirm-color"><?php esc_html_e('admin.builder.confirmation.confirm_color.label', 'outerwhisper'); ?></label>
				<div class="outerwhisper-color-picker-row">
					<input type="color" id="outerwhisper-style-confirm-color" class="outerwhisper-form-input" style="width: 60px; height: 36px; padding: 2px; cursor: pointer;" value="#000000" />
					<input type="text" id="outerwhisper-style-confirm-hex" class="outerwhisper-form-input" value="#000000" style="width: 120px;" />
				</div>
			</div>

			<div class="outerwhisper-form-group" id="outerwhisper-config-group-confirm-msg">
				<label for="outerwhisper_confirm_message_text"><?php esc_html_e('admin.builder.confirmation.confirm_message.label', 'outerwhisper'); ?></label>

            <?php
            wp_editor(
                    esc_html__('admin.builder.confirmation.confirm_message.default', 'outerwhisper'),
                    'outerwhisper_confirm_message_text',
                    [
                            'media_buttons' => false,
                            'textarea_name' => 'outerwhisper_form[confirm_message_text]',
                            'textarea_rows' => 1,
                            'tinymce'       => [
                                    'setup' => 'function(ed) { ed.on("init", function() { this.getDoc().body.style.fontSize = "13px"; }); }',
                            ]
                    ]
            );
            ?>

			</div>

			<!-- Custom redirect URL (Initially hidden) -->
			<div class="outerwhisper-form-group" id="outerwhisper-config-group-confirm-ext-url" style="display: none;">
				<label for="outerwhisper-config-confirm-url"><?php esc_html_e('admin.builder.confirmation.redirect_url.label', 'outerwhisper'); ?></label>
				<input type="url" id="outerwhisper-config-confirm-url" class="outerwhisper-form-input" value="<?php esc_attr_e('admin.builder.confirmation.redirect_url.default_value', 'outerwhisper'); ?>" placeholder="<?php esc_attr_e('admin.builder.confirmation.redirect_url.placeholder', 'outerwhisper'); ?>" />
			</div>
		</div>
	</div>
</section>
