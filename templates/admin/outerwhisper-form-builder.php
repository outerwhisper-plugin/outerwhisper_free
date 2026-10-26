<?php

/**
 * OuterWhisper Form Builder Template
 */
if (!defined('ABSPATH')) {
    exit;
}

$outerwhisperStatusText = esc_html__('admin.page.builder.status.paused', 'outerwhisper');
$outerwhisperStatusClass = 'outerwhisper-status-paused';
$outerwhisperStatus = $formData['status'] ?? 1;
switch ($outerwhisperStatus) {
    case 2:
        $outerwhisperStatusText = esc_html__('admin.page.builder.status.live', 'outerwhisper');
        $outerwhisperStatusClass = 'outerwhisper-status-live';
        break;
    case 3:
        $outerwhisperStatusText = esc_html__('admin.page.builder.status.admin_only', 'outerwhisper');
        $outerwhisperStatusClass = 'outerwhisper-status-admin-only';
        break;
}
$outerwhisperDisplayedFormId = '-';
if (!empty($formId) && is_numeric($formId)) {
	$outerwhisperDisplayedFormId = (int) $formId;
}
?>

<!-- OuterWhisper FormBuilder Application Frame -->
<main id="outerwhisper-formbuilder-app" role="main">

    <div class="outerwhisper-formbuilder-frame">

        <!-- Builder Header Area -->
        <div class="outerwhisper-builder-header">

            <!-- Header Top Row (Form Title, Status, Action Buttons) -->
            <div class="outerwhisper-header-top-row">
                <div class="outerwhisper-header-title-container">
                    <div class="outerwhisper-title-input-group">
                        <div class="outerwhisper-form-title-wrapper">
                            <input type="text" id="outerwhisper-form-title" class="outerwhisper-form-title-input" value="<?php echo (esc_html($formData['settings']['main']['title'] ?? '') ?? esc_html__('admin.page.builder.form_title.default', 'outerwhisper'))?>" title="<?php echo esc_html__('admin.page.builder.form_title.edit_title', 'outerwhisper') ?>" />
                            <i class="fas fa-pen text-xs" style="color: #94a3b8; cursor: pointer;"></i>
                        </div>
	                    <span style="font-size: 11px; color: var(--outerwhisper-text-secondary);"><?php esc_html_e('admin.page.builder.form_id', 'outerwhisper'); ?>: <span id="outerwhisper-active-form-id-display"><?php echo esc_html($outerwhisperDisplayedFormId) ?></span>
	                        <span style="margin-left: 12px; border-left: 1px solid rgba(255, 255, 255, 0.2); padding-left: 12px;"><?php esc_html_e('admin.page.builder.last_saved', 'outerwhisper'); ?>: <span id="outerwhisper-last-updated-display"><?php echo '-' ?></span></span>
	                        <span style="margin-left: 12px; border-left: 1px solid rgba(255, 255, 255, 0.2); padding-left: 12px;"><?php esc_html_e('admin.page.builder.last_published', 'outerwhisper'); ?>: <span id="outerwhisper-last-published-display"><?php echo '-' ?></span></span>
	                    </span>
                    </div>
                </div>

                <!-- Action Button Group & Status -->
                <div class="outerwhisper-action-button-group">
                    <!-- Undo and Redo Button Group -->
                    <div class="outerwhisper-header-history-group">
                        <button class="outerwhisper-btn" id="outerwhisper-btn-undo" title="<?php echo esc_attr__('admin.page.builder.undo', 'outerwhisper') ?>" disabled>
                            <i class="fas fa-undo"></i>
                        </button>
                        <button class="outerwhisper-btn" id="outerwhisper-btn-redo" title="<?php echo esc_attr__('admin.page.builder.redo', 'outerwhisper') ?>" disabled>
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>

                    <!-- Combined Status Dropdown Indicator -->
                    <div class="outerwhisper-status-dropdown-container">
                        <button class="outerwhisper-status-wrapper-btn" id="outerwhisper-btn-change-status" title="<?php echo esc_html__('admin.page.builder.change_status', 'outerwhisper') ?>">
                            <div class="outerwhisper-status-indicator <?php echo esc_html($outerwhisperStatusClass) ?>" id="outerwhisper-form-status-badge">
                                <span class="outerwhisper-status-dot"></span>
                                <span id="outerwhisper-form-status-text"><?php echo esc_html($outerwhisperStatusText) ?></span>
                                <i class="fas fa-chevron-down" style="font-size: 8px; opacity: 0.7; margin-left: 2px;"></i>
                            </div>
                        </button>
                        <div class="outerwhisper-status-dropdown-menu" id="outerwhisper-status-dropdown-menu">
                            <div class="outerwhisper-status-dropdown-item" data-status="1">
                                <span class="outerwhisper-status-dot-paused" style="width: 6px; height: 6px; border-radius: 50%; display: inline-block;"></span>
                                <span><?php esc_html_e('admin.page.builder.status.paused', 'outerwhisper'); ?></span>
                                <i class="fas fa-check outerwhisper-status-check"></i>
                            </div>
                            <div class="outerwhisper-status-dropdown-item" data-status="2">
                                <span class="outerwhisper-status-dot-live" style="width: 6px; height: 6px; border-radius: 50%; display: inline-block;"></span>
                                <span><?php esc_html_e('admin.page.builder.status.live', 'outerwhisper'); ?></span>
                                <i class="fas fa-check outerwhisper-status-check"></i>
                            </div>
                            <div class="outerwhisper-status-dropdown-item" data-status="3">
                                <span class="outerwhisper-status-dot-admin" style="width: 6px; height: 6px; border-radius: 50%; display: inline-block;"></span>
                                <span><?php esc_html_e('admin.page.builder.status.admin_only', 'outerwhisper'); ?></span>
                                <i class="fas fa-check outerwhisper-status-check"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Templates & Import/Export as separate small grouped buttons -->
                    <div style="display: flex; gap: 4px; align-items: center;">
                        <button class="outerwhisper-btn" id="outerwhisper-btn-load-templates" title="<?php echo esc_attr__('admin.page.builder.load_templates', 'outerwhisper') ?>" style="padding: 8px 10px; font-size: 12px; height: 34px;">
                            <i class="fas fa-folder-open"></i> <?php esc_html_e('admin.page.builder.templates', 'outerwhisper'); ?>
                        </button>
                        <button class="outerwhisper-btn" id="outerwhisper-btn-export-json" title="<?php echo esc_attr__('admin.page.builder.json_export_import', 'outerwhisper') ?>" style="padding: 8px 10px; font-size: 12px; height: 34px;">
                            <i class="fas fa-code"></i> <?php esc_html_e('admin.page.builder.json_label', 'outerwhisper'); ?>
                        </button>
                    </div>

                    <!-- Save / Publish buttons -->
                    <div style="display: flex; gap: 4px; align-items: center;">
                        <button class="outerwhisper-btn" id="outerwhisper-btn-save-draft" title="<?php echo esc_attr__('admin.page.builder.save_draft', 'outerwhisper') ?>" style="padding: 8px 10px; font-size: 12px; height: 34px;">
                            <i class="fas fa-save"></i> <?php esc_html_e('admin.page.builder.save', 'outerwhisper'); ?>
                        </button>
                        <button class="outerwhisper-btn outerwhisper-btn-primary" id="outerwhisper-btn-publish" title="<?php echo esc_attr__('admin.page.builder.publish', 'outerwhisper') ?>" style="padding: 8px 12px; font-size: 12px; height: 34px;">
                            <i class="fas fa-paper-plane"></i> <?php esc_html_e('admin.page.builder.publish_btn', 'outerwhisper'); ?>
                        </button>
                    </div>

                    <!-- Integrated Preview Segment (Split-View and Fullscreen) -->
                    <div class="outerwhisper-header-preview-segment">
                        <button class="outerwhisper-segment-btn" id="outerwhisper-btn-toggle-split-preview" title="<?php echo esc_attr__('admin.page.builder.split_view_title', 'outerwhisper') ?>">
                            <i class="fas fa-columns"></i> <?php esc_html_e('admin.page.builder.split_view', 'outerwhisper'); ?>
                        </button>
                        <button class="outerwhisper-segment-btn" id="outerwhisper-btn-preview-modal" title="<?php echo esc_attr__('admin.page.builder.preview_modal_title', 'outerwhisper') ?>">
                            <i class="fas fa-expand"></i> <?php esc_html_e('admin.page.builder.preview', 'outerwhisper'); ?>
                        </button>
                    </div>
                </div>

                <button class="outerwhisper-btn outerwhisper-btn-close" id="outerwhisper-btn-close-app" title="<?php echo esc_attr__('admin.page.builder.close_editor', 'outerwhisper') ?>">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Header Bottom Row (Configuration Step Navigation) -->
            <nav class="outerwhisper-header-nav-row" aria-label="<?php echo esc_attr__('admin.page.builder.nav_steps', 'outerwhisper') ?>">
                <div class="outerwhisper-nav-tab" data-view="fields" id="outerwhisper-nav-fields">
                    <i class="fas fa-cubes"></i> <?php esc_html_e('admin.page.builder.nav.fields', 'outerwhisper'); ?>
                </div>
                <div class="outerwhisper-nav-tab" data-view="general" id="outerwhisper-nav-general">
                    <i class="fas fa-cog"></i> <?php esc_html_e('admin.page.builder.nav.general', 'outerwhisper'); ?>
                </div>
                <div class="outerwhisper-nav-tab" data-view="styles" id="outerwhisper-nav-styles">
                    <i class="fas fa-paint-brush"></i> <?php esc_html_e('admin.page.builder.nav.styles', 'outerwhisper'); ?>
                </div>
                <div class="outerwhisper-nav-tab" data-view="display" id="outerwhisper-nav-display">
                    <i class="fas fa-eye"></i> <?php esc_html_e('admin.page.builder.nav.display', 'outerwhisper'); ?>
                </div>
                <div class="outerwhisper-nav-tab" data-view="targeting" id="outerwhisper-nav-targeting">
                    <i class="fas fa-bullseye"></i> <?php esc_html_e('admin.page.builder.nav.targeting', 'outerwhisper'); ?>
                </div>
                <div class="outerwhisper-nav-tab" data-view="confirmation" id="outerwhisper-nav-confirmation">
                    <i class="fas fa-check-circle"></i> <?php esc_html_e('admin.page.builder.nav.confirmation', 'outerwhisper'); ?>
                </div>
                <div class="outerwhisper-nav-tab" data-view="notification" id="outerwhisper-nav-notification">
                    <i class="fas fa-envelope"></i> <?php esc_html_e('admin.page.builder.nav.notification', 'outerwhisper'); ?>
                </div>
                <div class="outerwhisper-nav-tab" data-view="tracking" id="outerwhisper-nav-tracking">
                    <i class="fas fa-chart-line"></i> <?php esc_html_e('admin.page.builder.nav.tracking', 'outerwhisper'); ?>
                </div>
            </nav>

        </div>

        <!-- Content Area split by Selected tab (Loaded dynamically from /src/templates/admin/form-builder/) -->
        <div class="outerwhisper-builder-content-container">

	        <?php
			include OUTERWHISPER_PLUGIN_PATH . 'templates/admin/form-builder/default.php';
            include OUTERWHISPER_PLUGIN_PATH . 'templates/admin/form-builder/fields.php';
            include OUTERWHISPER_PLUGIN_PATH . 'templates/admin/form-builder/general.php';
            include OUTERWHISPER_PLUGIN_PATH . 'templates/admin/form-builder/styles.php';
            include OUTERWHISPER_PLUGIN_PATH . 'templates/admin/form-builder/display.php';
            include OUTERWHISPER_PLUGIN_PATH . 'templates/admin/form-builder/targeting.php';
            include OUTERWHISPER_PLUGIN_PATH . 'templates/admin/form-builder/confirmation.php';
            include OUTERWHISPER_PLUGIN_PATH . 'templates/admin/form-builder/notification.php';
            include OUTERWHISPER_PLUGIN_PATH . 'templates/admin/form-builder/tracking.php';
            ?>

        </div>

    </div>

