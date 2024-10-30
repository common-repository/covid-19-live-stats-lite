<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://covid19livestat.com
 * @since      1.0.0
 *
 * @package    covid19livestats
 * @subpackage covid19livestats/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    covid19livestats
 * @subpackage covid19livestats/admin
 * @author     qubxlab <info@qubxlab.com.au>
 */
class Covid19LiveStats_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Covid19LiveStats_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Covid19LiveStats_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/covid19livestats-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Covid19LiveStats_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Covid19LiveStats_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
    wp_enqueue_script('jquery');
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/covid19livestats-admin.js', array( 'jquery' ), NULL, false );

	}

	public function covid19livestats_admin_menu() {
		add_menu_page( $this->plugin_name, $this->plugin_name, 'administrator', 'covid19livestats_home', array( $this, 'display_covid19livestats_page' ), 'dashicons-chart-area' );
  }

  public function display_covid19livestats_page() {
		require_once ( 'partials/covid19livestats-admin-display.php' );
  }

	public function covid19livestats_add_cron_interval( $schedules ) {
			$schedules['ten_minutes'] = array(
					'interval' => 10*60,
					'display'  => esc_html__( 'Every Ten Minutes' ), );
			return $schedules;
	}

	public function covid19livestats_refresh_data() {

		covid19livestats_update_data();

		$covid19livestats_settings = get_option('covid19livestats_settings');
		$covid19livestats_settings['last_updated'] = current_time( 'timestamp' );
		update_option('covid19livestats_settings', $covid19livestats_settings);

	}

}
