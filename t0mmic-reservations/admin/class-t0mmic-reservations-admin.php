<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       t0mmic.cz
 * @since      1.0.0
 *
 * @package    T0mmic_Reservations
 * @subpackage T0mmic_Reservations/admin
 */

 		require_once TRP_PATH . 'admin/partials/t0mmic-reservations-admin-display.php';

   // cell update for resevation table
   function trp_update_table(){

			global $wpdb;
			$table_name = $wpdb->prefix . 'trp_reservation';

			$field_id = $_POST['field_id'];
			$value = $_POST['value'];
			$split_data = explode('-', $field_id);
			$id = $split_data[1];
			$name = $split_data[0];

			if ($name == 'rdate'){ $value = date('Y-m-d', strtotime($value)); }
			if ($name == 'timefrom'){ $value = date('H:i', strtotime($value)); }
			if ($name == 'timeto'){ $value = date('H:i', strtotime($value)); }
			$where = array("id"=>$id);
			$udata = array($name=>$value);
			if (($name == 'status') && ($value == '1')) { $udata['disapprove'] = 0; }
			if (($name == 'disapprove') && ($value == '1')) { $udata['status'] = 0; }
			$result = $wpdb->update($table_name, $udata, $where);

			if ( false === $result ) {
					echo __("An error occurred", "t0mmic-reservations");
			} else {
					if (isset($_POST['send_email'])){
						$data = get_option('t0mmic_settings');

						if ($data['dateFormatRes'] == 'yy-mm-dd'){$date='%Y-%m-%d';} else if ($data['dateFormatRes'] == 'dd-mm-yy'){$date='%d-%m-%Y';} else {$date='%m-%d-%Y';}
						if ($data['timeFormatRes'] == '24h'){$time='%H:%i';} else {$time='%l:%i %p';}
		        $result = $wpdb->get_row("SELECT *, DATE_FORMAT(rdate, '$date') as mdate, DATE_FORMAT(timefrom, '$time') as timef, DATE_FORMAT(timeto, '$time') as timet FROM $table_name WHERE id=$id", ARRAY_A);

		        $replace = array('\"', "\'","\n");
		        $reimbursement = array('"', "'","<br style=''>");
		        $mess2 = str_replace($replace,$reimbursement,base64_decode($data['editor_second']));

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
		                       $mess2,
		                       array('date' => $result['mdate'],
																 'firstname' => $result['firstname'],
																 'surname' => $result['surname'],
																 'timeFrom' => $result['timefrom'],
																 'timeTo' => $result['timeto'],
																 'party' => $result['places'],
																 'note' => $result['note'],
																 'ip' => ''
		                       )
		        );
		        $message .= '</td></tr></tbody></table></body></html>';

		        $name = imap_8bit($data['mail_sender_name']);
		        $name = "=?utf-8?Q?".$name."?=";

		        $headers  = "From: ".$name." <".$data['toEmail'].">\r\n";
		        $headers .= "Reply-To: ".$name." <".$data['toEmail'].">\r\n";
		        $headers .= "Cc: ".$name." <".$data['toEmail'].">\r\n";
		        $headers .= "Content-type: text/html; charset=utf-8\r\n";
		        $headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";

		        if (wp_mail($result['email'], $data['mail_subject_second'] ." ". $data['toEmail'], $message, $headers)){
		          echo __("Email was sent.", "t0mmic-reservations");
		        } else {
		          echo __("Error! Email was not sent.", "t0mmic-reservations");
		        }
					} else {
						echo __("Success", "t0mmic-reservations");
					}
			}
			wp_die();
  }
	add_action('wp_ajax_trp_update_table', 'trp_update_table');


  // update options in DB
  function trp_option(){

		if (isset($_POST['switch'])){$where = $_POST['switch'];}
    switch($where){
			case 'settings':
	      $data = array(
	          'lastID'            	=> $_POST['lastID'],
	          'dateFormatRes'     	=> $_POST['dateFormatRes'],
	          'timeFormatRes'     	=> $_POST['timeFormatRes'],
	          'maxAllRes' 					=> $_POST['maxAllRes'],
	          'maxOneRes'  					=> $_POST['maxOneRes'],
	          'timeOffset'					=> $_POST['timeOffset'],
	          'headingRes'  				=> $_POST['headingRes'],
	          'timepickerTheme'   	=> $_POST['timepickerTheme'],
	          'minRes'  						=> $_POST['minRes'],
	          'dayRes'  						=> $_POST['dayRes'],
	          'minTimePeriodRes'  	=> $_POST['minTimePeriodRes'],
	          'maxTimePeriodRes'  	=> $_POST['maxTimePeriodRes'],
	          'emailRes'  		 			=> $_POST['emailRes'],
	          'statusRes'  					=> $_POST['statusRes'],
	          'firstDayRes'  				=> $_POST['firstDayRes'],
	          'cssRes'  				  	=> $_POST['cssRes'],
	          'toEmail'  						=> $_POST['toEmail'],
	          'arrayDateClosed'   	=> $_POST['arrayDateClosed'],
	          'arrayBlockEmail'   	=> $_POST['arrayBlockEmail'],
	          'blockEmail'        	=> $_POST['blockEmail'],
						'editor_first'				=> base64_encode($_POST['editor_first']),
						'editor_second'				=> base64_encode($_POST['editor_second']),
						'mail_subject_first'  => $_POST['mail_subject_first'],
						'mail_subject_second' => $_POST['mail_subject_second'],
						'mail_confirm_text' 	=> $_POST['mail_confirm_text'],
						'mail_saved_text' 	  => $_POST['mail_saved_text'],
						'mail_sender_name'		=> $_POST['mail_sender_name'],
	          );
	      $days = $_POST['weekDaysRes'];
	      foreach($days as $value) {
	         $data['weekDaysRes'] = $_POST['weekDaysRes'];
	      }
	      $timeF = $_POST['timeFromRes'];
	      foreach($timeF as $value) {
	         $value = date('H:i', strtotime($value));
	         $data['timeFromRes'] = $_POST['timeFromRes'];
	      }
	      $timeT = $_POST['timeToRes'];
	      foreach($timeT as $value) {
	         $value = date('H:i', strtotime($value));
	         $data['timeToRes'] = $_POST['timeToRes'];
	      }
				$dateDiff = $_POST['dateDiffRes'];
	      foreach($dateDiff as $value) {
					 $value = date('Y-m-d', strtotime($value));
	         $data['dateDiffRes'] = $_POST['dateDiffRes'];
	      }
				$result = update_option('t0mmic_settings', $data, true);
				break;
			case 'table':
				$data = array(
					'screen_options'  	=> $_POST['screen_options'],
					'hide_disapproved'  => $_POST['hide_disapproved']
				);
				$tbl = $_POST['table_select'];
		    foreach($tbl as $value) {
		      $data['table_select'] = $_POST['table_select'];
		    }
				$result = update_option('t0mmic_reservation', $data, true);
				break;
			}
			echo $result;

			wp_die();
  }
	add_action('wp_ajax_trp_option', 'trp_option');

  // pagination, filers and data for table reservation
  function trp_table(){

    $data = get_option('t0mmic_settings');
		$tblsett = get_option('t0mmic_reservation');

		global $wpdb;

		$table_name = $wpdb->prefix . 'trp_reservation';

		$dateFilter = isset($_GET['val']) ? $_GET['val'] : date('Y-m-d');
		if ($tblsett['hide_disapproved'] == 1) {$disapprove = 'AND disapprove=0';} else {$disapprove = '';};

		$customPage = "";

		$query = "SELECT COUNT(0) FROM $table_name WHERE rdate>='$dateFilter'";
    $numrows = $wpdb->get_var($query);

    $rowsperpage = $tblsett['screen_options'];
    $page = isset($_GET['cpage']) ? abs((int) $_GET['cpage']) : 1;
    $offset = ($page*$rowsperpage)-$rowsperpage;

		$by = isset($_GET['orderby']) ? $_GET['orderby']: "rdate";
		$order = isset($_GET['order']) ? (bool) !$_GET['order']: 1;
		$orderby = $by . " " . ($order?"asc":"desc");
    if ($data['dateFormatRes'] == 'yy-mm-dd'){$date='%Y-%m-%d';} else if ($data['dateFormatRes'] == 'dd-mm-yy'){$date='%d-%m-%Y';} else {$date='%m-%d-%Y';}
    if ($data['timeFormatRes'] == '24h'){$time='%H:%i';} else {$time='%l:%i %p';}

		$sql = $wpdb->get_results("SELECT *, DATE_FORMAT(rdate, '$date') as mdate, DATE_FORMAT(timefrom, '$time') as timef, DATE_FORMAT(timeto, '$time') as timet FROM $table_name WHERE rdate>='$dateFilter' $disapprove ORDER BY $orderby LIMIT ${offset}, ${rowsperpage}", ARRAY_N);

		if (isset($_GET['filter'])) {
      $filter = $_GET['filter'];
      $sql = $wpdb->get_results("SELECT *, DATE_FORMAT(rdate, '$date') as mdate, DATE_FORMAT(timefrom, '$time') as timef, DATE_FORMAT(timeto, '$time') as timet FROM $table_name WHERE Concat(firstname,'',surname,'',phone,'',email,'',note) LIKE '%".$filter."%' $disapprove AND rdate>='$dateFilter' ORDER BY rdate, timefrom LIMIT ${offset}, ${rowsperpage}", ARRAY_N);
    }

		if (isset($_GET['time'])) {
      $timef = date('H:i', strtotime($_GET['time']));
      $sql = $wpdb->get_results("SELECT *, DATE_FORMAT(rdate, '$date') as mdate, DATE_FORMAT(timefrom, '$time') as timef, DATE_FORMAT(timeto, '$time') as timet FROM $table_name WHERE rdate='$dateFilter' $disapprove AND timefrom<='$timef' AND timeto>='$timef' ORDER BY rdate , timefrom LIMIT ${offset}, ${rowsperpage}", ARRAY_N);
    }

		if ((isset($_GET['filter'])) && (isset($_GET['time']))) {
      $filter = $_GET['filter'];
      $timef = date('H:i', strtotime($_GET['time']));
      $sql = $wpdb->get_results("SELECT *, DATE_FORMAT(rdate, '$date') as mdate, DATE_FORMAT(timefrom, '$time') as timef, DATE_FORMAT(timeto, '$time') as timet FROM $table_name WHERE Concat(firstname,'',surname,'',phone,'',email,'',note) LIKE '%".$filter."%' $disapprove AND rdate>='$dateFilter' AND timefrom<='$timef' AND timeto>='$timef' ORDER BY rdate, timefrom LIMIT ${offset}, ${rowsperpage}", ARRAY_N);
    }

    $totalPage = ceil($numrows/$rowsperpage);

    $customPage = '<div id="trp-paginate"><span class="trp-paginate">'.__('Page', 't0mmic-reservations')." ".$page." ".__('of', 't0mmic-reservations')." ".$totalPage.'</span>'.paginate_links(array(
      'base' => add_query_arg( 'cpage', '%#%' ),
      'format' => '',
      'prev_text' => '&laquo;',
      'next_text' => '&raquo;',
      'total' => $totalPage,
      'current' => $page
    )).'</div>';
    echo $customPage;

    if ($sql){
      foreach ($sql as $result){
        	print ("<tr class='iedit format-standard'>");
					print ("<td><input id='cb-select-" . $result[0] . "' class='trp-post' type='checkbox' name='post[]' value='" . $result[0] . "'></td>");
				if ($tblsett['table_select']['rdate'] == 1 ){
        	print ("<td>" . $result[12] . "</td>");
				}
				if ($tblsett['table_select']['timefrom'] == 1 ){
	        print ("<td id='timefrom-" . $result[0] . "' class='" . $result[0] . "' contenteditable='true' name='vdata'>" . $result[13] . "</td>");
				}
				if ($tblsett['table_select']['timeto'] == 1 ){
	        print ("<td id='timeto-" . $result[0] . "' class='" . $result[0] . "' contenteditable='true' name='vdata'>" . $result[14] . "</td>");
				}
				if ($tblsett['table_select']['places'] == 1 ){
	        print ("<td id='places-" . $result[0] . "' class='" . $result[0] . "' contenteditable='true' name='vdata'>" . $result[4] . "</td>");
				}
				if ($tblsett['table_select']['firstname'] == 1 ){
	        print ("<td>" . $result[5] . "</td>");
				}
				if ($tblsett['table_select']['surname'] == 1 ){
	        print ("<td>" . $result[6] . "</td>");
				}
				if ($tblsett['table_select']['phone'] == 1 ){
	        print ("<td>" . $result[7] . "</td>");
				}
				if ($tblsett['table_select']['email'] == 1 ){
	        print ("<td id='trp-email-" . $result[0] . "'>" . $result[10] . "</td>");
				}
				if ($tblsett['table_select']['status'] == 1 ){
	        print ("<td class='trp-center'><input type='checkbox' id='status-" . $result[0] . "' class='" . $result[0] . "' name='status' value='" . $result[8] . "'" . ($result[8]==1 ? 'checked' : '') . "></td>");
				}
				if ($tblsett['table_select']['disapprove'] == 1 ){
	        print ("<td class='trp-center'><input type='checkbox' id='disapprove-" . $result[0] . "' class='" . $result[0] . "' name='disapprove' value='" . $result[9] . "'" . ($result[9]==1 ? 'checked' : '') . "></td>");
				}
				if ($tblsett['table_select']['note'] == 1 ){
					print ("<td id='note-" . $result[0] . "' class='" . $result[0] . "' contenteditable='true' name='vdata'>" . $result[11] . "</td>");
				}
        print ("</tr>");
      }
    }

  }


	// add new reservation from admin page
	function trp_update_reservation(){

			global $wpdb;
			$table_name = $wpdb->prefix . 'trp_reservation';

			// save to MYSQL
			$result = $wpdb->insert(
					$table_name,
					array('rdate'     =>  $_POST['rdate'],
								'timefrom'  =>  $_POST['timefrom'],
								'timeto'    =>  $_POST['timeto'],
								'places'    =>  $_POST['places'],
								'firstname' =>  $_POST['firstname'],
								'surname'   =>  $_POST['surname'],
								'phone'     =>  $_POST['phone'],
								'status'    =>  $_POST['status'],
								'email'     =>  $_POST['email'],
								'note'      =>  $_POST['note'],
							)
			);
			echo json_encode($result);

      wp_die();
  }
	add_action('wp_ajax_trp_update_reservation', 'trp_update_reservation');


	// bulk action on table reservation page (edit and delete multiple row)
	function trp_bulk_action(){

			global $wpdb;
			$table_name = $wpdb->prefix . 'trp_reservation';

			$id = [];
			if (!empty($_POST["post"])){
				$id=$_POST["post"];
				$id = implode(", ", $id);
			}

			$val = $_POST['value'];
			switch($val){
				case 'disapprove':
					$result = $wpdb->query("UPDATE $table_name SET disapprove=1, status=0 WHERE id IN ($id)");
					break;
				case 'status':
					$result = $wpdb->query("UPDATE $table_name SET status=1, disapprove=0 WHERE id IN ($id)");
					break;
				case 'delete':
					$result = $wpdb->query("DELETE FROM $table_name WHERE id IN ($id)");
					break;
				default:
				  break;
			}
			echo json_encode($result);

			wp_die();
	}
	add_action('wp_ajax_trp_bulk_action', 'trp_bulk_action');


