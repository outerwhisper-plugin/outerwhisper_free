<?php
/**
 * Template for Form Overlay Widget
 */
if (!defined('ABSPATH')) exit;?>

<template id="outerwhisper-general-overlay-template">
    <div class="outerwhisper-feedback-plugin outerwhisper-general-overlay-backdrop" role="dialog" aria-modal="true" aria-labelledby="outerwhisper-general-overlay-title">
        <div class="outerwhisper-general-overlay-modal outerwhisper-overlay-card-pos-center">
            <!-- HEADER -->
            <div class="outerwhisper-overlay-header">

                <button id="outerwhisper-general-overlay-back-button" class="outerwhisper-general-overlay-icon-btn" aria-label="Back" style="display: none;">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>

                <div id="outerwhisper-general-overlay-header-indicator-wrapper" class="outerwhisper-overlay-header-indicator-wrapper">
                    <div id="outerwhisper-general-overlay-progress-bar-container" class="outerwhisper-general-overlay-progress-bar-container" style="display: none;">
                        <div id="outerwhisper-general-overlay-progress-bar" class="outerwhisper-general-overlay-progress-bar"></div>
                    </div>

                    <div id="outerwhisper-general-overlay-title" class="outerwhisper-overlay-header-title" style="display: none;">Feedback</div>

                    <div id="outerwhisper-general-overlay-step-indicator" class="outerwhisper-overlay-header-step-indicator" style="display: none;"></div>
                </div>

                <button id="outerwhisper-general-overlay-close-button" class="outerwhisper-general-overlay-icon-btn" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- BODY -->
            <div class="outerwhisper-overlay-body">
                <div id="outerwhisper-general-overlay-content" class="outerwhisper-feedback-type-placeholder outerwhisper-form-id-1" data-type="overlay" data-form-id="1" data-form-updated="20260717120405"></div>
            </div>

            <!-- FOOTER -->
            <div class="outerwhisper-overlay-footer">
                <?php esc_html_e('admin.frontend.default_footer_text', 'outerwhisper') ?>
            </div>
        </div>
    </div>
</template>