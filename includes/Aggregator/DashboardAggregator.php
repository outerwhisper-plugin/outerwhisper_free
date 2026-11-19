<?php

namespace OuterWhisper\Aggregator;

use OuterWhisper\Database\Form as FormDB;
use OuterWhisper\Database\FormFeedback;
use OuterWhisper\Database\FormFeedbackAnswer;
use OuterWhisper\Helper\ConfigHelper;
use OuterWhisper\Helper\DashboardStatsService;
use OuterWhisper\Helper\FormFeedbackHelper;
use OuterWhisper\Helper\StatisticService;

defined('ABSPATH') || exit;

class DashboardAggregator {

	public const CACHE_GROUP = 'outerwhisper_dashboard_aggregator';

	protected StatisticService $statistic_service;
	protected FormFeedback $form_feedback_db;
	protected FormDB $form_db;
	protected FormFeedbackHelper $form_feedback_helper;
	protected FormFeedbackAnswer $form_feedback_answer_db;
	protected DashboardStatsService $dashboard_stats_service;
	protected ConfigHelper $configHelper;

	public function __construct()
	{
		$this->statistic_service = new StatisticService();
		$this->form_feedback_db = new FormFeedback();
		$this->form_db = new FormDB();
		$this->form_feedback_helper = new FormFeedbackHelper();
		$this->form_feedback_answer_db = new FormFeedbackAnswer();
		$this->dashboard_stats_service = new DashboardStatsService();
		$this->configHelper = new ConfigHelper();
	}

	public static function clear_cache(): void {
		StatisticService::clear_cache_group(self::CACHE_GROUP);
	}

	public function get_all(array $filters = []): array {
		return [
			'kpis'                => $this->get_kpis($filters),
			'trend_chart_data'    => $this->get_trend_chart_data($filters),
			'top_forms'           => $this->get_top_forms($filters),
			'top_pages'           => $this->get_top_pages($filters),
			'display_type_stats'  => $this->get_display_type_stats($filters),
			'recent_feedbacks'    => $this->get_recent_feedbacks($filters),
			'rating_distribution' => $this->get_rating_distribution($filters),
		];
	}

	public function get_kpis(array $filters = []): array {
		return $this->dashboard_stats_service->get_kpis($filters);
	}

