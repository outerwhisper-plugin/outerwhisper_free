<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package OuterWhisper
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit;
}

require_once plugin_dir_path(__FILE__) . 'outerwhisper.php';

if (class_exists('\OuterWhisper\Database\Database')) {
	\OuterWhisper\Database\Database::uninstall_cleanup();
}