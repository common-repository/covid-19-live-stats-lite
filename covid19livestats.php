<?php
/**
 * The plugin bootstrap file
 *
 * @link              http://demo.covid19livestat.com
 * @since             1.0.0
 * @package           covid19livestats
 *
 * @wordpress-plugin
 * Plugin Name:       Covid-19 Live Stats Lite
 * Plugin URI:        http://covid19livestat.com
 * Description:       Covid-19 Live Stats is a WordPress Plugin to display Coronavirus (COVID-19) outbreak live updates in WordPress website. Display Covid-19 stats on your pages/posts/sidebars using simple widgets and shortcodes.
 * Version:           1.0.1
 * Author:            charleshop
 * Author URI:        http://covid19livestat.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       covid19livestats
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-covid19livestats-activator.php
 */
function activate_covid19livestats() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-covid19livestats-activator.php';
	Covid19LiveStats_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_covid19livestats() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-covid19livestats-deactivator.php';
	Covid19LiveStats_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_covid19livestats' );
register_deactivation_hook( __FILE__, 'deactivate_covid19livestats' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-covid19livestats.php';

/**
 * Begins execution of the plugin.
 *
 *
 * @since    1.0.0
 */
function run_covid19livestats() {

	$plugin = new Covid19LiveStats();
	$plugin->run();

}
run_covid19livestats();