	public function get_trend_chart_data(array $filters = []): array {
		$cache_key = 'ow_dash_trend_chart_' . md5(wp_json_encode($filters));
		$cached = wp_cache_get($cache_key, self::CACHE_GROUP);
		if (false !== $cached && is_array($cached)) {
			return $cached;
		}

		$period = $filters['period'] ?? '30d';
		$dates  = $this->statistic_service->resolve_period_dates($period);

		$now   = new \DateTimeImmutable('now', wp_timezone());
		$today = $now->setTime(0, 0, 0);

		$group_by = 'day';
		$buckets  = [];

		if ($period === 'all') {
			$earliest = $this->form_feedback_db->get_earliest_created_date();

			if ($earliest) {
				$start_dt  = (new \DateTimeImmutable($earliest, wp_timezone()))->setTime(0, 0, 0);
				$diff_days = (int) $today->diff($start_dt)->format('%a');
				if ($diff_days > 90) {
					$group_by      = 'month';
					$current_month = $start_dt->modify('first day of this month');
					$end_month     = $today->modify('first day of this month');
					while ($current_month <= $end_month) {
						$key   = $current_month->format('Y-m-01');
						$label = wp_date('M Y', $current_month->getTimestamp(), wp_timezone());
						$buckets[$key] = [
							'label'     => $label,
							'feedbacks' => 0,
							'score_sum' => 0.0,
							'score_cnt' => 0,
						];
						$current_month = $current_month->modify('+1 month');
					}
				} else {
					$group_by    = 'day';
					$current_day = $start_dt;
					while ($current_day <= $today) {
						$key   = $current_day->format('Y-m-d');
						$label = wp_date('j. M', $current_day->getTimestamp(), wp_timezone());
						$buckets[$key] = [
							'label'     => $label,
							'feedbacks' => 0,
							'score_sum' => 0.0,
							'score_cnt' => 0,
						];
						$current_day = $current_day->modify('+1 day');
					}
				}
			} else {
				$group_by = 'day';
				for ($i = 29; $i >= 0; $i--) {
					$dt    = $today->modify("-{$i} days");
					$key   = $dt->format('Y-m-d');
					$label = wp_date('j. M', $dt->getTimestamp(), wp_timezone());
					$buckets[$key] = [
						'label'     => $label,
						'feedbacks' => 0,
						'score_sum' => 0.0,
						'score_cnt' => 0,
					];
				}
			}
		} else {
			$group_by    = 'day';
			$start_dt    = new \DateTimeImmutable($dates['current_start'], wp_timezone());
			$end_dt      = new \DateTimeImmutable($dates['current_end'], wp_timezone());
			$current_day = $start_dt->setTime(0, 0, 0);
			$end_day     = $end_dt->setTime(0, 0, 0);

			while ($current_day <= $end_day) {
				$key   = $current_day->format('Y-m-d');
				$label = wp_date('j. M', $current_day->getTimestamp(), wp_timezone());
				$buckets[$key] = [
					'label'     => $label,
					'feedbacks' => 0,
					'score_sum' => 0.0,
					'score_cnt' => 0,
				];
				$current_day = $current_day->modify('+1 day');
			}
		}

		$query_args = [
			'form_id'  => $filters['form_id'] ?? null,
			'group_by' => $group_by,
		];

		if ($period !== 'all') {
			$query_args['start_date'] = $dates['current_start'];
			$query_args['end_date']   = $dates['current_end'];
		}

		$raw_data = $this->form_feedback_db->get_trend_data($query_args);

		foreach ($raw_data as $row) {
			$b_date = (string) ($row['bucket_date'] ?? '');
			$count  = (int) ($row['feedback_count'] ?? 0);
			$score  = isset($row['avg_score']) && null !== $row['avg_score'] ? (float) $row['avg_score'] : null;

			if (isset($buckets[$b_date])) {
				$buckets[$b_date]['feedbacks'] = $count;
				if (null !== $score) {
					$buckets[$b_date]['score_sum'] = $score;
					$buckets[$b_date]['score_cnt'] = 1;
				}
			}
		}

		$labels    = [];
		$feedbacks = [];
		$scores    = [];

		foreach ($buckets as $bucket_data) {
			$labels[]    = $bucket_data['label'];
			$feedbacks[] = $bucket_data['feedbacks'];
			$avg_score   = $bucket_data['score_cnt'] > 0 ? (int) round($bucket_data['score_sum'] / $bucket_data['score_cnt']) : null;
			$scores[]    = $avg_score;
		}

		$result = [
			'labels'    => $labels,
			'feedbacks' => $feedbacks,
			'scores'    => $scores,
		];

		wp_cache_set($cache_key, $result, self::CACHE_GROUP, 300);

		return $result;
	}

