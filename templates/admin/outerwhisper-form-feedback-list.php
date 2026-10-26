<?php
if (!defined('ABSPATH')) {
	exit;
}
?>

<section id="outerwhisper-view-start" class="outerwhisper-view-section outerwhisper-form-feedback-list">
	<header class="outerwhisper-view-header flex-row">
		<h2 style="font-size: 24px; font-weight: 600; margin: 0 0 25px 0; color: var(--outerwhisper-primary-color);"><?php esc_html_e('admin.page.feedback_list.title', 'outerwhisper'); ?></h2>
	</header>

	<form method="get">
		<input type="hidden" name="page" value="outerwhisper-form-feedbacks" />
		<?php wp_nonce_field('outerwhisper_admin_nonce', 'nonce'); ?>
		<?php $feedback_table->display(); ?>
	</form>

	<div id="outerwhisper-modal-backdrop" class="outerwhisper-modal-backdrop hidden"></div>
	<div id="outerwhisper-modal-container" class="outerwhisper-modal-container hidden"></div>

	<template id="outerwhisper-feedback-details-modal">
		<div class="outerwhisper-modal outerwhisper-feedback-dialog-container">
			<header class="outerwhisper-modal-header outerwhisper-feedback-dialog-header">
				<div style="display: flex; align-items: center; gap: 12px;">
					<div class="outerwhisper-feedback-avatar" id="outerwhisper-modal-avatar-wrapper">
						<i class="fas fa-comment-dots"></i>
					</div>
					<div>
						<h2 id="outerwhisper-modal-feedback-id-title" style="margin: 0; font-size: 1.15rem; font-weight: 600;"><?php esc_html_e('admin.page.feedback_list.modal.id_title', 'outerwhisper'); ?></h2>
						<p style="margin: 2px 0 0 0; font-size: 0.75rem; color: var(--outerwhisper-text-secondary);"><?php esc_html_e('admin.page.feedback_list.modal.created_at', 'outerwhisper'); ?> <span id="outerwhisper-modal-date-text" style="font-weight: 500;">{{date}}</span></p>
					</div>
				</div>
				<button class="outerwhisper-modal-modal-close" id="outerwhisper-modal-btn-close-modal" aria-label="<?php echo esc_attr__('admin.page.feedback_list.modal.close', 'outerwhisper') ?>"><i class="fas fa-times"></i></button>
			</header>

			<div class="outerwhisper-modal-scrollable-body" style="background-color: #f6f8fb;">
				<div class="outerwhisper-details-grid-layout">

					<!-- LINKER BEREICH: FORMULAR (USERWERTE) -->
					<div style="display: flex; flex-direction: column; gap: 20px;">
						<!-- BEARBEITUNGS-STATUS -->
						<div class="outerwhisper-details-card">
							<div class="outerwhisper-card-title-bar">
								<i class="fas fa-tasks" style="color: var(--app-primary-color);"></i>
								<h3><?php esc_html_e('admin.page.feedback_list.modal.status.title', 'outerwhisper'); ?></h3>
							</div>
							<div class="outerwhisper-status-segmented-control" id="outerwhisper-modal-status-control">
								<button type="button" class="outerwhisper-status-btn" data-status="unread">
									<i class="far fa-envelope"></i> <?php esc_html_e('admin.page.feedback_list.modal.status.unread', 'outerwhisper'); ?>
								</button>
								<button type="button" class="outerwhisper-status-btn" data-status="read">
									<i class="far fa-envelope-open"></i> <?php esc_html_e('admin.page.feedback_list.modal.status.read', 'outerwhisper'); ?>
								</button>
								<button type="button" class="outerwhisper-status-btn" data-status="archived">
									<i class="fas fa-archive"></i> <?php esc_html_e('admin.page.feedback_list.modal.status.archived', 'outerwhisper'); ?>
								</button>
							</div>
						</div>

						<!-- KUNDEN-FORMULARWERTE -->
						<div class="outerwhisper-details-card outerwhisper-details-form-card">
							<div class="outerwhisper-card-title-bar">
								<i class="fas fa-file-invoice" style="color: var(--app-primary-color);"></i>
								<h3><?php esc_html_e('admin.page.feedback_list.modal.customer_form_values', 'outerwhisper'); ?></h3>
							</div>

							<div class="outerwhisper-form-body">
								<div id="outerwhisper-admin-feedback-form-render" class="outerwhisper-feedback-plugin outerwhisper-form-frontend-wrapper" data-is-admin="1"></div>

								<!-- URL der Einsendung -->
								<div class="outerwhisper-form-group-item">
									<label class="outerwhisper-form-field-label"><?php esc_html_e('admin.page.feedback_list.modal.source_url', 'outerwhisper'); ?></label>
									<div style="margin-bottom: 8px; font-size: 0.85rem; color: var(--outerwhisper-primary-color); font-weight: 600;" id="outerwhisper-modal-page-path"></div>
									<div class="outerwhisper-copyable-input-group">
										<input type="text" id="outerwhisper-input-source-url" class="outerwhisper-form-text-control" readonly style="font-family: monospace; font-size: 0.8rem;">
										<button id="outerwhisper-btn-copy-url" class="outerwhisper-form-copy-btn" type="button" title="<?php echo esc_attr__('admin.page.feedback_list.modal.copy_to_clipboard', 'outerwhisper') ?>">
											<i class="far fa-copy"></i>
										</button>
										<button id="outerwhisper-btn-open-url" class="outerwhisper-form-open-btn" type="button" title="<?php echo esc_attr__('admin.page.feedback_list.modal.open_in_new_window', 'outerwhisper') ?>">
											<i class="fas fa-external-link-alt"></i>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- RECHTER BEREICH: TRACKING INFORMATIONEN -->
					<div class="outerwhisper-details-card outerwhisper-details-tracking-card">
						<div class="outerwhisper-card-title-bar">
							<i class="fas fa-satellite-dish" style="color: var(--outerwhisper-primary-color); animation: pulse 2s infinite;"></i>
							<h3><?php esc_html_e('admin.page.feedback_list.modal.tracking.title', 'outerwhisper'); ?></h3>
						</div>

						<div class="outerwhisper-tracking-grid">

							<!-- UserAgent -->
							<div class="outerwhisper-tracking-metric-box full-width">
								<div class="outerwhisper-metric-icon-sphere"><i class="fas fa-info-circle"></i></div>
								<div class="outerwhisper-metric-info-block">
									<span class="outerwhisper-metric-label" title="<?php echo esc_attr__('admin.page.feedback_list.modal.tracking.user_agent', 'outerwhisper') ?>"><?php esc_html_e('admin.page.feedback_list.modal.tracking.user_agent', 'outerwhisper') ?></span>
									<div class="outerwhisper-track-ua-text" id="outerwhisper-track-useragent" style="font-size: 0.75rem; color: var(--outerwhisper-text-secondary); word-break: break-all; line-height: 1.3;">-</div>
								</div>
							</div>
						</div>

						<!-- Collapse Section JSON -->
						<div class="outerwhisper-raw-data-section" style="margin-top: 20px; border-top: 1px dashed #e2e8f0; padding-top: 15px;">
							<button class="outerwhisper-raw-toggle-btn" id="outerwhisper-btn-raw-toggle" type="button" style="background: none; border: none; font-size: 0.8rem; color: var(--outerwhisper-primary-color); cursor: pointer; display: flex; align-items: center; justify-content: space-between; width: 100%; padding: 4px 6px; border-radius: 4px; transition: background 0.2s;">
								<span style="font-weight: 600;" title="<?php echo esc_attr__('admin.page.feedback_list.modal.json_data', 'outerwhisper') ?>"><i class="fas fa-code" style="margin-right: 6px;"></i> <?php esc_html_e('admin.page.feedback_list.modal.json_data', 'outerwhisper') ?></span>
								<i class="fas fa-chevron-down" id="outerwhisper-raw-chevron"></i>
							</button>
							<pre class="outerwhisper-raw-json-pre hidden" id="outerwhisper-raw-json-block" style="background: #1e293b; color: #38bdf8; font-family: monospace; font-size: 0.75rem; padding: 12px; border-radius: 6px; margin-top: 10px; max-height: 150px; overflow-y: auto; text-align: left;"></pre>
						</div>
					</div>

				</div>
			</div>

			<footer class="outerwhisper-modal-modal-footer" style="padding: 1rem 1.5rem; display: flex; justify-content: flex-end; background-color: #f8f9fa; border-top: 1px solid var(--outerwhisper-border-color);">
				<button class="outerwhisper-modal-btn-secondary" id="outerwhisper-modal-btn-modal-done" style="font-weight: 500; font-size: 0.85rem; padding: 8px 16px; border-radius: var(--outerwhisper-radius);"><?php esc_html_e('admin.page.feedback_list.modal.close_button', 'outerwhisper'); ?></button>
			</footer>
		</div>
	</template>

</section>