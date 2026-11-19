<?php

namespace OuterWhisper\Page;

use OuterWhisper\Helper\FeedbackStatsService;
use OuterWhisper\Helper\FormFeedbackHelper;
use OuterWhisper\Lists\FormFeedbackListTable;
use OuterWhisper\Page\Page;

/**
 * FeedbackList Page class.
 */
class FeedbackList extends Page {

    /**
     * @return string
     */
    protected function get_template_path(): string {
		return OUTERWHISPER_PLUGIN_PATH . 'templates/admin/outerwhisper-form-feedback-list.php';
    }

    /**
     * Prepares data for the feedback list page.
     */
    public function render() {
        $filters = $this->extract_filters();

        $feedback_table = new FormFeedbackListTable($filters);
        $feedback_table->prepare_items();

        $stats_service = new FeedbackStatsService();
        $preparedKpiData = $stats_service->get_kpis($filters);

        $feedback_helper = new FormFeedbackHelper();
        $first_item = !empty($feedback_table->items) ? reset($feedback_table->items) : null;
        $first_feedback_detail = $first_item ? $feedback_helper->get_detail_view_data($first_item) : null;

        $this->data = [
            'feedback_table'        => $feedback_table,
            'preparedKpiData'        => $preparedKpiData,
            'first_feedback_detail' => $first_feedback_detail,
            'filters'               => $filters,
        ];

        parent::render();
    }

	/**
	 * Registers hooks for the feedback page.
	 */
	public function register_hooks(string $hook_suffix): void {
		$table = new FormFeedbackListTable();

		add_action(
			'load-' . $hook_suffix,
			[$table, 'process_bulk_action']
		);
	}
}
