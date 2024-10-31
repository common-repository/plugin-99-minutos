<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

    $contador=0;
	$enviado='';
    global $wpdb;

    //PRICES
    $sdXs=65;
    $sdS=75;
    $sdM=85;
    $sdL=95;
    $sdXl=249;

    $ndXs=65;
    $ndS=75;
    $ndM=85;
    $ndL=95;
    $ndXl=249;

    $minXs=75;
    $minS=85;
    $minM=95;
    $minL=105;
    $minXl=0;

    $coXs=99;
    $coS=108;
    $coM=119;
    $coL=125;
    $coXl=0;

	if (isset($_POST ['submit'])) {

        if ( ! isset( $_POST['minutos_nusedonce'] ) || ! wp_verify_nonce( $_POST['minutos_nusedonce'], 'minutos_submit_form' ) ){
            echo 'Existe un problema de seguridad con tu información, intenta nuevamente. <br>';
            exit;

         }else{

            delete_fields_to_wpdb_tr();
            $sd_xs = sanitize_text_field($_POST['sd_xs']);
            $sd_s = sanitize_text_field($_POST['sd_s']);
            $sd_m = sanitize_text_field($_POST['sd_m']);
            $sd_l = sanitize_text_field($_POST['sd_l']);
            $sd_xl = sanitize_text_field($_POST['sd_xl']);
            
            $nd_xs = sanitize_text_field($_POST['nd_xs']);
            $nd_s = sanitize_text_field($_POST['nd_s']);
            $nd_m = sanitize_text_field($_POST['nd_m']);
            $nd_l = sanitize_text_field($_POST['nd_l']);
            $nd_xl = sanitize_text_field($_POST['nd_xl']);
    
            $min_xs = sanitize_text_field($_POST['min_xs']);
            $min_s = sanitize_text_field($_POST['min_s']);
            $min_m = sanitize_text_field($_POST['min_m']);
            $min_l = sanitize_text_field($_POST['min_l']);
            $min_xl = sanitize_text_field($_POST['min_xl']);
            
            $co_xs = sanitize_text_field($_POST['co_xs']);
            $co_s = sanitize_text_field($_POST['co_s']);
            $co_m = sanitize_text_field($_POST['co_m']);
            $co_l = sanitize_text_field($_POST['co_l']);
            $co_xl = sanitize_text_field($_POST['co_xl']);
    
            //SAME DAY
            if(!empty ($sd_xs) or $sd_xs=="0"){
                $sd_xs = trim($sd_xs);
                $sd_xs= filter_var($sd_xs, FILTER_SANITIZE_STRING);
                add_fields_to_wpdb_tr('sd_xs',$sd_xs);
                $enviado.= "Nuevo precio para Same Day ECH = " . $sd_xs . "<br>";
            }
            else{
                add_fields_to_wpdb_tr('sd_xs',$sdXs);
                $contador++;
            }
            if(!empty ($sd_s) or $sd_s=="0"){
                $sd_s = trim($sd_s);
                $sd_s= filter_var($sd_s, FILTER_SANITIZE_STRING);
                add_fields_to_wpdb_tr('sd_s',$sd_s);
                $enviado.="Nuevo precio para Same Day CH = ".$sd_s." <br>";
            }
            else{
                add_fields_to_wpdb_tr('sd_s',$sdS);
                $contador++;
            }
            if(!empty ($sd_m) or $sd_m=="0"){
                $sd_m = trim($sd_m);
                $sd_m= filter_var($sd_m, FILTER_SANITIZE_STRING);
                add_fields_to_wpdb_tr('sd_m',$sd_m);
                $enviado.="Nuevo precio para Same Day M = ".$sd_m." <br>";
            }
            else{
                add_fields_to_wpdb_tr('sd_m',$sdM);   
                $contador++;    
            }
            if(!empty ($sd_l) or $sd_l=="0"){
                $sd_l = trim($sd_l);
                $sd_l= filter_var($sd_l, FILTER_SANITIZE_STRING);
                add_fields_to_wpdb_tr('sd_l',$sd_l);
                $enviado.="Nuevo precio para Same Day G = ".$sd_l." <br>";
            }
            else{
                add_fields_to_wpdb_tr('sd_l',$sdL);
                $contador++;
            }
            if(!empty ($sd_xl) or $sd_xl=="0"){
                $sd_xl = trim($sd_xl);
                $sd_xl= filter_var($sd_xl, FILTER_SANITIZE_STRING);
                add_fields_to_wpdb_tr('sd_xl',$sd_xl);
                $enviado.="Nuevo precio para Same Day EG = ".$sd_xl." <br><br>";
            }
            else{
                add_fields_to_wpdb_tr('sd_xl',$sdXl);
                $contador++;
            }
            //NEXT DAY
            if(!empty ($nd_xs) or $nd_xs=="0"){
                $nd_xs = trim($nd_xs);
                $nd_xs= filter_var($nd_xs, FILTER_SANITIZE_STRING);
                add_fields_to_wpdb_tr('nd_xs',$nd_xs);
                $enviado.="Nuevo precio para Next Day ECH = ".$nd_xs." <br>";
            }
            else{
                add_fields_to_wpdb_tr('nd_xs',$ndXs);
                $contador++;
            }
            if(!empty ($nd_s) or $nd_s=="0"){
                $nd_s = trim($nd_s);
                $nd_s= filter_var($nd_s, FILTER_SANITIZE_STRING);
                add_fields_to_wpdb_tr('nd_s',$nd_s);
                $enviado.="Nuevo precio para Next Day CH = ".$nd_s." <br>";
            }
            else{
                add_fields_to_wpdb_tr('nd_s',$ndS);
                $contador++;
            }
            if(!empty ($nd_m) or $nd_m=="0"){
                $nd_m = trim($nd_m);
                $nd_m= filter_var($nd_m, FILTER_SANITIZE_STRING);
                add_fields_to_wpdb_tr('nd_m',$nd_m);
                $enviado.="Nuevo precio para Next Day M = ".$nd_m." <br>";
            }
            else{
                add_fields_to_wpdb_tr('nd_m',$ndM);
                $contador++;                    
            }
            if(!empty ($nd_l) or $nd_l=="0"){
                $nd_l = trim($nd_l);
                $nd_l= filter_var($nd_l, FILTER_SANITIZE_STRING);
                add_fields_to_wpdb_tr('nd_l',$nd_l);
                $enviado.="Nuevo precio para Next Day G = ".$nd_l." <br>";
            }
            else{
                add_fields_to_wpdb_tr('nd_l',$ndL);
                $contador++;
            }
            if(!empty ($nd_xl) or $nd_xl=="0"){
                $nd_xl = trim($nd_xl);
                $nd_xl= filter_var($nd_xl, FILTER_SANITIZE_STRING);
                add_fields_to_wpdb_tr('nd_xl',$nd_xl);
                $enviado.="Nuevo precio para Next Day EG = ".$nd_xl." <br><br>";
            }
            else{
                add_fields_to_wpdb_tr('nd_xl',$ndXl);
                $contador++;  
            }
            //99MINUTOS
            if(!empty ($min_xs) or $min_xs=="0"){
                $min_xs = trim($min_xs);
                $min_xs= filter_var($min_xs, FILTER_SANITIZE_STRING);
                add_fields_to_wpdb_tr('min_xs',$min_xs);
                $enviado.="Nuevo precio para 99minutos ECH = ".$min_xs." <br>";
            }
            else{
                add_fields_to_wpdb_tr('min_xs', $minXs);
                $contador++;
            }
            if(!empty ($min_s) or $min_s=="0"){
                $min_s = trim($min_s);
                $min_s= filter_var($min_s, FILTER_SANITIZE_STRING);
                add_fields_to_wpdb_tr('min_s',$min_s);
                $enviado.="Nuevo precio para 99minutos CH = ".$min_s." <br>";
            }
            else{
                add_fields_to_wpdb_tr('min_s', $minS);
                $contador++;
            }
            if(!empty ($min_m) or $min_m=="0"){
                $min_m = trim($min_m);
                $min_m= filter_var($min_m, FILTER_SANITIZE_STRING);
                add_fields_to_wpdb_tr('min_m',$min_m);
                $enviado.="Nuevo precio para 99minutos M = ".$min_m." <br>";
            }
            else{
                add_fields_to_wpdb_tr('min_m', $minM);
                $contador++;                    
            }
            if(!empty ($min_l) or $min_l=="0"){
                $min_l = trim($min_l);
                $min_l= filter_var($min_l, FILTER_SANITIZE_STRING);
                add_fields_to_wpdb_tr('min_l',$min_l);
                $enviado.="Nuevo precio para 99minutos G = ".$min_l." <br><br>";
            }
            else{
                add_fields_to_wpdb_tr('min_l', $minL);
                $contador++;
            }
            if(!empty ($min_xl) or $min_xl=="0"){
                $min_xl = trim($min_xl);
                $min_xl= filter_var($min_xl, FILTER_SANITIZE_STRING);
                add_fields_to_wpdb_tr('min_xl',$minXl);
                $enviado.="<br><b>No aplica.</b> Recuerda que no contamos con envíos <b>99minutos (EG)</b> </br><br>";
            }
            else{
                add_fields_to_wpdb_tr('min_xl', $minXl);
                $contador++;  
            }
            //CO2 FREE
            if(!empty ($co_xs) or $co_xs=="0"){
                $co_xs = trim($co_xs);
                $co_xs= filter_var($co_xs, FILTER_SANITIZE_STRING);
                add_fields_to_wpdb_tr('co_xs',$co_xs);           
                $enviado.="Nuevo precio para CO2 Free ECH = ".$co_xs." <br>";
            }
            else{
                add_fields_to_wpdb_tr('co_xs',$coXs);
                $contador++;            
            }
            if(!empty ($co_s) or $co_s=="0"){
                $co_s = trim($co_s);
                $co_s= filter_var($co_s, FILTER_SANITIZE_STRING);
                add_fields_to_wpdb_tr('co_s',$co_s);
                $enviado.="Nuevo precio para CO2 Free CH = ".$co_s." <br>";
            }
            else{
                add_fields_to_wpdb_tr('co_s',$coS); 
                $contador++;      
            }
            if(!empty ($co_m) or $co_m=="0"){
                $co_m = trim($co_m);
                $co_m= filter_var($co_m, FILTER_SANITIZE_STRING);    
                add_fields_to_wpdb_tr('co_m',$co_m);
                $enviado.="Nuevo precio para CO2 Free M = ".$co_m." <br>";
            }
            else{
                add_fields_to_wpdb_tr('co_m',$coM);
                $contador++;           
            }
            if(!empty ($co_l) or $co_l=="0"){
                $co_l = trim($co_l);
                $co_l= filter_var($co_l, FILTER_SANITIZE_STRING);
                add_fields_to_wpdb_tr('co_l',$co_l);
                $enviado.="Nuevo precio para CO2 Free G = ".$co_l." <br>";
            }
            else{
                add_fields_to_wpdb_tr('co_l',$coL);
                $contador++;
            }
            if(!empty ($co_xl) or $co_xl=="0"){
                $co_xl = trim($co_xl);
                $co_xl= filter_var($co_xl, FILTER_SANITIZE_STRING);
                add_fields_to_wpdb_tr('co_xl',$coXl);
                $enviado.="<br><b>No aplica.</b> Recuerda que no contamos con envíos <b>CO2 Free (EG)</b> </br><br>";
            }
            else{
                add_fields_to_wpdb_tr('co_xl',$coXl);
                $contador++;
            }
            //CONFIGURATION DETAILS
            if($contador == 20){
                $enviado.="Configuración guardada, estás utilizando los precios de 99 Minutos.";
            }
            elseif($contador != 20){
                $enviado.="<br> Configuración guardada, modificaste los precios.";
            }
         }
	}		
    
    function add_fields_to_wpdb_tr($meta_key, $meta_value){
        global $wpdb;
		$wpdb->insert( $wpdb->postmeta, array(
		'post_id' => '',
		'meta_key' => sanitize_text_field($meta_key),
		'meta_value' => sanitize_text_field($meta_value)
		), array('%d','%s','%s'));
		//echo $meta_value;
    }
    function delete_fields_to_wpdb_tr(){
		global $wpdb;
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
	}
