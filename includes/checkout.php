<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// ANCHOR EXTRA LABEL
function minutos_extra_field( $fields ) {   
    $fields['billing']['numero_int'] = array(
        'label'     => __('Número interior', 'woocommerce'),
        'placeholder'   => _x('Ej. 10', 'placeholder', 'woocommerce'),
        'class'     => array('form-row-wide'),
        'priority'  => 60,
    );
    return $fields;
}
add_filter( 'woocommerce_checkout_fields' , 'minutos_extra_field');

function minutos_message_numint(){
    ?>
    <style>
    .woocommerce-warning {
        padding: 15px;
        background-color: #343a40;
        align: justify;
        font-size: 1em;
        border-radius: 15px;
    }

    .woocommerce-warning99 {
    padding: 15px;
    background-color: #85c440;
    align: justify;
    font-size: 1em;
    border-radius: 15px;
    }
    </style>

    <br><div class="woocommerce-warning99" id="minutos_int_number" role="alert" style="color: white"> <i class="fas fa-exclamation-circle"></i> <?php esc_html_e('No olvides agregar en tus datos tu número interior para completar tu orden.', '99minutos' ); ?> </div><br> 
    <?php
}
add_action( 'woocommerce_after_checkout_billing_form', 'minutos_message_numint');

function minutos_update_numint( $order_id ) {   
    if(isset($_POST['numero_int']))
        update_post_meta( $order_id, 'numero_interior', sanitize_text_field( $_POST['numero_int'] ) );
    else
        update_post_meta( $order_id, 'numero_interior', '0');
}
add_action('woocommerce_checkout_update_order_meta','minutos_update_numint');