</main>

<!-- MODAL 1: EXPORT / IMPORT MODAL -->
<div id="outerwhisper-modal-export" class="outerwhisper-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="outerwhisper-json-title">
    <div class="outerwhisper-modal-box" style="max-width: 650px;">
        <div class="outerwhisper-modal-header">
            <h3 class="outerwhisper-modal-title" id="outerwhisper-json-title"><i class="fas fa-code"></i> <?php esc_html_e('admin.page.builder.json_modal.title', 'outerwhisper'); ?></h3>
            <button class="outerwhisper-btn outerwhisper-btn-close" id="outerwhisper-btn-close-export-modal" title="<?php esc_attr_e('admin.page.builder.close', 'outerwhisper'); ?>"><i class="fas fa-times"></i></button>
        </div>
        <div class="outerwhisper-modal-body">
            <p style="margin-bottom: 12px; color: var(--outerwhisper-text-secondary);">
                <?php esc_html_e('admin.page.builder.json_modal.description', 'outerwhisper'); ?>
            </p>

            <div class="outerwhisper-form-group">
                <label for="outerwhisper-json-textarea"><?php esc_html_e('admin.page.builder.json_modal.label', 'outerwhisper'); ?></label>
                <textarea id="outerwhisper-json-textarea" class="outerwhisper-form-textarea" style="min-height: 180px; font-size: 11.5px; background-color: #0f172a; color: #a5f3fc;" placeholder="<?php esc_attr_e('admin.page.builder.json_modal.placeholder', 'outerwhisper'); ?>"></textarea>
            </div>
        </div>
        <div class="outerwhisper-modal-footer">
            <button class="outerwhisper-btn" id="outerwhisper-btn-modal-import-action" style="background-color: var(--outerwhisper-primary); color: white; border-color: var(--outerwhisper-primary);">
                <i class="fas fa-download"></i> <?php esc_html_e('admin.page.builder.json_modal.import_btn', 'outerwhisper'); ?>
            </button>
            <button class="outerwhisper-btn" id="outerwhisper-btn-copy-json" style="background-color: var(--outerwhisper-success); color: white; border-color: var(--outerwhisper-success);">
                <i class="fas fa-copy"></i> <?php esc_html_e('admin.page.builder.json_modal.copy_btn', 'outerwhisper'); ?>
            </button>
            <button class="outerwhisper-btn" id="outerwhisper-btn-close-export-cancel"><?php esc_html_e('admin.page.builder.close', 'outerwhisper'); ?></button>
        </div>
    </div>
