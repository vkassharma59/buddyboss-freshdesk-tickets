<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wordpress.org/
 * @since      1.0.0
 *
 * @package    Wordpress_Download_Logs
 * @subpackage Wordpress_Download_Logs/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wordpress_Download_Logs
 * @subpackage Wordpress_Download_Logs/admin
 * @author     Vijay Carpenter <imdeveloper0307@gmail.com>
 */
class Buddyboss_Freshdesk_Tickets_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/buddyboss-freshdesk-tickets-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/buddyboss-freshdesk-tickets-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function wpdl_downloads_cpt() {
		/**
		 * Tracked downloads custom post type (reporting downloads, download limits)
		 */
		$wpdl_tracked_downloads_labels = array(
			'name'                  => __( 'Download Log', 'wpdl' ),
			'singular_name'         => __( 'Download Log', 'wpdl' ),
			'menu_name'             => __( 'Download Logs', 'wpdl' ),
			'name_admin_bar'        => __( 'Download Logs', 'wpdl' ),
			'archives'              => __( 'Download Logs', 'wpdl' ),
			'parent_item_colon'     => __( 'Parent Item:', 'wpdl' ),
			'all_items'             => __( 'Download Logs', 'wpdl' ),
			'add_new_item'          => __( 'Add New Download Log', 'wpdl' ),
			'add_new'               => __( 'Add New', 'wpdl' ),
			'new_item'              => __( 'New Download Log', 'wpdl' ),
			'edit_item'             => __( 'Free Download', 'wpdl' ),
			'update_item'           => __( 'Update Download Log', 'wpdl' ),
			'view_item'             => __( 'View Download Log', 'wpdl' ),
			'search_items'          => __( 'Search Download Logs', 'wpdl' ),
			'not_found'             => __( 'Not found', 'wpdl' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'wpdl' ),
			'featured_image'        => __( 'Featured Image', 'wpdl' ),
			'set_featured_image'    => __( 'Set featured image', 'wpdl' ),
			'remove_featured_image' => __( 'Remove featured image', 'wpdl' ),
			'use_featured_image'    => __( 'Use as featured image', 'wpdl' ),
			'insert_into_item'      => __( 'Insert into Download Log', 'wpdl' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Download Log', 'wpdl' ),
			'items_list'            => __( 'Download Logs list', 'wpdl' ),
			'items_list_navigation' => __( 'Download Logs list navigation', 'wpdl' ),
			'filter_items_list'     => __( 'Filter Download Logs list', 'wpdl' ),
		);
		$wpdl_tracked_downloads_rewrite = array(
			'slug'                  => 'tracked-downloads',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);

		$wpdl_tracked_downloads_capabilities = array(
			'edit_post'          => 'update_core',
			'read_post'          => 'update_core',
			'delete_post'        => 'update_core',
			'edit_posts'         => 'update_core',
			'edit_others_posts'  => 'update_core',
			'delete_posts'       => 'update_core',
			'publish_posts'      => 'update_core',
			'read_private_posts' => 'update_core',
			'create_posts' => false
		);

		$wpdl_tracked_downloads_supports = array(
			'title',
			'content',
			'author'
		);

		$wpdl_tracked_downloads_args = array(
			'label'                 => __( 'Download Log', 'wpdl' ),
			'description'           => __( 'Download Logs', 'wpdl' ),
			'labels'                => apply_filters( 'wpdl_downloads_labels', $wpdl_tracked_downloads_labels ),
			'supports'              => array( 'title', 'author', 'custom-fields' ),
			'hierarchical'          => false,
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => false,
			'show_in_admin_bar'     => false,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => true,
			'publicly_queryable'    => false,
			'capability_type'       => 'page',
			//'capabilities'          => apply_filters( 'wpdl_downloads_capabilities', $wpdl_tracked_downloads_capabilities ),
			'capabilities' => array( 'create_posts' => false ),
			'rewrite'               => apply_filters( 'wpdl_downloads_rewrite', $wpdl_tracked_downloads_rewrite ),
			'map_meta_cap' => true
		);
		register_post_type( 'wpdl_tracked', apply_filters( 'wpdl_downloads_args', $wpdl_tracked_downloads_args ) );
	}

	public function wpdl_free_downloads_menu() {

		add_menu_page(
	        __( 'Download Log', 'textdomain' ),
	        'Download Logs',
	        'manage_options',
	        'edit.php?post_type=wpdl_tracked',
	        '',
	        '',
	        6
	    );
	}

