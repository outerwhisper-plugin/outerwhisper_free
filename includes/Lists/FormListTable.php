<?php

namespace OuterWhisper\Lists;

use OuterWhisper\Database\Form;
use WP_List_Table;

if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('WP_List_Table')) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class FormListTable extends WP_List_Table
{

	public $total_items = 0;
	protected $adminNonce = '';

	public function __construct()
	{
		parent::__construct([
			'singular' => 'form',
            'plural'   => 'forms',
            'ajax'     => false
		]);

		$this->adminNonce = wp_create_nonce('outerwhisper_admin_nonce');
	}

	public function get_columns()
	{
		return [
			'cb'        => '<input type="checkbox" />',
			'id'        => esc_html__('admin.form_list.id', 'outerwhisper'),
			'name'      => esc_html__('admin.form_list.name', 'outerwhisper'),
			'status'    => esc_html__('admin.form_list.status', 'outerwhisper'),
			'shortcode' => esc_html__('admin.form_list.shortcode', 'outerwhisper'),
			'updated'   => esc_html__('admin.form_list.updated', 'outerwhisper'),
		];
	}

	protected function get_sortable_columns()
	{
		return [
			'id'      => ['id', false],
			'name'    => ['name', false],
			'status'  => ['status', false],
			'updated' => ['updated', true],
		];
	}

	public function column_default($item, $column_name)
	{
		switch ($column_name) {
			case 'name':
				return esc_html($item->getName());
			case 'status':
				$status = $item->getStatus();
				$label = esc_html__('admin.form_list.status.paused', 'outerwhisper');
				$class = 'outerwhisper-badge--preview';

				switch ($status) {
					case 2:
						$label = esc_html__('admin.form_list.status.live', 'outerwhisper');
						$class = 'outerwhisper-badge--live';
						break;
					case 3:
						$label = esc_html__('admin.form_list.status.admin_only', 'outerwhisper');
						$class = 'outerwhisper-badge--admin-only';
						break;
				}

				return sprintf('<span class="outerwhisper-badge %s">%s</span>', esc_attr($class), esc_html($label));
			case 'shortcode':
				return sprintf('<code>[outerwhisper_form id="%d"]</code>', (int)$item->getId());
			case 'updated':
				return date_i18n(
					get_option('date_format') . ' ' . get_option('time_format'),
					strtotime($item->getUpdated())
				);
			default:
				return '-';
		}
	}

	public function column_cb($item)
	{
		return sprintf('<input type="checkbox" name="forms[]" value="%s" />', (int)$item->getId());
	}

	public function column_id($item)
	{
		$actions = [
			'edit' => sprintf(
				'<a href="?page=outerwhisper-form-builder&id=%d&nonce=%s">%s</a>',
				(int)$item->getId(),
				esc_attr($this->adminNonce),
				esc_html__('admin.form_list.actions.edit', 'outerwhisper')
			),
		];

		$actions['duplicate'] = sprintf(
			'<a href="?page=outerwhisper-forms&action=duplicate&id=%d&nonce=%s">%s</a>',
			(int)$item->getId(),
			esc_attr($this->adminNonce),
			esc_html__('admin.form_list.actions.duplicate', 'outerwhisper')
		);

		$actions['delete'] = sprintf(
			'<a href="?page=outerwhisper-forms&action=delete&id=%d&nonce=%s" class="outerwhisper-delete-form-js" data-name="%s">%s</a>',
			(int)$item->getId(),
			esc_attr($this->adminNonce),
			esc_attr($item->getName()),
			esc_html__('admin.form_list.actions.delete', 'outerwhisper')
		);

		return sprintf(
			'<strong><a class="row-title" href="?page=outerwhisper-form-builder&id=%d&nonce=%s">#%d</a></strong> %s',
			$item->getId(),
			$this->adminNonce,
			$item->getId(),
			$this->row_actions($actions)
		);
	}

	public function column_name($item)
	{
		return sprintf(
			'<strong><a class="row-title" href="?page=outerwhisper-form-builder&id=%d&nonce=%s">%s</a></strong>',
			$item->getId(),
			$this->adminNonce,
			esc_html($item->getName())
		);
	}

	public function no_items()
	{
		esc_html_e('admin.form_list.no_forms', 'outerwhisper');
	}

	public function prepare_items()
	{
		if (!current_user_can('manage_options')) {
			wp_die(
				esc_html__('You do not have permission to access this page.', 'outerwhisper')
			);
		}

		$columns = $this->get_columns();
		$hidden = [];
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = [$columns, $hidden, $sortable];

		$per_page = 20;
		$current_page = $this->get_pagenum();

		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- Sorting and filtering are read-only operations.
		$orderby = (!empty($_GET['orderby'])) ? sanitize_text_field(wp_unslash($_GET['orderby'])) : 'updated';
		$order = (!empty($_GET['order'])) ? sanitize_text_field(wp_unslash($_GET['order'])) : 'desc';
		// phpcs:enable WordPress.Security.NonceVerification.Recommended

		// Map orderby to DB columns
		$mapping = [
			'id'      => 'outerwhisper_fd_id',
			'name'    => 'outerwhisper_fd_name',
			'status'  => 'outerwhisper_fd_status',
			'updated' => 'outerwhisper_fd_updated'
		];

		if (isset($mapping[$orderby])) {
			$orderby = $mapping[$orderby];
		}

		$args = [
			'limit'   => $per_page,
			'offset'  => ($current_page - 1) * $per_page,
			'orderby' => $orderby,
			'order'   => $order,
		];

		$form_db = new Form();
		$total_items = $form_db->get_form_count();

		$this->total_items = $total_items;

		$this->items = $form_db->get_forms($args);

		$this->set_pagination_args([
		   'total_items' => $total_items,
           'per_page'    => $per_page,
           'total_pages' => ceil($total_items / $per_page)
	   ]);
	}
}
