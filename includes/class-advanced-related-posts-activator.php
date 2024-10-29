<?php
global $ays_advanced_related_posts_db_version;
$ays_advanced_related_posts_db_version = '1.0.0';
/**
 * Fired during plugin activation
 *
 * @link       https://ays-pro.com
 * @since      1.0.0
 *
 * @package    Advanced_Related_Posts
 * @subpackage Advanced_Related_Posts/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Advanced_Related_Posts
 * @subpackage Advanced_Related_Posts/includes
 * @author     Advanced Related Posts Team <info@ays-pro.com>
 */
class Advanced_Related_Posts_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
        global $ays_advanced_related_posts_db_version;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $installed_ver = get_option( "ays_advanced_related_posts_db_version" );

        $settings_table = $wpdb->prefix . ADVANCED_RELATED_POSTS_DB_PREFIX . 'settings';

        $charset_collate = $wpdb->get_charset_collate();

        if($installed_ver != $ays_advanced_related_posts_db_version)  {

            $sql = "CREATE TABLE `".$settings_table."` (
                `id` INT(16) UNSIGNED NOT NULL AUTO_INCREMENT,
                `meta_key` TEXT NOT NULL DEFAULT '',
                `meta_value` TEXT NOT NULL DEFAULT '',
                `type` TEXT NOT NULL DEFAULT '',
                `note` TEXT NOT NULL DEFAULT '',
                `options` TEXT NOT NULL DEFAULT '',
                PRIMARY KEY (`id`)
            )$charset_collate;";

            $sql_schema = "SELECT * FROM INFORMATION_SCHEMA.TABLES
                           WHERE table_schema = '".DB_NAME."' AND table_name = '".$settings_table."' ";
            $results = $wpdb->get_results($sql_schema);

            if(empty($results)){
                $wpdb->query( $sql );
            }else{
                dbDelta( $sql );
            }

            update_option( 'ays_advanced_related_posts_db_version', $ays_advanced_related_posts_db_version );
        }

	}

	public static function ays_advanced_related_posts_update_db_check() {
        global $ays_advanced_related_posts_db_version;
        if ( get_site_option( 'ays_advanced_related_posts_db_version' ) != $ays_advanced_related_posts_db_version ) {
            self::activate();
        }
    }

}
