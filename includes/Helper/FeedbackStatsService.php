<?php

namespace OuterWhisper\Helper;

use wpdb;

defined('ABSPATH') || exit;

class FeedbackStatsService {

	public const CACHE_GROUP = 'outerwhisper_kpi';

	protected wpdb $wpdb;
	protected string $table_name;

	public function __construct() {
		global $wpdb;
		$this->wpdb = $wpdb;
		$this->table_name = $this->wpdb->prefix . 'outerwhisper_form_feedback';
	}

	public function get_kpis(array $filters = []): array {
		$wpdb = $this->wpdb;

		$cache_key = 'ow_kpis_' . md5(wp_json_encode($filters));
		$cached = wp_cache_get($cache_key, self::CACHE_GROUP);
		if (false !== $cached && is_array($cached)) {
			return $cached;
		}

		$period = $filters['period'] ?? '30d';
		$dates  = $this->resolve_period_dates($period);

		$extra = $this->build_extra_where($filters);

		$extra_where  = $extra['where'];
		$extra_params = $extra['params'];

		if ($dates['has_previous']) {
			$cur_start  = $dates['current_start'];
			$cur_end    = $dates['current_end'];
			$prev_start = $dates['previous_start'];
			$prev_end   = $dates['previous_end'];

			$sql = "SELECT 
				COUNT(CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s THEN 1 END) AS cur_total,
				COUNT(CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s AND outerwhisper_ff_feedback_score IS NOT NULL THEN 1 END) AS cur_rated,
				AVG(CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s THEN outerwhisper_ff_feedback_score END) AS cur_avg_score,
				SUM(CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s AND outerwhisper_ff_feedback_score >= 50 THEN 1 ELSE 0 END) AS cur_positive,
				SUM(CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s AND outerwhisper_ff_feedback_score < 50 THEN 1 ELSE 0 END) AS cur_negative,
				SUM(CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s AND outerwhisper_ff_status = 'unread' THEN 1 ELSE 0 END) AS cur_unread,

				COUNT(CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s THEN 1 END) AS prev_total,
				COUNT(CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s AND outerwhisper_ff_feedback_score IS NOT NULL THEN 1 END) AS prev_rated,
				AVG(CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s THEN outerwhisper_ff_feedback_score END) AS prev_avg_score,
				SUM(CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s AND outerwhisper_ff_feedback_score >= 50 THEN 1 ELSE 0 END) AS prev_positive,
				SUM(CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s AND outerwhisper_ff_feedback_score < 50 THEN 1 ELSE 0 END) AS prev_negative,
				SUM(CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s AND outerwhisper_ff_status = 'unread' THEN 1 ELSE 0 END) AS prev_unread
			FROM %i
			WHERE outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s
			{$extra_where}";

			$query_params = [
				// Aktueller Zeitraum (6 × 2)
				$cur_start, $cur_end,
				$cur_start, $cur_end,
				$cur_start, $cur_end,
				$cur_start, $cur_end,
				$cur_start, $cur_end,
				$cur_start, $cur_end,

				// Vorheriger Zeitraum (6 × 2)
				$prev_start, $prev_end,
				$prev_start, $prev_end,
				$prev_start, $prev_end,
				$prev_start, $prev_end,
				$prev_start, $prev_end,
				$prev_start, $prev_end,

				// FROM %i
				$this->table_name,

				// WHERE Zeitraum
				$prev_start, $cur_end,
			];

			$query_params = array_merge($query_params, $extra_params);

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, PluginCheck.Security.DirectDB.UnescapedDBParameter -- SQL fragments are built from fixed clauses; all values and the table identifier are passed to wpdb::prepare().
			$row = $wpdb->get_row(
			    // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->prepare($sql, $query_params)
			);
		} else {
			$sql = "SELECT 
				COUNT(*) AS cur_total,
				COUNT(CASE WHEN outerwhisper_ff_feedback_score IS NOT NULL THEN 1 END) AS cur_rated,
				AVG(outerwhisper_ff_feedback_score) AS cur_avg_score,
				SUM(CASE WHEN outerwhisper_ff_feedback_score >= 50 THEN 1 ELSE 0 END) AS cur_positive,
				SUM(CASE WHEN outerwhisper_ff_feedback_score < 50 THEN 1 ELSE 0 END) AS cur_negative,
				SUM(CASE WHEN outerwhisper_ff_status = 'unread' THEN 1 ELSE 0 END) AS cur_unread,
				0 AS prev_total,
				0 AS prev_rated,
				NULL AS prev_avg_score,
				0 AS prev_positive,
				0 AS prev_negative,
				0 AS prev_unread
			FROM %i
			WHERE 1=1
			{$extra_where}";

			$query_params = array_merge(
				[$this->table_name],
				$extra_params
			);

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, PluginCheck.Security.DirectDB.UnescapedDBParameter -- SQL fragments are built from fixed clauses; all values and the table identifier are passed to wpdb::prepare().
			$row = $wpdb->get_row(
			    // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->prepare($sql, $query_params)
			);
		}

		$kpis = $this->format_kpi_results($row, $dates['has_previous']);
		wp_cache_set($cache_key, $kpis, self::CACHE_GROUP, 300);

		return $kpis;
	}

	public static function clear_cache(): void {
		if (function_exists('wp_cache_flush_group')) {
			wp_cache_flush_group(self::CACHE_GROUP);
		} else {
			wp_cache_flush();
		}
	}

