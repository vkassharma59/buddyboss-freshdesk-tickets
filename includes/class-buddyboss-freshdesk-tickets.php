<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wordpress.org/
 * @since      1.0.0
 *
 * @package    Wordpress_Download_Logs
 * @subpackage Wordpress_Download_Logs/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wordpress_Download_Logs
 * @subpackage Wordpress_Download_Logs/includes
 * @author     Vijay Carpenter <imdeveloper0307@gmail.com>
 */
class Wordpress_Download_Logs {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Buddyboss_Freshdesk_Tickets_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WOOCOMMERCE_DOWNLOAD_LOGS_VERSION' ) ) {
			$this->version = WOOCOMMERCE_DOWNLOAD_LOGS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'buddyboss-freshdesk-tickets';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Buddyboss_Freshdesk_Tickets_Loader. Orchestrates the hooks of the plugin.
	 * - Buddyboss_Freshdesk_Tickets_i18n. Defines internationalization functionality.
	 * - Buddyboss_Freshdesk_Tickets_Admin. Defines all hooks for the admin area.
	 * - Buddyboss_Freshdesk_Tickets_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-buddyboss-freshdesk-tickets-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-buddyboss-freshdesk-tickets-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-buddyboss-freshdesk-tickets-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-buddyboss-freshdesk-tickets-public.php';

		$this->loader = new Buddyboss_Freshdesk_Tickets_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Buddyboss_Freshdesk_Tickets_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Buddyboss_Freshdesk_Tickets_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Buddyboss_Freshdesk_Tickets_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'init', $plugin_admin, 'wpdl_downloads_cpt', 50 );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'wpdl_free_downloads_menu', 99 ); 
		$this->loader->add_action( 'admin_head', $plugin_admin, 'wpdl_free_downloads_menu_highlight' ); 
		$this->loader->add_action( 'manage_wpdl_tracked_posts_columns', $plugin_admin, 'wpdl_tracked_columns' );
		$this->loader->add_action( 'manage_wpdl_tracked_posts_custom_column', $plugin_admin, 'wpdl_tracked_columns_content', 50, 2 );
		$this->loader->add_filter( 'post_row_actions', $plugin_admin, 'wpdl_tracked_remove_quick_edit' , 10, 2 );
		$this->loader->add_filter( 'bulk_actions-edit-wpdl_tracked', $plugin_admin, 'wpdl_remove_from_bulk_actions' );

		$this->loader->add_action( 'restrict_manage_posts', $plugin_admin, 'wpdl_tracked_filters', 10 );
		$this->loader->add_action( 'parse_query', $plugin_admin, 'wpdl_tracked_parse_query' );
		
		$this->loader->add_action( 'manage_posts_extra_tablenav', $plugin_admin, 'wpdl_tracked_list_export_button' );
		$this->loader->add_action( 'init', $plugin_admin, 'wpdl_tracked_list_export_callback' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Buddyboss_Freshdesk_Tickets_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action('wp_ajax_wp-download-attachments', $plugin_public, 'wp_download_attachments_callback');
		$this->loader->add_action('wp_ajax_nopriv_wp-download-attachments', $plugin_public, 'wp_download_attachments_callback');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Buddyboss_Freshdesk_Tickets_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
