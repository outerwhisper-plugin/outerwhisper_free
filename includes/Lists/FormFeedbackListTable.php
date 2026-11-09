<?php

namespace OuterWhisper\Lists;

use OuterWhisper\Database\FormFeedback;
use OuterWhisper\Helper\FeedbackStatsService;
use OuterWhisper\Helper\FormFeedbackHelper;
use OuterWhisper\Helper\FormHelper;
use WP_List_Table;

if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('WP_List_Table')) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class FormFeedbackListTable extends WP_List_Table {

	protected FormHelper $formHelper;
	protected FormFeedbackHelper $formFeedbackHelper;
	protected array $filters = [];

	public function __construct(array $filters = []) {
		$this->filters    = $filters;
		$this->formHelper = new FormHelper();
		$this->formFeedbackHelper = new FormFeedbackHelper();

		parent::__construct([
			'singular' => 'feedback',
            'plural'   => 'feedbacks',
            'ajax'     => false,
		]);
	}

	public function get_columns(): array {
		return [
			'cb'     => '<input type="checkbox" id="outerwhisper-feedback-cb-select-all" class="outerwhisper-feedback-checkbox" aria-label="' . esc_attr__('admin.page.feedback_list.table.select_all', 'outerwhisper') . '">',
			'id'     => esc_html__('admin.page.feedback_list.table.id', 'outerwhisper'),
			'status' => esc_html__('admin.page.feedback_list.table.status', 'outerwhisper'),
			'score'  => esc_html__('admin.page.feedback_list.table.score', 'outerwhisper'),
			'form'   => esc_html__('admin.page.feedback_list.table.form', 'outerwhisper'),
			'url'    => esc_html__('admin.page.feedback_list.table.page_url', 'outerwhisper'),
			'answer' => esc_html__('admin.page.feedback_list.table.answer', 'outerwhisper'),
			'date'   => esc_html__('admin.page.feedback_list.table.date', 'outerwhisper'),
			'action' => '<span class="screen-reader-text">' . esc_html__('admin.page.feedback_list.table.details', 'outerwhisper') . '</span>',
		];
	}

	protected function handle_row_actions( $item, $column_name, $primary ): string {
		return '';
	}

	protected function get_sortable_columns(): array {
		return [
			'id'     => ['id', false],
			'status' => ['status', false],
			'score'  => ['score', false],
			'form'   => ['form', false],
			'date'   => ['created', true],
		];
	}

	protected function get_bulk_actions(): array {
		return [
			'mark_read'   => esc_html__('admin.page.feedback_list.bulk.mark_read', 'outerwhisper'),
			'mark_unread' => esc_html__('admin.page.feedback_list.bulk.mark_unread', 'outerwhisper'),
			'archive'     => esc_html__('admin.page.feedback_list.bulk.archive', 'outerwhisper'),
			'trash'       => esc_html__('admin.page.feedback_list.bulk.trash', 'outerwhisper'),
		];
	}

	protected function get_table_classes(): array {
		return [
			'wp-list-table',
			'widefat',
			'fixed',
			'striped',
			'outerwhisper-feedback-list-table',
			$this->_args['plural'],
		];
	}

	public function process_bulk_action(): void {
		$action = $this->current_action();
		if (in_array($action, ['mark_read', 'mark_unread', 'archive', 'trash']) === false) {
			return;
		}

		if (!current_user_can('manage_options')) {
			return;
		}

		$nonce = isset($_REQUEST['nonce'])
			? sanitize_text_field(wp_unslash($_REQUEST['nonce']))
			: '';

		$wpnonce = isset($_REQUEST['_wpnonce'])
			? sanitize_text_field(wp_unslash($_REQUEST['_wpnonce']))
			: '';

		if (
			!wp_verify_nonce($nonce, 'outerwhisper_admin_nonce') &&
			!wp_verify_nonce($wpnonce, 'bulk-feedbacks')
		) {
			return;
		}

		$ids = [];
		if (!empty($_REQUEST['feedback_ids']) && is_array($_REQUEST['feedback_ids'])) {
			$ids = array_map('intval', (array) $_REQUEST['feedback_ids']);
		}

		$ids = array_filter($ids);
		if (empty($ids)) {
			return;
		}

		$form_feedback_db = new FormFeedback();
		$changed          = false;

		switch ($action) {
			case 'mark_read':
				foreach ($ids as $id) {
					$form_feedback_db->update_status($id, 'read');
				}
				$changed = true;
				break;

			case 'mark_unread':
				foreach ($ids as $id) {
					$form_feedback_db->update_status($id, 'unread');
				}
				$changed = true;
				break;

			case 'archive':
				foreach ($ids as $id) {
					$form_feedback_db->update_status($id, 'archived');
				}
				$changed = true;
				break;

			case 'trash':
				foreach ($ids as $id) {
					$form_feedback_db->delete_feedback($id);
				}
				$changed = true;
				break;
		}

		if ($changed) {
			FeedbackStatsService::clear_cache();

			$redirect_url = remove_query_arg(
				[
					'_wp_http_referer',
					'_wpnonce',
					'nonce',
					'ID',
					'action',
					'action2',
					'bulk_action',
					'feedback_ids',
				],
				sanitize_url(wp_unslash($_SERVER['REQUEST_URI'] ?? ''))
			);

			if (empty($redirect_url)) {
				$redirect_url = admin_url(
					'admin.php?page=outerwhisper-form-feedbacks'
				);
			}

			wp_safe_redirect($redirect_url, 303);
			exit;
		}
	}

	public function single_row($item): void {
		$feedback = $item['feedback_entity'];
		$id = $feedback->getId();
		printf(
			'<tr class="outerwhisper-feedback-row outerwhisper-feedback-plugin" data-id="%d" data-status="%s">',
			(int) $id,
			esc_attr($feedback->getStatus())
		);
		$this->single_row_columns($item);
		echo '</tr>';
	}

	public function column_default($item, $column_name) {
		return '-';
	}

	public function column_cb($item): string {
		$feedback = $item['feedback_entity'];
		$id = (int) $feedback->getId();

		return sprintf(
			'<input type="checkbox" name="feedback_ids[]" id="outerwhisper-feedback-cb-%1$d" value="%1$d" class="outerwhisper-feedback-checkbox outerwhisper-feedback-row-cb" aria-label="%2$s">',
			$id,
			esc_attr(sprintf(__('admin.page.feedback_list.table.select_item', 'outerwhisper'), $id))
		);
	}

	public function column_id($item): string {
		$feedback = $item['feedback_entity'];
		$id = (int) $feedback->getId();

		return sprintf(
			'<span class="outerwhisper-feedback-id" data-id="%1$d">#%1$d</span>',
			$id
		);
	}

	public function column_status($item): string {
		$feedback = $item['feedback_entity'];
		$status = $feedback->getStatus();

		switch ($status) {
			case 'read':
				$status_label = esc_html__('admin.page.feedback_list.status.read', 'outerwhisper');
				$status_class = 'outerwhisper-feedback-status-read';
				break;
			case 'archived':
				$status_label = esc_html__('admin.page.feedback_list.status.archived', 'outerwhisper');
				$status_class = 'outerwhisper-feedback-status-archived';
				break;
			case 'unread':
			default:
				$status_label = esc_html__('admin.page.feedback_list.status.unread', 'outerwhisper');
				$status_class = 'outerwhisper-feedback-status-unread';
				break;
		}

		return sprintf(
			'<span class="outerwhisper-feedback-status-pill %s">%s</span>',
			esc_attr($status_class),
			esc_html($status_label)
		);
	}

	public function column_score($item): string {
		$feedback = $item['feedback_entity'];
		$score = $feedback->getFeedbackScore();

		if ($score === null || $score === '') {
			return '<span class="outerwhisper-feedback-score-badge outerwhisper-feedback-score-none">–</span>';
		}

		$numeric_score = round((float) $score);
		if ($numeric_score >= 75) {
			$badge_class = 'outerwhisper-feedback-score-high';
		} elseif ($numeric_score >= 50) {
			$badge_class = 'outerwhisper-feedback-score-mid';
		} else {
			$badge_class = 'outerwhisper-feedback-score-low';
		}

		return sprintf(
			'<span class="outerwhisper-feedback-score-badge %s">%s</span>',
			esc_attr($badge_class),
			esc_html((string) $numeric_score)
		);
	}

	public function column_form($item): string {
		$feedback = $item['feedback_entity'];
		$data = $feedback->getDecodedFeedbackData();

		$form_title = $data['title'] ?? '-';
		$question = $data['first_label_text'] ?? '-';

		$icon = 'fa-regular fa-comment-dots';
		switch ($feedback->getFormType()) {
			case 'modal':
				$icon = 'fa-solid fa-window-maximize';
				break;
			case 'slide-in':
				$icon = 'fa-solid fa-globe';
				break;
			case 'feedback-button':
				$icon = 'fa-regular fa-comment-dots';
				break;
			case 'shortcode':
				$icon = 'fa-solid fa-code';
				break;
			case 'pre-content':
			case 'post-content':
				$icon = 'fa-regular fa-star';
				break;
		}

		return sprintf(
			'<div class="outerwhisper-feedback-form-cell">
				<i class="%s outerwhisper-feedback-form-icon" aria-hidden="true"></i>
				<div class="outerwhisper-feedback-form-meta">
					<span class="outerwhisper-feedback-form-title">%s</span>
					<span class="outerwhisper-feedback-form-question">%s</span>
				</div>
			</div>',
			esc_attr($icon),
			esc_html($form_title),
			esc_html($question)
		);
	}

	public function column_url($item): string {
		$feedback = $item['feedback_entity'];
		$url = $feedback->getTrackingPageUrl();

		if (empty($url)) {
			return '<span class="outerwhisper-feedback-url-link">-</span>';
		}

		$path = wp_parse_url($url, PHP_URL_PATH) ?: $url;

		return sprintf(
			'<a href="%1$s" target="_blank" rel="noopener noreferrer" class="outerwhisper-feedback-url-link" title="%1$s">%2$s</a>',
			esc_url($url),
			esc_html($path)
		);
	}

	public function column_answer($item): string {
		$feedback = $item['feedback_entity'];
		$data = $feedback->getDecodedFeedbackData();
		$firstAnswer = $data['first_answer'] ?? '-';
		$firstAnswerFieldType = $data['first_answer_field_type'] ?? '';

		return $this->formFeedbackHelper->prepareFirstAnswerPreview($firstAnswer, $firstAnswerFieldType, 'table-row');
	}

	public function column_date($item): string {
		$feedback = $item['feedback_entity'];
		$created = $feedback->getCreated();

		if (empty($created)) {
			return '-';
		}

		$timestamp = strtotime($created);
		$date_day = date_i18n('d.m.Y', $timestamp);
		$date_time = date_i18n('H:i', $timestamp);

		return sprintf(
			'<div class="outerwhisper-feedback-date-cell">
				<span>%s</span>
				<span class="outerwhisper-feedback-date-time">%s</span>
			</div>',
			esc_html($date_day),
			esc_html($date_time)
		);
	}

	public function column_action($item): string {
		return '<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>';
	}

	public function no_items(): void {
		esc_html_e('admin.page.feedback_list.table.no_items', 'outerwhisper');
	}

	public function prepare_items(array $filters = []): void {
		if (!current_user_can('manage_options')) {
			wp_die(
				esc_html__('admin.page.feedback_list.no_permission', 'outerwhisper')
			);
		}

		if (!empty($filters)) {
			$this->filters = array_merge($this->filters, $filters);
		}

		$columns  = $this->get_columns();
		$hidden   = [];
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = [$columns, $hidden, $sortable];

		$per_page     = 20;
		$current_page = $this->get_pagenum();

		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- Sorting and filtering are read-only operations.
		$filter_page_url = '';
		$filter_search = '';

		$orderby = !empty($this->filters['orderby']) ? $this->filters['orderby'] : 'created';
		$order   = !empty($this->filters['order']) ? $this->filters['order'] : 'desc';

		$filter_period    = isset($this->filters['period']) ? $this->filters['period'] : '30d';
		$filter_status    = isset($this->filters['status']) ? $this->filters['status'] : '';
		$filter_display_type = isset($this->filters['display_type']) ? $this->filters['display_type'] : '';
		$filter_form_id   = isset($this->filters['form_id']) ? $this->filters['form_id'] : '';
		// phpcs:enable WordPress.Security.NonceVerification.Recommended

		$filter_range = $filter_period;
		if ($filter_period === '30d') {
			$filter_range = 'last_30_days';
		} elseif ($filter_period === '7d') {
			$filter_range = 'last_7_days';
		} elseif ($filter_period === '90d') {
			$filter_range = 'last_90_days';
		} elseif ($filter_period === 'all') {
			$filter_range = '';
		}

		$mapping = [
			'id'      => 'outerwhisper_ff_id',
			'form_id' => 'outerwhisper_ff_fd_id',
			'created' => 'outerwhisper_ff_created',
			'date'    => 'outerwhisper_ff_created',
			'updated' => 'outerwhisper_ff_updated',
			'status' => 'outerwhisper_ff_status',
			'score' => 'outerwhisper_ff_feedback_score',
		];

		if (isset($mapping[$orderby])) {
			$orderby = $mapping[$orderby];
		}

		$args = [
			'limit'      => $per_page,
			'offset'     => ($current_page - 1) * $per_page,
			'orderby'    => $orderby,
			'order'      => $order,
			'range'      => $filter_range,
			'status'     => $filter_status,
			'form_type'  => $filter_display_type,
			'form_id'    => $filter_form_id
		];

		$form_feedback_db = new FormFeedback();
		$total_items      = $form_feedback_db->get_feedback_count($args);
		$feedbacks        = $form_feedback_db->get_feedbacks($args);

		$this->items = [];
		foreach ($feedbacks as $feedback) {
			$this->items[] = [
				'id'              => $feedback->getId(),
				'feedback_entity' => $feedback,
			];
		}

		$this->set_pagination_args([
		   'total_items' => $total_items,
           'per_page'    => $per_page,
           'total_pages' => ceil($total_items / $per_page),
	    ]);
	}

	public function display(): void {
		$singular = $this->_args['singular'];

		$this->display_tablenav('top');

		$this->screen->render_screen_reader_content('heading_list');
		?>
		<div class="outerwhisper-feedback-table-wrapper">
			<table id="outerwhisper-feedback-table" class="<?php echo esc_attr(implode(' ', $this->get_table_classes())); ?>">
				<thead>
					<tr>
						<?php $this->print_column_headers(); ?>
					</tr>
				</thead>

				<tbody id="outerwhisper-feedback-the-list"<?php
				if ($singular) {
					echo " data-wp-lists='list:" . esc_attr($singular) . "'";
				} ?>>
					<?php $this->display_rows_or_placeholder(); ?>
				</tbody>

				<tfoot>
					<tr>
						<?php $this->print_column_headers(false); ?>
					</tr>
				</tfoot>
			</table>
		</div>
		<?php
		$this->display_tablenav('bottom');
	}

	public function extra_tablenav($which): void {
		if ($which !== 'top') {
			return;
		}

		$current_period       = isset($this->filters['period']) && '' !== $this->filters['period'] ? $this->filters['period'] : '30d';
		$current_form_id      = isset($this->filters['form_id']) && '' !== $this->filters['form_id'] ? (string) $this->filters['form_id'] : 'all';
		$current_display_type = isset($this->filters['display_type']) && '' !== $this->filters['display_type'] ? $this->filters['display_type'] : 'all';
		$current_status       = isset($this->filters['status']) && '' !== $this->filters['status'] ? $this->filters['status'] : 'all';

		$active_filters = [];

		if ($current_period !== '30d') {
			$period_labels = [
				'7d'  => esc_html__('admin.page.feedback_list.filter.period_7d', 'outerwhisper'),
				'90d' => esc_html__('admin.page.feedback_list.filter.period_90d', 'outerwhisper'),
				'all' => esc_html__('admin.page.feedback_list.filter.period_all', 'outerwhisper'),
			];
			$active_filters['period'] = [
				'label'     => sprintf('%s: %s', esc_html__('admin.page.feedback_list.filter.period', 'outerwhisper'), $period_labels[$current_period] ?? $current_period),
				'reset_url' => remove_query_arg(['period', 'paged']),
			];
		}

		if ($current_form_id !== 'all') {
			$form_id_val = (int) $current_form_id;
			$form_db     = new \OuterWhisper\Database\Form();
			$form_entry  = $form_db->get_form($form_id_val);
			$form_name   = $form_entry ? $form_entry->getName() : '#' . $form_id_val;

			$active_filters['form_id'] = [
				'label'     => sprintf('%s: %s', esc_html__('admin.page.feedback_list.filter.form', 'outerwhisper'), $form_name),
				'reset_url' => remove_query_arg(['form_id', 'paged']),
			];
		}

		if ($current_display_type !== 'all') {
			$mappings = $this->formHelper->get_form_type_name_mapping();

			$active_filters['display_type'] = [
				'label'     => sprintf('%s: %s', esc_html__('admin.page.feedback_list.filter.display_type', 'outerwhisper'), $mappings[$current_display_type] ?? $current_display_type),
				'reset_url' => remove_query_arg(['display_type', 'paged']),
			];
		}

		if ($current_status !== 'all') {
			$status_labels = [
				'unread'   => esc_html__('admin.page.feedback_list.status.unread', 'outerwhisper'),
				'read'     => esc_html__('admin.page.feedback_list.status.read', 'outerwhisper'),
				'archived' => esc_html__('admin.page.feedback_list.status.archived', 'outerwhisper'),
			];

			$active_filters['status'] = [
				'label'     => sprintf('%s: %s', esc_html__('admin.page.feedback_list.filter.status', 'outerwhisper'), $status_labels[$current_status] ?? $current_status),
				'reset_url' => remove_query_arg(['status', 'paged']),
			];
		}
		?>
		<div class="outerwhisper-feedback-filter-bar">
			<div class="outerwhisper-feedback-filter-item">
				<label class="outerwhisper-feedback-filter-label" for="outerwhisper-feedback-filter-period"><?php esc_html_e('admin.page.feedback_list.filter.period', 'outerwhisper'); ?></label>
				<div class="outerwhisper-feedback-select-wrap">
					<select id="outerwhisper-feedback-filter-period" name="period" class="outerwhisper-feedback-select outerwhisper-feedback-select-with-icon">
						<option value="30d" <?php selected($current_period, '30d'); ?>><?php esc_html_e('admin.page.feedback_list.filter.period_30d', 'outerwhisper'); ?></option>
						<option value="7d" <?php selected($current_period, '7d'); ?>><?php esc_html_e('admin.page.feedback_list.filter.period_7d', 'outerwhisper'); ?></option>
						<option value="90d" <?php selected($current_period, '90d'); ?>><?php esc_html_e('admin.page.feedback_list.filter.period_90d', 'outerwhisper'); ?></option>
						<option value="all" <?php selected($current_period, 'all'); ?>><?php esc_html_e('admin.page.feedback_list.filter.period_all', 'outerwhisper'); ?></option>
					</select>
				</div>
			</div>

			<div class="outerwhisper-feedback-filter-item">
				<label class="outerwhisper-feedback-filter-label" for="outerwhisper-feedback-filter-form"><?php esc_html_e('admin.page.feedback_list.filter.form', 'outerwhisper'); ?></label>
				<div class="outerwhisper-feedback-select-wrap">
					<select id="outerwhisper-feedback-filter-form" name="form_id" class="outerwhisper-feedback-select">
						<option value="all" <?php selected($current_form_id, 'all'); ?>><?php esc_html_e('admin.page.feedback_list.filter.all_forms', 'outerwhisper'); ?></option>
						<?php
						$form_db = new \OuterWhisper\Database\Form();
						$forms   = $form_db->get_forms(['limit' => 999, 'orderby' => 'outerwhisper_fd_name', 'order' => 'ASC']);
						foreach ($forms as $form_entry) :
							?>
							<option value="<?php echo (int) $form_entry->getId(); ?>" <?php selected($current_form_id, (string) $form_entry->getId()); ?>>
								<?php echo esc_html($form_entry->getName()); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="outerwhisper-feedback-filter-item">
				<label class="outerwhisper-feedback-filter-label" for="outerwhisper-feedback-filter-display"><?php esc_html_e('admin.page.feedback_list.filter.display_type', 'outerwhisper'); ?></label>
				<div class="outerwhisper-feedback-select-wrap">
					<select id="outerwhisper-feedback-filter-display" name="display_type" class="outerwhisper-feedback-select">
						<option value="all" <?php selected($current_display_type, 'all'); ?>><?php esc_html_e('admin.page.feedback_list.filter.all_display_types', 'outerwhisper'); ?></option>
						<?php foreach ($this->formHelper->get_form_type_name_mapping() as $type => $name) : ?>
							<option value="<?php echo esc_attr($type); ?>" <?php selected($current_display_type, $type); ?>><?php echo esc_html($name); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="outerwhisper-feedback-filter-item">
				<label class="outerwhisper-feedback-filter-label" for="outerwhisper-feedback-filter-status"><?php esc_html_e('admin.page.feedback_list.filter.status', 'outerwhisper'); ?></label>
				<div class="outerwhisper-feedback-select-wrap">
					<select id="outerwhisper-feedback-filter-status" name="status" class="outerwhisper-feedback-select">
						<option value="all" <?php selected($current_status, 'all'); ?>><?php esc_html_e('admin.page.feedback_list.filter.all_statuses', 'outerwhisper'); ?></option>
						<option value="unread" <?php selected($current_status, 'unread'); ?>><?php esc_html_e('admin.page.feedback_list.status.unread', 'outerwhisper'); ?></option>
						<option value="read" <?php selected($current_status, 'read'); ?>><?php esc_html_e('admin.page.feedback_list.status.read', 'outerwhisper'); ?></option>
						<option value="archived" <?php selected($current_status, 'archived'); ?>><?php esc_html_e('admin.page.feedback_list.status.archived', 'outerwhisper'); ?></option>
					</select>
				</div>
			</div>

		</div>

		<?php if (!empty($active_filters)) : ?>
			<div id="outerwhisper-feedback-active-filters" class="outerwhisper-feedback-active-filters">
				<?php foreach ($active_filters as $filter_key => $filter_data) : ?>
					<span class="outerwhisper-feedback-filter-chip" data-chip="<?php echo esc_attr($filter_key); ?>">
						<span><?php echo esc_html($filter_data['label']); ?></span>
						<a href="<?php echo esc_url($filter_data['reset_url']); ?>" class="outerwhisper-feedback-chip-remove" aria-label="<?php echo esc_attr(sprintf(__('admin.page.feedback_list.filter.remove_filter', 'outerwhisper'), $filter_data['label'])); ?>">
							<i class="fa-solid fa-xmark" aria-hidden="true"></i>
						</a>
					</span>
				<?php endforeach; ?>

				<a href="<?php echo esc_url(remove_query_arg(['period', 'form_id', 'display_type', 'status', 'page_url', 's', 'paged'])); ?>" id="outerwhisper-feedback-reset-filters" class="outerwhisper-feedback-reset-link">
					<?php esc_html_e('admin.page.feedback_list.filter.reset_all', 'outerwhisper'); ?>
				</a>
			</div>
		<?php else : ?>
			<div id="outerwhisper-feedback-active-filters" class="outerwhisper-feedback-active-filters"></div>
		<?php endif; ?>
		<?php
	}

	protected function display_tablenav($which): void {
		if ($which === 'top') {
			$this->extra_tablenav($which);
			return;
		}
		?>
		<div class="outerwhisper-feedback-tablenav-bottom tablenav <?php echo esc_attr($which); ?>">
			<?php if ($this->has_items()) : ?>
				<div class="outerwhisper-feedback-bulk-actions alignleft actions bulkactions">
					<?php $this->bulk_actions($which); ?>
				</div>
			<?php endif; ?>
			<?php
			$this->extra_tablenav($which);
			$this->pagination($which);
			?>
		</div>
		<?php
	}
}
