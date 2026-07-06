<?php
/**
 * Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 */

// Theme Setup
if ( ! function_exists( 'nature21_theme_support' ) ) :
	function nature21_theme_support() {
		load_theme_textdomain( 'nature21', get_template_directory() . '/languages' );
		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'block-template-parts' );
		// Enqueue editor styles.
		add_editor_style( 'editor-style.css' );
	}
endif;

add_action( 'after_setup_theme', 'nature21_theme_support' );

function nature21_style_load() {
  wp_register_style(
    'nature21_style_load',
    get_template_directory_uri() . '/editor-style.css',
    array(),
    false // Disable the ?ver= query string
  );

  wp_enqueue_style( 'nature21_style_load' );
}
add_action( 'enqueue_block_editor_assets', 'nature21_style_load' );

function nature21_load_dashicons(){
   wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'nature21_load_dashicons', 999);

// Load Styles/Scripts
if ( ! function_exists( 'nature21_theme_styles' ) ) :

	function nature21_theme_styles() {
		
		// Register theme stylesheet.
		wp_register_style('nature21-theme-style', get_template_directory_uri() . '/style.css', array());

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'nature21-theme-style' );

		if ( is_rtl() ) { 
			wp_enqueue_style('rtl-css',get_template_directory_uri().'/assets/css/rtl.css', 'rtl_css' ); 
		}
				
		// Enqueue jquery.
		wp_enqueue_script('jquery');		
	}
	
endif;

add_action( 'wp_enqueue_scripts', 'nature21_theme_styles' );

function nature21_register_block_styles() {
    // Add a new style for the core button block
    register_block_style(
        'core/button',
        array(
            'name'  => 'fancy-button',
            'label' => __( 'Fancy Button', 'nature21' ),
        )
    );

    // Add a style for core/heading block
    register_block_style(
        'core/heading',
        array(
            'name'  => 'highlighted-heading',
            'label' => __( 'Highlighted Heading', 'nature21' ),
        )
    );
}
add_action( 'init', 'nature21_register_block_styles' );

// Add block patterns
require get_template_directory() . '/includes/block-patterns.php';