<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package the8-shop-dark
 */
/**
 *  Hook remove from WooCommerce archive
 */
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb',20 );
add_filter( 'woocommerce_show_page_title', '__return_false' );
remove_action( 'woocommerce_sidebar','woocommerce_get_sidebar',10 );

remove_action( 'woocommerce_before_shop_loop_item','woocommerce_template_loop_product_link_open',10 );
remove_action( 'woocommerce_before_shop_loop_item','woocommerce_template_loop_product_link_open',10 );
remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_product_link_close',5 );

remove_action( 'woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_thumbnail',10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

remove_action( 'woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',5 );

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display',5 );

add_filter( 'woocommerce_product_description_heading', '__return_false' );
add_filter( 'woocommerce_product_additional_information_heading', '__return_false' );


remove_action( 'woocommerce_archive_description','woocommerce_taxonomy_archive_description',10 );
remove_action( 'woocommerce_archive_description','woocommerce_taxonomy_archive_description',10 );	

add_action( 'the8_shop_dark_archive_description','woocommerce_taxonomy_archive_description',10 );
add_action( 'the8_shop_dark_archive_description','woocommerce_taxonomy_archive_description',10 );	

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function the8_shop_dark_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 300,
			'single_image_width'    => 600,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'the8_shop_dark_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */

function the8_shop_dark_woocommerce_scripts() {
	
	wp_enqueue_style( 'the8-shop-dark-woocommerce-core', get_template_directory_uri() . '/assets/css/woocommerce-core.css', array(), _SOPER_VERSION );
	wp_enqueue_style( 'the8-shop-dark-woocommerce-style', get_template_directory_uri() . '/woocommerce.css', array(), _SOPER_VERSION );

	$font_path   = esc_url( WC()->plugin_url() . '/assets/fonts/' );
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . esc_url( $font_path ) . 'star.eot");
			src: url("' . esc_url( $font_path ) . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . esc_url( $font_path ) . 'star.woff") format("woff"),
				url("' . esc_url( $font_path ) . 'star.ttf") format("truetype"),
				url("' . esc_url( $font_path ) . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'the8-shop-dark-woocommerce-style', $inline_font );

	wp_enqueue_script( 'the8-shop-dark-woocommerce', get_theme_file_uri( '/assets/js/the8-shop-dark-woocommerce.js' ) , 0, '1.1', true );
}
add_action( 'wp_enqueue_scripts', 'the8_shop_dark_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function the8_shop_dark_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'the8_shop_dark_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function the8_shop_dark_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'the8_shop_dark_woocommerce_related_products_args' );
add_filter( 'woocommerce_upsell_display_args', 'the8_shop_dark_woocommerce_related_products_args' );

add_filter( 'woocommerce_cross_sells_columns', 'the8_shop_dark_change_cross_sells_columns' );
 
function the8_shop_dark_change_cross_sells_columns( $columns ) {
	return 4;
}
/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'the8_shop_dark_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function the8_shop_dark_woocommerce_wrapper_before() {
		/**
		* Hook - the8_shop_dark_container_wrap_start 	
		*
		* @hooked the8_shop_dark_container_wrap_start	- 5
		*/
		if( is_product() ){
			 do_action( 'the8_shop_dark_container_wrap_start', 'no-sidebar');
		}else{
		 do_action( 'the8_shop_dark_container_wrap_start', 'full-container');
		}
	}
}
add_action( 'woocommerce_before_main_content', 'the8_shop_dark_woocommerce_wrapper_before' );