	/**
	 * Keep menu open.
	 */
	function wpdl_free_downloads_menu_highlight() {
		global $current_screen, $parent_file, $submenu_file;
		
		$base = $current_screen->base;
		$post_type = $current_screen->post_type;

		if ( $base == 'post' ) {
			if ( 'wpdl_tracked' == $post_type ) {
				$parent_file = 'wordpress';
				$submenu_file = 'edit.php?post_type=wpdl_tracked';
				return;
			}
		}
	}

	function wpdl_tracked_columns($columns) {
		unset( $columns['title'] );
		unset( $columns['date'] );
		unset( $columns['author'] );

		$columns['wpdl_tracked_page_column'] = 'Page';
		$columns['wpdl_tracked_attachment']  = 'File';
		$columns['wpdl_tracked_user']        = 'User';
		$columns['wpdl_tracked_ip_column']   = 'IP Address';
		$columns['wpdl_tracked_date_column'] = 'Date';

		$customOrder = array( 'cb', 'wpdl_tracked_page_column', 'wpdl_tracked_attachment', 'wpdl_tracked_user', 'wpdl_tracked_ip_column', 'wpdl_tracked_date_column' );

		# return a new column array to wordpress.
		# order is the exactly like you set in $customOrder.
		foreach ($customOrder as $colname) {
			$new_cols[$colname] = $columns[$colname];
		}
		
		return $new_cols;
	}

	function wpdl_tracked_columns_content( $column_name, $post_id ) {
		if ( $column_name == 'wpdl_tracked_page_column' ) {

			echo get_post_meta( $post_id, 'wpdl_page_name', true );
		}

		if ( $column_name == 'wpdl_tracked_attachment' ) {

			echo '<a target="_blank" href="'.get_post_meta( $post_id, 'wpdl_download_files', true).'" class="row-title">'.get_post_meta($post_id, 'wpdl_download_file_name', true).'</a>';
		}

		if ( $column_name == 'wpdl_tracked_user' ) {
			$author_id = get_post_meta( $post_id, 'wpdl_user_id', true );
			if ( $author_id ) {
				echo '<a href="edit.php?post_type=wpdl_tracked&author=' . $author_id . '">' . get_the_author_meta( 'display_name' , $author_id ) . '</a>';
			} else {
				echo '<a href="edit.php?post_type=wpdl_tracked&author=-1">Guest</a>';
			}
		}

		if ( $column_name == 'wpdl_tracked_ip_column' ) {

			echo get_post_meta($post_id, 'wpdl_user_ip', true);
		}

		if ( $column_name == 'wpdl_tracked_date_column' ) {
			echo get_the_date( 'Y/m/d' );
		}
	}

	function wpdl_tracked_remove_quick_edit( $actions, $post ) {
		if ( $post->post_type == 'wpdl_tracked' ) {
			unset( $actions['inline hide-if-no-js'] );
			unset( $actions['edit'] );
		}
		return $actions;
	}

    function wpdl_remove_from_bulk_actions($actions){
        unset( $actions[ 'edit' ] );
        return $actions;
    }

