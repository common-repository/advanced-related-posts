<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Advanced_Related_Posts
 * @subpackage Advanced_Related_Posts/includes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Advanced_Related_Posts
 * @subpackage Advanced_Related_Posts/includes
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Advanced_Related_Posts_Data {

    public static function get_arp_validated_data_from_array(){
        global $wpdb;

        // Array for related posts validated options
        $settings = array();
        $options = array();
        $name_prefix = 'arp_';

        $default_thumbnail = ADVANCED_RELATED_POSTS_ADMIN_URL . '/images/icons/icon-arp-default.png';

        $results = Advanced_Related_Posts_Settings_Actions::ays_get_all_settings( 'under_posts' );

        $options = array();
        foreach($results as $o_key => $o_value){
            if(isset($o_value)){
                $meta_key   = isset($o_value['meta_key']) ? $o_value['meta_key'] : "";
                $meta_value = isset($o_value['meta_value']) ? $o_value['meta_value'] : "";
                $options[$meta_key] = $meta_value;
            }
        }

        // =======================  //  ======================= // ======================= // ======================= // ======================= //

        // =============================================================
        // ======================   General Tab   ======================
        // ========================    START   =========================

        // Uunder posts count
        $settings[ $name_prefix . 'under_posts_count' ] = (isset($options[ $name_prefix . 'under_posts_count' ]) &&  sanitize_text_field( $options[ $name_prefix . 'under_posts_count' ] ) != '' &&  sanitize_text_field( $options[ $name_prefix . 'under_posts_count' ] ) != 0 ) ? absint( sanitize_text_field( $options[ $name_prefix . 'under_posts_count' ] ) ) : 3;

        // Enable for all post types
        $options[ $name_prefix . 'under_posts_all_post_type' ] = ( isset($options[ $name_prefix . 'under_posts_all_post_type' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_all_post_type' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'under_posts_all_post_type' ] ) : 'on';
        $settings[ $name_prefix . 'under_posts_all_post_type' ] = (isset($options[ $name_prefix . 'under_posts_all_post_type' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_all_post_type' ] ) == 'on') ? true : false;

        // For selected post types
        $settings[ $name_prefix . 'under_posts_selected_post_type' ] = ( isset($options[ $name_prefix . 'under_posts_selected_post_type' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_selected_post_type' ] ) != '' ) ? array_map('sanitize_text_field', json_decode( sanitize_text_field( $options[ $name_prefix . 'under_posts_selected_post_type' ] ) , true) ) : array();

        // Exclude for categories
        $settings[ $name_prefix . 'under_posts_exclude_categories_ids' ] = ( isset($options[ $name_prefix . 'under_posts_exclude_categories_ids' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_exclude_categories_ids' ] ) != '' ) ? array_map('sanitize_text_field', json_decode( sanitize_text_field( $options[ $name_prefix . 'under_posts_exclude_categories_ids' ] ) , true) ) : array();

        // Exclude posts ids
        $settings[ $name_prefix . 'under_posts_exclude_post_ids' ] = (isset($options[ $name_prefix . 'under_posts_exclude_post_ids' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_exclude_post_ids' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'under_posts_exclude_post_ids' ] ) : '';


        // Display on the front page
        $options[ $name_prefix . 'under_posts_display_front_page' ] = ( isset($options[ $name_prefix . 'under_posts_display_front_page' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_display_front_page' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'under_posts_display_front_page' ] ) : 'off';
        $settings[ $name_prefix . 'under_posts_display_front_page' ] = (isset($options[ $name_prefix . 'under_posts_display_front_page' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_display_front_page' ] ) == 'on') ? true : false;


        // =============================================================
        // ======================   General Tab   ======================
        // =======================     END      ========================


        // =======================  //  ======================= // ======================= // ======================= // ======================= //


        // =============================================================
        // =====================   Relevance Tab   =====================
        // ========================    START    ========================

        // Order posts query
        $settings[ $name_prefix . 'under_posts_order_posts_query' ] = (isset($options[ $name_prefix . 'under_posts_order_posts_query' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_order_posts_query' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'under_posts_order_posts_query' ] ) : 'relevance';

        // Only from same
        $settings[ $name_prefix . 'under_posts_only_from_same' ] = ( isset($options[ $name_prefix . 'under_posts_only_from_same' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_only_from_same' ] ) != '' ) ? array_map( 'sanitize_text_field', json_decode( sanitize_text_field( $options[ $name_prefix . 'under_posts_only_from_same' ] ) , true) ) : array('same_post_type');

        // Strongness of matching
        $settings[ $name_prefix . 'under_posts_strongness_of_matching' ] = (isset($options[ $name_prefix . 'under_posts_strongness_of_matching' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_strongness_of_matching' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'under_posts_strongness_of_matching' ] ) : 'gradually_weakening';

        // Limit to same author
        $options[ $name_prefix . 'under_posts_limit_to_same_author' ] = ( isset($options[ $name_prefix . 'under_posts_limit_to_same_author' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_limit_to_same_author' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'under_posts_limit_to_same_author' ] ) : 'off';
        $settings[ $name_prefix . 'under_posts_limit_to_same_author' ] = (isset($options[ $name_prefix . 'under_posts_limit_to_same_author' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_limit_to_same_author' ] ) == 'on') ? true : false;

        // Display Order results
        $settings[ $name_prefix . 'under_posts_display_order_results' ] = (isset($options[ $name_prefix . 'under_posts_display_order_results' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_display_order_results' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'under_posts_display_order_results' ] ) : 'default';

        // Category exclude IDs
        $settings[ $name_prefix . 'under_posts_general_exclude_cat_ids' ] = (isset($options[ $name_prefix . 'under_posts_general_exclude_cat_ids' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_general_exclude_cat_ids' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'under_posts_general_exclude_cat_ids' ] ) : '';

        // Post/page IDs to exclude
        $settings[ $name_prefix . 'under_posts_general_exclude_post_ids' ] = (isset($options[ $name_prefix . 'under_posts_general_exclude_post_ids' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_general_exclude_post_ids' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'under_posts_general_exclude_post_ids' ] ) : '';

        // Display only posts from the past
        $options[ $name_prefix . 'under_posts_enable_posts_from_past' ] = ( isset($options[ $name_prefix . 'under_posts_enable_posts_from_past' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_enable_posts_from_past' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'under_posts_enable_posts_from_past' ] ) : 'off';
        $settings[ $name_prefix . 'under_posts_enable_posts_from_past' ] = (isset($options[ $name_prefix . 'under_posts_enable_posts_from_past' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_enable_posts_from_past' ] ) == 'on') ? true : false;


        // Count only posts from the past
        $settings[ $name_prefix . 'under_posts_posts_from_past_period' ] = (isset($options[ $name_prefix . 'under_posts_posts_from_past_period' ]) &&  sanitize_text_field( $options[ $name_prefix . 'under_posts_posts_from_past_period' ] ) != '' &&  sanitize_text_field( $options[ $name_prefix . 'under_posts_posts_from_past_period' ] ) != 0 ) ? absint( sanitize_text_field( $options[ $name_prefix . 'under_posts_posts_from_past_period' ] ) ) : 12;

        // Time only posts from the past
        $settings[ $name_prefix . 'under_posts_time_posts_from_past' ] = (isset($options[ $name_prefix . 'under_posts_time_posts_from_past' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_time_posts_from_past' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'under_posts_time_posts_from_past' ] ) : 'month';

        // Display only posts older than current post
        $options[ $name_prefix . 'under_posts_enable_posts_older_current_post' ] = ( isset($options[ $name_prefix . 'under_posts_enable_posts_older_current_post' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_enable_posts_older_current_post' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'under_posts_enable_posts_older_current_post' ] ) : 'off';
        $settings[ $name_prefix . 'under_posts_enable_posts_older_current_post' ] = (isset($options[ $name_prefix . 'under_posts_enable_posts_older_current_post' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_enable_posts_older_current_post' ] ) == 'on') ? true : false;

        // =============================================================
        // =====================   Relevance Tab   =====================
        // ========================     END     ========================

        // =======================  //  ======================= // ======================= // ======================= // ======================= //

        // =============================================================
        // ======================   Settings Tab   =====================
        // ========================    START    ========================

        // Show metabox
        $options[ $name_prefix . 'under_posts_enable_meta_box' ] = ( isset($options[ $name_prefix . 'under_posts_enable_meta_box' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_enable_meta_box' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'under_posts_enable_meta_box' ] ) : 'on';
        $settings[ $name_prefix . 'under_posts_enable_meta_box' ] = (isset($options[ $name_prefix . 'under_posts_enable_meta_box' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_enable_meta_box' ] ) == 'on') ? true : false;

        // Limit meta box to Admins only
        $options[ $name_prefix . 'under_posts_enable_meta_box_to_admin_only' ] = ( isset($options[ $name_prefix . 'under_posts_enable_meta_box_to_admin_only' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_enable_meta_box_to_admin_only' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'under_posts_enable_meta_box_to_admin_only' ] ) : 'off';
        $settings[ $name_prefix . 'under_posts_enable_meta_box_to_admin_only' ] = (isset($options[ $name_prefix . 'under_posts_enable_meta_box_to_admin_only' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_enable_meta_box_to_admin_only' ] ) == 'on') ? true : false;

        // Limit post title length
        $options[ $name_prefix . 'under_posts_enable_post_title_length' ] = ( isset($options[ $name_prefix . 'under_posts_enable_post_title_length' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_enable_post_title_length' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'under_posts_enable_post_title_length' ] ) : 'off';
        $settings[ $name_prefix . 'under_posts_enable_post_title_length' ] = (isset($options[ $name_prefix . 'under_posts_enable_post_title_length' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_enable_post_title_length' ] ) == 'on') ? true : false;

        // Limit post title length count
        $settings[ $name_prefix . 'under_posts_post_title_length' ] = (isset($options[ $name_prefix . 'under_posts_post_title_length' ]) &&  sanitize_text_field( $options[ $name_prefix . 'under_posts_post_title_length' ] ) != '' &&  sanitize_text_field( $options[ $name_prefix . 'under_posts_post_title_length' ] ) != 0 ) ? absint( sanitize_text_field( $options[ $name_prefix . 'under_posts_post_title_length' ] ) ) : 60;

        // Limit post title length type
        $settings[ $name_prefix . 'under_posts_post_title_type' ] = (isset($options[ $name_prefix . 'under_posts_post_title_type' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_post_title_type' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'under_posts_post_title_type' ] ) : 'in_characters';

        // Show date
        $options[ $name_prefix . 'under_posts_show_date' ] = ( isset($options[ $name_prefix . 'under_posts_show_date' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_show_date' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'under_posts_show_date' ] ) : 'off';
        $settings[ $name_prefix . 'under_posts_show_date' ] = (isset($options[ $name_prefix . 'under_posts_show_date' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_show_date' ] ) == 'on') ? true : false;

        // Show author
        $options[ $name_prefix . 'under_posts_show_author' ] = ( isset($options[ $name_prefix . 'under_posts_show_author' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_show_author' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'under_posts_show_author' ] ) : 'off';
        $settings[ $name_prefix . 'under_posts_show_author' ] = (isset($options[ $name_prefix . 'under_posts_show_author' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_show_author' ] ) == 'on') ? true : false;

        // Show author
        $options[ $name_prefix . 'under_posts_links_on_new_window' ] = ( isset($options[ $name_prefix . 'under_posts_links_on_new_window' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_links_on_new_window' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'under_posts_links_on_new_window' ] ) : 'off';
        $settings[ $name_prefix . 'under_posts_links_on_new_window' ] = (isset($options[ $name_prefix . 'under_posts_links_on_new_window' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_links_on_new_window' ] ) == 'on') ? true : false;

        // Show post excerpt
        $options[ $name_prefix . 'under_posts_enable_post_excerpt' ] = ( isset($options[ $name_prefix . 'under_posts_enable_post_excerpt' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_enable_post_excerpt' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'under_posts_enable_post_excerpt' ] ) : 'off';
        $settings[ $name_prefix . 'under_posts_enable_post_excerpt' ] = (isset($options[ $name_prefix . 'under_posts_enable_post_excerpt' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_enable_post_excerpt' ] ) == 'on') ? true : false;

        // Show post excerpt length
        $settings[ $name_prefix . 'under_posts_post_excerpt_length' ] = (isset($options[ $name_prefix . 'under_posts_post_excerpt_length' ]) &&  sanitize_text_field( $options[ $name_prefix . 'under_posts_post_excerpt_length' ] ) != '' &&  sanitize_text_field( $options[ $name_prefix . 'under_posts_post_excerpt_length' ] ) != 0 ) ? absint( sanitize_text_field( $options[ $name_prefix . 'under_posts_post_excerpt_length' ] ) ) : 60;

        // Show post excerpt type
        $settings[ $name_prefix . 'under_posts_post_excerpt_type' ] = (isset($options[ $name_prefix . 'under_posts_post_excerpt_type' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_post_excerpt_type' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'under_posts_post_excerpt_type' ] ) : 'in_characters';

        // Title of the box
        $settings[ $name_prefix . 'under_posts_box_title' ] = (isset($options[ $name_prefix . 'under_posts_box_title' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_box_title' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'under_posts_box_title' ] ) : __( 'Related Posts' , ADVANCED_RELATED_POSTS_NAME );

        // Show when no posts are found
        $settings[ $name_prefix . 'under_posts_no_post_found' ] = (isset($options[ $name_prefix . 'under_posts_no_post_found' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_no_post_found' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'under_posts_no_post_found' ] ) : 'blank_output';

        // Dispaly custom text 
        $settings[ $name_prefix . 'under_posts_no_post_found_custom_text' ] = (isset($options[ $name_prefix . 'under_posts_no_post_found_custom_text' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_no_post_found_custom_text' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'under_posts_no_post_found_custom_text' ] ) : __( 'No related posts found' , ADVANCED_RELATED_POSTS_NAME );

        // Disable on mobile devices
        $options[ $name_prefix . 'under_posts_display_on_mobile' ] = ( isset($options[ $name_prefix . 'under_posts_display_on_mobile' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_display_on_mobile' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'under_posts_display_on_mobile' ] ) : 'off';
        $settings[ $name_prefix . 'under_posts_display_on_mobile' ] = (isset($options[ $name_prefix . 'under_posts_display_on_mobile' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_display_on_mobile' ] ) == 'on') ? true : false;


        // =============================================================
        // ======================   Settings Tab   =====================
        // ========================     END     ========================


        // =======================  //  ======================= // ======================= // ======================= // ======================= //

        // =============================================================
        // ======================    Styles Tab    =====================
        // ========================    START    ========================

        // Thumbnail Width / Height
        $options[ $name_prefix . 'under_posts_thumbnail_responsive_width_height' ] = ( isset($options[ $name_prefix . 'under_posts_thumbnail_responsive_width_height' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_thumbnail_responsive_width_height' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'under_posts_thumbnail_responsive_width_height' ] ) : 'on';
        $settings[ $name_prefix . 'under_posts_thumbnail_responsive_width_height' ] = (isset($options[ $name_prefix . 'under_posts_thumbnail_responsive_width_height' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_thumbnail_responsive_width_height' ] ) == 'on') ? true : false;


        // Responsive Width/Height Ratio
        $settings[ $name_prefix . 'under_posts_thumbnail_responsive_width_height_ratio' ] = (isset($options[ $name_prefix . 'under_posts_thumbnail_responsive_width_height_ratio' ]) &&  sanitize_text_field( $options[ $name_prefix . 'under_posts_thumbnail_responsive_width_height_ratio' ] ) != '' &&  sanitize_text_field( $options[ $name_prefix . 'under_posts_thumbnail_responsive_width_height_ratio' ] ) != 0 ) ? absint( sanitize_text_field( $options[ $name_prefix . 'under_posts_thumbnail_responsive_width_height_ratio' ] ) ) : 1;

        // Thumbnail width
        $settings[ $name_prefix . 'under_posts_thumbnail_width' ] = (isset($options[ $name_prefix . 'under_posts_thumbnail_width' ]) &&  sanitize_text_field( $options[ $name_prefix . 'under_posts_thumbnail_width' ] ) != '' &&  sanitize_text_field( $options[ $name_prefix . 'under_posts_thumbnail_width' ] ) != 0 ) ? absint( sanitize_text_field( $options[ $name_prefix . 'under_posts_thumbnail_width' ] ) ) : 300;

        // Thumbnail height
        $settings[ $name_prefix . 'under_posts_thumbnail_height' ] = (isset($options[ $name_prefix . 'under_posts_thumbnail_height' ]) &&  sanitize_text_field( $options[ $name_prefix . 'under_posts_thumbnail_height' ] ) != '' &&  sanitize_text_field( $options[ $name_prefix . 'under_posts_thumbnail_height' ] ) != 0 ) ? absint( sanitize_text_field( $options[ $name_prefix . 'under_posts_thumbnail_height' ] ) ) : 300;

        // Thumbnail size
        $settings[ $name_prefix . 'under_posts_thumbnail_size' ] = (isset($options[ $name_prefix . 'under_posts_thumbnail_size' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_thumbnail_size' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'under_posts_thumbnail_size' ] ) : 'medium_large';


        // Get first image
        $options[ $name_prefix . 'under_posts_first_image' ] = ( isset($options[ $name_prefix . 'under_posts_first_image' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_first_image' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'under_posts_first_image' ] ) : 'on';
        $settings[ $name_prefix . 'under_posts_first_image' ] = (isset($options[ $name_prefix . 'under_posts_first_image' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_first_image' ] ) == 'on') ? true : false;

        // Default thumbnail
        $settings[ $name_prefix . 'under_posts_default_thumbnail' ] = ( isset($options[ $name_prefix . 'under_posts_default_thumbnail' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_default_thumbnail' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'under_posts_default_thumbnail' ] ) : $default_thumbnail;

        // Custom Class
        $settings[ $name_prefix . 'under_posts_custom_class' ] = ( isset($options[ $name_prefix . 'under_posts_custom_class' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_custom_class' ] ) != '' ) ? stripslashes( sanitize_text_field( $options[ $name_prefix . 'under_posts_custom_class' ] ) ) : '';

        // Layouts
        $settings[ $name_prefix . 'under_posts_layouts' ] = ( isset($options[ $name_prefix . 'under_posts_layouts' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_layouts' ] ) != '' ) ? stripslashes( sanitize_text_field( $options[ $name_prefix . 'under_posts_layouts' ] ) ) : 'elegant';

        // Thumbnail columns count
        $settings[ $name_prefix . 'under_posts_thumbnail_columns_count' ] = ( isset($options[ $name_prefix . 'under_posts_thumbnail_columns_count' ]) && absint(sanitize_text_field( $options[ $name_prefix . 'under_posts_thumbnail_columns_count' ] ) ) != '') ? absint(sanitize_text_field( $options[ $name_prefix . 'under_posts_thumbnail_columns_count' ] )) : 3;

        // Text Color
        $settings[ $name_prefix . 'under_posts_text_color' ] = ( isset($options[ $name_prefix . 'under_posts_text_color' ]) && sanitize_text_field( $options[ $name_prefix . 'under_posts_text_color' ] ) != '') ? stripslashes( sanitize_text_field( $options[ $name_prefix . 'under_posts_text_color' ] ) ) : '#333';

        // =============================================================
        // ======================    Styles Tab    =====================
        // ========================     END     ========================

        return $settings;
    }

    public static function get_arp_widget_validated_data_from_array(){
        global $wpdb;

        // Array for related posts validated options
        $settings = array();
        $options = array();
        $name_prefix = 'arp_';

        $default_thumbnail = ADVANCED_RELATED_POSTS_ADMIN_URL . '/images/icons/icon-arp-default.png';

        $results = Advanced_Related_Posts_Settings_Actions::ays_get_all_settings( 'widget' );

        $options = array();
        foreach($results as $o_key => $o_value){
            if(isset($o_value)){
                $meta_key   = isset($o_value['meta_key']) ? $o_value['meta_key'] : "";
                $meta_value = isset($o_value['meta_value']) ? $o_value['meta_value'] : "";
                $options[$meta_key] = $meta_value;
            }
        }
        // Under posts count
        $settings[ $name_prefix . 'widget_count' ] = (isset($options[ $name_prefix . 'widget_count' ]) &&  sanitize_text_field( $options[ $name_prefix . 'widget_count' ] ) != '' &&  sanitize_text_field( $options[ $name_prefix . 'widget_count' ] ) != 0 ) ? absint( sanitize_text_field( $options[ $name_prefix . 'widget_count' ] ) ) : 3;

        // Enable for all post types
        $options[ $name_prefix . 'widget_all_post_type' ] = ( isset($options[ $name_prefix . 'widget_all_post_type' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_all_post_type' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'widget_all_post_type' ] ) : 'on';
        $settings[ $name_prefix . 'widget_all_post_type' ] = (isset($options[ $name_prefix . 'widget_all_post_type' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_all_post_type' ] ) == 'on') ? true : false;

        // For selected post types
        $settings[ $name_prefix . 'widget_selected_post_type' ] = ( isset($options[ $name_prefix . 'widget_selected_post_type' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_selected_post_type' ] ) != '' ) ? array_map('sanitize_text_field', json_decode( sanitize_text_field( $options[ $name_prefix . 'widget_selected_post_type' ] ) , true) ) : array();

        // Exclude for categories
        $settings[ $name_prefix . 'widget_exclude_categories_ids' ] = ( isset($options[ $name_prefix . 'widget_exclude_categories_ids' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_exclude_categories_ids' ] ) != '' ) ? array_map('sanitize_text_field', json_decode( sanitize_text_field( $options[ $name_prefix . 'widget_exclude_categories_ids' ] ) , true) ) : array();

        // Exclude posts ids
        $settings[ $name_prefix . 'widget_exclude_post_ids' ] = (isset($options[ $name_prefix . 'widget_exclude_post_ids' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_exclude_post_ids' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'widget_exclude_post_ids' ] ) : '';


        // Display on the front page
        $options[ $name_prefix . 'widget_display_front_page' ] = ( isset($options[ $name_prefix . 'widget_display_front_page' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_display_front_page' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'widget_display_front_page' ] ) : 'off';
        $settings[ $name_prefix . 'widget_display_front_page' ] = (isset($options[ $name_prefix . 'widget_display_front_page' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_display_front_page' ] ) == 'on') ? true : false;


        // =============================================================
        // ======================   General Tab   ======================
        // =======================     END      ========================


        // =======================  //  ======================= // ======================= // ======================= // ======================= //


        // =============================================================
        // =====================   Relevance Tab   =====================
        // ========================    START    ========================

        // Order posts query
        $settings[ $name_prefix . 'widget_order_posts_query' ] = (isset($options[ $name_prefix . 'widget_order_posts_query' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_order_posts_query' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'widget_order_posts_query' ] ) : 'relevance';

        // Only from same
        $settings[ $name_prefix . 'widget_only_from_same' ] = ( isset($options[ $name_prefix . 'widget_only_from_same' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_only_from_same' ] ) != '' ) ? array_map( 'sanitize_text_field', json_decode( sanitize_text_field( $options[ $name_prefix . 'widget_only_from_same' ] ) , true) ) : array('same_post_type');

        // Strongness of matching
        $settings[ $name_prefix . 'widget_strongness_of_matching' ] = (isset($options[ $name_prefix . 'widget_strongness_of_matching' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_strongness_of_matching' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'widget_strongness_of_matching' ] ) : 'gradually_weakening';

        // Limit to same author
        $options[ $name_prefix . 'widget_limit_to_same_author' ] = ( isset($options[ $name_prefix . 'widget_limit_to_same_author' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_limit_to_same_author' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'widget_limit_to_same_author' ] ) : 'off';
        $settings[ $name_prefix . 'widget_limit_to_same_author' ] = (isset($options[ $name_prefix . 'widget_limit_to_same_author' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_limit_to_same_author' ] ) == 'on') ? true : false;

        // Display Order results
        $settings[ $name_prefix . 'widget_display_order_results' ] = (isset($options[ $name_prefix . 'widget_display_order_results' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_display_order_results' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'widget_display_order_results' ] ) : 'default';

        // Category exclude IDs
        $settings[ $name_prefix . 'widget_general_exclude_cat_ids' ] = (isset($options[ $name_prefix . 'widget_general_exclude_cat_ids' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_general_exclude_cat_ids' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'widget_general_exclude_cat_ids' ] ) : '';

        // Post/page IDs to exclude
        $settings[ $name_prefix . 'widget_general_exclude_post_ids' ] = (isset($options[ $name_prefix . 'widget_general_exclude_post_ids' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_general_exclude_post_ids' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'widget_general_exclude_post_ids' ] ) : '';

        // Display only posts from the past
        $options[ $name_prefix . 'widget_enable_posts_from_past' ] = ( isset($options[ $name_prefix . 'widget_enable_posts_from_past' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_enable_posts_from_past' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'widget_enable_posts_from_past' ] ) : 'off';
        $settings[ $name_prefix . 'widget_enable_posts_from_past' ] = (isset($options[ $name_prefix . 'widget_enable_posts_from_past' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_enable_posts_from_past' ] ) == 'on') ? true : false;


        // Count only posts from the past
        $settings[ $name_prefix . 'widget_posts_from_past_period' ] = (isset($options[ $name_prefix . 'widget_posts_from_past_period' ]) &&  sanitize_text_field( $options[ $name_prefix . 'widget_posts_from_past_period' ] ) != '' &&  sanitize_text_field( $options[ $name_prefix . 'widget_posts_from_past_period' ] ) != 0 ) ? absint( sanitize_text_field( $options[ $name_prefix . 'widget_posts_from_past_period' ] ) ) : 12;

        // Time only posts from the past
        $settings[ $name_prefix . 'widget_time_posts_from_past' ] = (isset($options[ $name_prefix . 'widget_time_posts_from_past' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_time_posts_from_past' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'widget_time_posts_from_past' ] ) : 'month';

        // Display only posts older than current post
        $options[ $name_prefix . 'widget_enable_posts_older_current_post' ] = ( isset($options[ $name_prefix . 'widget_enable_posts_older_current_post' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_enable_posts_older_current_post' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'widget_enable_posts_older_current_post' ] ) : 'off';
        $settings[ $name_prefix . 'widget_enable_posts_older_current_post' ] = (isset($options[ $name_prefix . 'widget_enable_posts_older_current_post' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_enable_posts_older_current_post' ] ) == 'on') ? true : false;

        // =============================================================
        // =====================   Relevance Tab   =====================
        // ========================     END     ========================

        // =======================  //  ======================= // ======================= // ======================= // ======================= //

        // =============================================================
        // ======================   Settings Tab   =====================
        // ========================    START    ========================

        // Limit post title length
        $options[ $name_prefix . 'widget_enable_post_title_length' ] = ( isset($options[ $name_prefix . 'widget_enable_post_title_length' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_enable_post_title_length' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'widget_enable_post_title_length' ] ) : 'off';
        $settings[ $name_prefix . 'widget_enable_post_title_length' ] = (isset($options[ $name_prefix . 'widget_enable_post_title_length' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_enable_post_title_length' ] ) == 'on') ? true : false;

        // Limit post title length count
        $settings[ $name_prefix . 'widget_post_title_length' ] = (isset($options[ $name_prefix . 'widget_post_title_length' ]) &&  sanitize_text_field( $options[ $name_prefix . 'widget_post_title_length' ] ) != '' &&  sanitize_text_field( $options[ $name_prefix . 'widget_post_title_length' ] ) != 0 ) ? absint( sanitize_text_field( $options[ $name_prefix . 'widget_post_title_length' ] ) ) : 60;

        // Limit post title length type
        $settings[ $name_prefix . 'widget_post_title_type' ] = (isset($options[ $name_prefix . 'widget_post_title_type' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_post_title_type' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'widget_post_title_type' ] ) : 'in_characters';

        // Show date
        $options[ $name_prefix . 'widget_show_date' ] = ( isset($options[ $name_prefix . 'widget_show_date' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_show_date' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'widget_show_date' ] ) : 'off';
        $settings[ $name_prefix . 'widget_show_date' ] = (isset($options[ $name_prefix . 'widget_show_date' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_show_date' ] ) == 'on') ? true : false;

        // Show author
        $options[ $name_prefix . 'widget_show_author' ] = ( isset($options[ $name_prefix . 'widget_show_author' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_show_author' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'widget_show_author' ] ) : 'off';
        $settings[ $name_prefix . 'widget_show_author' ] = (isset($options[ $name_prefix . 'widget_show_author' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_show_author' ] ) == 'on') ? true : false;

        // Show author
        $options[ $name_prefix . 'widget_links_on_new_window' ] = ( isset($options[ $name_prefix . 'widget_links_on_new_window' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_links_on_new_window' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'widget_links_on_new_window' ] ) : 'off';
        $settings[ $name_prefix . 'widget_links_on_new_window' ] = (isset($options[ $name_prefix . 'widget_links_on_new_window' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_links_on_new_window' ] ) == 'on') ? true : false;

        // Show post excerpt
        $options[ $name_prefix . 'widget_enable_post_excerpt' ] = ( isset($options[ $name_prefix . 'widget_enable_post_excerpt' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_enable_post_excerpt' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'widget_enable_post_excerpt' ] ) : 'off';
        $settings[ $name_prefix . 'widget_enable_post_excerpt' ] = (isset($options[ $name_prefix . 'widget_enable_post_excerpt' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_enable_post_excerpt' ] ) == 'on') ? true : false;

        // Show post excerpt length
        $settings[ $name_prefix . 'widget_post_excerpt_length' ] = (isset($options[ $name_prefix . 'widget_post_excerpt_length' ]) &&  sanitize_text_field( $options[ $name_prefix . 'widget_post_excerpt_length' ] ) != '' &&  sanitize_text_field( $options[ $name_prefix . 'widget_post_excerpt_length' ] ) != 0 ) ? absint( sanitize_text_field( $options[ $name_prefix . 'widget_post_excerpt_length' ] ) ) : 60;

        // Show post excerpt type
        $settings[ $name_prefix . 'widget_post_excerpt_type' ] = (isset($options[ $name_prefix . 'widget_post_excerpt_type' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_post_excerpt_type' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'widget_post_excerpt_type' ] ) : 'in_characters';

        // Title of the box
        $settings[ $name_prefix . 'widget_box_title' ] = (isset($options[ $name_prefix . 'widget_box_title' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_box_title' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'widget_box_title' ] ) : __( 'Related Posts' , ADVANCED_RELATED_POSTS_NAME );

        // Show when no posts are found
        $settings[ $name_prefix . 'widget_no_post_found' ] = (isset($options[ $name_prefix . 'widget_no_post_found' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_no_post_found' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'widget_no_post_found' ] ) : 'blank_output';

        // Dispaly custom text 
        $settings[ $name_prefix . 'widget_no_post_found_custom_text' ] = (isset($options[ $name_prefix . 'widget_no_post_found_custom_text' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_no_post_found_custom_text' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'widget_no_post_found_custom_text' ] ) : __( 'No related posts found' , ADVANCED_RELATED_POSTS_NAME );

        // Disable on mobile devices
        $options[ $name_prefix . 'widget_display_on_mobile' ] = ( isset($options[ $name_prefix . 'widget_display_on_mobile' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_display_on_mobile' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'widget_display_on_mobile' ] ) : 'off';
        $settings[ $name_prefix . 'widget_display_on_mobile' ] = (isset($options[ $name_prefix . 'widget_display_on_mobile' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_display_on_mobile' ] ) == 'on') ? true : false;


        // =============================================================
        // ======================   Settings Tab   =====================
        // ========================     END     ========================


        // =======================  //  ======================= // ======================= // ======================= // ======================= //

        // =============================================================
        // ======================    Styles Tab    =====================
        // ========================    START    ========================

        // Thumbnail Width / Height
        $options[ $name_prefix . 'widget_thumbnail_responsive_width_height' ] = ( isset($options[ $name_prefix . 'widget_thumbnail_responsive_width_height' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_responsive_width_height' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_responsive_width_height' ] ) : 'on';
        $settings[ $name_prefix . 'widget_thumbnail_responsive_width_height' ] = (isset($options[ $name_prefix . 'widget_thumbnail_responsive_width_height' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_responsive_width_height' ] ) == 'on') ? true : false;


        // Responsive Width/Height Ratio
        $settings[ $name_prefix . 'widget_thumbnail_responsive_width_height_ratio' ] = (isset($options[ $name_prefix . 'widget_thumbnail_responsive_width_height_ratio' ]) &&  sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_responsive_width_height_ratio' ] ) != '' &&  sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_responsive_width_height_ratio' ] ) != 0 ) ? absint( sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_responsive_width_height_ratio' ] ) ) : 1;

        // Thumbnail width
        $settings[ $name_prefix . 'widget_thumbnail_width' ] = (isset($options[ $name_prefix . 'widget_thumbnail_width' ]) &&  sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_width' ] ) != '' &&  sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_width' ] ) != 0 ) ? absint( sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_width' ] ) ) : 300;

        // Thumbnail height
        $settings[ $name_prefix . 'widget_thumbnail_height' ] = (isset($options[ $name_prefix . 'widget_thumbnail_height' ]) &&  sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_height' ] ) != '' &&  sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_height' ] ) != 0 ) ? absint( sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_height' ] ) ) : 300;

        // Thumbnail size
        $settings[ $name_prefix . 'widget_thumbnail_size' ] = (isset($options[ $name_prefix . 'widget_thumbnail_size' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_size' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_size' ] ) : 'medium_large';


        // Get first image
        $options[ $name_prefix . 'widget_first_image' ] = ( isset($options[ $name_prefix . 'widget_first_image' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_first_image' ] ) != '' ) ? sanitize_text_field( $options[ $name_prefix . 'widget_first_image' ] ) : 'on';
        $settings[ $name_prefix . 'widget_first_image' ] = (isset($options[ $name_prefix . 'widget_first_image' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_first_image' ] ) == 'on') ? true : false;

        // Default thumbnail
        $settings[ $name_prefix . 'widget_default_thumbnail' ] = (isset($options[ $name_prefix . 'widget_default_thumbnail' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_default_thumbnail' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'widget_default_thumbnail' ] ) : $default_thumbnail;

        // Custom Class
        $settings[ $name_prefix . 'widget_custom_class' ] = ( isset($options[ $name_prefix . 'widget_custom_class' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_custom_class' ] ) != '' ) ? stripslashes( sanitize_text_field( $options[ $name_prefix . 'widget_custom_class' ] ) ) : '';

        // Layouts
        $settings[ $name_prefix . 'widget_layouts' ] = ( isset($options[ $name_prefix . 'widget_layouts' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_layouts' ] ) != '' ) ? stripslashes( sanitize_text_field( $options[ $name_prefix . 'widget_layouts' ] ) ) : 'elegant';

        // Thumbnail columns count
        $settings[ $name_prefix . 'widget_thumbnail_columns_count' ] = ( isset($options[ $name_prefix . 'widget_thumbnail_columns_count' ]) && absint(sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_columns_count' ] ) ) != '') ? absint(sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_columns_count' ] )) : 3;

        // Text Color
        $settings[ $name_prefix . 'widget_text_color' ] = ( isset($options[ $name_prefix . 'widget_text_color' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_text_color' ] ) != '') ? stripslashes( sanitize_text_field( $options[ $name_prefix . 'widget_text_color' ] ) ) : '#333';

        // =============================================================
        // ======================    Styles Tab    =====================
        // ========================     END     ========================

        return $settings;
    }

    public static function ays_arp_get_content_first_image( $id, $img = '' ) {
        $post = get_post( $id, "OBJECT" );

        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

        $first_img = ( isset( $matches [1] [0] ) && ! empty( $matches [1] [0] ) ) ? $matches [1] [0] : array();

        if(empty($first_img)){ //Defines a default image
            if ( ! empty( $img ) ) {
                $first_img = $img;
            }else {
                $first_img = ADVANCED_RELATED_POSTS_ADMIN_URL . '/images/icons/icon-arp-default.png';
            }
        }
        return $first_img;
    }

    public static function ays_arp_get_part_of_string( $string , $type = 'in_characters', $length = 60) {
        $str = '';
        if ( empty( $string ) ) {
            return $str;
        }

        $string = esc_attr( strip_tags( stripslashes( $string ) ) );
        $length = absint( $length );
        
        switch ( $type ) {
            case 'in_characters':
                if(strlen( $string ) <= $length ){
                    $str = $string;
                } else {
                    $str = substr( $string, 0, $length ) . '...';
                }
                break;
            case 'in_words':
                $pieces = explode( " ", $string );

                if( count( $pieces ) <= $length ){
                    $str = implode( " ", $pieces );
                } else {
                    $res = array_splice( $pieces, 0,  $length );
                    $str = implode( " ", $res ) . '...';
                }
                break;
            default:
                $str = substr( $string, 0, $length );
                break;
        }
        return $str;
    }

    public static function ays_arp_get_all_image_sizes() {
        global $_wp_additional_image_sizes;

        $image_sizes = array();
        $default_image_sizes = array( 'thumbnail', 'medium', 'medium_large', 'large' );

        foreach ( $default_image_sizes as $size ) {
            $image_sizes[$size]['width']    = intval( get_option( "{$size}_size_w") );
            $image_sizes[$size]['height'] = intval( get_option( "{$size}_size_h") );
            $image_sizes[$size]['crop'] = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
        }

        if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ){
            $image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
        }

        return $image_sizes;
    }

    public static function hex2rgba($color, $opacity = false){

        $default = 'rgb(0,0,0)';

        //Return default if no color provided
        if (empty($color))
            return $default;

        //Sanitize $color if "#" is provided
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }else{
            return $color;
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
            $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
        } elseif (strlen($color) == 3) {
            $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
        } else {
            return $default;
        }

        //Convert hexadec to rgb
        $rgb = array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if ($opacity) {
            if (abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
        } else {
            $output = 'rgb(' . implode(",", $rgb) . ')';
        }

        //Return rgb(a) color string
        return $output;
    }
}