// ANCHOR CHECKOUT LABELS
function minutos_message_about_shipping() {
    //CDMX before 2 p.m., XL weight restriction 99minutos and CO2 F
    echo '<div id="minutos_tshipping_limited"> <h2><span style="color: #85c440;"><b>' . esc_html( __( 'Envío por 99 Minutos', '99minutos' ) ) . '</b></span></h2>
    <h3>' . esc_html( __( 'Tipo de envío', '99minutos' ) ) . '</h3>
    <br><img class="aligncenter" role="logo" src="https://www.client.99minutos.com/static/media/logo-99minutos.b60d26d8.png" alt="99minutos.com" width="200" height="50"><br>
    <div class="woocommerce-warning" role="main" style="color: #e6e7e8">' . esc_html( __( 'Los tipos de envíos que ofrece 99 Minutos para compras superiores a 5Kg son:', '99minutos' ) ) .'<br><br><i class="fas fa-shipping-fast"></i>' . esc_html( __( ' Envío Same Day : Entrega el mismo día ', '99minutos' ) ) . '<br><i class="fas fa-shipping-fast"></i>' . esc_html( __( ' Envío Next Day : Entrega al día siguiente ', '99minutos' ) ) . '</div></div>';

    //CDMX before 2 p.m. (includes all types of shipping)
    echo '<div id="minutos_type_shipping_CDMX"> <h2><span style="color: #85c440;"><b>' . esc_html( __( 'Envío por 99 Minutos', '99minutos' ) ) . '</b></span></h2>
    <h3>' . esc_html( __( 'Tipo de envío', '99minutos' ) ) . '</h3>
    <br><img class="aligncenter" role="logo" src="https://www.client.99minutos.com/static/media/logo-99minutos.b60d26d8.png" alt="99minutos.com" width="200" height="50"><br>
    <div class="woocommerce-warning" role="main" style="color: #e6e7e8">' . esc_html( __( 'Los tipos de envío que ofrece 99 Minutos son: ', '99minutos' ) ) .'<br><br><i class="fas fa-shipping-fast"></i>' . esc_html( __( ' Envío Same Day : Entrega el mismo día ', '99minutos' ) ) . '<br><i class="fas fa-shipping-fast"></i>' . esc_html( __( ' Envío Next Day : Entrega al día siguiente ', '99minutos' ) ) . '<br><i class="fas fa-shipping-fast"></i>' . esc_html( __( ' Envío 99minutos : Para envíos inmediatos', '99minutos' ) ) . '<br><i class="fas fa-seedling"></i>' . esc_html( __( ' Envío CO2 Free : Envío sustentable, libre de CO2 ', '99minutos' ) ) . '<br></div></div>';

    //CDMX after 2 p.m.
    echo '<div id="minutos_aftertwo_message"> <h2><span style="color: #85c440;"><b>' . esc_html( __( 'Envío por 99 Minutos', '99minutos' ) ) . '</b></span></h2>
    <h3>' . esc_html( __( 'Tipo de envío', '99minutos' ) ) . '</h3>
    <br><img class="aligncenter" role="logo" src="https://www.client.99minutos.com/static/media/logo-99minutos.b60d26d8.png" alt="99minutos.com" width="200" height="50"><br>
    <div class="woocommerce-warning" role="main" style="color: #e6e7e8">' . esc_html( __( 'Los tipos de envío que ofrece 99 Minutos son: ', '99minutos' ) ) .'<br><br><i class="fas fa-shipping-fast"></i>' . esc_html( __( ' Envío Next Day : Entrega al día siguiente ', '99minutos' ) ) . '<br><i class="fas fa-shipping-fast"></i>' . esc_html( __( ' Envío 99minutos : Para envíos inmediatos', '99minutos' ) ) . '<br><i class="fas fa-seedling"></i>' . esc_html( __( ' Envío CO2 Free : Envío sustentable, libre de CO2 ', '99minutos' ) ) .'</div></div>';

    //CDMX after 5 p.m.
    echo '<div id="minutos_afterfive_message"> <h2><span style="color: #85c440;"><b>' . esc_html( __( 'Envío por 99 Minutos', '99minutos' ) ) . '</b></span></h2>
    <h3>' . esc_html( __( 'Tipo de envío', '99minutos' ) ) . '</h3>
    <br><img class="aligncenter" role="logo" src="https://www.client.99minutos.com/static/media/logo-99minutos.b60d26d8.png" alt="99minutos.com" width="200" height="50"><br>
    <div class="woocommerce-warning" role="main" style="color: #e6e7e8">' . esc_html( __( 'Los tipos de envío que ofrece 99 Minutos son: ', '99minutos' ) ) .'<br><br><i class="fas fa-shipping-fast"></i>' . esc_html( __( ' Envío Next Day : Entrega al día siguiente ', '99minutos' ) ) . '<br><i class="fas fa-seedling"></i>' . esc_html( __( ' Envío CO2 Free : Envío sustentable, libre de CO2 ', '99minutos' ) ) . '</div></div>';
    
    //Other States and weights restrictions
    echo '<div id="minutos_tshipping_interior"> <h2><span style="color: #85c440;"><b>' . esc_html( __( 'Envío por 99 Minutos', '99minutos' ) ) . '</b></span></h2>
    <h3>' . esc_html( __( 'Tipo de envío', '99minutos' ) ) . '</h3>
    <br><img class="aligncenter" role="logo" src="https://www.client.99minutos.com/static/media/logo-99minutos.b60d26d8.png" alt="99minutos.com" width="200" height="50"><br>
    <div class="woocommerce-warning" role="main" style="color: #e6e7e8">' . esc_html( __( 'El tipo de envío que ofrece 99 Minutos para el interior de la República y compras superiores a 5Kg es: ', '99minutos' ) ) . '<br><br><i class="fas fa-shipping-fast"></i>' . esc_html( __( ' Envío Next Day : Entrega al día siguiente ', '99minutos' ) ) . '<br></div></div><br>';

    date_default_timezone_set('America/Mexico_City');
    $hour = (int) date("H");

    echo '<div id="minutos_data_shipping">
    <div class="woocommerce-warning99" role="contentinfo" style="color: white" align="justify"> <i class="fas fa-exclamation-circle"></i><i>' . esc_html( __( ' Para el tipo de envío "Entrega el mismo día", la orden de compra deberá generarse antes de las 2:00 p.m y únicamente es válido para la CDMX. ', '99minutos' ) ) . 
    '</i><br><br>' . esc_html( __( 'Fecha y hora de la creación de tu orden: ', '99minutos' ) ) . '<br>' . date("d/m/Y ") . $hour . date(":i") . esc_html( __( ' (CDMX)', '99minutos' ) ) . '<br> </div></div><br>';

    echo '<div id="minutos_data_shipping_after">
    <div class="woocommerce-warning99" role="contentinfo" style="color: white" align="justify"> <i class="fas fa-exclamation-circle"></i><i>' . esc_html( __( ' Para el tipo de envío "99minutos", la orden de compra deberá generarse antes de las 5:00 p.m y únicamente es válido para la CDMX. ', '99minutos' ) ) . 
    '</i><br><br>' . esc_html( __( 'Fecha y hora de la creación de tu orden: ', '99minutos' ) ) . '<br>' . date("d/m/Y ") . $hour . date(":i") . esc_html( __( ' (CDMX)', '99minutos' ) ) . '<br> </div></div><br>';
}
add_action( 'woocommerce_after_order_notes', 'minutos_message_about_shipping', 10 );

