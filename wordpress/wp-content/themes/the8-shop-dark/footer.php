<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package the8-shop-dark
 */

?>

	</div><!-- #content -->

	<?php
	/**
	* Hook - the8_shop_dark_site_footer
	*
	* @hooked the8_shop_dark_container_wrap_start
	*/
	do_action( 'the8_shop_dark_site_footer');
	?>
</div><!-- #page -->

<?php wp_footer(); ?>
<a id="backToTop" class="ui-to-top"><?php echo esc_html__( 'BACK TO TOP', 'the8-shop-dark' );?><i class="bi bi-arrow-right"></i></a>
</body>
</html>