	protected function resolve_period_dates(string $period): array {
		$current_start  = '';
		$current_end    = '';
		$previous_start = '';
		$previous_end   = '';

		$now = new \DateTimeImmutable('now', wp_timezone());
		$today = $now->setTime(0, 0, 0);

		$has_previous = true;

		switch ($period) {
			case '7d':
			case '30d':
			case '90d':
				$days = (int) $period;

				$current_start  = $today->modify('-' . ($days - 1) . ' days');
				$current_end    = $today->setTime(23, 59, 59);

				$previous_start = $today->modify('-' . ($days * 2 - 1) . ' days');
				$previous_end   = $today->modify('-' . $days . ' days')->setTime(23, 59, 59);
				break;

			case 'all':
				$has_previous = false;
				break;

			default:
				$current_start  = $today->modify('-29 days');
				$current_end    = $today->setTime(23, 59, 59);
				$previous_start = $today->modify('-59 days');
				$previous_end   = $today->modify('-30 days')->setTime(23, 59, 59);
				break;
		}

		if ($period !== 'all') {
			$current_start  = $current_start->format('Y-m-d H:i:s');
			$current_end    = $current_end->format('Y-m-d H:i:s');
			$previous_start = $previous_start->format('Y-m-d H:i:s');
			$previous_end   = $previous_end->format('Y-m-d H:i:s');
		}

		return [
			'has_previous'   => $has_previous,
			'current_start'  => $current_start,
			'current_end'    => $current_end,
			'previous_start' => $previous_start,
			'previous_end'   => $previous_end,
		];
	}

	protected function build_extra_where(array $filters): array {
		$where  = '';
		$params = [];

		if (!empty($filters['form_id']) && 'all' !== $filters['form_id']) {
			if (is_array($filters['form_id'])) {
				$ids          = array_map('intval', $filters['form_id']);
				$placeholders = implode(',', array_fill(0, count($ids), '%d'));
				if (!empty($placeholders)) {
					$where .= " AND outerwhisper_ff_fd_id IN ($placeholders)";
					$params = array_merge($params, $ids);
				}
			} else {
				$where   .= ' AND outerwhisper_ff_fd_id = %d';
				$params[] = (int) $filters['form_id'];
			}
		}

		if (!empty($filters['display_type']) && 'all' !== $filters['display_type']) {
			$where   .= ' AND outerwhisper_ff_form_type = %s';
			$params[] = sanitize_text_field($filters['display_type']);
		}

		if (!empty($filters['status']) && 'all' !== $filters['status']) {
			$where   .= ' AND outerwhisper_ff_status = %s';
			$params[] = sanitize_text_field($filters['status']);
		}

		return [
			'where'  => $where,
			'params' => $params,
		];
	}

	protected function format_kpi_results($row, bool $has_previous): array {
		$cur_total   = (int) ($row->cur_total ?? 0);
		$cur_rated   = (int) ($row->cur_rated ?? 0);
		$cur_unread  = (int) ($row->cur_unread ?? 0);
		$cur_avg_score = isset($row->cur_avg_score) && null !== $row->cur_avg_score ? round((float) $row->cur_avg_score, 1) : null;
		$cur_positive = (int) ($row->cur_positive ?? 0);
		$cur_negative = (int) ($row->cur_negative ?? 0);

		$prev_total   = (int) ($row->prev_total ?? 0);
		$prev_rated   = (int) ($row->prev_rated ?? 0);
		$prev_avg_score = isset($row->prev_avg_score) && null !== $row->prev_avg_score ? round((float) $row->prev_avg_score, 1) : null;
		$prev_positive = (int) ($row->prev_positive ?? 0);

		$total_diff       = $cur_total - $prev_total;
		$total_change_pct = null;

		if ($has_previous) {
			if ($prev_total > 0) {
				$total_change_pct = (int) round((($cur_total - $prev_total) / $prev_total) * 100);
			} elseif ($cur_total > 0) {
				$total_change_pct = 100;
			} else {
				$total_change_pct = 0;
			}
		}

		$rated_pct = $cur_total > 0 ? (int) round(($cur_rated / $cur_total) * 100) : 0;

		$avg_score_diff = null;
		if ($has_previous && null !== $cur_avg_score && null !== $prev_avg_score) {
			$avg_score_diff = round($cur_avg_score - $prev_avg_score, 1);
		}

		$positive_pct = $cur_rated > 0 ? (int) round(($cur_positive / $cur_rated) * 100) : 0;
		$negative_pct = $cur_rated > 0 ? (int) (100 - $positive_pct) : 0;

		$prev_positive_pct = $prev_rated > 0 ? (int) round(($prev_positive / $prev_rated) * 100) : 0;
		$positive_pct_diff = null;

		if ($has_previous && $cur_rated > 0 && $prev_rated > 0) {
			$positive_pct_diff = $positive_pct - $prev_positive_pct;
		}

		return [
			'total'               => $cur_total,
			'prev_total'          => $prev_total,
			'total_diff'          => $total_diff,
			'total_change_pct'    => $total_change_pct,
			'rated'               => $cur_rated,
			'rated_pct'           => $rated_pct,
			'avg_score'           => $cur_avg_score,
			'prev_avg_score'      => $prev_avg_score,
			'avg_score_diff'      => $avg_score_diff,
			'positive_count'      => $cur_positive,
			'negative_count'      => $cur_negative,
			'positive_pct'        => $positive_pct,
			'negative_pct'        => $negative_pct,
			'positive_pct_diff'   => $positive_pct_diff,
			'unread'              => $cur_unread,
			'has_previous_period' => $has_previous,
		];
	}
}
