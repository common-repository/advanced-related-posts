<?php

class Advanced_Related_Posts_Widget extends WP_Widget {

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

    private $html_class_prefix = 'ays-arp-';
    private $html_name_prefix = 'ays-arp-';
    private $name_prefix = 'arp_';
    private $unique_id;
    private $unique_id_in_class;
    private $options;
    private $layout_obj;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct() {

        $this->plugin_name = ADVANCED_RELATED_POSTS_NAME;
        $this->version = ADVANCED_RELATED_POSTS_VERSION;

        $widget_options = array(
            'classname' => 'advanced_related_posts',
            'description' => __( 'Advanced Related Posts' , $this->plugin_name ),
        );
        parent::__construct( 'advanced_related_posts', 'Advanced Related Posts', $widget_options );
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
         * defined in Advanced_Related_Posts_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Advanced_Related_Posts_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        $id_prefix = $this->plugin_name . '-widget';

        wp_enqueue_style( $id_prefix, plugin_dir_url( __FILE__ ) . 'css/advanced-related-posts-widget-style.css', array(), $this->version, 'all' );

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
         * defined in Advanced_Related_Posts_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Advanced_Related_Posts_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        $id_prefix = $this->plugin_name . '-widget';

        wp_enqueue_script( $id_prefix, plugin_dir_url( __FILE__ ) . 'js/advanced-related-posts-widget-public.js', array( 'jquery' ), $this->version, false );

    }

    public function form( $instance ) {
        $title = (isset($instance[ $this->name_prefix . 'title' ]) && sanitize_text_field( $instance[ $this->name_prefix . 'title' ] ) != '') ? esc_attr( sanitize_text_field( $instance[ $this->name_prefix . 'title' ] ) ) : __('Advanced Related Posts' , $this->plugin_name);
        ?>
            <div class="form-group row" style="padding:10px 0;">
                <div class="col-sm-3">
                    <label for="<?php echo $this->name_prefix; ?>title">
                        <?php _e( 'Title:', $this->plugin_name ); ?>
                    </label>
                </div>
                <div class="col-sm-9">
                    <input type="text" id="<?php echo $this->name_prefix; ?>title" name="<?php echo $this->get_field_name( $this->name_prefix . 'title' ); ?>" value="<?php echo $title; ?>" style="width: 100%;">
                </div>
            </div> <!-- ARP Title -->
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance[ $this->name_prefix . 'title' ] = ( ! empty( $new_instance[ $this->name_prefix . 'title' ] ) ) ? strip_tags( $new_instance[ $this->name_prefix . 'title' ] ) : '';

        return $instance;
    }

    public function widget( $args, $instance ) {

        $id = get_the_ID(); // Post ID
        $flag = true;

        if ( $id ) {
            /*******************************************************************************************************/

            $this->enqueue_styles();
            $this->enqueue_scripts();

            /*******************************************************************************************************/

            $this->current_post_obj = get_post( $id, "OBJECT" );

            $this->options = Advanced_Related_Posts_Data::get_arp_widget_validated_data_from_array();

            /*******************************************************************************************************/

            $flag = $this->check_advanced_related_posts($id);

            if ( $flag ) {

                $arp_content = $this->show_advanced_related_posts( $id , $instance );

                if ( $arp_content ) {
                    echo $arp_content;
                }
            }
        }
    }

