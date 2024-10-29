<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ays-pro.com
 * @since      1.0.0
 *
 * @package    Advanced_Related_Posts
 * @subpackage Advanced_Related_Posts/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Advanced_Related_Posts
 * @subpackage Advanced_Related_Posts/admin
 * @author     Advanced Related Posts Team <info@ays-pro.com>
 */
class Advanced_Related_Posts_Admin {

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
	 * The capability of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $capability    The capability for users access to this plugin.
	 */
    private $capability;

    /**
	 * The settings object of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $settings_obj    The settings object of this plugin.
	 */
    private $settings_obj;

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
	public function enqueue_styles( $hook_suffix ) {
		wp_enqueue_style($this->plugin_name . '-admin', plugin_dir_url(__FILE__) . 'css/admin.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name . '-sweetalert-css', ADVANCED_RELATED_POSTS_PUBLIC_URL . '/css/advanced-related-posts-sweetalert2.min.css', array(), $this->version, 'all');

        if (false === strpos($hook_suffix, $this->plugin_name))
            return;

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Advanced_Related_Posts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Advanced_Related_Posts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        wp_enqueue_style('wp-color-picker');
		wp_enqueue_style( $this->plugin_name . '-banner', plugin_dir_url(__FILE__) . 'css/banner.css', array(), $this->version, 'all');
		wp_enqueue_style( $this->plugin_name . '-bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
        wp_enqueue_style( $this->plugin_name . '-font-awesome', plugin_dir_url(__FILE__) . 'css/advanced-related-posts-font-awesome.css', array(), $this->version, 'all');
        wp_enqueue_style( $this->plugin_name . '-font-awesome-icons', plugin_dir_url(__FILE__) . 'css/advanced-related-posts-font-awesome-icons.css', array(), $this->version, 'all');
        wp_enqueue_style( $this->plugin_name . '-select2', ADVANCED_RELATED_POSTS_PUBLIC_URL .  '/css/advanced-related-posts-select2.min.css', array(), $this->version, 'all');

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/advanced-related-posts-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook_suffix ) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Advanced_Related_Posts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Advanced_Related_Posts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        if (false !== strpos($hook_suffix, "plugins.php")){
            wp_enqueue_script( $this->plugin_name . '-sweetalert-js', ADVANCED_RELATED_POSTS_PUBLIC_URL . '/js/advanced-related-posts-sweetalert2.all.min.js', array('jquery'), $this->version, true );
            wp_enqueue_script(  $this->plugin_name . '-admin', plugin_dir_url(__FILE__) . 'js/admin.js', array( 'jquery' ), $this->version, true );
            wp_localize_script( $this->plugin_name . '-admin', 'AdvencedRelatedPostsAdmin', array( 
            	'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            ) );
        }
        
        if (false === strpos($hook_suffix, $this->plugin_name))
            return;

        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-effects-core' );
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_editor();
        wp_enqueue_media();
        wp_enqueue_script( $this->plugin_name . '-color-picker-alpha', plugin_dir_url(__FILE__) . 'js/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), $this->version, true );
        $color_picker_strings = array(
            'clear'            => __( 'Clear', $this->plugin_name ),
            'clearAriaLabel'   => __( 'Clear color', $this->plugin_name ),
            'defaultString'    => __( 'Default', $this->plugin_name ),
            'defaultAriaLabel' => __( 'Select default color', $this->plugin_name ),
            'pick'             => __( 'Select Color', $this->plugin_name ),
            'defaultLabel'     => __( 'Color value', $this->plugin_name ),
        );
        wp_localize_script( $this->plugin_name . '-color-picker-alpha', 'wpColorPickerL10n', $color_picker_strings );


		/* 
        ========================================== 
           * Bootstrap
           * select2
           * jQuery DataTables
        ========================================== 
        */
        wp_enqueue_script( $this->plugin_name . "-popper", plugin_dir_url(__FILE__) . 'js/popper.min.js', array( 'jquery' ), $this->version, true );
        wp_enqueue_script( $this->plugin_name . "-bootstrap", plugin_dir_url(__FILE__) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, true );
        wp_enqueue_script( $this->plugin_name . '-select2js', ADVANCED_RELATED_POSTS_PUBLIC_URL . '/js/advanced-related-posts-select2.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script( $this->plugin_name . '-sweetalert-js', ADVANCED_RELATED_POSTS_PUBLIC_URL . '/js/advanced-related-posts-sweetalert2.all.min.js', array('jquery'), $this->version, true );

        /* 
        ================================================
           Advanced related admin dashboard scripts (and for AJAX)
        ================================================
        */
        wp_enqueue_script( $this->plugin_name . "-functions", plugin_dir_url(__FILE__) . 'js/functions.js', array( 'jquery', 'wp-color-picker' ), $this->version, true );
        wp_enqueue_script( $this->plugin_name . "-admin-styles", plugin_dir_url(__FILE__) . 'js/partials/advanced-related-posts-admin-styles.js', array('jquery', 'wp-color-picker'), $this->version, true);
        wp_enqueue_script( $this->plugin_name . '-ajax', plugin_dir_url(__FILE__) . 'js/advanced-related-posts-admin-ajax.js', array('jquery', 'wp-color-picker'), $this->version, true);

		wp_enqueue_script(  $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/advanced-related-posts-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, true );
        wp_localize_script( $this->plugin_name, 'AdvencedRelatedPostsAdmin', array( 
        	'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'defaultThumbnailUrl' => ADVANCED_RELATED_POSTS_ADMIN_URL . '/images/icons/icon-arp-default.png',
            'addImage'            => __( 'Add Image' , $this->plugin_name ),
            'editImage'           => __( 'Edit Image' , $this->plugin_name ),
            'upload'              => __( 'Upload' , $this->plugin_name ),
            'excludeCategories'   => __( 'Exclude Categories' , $this->plugin_name ),
        ) );


	}

	public function ays_AdvencedRelatedPosts_VersionCompare($version1, $operator, $version2) {
   
        $_fv = intval ( trim ( str_replace ( '.', '', $version1 ) ) );
        $_sv = intval ( trim ( str_replace ( '.', '', $version2 ) ) );
       
        if (strlen ( $_fv ) > strlen ( $_sv )) {
            $_sv = str_pad ( $_sv, strlen ( $_fv ), 0 );
        }
       
        if (strlen ( $_fv ) < strlen ( $_sv )) {
            $_fv = str_pad ( $_fv, strlen ( $_sv ), 0 );
        }
       
        return version_compare ( ( string ) $_fv, ( string ) $_sv, $operator );
    }

	/**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu(){

        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
         *
         *        Administration Menus: http://codex.wordpress.org/Administration_Menus
         *
         */
        
        $this->capability = $this->ays_related_posts_capabilities();
        $capability = $this->capability;
                
        add_menu_page(
            'Related Posts', 
            'Related Posts',
            $this->capability,
            $this->plugin_name,
            array($this, 'display_plugin_under_posts_page'), 
            ADVANCED_RELATED_POSTS_ADMIN_URL . '/images/icons/advanced_related_posts_logo.png',
            '6.27'
        );
    }

    public function add_plugin_widget_settings_submenu(){
        $hook_settings = add_submenu_page(
            $this->plugin_name,
            __('Widget settings', $this->plugin_name),
            __('Widget settings', $this->plugin_name),
            $this->capability,
            $this->plugin_name . '-wiget-settings',
            array($this, 'display_plugin_wiget_settings_page')
        );

        $this->settings_obj = new Advanced_Related_Posts_Settings_Actions($this->plugin_name);
    }

    public function add_plugin_under_posts_submenu(){
        $hook_under_posts = add_submenu_page(
            $this->plugin_name,
            __('Display after post', $this->plugin_name),
            __('Display after post', $this->plugin_name),
            $this->capability,
            $this->plugin_name,
            array($this, 'display_plugin_under_posts_page')
        );

        $this->settings_obj = new Advanced_Related_Posts_Settings_Actions($this->plugin_name);
    }

    public function add_plugin_featured_plugins_submenu(){
        add_submenu_page( $this->plugin_name,
            __('Our products', $this->plugin_name),
            __('Our products', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-featured-plugins',
            array($this, 'display_plugin_featured_plugins_page') 
        );
    }

    public function add_plugin_related_posts_features_submenu(){
        add_submenu_page(
            $this->plugin_name,
            __('PRO Features', $this->plugin_name),
            __('PRO Features', $this->plugin_name),
            'manage_options',
            $this->plugin_name . '-related-posts-features',
            array($this, 'display_plugin_related_posts_features_page')
        );
    }

    public function display_plugin_wiget_settings_page(){
        include_once('partials/settings/actions/advanced-related-posts-settings-actions.php');
    }

    public function display_plugin_under_posts_page(){
        include_once('partials/under-posts/actions/advanced-related-posts-under-posts-actions.php');
    }

    public function display_plugin_featured_plugins_page(){
        include_once('partials/features/advanced-related-posts-plugin-featured-display.php');
    }

    public function display_plugin_related_posts_features_page(){
        include_once('partials/features/advanced-related-posts-features-display.php');
    }

    // Widget
    public function load_advanced_related_post_widget(){
        require_once ADVANCED_RELATED_POSTS_DIR . "/widget/advanced-related-posts-widget.php";

        register_widget( 'Advanced_Related_Posts_Widget' );
    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */
    public function add_action_links($links){
        /*
        *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
        */
        $settings_link = array(
            '<a href="' . admin_url('admin.php?page=' . $this->plugin_name) . '">' . __('Settings', $this->plugin_name) . '</a>',
            // '<a href="https://quiz-plugin.com/wordpress-advanced-related-posts-plugin-free-demo/" target="_blank">' . __('Demo', $this->plugin_name) . '</a>',
            '<a href="https://ays-pro.com/wordpress/advanced-related-posts" target="_blank" style="color:red;font-weight:bold;">' . __('Buy Now', $this->plugin_name) . '</a>',
            );
        return array_merge($settings_link, $links);
    }

    protected function ays_related_posts_capabilities(){
        global $wpdb;
        return 'manage_options';

        // $sql = "SELECT meta_value FROM {$wpdb->prefix}aysquiz_settings WHERE `meta_key` = 'user_roles'";
        // $result = $wpdb->get_var($sql);
        
        // $capability = 'manage_options';
        // if($result !== null){
        //     $ays_user_roles = json_decode($result, true);
        //     if(is_user_logged_in()){
        //         $current_user = wp_get_current_user();
        //         $current_user_roles = $current_user->roles;
        //         $ishmar = 0;
        //         foreach($current_user_roles as $r){
        //             if(in_array($r, $ays_user_roles)){
        //                 $ishmar++;
        //             }
        //         }
        //         if($ishmar > 0){
        //             $capability = "read";
        //         }
        //     }
        // }
        // return $capability;
    }

    public function ays_advanced_related_posts_admin_ajax(){
		global $wpdb;
		$results = array(
			"status" => false
		);

		$function = isset($_REQUEST['function']) ? sanitize_text_field( $_REQUEST['function'] ) : null;

		if($function !== null){
			$results = array();
			switch ($function) {
				case 'deactivate_plugin_option_arp':
                    // Deactivate plugin AJAX action
					$results = $this->deactivate_plugin_option_arp();
					break;
				case 'ays_advanced_related_posts_exlude_categories':
                    // Exclude Categories
					$results = $this->ays_advanced_related_posts_exlude_categories();
					break;
            }
            ob_end_clean();
            $ob_get_clean = ob_get_clean();
			echo json_encode( $results );
			wp_die();
        }
        ob_end_clean();
        $ob_get_clean = ob_get_clean();
		echo json_encode( $results );
		wp_die();
	}

	public function deactivate_plugin_option_arp(){
        $request_value = sanitize_text_field( $_REQUEST['upgrade_plugin'] );
        $upgrade_option = get_option( 'ays_advanced_related_posts_upgrade_plugin', '' );

        if($upgrade_option === ''){
            add_option( 'ays_advanced_related_posts_upgrade_plugin', $request_value );
        }else{
            update_option( 'ays_advanced_related_posts_upgrade_plugin', $request_value );
        }
        
        ob_end_clean();
        $ob_get_clean = ob_get_clean();
        echo json_encode( array( 'option' => get_option( 'ays_advanced_related_posts_upgrade_plugin', '' ) ) );
        wp_die();
    }

    public function ays_advanced_related_posts_exlude_categories(){

        $search = isset($_REQUEST['search']) && sanitize_text_field( $_REQUEST['search'] ) != '' ? sanitize_text_field( $_REQUEST['search'] ) : null;
        $checked = isset($_REQUEST['val']) && sanitize_text_field( $_REQUEST['val'] ) !='' ? sanitize_text_field( $_REQUEST['val'] ) : null;

        if($search != null){
            $get_terms = get_terms( 
                array(
                    'taxonomy' => array( 'category' ),
                    'name__like' => $search,
                ) 
            );
        }

        $response = array(
            'results' => array()
        );
        $category_name = ''; 
        $category_id = '';
        foreach ($get_terms as $key => $get_term) {
            $category_name = isset($get_term->name) && $get_term->name != '' ? $get_term->name : '';
            $category_id = isset($get_term->term_id) && $get_term->term_id != '' ? $get_term->term_id : '';
            if ($checked !== null) {
                if (in_array($category_id, $checked)) {
                    continue;
                }else{
                    $response['results'][] = array(
                        'id'   => $category_id,
                        'text' => $category_name
                    );
                }
            }else{
                $response['results'][] = array(
                    'id' => $category_id,
                    'text' => $category_name,
                );
            }
        }

        ob_end_clean();
        $ob_get_clean = ob_get_clean();
        echo json_encode($response);
        wp_die();

    }

}
