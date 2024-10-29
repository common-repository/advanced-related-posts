<div id="tab3" class="<?php echo $class_prefix; ?>tab-content <?php echo ($ays_tab == 'tab3') ? $class_prefix . 'tab-content-active' : ''; ?>">
    <p class="ays-subtitle"><?php echo __('Settings',$this->plugin_name)?></p>
    <hr/>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>under_posts_enable_meta_box">
                <?php echo __('Show metabox', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <input type="checkbox" name="<?php echo $html_name_prefix; ?>under_posts_enable_meta_box" id="<?php echo $html_name_prefix; ?>under_posts_enable_meta_box" value="on" <?php echo $under_posts_enable_meta_box ? 'checked' : '' ;?>>
        </div>
    </div> <!-- Show metabox -->
    <hr>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>under_posts_enable_meta_box_to_admin_only">
                <?php echo __('Limit meta box to Admins only', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <input type="checkbox" name="<?php echo $html_name_prefix; ?>under_posts_enable_meta_box_to_admin_only" id="<?php echo $html_name_prefix; ?>under_posts_enable_meta_box_to_admin_only" value="on" <?php echo $under_posts_enable_meta_box_to_admin_only ? 'checked' : '' ;?>>
        </div>
    </div> <!-- Limit meta box to Admins only -->
    <hr>
    <div class="form-group row ays_toggle_parent">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>under_posts_enable_post_title_length">
                <?php echo __('Limit post title length', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-1">
            <input type="checkbox" name="<?php echo $html_name_prefix; ?>under_posts_enable_post_title_length" id="<?php echo $html_name_prefix; ?>under_posts_enable_post_title_length" value="on" <?php echo $under_posts_enable_post_title_length ? "checked" : "" ;?> class="ays_toggle_checkbox">
        </div>
        <div class=" col-sm-8 ays_divider_left ays_toggle_target <?php echo $under_posts_enable_post_title_length ? "" : "display_none_not_important" ;?>">
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="<?php echo $html_name_prefix; ?>under_posts_post_title_length">
                        <?php echo __('Post title length', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-6">
                    <input type="number" name="<?php echo $html_name_prefix; ?>under_posts_post_title_length" id="<?php echo $html_name_prefix; ?>under_posts_post_title_length" value="<?php echo $under_posts_post_title_length; ?>" class="ays-text-input">
                </div>
                <div class="col-sm-3">
                    <select name="<?php echo $html_name_prefix; ?>under_posts_post_title_type" class="ays-text-input-select" id="<?php echo $html_name_prefix; ?>under_posts_post_title_type">
                    <?php
                        foreach ($post_length_type_array as $post_title_length_type_key => $post_title_length_type):
                            $selected = '';
                            if(is_array($post_title_length_type_key)):
                                if(in_array($under_posts_post_title_type,$post_title_length_type_key)):
                                    $selected = 'selected';
                                else:
                                    $selected = '';
                                endif;
                            else:
                                if($post_title_length_type_key == $under_posts_post_title_type):
                                    $selected = 'selected';
                                else:
                                    $selected = '';
                                endif;
                            endif;
                    ?>
                            <option value="<?php echo $post_title_length_type_key;?>" <?php echo $selected; ?>>
                                <?php echo $post_title_length_type; ?>
                            </option>
                    <?php
                        endforeach;
                    ?>
                    </select>
                </div>
            </div>
        </div>
    </div><!-- Limit post title length  -->
    <hr>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>under_posts_show_date">
                <?php echo __('Show date', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <input type="checkbox" name="<?php echo $html_name_prefix; ?>under_posts_show_date" id="<?php echo $html_name_prefix; ?>under_posts_show_date" value="on" <?php echo $under_posts_show_date ? 'checked' : '' ;?>>
        </div>
    </div> <!-- Show date -->
    <hr>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>under_posts_show_author">
                <?php echo __('Show Author', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <input type="checkbox" name="<?php echo $html_name_prefix; ?>under_posts_show_author" id="<?php echo $html_name_prefix; ?>under_posts_show_author" value="on" <?php echo $under_posts_show_author ? 'checked' : '' ;?>>
        </div>
    </div> <!-- Show Author --->
    <hr>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>under_posts_links_on_new_window">
                <?php echo __('Open links in new window', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <input type="checkbox" name="<?php echo $html_name_prefix; ?>under_posts_links_on_new_window" id="<?php echo $html_name_prefix; ?>under_posts_links_on_new_window" value="on" <?php echo $under_posts_links_on_new_window ? 'checked' : '' ;?>>
        </div>
    </div> <!-- Open links in new window -->
    <hr>
    <div class="form-group row ays_toggle_parent">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>under_posts_enable_post_excerpt">
                <?php echo __('Show post excerpt', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-1">
            <input type="checkbox" name="<?php echo $html_name_prefix; ?>under_posts_enable_post_excerpt" id="<?php echo $html_name_prefix; ?>under_posts_enable_post_excerpt" value="on" <?php echo $under_posts_enable_post_excerpt ? "checked" : "" ;?> class="ays_toggle_checkbox">
        </div>
        <div class="col-sm-8 ays_divider_left ays_toggle_target <?php echo $under_posts_enable_post_excerpt ? "" : "display_none_not_important" ;?>">
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="<?php echo $html_name_prefix; ?>under_posts_post_excerpt_length">
                        <?php echo __('Post excerpt length', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-6">
                    <input type="number" name="<?php echo $html_name_prefix; ?>under_posts_post_excerpt_length" id="<?php echo $html_name_prefix; ?>under_posts_post_excerpt_length" value="<?php echo $under_posts_post_excerpt_length; ?>" class="ays-text-input ">
                </div>
                <div class="col-sm-3">
                    <select name="<?php echo $html_name_prefix; ?>under_posts_post_excerpt_type" class="ays-text-input-select" id="<?php echo $html_name_prefix; ?>under_posts_post_excerpt_type">
                    <?php
                        foreach ($post_length_type_array as $post_length_type_key => $post_length_type):
                            $selected = '';
                            if(is_array($post_length_type_key)):
                                if(in_array($under_posts_post_excerpt_type,$post_length_type_key)):
                                    $selected = 'selected';
                                else:
                                    $selected = '';
                                endif;
                            else:
                                if($under_posts_post_excerpt_type == $post_length_type_key):
                                    $selected = 'selected';
                                else:
                                    $selected = '';
                                endif;
                            endif;
                    ?>
                            <option value="<?php echo $post_length_type_key;?>" <?php echo $selected; ?>>
                                <?php echo $post_length_type; ?>
                            </option>
                    <?php
                        endforeach;
                    ?>
                    </select>
                </div>
            </div>
        </div>
    </div> <!-- Limit post length  -->
    <hr>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>under_posts_box_title">
                <?php echo __('Title of the box', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <input type="text" name="<?php echo $html_name_prefix; ?>under_posts_box_title" id="<?php echo $html_name_prefix; ?>under_posts_box_title" class="ays-text-input" value="<?php echo $under_posts_box_title ;?>">
        </div>
    </div> <!-- Title of the box  -->
    <hr>
    <div class="form-group row ays_toggle_parent">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>under_posts_no_post_found_cont">
                <?php echo __('Show when no posts are found', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-2">
            <div>
                <input type="radio" data-flag="false" name="<?php echo $html_name_prefix; ?>under_posts_no_post_found" id="<?php echo $html_name_prefix; ?>under_posts_no_post_found_blank_output" class="ays_toggle_radio" value="blank_output" <?php echo ($under_posts_no_post_found == 'blank_output') ? 'checked' : ''; ?> >
                <label for="<?php echo $html_name_prefix; ?>under_posts_no_post_found_blank_output">
                    <?php echo __( 'Blank output', $this->plugin_name ); ?>
                </label>
            </div>
            <div>
                <input type="radio" data-flag="true" name="<?php echo $html_name_prefix; ?>under_posts_no_post_found" id="<?php echo $html_name_prefix; ?>under_posts_no_post_found_display_custom_text" class="ays_toggle_radio" value="display_custom_text" <?php echo ($under_posts_no_post_found == 'display_custom_text') ? 'checked' : ''; ?> >
                <label for="<?php echo $html_name_prefix; ?>under_posts_no_post_found_display_custom_text">
                    <?php echo __( 'Display custom text', $this->plugin_name ); ?>
                </label>
            </div>
        </div>
        <div class="col-sm-7 ays_divider_left ays_toggle_target <?php echo ($under_posts_no_post_found == 'display_custom_text') ? '' : 'display_none_not_important'; ?>">
            <div class="form-group row">
                <div class='col-sm-12'>
                    <label for="<?php echo $html_name_prefix; ?>under_posts_no_post_found_custom_text">
                        <?php echo __('Write your custom text', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
            </div>
            <div class="form-group row">
                <div class='col-sm-12'>
                    <?php
                        $content   = $under_posts_no_post_found_custom_text;
                        $editor_id = $html_name_prefix.'under_posts_no_post_found_custom_text';
                        $settings  = array(
                            'editor_height' => '15',
                            'textarea_name' => $html_name_prefix.'under_posts_no_post_found_custom_text',
                            'editor_class'  => $class_prefix.'widget-textarea',
                            'media_buttons' => true,
                        );
                        wp_editor($content, $editor_id, $settings);
                    ?>
                </div>
            </div> <!-- Show when no posts are found -->
        </div>   
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>under_posts_display_on_mobile">
                <?php echo __('Disable on mobile devices', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <input type="checkbox" name="<?php echo $html_name_prefix; ?>under_posts_display_on_mobile" id="<?php echo $html_name_prefix; ?>under_posts_display_on_mobile" value="on" <?php echo $under_posts_display_on_mobile ? 'checked' : '' ;?>>
        </div>
    </div> <!-- Disable on mobile devices -->
</div>
