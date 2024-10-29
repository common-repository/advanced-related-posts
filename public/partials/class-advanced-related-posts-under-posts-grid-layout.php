<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Advanced_Related_Posts
 * @subpackage Advanced_Related_Posts/public/partials
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
 * @package    Advanced_Related_Posts
 * @subpackage Advanced_Related_Posts/public/partials
 * @author     Advanced Related Posts Team <info@ays-pro.com>
 */

class Advanced_Related_Posts_Under_Posts_GRID_Layout extends Advanced_Related_Posts_Public{

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

    protected $layout_name;
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name   The name of the plugin.
     * @param      string    $version       The version of this plugin.
     */

    public function __construct( $plugin_name, $plugin_version, $options, $layout_name, $layout_options ) {
        $this->plugin_name  = $plugin_name;
        $this->version      = $plugin_version;
        $this->options      = $options;
        $this->layout_name  = $layout_name;

        $this->unique_id            = $layout_options['unique_id'];
        $this->unique_id_in_class   = $layout_options['unique_id_in_class'];
    }

    protected function layout_enqueue_styles(){
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

        $id_prefix = $this->plugin_name . '-under-posts-' . $this->layout_name;

        wp_enqueue_style( $id_prefix, ADVANCED_RELATED_POSTS_PUBLIC_URL . '/css/layouts/advanced-related-posts-under-posts-'. $this->layout_name .'-layout.css', array(), $this->version, 'all' );

    }
    
    protected function layout_enqueue_scripts(){
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

        $id_prefix = $this->plugin_name . '-under-posts-' . $this->layout_name;

    }

    public function ays_arp_generate_layout_content( $posts ){
        
        /*******************************************************************************************************/

        $this->layout_enqueue_styles();
        $this->layout_enqueue_scripts();

        /*******************************************************************************************************/

        $content = array();

        $content[] = '<div class="' . $this->html_class_prefix . 'under-posts">';

        foreach ( $posts as $post_id => $post ) {
            $content[] = $this->layout_create_post( $post );
        }

        $content[] = '</div>';

        $content = implode( '', $content );

        return $content;
    }

