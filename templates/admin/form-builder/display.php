<?php
if (!defined('ABSPATH')) {
	exit;
}
?>

<section class="outerwhisper-builder-view outerwhisper-config-screen-layout" id="outerwhisper-view-display" aria-label="Widget Display">

    <div class="outerwhisper-settings-wrapper outerwhisper-form-builder-template-display-layout-grid">

        <!-- LEFT COLUMN: SETTINGS FORM -->
        <div class="outerwhisper-form-builder-template-display-left-col">

            <!-- Top Header -->
            <div class="outerwhisper-builder-section-header">
                <h3 class="outerwhisper-builder-section-title" style="margin-bottom: 0;">
                    <i class="fas fa-eye" style="color: var(--outerwhisper-primary);"></i> <?php esc_html_e('admin.builder.display.header.title', 'outerwhisper'); ?>
                </h3>
            </div>

            <!-- Hidden compatibility inputs for legacy bindings -->
            <input type="hidden" id="outerwhisper-style-display-type" value="in-content" />

            <!-- SECTION 1: HAUPTANZEIGETYP WÄHLEN -->
            <div class="outerwhisper-form-builder-template-display-section">
                <div class="outerwhisper-form-builder-template-display-section-header">
                    <h4 class="outerwhisper-form-builder-template-display-section-title">
                        <i class="fas fa-layer-group"></i> <?php esc_html_e('admin.builder.display.section1.title', 'outerwhisper'); ?>
                    </h4>
                    <span class="outerwhisper-form-builder-template-display-badge"><?php esc_html_e('admin.builder.display.step1', 'outerwhisper'); ?></span>
                </div>
                <p class="outerwhisper-form-builder-template-display-desc">
                    <?php esc_html_e('admin.builder.display.section1.description', 'outerwhisper'); ?>
                </p>

                <div class="outerwhisper-form-builder-template-display-grid-cards">
                    <!-- Card 1: In-Content -->
                    <div class="outerwhisper-form-builder-template-display-type-card active" data-type="in-content" data-subtype="shortcode">
                        <div class="outerwhisper-form-builder-template-display-type-card-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="outerwhisper-form-builder-template-display-type-card-content">
                            <h4><?php esc_html_e('admin.builder.display.card1.title', 'outerwhisper'); ?></h4>
                            <p><?php esc_html_e('admin.builder.display.card1.description', 'outerwhisper'); ?></p>
                        </div>
                        <div class="outerwhisper-form-builder-template-display-card-indicator">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>

                    <!-- Card 2: Overlay Pop-Up -->
                    <div class="outerwhisper-form-builder-template-display-type-card" data-type="overlay" data-subtype="modal">
                        <div class="outerwhisper-form-builder-template-display-type-card-icon">
                            <i class="fas fa-window-restore"></i>
                        </div>
                        <div class="outerwhisper-form-builder-template-display-type-card-content">
                            <h4><?php esc_html_e('admin.builder.display.card2.title', 'outerwhisper'); ?></h4>
                            <p><?php esc_html_e('admin.builder.display.card2.description', 'outerwhisper'); ?></p>
                        </div>
                        <div class="outerwhisper-form-builder-template-display-card-indicator">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>

                    <!-- Card 3: Slide-In Panel -->
                    <div class="outerwhisper-form-builder-template-display-type-card" data-type="overlay" data-subtype="slide-in">
                        <div class="outerwhisper-form-builder-template-display-type-card-icon">
                            <i class="fas fa-square-parking"></i>
                        </div>
                        <div class="outerwhisper-form-builder-template-display-type-card-content">
                            <h4><?php esc_html_e('admin.builder.display.card3.title', 'outerwhisper'); ?></h4>
                            <p><?php esc_html_e('admin.builder.display.card3.description', 'outerwhisper'); ?></p>
                        </div>
                        <div class="outerwhisper-form-builder-template-display-card-indicator">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>

                    <!-- Card 4: Floating Feedback Button -->
                    <div class="outerwhisper-form-builder-template-display-type-card" data-type="overlay" data-subtype="feedback-button">
                        <div class="outerwhisper-form-builder-template-display-type-card-icon">
                            <i class="fas fa-comment-dots"></i>
                        </div>
                        <div class="outerwhisper-form-builder-template-display-type-card-content">
                            <h4><?php esc_html_e('admin.builder.display.card4.title', 'outerwhisper'); ?></h4>
                            <p><?php esc_html_e('admin.builder.display.card4.description', 'outerwhisper'); ?></p>
                        </div>
                        <div class="outerwhisper-form-builder-template-display-card-indicator">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <!-- In-Content Specific Sub-Option: Automatic insertion -->
                <div id="outerwhisper-incontent-sub-options" style="margin-top: 14px; padding: 12px; background: #f8fafc; border-radius: 8px; border: 1px solid var(--outerwhisper-border);">
                    <div class="outerwhisper-switch-group" style="margin-bottom: 0;">
            <span class="outerwhisper-switch-label" style="font-weight: 600; font-size: 12px;">
              <i class="fas fa-magic" style="color: var(--outerwhisper-primary); font-size: 12px;"></i> <?php esc_html_e('admin.builder.display.in_content.auto_insert', 'outerwhisper'); ?>
            </span>
                        <label class="outerwhisper-switch-wrapper" for="outerwhisper-style-display-in-content">
                            <input type="checkbox" id="outerwhisper-style-display-in-content" />
                            <span class="outerwhisper-switch-slider"></span>
                        </label>
                    </div>
                    <div id="outerwhisper-in-content-auto-position-group" style="display: none; margin-top: 10px; flex-direction: column; gap: 6px;">
                        <label for="outerwhisper-style-in-content-position" style="font-size: 11.5px; font-weight: 600;"><?php esc_html_e('admin.builder.display.in_content.position.label', 'outerwhisper'); ?></label>
                        <select id="outerwhisper-style-in-content-position" class="outerwhisper-form-select" style="height: 34px;">
                            <option value="bottom" selected><?php esc_html_e('admin.builder.display.in_content.position.bottom', 'outerwhisper'); ?></option>
                            <option value="top"><?php esc_html_e('admin.builder.display.in_content.position.top', 'outerwhisper'); ?></option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: AUSLÖSER & TIMING (TRIGGERS) -->
            <div class="outerwhisper-form-builder-template-display-section" id="outerwhisper-display-section-triggers" style="display: none;">
                <div class="outerwhisper-form-builder-template-display-section-header">
                    <h4 class="outerwhisper-form-builder-template-display-section-title">
                        <i class="fas fa-bolt"></i> <?php esc_html_e('admin.builder.display.section2.title', 'outerwhisper'); ?>
                    </h4>
                    <span class="outerwhisper-form-builder-template-display-badge"><?php esc_html_e('admin.builder.display.step2', 'outerwhisper'); ?></span>
                </div>
                <p class="outerwhisper-form-builder-template-display-desc">
                    <?php esc_html_e('admin.builder.display.section2.description', 'outerwhisper'); ?>
                </p>

                <!-- Hidden trigger select for compatibility -->
                <select id="outerwhisper-style-overlay-trigger" style="display: none;">
                    <option value="click">click</option>
                    <option value="exit-intent">exit-intent</option>
                    <option value="delay">delay</option>
                    <option value="scroll">scroll</option>
                </select>

                <!-- Segmented Control for Triggers -->
                <div class="outerwhisper-form-builder-template-display-segmented-control" id="outerwhisper-display-trigger-segmented-control">
                    <button type="button" class="outerwhisper-form-builder-template-display-segment-btn active" data-trigger="click">
                        <i class="fas fa-mouse-pointer"></i> <?php esc_html_e('admin.builder.display.trigger.click', 'outerwhisper'); ?>
                    </button>
                    <button type="button" class="outerwhisper-form-builder-template-display-segment-btn" data-trigger="exit-intent">
                        <i class="fas fa-door-open"></i> <?php esc_html_e('admin.builder.display.trigger.exit_intent', 'outerwhisper'); ?>
                    </button>
                    <button type="button" class="outerwhisper-form-builder-template-display-segment-btn" data-trigger="delay">
                        <i class="fas fa-clock"></i> <?php esc_html_e('admin.builder.display.trigger.delay', 'outerwhisper'); ?>
                    </button>
                    <button type="button" class="outerwhisper-form-builder-template-display-segment-btn" data-trigger="scroll">
                        <i class="fas fa-arrows-alt-v"></i> <?php esc_html_e('admin.builder.display.trigger.scroll', 'outerwhisper'); ?>
                    </button>
                </div>

                <!-- Trigger Detail Card -->
                <div class="outerwhisper-form-builder-template-display-trigger-detail-card" id="outerwhisper-display-trigger-content">

                    <!-- Panel Click -->
                    <div id="outerwhisper-overlay-trigger-panel-click" style="display: flex; flex-direction: column; gap: 10px;">
                        <div class="outerwhisper-form-group" id="outerwhisper-overlay-click-selector-group" style="margin-bottom: 0;">
                            <label for="outerwhisper-style-overlay-click-selector" class="outerwhisper-form-builder-template-display-label"><?php esc_html_e('admin.builder.display.trigger.click.selector.label', 'outerwhisper'); ?></label>
                            <input type="text" id="outerwhisper-style-overlay-click-selector" class="outerwhisper-form-input" placeholder="#my-feedback-btn, .open-feedback" style="height: 34px; font-size: 12.5px;" />
                            <span class="outerwhisper-form-builder-template-display-hint"><?php esc_html_e('admin.builder.display.trigger.click.hint', 'outerwhisper'); ?></span>
                        </div>

                        <div class="outerwhisper-switch-group" id="outerwhisper-overlay-click-use-standard-toggle-group" style="margin-top: 6px; margin-bottom: 0; display: none;">
                            <span class="outerwhisper-switch-label" style="font-size: 11.5px;"><?php esc_html_e('admin.builder.display.trigger.click.standard_button.label', 'outerwhisper'); ?></span>
                            <label class="outerwhisper-switch-wrapper" for="outerwhisper-style-overlay-click-use-standard">
                                <input type="checkbox" id="outerwhisper-style-overlay-click-use-standard" checked />
                                <span class="outerwhisper-switch-slider"></span>
                            </label>
                        </div>
                    </div>

                    <!-- Panel Exit-Intent -->
                    <div id="outerwhisper-overlay-trigger-panel-exit-intent" style="display: none; flex-direction: column; gap: 10px;">
                        <p class="outerwhisper-form-builder-template-display-hint">
                            <i class="fas fa-info-circle" style="color: var(--outerwhisper-primary);"></i> <?php esc_html_e('admin.builder.display.trigger.exit_intent.hint', 'outerwhisper'); ?>
                        </p>
                        <div class="outerwhisper-form-group" style="margin-bottom: 0;">
                            <label for="outerwhisper-style-exit-intent-delay" class="outerwhisper-form-builder-template-display-label"><?php esc_html_e('admin.builder.display.trigger.exit_intent.sensitivity.label', 'outerwhisper'); ?></label>
                            <select id="outerwhisper-style-exit-intent-delay" class="outerwhisper-form-select" style="height: 34px;">
                                <option value="immediate" selected><?php esc_html_e('admin.builder.display.trigger.exit_intent.sensitivity.immediate', 'outerwhisper'); ?></option>
                                <option value="5s"><?php esc_html_e('admin.builder.display.trigger.exit_intent.sensitivity.5s', 'outerwhisper'); ?></option>
                                <option value="10s"><?php esc_html_e('admin.builder.display.trigger.exit_intent.sensitivity.10s', 'outerwhisper'); ?></option>
                                <option value="60s"><?php esc_html_e('admin.builder.display.trigger.exit_intent.sensitivity.60s', 'outerwhisper'); ?></option>
                            </select>
                        </div>
                    </div>

                    <!-- Panel Delay -->
                    <div id="outerwhisper-overlay-trigger-panel-delay" style="display: none; flex-direction: column; gap: 10px;">
                        <p class="outerwhisper-form-builder-template-display-hint">
                            <i class="fas fa-clock" style="color: var(--outerwhisper-primary);"></i> <?php esc_html_e('admin.builder.display.trigger.delay.hint', 'outerwhisper'); ?>
                        </p>
                        <div class="outerwhisper-form-group" style="margin-bottom: 0;">
                            <label for="outerwhisper-style-overlay-delay-seconds" class="outerwhisper-form-builder-template-display-label"><?php esc_html_e('admin.builder.display.trigger.delay.label', 'outerwhisper'); ?></label>
                            <input type="number" id="outerwhisper-style-overlay-delay-seconds" class="outerwhisper-form-input" min="1" max="3600" value="5" style="height: 34px;" />
                        </div>
                    </div>

                    <!-- Panel Scroll -->
                    <div id="outerwhisper-overlay-trigger-panel-scroll" style="display: none; flex-direction: column; gap: 10px;">
                        <p class="outerwhisper-form-builder-template-display-hint">
                            <i class="fas fa-arrows-alt-v" style="color: var(--outerwhisper-primary);"></i> <?php esc_html_e('admin.builder.display.trigger.scroll.hint', 'outerwhisper'); ?>
                        </p>
                        <div class="outerwhisper-form-group" style="margin-bottom: 0;">
                            <label for="outerwhisper-style-overlay-scroll-type" class="outerwhisper-form-builder-template-display-label"><?php esc_html_e('admin.builder.display.trigger.scroll.condition.label', 'outerwhisper'); ?></label>
                            <select id="outerwhisper-style-overlay-scroll-type" class="outerwhisper-form-select" style="height: 34px;">
                                <option value="end" selected><?php esc_html_e('admin.builder.display.trigger.scroll.condition.end', 'outerwhisper'); ?></option>
                                <option value="percent"><?php esc_html_e('admin.builder.display.trigger.scroll.condition.percent', 'outerwhisper'); ?></option>
                            </select>
                        </div>
                        <div id="outerwhisper-overlay-scroll-percent-container" class="outerwhisper-form-group" style="display: none; margin-bottom: 0;">
                            <label for="outerwhisper-style-overlay-scroll-percent" class="outerwhisper-form-builder-template-display-label"><?php esc_html_e('admin.builder.display.trigger.scroll.percent.label', 'outerwhisper'); ?></label>
                            <input type="number" id="outerwhisper-style-overlay-scroll-percent" class="outerwhisper-form-input" min="1" max="100" value="50" style="height: 34px;" />
                        </div>
                    </div>

                </div>
            </div>

            <!-- SECTION 2B: FEEDBACK-BUTTON EINSTELLUNGEN -->
            <div class="outerwhisper-form-builder-template-display-section" id="outerwhisper-display-section-feedback-button" style="display: none;">
                <div class="outerwhisper-form-builder-template-display-section-header">
                    <h4 class="outerwhisper-form-builder-template-display-section-title">
                        <i class="fas fa-comment-alt"></i> 2. <?php esc_html_e('admin.builder.display.feedback_button.title', 'outerwhisper'); ?>
                    </h4>
                    <span class="outerwhisper-form-builder-template-display-badge"><?php esc_html_e('admin.builder.display.step.2', 'outerwhisper'); ?></span>
                </div>
                <p class="outerwhisper-form-builder-template-display-desc">
                    <?php esc_html_e('admin.builder.display.feedback_button.description', 'outerwhisper'); ?>
                </p>

                <div class="outerwhisper-form-builder-template-display-trigger-detail-card" id="outerwhisper-overlay-click-standard-btn-group" style="display: flex; flex-direction: column; gap: 10px;">
                    <div class="outerwhisper-form-group" style="margin-bottom: 0;">
                        <label for="outerwhisper-style-feedback-btn-text" class="outerwhisper-form-builder-template-display-label"><?php esc_html_e('admin.builder.display.feedback_button.label.text', 'outerwhisper'); ?></label>
                        <input type="text" id="outerwhisper-style-feedback-btn-text" class="outerwhisper-form-input" style="height: 34px; font-size: 12.5px;" value="<?php esc_html_e('admin.builder.display.feedback_button.label.default', 'outerwhisper'); ?>" />
                    </div>
                    <div class="outerwhisper-form-group" style="margin-bottom: 0;">
                        <label for="outerwhisper-style-feedback-btn-position" class="outerwhisper-form-builder-template-display-label"><?php esc_html_e('admin.builder.display.feedback_button.position.label', 'outerwhisper'); ?></label>
                        <select id="outerwhisper-style-feedback-btn-position" class="outerwhisper-form-select" style="height: 34px;">
                            <option value="right-middle" selected><?php esc_html_e('admin.builder.display.feedback_button.position.right_middle', 'outerwhisper'); ?></option>
                            <option value="left-middle"><?php esc_html_e('admin.builder.display.feedback_button.position.left_middle', 'outerwhisper'); ?></option>
                            <option value="bottom-right"><?php esc_html_e('admin.builder.display.feedback_button.position.bottom_right', 'outerwhisper'); ?></option>
                            <option value="bottom-middle"><?php esc_html_e('admin.builder.display.feedback_button.position.bottom_middle', 'outerwhisper'); ?></option>
                            <option value="bottom-left"><?php esc_html_e('admin.builder.display.feedback_button.position.bottom_left', 'outerwhisper'); ?></option>
                        </select>
                    </div>
                    <div class="outerwhisper-switch-group" style="margin-bottom: 0;">
                        <span class="outerwhisper-switch-label" style="font-size: 11px;"><?php esc_html_e('admin.builder.display.feedback_button.hide_option.label', 'outerwhisper'); ?></span>
                        <label class="outerwhisper-switch-wrapper" for="outerwhisper-style-feedback-hide-option-enabled">
                            <input type="checkbox" id="outerwhisper-style-feedback-hide-option-enabled" />
                            <span class="outerwhisper-switch-slider"></span>
                        </label>
                    </div>

                    <!-- CUSTOM STYLES & FARBEN FÜR FEEDBACK-BUTTON -->
                    <div class="outerwhisper-switch-group" style="margin-top: 6px; margin-bottom: 0; padding-top: 10px; border-top: 1px dashed var(--outerwhisper-border, #e2e8f0);">
                        <div class="outerwhisper-form-builder-template-display-toggle-info">
                            <span class="outerwhisper-form-builder-template-display-toggle-title" style="font-size: 12px; font-weight: 600;"><?php esc_html_e('admin.builder.display.feedback_button.custom_design.title', 'outerwhisper'); ?></span>
                            <span class="outerwhisper-form-builder-template-display-toggle-desc" style="font-size: 11px; color: var(--outerwhisper-text-muted, #6c757d);"><?php esc_html_e('admin.builder.display.feedback_button.custom_design.description', 'outerwhisper'); ?></span>
                        </div>
                        <label class="outerwhisper-switch-wrapper" for="outerwhisper-opt-feedback-btn-custom-enabled">
                            <input type="checkbox" id="outerwhisper-opt-feedback-btn-custom-enabled" />
                            <span class="outerwhisper-switch-slider"></span>
                        </label>
                    </div>

                    <div id="outerwhisper-opt-feedback-btn-colors-subpanel" style="display: none; flex-direction: column; gap: 12px; margin-top: 4px; padding-top: 10px; border-top: 1px dashed var(--outerwhisper-border, #e2e8f0);">

                        <!-- Schriftgröße -->
                        <div class="outerwhisper-form-group" style="margin-bottom: 0;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                <label for="outerwhisper-opt-feedback-btn-font-size" class="outerwhisper-form-builder-template-display-label" style="margin-bottom: 0;"><?php esc_html_e('admin.builder.display.feedback_button.font_size.label', 'outerwhisper'); ?></label>
                                <span id="outerwhisper-opt-feedback-btn-font-size-val" style="font-size: 12px; font-weight: 600; color: var(--outerwhisper-primary, #104689);">16px</span>
                            </div>
                            <input type="range" id="outerwhisper-opt-feedback-btn-font-size" min="10" max="24" value="16" style="width: 100%; accent-color: var(--outerwhisper-primary, #104689);" />
                        </div>

                        <!-- Farb-Raster -->
                        <div class="outerwhisper-form-builder-template-display-color-grid">

                            <div class="outerwhisper-form-builder-template-display-color-field">
                                <label class="outerwhisper-form-builder-template-display-label"><?php esc_html_e('admin.builder.display.feedback_button.background.label', 'outerwhisper'); ?></label>
                                <div class="outerwhisper-form-builder-template-display-color-wrapper">
                                    <input type="color" id="outerwhisper-opt-feedback-btn-bg" value="#104689" />
                                    <input type="text" id="outerwhisper-opt-feedback-btn-bg-hex" value="#104689" readonly />
                                </div>
                            </div>

                            <div class="outerwhisper-form-builder-template-display-color-field">
                                <label class="outerwhisper-form-builder-template-display-label"><?php esc_html_e('admin.builder.display.feedback_button.text_color.label', 'outerwhisper'); ?></label>
                                <div class="outerwhisper-form-builder-template-display-color-wrapper">
                                    <input type="color" id="outerwhisper-opt-feedback-btn-text" value="#ffffff" />
                                    <input type="text" id="outerwhisper-opt-feedback-btn-text-hex" value="#FFFFFF" readonly />
                                </div>
                            </div>

                            <div class="outerwhisper-form-builder-template-display-color-field">
                                <label class="outerwhisper-form-builder-template-display-label"><?php esc_html_e('admin.builder.display.feedback_button.border.label', 'outerwhisper'); ?></label>
                                <div class="outerwhisper-form-builder-template-display-color-wrapper">
                                    <input type="color" id="outerwhisper-opt-feedback-btn-border" value="#104689" />
                                    <input type="text" id="outerwhisper-opt-feedback-btn-border-hex" value="#104689" readonly />
                                </div>
                            </div>

                            <div class="outerwhisper-form-builder-template-display-color-field">
                                <label class="outerwhisper-form-builder-template-display-label"><?php esc_html_e('admin.builder.display.feedback_button.hover.background.label', 'outerwhisper'); ?></label>
                                <div class="outerwhisper-form-builder-template-display-color-wrapper">
                                    <input type="color" id="outerwhisper-opt-feedback-btn-hover-bg" value="#0a2e5c" />
                                    <input type="text" id="outerwhisper-opt-feedback-btn-hover-bg-hex" value="#0A2E5C" readonly />
                                </div>
                            </div>

                            <div class="outerwhisper-form-builder-template-display-color-field">
                                <label class="outerwhisper-form-builder-template-display-label"><?php esc_html_e('admin.builder.display.feedback_button.hover.text_color.label', 'outerwhisper'); ?></label>
                                <div class="outerwhisper-form-builder-template-display-color-wrapper">
                                    <input type="color" id="outerwhisper-opt-feedback-btn-hover-text" value="#ffffff" />
                                    <input type="text" id="outerwhisper-opt-feedback-btn-hover-text-hex" value="#FFFFFF" readonly />
                                </div>
                            </div>

                            <div class="outerwhisper-form-builder-template-display-color-field">
                                <label class="outerwhisper-form-builder-template-display-label"><?php esc_html_e('admin.builder.display.feedback_button.hover.border.label', 'outerwhisper'); ?></label>
                                <div class="outerwhisper-form-builder-template-display-color-wrapper">
                                    <input type="color" id="outerwhisper-opt-feedback-btn-hover-border" value="#0a2e5c" />
                                    <input type="text" id="outerwhisper-opt-feedback-btn-hover-border-hex" value="#0A2E5C" readonly />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: GLOBALE EINSTELLUNGEN -->
            <div class="outerwhisper-form-builder-template-display-section">
                <div class="outerwhisper-form-builder-template-display-section-header">
                    <h4 class="outerwhisper-form-builder-template-display-section-title">
                        <i class="fas fa-sliders"></i> <?php esc_html_e('admin.builder.display.global.title', 'outerwhisper'); ?>
                    </h4>
                    <span class="outerwhisper-form-builder-template-display-badge"><?php esc_html_e('admin.builder.display.step.3', 'outerwhisper'); ?></span>
                </div>
                <p class="outerwhisper-form-builder-template-display-desc">
                    <?php esc_html_e('admin.builder.display.global.description', 'outerwhisper'); ?>
                </p>

                <!-- Global Settings Navigation Tabs -->
                <div class="outerwhisper-form-builder-template-display-tabs-nav">
                    <button type="button" class="outerwhisper-form-builder-template-display-tab-btn active" data-global-tab="behavior">
                        <i class="fas fa-hand"></i> <?php esc_html_e('admin.builder.display.tab.behavior', 'outerwhisper'); ?>
                    </button>
                    <button type="button" class="outerwhisper-form-builder-template-display-tab-btn" data-global-tab="box-model">
                        <i class="fas fa-expand"></i> <?php esc_html_e('admin.builder.display.tab.box_model', 'outerwhisper'); ?>
                    </button>
                    <button type="button" class="outerwhisper-form-builder-template-display-tab-btn" data-global-tab="styling">
                        <i class="fas fa-palette"></i> <?php esc_html_e('admin.builder.display.tab.styling', 'outerwhisper'); ?>
                    </button>
                </div>

                <!-- TAB PANEL 1: VERHALTEN & FREQUENZ -->
                <div class="outerwhisper-form-builder-template-display-tab-panel active" id="outerwhisper-display-global-tab-behavior">

                    <div class="outerwhisper-form-builder-template-display-group-card" id="outerwhisper-display-group-frequency">
                        <h5 class="outerwhisper-form-builder-template-display-group-title"><i class="fas fa-history"></i> <?php esc_html_e('admin.builder.display.group.frequency.title', 'outerwhisper'); ?></h5>

                        <div class="outerwhisper-form-builder-template-display-grid-2">
                            <div class="outerwhisper-form-builder-template-display-form-row" id="outerwhisper-display-row-close-days">
                                <label class="outerwhisper-form-builder-template-display-label" for="outerwhisper-style-overlay-rule-close-days">
                                    <?php esc_html_e('admin.builder.display.frequency.close_days.label', 'outerwhisper'); ?>
                                </label>
                                <div class="outerwhisper-form-builder-input-suffix">
                                    <input type="number" id="outerwhisper-style-overlay-rule-close-days" value="1" min="0" />
                                    <span><?php esc_html_e('admin.builder.display.days', 'outerwhisper'); ?></span>
                                </div>
                                <span class="outerwhisper-form-builder-template-display-hint"><?php esc_html_e('admin.builder.display.frequency.close_days.hint', 'outerwhisper'); ?></span>
                            </div>

                            <div class="outerwhisper-form-builder-template-display-form-row" id="outerwhisper-display-row-submit-days">
                                <label class="outerwhisper-form-builder-template-display-label" for="outerwhisper-style-overlay-rule-submit-days">
                                    <?php esc_html_e('admin.builder.display.frequency.submit_days.label', 'outerwhisper'); ?>
                                </label>
                                <div class="outerwhisper-form-builder-input-suffix">
                                    <input type="number" id="outerwhisper-style-overlay-rule-submit-days" value="30" min="0" />
                                    <span><?php esc_html_e('admin.builder.display.days', 'outerwhisper'); ?></span>
                                </div>
                                <span class="outerwhisper-form-builder-template-display-hint"><?php esc_html_e('admin.builder.display.frequency.submit_days.hint', 'outerwhisper'); ?></span>
                            </div>
                        </div>

                        <div class="outerwhisper-form-builder-template-display-form-row" id="outerwhisper-display-row-cookie-scope" style="margin-top: 10px;">
                            <label class="outerwhisper-form-builder-template-display-label" for="outerwhisper-style-overlay-rule-cookie-scope"><?php esc_html_e('admin.builder.display.cookie_scope.label', 'outerwhisper'); ?></label>
                            <select id="outerwhisper-style-overlay-rule-cookie-scope" class="outerwhisper-form-select" style="height: 34px;">
                                <option value="domain" selected><?php esc_html_e('admin.builder.display.cookie_scope.domain', 'outerwhisper'); ?></option>
                                <option value="page"><?php esc_html_e('admin.builder.display.cookie_scope.page', 'outerwhisper'); ?></option>
                            </select>
                        </div>

                        <!-- Hide Click Trigger Options (Visible when trigger is click) -->
                        <div class="outerwhisper-form-builder-template-display-form-row" id="outerwhisper-display-row-hide-click-on-close" style="margin-top: 10px; display: none;">
                            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                <div style="flex: 1; padding-right: 15px;">
                                    <label class="outerwhisper-form-builder-template-display-label" style="margin-bottom: 0;"><?php esc_html_e('admin.builder.display.trigger.hide_click_on_close.label', 'outerwhisper'); ?></label>
                                    <div style="font-size: 11px; color: var(--outerwhisper-text-secondary);"><?php esc_html_e('admin.builder.display.trigger.hide_click_on_close.desc', 'outerwhisper'); ?></div>
                                </div>
                                <label class="outerwhisper-switch-wrapper" for="outerwhisper-style-overlay-rule-hide-click-on-close" style="cursor: pointer;">
                                    <input type="checkbox" id="outerwhisper-style-overlay-rule-hide-click-on-close" />
                                    <span class="outerwhisper-switch-slider"></span>
                                </label>
                            </div>
                        </div>

                        <div class="outerwhisper-form-builder-template-display-form-row" id="outerwhisper-display-row-hide-click-on-submit" style="margin-top: 10px; display: none;">
                            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                <div style="flex: 1; padding-right: 15px;">
                                    <label class="outerwhisper-form-builder-template-display-label" style="margin-bottom: 0;"><?php esc_html_e('admin.builder.display.trigger.hide_click_on_submit.label', 'outerwhisper'); ?></label>
                                    <div style="font-size: 11px; color: var(--outerwhisper-text-secondary);"><?php esc_html_e('admin.builder.display.trigger.hide_click_on_submit.desc', 'outerwhisper'); ?></div>
                                </div>
                                <label class="outerwhisper-switch-wrapper" for="outerwhisper-style-overlay-rule-hide-click-on-submit" style="cursor: pointer;">
                                    <input type="checkbox" id="outerwhisper-style-overlay-rule-hide-click-on-submit" />
                                    <span class="outerwhisper-switch-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="outerwhisper-form-builder-template-display-group-card" id="outerwhisper-display-group-closing-options" style="margin-top: 14px;">
                        <h5 class="outerwhisper-form-builder-template-display-group-title"><i class="fas fa-times-circle"></i> <?php esc_html_e('admin.builder.display.group.closing_options.title', 'outerwhisper'); ?></h5>

                        <div class="outerwhisper-form-builder-template-display-toggle-list">
	                        <label class="outerwhisper-form-builder-template-display-toggle-item">
		                        <div class="outerwhisper-form-builder-template-display-toggle-info">
			                        <span class="outerwhisper-form-builder-template-display-toggle-title"><?php esc_html_e('admin.builder.display.overlay.allow_scroll.title', 'outerwhisper'); ?></span>
			                        <span class="outerwhisper-form-builder-template-display-toggle-desc"><?php esc_html_e('admin.builder.display.overlay.allow_scroll.desc', 'outerwhisper'); ?></span>
		                        </div>
		                        <div class="outerwhisper-switch-wrapper">
			                        <input type="checkbox" id="outerwhisper-style-overlay-rule-allow-scroll" checked />
			                        <span class="outerwhisper-switch-slider"></span>
		                        </div>
	                        </label>

	                        <label class="outerwhisper-form-builder-template-display-toggle-item">
		                        <div class="outerwhisper-form-builder-template-display-toggle-info">
			                        <span class="outerwhisper-form-builder-template-display-toggle-title"><?php esc_html_e('admin.builder.display.overlay.hide_header.title', 'outerwhisper'); ?></span>
			                        <span class="outerwhisper-form-builder-template-display-toggle-desc"><?php esc_html_e('admin.builder.display.overlay.hide_header.desc', 'outerwhisper'); ?></span>
		                        </div>
		                        <div class="outerwhisper-switch-wrapper">
			                        <input type="checkbox" id="outerwhisper-style-overlay-rule-hide-header" />
			                        <span class="outerwhisper-switch-slider"></span>
		                        </div>
	                        </label>

	                        <label class="outerwhisper-form-builder-template-display-toggle-item">
		                        <div class="outerwhisper-form-builder-template-display-toggle-info">
			                        <span class="outerwhisper-form-builder-template-display-toggle-title"><?php esc_html_e('admin.builder.display.overlay.hide_footer.title', 'outerwhisper'); ?></span>
			                        <span class="outerwhisper-form-builder-template-display-toggle-desc"><?php esc_html_e('admin.builder.display.overlay.hide_footer.desc', 'outerwhisper'); ?></span>
		                        </div>
		                        <div class="outerwhisper-switch-wrapper">
			                        <input type="checkbox" id="outerwhisper-style-overlay-rule-hide-footer" />
			                        <span class="outerwhisper-switch-slider"></span>
		                        </div>
	                        </label>

                            <label class="outerwhisper-form-builder-template-display-toggle-item">
                                <div class="outerwhisper-form-builder-template-display-toggle-info">
                                    <span class="outerwhisper-form-builder-template-display-toggle-title"><?php esc_html_e('admin.builder.display.overlay.show_backdrop.title', 'outerwhisper'); ?></span>
                                    <span class="outerwhisper-form-builder-template-display-toggle-desc"><?php esc_html_e('admin.builder.display.overlay.show_backdrop.desc', 'outerwhisper'); ?></span>
                                </div>
                                <div class="outerwhisper-switch-wrapper">
                                    <input type="checkbox" id="outerwhisper-style-overlay-rule-show-backdrop" checked />
                                    <span class="outerwhisper-switch-slider"></span>
                                </div>
                            </label>

                            <label class="outerwhisper-form-builder-template-display-toggle-item">
                                <div class="outerwhisper-form-builder-template-display-toggle-info">
                                    <span class="outerwhisper-form-builder-template-display-toggle-title"><?php esc_html_e('admin.builder.display.overlay.close_on_backdrop.title', 'outerwhisper'); ?></span>
                                    <span class="outerwhisper-form-builder-template-display-toggle-desc"><?php esc_html_e('admin.builder.display.overlay.close_on_backdrop.desc', 'outerwhisper'); ?></span>
                                </div>
                                <div class="outerwhisper-switch-wrapper">
                                    <input type="checkbox" id="outerwhisper-style-overlay-rule-backdrop" checked />
                                    <span class="outerwhisper-switch-slider"></span>
                                </div>
                            </label>

                            <label class="outerwhisper-form-builder-template-display-toggle-item">
                                <div class="outerwhisper-form-builder-template-display-toggle-info">
                                    <span class="outerwhisper-form-builder-template-display-toggle-title"><?php esc_html_e('admin.builder.display.overlay.esc_close.title', 'outerwhisper'); ?></span>
                                    <span class="outerwhisper-form-builder-template-display-toggle-desc"><?php esc_html_e('admin.builder.display.overlay.esc_close.desc', 'outerwhisper'); ?></span>
                                </div>
                                <div class="outerwhisper-switch-wrapper">
                                    <input type="checkbox" id="outerwhisper-style-overlay-rule-esc" checked />
                                    <span class="outerwhisper-switch-slider"></span>
                                </div>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- TAB PANEL 2: ABSTÄNDE & MAßE -->
                <div class="outerwhisper-form-builder-template-display-tab-panel" id="outerwhisper-display-global-tab-box-model">

                    <!-- Padding Box Model -->
                    <div class="outerwhisper-form-builder-template-display-group-card" id="outerwhisper-display-group-padding">
                        <div class="outerwhisper-form-builder-template-display-box-header">
                            <h5 class="outerwhisper-form-builder-template-display-group-title" style="margin: 0;"><i class="fas fa-expand"></i> <?php esc_html_e('admin.builder.display.box_model.padding.title', 'outerwhisper'); ?></h5>
                            <div class="outerwhisper-form-builder-template-display-box-actions">
                                <select id="outerwhisper-globaldata-padding-unit" class="outerwhisper-box-model-unit-select">
                                    <option value="px" selected>px</option>
                                    <option value="rem">rem</option>
                                    <option value="em">em</option>
                                </select>
                                <button type="button" id="outerwhisper-globaldata-padding-link" class="outerwhisper-box-model-link-btn is-linked" title="<?php esc_html_e('admin.builder.display.box_model.link.title', 'outerwhisper'); ?>">
                                    <i class="fas fa-link"></i>
                                </button>
	                            <button type="button" id="outerwhisper-globaldata-padding-reset" class="outerwhisper-box-model-reset-btn" title="<?php esc_html_e('admin.builder.display.box_model.reset.title', 'outerwhisper'); ?>">
		                            <i class="fas fa-undo"></i>
	                            </button>
                            </div>
                        </div>

                        <div class="outerwhisper-form-builder-template-display-box-inputs">
                            <div class="outerwhisper-form-builder-template-display-box-field">
                                <span><?php esc_html_e('admin.builder.display.box_model.label.top', 'outerwhisper'); ?></span>
                                <input type="text" id="outerwhisper-globaldata-padding-top" placeholder="16" />
                            </div>
                            <div class="outerwhisper-form-builder-template-display-box-field">
                                <span><?php esc_html_e('admin.builder.display.box_model.label.right', 'outerwhisper'); ?></span>
                                <input type="text" id="outerwhisper-globaldata-padding-right" placeholder="16" />
                            </div>
                            <div class="outerwhisper-form-builder-template-display-box-field">
                                <span><?php esc_html_e('admin.builder.display.box_model.label.bottom', 'outerwhisper'); ?></span>
                                <input type="text" id="outerwhisper-globaldata-padding-bottom" placeholder="16" />
                            </div>
                            <div class="outerwhisper-form-builder-template-display-box-field">
                                <span><?php esc_html_e('admin.builder.display.box_model.label.left', 'outerwhisper'); ?></span>
                                <input type="text" id="outerwhisper-globaldata-padding-left" placeholder="16" />
                            </div>
                        </div>
                    </div>

                    <!-- Margin Box Model -->
                    <div class="outerwhisper-form-builder-template-display-group-card" id="outerwhisper-display-group-margin" style="margin-top: 14px;">
                        <div class="outerwhisper-form-builder-template-display-box-header">
                            <h5 class="outerwhisper-form-builder-template-display-group-title" style="margin: 0;"><i class="fas fa-arrows-alt"></i> <?php esc_html_e('admin.builder.display.box_model.margin.title', 'outerwhisper'); ?></h5>
                            <div class="outerwhisper-form-builder-template-display-box-actions">
                                <select id="outerwhisper-globaldata-margin-unit" class="outerwhisper-box-model-unit-select">
                                    <option value="px" selected>px</option>
                                    <option value="rem">rem</option>
                                    <option value="em">em</option>
                                </select>
                                <button type="button" id="outerwhisper-globaldata-margin-link" class="outerwhisper-box-model-link-btn is-linked" title="<?php esc_html_e('admin.builder.display.box_model.link.title', 'outerwhisper'); ?>">
                                    <i class="fas fa-link"></i>
                                </button>
	                            <button type="button" id="outerwhisper-globaldata-margin-reset" class="outerwhisper-box-model-reset-btn" title="<?php esc_html_e('admin.builder.display.box_model.reset.title', 'outerwhisper'); ?>">
		                            <i class="fas fa-undo"></i>
	                            </button>
                            </div>
                        </div>

                        <div class="outerwhisper-form-builder-template-display-box-inputs">
                            <div class="outerwhisper-form-builder-template-display-box-field">
                                <span><?php esc_html_e('admin.builder.display.box_model.label.top', 'outerwhisper'); ?></span>
                                <input type="text" id="outerwhisper-globaldata-margin-top" placeholder="0" />
                            </div>
                            <div class="outerwhisper-form-builder-template-display-box-field">
                                <span><?php esc_html_e('admin.builder.display.box_model.label.right', 'outerwhisper'); ?></span>
                                <input type="text" id="outerwhisper-globaldata-margin-right" placeholder="auto" />
                            </div>
                            <div class="outerwhisper-form-builder-template-display-box-field">
                                <span><?php esc_html_e('admin.builder.display.box_model.label.bottom', 'outerwhisper'); ?></span>
                                <input type="text" id="outerwhisper-globaldata-margin-bottom" placeholder="0" />
                            </div>
                            <div class="outerwhisper-form-builder-template-display-box-field">
                                <span><?php esc_html_e('admin.builder.display.box_model.label.left', 'outerwhisper'); ?></span>
                                <input type="text" id="outerwhisper-globaldata-margin-left" placeholder="auto" />
                            </div>
                        </div>
                    </div>

                    <!-- Dimensions & Position -->
                    <div class="outerwhisper-form-builder-template-display-group-card" id="outerwhisper-display-group-dimensions" style="margin-top: 14px;">
                        <h5 class="outerwhisper-form-builder-template-display-group-title"><i class="fas fa-arrows-alt"></i> <?php esc_html_e('admin.builder.display.dimensions.title', 'outerwhisper'); ?></h5>
                        <div class="outerwhisper-form-builder-template-display-form-row" id="outerwhisper-display-row-overlay-position" style="margin-bottom: 12px;">
                            <label class="outerwhisper-form-builder-template-display-label" for="outerwhisper-style-overlay-position"><?php esc_html_e('admin.builder.display.dimensions.overlay_position.label', 'outerwhisper'); ?></label>
                            <select id="outerwhisper-style-overlay-position" class="outerwhisper-form-select" style="height: 34px;">
                                <option value="center" selected><?php esc_html_e('admin.builder.display.dimensions.overlay_position.center', 'outerwhisper'); ?></option>
                                <option value="bottom-right"><?php esc_html_e('admin.builder.display.dimensions.overlay_position.bottom_right', 'outerwhisper'); ?></option>
                                <option value="bottom-left"><?php esc_html_e('admin.builder.display.dimensions.overlay_position.bottom_left', 'outerwhisper'); ?></option>
                                <option value="bottom-middle"><?php esc_html_e('admin.builder.display.dimensions.overlay_position.bottom_middle', 'outerwhisper'); ?></option>
                                <option value="right-middle"><?php esc_html_e('admin.builder.display.dimensions.overlay_position.right_middle', 'outerwhisper'); ?></option>
                                <option value="left-middle"><?php esc_html_e('admin.builder.display.dimensions.overlay_position.left_middle', 'outerwhisper'); ?></option>
                                <option value="top-right"><?php esc_html_e('admin.builder.display.dimensions.overlay_position.top_right', 'outerwhisper'); ?></option>
                                <option value="top-middle"><?php esc_html_e('admin.builder.display.dimensions.overlay_position.top_middle', 'outerwhisper'); ?></option>
                                <option value="top-left"><?php esc_html_e('admin.builder.display.dimensions.overlay_position.top_left', 'outerwhisper'); ?></option>
                            </select>
                        </div>
                        <div class="outerwhisper-form-builder-template-display-grid-2">
                            <div class="outerwhisper-form-builder-template-display-form-row">
                                <label class="outerwhisper-form-builder-template-display-label" for="outerwhisper-style-overlay-rule-width"><?php esc_html_e('admin.builder.display.dimensions.max_width.label', 'outerwhisper'); ?></label>
                                <div class="outerwhisper-form-builder-input-suffix">
                                    <input type="number" id="outerwhisper-style-overlay-rule-width" placeholder="480" min="280" max="1200" />
                                    <span>px</span>
                                </div>
                            </div>

                            <div class="outerwhisper-form-builder-template-display-form-row" id="outerwhisper-display-row-min-height">
                                <label class="outerwhisper-form-builder-template-display-label" for="outerwhisper-style-min-height"><?php esc_html_e('admin.builder.display.dimensions.min_height.label', 'outerwhisper'); ?></label>
                                <div class="outerwhisper-form-builder-input-suffix">
                                    <input type="number" id="outerwhisper-style-min-height" placeholder="Auto" min="0" max="800" />
                                    <span>px</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- TAB PANEL 3: DESIGN & FARBEN -->
                <div class="outerwhisper-form-builder-template-display-tab-panel" id="outerwhisper-display-global-tab-styling">

                    <div class="outerwhisper-form-builder-template-display-group-card" id="outerwhisper-display-group-custom-colors">
                        <div class="outerwhisper-switch-group" style="margin-bottom: 0;">
                            <div class="outerwhisper-form-builder-template-display-toggle-info">
                                <span class="outerwhisper-form-builder-template-display-toggle-title"><?php esc_html_e('admin.builder.display.custom_colors.title', 'outerwhisper'); ?></span>
                                <span class="outerwhisper-form-builder-template-display-toggle-desc"><?php esc_html_e('admin.builder.display.custom_colors.desc', 'outerwhisper'); ?></span>
                            </div>
                            <label class="outerwhisper-switch-wrapper" for="outerwhisper-opt-globaldata-custom-enabled">
                                <input type="checkbox" id="outerwhisper-opt-globaldata-custom-enabled" />
                                <span class="outerwhisper-switch-slider"></span>
                            </label>
                        </div>

                        <div id="outerwhisper-opt-globaldata-colors-subpanel" style="display: none; margin-top: 14px; padding-top: 14px; border-top: 1px dashed var(--outerwhisper-border);">
                            <div class="outerwhisper-form-builder-template-display-color-grid">

                                <div class="outerwhisper-form-builder-template-display-color-field">
                                    <label class="outerwhisper-form-builder-template-display-label"><?php esc_html_e('admin.builder.display.custom_colors.label.background', 'outerwhisper'); ?></label>
                                    <div class="outerwhisper-form-builder-template-display-color-wrapper">
                                        <input type="color" id="outerwhisper-opt-globaldata-bg" value="#ffffff" />
                                        <input type="text" id="outerwhisper-opt-globaldata-bg-hex" value="#FFFFFF" readonly />
                                    </div>
                                </div>

                                <div class="outerwhisper-form-builder-template-display-color-field">
                                    <label class="outerwhisper-form-builder-template-display-label"><?php esc_html_e('admin.builder.display.custom_colors.label.border', 'outerwhisper'); ?></label>
                                    <div class="outerwhisper-form-builder-template-display-color-wrapper">
                                        <input type="color" id="outerwhisper-opt-globaldata-border" value="#e2e8f0" />
                                        <input type="text" id="outerwhisper-opt-globaldata-border-hex" value="#E2E8F0" readonly />
                                    </div>
                                </div>

                                <div class="outerwhisper-form-builder-template-display-color-field" style="grid-column: span 2;">
                                    <label class="outerwhisper-form-builder-template-display-label" for="outerwhisper-opt-globaldata-border-style"><?php esc_html_e('admin.builder.display.custom_colors.label.border_style', 'outerwhisper'); ?></label>
                                    <select id="outerwhisper-opt-globaldata-border-style" class="outerwhisper-form-select" style="height: 34px;">
                                        <option value="solid" selected><?php esc_html_e('admin.builder.display.custom_colors.option.solid', 'outerwhisper'); ?></option>
                                        <option value="dashed"><?php esc_html_e('admin.builder.display.custom_colors.option.dashed', 'outerwhisper'); ?></option>
                                        <option value="dotted"><?php esc_html_e('admin.builder.display.custom_colors.option.dotted', 'outerwhisper'); ?></option>
                                    </select>
                                </div>

	                            <div class="outerwhisper-form-builder-template-display-color-field" style="grid-column: span 2;">
		                            <label class="outerwhisper-form-builder-template-display-label" for="outerwhisper-opt-globaldata-border-width"><?php esc_html_e('admin.builder.display.custom_colors.label.border_width', 'outerwhisper'); ?></label>
		                            <div class="outerwhisper-form-builder-input-suffix">
			                            <input type="number" id="outerwhisper-opt-globaldata-border-width" value="0" min="0" max="20" />
			                            <span>px</span>
		                            </div>
	                            </div>

                                <div class="outerwhisper-form-builder-template-display-color-field" style="grid-column: span 2;">
                                    <label class="outerwhisper-form-builder-template-display-label" for="outerwhisper-opt-globaldata-border-radius"><?php esc_html_e('admin.builder.display.custom_colors.label.border_radius', 'outerwhisper'); ?></label>
                                    <div class="outerwhisper-form-builder-input-suffix">
                                        <input type="number" id="outerwhisper-opt-globaldata-border-radius" value="0" min="0" max="50" />
                                        <span>px</span>
                                    </div>
                                </div>

	                            <div class="outerwhisper-form-builder-template-display-color-field" style="grid-column: span 2;">
		                            <label class="outerwhisper-form-builder-template-display-label" for="outerwhisper-opt-globaldata-box-shadow"><?php esc_html_e('admin.builder.display.custom_colors.label.box_shadow', 'outerwhisper'); ?></label>
		                            <select id="outerwhisper-opt-globaldata-box-shadow" class="outerwhisper-form-select" style="height: 34px;">
			                            <option value="none" selected><?php esc_html_e('admin.builder.display.custom_colors.option.shadow_none', 'outerwhisper'); ?></option>
			                            <option value="low"><?php esc_html_e('admin.builder.display.custom_colors.option.shadow_low', 'outerwhisper'); ?></option>
			                            <option value="medium"><?php esc_html_e('admin.builder.display.custom_colors.option.shadow_medium', 'outerwhisper'); ?></option>
			                            <option value="strong"><?php esc_html_e('admin.builder.display.custom_colors.option.shadow_strong', 'outerwhisper'); ?></option>
		                            </select>
	                            </div>

                            </div>
                        </div>
                    </div>

                    <div class="outerwhisper-form-builder-template-display-group-card" id="outerwhisper-display-group-header-footer" style="margin-top: 14px;">
                        <h5 class="outerwhisper-form-builder-template-display-group-title"><i class="fas fa-heading"></i> <?php esc_html_e('admin.builder.display.header_footer.title', 'outerwhisper'); ?></h5>
                        <div class="outerwhisper-form-builder-template-display-grid-2">
                            <div class="outerwhisper-form-builder-template-display-form-row">
                                <label class="outerwhisper-form-builder-template-display-label" for="outerwhisper-style-overlay-header-indicator"><?php esc_html_e('admin.builder.display.header_footer.indicator_type.label', 'outerwhisper'); ?></label>
                                <select id="outerwhisper-style-overlay-header-indicator" class="outerwhisper-form-select" style="height: 34px;">
                                    <option value="progress" selected><?php esc_html_e('admin.builder.display.header_footer.indicator_type.option.progress', 'outerwhisper'); ?></option>
                                    <option value="title"><?php esc_html_e('admin.builder.display.header_footer.indicator_type.option.title', 'outerwhisper'); ?></option>
                                    <option value="step"><?php esc_html_e('admin.builder.display.header_footer.indicator_type.option.step', 'outerwhisper'); ?></option>
                                    <option value="none"><?php esc_html_e('admin.builder.display.header_footer.indicator_type.option.none', 'outerwhisper'); ?></option>
                                </select>
                            </div>

                            <div class="outerwhisper-form-builder-template-display-form-row" id="outerwhisper-style-overlay-header-title-container" style="display: none;">
                                <label class="outerwhisper-form-builder-template-display-label" for="outerwhisper-style-overlay-header-title"><?php esc_html_e('admin.builder.display.header_footer.custom_title.label', 'outerwhisper'); ?></label>
                                <input type="text" id="outerwhisper-style-overlay-header-title" class="outerwhisper-form-input" placeholder="<?php esc_html_e('admin.builder.display.header_footer.custom_title.placeholder', 'outerwhisper'); ?>" style="height: 34px;" />
                            </div>
                        </div>

                        <div class="outerwhisper-switch-group" style="margin-top: 12px; margin-bottom: 0;">
                            <span class="outerwhisper-switch-label" style="font-size: 11.5px;"><?php esc_html_e('admin.builder.display.header_footer.show_footer.label', 'outerwhisper'); ?></span>
                            <label class="outerwhisper-switch-wrapper" for="outerwhisper-style-overlay-show-footer">
                                <input type="checkbox" id="outerwhisper-style-overlay-show-footer" checked />
                                <span class="outerwhisper-switch-slider"></span>
                            </label>
                        </div>

                        <div class="outerwhisper-form-group" id="outerwhisper-style-overlay-footer-text-container" style="margin-top: 8px; margin-bottom: 0;">
                            <label class="outerwhisper-form-builder-template-display-label" for="outerwhisper-style-overlay-footer-text"><?php esc_html_e('admin.builder.display.header_footer.custom_footer_text.label', 'outerwhisper'); ?></label>
                            <input type="text" id="outerwhisper-style-overlay-footer-text" class="outerwhisper-form-input" placeholder="<?php esc_html_e('admin.builder.display.header_footer.custom_footer_text.placeholder', 'outerwhisper'); ?>" style="height: 34px;" />
                        </div>
                    </div>

                </div>

            </div>

        </div>

    <!-- RIGHT COLUMN: LIVE INTERACTIVE SIMULATOR -->
    <div id="outerwhisper-preview-simulator-container" class="outerwhisper-preview-simulator-container"></div>


    </div>

</section>
