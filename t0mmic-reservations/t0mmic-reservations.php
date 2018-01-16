<?php
ob_start();
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/t0mmic/trp-restaurant-reservation
 * @since             1.0.0
 * @package           T0mmic_Reservations
 *
 * @wordpress-plugin
 * Plugin Name:       t0mmic-reservations
 * Plugin URI:        https://github.com/t0mmic/trp-restaurant-reservation
 * Description:       Restaurant reservation plugin will make you work easier.
 * Version:           1.0.0
 * Author:            Michal Tomek
 * Author URI:        https://github.com/t0mmic/trp-restaurant-reservation
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       t0mmic-reservations
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently pligin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('TRP_VERSION', '1.0.0');
define('TRP_PATH', plugin_dir_path(__FILE__));
define('TRP_URL', plugin_dir_url(__FILE__));
define('TRP_ADMIN_URL', admin_url());
define('TRP_SITE_URL', site_url());

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-t0mmic-reservations-activator.php
 */
function activate_t0mmic_reservations() {
	require_once TRP_PATH . 'includes/class-t0mmic-reservations-activator.php';
	T0mmic_Reservations_Activator::activate();
	flush_rewrite_rules();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-t0mmic-reservations-deactivator.php
 */
function deactivate_t0mmic_reservations() {
	require_once TRP_PATH . 'includes/class-t0mmic-reservations-deactivator.php';
	T0mmic_Reservations_Deactivator::deactivate();
	flush_rewrite_rules();
}

/**
 * The code that runs during plugin uninstallation.
 * This action is documented in uninstall.php
 */
function uninstall_t0mmic_reservations() {
	require_once TRP_PATH . 'uninstall.php';
	T0mmic_Reservations_Uninstaller::uninstall();
	flush_rewrite_rules();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-t0mmic-reservations-deactivator.php
 */
register_activation_hook( __FILE__, 'activate_t0mmic_reservations' );
register_deactivation_hook( __FILE__, 'deactivate_t0mmic_reservations' );
register_uninstall_hook( __FILE__, 'uninstall_t0mmic_reservations' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require TRP_PATH . 'includes/class-t0mmic-reservations.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

function run_t0mmic_reservations() {
	$plugin = new T0mmic_Reservations();
	$plugin->run();
}
run_t0mmic_reservations();
