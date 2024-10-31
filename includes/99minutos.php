<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$addpercent = 0;

// ANCHOR SHIPPING METHOD
function save_checkout($order_id){
	if( !empty( $_POST['weight'] ) )
        update_post_meta( $order_id, 'weight', sanitize_text_field( $_POST['weight'] ) );
    $weight = WC()->cart->get_cart_contents_weight();
    update_post_meta( $order_id, '_cart_weight', $weight );
}
add_action('woocommerce_checkout_update_order_meta','save_checkout');

function show_checkout($order){
    global $wpdb;
    $reload_checkout = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='counter' AND post_id=$order->id; ");
    if(null!== $reload_checkout){
    $delivery_type_and_size = get_post_meta( $order->id, 'shippingtype', true);
    $delivery_type = trim(stristr($delivery_type_and_size, ' ', TRUE));
    $package_size = trim(strstr($delivery_type_and_size, ' '));
    switch ($delivery_type){
        case 'sameDay':
            $delivery_type = 'Entrega el mismo día';
        break;
        case 'nextDay':
            $delivery_type = 'Entrega al día siguiente';
        break;
        case 'CO2':
            $delivery_type = 'Envío sustentable, libre de CO2';
        break;

    }
    switch ($package_size){
        case 'xs':
            $package_size = 'Extra chico';
        break;
        case 's':
            $package_size = 'Chico';
        break;
        case 'm':
            $package_size = 'Mediano';
        break;
        case 'l':
            $package_size = 'Grande';
        break;
        case 'xl':
            $package_size = 'Extra grande';
        break;
    }

    echo '<p><strong>'.__('Método preferido de tipo de envío y tamaño del pedido').':</strong> ' . $delivery_type.", ".$package_size. '</p>'
    . '<p><strong>'.__('El peso total de la compra es').':</strong> ' . get_post_meta($order->id, '_cart_weight', true) . get_option('woocommerce_weight_unit') . '</p>'
    . '<p><strong>'.__('Número de seguimiento').':</strong> ' . $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='counter'AND post_id=$order->id; ") . '</p>'
    . '<p><strong>'.__('ID de rastreo').':</strong> ' . $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='trackingid'AND post_id=$order->id; ") . '</p>';
    } 
}
add_action('woocommerce_admin_order_data_after_billing_address','show_checkout');

function order_and_thankyou_page($order_id){
    global $wpdb;
    $reload_checkout = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='reload_checkout'; ");
    if($reload_checkout == '2'){
    $order = wc_get_order( $order_id );
    $delivery_type_and_size = get_post_meta( $order->id, 'shippingtype', true);
    $delivery_type = trim(stristr($delivery_type_and_size, ' ', TRUE));
    $package_size = trim(strstr($delivery_type_and_size, ' '));
    switch ($delivery_type){
        case 'sameDay':
            $delivery_type = 'Entrega el mismo día';
        break;
        case 'nextDay':
            $delivery_type = 'Entrega al día siguiente';
        break;
        case 'CO2':
            $delivery_type = 'Envío sustentable, libre de CO2';
        break;

    }
    switch ($package_size){
        case 'xs':
            $package_size = 'extra chico';
        break;
        case 's':
            $package_size = 'chico';
        break;
        case 'm':
            $package_size = 'mediano';
        break;
        case 'l':
            $package_size = 'grande';
        break;
        case 'xl':
            $package_size = 'extra grande';
        break;
    }
    echo '<p><strong>'.__('Método preferido de tipo de envío y tamaño del pedido').':</strong> ' . $delivery_type.", ".$package_size. '</p>';
    
    // NOTE 99 Minutos API
    $api_key = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='APIKey'; ");

    $delivery_type_and_size = get_post_meta( $order->id, 'shippingtype', true);
    $delivery_type = trim(stristr($delivery_type_and_size, ' ', TRUE));
    $package_size = trim(strstr($delivery_type_and_size, ' '));

    $notes = $order-> get_customer_note();
    $amount_cash = (float) $order -> get_total();
    if($order -> get_payment_method() === "cod")
      $cash_on_delivery = true;
    else
      $cash_on_delivery = false;

    $wpdb->update( $wpdb->postmeta,array(
        'post_id' => $order_id),
        array( 'post_id' => 0 ));
    $amount_secure_db = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='secure_package' AND post_id=$order_id; ");
    if( $amount_secure_db != NULL )
    {
      $secure_package = true;
      $amount_secure = $amount_secure_db;
    }
    else
    {
      $secure_package = false;
      $amount_secure = 0;
    }
    $received_id = "";

    $o_sender = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='name_sender'; ");
    $o_name_sender = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='name_sender'; ");
    $o_last_name_sender = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='last_name_sender'; ");
    $o_email_sender = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='email_sender'; ");
    $o_phone_sender = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='phone_sender'; ");
    $o_address_origin = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='address_origin'; ");
    $o_number_origin = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='number_origin'; ");
    $o_code_postal_origin = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='code_postal_origin'; ");
    $o_country = "MEX";
    
    $d_receiver = $order-> get_shipping_first_name();
    $d_name_receiver = $order-> get_shipping_first_name();
    $d_last_name_receiver = $order-> get_shipping_last_name();
    $d_email_receiver = $order-> get_billing_email();
    $d_phone_receiver = $order-> get_billing_phone();
    $d_address_destination = $order-> get_shipping_address_1().' '.$order-> get_shipping_address_2();
    $d_number_destination = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='numero_interior'AND post_id=$order_id; ");
    $d_code_postal_destination = $order-> get_shipping_postcode();
    $d_country = "MEX";
    
    //API URL
    if( $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='APIKeyf'") === '1'){
        $url = 'https://deploy-dot-precise-line-76299minutos.appspot.com/api/v1/autorization/order';
    }
    else{
        $url = 'https://prd-dot-precise-line-76299minutos.appspot.com/api/v1/autorization/order';
    }
    //setup request to send json via POST
    $body = array(
      "apikey" => $api_key,
      "deliveryType" => $delivery_type,
      "packageSize" => $package_size,
      "notes" => $notes,
      "cahsOnDelivery" => $cash_on_delivery,
      "amountCash" => $amount_cash,
      "SecurePackage" => $secure_package,
      "amountSecure" => $amount_secure,
      "receivedId" => $received_id,
      "origin" => array(
        "sender" => $o_sender,
        "nameSender" => $o_name_sender,
        "lastNameSender" => $o_last_name_sender,
        "emailSender" => $o_email_sender,
        "phoneSender" => $o_phone_sender,
        "addressOrigin" => $o_address_origin,
        "numberOrigin" => $o_number_origin,
        "codePostalOrigin" => $o_code_postal_origin,
        "country" => $o_country
      ),
      "destination" => array(
        "receiver" => $d_receiver,
        "nameReceiver" => $d_name_receiver,
        "lastNameReceiver" => $d_last_name_receiver,
        "emailReceiver" => $d_email_receiver,
        "phoneReceiver" => $d_phone_receiver,
        "addressDestination" => $d_address_destination,
        "numberDestination" => $d_number_destination,
        "codePostalDestination" => $d_code_postal_destination,
        "country" => $d_country
      )
    );
  
    $headers = array(
        'Content-Type' => 'application/json'
    );
    $args = array(
        'body' => json_encode($body),
        'headers' => $headers
    );
    $result = json_decode(wp_remote_retrieve_body(wp_remote_post( $url, $args )),true); 
    //echo($result); var_dump($result);
    
    echo '<h2><b>Estatus del envío:</b></h2>';
    //var_dump(wp_remote_post( $url, $args ));
    
    if(isset($result['message'][0]['message']) && ($result['message'][0]['message']== "Creado")){
        $wpdb->insert( $wpdb->postmeta, array(
            'post_id' => $order_id,
            'meta_key' => 'counter',
            'meta_value' => $result['message'][0]['reason']['counter']
            ), array('%d','%s','%d'));
            $wpdb->insert( $wpdb->postmeta, array(
                'post_id' => $order_id,
                'meta_key' => 'trackingid',
                'meta_value' => $result['message'][0]['reason']['trackingid'] 
                ), array('%d','%s','%s'));

        echo '<h7>Tu orden fue creada de forma satisfactoria.</h7><br>
        <br> <h3><b>Detalles del envío:</b></h3> 
        <br> <b>Número de seguimiento: </b>' . $result['message'][0]['reason']['counter'] . 
        '<br> <b>ID de rastreo: </b>' . $result['message'][0]['reason']['trackingid'] . '<br><br>';
        
    } else {
        echo '<h7><b>Error. </b>Estamos teniendo problemas con el servicio de 99 Minutos, <b>por favor crea tu orden nuevamente, contacta con la tienda o intenta más tarde.</b></h7><br>
        <br><br> <h3><b>Detalles del envío:</b></h3>  
        <br><h7><b>Error. </b>No se pudo obtener el número de seguimiento de tu orden.</h7>
        <br><h7><b>Error. </b>No se pudo obtener el ID de rastreo de tu orden.</h7> <br> <br>';
    }
    
    }
     $wpdb->update( $wpdb->postmeta,array(
        'meta_value' => '0'),
        array( 'meta_key' => 'reload_checkout' )); 
}
add_action('woocommerce_thankyou','order_and_thankyou_page', 20);

