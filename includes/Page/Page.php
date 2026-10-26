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
}
