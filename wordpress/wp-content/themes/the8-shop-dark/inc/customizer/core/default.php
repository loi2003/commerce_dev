<?php
/**
 * Default theme options.
 *
 * @package the8-shop-dark
 */

if ( ! function_exists( 'the8_shop_dark_get_default_theme_options' ) ) :

	/**
	 * Get default theme options
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
	function the8_shop_dark_get_default_theme_options() {

		$defaults = array();
		
		
		/*Posts Layout*/
		$defaults['blog_layout']     				= 'content-sidebar';
		$defaults['single_post_layout']     		= 'no-sidebar';
		
		$defaults['blog_loop_content_type']     	= 'excerpt';
		
		$defaults['blog_meta_hide']     			= false;
		$defaults['signle_meta_hide']     			= false;
		
		/*Posts Layout*/
		$defaults['page_layout']     				= 'full-container';
		
		/*layout*/
		$defaults['copyright_text']					= esc_html__( 'Copyright All right reserved', 'the8-shop-dark' );
		$defaults['read_more_text']					= esc_html__( 'Read More', 'the8-shop-dark' );
		$defaults['index_hide_thumb']     			= false;
		
		
		/*Posts Layout*/
		$defaults['__primary_color']     			= '#6c757d';
		$defaults['__secondary_color']     			= '#d2a35c';


		$defaults['__media_url']     				= '';
		$defaults['__banner_title']     			= '';
		$defaults['__banner_desc']     				= '';
		// Pass through filter.
		$defaults = apply_filters( 'the8_shop_dark_filter_default_theme_options', $defaults );

		return $defaults;

	}

endif;