function minutos99_update_order( $order_id ) {
    $weight = WC()->cart->get_cart_contents_weight();
    if (($weight <= 1)) { 
        //XS
        //CDMX before 2 p.m. (includes all types of shipping)  
        switch ($_POST['weight']){
            case 'sameDay':
                update_post_meta( $order_id, 'shippingtype', 'sameDay xs' );
            break;
            case 'nextDay':
                update_post_meta( $order_id, 'shippingtype', 'nextDay xs' );
            break;
            case 'min99':
                update_post_meta( $order_id, 'shippingtype', '99minutos xs' );
            break;
            case 'CO2Free':
                update_post_meta( $order_id, 'shippingtype', 'CO2 xs' );
            break;
        }

        //CDMX after 2 p.m.
        switch ($_POST['minutos_aftertwo']){
            case 'nextDay':
                update_post_meta( $order_id, 'shippingtype', 'nextDay xs' );
            break;
            case 'min99':
                update_post_meta( $order_id, 'shippingtype', '99minutos xs' );
            break;
            case 'CO2Free':
                update_post_meta( $order_id, 'shippingtype', 'CO2 xs' );
            break;
        }

        //CDMX after 5 p.m.
        switch ($_POST['minutos_afterfive']){
            case 'nextDay':
                update_post_meta( $order_id, 'shippingtype', 'nextDay xs' );
            break;
            case 'CO2Free':
                update_post_meta( $order_id, 'shippingtype', 'CO2 xs' );
            break;
        }

        //Other States 
        switch ($_POST['other_options']){
            case 'nextDay':
                update_post_meta( $order_id, 'shippingtype', 'nextDay xs' );
            break;
        } 
    }

    elseif (($weight > 1) && ($weight <= 2) ) { 
        //S
        //CDMX before 2 p.m. (includes all types of shipping) 
        switch ($_POST['weight']){
            case 'sameDay':
                update_post_meta( $order_id, 'shippingtype', 'sameDay s' );
            break;
            case 'nextDay':
                update_post_meta( $order_id, 'shippingtype', 'nextDay s' );
            break;
            case 'min99':
                update_post_meta( $order_id, 'shippingtype', '99minutos s' );
            break;
            case 'CO2Free':
                update_post_meta( $order_id, 'shippingtype', 'CO2 s' );
            break;
        }
        
        //CDMX after 2 p.m.
        switch ($_POST['minutos_aftertwo']){
            case 'nextDay':
                update_post_meta( $order_id, 'shippingtype', 'nextDay s' );
            break;
            case 'min99':
                update_post_meta( $order_id, 'shippingtype', '99minutos s' );
            break;
            case 'CO2Free':
                update_post_meta( $order_id, 'shippingtype', 'CO2 s' );
            break;
        }

        //CDMX after 5 p.m.
        switch ($_POST['minutos_afterfive']){
            case 'nextDay':
                update_post_meta( $order_id, 'shippingtype', 'nextDay s' );
            break;
            case 'CO2Free':
                update_post_meta( $order_id, 'shippingtype', 'CO2 s' );
            break;
        }

        //Other States 
        switch ($_POST['other_options']){
            case 'nextDay':
                update_post_meta( $order_id, 'shippingtype', 'nextDay s' );
            break;
        } 
    } 

    elseif (($weight > 2) && ($weight <= 3) ) {
        //M
        //CDMX before 2 p.m. (includes all types of shipping) 
        switch ($_POST['weight']){
            case 'sameDay':
                update_post_meta( $order_id, 'shippingtype', 'sameDay m' );
            break;
            case 'nextDay':
                update_post_meta( $order_id, 'shippingtype', 'nextDay m' );
            break;
            case 'min99':
                update_post_meta( $order_id, 'shippingtype', '99minutos m' );
            break;
            case 'CO2Free':
                update_post_meta( $order_id, 'shippingtype', 'CO2 m' );
            break;
        }
        
        //CDMX after 2 p.m.
        switch ($_POST['minutos_aftertwo']){
            case 'nextDay':
                update_post_meta( $order_id, 'shippingtype', 'nextDay m' );
            break;
            case 'min99':
                update_post_meta( $order_id, 'shippingtype', '99minutos m' );
            break;
            case 'CO2Free':
                update_post_meta( $order_id, 'shippingtype', 'CO2 m' );
            break;
        }

        //CDMX after 5 p.m.
        switch ($_POST['minutos_afterfive']){
            case 'nextDay':
                update_post_meta( $order_id, 'shippingtype', 'nextDay m' );
            break;
            case 'CO2Free':
                update_post_meta( $order_id, 'shippingtype', 'CO2 m' );
            break;
        }

        //Other States 
        switch ($_POST['other_options']){
            case 'nextDay':
                update_post_meta( $order_id, 'shippingtype', 'nextDay m' );
            break;
        } 
    } 

    elseif ( ($weight > 3) && ($weight <= 5) ) { 
        //L
        //CDMX before 2 p.m. (includes all types of shipping)
        switch ($_POST['weight']){
            case 'sameDay':
                update_post_meta( $order_id, 'shippingtype', 'sameDay l' );
            break;
            case 'nextDay':
                update_post_meta( $order_id, 'shippingtype', 'nextDay l' );
            break;
            case 'min99':
                update_post_meta( $order_id, 'shippingtype', '99minutos l' );
            break;
            case 'CO2Free':
                update_post_meta( $order_id, 'shippingtype', 'CO2 l' );
            break;
        }
        
        //CDMX after 2 p.m.
        switch ($_POST['minutos_aftertwo']){
            case 'nextDay':
                update_post_meta( $order_id, 'shippingtype', 'nextDay l' );
            break;
            case 'min99':
                update_post_meta( $order_id, 'shippingtype', '99minutos l' );
            break;
            case 'CO2Free':
                update_post_meta( $order_id, 'shippingtype', 'CO2 l' );
            break;
        }

        //CDMX after 5 p.m.
        switch ($_POST['minutos_afterfive']){
            case 'nextDay':
                update_post_meta( $order_id, 'shippingtype', 'nextDay l' );
            break;
            case 'CO2Free':
                update_post_meta( $order_id, 'shippingtype', 'CO2 l' );
            break;
        }

        //Other States 
        switch ($_POST['other_options']){
            case 'nextDay':
                update_post_meta( $order_id, 'shippingtype', 'nextDay l' );
            break;
        } 
    } 

    elseif ( ($weight > 5) && ($weight <= 25) ) { 
        //XL
        //CDMX before 2 p.m., XL weight restriction 99minutos and CO2 F
        switch ($_POST['minutos_beforetwo_restriction']){
            case 'sameDay':
                update_post_meta( $order_id, 'shippingtype', 'sameDay xl' );
            break;
            case 'nextDay':
                update_post_meta( $order_id, 'shippingtype', 'nextDay xl' );
            break;
        }
        
        //Other States 
        switch ($_POST['other_options']){
            case 'nextDay':
                update_post_meta( $order_id, 'shippingtype', 'nextDay xl' );
            break;
        } 
    }
}
add_action('woocommerce_checkout_update_order_meta','minutos99_update_order');

