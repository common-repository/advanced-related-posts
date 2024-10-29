<div id="tab2" class="<?php echo $class_prefix; ?>tab-content <?php echo ($ays_tab == 'tab2') ? $class_prefix . 'tab-content-active' : ''; ?>">
    <p class="ays-subtitle"><?php echo __('Relevance',$this->plugin_name); ?></p>
    <hr/>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>widget_order_post">
                <?php echo __('Order posts query', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <?php
                foreach ($order_posts_query_array as $order_posts_query_key => $order_posts_query):
                    $checked = '';
                    if( $order_posts_query_key == $widget_order_posts_query):
                        $checked = 'checked';
                    else:
                        $checked = '';
                    endif;
            ?>
                <div>
                    <input type="radio" name="<?php echo $html_name_prefix; ?>widget_order_posts_query" id="<?php echo $html_name_prefix; ?>widget_order_posts_query<?php echo $order_posts_query;?>" value="<?php echo $order_posts_query_key;?>" <?php echo $checked ;?>>
                    <label for="<?php echo $html_name_prefix; ?>widget_order_posts_query<?php echo $order_posts_query;?>"><?php echo $order_posts_query;?></label>
                </div>
            <?php
                endforeach;
            ?>
        </div>
    </div> <!-- Order posts query -->
    <hr>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>widget_only_same">
                <?php echo __('Only from same', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <?php
                foreach ($only_from_same_type_array as $only_from_same_type_key => $only_from_same_type):
                    $checked = '';
                    if(is_array($widget_only_from_same_type)):
                        if(in_array($only_from_same_type_key,$widget_only_from_same_type)):
                            $checked = 'checked';
                        else:
                            $checked = '';
                        endif;
                    else:
                        if( $only_from_same_type_key == $widget_only_from_same_type):
                            $checked = 'checked';
                        else:
                            $checked = '';
                        endif;
                    endif;
            ?>
                <div>
                    <input type="checkbox" name="<?php echo $html_name_prefix; ?>widget_only_from_same[]" id="<?php echo $html_name_prefix; ?>widget_only_from_same<?php echo $only_from_same_type;?>" value="<?php echo $only_from_same_type_key;?>" <?php echo $checked ;?>>
                    <label for="<?php echo $html_name_prefix; ?>widget_only_from_same<?php echo $only_from_same_type;?>"><?php echo $only_from_same_type;?></label>
                </div>
            <?php
                endforeach;
            ?>
        </div>
    </div> <!-- Only from same -->
    <hr/>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>widget_strongness_of_matching_cont">
                <?php echo __('Strongness of matching', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <?php
                foreach ($strongness_of_matching_array as $strongness_of_matching_key => $strongness_of_matching):
                    $checked = '';
                    if( $strongness_of_matching_key == $widget_strongness_of_matching):
                        $checked = 'checked';
                    else:
                        $checked = '';
                    endif;
            ?>
                <div>
                    <input type="radio" name="<?php echo $html_name_prefix; ?>widget_strongness_of_matching" id="<?php echo $html_name_prefix; ?>widget_strongness_of_matching<?php echo $strongness_of_matching;?>" value="<?php echo $strongness_of_matching_key;?>" <?php echo $checked ;?>>
                    <label for="<?php echo $html_name_prefix; ?>widget_strongness_of_matching<?php echo $strongness_of_matching;?>"><?php echo $strongness_of_matching;?></label>
                </div>
            <?php
                endforeach;
            ?>
        </div>
    </div> <!-- Strongness of matching -->
    <hr>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>widget_limit_to_same_author">
                <?php echo __('Limit to same author', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <input type="checkbox" name="<?php echo $html_name_prefix; ?>widget_limit_to_same_author" id="<?php echo $html_name_prefix; ?>widget_limit_to_same_author" value="on" <?php echo $widget_limit_to_same_author ? 'checked' : '' ;?>>
        </div>
    </div> <!-- Limit to same author  -->
    <hr/>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>widget_display_order_results_cont">
                <?php echo __('Display order results', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <?php
                foreach ($display_order_results_array as $display_order_results_key => $display_order_results):
                    $checked = '';
                    if( $display_order_results_key == $widget_display_order_results):
                        $checked = 'checked';
                    else:
                        $checked = '';
                    endif;
            ?>
                <div>
                    <input type="radio" name="<?php echo $html_name_prefix; ?>widget_display_order_results" id="<?php echo $html_name_prefix; ?>widget_display_order_results<?php echo $display_order_results;?>" value="<?php echo $display_order_results_key;?>" <?php echo $checked ;?>>
                    <label for="<?php echo $html_name_prefix; ?>widget_display_order_results<?php echo $display_order_results;?>"><?php echo $display_order_results;?></label>
                </div>
            <?php
                endforeach;
            ?>
        </div>
    </div> <!-- Display Order results -->
    <hr>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>widget_general_exclude_cat_ids">
                <?php echo __('Exclude category IDs', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <input type="text" name="<?php echo $html_name_prefix; ?>widget_general_exclude_cat_ids" id="<?php echo $html_name_prefix; ?>widget_general_exclude_cat_ids" class="ays-text-input" value="<?php echo $widget_general_exclude_cat_ids ;?>" placeholder="Ex:1,12,13">
        </div>
    </div> <!-- Exclude Category IDs  -->
    <hr>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>widget_general_exclude_post_ids">
                <?php echo __('Exclude post IDs', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <input type="text" name="<?php echo $html_name_prefix; ?>widget_general_exclude_post_ids" id="<?php echo $html_name_prefix; ?>widget_general_exclude_post_ids" class="ays-text-input" value="<?php echo $widget_general_exclude_post_ids ;?>" placeholder="Ex:1,12,13">
        </div>
    </div> <!-- Exclude Post IDs  -->
    <hr>
    <div class="form-group row ays_toggle_parent">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>widget_enable_posts_from_past">
                <?php echo __('Display only post from past', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-1">
            <input type="checkbox" name="<?php echo $html_name_prefix; ?>widget_enable_posts_from_past" id="<?php echo $html_name_prefix; ?>widget_enable_posts_from_past" value="on" <?php echo $widget_enable_posts_from_past ? "checked" : "" ;?> class="ays_toggle_checkbox">
        </div>
        <div class="col-sm-8 ays_divider_left ays_toggle_target <?php echo $widget_enable_posts_from_past ? "" : "display_none_not_important" ;?>">
            <div class="form-group row">
                <div class="col-sm-3">
                    <label for="<?php echo $html_name_prefix; ?>widget_posts_from_past_period">
                        <?php echo __('Number of the past period', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-6">
                    <input type="number" name="<?php echo $html_name_prefix; ?>widget_posts_from_past_period" id="<?php echo $html_name_prefix; ?>widget_posts_from_past_period" value="<?php echo $widget_posts_from_past_period; ?>" class="ays-text-input">
                </div>
                <div class="col-sm-3">
                    <select name="<?php echo $html_name_prefix; ?>widget_time_posts_from_past" class="ays-text-input-select" id="<?php echo $html_name_prefix; ?>widget_time_posts_from_past">
                    <?php
                        foreach ($period_time_array as $period_time_key => $period_time):
                            $selected = '';
                            if(is_array($period_time_key)):
                                if(in_array($widget_time_posts_from_past,$period_time_key)):
                                    $selected = 'selected';
                                else:
                                    $selected = '';
                                endif;
                            else:
                                if($period_time_key == $widget_time_posts_from_past):
                                    $selected = 'selected';
                                else:
                                    $selected = '';
                                endif;
                            endif;
                    ?>
                        <option value="<?php echo $period_time_key;?>" <?php echo $selected; ?>>
                        <?php echo $period_time; ?>
                    </option>
                    <?php
                        endforeach;
                    ?>
                    </select>
                </div>
            </div>
        </div>
    </div> <!-- Display only post from past  -->
    <hr/>
    <div class="form-group row">
        <div class="col-sm-3">
            <label for="<?php echo $html_name_prefix; ?>widget_enable_posts_older_current_post">
                <?php echo __('Display only posts older than current post', $this->plugin_name); ?>
                <a class="ays_help" data-toggle="tooltip" title="<?php echo __('.',$this->plugin_name); ?>">
                    <i class="ays_fa ays_fa_info_circle"></i>
                </a>
            </label>
        </div>
        <div class="col-sm-9">
            <input type="checkbox" name="<?php echo $html_name_prefix; ?>widget_enable_posts_older_current_post" id="<?php echo $html_name_prefix; ?>widget_enable_posts_older_current_post" value="on" <?php echo $widget_enable_posts_older_current_post ? 'checked' : '' ;?>>
        </div>
    </div> <!-- Display only posts older than current post -->
</div>
