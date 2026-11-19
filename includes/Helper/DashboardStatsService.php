<?php

namespace OuterWhisper\Helper;

use OuterWhisper\Helper\StatisticService;
use wpdb;

defined('ABSPATH') || exit;

class DashboardStatsService extends StatisticService {

	public const CACHE_GROUP = 'outerwhisper_dashboard_kpi';

	protected wpdb $wpdb;
	protected string $table_name;

	public function __construct() {
		global $wpdb;
		$this->wpdb = $wpdb;
		$this->table_name = $this->wpdb->prefix . 'outerwhisper_form_feedback';
	}

	public static function clear_cache(): void {
		StatisticService::clear_cache_group(self::CACHE_GROUP);
	}

	public function get_kpis(array $filters = []): array {
		$wpdb = $this->wpdb;

		$cache_key = 'ow_dashboard_kpis_' . md5(wp_json_encode($filters));
		$cached = wp_cache_get($cache_key, self::CACHE_GROUP);
		if (false !== $cached && is_array($cached)) {
			return $cached;
		}

		$period = $filters['period'] ?? '30d';
		$dates  = $this->resolve_period_dates($period);

		$extra        = $this->build_extra_where($filters);
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
				COUNT(DISTINCT CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s AND outerwhisper_ff_tracking_page_url IS NOT NULL AND outerwhisper_ff_tracking_page_url != '' THEN outerwhisper_ff_tracking_page_url END) AS cur_pages,

				COUNT(CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s THEN 1 END) AS prev_total,
				COUNT(CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s AND outerwhisper_ff_feedback_score IS NOT NULL THEN 1 END) AS prev_rated,
				AVG(CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s THEN outerwhisper_ff_feedback_score END) AS prev_avg_score,
				SUM(CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s AND outerwhisper_ff_feedback_score >= 50 THEN 1 ELSE 0 END) AS prev_positive,
				COUNT(DISTINCT CASE WHEN outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s AND outerwhisper_ff_tracking_page_url IS NOT NULL AND outerwhisper_ff_tracking_page_url != '' THEN outerwhisper_ff_tracking_page_url END) AS prev_pages
			FROM %i
			WHERE outerwhisper_ff_created >= %s AND outerwhisper_ff_created <= %s
			{$extra_where}";

			$query_params = [
				$cur_start, $cur_end,
				$cur_start, $cur_end,
				$cur_start, $cur_end,
				$cur_start, $cur_end,
				$cur_start, $cur_end,

				$prev_start, $prev_end,
				$prev_start, $prev_end,
				$prev_start, $prev_end,
				$prev_start, $prev_end,
				$prev_start, $prev_end,

				$this->table_name,

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
				COUNT(DISTINCT CASE WHEN outerwhisper_ff_tracking_page_url IS NOT NULL AND outerwhisper_ff_tracking_page_url != '' THEN outerwhisper_ff_tracking_page_url END) AS cur_pages,
				0 AS prev_total,
				0 AS prev_rated,
				NULL AS prev_avg_score,
				0 AS prev_positive,
				0 AS prev_pages
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

		return [
			'where'  => $where,
			'params' => $params,
		];
	}

	protected function format_kpi_results($row, bool $has_previous): array {
		$cur_total     = (int) ($row->cur_total ?? 0);
		$cur_rated     = (int) ($row->cur_rated ?? 0);
		$cur_avg_score = isset($row->cur_avg_score) && null !== $row->cur_avg_score ? round((float) $row->cur_avg_score, 1) : null;
		$cur_positive  = (int) ($row->cur_positive ?? 0);
		$cur_pages     = (int) ($row->cur_pages ?? 0);

		$prev_total     = (int) ($row->prev_total ?? 0);
		$prev_rated     = (int) ($row->prev_rated ?? 0);
		$prev_avg_score = isset($row->prev_avg_score) && null !== $row->prev_avg_score ? round((float) $row->prev_avg_score, 1) : null;
		$prev_positive  = (int) ($row->prev_positive ?? 0);
		$prev_pages     = (int) ($row->prev_pages ?? 0);

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

		$avg_score_diff = null;
		if ($has_previous && null !== $cur_avg_score && null !== $prev_avg_score) {
			$avg_score_diff = round($cur_avg_score - $prev_avg_score, 1);
		}

		$positive_pct      = $cur_rated > 0 ? (int) round(($cur_positive / $cur_rated) * 100) : 0;
		$prev_positive_pct = $prev_rated > 0 ? (int) round(($prev_positive / $prev_rated) * 100) : 0;
		$positive_pct_diff = null;

		if ($has_previous && $cur_rated > 0 && $prev_rated > 0) {
			$positive_pct_diff = $positive_pct - $prev_positive_pct;
		}

		$pages_change_pct = null;
		if ($has_previous) {
			if ($prev_pages > 0) {
				$pages_change_pct = (int) round((($cur_pages - $prev_pages) / $prev_pages) * 100);
			} elseif ($cur_pages > 0) {
				$pages_change_pct = 100;
			} else {
				$pages_change_pct = 0;
			}
		}

		return [
			'total'               => $cur_total,
			'prev_total'          => $prev_total,
			'total_change_pct'    => $total_change_pct,
			'avg_score'           => $cur_avg_score,
			'prev_avg_score'      => $prev_avg_score,
			'avg_score_diff'      => $avg_score_diff,
			'positive_pct'        => $positive_pct,
			'positive_pct_diff'   => $positive_pct_diff,
			'rated'               => $cur_rated,
			'pages'               => $cur_pages,
			'prev_pages'          => $prev_pages,
			'pages_change_pct'    => $pages_change_pct,
			'has_previous_period' => $has_previous,
		];
	}
}
