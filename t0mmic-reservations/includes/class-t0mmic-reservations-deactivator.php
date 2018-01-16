<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/t0mmic/trp-restaurant-reservation
 * @since      1.0.0
 *
 * @package    T0mmic_Reservations
 * @subpackage T0mmic_Reservations/includes
 */

  
/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    T0mmic_Reservations
 * @subpackage T0mmic_Reservations/includes
 * @author     Michal Tomek <t0mmic@email.cz>
 */
class T0mmic_Reservations_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		remove_all_shortcodes();

	}

}
