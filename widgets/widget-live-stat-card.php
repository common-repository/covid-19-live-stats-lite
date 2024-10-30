<?php

class Covid_19_Live_Stat_Card extends WP_Widget {

  function __construct() {

    parent::__construct(
      'covid-19-live-stat-card',
      'Covid-19 Live Stat Card'
    );

    add_action( 'widgets_init', function() {
      register_widget( 'Covid_19_Live_Stat_Card' );
    });

  }

  public $args = array(
          'before_title'  => '<h4 class="cod-widget-title">',
          'after_title'   => '</h4>',
          'before_widget' => '<div>',
          'after_widget'  => '</div>'
      );

  public function widget( $args, $instance ) {

    global $wpdb;
		$table_name = $wpdb->prefix . "covid19_all_countries";

    echo $args['before_widget'];

    if( !empty( $instance['title'] ) ) {
      echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
    }

    $country_id = !empty( $instance['country_id'] ) ? $instance['country_id'] : 0;

    if( $country_id == 0 ) {

      $result  = $wpdb->get_results( "SELECT sum(confirmed) as total_confirmed,
                                      sum(recovered) as total_recovered,
                                      sum(critical) as total_critical,
                                      sum(deaths) as total_deaths
                                      FROM  $table_name" );
        $country = 'Worldwide';
    }
    else {
       $result  = $wpdb->get_results( "SELECT country as country_name,
                                        sum(confirmed) as total_confirmed,
                                       sum(recovered) as total_recovered,
                                       sum(critical) as total_critical,
                                       sum(deaths) as total_deaths
                                       FROM  $table_name
                                       WHERE id=" . $country_id );

        $country = $result[0]->country_name;
    }

    echo '<div class="cod-widget-wrap">';
    echo '<div class="container">';
    echo '<div class="row">';
    echo '<div class="col-md-12">';
    echo '<h3>Covid-19 Live Stats - '. $country .'</h3>';
    echo '</div>'; // end col
    echo '</div>'; // end row

    echo '<div class="row">';

    echo '<div class="col-md-6">';
    echo '<div class="cod-widget-stat-box box-confirmed"><p>';
    echo number_format($result[0]->total_confirmed, 0);
    echo '<span class="text-legend">';
    echo esc_html__( 'Confirmed', 'covid19livestats' );
    echo '</span></p></div>';
    echo '</div>'; // end col

    echo '<div class="col-md-6">';
    echo '<div class="cod-widget-stat-box box-recovered"><p>';
    echo number_format($result[0]->total_recovered, 0);
    echo '<span class="text-legend">';
    echo esc_html__( 'Recovered', 'covid19livestats' );
    echo '</span></p></div>';
    echo '</div>'; // end col

    echo '</div>'; // end row

    echo '<div class="row">';

    echo '<div class="col-md-6">';
    echo '<div class="cod-widget-stat-box box-critical"><p>';
    echo number_format($result[0]->total_critical, 0);
    echo '<span class="text-legend">';
    echo esc_html__( 'Critical', 'covid19livestats' );
    echo '</span></p></div>';
    echo '</div>'; // end col

    echo '<div class="col-md-6">';
    echo '<div class="cod-widget-stat-box box-deaths"><p>';
    echo number_format($result[0]->total_deaths, 0);
    echo '<span class="text-legend">';
    echo esc_html__( 'Deaths', 'covid19livestats' );
    echo '</span></p></div>';
    echo '</div>'; // end col

    echo '</div>'; // end row
    echo '</div>'; // end container
    echo '</div>'; // end cod-widget-wrap

    echo $args['after_widget'];
  }


  public function form( $instance ) {

    global $wpdb;
    $table_name = $wpdb->prefix . "covid19_all_countries";
    $results  = $wpdb->get_results( "SELECT id, country FROM  $table_name" );

    $title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'covid19livestats' );
    $country_id = !empty( $instance['country_id'] ) ? $instance['country_id'] : 0;
    ?>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'covid19livestats' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'country_id' ) ); ?>"><?php echo esc_html__( 'Country:', 'covid19livestats' ); ?></label>
      <select name="<?php echo esc_attr( $this->get_field_name( 'country_id' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'country_id' ) ); ?>">
        <?php
          echo '<option value="0" '. ( $country_id == 0 ? ' selected' : '' ) .'>Worldwide</option>';
          foreach( $results as $result )
          echo '<option value="'. $result->id .'" '. ( $country_id == $result->id ? ' selected' : '' ) .'>'. $result->country .'</option>';
        ?>
      </select>
    </p>
    <?php
  }

  public function update( $new_instance, $old_instance ) {

    $instance = array();
    $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['country_id'] = ( !empty( $new_instance['country_id'] ) ) ? strip_tags( $new_instance['country_id'] ) : '';

    return $instance;
  }

} // end class

$my_widget = new Covid_19_Live_Stat_Card();

?>
