<?php
/**
 * Template for Form Shortcode
 */
if (!defined('ABSPATH')) exit;

$outerwhisperStyleAttribute = '';
if (!empty($inlineStyles)) {
	$outerwhisperStyleAttribute = implode('; ', $inlineStyles);
}

$outerwhisperWrapperClasses = ['outerwhisper-feedback-plugin', 'outerwhisper-feedback-type-placeholder', 'outerwhisper-in-content-feedback-container', esc_attr('outerwhisper-form-id-' . $formData['id'])];
if (!empty($customClasses)) :
	$outerwhisperWrapperClasses[] = esc_attr($customClasses);
endif;
?>
<div class="<?php echo esc_html(implode(' ', $outerwhisperWrapperClasses)) ?>" <?php echo !empty($outerwhisperStyleAttribute) ? 'style="' . esc_attr($outerwhisperStyleAttribute) . '"' : ''; ?> data-type="<?php echo esc_attr($formType) ?>" data-form-id="<?php echo esc_attr($formData['id']) ?>" data-form-updated="<?php echo esc_attr($formUpdated) ?>"></div>