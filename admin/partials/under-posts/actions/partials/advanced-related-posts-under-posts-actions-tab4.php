<div id="tab4" class="<?php echo $class_prefix; ?>tab-content <?php echo ($ays_tab == 'tab4') ? $class_prefix . 'tab-content-active' : ''; ?>">
    <p class="ays-subtitle"><?php echo __('Styles',$this->plugin_name); ?></p>
    <hr/>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>layouts">
                <?php echo __('Layouts', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" data-html="true" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <select name="<?php echo $html_name_prefix; ?>under_posts_layouts" id="<?php echo $html_name_prefix; ?>layouts" class="ays-text-input-select ays-text-input-short <?php echo $class_prefix; ?>layouts" style="display:block;">
                <option value="elegant" <?php echo $under_posts_layouts == 'elegant' ? 'selected' : ''; ?>><?php echo __( "Elegant", $this->plugin_name ); ?></option>
                <option value="classy" <?php echo $under_posts_layouts == 'classy' ? 'selected' : ''; ?>><?php echo __( "Classy", $this->plugin_name ); ?></option>
                <option value="grid" <?php echo $under_posts_layouts == 'grid' ? 'selected' : ''; ?>><?php echo __( "Grid", $this->plugin_name ); ?></option>
            </select>
        </div>
    </div> <!-- Լayouts -->
    <hr/>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for='<?php echo $html_name_prefix; ?>text_color'>
                <?php echo __('Text color', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <input type="text" class="ays-text-input <?php echo $class_prefix; ?>text-color" id='<?php echo $html_name_prefix; ?>text_color' data-alpha="true"name='<?php echo $html_name_prefix; ?>under_posts_text_color' value="<?php echo $under_posts_text_color; ?>"/>
        </div>
    </div> <!-- Text Color -->
    <hr/>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>under_posts_thumbnail_columns_count">
                <?php echo __('Thumbnail columns count', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <input type="number" name="<?php echo $html_name_prefix; ?>under_posts_thumbnail_columns_count" id="<?php echo $html_name_prefix; ?>under_posts_thumbnail_columns_count" class="ays-text-input" value="<?php echo $under_posts_thumbnail_columns_count ;?>">
        </div>
    </div> <!-- Thumbnail columns count -->
    <hr>
    <div class="form-group row ays_toggle_parent">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>under_posts_thumbnail_responsive_width_height">
                <?php echo __('Responsive Width / Height', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-1">
            <input type="checkbox" name="<?php echo $html_name_prefix; ?>under_posts_thumbnail_responsive_width_height" id="<?php echo $html_name_prefix; ?>under_posts_thumbnail_responsive_width_height" value="on" <?php echo $under_posts_thumbnail_responsive_width_height ? "checked" : "" ;?> class="ays_toggle_checkbox <?php echo $class_prefix; ?>thumbnail_responsive_width_height">
        </div>
        <div class="col-sm-8 ays_divider_left ays_toggle_target <?php echo $under_posts_thumbnail_responsive_width_height ? "" : "display_none_not_important" ;?>">
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="<?php echo $html_name_prefix; ?>under_posts_thumbnail_responsive_width_height_ratio">
                        <?php echo __('Width/Height ratio', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <input type="number" name="<?php echo $html_name_prefix; ?>under_posts_thumbnail_responsive_width_height_ratio" id="<?php echo $html_name_prefix; ?>under_posts_thumbnail_responsive_width_height_ratio" class="ays-text-input <?php echo $class_prefix;?>thumbnail-ratio" value="<?php echo $under_posts_thumbnail_responsive_width_height_ratio ;?>" <?php echo ($under_posts_layouts == 'grid') ? "readonly" : "" ;?>>
                </div>
            </div>
        </div>
    </div> <!--Width/Height ratio  -->
    <hr>
    <div class="form-group row thumbnail-width-height-box <?php echo $under_posts_thumbnail_responsive_width_height ? "display_none_not_important" : ""; ?>">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>under_posts_thumbnail_width_height">
                <?php echo __('Thumbnail Width / Height', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="<?php echo $html_name_prefix; ?>under_posts_thumbnail_width">
                        <?php echo __('Thumbnail Width', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <input type="number" name="<?php echo $html_name_prefix; ?>under_posts_thumbnail_width" id="<?php echo $html_name_prefix; ?>under_posts_thumbnail_width" class="ays-text-input" value="<?php echo $under_posts_thumbnail_width ;?>">
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="<?php echo $html_name_prefix; ?>under_posts_thumbnail_height">
                        <?php echo __('Thumbnail Height', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-9">
                    <input type="number" name="<?php echo $html_name_prefix; ?>under_posts_thumbnail_height" id="<?php echo $html_name_prefix; ?>under_posts_thumbnail_height" class="ays-text-input" value="<?php echo $under_posts_thumbnail_height ;?>">
                </div>
            </div>
        </div>
    </div> <!--Thumbnail Width/Height  -->
    <hr  class="<?php echo $under_posts_thumbnail_responsive_width_height ? "display_none_not_important" : ""; ?>">
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>under_posts_thumnail_size_cont">
                <?php echo __('Thumbnail size', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <?php
                foreach ($thumbnail_size_array as $thumbnail_size_key => $thumbnail_size):
                    $checked = '';
                    
                    $thumbnail_size_key = strtolower( $thumbnail_size_key );

                    if( $thumbnail_size_key == $under_posts_thumbnail_size):
                        $checked = 'checked';
                    else:
                        $checked = '';
                    endif;

                    $thumbnail_name = ucfirst($thumbnail_size_key);
                    $thumbnail_size_text = __( "$thumbnail_name ({$thumbnail_size['width']}x{$thumbnail_size['height']})" );
            ?>
                <div>
                    <input type="radio" name="<?php echo $html_name_prefix; ?>under_posts_thumbnail_size" id="<?php echo $html_name_prefix; ?>under_posts_thumbnail_size_<?php echo $thumbnail_size_key;?>" value="<?php echo $thumbnail_size_key;?>" <?php echo $checked ; ?> >
                    <label for="<?php echo $html_name_prefix; ?>under_posts_thumbnail_size_<?php echo $thumbnail_size_key;?>"><?php echo $thumbnail_size_text; ?></label>
                </div>
            <?php
                endforeach;
            ?>
        </div>
    </div> <!-- Thumbnail size -->
    <hr>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>under_posts_first_image" >
                <?php echo __('Get first image', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <input type="checkbox" name="<?php echo $html_name_prefix; ?>under_posts_first_image" id="<?php echo $html_name_prefix; ?>under_posts_first_image"  value="on" <?php echo $under_posts_first_image ? 'checked' : '';?>>
        </div>
    </div> <!-- Get first image -->
    <hr>
    <div class="form-group row ays_toggle_parent">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>under_posts_default_thumbnail">
                <?php echo __('Default thumbnail', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <a href="javascript:void(0)" class="<?php echo $class_prefix; ?>add-bg-image button">
                <?php echo $default_image_text; ?>                                        
            </a>
            <div class="col-sm-12">
                <div class="<?php echo $class_prefix; ?>bg-image-container">
                    <span class="<?php echo $class_prefix; ?>remove-bg-img"></span>
                    <img src="<?php echo $under_posts_default_thumbnail ;?>" id="<?php echo $html_name_prefix; ?>under_posts_default_thumbnail_img" class="<?php echo $class_prefix; ?>default_thumbnail_img"/>
                    <input type="hidden" name="<?php echo $html_name_prefix; ?>under_posts_default_thumbnail" id="<?php echo $html_name_prefix; ?>under_posts_default_image" class="<?php echo $class_prefix; ?>default_image" value="<?php echo $under_posts_default_thumbnail; ?>" >
                </div>
            </div>
        </div>
    </div> <!-- Default thumbnail -->
    <hr>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>custom_class">
                <?php echo __('Custom class for related posts container',$this->plugin_name)?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Use your custom HTML class for adding your custom styles to the related posts container.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <input type="text" class="ays-text-input" name="<?php echo $html_name_prefix; ?>under_posts_custom_class" id="<?php echo $html_name_prefix; ?>custom_class" placeholder="myClass myAnotherClass..." value="<?php echo $under_posts_custom_class; ?>">
        </div>
    </div> <!-- Custom class for related posts container -->
</div>
