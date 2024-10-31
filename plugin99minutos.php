<?php
/*
Plugin Name: Plugin 99 Minutos
Description: La extensión oficial de 99 Minutos te permite integrar los servicios de envío que ofrece 99minutos.com en la orden de compra de tus clientes. Para poder utilizar nuestros servicios es necesario que instales nuestro plugin en tu tienda realizada con WooCommerce. Recuerda que estamos en constante trabajo para brindarte nuevas actualizaciones.
Contributors: almeida02, robtone, nestormtz, davidvazquez
Donate link: #
Tags: paquetería, mensajería, envíos, woocommerce, commerce, e-commerce,
Requires at least: 4.5
Tested up to: 5.3.2
Stable tag: 1.1.0
Requires PHP: 5.6
Plugin URI: https://www.client.99minutos.com/
Version: 1.1.0
Author: 99 Minutos Developers: almeida02, robtone, nestormtz, davidvazquez
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Text Domain: woocommerce-shipping-99Minutos
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	
	/**
	 * The code that runs during plugin activation. 
	 **/

	// Admin
	require_once(dirname(__FILE__) . '/admin/admin.php');

	// Shipping method 99 Minutos
	require_once(dirname(__FILE__) . '/includes/99minutos.php');
	require_once(dirname(__FILE__) . '/includes/checkout.php');
	require_once(dirname(__FILE__) . '/includes/postcode.php');

	//Activate
	function wc_minutos99_activate() {
		add_option( 'wc_minutos99_show_upgrade_notice','yes');
	}
	register_activation_hook( __FILE__, 'wc_minutos99_activate' );

	// Deactivation
	function wc_minutos99_deactivate() {
		delete_option( 'wc_minutos99_show_upgrade_notice');
	}
	register_deactivation_hook( __FILE__, 'wc_minutos99_deactivate' );
	
	// Class Envío 99 Minutos
	class envio_99_Init {
		/**
		* Plugin's Instance.
		* @access private
		* @since 1.0.0
		* @var envio_99_Init
		*/		
	   private static $instance;
	   /**
		* Get the class instance
		* @access public
		* @since 1.0.0
		* @return mixed envio_99_Init instance
		*/
	   public static function get_instance() {
		   return null === self::$instance ? ( self::$instance = new self ) : self::$instance;
	   }

	   /**
		* Class constructor
		* @access public
		* @since 1.0.0
		*/
	   public function __construct() {
		   
		   if ( class_exists( 'WC_Shipping_Method' ) ):		   
			   add_action( 'admin_notices', array( $this, 'upgrade_notice' ) );
			   add_action( 'wp_ajax_minutos99_dismiss_upgrade_notice', array( $this, 'minutos99_dismiss_upgrade_notice' ) );
			   add_action( 'wp_ajax_nopriv_minutos99_dismiss_upgrade_notice', array( $this, 'minutos99_dismiss_upgrade_notice' ) );
		   else:
			   add_action( 'admin_notices', array( $this, 'wc_deactivated' ) );
		   endif;
	   }

	   /**
		 * Localisation
		 * @access public
		 * @since 1.0.0
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'woocommerce-shipping-99Minutos', false, basename( dirname( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Add 99 Minutos shipping method to WC
		 * @access public
		 * @since 1.0.0
		 * @param mixed $methods shipping methods
		 * @return mixed $methods shipping methods
		 */
		public function add_method( $methods ) {
			$methods['99Minutos'] = 'envio_99';
			return $methods;
		}

	   /**
		* Show the user a notice for plugin updates
		* @access public
		* @since 1.0.0
		* @return string raw html/javascript
		*/
	   public function upgrade_notice() {
		   $show_notice = get_option( 'wc_minutos99_show_upgrade_notice' );

		   if ( 'yes' !== $show_notice ):
			   return;
		   endif;

		   $query_args = array( 'page' => 'wc-settings', 'tab' => 'shipping' );
		   $zones_admin_url = add_query_arg( $query_args, get_admin_url() . 'admin.php' );
		   ?>
		   <div class="notice notice-success is-dismissible wc-notice">
			   <p><?php echo sprintf( __( 'No olvides activar el plugin de 99 Minutos en tus zonas de envío o también puedes hacer click %1$saquí.%2$s ', 'woocommerce-shipping-99Minutos' ),'<a href="' . $zones_admin_url . '" target="_blank">','</a>' ); ?></p>
		   </div>

		   <script type="application/javascript">
			   jQuery( '.notice.wc-notice' ).on( 'click', '.notice-dismiss', function () {
				   wp.ajax.post('minutos99_dismiss_upgrade_notice');
			   });
		   </script>
		   <?php
	   }

	   /**
		* Turn of the dismisable upgrade notice.
		* @access public
		* @since 1.0.0
		*/
	   public function minutos99_dismiss_upgrade_notice() {
		   update_option( 'wc_minutos99_show_upgrade_notice', 'no' );
	   }
   }
   add_action( 'plugins_loaded' , array( 'envio_99_Init', 'get_instance' ), 0 );

   function notice_warning_minutos99() {
    ?>
    <div class="notice notice-warning is-dismissible">
		<p><?php _e( 'Recuerda añadir el peso a todos tus productos en la sección de "Información del producto", 
					  de lo contrario el plugin de 99 Minutos no funcionará correctamente.', 'sample-text-domain' ); 
		?></p>
    </div>

    <?php
	}
	add_action( 'admin_notices', 'notice_warning_minutos99' );
}