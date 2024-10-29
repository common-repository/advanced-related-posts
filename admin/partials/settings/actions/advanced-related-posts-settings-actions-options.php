<?php
$ays_tab = 'tab1';
    if(isset($_GET['tab'])){
        $ays_tab = sanitize_text_field($_GET['tab']);
    }

    $actions = $this->settings_obj;

    $ays_prefix        = 'ays_';
    $name_prefix       = 'arp_';
    $html_name_prefix  = 'ays_arp_';
    $class_prefix      = 'ays-arp-';

    $user_id = get_current_user_id();

    $options = array(
        // General Tab
        $name_prefix . 'widget_all_post_type' => 'on', 
        $name_prefix . 'widget_selected_post_type' => array(), 
        $name_prefix . 'widget_exclude_categories_ids' => array(), 
        $name_prefix . 'widget_exclude_post_ids' => '', 
        $name_prefix . 'widget_count' => 3,
        $name_prefix . 'widget_display_front_page' => 'off',

        //Relevance Tab
        $name_prefix . 'widget_order_posts_query' => 'relevance',
        $name_prefix . 'widget_only_from_same' => 'same_post_type',
        $name_prefix . 'widget_strongness_of_matching' => 'gradually_weakening',
        $name_prefix . 'widget_limit_to_same_author' => 'off',
        $name_prefix . 'widget_display_order_results' => 'default',
        $name_prefix . 'widget_general_exclude_cat_ids' => '',
        $name_prefix . 'widget_general_exclude_post_ids' => '',
        $name_prefix . 'widget_enable_posts_from_past' => 'off',
        $name_prefix . 'widget_posts_from_past_period' => 12,
        $name_prefix . 'widget_time_posts_from_past' => 'day',
        $name_prefix . 'widget_enable_posts_older_current_post' => 'off',

        //Settings tab
        $name_prefix . 'widget_enable_post_title_length' => 'off',
        $name_prefix . 'widget_post_title_length' => 60,
        $name_prefix . 'widget_post_title_type' => 'in_characters',
        $name_prefix . 'widget_show_date' => 'off',
        $name_prefix . 'widget_show_author' => 'off',
        $name_prefix . 'widget_links_on_new_window' => 'off',
        $name_prefix . 'widget_enable_post_excerpt' => 'off',
        $name_prefix . 'widget_post_excerpt_length' => 60,
        $name_prefix . 'widget_post_excerpt_type' => 'in_characters',
        $name_prefix . 'widget_box_title' => __( 'Related Posts' , $this->plugin_name ),
        $name_prefix . 'widget_no_post_found' => 'blank_output',
        $name_prefix . 'widget_no_post_found_custom_text' => __( "No related posts found" , $this->plugin_name ),
        $name_prefix . 'widget_display_on_mobile' => 'off',
        
        // Style Tab
        $name_prefix . 'widget_thumbnail_responsive_width_height' => 'on',
        $name_prefix . 'widget_thumbnail_responsive_width_height_ratio' => 1,
        $name_prefix . 'widget_thumbnail_width' => 300,
        $name_prefix . 'widget_thumbnail_height' => 300,
        $name_prefix . 'widget_thumbnail_size' => 'medium_large',
        $name_prefix . 'widget_default_thumbnail' => '',
        $name_prefix . 'widget_first_image' => 'on',
        $name_prefix . 'widget_custom_class' => '',
        $name_prefix . 'widget_layouts' => '',
        $name_prefix . 'widget_thumbnail_columns_count' => 3,
        $name_prefix . 'widget_text_color' => '#333',

    );

    $heading = __( 'Related posts', $this->plugin_name );
    $default_image_text = __('Edit Image', $this->plugin_name);

    if( isset($_POST['ays_apply']) || isset($_POST['ays_apply_top']) ){
        $_POST[ $html_name_prefix . 'type' ] = 'widget';
        $actions->store_data();
    }

    $loader_iamge = '<span class="display_none ays_arp_loader_box"><img src="'. ADVANCED_RELATED_POSTS_ADMIN_URL .'/images/loaders/loading.gif"></span>';
    $default_thumbnail = ADVANCED_RELATED_POSTS_ADMIN_URL . '/images/icons/icon-arp-default.png';

    $ays_super_admin_email = get_option('admin_email');
    $wp_general_settings_url = admin_url( 'options-general.php' );

    $results = Advanced_Related_Posts_Settings_Actions::ays_get_all_settings( 'widget' );

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
    // ======================  General Tab  ========================
    // ========================    START   =========================

    // All Post Type
    $options[ $name_prefix . 'widget_all_post_type' ] = ( isset($options[ $name_prefix . 'widget_all_post_type' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_all_post_type' ] )) != '' ) ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_all_post_type' ] )) : 'on';
    
    $widget_all_post_type = (isset($options[ $name_prefix . 'widget_all_post_type' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_all_post_type' ] ) == 'on') ? true : false;
    
    //Selected post type
    $widget_post_types = get_post_types(array( 'public' => true,));
    unset( $widget_post_types['attachment'] );

    $widget_selected_post_types = ( isset($options[ $name_prefix . 'widget_selected_post_type' ]) && sanitize_text_field($options[ $name_prefix . 'widget_selected_post_type' ]) != '' ) ? array_map( 'sanitize_text_field',json_decode($options[ $name_prefix . 'widget_selected_post_type' ],true)) : array();

    //Exclude by category 
    $categories_post_types = array();
    foreach ($widget_post_types as $key => $widget_post_type) {
        $get_posts_by_post_types = get_posts(array('post_type' => $widget_post_type));
        $post_types = array();
        foreach ($get_posts_by_post_types as $key => $get_posts_by_post_type) {
            $post_id = $get_posts_by_post_type->ID;
            $post_types = $get_posts_by_post_type->post_type;
            $category_post_type = array();
            $categories = get_the_category($post_id);
            foreach ($categories as $key => $category) {
                $category_post_type[$post_types] = $category->cat_name;
                $categories_post_types[$category->cat_ID]= $category_post_type;
            }
        }
    }
    $widget_exclude_categories = ( isset($options[ $name_prefix . 'widget_exclude_categories_ids' ]) && sanitize_text_field($options[ $name_prefix . 'widget_exclude_categories_ids' ])  != '' ) ? array_map( 'sanitize_text_field',json_decode($options[ $name_prefix . 'widget_exclude_categories_ids' ],true)) : array();

    //Exclude Post IDs
    $widget_exclude_post_ids = ( isset($options[ $name_prefix . 'widget_exclude_post_ids' ]) && sanitize_text_field($options[ $name_prefix . 'widget_exclude_post_ids' ])  != '' ) ? sanitize_text_field($options[ $name_prefix . 'widget_exclude_post_ids' ]) : '';

    // Widget Count
    $widget_count = (isset($options[ $name_prefix . 'widget_count' ]) && sanitize_text_field($options[ $name_prefix . 'widget_count' ]) != '') ? absint( intval( $options[ $name_prefix . 'widget_count' ] ) ) : 3;

    //Display On Front Page
    $options[ $name_prefix . 'widget_display_front_page' ] = ( isset($options[ $name_prefix . 'widget_display_front_page' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_display_front_page' ] )) != '' ) ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_display_front_page' ] )) : 'off';
    
    $widget_display_front_page = (isset($options[ $name_prefix . 'widget_display_front_page' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_display_front_page' ] )) == 'on') ? true : false;

    //Enable/Dispable Post Type options
    $widget_enable_post_type_options = $widget_all_post_type ? $class_prefix.'enable-disable-options-div' : '';

    // =============================================================
    // ======================  General Tab  ========================
    // ========================     END     ========================
    
    // =======================  //  ======================= // ======================= // ======================= // ======================= //

    // =============================================================
    // ======================  Relevance Tab  ======================
    // ========================    START   =========================

    //Order posts query
    $order_posts_query_array = array(
        'relevance'    => __( 'By relevance', $this->plugin_name ),
        'random'       => __( 'Randomly', $this->plugin_name ),
        'by_date'      => __( 'By date', $this->plugin_name ),
    );
   
    $widget_order_posts_query = (isset($options[ $name_prefix . 'widget_order_posts_query' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_order_posts_query' ] )) != '') ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_order_posts_query' ] )) : 'relevance';
    
    //Only from same type
    $only_from_same_type_array = array(
        'same_post_type'  => __( 'Same post type', $this->plugin_name ),
        'categories'      => __( 'Categories', $this->plugin_name ),
        'post_tag'        => __( 'Post tag', $this->plugin_name ),
        'post_format'     => __( 'Post format', $this->plugin_name ),
    );
    
    $widget_only_from_same_type = (isset($options[ $name_prefix . 'widget_only_from_same' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_only_from_same' ] )) != '' ) ? array_map('sanitize_text_field',json_decode($options[ $name_prefix . 'widget_only_from_same' ],true) ) : array('same_post_type');
    
    //Strongness of matching
    $strongness_of_matching_array = array(
        'gradually_weakening' => __( 'Gradually Weakening', $this->plugin_name ),
        'and'                 => __( 'And', $this->plugin_name ),
        'or'                  => __( 'Or', $this->plugin_name ),
    );
   
    $widget_strongness_of_matching = (isset($options[ $name_prefix . 'widget_strongness_of_matching' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_strongness_of_matching' ] )) != '') ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_strongness_of_matching' ] )) : 'gradually_weakening';

    //Limit to same author 
    $options[ $name_prefix . 'widget_limit_to_same_author' ] = ( isset($options[ $name_prefix . 'widget_limit_to_same_author' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_limit_to_same_author' ] )) != '' ) ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_limit_to_same_author' ] )) : 'off';
    
    $widget_limit_to_same_author = (isset($options[ $name_prefix . 'widget_limit_to_same_author' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_limit_to_same_author' ] )) == 'on') ? true : false;
    
    
    //Display Order results 
    $display_order_results_array = array(
        'default'    => __( 'Default ', $this->plugin_name ),
        'new_to_old' => __( 'Date (new to old)', $this->plugin_name ),
        'old_to_new' => __( 'Date (old to new)', $this->plugin_name ),
        'asc'        => __( 'Title (alphabetical ASC)', $this->plugin_name ),
        'desc'       => __( 'Title (alphabetical DESC)', $this->plugin_name ),
        'random'     => __( 'Random', $this->plugin_name ),
    );
    
    $widget_display_order_results = (isset($options[ $name_prefix . 'widget_display_order_results' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_display_order_results' ] )) != '') ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_display_order_results' ] )) : 'default';
    
    //Exclude category ids
    $widget_general_exclude_cat_ids = (isset($options[ $name_prefix . 'widget_general_exclude_cat_ids' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_general_exclude_cat_ids' ] )) != '') ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_general_exclude_cat_ids' ] )) : '';
    
    //Exclude post ids
    $widget_general_exclude_post_ids = (isset($options[ $name_prefix . 'widget_general_exclude_post_ids' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_general_exclude_post_ids' ] )) != '') ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_general_exclude_post_ids' ] )) : '';
    
    //Display post from past
    //Enable post from the past
    $options[ $name_prefix . 'widget_enable_posts_from_past' ] = ( isset($options[ $name_prefix . 'widget_enable_posts_from_past' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_enable_posts_from_past' ] )) != '' ) ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_enable_posts_from_past' ] )) : 'off';
    
    $widget_enable_posts_from_past = (isset($options[ $name_prefix . 'widget_enable_posts_from_past' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_enable_posts_from_past' ] )) == 'on') ? true : false;
    
    //Number of the past period
    $widget_posts_from_past_period = (isset($options[ $name_prefix . 'widget_posts_from_past_period' ]) && absint(sanitize_text_field( $options[ $name_prefix . 'widget_posts_from_past_period' ] )) != '') ? absint(sanitize_text_field( $options[ $name_prefix . 'widget_posts_from_past_period' ] )) : 12;
    
    //Period name
    $period_time_array = array(
        'day'   => __( 'Day(s)', $this->plugin_name ),
        'week'  => __( 'Week(s)', $this->plugin_name ),
        'month' => __( 'Month(s)', $this->plugin_name ),
    );
    
    $widget_time_posts_from_past = (isset($options[ $name_prefix . 'widget_time_posts_from_past' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_time_posts_from_past' ] )) != '') ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_time_posts_from_past' ] )) : 'day';
    
    //Display only posts older than current post
    $options[ $name_prefix . 'widget_enable_posts_older_current_post' ] = ( isset($options[ $name_prefix . 'widget_enable_posts_older_current_post' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_enable_posts_older_current_post' ] )) != '' ) ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_enable_posts_older_current_post' ] )) : 'off';
    
    $widget_enable_posts_older_current_post  = (isset($options[ $name_prefix . 'widget_enable_posts_older_current_post']) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_enable_posts_older_current_post' ] )) == 'on') ? true : false;
    
    // =============================================================
    // ======================  Relevance Tab  ======================
    // ========================     END     ========================
    
    // =======================  //  ======================= // ======================= // ======================= // ======================= //
    
    // =============================================================
    // ======================  Settings Tab  =======================
    // ========================    START   =========================
    
    
    //Limit post and post title length type
    $post_length_type_array = array(
        'in_characters' => __( 'In characters', $this->plugin_name ),
        'in_words'      => __( 'In words', $this->plugin_name ),
    );
    
    //Limit post title length
    //Enable Limit post title length
    $options[ $name_prefix . 'widget_enable_post_length' ] = ( isset($options[ $name_prefix . 'widget_enable_post_title_length' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_enable_post_title_length' ] )) != '' ) ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_enable_post_title_length' ] )) : 'off';
    
    $widget_enable_post_title_length = (isset($options[ $name_prefix . 'widget_enable_post_title_length' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_enable_post_title_length' ] )) == 'on') ? true : false;

    //Limit post title length
    $widget_post_title_length = (isset($options[ $name_prefix . 'widget_post_title_length' ]) && absint(sanitize_text_field( $options[ $name_prefix . 'widget_post_title_length' ] )) != '') ? absint(sanitize_text_field( $options[ $name_prefix . 'widget_post_title_length' ] )) : 60;
    
    //Limit post title type
    $widget_post_title_type = (isset($options[ $name_prefix . 'widget_post_title_type' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_post_title_type' ] )) != '') ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_post_title_type' ] )) : 'in_characters';

    //Show date 
    $options[ $name_prefix . 'widget_show_date' ] = ( isset($options[ $name_prefix . 'widget_show_date' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_show_date' ] )) != '' ) ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_show_date' ] )) : 'off';
    
    $widget_show_date  = (isset($options[ $name_prefix . 'widget_show_date']) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_show_date' ] )) == 'on') ? true : false;
    
    //Show Author
    $options[ $name_prefix . 'widget_show_author' ] = ( isset($options[ $name_prefix . 'widget_show_author' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_show_author' ] )) != '' ) ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_show_author' ] )) : 'off';
    
    $widget_show_author  = (isset($options[ $name_prefix . 'widget_show_author']) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_show_author' ] )) == 'on') ? true : false;
    
    //Open links in new window
    $options[ $name_prefix . 'widget_links_on_new_window' ] = ( isset($options[ $name_prefix . 'widget_links_on_new_window' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_links_on_new_window' ] )) != '' ) ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_links_on_new_window' ] )) : 'off';
    
    $widget_links_on_new_window  = (isset($options[ $name_prefix . 'widget_links_on_new_window']) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_links_on_new_window' ] )) == 'on') ? true : false;
    
    //Limit post length
    //Enable Limit post length
    $options[ $name_prefix . 'widget_enable_post_excerpt' ] = ( isset($options[ $name_prefix . 'widget_enable_post_excerpt' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_enable_post_excerpt' ] )) != '' ) ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_enable_post_excerpt' ] )) : 'off';
    
    $widget_enable_post_excerpt = (isset($options[ $name_prefix . 'widget_enable_post_excerpt' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_enable_post_excerpt' ] )) == 'on') ? true : false;
    
    //Limit post length
    $widget_post_excerpt_length = (isset($options[ $name_prefix . 'widget_post_excerpt_length' ]) && absint(sanitize_text_field( $options[ $name_prefix . 'widget_post_excerpt_length' ] )) != '') ? absint(sanitize_text_field( $options[ $name_prefix . 'widget_post_excerpt_length' ] )) : 60;
    
    $widget_post_excerpt_type = (isset($options[ $name_prefix . 'widget_post_excerpt_type' ]) && sanitize_text_field( $options[ $name_prefix . 'widget_post_excerpt_type' ] ) != '') ? sanitize_text_field( $options[ $name_prefix . 'widget_post_excerpt_type' ] ) : 'in_characters';
    
    //Title of the box
    $widget_box_title = (isset($options[ $name_prefix . 'widget_box_title' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_box_title' ] )) != '') ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_box_title' ] )) : __( "Related Posts" , $this->plugin_name );
    
    //Show when no posts are found
    $widget_no_post_found = (isset($options[ $name_prefix . 'widget_no_post_found' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_no_post_found' ] )) != '') ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_no_post_found' ] )) : 'blank_output';

    //Custom text content
    $widget_no_post_found_custom_text = (isset($options[ $name_prefix . 'widget_no_post_found_custom_text' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_no_post_found_custom_text' ] )) != '') ? wpautop(stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_no_post_found_custom_text' ] ))) : __( "No related posts found" , $this->plugin_name );

    //Disable on mobile devices
    $options[ $name_prefix . 'widget_display_on_mobile' ] = ( isset($options[ $name_prefix . 'widget_display_on_mobile' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_display_on_mobile' ] )) != '' ) ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_display_on_mobile' ] )) : 'off';
    
    $widget_display_on_mobile  = (isset($options[ $name_prefix . 'widget_display_on_mobile']) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_display_on_mobile' ] )) == 'on') ? true : false;

    // =============================================================
    // ======================  Settings Tab  =======================
    // ========================     END     ========================

    // =======================  //  ======================= // ======================= // ======================= // ======================= //

    // =============================================================
    // ======================    Styles Tab    =====================
    // ========================    START    ========================

    $thumbnail_size_array = Advanced_Related_Posts_Data::ays_arp_get_all_image_sizes();

    //Responsive Width / Height
    $options[ $name_prefix . 'widget_thumbnail_responsive_width_height' ] = ( isset($options[ $name_prefix . 'widget_thumbnail_responsive_width_height' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_responsive_width_height' ] )) != '' ) ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_responsive_width_height' ] )) : 'on';
    
    $widget_thumbnail_responsive_width_height  = (isset($options[ $name_prefix . 'widget_thumbnail_responsive_width_height']) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_responsive_width_height' ] )) == 'on') ? true : false;

    $widget_thumbnail_responsive_width_height_ratio = (isset($options[ $name_prefix . 'widget_thumbnail_responsive_width_height_ratio' ]) && absint(sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_responsive_width_height_ratio' ] )) != '') ? absint(sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_responsive_width_height_ratio' ] )) : 1;
    
    //Thumbnail Width / Height
    $widget_thumbnail_width = (isset($options[ $name_prefix . 'widget_thumbnail_width' ]) && absint(sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_width' ] )) != '') ? absint(sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_width' ] )) : 300;

    $widget_thumbnail_height = (isset($options[ $name_prefix . 'widget_thumbnail_height' ]) && absint(sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_height' ] )) != '') ? absint(sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_height' ] )) : 300;

    //Thumbnail size
    $widget_thumbnail_size = (isset($options[ $name_prefix . 'widget_thumbnail_size' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_size' ] )) != '') ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_size' ] )) : 'medium_large';
    
    //Get first image
    $options[ $name_prefix . 'widget_first_image' ] = ( isset($options[ $name_prefix . 'widget_first_image' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_first_image' ] )) != '' ) ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_first_image' ] )) : 'on';

    $widget_first_image = (isset($options[ $name_prefix . 'widget_first_image' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_first_image' ] )) == 'on' ) ? true : false;

    // Defaullt thumbnail
    $widget_default_thumbnail = (isset($options[ $name_prefix . 'widget_default_thumbnail' ]) && esc_url( $options[ $name_prefix . 'widget_default_thumbnail' ] ) != '') ? esc_url( $options[ $name_prefix . 'widget_default_thumbnail' ] ) : $default_thumbnail;

    // Custom Class
    $widget_custom_class = (isset($options[ $name_prefix . 'widget_custom_class' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_custom_class' ] )) != '') ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_custom_class' ] )) : '';
 
    // Layouts
    $widget_layouts = (isset($options[ $name_prefix . 'widget_layouts' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_layouts' ] )) != '') ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_layouts' ] )) : 'elegant';

    // Thumbnail columns count
    $widget_thumbnail_columns_count = (isset($options[ $name_prefix . 'widget_thumbnail_columns_count' ]) && absint(sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_columns_count' ] )) != '') ? absint(sanitize_text_field( $options[ $name_prefix . 'widget_thumbnail_columns_count' ] )) : 3;

    // Text color
    $widget_text_color = (isset($options[ $name_prefix . 'widget_text_color' ]) && stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_text_color' ] )) != '') ? stripslashes(sanitize_text_field( $options[ $name_prefix . 'widget_text_color' ] )) : '#333';

    // =============================================================
    // ======================    Styles Tab    =====================
    // ========================     END     ========================



    // =======================  //  ======================= // ======================= // ======================= // ======================= //