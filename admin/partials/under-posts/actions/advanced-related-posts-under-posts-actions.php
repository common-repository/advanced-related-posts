<?php
    require_once( ADVANCED_RELATED_POSTS_ADMIN_PATH . "/partials/under-posts/actions/advanced-related-posts-under-posts-actions-options.php" );
?>

<div class="wrap">
    <div class="container-fluid">
        <form method="post" id="<?php echo $class_prefix; ?>form">
            <input type="hidden" name="<?php echo $html_name_prefix; ?>tab" value="<?php echo $ays_tab; ?>">
            <h1 class="wp-heading-inline">
                <?php
                    echo $heading;
                    $other_attributes = array('id' => 'ays-button-apply-top');
                    submit_button(__('Save', $this->plugin_name), 'primary ays-button ' . $class_prefix . 'loader-banner', 'ays_apply_top', false, $other_attributes);
                    echo $loader_iamge;
                ?>
            </h1>
            <hr/>
            <div class="ays-top-menu-wrapper">
                <div class="ays_menu_left" data-scroll="0"><i class="ays_fa ays_fa_angle_left"></i></div>
                <div class="ays-top-menu">
                    <div class="nav-tab-wrapper ays-top-tab-wrapper">
                        <a href="#tab1" data-tab="tab1" class="nav-tab <?php echo ($ays_tab == 'tab1') ? 'nav-tab-active' : ''; ?>">
                            <?php echo __("General", $this->plugin_name);?>
                        </a>
                        <a href="#tab2" data-tab="tab2" class="nav-tab <?php echo ($ays_tab == 'tab2') ? 'nav-tab-active' : ''; ?>">
                            <?php echo __("Relevance", $this->plugin_name);?>
                        <a href="#tab3" data-tab="tab3" class="nav-tab <?php echo ($ays_tab == 'tab3') ? 'nav-tab-active' : ''; ?>">
                            <?php echo __("Settings", $this->plugin_name);?>
                        </a>
                        <a href="#tab4" data-tab="tab4" class="nav-tab <?php echo ($ays_tab == 'tab4') ? 'nav-tab-active' : ''; ?>">
                            <?php echo __("Styles", $this->plugin_name);?>
                        </a>
                    </div>  
                </div>
                <div class="ays_menu_right" data-scroll="-1"><i class="ays_fa ays_fa_angle_right"></i></div>
            </div>
            
            <?php
                for($tab_ind = 1; $tab_ind <= 4; $tab_ind++){
                    require_once( ADVANCED_RELATED_POSTS_ADMIN_PATH . "/partials/under-posts/actions/partials/advanced-related-posts-under-posts-actions-tab".$tab_ind.".php" );
                }
            ?>

            <hr>
            <?php
                wp_nonce_field('settings_action', 'settings_action');
                $other_attributes = array('id' => 'ays-button-apply');
                submit_button(__('Save', $this->plugin_name), 'primary ays-button ' . $class_prefix . 'loader-banner', 'ays_apply', false, $other_attributes);
                echo $loader_iamge;
            ?>
        </form>
    </div>
</div>
