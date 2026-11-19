<?php

use OuterWhisper\Helper\StatisticService;

if (!defined('ABSPATH')) {
	exit;
}

$outerwhisperFilters       = $filters ?? [];
$outerwhisperCurrentPeriod = !empty($outerwhisperFilters['period']) ? $outerwhisperFilters['period'] : '30d';
$outerwhisperCurrentForm   = !empty($outerwhisperFilters['form_id']) ? (string) $outerwhisperFilters['form_id'] : 'all';

$outerwhisperKpis = $preparedKpiData ?? [];

$outerwhisperDashboardData = $dashboardData ?? [];
$outerwhisperTrendChartData = $outerwhisperDashboardData['trend_chart_data'] ?? [];
$outerwhisperTopForms      = $outerwhisperDashboardData['top_forms'] ?? [];
$outerwhisperTopPages      = $outerwhisperDashboardData['top_pages'] ?? [];
$outerwhisperDisplayStats  = $outerwhisperDashboardData['display_type_stats'] ?? [];
$outerwhisperDisplayTotal  = $outerwhisperDisplayStats['total_formatted'] ?? '0';
$outerwhisperDisplayItems  = $outerwhisperDisplayStats['items'] ?? [];
$outerwhisperRecentFeedbacks = $outerwhisperDashboardData['recent_feedbacks'] ?? [];
$outerwhisperRatingDist    = $outerwhisperDashboardData['rating_distribution'] ?? [];
$outerwhisperDistStars     = $outerwhisperRatingDist['stars'] ?? [];

$outerwhisperKpi_total             = $outerwhisperKpis['total'] ?? 0;
$outerwhisperKpi_prev_total        = $outerwhisperKpis['prev_total'] ?? 0;
$outerwhisperKpi_total_change_pct  = $outerwhisperKpis['total_change_pct'] ?? null;
$outerwhisperKpi_has_previous      = !empty($outerwhisperKpis['has_previous_period']);

$outerwhisperKpi_avg_score         = $outerwhisperKpis['avg_score'] ?? null;
$outerwhisperKpi_prev_avg_score    = $outerwhisperKpis['prev_avg_score'] ?? null;
$outerwhisperKpi_avg_score_diff    = $outerwhisperKpis['avg_score_diff'] ?? null;

$outerwhisperKpi_positive_pct      = $outerwhisperKpis['positive_pct'] ?? 0;
$outerwhisperKpi_positive_pct_diff = $outerwhisperKpis['positive_pct_diff'] ?? null;
$outerwhisperKpi_rated             = $outerwhisperKpis['rated'] ?? 0;

$outerwhisperKpi_pages             = $outerwhisperKpis['pages'] ?? 0;
$outerwhisperKpi_prev_pages        = $outerwhisperKpis['prev_pages'] ?? 0;
$outerwhisperKpi_pages_change_pct  = $outerwhisperKpis['pages_change_pct'] ?? null;
?>

