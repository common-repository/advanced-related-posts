<?php
ob_start();
class Advanced_Related_Posts_Settings_Actions {
    private $plugin_name;

    public function __construct($plugin_name) {
        $this->plugin_name = $plugin_name;
    }

    public function store_data(){
        global $wpdb;
        
        if( isset($_POST["settings_action"]) && wp_verify_nonce( sanitize_text_field($_POST["settings_action"]) , 'settings_action' ) ){
            $success = 0;

            $ays_prefix   = 'ays_';
            $prefix       = 'arp_';
            $name_prefix  = 'ays_arp_';
            $class_prefix = 'ays-arp-';

            // Type
            $ays_arp_type = ( isset( $_POST[ $name_prefix . 'type' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'type' ] ) != '' ) ? sanitize_text_field( $_POST[ $name_prefix . 'type' ] ) : 'under_posts';

            $default_thumbnail = ADVANCED_RELATED_POSTS_ADMIN_URL . '/images/icons/icon-arp-default.png';


            // =======================  //  def // ======================= // ======================= // ======================= //

            // =============================================================
            // ===================  Under Posts Settings  ==================
            // ========================    START   =========================

            // All Post Type
            $arp_under_posts_all_post_type = (isset( $_POST[ $name_prefix . 'under_posts_all_post_type' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'under_posts_all_post_type' ] ) == 'on') ? 'on' : 'off';

            //Selected post type
            $arp_under_posts_selected_post_type = (isset($_POST[ $name_prefix . 'under_posts_selected_post_type' ]) && !empty($_POST[ $name_prefix . 'under_posts_selected_post_type' ] )) ? array_map('sanitize_text_field',$_POST[ $name_prefix . 'under_posts_selected_post_type' ]) : array();

            //Exclude selected category of the post type 
            $arp_under_posts_exclude_categories_ids = (isset($_POST[ $name_prefix . 'under_posts_exclude_categories_ids' ]) && !empty($_POST[ $name_prefix . 'under_posts_exclude_categories_ids' ])) ? array_map('sanitize_text_field',$_POST[ $name_prefix . 'under_posts_exclude_categories_ids' ]) : array();

            //Exclude selected post ids
            $arp_under_posts_exclude_post_ids = (isset($_POST[ $name_prefix . 'under_posts_exclude_post_ids' ]) && sanitize_text_field($_POST[ $name_prefix . 'under_posts_exclude_post_ids' ] != '')) ? sanitize_text_field($_POST[ $name_prefix . 'under_posts_exclude_post_ids' ]) : '';

            // Display On Front Page
            $arp_under_posts_display_front_page = (isset( $_POST[ $name_prefix . 'under_posts_display_front_page' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'under_posts_display_front_page' ] ) == 'on') ? 'on' : 'off';

            // Enable under posts
            $arp_enable_under_posts = (isset( $_POST[ $name_prefix . 'enable_under_posts' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'enable_under_posts' ] ) == 'on') ? 'on' : 'off';

            // Enable under posts count
            $arp_under_posts_count = (isset( $_POST[ $name_prefix . 'under_posts_count' ] ) && absint( sanitize_text_field( $_POST[ $name_prefix . 'under_posts_count' ] ) ) != '') ? absint( sanitize_text_field( $_POST[ $name_prefix . 'under_posts_count' ] ) ) : 3;

            // =============================================================
            // ===================  Under Posts Relevance  ==================
            // ==============================================================

            // Order posts query
            $arp_under_posts_order_posts_query = (isset( $_POST[ $name_prefix . 'under_posts_order_posts_query' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'under_posts_order_posts_query' ] ) != '') ? sanitize_text_field($_POST[ $name_prefix . 'under_posts_order_posts_query' ]) : 'relevance';

            //Only from same type
            $arp_under_posts_only_from_same = (isset($_POST[ $name_prefix . 'under_posts_only_from_same' ]) && !empty($_POST[ $name_prefix . 'under_posts_only_from_same' ])) ? array_map('sanitize_text_field',$_POST[ $name_prefix . 'under_posts_only_from_same' ]) : array('same_post_type');
            
            // Order posts query
            $arp_under_posts_strongness_of_matching = (isset( $_POST[ $name_prefix . 'under_posts_strongness_of_matching' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'under_posts_strongness_of_matching' ] ) != '') ?  sanitize_text_field($_POST[ $name_prefix . 'under_posts_strongness_of_matching' ]) : 'gradually_weakening';
            
            // Display On Front Page
            $arp_under_posts_limit_to_same_author = (isset( $_POST[ $name_prefix . 'under_posts_limit_to_same_author' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'under_posts_limit_to_same_author' ] ) == 'on') ? 'on' : 'off';
            
            // Order posts query
            $arp_under_posts_display_order_results = (isset( $_POST[ $name_prefix . 'under_posts_display_order_results' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'under_posts_display_order_results' ] ) != '') ?  sanitize_text_field($_POST[ $name_prefix . 'under_posts_display_order_results' ]) : 'default';
            
            // Exclude Cat IDs
            $arp_under_posts_general_exclude_cat_ids = (isset( $_POST[ $name_prefix . 'under_posts_general_exclude_cat_ids' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'under_posts_general_exclude_cat_ids' ] ) != '') ? sanitize_text_field( $_POST[ $name_prefix . 'under_posts_general_exclude_cat_ids' ] ) : '';
            
            // Exclude Post IDs
            $arp_under_posts_general_exclude_post_ids = (isset( $_POST[ $name_prefix . 'under_posts_general_exclude_post_ids' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'under_posts_general_exclude_post_ids' ] ) != '') ? sanitize_text_field( $_POST[ $name_prefix . 'under_posts_general_exclude_post_ids' ] ) : '';
            
            // Display Only From The Past 
            //Enable posts form pasts
            $arp_under_posts_enable_posts_from_past = (isset( $_POST[ $name_prefix . 'under_posts_enable_posts_from_past' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'under_posts_enable_posts_from_past' ] ) == 'on') ? 'on' : 'off';
            
            //Posts from past period
            $arp_under_posts_posts_from_past_period = (isset( $_POST[ $name_prefix . 'under_posts_posts_from_past_period' ] ) && absint( sanitize_text_field( $_POST[ $name_prefix . 'under_posts_posts_from_past_period' ] ) != '') ) ? absint( sanitize_text_field( $_POST[ $name_prefix . 'under_posts_posts_from_past_period' ] ) ) : 12;
            
            //Posts period time
            $arp_under_posts_time_posts_from_past = (isset( $_POST[ $name_prefix . 'under_posts_time_posts_from_past' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'under_posts_time_posts_from_past' ] ) != '') ? sanitize_text_field( $_POST[ $name_prefix . 'under_posts_time_posts_from_past' ] ) : 'day';
            
            //Display only posts older than current post
            $arp_under_posts_enable_posts_older_current_post = (isset( $_POST[ $name_prefix . 'under_posts_enable_posts_older_current_post' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'under_posts_enable_posts_older_current_post' ] ) == 'on') ? 'on' : 'off';

            // =============================================================
            // ===================  Under Posts Settings  ==================
            // ==============================================================
            
            //Show metbox
            $arp_under_posts_enable_meta_box = (isset( $_POST[ $name_prefix . 'under_posts_enable_meta_box' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'under_posts_enable_meta_box' ] ) == 'on') ? 'on' : 'off';
           
            //Limit meta box to Admins only 
            $arp_under_posts_enable_meta_box_to_admin_only = (isset( $_POST[ $name_prefix . 'under_posts_enable_meta_box_to_admin_only' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'under_posts_enable_meta_box_to_admin_only' ] ) == 'on') ? 'on' : 'off';
            
            //Enable Limit post title length
            $arp_under_posts_enable_post_title_length = (isset( $_POST[ $name_prefix . 'under_posts_enable_post_title_length' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'under_posts_enable_post_title_length' ] ) == 'on') ? 'on' : 'off';
            
            //Limit post title length
            $arp_under_posts_post_title_length = (isset( $_POST[ $name_prefix . 'under_posts_post_title_length' ] ) && absint( sanitize_text_field( $_POST[ $name_prefix . 'under_posts_post_title_length' ] ) ) != '') ? absint( sanitize_text_field( $_POST[ $name_prefix . 'under_posts_post_title_length' ] ) ) : 60;
            
            //Limit post title type
            $arp_under_posts_post_title_type = (isset( $_POST[ $name_prefix . 'under_posts_post_title_type' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'under_posts_post_title_type' ] ) != '') ? sanitize_text_field( $_POST[ $name_prefix . 'under_posts_post_title_type' ] ) : 'in_characters';

            //Show date             
            $arp_under_posts_show_date  = (isset($_POST[ $name_prefix . 'under_posts_show_date']) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_show_date' ] )) == 'on') ? 'on' : 'off';

            //Show Author
            $arp_under_posts_show_author  = (isset($_POST[ $name_prefix . 'under_posts_show_author']) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_show_author' ] )) == 'on') ? 'on' : 'off';

            //Open links in new window
            $arp_under_posts_links_on_new_window  = (isset($_POST[ $name_prefix . 'under_posts_links_on_new_window']) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_links_on_new_window' ] )) == 'on') ? 'on' : 'off';

            //Enable Limit post title length
            $arp_under_posts_enable_post_excerpt = (isset( $_POST[ $name_prefix . 'under_posts_enable_post_excerpt' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'under_posts_enable_post_excerpt' ] ) == 'on') ? 'on' : 'off';
            
            //Limit post title length
            $arp_under_posts_post_excerpt_length = (isset( $_POST[ $name_prefix . 'under_posts_post_excerpt_length' ] ) && absint( sanitize_text_field( $_POST[ $name_prefix . 'under_posts_post_excerpt_length' ] ) != '' ) ) ? absint( sanitize_text_field( $_POST[ $name_prefix . 'under_posts_post_excerpt_length' ] ) ) : 60;
            
            //Limit post title type
            $arp_under_posts_post_excerpt_type = (isset( $_POST[ $name_prefix . 'under_posts_post_excerpt_type' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'under_posts_post_excerpt_type' ] ) != '') ? sanitize_text_field( $_POST[ $name_prefix . 'under_posts_post_excerpt_type' ] ) : 'in_characters';

            //Title of the box
            $arp_under_posts_box_title = (isset($_POST[ $name_prefix . 'under_posts_box_title' ]) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_box_title' ] )) != '') ? stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_box_title' ] )) : __( 'Related Posts', $this->plugin_name );

            $arp_under_posts_no_post_found = (isset($_POST[ $name_prefix . 'under_posts_no_post_found' ]) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_no_post_found' ] )) != '') ? stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_no_post_found' ] )) : 'blank_output';
            
            //Custom text 
            $arp_under_posts_no_post_found_custom_text = (isset($_POST[ $name_prefix . 'under_posts_no_post_found_custom_text' ]) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_no_post_found_custom_text' ] )) != '') ? wpautop(stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_no_post_found_custom_text' ] ))) : __( 'No related posts found', $this->plugin_name );

            //Disable on mobile devices
            $arp_under_posts_display_on_mobile  = (isset($_POST[ $name_prefix . 'under_posts_display_on_mobile']) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_display_on_mobile' ] )) == 'on') ? 'on' : 'off';

            // =============================================================
            // ===================  Under Posts Settings  ==================
            // ==============================================================

            //Responsive Width / Height
            $arp_under_posts_thumbnail_responsive_width_height  = (isset($_POST[ $name_prefix . 'under_posts_thumbnail_responsive_width_height']) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_thumbnail_responsive_width_height' ] )) == 'on') ? 'on' : 'off';

            $arp_under_posts_thumbnail_responsive_width_height_ratio = (isset($_POST[ $name_prefix . 'under_posts_thumbnail_responsive_width_height_ratio' ]) && absint(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_thumbnail_responsive_width_height_ratio' ] )) != '') ? absint(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_thumbnail_responsive_width_height_ratio' ] )) : 1;
            
            //Thumbnail Width / Height
            $arp_under_posts_thumbnail_width = (isset($_POST[ $name_prefix . 'under_posts_thumbnail_width' ]) && absint(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_thumbnail_width' ] )) != '') ? absint(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_thumbnail_width' ] )) : 300;

            $arp_under_posts_thumbnail_height = (isset($_POST[ $name_prefix . 'under_posts_thumbnail_height' ]) && absint(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_thumbnail_height' ] )) != '') ? absint(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_thumbnail_height' ] )) : 300;

            //Thumbnail size
            $arp_under_posts_thumbnail_size = (isset($_POST[ $name_prefix . 'under_posts_thumbnail_size' ]) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_thumbnail_size' ] )) != '') ? stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_thumbnail_size' ] )) : 'medium_large';
            
            //Get first image
            $arp_under_posts_first_image = (isset($_POST[ $name_prefix . 'under_posts_first_image']) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_first_image' ] )) == 'on') ? 'on' : 'off';
            
            // Defaullt thumbnail
            $arp_under_posts_default_thumbnail = (isset($_POST[ $name_prefix . 'under_posts_default_thumbnail' ]) && sanitize_text_field( $_POST[ $name_prefix . 'under_posts_default_thumbnail' ] ) != '') ? sanitize_text_field( $_POST[ $name_prefix . 'under_posts_default_thumbnail' ] ) : $default_thumbnail;

            // Custom class for related posts container
            $arp_under_posts_custom_class = (isset($_POST[ $name_prefix . 'under_posts_custom_class' ]) && stripslashes( sanitize_text_field( $_POST[ $name_prefix . 'under_posts_custom_class' ] )) != '') ? stripslashes( sanitize_text_field( $_POST[ $name_prefix . 'under_posts_custom_class' ] )) : '';

            // Layouts
            $arp_under_posts_layouts = (isset($_POST[ $name_prefix . 'under_posts_layouts' ]) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_layouts' ] )) != '') ? stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_layouts' ] )) : 'elegant';

            // Thumbnail columns count
            $arp_under_posts_thumbnail_columns_count = (isset($_POST[ $name_prefix . 'under_posts_thumbnail_columns_count' ]) && absint(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_thumbnail_columns_count' ] )) != '') ? absint(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_thumbnail_columns_count' ] )) : 3;

            // Text color
            $arp_under_posts_text_color = (isset($_POST[ $name_prefix . 'under_posts_text_color' ]) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_text_color' ] )) != '') ? stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'under_posts_text_color' ] )) : '#333';

            $under_posts_options = array(
                // General Tab
                $prefix . 'under_posts_all_post_type'                    => $arp_under_posts_all_post_type,
                $prefix . 'under_posts_selected_post_type'               => json_encode($arp_under_posts_selected_post_type),
                $prefix . 'under_posts_exclude_categories_ids'           => json_encode($arp_under_posts_exclude_categories_ids),
                $prefix . 'under_posts_exclude_post_ids'                 => $arp_under_posts_exclude_post_ids,
                $prefix . 'enable_under_posts'                           => $arp_enable_under_posts,
                $prefix . 'under_posts_count'                            => $arp_under_posts_count,
                $prefix . 'under_posts_display_front_page'               => $arp_under_posts_display_front_page,

                // Relevance Tab   
                $prefix . 'under_posts_order_posts_query'                => $arp_under_posts_order_posts_query,
                $prefix . 'under_posts_only_from_same'                   => json_encode($arp_under_posts_only_from_same),
                $prefix . 'under_posts_strongness_of_matching'           => $arp_under_posts_strongness_of_matching,
                $prefix . 'under_posts_limit_to_same_author'             => $arp_under_posts_limit_to_same_author,
                $prefix . 'under_posts_display_order_results'            => $arp_under_posts_display_order_results,
                $prefix . 'under_posts_general_exclude_cat_ids'          => $arp_under_posts_general_exclude_cat_ids,
                $prefix . 'under_posts_general_exclude_post_ids'         => $arp_under_posts_general_exclude_post_ids,
                $prefix . 'under_posts_enable_posts_from_past'           => $arp_under_posts_enable_posts_from_past,
                $prefix . 'under_posts_posts_from_past_period'           => $arp_under_posts_posts_from_past_period,
                $prefix . 'under_posts_time_posts_from_past'             => $arp_under_posts_time_posts_from_past,
                $prefix . 'under_posts_enable_posts_older_current_post'  => $arp_under_posts_enable_posts_older_current_post,
            
                // Settings Tab
                $prefix . 'under_posts_enable_meta_box'                  => $arp_under_posts_enable_meta_box,
                $prefix . 'under_posts_enable_meta_box_to_admin_only'    => $arp_under_posts_enable_meta_box_to_admin_only,
                $prefix . 'under_posts_enable_post_title_length'         => $arp_under_posts_enable_post_title_length,
                $prefix . 'under_posts_post_title_length'                => $arp_under_posts_post_title_length,
                $prefix . 'under_posts_post_title_type'                  => $arp_under_posts_post_title_type,
                $prefix . 'under_posts_show_date'                        => $arp_under_posts_show_date,
                $prefix . 'under_posts_show_author'                      => $arp_under_posts_show_author,
                $prefix . 'under_posts_links_on_new_window'              => $arp_under_posts_links_on_new_window,
                $prefix . 'under_posts_enable_post_excerpt'              => $arp_under_posts_enable_post_excerpt,
                $prefix . 'under_posts_post_excerpt_length'              => $arp_under_posts_post_excerpt_length,
                $prefix . 'under_posts_post_excerpt_type'                => $arp_under_posts_post_excerpt_type,
                $prefix . 'under_posts_box_title'                        => $arp_under_posts_box_title,
                $prefix . 'under_posts_no_post_found'                    => $arp_under_posts_no_post_found,
                $prefix . 'under_posts_no_post_found_custom_text'        => $arp_under_posts_no_post_found_custom_text,
                $prefix . 'under_posts_display_on_mobile'                => $arp_under_posts_display_on_mobile,

                // Style Tab
                $prefix . 'under_posts_thumbnail_responsive_width_height'=> $arp_under_posts_thumbnail_responsive_width_height,
                $prefix . 'under_posts_thumbnail_responsive_width_height_ratio'=> $arp_under_posts_thumbnail_responsive_width_height_ratio,
                $prefix . 'under_posts_thumbnail_width'                  => $arp_under_posts_thumbnail_width,
                $prefix . 'under_posts_thumbnail_height'                 => $arp_under_posts_thumbnail_height,
                $prefix . 'under_posts_thumbnail_size'                   => $arp_under_posts_thumbnail_size,
                $prefix . 'under_posts_default_thumbnail'                => $arp_under_posts_default_thumbnail,
                $prefix . 'under_posts_first_image'                      => $arp_under_posts_first_image,
                $prefix . 'under_posts_custom_class'                     => $arp_under_posts_custom_class,
                $prefix . 'under_posts_layouts'                          => $arp_under_posts_layouts,
                $prefix . 'under_posts_thumbnail_columns_count'          => $arp_under_posts_thumbnail_columns_count,
                $prefix . 'under_posts_text_color'                       => $arp_under_posts_text_color,
            );

            $object_under_posts_note = array(
                // Example
                // $prefix . 'under_posts_all_post_type'  => 'test',
            );

            $object_under_posts_options = array(

            );

            // =======================  //  ======================= // ======================= // ======================= // ======================= //

            // =============================================================
            // ===================  Under Posts Settings  ==================
            // ========================     End    =========================


            // =======================  //  ======================= // ======================= // ======================= // ======================= //


            // =============================================================
            // =====================   Widget Settings  ====================
            // ========================    START   =========================

            // All Post Type
            $arp_widget_all_post_type = (isset( $_POST[ $name_prefix . 'widget_all_post_type' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'widget_all_post_type' ] ) == 'on') ? 'on' : 'off';
            
            //Selected post type
            $arp_widget_selected_post_type = (isset($_POST[ $name_prefix . 'widget_selected_post_type' ]) && !empty($_POST[ $name_prefix . 'widget_selected_post_type' ] )) ? array_map('sanitize_text_field',$_POST[ $name_prefix . 'widget_selected_post_type' ]) : array();

            //Exclude selected category of the post type 
            $arp_widget_exclude_categories_ids = (isset($_POST[ $name_prefix . 'widget_exclude_categories_ids' ]) && !empty($_POST[ $name_prefix . 'widget_exclude_categories_ids' ])) ? array_map('sanitize_text_field',$_POST[ $name_prefix . 'widget_exclude_categories_ids' ]) : array();
            
            //Exclude selected post ids
            $arp_widget_exclude_post_ids = (isset($_POST[ $name_prefix . 'widget_exclude_post_ids' ]) && sanitize_text_field($_POST[ $name_prefix . 'widget_exclude_post_ids' ] != '')) ? sanitize_text_field($_POST[ $name_prefix . 'widget_exclude_post_ids' ]) : '';
            
            // Widget Count
            $arp_widget_count = (isset( $_POST[ $name_prefix . 'widget_count' ] ) && absint( sanitize_text_field( $_POST[ $name_prefix . 'widget_count' ] ) ) != '') ? absint( sanitize_text_field( $_POST[ $name_prefix . 'widget_count' ] ) ) : 3;
            
            // Display On Front Page
            $arp_widget_display_front_page = (isset( $_POST[ $name_prefix . 'widget_display_front_page' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'widget_display_front_page' ] ) == 'on') ? 'on' : 'off';
            
            // =============================================================
            // =====================    Relevance Tab  ====================
            // ==============================================================
            
            // Order posts query
            $arp_widget_order_posts_query = (isset( $_POST[ $name_prefix . 'widget_order_posts_query' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'widget_order_posts_query' ] ) != '') ? sanitize_text_field($_POST[ $name_prefix . 'widget_order_posts_query' ]) : 'relevance';
            
            //Only from same type
            $arp_widget_only_from_same = (isset($_POST[ $name_prefix . 'widget_only_from_same' ]) && !empty($_POST[ $name_prefix . 'widget_only_from_same' ])) ? array_map('sanitize_text_field',$_POST[ $name_prefix . 'widget_only_from_same' ]) : array('same_post_type');
            
            // Order posts query
            $arp_widget_strongness_of_matching = (isset( $_POST[ $name_prefix . 'widget_strongness_of_matching' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'widget_strongness_of_matching' ] ) != '') ?  sanitize_text_field($_POST[ $name_prefix . 'widget_strongness_of_matching' ]) : 'gradually_weakening';
            
            // Display On Front Page
            $arp_widget_limit_to_same_author = (isset( $_POST[ $name_prefix . 'widget_limit_to_same_author' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'widget_limit_to_same_author' ] ) == 'on') ? 'on' : 'off';
            
            // Order posts query
            $arp_widget_display_order_results = (isset( $_POST[ $name_prefix . 'widget_display_order_results' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'widget_display_order_results' ] ) != '') ?  sanitize_text_field($_POST[ $name_prefix . 'widget_display_order_results' ]) : 'default';
            
            // Exclude Cat IDs
            $arp_widget_general_exclude_cat_ids = (isset( $_POST[ $name_prefix . 'widget_general_exclude_cat_ids' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'widget_general_exclude_cat_ids' ] ) != '') ? sanitize_text_field( $_POST[ $name_prefix . 'widget_general_exclude_cat_ids' ] ) : '';
            
            // Exclude Post IDs
            $arp_widget_general_exclude_post_ids = (isset( $_POST[ $name_prefix . 'widget_general_exclude_post_ids' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'widget_general_exclude_post_ids' ] ) != '') ? sanitize_text_field( $_POST[ $name_prefix . 'widget_general_exclude_post_ids' ] ) : '';
            
            // Display Only From The Past 
            //Enable posts form pasts
            $arp_widget_enable_posts_from_past = (isset( $_POST[ $name_prefix . 'widget_enable_posts_from_past' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'widget_enable_posts_from_past' ] ) == 'on') ? 'on' : 'off';
            
            //Posts from past period
            $arp_widget_posts_from_past_period = (isset( $_POST[ $name_prefix . 'widget_posts_from_past_period' ] ) && absint( sanitize_text_field( $_POST[ $name_prefix . 'widget_posts_from_past_period' ] ) ) != '') ? absint( sanitize_text_field( $_POST[ $name_prefix . 'widget_posts_from_past_period' ] ) ) : 12;
            
            //Posts period time
            $arp_widget_time_posts_from_past = (isset( $_POST[ $name_prefix . 'widget_time_posts_from_past' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'widget_time_posts_from_past' ] ) != '') ? sanitize_text_field( $_POST[ $name_prefix . 'widget_time_posts_from_past' ] ) : 'day';
            
            //Display only posts older than current post
            $arp_widget_enable_posts_older_current_post = (isset( $_POST[ $name_prefix . 'widget_enable_posts_older_current_post' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'widget_enable_posts_older_current_post' ] ) == 'on') ? 'on' : 'off';

            // =============================================================
            // =====================    Settings Tab  ====================
            // ==============================================================
            
            //Limit post title length
            //Enable Limit post title length
            $arp_widget_enable_post_title_length = (isset( $_POST[ $name_prefix . 'widget_enable_post_title_length' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'widget_enable_post_title_length' ] ) == 'on') ? 'on' : 'off';
            
            //Limit post title length
            $arp_widget_post_title_length = (isset( $_POST[ $name_prefix . 'widget_post_title_length' ] ) && absint( sanitize_text_field( $_POST[ $name_prefix . 'widget_post_title_length' ] ) ) != '') ? absint( sanitize_text_field( $_POST[ $name_prefix . 'widget_post_title_length' ] ) ) : 60;
            
            //Limit post title type
            $arp_widget_post_title_type = (isset( $_POST[ $name_prefix . 'widget_post_title_type' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'widget_post_title_type' ] ) != '') ? sanitize_text_field( $_POST[ $name_prefix . 'widget_post_title_type' ] ) : 'in_characters';

            //Show date             
            $arp_widget_show_date  = (isset($_POST[ $name_prefix . 'widget_show_date']) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'widget_show_date' ] )) == 'on') ? 'on' : 'off';

            //Show Author
            $arp_widget_show_author  = (isset($_POST[ $name_prefix . 'widget_show_author']) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'widget_show_author' ] )) == 'on') ? 'on' : 'off';

            //Open links in new window
            $arp_widget_links_on_new_window  = (isset($_POST[ $name_prefix . 'widget_links_on_new_window']) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'widget_links_on_new_window' ] )) == 'on') ? 'on' : 'off';

            //Limit post title length
            //Enable Limit post title length
            $arp_widget_enable_post_excerpt = (isset( $_POST[ $name_prefix . 'widget_enable_post_excerpt' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'widget_enable_post_excerpt' ] ) == 'on') ? 'on' : 'off';
            
            //Limit post title length
            $arp_widget_post_excerpt_length = (isset( $_POST[ $name_prefix . 'widget_post_excerpt_length' ] ) && absint(  sanitize_text_field( $_POST[ $name_prefix . 'widget_post_excerpt_length' ] ) ) != '') ? absint( sanitize_text_field( $_POST[ $name_prefix . 'widget_post_excerpt_length' ] ) ) : 60;
            
            //Limit post title type
            $arp_widget_post_excerpt_type = (isset( $_POST[ $name_prefix . 'widget_post_excerpt_type' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'widget_post_excerpt_type' ] ) != '') ? sanitize_text_field( $_POST[ $name_prefix . 'widget_post_excerpt_type' ] ) : 'in_characters';
            
            //Title of the box
            $arp_widget_box_title = (isset($_POST[ $name_prefix . 'widget_box_title' ]) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'widget_box_title' ] )) != '') ? stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'widget_box_title' ] )) : __( 'Related Posts', $this->plugin_name);

            $arp_widget_no_post_found = (isset($_POST[ $name_prefix . 'widget_no_post_found' ]) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'widget_no_post_found' ] )) != '') ? stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'widget_no_post_found' ] )) : 'blank_output';
            
            //Custom text 
            $arp_widget_no_post_found_custom_text = (isset($_POST[ $name_prefix . 'widget_no_post_found_custom_text' ]) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'widget_no_post_found_custom_text' ] )) != '') ? wpautop(stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'widget_no_post_found_custom_text' ] ))) : __( 'No related posts found', $this->plugin_name);

            //Disable on mobile devices
            $arp_widget_display_on_mobile  = (isset($_POST[ $name_prefix . 'widget_display_on_mobile']) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'widget_display_on_mobile' ] )) == 'on') ? 'on' : 'off';

            // =============================================================
            // =====================    Style Tab  ====================
            // ==============================================================

            //Responsive Width / Height
            $arp_widget_thumbnail_responsive_width_height  = (isset($_POST[ $name_prefix . 'widget_thumbnail_responsive_width_height']) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'widget_thumbnail_responsive_width_height' ] )) == 'on') ? 'on' : 'off';

            $arp_widget_thumbnail_responsive_width_height_ratio = (isset($_POST[ $name_prefix . 'widget_thumbnail_responsive_width_height_ratio' ]) && absint(sanitize_text_field( $_POST[ $name_prefix . 'widget_thumbnail_responsive_width_height_ratio' ] )) != '') ? absint(sanitize_text_field( $_POST[ $name_prefix . 'widget_thumbnail_responsive_width_height_ratio' ] )) : 1;
            
            //Thumbnail Width / Height
            $arp_widget_thumbnail_width = (isset($_POST[ $name_prefix . 'widget_thumbnail_width' ]) && absint(sanitize_text_field( $_POST[ $name_prefix . 'widget_thumbnail_width' ] )) != '') ? absint(sanitize_text_field( $_POST[ $name_prefix . 'widget_thumbnail_width' ] )) : 300;

            $arp_widget_thumbnail_height = (isset($_POST[ $name_prefix . 'widget_thumbnail_height' ]) && absint(sanitize_text_field( $_POST[ $name_prefix . 'widget_thumbnail_height' ] )) != '') ? absint(sanitize_text_field( $_POST[ $name_prefix . 'widget_thumbnail_height' ] )) : 300;

            //Thumbnail size
            $arp_widget_thumbnail_size = (isset($_POST[ $name_prefix . 'widget_thumbnail_size' ]) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'widget_thumbnail_size' ] )) != '') ? stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'widget_thumbnail_size' ] )) : 'medium_large';
            
            //Get first image
            $arp_widget_first_image = (isset($_POST[ $name_prefix . 'widget_first_image' ]) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'widget_first_image' ] )) == 'on') ? 'on' : 'off';

            // Defaullt thumbnail
            $arp_widget_default_thumbnail = (isset($_POST[ $name_prefix . 'widget_default_thumbnail' ]) && $_POST[ $name_prefix . 'widget_default_thumbnail' ] ) != '' ? sanitize_text_field( $_POST[ $name_prefix . 'widget_default_thumbnail' ] ) : $default_thumbnail;

            // Custom class for related posts container
            $arp_widget_custom_class = (isset($_POST[ $name_prefix . 'widget_custom_class' ]) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'widget_custom_class' ] )) != '') ? stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'widget_custom_class' ] )) : '';

            // Layouts
            $arp_widget_layouts = (isset($_POST[ $name_prefix . 'widget_layouts' ]) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'widget_layouts' ] )) != '') ? stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'widget_layouts' ] )) : 'elegant';

            // Thumbnail columns count
            $arp_widget_thumbnail_columns_count = (isset($_POST[ $name_prefix . 'widget_thumbnail_columns_count' ]) && absint(sanitize_text_field( $_POST[ $name_prefix . 'widget_thumbnail_columns_count' ] )) != '') ? absint(sanitize_text_field( $_POST[ $name_prefix . 'widget_thumbnail_columns_count' ] )) : 3;

            // Text color
            $arp_widget_text_color = (isset($_POST[ $name_prefix . 'widget_text_color' ]) && stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'widget_text_color' ] )) != '') ? stripslashes(sanitize_text_field( $_POST[ $name_prefix . 'widget_text_color' ] )) : '#333';

            $widget_options = array(
                //General
                $prefix . 'widget_all_post_type'                    => $arp_widget_all_post_type,
                $prefix . 'widget_selected_post_type'               => json_encode($arp_widget_selected_post_type),
                $prefix . 'widget_exclude_categories_ids'           => json_encode($arp_widget_exclude_categories_ids),
                $prefix . 'widget_exclude_post_ids'                 => $arp_widget_exclude_post_ids,
                $prefix . 'widget_count'                            => $arp_widget_count,
                $prefix . 'widget_display_front_page'               => $arp_widget_display_front_page,
                    
                //Relevance    
                $prefix . 'widget_order_posts_query'                => $arp_widget_order_posts_query,
                $prefix . 'widget_only_from_same'                   => json_encode($arp_widget_only_from_same),
                $prefix . 'widget_strongness_of_matching'           => $arp_widget_strongness_of_matching,
                $prefix . 'widget_limit_to_same_author'             => $arp_widget_limit_to_same_author,
                $prefix . 'widget_display_order_results'            => $arp_widget_display_order_results,
                $prefix . 'widget_general_exclude_cat_ids'          => $arp_widget_general_exclude_cat_ids,
                $prefix . 'widget_general_exclude_post_ids'         => $arp_widget_general_exclude_post_ids,
                $prefix . 'widget_enable_posts_from_past'           => $arp_widget_enable_posts_from_past,
                $prefix . 'widget_posts_from_past_period'           => $arp_widget_posts_from_past_period,
                $prefix . 'widget_time_posts_from_past'             => $arp_widget_time_posts_from_past,
                $prefix . 'widget_enable_posts_older_current_post'  => $arp_widget_enable_posts_older_current_post,

                //Settings
                $prefix . 'widget_enable_post_title_length'         => $arp_widget_enable_post_title_length,
                $prefix . 'widget_post_title_length'                => $arp_widget_post_title_length,
                $prefix . 'widget_post_title_type'                  => $arp_widget_post_title_type,
                $prefix . 'widget_show_date'                        => $arp_widget_show_date,
                $prefix . 'widget_show_author'                      => $arp_widget_show_author,
                $prefix . 'widget_links_on_new_window'              => $arp_widget_links_on_new_window,
                $prefix . 'widget_enable_post_excerpt'              => $arp_widget_enable_post_excerpt,
                $prefix . 'widget_post_excerpt_length'              => $arp_widget_post_excerpt_length,
                $prefix . 'widget_post_excerpt_type'                => $arp_widget_post_excerpt_type,
                $prefix . 'widget_box_title'                        => $arp_widget_box_title,
                $prefix . 'widget_no_post_found'                    => $arp_widget_no_post_found,
                $prefix . 'widget_no_post_found_custom_text'        => $arp_widget_no_post_found_custom_text,
                $prefix . 'widget_display_on_mobile'                => $arp_widget_display_on_mobile,

                //Styles
                $prefix . 'widget_thumbnail_responsive_width_height'=> $arp_widget_thumbnail_responsive_width_height,
                $prefix . 'widget_thumbnail_responsive_width_height_ratio'=> $arp_widget_thumbnail_responsive_width_height_ratio,
                $prefix . 'widget_thumbnail_width'                  => $arp_widget_thumbnail_width,
                $prefix . 'widget_thumbnail_height'                 => $arp_widget_thumbnail_height,
                $prefix . 'widget_thumbnail_size'                   => $arp_widget_thumbnail_size,
                $prefix . 'widget_default_thumbnail'                => $arp_widget_default_thumbnail,
                $prefix . 'widget_first_image'                      => $arp_widget_first_image,
                $prefix . 'widget_custom_class'                     => $arp_widget_custom_class,
                $prefix . 'widget_layouts'                          => $arp_widget_layouts,
                $prefix . 'widget_thumbnail_columns_count'          => $arp_widget_thumbnail_columns_count,
                $prefix . 'widget_text_color'                       => $arp_widget_text_color,
            );

            // =============================================================
            // =====================   Widget Settings  ====================
            // ========================     End    =========================
            
            $object_widget_note = array(
                // Example
                // $prefix . 'widget_all_post_type'  => 'test',
            );

            $object_widget_options = array(

            );
            
            $result = false;
            switch ( $ays_arp_type ) {
                case 'under_posts':
                    foreach ($under_posts_options as $meta_key => $meta_value) {
                        $object_under_posts_note_val    = '';
                        $object_under_posts_options_val = '';
                        if ( isset( $object_under_posts_note[ $meta_key ] ) ) {
                            $object_under_posts_note_val = $object_under_posts_note[ $meta_key ];
                        }

                        if ( isset( $object_under_posts_options[ $meta_key ] ) ) {
                            $object_under_posts_options_val = $object_under_posts_options[ $meta_key ];
                        }

                        $result = $this->ays_update_setting( $meta_key, $meta_value , $ays_arp_type, $object_under_posts_note_val, $object_under_posts_options_val );
                    }
                    break;
                case 'widget':
                    foreach ($widget_options as $meta_key => $meta_value) {
                        $object_widget_note_val    = '';
                        $object_widget_options_val = '';
                        if ( isset( $object_widget_note[ $meta_key ] ) ) {
                            $object_widget_note_val = $object_widget_note[ $meta_key ];
                        }

                        if ( isset( $object_widget_options[ $meta_key ] ) ) {
                            $object_widget_options_val = $object_widget_options[ $meta_key ];
                        }

                        $result = $this->ays_update_setting( $meta_key, $meta_value , $ays_arp_type, $object_widget_note_val, $object_widget_options_val );
                    }
                    break;
                default:
                    break;
            }

            if ($result) {
                $success++;
            }

            $message = "saved";
            $ays_posts_tab = ( isset( $_POST[ $name_prefix . 'tab' ] ) && sanitize_text_field( $_POST[ $name_prefix . 'tab' ] ) != '' ) ? sanitize_text_field( $_POST[ $name_prefix . 'tab' ] ) : 'tab1';
            if( $success > 0 ) {
                $url = esc_url_raw( add_query_arg( array(
                    "tab"       => $ays_posts_tab,
                    "status"    => $message
                ) ) );
                wp_redirect( $url );
            }
        }
    }

    public static function get_db_data(){
        global $wpdb;
        $settings_table = esc_sql( $wpdb->prefix . ADVANCED_RELATED_POSTS_DB_PREFIX ) . "settings";
        $sql = "SELECT * FROM ".$settings_table;
        $results = $wpdb->get_results($sql, ARRAY_A);
        if(count($results) > 0){
            return $results;
        }else{
            return array();
        }
    }    
    
    public static function check_settings_metas( $metas ){
        global $wpdb;
        $settings_table = esc_sql( $wpdb->prefix . ADVANCED_RELATED_POSTS_DB_PREFIX ) . "settings";
        foreach($metas as $key => $meta_key){
            $sql = "SELECT COUNT(*) FROM ".$settings_table." WHERE meta_key = '".$meta_key."'";
            $result = $wpdb->get_var($sql);
            if(intval($result) == 0){
                $res = self::ays_add_setting($meta_key, "", "", "", "");
            }
        }
        return false;
    }

    public static function check_settings_meta( $meta_key ){
        global $wpdb;

        if ( isset($meta_key) && sanitize_text_field($meta_key) == '' ) {
            return false;
        }

        $settings_table = esc_sql( $wpdb->prefix . ADVANCED_RELATED_POSTS_DB_PREFIX ) . "settings";
        $sql = "SELECT COUNT(*) FROM ".$settings_table." WHERE meta_key = '".$meta_key."'";
        $result = $wpdb->get_var($sql);
        if(intval($result) == 0){
            $res = self::ays_add_setting($meta_key, "", "", "", "");
            if ( $res ) {
                return true;
            }else {
                return false;
            }
        }
        return true;
    }
    
    public static function ays_get_setting( $meta_key ){
        global $wpdb;
        $settings_table = esc_sql( $wpdb->prefix . ADVANCED_RELATED_POSTS_DB_PREFIX ) . "settings";
        $sql = "SELECT meta_value FROM ".$settings_table." WHERE meta_key = '".$meta_key."'";
        $result = $wpdb->get_var($sql);
        if($result != ""){
            return $result;
        }
        return false;
    }

    public static function ays_get_all_settings( $type ){
        global $wpdb;

        if ( ! isset( $type ) ) {
            $type = 'under_posts';
        }

        $settings_table = esc_sql( $wpdb->prefix . ADVANCED_RELATED_POSTS_DB_PREFIX ) . "settings";
        $sql = "SELECT * FROM ".$settings_table." WHERE type = '".$type."'";

        $result = $wpdb->get_results( $sql , "ARRAY_A");
        if($result != ""){
            return $result;
        }
        return false;
    }
    
    public static function ays_add_setting($meta_key, $meta_value, $type = "", $note = "", $options = ""){
        global $wpdb;
        $settings_table = esc_sql( $wpdb->prefix . ADVANCED_RELATED_POSTS_DB_PREFIX ) . "settings";
        $result = $wpdb->insert(
            $settings_table,
            array(
                'meta_key'    => $meta_key,
                'meta_value'  => $meta_value,
                'type'        => $type,
                'note'        => $note,
                'options'     => $options
            ),
            array( 
                '%s', // meta_key
                '%s', // meta_value
                '%s', // type
                '%s', // note
                '%s', // options
            )
        );
        if($result >= 0){
            return true;
        }
        return false;
    }
    
    public static function ays_update_setting($meta_key, $meta_value,  $type = null, $note = null, $options = null){
        global $wpdb;

        $meta_key = ( isset($meta_key) && sanitize_text_field($meta_key) != "" ) ? sanitize_text_field($meta_key) : "";
        if ( $meta_key == "" ) {
            return false;
        }

        $check_settings_meta = self::check_settings_meta( $meta_key );

        if ( ! $check_settings_meta ) {
            return false;
        }

        $settings_table = esc_sql( $wpdb->prefix . ADVANCED_RELATED_POSTS_DB_PREFIX ) . "settings";
        $value = array(
            'meta_value'  => $meta_value,
        );
        $value_s = array( '%s' );
        if($note != null){
            $value['note'] = $note;
            $value_s[] = '%s';
        }
        if($type != null){
            $value['type'] = $type;
            $value_s[] = '%s';
        }
        if($options != null){
            $value['options'] = $options;
            $value_s[] = '%s';
        }
        $result = $wpdb->update(
            $settings_table,
            $value,
            array( 'meta_key' => $meta_key, ),
            $value_s,
            array( '%s' )
        );
        if($result >= 0){
            return true;
        }
        return false;
    }
    
    public static function ays_delete_setting($meta_key){
        global $wpdb;
        $settings_table = esc_sql( $wpdb->prefix . ADVANCED_RELATED_POSTS_DB_PREFIX ) . "settings";
        $wpdb->delete(
            $settings_table,
            array( 'meta_key' => $meta_key ),
            array( '%s' )
        );
    }   
}
