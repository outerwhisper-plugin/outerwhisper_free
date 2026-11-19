<?php

namespace OuterWhisper\Helper;

use OuterWhisper\Aggregator\DashboardAggregator;
use OuterWhisper\Helper\DashboardStatsService;
use OuterWhisper\Helper\FeedbackStatsService;

class StatisticService {

	protected array $calculatedDates = [];

	public function resolve_period_dates(string $period): array {
		if (!empty($this->calculatedDates[$period])) {
			return $this->calculatedDates[$period];
		}

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

		$calculatedDates = [
			'has_previous'   => $has_previous,
			'current_start'  => $current_start,
			'current_end'    => $current_end,
			'previous_start' => $previous_start,
			'previous_end'   => $previous_end,
		];

		$this->calculatedDates[$period] = $calculatedDates;

		return $calculatedDates;
	}

	public static function clear_cache_group(string $groupName): void {
		if (function_exists('wp_cache_flush_group')) {
			wp_cache_flush_group($groupName);
		} else {
			wp_cache_flush();
		}
	}

	public static function clear_statistic_cache(): void {
		self::clear_cache_group(FeedbackStatsService::CACHE_GROUP);
		self::clear_cache_group(DashboardStatsService::CACHE_GROUP);
		self::clear_cache_group(DashboardAggregator::CACHE_GROUP);
	}

	public static function get_admin_page_url(array $params = [], string $page = 'outerwhisper-form-feedbacks'): string {
		$query_args = ['page' => $page];

		foreach ($params as $key => $value) {
			if ($value === null || $value === '' || $value === 'all') {
				continue;
			}
			$query_args[$key] = $value;
		}

		return add_query_arg($query_args, admin_url('admin.php'));
	}
}