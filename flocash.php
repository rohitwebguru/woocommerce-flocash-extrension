<?php
/**
 * Plugin Name: Flocash Payments Gateway
 * Plugin URI: http://localhost/testproject/checkout/
 * Author: Rohit Sharma
 * Author URI: https://rohitfullstackdeveloper.com/
 * Description: Woocommerce Payment Gateway Method.
 * Version: 0.1.0
 * License: GPL2
 * License URL: http://www.gnu.org/licenses/gpl-2.0.txt
 * text-domain: flocash-payments-woo
 *
 * Class WC_Gateway_Flocash file.
 *
 * @package WooCommerce\Flocash
 */

define('FLOCASH_SANDBOX_URL', 'https://sandbox.flocash.com/ecom/ecommerce.do');
define('FLOCASH_LIVE_URL', 'https://fcms.flocash.com/ecom/ecommerce.do');

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Include the currencies functions based on the context (admin or public)
if (is_admin()) {
    require_once plugin_dir_path(__FILE__) . 'admin/admin-main-file.php';
} else {
    require_once plugin_dir_path(__FILE__) . 'public/frontend-main-file.php';
}

require_once plugin_dir_path(__FILE__) . 'includes/flocash-init.php';

// Check WooCommerce existence during activation
function flocash_check_wc_existence()
{
    global $wpdb; 
    
    if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        // Deactivate the plugin
        deactivate_plugins(plugin_basename(__FILE__));

        // Throw an error message
        wp_die('Flocash Payments Gateway requires WooCommerce to be installed and activated. Please install and activate WooCommerce first.');
    }

    //  Create Thank You Page
    $page_title = __('Flocash Thankyou Page','flocash-payments-woo');    
    $is_page_exist = $wpdb->get_results( "SELECT * from $wpdb->posts where post_title='".$page_title."'" );

    if( empty( $is_page_exist ) ){
        $page_content = '[place_order]';
        $page = array(
            'post_title' => $page_title,
            'post_content' => $page_content,
            'post_status' => 'publish',
            'post_type' => 'page',
        );
        $return_page_id = wp_insert_post($page);
        update_option('flocash_return_page', $return_page_id);
    }    
}

register_activation_hook(__FILE__, 'flocash_check_wc_existence');