/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    T0mmic_Reservations
 * @subpackage T0mmic_Reservations/admin
 * @author     Michal Tomek <t0mmic@email.cz>
 */
class T0mmic_Reservations_Admin {

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
		wp_enqueue_style( $this->plugin_name, TRP_URL . 'admin/css/t0mmic-reservations-admin.css', array(), $this->version, 'all' );
    add_action( 'wp_enqueue_style', 't0mmic_reservation' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('jquery-ui-widget');
		wp_enqueue_script( $this->plugin_name, TRP_URL . 'admin/js/t0mmic-reservations-admin.js', array( 'jquery' ), $this->version, false );
		add_action( 'wp_enqueue_scripts', 't0mmic_reservation' );

		$data = get_option('t0mmic_settings');
		$phpSettings = array(
		  'weekDaysRes'     => __('Week days', 't0mmic-reservations'),
		  'monday'          => __('monday', 't0mmic-reservations'),
		  'tuesday'         => __('tuesday', 't0mmic-reservations'),
		  'wednesday'       => __('wednesday', 't0mmic-reservations'),
		  'thursday'        => __('thursday', 't0mmic-reservations'),
		  'friday'          => __('friday', 't0mmic-reservations'),
		  'saturday'        => __('saturday', 't0mmic-reservations'),
		  'sunday'          => __('sunday', 't0mmic-reservations'),
		  'from'            => __('From', 't0mmic-reservations'),
		  'to'              => __('To', 't0mmic-reservations'),
		  'removeThis'      => __('Remove this', 't0mmic-reservations'),
			'daysett'      		=> __('Day with extra open hours.', 't0mmic-reservations'),
			'sendEmail'      	=> __('Do you want to send a confirmation email?', 't0mmic-reservations')
		);
		wp_localize_script('t0mmic-reservations', 'phpSettings', $phpSettings );
		wp_localize_script('t0mmic-reservations', 'ajax', array('url' => TRP_ADMIN_URL . 'admin-ajax.php'));
	}

  // Create the Plugin Name menu page with add_menu_page();
  public function add_admin_page() {
      add_menu_page( __('Reservation', 't0mmic-reservations'), __('Reservations', 't0mmic-reservations'), 'edit_posts', 'trp-info', 't0mmic_reservations_info', 'dashicons-calendar-alt', 25);
      add_submenu_page('trp-info', __('Info', 't0mmic-reservations'), __('Info', 't0mmic-reservations'), 'edit_posts', 'trp-info', 't0mmic_reservations_info');
      add_submenu_page('trp-info', __('Reservations overview', 't0mmic-reservations'), __('Reservations', 't0mmic-reservations'), 'edit_posts', 'trp-reservations', 't0mmic_reservations_reservations');
      add_submenu_page('trp-info', __('Settings', 't0mmic-reservations'), __('Settings', 't0mmic-reservations'), 'publish_pages', 'trp-settings', 't0mmic_settings');
  }

}
