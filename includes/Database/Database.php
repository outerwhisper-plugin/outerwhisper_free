<?php

namespace OuterWhisper\Database;

use OuterWhisper\Helper\LanguageHelper;

abstract class Database {
    protected $table_name;
    protected $wpdb;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
    }

    abstract public function create_table();

    public static function update_check() {
        $installed_version = get_option('outerwhisper_db_version');
        if ($installed_version != OUTERWHISPER_DB_VERSION) {
            $languageHelper = new LanguageHelper();
            $languageHelper->load_textdomain();

            $form = new Form();
            $form->create_table();

            $formFeedback = new FormFeedback();
            $formFeedback->create_table();

            // Initial-Formulare anlegen, falls noch keine existieren
            if ($form->get_form_count() === 0) {
                $form->create_initial_forms();
            }

            update_option('outerwhisper_db_version', OUTERWHISPER_DB_VERSION);
        }
    }

    /**
     * Cleanup data when uninstall.
     *
     * @since 1.0.2
     */
    public static function uninstall_cleanup() {
        global $wpdb;

        // Check if the other version of the plugin is active to avoid deleting shared data
        if (!function_exists('is_plugin_active')) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }

        // Determine if we are in 'outerwhisper' (Free) or 'outerwhisper-premium' (Pro) folder
        $current_dir = basename(rtrim(OUTERWHISPER_PLUGIN_PATH, '/'));
        $other_plugin = ($current_dir === 'outerwhisper') ? 'outerwhisper-premium/outerwhisper.php' : 'outerwhisper/outerwhisper.php';

        if (is_plugin_active($other_plugin)) {
            return;
        }

        // Delete database tables
		// phpcs:disable WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.SchemaChange, WordPress.DB.DirectDatabaseQuery.DirectQuery
        $wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "outerwhisper_form_feedback" );
        $wpdb->query( "DROP TABLE IF EXISTS " . $wpdb->prefix . "outerwhisper_form_data" );

        // Delete outerwhisper options
        $wpdb->query( "DELETE FROM `" . $wpdb->prefix . "options` WHERE `option_name` LIKE ('outerwhisper_%')" );

        // Delete transients
        $wpdb->query( "DELETE FROM `" . $wpdb->prefix . "options` WHERE `option_name` LIKE ('_transient_outerwhisper_%')" );
		// phpcs:enable WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.SchemaChange, WordPress.DB.DirectDatabaseQuery.DirectQuery
    }
}
