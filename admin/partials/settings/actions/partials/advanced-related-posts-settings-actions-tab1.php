<div id="tab1" class="<?php echo $class_prefix; ?>tab-content <?php echo ($ays_tab == 'tab1') ? $class_prefix . 'tab-content-active' : ''; ?>">
    <p class="ays-subtitle"><?php echo __('General',$this->plugin_name); ?></p>
    <hr/>
    <div class="<?php echo $class_prefix; ?>enable_disable_options_main">
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="<?php echo $html_name_prefix; ?>widget_all_post_type">
                    <?php echo __('Enable for all post type', $this->plugin_name); ?>
                    <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                        <i class="ays_fa ays_fa_info_circle"></i>
                    </a>
                </label>
            </div>
            <div class="col-sm-9">
                <input type="checkbox" id="<?php echo $html_name_prefix; ?>widget_all_post_type"  class="<?php echo $class_prefix; ?>enable-disable-options" name="<?php echo $html_name_prefix; ?>widget_all_post_type" value="on" <?php echo $widget_all_post_type ? 'checked': '' ;?>>
            </div>
        </div> <!-- Enable for all post types -->
        <hr>
        <div class="<?php echo $widget_enable_post_type_options; ?> <?php echo $class_prefix; ?>enable-disable-options-div-js" data-name='ays-arp-all-post-type'>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="<?php echo $html_name_prefix; ?>widget_selected_post_type" class="<?php echo $class_prefix;?>enable-options-label">
                        <?php echo __('Selected post types', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <?php
                        foreach ($widget_post_types as $key => $widget_post_type):
                            $checked = '';
                            if(is_array($widget_selected_post_types)):
                                if(empty($widget_selected_post_types) && isset($widget_selected_post_types)):
                                    $checked = 'checked';
                                else:
                                    if(in_array($widget_post_type,$widget_selected_post_types)):
                                        $checked = 'checked';
                                    else:
                                        $checked = '';
                                    endif;
                                endif;
                            else:
                                if($widget_post_type == $widget_selected_post_types):
                                    $checked = 'checked';
                                else:
                                    $checked = '';
                                endif;
                            endif;    
                    ?>
                        <div>
                            <input type="checkbox" id="<?php echo $html_name_prefix; ?>widget_selected_post_type_<?php echo $widget_post_type; ?>" class="<?php echo $class_prefix;?>enable-options-field" name="<?php echo $html_name_prefix; ?>widget_selected_post_type[]" value="<?php echo $widget_post_type ;?>" <?php echo $checked ;?>>
                            <label for="<?php echo $html_name_prefix; ?>widget_selected_post_type_<?php echo $widget_post_type; ?>" class="<?php echo $class_prefix; ?>widget-selected-post-type <?php echo $class_prefix;?>enable-options-label">
                                <?php echo $widget_post_type; ?>
                            </label>
                        </div>
                    <?php
                        endforeach;
                    ?>
    
                </div> 
            </div> <!-- Enable for selected post types -->
            <hr>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="<?php echo $html_name_prefix; ?>widget_exclude_categories_ids" class="<?php echo $class_prefix;?>enable-options-label">
                        <?php echo __('Exclude for categories', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <select id="<?php echo $html_name_prefix; ?>widget_exclude_categories_ids" class="<?php echo $class_prefix;?>enable-options-field <?php echo $class_prefix;?>exclude-by-categories" name="<?php echo $html_name_prefix; ?>widget_exclude_categories_ids[]" multiple>
                        <?php
                            $selected = '';
                            foreach ($categories_post_types as $category_post_type_key => $category_post_type):
                                if(is_array($widget_exclude_categories)):
                                    if(in_array($category_post_type_key,$widget_exclude_categories)):
                                        $selected = 'selected';
                                    else:
                                        $selected = ''; 
                                    endif;
                                else:
                                    if($category_post_type_key == $widget_exclude_categories):
                                        $selected = 'selected';
                                    else:
                                        $selected = ''; 
                                    endif;
                                endif;
                                
                                foreach ($category_post_type as $key => $category_post_and_type):
                                    ?>

                                    <option value="<?php echo $category_post_type_key; ?>" <?php echo $selected; ?>><?php echo $category_post_and_type.'('.$key.')'; ?></option>
                        <?php
                                endforeach;
                            endforeach;
                        ?>
                    </select>
                </div>
            </div> <!-- Exclude for categories -->
            <hr>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="<?php echo $html_name_prefix; ?>widget_exclude_post_ids" class="<?php echo $class_prefix;?>enable-options-label">
                        <?php echo __('Exclude posts ids', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <input type="text" id="<?php echo $html_name_prefix; ?>widget_exclude_post_ids" name="<?php echo $html_name_prefix; ?>widget_exclude_post_ids" class="ays-text-input <?php echo $class_prefix;?>enable-options-field" value="<?php echo $widget_exclude_post_ids; ?>" placeholder='Ex:1,12,13'>
                </div>
            </div> <!--Exclude post ids width comma -->
        </div>
    </div> <!-- Enable for all post types -->
    <hr>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>widget_count">
                <?php echo __('Count', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <input type="number" id="<?php echo $html_name_prefix; ?>widget_count" name="<?php echo $html_name_prefix; ?>widget_count" class="ays-text-input" value="<?php echo $widget_count; ?>">
        </div>
    </div> <!-- Count -->
    <hr>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>widget_display_front_page">
                <?php echo __('Display on the front page', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <input type="checkbox" id="<?php echo $html_name_prefix; ?>widget_display_front_page" name="<?php echo $html_name_prefix; ?>widget_display_front_page" value="on" <?php echo $widget_display_front_page ? 'checked': '' ;?>>
        </div>
    </div> <!--Dispaly on Front page -->
</div>
