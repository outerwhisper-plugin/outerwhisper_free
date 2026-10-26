<?php
/**
 * Plugin Name:       OuterWhisper
 * Plugin URI:        https://outerwhisper.de
 * Description:       Collect and analyze user feedback directly in WordPress with a visual form builder, flexible display options, smart triggers, and targeting.
 * Version:           1.0.1
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            Kai Steudten
 * License:           GPLv2+
 * Text Domain:       outerwhisper
 * Domain Path:       /languages
 *
 * @package         OuterWhisper
 * @author          OuterWhisper
 * @copyright       Copyright (c) OuterWhisper
 *
 * OuterWhisper is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as published by
 * the Free Software Foundation.
 *
 * OuterWhisper is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WordPress. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 *
 * Note: This file must not contain PHP code that does not run on PHP < 7.4!
 */

if (!defined('ABSPATH')) {
    exit;
}

// Konstanten definieren
if (!defined('OUTERWHISPER_PLUGIN_NAME_PREFIX')) {
	define('OUTERWHISPER_PLUGIN_NAME_PREFIX', 'OUTERWHISPER_');
	define('OUTERWHISPER_PLUGIN_PATH', plugin_dir_path(__FILE__));
	define('OUTERWHISPER_PLUGIN_URL', plugin_dir_url(__FILE__));
	define('OUTERWHISPER_VERSION', '1.0.1');
	define('OUTERWHISPER_DB_VERSION', '1.0.1');
}

// Autoloader (einfach gehalten für dieses Plugin)
spl_autoload_register(function ($class) {
    $prefix = 'OuterWhisper\\';
    $base_dir = OUTERWHISPER_PLUGIN_PATH . 'includes/';

    $len = strlen($prefix);
    if (strpos($class, $prefix) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    // Ersetze Namespace-Backslashes durch Slashes für den Pfad
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // Debugging oder Fallback für Case-Sensitivity (Linux/WSL)
    // Wenn die Datei nicht existiert, versuchen wir es kleingeschrieben für den Ordnerpfad
    if (!file_exists($file)) {
        $parts = explode('\\', $relative_class);
        if (count($parts) > 1) {
            $class_name = array_pop($parts);
            $sub_dir = strtolower(implode('/', $parts));
            $file = $base_dir . $sub_dir . '/' . $class_name . '.php';
        }
    }

    if (file_exists($file)) {
        require_once $file;
    }
});

require_once OUTERWHISPER_PLUGIN_PATH . 'includes/Core.php';
if (!function_exists('outerwhisper_activate')) {
    function outerwhisper_activate() {
        if (!function_exists('is_plugin_active')) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }

        if (is_plugin_active('outerwhisper-premium/outerwhisper.php')) {
             wp_die('The Pro version of OuterWhisper is already active. Please deactivate the Pro version first before activating the free version.');
        }

        if (!class_exists('\OuterWhisper\Core')) {
            require_once OUTERWHISPER_PLUGIN_PATH . 'includes/Core.php';
        }
        \OuterWhisper\Core::plugin_activation();
    }
}
register_activation_hook( __FILE__, 'outerwhisper_activate' );

add_filter('load_script_translation_file', function ($file, $handle, $domain) {
	if ($domain !== 'outerwhisper') {
		return $file;
	}

	// If WordPress did not find a translation file for the active locale
	if (!$file || !file_exists($file)) {
		// Construct the path to the en_GB fallback file
		// Replaces any locale in the filename (or empty) with en_GB
		$locale = determine_locale();
		$fallback_file = str_replace("-{$locale}-", '-en_GB-', (string) $file);

		if ($fallback_file && file_exists($fallback_file)) {
			return $fallback_file;
		}
	}

	return $file;
}, 10, 3);

// Start
add_action('init', function() {
	$languageHelper = new \OuterWhisper\Helper\LanguageHelper();
	$languageHelper->load_textdomain();

	$plugin = new \OuterWhisper\Core();
	$plugin->run();
}, 5);