if ( ! function_exists( 'the8_shop_dark_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function the8_shop_dark_woocommerce_wrapper_after() {
		/**
		* Hook - the8_shop_dark_container_wrap_end	
		*
		* @hooked container_wrap_end - 999
		*/
		do_action( 'the8_shop_dark_container_wrap_end', 'full-container');
	}
}
add_action( 'woocommerce_after_main_content', 'the8_shop_dark_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'the8_shop_dark_woocommerce_header_cart' ) ) {
			the8_shop_dark_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'the8_shop_dark_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function the8_shop_dark_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		the8_shop_dark_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'the8_shop_dark_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'the8_shop_dark_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function the8_shop_dark_woocommerce_cart_link() {
		?>
		<a class="cart-contents gap-2" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'the8-shop-dark' ); ?>">
			<?php
				$item_count_text = sprintf(
					/* translators: %d is the number of items (no label shown) */
					_n( '(&nbsp;%d&nbsp;)', '(&nbsp;%d&nbsp;)', WC()->cart->get_cart_contents_count(), 'the8-shop-dark' ),
					WC()->cart->get_cart_contents_count()
				);
			?>
			<i class="bi bi-cart3"></i>
			<span class="quantity"><?php echo esc_html( $item_count_text ); ?></span>
		</a>

		<?php
	}
}