<section id="outerwhisper-view-start" class="outerwhisper-view-section outerwhisper-dashboard-section">

	<header class="outerwhisper-dashboard-header">
		<div>
			<h1 class="outerwhisper-dashboard-title"><?php esc_html_e('admin.page.dashboard.title', 'outerwhisper'); ?></h1>
			<p class="outerwhisper-dashboard-subtitle"><?php esc_html_e('admin.page.dashboard.subtitle', 'outerwhisper'); ?></p>
		</div>
		<form id="outerwhisper-dashboard-filter-form" class="outerwhisper-dashboard-filters" method="get" action="">
			<input type="hidden" name="page" value="outerwhisper-dashboard" />
			<?php wp_nonce_field('outerwhisper_admin_nonce', 'nonce'); ?>
			<div class="outerwhisper-dashboard-select-wrap">
				<i class="fa-regular fa-calendar outerwhisper-dashboard-select-icon" aria-hidden="true"></i>
				<label for="outerwhisper-dashboard-filter-period" style="display:none;"><?php esc_html_e('admin.page.dashboard.filter.period', 'outerwhisper'); ?></label>
				<select id="outerwhisper-dashboard-filter-period" name="period" class="outerwhisper-dashboard-select" aria-label="<?php esc_attr_e('admin.page.dashboard.filter.select_period', 'outerwhisper'); ?>">
					<option value="7d" <?php selected($outerwhisperCurrentPeriod, '7d'); ?>><?php esc_html_e('admin.page.dashboard.filter.period_7d', 'outerwhisper'); ?></option>
					<option value="30d" <?php selected($outerwhisperCurrentPeriod, '30d'); ?>><?php esc_html_e('admin.page.dashboard.filter.period_30d', 'outerwhisper'); ?></option>
					<option value="90d" <?php selected($outerwhisperCurrentPeriod, '90d'); ?>><?php esc_html_e('admin.page.dashboard.filter.period_90d', 'outerwhisper'); ?></option>
					<option value="all" <?php selected($outerwhisperCurrentPeriod, 'all'); ?>><?php esc_html_e('admin.page.dashboard.filter.period_all', 'outerwhisper'); ?></option>
				</select>
				<i class="fa-solid fa-chevron-down outerwhisper-dashboard-select-chevron" aria-hidden="true"></i>
			</div>
			<div class="outerwhisper-dashboard-select-wrap">
				<i class="fa-solid fa-globe outerwhisper-dashboard-select-icon" aria-hidden="true"></i>
				<label for="outerwhisper-dashboard-filter-form-id" style="display:none;"><?php esc_html_e('admin.page.dashboard.filter.form', 'outerwhisper'); ?></label>
				<select id="outerwhisper-dashboard-filter-form-id" name="form_id" class="outerwhisper-dashboard-select" aria-label="<?php esc_attr_e('admin.page.dashboard.filter.select_form', 'outerwhisper'); ?>">
					<option value="all" <?php selected($outerwhisperCurrentForm, 'all'); ?>><?php esc_html_e('admin.page.dashboard.filter.all_forms', 'outerwhisper'); ?></option>
					<?php
					$outerwhisperFormDb = new \OuterWhisper\Database\Form();
					$outerwhisperForms  = $outerwhisperFormDb->get_forms(['limit' => 999, 'orderby' => 'outerwhisper_fd_name', 'order' => 'ASC']);
					foreach ($outerwhisperForms as $outerwhisperFormEntry) :
						?>
						<option value="<?php echo (int) $outerwhisperFormEntry->getId(); ?>" <?php selected($outerwhisperCurrentForm, (string) $outerwhisperFormEntry->getId()); ?>>
							<?php echo esc_html($outerwhisperFormEntry->getName()); ?>
						</option>
					<?php endforeach; ?>
				</select>
				<i class="fa-solid fa-chevron-down outerwhisper-dashboard-select-chevron" aria-hidden="true"></i>
			</div>
		</form>
	</header>

	<div class="outerwhisper-dashboard-kpi-grid" role="region" aria-label="<?php esc_attr_e('admin.page.dashboard.kpi.aria_label', 'outerwhisper'); ?>">
		<article class="outerwhisper-dashboard-card outerwhisper-dashboard-kpi-card">
			<div class="outerwhisper-dashboard-kpi-icon-circle outerwhisper-dashboard-kpi-icon-blue" aria-hidden="true">
				<i class="fa-regular fa-comment"></i>
			</div>
			<div class="outerwhisper-dashboard-kpi-body">
				<span class="outerwhisper-dashboard-kpi-label"><?php esc_html_e('admin.page.dashboard.kpi.total_feedbacks', 'outerwhisper'); ?></span>
				<div class="outerwhisper-dashboard-kpi-value-row">
					<span id="outerwhisper-dashboard-kpi-total" class="outerwhisper-dashboard-kpi-value"><?php echo esc_html(number_format_i18n($outerwhisperKpi_total)); ?></span>
					<?php if ($outerwhisperKpi_has_previous && null !== $outerwhisperKpi_total_change_pct) : ?>
						<span id="outerwhisper-dashboard-kpi-total-trend" class="outerwhisper-dashboard-kpi-trend <?php echo $outerwhisperKpi_total_change_pct < 0 ? 'outerwhisper-dashboard-trend-down' : ($outerwhisperKpi_total_change_pct === 0 ? 'outerwhisper-dashboard-trend-flat' : 'outerwhisper-dashboard-trend-up'); ?>">
							<i class="fa-solid <?php echo $outerwhisperKpi_total_change_pct > 0 ? 'fa-arrow-up' : ($outerwhisperKpi_total_change_pct < 0 ? 'fa-arrow-down' : 'fa-minus'); ?>" aria-hidden="true"></i>
							<?php echo esc_html(($outerwhisperKpi_total_change_pct > 0 ? '+ ' : ($outerwhisperKpi_total_change_pct < 0 ? '- ' : '')) . abs($outerwhisperKpi_total_change_pct) . ' %'); ?>
						</span>
					<?php endif; ?>
				</div>
				<span id="outerwhisper-dashboard-kpi-total-prev" class="outerwhisper-dashboard-kpi-subtext">
					<?php if ($outerwhisperKpi_has_previous) : ?>
						<?php printf(esc_html__('admin.page.dashboard.kpi.previous_period', 'outerwhisper'), esc_html(number_format_i18n($outerwhisperKpi_prev_total))); ?>
					<?php else : ?>
						<?php esc_html_e('admin.page.dashboard.kpi.all_time', 'outerwhisper'); ?>
					<?php endif; ?>
				</span>
			</div>
		</article>

		<article class="outerwhisper-dashboard-card outerwhisper-dashboard-kpi-card">
			<div class="outerwhisper-dashboard-kpi-icon-circle outerwhisper-dashboard-kpi-icon-blue" aria-hidden="true">
				<i class="fa-regular fa-star"></i>
			</div>
			<div class="outerwhisper-dashboard-kpi-body">
				<span class="outerwhisper-dashboard-kpi-label"><?php esc_html_e('admin.page.dashboard.kpi.average_score', 'outerwhisper'); ?></span>
				<div class="outerwhisper-dashboard-kpi-value-row">
					<span class="outerwhisper-dashboard-kpi-value">
						<?php if (null !== $outerwhisperKpi_avg_score) : ?>
							<span id="outerwhisper-dashboard-kpi-score"><?php echo esc_html(number_format_i18n($outerwhisperKpi_avg_score, 1)); ?></span> <span class="outerwhisper-dashboard-kpi-unit">/ 100</span>
						<?php else : ?>
							<span id="outerwhisper-dashboard-kpi-score">–</span>
						<?php endif; ?>
					</span>
					<?php if ($outerwhisperKpi_has_previous && null !== $outerwhisperKpi_avg_score_diff) : ?>
						<span id="outerwhisper-dashboard-kpi-score-trend" class="outerwhisper-dashboard-kpi-trend <?php echo $outerwhisperKpi_avg_score_diff < 0 ? 'outerwhisper-dashboard-trend-down' : ($outerwhisperKpi_avg_score_diff == 0 ? 'outerwhisper-dashboard-trend-flat' : 'outerwhisper-dashboard-trend-up'); ?>">
							<i class="fa-solid <?php echo $outerwhisperKpi_avg_score_diff > 0 ? 'fa-arrow-up' : ($outerwhisperKpi_avg_score_diff < 0 ? 'fa-arrow-down' : 'fa-minus'); ?>" aria-hidden="true"></i>
							<?php echo esc_html(($outerwhisperKpi_avg_score_diff > 0 ? '+ ' : ($outerwhisperKpi_avg_score_diff < 0 ? '- ' : '')) . number_format_i18n(abs($outerwhisperKpi_avg_score_diff), 1)); ?>
						</span>
					<?php endif; ?>
				</div>
				<span id="outerwhisper-dashboard-kpi-score-prev" class="outerwhisper-dashboard-kpi-subtext">
					<?php if ($outerwhisperKpi_has_previous && null !== $outerwhisperKpi_prev_avg_score) : ?>
						<?php printf(esc_html__('admin.page.dashboard.kpi.previous_period', 'outerwhisper'), esc_html(number_format_i18n($outerwhisperKpi_prev_avg_score, 1))); ?>
					<?php elseif ($outerwhisperKpi_has_previous) : ?>
						<?php printf(esc_html__('admin.page.dashboard.kpi.previous_period', 'outerwhisper'), '–'); ?>
					<?php else : ?>
						<?php esc_html_e('admin.page.dashboard.kpi.all_time', 'outerwhisper'); ?>
					<?php endif; ?>
				</span>
			</div>
		</article>

		<article class="outerwhisper-dashboard-card outerwhisper-dashboard-kpi-card">
			<div class="outerwhisper-dashboard-kpi-icon-circle outerwhisper-dashboard-kpi-icon-green" aria-hidden="true">
				<i class="fa-regular fa-thumbs-up"></i>
			</div>
			<div class="outerwhisper-dashboard-kpi-body">
				<span class="outerwhisper-dashboard-kpi-label"><?php esc_html_e('admin.page.dashboard.kpi.positive_rate', 'outerwhisper'); ?></span>
				<div class="outerwhisper-dashboard-kpi-value-row">
					<span id="outerwhisper-dashboard-kpi-positive" class="outerwhisper-dashboard-kpi-value"><?php echo esc_html((string) $outerwhisperKpi_positive_pct); ?> %</span>
					<?php if ($outerwhisperKpi_has_previous && null !== $outerwhisperKpi_positive_pct_diff) : ?>
						<span id="outerwhisper-dashboard-kpi-positive-trend" class="outerwhisper-dashboard-kpi-trend <?php echo $outerwhisperKpi_positive_pct_diff < 0 ? 'outerwhisper-dashboard-trend-down' : ($outerwhisperKpi_positive_pct_diff === 0 ? 'outerwhisper-dashboard-trend-flat' : 'outerwhisper-dashboard-trend-up'); ?>">
							<i class="fa-solid <?php echo $outerwhisperKpi_positive_pct_diff > 0 ? 'fa-arrow-up' : ($outerwhisperKpi_positive_pct_diff < 0 ? 'fa-arrow-down' : 'fa-minus'); ?>" aria-hidden="true"></i>
							<?php echo esc_html(($outerwhisperKpi_positive_pct_diff > 0 ? '+ ' : ($outerwhisperKpi_positive_pct_diff < 0 ? '- ' : '')) . abs($outerwhisperKpi_positive_pct_diff) . ' %'); ?>
						</span>
					<?php endif; ?>
				</div>
				<span id="outerwhisper-dashboard-kpi-positive-sub" class="outerwhisper-dashboard-kpi-subtext"><?php printf(esc_html__('admin.page.dashboard.kpi.based_on_ratings', 'outerwhisper'), esc_html(number_format_i18n($outerwhisperKpi_rated))); ?></span>
			</div>
		</article>

		<article class="outerwhisper-dashboard-card outerwhisper-dashboard-kpi-card">
			<div class="outerwhisper-dashboard-kpi-icon-circle outerwhisper-dashboard-kpi-icon-blue" aria-hidden="true">
				<i class="fa-regular fa-file-lines"></i>
			</div>
			<div class="outerwhisper-dashboard-kpi-body">
				<span class="outerwhisper-dashboard-kpi-label"><?php esc_html_e('admin.page.dashboard.kpi.pages_with_feedback', 'outerwhisper'); ?></span>
				<div class="outerwhisper-dashboard-kpi-value-row">
					<span id="outerwhisper-dashboard-kpi-pages" class="outerwhisper-dashboard-kpi-value"><?php echo esc_html(number_format_i18n($outerwhisperKpi_pages)); ?></span>
					<?php if ($outerwhisperKpi_has_previous && null !== $outerwhisperKpi_pages_change_pct) : ?>
						<span id="outerwhisper-dashboard-kpi-pages-trend" class="outerwhisper-dashboard-kpi-trend <?php echo $outerwhisperKpi_pages_change_pct < 0 ? 'outerwhisper-dashboard-trend-down' : ($outerwhisperKpi_pages_change_pct === 0 ? 'outerwhisper-dashboard-trend-flat' : 'outerwhisper-dashboard-trend-up'); ?>">
							<i class="fa-solid <?php echo $outerwhisperKpi_pages_change_pct > 0 ? 'fa-arrow-up' : ($outerwhisperKpi_pages_change_pct < 0 ? 'fa-arrow-down' : 'fa-minus'); ?>" aria-hidden="true"></i>
							<?php echo esc_html(($outerwhisperKpi_pages_change_pct > 0 ? '+ ' : ($outerwhisperKpi_pages_change_pct < 0 ? '- ' : '')) . abs($outerwhisperKpi_pages_change_pct) . ' %'); ?>
						</span>
					<?php endif; ?>
				</div>
				<span id="outerwhisper-dashboard-kpi-pages-prev" class="outerwhisper-dashboard-kpi-subtext">
					<?php if ($outerwhisperKpi_has_previous) : ?>
						<?php printf(esc_html__('admin.page.dashboard.kpi.previous_period', 'outerwhisper'), esc_html(number_format_i18n($outerwhisperKpi_prev_pages))); ?>
					<?php else : ?>
						<?php esc_html_e('admin.page.dashboard.kpi.all_time', 'outerwhisper'); ?>
					<?php endif; ?>
				</span>
			</div>
		</article>
	</div>

	<div class="outerwhisper-dashboard-charts-row">
		<article class="outerwhisper-dashboard-card">
			<div class="outerwhisper-dashboard-card-header">
				<h2 class="outerwhisper-dashboard-card-title"><?php esc_html_e('admin.page.dashboard.trend.title', 'outerwhisper'); ?></h2>
				<div class="outerwhisper-dashboard-legend-inline">
                <span class="outerwhisper-dashboard-legend-item">
                  <span class="outerwhisper-dashboard-dot outerwhisper-dashboard-dot-blue" aria-hidden="true"></span>
                  <span><?php esc_html_e('admin.page.dashboard.trend.feedbacks', 'outerwhisper'); ?></span>
                </span>
					<span class="outerwhisper-dashboard-legend-item">
                  <span class="outerwhisper-dashboard-dot outerwhisper-dashboard-dot-green" aria-hidden="true"></span>
                  <span><?php esc_html_e('admin.page.dashboard.trend.average_score', 'outerwhisper'); ?></span>
                </span>
				</div>
			</div>
			<div class="outerwhisper-dashboard-trend-canvas-wrap">
				<canvas id="outerwhisper-dashboard-trend-chart" aria-label="<?php esc_attr_e('admin.page.dashboard.trend.title', 'outerwhisper'); ?>"></canvas>
			</div>
		</article>

		<article class="outerwhisper-dashboard-card">
			<div class="outerwhisper-dashboard-card-header">
				<h2 class="outerwhisper-dashboard-card-title"><?php esc_html_e('admin.page.dashboard.distribution.title', 'outerwhisper'); ?></h2>
				<span id="outerwhisper-dashboard-dist-total" class="outerwhisper-dashboard-card-meta"><?php echo esc_html($outerwhisperDistStars['total_formatted'] ?? '0 Antworten'); ?></span>
			</div>

			<div class="outerwhisper-dashboard-tablist" role="tablist" aria-label="<?php esc_attr_e('admin.page.dashboard.distribution.rating_types', 'outerwhisper'); ?>">
				<button type="button" id="outerwhisper-dashboard-tab-btn-stars" class="outerwhisper-dashboard-tab-btn is-active" role="tab" aria-selected="true" aria-controls="outerwhisper-dashboard-panel-stars" data-tab-target="stars" data-total-label="<?php echo esc_attr($outerwhisperDistStars['total_formatted'] ?? '0 Antworten'); ?>"><?php esc_html_e('admin.page.dashboard.distribution.stars', 'outerwhisper'); ?></button>
			</div>

			<div id="outerwhisper-dashboard-panel-stars" class="outerwhisper-dashboard-tabpanel" role="tabpanel" aria-labelledby="outerwhisper-dashboard-tab-btn-stars">
				<div class="outerwhisper-dashboard-vbars">
					<?php if (!empty($outerwhisperDistStars['items'])) : ?>
						<?php foreach ($outerwhisperDistStars['items'] as $outerwhisperStarItem) : ?>
							<div class="outerwhisper-dashboard-vbar-col">
								<div class="outerwhisper-dashboard-vbar-stage">
									<span class="outerwhisper-dashboard-vbar-pct"><?php echo esc_html($outerwhisperStarItem['percentage_formatted'] ?? '0 %'); ?></span>
									<span class="outerwhisper-dashboard-vbar-cnt">(<?php echo esc_html(number_format_i18n((int) ($outerwhisperStarItem['count'] ?? 0))); ?>)</span>
									<div class="outerwhisper-dashboard-vbar-fill <?php echo esc_attr($outerwhisperStarItem['fill_class'] ?? ''); ?>" style="height: <?php echo esc_attr((int) ($outerwhisperStarItem['height_px'] ?? 4)); ?>px;"></div>
								</div>
								<span class="outerwhisper-dashboard-vbar-label"><?php echo esc_html($outerwhisperStarItem['label'] ?? ''); ?></span>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>

		</article>
	</div>

	<div class="outerwhisper-dashboard-triple-row">
		<article class="outerwhisper-dashboard-card">
			<div class="outerwhisper-dashboard-card-header">
				<h2 class="outerwhisper-dashboard-card-title"><?php esc_html_e('admin.page.dashboard.display_type.title', 'outerwhisper'); ?></h2>
			</div>
			<div class="outerwhisper-dashboard-donut-layout">
				<div class="outerwhisper-dashboard-donut-wrap">
					<canvas id="outerwhisper-dashboard-display-chart" aria-label="<?php esc_attr_e('admin.page.dashboard.display_type.title', 'outerwhisper'); ?>"></canvas>
					<div class="outerwhisper-dashboard-donut-center">
						<span id="outerwhisper-dashboard-donut-total" class="outerwhisper-dashboard-donut-total"><?php echo esc_html($outerwhisperDisplayTotal); ?></span>
						<span class="outerwhisper-dashboard-donut-sub"><?php esc_html_e('admin.page.dashboard.display_type.feedbacks', 'outerwhisper'); ?></span>
					</div>
				</div>
				<div class="outerwhisper-dashboard-donut-legend-cols">
					<ul class="outerwhisper-dashboard-donut-legend">
						<?php foreach ($outerwhisperDisplayItems as $outerwhisperDisplayItem) :
							$outerwhisperDisplayKey = (string) ($outerwhisperDisplayItem['key'] ?? '');
							$outerwhisperDisplayUrl = StatisticService::get_admin_page_url([
							   'period'       => $outerwhisperCurrentPeriod,
                               'form_id'      => $outerwhisperCurrentForm,
                               'display_type' => $outerwhisperDisplayKey,
						   ]);
							?>
							<li class="outerwhisper-dashboard-donut-legend-item">
								<a href="<?php echo esc_url($outerwhisperDisplayUrl); ?>" class="outerwhisper-dashboard-donut-legend-name outerwhisper-dashboard-table-link">
									<span class="outerwhisper-dashboard-dot <?php echo esc_attr($outerwhisperDisplayItem['dot_class'] ?? ''); ?>" aria-hidden="true"></span>
									<span><?php echo esc_html($outerwhisperDisplayItem['label'] ?? ''); ?></span>
								</a>
								<span class="outerwhisper-dashboard-donut-legend-val"><?php echo esc_html($outerwhisperDisplayItem['percentage_formatted'] ?? '0 %'); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</article>

		<article class="outerwhisper-dashboard-card">
			<div class="outerwhisper-dashboard-card-header">
				<h2 class="outerwhisper-dashboard-card-title"><?php esc_html_e('admin.page.dashboard.top_pages.title', 'outerwhisper'); ?></h2>
			</div>
			<div class="outerwhisper-dashboard-table-wrap">
				<table class="outerwhisper-dashboard-table">
					<thead>
						<tr>
							<th scope="col"><?php esc_html_e('admin.page.dashboard.top_pages.page', 'outerwhisper'); ?></th>
							<th scope="col"><?php esc_html_e('admin.page.dashboard.top_pages.score', 'outerwhisper'); ?></th>
							<th scope="col"><?php esc_html_e('admin.page.dashboard.top_pages.feedbacks', 'outerwhisper'); ?></th>
							<th scope="col"><?php esc_html_e('admin.page.dashboard.top_pages.trend', 'outerwhisper'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($outerwhisperTopPages)) : ?>
							<?php foreach ($outerwhisperTopPages as $outerwhisperTopPage) :
								$outerwhisperPageUrl         = (string) ($outerwhisperTopPage['page_url'] ?? '');
								$outerwhisperDisplayPath     = (string) ($outerwhisperTopPage['display_path'] ?? '');
								$outerwhisperPageScoreFormat = $outerwhisperTopPage['score_formatted'] ?? '–';
								$outerwhisperProgressPercent = $outerwhisperTopPage['progress_percent'] ?? 0;
								$outerwhisperProgressClass   = $outerwhisperTopPage['progress_class'] ?? '';
								$outerwhisperFeedbackCount   = (int) ($outerwhisperTopPage['feedback_count'] ?? 0);
								$outerwhisperTrend           = $outerwhisperTopPage['trend'] ?? 'none';
								$outerwhisperTrendText       = $outerwhisperTopPage['trend_text'] ?? '–';
								$outerwhisperPageFeedbackUrl = StatisticService::get_admin_page_url([
																										'period'   => $outerwhisperCurrentPeriod,
									                                                                    'form_id'  => $outerwhisperCurrentForm,
									                                                                    'page_url' => $outerwhisperPageUrl,
																									]);
								?>
								<tr>
									<td><a href="<?php echo esc_url($outerwhisperPageFeedbackUrl); ?>" class="outerwhisper-dashboard-table-link" title="<?php echo esc_attr($outerwhisperPageUrl); ?>"><?php echo esc_html($outerwhisperDisplayPath); ?></a></td>
									<td>
										<div class="outerwhisper-dashboard-score-cell">
											<span class="outerwhisper-dashboard-score-num"><?php echo esc_html($outerwhisperPageScoreFormat); ?></span>
											<div class="outerwhisper-dashboard-progress-track" aria-hidden="true">
												<div class="outerwhisper-dashboard-progress-fill <?php echo esc_attr($outerwhisperProgressClass); ?>" style="width: <?php echo esc_attr($outerwhisperProgressPercent); ?>%;"></div>
											</div>
										</div>
									</td>
									<td><?php echo esc_html(number_format_i18n($outerwhisperFeedbackCount)); ?></td>
									<td>
										<?php if ($outerwhisperTrend === 'up') : ?>
											<span class="outerwhisper-dashboard-trend-up"><i class="fa-solid fa-arrow-up" aria-hidden="true"></i> <?php echo esc_html($outerwhisperTrendText); ?></span>
										<?php elseif ($outerwhisperTrend === 'down') : ?>
											<span class="outerwhisper-dashboard-trend-down"><i class="fa-solid fa-arrow-down" aria-hidden="true"></i> <?php echo esc_html($outerwhisperTrendText); ?></span>
										<?php elseif ($outerwhisperTrend === 'flat') : ?>
											<span class="outerwhisper-dashboard-trend-flat"><i class="fa-solid fa-arrow-right" aria-hidden="true"></i> 0</span>
										<?php else : ?>
											<span class="outerwhisper-dashboard-trend-flat">–</span>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else : ?>
							<tr>
								<td colspan="4" class="outerwhisper-dashboard-table-empty">
									<?php esc_html_e('admin.page.dashboard.top_pages.no_data', 'outerwhisper'); ?>
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
			<footer class="outerwhisper-dashboard-card-footer">
				<a href="<?php echo esc_url(
					StatisticService::get_admin_page_url(['period' => $outerwhisperCurrentPeriod, 'form_id' => $outerwhisperCurrentForm])); ?>" id="outerwhisper-dashboard-link-all-pages" class="outerwhisper-dashboard-more-link">
					<span><?php esc_html_e('admin.page.dashboard.top_pages.view_all', 'outerwhisper'); ?></span>
					<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
				</a>
			</footer>
		</article>

		<article class="outerwhisper-dashboard-card">
			<div class="outerwhisper-dashboard-card-header">
				<h2 class="outerwhisper-dashboard-card-title"><?php esc_html_e('admin.page.dashboard.top_forms.title', 'outerwhisper'); ?></h2>
			</div>
			<div class="outerwhisper-dashboard-table-wrap">
				<table class="outerwhisper-dashboard-table">
					<thead>
						<tr>
							<th scope="col"><?php esc_html_e('admin.page.dashboard.top_forms.form', 'outerwhisper'); ?></th>
							<th scope="col"><?php esc_html_e('admin.page.dashboard.top_forms.feedbacks', 'outerwhisper'); ?></th>
							<th scope="col"><?php esc_html_e('admin.page.dashboard.top_forms.average_score', 'outerwhisper'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($outerwhisperTopForms)) : ?>
							<?php foreach ($outerwhisperTopForms as $outerwhisperTopForm) :
								$outerwhisperFormId          = (int) ($outerwhisperTopForm['form_id'] ?? 0);
								$outerwhisperFormName        = (string) ($outerwhisperTopForm['form_name'] ?? '');
								$outerwhisperFeedbackCount   = (int) ($outerwhisperTopForm['feedback_count'] ?? 0);
								$outerwhisperScoreFormatted  = $outerwhisperTopForm['score_formatted'] ?? '–';
								$outerwhisperProgressPercent = $outerwhisperTopForm['progress_percent'] ?? 0;
								$outerwhisperProgressClass   = $outerwhisperTopForm['progress_class'] ?? '';
								$outerwhisperFormFeedbackUrl = StatisticService::get_admin_page_url([
									'period'  => $outerwhisperCurrentPeriod,
                                    'form_id' => $outerwhisperFormId,
								]);
								if ($outerwhisperFormName === '') {
									$outerwhisperFormName = sprintf(esc_html__('admin.page.dashboard.top_forms.fallback_name', 'outerwhisper'), $outerwhisperFormId);
								}
								?>
								<tr>
									<td><a href="<?php echo esc_url($outerwhisperFormFeedbackUrl); ?>" class="outerwhisper-dashboard-table-link"><?php echo esc_html($outerwhisperFormName); ?></a></td>
									<td><?php echo esc_html(number_format_i18n($outerwhisperFeedbackCount)); ?></td>
									<td>
										<div class="outerwhisper-dashboard-progress-track"  title="<?php echo esc_attr(sprintf(esc_html__('admin.page.dashboard.top_forms.score_aria', 'outerwhisper'), $outerwhisperScoreFormatted)); ?>" aria-label="<?php echo esc_attr(sprintf(esc_html__('admin.page.dashboard.top_forms.score_aria', 'outerwhisper'), $outerwhisperScoreFormatted)); ?>">
											<div class="outerwhisper-dashboard-progress-fill <?php echo esc_attr($outerwhisperProgressClass); ?>" style="width: <?php echo esc_attr($outerwhisperProgressPercent); ?>%;"></div>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else : ?>
							<tr>
								<td colspan="3" class="outerwhisper-dashboard-table-empty">
									<?php esc_html_e('admin.page.dashboard.top_forms.no_data', 'outerwhisper'); ?>
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
			<footer class="outerwhisper-dashboard-card-footer">
				<a href="<?php echo esc_url(
					StatisticService::get_admin_page_url(['period' => $outerwhisperCurrentPeriod, 'form_id' => $outerwhisperCurrentForm])); ?>" id="outerwhisper-dashboard-link-all-forms" class="outerwhisper-dashboard-more-link">
					<span><?php esc_html_e('admin.page.dashboard.top_forms.view_all', 'outerwhisper'); ?></span>
					<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
				</a>
			</footer>
		</article>
	</div>

	<article class="outerwhisper-dashboard-card">
		<div class="outerwhisper-dashboard-card-header">
			<h2 class="outerwhisper-dashboard-card-title"><?php esc_html_e('admin.page.dashboard.recent.title', 'outerwhisper'); ?></h2>
		</div>
		<div class="outerwhisper-dashboard-table-wrap">
			<table class="outerwhisper-dashboard-table outerwhisper-dashboard-recent-table">
				<thead>
					<tr>
						<th scope="col"><?php esc_html_e('admin.page.dashboard.recent.date', 'outerwhisper'); ?></th>
						<th scope="col"><?php esc_html_e('admin.page.dashboard.recent.page', 'outerwhisper'); ?></th>
						<th scope="col"><?php esc_html_e('admin.page.dashboard.recent.form', 'outerwhisper'); ?></th>
						<th scope="col"><?php esc_html_e('admin.page.dashboard.recent.rating', 'outerwhisper'); ?></th>
						<th scope="col"><?php esc_html_e('admin.page.dashboard.recent.free_text', 'outerwhisper'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($outerwhisperRecentFeedbacks)) : ?>
						<?php foreach ($outerwhisperRecentFeedbacks as $outerwhisperFeedback) : ?>
							<tr class="outerwhisper-dashboard-recent-row">
								<td><?php echo esc_html($outerwhisperFeedback['date_formatted']); ?></td>
								<td>
									<?php if (!empty($outerwhisperFeedback['page_url'])) : ?>
										<a href="<?php echo esc_url(
											StatisticService::get_admin_page_url(['period' => $outerwhisperCurrentPeriod, 'form_id' => $outerwhisperCurrentForm, 'page_url' => $outerwhisperFeedback['page_url']])); ?>" class="outerwhisper-dashboard-table-link" title="<?php echo esc_attr($outerwhisperFeedback['page_url']); ?>">
											<?php echo esc_html($outerwhisperFeedback['display_path']); ?>
										</a>
									<?php else : ?>
										<span>-</span>
									<?php endif; ?>
								</td>
								<td>
									<?php if (!empty($outerwhisperFeedback['form_id'])) : ?>
										<a href="<?php echo esc_url(
											StatisticService::get_admin_page_url(['period' => $outerwhisperCurrentPeriod, 'form_id' => (int) $outerwhisperFeedback['form_id']])); ?>" class="outerwhisper-dashboard-table-link">
											<?php echo esc_html($outerwhisperFeedback['form_name']); ?>
										</a>
									<?php else : ?>
										<?php echo esc_html($outerwhisperFeedback['form_name']); ?>
									<?php endif; ?>
								</td>
								<td class="outerwhisper-dashboard-recent-feedback-rating outerwhisper-feedback-plugin">
									<?php echo $outerwhisperFeedback['rating_html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</td>
								<td class="outerwhisper-dashboard-recent-feedback-free-text">
									<?php echo $outerwhisperFeedback['free_text_html']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<tr>
							<td colspan="5" class="outerwhisper-dashboard-table-empty">
								<?php esc_html_e('admin.page.dashboard.recent.no_data', 'outerwhisper'); ?>
							</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
		<footer class="outerwhisper-dashboard-card-footer">
			<a href="<?php echo esc_url(
				StatisticService::get_admin_page_url(['period' => $outerwhisperCurrentPeriod, 'form_id' => $outerwhisperCurrentForm])); ?>" id="outerwhisper-dashboard-link-all-feedbacks" class="outerwhisper-dashboard-more-link">
				<span><?php esc_html_e('admin.page.dashboard.recent.view_all', 'outerwhisper'); ?></span>
				<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
			</a>
		</footer>
	</article>

</section>
