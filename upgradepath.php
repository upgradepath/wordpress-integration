<?php
/**
 * UpgradePath
 *
 * @package           UpgradePath
 * @author            UpgradePath
 * @copyright         2020 UpgradePath
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       UpgradePath
 * Description:       The UpgradePath wordpress integration sends plugin meta information to UpgradePath so that you can easily manage your software versions in one central place.
 * Version:           0.0.3
 * Requires at least: 5.1
 * Requires PHP:      7.0
 * Author:            UpgradePath
 * Author URI:        https://upgradepath.io
 * Text Domain:       upgradepath
 * Domain Path: 	  /assets/languages
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Check if get_plugins() function exists. This is required on the front end of the
// site, since it is in a file that is normally only loaded in the admin.

if (!function_exists('get_plugins')) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

require_once 'vendor/autoload.php';

$core = new Upgradepath\Core(__FILE__);
$core->init();