	public function get_display_type_stats(array $filters = []): array {
		$cache_key = 'ow_dash_display_types_' . md5(wp_json_encode($filters));
		$cached = wp_cache_get($cache_key, self::CACHE_GROUP);
		if (false !== $cached && is_array($cached)) {
			return $cached;
		}

		$period = $filters['period'] ?? '30d';
		$dates  = $this->statistic_service->resolve_period_dates($period);

		$query_args = [
			'form_id' => $filters['form_id'] ?? null,
		];

		if ($period !== 'all') {
			$query_args['start_date'] = $dates['current_start'];
			$query_args['end_date']   = $dates['current_end'];
		}

		$raw_counts = $this->form_feedback_db->get_display_type_counts($query_args);

		$types = [
			'shortcode'       => [
				'key'        => 'shortcode',
				'label'      => esc_html__('admin.form_type.shortcode.name', 'outerwhisper'),
				'dot_class'  => 'outerwhisper-dashboard-dot-blue',
				'color'      => '#1d6fe8',
				'count'      => 0,
				'percentage' => 0,
			],
			'pre-content'     => [
				'key'        => 'pre-content',
				'label'      => esc_html__('admin.form_type.pre-content.name', 'outerwhisper'),
				'dot_class'  => 'outerwhisper-dashboard-dot-purple',
				'color'      => '#8b5cf6',
				'count'      => 0,
				'percentage' => 0,
			],
			'post-content'    => [
				'key'        => 'post-content',
				'label'      => esc_html__('admin.form_type.post-content.name', 'outerwhisper'),
				'dot_class'  => 'outerwhisper-dashboard-dot-sky',
				'color'      => '#0ea5e9',
				'count'      => 0,
				'percentage' => 0,
			],
			'modal'           => [
				'key'        => 'modal',
				'label'      => esc_html__('admin.form_type.modal.name', 'outerwhisper'),
				'dot_class'  => 'outerwhisper-dashboard-dot-pink',
				'color'      => '#ec4899',
				'count'      => 0,
				'percentage' => 0,
			],
			'slide-in'        => [
				'key'        => 'slide-in',
				'label'      => esc_html__('admin.form_type.slide-in.name', 'outerwhisper'),
				'dot_class'  => 'outerwhisper-dashboard-dot-emerald',
				'color'      => '#10b981',
				'count'      => 0,
				'percentage' => 0,
			],
			'feedback-button' => [
				'key'        => 'feedback-button',
				'label'      => esc_html__('admin.form_type.feedback-button.name', 'outerwhisper'),
				'dot_class'  => 'outerwhisper-dashboard-dot-amber',
				'color'      => '#f59e0b',
				'count'      => 0,
				'percentage' => 0,
			],
		];

		$total = 0;
		foreach ($raw_counts as $row) {
			$form_type = (string) ($row['form_type'] ?? '');
			$count     = (int) ($row['feedback_count'] ?? 0);
			$total    += $count;

			if (isset($types[$form_type])) {
				$types[$form_type]['count'] += $count;
			}
		}

		$chart_labels = [];
		$chart_data   = [];
		$chart_colors = [];

		foreach ($types as $type_key => $type_data) {
			$percentage = $total > 0 ? (int) round(($type_data['count'] / $total) * 100) : 0;
			$types[$type_key]['percentage']           = $percentage;
			$types[$type_key]['percentage_formatted'] = $percentage . ' %';
			$types[$type_key]['count_formatted']      = number_format_i18n($type_data['count']);

			$chart_labels[] = $type_data['label'];
			$chart_data[]   = $percentage;
			$chart_colors[] = $type_data['color'];
		}

		$result = [
			'total'           => $total,
			'total_formatted' => number_format_i18n($total),
			'items'           => array_values($types),
			'chart_labels'    => $chart_labels,
			'chart_data'      => $chart_data,
			'chart_colors'    => $chart_colors,
		];

		wp_cache_set($cache_key, $result, self::CACHE_GROUP, 300);

		return $result;
	}

