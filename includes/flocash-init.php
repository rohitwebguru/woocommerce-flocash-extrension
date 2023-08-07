<?php

class Flocash_Init
{

    public function __construct()
    {
        add_action('plugins_loaded', array($this, 'flocash_payment_init'), 11);
        add_filter('woocommerce_payment_gateways', array($this, 'add_to_woo_flocash_payment_gateway'));        
    }
    
    public function flocash_payment_init()
    {
        if (class_exists('WC_Payment_Gateway')) {
            require_once plugin_dir_path(__FILE__) . 'class-wc-payment-gateway-flocash.php';
            require_once plugin_dir_path(__FILE__) . 'flocash-order-statuses.php';
            require_once plugin_dir_path(__FILE__) . 'flocash-currencies.php';
            // require_once plugin_dir_path( __FILE__ ) . '/includes/flocash-checkout-description-fields.php';
        }
    }
    public function add_to_woo_flocash_payment_gateway($gateways)
    {
        $gateways[] = 'WC_Gateway_flocash';
        return $gateways;
    }

}

$flocash_init = new Flocash_Init();
