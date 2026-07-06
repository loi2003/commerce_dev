<?php
/**
 * Template Name: Homepage
 *
 * @package the8-shop-dark
 * @subpackage the8-shop-dark
 * @since the8-shop-dark 1.0.0
 * @version 1.0.0
 */
get_header();

$layout = 'full-container';

/**
* Hook - the8_shop_dark_container_wrap_start 	
*
* @hooked the8_shop_dark_container_wrap_start	- 5
*/
 do_action( 'the8_shop_dark_container_wrap_start', esc_attr( $layout ) );

		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		
/**
* Hook - the8_shop_dark_container_wrap_end	
*
* @hooked container_wrap_end - 999
*/
 do_action( 'the8_shop_dark_container_wrap_end', esc_attr( $layout ));
get_footer();