	public function get_top_pages(array $filters = [], int $limit = 5): array {
		$cache_key = 'ow_dash_top_pages_' . md5(wp_json_encode($filters) . '_' . $limit);
		$cached = wp_cache_get($cache_key, self::CACHE_GROUP);
		if (false !== $cached && is_array($cached)) {
			return $cached;
		}

		$period = $filters['period'] ?? '30d';
		$dates  = $this->statistic_service->resolve_period_dates($period);

		$query_args = [
			'limit'        => $limit,
			'form_id'      => $filters['form_id'] ?? null,
			'has_previous' => $dates['has_previous'],
		];

		if ($period !== 'all') {
			$query_args['start_date']      = $dates['current_start'];
			$query_args['end_date']        = $dates['current_end'];
			$query_args['prev_start_date'] = $dates['previous_start'];
			$query_args['prev_end_date']   = $dates['previous_end'];
		}

		$raw_pages = $this->form_feedback_db->get_top_pages($query_args);

		$top_pages = [];
		foreach ($raw_pages as $row) {
			$avg_score = isset($row['avg_score']) && null !== $row['avg_score']
				? round((float) $row['avg_score'], 1)
				: null;
			$prev_avg_score = isset($row['prev_avg_score']) && null !== $row['prev_avg_score']
				? round((float) $row['prev_avg_score'], 1)
				: null;

			$score_diff = null;
			$trend      = 'none';
			$trend_text = '–';

			if ($dates['has_previous'] && null !== $avg_score && null !== $prev_avg_score) {
				$diff = round($avg_score - $prev_avg_score, 1);
				$score_diff = $diff;
				if ($diff > 0) {
					$trend      = 'up';
					$trend_text = '+' . $diff;
				} elseif ($diff < 0) {
					$trend      = 'down';
					$trend_text = (string) $diff;
				} else {
					$trend      = 'flat';
					$trend_text = '0';
				}
			}

			$page_url = (string) ($row['page_url'] ?? '');
			$parsed_path = wp_parse_url($page_url, PHP_URL_PATH);
			$display_path = !empty($parsed_path) ? $parsed_path : $page_url;

			$progress_percent = null !== $avg_score ? max(0, min(100, (int) round($avg_score))) : 0;

			$top_pages[] = [
				'page_url'         => $page_url,
				'display_path'     => $display_path,
				'feedback_count'   => (int) ($row['feedback_count'] ?? 0),
				'avg_score'        => $avg_score,
				'score_formatted'  => null !== $avg_score ? number_format_i18n($avg_score, 1) : '–',
				'score_int'        => null !== $avg_score ? (int) round($avg_score) : 0,
				'progress_percent' => $progress_percent,
				'progress_class'   => $this->get_progress_color_class($avg_score),
				'prev_avg_score'   => $prev_avg_score,
				'score_diff'       => $score_diff,
				'trend'            => $trend,
				'trend_text'       => $trend_text,
			];
		}

		wp_cache_set($cache_key, $top_pages, self::CACHE_GROUP, 300);

		return $top_pages;
	}

