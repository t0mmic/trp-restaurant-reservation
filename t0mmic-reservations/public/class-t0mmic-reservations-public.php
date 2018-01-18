<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/t0mmic/trp-restaurant-reservation
 * @since      1.0.0
 *
 * @package    T0mmic_Reservations
 * @subpackage T0mmic_Reservations/public
 */

  function t0mmic_reservation_table(){

   $data = get_option('t0mmic_settings');

       $FormDate 		  	= $_POST['trp-date'];
       $FormTimeF 		 	= $_POST['timepickerFrom'];
       $FormTimeR 		 	= $_POST['resTimeRes'];
       $FormPlaces 	  	= $_POST['placesRes'];
       $FormPhone 		  = $_POST['phoneRes'];
       $FormFirstname 	= sanitize_text_field($_POST['firstnameRes']);
       $FormSurname 		= sanitize_text_field($_POST['surnameRes']);
       $FormText 			  = sanitize_text_field($_POST['textRes']);
       $FormEmail			  = sanitize_email($_POST['emailRes']);
       $FormStatus 			= $data['statusRes'];
       $arrayBlockEmail	= explode(',', $data['arrayBlockEmail']);

       $timeFrom = date("H:i", strtotime($FormTimeF));
       $timeTo = date("H:i", strtotime('+ '.$FormTimeR.' minutes', strtotime($FormTimeF)));
       if ($data['timeFormatRes'] == '12h'){
         $timeToEmail = date("g:i A", strtotime('+ '.$FormTimeR.' minutes', strtotime($FormTimeF)));
       } else {
         $timeToEmail = $timeTo;
       }

       // control if place is still empty
       global $wpdb;
       $table_name = $wpdb->prefix . 'trp_reservation';
       $FormDate = date("Y-m-d", strtotime($FormDate));
       $result = $wpdb->get_row("SELECT SUM(places) as places FROM $table_name WHERE rdate='$FormDate' AND timefrom<='$timeTo' AND timeto>='$FormTimeF'", ARRAY_A);

       if ($result===null){
         $result['places'] = 0;
       }

       if (($data['maxAllRes'] - $result['places'] - $FormPlaces) >= 0){

         if ($data['arrayBlockEmail'] != ""){
           if (((in_array($FormEmail, $arrayBlockEmail)) || (in_array($FormPhone, $arrayBlockEmail))) && ($data['blockEmail'] == 0)){
             $FormStatus = 0;
             $FormText =  __("Verify by phone!!!", "t0mmic-reservations") . ' ' . $FormText;
           } else if (((in_array($FormEmail, $arrayBlockEmail)) || (in_array($FormPhone, $arrayBlockEmail))) && ($data['blockEmail'] == 1)){
             echo __("Sorry, you have to reserved a place by phone.", "t0mmic-reservations");
             goto next;
           }
         }

         // send email
         if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
           $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
         } else {
           $ip = $_SERVER['REMOTE_ADDR'];
         }

         $replace = array('\"', "\'","\n");
         $reimbursement = array('"', "'","<br style=''>");
         $mess1 = str_replace($replace,$reimbursement,base64_decode($data['editor_first']));
         if ($FormStatus == 1){$text=$FormText.'<br style="" />'.$data['mail_confirm_text'];} else {$text = $FormText;}

         function replaceVariables($template, $variables) {
            return preg_replace_callback(
                '~\$([a-z_][a-z0-9_]*|\$)~i',
                function ($match) use ($variables) {
                    if ($match[1] == '$') {
                        return '$';
                    }
                    return $variables[$match[1]];
                },
                $template
            );
         }

         $message  = '<html><head></head><body style="margin: 0px; padding: 0px; height: auto;"><table style="margin: 0px;"><tbody><tr><td>';
         $message .= replaceVariables(
                        $mess1,
                        array('date' => $FormDate,
                              'firstname' => $FormFirstname,
                              'surname' => $FormSurname,
                              'timeFrom' => $FormTimeF,
                              'timeTo' => $timeToEmail,
                              'party' => $FormPlaces,
                              'note' => $text,
                              'ip' => $ip
                        )
         );
         $message .= '</td></tr></tbody></table></body></html>';


         $name = $FormFirstname." ".$FormSurname;

         if($FormEmail == ""){
           $headers  = "From: \"".$name."\" <".$data['toEmail'].">\r\n";
         } else {
           $headers  = "From: \"".$name."\" <".$FormEmail.">\r\n";
           $headers .= "Reply-To: \"".$name."\" <".$FormEmail.">\r\n";
           $headers .= "Cc: \"".$name."\" <".$FormEmail.">\r\n";
         }
         $headers .= "Content-type: text/html; charset=utf-8\r\n";
         $headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";

         // save to MYSQL
         $result = $wpdb->insert(
             $table_name,
             array('rdate'     =>  $FormDate,
                   'timefrom'  =>  $FormTimeF,
                   'timeto'    =>  $timeTo,
                   'places'    =>  $FormPlaces,
                   'firstname' =>  $FormFirstname,
                   'surname'   =>  $FormSurname,
                   'phone'     =>  $FormPhone,
                   'status'    =>  $FormStatus,
                   'email'     =>  $FormEmail,
                   'note'      =>  $FormText,
                 )
         );
         if ( false === $result ) {
           echo __("An error occurred", "t0mmic-reservations");
         } else {
           if (wp_mail($data['toEmail'], $data['mail_subject_first'] ." ". $FormEmail, $message, $headers)){
             if ($FormStatus == 1){
               echo $data['mail_confirm_text'];
             } else {
               echo $data['mail_saved_text'];
             }
           } else {
             echo __("An error occurred. Reservation has been saved, but email was not sent.", "t0mmic-reservations");
           }
         }

       } else {
         echo __("We're sorry, but someone made a booking faster.", "t0mmic-reservations");
       } // end if control
       next:  wp_die();
 } if (is_admin()){
 add_action('wp_ajax_nopriv_t0mmic_reservation_table', 't0mmic_reservation_table');
 add_action('wp_ajax_t0mmic_reservation_table', 't0mmic_reservation_table');}

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    T0mmic_Reservations
 * @subpackage T0mmic_Reservations/public
 * @author     Michal Tomek <t0mmic@email.cz>
 */

