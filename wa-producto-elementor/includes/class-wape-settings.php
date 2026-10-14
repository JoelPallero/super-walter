<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajustes globales del plugin (teléfono y mensaje por defecto),
 * al estilo de la pantalla de configuración de Joinchat.
 */
class WAPE_Settings {

	const OPTION_KEY = 'wape_options';

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_settings_page' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );
	}

	public static function get_options() {
		$defaults = [
			'default_phone'   => '',
			'default_message' => 'Hola! Vi tu anuncio en *{sitio}:* {titulo} {enlace}. *Quería consultar por la financiación.*',
			'site_name'       => get_bloginfo( 'name' ),
		];

		return wp_parse_args( get_option( self::OPTION_KEY, [] ), $defaults );
	}

	public function add_settings_page() {
		add_options_page(
			__( 'WhatsApp Producto', 'wa-producto-elementor' ),
			__( 'WhatsApp Producto', 'wa-producto-elementor' ),
			'manage_options',
			'wape-settings',
			[ $this, 'render_settings_page' ]
		);
	}

	public function register_settings() {
		register_setting( 'wape_settings_group', self::OPTION_KEY, [ $this, 'sanitize_options' ] );
	}

	public function sanitize_options( $input ) {
		$output                     = [];
		$output['default_phone']    = isset( $input['default_phone'] ) ? preg_replace( '/\D+/', '', $input['default_phone'] ) : '';
		$output['default_message']  = isset( $input['default_message'] ) ? sanitize_textarea_field( $input['default_message'] ) : '';
		$output['site_name']        = isset( $input['site_name'] ) ? sanitize_text_field( $input['site_name'] ) : '';

		return $output;
	}

	public function render_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$options = self::get_options();
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'WA Producto Button - Configuración', 'wa-producto-elementor' ); ?></h1>
			<p><?php esc_html_e( 'Estos valores se usan como predeterminados en el widget de Elementor. Cada botón puede sobrescribirlos individualmente.', 'wa-producto-elementor' ); ?></p>
			<form method="post" action="options.php">
				<?php settings_fields( 'wape_settings_group' ); ?>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row">
							<label for="wape_default_phone"><?php esc_html_e( 'Teléfono de WhatsApp por defecto', 'wa-producto-elementor' ); ?></label>
						</th>
						<td>
							<input type="text" id="wape_default_phone" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[default_phone]" value="<?php echo esc_attr( $options['default_phone'] ); ?>" class="regular-text" placeholder="5493471155266" />
							<p class="description"><?php esc_html_e( 'Solo números, con código de país (sin +, espacios ni guiones).', 'wa-producto-elementor' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="wape_site_name"><?php esc_html_e( 'Nombre del sitio (para {sitio})', 'wa-producto-elementor' ); ?></label>
						</th>
						<td>
							<input type="text" id="wape_site_name" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[site_name]" value="<?php echo esc_attr( $options['site_name'] ); ?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="wape_default_message"><?php esc_html_e( 'Mensaje por defecto', 'wa-producto-elementor' ); ?></label>
						</th>
						<td>
							<textarea id="wape_default_message" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[default_message]" rows="4" class="large-text"><?php echo esc_textarea( $options['default_message'] ); ?></textarea>
							<p class="description"><?php esc_html_e( 'Variables disponibles: {sitio}, {titulo}, {enlace}.', 'wa-producto-elementor' ); ?></p>
						</td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}
}