?>

<style>
    body{
	    background: #F2F2F2;
	    font-size: 16px;
    }
    .contenedorTablaPrecios, 
    {
        align-items: center;
    }

    .tablaPrecios2>thead>tr>th{
        text-align: center
    }    
    .tablaPrecios2{      
        width: 100%;
    	background: #ffff;
    	overflow: hidden;
    	box-shadow: 0 0 3px grey;
        text-align:center;
        border :1px solid #85C440;
        padding: 5px;
        margin-bottom: 20px;
        font-size: 1em;
        color: #141938 ;
        border-radius: 15px;
    }
    
    .tablaPrecios>thead>tr>th{
        text-align: center
    }    
    .tablaPrecios{      
        background: white;
        width: 95%;
        padding: 25px;
        margin: 0 auto;
        margin-top: 2%;
        border-collapse: collapse;
        border-radius: 1em;
        overflow: hidden;
        text-align: center;
    }
    tr {
        color: #343a40;
        height: 37px;
        border-top: .5px solid #85c440;
    }
    td {
        color: rgba(100, 100, 100, 60);
        height: 35px;
        border-top: .5px solid #85c440;
    }
    th:hover {
        background-color:#85c440;
        color:#ffff;
    }

    tr:hover {
        background-color:#85c440;
        color:#ffff;
    }

    .wrap{
        width: 90%;
        max-width:90%;
        margin: auto;
    }
    form{
        width: 100%;
        margin: 0px 0;
        padding: 20px;
    	background: #fff;
    	overflow: hidden;
    	box-shadow: 0 0 3px grey;
    	border-top: 4px solid #85C440;
        text-align:center;
        border-radius: 15px;
	}
    
    form input[type="number"],	
	form input[type="text"]{
        border :1px solid #85C440;
        border-radius: 2px;
        display: inline;
        margin-bottom: 20px;
        font-size: 1em;
        color: #141938 ;
        border-radius: 15px;
        width: 16%;
	}
	form input[type="number"]:focus,
	form input[type="text"]:focus{
        border: 2px solid #85C440;
	}	
	form input[type="submit"]{
        padding: 15px;
        background: #ffff;
        color: #85C440;
        font-size: 1em;
        border-radius: 30px;
        float: right;
        margin: 5px;
        border: 1px solid #85C440;
	}
	form input[type="submit"]:hover{
        background: #85C440;
        color:#ffff;
	}
	form input[type="submit"]:focus{
		outline:none !important;
	}
    form input[type="reset"]{
        padding: 15px !important;
        background: #ffff;
        color: #85C440;
        font-size: 1em;
        border-radius: 30px;
        float: right;
        margin: 5px;
        border: 1px solid #85C440 !important;
	}
	form input[type="reset"]:hover{
        background: #85C440 !important;
        color:#ffff !important;
	}
	form input[type="reset"]:focus{
		outline:none !important;
	}

    .alert{
        padding: 1em;
        color: grey;
        border-radius: 2px;
        margin-bottom: 28px;
        font-size: 15px;    
	} 
    .alert.success{
        background: #ffff;
        box-shadow: 0 0 3px grey;
        border-top: 4px solid #85C440;
	    border-radius: 5px;
        width: 94%;
	}

    .woocommerce-noticeTR {
		padding: 10px;
        background: linear-gradient(#394147, #343a40, #1D1D1E);
        align: justify;
        font-size: 1em;
        border-radius: 15px;
        box-shadow: 20px 20px 0px #D7DADA;
        max-width: 400px;
    }
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tabla de precios </title>
</head>
<body>
    <?php if(!empty($enviado)): ?>
		<div class="alert success" role="alert">
        <?php echo $enviado; ?>
		</div>
	<?php endif; ?>
    <br>
    <div class="woocommerce-noticeTR" role="alert" style="color: white"> 
	    <b style="font-size: 50px; color: #85c440;">!</b>
	    Por defecto, los precios que se mostrarán en las órdenes de tus clientes son los siguientes: 
    </div>
    <br>
    <div class="contenedorTablaPrecios">
        <table class="tablaPrecios">
            <thead>
                <tr>
                    <th colspan="6">Tamaños</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Tipo de envío</th>
                    <th>Extra chico (ECH)</th>
                    <th>Chico (CH) </th>
                    <th>Mediano (M) </th>
                    <th>Grande (G)</th>
                    <th>Extra grande (EG) </th>
                </tr>
                <tr>
                    <th scope="row" style="color: #606b75">Kilogramos</th>
                    <td><b>Menos de 1Kg</b></td>
                    <td><b>1 a 2Kg</b></td>
                    <td><b>2 a 3Kg</b></td>
                    <td><b>3 a 5Kg</b></td>
                    <td><b>Hasta 25Kg</b></td>
                </tr>
                <tr>
                    <th scope="row">Same day</th>
                    <td>$65</td>
                    <td>$75</td>
                    <td>$85</td>
                    <td>$95</td>
                    <td>$249</td>
                </tr>
                <tr>
                    <th scope="row">Next day</th>
                    <td>$65</td>
                    <td>$75</td>
                    <td>$85</td>
                    <td>$95</td>
                    <td>$249</td>
                </tr>
                <tr>
                    <th scope="row">99minutos</th>
                    <td>$75</td>
                    <td>$85</td>
                    <td>$95</td>
                    <td>$105</td>
                    <td>No aplica</td>
                </tr>
                <tr>
                    <th scope="row">CO2 Free</th>
                    <td>$99</td>
                    <td>$108</td>
                    <td>$119</td>
                    <td>$125</td>
                    <td>No aplica</td>
                </tr>
            </tbody>
        </table>
        <br><br>
    </div>
    <br><br>
    <div class="woocommerce-noticeTR" role="alert" style="color: white"> 
	    <b style="font-size: 50px; color: #85c440;">!</b>
	     Si no deseas modificar nuestros precios, no es necesario que configures nada, sólo da click en guardar.
    </div>
    <br><br><br> 
    <div class="wrap">
        <form method="post">
            <div class="contenedorTablaPrecios">
                <table class="tablaPrecios2">
                    <thead>
                        <tr>
                            <th colspan="6">Tamaños</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>Tipo de envío</th>
                        <th>Extra chico (ECH)</th>
                        <th>Chico (CH) </th>
                        <th>Mediano (M) </th>
                        <th>Grande (G)</th>
                        <th>Extra grande (EG) </th>
                    </tr>
                </table>
            </div> 

            <div class="containerSameday">
                <label for="" style="font-size: 20px; margin: 44px"><b>Same day</b></label>
                <input type="text" style="width : 168px" id="sd_xs" name="sd_xs" placeholder="<?php echo '$' . $sdXs ?>" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='sd_xs'; ");?>"<?php if(!$enviado && isset($sd_xs)) echo $sd_xs; ?>>
                <input type="text" style="width : 168px" id="sd_s" name="sd_s" placeholder="<?php echo '$' . $sdS ?>" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='sd_s'; ");?>"<?php if(!$enviado && isset($sd_s)) echo $sd_s; ?>>
                <input type="text" style="width : 168px" id="sd_m" name="sd_m" placeholder="<?php echo '$' . $sdM ?>"value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='sd_m'; ");?>"<?php if(!$enviado && isset($sd_m)) echo $sd_m; ?>>
                <input type="text" style="width : 168px" id="sd_l" name="sd_l" placeholder="<?php echo '$' . $sdL ?>" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='sd_l'; ");?>"<?php if(!$enviado && isset($sd_l)) echo $sd_l; ?>>
                <input type="text" style="width : 168px" id="sd_xl" name="sd_xl" placeholder="<?php echo '$' . $sdXl ?>"value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='sd_xl'; ");?>"<?php if(!$enviado && isset($sd_xl)) echo $sd_xl; ?>>
            </div>

            <div class="containerNextday">
            <label for="" style="font-size: 20px; margin: 49px"><b>Nex day</b></label>
                <input type="text" style="width : 168px" id="nd_xs" name="nd_xs" placeholder="<?php echo '$' . $ndXs ?>" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='nd_xs'; ");?>"<?php if(!$enviado && isset($nd_xs)) echo $nd_xs; ?>>
                <input type="text" style="width : 168px" id="nd_s" name="nd_s" placeholder="<?php echo '$' . $ndS ?>" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='nd_s'; ");?>"<?php if(!$enviado && isset($nd_s)) echo $nd_s; ?>>
                <input type="text" style="width : 168px" id="nd_m" name="nd_m" placeholder="<?php echo '$' . $ndM ?>" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='nd_m'; ");?>"<?php if(!$enviado && isset($nd_m)) echo $nd_m; ?>>
                <input type="text" style="width : 168px" id="nd_l" name="nd_l" placeholder="<?php echo '$' . $ndL ?>"value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='nd_l'; ");?>"<?php if(!$enviado && isset($nd_l)) echo $nd_l; ?>>
                <input type="text" style="width : 168px" id="nd_xl" name="nd_xl" placeholder="<?php echo '$' . $ndXl ?>" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='nd_xl'; ");?>"<?php if(!$enviado && isset($nd_xl)) echo $nd_xl; ?>>
            </div>

            <div class="container99minutos">
            <label for="" style="font-size: 20px; margin: 36px"><b>99minutos</b></label>
                <input type="text" style="width : 168px" id="min_xs" name="min_xs" placeholder="<?php echo '$' . $minXs ?>" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='min_xs'; ");?>"<?php if(!$enviado && isset($min_xs)) echo $min_xs; ?>>
                <input type="text" style="width : 168px" id="min_s" name="min_s" placeholder="<?php echo '$' . $minS ?>" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='min_s'; ");?>"<?php if(!$enviado && isset($min_s)) echo $min_s; ?>>
                <input type="text" style="width : 168px" id="min_m" name="min_m" placeholder="<?php echo '$' . $minM ?>" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='min_m'; ");?>"<?php if(!$enviado && isset($min_m)) echo $min_m; ?>>
                <input type="text" style="width : 168px" id="min_l" name="min_l" placeholder="<?php echo '$' . $minL ?>" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='min_l'; ");?>"<?php if(!$enviado && isset($min_l)) echo $min_l; ?>>
                <input type="text" style="width : 168px" id="min_xl" name="min_xl" placeholder="<?php echo '$' . $minXl ?>" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='min_xl'; ");?>"<?php if(!$enviado && isset($min_xl)) echo $min_xl; ?>>
            </div>

            <div class="containerCO2Free">
                <label for="" style="font-size: 20px; margin: 43px"><b>CO2 Free</b></label>
                <input type="text" style="width : 168px" id="co_xs" name="co_xs" placeholder="<?php echo '$' . $coXs ?>" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='co_xs'; ");?>"<?php if(!$enviado && isset($co_xs)) echo $co_xs; ?>>
                <input type="text" style="width : 168px" id="co_s" name="co_s" placeholder="<?php echo '$' . $coS ?>" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='co_s'; ");?>"<?php if(!$enviado && isset($co_s)) echo $co_s; ?>>
                <input type="text" style="width : 168px" id="co_m" name="co_m" placeholder="<?php echo '$' . $coM ?>" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='co_m'; ");?>"<?php if(!$enviado && isset($co_m)) echo $co_m; ?>>
                <input type="text" style="width : 168px" id="co_l" name="co_l" placeholder="<?php echo '$' . $coL ?>" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='co_l'; ");?>"<?php if(!$enviado && isset($co_l)) echo $co_l; ?>>
                <input type="text" style="width : 168px" id="co_xl" name="co_xl" placeholder="<?php echo '$' . $coXl ?>" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='co_xl'; ");?>"<?php if(!$enviado && isset($co_xl)) echo $co_xl; ?>>
            </div>

            <input type="submit" name="submit" class="btn btn-primary" value="Guardar información">
            <!-- <input type="reset" name="reset" class="btn btn-secondary" value="Borrar campos"> -->

            <?php wp_nonce_field('minutos_submit_form','minutos_nusedonce');?>
        </form>
        * Si alguno de los precios o tamaños no coincide con la información que tu asesor de ventas te proporcionó, comunícate con ellos nuevamente.
    </div>

    <br><br>
    <img class="minutosimage" src="https://www.client.99minutos.com/static/media/logo-99minutos.b60d26d8.png" alt="99minutos.com" width="200" height="50">
    <br>
</body>
</html>