<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<section class="outerwhisper-builder-view outerwhisper-config-screen-layout" id="outerwhisper-view-tracking"
         aria-label="<?php esc_attr_e('admin.builder.tracking.title', 'outerwhisper'); ?>">

	<div class="outerwhisper-builder-section-col">
		<!-- Header -->
		<div class="outerwhisper-builder-section-header">
			<h3 class="outerwhisper-builder-section-title"><i class="fas fa-chart-line"></i> <?php esc_html_e('admin.builder.tracking.title', 'outerwhisper'); ?>
			</h3>
		</div>

		<div class="outerwhisper-builder-section">
			<div style="background-color: #f1f5f9; padding: 12px 16px; border-radius: 6px; font-size: 11.5px; color: var(--outerwhisper-text-secondary); line-height: 1.45; margin-bottom: 20px;">
				<?php esc_html_e('admin.builder.tracking.description', 'outerwhisper'); ?>
			</div>

			<!-- Main toggler activation -->
			<div class="outerwhisper-switch-group">
				<span class="outerwhisper-switch-label" style="font-size: 14px; font-weight: 650; color: var(--outerwhisper-text);">
				<i class="fas fa-toggle-on" style="color: var(--outerwhisper-success);"></i> <?php esc_html_e('admin.builder.tracking.enabled.label', 'outerwhisper'); ?>
				</span>
				<label class="outerwhisper-switch-wrapper" for="outerwhisper-setting-tracking-enabled">
					<input type="checkbox" id="outerwhisper-setting-tracking-enabled" checked/>
					<span class="outerwhisper-switch-slider"></span>
				</label>
			</div>

			<div id="outerwhisper-tracking-settings-fields-group" style="display: flex; flex-direction: column; gap: 14px; margin-top: 10px;">

				<span style="font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 4px;"><?php esc_html_e('admin.builder.tracking.data_points.title', 'outerwhisper'); ?></span>

				<!-- URL -->
				<div class="outerwhisper-switch-group" style="margin-bottom: 0;">
					<span class="outerwhisper-switch-label">
					<i class="fas fa-link" style="width: 16px; color: var(--outerwhisper-primary);"></i> <?php esc_html_e('admin.builder.tracking.url.label', 'outerwhisper'); ?>
					</span>
					<label class="outerwhisper-switch-wrapper" for="outerwhisper-setting-tracking-url">
						<input type="checkbox" id="outerwhisper-setting-tracking-url" checked/>
						<span class="outerwhisper-switch-slider"></span>
					</label>
				</div>

				<!-- Page Title -->
				<div class="outerwhisper-switch-group" style="margin-bottom: 0;">
					<span class="outerwhisper-switch-label">
					<i class="fas fa-heading" style="width: 16px; color: var(--outerwhisper-primary);"></i> <?php esc_html_e('admin.builder.tracking.page_title.label', 'outerwhisper'); ?>
					</span>
					<label class="outerwhisper-switch-wrapper" for="outerwhisper-setting-tracking-pageTitle">
						<input type="checkbox" id="outerwhisper-setting-tracking-pageTitle" checked/>
						<span class="outerwhisper-switch-slider"></span>
					</label>
				</div>

				<!-- Referrer -->
				<div class="outerwhisper-switch-group" style="margin-bottom: 0;">
					<span class="outerwhisper-switch-label">
					<i class="fas fa-sign-in-alt" style="width: 16px; color: var(--outerwhisper-primary);"></i> <?php esc_html_e('admin.builder.tracking.referrer.label', 'outerwhisper'); ?>
					</span>
					<label class="outerwhisper-switch-wrapper" for="outerwhisper-setting-tracking-referrer">
						<input type="checkbox" id="outerwhisper-setting-tracking-referrer" checked/>
						<span class="outerwhisper-switch-slider"></span>
					</label>
				</div>

				<!-- User Agent -->
				<div class="outerwhisper-switch-group" style="margin-bottom: 0;">
					<span class="outerwhisper-switch-label">
					<i class="fas fa-laptop" style="width: 16px; color: var(--outerwhisper-primary);"></i> <?php esc_html_e('admin.builder.tracking.user_agent.label', 'outerwhisper'); ?>
					</span>
					<label class="outerwhisper-switch-wrapper" for="outerwhisper-setting-tracking-userAgent">
						<input type="checkbox" id="outerwhisper-setting-tracking-userAgent" checked/>
						<span class="outerwhisper-switch-slider"></span>
					</label>
				</div>

				<!-- Language -->
				<div class="outerwhisper-switch-group outerwhisper-pro-feature-hint" style="margin-bottom: 0;">
					<span class="outerwhisper-switch-label">
					<i class="fas fa-language" style="width: 16px; color: var(--outerwhisper-primary);"></i> <?php esc_html_e('admin.builder.tracking.language.label', 'outerwhisper'); ?>
					</span>
					<label class="outerwhisper-switch-wrapper" for="outerwhisper-setting-tracking-language">
						<span class="outerwhisper-switch-slider"></span>
					</label>
				</div>

				<!-- Screen Resolution -->
				<div class="outerwhisper-switch-group outerwhisper-pro-feature-hint" style="margin-bottom: 0;">
					<span class="outerwhisper-switch-label">
					<i class="fas fa-desktop" style="width: 16px; color: var(--outerwhisper-primary);"></i> <?php esc_html_e('admin.builder.tracking.screen_resolution.label', 'outerwhisper'); ?>
					</span>
					<label class="outerwhisper-switch-wrapper" for="outerwhisper-setting-tracking-screenResolution">
						<span class="outerwhisper-switch-slider"></span>
					</label>
				</div>

				<!-- Viewport Size -->
				<div class="outerwhisper-switch-group outerwhisper-pro-feature-hint" style="margin-bottom: 0;">
					<span class="outerwhisper-switch-label">
					<i class="fas fa-window-maximize" style="width: 16px; color: var(--outerwhisper-primary);"></i> <?php esc_html_e('admin.builder.tracking.viewport_size.label', 'outerwhisper'); ?>
					</span>
					<label class="outerwhisper-switch-wrapper" for="outerwhisper-setting-tracking-viewportSize">
						<span class="outerwhisper-switch-slider"></span>
					</label>
				</div>

				<!-- Timezone -->
				<div class="outerwhisper-switch-group outerwhisper-pro-feature-hint" style="margin-bottom: 0;">
					<span class="outerwhisper-switch-label">
					<i class="fas fa-globe" style="width: 16px; color: var(--outerwhisper-primary);"></i> <?php esc_html_e('admin.builder.tracking.timezone.label', 'outerwhisper'); ?>
					</span>
					<label class="outerwhisper-switch-wrapper" for="outerwhisper-setting-tracking-timezone">
						<span class="outerwhisper-switch-slider"></span>
					</label>
				</div>

				<!-- Connection Type -->
				<div class="outerwhisper-switch-group outerwhisper-pro-feature-hint" style="margin-bottom: 0;">
				<span class="outerwhisper-switch-label">
				<i class="fas fa-wifi" style="width: 16px; color: var(--outerwhisper-primary);"></i> <?php esc_html_e('admin.builder.tracking.connection_type.label', 'outerwhisper'); ?>
				</span>
					<label class="outerwhisper-switch-wrapper" for="outerwhisper-setting-tracking-connectionType">
						<span class="outerwhisper-switch-slider"></span>
					</label>
				</div>

				<!-- Device Type -->
				<div class="outerwhisper-switch-group outerwhisper-pro-feature-hint" style="margin-bottom: 0;">
				<span class="outerwhisper-switch-label">
				<i class="fas fa-mobile-alt" style="width: 16px; color: var(--outerwhisper-primary);"></i> <?php esc_html_e('admin.builder.tracking.device_type.label', 'outerwhisper'); ?>
				</span>
					<label class="outerwhisper-switch-wrapper" for="outerwhisper-setting-tracking-deviceType">
						<span class="outerwhisper-switch-slider"></span>
					</label>
				</div>

				<!-- Session ID -->
				<div class="outerwhisper-switch-group outerwhisper-pro-feature-hint" style="margin-bottom: 0;">
				<span class="outerwhisper-switch-label">
				<i class="fas fa-id-badge" style="width: 16px; color: var(--outerwhisper-primary);"></i> <?php esc_html_e('admin.builder.tracking.session_id.label', 'outerwhisper'); ?>
				</span>
					<label class="outerwhisper-switch-wrapper" for="outerwhisper-setting-tracking-anonymizedSessionId">
						<span class="outerwhisper-switch-slider"></span>
					</label>
				</div>

				<!-- Time on Page -->
				<div class="outerwhisper-switch-group outerwhisper-pro-feature-hint" style="margin-bottom: 0;">
				<span class="outerwhisper-switch-label">
				<i class="fas fa-hourglass-half" style="width: 16px; color: var(--outerwhisper-primary);"></i> <?php esc_html_e('admin.builder.tracking.time_on_page.label', 'outerwhisper'); ?>
				</span>
					<label class="outerwhisper-switch-wrapper" for="outerwhisper-setting-tracking-timeOnPageSeconds">
						<span class="outerwhisper-switch-slider"></span>
					</label>
				</div>

				<!-- Color Scheme -->
				<div class="outerwhisper-switch-group outerwhisper-pro-feature-hint" style="margin-bottom: 0;">
				<span class="outerwhisper-switch-label">
				<i class="fas fa-adjust" style="width: 16px; color: var(--outerwhisper-primary);"></i> <?php esc_html_e('admin.builder.tracking.color_scheme.label', 'outerwhisper'); ?>
				</span>
					<label class="outerwhisper-switch-wrapper" for="outerwhisper-setting-tracking-colorScheme">
						<span class="outerwhisper-switch-slider"></span>
					</label>
				</div>

			</div>
		</div>
	</div>
</section>