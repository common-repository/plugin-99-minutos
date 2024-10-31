<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
} 

global $wpdb;
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'APIKey'
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'name_sender' 
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'last_name_sender'
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'email_sender' 
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'city_sender' 
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'suburb_sender' 
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'phone_sender' 
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'address_origin'
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'number_origin' 
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'code_postal_origin'
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'origin_country' 
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'reload_checkout' 
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'counter'
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'trackingid'
    ));
    $wpdb->delete( $wpdb->postmeta, array(
       'meta_key' => 'secure_package' 
    )); 

    //SIZES
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'sd_xs'
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'sd_s' 
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'sd_m'
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'sd_l' 
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'sd_xl' 
    ));

    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'nd_xs'
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'nd_s' 
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'nd_m'
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'nd_l' 
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'nd_xl' 
    ));

    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'min_xs'
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'min_s' 
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'min_m'
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'min_l' 
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'min_xl' 
    ));

    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'co_xs' 
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'co_s' 
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'co_m' 
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'co_l' 
    ));
    $wpdb->delete( $wpdb->postmeta, array(
        'meta_key' => 'co_xl' 
    ));