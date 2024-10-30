<?php

/**
 * Fired during plugin activation
 *
 * @link       http://covid19livestat.com
 * @since      1.0.0
 *
 * @package    covid19livestats
 * @subpackage covid19livestats/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    covid19livestats
 * @subpackage covid19livestats/includes
 * @author     Covid19LiveStats.pro <info@covid19livestats.pro>
 */
class Covid19LiveStats_Activator {

	/**
	 * Plugin activation
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		// Create options
		$covid19livestats_settings = array (
				'last_updated' => '',
				'interval' => 'ten_minutes',
		);
		add_option('covid19livestats_settings', $covid19livestats_settings);

		// Setup cron for schedule posts
		// Use wp_next_scheduled to check if the event is already scheduled
		$timestamp = wp_next_scheduled( 'covid19livestats_update' );

		//If $timestamp == false schedule create new post since it hasn't been done previously
		if( $timestamp == false ) {
			//Schedule the event for right now, then to repeat daily
			wp_schedule_event( time(), 'ten_minutes', 'covid19livestats_update' );
		}

		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . "covid19_all_countries";

		$sql = "CREATE TABLE $table_name (
				id int(10) NOT NULL AUTO_INCREMENT,
				country varchar(100) NOT NULL DEFAULT '',
				code varchar(10) NOT NULL DEFAULT '',
				confirmed int(10) NOT NULL DEFAULT 0,
				recovered int(10) NOT NULL DEFAULT 0,
				critical int(10) NOT NULL DEFAULT 0,
				deaths int(10) NOT NULL DEFAULT 0,
				PRIMARY KEY  (id)
		) $charset_collate";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		// Update data on first activation
		// covid19livestats_update_data();

		$covid19livestats_settings['last_updated'] = current_time( 'timestamp' );

		update_option('covid19livestats_settings', $covid19livestats_settings);

	}

}
