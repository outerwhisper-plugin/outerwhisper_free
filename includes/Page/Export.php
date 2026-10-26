<?php

namespace OuterWhisper\Page;

/**
 * Export Page class.
 */
class Export extends Page {

    /**
     * @return string
     */
    protected function get_template_path(): string {
		return OUTERWHISPER_PLUGIN_PATH . 'templates/admin/outerwhisper-export.php';
    }

    /**
     * Prepares data for the export page.
     */
    public function render() {
		$form_db = new \OuterWhisper\Database\Form();
		$forms = $form_db->get_forms(['limit' => 999, 'orderby' => 'outerwhisper_fd_name', 'order' => 'ASC']);

        $this->data = [
            'forms' => $forms,
        ];

        parent::render();
    }
}
