<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://covid19livestat.com
 * @since      1.0.0
 *
 * @package    covid19livestats
 * @subpackage covid19livestats/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    covid19livestats
 * @subpackage covid19livestats/public
 * @author     Covid19LiveStats.pro <info@covid19livestats.pro>
 */
class Covid19LiveStats_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $covid19livestats    The ID of this plugin.
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
	 * @param      string    $covid19livestats       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( 'covid19-bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap/bootstrap.min.css', array(), '4.4.1', 'all' );
		wp_enqueue_style( 'datatables', plugin_dir_url( __FILE__ ) . 'css/datatables.min.css', array( ), '1.10.20', 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/covid19livestats-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'bootstrap-bundle', plugin_dir_url( __FILE__ ) . 'js/bootstrap/bootstrap.min.js', array( 'jquery' ), '4.4.1', false );
		wp_enqueue_script( 'datatables', plugin_dir_url( __FILE__ ) . 'js/datatables.min.js', array( 'jquery' ), '1.10.20', false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/covid19livestats-public.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Register the shortcodes
	 *
	 * @since    1.0.3
	 */
	public function covid19livestats_register_shortcodes() {
		add_shortcode('covid-19-live-stat-table', array( $this, 'covid19livestats_table_shortcode_function' ) );
		add_shortcode('covid-19-live-stat-card', array( $this, 'covid19livestats_card_shortcode_function' ) );
	}

	/**
	 * Shortcode function
	 *
	 * @since    1.0.3
	 */
	public static function covid19livestats_table_shortcode_function( $atts ) {

		global $wpdb;
		$table_name = $wpdb->prefix . "covid19_all_countries";
		$results = $wpdb->get_results( "SELECT * FROM  $table_name ORDER BY confirmed DESC" );

		$atts = shortcode_atts( array(

        ), $atts );

		$return_string = '';
		$return_string = '<div class="cod-widget-wrap">';
		$return_string .= '<div class="container">';
		$return_string .= '<div class="row">';
		$return_string .= '<div class="col-md-12">';
		$return_string .= '<div class="cod-block-title">Covid-19 Live Stats - Worldwide</div>';
		$return_string .= '<input type="text" id="myTableSearchBox" class="form-control" placeholder="Search countries...">';
		$return_string .= '</div>'; // end col
		$return_string .= '</div>'; // end row
		$return_string .= '<div class="row">';
		$return_string .= '<div class="col-md-12">';

		$return_string .= '<table class="cod-widget-table">';
		$return_string .= '<thead>';
		$return_string .= '<tr>';
		$return_string .= '<th width="30%">Country</th>';
		$return_string .= '<th class="text-confirmed">Confirmed</th>';
		$return_string .= '<th class="text-recovered">Recovered</th>';
		$return_string .= '<th class="text-critical">Critical</th>';
		$return_string .= '<th class="text-deaths">Deaths</th>';
		$return_string .= '</tr>';
		$return_string .= '</thead>';
		$return_string .= '<tbody>';

    foreach( $results as $result ) {

			$return_string .= '<tr>';
			$return_string .= '<td><img src="'. covid19livestats_flag($result->country) .'" alt="'. $result->country .'" title="'. $result->country .'" class="flags" />' . $result->country . '</td>';
			$return_string .= '<td class="text-confirmed">' . number_format($result->confirmed, 0) . '</td>';
			$return_string .= '<td class="text-recovered">' . number_format($result->recovered, 0) . '</td>';
			$return_string .= '<td class="text-critical">' . number_format($result->critical, 0) . '</td>';
			$return_string .= '<td class="text-deaths">' . number_format($result->deaths, 0) . '</td>';
			$return_string .= '</tr>';
    }

		$return_string .= '</tbody>';
		$return_string .= '</table>';

		$return_string .= '</div>'; // end col
		$return_string .= '</div>';	// end row
		$return_string .= '</div>'; // end container

		$return_string .= '</div>'; // end cod-widget-wrap

		return $return_string;

  }

	/**
	 * Shortcode function
	 *
	 * @since    1.0.3
	 */
	public static function covid19livestats_card_shortcode_function( $atts ) {

		global $wpdb;
		$table_name = $wpdb->prefix . "covid19_all_countries";

		$atts = shortcode_atts( array(
						'country' 	=> '',
        ), $atts );
		$country = $atts['country'];

		if( $country == '' ) {

			$result = $wpdb->get_results( "SELECT sum(confirmed) as total_confirmed,
																			sum(recovered) as total_recovered,
																			sum(critical) as total_critical,
																			sum(deaths) as total_deaths
																			FROM  $table_name" );
				$country = 'Worldwide';
		}
		else {
			 $result  = $wpdb->get_results( $wpdb->prepare("SELECT country as country_name,
																				sum(confirmed) as total_confirmed,
																			 sum(recovered) as total_recovered,
																			 sum(critical) as total_critical,
																			 sum(deaths) as total_deaths
																			 FROM  $table_name
																			 WHERE country LIKE %s", $country) );
		}


		$return_string = '';
		$return_string = '<div class="cod-widget-wrap">';

		$return_string .= '<div class="container">';
		$return_string .= '<div class="row">';
		$return_string .= '<div class="col-md-12">';
		$return_string .= '<h3>Covid-19 Live Stats - '. $country .'</h3>';
		$return_string .= '</div>'; // end col
		$return_string .= '</div>'; // end row

		$return_string .= '<div class="row">';

		$return_string .= '<div class="col-md-6 nopadding">';
		$return_string .= '<div class="cod-widget-stat-box box-confirmed"><p>';
		$return_string .= number_format($result[0]->total_confirmed, 0);
		$return_string .= '<span class="text-legend">';
		$return_string .= esc_html__( 'Confirmed', 'text_domain' );
		$return_string .= '</span></p></div>';
		$return_string .= '</div>'; // end col

		$return_string .= '<div class="col-md-6 nopadding">';
		$return_string .= '<div class="cod-widget-stat-box box-recovered"><p>';
		$return_string .= number_format($result[0]->total_recovered, 0);
		$return_string .= '<span class="text-legend">';
		$return_string .= esc_html__( 'Recovered', 'text_domain' );
		$return_string .= '</span></p></div>';
		$return_string .= '</div>'; // end col

		$return_string .= '</div>'; // end row

		$return_string .= '<div class="row">';

		$return_string .= '<div class="col-md-6">';
		$return_string .= '<div class="cod-widget-stat-box box-critical"><p>';
		$return_string .= number_format($result[0]->total_critical, 0);
		$return_string .= '<span class="text-legend">';
		$return_string .= esc_html__( 'Critical', 'text_domain' );
		$return_string .= '</span></p></div>';
		$return_string .= '</div>'; // end col

		$return_string .= '<div class="col-md-6">';
		$return_string .= '<div class="cod-widget-stat-box box-deaths"><p>';
		$return_string .= number_format($result[0]->total_deaths, 0);
		$return_string .= '<span class="text-legend">';
		$return_string .= esc_html__( 'Deaths', 'text_domain' );
		$return_string .= '</span></p></div>';
		$return_string .= '</div>'; // end col

		$return_string .= '</div>'; // end row
		$return_string .= '</div>'; // end container
		$return_string .= '</div>'; // end cod-widget-wrap

		return $return_string;

  }

}
