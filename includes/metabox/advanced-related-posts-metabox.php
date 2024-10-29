<?php
/**
 * Register a meta box using a class.
 */
class Advanced_Related_Posts_Meta_Box {

    private $plugin_name;
    private $html_class_prefix = 'ays-arp-';
	private $html_name_prefix = 'ays-arp-';
	private $name_prefix = 'arp_';
    private $options;
    /**
     * Constructor.
     */
    public function __construct( $plugin_name ) {

        $this->plugin_name = $plugin_name;

        add_action( 'add_meta_boxes', array( $this, 'arp_add_meta_box'));
        add_action( 'save_post', array( $this, 'arp_save_metabox' ));
    }
 
    public function arp_add_meta_box( $post_type ) {
        $this->options = Advanced_Related_Posts_Data::get_arp_validated_data_from_array();

        $show_meta_box = $this->options[ $this->name_prefix . 'under_posts_enable_meta_box' ];
        $show_meta_box_admins_only = $this->options[ $this->name_prefix . 'under_posts_enable_meta_box_to_admin_only' ];
       
        if(!$show_meta_box){
            return;
        }else{
            if($show_meta_box_admins_only){
                if(! current_user_can( 'manage_options' ) ){
                    return;
                }else{
                    add_meta_box(
                        $this->name_prefix . 'metabox',
                        __( 'Advanced Related Posts', $this->plugin_name ),
                        array( $this, 'arp_call_meta_box' ),
                        $post_type,
                        'advanced',
                        'default'
                    );
                }
            }else{
                add_meta_box(
                    $this->name_prefix . 'metabox',
                    __( 'Advanced Related Posts', $this->plugin_name ),
                    array( $this, 'arp_call_meta_box' ),
                    $post_type,
                    'advanced',
                    'default'
                );
            }
        }
    }

    public function arp_call_meta_box() {
        global $post;

        wp_nonce_field( $this->name_prefix . 'metabox_nonce_action', $this->name_prefix . 'meta_box_nonce' );

        $arp_get_post_metas = get_post_meta( $post->ID, $this->name_prefix . 'post_meta' );

        $arp_post_metas_values = array();
        foreach ($arp_get_post_metas as $key => $arp_get_post_meta) {
            $arp_metabox_post_ids = ( isset( $arp_get_post_meta [ $this->name_prefix . 'metabox_exclude_post_ids'] ) && sanitize_text_field( $arp_get_post_meta [ $this->name_prefix . 'metabox_exclude_post_ids'] ) != '') ? sanitize_text_field( $arp_get_post_meta [ $this->name_prefix . 'metabox_exclude_post_ids'] ) : '';
            $arp_post_metas_values = array(
                $this->name_prefix . 'metabox_post_ids' => $arp_metabox_post_ids,
            );
        }
        $arp_exclude_post_ids = ( isset( $arp_post_metas_values [ $this->name_prefix . 'metabox_post_ids'] ) && sanitize_text_field( $arp_post_metas_values [ $this->name_prefix . 'metabox_post_ids'] ) != '' ) ? sanitize_text_field( $arp_post_metas_values [ $this->name_prefix . 'metabox_post_ids'] ) : '';

        $content = array();

        $content[] = '<div style="padding-top: 5px;">';
            $content[] = '<div>';

                $content[] = '<label for="' . $this->html_class_prefix . 'metabox_post_ids">';
                    $content[] = '<span>' . __('Exclude post Ids։', $this->plugin_name) . '</span>';
                $content[] = '</label>';

                $content[] = '<input type="text" name="'. $this->name_prefix .'metabox_post_ids" id="'. $this->name_prefix .'metabox_post_ids" class="arp-metabox-post-ids" placeholder="' .  __('Ex:1,12,13',$this->plugin_name) . '" style="width: 100%;" value="'. $arp_exclude_post_ids .'">';

            $content[] = '</div>';
        $content[] = '</div>';

        $content = implode( '', $content );

        echo $content;
    }

    public function arp_save_metabox( $post_id ) {
        $arp_post_meta_values = array();

        // Bail if we're doing an auto save.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
    
        // If our nonce isn't there, or we can't verify it, bail.
        if ( ! isset( $_POST[ $this->name_prefix . 'meta_box_nonce' ] ) || ! wp_verify_nonce( sanitize_key( $_POST[ $this->name_prefix . 'meta_box_nonce' ] ), $this->name_prefix . 'metabox_nonce_action' ) ) { 
            return;
        }
    
        // If our current user can't edit this post, bail.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        if ( isset( $_POST[ $this->name_prefix . 'metabox_post_ids' ] ) ) {
            $arp_post_meta_values[ $this->name_prefix .'metabox_exclude_post_ids' ] = sanitize_text_field( wp_unslash( $_POST[ $this->name_prefix . 'metabox_post_ids' ] ) );
        }
    
        $arp_post_meta_filtered = array_filter( $arp_post_meta_values );
    
        /**** Now we can start saving */
        if ( empty( $arp_post_meta_values ) ) {   // Checks if all the array items are 0 or empty.
            delete_post_meta( $post_id, $this->name_prefix . 'post_meta' );  // Delete the post meta if no options are set.
        } else {
            update_post_meta( $post_id, $this->name_prefix . 'post_meta', $arp_post_meta_filtered );
        }
    }
}
new Advanced_Related_Posts_Meta_Box( $this->plugin_name );