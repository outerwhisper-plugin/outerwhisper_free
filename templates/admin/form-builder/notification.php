<?php
if (!defined('ABSPATH')) {
	exit;
}
?>

<section class="outerwhisper-builder-view outerwhisper-config-screen-layout" id="outerwhisper-view-notification" aria-label="<?php esc_attr_e('admin.builder.notification.title', 'outerwhisper'); ?>">

	<div class="outerwhisper-builder-section-col">
		<!-- Header -->
		<div class="outerwhisper-builder-section-header">
			<h3 class="outerwhisper-builder-section-title"><i class="fas fa-envelope"></i> <?php esc_html_e('admin.builder.notification.title', 'outerwhisper'); ?></h3>
		</div>

		<div class="outerwhisper-builder-section">
			<div style="background-color: #f1f5f9; padding: 12px 16px; border-radius: 6px; font-size: 11.5px; color: var(--outerwhisper-text-secondary); line-height: 1.45; margin-bottom: 20px;">
				<?php esc_html_e('admin.builder.notification.description', 'outerwhisper'); ?>
			</div>

			<!-- Main toggler activation -->
			<div class="outerwhisper-switch-group">
		      <span class="outerwhisper-switch-label" style="font-size: 14px; font-weight: 650; color: var(--outerwhisper-text);">
		        <i class="fas fa-toggle-on" style="color: var(--outerwhisper-success);"></i> <?php esc_html_e('admin.builder.notification.enabled.label', 'outerwhisper'); ?>
		      </span>
				<label class="outerwhisper-switch-wrapper" for="outerwhisper-notification-enabled">
					<input type="checkbox" id="outerwhisper-notification-enabled" checked />
					<span class="outerwhisper-switch-slider"></span>
				</label>
			</div>

			<div id="outerwhisper-notification-settings-fields-group" style="display: flex; flex-direction: column; gap: 20px;">

				<div class="outerwhisper-form-group">
					<label for="outerwhisper-notify-recipient"><?php esc_html_e('admin.builder.notification.recipient.label', 'outerwhisper'); ?> <i class="fas fa-question-circle outerwhisper-help-tip" title="<?php esc_html_e('admin.builder.notification.recipient.hint', 'outerwhisper'); ?>"></i></label>
					<div class="outerwhisper-color-picker-row">
						<input type="text" id="outerwhisper-notify-recipient" class="outerwhisper-form-input" value="<?php esc_html_e('admin.builder.notification.recipient.default', 'outerwhisper'); ?>" />
					</div>
				</div>

				<div class="outerwhisper-form-group">
					<label for="outerwhisper-notify-subject"><?php esc_html_e('admin.builder.notification.subject.label', 'outerwhisper'); ?></label>
					<div class="outerwhisper-color-picker-row">
						<input type="text" id="outerwhisper-notify-subject" class="outerwhisper-form-input" value="<?php esc_html_e('admin.builder.notification.subject.default', 'outerwhisper'); ?>" />
					</div>
				</div>

				<div class="outerwhisper-form-group">
					<label for="outerwhisper-notify-sender-name"><?php esc_html_e('admin.builder.notification.sender_name.label', 'outerwhisper'); ?></label>
					<div class="outerwhisper-color-picker-row">
						<input type="text" id="outerwhisper-notify-sender-name" class="outerwhisper-form-input" value="<?php esc_html_e('admin.builder.notification.sender_name.default', 'outerwhisper'); ?>" />
					</div>
				</div>

				<div class="outerwhisper-form-group">
					<label for="outerwhisper-notify-sender-email"><?php esc_html_e('admin.builder.notification.sender_email.label', 'outerwhisper'); ?></label>
					<div class="outerwhisper-color-picker-row">
						<input type="email" id="outerwhisper-notify-sender-email" class="outerwhisper-form-input" value="info@my-website.com" />
					</div>
				</div>

			</div>
		</div>
	</div>
</section>