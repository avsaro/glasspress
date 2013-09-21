<?php

/*
* Plugin Name: GlassPress
* Plugin URI: https://github.com/avsaro/glasspress
* Description: Google Glass support for WordPress blogs.
* Version: 0.1
* Author: Onur Avsar
* Author URI: http://twitter.com/avsaro
* License: MPL 2.0
*/

add_action('admin_menu', 'glasspress_admin_menu');
add_action('publish_post', 'glasspress_publish_post');
register_activation_hook(__FILE__, 'glasspress_create_database');
add_action('wp_footer', 'glasspress_put_link_footer');

/*
 * Action methods
 */

function glasspress_admin_menu() {

    $page_title = 'GlassPress Options';
    $menu_title = 'GlassPress';
    $capability = 'manage_options';
    $menu_slug = 'glasspress';
    $function = 'glasspress_admin_page';
    add_options_page($page_title, $menu_title, $capability, $menu_slug, $function);

}

function glasspress_publish_post($post_id) {
    
    $post = get_post($post_id);
    
    require_once(plugin_dir_path( __FILE__ ) . '/config.php');
    require_once(plugin_dir_path( __FILE__ ) . '/mirror-client.php');
    require_once(plugin_dir_path( __FILE__ ) . '/google-api-php-client/src/Google_Client.php');
    require_once(plugin_dir_path( __FILE__ ) . '/google-api-php-client/src/contrib/Google_Oauth2Service.php');
    require_once(plugin_dir_path( __FILE__ ) . '/util.php');
    
    $subscribers = $wpdb->get_results('SELECT * FROM ' . $table_name, ARRAY_A);
    foreach ($subscribers as $subscriber) {
        $client = get_google_api_client();
        $client->setClientId($api_client_id);
        $client->setClientSecret($api_client_secret);
        $mirror_service = new Google_MirrorService($client);
        $client->refreshToken($subscriber['refreshToken']);

        $timeline_item = new Google_TimelineItem();

        $timeline_item->setText($post->post_title);
        
        $shareAction = new Google_MenuItem();
        $shareAction->setAction('SHARE');
        $readAloudAction = new Google_MenuItem();
        $readAloudAction->setAction('READ_ALOUD');
        $deleteAction = new Google_MenuItem();
        $deleteAction->setAction('DELETE');
        $timeline_item->menuItems = array($shareAction, $readAloudAction, $deleteAction);
        
        $notification = new Google_NotificationConfig();
        $notification->setLevel('DEFAULT');
        $timeline_item->setNotification($notification);

        insert_timeline_item($mirror_service, $timeline_item, null, null);
    }
    
}

function glasspress_create_database() {

   require_once(plugin_dir_path( __FILE__ ) . '/config.php');
   global $jal_db_version;
   $jal_db_version = "0.1";
      
   $sql = "CREATE TABLE $table_name (
    id BIGINT NOT NULL AUTO_INCREMENT,
    googleId text NOT NULL UNIQUE,
    refreshToken text NOT NULL,
    UNIQUE KEY id (id)
   );";
   
   dbDelta($sql);
 
   add_option("jal_db_version", $jal_db_version);
   
}

function glasspress_put_link_footer() {
    
    $href = plugins_url().'/glasspress/oauth2callback.php';
    echo '<p style="text-align: center;"><a href="'.$href.'">Subscribe via Glass</a></p><br />';
    
}

/*
 * Helper methods
 */
function glasspress_admin_page() {

    if (!current_user_can( 'manage_options' ))  {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    include 'glasspress_admin_page.php';

}