// NOTE Shipping options
function minutos_details_about_shipping($checkout){
    global $woocommerce;

    //CDMX before 2 p.m., XL weight restriction 99minutos and CO2 F
    woocommerce_form_field('minutos_beforetwo_restriction',array(
        'type' => 'select', 
        'required' => true, 
        'class' => array('form-row-wide'), 
        'label' => __('<b>Selecciona tu método de envío preferido</b>', 'woocommerce'),
        'options' => array( 
            '' => 'Selecciona uno', 
            'sameDay' => 'Entrega el mismo día', 
            'nextDay' => 'Entrega al día siguiente'
        )
        ), $checkout->get_value('minutos_beforetwo_restriction')
    );

    //CDMX before 2 p.m. (includes all types of shipping)
    woocommerce_form_field('weight',array(
        'type' => 'select', 
        'required' => true, 
        'class' => array('form-row-wide'), 
        'label' => __('<b>Selecciona tu método de envío preferido</b>', 'woocommerce'),
        'options' => array( 
            '' => 'Selecciona uno',
            'sameDay' => 'Entrega el mismo día', 
            'nextDay' => 'Entrega al día siguiente',
            'min99' => '99minutos',
            'CO2Free' => 'Envío sustentable, libre de CO2'
        )
        ), $checkout->get_value('weight')
    );

    //CDMX after 2 p.m.
    woocommerce_form_field('minutos_aftertwo',array(
        'type' => 'select', 
        'required' => true, 
        'class' => array('form-row-wide'), 
        'label' => __('<b>Selecciona tu método de envío preferido</b>', 'woocommerce'),
        'options' => array( 
            '' => 'Selecciona uno',
            'nextDay' => 'Entrega al día siguiente',
            'min99' => '99minutos',
            'CO2Free' => 'Envío sustentable, libre de CO2'
        )
        ), $checkout->get_value('minutos_aftertwo')
    );

    //CDMX after 5 p.m.
    woocommerce_form_field('minutos_afterfive',array(
        'type' => 'select', 
        'required' => true, 
        'class' => array('form-row-wide'), 
        'label' => __('<b>Selecciona tu método de envío preferido</b>', 'woocommerce'),
        'options' => array( 
            '' => 'Selecciona uno',
            'nextDay' => 'Entrega al día siguiente',
            'CO2Free' => 'Envío sustentable, libre de CO2'
        )
        ), $checkout->get_value('minutos_afterfive')
    );

    //Other States 
    woocommerce_form_field('other_options',array(
        'type' => 'select', 
        'required' => true, 
        'class' => array('form-row-wide'), 
        'label' => __('<b>Selecciona tu método de envío preferido</b>', 'woocommerce'),
        'options' => array( 
            '' => 'Selecciona uno', 
            'nextDay' => 'Entrega al día siguiente'
        )
        ), $checkout->get_value('other_options')
    );

    echo '<br><div id="minutos_adittional_details"><h3>' . esc_html( __( 'Detalles adicionales sobre tu compra', '99minutos' ) ) . '</h3>
    <div class="woocommerce-warning" role="complementary" style="color: #e6e7e8">' . esc_html( __( 'El peso total de tu compra es: ', '99minutos' ) ) . $woocommerce->cart->cart_contents_weight . get_option('woocommerce_weight_unit') . '<br><i>' . esc_html( __( '* Recuerda que 99 Minutos sólo hace envíos hasta por 25Kg.', '99minutos' ) ) . '</i><br></div></div><br>';
    
    echo '<br><br><div id="minutos_image" role="image"><img class="aligncenter" src="https://mx.99minutos.com/img/vehiculos-99minutos.png" alt="99minutos.com" width="220" height="70"></div>';
}
add_action('woocommerce_after_order_notes','minutos_details_about_shipping');

// NOTE Secure
function minutos_message_secure() {
    global $wpdb;
    $addpercent = (WC()->cart->cart_contents_total + $woocommerce->cart->shipping_total) * 0.02;

    echo '<div id="minutos_optional_secure"><h3>' . esc_html( __( 'Seguro de envío', '99minutos' ) ) . '</h3>
    <div class="woocommerce-warning" role="definition" style="color: #e6e7e8"> <p align="justify">' . esc_html( __( 'No olvides que con 99 Minutos también puedes asegurar tu envío, sólo tienes que activar esta opción, ¡así de fácil!', '99minutos' ) ) . '</div></div> <br>
    
    <span style="font-size: 25px; color: #85c440;"><i class="fas fa-lock"></i></span> <span style="font-size: 20px; color: #85c440;"><i><b>' . esc_html( __( '¿Qué es el seguro de envío?', '99minutos' ) ) . '</b></i></span>
    <br> <p align="justify"><span style="font-size: 18px; color: #85c440;"><b>' . esc_html( __( '99 Minutos', '99minutos' ) ) . '</b></span>' . esc_html( __( ' te ofrece la oportunidad de proteger el translado de cada uno de tus envíos, a través de un ', '99minutos' ) ) . '<b>' . esc_html( __( 'seguro adicional correspondiente al 2% de tu compra', '99minutos' ) ) . '</b></p>
    
    <div class="woocommerce-warning99" role="note" style="color: white"><i class="fas fa-exclamation-circle"></i>' . esc_html( __( ' El costo adicional al 2% de tu compra sería: $', '99minutos' ) ) . $addpercent . '</div><br>';
}
//add_action( 'woocommerce_after_order_notes', 'minutos_message_secure', 10 );

function minutos_secure_select(){
    woocommerce_form_field( 'minutos_value_fee', array(
        'type'  => 'checkbox',
        'label' => __('<b>Asegurar el valor de envío</b>', 'woocommerce'),
        'class' => array( 'form-row-wide' ),
    ), '' );
    echo '<br><br><div id="minutos_image" role="image"><img class="aligncenter" src="https://mx.99minutos.com/img/vehiculos-99minutos.png" alt="99minutos.com" width="220" height="70"></div>';
}
//add_action( 'woocommerce_after_order_notes', 'minutos_secure_select', 11);