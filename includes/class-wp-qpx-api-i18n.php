<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://costinbotez.co.uk
 * @since      1.0.0
 *
 * @package    Wp_Qpx_Api
 * @subpackage Wp_Qpx_Api/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wp_Qpx_Api
 * @subpackage Wp_Qpx_Api/includes
 * @author     Costin Botez <costibotez94@gmail.com>
 */
class Wp_Qpx_Api_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-qpx-api',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