function delivery_type() {
    if (is_checkout()) {
        ?>
        <script type="text/javascript">
            var $j = jQuery.noConflict();
            $j(function(){
                $j( document ).ready(function( $ ) {
                    $j('#minutos_beforetwo_restriction').click(function(){
                        $j('body').trigger('update_checkout');
                    });
                    $j('#weight').click(function(){
                        $j('body').trigger('update_checkout');
                    });
                    $j('#minutos_aftertwo').click(function(){
                        $j('body').trigger('update_checkout');
                    });
                    $j('#minutos_afterfive').click(function(){
                        $j('body').trigger('update_checkout');
                    });
                    $j('#other_options').click(function(){
                        $j('body').trigger('update_checkout');
                    });
                });
            });
        </script>
        <?php
    }
}
add_action( 'wp_footer', 'delivery_type', 357);


function table_rate_99minutos($cart){
    global $wpdb;
    if(!($wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='reload_checkout'; ") == '3')){  
        $weight = WC()->cart->get_cart_contents_weight();

        $sd_xs = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='sd_xs'; ");           
        $sd_s =$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='sd_s'; ");              
        $sd_m = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='sd_m'; ");             
        $sd_l = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='sd_l'; ");            
        $sd_xl = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='sd_xl'; ");

        $nd_xs = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='nd_xs'; ");             
        $nd_s = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='nd_s'; ");             
        $nd_m = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='nd_m'; ");             
        $nd_l = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='nd_l'; ");             
        $nd_xl = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='nd_xl'; ");
        
        $min_xs = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='min_xs'; "); 
        $min_s = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='min_s'; "); 
        $min_m = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='min_m'; "); 
        $min_l = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='min_l'; "); 

        $co_xs = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='co_xs'; ");               
        $co_s = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='co_s'; ");               
        $co_m = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='co_m'; ");               
        $co_l = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='co_l'; ");             
    
        if ( ! $_POST || ( is_admin() && ! is_ajax() ) ) {
            return;
        }
        if ( isset( $_POST['post_data'] ) ) {
            parse_str( $_POST['post_data'], $post_data );
        } else {
            $post_data = $_POST;
        }

        //CDMX before 2 p.m., XL weight restriction 99minutos and CO2 F
        date_default_timezone_set('America/Mexico_City');
        $hour = (int) date("H");
        $hour = $hour + 5;

        if ((WC()->customer->get_state() == 'DF') && ($hour-5 <= 13) && $weight > 5){
            switch ($post_data['minutos_beforetwo_restriction']){
                case 'sameDay':
                    if (($weight > 5) && ($weight <= 25) ) 
                    WC()->cart->add_fee( 'Entrega el mismo día',$sd_xl );
                break;
                case 'nextDay':
                    if (($weight > 5) && ($weight <= 25) ) 
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_xl );
                break;
            }
        }

        //Includes all types of shipping
        elseif((WC()->customer->get_state() == 'DF') && ($hour-5 <= 13)){
            switch ($post_data['weight']){
                case 'sameDay':
                    if($weight <= 1)
                    WC()->cart->add_fee( 'Entrega el mismo día',$sd_xs );
                    elseif (($weight > 1) && ($weight <= 2) ) 
                    WC()->cart->add_fee( 'Entrega el mismo día',$sd_s );
                    elseif (($weight > 2) && ($weight <= 3) ) 
                    WC()->cart->add_fee( 'Entrega el mismo día',$sd_m );
                    elseif (($weight > 3) && ($weight <= 5) ) 
                    WC()->cart->add_fee( 'Entrega el mismo día',$sd_l );
                    elseif (($weight > 5) && ($weight <= 25) ) 
                    WC()->cart->add_fee( 'Entrega el mismo día',$sd_xl );
                break;
                case 'nextDay':
                    if($weight <= 1)
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_xs );
                    elseif (($weight > 1) && ($weight <= 2) ) 
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_s );
                    elseif (($weight > 2) && ($weight <= 3) ) 
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_m );
                    elseif (($weight > 3) && ($weight <= 5) ) 
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_l );
                    elseif (($weight > 5) && ($weight <= 25) ) 
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_xl );
                break;
                case 'min99':
                    if($weight <= 1)
                    WC()->cart->add_fee( 'Entrega en 99 minutos',$min_xs );
                    elseif (($weight > 1) && ($weight <= 2) ) 
                    WC()->cart->add_fee( 'Entrega en 99 minutos',$min_s );
                    elseif (($weight > 2) && ($weight <= 3) ) 
                    WC()->cart->add_fee( 'Entrega en 99 minutos',$min_m );
                    elseif (($weight > 3) && ($weight <= 5) ) 
                    WC()->cart->add_fee( 'Entrega en 99 minutos',$min_l );
                break;
                case 'CO2Free':
                    if($weight <= 1)
                    WC()->cart->add_fee( 'Envío sustentable, libre de CO2',$co_xs );
                    elseif (($weight > 1) && ($weight <= 2) ) 
                    WC()->cart->add_fee( 'Envío sustentable, libre de CO2',$co_s );
                    elseif (($weight > 2) && ($weight <= 3) ) 
                    WC()->cart->add_fee( 'Envío sustentable, libre de CO2',$co_m );
                    elseif (($weight > 3) && ($weight <= 5) ) 
                    WC()->cart->add_fee( 'Envío sustentable, libre de CO2',$co_l );
                break;
            }
        }

        //CDMX after 2 p.m., XL weight restriction 99minutos and CO2 F
        elseif((WC()->customer->get_state() == 'DF') && ($hour-5 <= 16) && $weight > 5){
            switch ($post_data['other_options']){
                case 'nextDay':
                    if (($weight > 5) && ($weight <= 25) ) 
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_xl );
                break;
            }
        }

        //CDMX after 2 p.m.
        elseif((WC()->customer->get_state() == 'DF') && ($hour-5 <= 16)){
            switch ($post_data['minutos_aftertwo']){
                case 'nextDay':
                    if($weight <= 1)
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_xs );
                    elseif (($weight > 1) && ($weight <= 2) ) 
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_s );
                    elseif (($weight > 2) && ($weight <= 3) ) 
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_m );
                    elseif (($weight > 3) && ($weight <= 5) ) 
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_l );
                    elseif (($weight > 5) && ($weight <= 25) ) 
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_xl );
                break;
                case 'min99':
                    if($weight <= 1)
                    WC()->cart->add_fee( 'Entrega en 99 minutos',$min_xs );
                    elseif (($weight > 1) && ($weight <= 2) ) 
                    WC()->cart->add_fee( 'Entrega en 99 minutos',$min_s );
                    elseif (($weight > 2) && ($weight <= 3) ) 
                    WC()->cart->add_fee( 'Entrega en 99 minutos',$min_m );
                    elseif (($weight > 3) && ($weight <= 5) ) 
                    WC()->cart->add_fee( 'Entrega en 99 minutos',$min_l );
                break;
                case 'CO2Free':
                    if($weight <= 1)
                    WC()->cart->add_fee( 'Envío sustentable, libre de CO2',$co_xs );
                    elseif (($weight > 1) && ($weight <= 2) ) 
                    WC()->cart->add_fee( 'Envío sustentable, libre de CO2',$co_s );
                    elseif (($weight > 2) && ($weight <= 3) ) 
                    WC()->cart->add_fee( 'Envío sustentable, libre de CO2',$co_m );
                    elseif (($weight > 3) && ($weight <= 5) ) 
                    WC()->cart->add_fee( 'Envío sustentable, libre de CO2',$co_l );
                break;
            }
        }

        //CDMX after 5 p.m., XL weight restriction 99minutos and CO2 F
        elseif((WC()->customer->get_state() == 'DF') && ($hour-5 >= 17) && $weight > 5){
            switch ($post_data['other_options']){
                case 'nextDay':
                    if (($weight > 5) && ($weight <= 25) ) 
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_xl );
                break;
            }
        }

        //CDMX after 5 p.m.
        elseif((WC()->customer->get_state() == 'DF') && ($hour-5 >= 17)){
            switch ($post_data['minutos_afterfive']){
                case 'nextDay':
                    if($weight <= 1)
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_xs );
                    elseif (($weight > 1) && ($weight <= 2) ) 
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_s );
                    elseif (($weight > 2) && ($weight <= 3) ) 
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_m );
                    elseif (($weight > 3) && ($weight <= 5) ) 
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_l );
                    elseif (($weight > 5) && ($weight <= 25) ) 
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_xl );
                break;
                case 'CO2Free':
                    if($weight <= 1)
                    WC()->cart->add_fee( 'Envío sustentable, libre de CO2',$co_xs );
                    elseif (($weight > 1) && ($weight <= 2) ) 
                    WC()->cart->add_fee( 'Envío sustentable, libre de CO2',$co_s );
                    elseif (($weight > 2) && ($weight <= 3) ) 
                    WC()->cart->add_fee( 'Envío sustentable, libre de CO2',$co_m );
                    elseif (($weight > 3) && ($weight <= 5) ) 
                    WC()->cart->add_fee( 'Envío sustentable, libre de CO2',$co_l );
                break;
            }
        }

        //Other States
        else{ 
            switch ($post_data['other_options']){
                case 'nextDay':
                    if($weight <= 1)
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_xs );
                    elseif (($weight > 1) && ($weight <= 2) ) 
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_s );
                    elseif (($weight > 2) && ($weight <= 3) ) 
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_m );
                    elseif (($weight > 3) && ($weight <= 5) ) 
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_l );
                    elseif (($weight > 5) && ($weight <= 25) ) 
                    WC()->cart->add_fee( 'Entrega al día siguiente',$nd_xl );
                break;
            }
        }
    }
}
add_action( 'woocommerce_cart_calculate_fees', 'table_rate_99minutos',100);

