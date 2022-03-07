<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://wordpress.org/
 * @since      1.0.0
 *
 * @package    Wordpress_Download_Logs
 * @subpackage Wordpress_Download_Logs/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wordpress_Download_Logs
 * @subpackage Wordpress_Download_Logs/includes
 * @author     Vijay Carpenter <imdeveloper0307@gmail.com>
 */
class Buddyboss_Freshdesk_Tickets_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'buddyboss-freshdesk-tickets',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
