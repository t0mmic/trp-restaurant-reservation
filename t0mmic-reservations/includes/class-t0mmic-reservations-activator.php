<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/t0mmic/trp-restaurant-reservation
 * @since      1.0.0
 *
 * @package    T0mmic_Reservations
 * @subpackage T0mmic_Reservations/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    T0mmic_Reservations
 * @subpackage T0mmic_Reservations/includes
 * @author     Michal Tomek <t0mmic@email.cz>
 */
class T0mmic_Reservations_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		 global $wpdb;
		 $charset_collate = $wpdb->get_charset_collate();
		 $table_name = $wpdb->prefix . 'trp_reservation';

		 $result = $wpdb->get_var("SHOW TABLES LIKE '$table_name'");
		 if (!$result){
			$sql="CREATE TABLE $table_name (
				id int(11) NOT NULL AUTO_INCREMENT,
				rdate date NOT NULL,
				timefrom time NOT NULL,
				timeto time NOT NULL,
				places int(3) NOT NULL,
				firstname varchar(100) NOT NULL,
				surname varchar(100) NOT NULL,
				phone varchar(30) NOT NULL,
				status tinyint(1) NOT NULL,
				disapprove tinyint(1) NOT NULL,
				email varchar(200) NOT NULL,
				note varchar(500) NOT NULL,
				UNIQUE KEY id (id)
			)$charset_collate;";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
			}

			$table = $wpdb->prefix . 'options';

			$result = $wpdb->get_var("SELECT COUNT(0) FROM '$table' WHERE option_name='t0mmic_settings'");
			if (!$result){
				$data = array(
					 'lastID'           => '0',
					 'timepickerTheme'  => 'dark-hive',
					 'dateFormatRes'	=> 'yy-mm-dd',
					 'timeFormatRes'	=> '24h',
					 'maxAllRes' 		=> '20',
					 'maxOneRes'  		=> '8',
					 'timeOffset'		=> '5',
					 'headingRes'  		=> '',
					 'minRes'  			=> '30',
					 'dayRes'  			=> '30',
					 'firstDayRes'		=> '0',
					 'cssRes'			=> 'white',
					 'minTimePeriodRes' => '60',
					 'maxTimePeriodRes' => '240',
					 'emailRes'  		=> '0',
					 'statusRes'  		=> '0',
					 'toEmail'  		=> 'myemailaddress@example.com',
					 'blockEmail'		=> '0',
					 'arrayDateClosed'	=> '',
					 'arrayBlockEmail'	=> '',
					 'dateDiffRes'      => array (
					    0 => '',
					  ),
					 'mail_subject_first'  => 'Reservation request from:',
					 'mail_subject_second' => 'Reservation confirmed:',
					 'mail_confirm_text' 	=> 'Reservation has been saved and confirmed. Looking forward to your visit.',
					 'mail_saved_text' 	=> 'Reservation has been saved. We will confirm your reservation as soon as possible.',
					 'mail_sender_name'		=> 'Reservation ',
					 'editor_first'			=> 'PGhyIC8+DQo8cCBzdHlsZT1cInRleHQtYWxpZ246IGNlbnRlcjtcIj48c3BhbiBzdHlsZT1cImNvbG9yOiAjNjY2Njk5O1wiPjxzdHJvbmc+UmVzZXJ2YXRpb24gcmVxdWVzdCBvZiAkZmlyc3RuYW1lICRzdXJuYW1lPC9zdHJvbmc+PC9zcGFuPjwvcD4NCg0KDQo8aHIgLz4NCg0KPHNwYW4gc3R5bGU9XCJmb250LXNpemU6IDE0cHQ7XCI+SGVsbG8hPC9zcGFuPg0KPHNwYW4gc3R5bGU9XCJmb250LXNpemU6IDE0cHQ7XCI+IEkgbWFrZSBhIHRhYmxlIHJlc2VydmF0aW9uIG9uIHRoZSAkZGF0ZSBmcm9tICR0aW1lRnJvbSB0byAkdGltZVRvLjwvc3Bhbj4NCjxzcGFuIHN0eWxlPVwiZm9udC1zaXplOiAxNHB0O1wiPiBQYXJ0eSBzaXplIGlzICRwYXJ0eS48L3NwYW4+DQoNCjxzcGFuIHN0eWxlPVwiZm9udC1zaXplOiAxNHB0O1wiPk5vdGU6ICRub3RlPC9zcGFuPg0KPHNwYW4gc3R5bGU9XCJmb250LXNpemU6IDE0cHQ7XCI+IElQIGFkZHJlc3MgZnJvbSB3aGljaCB0aGUgcmVxdWVzdCBjYW1lOiAkaXA8L3NwYW4+DQoNCjxociAvPg0KPHAgc3R5bGU9XCJ0ZXh0LWFsaWduOiBjZW50ZXI7XCI+PHNwYW4gc3R5bGU9XCJmb250LXNpemU6IDhwdDtcIj5EbyBub3QgcmVzcG9uZCB0byB0aGlzIGVtYWlsLCBpdCBpcyBhdXRvbWF0aWNhbGx5IGdlbmVyYXRlZC48L3NwYW4+DQo8c3BhbiBzdHlsZT1cImZvbnQtc2l6ZTogOHB0O1wiPjxhIHN0eWxlPVwiY29sb3I6ICNhY2I5Y2E7IHRleHQtZGVjb3JhdGlvbjogbm9uZTtcIiBocmVmPVwiaHR0cHM6Ly9naXRodWIuY29tL3QwbW1pYy90cnAtcmVzdGF1cmFudC1yZXNlcnZhdGlvblwiPsKpIHQwbW1pYzwvYT48L3NwYW4+PC9wPg0KDQoNCjxociAvPg0KDQombmJzcDs=',
					 'editor_second' 		=> 'SGVsbG8hDQoNCllvdXIgcmVzZXJ2YXRpb24gb24gJGRhdGUgZnJvbSAkdGltZUZyb20gdW50aWwgJHRpbWVUbyBmb3IgJHBhcnR5IHBlcnNvbnMgd2FzIGFwcHJvdmVkLg0KDQpXZSBhcmUgbG9va2luZyBmb3J3YXJkIHRvIHlvdXIgdmlzaXQuDQoNCkJlc3QgcmVnYXJkcywNClQwbW1pYw==',
					 'weekDaysRes'		=> array (
						    0 =>
						    array (
						      0 => '1',
						      1 => '1',
						      2 => '1',
						      3 => '1',
						      4 => '1',
						      5 => '1',
						      6 => '1',
						    ),
						  ),
					 'timeFromRes'			=> array(
						 0	=>	'10:00'
					 ),
					 'timeToRes'				=> array(
						 0	=>	'21:00'
					 )
			 );
			 update_option('t0mmic_settings', $data, true);
		 }

		 $result = $wpdb->get_var("SELECT COUNT(0) FROM '$table' WHERE option_name='t0mmic_reservation'");
		 if (!$result){
			 $data = array (
				  'screen_options' 		=> '20',
				  'hide_disapproved' 	=> '0',
				  'table_select' 		=>
				  array (
					'rdate' 			=> '1',
					'timefrom' 			=> '1',
					'timeto' 			=> '1',
					'places' 			=> '1',
					'firstname' 		=> '0',
					'surname' 			=> '1',
					'phone' 			=> '1',
					'email' 			=> '0',
					'status' 			=> '1',
					'disapprove' 		=> '0',
					'note' 				=> '1',
				  ),
			 );
			 update_option('t0mmic_reservation', $data, true);
		 }
	}
}