// ANCHOR SHIPPING METHOD WC ADMIN
function request_a_shipping_quote_init() {
    if ( ! class_exists( 'envio_99' ) ) {

        class envio_99 extends WC_Shipping_Method {
            /**
             * Constructor.
             * @param int $instance_id
             */
            public function __construct( $instance_id = 0 ) {
                $this->id           = 'envio_99_minutos';
                $this->instance_id  = absint( $instance_id );
                $this->method_title = __( "Envío por 99 Minutos", 'woocommerce' );
                $this->method_description = __( 'La extensión oficial de 99 Minutos te permite integrar los servicios de envío que ofrece 99minutos.com en la orden de compra de tus clientes.', 'my' );
                $this->supports     = array(
                    'shipping-zones',
                    'instance-settings',
                    'instance-settings-modal',
                ); 
                $this->init();
            }
            /**
             * Initialize custom shiping method.
             */
            public function init() {
                $this->init_form_fields();
                $this->init_settings();

                $this->title = $this->get_option('title');

                // Actions
                add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
            }

            /**
             * Calculate custom shipping method.
             * @param array $package
             * @return void
             */
            public function calculate_shipping( $package = array() ) {
                $this->add_rate( array(
                    'label'   => $this->title,
                    'package' => $package,
                ) );
            }

            /**
             * Init form fields.
             */
            public function init_form_fields() {
                $this->instance_form_fields = array(
                    'title' => array(
                        'title'       => __( 'Envío por 99 Minutos', 'woocommerce' ),
                        'type'        => 'text',
                        'description' => __( 'La extensión oficial de 99 Minutos te permite integrar los servicios de envío que ofrece 99minutos.com en la orden de compra de tus clientes. ', 'woocommerce' ),
                        'default'     => __( 'Envío por 99 Minutos', 'woocommerce' ),
                        'desc_tip'    => true,
                    ),
                );
            }
        }
    }
}
add_action( 'woocommerce_shipping_init', 'request_a_shipping_quote_init' );

