<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://covid19livestat.com
 * @since      1.0.0
 *
 * @package    covid19livestats
 * @subpackage covid19livestats/admin/partials
 */
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
<h2></h2>
<div id="poststuff" class="metabox-holder">
    <h1>Covid-19 Live Stats Lite</h1>
</div>
<?php
if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'updateStats' ) {

    covid19livestats_update_data();

    $covid19livestats_settings = get_option('covid19livestats_settings');
    $covid19livestats_settings['last_updated'] = current_time( 'timestamp' );
    update_option('covid19livestats_settings', $covid19livestats_settings);

    echo '<div class="updated fade"><p><strong>Covid-19 Live Stats Data Updated Successfully</strong></p></div>';
}

?>

<div class="metabox-holder has-right-sidebar">
<div class="meta-box-sortabless">

  <?php include 'covid19livestats-admin-sidebar.php'; ?>

	<div class="has-sidebar sm-padded">
	<div id="post-body-content" class="has-sidebar-content">
	<div class="meta-box-sortabless">

    <?php
        $covid19livestats_settings = get_option('covid19livestats_settings');
        // print_r($covid19livestats_settings);
    ?>
    <div class="postbox">
      <div class="inside">
        <center>
          <h3>Last Updated: <?php echo get_date_from_gmt( date( 'Y-m-d H:i:s', $covid19livestats_settings['last_updated'] ), 'H:i A F j, Y' ); ?></h3>

          <form action="" method="POST">
            <input type="hidden" name="action" value="updateStats" />
            <input type="submit" class="button-primary" name="updateStats" value="Update Live Stat" />
          </form>
        </center>
      </div>
    </div> <!--postbox-->


    <div class="postbox">
      <div class="inside">
        <center><h2>Shortcodes</h2></center>
      </div>
    </div> <!--postbox-->
        <br /><br />
        <table class="widefat" cellspacing="0" style="clear: none !important;">
          <tr>
            <td>
              <center>
                <h3>Covid-19 Live Stat Card</h3>
                <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) );  ?>images/covid-19-live-stat-card.jpg" class="shortcode-screenshot" alt="Shortcodes" />
                <br /><br /><br />
                <code>[covid-19-live-stat-card]</code>
                <br /><br />
                <h3>Available Options</h3>
                <br /><br />
                <code>[covid-19-live-stat-card title="YOUR TITLE HERE"]</code>
                <br /><br />
                <code>[covid-19-live-stat-card country="Australia"]</code>
                <br /><br />
                <code>[covid-19-live-stat-card title="YOUR TITLE HERE" country="Australia"]</code>
                <br /><br />
              </center>
            </td>
          </tr>
          <tr>
            <td>
              <center>
                <h3>Covid-19 Live Stat Data Table</h3>
                <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) );  ?>images/covid-19-live-stat-table.jpg" class="shortcode-screenshot" alt="Shortcodes" />
                <br /><br /><br />
                <code>[covid-19-live-stat-table]</code>
                <br /><br />
                <h3>Available Options</h3>
                <br /><br />
                <code>[covid-19-live-stat-table title="YOUR TITLE HERE"]</code>
                <br /><br />
              </center>
            </td>
          </tr>
        </table>

	</div> <!--meta-box-sortabless-->
	</div> <!--has-sidebar-content-->
	</div> <!--has-sidebar sm-padded-->

</div> <!--meta-box-sortabless-->
</div> <!--metabox-holder has-right-sidebar-->
</div>