    public function layout_create_post( $post ){

        /*******************************************************************************************************/

        $content = array();

        $post_title = $post->post_title;
        $post_content = $post->post_content;

        $first_part_of_post_title = '';
        $post_excerpt = '';

        $post_date = '';
        $post_time = '';
        $post_author_name = '';
        $enable_new_blank = '';
        $thumbnail_size   = '';

        /*******************************************************************************************************/

        // Image URL
        $post_image_url = $this->options[ $this->name_prefix . 'under_posts_default_thumbnail' ];

        // Thumbnail size
        $thumbnail_size = $this->options[ $this->name_prefix . 'under_posts_thumbnail_size' ];

        // Check post thumbnail
        if ( has_post_thumbnail( $post->ID ) ){

            $image_arr = get_the_post_thumbnail_url( $post->ID, $thumbnail_size );

            $post_image_url = ( isset($image_arr) && ! empty($image_arr) ) ? $image_arr : '';

        }else {
            // Get first image
            if ( $this->options[ $this->name_prefix . 'under_posts_first_image' ] ) {
                $post_image_url = Advanced_Related_Posts_Data::ays_arp_get_content_first_image( $post->ID, $post_image_url );
            }
        }

        // Limit post title length
        if ( $this->options[ $this->name_prefix . 'under_posts_enable_post_title_length' ] ) {
            // Limit post title length count
            $under_posts_post_title_length = $this->options[ $this->name_prefix . 'under_posts_post_title_length' ];

            // Limit post title length type
            $under_posts_post_title_type   = $this->options[ $this->name_prefix . 'under_posts_post_title_type' ];

            $first_part_of_post_title = Advanced_Related_Posts_Data::ays_arp_get_part_of_string( $post_title , $under_posts_post_title_type, $under_posts_post_title_length);
        }

        // Show date
        if ( $this->options[ $this->name_prefix . 'under_posts_show_date' ] ) {
            $post_date = get_the_date( '', $post->ID );

            $post_time = get_the_modified_time( '', $post->ID );
        }

        // Show Author
        if ( $this->options[ $this->name_prefix . 'under_posts_show_author' ] ) {
            $post_author_id = ( isset( $post->post_author ) && $post->post_author != null ) ? absint( sanitize_text_field( $post->post_author ) ) : null;
            if (! is_null( $post_author_id ) ) {
                $post_user_data = get_user_by( 'id', $post_author_id );
                if ( $post_user_data ) {
                    $post_author_name = ( isset( $post_user_data->display_name ) && sanitize_text_field( $post_user_data->display_name ) != '' ) ? sanitize_text_field( $post_user_data->display_name ) : '';
                }else {
                    $post_author_name = '';
                }
            }
        }

        // Open links in new window
        if ( $this->options[ $this->name_prefix . 'under_posts_links_on_new_window' ] ) {
            $enable_new_blank = 'target="_blank"';
        }

        // Show post excerpt
        if ( $this->options[ $this->name_prefix . 'under_posts_enable_post_excerpt' ] ) {
            // Show post excerpt length
            $under_posts_post_excerpt_length = $this->options[ $this->name_prefix . 'under_posts_post_excerpt_length' ];

            // Show post excerpt type
            $under_posts_post_excerpt_type   = $this->options[ $this->name_prefix . 'under_posts_post_excerpt_type' ];

            $post_excerpt = Advanced_Related_Posts_Data::ays_arp_get_part_of_string( $post_content , $under_posts_post_excerpt_type, $under_posts_post_excerpt_length);
        }

        $content[] = '<div class="' . $this->html_class_prefix . 'under-post">';

            $content[] = '<div class="' . $this->html_class_prefix . 'under-post-header">';

                $content[] = '<div class="' . $this->html_class_prefix . 'under-post-img-row">';
                    if( $post_image_url != '' ){
                        $content[] = '<img src="' . $post_image_url . '" class="' . $this->html_class_prefix . 'under-post-img">';
                    }else {
                        $content[] = '<p class="' . $this->html_class_prefix . 'under-post-empty-img">'. __( 'Post does not have featured image' , $this->plugin_name ) .'</p>';
                    }
                $content[] = '</div>';

            $content[] = '</div>';

            $content[] = '<div class="' . $this->html_class_prefix . 'under-post-content">';                

                // Post title | + LINK
                $content[] = '<div class="' . $this->html_class_prefix . 'under-post-title-row">';
                    $content[] = '<h4 class="' . $this->html_class_prefix . 'under-post-title">';

                        $content[] = '<a href="' . get_permalink( $post->ID ) . '" class="' . $this->html_class_prefix . 'under-post-link" '. $enable_new_blank .' >';
                        if ( $this->options[ $this->name_prefix . 'under_posts_enable_post_title_length' ] ) {
                            $content[] = $first_part_of_post_title;
                        }else{
                            $content[] = $post_title;
                        }
                        $content[] = '</a>';

                    $content[] = '</h4>';
                $content[] = '</div>';

                // Post excerpt
                if ( $this->options[ $this->name_prefix . 'under_posts_enable_post_excerpt' ] ) {
                    $content[] = '<div class="' . $this->html_class_prefix . 'under-post-excerpt-row">';
                        $content[] = '<span class="' . $this->html_class_prefix . 'under-post-excerpt">' . $post_excerpt . '</span>';
                    $content[] = '</div>';
                }

                // Post Date | Post Author
                if ( $this->options[ $this->name_prefix . 'under_posts_show_date' ] || $this->options[ $this->name_prefix . 'under_posts_show_author' ] ) {

                    $content[] = '<div class="' . $this->html_class_prefix . 'under-post-date-author-row">';  
                    // Post Date
                    if ( $this->options[ $this->name_prefix . 'under_posts_show_date' ] ) {
                        $content[] = '<span class="' . $this->html_class_prefix . 'under-post-date">' . $post_date . '</span>';
                        $content[] = '<span class="' . $this->html_class_prefix . 'under-post-time">' . $post_time . '</span>';
                    }

                    // Post Author
                    if ( $this->options[ $this->name_prefix . 'under_posts_show_author' ] ) {
                        $date_enabled_class = '';
                        if ( $this->options[ $this->name_prefix . 'under_posts_show_date' ] ) {
                            $date_enabled_class = $this->html_class_prefix . 'under-post-date-enabled';
                        }
                        $content[] = '<span class="' . $this->html_class_prefix . 'under-post-author ' . $date_enabled_class . '">' . $post_author_name . '</span>';
                    }
                    $content[] = '</div>';
                }

            $content[] = '</div>';

            $content[] = '<div class="' . $this->html_class_prefix . 'under-post-footer">';
            
            $content[] = '</div>';
        
        $content[] = '</div>';

        $content = implode( '', $content );

        return $content;
    }

    public function get_leyout_styles(){
        
        $content = array();

        $content[] = '
            /* Layout CSS */
            #' . $this->html_class_prefix . 'under-posts-container-' . $this->unique_id_in_class . '.' . $this->html_class_prefix . $this->layout_name . '-layout .' . $this->html_class_prefix . 'under-post-date-author-row {
                
            }
            
            ';

        $content = implode( '', $content );

        return $content;
    }
}

?>