    public function check_advanced_related_posts( $id ){
        $cat_id = get_the_category( $id );
        $flag = true;

        $exclude_categories_ids = array();
        $exclude_posts_ids = array();

        // Exclude for categories
        if ( ! empty( $this->options[ $this->name_prefix . 'widget_exclude_categories_ids' ] ) ) {
            $exclude_categories_ids_arr = $this->options[ $this->name_prefix . 'widget_exclude_categories_ids' ];
            foreach ($exclude_categories_ids_arr as $key => $categories_id) {

                if ($categories_id == '') {
                    continue;
                }

                $categories_id_val = absint( $categories_id );

                if ($categories_id_val == 0) {
                    continue;
                }

                if ( ! in_array($categories_id_val, $exclude_categories_ids) ) {
                    $exclude_categories_ids[] = $categories_id_val;
                }

            }
        }

        // Exclude posts ids
        if ( $this->options[ $this->name_prefix . 'widget_exclude_post_ids' ] != '' ) {
            $exclude_post_ids_arr = explode(',',  $this->options[ $this->name_prefix . 'widget_exclude_post_ids' ] );

            foreach ($exclude_post_ids_arr as $key => $post_id) {

                if ($post_id == '') {
                    continue;
                }

                $post_id_val = absint( $post_id );

                if ($post_id_val == 0) {
                    continue;
                }
                if ( ! in_array($post_id_val, $exclude_posts_ids) ) {
                    $exclude_posts_ids[] = $post_id_val;
                }
            }
        }

        // Check currrent post category id
        if (! empty($cat_id) || ! is_null($cat_id) ) {
            foreach ($cat_id as $key => $c_id) {
                if( in_array($c_id->term_id, $exclude_categories_ids) ){
                    $flag = false;
                    break;
                }
            }
        }

        // Check currrent post id
        if( in_array($id, $exclude_posts_ids) ){
            $flag = false;
        }

        // Disable on mobile devices
        if ( $this->options[ $this->name_prefix . 'widget_display_on_mobile' ] ) {
            $check_device = wp_is_mobile();

            if ( $check_device ) {
                $flag = false;
            }
        }

        // Enable for all post types
        if ( ! $this->options[ $this->name_prefix . 'widget_all_post_type' ] ) {
            // For selected post types
            if ( ! empty( $this->options[ $this->name_prefix . 'widget_selected_post_type' ] ) ) {
                $selected_post_type = $this->options[ $this->name_prefix . 'widget_selected_post_type' ];

                $current_post_type = (isset( $this->current_post_obj->post_type ) && $this->current_post_obj->post_type != '') ? $this->current_post_obj->post_type : null;

                if ( ! is_null( $current_post_type ) ) {
                    // Check currrent post type
                    if( ! in_array( $current_post_type , $selected_post_type) ){
                        $flag = false;
                    }
                }
            }
        }

        // Display on the front page
        if ( is_front_page() ) {
            if ( ! $this->options[ $this->name_prefix . 'widget_display_front_page' ] ) {
                $flag = false;
            }else {
                if ( ! is_singular() && ! ( (is_archive() || is_home()) ) ) {
                    $flag = false;
                }
            }
        }

        return $flag;
    }