if ( ! function_exists( 'the8_shop_dark_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function the8_shop_dark_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php the8_shop_dark_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}

/*------------------------------------*/
	//TOOL BAR
/*------------------------------------*/
remove_action('woocommerce_before_shop_loop','woocommerce_result_count',20);

if ( ! function_exists( 'the8_shop_dark_toolbar_start' ) ) {
	/**
	 * Insert the opening anchor tag for products in the loop.
	 */
	function the8_shop_dark_toolbar_start() {
		echo '<div class="the8-shop-dark-toolbar clearfix">';
	}
	
	add_action('woocommerce_before_shop_loop','the8_shop_dark_toolbar_start',20);
}

/**
* Add Custom Result Counter.
*/
function the8_shop_dark_result_count() {
	get_template_part( 'woocommerce/result-count' );
}
add_action('woocommerce_before_shop_loop','the8_shop_dark_result_count',30);


if ( ! function_exists( 'the8_shop_dark_header_toolbar_end' ) ) {
	/**
	 * Insert the opening anchor tag for products in the loop.
	 */
	function the8_shop_dark_header_toolbar_end() {
		echo '<div class="clearfix"></div></div>';
	}
	
	add_action('woocommerce_before_shop_loop','the8_shop_dark_header_toolbar_end',30);
}


if ( ! function_exists( 'the8_shop_dark_loop_shop_per_page' ) ) :
	/**
	 * Returns correct posts per page for the shop
	 *
	 * @since 1.0.0
	 */
	function the8_shop_dark_loop_shop_per_page() {
		
		$posts_per_page = ( isset( $_GET['products-per-page'] ) ) ? sanitize_text_field( wp_unslash( $_GET['products-per-page'] ) ) : get_theme_mod( 'shopstore_woo_shop_posts_per_page',12 );

		if ( $posts_per_page == 'all' ) {
			$posts_per_page = wp_count_posts( 'product' )->publish;
		}
		
		return $posts_per_page;
	}
	add_filter( 'loop_shop_per_page', 'the8_shop_dark_loop_shop_per_page', 20 );
endif;

/*------------------------------------*/
	//PRODUCT LOOP
/*------------------------------------*/


/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function the8_shop_dark_woocommerce_loop_columns() {
	return 4;
}
add_filter( 'loop_shop_columns', 'the8_shop_dark_woocommerce_loop_columns' );


if ( ! function_exists( 'the8_shop_dark_thumbnail_before' ) ) {

	function the8_shop_dark_thumbnail_before(){
		echo '<div class="product-image">';
	}
	add_action( 'woocommerce_before_shop_loop_item_title','the8_shop_dark_thumbnail_before',5 );
}
	add_action( 'woocommerce_before_shop_loop_item_title','woocommerce_template_loop_rating',10 );
add_action( 'woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_link_open',15 );

if ( ! function_exists( 'the8_shop_dark_loop_product_thumbnail' ) ) {
	
	/**
	 * Get the product thumbnail for the loop.
	 */
	function the8_shop_dark_loop_product_thumbnail() {
		global $product;
		$attachment_ids   = $product->get_gallery_image_ids();
			if( isset( $attachment_ids[0] ) && $attachment_ids[0] != "" ) {
			
				$img_tag = array(
				'class'         => 'woo-entry-image-secondary',
				'alt'           => get_the_title(),
				);
				
				echo '<figure class="hover_hide">'. wp_kses_post(woocommerce_get_product_thumbnail()) . wp_get_attachment_image( $attachment_ids[0], 'shop_catalog', '', $img_tag ) .'</figure>';

			}else{
				echo '<figure>'.wp_kses_post(woocommerce_get_product_thumbnail()).'</figure>';	
			}
		
	}
	add_action( 'woocommerce_before_shop_loop_item_title','the8_shop_dark_loop_product_thumbnail',30 );
	
}

if ( ! function_exists( 'the8_shop_dark_thumbnail_after' ) ) {

	function the8_shop_dark_thumbnail_after(){
		echo '</div>';
	}
	add_action( 'woocommerce_before_shop_loop_item_title','the8_shop_dark_thumbnail_after',90 );
}
add_action( 'woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_link_close',99 );

if ( ! function_exists( 'the8_shop_dark_shop_loop_content_before' ) ) {

	/**
	 * end the product content wrap
	 */
	function the8_shop_dark_shop_loop_content_before() {
		echo '<div class="product_wrap">';
	}
	add_action( 'woocommerce_shop_loop_item_title', 'the8_shop_dark_shop_loop_content_before', 5 );
}

if ( ! function_exists( 'the8_shop_dark_shop_loop_item_title' ) ) {

	/**
	 * Show the product title in the product loop. By default this is an h4.
	 */
	function the8_shop_dark_shop_loop_item_title() {
		echo '<h4 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">' . esc_html( get_the_title() ) . '</h4>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	add_action( 'woocommerce_shop_loop_item_title', 'the8_shop_dark_shop_loop_item_title', 10 );
}


if ( ! function_exists( 'the8_shop_dark_shop_loop_content_after' ) ) {

	/**
	 * end the product content wrap
	 */
	function the8_shop_dark_shop_loop_content_after() {
		echo '</div>';
	}
	add_action( 'woocommerce_after_shop_loop_item', 'the8_shop_dark_shop_loop_content_after', 999);
}



if ( ! function_exists( 'the8_shop_dark_before_quantity_input_field' ) ) {
	/**
	 * before quantity.
	 *
	 *
	 * @return $html
	 */
	function the8_shop_dark_before_quantity_input_field() {
		echo '<button type="button" class="plus"><i class="bi bi-plus"></i></button>';
	}
	add_action( 'woocommerce_before_quantity_input_field','the8_shop_dark_before_quantity_input_field',10);
	
	
}

if ( ! function_exists( 'the8_shop_dark_after_quantity_input_field' ) ) {
	/**
	 * after quantity.
	 *
	 *
	 * @return $html
	 */
	function the8_shop_dark_after_quantity_input_field() {
		echo '<button type="button" class="minus"><i class="bi bi-dash"></i></button>';
	}
	add_action( 'woocommerce_after_quantity_input_field','the8_shop_dark_after_quantity_input_field',10);
}

add_action( 'the8_shop_dark_single_product_countdown', 'the8_shop_dark_single_product_countdown',  );

function the8_shop_dark_single_product_countdown() {
    global $product;

    // Ensure we have a product object
    if ( ! $product || ! $product->is_type( 'simple' ) && ! $product->is_type( 'variable' ) ) {
        return;
    }

    // Get the sale end date
    $sale_end = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );

    if ( $product->is_on_sale() && $sale_end ) {
        $formatted_date = date( 'Y-m-d H:i:s', (int) $sale_end ); // Ensure the date is formatted correctly
        echo '<div class="sale-countdown-wrapper">';
        echo '<div id="sale-countdown" class="countdown" data-end-date="' . esc_attr( $formatted_date ) . '" data-days="days" data-hours="hours" data-minutes="minutes" data-seconds="seconds">' . esc_attr( $formatted_date ) . '</div>';
        echo '</div>';
    } 
}
