<?php

class Covid_19_Live_Stat_Table extends WP_Widget {

  function __construct() {

    parent::__construct(
      'covid-19-live-stat-table',
      'Covid-19 Live Stat Table'
    );

    add_action( 'widgets_init', function() {
      register_widget( 'Covid_19_Live_Stat_Table' );
    });

  }

  public $args = array(
          'before_title'  => '<h3 class="cod-widget-title">',
          'after_title'   => '</h3>',
          'before_widget' => '<div>',
          'after_widget'  => '</div>'
      );

  public function widget( $args, $instance ) {

    global $wpdb;
		$table_name = $wpdb->prefix . "covid19_all_countries";
		$results = $wpdb->get_results( "SELECT * FROM  $table_name ORDER BY confirmed DESC" );

    echo $args['before_widget'];

    if( !empty( $instance['title'] ) ) {
      echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
    }

    echo '<div class="cod-widget-wrap">';
    echo '<h3>Covid-19 Live Stats - Worldwide</h3>';
    echo '<input type="text" id="myTableSearchBox" class="form-control" placeholder="Search countries...">';
    echo '<table class="cod-widget-table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th width="30%">Country</th>';
    echo '<th class="text-confirmed">Confirmed</th>';
    echo '<th class="text-recovered">Recovered</th>';
    echo '<th class="text-critical">Critical</th>';
    echo '<th class="text-deaths">Deaths</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach( $results as $result ) {

      echo '<tr>';
      echo '<td><img src="'. covid19livestats_flag($result->country) .'" alt="'. $result->country .'" title="'. $result->country .'" class="flags" />' . $result->country . '</td>';
      echo '<td class="text-confirmed">' . number_format($result->confirmed, 0) . '</td>';
      echo '<td class="text-recovered">' . number_format($result->recovered, 0) . '</td>';
      echo '<td class="text-critical">' . number_format($result->critical, 0) . '</td>';
      echo '<td class="text-deaths">' . number_format($result->deaths, 0) . '</td>';
      echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo $args['after_widget'];
  }


  public function form( $instance ) {

    global $wpdb;
    $table_name = $wpdb->prefix . "covid19_all_countries";
    $results  = $wpdb->get_results( "SELECT id,country FROM  $table_name" );

    $title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'covid19livestats' );
    ?>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'covid19livestats' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <?php
  }

  public function update( $new_instance, $old_instance ) {

    $instance = array();
    $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['theme'] = ( !empty( $new_instance['theme'] ) ) ? strip_tags( $new_instance['theme'] ) : '';

    return $instance;
  }

} // end class

$my_widget = new Covid_19_Live_Stat_Table();

?>