    function wpdl_tracked_filters() {
    	global $wpdb, $table_prefix;
        $post_type = (isset($_GET['post_type'])) ? $_GET['post_type'] : 'post';
        if ($post_type == 'wpdl_tracked'){
        
            $pageValues= $fileValues = $userValues = array();
            $query_pages = $wpdb->get_results("SELECT meta_value as pages from ".$table_prefix."posts p
                    LEFT join ".$table_prefix."postmeta pm ON pm.post_id = p.ID WHERE p.post_type='".$post_type."' AND meta_key = 'wpdl_page_name' group by pages");
            foreach ($query_pages as &$data){
                $pageValues[$data->pages] = $data->pages;
            }

            $query_files = $wpdb->get_results("SELECT meta_value as attachments from ".$table_prefix."posts p
                    LEFT join ".$table_prefix."postmeta pm ON pm.post_id = p.ID WHERE p.post_type='".$post_type."' AND meta_key = 'wpdl_download_file_name' group by attachments");
            foreach ($query_files as &$data){
                $fileValues[$data->attachments] = $data->attachments;
            }

            $query_users = $wpdb->get_results("SELECT meta_value as users from ".$table_prefix."posts p
                    LEFT join ".$table_prefix."postmeta pm ON pm.post_id = p.ID WHERE p.post_type='".$post_type."' AND meta_key = 'wpdl_user_fullname' group by users");
            foreach ($query_users as &$data){
                $userValues[$data->users] = $data->users;
            }
            ?>
            <select name="wpdl_pagename" id="wpdl_pagename">
				<option value="">All Pages</option>
                <?php 
                $current_pagename = isset($_GET['wpdl_pagename'])? $_GET['wpdl_pagename'] : '';
                foreach ($pageValues as $label => $value) {
                    printf(
                        '<option value="%s"%s>%s</option>',
                        $value,
                        $value == $current_pagename? ' selected="selected"':'',
                        $label
                    );
                }
                ?>
            </select>

            <select name="wpdl_attachment" id="wpdl_attachment">
				<option value="">All Files</option>
                <?php 
                $current_attachment = isset($_GET['wpdl_attachment'])? $_GET['wpdl_attachment'] : '';
                foreach ($fileValues as $label => $value) {
                    printf(
                        '<option value="%s"%s>%s</option>',
                        $value,
                        $value == $current_attachment? ' selected="selected"':'',
                        $label
                    );
                }
                ?>
            </select>

            <select name="wpdl_users" id="wpdl_users">
				<option value="">All Users</option>
                <?php 
                $current_users = isset($_GET['wpdl_users'])? $_GET['wpdl_users'] : '';
                foreach ($userValues as $label => $value) {
                    printf(
                        '<option value="%s"%s>%s</option>',
                        $value,
                        $value == $current_users? ' selected="selected"':'',
                        $label
                    );
                }
                ?>
            </select>
            <?php
        }
	}

	function wpdl_tracked_parse_query($query) {
    	global $pagenow;
        $post_type = (isset($_GET['post_type'])) ? $_GET['post_type'] : 'post';

        if ($post_type == 'wpdl_tracked' && $pagenow=='edit.php') {

    		$meta_query = array();
        	if (isset($_GET['wpdl_pagename']) && $_GET['wpdl_pagename'] != '') {
        		$meta_query[] = array(
                    'key'     => 'wpdl_page_name',
                    'value'   => $_GET['wpdl_pagename'],
                    'compare' => '='
                );
        	}
	        
	        if (isset($_GET['wpdl_attachment']) && $_GET['wpdl_attachment'] != '') {
	        	$meta_query[] = array(
                    'key'     => 'wpdl_download_file_name',
                    'value'   => $_GET['wpdl_attachment'],
                    'compare' => '='
                );
	        }

	        if (isset($_GET['wpdl_users']) && $_GET['wpdl_users'] != '') {
	        	$meta_query[] = array(
                    'key'     => 'wpdl_user_fullname',
                    'value'   => $_GET['wpdl_users'],
                    'compare' => '='
                );
	        }

	        if (!empty($meta_query)) {
	        	$query->set('meta_query', $meta_query);
	        }
        }

        return $query;
	}

	public function wpdl_tracked_list_export_button($which) {
		global $typenow;
	    if ( 'wpdl_tracked' === $typenow && 'top' === $which ) {
	        ?>
	        <input type="submit" name="export_wpdl_tracked" class="button button-primary" value="<?php _e('Export CSV'); ?>" />
	        <?php
	    }
	}

	public function wpdl_tracked_list_export_callback() {
		if(isset($_GET['export_wpdl_tracked'])) {
	        $arg = array(
	            'post_type'      => 'wpdl_tracked',
	            'post_status'    => 'publish',
	            'posts_per_page' => -1,
	        );
	  
	        global $post;
	        $arr_post = get_posts($arg);
	        if ($arr_post) {
	            header('Content-type: text/csv');
	            header('Content-Disposition: attachment; filename="wp-wpdl-tracked.csv"');
	            header('Pragma: no-cache');
	            header('Expires: 0');
	  
	            $file = fopen('php://output', 'w');
	            fputcsv($file, array('Pages', 'Files Name', 'File Links', 'User Name', 'User Email', 'IP Address', 'Date'));
	  
	            foreach ($arr_post as $post) {
	                setup_postdata($post);

	                $row = array(
	                		get_post_meta($post->ID, 'wpdl_page_name', true),
	                		get_post_meta($post->ID, 'wpdl_download_file_name', true),
	                		get_post_meta($post->ID, 'wpdl_download_files', true),
	                		get_post_meta($post->ID, 'wpdl_user_fullname', true),
	                		get_post_meta($post->ID, 'wpdl_user_email', true),
	                		get_post_meta($post->ID, 'wpdl_user_ip', true),
	                		get_the_date('Y/m/d')
	                	);     	  
	                fputcsv($file, $row);
	            }
	            exit();
	        }
	    }
	}
}
