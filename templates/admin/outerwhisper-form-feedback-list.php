<?php
if (!defined('ABSPATH')) {
	exit;
}

$outerwhisperKpis = $preparedKpiData ?? [];

$outerwhisperKpi_total             = $outerwhisperKpis['total'] ?? 0;
$outerwhisperKpi_prev_total        = $outerwhisperKpis['prev_total'] ?? 0;
$outerwhisperKpi_total_diff        = $outerwhisperKpis['total_diff'] ?? 0;
$outerwhisperKpi_total_change_pct  = $outerwhisperKpis['total_change_pct'] ?? null;
$outerwhisperKpi_has_previous      = !empty($outerwhisperKpis['has_previous_period']);

$outerwhisperKpi_rated             = $outerwhisperKpis['rated'] ?? 0;
$outerwhisperKpi_rated_pct         = $outerwhisperKpis['rated_pct'] ?? 0;

$outerwhisperKpi_avg_score         = $outerwhisperKpis['avg_score'] ?? null;
$outerwhisperKpi_avg_score_diff    = $outerwhisperKpis['avg_score_diff'] ?? null;

$outerwhisperKpi_positive_pct      = $outerwhisperKpis['positive_pct'] ?? 0;
$outerwhisperKpi_negative_pct      = $outerwhisperKpis['negative_pct'] ?? 0;
$outerwhisperKpi_positive_pct_diff = $outerwhisperKpis['positive_pct_diff'] ?? null;

$outerwhisperKpi_unread            = $outerwhisperKpis['unread'] ?? 0;
?>

