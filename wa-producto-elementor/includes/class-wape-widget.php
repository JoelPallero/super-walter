<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

class WAPE_Widget extends Widget_Base {

	public function get_name() {
		return 'wape_button';
	}

	public function get_title() {
		return __( 'Botón WhatsApp Producto', 'wa-producto-elementor' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
		return [ 'wa-producto-elementor' ];
	}

	public function get_keywords() {
		return [ 'whatsapp', 'wa', 'boton', 'producto', 'joinchat' ];
	}

	protected function register_controls() {
		$this->register_content_controls();
		$this->register_style_controls();
	}

	private function register_content_controls() {

		$options = WAPE_Settings::get_options();

		$this->start_controls_section(
			'section_message',
			[
				'label' => __( 'Mensaje de WhatsApp', 'wa-producto-elementor' ),
			]
		);

		$this->add_control(
			'link_source',
			[
				'label'   => __( 'Origen del enlace', 'wa-producto-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => [
					'custom' => __( 'Enlace personalizado (pegado en el botón)', 'wa-producto-elementor' ),
					'auto'   => __( 'Automático (teléfono + mensaje de abajo)', 'wa-producto-elementor' ),
				],
				'description' => __( 'Con "Enlace personalizado" todo el texto queda guardado dentro de este botón, sin depender de la configuración global — ideal si tenés varios idiomas.', 'wa-producto-elementor' ),
			]
		);

		$this->add_control(
			'custom_link',
			[
				'label'       => __( 'Enlace de WhatsApp', 'wa-producto-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'condition'   => [
					'link_source' => 'custom',
				],
				'placeholder' => 'https://api.whatsapp.com/send/?phone=549347115526624&text=Hola%21+Estoy+interesado+en+%2A[product_title]%2A.+Quisiera+consultar+por+la+financiaci%C3%B3n.&type=phone_number&app_absent=0',
				'description' => __( 'Pegá acá el enlace completo (podés generarlo con la herramienta "Click to Chat" de WhatsApp). Usá [product_title] para insertar el título de esta página y [product_url] para su enlace — se reemplazan automáticamente al mostrar el botón.', 'wa-producto-elementor' ),
			]
		);

		$this->add_control(
			'phone',
			[
				'label'       => __( 'Teléfono de WhatsApp', 'wa-producto-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => $options['default_phone'] ? $options['default_phone'] : '5493471155266',
				'description' => __( 'Dejalo vacío para usar el teléfono configurado en Ajustes > WhatsApp Producto.', 'wa-producto-elementor' ),
				'condition'   => [
					'link_source' => 'auto',
				],
			]
		);

		$this->add_control(
			'use_page_title',
			[
				'label'        => __( 'Usar el título de la página como título del producto', 'wa-producto-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Sí', 'wa-producto-elementor' ),
				'label_off'    => __( 'No', 'wa-producto-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'link_source' => 'auto',
				],
			]
		);

		$this->add_control(
			'custom_title',
			[
				'label'     => __( 'Título del producto', 'wa-producto-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'link_source'      => 'auto',
					'use_page_title!'  => 'yes',
				],
			]
		);

		$this->add_control(
			'use_page_url',
			[
				'label'        => __( 'Usar el enlace de esta página', 'wa-producto-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Sí', 'wa-producto-elementor' ),
				'label_off'    => __( 'No', 'wa-producto-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'link_source' => 'auto',
				],
			]
		);

		$this->add_control(
			'custom_url',
			[
				'label'     => __( 'Enlace del producto', 'wa-producto-elementor' ),
				'type'      => Controls_Manager::URL,
				'condition' => [
					'link_source'    => 'auto',
					'use_page_url!' => 'yes',
				],
			]
		);

		$this->add_control(
			'message_template',
			[
				'label'       => __( 'Mensaje', 'wa-producto-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'default'     => $options['default_message'],
				'description' => __( 'Variables disponibles: {sitio}, {titulo}, {enlace}.', 'wa-producto-elementor' ),
				'condition'   => [
					'link_source' => 'auto',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button',
			[
				'label' => __( 'Botón', 'wa-producto-elementor' ),
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'   => __( 'Texto del botón', 'wa-producto-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Consultar por WhatsApp', 'wa-producto-elementor' ),
			]
		);

		$this->add_control(
			'icon',
			[
				'label'   => __( 'Ícono', 'wa-producto-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fab fa-whatsapp',
					'library' => 'fa-brands',
				],
			]
		);

		$this->add_control(
			'icon_position',
			[
				'label'   => __( 'Posición del ícono', 'wa-producto-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'before',
				'options' => [
					'before' => __( 'Antes del texto', 'wa-producto-elementor' ),
					'after'  => __( 'Después del texto', 'wa-producto-elementor' ),
				],
				'condition' => [
					'icon[value]!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'     => __( 'Alineación', 'wa-producto-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [ 'title' => __( 'Izquierda', 'wa-producto-elementor' ), 'icon' => 'eicon-text-align-left' ],
					'center'  => [ 'title' => __( 'Centro', 'wa-producto-elementor' ), 'icon' => 'eicon-text-align-center' ],
					'right'   => [ 'title' => __( 'Derecha', 'wa-producto-elementor' ), 'icon' => 'eicon-text-align-right' ],
					'justify' => [ 'title' => __( 'Justificado', 'wa-producto-elementor' ), 'icon' => 'eicon-text-align-justify' ],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'open_new_tab',
			[
				'label'        => __( 'Abrir en pestaña nueva', 'wa-producto-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Sí', 'wa-producto-elementor' ),
				'label_off'    => __( 'No', 'wa-producto-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();
	}

	private function register_style_controls() {

		$this->start_controls_section(
			'section_button_style',
			[
				'label' => __( 'Botón', 'wa-producto-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'selector' => '{{WRAPPER}} .wape-btn',
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label'     => __( 'Separación del ícono', 'wa-producto-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'   => [ 'size' => 8, 'unit' => 'px' ],
				'selectors' => [
					'{{WRAPPER}} .wape-btn' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'      => __( 'Tamaño del ícono', 'wa-producto-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 6, 'max' => 60 ],
					'em'  => [ 'min' => 0.5, 'max' => 5, 'step' => 0.1 ],
					'rem' => [ 'min' => 0.5, 'max' => 5, 'step' => 0.1 ],
				],
				'default'    => [ 'size' => 18, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} svg.wape-btn-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} i.wape-btn-icon'   => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      => __( 'Padding', 'wa-producto-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wape-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[ 'label' => __( 'Normal', 'wa-producto-elementor' ) ]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => __( 'Color de texto', 'wa-producto-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wape-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => __( 'Color del ícono', 'wa-producto-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wape-btn-icon'    => 'color: {{VALUE}};',
					'{{WRAPPER}} svg.wape-btn-icon' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'bg_color',
			[
				'label'     => __( 'Color de fondo', 'wa-producto-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#25D366',
				'selectors' => [
					'{{WRAPPER}} .wape-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'border',
				'selector' => '{{WRAPPER}} .wape-btn',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'      => __( 'Radio del borde', 'wa-producto-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'default'    => [ 'top' => '50', 'right' => '50', 'bottom' => '50', 'left' => '50', 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .wape-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .wape-btn',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[ 'label' => __( 'Hover', 'wa-producto-elementor' ) ]
		);

		$this->add_control(
			'hover_text_color',
			[
				'label'     => __( 'Color de texto', 'wa-producto-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wape-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label'     => __( 'Color del ícono', 'wa-producto-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wape-btn:hover .wape-btn-icon'    => 'color: {{VALUE}};',
					'{{WRAPPER}} .wape-btn:hover svg.wape-btn-icon' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_bg_color',
			[
				'label'     => __( 'Color de fondo', 'wa-producto-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wape-btn:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_border_color',
			[
				'label'     => __( 'Color de borde', 'wa-producto-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .wape-btn:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'hover_box_shadow',
				'selector' => '{{WRAPPER}} .wape-btn:hover',
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Animación', 'wa-producto-elementor' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_control(
			'transition_duration',
			[
				'label'     => __( 'Duración de la transición (ms)', 'wa-producto-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 'px' => [ 'min' => 0, 'max' => 3000 ] ],
				'selectors' => [
					'{{WRAPPER}} .wape-btn' => 'transition-duration: {{SIZE}}ms;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Reemplaza los placeholders [product_title], [product_url] y [site_name]
	 * dentro de un enlace ya armado (o de cualquier texto), codificando cada
	 * valor igual que el resto del enlace (espacios como "+", etc.).
	 */
	private function apply_placeholders( $text ) {
		$options = WAPE_Settings::get_options();

		return str_replace(
			[ '[product_title]', '[product_url]', '[site_name]' ],
			[ urlencode( get_the_title() ), urlencode( get_permalink() ), urlencode( $options['site_name'] ) ],
			$text
		);
	}

	/**
	 * Arma el link final tipo:
	 * https://api.whatsapp.com/send/?phone=...&text=...&type=phone_number&app_absent=0
	 */
	private function build_whatsapp_link( $settings ) {
		if ( 'custom' === $settings['link_source'] ) {
			if ( empty( $settings['custom_link'] ) ) {
				return '';
			}

			return $this->apply_placeholders( trim( $settings['custom_link'] ) );
		}

		$options = WAPE_Settings::get_options();

		$phone = ! empty( $settings['phone'] ) ? $settings['phone'] : $options['default_phone'];
		$phone = preg_replace( '/\D+/', '', (string) $phone );

		if ( empty( $phone ) ) {
			return '';
		}

		$titulo = 'yes' === $settings['use_page_title'] ? get_the_title() : $settings['custom_title'];

		if ( 'yes' === $settings['use_page_url'] ) {
			$enlace = get_permalink();
		} else {
			$enlace = ! empty( $settings['custom_url']['url'] ) ? $settings['custom_url']['url'] : '';
		}

		$template = ! empty( $settings['message_template'] ) ? $settings['message_template'] : $options['default_message'];

		$message = str_replace(
			[ '{sitio}', '{titulo}', '{enlace}' ],
			[ $options['site_name'], $titulo, $enlace ],
			$template
		);

		$query = [
			'phone'      => $phone,
			'text'       => $message,
			'type'       => 'phone_number',
			'app_absent' => '0',
		];

		return 'https://api.whatsapp.com/send/?' . http_build_query( $query, '', '&' );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$link     = $this->build_whatsapp_link( $settings );

		if ( empty( $link ) ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<div class="wape-btn-notice">' . esc_html__( 'Completá el enlace de WhatsApp (o el teléfono, si usás el modo automático) para que se muestre el botón.', 'wa-producto-elementor' ) . '</div>';
			}
			return;
		}

		$this->add_render_attribute( 'button', 'class', 'wape-btn' );
		$this->add_render_attribute( 'button', 'href', esc_url( $link ) );
		$this->add_render_attribute( 'button', 'rel', 'nofollow noopener' );

		if ( 'yes' === $settings['open_new_tab'] ) {
			$this->add_render_attribute( 'button', 'target', '_blank' );
		}

		if ( ! empty( $settings['hover_animation'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}

		$has_icon = ! empty( $settings['icon']['value'] );

		$icon_html = '';
		if ( $has_icon ) {
			ob_start();
			Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true', 'class' => 'wape-btn-icon' ] );
			$icon_html = ob_get_clean();
		}
		?>
		<a <?php $this->print_render_attribute_string( 'button' ); ?>>
			<?php if ( $has_icon && 'before' === $settings['icon_position'] ) : ?>
				<?php echo $icon_html; // phpcs:ignore ?>
			<?php endif; ?>
			<?php if ( ! empty( $settings['button_text'] ) ) : ?>
				<span class="wape-btn-text"><?php echo esc_html( $settings['button_text'] ); ?></span>
			<?php endif; ?>
			<?php if ( $has_icon && 'after' === $settings['icon_position'] ) : ?>
				<?php echo $icon_html; // phpcs:ignore ?>
			<?php endif; ?>
		</a>
		<?php
	}
}