    public function show_advanced_related_posts( $id , $instance ){

        /*******************************************************************************************************/

        $unique_id = uniqid();
        $this->unique_id = $unique_id;
        $this->unique_id_in_class = $id . "-" . $unique_id;;

        /*******************************************************************************************************/

        $content = array();

        $posts = array();
        // Uunder posts count
        $posts_count = $this->options[ $this->name_prefix . 'widget_count' ];

        // Only from same
        $only_from_same = $this->options[ $this->name_prefix . 'widget_only_from_same' ];

        // Strongness of matching
        $strongness_of_matching = $this->options[ $this->name_prefix . 'widget_strongness_of_matching' ];
        
        $user_id = get_current_user_id();

        /*******************************************************************************************************/
        $got_post_ids = array();
        if ( ! empty( $only_from_same ) && $strongness_of_matching != 'and' ) {

            $only_from_same = array(
                "same_post_type",
                "categories",
                "post_tag",
                "post_format",
            );
            
            foreach ($only_from_same as $index => $value) {

                // Get posts
                $posts_arr = $this->ays_widget_get_posts( $id , $index, $got_post_ids );

                if ( $posts_arr ) {
                    foreach ($posts_arr as $k => $v) {
                        if ( $k == 'ID' ) {
                            $got_post_ids[] = $v->ID;
                        }
                    }

                    $posts = array_merge($posts, $posts_arr);

                    $count_of_posts_arr = count( $posts );

                    if ( $count_of_posts_arr > $posts_count ) {
                        $posts = array_slice( $posts , 0, $posts_count );
                        break;
                    } elseif ( $count_of_posts_arr == $posts_count ) {
                        break;
                    }
                }
            }
        }else {
            // Get posts
            $posts = $this->ays_widget_get_posts( $id , 0, $got_post_ids );
        }

        if ( empty( $posts ) ) {
            // Show when no posts are found
            $widget_no_post_found = $this->options[ $this->name_prefix . 'widget_no_post_found' ];

            // Dispaly custom text 
            switch ( $widget_no_post_found ) {
                case 'display_custom_text':
                    $content[] = '<div class="' . $this->html_class_prefix . 'widget-container" id="' . $this->html_class_prefix . 'widget-container-' . $this->unique_id_in_class . '" data-id="' . $unique_id . '">';
                    $content[] = '<input type="hidden" name="'. $this->html_name_prefix .'id-' . $unique_id . '" value="'. $id .'">';

                    $content[] = '<div class="' . $this->html_class_prefix . 'widget-empty-content-row">';
                        $content[] = '<div class="' . $this->html_class_prefix . 'widget-empty-content">';
                            $content[] = do_shortcode( stripcslashes( $this->options[ $this->name_prefix . 'widget_no_post_found_custom_text' ] ) );
                        $content[] = '</div>';
                    $content[] = '</div>';

                    $content[] = $this->get_styles();

                    $content[] = '</div>';
                    break;
                case 'blank_output':
                default:
                    break;
            }

            $content = implode( '', $content );
            return $content;
        }
        // Display Order results
        switch ( $this->options[ $this->name_prefix . 'widget_display_order_results' ] ) {
            case 'new_to_old':
                usort($posts, function($a, $b) {
                    if ($a->ID == $b->ID){
                        return (0);
                    }
                    return (($a->ID < $b->ID) ? 1 : -1);
                });
            break;
            case 'old_to_new':
                usort($posts, function($a, $b) {
                    if ($a->ID == $b->ID){
                        return (0);
                    }
                    return (($a->ID < $b->ID) ? -1 : 1);
                });
            break;
            case 'asc':
                usort($posts, function($a, $b) {
                    return strcmp($a->post_title, $b->post_title);
                });
            break;
            case 'desc':
                usort($posts, function($a, $b) {
                    return -1 * strcmp($a->post_title, $b->post_title);
                });
            break;
            case 'random':
                shuffle( $posts );
            break;
            default:
            break;
        }

        // Layouts | Class for container
        $layout_container_class = '';
        $widget_layout = $this->options[ $this->name_prefix . 'widget_layouts' ];
        switch ( $widget_layout ) {
            case 'elegant':
            case 'classy':
            case 'grid':
                $layout_container_class = $this->html_class_prefix . $widget_layout . '-layout';
                break;
            default:
                $layout_container_class = $this->html_class_prefix . 'elegant-layout';
                break;
        }

        $data_ratio = '';
        // Thumbnail Width / Height
        if ( $this->options[ $this->name_prefix . 'widget_thumbnail_responsive_width_height' ] ) {
            // Responsive Width/Height Ratio
            $responsive_ratio = $this->options[ $this->name_prefix . 'widget_thumbnail_responsive_width_height_ratio' ];

            if ( $widget_layout == 'grid' ) {
                $responsive_ratio = 1;
            }

            $data_ratio = 'data-ratio="' . $responsive_ratio . '"';
        } else {
            if ( $widget_layout == 'grid' ) {
                $responsive_ratio = 1;
                
                $data_ratio = 'data-ratio="' . $responsive_ratio . '"';
            }
        }



        $instance_title = ( isset( $instance[ $this->name_prefix . 'title' ] ) && sanitize_text_field( $instance[ $this->name_prefix . 'title' ] ) != '' ) ? sanitize_text_field( $instance[ $this->name_prefix . 'title' ] ) : __( 'Advanced Related Posts', $this->plugin_name );

        $title = apply_filters( 'widget_title', $instance_title );

        $content = array();
        
        $content[] = '<div class="' . $this->html_class_prefix . 'widget-container '. $layout_container_class .' '. $this->options[ $this->name_prefix . 'widget_custom_class' ] .'" id="' . $this->html_class_prefix . 'widget-container-' . $this->unique_id_in_class . '" data-id="' . $unique_id . '" ' . $data_ratio . '>';

        $content[] = '<h3 class="' . $this->html_class_prefix . 'widget-container-title">' . $title . '</h3>';
        $content[] = '<input type="hidden" name="'. $this->html_name_prefix .'id-' . $unique_id . '" value="'. $id .'">';

        $content[] = $this->create_posts( $posts );

        $content[] = $this->get_styles();

        $content[] = '</div>';
        
        $content = implode( '', $content );
        return $content;

    }