<section id="outerwhisper-feedback-section" class="outerwhisper-feedback-workspace outerwhisper-feedback-workspace-with-drawer" aria-label="<?php esc_attr_e('admin.page.feedback_list.overview', 'outerwhisper'); ?>">
	<div class="outerwhisper-feedback-main-panel">
		<header class="outerwhisper-feedback-header">
			<div>
				<h1 class="outerwhisper-feedback-title"><?php esc_html_e('admin.page.feedback_list.heading', 'outerwhisper'); ?></h1>
				<p class="outerwhisper-feedback-subtitle"><strong><?php esc_html_e('admin.page.feedback_list.subtitle_bold', 'outerwhisper'); ?></strong> <?php esc_html_e('admin.page.feedback_list.subtitle_text', 'outerwhisper'); ?></p>
			</div>
		</header>

		<div class="outerwhisper-feedback-kpi-grid" role="region" aria-label="<?php esc_attr_e('admin.page.feedback_list.kpi.aria_label', 'outerwhisper'); ?>">
			<article class="outerwhisper-feedback-kpi-card">
				<div class="outerwhisper-feedback-kpi-top">
					<span class="outerwhisper-feedback-kpi-label"><?php esc_html_e('admin.page.feedback_list.kpi.total', 'outerwhisper'); ?></span>
					<span class="outerwhisper-feedback-kpi-icon outerwhisper-feedback-kpi-icon-blue" aria-hidden="true">
						<i class="fa-regular fa-comment-dots"></i>
					</span>
				</div>
				<div class="outerwhisper-feedback-kpi-middle">
					<span id="outerwhisper-feedback-kpi-total" class="outerwhisper-feedback-kpi-value"><?php echo esc_html(number_format_i18n($outerwhisperKpi_total)); ?></span>
					<?php if ($outerwhisperKpi_has_previous && null !== $outerwhisperKpi_total_change_pct) : ?>
						<span class="outerwhisper-feedback-kpi-trend <?php echo $outerwhisperKpi_total_diff < 0 ? 'outerwhisper-feedback-kpi-trend-down' : ($outerwhisperKpi_total_diff === 0 ? 'outerwhisper-feedback-kpi-trend-neutral' : ''); ?>">
							<i class="fa-solid <?php echo $outerwhisperKpi_total_diff > 0 ? 'fa-arrow-up' : ($outerwhisperKpi_total_diff < 0 ? 'fa-arrow-down' : 'fa-minus'); ?>" aria-hidden="true"></i>
							<?php echo esc_html(($outerwhisperKpi_total_change_pct > 0 ? '+ ' : ($outerwhisperKpi_total_change_pct < 0 ? '- ' : '')) . abs($outerwhisperKpi_total_change_pct) . ' %'); ?>
						</span>
					<?php endif; ?>
				</div>
				<div class="outerwhisper-feedback-kpi-bottom">
					<?php if ($outerwhisperKpi_has_previous) : ?>
						<span><?php printf(esc_html__('admin.page.feedback_list.kpi.prev_period', 'outerwhisper'), esc_html(number_format_i18n($outerwhisperKpi_prev_total))); ?></span>
					<?php else : ?>
						<span><?php esc_html_e('admin.page.feedback_list.kpi.all_time', 'outerwhisper'); ?></span>
					<?php endif; ?>
				</div>
			</article>

			<article class="outerwhisper-feedback-kpi-card">
				<div class="outerwhisper-feedback-kpi-top">
					<span class="outerwhisper-feedback-kpi-label"><?php esc_html_e('admin.page.feedback_list.kpi.rated', 'outerwhisper'); ?></span>
					<span class="outerwhisper-feedback-kpi-icon outerwhisper-feedback-kpi-icon-blue" aria-hidden="true">
						<i class="fa-solid fa-chart-column"></i>
					</span>
				</div>
				<div class="outerwhisper-feedback-kpi-middle">
					<span id="outerwhisper-feedback-kpi-rated" class="outerwhisper-feedback-kpi-value"><?php echo esc_html(number_format_i18n($outerwhisperKpi_rated)); ?></span>
				</div>
				<div class="outerwhisper-feedback-kpi-bottom">
					<span class="outerwhisper-feedback-kpi-bottom-strong"><?php echo esc_html((string) $outerwhisperKpi_rated_pct); ?> %</span>
				</div>
			</article>

			<article class="outerwhisper-feedback-kpi-card">
				<div class="outerwhisper-feedback-kpi-top">
					<span class="outerwhisper-feedback-kpi-label"><?php esc_html_e('admin.page.feedback_list.kpi.avg_score', 'outerwhisper'); ?></span>
					<span class="outerwhisper-feedback-kpi-icon outerwhisper-feedback-kpi-icon-amber" aria-hidden="true">
						<i class="fa-solid fa-star"></i>
					</span>
				</div>
				<div class="outerwhisper-feedback-kpi-middle">
					<span id="outerwhisper-feedback-kpi-avg" class="outerwhisper-feedback-kpi-value">
						<?php if (null !== $outerwhisperKpi_avg_score) : ?>
							<?php echo esc_html(number_format_i18n($outerwhisperKpi_avg_score, 1)); ?> <span class="outerwhisper-feedback-kpi-value-unit">/ 100</span>
						<?php else : ?>
							–
						<?php endif; ?>
					</span>
				</div>
				<div class="outerwhisper-feedback-kpi-bottom">
					<?php if ($outerwhisperKpi_has_previous && null !== $outerwhisperKpi_avg_score_diff) : ?>
						<span class="outerwhisper-feedback-kpi-trend <?php echo $outerwhisperKpi_avg_score_diff < 0 ? 'outerwhisper-feedback-kpi-trend-down' : ($outerwhisperKpi_avg_score_diff == 0 ? 'outerwhisper-feedback-kpi-trend-neutral' : ''); ?>">
							<i class="fa-solid <?php echo $outerwhisperKpi_avg_score_diff > 0 ? 'fa-arrow-up' : ($outerwhisperKpi_avg_score_diff < 0 ? 'fa-arrow-down' : 'fa-minus'); ?>" aria-hidden="true"></i>
							<?php echo esc_html(($outerwhisperKpi_avg_score_diff > 0 ? '+ ' : ($outerwhisperKpi_avg_score_diff < 0 ? '- ' : '')) . number_format_i18n(abs($outerwhisperKpi_avg_score_diff), 1)); ?>
						</span>
					<?php endif; ?>
				</div>
			</article>

			<article class="outerwhisper-feedback-kpi-card">
				<div class="outerwhisper-feedback-kpi-top">
					<span class="outerwhisper-feedback-kpi-label"><?php esc_html_e('admin.page.feedback_list.kpi.sentiment', 'outerwhisper'); ?></span>
					<span class="outerwhisper-feedback-kpi-icon outerwhisper-feedback-kpi-icon-green" aria-hidden="true">
						<i class="fa-solid fa-thumbs-up"></i>
					</span>
				</div>
				<div class="outerwhisper-feedback-kpi-middle">
					<span class="outerwhisper-feedback-kpi-sentiment-main">
						<i class="fa-solid fa-thumbs-up" aria-hidden="true"></i> <?php echo esc_html((string) $outerwhisperKpi_positive_pct); ?> %
					</span>
					<?php if ($outerwhisperKpi_has_previous && null !== $outerwhisperKpi_positive_pct_diff) : ?>
						<span class="outerwhisper-feedback-kpi-trend <?php echo $outerwhisperKpi_positive_pct_diff < 0 ? 'outerwhisper-feedback-kpi-trend-down' : ($outerwhisperKpi_positive_pct_diff === 0 ? 'outerwhisper-feedback-kpi-trend-neutral' : ''); ?>">
							<i class="fa-solid <?php echo $outerwhisperKpi_positive_pct_diff > 0 ? 'fa-arrow-up' : ($outerwhisperKpi_positive_pct_diff < 0 ? 'fa-arrow-down' : 'fa-minus'); ?>" aria-hidden="true"></i>
							<?php echo esc_html(($outerwhisperKpi_positive_pct_diff > 0 ? '+ ' : ($outerwhisperKpi_positive_pct_diff < 0 ? '- ' : '')) . abs($outerwhisperKpi_positive_pct_diff) . ' %'); ?>
						</span>
					<?php endif; ?>
				</div>
				<div class="outerwhisper-feedback-kpi-bottom">
					<i class="fa-solid fa-thumbs-down outerwhisper-feedback-kpi-bottom-neg" aria-hidden="true"></i>
					<span><?php printf(esc_html__('admin.page.feedback_list.kpi.negative_pct', 'outerwhisper'), (int) $outerwhisperKpi_negative_pct); ?></span>
				</div>
			</article>

			<article class="outerwhisper-feedback-kpi-card">
				<div class="outerwhisper-feedback-kpi-top">
					<span class="outerwhisper-feedback-kpi-label"><?php esc_html_e('admin.page.feedback_list.status.unread', 'outerwhisper'); ?></span>
					<span class="outerwhisper-feedback-kpi-icon outerwhisper-feedback-kpi-icon-red" aria-hidden="true">
						<i class="fa-regular fa-envelope"></i>
					</span>
				</div>
				<div class="outerwhisper-feedback-kpi-middle">
					<span id="outerwhisper-feedback-kpi-unread" class="outerwhisper-feedback-kpi-value outerwhisper-feedback-kpi-value-danger"><?php echo esc_html(number_format_i18n($outerwhisperKpi_unread)); ?></span>
				</div>
				<div class="outerwhisper-feedback-kpi-bottom">
					<span><?php printf(esc_html__('admin.page.feedback_list.kpi.of_total', 'outerwhisper'), esc_html(number_format_i18n($outerwhisperKpi_total))); ?></span>
				</div>
			</article>
		</div>

		<form id="outerwhisper-feedback-list-form" class="outerwhisper-feedback-form" method="get" action="">
			<input type="hidden" name="page" value="outerwhisper-form-feedbacks" />
			<?php wp_nonce_field('outerwhisper_admin_nonce', 'nonce'); ?>

			<?php if (isset($feedback_table)) : ?>
				<?php $feedback_table->display(); ?>
			<?php endif; ?>
		</form>
	</div>

	<aside id="outerwhisper-feedback-detail-drawer" class="outerwhisper-feedback-detail-drawer" aria-label="<?php esc_attr_e('admin.page.feedback_list.drawer.aria_label', 'outerwhisper'); ?>">
		<?php
		if (!empty($first_feedback_detail) && is_array($first_feedback_detail)) {
			extract($first_feedback_detail, EXTR_SKIP);
			require __DIR__ . '/partial/outerwhisper-form-feedback-list-detail.php';
		} else {
			?>
			<div class="outerwhisper-feedback-drawer-empty" style="padding: 32px; text-align: center; color: var(--outerwhisper-feedback-text-muted);">
				<i class="fa-regular fa-comment-dots" style="font-size: 32px; margin-bottom: 12px; display: block;" aria-hidden="true"></i>
				<p style="margin: 0; font-size: 14px;"><?php esc_html_e('admin.page.feedback_list.drawer.empty', 'outerwhisper'); ?></p>
			</div>
			<?php
		}
		?>
	</aside>
</section>