</div>

<!-- MODAL 2: LIVE POPUP WIDGET PREVIEW -->
<div id="outerwhisper-modal-preview" class="outerwhisper-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="outerwhisper-preview-title">
    <div class="outerwhisper-modal-box" style="max-width: 900px; width: 95%;">

	    <div id="outerwhisper-preview-simulator-container-modal-box" class="outerwhisper-preview-simulator-container"></div>

    </div>
</div>

<!-- MODAL 3: SELECT TEMPLATE -->
<div id="outerwhisper-modal-templates" class="outerwhisper-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="outerwhisper-tmpl-title">
    <div class="outerwhisper-modal-box" style="max-width: 1200px; width: 95%; max-height: 90vh;">
        <div class="outerwhisper-modal-header">
            <h3 class="outerwhisper-modal-title" id="outerwhisper-tmpl-title"><i class="fas fa-folder-open"></i> <?php esc_html_e('admin.page.builder.modal_tmpl_title', 'outerwhisper'); ?></h3>
            <button class="outerwhisper-btn outerwhisper-btn-close" id="outerwhisper-btn-close-tmpl-modal"><i class="fas fa-times"></i></button>
        </div>
        <div class="outerwhisper-modal-body" style="overflow-y: auto; flex: 1; padding: 24px;">
            <p style="margin-bottom: 20px; color: var(--outerwhisper-text-secondary); font-size: 13.5px;">
                <?php esc_html_e('admin.page.builder.modal_tmpl_desc', 'outerwhisper'); ?>
            </p>

            <div class="outerwhisper-template-grid-new" id="outerwhisper-templates-container">
                <!-- Wird dynamisch befüllt -->
            </div>
        </div>
        <div class="outerwhisper-modal-footer">
            <button class="outerwhisper-btn" id="outerwhisper-btn-close-tmpl-cancel"><?php esc_html_e('admin.page.builder.modal_tmpl_cancel', 'outerwhisper'); ?></button>
        </div>
    </div>
