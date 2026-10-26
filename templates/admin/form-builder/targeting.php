<?php
if (!defined('ABSPATH')) {
	exit;
}
?>

<section class="outerwhisper-builder-view outerwhisper-config-screen-layout" id="outerwhisper-view-targeting" aria-label="<?php esc_attr_e('admin.builder.targeting.title', 'outerwhisper'); ?>">

	<div class="outerwhisper-builder-section-col">
		<!-- Header -->
		<div class="outerwhisper-builder-section-header">
			<h3 class="outerwhisper-builder-section-title"><i class="fas fa-bullseye"></i> <?php esc_html_e('admin.builder.targeting.header', 'outerwhisper'); ?></h3>
		</div>

		<div class="outerwhisper-builder-section">
			<div style="background-color: #f1f5f9; padding: 12px 16px; border-radius: 6px; font-size: 11.5px; color: var(--outerwhisper-text-secondary); line-height: 1.45; margin-bottom: 20px;">
				<?php esc_html_e('admin.builder.targeting.description', 'outerwhisper'); ?>
			</div>

			<!-- Segmented Display Type Sub-Tabs inside Targeting -->
			<div id="outerwhisper-targeting-tabs-container" class="outerwhisper-targeting-tabs" style="display: flex; gap: 8px; margin-bottom: 24px; border-bottom: 2px solid var(--outerwhisper-border); padding-bottom: 12px; overflow-x: auto;">
				<!-- Dynamisch erzeugt basierend auf Hauptanzeigetyp -->
			</div>

			<!-- Targeting Inputs Form Container acting on current sub-tab -->
			<div id="outerwhisper-targeting-condition-builder-container"></div>
		</div>
	</div>
</section>
