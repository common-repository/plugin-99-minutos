<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function minutos99_options_page() {
	add_menu_page(
		'Envío 99 Minutos',
		'Envío 99 Minutos',
		'manage_options',
		'99minutos',
		'minutos99_admin_page',
		plugin_dir_url(__FILE__) . 'images/admin_icon.png'
	);
	add_submenu_page( 
		'99minutos',
		'Rangos de precios',
		'Rangos de precios',
		'manage_options',
		'tablerate',
		'minutos99_tablerate'
	);
}
add_action('admin_menu', 'minutos99_options_page');

function minutos99_admin_page() {

	echo '<div id="admin_page"> <br><span style="font-size: 35px; color: #343a40;"> <b>Bienvenido al plugin de 99 Minutos</b> </span> <br>
	</div>';
	?><style>
        .woocommerce-adminPage {
		padding: 15px;
        background-color: #343a40;
        align: justify;
        font-size: 1em;
        border-radius: 15px;
		width: 1100px;
        }
    </style>
    <br><div class="woocommerce-adminPage" id="alert_number" role="alert" style="color: white"> 
	<b style="font-size: 20px; color: #85c440;">Configuración de mi cuenta</b><br><br>
	Recuerda que los datos de tu tienda online sólo tienen que ser ingresados una vez. </div><br>
	<?php
	require('configuration.php');
}

function minutos99_tablerate(){
	echo '<div id="table_rate"> <br><span style="font-size: 35px; color: #343a40;"> <b>Rangos de precios</b> </span> <br></div>';
	?><style>
        .woocommerce-tableRate {
        padding: 15px;
        background-color: #85c440;
        align: justify;
        font-size: 1.1em;
        border-radius: 15px;
  		width: 1100px;
        }
    </style>
    <br><div class="woocommerce-tableRate" id="alert_number" role="alert" style="color: white"> 
	<b style="font-size: 20px; color: #343a40;">Configuración de los rangos de precios para los diferentes tipos de envíos y pesos</b><br><br>
	Si quieres modificar los precios de 99 Minutos, puedes hacerlo aquí. </div><br><?php
	require('tablerate.php');
}