class T0mmic_Reservations_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

    require_once TRP_PATH . 'public/partials/t0mmic-reservations-public-display.php';
    add_shortcode( 't0mmic_reservation', 't0mmic_reservation_public_page' );

	}

  /**
   * Register the JavaScript for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts() {
    wp_enqueue_script('t0mmic-reservations', TRP_URL . 'public/js/t0mmic-reservations-public.js', array('jquery','json2'), $this->version, false);
    add_action('wp_enqueue_scripts', 't0mmic_reservation');

    $data = get_option('t0mmic_settings');
    $phpSettings = array(
        'dateFormatRes'   => $data['dateFormatRes'],
        'timeFormatRes'   => $data['timeFormatRes'],
        'maxAllRes' 			=> $data['maxAllRes'],
        'maxOneRes'  			=> $data['maxOneRes'],
        'timeOffset'			=> $data['timeOffset'],
        'headingRes'  		=> $data['headingRes'],
        'minRes'  				=> $data['minRes'],
        'dayRes'  				=> $data['dayRes'],
        'minTimePeriodRes'=> $data['minTimePeriodRes'],
        'maxTimePeriodRes'=> $data['maxTimePeriodRes'],
        'emailRes'  		 	=> $data['emailRes'],
        'statusRes'  			=> $data['statusRes'],
        'toEmail'  				=> $data['toEmail'],
        'weekDaysRes'     => $data['weekDaysRes'],
        'timeFromRes'		  => $data['timeFromRes'],
        'timeToRes'			  => $data['timeToRes'],
        'arrayDateClosed' => $data['arrayDateClosed'],
        'dateDiffRes'     => $data['dateDiffRes'],
        'firstDayRes'     => $data['firstDayRes'],
        'closed'          => __('Closed','t0mmic-reservations'),
        'fail'            => __("Fail. Please try again later.", "t0mmic-reservations"),
        'occupied'        => __("Selected time is not empty. See graph. Green shows free times under the same conditions.", "t0mmic-reservations"),
        'url'             => TRP_ADMIN_URL . 'admin-ajax.php'
    );
    wp_localize_script('t0mmic-reservations', 'phpSettings', $phpSettings);
  }


	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
    $data = get_option('t0mmic_settings');
		wp_enqueue_style( 't0mmic-reservations-public', TRP_URL . 'public/css/t0mmic-reservations-public-'.$data['cssRes'].'.css', array(), $this->version, 'all' );
    add_action( 'wp_enqueue_style', 't0mmic_reservation' );
	}

}

// widget functionality
class T0mmic_Reservations_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			't0mmic-reservations',
			__('TRP Reservation', 't0mmic-reservations'),
			array('description' => __('Reservation form.', 't0mmic-reservations'))
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $args['before_widget'];
		if (!empty($title)){
			echo $args['before_title'] . $title . $args['after_title'];
		}
		echo t0mmic_reservation_public_page();
		echo $args['after_widget'];
	}

	function update($new_instance, $old_instance){
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		return $instance;
	}

	public function form($instance){
		if (isset($instance['title'])){
			$title = $instance['title'];
		}
		else {
			$title = __('New title', 't0mmic-reservations');
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php __('Title:', 't0mmic-reservations'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<?php
	}

}
function t0mmic_reservation_register_widgets() {
	register_widget( 'T0mmic_Reservations_Widget' );
}
add_action( 'widgets_init', 't0mmic_reservation_register_widgets' );

// Load the datepicker script.
function wp_enqueue_datepicker() {
  $data = get_option('t0mmic_settings');
  wp_enqueue_script( 'jquery-ui-datepicker' );

  wp_register_style( 'jquery-ui', 'http://code.jquery.com/ui/1.12.1/themes/'.$data["timepickerTheme"].'/jquery-ui.css' );
  wp_enqueue_style( 'jquery-ui' );
}
add_action( 'wp_enqueue_scripts', 'wp_enqueue_datepicker' );

// Ajax - occupancy from mysql
function t0mmic_reservation_ajax(){

    $data = get_option('t0mmic_settings');

    $selDate     = date("Y-m-d", strtotime($_POST["datepicker"]));
    $selTimeFrom = date("H:i", strtotime($_POST["timepicker"]));
    $selTimeTo   = date("H:i", strtotime('+ '.$_POST["minutes"].' minutes', strtotime($_POST["timepicker"])));
    $open        = $_POST["timeval"];
    $frTime      = date("H:i", strtotime($open[0]));
    $toTime      = date("H:i", strtotime($open[count($open)-1]));
    $openFrom    = explode(':', $frTime);
    $openFromMin = ($openFrom[0] * 60 + $openFrom[1]);
    $openTo      = explode(':', $toTime);
    $openToMin   = ($openTo[0] * 60 + $openTo[1]);

    global $wpdb;
    $table_name = $wpdb->prefix . 'trp_reservation';

    $result = $wpdb->get_row("SELECT SUM(places) as places FROM $table_name WHERE rdate='$selDate' AND disapprove=0 AND timefrom<='$selTimeTo' AND timeto>='$selTimeFrom'", ARRAY_A);

    if ($result===null){
      $result['places'] = 0;
    } else {
      $dataTime = array("places" => $result['places']);
    }

    if (($data['maxAllRes'] - $result['places'] - $_POST["places"]) < 0){
      for ($i = $openFromMin; $i <= $openToMin; $i+=$data['minRes']){
        $selTimeFrom = floor($i/60).':'.$i%60;
        $selTimeTo = date("H:i", strtotime('+ '.$_POST["minutes"].' minutes', strtotime($selTimeFrom)));
        $result = $wpdb->get_row("SELECT SUM(places) as places FROM $table_name WHERE rdate='$selDate' AND disapprove=0 AND timefrom<='$selTimeTo' AND timeto>='$selTimeFrom'", ARRAY_A);
        array_push($dataTime, $result['places']);
      }
      echo json_encode($dataTime);
    } else {
      echo json_encode($result);
    }
    wp_die();

} if (is_admin()){
add_action('wp_ajax_nopriv_t0mmic_reservation_ajax', 't0mmic_reservation_ajax');
add_action('wp_ajax_t0mmic_reservation_ajax', 't0mmic_reservation_ajax');}
