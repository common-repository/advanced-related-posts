<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ays-pro.com/wordpress/advanced-related-posts
 * @since             1.0.0
 * @package           Advanced_Related_Posts
 *
 * @wordpress-plugin
 * Plugin Name:       Advanced Related Posts
 * Plugin URI:        https://ays-pro.com/wordpress/advanced-related-posts
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Advanced Related Posts Team
 * Author URI:        https://ays-pro.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       advanced-related-posts
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ADVANCED_RELATED_POSTS_VERSION', '1.0.0' );
define( 'ADVANCED_RELATED_POSTS_NAME_VERSION', '1.0.0' );
define( 'ADVANCED_RELATED_POSTS_NAME', 'advanced-related-posts' );
define( 'ADVANCED_RELATED_POSTS_DB_PREFIX', 'aysarp_' );

if( ! defined( 'ADVANCED_RELATED_POSTS_BASENAME' ) )
    define( 'ADVANCED_RELATED_POSTS_BASENAME', plugin_basename( __FILE__ ) );

if( ! defined( 'ADVANCED_RELATED_POSTS_DIR' ) )
    define( 'ADVANCED_RELATED_POSTS_DIR', plugin_dir_path( __FILE__ ) );

if( ! defined( 'ADVANCED_RELATED_POSTS_BASE_URL' ) )
    define( 'ADVANCED_RELATED_POSTS_BASE_URL', plugin_dir_url(__FILE__ ) );

if( ! defined( 'ADVANCED_RELATED_POSTS_ADMIN_PATH' ) )
    define( 'ADVANCED_RELATED_POSTS_ADMIN_PATH', plugin_dir_path( __FILE__ ) . 'admin' );

if( ! defined( 'ADVANCED_RELATED_POSTS_ADMIN_URL' ) )
    define( 'ADVANCED_RELATED_POSTS_ADMIN_URL', plugin_dir_url( __FILE__ ) . 'admin' );

if( ! defined( 'ADVANCED_RELATED_POSTS_PUBLIC_PATH' ) )
    define( 'ADVANCED_RELATED_POSTS_PUBLIC_PATH', plugin_dir_path( __FILE__ ) . 'public' );

if( ! defined( 'ADVANCED_RELATED_POSTS_PUBLIC_URL' ) )
    define( 'ADVANCED_RELATED_POSTS_PUBLIC_URL', plugin_dir_url( __FILE__ ) . 'public' );

if( ! defined( 'ADVANCED_RELATED_POSTS_WIDGET_URL' ) )
    define( 'ADVANCED_RELATED_POSTS_WIDGET_URL', plugin_dir_url( __FILE__ ) . 'widget' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-advanced-related-posts-activator.php
 */
function activate_advanced_related_posts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-advanced-related-posts-activator.php';
	Advanced_Related_Posts_Activator::ays_advanced_related_posts_update_db_check();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-advanced-related-posts-deactivator.php
 */
function deactivate_advanced_related_posts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-advanced-related-posts-deactivator.php';
	Advanced_Related_Posts_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_advanced_related_posts' );
register_deactivation_hook( __FILE__, 'deactivate_advanced_related_posts' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-advanced-related-posts.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_advanced_related_posts() {

	add_action( 'activated_plugin', 'advanced_related_posts_activation_redirect_method' );
	add_action( 'admin_notices', 'advanced_related_posts_general_admin_notice' );
	$plugin = new Advanced_Related_Posts();
	$plugin->run();

}

function advanced_related_posts_activation_redirect_method( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( admin_url( 'admin.php?page=' . ADVANCED_RELATED_POSTS_NAME ) ) );
    }
}

function advanced_related_posts_general_admin_notice(){
    global $wpdb;
    if ( isset($_GET['page']) && strpos($_GET['page'], ADVANCED_RELATED_POSTS_NAME) !== false ) {
        ?>
         <div class="ays-notice-banner">
            <div class="navigation-bar">
                <div id="navigation-container">
                    <a class="logo-container" href="https://ays-pro.com/" target="_blank">
                        <img class="logo" src="<?php echo ADVANCED_RELATED_POSTS_ADMIN_URL . '/images/ays_pro.png'; ?>" alt="AYS Pro logo" title="AYS Pro logo"/>
                    </a>
                    <ul id="menu">
                        <li class="modile-ddmenu-lg"><a class="ays-btn" href="https://ays-pro.com/wordpress-advanced-related-posts-user-manual" target="_blank">Documentation</a></li>
                        <li class="modile-ddmenu-xs"><a class="ays-btn" href="https://wordpress.org/support/plugin/advanced-related-posts/reviews/" target="_blank">Rate Us</a></li>
                        <li class="modile-ddmenu-lg"><a class="ays-btn" href="https://ays-demo.com/wordpress-advanced-related-posts-plugin-pro-demo/" target="_blank">Demo</a></li>
                        <li class="modile-ddmenu-lg"><a class="ays-btn" href="https://wordpress.org/support/plugin/advanced-related-posts/" target="_blank">Free Support</a></li>
                        <li class="modile-ddmenu-lg"><a class="ays-btn" href="https://wordpress.org/support/plugin/advanced-related-posts/" target="_blank">Contact us</a></li>
                        <li class="modile-ddmenu-md">
                            <a class="toggle_ddmenu" href="javascript:void(0);"><i class="ays_fa ays_fa_ellipsis_h"></i></a>
                            <ul class="ddmenu" data-expanded="false">
                                <li><a class="ays-btn" href="https://ays-pro.com/wordpress-advanced-related-posts-user-manual" target="_blank">Documentation</a></li>
                                <li><a class="ays-btn" href="https://wordpress.org/support/plugin/advanced-related-posts/reviews/" target="_blank">Rate Us</a></li>
                                <li><a class="ays-btn" href="https://ays-demo.com/wordpress-advanced-related-posts-plugin-pro-demo/" target="_blank">Demo</a></li>
                                <li><a class="ays-btn" href="https://wordpress.org/support/plugin/advanced-related-posts/" target="_blank">Free Support</a></li>
                                <li><a class="ays-btn" href="https://wordpress.org/support/plugin/advanced-related-posts/" target="_blank">Contact us</a></li>
                            </ul>
                        </li>
                        <li class="modile-ddmenu-sm">
                            <a class="toggle_ddmenu" href="javascript:void(0);"><i class="ays_fa ays_fa_ellipsis_h"></i></a>
                            <ul class="ddmenu" data-expanded="false">
                                <li><a class="ays-btn" href="https://ays-pro.com/wordpress-advanced-related-posts-user-manual" target="_blank">Documentation</a></li>
                                <li><a class="ays-btn" href="https://wordpress.org/support/plugin/advanced-related-posts/reviews/" target="_blank">Rate Us</a></li>
                                <li><a class="ays-btn" href="https://ays-demo.com/wordpress-advanced-related-posts-plugin-pro-demo/" target="_blank">Demo</a></li>
                                <li><a class="ays-btn" href="https://wordpress.org/support/plugin/advanced-related-posts/" target="_blank">Free Support</a></li>
                                <li><a class="ays-btn" href="https://wordpress.org/support/plugin/advanced-related-posts/" target="_blank">Contact us</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
         </div>
     <?php
    }
}
run_advanced_related_posts();