	public function get_recent_feedbacks(array $filters = [], int $limit = 5): array {
		$cache_key = 'ow_dash_recent_feedbacks_' . md5(wp_json_encode($filters) . '_' . $limit);
		$cached = wp_cache_get($cache_key, self::CACHE_GROUP);
		if (false !== $cached && is_array($cached)) {
			return $cached;
		}

		$formFieldData = $this->configHelper->get_form_fields_data();

		$period = $filters['period'] ?? '30d';
		$dates  = $this->statistic_service->resolve_period_dates($period);

		$query_args = [
			'limit'   => $limit,
			'orderby' => 'outerwhisper_ff_created',
			'order'   => 'DESC',
		];

		if (!empty($filters['form_id']) && 'all' !== $filters['form_id']) {
			$query_args['form_id'] = $filters['form_id'];
		}

		if ($period !== 'all') {
			$query_args['start_date'] = $dates['current_start'];
			$query_args['end_date']   = $dates['current_end'];
		}

		$feedback_entities = $this->form_feedback_db->get_feedbacks($query_args);

		$rating_field_types = $formFieldData['rating'];
		$form_names_cache   = [];
		$recent_feedbacks   = [];

		foreach ($feedback_entities as $feedback) {
			$feedback_data           = $feedback->getDecodedFeedbackData();
			$first_answer            = (string) ($feedback_data['first_answer'] ?? '');
			$first_answer_field_type = (string) ($feedback_data['first_answer_field_type'] ?? '');
			$first_rating_answer     = (string) ($feedback_data['first_rating_answer'] ?? $first_answer);
			$first_rating_answer_field_type = (string) ($feedback_data['first_rating_answer_field_type'] ?? $first_answer_field_type);
			$first_free_text_answer  = (string) ($feedback_data['first_free_text_answer'] ?? '');
			$first_free_text_answer_field_type = (string) ($feedback_data['first_free_text_answer_field_type'] ?? '');

			if (empty($first_free_text_answer) && in_array($first_answer_field_type, $formFieldData['freeText'])) {
				$first_free_text_answer = $first_answer;
				$first_free_text_answer_field_type = $first_answer_field_type;
			}

			$form_id   = $feedback->getFormId();
			$form_name = !empty($feedback_data['title']) ? (string) $feedback_data['title'] : '';

			if (empty($form_name) && $form_id) {
				if (!isset($form_names_cache[$form_id])) {
					$form_obj = $this->form_db->get_form($form_id);
					$form_names_cache[$form_id] = $form_obj ? $form_obj->getName() : '';
				}
				$form_name = $form_names_cache[$form_id];
			}

			if (empty($form_name)) {
				$form_name = '-';
			}

			$rating_html = '-';
			$free_text_html = '-';
			if (!empty($first_rating_answer) && in_array($first_rating_answer_field_type, $rating_field_types, true)) {
				$rating_html = $this->form_feedback_helper->prepareFirstAnswerPreview(
					$first_rating_answer,
					$first_rating_answer_field_type,
					'table-row'
				);
			}

			if (!empty($first_free_text_answer) && $first_free_text_answer !== '-' && in_array($first_free_text_answer_field_type, $formFieldData['freeText'], true)) {
				$trimmed_text   = wp_trim_words($first_free_text_answer, 15, '...');
				$free_text_html = '<span class="outerwhisper-dashboard-preview-quote">„' . esc_html($trimmed_text) . '“</span>';
			}

			$created        = $feedback->getCreated();
			$date_formatted = '-';
			if (!empty($created)) {
				$timestamp      = strtotime($created);
				$date_formatted = wp_date('d.m.Y H:i', $timestamp, wp_timezone());
			}

			$page_url     = (string) ($feedback->getTrackingPageUrl() ?? '');
			$parsed_path  = wp_parse_url($page_url, PHP_URL_PATH);
			$display_path = !empty($parsed_path) ? $parsed_path : ($page_url ?: '-');

			$recent_feedbacks[] = [
				'id'                      => $feedback->getId(),
				'form_id'                 => $form_id,
				'form_name'               => $form_name,
				'page_url'                => $page_url,
				'display_path'            => $display_path,
				'date_formatted'          => $date_formatted,
				'rating_html'             => $rating_html,
				'free_text_html'          => $free_text_html,
			];
		}

		wp_cache_set($cache_key, $recent_feedbacks, self::CACHE_GROUP, 300);

		return $recent_feedbacks;
	}

	public function get_top_forms(array $filters = [], int $limit = 5): array {
		$cache_key = 'ow_dash_top_forms_' . md5(wp_json_encode($filters) . '_' . $limit);
		$cached = wp_cache_get($cache_key, self::CACHE_GROUP);
		if (false !== $cached && is_array($cached)) {
			return $cached;
		}

		$period = $filters['period'] ?? '30d';
		$dates  = $this->statistic_service->resolve_period_dates($period);

		$query_args = [
			'limit'   => $limit,
			'form_id' => $filters['form_id'] ?? null,
		];

		if ($period !== 'all') {
			$query_args['start_date'] = $dates['current_start'];
			$query_args['end_date']   = $dates['current_end'];
		}

		$raw_forms = $this->form_feedback_db->get_top_forms($query_args);

		$top_forms = [];
		foreach ($raw_forms as $row) {
			$avg_score = isset($row['avg_score']) && null !== $row['avg_score']
				? round((float) $row['avg_score'], 1)
				: null;

			$progress_percent = null !== $avg_score ? max(0, min(100, (int) round($avg_score))) : 0;

			$top_forms[] = [
				'form_id'          => (int) ($row['form_id'] ?? 0),
				'form_name'        => (string) ($row['form_name'] ?? ''),
				'feedback_count'   => (int) ($row['feedback_count'] ?? 0),
				'avg_score'        => $avg_score,
				'score_formatted'  => null !== $avg_score ? number_format_i18n($avg_score, 1) : '–',
				'progress_percent' => $progress_percent,
				'progress_class'   => $this->get_progress_color_class($avg_score),
			];
		}

		wp_cache_set($cache_key, $top_forms, self::CACHE_GROUP, 300);

		return $top_forms;
	}

