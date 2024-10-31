<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

	$errores='';
	$enviado='';
	global $wpdb;

	if (isset($_POST ['submit'])) {
		if ( ! isset( $_POST['minutos_nonce_field'] ) || ! wp_verify_nonce( $_POST['minutos_nonce_field'], 'minutos_settings_form_save' ) ){
            echo 'Existe un problema de seguridad con tu información, intenta nuevamente. <br>';
            exit;
         }else{

			delete_fields_to_wpdb();
			$apikeyf = '';
			$apiKey = sanitize_text_field($_POST['apiKey']);
			$nombre = sanitize_text_field($_POST['nombre']);
			$apellido = sanitize_text_field($_POST['apellido']);
			$email = sanitize_text_field($_POST['email']);
			$telefono = sanitize_text_field($_POST['telefono']);
			$ciudad = sanitize_text_field($_POST['ciudad']);
			$colonia = sanitize_text_field($_POST['colonia']);
			$calleNumero = sanitize_text_field($_POST['calleNumero']);
			$interior = sanitize_text_field($_POST['interior']);
			$codigoPostal = sanitize_text_field($_POST['codigoPostal']);
			$pais = sanitize_text_field($_POST['pais']);
	
			if(!empty ($apiKey)){
				$apiKey = trim($apiKey);
				$apiKey= filter_var($apiKey, FILTER_SANITIZE_STRING);
				if($apiKey==""){
					$errores.='Ingresa tu API Key.<br />';
				}
				$apikeyf = str_replace(" ", "",trim(strtolower($apiKey)));
				if ( strlen($apikeyf) > 40){
					add_fields_to_wpdb('APIKeyf','1');
					add_fields_to_wpdb('APIKey',str_replace('pruebas','',$apikeyf));
					
				}
				else{
					add_fields_to_wpdb('APIKeyf','0');
					add_fields_to_wpdb('APIKey',$apiKey);
					
				}
				
			}
			else{
					$errores.='Ingresa tu API Key.<br/>';
				}
			//
			
			if(!empty ($nombre)){
				$nombre = trim($nombre);
				$nombre= filter_var($nombre, FILTER_SANITIZE_STRING);
				if($nombre==""){
					$errores.='Ingresa tu nombre.<br />';
				}
				add_fields_to_wpdb('name_sender',$nombre);
			}
			else{
				$errores.='Ingresa tu nombre.<br/>';
			}	
			//
			if(!empty ($apellido)){
				$apellido = trim($apellido);
				$apellido= filter_var($apellido, FILTER_SANITIZE_STRING);
				if($apellido==""){
					$errores.='Ingresa tu apellido.<br />';
				}
				add_fields_to_wpdb('last_name_sender',$apellido);
			}
			else{
				$errores.='Ingresa tu apellido.<br/>';
			}
			//
			if (!empty($email)) {
				$email = filter_var($email, FILTER_SANITIZE_EMAIL);
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$errores.= "Por favor ingresa un correo válido.<br />";
				}
				else
				{
					add_fields_to_wpdb('email_sender',$email);
				}
			} else {
				$errores.= 'Por favor ingresa un correo válido.<br />';
			}
			//
			if(!empty ($telefono)){
				$telefono = trim($telefono);
				$telefono= filter_var($telefono, FILTER_SANITIZE_STRING);
				if($telefono==""){
					$errores.='Ingresa tu teléfono móvil.<br />';
				}
				add_fields_to_wpdb('phone_sender',$telefono);
			}
			else{
				$errores.='Ingresa tu teléfono móvil.<br/>';
			}	
			//
			if (!empty($ciudad)) {
				$ciudad = filter_var($ciudad, FILTER_SANITIZE_STRING);
				if($ciudad==""){
					$errores.='Ingresa tu ciudad.<br />';
				}
				add_fields_to_wpdb('city_sender',$ciudad);
			}else {
				$errores.= 'Ingresa tu ciudad.<br />';
			}
			//
			if (!empty($colonia)) {
				$colonia = filter_var($colonia, FILTER_SANITIZE_STRING);
				if($colonia==""){
					$errores.='Ingresa tu colonia.<br />';
				}
				add_fields_to_wpdb('suburb_sender',$colonia);
			}else {
				$errores.= 'Ingresa tu colonia.<br />';
			}
			//
			if (!empty($calleNumero)) {
				$calleNumero = filter_var($calleNumero, FILTER_SANITIZE_STRING);
				if($calleNumero==""){
					$errores.='Ingresa tu calle y número.<br />';
				}
				add_fields_to_wpdb('address_origin',$calleNumero);
			}else {
				$errores.= 'Ingresa tu calle y número.<br />';
			}
			//
			if (!empty($interior) or $interior == "0") {
				$interior = filter_var($interior, FILTER_SANITIZE_STRING);
				if($interior==""){
					$errores.='Ingresa tu número interior.<br />';
				}
				add_fields_to_wpdb('number_origin',$interior);
			}else {
				$errores.= 'Ingresa tu número interior.<br />';
			}
			//
				if (!empty($codigoPostal)) {
					$codigoPostal = filter_var($codigoPostal, FILTER_SANITIZE_STRING);
					if($codigoPostal==""){
						$errores.='Ingresa tu código postal.<br />';
					}
					
					if( $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='APIKeyf'") === '1'){
						$url = 'https://deploy-dot-precise-line-76299minutos.appspot.com/api/v1/cat/coveage';
					}
					else{
						$url = 'https://prd-dot-precise-line-76299minutos.appspot.com/api/v1/cat/coveage';
					}
					
					$body = array(
						"coverage" => $codigoPostal
						);
					$headers = array(
							'Content-Type' => 'application/json',
							'Authorization' => 'Berear '.$wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='APIKey'")
						);
					$args = array(
							'body' => json_encode($body),
							'headers' => $headers
						);
					$result = json_decode(wp_remote_retrieve_body(wp_remote_post( $url, $args )),true);
		
					if ($result['coverage']['message'] == true) { 
					$enviado.= 'Zona con cobertura.<br />';
					add_fields_to_wpdb('code_postal_origin',$codigoPostal);
					}else
					$errores.= 'Zona sin cobertura, revisa tu código postal.';
							
				}
					else{
					$errores.= 'Ingresa tu código postal.<br />';
					}
			
			
			if (!empty($pais)) {
				$pais = filter_var($pais, FILTER_SANITIZE_STRING);
				if($pais==""){
					$errores.='Ingresa tu país.';
				}
				add_fields_to_wpdb('origin_country',$pais);
			}else {
				$errores.= 'Ingresa tu país.';
			}
			
			if(!$errores){
				$enviado=true;
			}
		 }
	}

        function add_fields_to_wpdb($meta_key, $meta_value){
			global $wpdb;
			$wpdb->insert( $wpdb->postmeta, array(
			'post_id' => '',
			'meta_key' => sanitize_text_field($meta_key),
			'meta_value' => sanitize_text_field($meta_value)
			), array('%d','%s','%s'));
			
        }
        
        function delete_fields_to_wpdb(){
			global $wpdb;
			$wpdb->delete( $wpdb->postmeta, array(
				'meta_key' => 'APIKeyf'
				));
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

			$wpdb->insert( $wpdb->postmeta, array(
				'post_id' => '',
				'meta_key' => 'reload_checkout',
				'meta_value' => '0'
				), array('%d','%s','%s'));
		}
        
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Formulario</title>
<style>
		*{
        padding: 0;
        margin: 0;
        -webkit-box-sizinh: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    body{
        background: #F2F2F2;
        font-size: 16px;
    }
    .wrap{
        width: 98%;
        max-width: 500px;
        margin: auto;
    }
    form{
        width: 100%;
        margin: 20px 0;
        padding: 20px;
    	background: #fff;
    	overflow: hidden;
    	box-shadow: 0 0 3px grey;
    	border-top: 4px solid #85C440;
		border-radius: 15px;
	}
	form input[type="number"],	
	form input[type="text"]{
    border :1px solid #85C440;
    border-radius: 2px;
    padding: 16px;
    width: 100%;
    display: black;
    margin-bottom: 20px;
    font-size: 1em;
    color: #141938 ;
	border-radius: 15px;
	}
	form input[type="number"]:focus,
	form input[type="text"]:focus{
    border: 2px solid #85C440;

	}
	.alert{
    padding: 1em;
    color: #fff;
    border-radius: 2px;
    margin-bottom: 28px;
    font-size: 14px;
	} 

	.alert.error{
    background: #F2DEDE;
    border: 1px solid #a94442;
    color: #a94442
	}
	.alert.success{
    background: #85c440;
	border-radius: 5px;
	}

	form input[type="submit"]{
    padding: 15px;
    background: #ED572A;
    color: #E1E9FA;
    font-size: 1em;
    border-radius: 5px;
    float: right;
    cursor: pointer;
	}
	form input[type="submit"]:hover{
    background: #85C440;
    padding:15px;
	}

	.alert{
    padding: 1em;
    color: #fff;
    border-radius: 2px;
    margin-bottom: 28px;
    font-size: 14px;
	} 

	.alert.error{
    background: #F2DEDE;
    border: 1px solid #a94442;
    color: #a94442
	}
	.alert.success{
    background: #85c440;
	border-radius: 5px;
	}	
	
	form input[type="submit"]{
    padding: 15px;
    background: #ffff;
    color: #85C440;
    font-size: 1em;
    border-radius: 30px;
    float: right;
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
    float: left;
    border: 1px solid #85C440 !important;
	}
	form input[type="reset"]:hover{
    background: #85C440 !important;
    color:#ffff !important;
	}
	form input[type="reset"]:focus{
		outline:none !important;
	}

	.recoadatorioEmail{
    color:#85C440;
    font-weight:700;
	}

	.errorj{
    width : 100%;
    background-color: #900;
    color: white;
    font-weight: bold;
    text-align: center;
    border-radius: 0 0 5px 5px;
    box-sizing: border-box;	
    
	}

	.woocommerce-noticeTR {
		padding: 10px;
        background: linear-gradient(#95D64E, #85c440, #6BA42D);
        align: justify;
        font-size: 1em;
        border-radius: 15px;
        box-shadow: 20px 20px 0px #D7DADA;
        max-width: 830px;
    }

	.woocommerce-warning99>thead>tr>th{
        text-align: center
    }    
    .woocommerce-warning99{      
        width: 100%;
    	background: #85c440;
    	overflow: hidden;
    	box-shadow: 0 0 3px grey;
        text-align:center;
        border: 3px solid #ffff;
        padding: 5px;
        margin-bottom: 20px;
        font-size: 1em;
        color: #141938 ;
        border-radius: 10px;
    }

</style>
</head>

<br>
    <div class="woocommerce-noticeTR" role="alert" style="color: #FFFFFF"> 
	    <b style="font-size: 50px; color: #343a40;">!</b>
	    Si deseas realizar pruebas con el plugin de 99 Minutos, por favor agrega la palabra pruebas seguida de un espacio 
		e intrudece tu API Key de pruebas, en caso contrario, sólo ingresa tu API Key de producción. <br><br><b>Ejemplo: "pruebas c34e6e379abfdc1c3bdcef03f6d1db1be566eca0"</b><br> 
    </div>
<br>

<body>
	<div class="wrap">
		<form method="post" name="formulario">
			<h4>Escribe tus datos para comenzar a configurar tus envíos.</h4>
			<?php if (!empty($errores)): ?>
				<div class="alert error" role="alert">
					<?php echo esc_html( $errores ); ?>
				</div>
			<?php elseif($enviado) : ?>
				<div class="alert success" role="alert">
					<?php echo esc_html( 'Enviado correctamente' ); ?>
				</div>
			<?php endif; ?>  
			<h2>Developers</h2>

			<br><div class="woocommerce-warning99" id="alert_API" role="alert" style="color: white"> <?php esc_html_e('Recuerda especificar si tu API Key es de pruebas o producción.', '99minutos' ); ?> </div>

			<label for="">Api Key:</label>
            <input type="text" class="" id="apiKey" name="apiKey" placeholder="Ingresa aquí tu API Key" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='apiKey'; ");?>"<?php if(!$enviado && isset($apiKey)) echo $apiKey; ?>">
			<span id="errorApi" class="errorj " aria-live="polite"></span>
			<p class="description">
				<?php esc_html_e( 'El API KEY es tu llave de acceso a la API de 99 Minutos. La obtienes en la sección "Developers" de "Mi cuenta" o haciendo' ); ?>
				<span><a href="https://www.client.99minutos.com/developers" target="_blank">click aquí.</a></span>
			</p>
			<h2>Datos de contacto de logística</h2>
			<label for="">Nombre:</label>
            <input type="text" class="" id="nombre" name="nombre" placeholder="Ej. Rodrigo" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='name_sender'; ");?>"<?php if(!$enviado && isset($nombre)) echo $nombre; ?>">
			<span id="errorNombre" class="errorj " aria-live="polite"></span>
			<label for="">Apellido:</label>
            <input type="text" class="" id="apellido" name="apellido" placeholder="Ej. Noroña" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='last_name_sender'; ");?>"<?php if(!$enviado && isset($apellido)) echo $apellido; ?>">
			<span id="errorApellido" class="errorj " aria-live="polite"></span>
			<label for="">Correo electrónico:</label>
            <input type="text" class="" id="email" name="email" placeholder="example@99minutos.com" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='email_sender'; ");?>"<?php if(!$enviado && isset($email)) echo $email; ?>">
			<span id="errorEmail" class="errorj " aria-live="polite"></span>
			<p>
				<small>* Recuerda que tu correo debe de ser el mismo con el que te registraste en 99 Minutos.</small>
			</p>
			<label for="">Teléfono móvil:</label>
            <input type="text" class="" id="telefono" name="telefono" placeholder="Ej. 5512345678" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='phone_sender'; ");?>"<?php if(!$enviado && isset($telefono)) echo $telefono; ?>">
			<span id="errorTelefono" class="errorj " aria-live="polite"></span>

			<h2>Dirección de origen</h2>
			<label for="">Ciudad:</label>
            <input type="text" class="" id="ciudad" name="ciudad" placeholder="Ej. CDMX" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='city_sender'; ");?>"<?php if(!$enviado && isset($ciudad)) echo $ciudad; ?>">
			<span id="errorCiudad" class="errorj " aria-live="polite"></span>
			<label for="">Colonia:</label>
            <input type="text" class="" id="colonia" name="colonia" placeholder="Ej. Las condes" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='suburb_sender'; ");?>"<?php if(!$enviado && isset($colonia)) echo $colonia; ?>">
			<span id="errorColonia" class="errorj " aria-live="polite"></span>
			<label for="">Calle y número exterior:</label>
            <input type="text" class="" id="calleNumero" name="calleNumero" placeholder="Ej. calle 145" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='address_origin'; ");?>"<?php if(!$enviado && isset($calleNumero)) echo $calleNumero; ?>">
			<span id="errorCalle" class="errorj " aria-live="polite"></span>
			<label for="">Número interior:</label>
            <input type="text" class="" id="interior" name="interior" placeholder="Ej. 202" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='number_origin'; ");?>"<?php if(!$enviado && isset($interior)) echo $interior; ?>">
			<span id="errorInterior" class="errorj " aria-live="polite"></span>
			<b>
				<small>* Si no tienes número interior, ingresa 0.</small>
			</b><br><br>
			<label for="">Código postal:</label>
            <input type="text" class="" id="codigoPostal" name="codigoPostal" placeholder="Ej. 30077" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='code_postal_origin'; ");?>"<?php if(!$enviado && isset($codigoPostal)) echo $codigoPostal; ?>">
			<span id="errorCodigo" class="errorj " aria-live="polite"></span>
			
			<label for="">País:</label>
            <input type="text" class="" id="pais" name="pais" placeholder="Ej. México" value="<?=$wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='origin_country'; ");?>"<?php if(!$enviado && isset($pais)) echo $pais; ?>">
			
			<!-- <input type="reset" name="reset" class="btn btn-secondary" value="Borrar campos"> -->
			<input type="submit" name="submit" class="btn btn-primary" value="Guardar información">
			<?php wp_nonce_field('minutos_settings_form_save','minutos_nonce_field');?>
		</form>
	</div>
	<br><img class="minutosimage" src="https://www.client.99minutos.com/static/media/logo-99minutos.b60d26d8.png" alt="99minutos.com" width="200" height="50"><br>

	<script>
		(function(){
			var auxerror=0;
			var formulario=document.getElementsByName('formulario')[0],
			elementos=formulario.elements,
			boton=document.getElementById('btn');
			var validarApiKey=function(e){
				if(formulario.apiKey.value==0){
					errorApi.innerHTML = "Por favor ingresa tu API Key.";
					e.preventDefault();
					return auxerror++;
				}
			};
			var validarNombre=function(e){
				if(formulario.nombre.value==0){
					errorNombre.innerHTML = "Por favor ingresa tu nombre.<br>";
					e.preventDefault();
					return auxerror++;
				}
			};
			var validarApellido=function(e){
				if(formulario.apellido.value==0){
					errorApellido.innerHTML = "Por favor ingresa tu apellido.<br>";
					e.preventDefault();
					return auxerror++;

				}
			};

			var validarEmail=function(e){
				if(formulario.email.value==0){
					errorEmail.innerHTML = "Por favor ingresa tu correo electrónico.<br>";
					e.preventDefault();
					return auxerror++;

				}
			};
			var validarTelefono=function(e){
				if(formulario.telefono.value==0){
					errorTelefono.innerHTML = "Por favor ingresa tu teléfono móvil.<br>";
					e.preventDefault();
					return auxerror++;
				}else if(telefono.value.length!=10){
					alert("Es necesario ingresar 10 números válidos.");
					e.preventDefault();
					return auxerror++;
				} 
				for (i=0;i<telefono.value.length;i++){
					if(isNaN(parseInt(telefono.value.charAt(i)))==true){
						alert("En éste campo sólo puedes ingresar números.");
						e.preventDefault();
						return auxerror++;
					}
				}

			};

			var validarCiudad=function(e){
				if(formulario.ciudad.value==0){
					errorCiudad.innerHTML = "Por favor ingresa tu ciudad.<br>";
					e.preventDefault();
					return auxerror++;

				}
			};
			var validarColonia=function(e){
				if(formulario.colonia.value==0){
					errorColonia.innerHTML = "Por favor ingresa tu colonia.<br>";
					e.preventDefault();
					return auxerror++;

				}
			};
			var validarCalle=function(e){
				if(formulario.calleNumero.value==0){
					errorCalle.innerHTML = "Por favor ingresa tu calle y número exterior.<br>";
					e.preventDefault();
					return auxerror++;

				}
			};
			var validarInterior=function(e){
				if(formulario.interior.value == ''){
					errorInterior.innerHTML = "Por favor ingresa tu número interior.<br>";
					e.preventDefault();
					return auxerror++;

				}
			};
			
			var validarCodigo=function(e){
				if(formulario.codigoPostal.value==0){
					errorCodigo.innerHTML = "Por favor ingresa tu código postal.<br>";
					e.preventDefault();
					return auxerror++;
				}
				if (codigoPostal.value.length!=5){
					alert("Es necesario ingresar 5 números válidos.");
				}
				for (i=0; i<codigoPostal.value.length;i++){
					if(isNaN(parseInt(codigoPostal.value.charAt(i)))==true){
						alert("En éste campo sólo puedes ingresar números.");
					}
				}
			};
			var validar =function(e){
				validarApiKey(e);
				validarNombre(e);
				validarApellido(e);
				validarEmail(e);
				validarTelefono(e);
				validarCiudad(e);
				validarColonia(e);
				validarCalle(e);
				validarInterior(e);
				validarCodigo(e);
				if(auxerror>0){
					alert("Es importante llenar todos los campos para continuar.");
					auxerror=0;
				}else{
					alert("El formulario se envió correctamente.");
				}
			};
			formulario.addEventListener("submit", validar);
		}())
	</script>

</body>
</html>