    public function ays_widget_get_posts( $id, $index = 0, $got_post_ids = array() ){
        global $wp_query;

        $posts = array();

        $exclude_posts_ids = array( $id );
        $date_query = array();

        $category_ids = array();
        $post_type = 'any';
        $post_format = '';
        $post_tag = '';
        $orderby = '';
        $order = '';

        if ( ! empty( $got_post_ids ) ) {
            $exclude_posts_ids = array_merge($got_post_ids, $exclude_posts_ids);
        }

        // Uunder posts count
        $posts_count = $this->options[ $this->name_prefix . 'widget_count' ];

        // Exclude for categories
        if ( $this->options[ $this->name_prefix . 'widget_general_exclude_cat_ids' ] != '' ) {
            $exclude_categories_ids_arr = explode(',',  $this->options[ $this->name_prefix . 'widget_general_exclude_cat_ids' ] );
            // $exclude_categories_ids = array();

            foreach ($exclude_categories_ids_arr as $key => $categories_id) {

                if ($categories_id == '') {
                    continue;
                }

                $categories_id_val = absint( $categories_id );

                if ($categories_id_val == 0) {
                    continue;
                }
                $categories_id_val = -1 * $categories_id_val;

                $category_ids[] = $categories_id_val;
            }
        }

        // Exclude posts ids
        if ( $this->options[ $this->name_prefix . 'widget_general_exclude_post_ids' ] != '' ) {
            $exclude_post_ids_arr = explode(',',  $this->options[ $this->name_prefix . 'widget_general_exclude_post_ids' ] );

            foreach ($exclude_post_ids_arr as $key => $post_id) {

                if ($post_id == '') {
                    continue;
                }

                $post_id_val = absint( $post_id );

                if ($post_id_val == 0) {
                    continue;
                }
                if ( ! in_array($post_id_val, $exclude_posts_ids) ) {
                    $exclude_posts_ids[] = $post_id_val;
                }
            }
        }

        $order_posts_query = $this->options[ $this->name_prefix . 'widget_order_posts_query' ];
        // Order posts query
        switch ( $order_posts_query ) {
            case 'relevance':
                // Order search results by relevance only when another "orderby" is not specified in the query.
                $orderby = '';
                break;
            case 'random':
                $orderby = 'rand';
                break;
            case 'by_date':
                $orderby = 'date';
                $order = 'DESC';
                break;
            default:
                $orderby = '';
                break;
        }

        // Only from same
        $only_from_same = $this->options[ $this->name_prefix . 'widget_only_from_same' ];

        // Strongness of matching
        $strongness_of_matching = $this->options[ $this->name_prefix . 'widget_strongness_of_matching' ];


        // =============================================================
        // =======================   Filters   =========================
        // ======================     START     ========================


        // Only from same
        if ( ! empty( $only_from_same ) ) {
            $post_type = (isset( $this->current_post_obj->post_type ) && $this->current_post_obj->post_type != '') ? $this->current_post_obj->post_type : 'any';
        }

        // Get the curent post categories
        $post_categories_arr = get_the_category( $id );

        if ( $post_categories_arr && !empty( $post_categories_arr ) ) {

            foreach ($post_categories_arr as $key => $post_category) {
                $post_category = (array) $post_category;

                $cat_ID = (isset( $post_category['cat_ID'] ) && sanitize_text_field( $post_category['cat_ID'] ) != '') ? absint( sanitize_text_field( $post_category['cat_ID'] ) ) : null;

                if ( ! is_null( $cat_ID ) ) {

                    $chcek_cat_ID = -1 * $cat_ID;

                    if ( ! in_array($chcek_cat_ID, $category_ids ) ) {
                        $category_ids[] = $cat_ID;
                    }
                }
            }
        }

        // Get the curent post tags
        $post_tags_arr = get_the_tags( $id );

        if ( $post_tags_arr && !empty( $post_tags_arr ) ) {
            $tag_arr = array();
            foreach ($post_tags_arr as $key => $post_tag) {
                $post_tag = (array) $post_tag;

                $tag_slug = (isset( $post_tag['slug'] ) && sanitize_text_field( $post_tag['slug'] ) != '') ? sanitize_text_field( $post_tag['slug'] ) : '';

                if ( $tag_slug != '' ) {
                    $tag_arr[] = $tag_slug;
                }
            }
            $post_tag = implode( ',', $tag_arr );
        }

        // Get the current post format
        $post_format_str = get_post_format( $id );

        if ( $post_format_str && !empty( $post_format_str ) ) {
            $post_format = $post_format_str;
        }

        // =============================================================
        // =======================   Filters   =========================
        // =====================      END      =========================

        switch ( $strongness_of_matching ) {
            case 'and':
                break;
            case 'or':

                $new_only_from_same = array();

                if ( $index > 0 ) {
                    $new_only_from_same = array();
                    if ( ($filter_type = array_search('same_post_type', $only_from_same)) !== false ) {
                        $new_only_from_same[] = 'same_post_type';
                    }
                }

                if ( $index > 1 ) {
                    $new_only_from_same = array();
                    if ( ($filter_type = array_search('categories', $only_from_same)) !== false ) {
                        $new_only_from_same[] = 'categories';
                    }
                }

                if ( $index > 2 ) {
                    $new_only_from_same = array();
                    if ( ($filter_type = array_search('post_tag', $only_from_same)) !== false ) {
                        $new_only_from_same[] = 'post_tag';
                    }
                }

                if ( ! empty( $new_only_from_same ) ) {
                    $only_from_same = $new_only_from_same;
                }

                break;
            default:

                if ( $index > 0 ) {
                    if (($filter_type = array_search('post_format', $only_from_same)) !== false) {
                        unset($only_from_same[$filter_type]);
                    }
                }

                if ( $index > 1 ) {
                    if (($filter_type = array_search('post_tag', $only_from_same)) !== false) {
                        unset($only_from_same[$filter_type]);
                    }
                }

                if ( $index > 2 ) {
                    if (($filter_type = array_search('categories', $only_from_same)) !== false) {
                        unset($only_from_same[$filter_type]);
                    }
                }

                break;
        }

        // =============================================================
        // =====================    Date Query     =====================
        // =============================================================

        // Display only posts from the past
        if ( $this->options[ $this->name_prefix . 'widget_enable_posts_from_past' ] ) {
            $strtotime_str = '';  

            // Count only posts from the past
            $posts_from_past_period = $this->options[ $this->name_prefix . 'widget_posts_from_past_period' ];

            $past_period = -1 * $posts_from_past_period;

            // Time only posts from the past
            $time_posts_from_past  = $this->options[ $this->name_prefix . 'widget_time_posts_from_past' ];

            switch ( $time_posts_from_past ) {
                case 'month':
                case 'week':
                case 'day':
                    $strtotime_str = $past_period . ' ' . $time_posts_from_past;
                    break;
                default:
                    $strtotime_str = $past_period . ' ' . 'month';
                    break;
            }

            $date_query['after'] = strtotime( $strtotime_str );
        }

        // Display only posts older than current post
        if ( $this->options[ $this->name_prefix . 'widget_enable_posts_older_current_post' ] ) {
            if ( isset($this->current_post_obj->post_date) ) {

                $date_query['before'] = strtotime( $this->current_post_obj->post_date );

                if ( isset($date_query['after']) ) {
                    $date_query['inclusive'] = true;
                }
            }
        }

        // =============================================================
        // =====================    Date Query     =====================
        // =============================================================

        // Parameters
        $posts_args = array(
            'numberposts' => $posts_count,
            'include'     => array(),
            'exclude'     => $exclude_posts_ids,
            'meta_key'    => '',
            'meta_value'  => '',
            'post_status' => 'publish',
            'suppress_filters' => true,
        );

        if ( $this->options[ $this->name_prefix . 'widget_limit_to_same_author' ] ) {
            if ( isset($this->current_post_obj->post_author) ) {
                $posts_args['author'] = $this->current_post_obj->post_author;
            }
        }

        if ( $order != '' ) {
            $posts_args['order'] = $order;
        }

        if ( $orderby != '' ) {
            $posts_args['orderby'] = $orderby;
        }

        if ( ! empty( $date_query ) ) {
            $posts_args['date_query'] = $date_query;
        }

        if ( in_array( 'same_post_type' , $only_from_same ) ) {
            $posts_args['post_type'] = $post_type;
        }

        if ( in_array( 'categories' , $only_from_same ) ) {
            if ( ! empty( $category_ids ) ) {
                $posts_args['category'] = $category_ids;
            }
        }

        if ( in_array( 'post_tag' , $only_from_same ) ) {
            if ( $post_tag != '' ) {
                $posts_args['tag'] = $post_tag;
            }
        }

        if ( in_array( 'post_format' , $only_from_same ) ) {
            if ( $post_format != '' ) {
                $posts_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'post_format',
                        'field' => 'slug',
                        'terms' => array( 'post-format-'. $post_format ),
                    )
                );
            }
        }

        // Get posts
        $posts = get_posts( $posts_args );


        return $posts;
    }

    public function create_posts( $posts ){

        $content = array();
        $layout_content = '';

        $layout_options = array(
            'unique_id'            => $this->unique_id,
            'unique_id_in_class'   => $this->unique_id_in_class,
        );

        // Layouts
        $widget_layout = $this->options[ $this->name_prefix . 'widget_layouts' ];
        switch ( $widget_layout ) {
            case 'elegant':
            case 'classy':
            case 'grid':
                include_once('partials/class-advanced-related-posts-widget-'. $widget_layout .'-layout.php');
                $layout_class_name = 'Advanced_Related_Posts_Widget_' . strtoupper( $widget_layout ) . '_Layout';

                $this->layout_obj = new $layout_class_name( $this->plugin_name, $this->version, $this->options, $widget_layout, $layout_options );
                $layout_content = $this->layout_obj->ays_arp_generate_layout_content( $posts );
                break;
            default:
                include_once('partials/class-advanced-related-posts-widget-elegant-layout.php');
                $layout_class_name = 'Advanced_Related_Posts_Widget_ELEGANT_Layout';

                $this->layout_obj = new $layout_class_name( $this->plugin_name, $this->version, $this->options, $widget_layout, $layout_options );
                $layout_content = $this->layout_obj->ays_arp_generate_layout_content( $posts );
                break;
        }

        $content[] = $layout_content;

        $content = implode( '', $content );

        return $content;
    }

    public function get_styles(){
        
        $content = array();
        $content[] = '<style type="text/css">';

        // Thumbnail width
        $thumbnail_width = '300px';
        if ( $this->options[ $this->name_prefix . 'widget_thumbnail_width' ] != '' ) {
            $thumbnail_width = $this->options[ $this->name_prefix . 'widget_thumbnail_width' ] .'px;';
        }

        // Thumbnail height
        $thumbnail_height = '300px';
        if ( $this->options[ $this->name_prefix . 'widget_thumbnail_height' ] != '' ) {
            $thumbnail_height = $this->options[ $this->name_prefix . 'widget_thumbnail_height' ] .'px;';
        }

        // Thumbnail Width / Height
        $thumbnail_width_height = '';
        if ( ! $this->options[ $this->name_prefix . 'widget_thumbnail_responsive_width_height' ] ) {
            $thumbnail_width_height_arr = array();

            $thumbnail_width_height_arr[] = 'width: ' . $thumbnail_width;
            $thumbnail_width_height_arr[] = 'height:' . $thumbnail_height;

            if ( $this->options[ $this->name_prefix . 'widget_layouts' ] == 'grid' ) {
                $thumbnail_width_height_arr = array();
            }
            
            $thumbnail_width_height = implode( '', $thumbnail_width_height_arr );
        }

        $thumbnail_columns_count = 3;
        if ( $this->options[ $this->name_prefix . 'widget_thumbnail_columns_count' ] != 0 ) {
            $thumbnail_columns_count = absint( $this->options[ $this->name_prefix . 'widget_thumbnail_columns_count' ] );
        }

        $column_width = intval( floor(100 / $thumbnail_columns_count) );

        $width = "100%";

        $content[] = '
            #' . $this->html_class_prefix . 'widget-container-' . $this->unique_id_in_class . ' {
                width: ' . $width . ';
                word-break: break-word;
            }

            #' . $this->html_class_prefix . 'widget-container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'widget {
                width: calc('. $column_width .'% - 10px);
            }

            #' . $this->html_class_prefix . 'widget-container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'widget-img-row .' . $this->html_class_prefix . 'widget-img{
                object-fit: cover;
                object-position: center center;
                ' . $thumbnail_width_height . '
            }

            #' . $this->html_class_prefix . 'widget-container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'widget-container-title,
            #' . $this->html_class_prefix . 'widget-container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'widget-title  .' . $this->html_class_prefix . 'widget-link,
            #' . $this->html_class_prefix . 'widget-container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'widget-excerpt-row ,
            #' . $this->html_class_prefix . 'widget-container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'widget {
                color: ' . $this->options[ $this->name_prefix . 'widget_text_color' ] . ';
            }

            #' . $this->html_class_prefix . 'widget-container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'widget div.ays-arp-widget-arrow svg{
                fill: ' . $this->options[ $this->name_prefix . 'widget_text_color' ] . ';
            }

            #' . $this->html_class_prefix . 'widget-container-' . $this->unique_id_in_class . ' .' . $this->html_class_prefix . 'widget-date-author-row {
                color: ' . Advanced_Related_Posts_Data::hex2rgba( $this->options[ $this->name_prefix . 'widget_text_color' ] , 0.7 ) . ';
            }
            
            ';

        // Layouts CSS
        if ( ! is_null( $this->layout_obj ) ) {
            $content[] = $this->layout_obj->get_leyout_styles();
        }
        
        $content[] = '</style>';

        $content = implode( '', $content );

        return $content;
    }

}