function request_shipping_quote_shipping_method( $methods ) {
    $methods['envio_99_minutos'] = 'envio_99';

    return $methods;
}
add_filter( 'woocommerce_shipping_methods', 'request_shipping_quote_shipping_method' );
  
function hide_shipping_method() {
    global $wpdb;
    global $woocommerce;

    $chosen_methods = WC()->session->get('chosen_shipping_methods');
    
    //NOTE: API COBERTURA
    $api_key = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='APIKey'; ");
    if( $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='APIKeyf'") === '1'){
        $url = 'https://deploy-dot-precise-line-76299minutos.appspot.com/api/v1/cat/coveage';
    }
    else{
        $url = 'https://prd-dot-precise-line-76299minutos.appspot.com/api/v1/cat/coveage';
    }
    $body = array(
    'coverage' => WC()->customer->get_postcode()
    );
    $headers = array(
        'Content-Type' => 'application/json',
        'Authorization' => 'Berear '.$api_key
    );
    $args = array(
        'body' => json_encode($body),
        'headers' => $headers
    );
    //$response = json_decode(wp_remote_retrieve_body(wp_remote_post( $url, $args )),true);
    $result = wp_remote_retrieve_response_code( wp_remote_post( $url, $args ));
    //var_dump($result);
    

    if (trim(strstr($chosen_methods[0], ':', true)) == 'envio_99_minutos' ){
        if($wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='reload_checkout'; ") == '0'){
            if($result>=500){
                wc_add_notice( 'Por el momento estamos teniendo problemas con el envío, intenta más tarde.', 'error' ); 
                ?>
                <script type="text/javascript">
                //Extra field
                jQuery('#minutos_int_number').fadeOut();
                jQuery('#numero_int_field').fadeOut();
                jQuery('#numero_int_field input').val('');
    
                //Secure and extra data
                jQuery('#minutos_value_fee_field').fadeOut();
                jQuery('#minutos_optional_secure').fadeOut();
    
                jQuery('#minutos_data_shipping').fadeOut();
                jQuery('#minutos_data_shipping_after').fadeOut();
                jQuery('#minutos_adittional_details').fadeOut();
                jQuery('#minutos_image').fadeOut();
    
                //Text boxes
                jQuery('#minutos_tshipping_limited').fadeOut();
                jQuery('#minutos_type_shipping_CDMX').fadeOut();
                jQuery('#minutos_aftertwo_message').fadeOut();
                jQuery('#minutos_afterfive_message').fadeOut();
                jQuery('#minutos_tshipping_interior').fadeOut();
    
                //Valid shipments
                jQuery('#minutos_beforetwo_restriction_field').fadeOut();
                jQuery('#minutos_beforetwo_restriction_field select').val('');
                jQuery('#weight_field').fadeOut();
                jQuery('#weight_field select').val('');
                jQuery('#minutos_aftertwo_field').fadeOut();
                jQuery('#minutos_aftertwo_field select').val('');
                jQuery('#minutos_afterfive_field').fadeOut();
                jQuery('#minutos_afterfive_field select').val('');
                jQuery('#other_options_field').fadeOut();
                jQuery('#other_options_field select').val('');
                </script>
                <?php
            }
            else{
                wc_add_notice( 'Lo sentimos, 99 Minutos no tiene cobertura en tu zona.', 'error' );
                ?>
                <script type="text/javascript">
                //Extra field
                jQuery('#minutos_int_number').fadeOut();
                jQuery('#numero_int_field').fadeOut();
                jQuery('#numero_int_field input').val('');
    
                //Secure and extra data
                jQuery('#minutos_value_fee_field').fadeOut();
                jQuery('#minutos_optional_secure').fadeOut();
    
                jQuery('#minutos_data_shipping').fadeOut();
                jQuery('#minutos_data_shipping_after').fadeOut();
                jQuery('#minutos_adittional_details').fadeOut();
                jQuery('#minutos_image').fadeOut();
    
                //Text boxes
                jQuery('#minutos_tshipping_limited').fadeOut();
                jQuery('#minutos_type_shipping_CDMX').fadeOut();
                jQuery('#minutos_aftertwo_message').fadeOut();
                jQuery('#minutos_afterfive_message').fadeOut();
                jQuery('#minutos_tshipping_interior').fadeOut();
    
                //Valid shipments
                jQuery('#minutos_beforetwo_restriction_field').fadeOut();
                jQuery('#minutos_beforetwo_restriction_field select').val('');
                jQuery('#weight_field').fadeOut();
                jQuery('#weight_field select').val('');
                jQuery('#minutos_aftertwo_field').fadeOut();
                jQuery('#minutos_aftertwo_field select').val('');
                jQuery('#minutos_afterfive_field').fadeOut();
                jQuery('#minutos_afterfive_field select').val('');
                jQuery('#other_options_field').fadeOut();
                jQuery('#other_options_field select').val('');
                </script>
                <?php
            }
        }
        else{
            $weight = $woocommerce->cart->cart_contents_weight;
            if( $weight > 25 ){
                wc_add_notice( sprintf( __( 'Lo sentimos, el peso de tu carrito es de %sKg, 99 Minutos sólo hace envíos hasta por 25Kg. <br>Selecciona otro método de envío.<br>', 'woocommerce' ), $weight ), 'error' );
                ?>
                <script type="text/javascript">
                //Extra field
                jQuery('#minutos_int_number').fadeOut();
                jQuery('#numero_int_field').fadeOut();
                jQuery('#numero_int_field input').val('');
        
                //Secure and extra data
                jQuery('#minutos_value_fee_field').fadeOut();
                jQuery('#minutos_optional_secure').fadeOut();
        
                jQuery('#minutos_data_shipping').fadeOut();
                jQuery('#minutos_data_shipping_after').fadeOut();
                jQuery('#minutos_adittional_details').fadeOut();
                jQuery('#minutos_image').fadeOut();
        
                //Text boxes
                jQuery('#minutos_tshipping_limited').fadeOut();
                jQuery('#minutos_type_shipping_CDMX').fadeOut();
                jQuery('#minutos_aftertwo_message').fadeOut();
                jQuery('#minutos_afterfive_message').fadeOut();
                jQuery('#minutos_tshipping_interior').fadeOut();
        
                //Valid shipments
                jQuery('#minutos_beforetwo_restriction_field').fadeOut();
                jQuery('#minutos_beforetwo_restriction_field select').val('');
                jQuery('#weight_field').fadeOut();
                jQuery('#weight_field select').val('');
                jQuery('#minutos_aftertwo_field').fadeOut();
                jQuery('#minutos_aftertwo_field select').val('');
                jQuery('#minutos_afterfive_field').fadeOut();
                jQuery('#minutos_afterfive_field select').val('');
                jQuery('#other_options_field').fadeOut();
                jQuery('#other_options_field select').val('');
                </script>
                <?php
            }
            else{
                if($result>=500){
                    wc_add_notice( 'Por el momento estamos teniendo problemas con el envío, intenta más tarde.', 'error' );
                    ?>
                    <script type="text/javascript">
                    //Extra field
                    jQuery('#minutos_int_number').fadeOut();
                    jQuery('#numero_int_field').fadeOut();
                    jQuery('#numero_int_field input').val('');
    
                    //Secure and extra data
                    jQuery('#minutos_value_fee_field').fadeOut();
                    jQuery('#minutos_optional_secure').fadeOut();
    
                    jQuery('#minutos_data_shipping').fadeOut();
                    jQuery('#minutos_data_shipping_after').fadeOut();
                    jQuery('#minutos_adittional_details').fadeOut();
                    jQuery('#minutos_image').fadeOut();
    
                    //Text boxes
                    jQuery('#minutos_tshipping_limited').fadeOut();
                    jQuery('#minutos_type_shipping_CDMX').fadeOut();
                    jQuery('#minutos_aftertwo_message').fadeOut();
                    jQuery('#minutos_afterfive_message').fadeOut();
                    jQuery('#minutos_tshipping_interior').fadeOut();
    
                    //Valid shipments
                    jQuery('#minutos_beforetwo_restriction_field').fadeOut();
                    jQuery('#minutos_beforetwo_restriction_field select').val('');
                    jQuery('#weight_field').fadeOut();
                    jQuery('#weight_field select').val('');
                    jQuery('#minutos_aftertwo_field').fadeOut();
                    jQuery('#minutos_aftertwo_field select').val('');
                    jQuery('#minutos_afterfive_field').fadeOut();
                    jQuery('#minutos_afterfive_field select').val('');
                    jQuery('#other_options_field').fadeOut();
                    jQuery('#other_options_field select').val('');
                    </script>
                    <?php
                }
                //Valid shipments
                else{
                    //CDMX before 2 p.m., XL weight restriction 99minutos and CO2 F
                    date_default_timezone_set('America/Mexico_City');
                    $hour = (int) date("H");
                    //echo $hour;
                    $hour = $hour + 5;
                    //echo $hour;
                    
                    if ((WC()->customer->get_state() == 'DF') && ($hour-5 <= 13) && $weight > 5){
                        ?>
                        <script type="text/javascript">
                        //Extra field
                        jQuery('#minutos_int_number').fadeIn();
                        jQuery('#numero_int_field').fadeIn();
        
                        //Secure and extra data
                        jQuery('#minutos_value_fee_field').fadeIn();
                        jQuery('#minutos_optional_secure').fadeIn();
        
                        jQuery('#minutos_data_shipping').fadeIn();
                        jQuery('#minutos_data_shipping_after').fadeOut();
                        jQuery('#minutos_adittional_details').fadeIn();
                        jQuery('#minutos_image').fadeIn();
        
                        //Text boxes
                        jQuery('#minutos_tshipping_limited').fadeIn();
                        jQuery('#minutos_type_shipping_CDMX').fadeOut();
                        jQuery('#minutos_aftertwo_message').fadeOut();
                        jQuery('#minutos_afterfive_message').fadeOut();
                        jQuery('#minutos_tshipping_interior').fadeOut();
        
                        //Valid shipments
                        jQuery('#minutos_beforetwo_restriction_field').fadeIn();
                        jQuery('#weight_field').fadeOut();
                        jQuery('#weight_field select').val('');
                        jQuery('#minutos_aftertwo_field').fadeOut();
                        jQuery('#minutos_aftertwo_field select').val('');
                        jQuery('#minutos_afterfive_field').fadeOut();
                        jQuery('#minutos_afterfive_field select').val('');
                        jQuery('#other_options_field').fadeOut();
                        jQuery('#other_options_field select').val('');
                        </script>
                        <?php  
                    }
                    //Includes all types of shipping
                    elseif((WC()->customer->get_state() == 'DF') && ($hour-5 <= 13)){
                        ?>
                        <script type="text/javascript">
                        //Extra field
                        jQuery('#minutos_int_number').fadeIn();
                        jQuery('#numero_int_field').fadeIn();
        
                        //Secure and extra data
                        jQuery('#minutos_value_fee_field').fadeIn();
                        jQuery('#minutos_optional_secure').fadeIn();
        
                        jQuery('#minutos_data_shipping').fadeIn();
                        jQuery('#minutos_data_shipping_after').fadeOut();
                        jQuery('#minutos_adittional_details').fadeIn();
                        jQuery('#minutos_image').fadeIn();
        
                        //Text boxes
                        jQuery('#minutos_tshipping_limited').fadeOut();
                        jQuery('#minutos_type_shipping_CDMX').fadeIn();
                        jQuery('#minutos_aftertwo_message').fadeOut();
                        jQuery('#minutos_afterfive_message').fadeOut();
                        jQuery('#minutos_tshipping_interior').fadeOut();
        
                        //Valid shipments
                        jQuery('#minutos_beforetwo_restriction_field').fadeOut();
                        jQuery('#minutos_beforetwo_restriction_field select').val('');
                        jQuery('#weight_field').fadeIn();
                        jQuery('#minutos_aftertwo_field').fadeOut();
                        jQuery('#minutos_aftertwo_field select').val('');
                        jQuery('#minutos_afterfive_field').fadeOut();
                        jQuery('#minutos_afterfive_field select').val('');
                        jQuery('#other_options_field').fadeOut();
                        jQuery('#other_options_field select').val('');
                        </script>
                        <?php 
                    }
                    //CDMX after 2 p.m., XL weight restriction 99minutos and CO2 F
                    elseif((WC()->customer->get_state() == 'DF') && ($hour-5 <= 16) && $weight > 5){
                        ?>
                        <script type="text/javascript">
                        //Extra field
                        jQuery('#minutos_int_number').fadeIn();
                        jQuery('#numero_int_field').fadeIn();
        
                        //Secure and extra data
                        jQuery('#minutos_value_fee_field').fadeIn();
                        jQuery('#minutos_optional_secure').fadeIn();
        
                        jQuery('#minutos_data_shipping').fadeOut();
                        jQuery('#minutos_data_shipping_after').fadeOut();
                        jQuery('#minutos_adittional_details').fadeIn();
                        jQuery('#minutos_image').fadeIn();
        
                        //Text boxes
                        jQuery('#minutos_tshipping_limited').fadeOut();
                        jQuery('#minutos_type_shipping_CDMX').fadeOut();
                        jQuery('#minutos_aftertwo_message').fadeOut();
                        jQuery('#minutos_afterfive_message').fadeOut();
                        jQuery('#minutos_tshipping_interior').fadeIn();
        
                        //Valid shipments
                        jQuery('#minutos_beforetwo_restriction_field').fadeOut();
                        jQuery('#minutos_beforetwo_restriction_field select').val('');
                        jQuery('#weight_field').fadeOut();
                        jQuery('#weight_field select').val('');
                        jQuery('#minutos_aftertwo_field').fadeOut();
                        jQuery('#minutos_aftertwo_field select').val('');
                        jQuery('#minutos_afterfive_field').fadeOut();
                        jQuery('#minutos_afterfive_field select').val('');
                        jQuery('#other_options_field').fadeIn();
                        </script>
                        <?php 
                    }
                    //CDMX after 2 p.m.
                    elseif((WC()->customer->get_state() == 'DF') && ($hour-5 <= 16)){
                        ?>
                        <script type="text/javascript">
                        //Extra field
                        jQuery('#minutos_int_number').fadeIn();
                        jQuery('#numero_int_field').fadeIn();
        
                        //Secure and extra data
                        jQuery('#minutos_value_fee_field').fadeIn();
                        jQuery('#minutos_optional_secure').fadeIn();
        
                        jQuery('#minutos_data_shipping').fadeOut();
                        jQuery('#minutos_data_shipping_after').fadeIn();
                        jQuery('#minutos_adittional_details').fadeIn();
                        jQuery('#minutos_image').fadeIn();
        
                        //Text boxes
                        jQuery('#minutos_tshipping_limited').fadeOut();
                        jQuery('#minutos_type_shipping_CDMX').fadeOut();
                        jQuery('#minutos_aftertwo_message').fadeIn();
                        jQuery('#minutos_afterfive_message').fadeOut();
                        jQuery('#minutos_tshipping_interior').fadeOut();
        
                        //Valid shipments
                        jQuery('#minutos_beforetwo_restriction_field').fadeOut();
                        jQuery('#minutos_beforetwo_restriction_field select').val('');
                        jQuery('#weight_field').fadeOut();
                        jQuery('#weight_field select').val('');
                        jQuery('#minutos_aftertwo_field').fadeIn();
                        jQuery('#minutos_afterfive_field').fadeOut();
                        jQuery('#minutos_afterfive_field select').val('');
                        jQuery('#other_options_field').fadeOut();
                        jQuery('#other_options_field select').val('');
                        </script>
                        <?php 
                    }
                    //CDMX after 5 p.m., XL weight restriction 99minutos and CO2 F
                    elseif((WC()->customer->get_state() == 'DF') && ($hour-5 >= 17) && $weight > 5){
                        ?>
                        <script type="text/javascript">
                        //Extra field
                        jQuery('#minutos_int_number').fadeIn();
                        jQuery('#numero_int_field').fadeIn();
        
                        //Secure and extra data
                        jQuery('#minutos_value_fee_field').fadeIn();
                        jQuery('#minutos_optional_secure').fadeIn();
        
                        jQuery('#minutos_data_shipping').fadeOut();
                        jQuery('#minutos_data_shipping_after').fadeOut();
                        jQuery('#minutos_adittional_details').fadeIn();
                        jQuery('#minutos_image').fadeIn();
        
                        //Text boxes
                        jQuery('#minutos_tshipping_limited').fadeOut();
                        jQuery('#minutos_type_shipping_CDMX').fadeOut();
                        jQuery('#minutos_aftertwo_message').fadeOut();
                        jQuery('#minutos_afterfive_message').fadeOut();
                        jQuery('#minutos_tshipping_interior').fadeIn();
        
                        //Valid shipments
                        jQuery('#minutos_beforetwo_restriction_field').fadeOut();
                        jQuery('#minutos_beforetwo_restriction_field select').val('');
                        jQuery('#weight_field').fadeOut();
                        jQuery('#weight_field select').val('');
                        jQuery('#minutos_aftertwo_field').fadeOut();
                        jQuery('#minutos_aftertwo_field select').val('');
                        jQuery('#minutos_afterfive_field').fadeOut();
                        jQuery('#minutos_afterfive_field select').val('');
                        jQuery('#other_options_field').fadeIn();
                        </script>
                        <?php 
                    }
                    //CDMX after 5 p.m.
                    elseif((WC()->customer->get_state() == 'DF') && ($hour-5 >= 17)){
                        ?>
                        <script type="text/javascript">
                        //Extra field
                        jQuery('#minutos_int_number').fadeIn();
                        jQuery('#numero_int_field').fadeIn();
        
                        //Secure and extra data
                        jQuery('#minutos_value_fee_field').fadeIn();
                        jQuery('#minutos_optional_secure').fadeIn();
        
                        jQuery('#minutos_data_shipping').fadeOut();
                        jQuery('#minutos_data_shipping_after').fadeOut();
                        jQuery('#minutos_adittional_details').fadeIn();
                        jQuery('#minutos_image').fadeIn();
        
                        //Text boxes
                        jQuery('#minutos_tshipping_limited').fadeOut();
                        jQuery('#minutos_type_shipping_CDMX').fadeOut();
                        jQuery('#minutos_aftertwo_message').fadeOut();
                        jQuery('#minutos_afterfive_message').fadeIn();
                        jQuery('#minutos_tshipping_interior').fadeOut();
        
                        //Valid shipments
                        jQuery('#minutos_beforetwo_restriction_field').fadeOut();
                        jQuery('#minutos_beforetwo_restriction_field select').val('');
                        jQuery('#weight_field').fadeOut();
                        jQuery('#weight_field select').val('');
                        jQuery('#minutos_aftertwo_field').fadeOut();
                        jQuery('#minutos_aftertwo_field select').val('');
                        jQuery('#minutos_afterfive_field').fadeIn();
                        jQuery('#other_options_field').fadeOut();
                        jQuery('#other_options_field select').val('');
                        </script>
                        <?php 
                    }
                    //Other States
                    else{
                        ?>
                        <script type="text/javascript">
                        //Extra field
                        jQuery('#minutos_int_number').fadeIn();
                        jQuery('#numero_int_field').fadeIn();
        
                        //Secure and extra data
                        jQuery('#minutos_value_fee_field').fadeIn();
                        jQuery('#minutos_optional_secure').fadeIn();
        
                        jQuery('#minutos_data_shipping').fadeOut();
                        jQuery('#minutos_data_shipping_after').fadeOut();
                        jQuery('#minutos_adittional_details').fadeIn();
                        jQuery('#minutos_image').fadeIn();
        
                        //Text boxes
                        jQuery('#minutos_tshipping_limited').fadeOut();
                        jQuery('#minutos_type_shipping_CDMX').fadeOut();
                        jQuery('#minutos_aftertwo_message').fadeOut();
                        jQuery('#minutos_afterfive_message').fadeOut();
                        jQuery('#minutos_tshipping_interior').fadeIn();
        
                        //Valid shipments
                        jQuery('#minutos_beforetwo_restriction_field').fadeOut();
                        jQuery('#minutos_beforetwo_restriction_field select').val('');
                        jQuery('#weight_field').fadeOut();
                        jQuery('#weight_field select').val('');
                        jQuery('#minutos_aftertwo_field').fadeOut();
                        jQuery('#minutos_aftertwo_field select').val('');
                        jQuery('#minutos_afterfive_field').fadeOut();
                        jQuery('#minutos_afterfive_field select').val('');
                        jQuery('#other_options_field').fadeIn();
                        </script>
                        <?php 
                    }
                }//Valid shipments
            }
        }
    }
    else{
        ?>
        <script type="text/javascript">
        //Extra field
        jQuery('#minutos_int_number').fadeOut();
        jQuery('#numero_int_field').fadeOut();
        jQuery('#numero_int_field input').val('');

        //Secure and extra data
        jQuery('#minutos_value_fee_field').fadeOut();
        jQuery('#minutos_optional_secure').fadeOut();

        jQuery('#minutos_data_shipping').fadeOut();
        jQuery('#minutos_data_shipping_after').fadeOut();
        jQuery('#minutos_adittional_details').fadeOut();
        jQuery('#minutos_image').fadeOut();

        //Text boxes
        jQuery('#minutos_tshipping_limited').fadeOut();
        jQuery('#minutos_type_shipping_CDMX').fadeOut();
        jQuery('#minutos_aftertwo_message').fadeOut();
        jQuery('#minutos_afterfive_message').fadeOut();
        jQuery('#minutos_tshipping_interior').fadeOut();

        //Valid shipments
        jQuery('#minutos_beforetwo_restriction_field').fadeOut();
        jQuery('#minutos_beforetwo_restriction_field select').val('');
        jQuery('#weight_field').fadeOut();
        jQuery('#weight_field select').val('');
        jQuery('#minutos_aftertwo_field').fadeOut();
        jQuery('#minutos_aftertwo_field select').val('');
        jQuery('#minutos_afterfive_field').fadeOut();
        jQuery('#minutos_afterfive_field select').val('');
        jQuery('#other_options_field').fadeOut();
        jQuery('#other_options_field select').val('');
        </script>
        <?php  
    }  
}
add_action( 'woocommerce_review_order_before_submit', 'hide_shipping_method');