</div>


<!-- PRO / Freemius Upgrade Modal -->
<div id="outerwhisper-modal-pro-upgrade" class="outerwhisper-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="outerwhisper-pro-title">
    <div class="outerwhisper-modal-box" style="max-width: 500px;">
        <div class="outerwhisper-modal-header" style="background-color: var(--outerwhisper-primary-light); border-bottom: 1px solid var(--outerwhisper-border); padding: 16px 24px; border-top-left-radius: 12px; border-top-right-radius: 12px;">
            <h3 class="outerwhisper-modal-title" id="outerwhisper-pro-title" style="color: var(--outerwhisper-primary); font-weight: 700;">
                <i class="fas fa-crown" style="color: var(--outerwhisper-warning);"></i> <?php esc_html_e('admin.page.builder.pro.title', 'outerwhisper'); ?>
            </h3>
            <button class="outerwhisper-btn outerwhisper-btn-close" id="outerwhisper-btn-close-pro-modal"><i class="fas fa-times"></i></button>
        </div>
        <div class="outerwhisper-modal-body" style="padding: 24px;">
            <div style="text-align: center; margin-bottom: 24px;">
                <div style="font-size: 48px; margin-bottom: 12px; color: var(--outerwhisper-warning);">
                    <i class="fas fa-gem"></i>
                </div>
                <h4 style="font-size: 18px; font-weight: 700; color: var(--outerwhisper-text); margin-bottom: 8px;"><?php esc_html_e('admin.page.builder.pro.subtitle', 'outerwhisper'); ?></h4>
                <p style="color: var(--outerwhisper-text-secondary); font-size: 13.5px; line-height: 1.5; margin: 0;">
                    <?php esc_html_e('admin.page.builder.pro.description', 'outerwhisper'); ?>
                </p>
            </div>

            <div style="background-color: var(--outerwhisper-bg); border: 1px solid var(--outerwhisper-border); border-radius: 8px; padding: 16px; margin-bottom: 4px;">
                <h5 style="font-weight: 700; font-size: 13px; color: var(--outerwhisper-text); margin-bottom: 12px; margin-top: 0; text-transform: uppercase; letter-spacing: 0.05em;"><?php esc_html_e('admin.page.builder.pro.benefits_title', 'outerwhisper'); ?></h5>
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 10px; font-size: 13px; padding-left: 0; margin: 0;">
                    <li style="display: flex; align-items: flex-start; gap: 8px; color: var(--outerwhisper-text);">
                        <i class="fas fa-check-circle" style="color: var(--outerwhisper-success); margin-top: 2px;"></i>
                        <span><?php esc_html_e('admin.page.builder.pro.benefit.1', 'outerwhisper'); ?></span>
                    </li>
                    <li style="display: flex; align-items: flex-start; gap: 8px; color: var(--outerwhisper-text);">
                        <i class="fas fa-check-circle" style="color: var(--outerwhisper-success); margin-top: 2px;"></i>
                        <span><?php esc_html_e('admin.page.builder.pro.benefit.2', 'outerwhisper'); ?></span>
                    </li>
                    <li style="display: flex; align-items: flex-start; gap: 8px; color: var(--outerwhisper-text);">
                        <i class="fas fa-check-circle" style="color: var(--outerwhisper-success); margin-top: 2px;"></i>
                        <span><?php esc_html_e('admin.page.builder.pro.benefit.3', 'outerwhisper'); ?></span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="outerwhisper-modal-footer" style="padding: 16px 24px; border-top: 1px solid var(--outerwhisper-border); display: flex; justify-content: flex-end; gap: 12px; background-color: var(--outerwhisper-bg); border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
            <button class="outerwhisper-btn" id="outerwhisper-btn-close-pro-cancel" style="border: 1px solid var(--outerwhisper-border); background: white; color: var(--outerwhisper-text-secondary); font-weight: 550; padding: 8px 16px; border-radius: 6px; cursor: pointer; height: auto;"><?php esc_html_e('admin.page.builder.pro.cancel_btn', 'outerwhisper'); ?></button>
            <a href="https://outerwhisper.de" target="_blank" class="outerwhisper-btn" id="outerwhisper-btn-pro-upgrade-cta" style="background-color: var(--outerwhisper-primary); color: white; font-weight: 600; padding: 8px 20px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; border: 1px solid var(--outerwhisper-primary); box-shadow: var(--outerwhisper-shadow-md); transition: all 0.2s; height: auto;">
                <i class="fas fa-shopping-cart"></i> <?php esc_html_e('admin.page.builder.pro.upgrade_btn', 'outerwhisper'); ?>
            </a>
        </div>
    </div>
