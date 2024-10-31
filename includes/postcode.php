<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// ANCHOR POSTCODE
function coverage_API_details($checkout){
    global $wpdb;
    if(strlen(WC()->customer->get_postcode()) == 5 && is_checkout() ){
        // 
        $api_key = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='APIKey'; ");
        if( $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='APIKeyf'") === '1'){
            $url = 'https://deploy-dot-precise-line-76299minutos.appspot.com/api/v1/cat/coveage';
        }
        else{
            $url = 'https://prd-dot-precise-line-76299minutos.appspot.com/api/v1/cat/coveage';
        }
        $body = array(
        "coverage" => WC()->customer->get_postcode()
        );
        $headers = array(
            'Content-Type' => 'application/json',
            'Authorization' => 'Berear '.$api_key
        );
        $args = array(
            'body' => json_encode($body),
            'headers' => $headers
        );
        $result = json_decode(wp_remote_retrieve_body(wp_remote_post( $url, $args )),true); 

        if ($result['coverage']['message'] == true ) {
            $enviado= 'Zona con cobertura';
            if($reload_checkout == '0'){ 
            $wpdb->update( $wpdb->postmeta,array(
                          'meta_value' => '1'),
                          array( 'meta_key' => 'reload_checkout' ));
            }
            $chosen_methods = WC()->session->get('chosen_shipping_methods');

        if (trim(strstr($chosen_methods[0], ':', true)) == 'envio_99_minutos' ){
            $wpdb->update( $wpdb->postmeta,array(
                'meta_value' => '2'),
                array( 'meta_key' => 'reload_checkout' ));
        }
        else{
            $wpdb->update( $wpdb->postmeta,array(
                'meta_value' => '3'),
                array( 'meta_key' => 'reload_checkout' ));
                WC()->session->set('enable_fee', false);
        }
        }
        elseif($response['coverage']['message'] == false){
        $enviado= 'Zona sin cobertura';
        $wpdb->update( $wpdb->postmeta,array(
            'meta_value' => '0'),
            array( 'meta_key' => 'reload_checkout' ));
        }
        
    }
}
add_action( 'woocommerce_cart_calculate_fees', 'coverage_API_details');