// ANCHOR SECURE 2%
function remove_order_( $field, $key, $args, $value ) {
    if( 'value_fee' === $key && is_checkout() ) {
        $optional = '&nbsp;<span class="optional">(' . esc_html__( 'optional', 'woocommerce' ) . ')</span>';
        $field = str_replace( $optional, '', $field );
    }
    return $field;
}
add_filter( 'woocommerce_form_field' , 'remove_order_', 10, 4 );

function checkout_fee_script() {
    if( is_checkout() && ! is_wc_endpoint_url() ) :

    if( WC()->session->__isset('enable_fee') )
        WC()->session->__unset('enable_fee')
    ?>
    <script type="text/javascript">
    jQuery( function($){
        if (typeof wc_checkout_params === 'undefined') 
            return false;

        $('form.checkout').on('change', 'input[name=value_fee]', function(e){
            var fee = $(this).prop('checked') === true ? '1' : '';

            $.ajax({
                type: 'POST',
                url: wc_checkout_params.ajax_url,
                data: {
                    'action': 'enable_fee',
                    'enable_fee': fee,
                },
                success: function (result) {
                    $('body').trigger('update_checkout');
                },
            });
        });
    });
    </script>
    <?php
    endif;
}
add_action( 'wp_footer', 'checkout_fee_script' );

