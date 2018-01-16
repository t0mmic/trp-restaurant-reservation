<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/t0mmic/trp-restaurant-reservation
 * @since      1.0.0
 *
 * @package    T0mmic_Reservations
 * @subpackage T0mmic_Reservations/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    T0mmic_Reservations
 * @subpackage T0mmic_Reservations/includes
 * @author     Michal Tomek <t0mmic@email.cz>
 */
class T0mmic_Reservations_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			't0mmic-reservations',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}
}
