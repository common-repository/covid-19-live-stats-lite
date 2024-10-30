<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://covid19livestat.com
 * @since      1.0.0
 *
 * @package    covid19livestats
 * @subpackage covid19livestats/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    covid19livestats
 * @subpackage covid19livestats/includes
 * @author     Covid19LiveStats.pro <info@covid19livestats.pro>
 */
class Covid19LiveStats_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'covid19livestats',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
