<?php

class Flocash_Currencies
{

    public function __construct()
    {
        add_filter('woocommerce_currencies', array($this, 'flocash_add_ugx_currencies'));
        add_filter('woocommerce_currency_symbol', array($this, 'flocash_add_ugx_currencies_symbol'), 10, 2);

    }

    public function flocash_add_ugx_currencies($currencies)
    {
        $currencies['UGX'] = __('Ugandan Shillings', 'flocash-payments-woo');
        return $currencies;
    }

    public function flocash_add_ugx_currencies_symbol($currency_symbol, $currency)
    {
        switch ($currency) {
            case 'UGX':
                $currency_symbol = 'UGX';
                break;
        }
        return $currency_symbol;
    }

}

$flocash_currencies = new Flocash_Currencies();
