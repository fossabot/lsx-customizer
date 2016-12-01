<?php
if ( ! class_exists( 'LSX_Customizer_Blog' ) ) {

	/**
	 * LSX Customizer Blog Class
	 *
	 * @package   LSX Customizer
	 * @author    LightSpeed
	 * @license   GPL3
	 * @link      
	 * @copyright 2016 LightSpeed
	 */
	class LSX_Customizer_Blog extends LSX_Customizer {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'customize_register' ), 20 );
			add_filter( 'body_class',         array( $this, 'body_class' ) );
			add_filter( 'post_class',         array( $this, 'post_class' ) );
			add_action( 'wp',                 array( $this, 'layout' ), 999 );
		}

		/**
		 * Customizer Controls and Settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since 1.0.0
		 */
		public function customize_register( $wp_customize ) {
			/**
			 * Add the blog panel
			 */
			$wp_customize->add_panel( 'lsx_customizer_blog_panel', array(
				'priority'       	=> 61,
				'capability'     	=> 'edit_theme_options',
				'theme_supports' 	=> '',
				'title'				=> esc_html__( 'Blog', 'lsx-customizer' ),
				'description'    	=> esc_html__( 'Customise the appearance of your blog posts and archives.', 'lsx-customizer' ),
			) );

			/**
			 * General section
			 */
			$wp_customize->add_section( 'lsx_customizer_general' , array(
				'title'      	=> esc_html__( 'General', 'lsx-customizer' ),
				'priority'   	=> 10,
				'description' 	=> esc_html__( 'Customise the look & feel of the blog archives and blog post pages', 'lsx-customizer' ),
				'panel'			=> 'lsx_customizer_blog_panel',
			) );

			/**
			 * Blog archives section
			 */
			$wp_customize->add_section( 'lsx_customizer_archive' , array(
				'title'      	=> esc_html__( 'Archives', 'lsx-customizer' ),
				'priority'   	=> 20,
				'description' 	=> esc_html__( 'Customise the look & feel of the blog archives', 'lsx-customizer' ),
				'panel'			=> 'lsx_customizer_blog_panel',
			) );

			/**
			 * Single blog post section
			 */
			$wp_customize->add_section( 'lsx_customizer_single' , array(
				'title'      	=> esc_html__( 'Single posts', 'lsx-customizer' ),
				'priority'   	=> 30,
				'description' 	=> esc_html__( 'Customise the look & feel of the blog post pages', 'lsx-customizer' ),
				'panel'			=> 'lsx_customizer_blog_panel',
			) );

			/**
			 * General section: display date
			 */
			$wp_customize->add_setting( 'lsx_customizer_general_date', array(
				'default'           => true,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_customizer_general_date', array(
				'label'         => esc_html__( 'Display date', 'lsx-customizer' ),
				'description'   => esc_html__( 'Display post date in blog archives and blog post pages.', 'lsx-customizer' ),
				'section'       => 'lsx_customizer_general',
				'settings'      => 'lsx_customizer_general_date',
				'type'          => 'checkbox',
				'priority'      => 10,
			) ) );

			/**
			 * General section: display author
			 */
			$wp_customize->add_setting( 'lsx_customizer_general_author', array(
				'default'           => true,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_customizer_general_author', array(
				'label'         => esc_html__( 'Display author', 'lsx-customizer' ),
				'description'   => esc_html__( 'Display post author in blog archives and blog post pages.', 'lsx-customizer' ),
				'section'       => 'lsx_customizer_general',
				'settings'      => 'lsx_customizer_general_author',
				'type'          => 'checkbox',
				'priority'      => 20,
			) ) );

			/**
			 * General section: display categories
			 */
			$wp_customize->add_setting( 'lsx_customizer_general_category', array(
				'default'           => true,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_customizer_general_category', array(
				'label'         => esc_html__( 'Display categories', 'lsx-customizer' ),
				'description'   => esc_html__( 'Display post categories in blog archives and blog post pages.', 'lsx-customizer' ),
				'section'       => 'lsx_customizer_general',
				'settings'      => 'lsx_customizer_general_category',
				'type'          => 'checkbox',
				'priority'      => 30,
			) ) );

			/**
			 * General section: display tags
			 */
			$wp_customize->add_setting( 'lsx_customizer_general_tags', array(
				'default'           => true,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_customizer_general_tags', array(
				'label'         => esc_html__( 'Display tags', 'lsx-customizer' ),
				'description'   => esc_html__( 'Display post tags in blog archives and blog post pages.', 'lsx-customizer' ),
				'section'       => 'lsx_customizer_general',
				'settings'      => 'lsx_customizer_general_tags',
				'type'          => 'checkbox',
				'priority'      => 30,
			) ) );

			/**
			 * Blog archives section: full width
			 */
			$wp_customize->add_setting( 'lsx_customizer_archive_full_width', array(
				'default'           => false,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_customizer_archive_full_width', array(
				'label'         => esc_html__( 'Full width', 'lsx-customizer' ),
				'description'   => esc_html__( 'Display blog archives in a full width layout.', 'lsx-customizer' ),
				'section'       => 'lsx_customizer_archive',
				'settings'      => 'lsx_customizer_archive_full_width',
				'type'          => 'checkbox',
				'priority'      => 10,
			) ) );

			/**
			 * Single blog post section: full width
			 */
			$wp_customize->add_setting( 'lsx_customizer_single_full_width', array(
				'default'           => false,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_customizer_single_full_width', array(
				'label'         => esc_html__( 'Full width', 'lsx-customizer' ),
				'description'   => esc_html__( 'Give the single blog post pages a full width layout.', 'lsx-customizer' ),
				'section'       => 'lsx_customizer_single',
				'settings'      => 'lsx_customizer_single_full_width',
				'type'          => 'checkbox',
				'priority'      => 10,
			) ) );

			/**
			 * Single blog post section: display thumbnail
			 */
			$wp_customize->add_setting( 'lsx_customizer_single_thumbnail', array(
				'default'           => true,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_customizer_single_thumbnail', array(
				'label'         => esc_html__( 'Display thumbnail', 'lsx-customizer' ),
				'description'   => esc_html__( 'Display post thumbnail in blog post pages.', 'lsx-customizer' ),
				'section'       => 'lsx_customizer_single',
				'settings'      => 'lsx_customizer_single_thumbnail',
				'type'          => 'checkbox',
				'priority'      => 20,
			) ) );

			/**
			 * Single blog post section: display related posts
			 */
			$wp_customize->add_setting( 'lsx_customizer_single_related_posts', array(
				'default'           => true,
				'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lsx_customizer_single_related_posts', array(
				'label'         => esc_html__( 'Display related posts', 'lsx-customizer' ),
				'description'   => esc_html__( 'Display related posts in blog post pages.', 'lsx-customizer' ),
				'section'       => 'lsx_customizer_single',
				'settings'      => 'lsx_customizer_single_related_posts',
				'type'          => 'checkbox',
				'priority'      => 30,
			) ) );
		}

		/**
		 * Layout.
		 *
		 * @since 1.0.0
		 */
		public function layout() {
			$body_classes               = get_body_class();
			
			$is_archive                 = in_array( 'blog', $body_classes ) || is_archive() || is_category() || is_tag() || is_date() || is_search();
			$is_single_post             = is_singular( 'post' );
			$is_archive_or_single_post  = $is_archive || $is_single_post;

			$general_date               = get_theme_mod( 'lsx_customizer_general_date', true );
			$general_author             = get_theme_mod( 'lsx_customizer_general_author', true );
			$general_category           = get_theme_mod( 'lsx_customizer_general_category', true );
			$general_tags               = get_theme_mod( 'lsx_customizer_general_tags', true );

			$single_thumbnail           = get_theme_mod( 'lsx_customizer_single_thumbnail', true );
			$single_related_posts       = get_theme_mod( 'lsx_customizer_single_related_posts', true );

			if ( $is_archive_or_single_post && false == $general_date ) {
				remove_action( 'lsx_content_post_meta', 'lsx_post_meta_date', 10 );
			}

			if ( $is_archive_or_single_post && false == $general_author ) {
				remove_action( 'lsx_content_post_meta', 'lsx_post_meta_author', 20 );
			}

			if ( $is_archive_or_single_post && false == $general_category ) {
				remove_action( 'lsx_content_post_meta', 'lsx_post_meta_category', 30 );
			}

			if ( $is_archive_or_single_post && false == $general_tags ) {
				remove_action( 'lsx_content_post_tags', 'lsx_post_tags', 10 );
			}

			if ( $is_single_post && false == $single_thumbnail ) {
				add_filter( 'lsx_allowed_post_type_banners', function( $post_types ) {
					if ( ( $key = array_search( 'post', $post_types ) ) !== false ) {
						unset( $post_types[$key] );
					}

					return $post_types;
				} );
			}

			if ( $is_single_post && false == $single_related_posts ) {
				remove_action( 'lsx_entry_bottom', 'lsx_related_posts', 10 );
			}
		}

		/**
		 * Body class.
		 *
		 * @param array $classes the classes applied to the body tag.
		 * @return array $classes the classes applied to the body tag.
		 * @since 1.0.0
		 */
		public function body_class( $body_classes ) {
			$is_archive                 = in_array( 'blog', $body_classes ) || is_archive() || is_category() || is_tag() || is_date() || is_search();
			$is_single_post             = is_singular( 'post' );
			$is_archive_or_single_post  = $is_archive || $is_single_post;

			$general_date               = get_theme_mod( 'lsx_customizer_general_date', true );
			$general_author             = get_theme_mod( 'lsx_customizer_general_author', true );
			$general_category           = get_theme_mod( 'lsx_customizer_general_category', true );

			$archive_full_width         = get_theme_mod( 'lsx_customizer_archive_full_width', false );

			$single_full_width          = get_theme_mod( 'lsx_customizer_single_full_width', false );
			
			if ( $is_archive_or_single_post && false == $general_date ) {
				$body_classes[] = 'lsx-hide-post-date';
			}

			if ( $is_archive_or_single_post && false == $general_author ) {
				$body_classes[] = 'lsx-hide-post-author';
			}

			if ( $is_archive_or_single_post && false == $general_category ) {
				$body_classes[] = 'lsx-hide-post-category';
			}

			if ( $is_archive && true == $archive_full_width ) {
				$body_classes[] = 'lsx-body-full-width';
			}

			if ( $is_single_post && true == $single_full_width ) {
				$body_classes[] = 'lsx-body-full-width';
			}

			return $body_classes;
		}

		/**
		 * Post class.
		 *
		 * @param  array $classes The classes.
		 * @return array $classes The classes.
		 * @since 1.0.0
		 */
		public function post_class( $classes ) {
			$body_classes               = get_body_class();
			
			$is_archive                 = in_array( 'blog', $body_classes ) || is_archive() || is_category() || is_tag() || is_date() || is_search();
			$is_single_post             = is_singular( 'post' );
			$is_archive_or_single_post  = $is_archive || $is_single_post;

			$general_tags               = get_theme_mod( 'lsx_customizer_general_tags', true );

			if ( $is_single_post && false == $general_tags ) {
				if ( ! function_exists( 'sharing_display' ) && ! class_exists( 'Jetpack_Likes' ) ) {
					$classes[] = 'lsx-hide-post-tags';
				}
			} elseif ( $is_archive && false == $general_tags ) {
				if ( ! comments_open() || 0 == get_comments_number() ) {
					$classes[] = 'lsx-hide-post-tags';
				}
			}

			return $classes;
		}

	}

	new LSX_Customizer_Blog;

}
