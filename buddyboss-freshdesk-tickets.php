<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wordpress.org/
 * @since             1.0.0
 * @package           Buddyboss_freshdesk_tickets
 *
 * @wordpress-plugin
 * Plugin Name:       Buddyboss freshdesk tickets
 * Plugin URI:        https://wordpress.org/
 * Description:       Show listing of freshdesk tickets. It's displayed in the Boddyboss profile area.
 * Version:           1.0.0
 * Author:            Vikas Sharma
 * Author URI:        https://wordpress.org/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bb-freshdesk-tickets
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BB_FRESHDESK_TICKET_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-buddyboss-freshdesk-tickets-activator.php
 */
function activate_buddyboss_freshdesk_tickets() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-buddyboss-freshdesk-tickets-activator.php';
	Buddyboss_Freshdesk_Tickets_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-buddyboss-freshdesk-tickets-deactivator.php
 */
function deactivate_buddyboss_freshdesk_tickets() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-buddyboss-freshdesk-tickets-deactivator.php';
	Buddyboss_Freshdesk_Tickets_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_buddyboss_freshdesk_tickets' );
register_deactivation_hook( __FILE__, 'deactivate_buddyboss_freshdesk_tickets' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-buddyboss-freshdesk-tickets.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_buddyboss_freshdesk_tickets() {

	$plugin = new Wordpress_Download_Logs();
	$plugin->run();

}
run_buddyboss_freshdesk_tickets();
