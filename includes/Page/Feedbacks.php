<?php

namespace OuterWhisper\Page;

use OuterWhisper\Helper\FeedbackStatsService;
use OuterWhisper\Helper\FormFeedbackHelper;
use OuterWhisper\Lists\FormFeedbackListTable;

/**
 * Feedbacks Page class.
 */
class Feedbacks extends Page {

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

    /**
     * Extracts and normalizes filters from the request.
     *
     * @return array
     */
    protected function extract_filters(): array {
        // phpcs:disable WordPress.Security.NonceVerification.Recommended
		$period = !empty($_GET['period']) ? sanitize_text_field(wp_unslash($_GET['period'])) : '30d';
		$status = !empty($_GET['status']) ? sanitize_text_field(wp_unslash($_GET['status'])) : '';
		$display_type = !empty($_GET['display_type']) ? sanitize_text_field(wp_unslash($_GET['display_type'])) : '';
		$form_id = !empty($_GET['form_id']) ? sanitize_text_field(wp_unslash($_GET['form_id'])) : '';
		$orderby = !empty($_GET['orderby']) ? sanitize_sql_orderby(wp_unslash($_GET['orderby'])) : 'created';
		$order = !empty($_GET['order']) ? sanitize_text_field(wp_unslash($_GET['order'])) : 'desc';
        // phpcs:enable WordPress.Security.NonceVerification.Recommended

        if ('all' === $status) {
            $status = '';
        }

        if ('all' === $display_type) {
			$display_type = '';
        }

        if ('all' === $form_id) {
            $form_id = '';
        }

        return [
            'period'    => $period,
            'status'    => $status,
            'display_type' => $display_type,
            'form_id'   => $form_id,
            'orderby'   => $orderby,
            'order'     => $order,
        ];
    }
}
