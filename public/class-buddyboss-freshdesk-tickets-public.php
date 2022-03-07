<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wordpress.org/
 * @since      1.0.0
 *
 * @package    Wordpress_Download_Logs
 * @subpackage Wordpress_Download_Logs/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wordpress_Download_Logs
 * @subpackage Wordpress_Download_Logs/public
 * @author     Vijay Carpenter <imdeveloper0307@gmail.com>
 */
class Buddyboss_Freshdesk_Tickets_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Buddyboss_Freshdesk_Tickets_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Buddyboss_Freshdesk_Tickets_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/buddyboss-freshdesk-tickets-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Buddyboss_Freshdesk_Tickets_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Buddyboss_Freshdesk_Tickets_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/buddyboss-freshdesk-tickets-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->plugin_name, 'wdl_params', 
		    array(
		    	'ajax_url' => admin_url('admin-ajax.php'),
		      	'site_url' => get_site_url(),		      	
		    )
	  	);
	}

	public function wp_download_logs($attachment_id, $file_name) {

		$title = '';
		$href_link = '';

		if (is_singular()) {
			global $post;
			$title = get_the_title($post->ID);
		} else {
			if ( is_front_page() && is_home() ) {
				$title = 'Home';
			} elseif (is_home()) {
				$title = get_the_title(get_option('page_for_posts', true));
			} elseif (is_404()) {
				$title = 'This page doesn\'t seem to exist.';
			} elseif (is_search()) {
				$title = 'Search Results for: '.get_search_query();
			} elseif (class_exists( 'WooCommerce' ) && is_shop()) {
				$title = woocommerce_page_title(false);
			} elseif (is_archive()) {
				$title = get_the_archive_title();
			}
		}

		if ($attachment_id != '') {

			$attachment = wp_get_attachment_url($attachment_id);

			if ($file_name == '') {
				$file_name = 'Download';
			}

			if ($attachment != '') {
				$href_link =  "<a href='".$attachment."' class='button button-primary wp-download-lgs' data-media_id='".$attachment_id."' data-page_name='".$title."' data-file_name='".$file_name."' download>Download</a>";
			}
		} 

		return $href_link;
	}

	public function wp_download_attachments_callback() {
		$response = array('error' => false);
		if (isset($_REQUEST['media_id']) && $_REQUEST['media_id'] > 0) {

			$current_user_id = get_current_user_id();
			$user_email = '';
			$user_fullname = 'Guest';

			if ($current_user_id > 0) {
				$user = get_user_by( 'ID', $current_user_id );
				if(is_object($user) && !empty($user)) {
					$user_fullname = $user->first_name.' '.$user->last_name;
					$user_email    = $user->user_email;

					if ($user_fullname != '') {
						$user_fullname = $user->display_name;
					}
				}
			}

			$post_information = array(
				'post_type'    => 'wpdl_tracked',
				'post_title'   => 'Free Download: '.$_REQUEST['file_name'],
				'post_content' => 'Download',
				'post_status'  => 'publish',
				'meta_input'   => array(
					'wpdl_user_id' => $current_user_id,
					'wpdl_user_email' => $user_email,
					'wpdl_user_fullname' => $user_fullname,
					'wpdl_user_ip' => (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1',
					'wpdl_page_name' => $_REQUEST['page_name'],
					'wpdl_download_files' => wp_get_attachment_url($_REQUEST['media_id']),
					'wpdl_download_file_name' => $_REQUEST['file_name']
				)
			);

			$post_id = wp_insert_post( $post_information );

			if ($post_id > 0) {
				$response['message'] = 'Data inserted successfully.';
			} else {
				$response['error'] = 'Data not inserted, please try again later!';
			}
		} else {
			$response['error'] = 'Validation Error: Requested data not found!';
		}

		wp_send_json($response);
	}
}