	public function get_rating_distribution(array $filters = []): array {
		$cache_key = 'ow_dash_rating_dist_' . md5(wp_json_encode($filters));
		$cached = wp_cache_get($cache_key, self::CACHE_GROUP);
		if (false !== $cached && is_array($cached)) {
			return $cached;
		}

		$period = $filters['period'] ?? '30d';
		$dates  = $this->statistic_service->resolve_period_dates($period);

		$query_args = [
			'form_id' => $filters['form_id'] ?? null,
		];

		if ($period !== 'all') {
			$query_args['start_date'] = $dates['current_start'];
			$query_args['end_date']   = $dates['current_end'];
		}

		$raw_counts = $this->form_feedback_answer_db->get_rating_distribution_counts($query_args);

		$counts_by_type = [
			'rating'  => [],
		];

		foreach ($raw_counts as $row) {
			$field_type = (string) ($row['field_type'] ?? '');
			if (!isset($counts_by_type[$field_type])) {
				continue;
			}
			$val = (int) round((float) ($row['num_value'] ?? 0));
			$cnt = (int) ($row['count'] ?? 0);
			$counts_by_type[$field_type][$val] = ($counts_by_type[$field_type][$val] ?? 0) + $cnt;
		}

		// 1. Stars (Rating)
		$stars_total = 0;
		for ($v = 1; $v <= 5; $v++) {
			$stars_total += $counts_by_type['rating'][$v] ?? 0;
		}
		$stars_labels = [
			1 => esc_html__('admin.page.dashboard.distribution.stars.1', 'outerwhisper'),
			2 => esc_html__('admin.page.dashboard.distribution.stars.2', 'outerwhisper'),
			3 => esc_html__('admin.page.dashboard.distribution.stars.3', 'outerwhisper'),
			4 => esc_html__('admin.page.dashboard.distribution.stars.4', 'outerwhisper'),
			5 => esc_html__('admin.page.dashboard.distribution.stars.5', 'outerwhisper'),
		];
		$stars_items = [];
		for ($v = 1; $v <= 5; $v++) {
			$count      = $counts_by_type['rating'][$v] ?? 0;
			$percentage = $stars_total > 0 ? (int) round(($count / $stars_total) * 100) : 0;
			$height_px  = max(4, min(105, (int) round(($percentage / 100) * 105)));

			$stars_items[] = [
				'value'                => $v,
				'label'                => $stars_labels[$v],
				'count'                => $count,
				'count_formatted'      => number_format_i18n($count),
				'percentage'           => $percentage,
				'percentage_formatted' => $percentage . ' %',
				'fill_class'           => 'outerwhisper-dashboard-vbar-fill-' . $v,
				'height_px'            => $height_px,
			];
		}
		$stars_data = [
			'total'           => $stars_total,
			'total_formatted' => esc_html(sprintf(_n('admin.page.dashboard.distribution.answer', 'admin.page.dashboard.distribution.answers', $stars_total, 'outerwhisper'), number_format_i18n($stars_total))),
			'items'           => $stars_items,
		];

		$result = [
			'stars' => $stars_data,
		];

		wp_cache_set($cache_key, $result, self::CACHE_GROUP, 300);

		return $result;
	}

	protected function get_progress_color_class(?float $score): string {
		if (null === $score) {
			return '';
		}

		if ($score >= 80) {
			return 'outerwhisper-dashboard-progress-green';
		}
		if ($score >= 70) {
			return 'outerwhisper-dashboard-progress-lime';
		}
		if ($score >= 60) {
			return 'outerwhisper-dashboard-progress-amber';
		}

		return 'outerwhisper-dashboard-progress-orange';
	}
}
