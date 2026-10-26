<?php
if (!defined('ABSPATH')) {
	exit;
}
?>

<section class="outerwhisper-builder-view outerwhisper-felder-editor-layout" id="outerwhisper-view-fields" aria-label="<?php esc_attr_e('admin.builder.fields.title', 'outerwhisper'); ?>">

    <!-- Sidebar selection & specifics -->
    <aside class="outerwhisper-builder-sidebar">

        <!-- Tab Header in Sidebar -->
        <div class="outerwhisper-sidebar-tabs-header">
            <div class="outerwhisper-sidebar-tab-trigger outerwhisper-sidebar-tab-active" data-panel="add-fields" id="outerwhisper-tab-trigger-add">
                <i class="fas fa-plus-circle"></i> <?php esc_html_e('admin.builder.fields.add_fields', 'outerwhisper'); ?>
            </div>
            <div class="outerwhisper-sidebar-tab-trigger" data-panel="field-options" id="outerwhisper-tab-trigger-options">
                <i class="fas fa-sliders-h"></i> <?php esc_html_e('admin.builder.fields.field_options', 'outerwhisper'); ?>
            </div>
        </div>

        <!-- Container für dynamische Warnmeldungen -->
        <div id="outerwhisper-warning-banners-container"></div>

        <!-- Sidebar Tab Panel Content -->
        <div class="outerwhisper-sidebar-tab-content-wrapper">

            <!-- PANEL A: Felder hinzufügen -->
            <div class="outerwhisper-sidebar-tab-panel outerwhisper-sidebar-tab-panel-active" id="outerwhisper-panel-add-fields">

                <!-- Search boxes for standard fields -->
                <div class="outerwhisper-search-box-wrapper">
                    <i class="fas fa-search"></i>
                    <input type="text" id="outerwhisper-search-fields-input" class="outerwhisper-search-input" placeholder="<?php esc_attr_e('admin.builder.fields.search_placeholder', 'outerwhisper'); ?>" title="<?php esc_html_e('admin.builder.fields.search_title', 'outerwhisper'); ?>" autocomplete="off" />
                </div>

                <div class="outerwhisper-sidebar-section-title" id="outerwhisper-sec-title-standard">
                    <span><?php esc_html_e('admin.builder.fields.standard_fields', 'outerwhisper'); ?></span>
                    <i class="fas fa-chevron-down text-xs"></i>
                </div>

                <!-- Draggable elements container -->
                <div id="outerwhisper-draggable-store-grid" style="display: flex; flex-direction: column; gap: 16px;margin-bottom: 15px;">

                    <!-- Grid 1: Standard elements -->
                    <div class="outerwhisper-fields-grid">
                        <div class="outerwhisper-draggable-field-item" draggable="true" data-type="headline" id="outerwhisper-field-drag-headline">
                            <i class="fas fa-heading"></i>
                            <span><?php esc_html_e('admin.builder.fields.headline', 'outerwhisper'); ?></span>
                        </div>

                        <div class="outerwhisper-draggable-field-item" draggable="true" data-type="description" id="outerwhisper-field-drag-desc">
                            <i class="fas fa-align-left"></i>
                            <span><?php esc_html_e('admin.builder.fields.description', 'outerwhisper'); ?></span>
                        </div>

                        <div class="outerwhisper-draggable-field-item" draggable="true" data-type="button" id="outerwhisper-field-drag-button">
                            <i class="fas fa-square-minus" style="transform: scaleY(0.75);"></i>
                            <span><?php esc_html_e('admin.builder.fields.button', 'outerwhisper'); ?></span>
                        </div>

                        <div class="outerwhisper-draggable-field-item" draggable="true" data-type="textarea" id="outerwhisper-field-drag-textarea">
                            <i class="fas fa-keyboard"></i>
                            <span><?php esc_html_e('admin.builder.fields.textarea', 'outerwhisper'); ?></span>
                        </div>

	                    <div class="outerwhisper-draggable-field-item" draggable="true" data-type="dropdown" id="outerwhisper-field-drag-dropdown">
		                    <i class="fas fa-chevron-down"></i>
		                    <span><?php esc_html_e('fields.dropdown.name', 'outerwhisper'); ?></span>
	                    </div>

	                    <div class="outerwhisper-draggable-field-item" draggable="true" data-type="chips" id="outerwhisper-field-drag-chips">
		                    <i class="fas fa-tags"></i>
		                    <span><?php esc_html_e('fields.chips.name', 'outerwhisper'); ?></span>
	                    </div>

	                    <div class="outerwhisper-draggable-field-item" draggable="true" data-type="radio" id="outerwhisper-field-drag-radio">
		                    <i class="fas fa-circle-dot"></i>
		                    <span><?php esc_html_e('fields.radio.name', 'outerwhisper'); ?></span>
	                    </div>

	                    <div class="outerwhisper-draggable-field-item" draggable="true" data-type="name" id="outerwhisper-field-drag-name">
		                    <i class="fas fa-user"></i>
		                    <span><?php esc_html_e('fields.name.name', 'outerwhisper'); ?></span>
	                    </div>

	                    <div class="outerwhisper-draggable-field-item" draggable="true" data-type="email" id="outerwhisper-field-drag-email">
		                    <i class="fas fa-envelope"></i>
		                    <span><?php esc_html_e('fields.email.name', 'outerwhisper'); ?></span>
	                    </div>
                    </div>

                    <div class="outerwhisper-sidebar-section-title" id="outerwhisper-sec-title-reviews" style="margin-top: 8px; margin-bottom: 0;">
                        <span><?php esc_html_e('admin.builder.fields.reviews', 'outerwhisper'); ?></span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>

                    <!-- Grid 2: Reviews elements -->
                    <div class="outerwhisper-fields-grid">
                        <div class="outerwhisper-draggable-field-item" draggable="true" data-type="rating" id="outerwhisper-field-drag-rating">
                            <i class="fas fa-star"></i>
                            <span><?php esc_html_e('admin.builder.fields.rating', 'outerwhisper'); ?></span>
                        </div>
                    </div>

	                <div class="outerwhisper-sidebar-section-title" id="outerwhisper-sec-title-reviews" style="margin-top: 8px; margin-bottom: 0;">
		                <span><?php esc_html_e('admin.builder.fields.pro_section.headline', 'outerwhisper'); ?></span>
		                <i class="fas fa-chevron-down text-xs"></i>
	                </div>

	                <div class="outerwhisper-fields-grid">
		                <div class="outerwhisper-draggable-field-item outerwhisper-draggable-pro-item outerwhisper-pro-feature-hint">
			                <i class="fas fa-thumbs-up"></i>
			                <span><?php esc_html_e('admin.builder.fields.thumbs', 'outerwhisper'); ?></span>
		                </div>

		                <div class="outerwhisper-draggable-field-item outerwhisper-draggable-pro-item outerwhisper-pro-feature-hint">
			                <i class="fas fa-smile"></i>
			                <span><?php esc_html_e('admin.builder.fields.smileys', 'outerwhisper'); ?></span>
		                </div>

		                <div class="outerwhisper-draggable-field-item outerwhisper-draggable-pro-item outerwhisper-pro-feature-hint">
			                <i class="fas fa-chart-bar"></i>
			                <span><?php esc_html_e('admin.builder.fields.nps', 'outerwhisper'); ?></span>
		                </div>
	                </div>


                </div>

                <div class="outerwhisper-empty-search-msg" id="outerwhisper-search-no-results">
                    <?php esc_html_e('admin.builder.fields.search_no_results', 'outerwhisper'); ?>
                </div>

                <div style="margin-top: auto; padding-top: 24px; font-size: 11px; color: var(--outerwhisper-text-secondary); line-height: 1.4; border-top: 1px dashed var(--outerwhisper-border);">
                    <i class="fas fa-mouse-pointer" style="margin-right: 4px;"></i>
                    <strong><?php esc_html_e('admin.builder.fields.tip', 'outerwhisper'); ?>:</strong> <?php esc_html_e('admin.builder.fields.tip_text', 'outerwhisper'); ?>
                </div>

            </div>

            <!-- PANEL B: Feldoptionen -->
            <div class="outerwhisper-sidebar-tab-panel" id="outerwhisper-panel-field-options">

                <!-- Default notice if no element selected -->
                <div class="outerwhisper-no-field-selected" id="outerwhisper-options-empty-notice">
                    <i class="fas fa-mouse-pointer"></i>
                    <p><?php esc_html_e('admin.builder.fields.no_field_selected', 'outerwhisper'); ?></p>
                </div>

                <!-- Active options form -->
                <div class="outerwhisper-field-options-form" id="outerwhisper-options-form-container" style="display: none;">
                    <input type="hidden" id="outerwhisper-opt-element-id" />

                    <div style="display: flex; flex-direction: column; margin-bottom: 12px;">
                        <span id="outerwhisper-opt-element-type-badge" style="font-size: 12px; font-weight: 650; color: var(--outerwhisper-text-secondary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;"><?php esc_html_e('admin.builder.fields.options.field_type', 'outerwhisper'); ?></span>
                        <span class="outerwhisper-badge-id" id="outerwhisper-opt-element-id-badge" style="align-self: flex-start; font-size: 10px; color: #64748b; background-color: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-family: var(--outerwhisper-font-mono);"><?php esc_html_e('admin.builder.fields.options.id', 'outerwhisper'); ?>: #</span>
                    </div>

                    <!-- Basic Label Option -->
                    <div class="outerwhisper-form-group" id="outerwhisper-opt-group-label">
                        <label for="outerwhisper-opt-label"><?php esc_html_e('admin.builder.fields.options.label.title', 'outerwhisper'); ?> <i class="fas fa-question-circle outerwhisper-help-tip" title="<?php esc_html_e('admin.builder.fields.options.label.hint', 'outerwhisper'); ?>"></i></label>
                        <input type="text" id="outerwhisper-opt-label" class="outerwhisper-form-input" />
                    </div>

                    <!-- Dynamic settings dependent on Field Type -->

                    <!-- Description setting -->
                    <div class="outerwhisper-form-group" id="outerwhisper-opt-group-desc-text">
                        <label for="outerwhisper-opt-desc-text"><?php esc_html_e('admin.builder.fields.options.description.title', 'outerwhisper'); ?></label>
                        <textarea id="outerwhisper-opt-desc-text" class="outerwhisper-form-textarea" placeholder="<?php esc_html_e('admin.builder.fields.options.description.placeholder', 'outerwhisper'); ?>"></textarea>
                    </div>

                    <!-- Placeholder parameter -->
                    <div class="outerwhisper-form-group" id="outerwhisper-opt-group-placeholder">
                        <label for="outerwhisper-opt-placeholder"><?php esc_html_e('admin.builder.fields.options.placeholder.title', 'outerwhisper'); ?></label>
                        <input type="text" id="outerwhisper-opt-placeholder" class="outerwhisper-form-input" placeholder="<?php esc_html_e('admin.builder.fields.options.placeholder.placeholder', 'outerwhisper'); ?>" />
                    </div>

                    <!-- Button Type Picker -->
                    <div class="outerwhisper-form-group" id="outerwhisper-opt-group-button-type">
                        <label for="outerwhisper-opt-button-type"><?php esc_html_e('admin.builder.fields.options.button_type.title', 'outerwhisper'); ?></label>
                        <select id="outerwhisper-opt-button-type" class="outerwhisper-form-select">
                            <option value="next"><?php esc_html_e('admin.builder.fields.options.button_type.next', 'outerwhisper'); ?></option>
                            <option value="submit"><?php esc_html_e('admin.builder.fields.options.button_type.submit', 'outerwhisper'); ?></option>
                            <option value="back"><?php esc_html_e('admin.builder.fields.options.button_type.back', 'outerwhisper'); ?></option>
                        </select>
                    </div>

                    <!-- Button Icon Picker -->
                    <div class="outerwhisper-form-group" id="outerwhisper-opt-group-icon">
                        <label for="outerwhisper-opt-icon"><?php esc_html_e('admin.builder.fields.options.icon.title', 'outerwhisper'); ?> <i class="far fa-question-circle outerwhisper-help-tip" title="<?php esc_html_e('admin.builder.fields.options.icon.hint', 'outerwhisper'); ?>"></i></label>
                        <select id="outerwhisper-opt-icon" class="outerwhisper-form-select">
                            <option value="fa-arrow-right"><?php esc_html_e('admin.builder.fields.options.icon.option.arrow_right', 'outerwhisper'); ?></option>
                            <option value="fa-arrow-circle-right"><?php esc_html_e('admin.builder.fields.options.icon.option.arrow_circle_right', 'outerwhisper'); ?></option>
                            <option value="fa-arrow-left"><?php esc_html_e('admin.builder.fields.options.icon.option.arrow_left', 'outerwhisper'); ?></option>
                            <option value="fa-arrow-circle-left"><?php esc_html_e('admin.builder.fields.options.icon.option.arrow_circle_left', 'outerwhisper'); ?></option>
                            <option value="fa-paper-plane"><?php esc_html_e('admin.builder.fields.options.icon.option.paper_plane', 'outerwhisper'); ?></option>
                            <option value="fa-check"><?php esc_html_e('admin.builder.fields.options.icon.option.check', 'outerwhisper'); ?></option>
                            <option value="fa-heart"><?php esc_html_e('admin.builder.fields.options.icon.option.heart', 'outerwhisper'); ?></option>
                            <option value="fa-comment"><?php esc_html_e('admin.builder.fields.options.icon.option.comment', 'outerwhisper'); ?></option>
                            <option value="fa-laugh-beam"><?php esc_html_e('admin.builder.fields.options.icon.option.laugh_beam', 'outerwhisper'); ?></option>
                            <option value="fa-futbol"><?php esc_html_e('admin.builder.fields.options.icon.option.futbol', 'outerwhisper'); ?></option>
                            <option value="fa-lightbulb"><?php esc_html_e('admin.builder.fields.options.icon.option.lightbulb', 'outerwhisper'); ?></option>
                            <option value="fa-bug"><?php esc_html_e('admin.builder.fields.options.icon.option.bug', 'outerwhisper'); ?></option>
                            <option value="fa-comment-dots"><?php esc_html_e('admin.builder.fields.options.icon.option.comment_dots', 'outerwhisper'); ?></option>
                            <option value="fa-times"><?php esc_html_e('admin.builder.fields.options.icon.option.none', 'outerwhisper'); ?></option>
                        </select>
                    </div>

                    <!-- Button Icon Position -->
                    <div class="outerwhisper-form-group" id="outerwhisper-opt-group-icon-position">
                        <label for="outerwhisper-opt-icon-position"><?php esc_html_e('admin.builder.fields.options.icon_position.title', 'outerwhisper'); ?></label>
                        <select id="outerwhisper-opt-icon-position" class="outerwhisper-form-select">
                            <option value="right"><?php esc_html_e('admin.builder.fields.options.icon_position.right', 'outerwhisper'); ?></option>
                            <option value="left"><?php esc_html_e('admin.builder.fields.options.icon_position.left', 'outerwhisper'); ?></option>
                        </select>
                    </div>

                    <!-- Rating Stars Amount -->
                    <div class="outerwhisper-form-group" id="outerwhisper-opt-group-rating-stars">
                        <label for="outerwhisper-opt-rating-stars"><?php esc_html_e('admin.builder.fields.options.rating_stars.title', 'outerwhisper'); ?> <i class="fas fa-question-circle outerwhisper-help-tip" title="<?php esc_html_e('admin.builder.fields.options.rating_stars.hint', 'outerwhisper'); ?>"></i></label>
                        <select id="outerwhisper-opt-rating-stars" class="outerwhisper-form-select">
                            <option value="3"><?php esc_html_e('admin.builder.fields.options.rating_stars.3', 'outerwhisper'); ?></option>
                            <option value="5"><?php esc_html_e('admin.builder.fields.options.rating_stars.5', 'outerwhisper'); ?></option>
                        </select>
                    </div>

                    <!-- Alignment Selection (Ausrichtung) -->
                    <div class="outerwhisper-form-group" id="outerwhisper-opt-group-alignment">
                        <label for="outerwhisper-opt-alignment"><?php esc_html_e('admin.builder.fields.options.alignment.title', 'outerwhisper'); ?> <i class="fas fa-question-circle outerwhisper-help-tip" title="<?php esc_html_e('admin.builder.fields.options.alignment.hint', 'outerwhisper'); ?>"></i></label>
                        <select id="outerwhisper-opt-alignment" class="outerwhisper-form-select">
                            <option value="left"><?php esc_html_e('admin.builder.fields.options.alignment.left', 'outerwhisper'); ?></option>
                            <option value="center"><?php esc_html_e('admin.builder.fields.options.alignment.center', 'outerwhisper'); ?></option>
                            <option value="right"><?php esc_html_e('admin.builder.fields.options.alignment.right', 'outerwhisper'); ?></option>
                        </select>
                    </div>

                    <!-- Heading Tag Type Selection -->
                    <div class="outerwhisper-form-group" id="outerwhisper-opt-group-h-type" style="display: none;">
                        <label for="outerwhisper-opt-h-type"><?php esc_html_e('admin.builder.fields.h_type.title', 'outerwhisper'); ?> <i class="fas fa-question-circle outerwhisper-help-tip" title="<?php esc_html_e('admin.builder.fields.h_type.hint', 'outerwhisper'); ?>"></i></label>
                        <select id="outerwhisper-opt-h-type" class="outerwhisper-form-select">
                            <option value="h1"><?php esc_html_e('admin.builder.fields.h_type.h1', 'outerwhisper'); ?></option>
                            <option value="h2"><?php esc_html_e('admin.builder.fields.h_type.h2', 'outerwhisper'); ?></option>
                            <option value="h3"><?php esc_html_e('admin.builder.fields.h_type.h3', 'outerwhisper'); ?></option>
                            <option value="h4"><?php esc_html_e('admin.builder.fields.h_type.h4', 'outerwhisper'); ?></option>
                            <option value="h5"><?php esc_html_e('admin.builder.fields.h_type.h5', 'outerwhisper'); ?></option>
                            <option value="h6"><?php esc_html_e('admin.builder.fields.h_type.h6', 'outerwhisper'); ?></option>
                            <option value="div"><?php esc_html_e('admin.builder.fields.h_type.div', 'outerwhisper'); ?></option>
                        </select>
                    </div>

                    <!-- Text formatting settings -->
                    <div class="outerwhisper-form-group" id="outerwhisper-opt-group-textFormatting" style="display: none;">
                        <label><?php esc_html_e('admin.builder.fields.text_formatting.title', 'outerwhisper'); ?> <i class="fas fa-question-circle outerwhisper-help-tip" title="<?php esc_html_e('admin.builder.fields.text_formatting.hint', 'outerwhisper'); ?>"></i></label>
                        <div style="display: flex; gap: 8px; width: 100%;">
                            <!-- Bold -->
                            <label class="outerwhisper-formatting-btn" style="flex: 1; display: flex; align-items: center; justify-content: center; height: 32px;">
                                <input type="checkbox" id="outerwhisper-opt-bold" style="display: none;" />
                                <i class="fas fa-bold"></i>
                            </label>
                            <!-- Italic -->
                            <label class="outerwhisper-formatting-btn" style="flex: 1; display: flex; align-items: center; justify-content: center; height: 32px;">
                                <input type="checkbox" id="outerwhisper-opt-italic" style="display: none;" />
                                <i class="fas fa-italic"></i>
                            </label>
                            <!-- Underline -->
                            <label class="outerwhisper-formatting-btn" style="flex: 1; display: flex; align-items: center; justify-content: center; height: 32px;">
                                <input type="checkbox" id="outerwhisper-opt-underline" style="display: none;" />
                                <i class="fas fa-underline"></i>
                            </label>
                        </div>
                    </div>

	                <!-- Name Format Settings -->
	                <div class="outerwhisper-form-group" id="outerwhisper-opt-group-name-type" style="margin-bottom: 14px; display: none;">
		                <label style="font-size: 11px; font-weight: 650; margin-bottom: 6px; display: block;"><?php esc_html_e('fields.name.format.label', 'outerwhisper'); ?></label>
		                <select id="outerwhisper-opt-name-type" class="outerwhisper-form-input" style="padding: 6px;">
			                <option value="full" selected><?php esc_html_e('fields.name.format.full', 'outerwhisper'); ?></option>
			                <option value="first_last"><?php esc_html_e('fields.name.format.first_last', 'outerwhisper'); ?></option>
			                <option value="first_middle_last"><?php esc_html_e('fields.name.format.first_middle_last', 'outerwhisper'); ?></option>
		                </select>
	                </div>

	                <div class="outerwhisper-form-group" id="outerwhisper-opt-group-name-placeholders" style="margin-bottom: 14px; display: none;">
		                <label style="font-size: 11px; font-weight: 650; margin-bottom: 6px; display: block;"><?php esc_html_e('admin.builder.fields.placeholder.label', 'outerwhisper'); ?></label>
		                <div style="display: flex; flex-direction: column; gap: 8px;">
			                <input type="text" id="outerwhisper-opt-name-ph-first" class="outerwhisper-form-input" placeholder="<?php esc_html_e('fields.name.first_name', 'outerwhisper'); ?>" />
			                <input type="text" id="outerwhisper-opt-name-ph-middle" class="outerwhisper-form-input" placeholder="<?php esc_html_e('fields.name.middle_name', 'outerwhisper'); ?>" />
			                <input type="text" id="outerwhisper-opt-name-ph-last" class="outerwhisper-form-input" placeholder="<?php esc_html_e('fields.name.last_name', 'outerwhisper'); ?>" />
		                </div>
	                </div>

                    <!-- Inline styles (Font size) -->
                    <div class="outerwhisper-form-group" id="outerwhisper-opt-group-font-size">
                        <div>
                            <input type="hidden" id="outerwhisper-opt-font-size" value="inherit" />
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 6px;">
                                <span style="font-size: 13px; font-weight: 550; color: var(--outerwhisper-text-main); white-space: nowrap;"><?php esc_html_e('admin.builder.fields.font_size.title', 'outerwhisper'); ?></span>
                                <button type="button" id="outerwhisper-opt-font-size-reset" class="outerwhisper-btn" style="font-size: 10px; padding: 2px 4px; height: auto; background: none; border: none; color: var(--outerwhisper-primary); cursor: pointer; text-decoration: underline; box-shadow: none;"><?php esc_html_e('admin.builder.fields.font_size.reset', 'outerwhisper'); ?></button>
                            </div>

	                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; width: 100%;">
		                        <input type="range" id="outerwhisper-opt-font-size-slider" min="6" max="48" step="1" value="16" class="outerwhisper-range-input" style="flex-grow: 1; margin: 0; min-width: 0;" />
		                        <div style="display: inline-flex; align-items: center; border: 1px solid var(--outerwhisper-border); border-radius: 6px; padding: 4px 8px; background: #ffffff; width: 68px; min-width: 68px; justify-content: space-between; height: 28px; box-sizing: border-box;">
			                        <input type="number" id="outerwhisper-opt-font-size-input" min="6" max="48" value="16" style="width: 32px; border: none; font-size: 13px; text-align: right; padding: 0; outline: none; background: transparent; -webkit-appearance: none; -moz-appearance: textfield; margin: 0; font-family: inherit; font-weight: 600; color: var(--outerwhisper-text-main);" />
			                        <span style="font-size: 12px; color: #94a3b8; font-weight: 500; margin-left: 2px; pointer-events: none; user-select: none;">px</span>
		                        </div>
	                        </div>
                        </div>

                        <div style="margin-top: 14px;">
                            <input type="hidden" id="outerwhisper-opt-line-height" value="inherit" />
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 6px;">
                                <span style="font-size: 13px; font-weight: 550; color: var(--outerwhisper-text-main); white-space: nowrap;"><?php esc_html_e('admin.builder.fields.line_height.title', 'outerwhisper'); ?></span>
                                <button type="button" id="outerwhisper-opt-line-height-reset" class="outerwhisper-btn" style="font-size: 10px; padding: 2px 4px; height: auto; background: none; border: none; color: var(--outerwhisper-primary); cursor: pointer; text-decoration: underline; box-shadow: none;"><?php esc_html_e('admin.builder.fields.line_height.reset', 'outerwhisper'); ?></button>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; width: 100%;">
                                <input type="range" id="outerwhisper-opt-line-height-slider" min="0.8" max="3.0" step="0.1" value="1.4" class="outerwhisper-range-input" style="flex-grow: 1; margin: 0; min-width: 0;" />
                                <div style="display: inline-flex; align-items: center; border: 1px solid var(--outerwhisper-border); border-radius: 6px; padding: 4px 8px; background: #ffffff; width: 68px; min-width: 68px; justify-content: space-between; height: 28px; box-sizing: border-box;">
                                    <input type="number" id="outerwhisper-opt-line-height-input" min="0.8" max="3.0" step="0.1" value="1.4" style="width: 32px; border: none; font-size: 13px; text-align: right; padding: 0; outline: none; background: transparent; -webkit-appearance: none; -moz-appearance: textfield; margin: 0; font-family: inherit; font-weight: 600; color: var(--outerwhisper-text-main);" />
                                    <span style="font-size: 12px; color: #94a3b8; font-weight: 500; margin-left: 2px; pointer-events: none; user-select: none;"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Option: BorderRadius (Eckenradius) -->
                    <div class="outerwhisper-form-group" id="outerwhisper-opt-group-border-radius" style="display: none;">
                        <div>
                            <input type="hidden" id="outerwhisper-opt-border-radius" value="inherit" />
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 6px;">
                                <span style="font-size: 13px; font-weight: 550; color: var(--outerwhisper-text-main); white-space: nowrap;"><?php esc_html_e('admin.builder.fields.border_radius.title', 'outerwhisper'); ?></span>
                                <button type="button" id="outerwhisper-opt-border-radius-reset" class="outerwhisper-btn" style="font-size: 10px; padding: 2px 4px; height: auto; background: none; border: none; color: var(--outerwhisper-primary); cursor: pointer; text-decoration: underline; box-shadow: none;"><?php esc_html_e('admin.builder.fields.border_radius.reset', 'outerwhisper'); ?></button>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; width: 100%;">
                                <input type="range" id="outerwhisper-opt-border-radius-slider" min="0" max="100" step="1" value="6" class="outerwhisper-range-input" style="flex-grow: 1; margin: 0; min-width: 0;" />
                                <div style="display: inline-flex; align-items: center; border: 1px solid var(--outerwhisper-border); border-radius: 6px; padding: 4px 8px; background: #ffffff; width: 68px; min-width: 68px; justify-content: space-between; height: 28px; box-sizing: border-box;">
                                    <input type="number" id="outerwhisper-opt-border-radius-input" min="0" max="100" value="6" style="width: 32px; border: none; font-size: 13px; text-align: right; padding: 0; outline: none; background: transparent; -webkit-appearance: none; -moz-appearance: textfield; margin: 0; font-family: inherit; font-weight: 600; color: var(--outerwhisper-text-main);" />
                                    <span style="font-size: 12px; color: #94a3b8; font-weight: 500; margin-left: 2px; pointer-events: none; user-select: none;">px</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Option: Textfarbe -->
                    <div class="outerwhisper-form-group" id="outerwhisper-opt-group-textColor" style="display: none; margin-bottom: 14px;">
                        <label for="outerwhisper-opt-text-color" style="display: flex; align-items: center; gap: 6px; font-weight: 550; font-size: 11.5px; color: var(--outerwhisper-text-main); margin-bottom: 4px;">
                            <i class="fas fa-paint-brush" style="color: var(--outerwhisper-text-secondary); font-size: 11px;"></i> <?php esc_html_e('admin.builder.fields.text_color.title', 'outerwhisper'); ?>
                        </label>
                        <div style="display: flex; gap: 6px; align-items: center;">
                            <input type="color" id="outerwhisper-opt-text-color" style="width: 44px; height: 32px; padding: 2px; cursor: pointer; border-radius: 4px; border: 1px solid var(--outerwhisper-border);" />
                            <input type="text" id="outerwhisper-opt-text-color-hex" class="outerwhisper-form-input" style="font-family: var(--outerwhisper-font-mono); font-size: 11px; height: 32px; padding: 4px 8px;" placeholder="#222222" />
                        </div>
                    </div>

                    <!-- Validation: Required status -->
                    <div class="outerwhisper-switch-group" id="outerwhisper-opt-group-required">
                        <span class="outerwhisper-switch-label"><i class="fas fa-exclamation-triangle" style="color: var(--outerwhisper-warning); font-size: 11px;"></i> <?php esc_html_e('admin.builder.fields.required.title', 'outerwhisper'); ?></span>
                        <label class="outerwhisper-switch-wrapper" for="outerwhisper-opt-required">
                            <input type="checkbox" id="outerwhisper-opt-required" />
                            <span class="outerwhisper-switch-slider"></span>
                        </label>
                    </div>

                    <!-- Option: Hide Label -->
                    <div class="outerwhisper-switch-group" id="outerwhisper-opt-group-hide-label" style="display: none;">
                        <span class="outerwhisper-switch-label"><i class="fas fa-eye-slash" style="color: var(--outerwhisper-text-secondary); font-size: 11px;"></i> <?php esc_html_e('admin.builder.fields.hide_label.title', 'outerwhisper'); ?></span>
                        <label class="outerwhisper-switch-wrapper" for="outerwhisper-opt-hide-label">
                            <input type="checkbox" id="outerwhisper-opt-hide-label" />
                            <span class="outerwhisper-switch-slider"></span>
                        </label>
                    </div>

	                <!-- Option: ChoicesList (Auswahlmöglichkeiten) -->
	                <div class="outerwhisper-form-group" id="outerwhisper-opt-group-choicesList" style="display: none; margin-top: 14px; margin-bottom: 14px;">
		                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
			                <label style="margin-bottom: 0; font-size: 13px; font-weight: 600; color: var(--outerwhisper-text-main); display: flex; align-items: center; gap: 6px;">
				                <?php echo esc_html__('fields.dropdown.choices_title', 'outerwhisper'); ?> <i class="far fa-question-circle outerwhisper-help-tip" title="<?php echo esc_attr__('fields.dropdown.choices_tooltip', 'outerwhisper'); ?>"></i>
			                </label>
		                </div>
		                <div id="outerwhisper-opt-choices-list-container" class="outerwhisper-choices-list-container"></div>
	                </div>

                    <!-- Option: Full Width -->
                    <div class="outerwhisper-switch-group" id="outerwhisper-opt-group-full-width">
                        <span class="outerwhisper-switch-label"><i class="fas fa-arrows-alt-h" style="color: var(--outerwhisper-text-secondary); font-size: 11px;"></i> <?php esc_html_e('admin.builder.fields.full_width.title', 'outerwhisper'); ?></span>
                        <label class="outerwhisper-switch-wrapper" for="outerwhisper-opt-full-width">
                            <input type="checkbox" id="outerwhisper-opt-full-width" />
                            <span class="outerwhisper-switch-slider"></span>
                        </label>
                    </div>

                    <!-- Option: Element-Breite -->
                    <div class="outerwhisper-form-group" id="outerwhisper-opt-group-width" style="display: none;">
                        <label for="outerwhisper-opt-width" style="display: flex; align-items: center; gap: 6px; font-weight: 550; font-size: 11.5px; color: var(--outerwhisper-text-main); margin-bottom: 4px;">
                            <i class="fas fa-arrows-alt-h" style="color: var(--outerwhisper-text-secondary); font-size: 11px;"></i> <?php esc_html_e('admin.builder.fields.width.title', 'outerwhisper'); ?>
                        </label>
                        <select id="outerwhisper-opt-width" class="outerwhisper-form-select">
                            <option value="100%"><?php esc_html_e('admin.builder.fields.width.100', 'outerwhisper'); ?></option>
                            <option value="50%"><?php esc_html_e('admin.builder.fields.width.50', 'outerwhisper'); ?></option>
                            <option value="33%"><?php esc_html_e('admin.builder.fields.width.33', 'outerwhisper'); ?></option>
                            <option value="25%"><?php esc_html_e('admin.builder.fields.width.25', 'outerwhisper'); ?></option>
                        </select>
                    </div>

                    <!-- Option: In neuer Zeile starten -->
                    <div class="outerwhisper-switch-group" id="outerwhisper-opt-group-clear-before" style="display: none;">
                        <span class="outerwhisper-switch-label"><i class="fas fa-level-down-alt" style="color: var(--outerwhisper-text-secondary); font-size: 11px; transform: rotate(90deg);"></i> <?php esc_html_e('admin.builder.fields.clear_before.title', 'outerwhisper'); ?></span>
                        <label class="outerwhisper-switch-wrapper" for="outerwhisper-opt-clear-before">
                            <input type="checkbox" id="outerwhisper-opt-clear-before" />
                            <span class="outerwhisper-switch-slider"></span>
                        </label>
                    </div>

	                <!-- Email Options -->
	                <div class="outerwhisper-switch-group" id="outerwhisper-opt-group-email-confirmation" style="margin-bottom: 14px; display: none;">
		                <span class="outerwhisper-switch-label"><i class="fas fa-envelope-open-text" style="color: var(--outerwhisper-primary); font-size: 11px;"></i> <?php esc_html_e('fields.email.confirmation_activation', 'outerwhisper'); ?></span>
		                <label class="outerwhisper-switch-wrapper" for="outerwhisper-opt-email-confirmation">
			                <input type="checkbox" id="outerwhisper-opt-email-confirmation" />
			                <span class="outerwhisper-switch-slider"></span>
		                </label>
	                </div>

	                <div class="outerwhisper-form-group" id="outerwhisper-opt-group-email-placeholders" style="margin-bottom: 14px; display: none;">
		                <label style="font-size: 11px; font-weight: 650; margin-bottom: 6px; display: block;"><?php esc_html_e('admin.builder.fields.placeholder.label', 'outerwhisper'); ?></label>
		                <div style="display: flex; flex-direction: column; gap: 8px;">
			                <input type="text" id="outerwhisper-opt-email-ph-main" class="outerwhisper-form-input" placeholder="<?php esc_html_e('fields.email.placeholder', 'outerwhisper'); ?>" />
			                <input type="text" id="outerwhisper-opt-email-ph-confirm" class="outerwhisper-form-input" placeholder="<?php esc_html_e('fields.email.confirmation_placeholder', 'outerwhisper'); ?>" />
		                </div>
	                </div>

                    <!-- Button Custom Color Settings -->
                    <div id="outerwhisper-opt-group-button-colors" style="border-top: 1px dashed var(--outerwhisper-border); padding-top: 14px; margin-top: 14px; display: none; flex-direction: column; gap: 12px;">
                        <div id="outerwhisper-opt-custom-colors-title" style="font-weight: 650; font-size: 11.5px; color: var(--outerwhisper-text-primary); margin-bottom: 2px;">
                            <i class="fas fa-palette" style="color: var(--outerwhisper-primary);"></i> <?php esc_html_e('admin.builder.fields.custom_colors.title', 'outerwhisper'); ?>
                        </div>

                        <!-- Toggle to override colors -->
                        <div class="outerwhisper-switch-group" style="margin-bottom: 6px;">
                            <span class="outerwhisper-switch-label" style="font-size: 11px;"><?php esc_html_e('admin.builder.fields.custom_colors.enabled_label', 'outerwhisper'); ?></span>
                            <label class="outerwhisper-switch-wrapper" for="outerwhisper-opt-btn-custom-colors-enabled">
                                <input type="checkbox" id="outerwhisper-opt-btn-custom-colors-enabled" />
                                <span class="outerwhisper-switch-slider"></span>
                            </label>
                        </div>

                        <div id="outerwhisper-opt-btn-colors-subpanel" style="display: none; flex-direction: column; gap: 10px; padding-left: 6px; border-left: 2px solid var(--outerwhisper-border);">
                            <!-- Standard state colors -->
                            <div id="outerwhisper-opt-colors-standard-header" style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--outerwhisper-text-secondary);"><?php esc_html_e('admin.builder.fields.custom_colors.standard_state', 'outerwhisper'); ?></div>

                            <div class="outerwhisper-form-group" id="outerwhisper-opt-colors-group-bg" style="margin-bottom: 4px;">
                                <label style="font-size: 10.5px;"><?php esc_html_e('admin.builder.fields.custom_colors.bg_color', 'outerwhisper'); ?></label>
                                <div style="display: flex; gap: 6px; align-items: center;">
                                    <input type="color" id="outerwhisper-opt-btn-bg-color" style="width: 44px; height: 32px; padding: 2px; cursor: pointer; border-radius: 4px; border: 1px solid var(--outerwhisper-border);" />
                                    <input type="text" id="outerwhisper-opt-btn-bg-hex" class="outerwhisper-form-input" style="font-family: var(--outerwhisper-font-mono); font-size: 11px; height: 32px; padding: 4px 8px;" />
                                </div>
                            </div>

                            <div class="outerwhisper-form-group" id="outerwhisper-opt-colors-group-text" style="margin-bottom: 4px;">
                                <label style="font-size: 10.5px;"><?php esc_html_e('admin.builder.fields.custom_colors.text_color', 'outerwhisper'); ?></label>
                                <div style="display: flex; gap: 6px; align-items: center;">
                                    <input type="color" id="outerwhisper-opt-btn-text-color" style="width: 44px; height: 32px; padding: 2px; cursor: pointer; border-radius: 4px; border: 1px solid var(--outerwhisper-border);" />
                                    <input type="text" id="outerwhisper-opt-btn-text-hex" class="outerwhisper-form-input" style="font-family: var(--outerwhisper-font-mono); font-size: 11px; height: 32px; padding: 4px 8px;" />
                                </div>
                            </div>

                            <div class="outerwhisper-form-group" id="outerwhisper-opt-colors-group-border" style="margin-bottom: 8px;">
                                <label style="font-size: 10.5px;"><?php esc_html_e('admin.builder.fields.custom_colors.border_color', 'outerwhisper'); ?></label>
                                <div style="display: flex; gap: 6px; align-items: center;">
                                    <input type="color" id="outerwhisper-opt-btn-border-color" style="width: 44px; height: 32px; padding: 2px; cursor: pointer; border-radius: 4px; border: 1px solid var(--outerwhisper-border);" />
                                    <input type="text" id="outerwhisper-opt-btn-border-hex" class="outerwhisper-form-input" style="font-family: var(--outerwhisper-font-mono); font-size: 11px; height: 32px; padding: 4px 8px;" />
                                </div>
                            </div>

                            <!-- Hover state colors -->
                            <div id="outerwhisper-opt-colors-hover-header" style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--outerwhisper-text-secondary); margin-top: 4px; border-top: 1px dashed var(--outerwhisper-border); padding-top: 8px;"><?php esc_html_e('admin.builder.fields.custom_colors.hover_state', 'outerwhisper'); ?></div>

                            <div class="outerwhisper-form-group" id="outerwhisper-opt-colors-group-hover-bg" style="margin-bottom: 4px;">
                                <label style="font-size: 10.5px;"><?php esc_html_e('admin.builder.fields.custom_colors.bg_color_hover', 'outerwhisper'); ?></label>
                                <div style="display: flex; gap: 6px; align-items: center;">
                                    <input type="color" id="outerwhisper-opt-btn-hover-bg-color" style="width: 44px; height: 32px; padding: 2px; cursor: pointer; border-radius: 4px; border: 1px solid var(--outerwhisper-border);" />
                                    <input type="text" id="outerwhisper-opt-btn-hover-bg-hex" class="outerwhisper-form-input" style="font-family: var(--outerwhisper-font-mono); font-size: 11px; height: 32px; padding: 4px 8px;" />
                                </div>
                            </div>

                            <div class="outerwhisper-form-group" id="outerwhisper-opt-colors-group-hover-text" style="margin-bottom: 4px;">
                                <label style="font-size: 10.5px;"><?php esc_html_e('admin.builder.fields.custom_colors.text_color_hover', 'outerwhisper'); ?></label>
                                <div style="display: flex; gap: 6px; align-items: center;">
                                    <input type="color" id="outerwhisper-opt-btn-hover-text-color" style="width: 44px; height: 32px; padding: 2px; cursor: pointer; border-radius: 4px; border: 1px solid var(--outerwhisper-border);" />
                                    <input type="text" id="outerwhisper-opt-btn-hover-text-hex" class="outerwhisper-form-input" style="font-family: var(--outerwhisper-font-mono); font-size: 11px; height: 32px; padding: 4px 8px;" />
                                </div>
                            </div>

                            <div class="outerwhisper-form-group" id="outerwhisper-opt-colors-group-hover-border" style="margin-bottom: 4px;">
                                <label style="font-size: 10.5px;"><?php esc_html_e('admin.builder.fields.custom_colors.border_color_hover', 'outerwhisper'); ?></label>
                                <div style="display: flex; gap: 6px; align-items: center;">
                                    <input type="color" id="outerwhisper-opt-btn-hover-border-color" style="width: 44px; height: 32px; padding: 2px; cursor: pointer; border-radius: 4px; border: 1px solid var(--outerwhisper-border);" />
                                    <input type="text" id="outerwhisper-opt-btn-hover-border-hex" class="outerwhisper-form-input" style="font-family: var(--outerwhisper-font-mono); font-size: 11px; height: 32px; padding: 4px 8px;" />
                                </div>
                            </div>

                            <button type="button" id="outerwhisper-opt-btn-colors-reset" class="outerwhisper-btn" style="margin-top: 10px; width: 100%; font-size: 11px; padding: 6px 12px; height: auto; display: flex; align-items: center; justify-content: center; gap: 6px; border: 1px solid var(--outerwhisper-border); background: #ffffff; color: var(--outerwhisper-text-primary); border-radius: 4px; cursor: pointer; transition: all 0.2s; box-shadow: none;">
                                <i class="fas fa-undo"></i> <?php esc_html_e('admin.builder.fields.custom_colors.reset', 'outerwhisper'); ?>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2 Trigger Toggle for Buttons & Ratings -->
                    <div id="outerwhisper-opt-group-step2" style="border-top: 1px dashed var(--outerwhisper-border); padding-top: 14px; margin-top: 4px; flex-direction: column;">
                        <div class="outerwhisper-switch-group">
              <span class="outerwhisper-switch-label" style="color: var(--outerwhisper-step2-accent); font-weight: 650;">
                <i class="fas fa-project-diagram"></i> <?php esc_html_e('admin.builder.fields.step2.title_activate', 'outerwhisper'); ?>
              </span>
                            <label class="outerwhisper-switch-wrapper" for="outerwhisper-opt-step2-enabled">
                                <input type="checkbox" id="outerwhisper-opt-step2-enabled" />
                                <span class="outerwhisper-switch-slider"></span>
                            </label>
                        </div>
                        <p style="font-size: 10.5px; color: var(--outerwhisper-text-secondary); line-height: 1.35; margin-top: 6px;">
                            <?php esc_html_e('admin.builder.fields.step2.description', 'outerwhisper'); ?>
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </aside>

    <!-- Visual Editor Canvas Area -->
    <article class="outerwhisper-editor-canvas-column" id="outerwhisper-canvas-column">

        <div class="outerwhisper-editor-steps-container">

            <!-- SCHRITT 1 CONTAINER CARD -->
            <div class="outerwhisper-step-card outerwhisper-step-card-step1" id="outerwhisper-step-1-card">

                <div class="outerwhisper-step-header" id="outerwhisper-step-1-header">
                    <div class="outerwhisper-step-meta-left">
                        <span class="outerwhisper-step-index-badge outerwhisper-step-badge-1">1</span>
                        <div>
                            <h3 class="outerwhisper-step-title"><?php esc_html_e('admin.builder.fields.step1.title', 'outerwhisper'); ?></h3>
                            <span class="outerwhisper-step-subtitle" id="outerwhisper-step-1-count"><?php esc_html_e('admin.builder.fields.step1.subtitle', 'outerwhisper'); ?></span>
                        </div>
                    </div>
                    <div class="outerwhisper-step-nav-action" id="outerwhisper-step-1-nav-toggle" style="display: none;">
                        <i class="fas fa-compress-alt"></i> <?php esc_html_e('admin.builder.fields.nav.back', 'outerwhisper'); ?>
                    </div>
                </div>

                <!-- Droppable Area -->
                <div class="outerwhisper-step-canvas-droppable" id="outerwhisper-canvas-step-1" data-step="1">

                    <div class="outerwhisper-canvas-empty-notifier">
                        <i class="fas fa-hand-holding-hand drag-icon"></i>
                        <span><?php esc_html_e('admin.builder.fields.step1.empty_notifier', 'outerwhisper'); ?></span>
                    </div>

                </div>

            </div>


            <!-- CONNECTOR CONNECTOR LINE (VISUAL ONLY) -->
            <div id="outerwhisper-steps-visual-connector" style="display: flex; justify-content: center; align-items: center; margin: -10px 0;">
                <div style="width: 2px; height: 24px; background: repeating-linear-gradient(to bottom, #cbd5e1, #cbd5e1 4px, transparent 4px, transparent 8px); z-index: 1;"></div>
            </div>


            <!-- SCHRITT 2 CONTAINER CARD (Tied dynamically) -->
            <div class="outerwhisper-step-card outerwhisper-step-card-step2" id="outerwhisper-step-2-card">

                <div class="outerwhisper-step-header" id="outerwhisper-step-2-header" style="cursor: pointer;">
                    <div class="outerwhisper-step-meta-left">
                        <span class="outerwhisper-step-index-badge outerwhisper-step-badge-2">2</span>
                        <div>
                            <h3 class="outerwhisper-step-title"><?php esc_html_e('admin.builder.fields.step2.title', 'outerwhisper'); ?></h3>
                            <span class="outerwhisper-step-subtitle" id="outerwhisper-step-2-count"><?php esc_html_e('admin.builder.fields.step2.subtitle', 'outerwhisper'); ?></span>
                        </div>
                    </div>
                    <div class="outerwhisper-step-nav-action" id="outerwhisper-step-2-nav-toggle">
                        <i class="fas fa-expand-alt"></i> <?php esc_html_e('admin.builder.fields.nav.maximize', 'outerwhisper'); ?>
                    </div>
                </div>

                <!-- Droppable Area Step 2 -->
                <div class="outerwhisper-step-canvas-droppable" id="outerwhisper-canvas-step-2" data-step="2">

                    <div class="outerwhisper-canvas-empty-notifier" id="outerwhisper-step-2-disabled-notifier">
                        <i class="fas fa-lock"></i>
                        <span><?php esc_html_e('admin.builder.fields.step2.disabled_notifier', 'outerwhisper'); ?></span>
                    </div>

                    <div class="outerwhisper-canvas-empty-notifier" id="outerwhisper-step-2-enabled-empty-notifier" style="display: none;">
                        <i class="fas fa-plus"></i>
                        <span><?php esc_html_e('admin.builder.fields.step2.enabled_notifier', 'outerwhisper'); ?></span>
                    </div>

                </div>

            </div>

        </div>

    </article>

    <!-- Split-View Live-Vorschau Column (Initially collapsed or shown per click) -->
    <aside class="outerwhisper-split-preview-column outerwhisper-feedback-plugin" id="outerwhisper-split-preview-column" style="display: none;">
	    <!-- RIGHT COLUMN: LIVE INTERACTIVE SIMULATOR -->
	    <div id="outerwhisper-preview-simulator-container-fields" class="outerwhisper-preview-simulator-container"></div>
    </aside>

</section>
