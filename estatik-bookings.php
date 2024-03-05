<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Estatik_Bookings
 *
 * @wordpress-plugin
 * Plugin Name:       Estatik Bookings
 * Plugin URI:        http://example.com/estatik-bookings-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Pavlo Alokhin
 * Author URI:        https://www.linkedin.com/in/pavlo-a-399113193/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       estatik-bookings
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ESTATIK_BOOKINGS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-estatik-bookings-activator.php
 */
function activate_estatik_bookings() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-estatik-bookings-activator.php';
	Estatik_Bookings_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-estatik-bookings-deactivator.php
 */
function deactivate_estatik_bookings() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-estatik-bookings-deactivator.php';
	Estatik_Bookings_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_estatik_bookings' );
register_deactivation_hook( __FILE__, 'deactivate_estatik_bookings' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-estatik-bookings.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_estatik_bookings() {

	$plugin = new Estatik_Bookings();
	$plugin->run();

}
run_estatik_bookings();
