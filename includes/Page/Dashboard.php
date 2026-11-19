<?php

namespace OuterWhisper\Page;

use OuterWhisper\Aggregator\DashboardAggregator;
use OuterWhisper\EnvironmentChecks;

/**
 * Dashboard Page class.
 */
class Dashboard extends Page {

    /**
     * @return string
     */
    protected function get_template_path(): string {
        return OUTERWHISPER_PLUGIN_PATH . 'templates/admin/outerwhisper-dashboard.php';
    }

    /**
     * Prepares data for the dashboard.
     */
    public function render() {
		if (EnvironmentChecks::check()) {
			$filters = $this->extract_filters();

			$aggregator = new DashboardAggregator();
			$dashboardData = $aggregator->get_all($filters);
			$preparedKpiData = $dashboardData['kpis'] ?? $aggregator->get_kpis($filters);

			wp_localize_script('outerwhisper-admin-script', 'outerwhisperDashboard', [
				'trendChartData' => $dashboardData['trend_chart_data'] ?? [],
				'displayStats'   => $dashboardData['display_type_stats'] ?? [],
			]);

			$this->data = [
				'preparedKpiData' => $preparedKpiData,
				'dashboardData'   => $dashboardData,
				'filters'         => $filters,
			];

			parent::render();
		}
    }
}
