<?php
/**
 * LSX_Customizer_Colour
 *
 * @package   lsx-customizer
 * @author    LightSpeed
 * @license   GPL-2.0+
 * @link      
 * @copyright 2016 LightSpeedDevelopment
 */

if ( ! class_exists( 'LSX_Customizer_Colour' ) ) {

	/**
	 * Customizer Colour class.
	 *
	 * @package LSX_Customizer_Colour
	 * @author  LightSpeed
	 */
	class LSX_Customizer_Colour extends LSX_Customizer {

		/**
		 * Button customizer instance.
		 *
		 * @var string
		 * @since 1.1.0
		 */
		public $button;

		/**
		 * Button CTA customizer instance.
		 *
		 * @var string
		 * @since 1.1.0
		 */
		public $button_cta;

		/**
		 * Top Menu customizer instance.
		 *
		 * @var string
		 * @since 1.1.0
		 */
		public $top_menu;

		/**
		 * Header customizer instance.
		 *
		 * @var string
		 * @since 1.1.0
		 */
		public $header;

		/**
		 * Main menu customizer instance.
		 *
		 * @var string
		 * @since 1.1.0
		 */
		public $main_menu;

		/**
		 * Banner customizer instance.
		 *
		 * @var string
		 * @since 1.1.0
		 */
		public $banner;

		/**
		 * Body customizer instance.
		 *
		 * @var string
		 * @since 1.1.0
		 */
		public $body;

		/**
		 * Footer CTA customizer instance.
		 *
		 * @var string
		 * @since 1.1.0
		 */
		public $footer_cta;

		/**
		 * Footer Widgets customizer instance.
		 *
		 * @var string
		 * @since 1.1.0
		 */
		public $footer_widgets;

		/**
		 * Footer customizer instance.
		 *
		 * @var string
		 * @since 1.1.0
		 */
		public $footer;

		/**
		 * Constructor.
		 *
		 * @since 1.1.0
		 */
		public function __construct() {
			add_action( 'after_setup_theme',                       array( $this, 'after_setup_theme' ), 20 );
			add_action( 'customize_register',                      array( $this, 'customize_register' ), 20 );
			add_action( 'customize_controls_print_footer_scripts', array( $this, 'colour_scheme_css_template' ) );
		}

		/**
		 * Customizer Controls and Settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.1.0
		 */
		public function after_setup_theme() {
			require_once( LSX_CUSTOMIZER_PATH . 'includes/lsx-customizer-colour-options.php' );
			require_once( LSX_CUSTOMIZER_PATH . 'includes/lsx-customizer-colour-deprecated.php' );

			if ( class_exists( 'WP_Customize_Control' ) ) {
				require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-control.php' );
			}

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-button.php' );
			$this->button = new LSX_Customizer_Colour_Button;

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-button-cta.php' );
			$this->button_cta = new LSX_Customizer_Colour_Button_CTA;

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-top-menu.php' );
			$this->top_menu = new LSX_Customizer_Colour_Top_Menu;

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-header.php' );
			$this->header = new LSX_Customizer_Colour_Header;

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-main-menu.php' );
			$this->main_menu = new LSX_Customizer_Colour_Main_Menu;

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-banner.php' );
			$this->banner = new LSX_Customizer_Colour_Banner;

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-body.php' );
			$this->body = new LSX_Customizer_Colour_Body;

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-footer-cta.php' );
			$this->footer_cta = new LSX_Customizer_Colour_Footer_CTA;

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-footer-widgets.php' );
			$this->footer_widgets = new LSX_Customizer_Colour_Footer_Widgets;

			require_once( LSX_CUSTOMIZER_PATH . 'classes/class-lsx-customizer-colour-footer.php' );
			$this->footer = new LSX_Customizer_Colour_Footer;
		}

		/**
		 * Customizer Controls and Settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.1.0
		 */
		public function customize_register( $wp_customize ) {
			global $customizer_colour_names;
			global $customizer_colour_choices;
			
			/**
			 * Colors
			 */
			$wp_customize->add_section( 'colors' , array(
				'title'             => esc_html__( 'Colors', 'lsx-customizer' ),
				'priority'          => 60,
			) );

			/**
			 * Background: Background Color
			 */
			$wp_customize->add_setting( 'color_scheme', array(
				'default'           => 'default',
				'type'	            => 'theme_mod',
				'transport'         => 'postMessage',
			) );

			$wp_customize->add_control( new LSX_Customizer_Colour_Control( $wp_customize, 'color_scheme', array(
				'label'             => esc_html__( 'Base Color Scheme', 'lsx-customizer' ),
				'section'           => 'colors',
				'type'              => 'select',
				'priority'          => 1,
				'choices'           => $customizer_colour_choices,
			) ) );

			foreach ( $customizer_colour_names as $key => $value ) {
				$sanitize_callback = 'sanitize_hex_color';

				if ( 'background_color' === $key ) {
					$sanitize_callback = 'sanitize_hex_color_no_hash';
				}

				$wp_customize->add_setting( $key, array(
					'default'           => $customizer_colour_choices['default']['colors'][$key],
					'type'	            => 'theme_mod',
					'transport'         => 'postMessage',
					'sanitize_callback' => $sanitize_callback,
				) );

				$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, array(
					'label'             => $value,
					'section'           => 'colors',
					'settings'          => $key,
				) ) );
			}
		}

		/**
		 * Outputs an Underscore template for generating CSS for the color scheme.
		 *
		 * @since 1.1.0
		 */
		public function colour_scheme_css_template() {
			global $customizer_colour_names;
			
			$colors = array();

			foreach ( $customizer_colour_names as $key => $value ) {
				$colors[$key] = 'unquote("{{ data.'.$key.' }}")';
			}
			?>
			<script type="text/html" id="tmpl-lsx-color-scheme">
				<?php echo $this->top_menu->get_css( $colors ) ?>
				<?php echo $this->header->get_css( $colors ) ?>
				<?php echo $this->main_menu->get_css( $colors ) ?>

				<?php echo $this->banner->get_css( $colors ) ?>
				<?php echo $this->body->get_css( $colors ) ?>

				<?php echo $this->footer_cta->get_css( $colors ) ?>
				<?php echo $this->footer_widgets->get_css( $colors ) ?>
				<?php echo $this->footer->get_css( $colors ) ?>

				<?php echo $this->button->get_css( $colors ) ?>
				<?php echo $this->button_cta->get_css( $colors ) ?>
			</script>
			<?php
		}

		/**
		 * Transform SCSS to CSS.
		 *
		 * @since 1.1.0
		 */
		public function scss_to_css( $scss ) {
			$css = '';
			$scssphp_file = LSX_CUSTOMIZER_PATH .'vendor/leafo/scssphp/scss.inc.php';

			if ( ! empty( $scss ) && file_exists( $scssphp_file ) ) {
				require_once $scssphp_file;

				$compiler = new \Leafo\ScssPhp\Compiler();
				$compiler->setFormatter( 'Leafo\ScssPhp\Formatter\Compact' );

				try {
					$css = $compiler->compile( $scss );
				} catch ( Exception $e ) {
					$error = $e->getMessage();
					return "/*\n\n\$error:\n\n{$error}\n\n\$scss:\n\n{$scss} */";
				}
			}

			return $css;
		}

		/**
		 * Converts a HEX value to RGB.
		 *
		 * @since 1.1.0
		 */
		public static function hex2rgb( $color ) {
			$color = trim( $color, '#' );

			if ( strlen( $color ) === 3 ) {
				$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
				$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
				$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
			} else if ( strlen( $color ) === 6 ) {
				$r = hexdec( substr( $color, 0, 2 ) );
				$g = hexdec( substr( $color, 2, 2 ) );
				$b = hexdec( substr( $color, 4, 2 ) );
			} else {
				return array();
			}

			return array( 'red' => $r, 'green' => $g, 'blue' => $b );
		}

		/**
		 * Retrieves the current color scheme.
		 *
		 * @since 1.1.0
		 */
		public function get_color_scheme() {
			global $customizer_colour_choices;

			$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );
			$color_schemes = $customizer_colour_choices;

			if ( array_key_exists( $color_scheme_option, $color_schemes ) ) {
				return $color_schemes[ $color_scheme_option ]['colors'];
			}

			return $color_schemes['default']['colors'];
		}

	}

	new LSX_Customizer_Colour;

}