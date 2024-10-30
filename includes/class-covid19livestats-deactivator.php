<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://covid19livestat.com
 * @since      1.0.0
 *
 * @package    covid19livestats
 * @subpackage covid19livestats/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    covid19livestats
 * @subpackage covid19livestats/includes
 * @author     Covid19LiveStats.pro <info@covid19livestats.pro>
 */
class Covid19LiveStats_Deactivator {

	/**
	 *
	 * Plugin deactivation
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		global $wpdb;
		$table_name = $wpdb->prefix . "covid19_all_countries";
		$wpdb->query( "DROP TABLE IF EXISTS $table_name" );
		delete_option("covid19livestats_settings");

		// Delete previous plugin cron
		wp_clear_scheduled_hook( 'covid19livestats_update' );
		
	}

}
