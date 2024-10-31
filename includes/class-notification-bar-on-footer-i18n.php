<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.topinfosoft.com/about
 * @since      1.0.0
 *
 * @package    Notification_Bar_On_Footer
 * @subpackage Notification_Bar_On_Footer/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Notification_Bar_On_Footer
 * @subpackage Notification_Bar_On_Footer/includes
 * @author     Top Infosoft <topinfosoft@gmail.com>
 */
class Notification_Bar_On_Footer_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'notification-bar-on-footer',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
