<?php

namespace OuterWhisper\Page;

/**
 * Base class for Admin Pages.
 */
abstract class Page {

    /**
     * Page title.
     * @var string
     */
    protected $page_title = '';

    /**
     * Data to be passed to the template.
     * @var array
     */
    protected $data = [];

    /**
     * Constructor.
     */
    public function __construct() {
        $this->page_title = esc_html__('OuterWhisper', 'outerwhisper');
    }

    /**
     * Renders the page.
     */
    public function render() {
		$currentScreen = get_current_screen();

        $admin_template = $this->get_template_path();

		$data = [
			'id' => '',
			'page' => !empty($currentScreen) ? str_replace('outerwhisper_page_', '', $currentScreen->id) : '',
			'nonce' => wp_create_nonce('outerwhisper_admin_nonce')
		];

		if (!empty($_GET['nonce']) && wp_verify_nonce(sanitize_key(wp_unslash($_GET['nonce'])), 'outerwhisper_admin_nonce')) {
			$data['id'] = sanitize_text_field(wp_unslash($_GET['id'] ?? ''));
		}

		$this->data = array_merge($this->data, $data);

		// Extract data for the template
		extract($this->data);

        // We use the common admin page wrapper
        include OUTERWHISPER_PLUGIN_PATH . 'templates/admin/outerwhisper-admin-page.php';
    }

    /**
     * Returns the path to the template file.
     * 
     * @return string
     */
    abstract protected function get_template_path(): string;

    /**
     * Registers meta boxes for the page.
     */
    public function register_meta_boxes() {
        // Optional: Override in child classes
    }

	/**
	 * Extracts and normalizes filters from the request.
	 *
	 * @return array
	 */
	protected function extract_filters(): array {
		$page_url = '';
		$search = '';

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

		if ('all' === $page_url) {
			$page_url = '';
		}

		return [
			'period'    => $period,
			'status'    => $status,
			'display_type' => $display_type,
			'form_id'   => $form_id,
			'page_url'  => $page_url,
			'search'    => $search,
			'orderby'   => $orderby,
			'order'     => $order,
		];
	}
}
