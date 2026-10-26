<?php
if (!defined('ABSPATH')) {
	exit;
}

use OuterWhisper\Helper\FormHelper;

$outerwhisperFormHelper = new FormHelper();
?>

<section id="outerwhisper-view-start" class="outerwhisper-view-section">
    <header class="outerwhisper-view-header">
        <h2 style="font-size: 24px; font-weight: 600; margin: 0 0 5px 0; color: var(--outerwhisper-primary-color);"><?php esc_html_e('admin.page.dashboard.welcome', 'outerwhisper'); ?></h2>
        <p><?php esc_html_e('admin.page.dashboard.overview', 'outerwhisper'); ?></p>
    </header>
    <div class="outerwhisper-stats-grid bento-grid">
        <div class="outerwhisper-stat-card card-span-2">
            <div class="outerwhisper-stat-info" style="width: 100%;">
                <span class="outerwhisper-stat-label"><?php esc_html_e('admin.page.dashboard.summary', 'outerwhisper'); ?></span>
                <div style="display: flex; justify-content: space-between; margin-top: 15px; gap: 15px; flex-wrap: wrap;">
                    <div>
                        <span style="font-size: 11px; color: var(--outerwhisper-text-secondary); text-transform: uppercase; display: block;"><?php esc_html_e('admin.page.dashboard.total', 'outerwhisper'); ?></span>
                        <span class="outerwhisper-stat-value" id="outerwhisper-stat-total" style="font-size: 24px; margin: 0;"><?php echo (int) $stats['total']; ?></span>
                    </div>
                    <div>
                        <span style="font-size: 11px; color: var(--outerwhisper-text-secondary); text-transform: uppercase; display: block;"><?php esc_html_e('admin.page.dashboard.today', 'outerwhisper'); ?></span>
                        <span class="outerwhisper-stat-value" id="outerwhisper-stat-today" style="font-size: 24px; margin: 0;"><?php echo (int) $stats['today']; ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="outerwhisper-stat-card card-span-2">
            <div class="outerwhisper-stat-info">
                <span class="outerwhisper-stat-label"><?php esc_html_e('admin.page.dashboard.distribution_by_type', 'outerwhisper'); ?></span>
                <div id="outerwhisper-stat-types" style="display: flex; flex-direction: column; gap: 15px; margin-top: 15px;">
                    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-size: 11px; color: var(--outerwhisper-text-secondary); text-transform: uppercase; min-width: 80px;"><?php esc_html_e('admin.page.dashboard.type.shortcode', 'outerwhisper'); ?></span>
                            <span class="outerwhisper-badge" style="background:#f6f7f7; color:#50575e"><?php echo (int) ($stats['types']['shortcode']['total'] ?? 0); ?></span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-size: 11px; color: var(--outerwhisper-text-secondary); text-transform: uppercase; min-width: 80px;"><?php esc_html_e('admin.page.dashboard.type.pre_content', 'outerwhisper'); ?></span>
                            <span class="outerwhisper-badge" style="background:#f6f7f7; color:#50575e"><?php echo (int) ($stats['types']['pre-content']['total'] ?? 0); ?></span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-size: 11px; color: var(--outerwhisper-text-secondary); text-transform: uppercase; min-width: 80px;"><?php esc_html_e('admin.page.dashboard.type.post_content', 'outerwhisper'); ?></span>
                            <span class="outerwhisper-badge" style="background:#f6f7f7; color:#50575e"><?php echo (int) ($stats['types']['post-content']['total'] ?? 0); ?></span>
                        </div>
	                    <div style="display: flex; align-items: center; gap: 10px;">
		                    <span style="font-size: 11px; color: var(--outerwhisper-text-secondary); text-transform: uppercase; min-width: 80px;"><?php esc_html_e('admin.page.dashboard.type.overlay', 'outerwhisper'); ?></span>
		                    <span class="outerwhisper-badge" style="background:#f6f7f7; color:#50575e"><?php echo (int) ($stats['types']['modal']['total'] ?? 0); ?></span>
	                    </div>
	                    <div style="display: flex; align-items: center; gap: 10px;">
		                    <span style="font-size: 11px; color: var(--outerwhisper-text-secondary); text-transform: uppercase; min-width: 80px;"><?php esc_html_e('admin.page.dashboard.type.slide_in', 'outerwhisper'); ?></span>
		                    <span class="outerwhisper-badge" style="background:#f6f7f7; color:#50575e"><?php echo (int) ($stats['types']['slide-in']['total'] ?? 0); ?></span>
	                    </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-size: 11px; color: var(--outerwhisper-text-secondary); text-transform: uppercase; min-width: 80px;"><?php esc_html_e('admin.page.dashboard.type.feedback_button', 'outerwhisper'); ?></span>
                            <span class="outerwhisper-badge" style="background:#f6f7f7; color:#50575e"><?php echo (int) ($stats['types']['feedback-button']['total'] ?? 0); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="outerwhisper-recent-activity card-span-4 card-span-2">
            <h3><?php esc_html_e('admin.page.dashboard.recent_activities', 'outerwhisper'); ?></h3>
            <ul id="outerwhisper-activity-list" class="outerwhisper-list-simple">
                <?php 
                $outerwhisperFormFeedbackDb = new \OuterWhisper\Database\FormFeedback();
                $outerwhisperRecentFeedbacks = $outerwhisperFormFeedbackDb->get_feedbacks(['limit' => 5]);
                if (empty($outerwhisperRecentFeedbacks)):
                ?>
                    <li><?php esc_html_e('admin.page.dashboard.no_activities', 'outerwhisper'); ?></li>
                <?php else: ?>
                    <?php foreach ($outerwhisperRecentFeedbacks as $outerwhisperFeedbackEntity):
                        $outerwhisperFeedbackItem = $outerwhisperFeedbackEntity->toArray();
                        $outerwhisperFeedbackData = $outerwhisperFeedbackEntity->getDecodedFeedbackData();
                        ?>
                        <li>
                            <div style="display: flex; flex-direction: column; width: 100%;">
                                <span style="display: block; width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <strong><?php echo esc_html($outerwhisperFormHelper->get_form_type_name($outerwhisperFeedbackItem['form_type'])); ?>:</strong>
                                    <?php echo esc_html($outerwhisperFeedbackData['title'] ?? '-'); ?>
                                </span>
                                <small style="color: var(--outerwhisper-text-secondary); font-size: 11px;">
									<?php echo esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($outerwhisperFeedbackItem['created']))); ?>
                                    <span style="margin-left: 2px; opacity: 0.8;">| #<?php echo (int) $outerwhisperFeedbackItem['id']; ?></span>
                                </small>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <div class="outerwhisper-dashboard-chart-container">
        <h3><?php esc_html_e('admin.page.dashboard.feedback_trend', 'outerwhisper'); ?></h3>
        <div style="height: 300px; width: 100%;">
            <canvas id="outerwhisper-feedback-trend-chart"></canvas>
        </div>
    </div>
</section>
