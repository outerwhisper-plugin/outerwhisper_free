<?php
if (!defined('ABSPATH')) {
	exit;
}

$outerwhisperProNoticeModalPath = OUTERWHISPER_PLUGIN_PATH . 'templates/admin/partial/outerwhisper-pro-notice-modal.php';
if (isset($outerwhisperProNoticeModalPath) && file_exists($outerwhisperProNoticeModalPath)) {
	$outerwhisperProNoticeHeadline = esc_html__('admin.page.export.pro_notice.headline', 'outerwhisper');

	$outerwhisperProNoticeIntro = wp_kses(__('admin.page.export.pro_notice.intro', 'outerwhisper'), ['strong' => []]);
	$outerwhisperProNoticeAdvantages = [
		esc_html__('admin.page.export.pro_notice.advantage.1', 'outerwhisper'),
		esc_html__('admin.page.export.pro_notice.advantage.2', 'outerwhisper'),
		esc_html__('admin.page.export.pro_notice.advantage.3', 'outerwhisper'),
		esc_html__('admin.page.export.pro_notice.advantage.4', 'outerwhisper')
	];

	include $outerwhisperProNoticeModalPath;
}
?>

<?php include OUTERWHISPER_PLUGIN_PATH . 'templates/admin/partial/mockup/export.php'; ?>