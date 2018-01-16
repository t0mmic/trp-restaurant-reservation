<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       t0mmic.cz
 * @since      1.0.0
 *
 * @package    T0mmic_Reservations
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN' )){
	die;
}

class T0mmic_Reservations_Uninstaller {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function uninstall() {

		// option table cleaning
		delete_option('t0mmic_settings');
		delete_option('t0mmic_reservation');
		delete_option('widget_t0mmic-reservations');

		// for site options in Multisite
		if (is_multisite()){
			delete_site_option('t0mmic_settings');
			delete_site_option('t0mmic_reservation');
			delete_site_option('widget_t0mmic-reservations');
		}

		// posts table cleaning
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name_a = $wpdb->prefix . 'posts';
		$table_name_b = $wpdb->prefix . 'term_relationships';
		$table_name_c = $wpdb->prefix . 'postmeta';
		$wpdb->query($wpdb->delete("DELETE * FROM $table_name_a a LEFT JOIN $table_name_b b ON (a.ID = b.object_id) LEFT JOIN $table_name_c c ON (a.ID = c.post_id) WHERE a.post_content = '%t0mmic-reservation%'"));

		// trp_reservation table delete
		$table_name = $wpdb->prefix . 'trp_reservation';
		$wpdb->query("DROP TABLE IF EXIST {$wpdb->prefix}trp_reservation");

	}
}
