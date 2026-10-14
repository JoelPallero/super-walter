<?php
/**
 * Plugin Name: WA Producto Button para Elementor
 * Plugin URI: https://joelpallero.com.ar
 * Description: Widget de Elementor que arma un botón de WhatsApp con el título del producto y el enlace de la página, con configuración personalizada de teléfono y mensaje.
 * Version: 1.0.0
 * Author: Joel Pallero
 * Author URI: https://joelpallero.com.ar
 * Text Domain: wa-producto-elementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WAPE_VERSION', '1.0.0' );
define( 'WAPE_PLUGIN_FILE', __FILE__ );
define( 'WAPE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WAPE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * La configuración (WAPE_Settings) no depende de Elementor, se puede
 * cargar siempre. El widget en cambio extiende clases de Elementor, así
 * que su archivo sólo se requiere dentro de hooks que Elementor mismo
 * dispara (nunca antes), para no romper el sitio si Elementor todavía no
 * terminó de cargar sus clases o no está activo.
 */
function wape_init() {
	require_once WAPE_PLUGIN_DIR . 'includes/class-wape-settings.php';
	new WAPE_Settings();

	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'wape_admin_notice_missing_elementor' );
		return;
	}

	add_action( 'elementor/widgets/register', 'wape_register_widgets' );
	add_action( 'elementor/elements/categories_registered', 'wape_register_category' );
	add_action( 'wp_enqueue_scripts', 'wape_enqueue_styles' );
}
add_action( 'plugins_loaded', 'wape_init' );

function wape_admin_notice_missing_elementor() {
	?>
	<div class="notice notice-warning">
		<p><?php esc_html_e( 'WA Producto Button para Elementor requiere que Elementor esté instalado y activo.', 'wa-producto-elementor' ); ?></p>
	</div>
	<?php
}

function wape_register_category( $elements_manager ) {
	$elements_manager->add_category(
		'wa-producto-elementor',
		[
			'title' => __( 'WhatsApp Producto', 'wa-producto-elementor' ),
			'icon'  => 'fa fa-plug',
		]
	);
}

function wape_register_widgets( $widgets_manager ) {
	// Se requiere recién acá: este hook lo dispara Elementor cuando ya
	// están cargadas todas sus clases (Widget_Base, Controls_Manager, etc.).
	require_once WAPE_PLUGIN_DIR . 'includes/class-wape-widget.php';

	if ( ! class_exists( '\WAPE_Widget' ) ) {
		return;
	}

	$widgets_manager->register( new \WAPE_Widget() );
}

function wape_enqueue_styles() {
	wp_enqueue_style( 'wape-style', WAPE_PLUGIN_URL . 'assets/css/wa-producto.css', [], WAPE_VERSION );
}