function get_enable_fee() {
    if ( isset($_POST['enable_fee']) ) {
        WC()->session->set('enable_fee', ($_POST['enable_fee'] ? true : false) );
    }
    die();
}
add_action( 'wp_ajax_enable_fee', 'get_enable_fee' );
add_action( 'wp_ajax_nopriv_enable_fee', 'get_enable_fee' );

function custom_percetage_fee( $cart) {
    global $wpdb;
    global $woocommerce;
    global $addpercent;

    if ( ( is_admin() && ! defined( 'DOING_AJAX' ) ) || ! is_checkout() )
        return;

    $percent = 0.02;
    $addpercent = ( $woocommerce->cart->cart_contents_total + $woocommerce->cart->shipping_total ) * $percent;	
    $chosen_methods = WC()->session->get('chosen_shipping_methods');

    if(trim(strstr($chosen_methods[0], ':', true)) == 'envio_99_minutos' && WC()->session->get('enable_fee')){ 
        $woocommerce->cart->add_fee( 'Asegurar el valor del envío', $addpercent, true, '' );
        $wpdb->insert( $wpdb->postmeta, array(
            'post_id' => 0,
            'meta_key' => 'secure_package',
            'meta_value' => $addpercent
        ), array('%d','%s','%f'));
    }else{
        $wpdb->delete( $wpdb->postmeta, array(
            'meta_key' => 'secure_package' 
        ));}
}
add_action( 'woocommerce_cart_calculate_fees', 'custom_percetage_fee');