</div>

<!-- Generic Preview Shell Template -->
<template id="outerwhisper-preview-shell-template">
	<div class="outerwhisper-form-builder-template-display-preview-panel">
		<div class="outerwhisper-form-builder-template-display-preview-card">
			<!-- Preview Toolbar -->
			<div data-slot="header" class="outerwhisper-form-builder-template-display-preview-toolbar"></div>

			<!-- Simulated Website Stage -->
			<div data-slot="body" class="outerwhisper-form-builder-template-display-stage" id="outerwhisper-display-stage-wrapper">
				<!-- The inner shell for the actual widget/overlay content -->
				<div class="outerwhisper-preview-shell outerwhisper-preview-shell--overlay">
					<div data-slot="inner-header"></div>
					<div data-slot="inner-body"></div>
					<div data-slot="inner-footer"></div>
				</div>
			</div>

			<!-- Status Bar -->
			<div data-slot="footer" class="outerwhisper-form-builder-template-display-preview-footer"></div>
		</div>
	</div>
</template>

<!-- Neues allgemeines Overlay-Formular Template -->
<template id="outerwhisper-general-overlay-template">
    <div class="outerwhisper-feedback-plugin outerwhisper-general-overlay-backdrop" role="dialog" aria-modal="true" aria-labelledby="outerwhisper-general-overlay-title">
        <div class="outerwhisper-general-overlay-modal outerwhisper-overlay-card-pos-center">
            <!-- HEADER -->
            <div class="outerwhisper-overlay-header">
                <!-- Zurück-Button (Sinnvoll bei mehrschrittigen Formularen) -->
                <button id="outerwhisper-general-overlay-back-button" class="outerwhisper-general-overlay-icon-btn" aria-label="<?php echo esc_attr__('admin.builder.overlay_template.back', 'outerwhisper') ?>" style="display: none;">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>

                <!-- Flexibler Indikator-Container (wird dynamisch gesteuert: progress, title, step oder none) -->
                <div id="outerwhisper-general-overlay-header-indicator-wrapper" class="outerwhisper-overlay-header-indicator-wrapper">
                    <!-- Variante 1: Progressbar -->
                    <div id="outerwhisper-general-overlay-progress-bar-container" class="outerwhisper-general-overlay-progress-bar-container" style="display: none;">
                        <div id="outerwhisper-general-overlay-progress-bar" class="outerwhisper-general-overlay-progress-bar"></div>
                    </div>

                    <!-- Variante 2: Formulartitel -->
                    <div id="outerwhisper-general-overlay-title" class="outerwhisper-overlay-header-title" style="display: none;"><?php esc_html_e('admin.builder.overlay_template.feedback', 'outerwhisper'); ?></div>

                    <!-- Variante 3: Schritt-Indikator -->
                    <div id="outerwhisper-general-overlay-step-indicator" class="outerwhisper-overlay-header-step-indicator" style="display: none;"></div>
                </div>

                <!-- Schließen-Button -->
                <button id="outerwhisper-general-overlay-close-button" class="outerwhisper-general-overlay-icon-btn" aria-label="<?php echo esc_attr__('admin.builder.overlay_template.close', 'outerwhisper') ?>">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- BODY -->
            <div class="outerwhisper-overlay-body">
                <div id="outerwhisper-general-overlay-content" class="outerwhisper-feedback-type-placeholder outerwhisper-form-id-1" data-type="overlay" data-form-id="1" data-form-updated="20260717120405"></div>
            </div>

            <!-- FOOTER -->
            <div class="outerwhisper-overlay-footer">
                <?php esc_html_e('admin.builder.overlay_template.footer_text', 'outerwhisper'); ?>
            </div>
        </div>
    </div>
</template>

<!-- Template for dynamic warning banners -->
<template id="outerwhisper-tmpl-warning-banner">
    <div class="outerwhisper-submit-warning-banner">
        <i class="fas fa-exclamation-triangle"></i>
        <span class="outerwhisper-warning-text"></span>
        <span class="outerwhisper-warning-count-badge" style="display: none;"></span>
    </div>
</template>

<!-- Toast Notifications Container -->
<div id="outerwhisper-toast-container" aria-live="polite"></div>