<?php
/**
 * The Site Theme Header Class 
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package the8-shop-dark
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class the8_shop_dark_Header_Layout{
	/**
	 * Function that is run after instantiation.
	 *
	 * @return void
	 */
	public function __construct() {

		add_action('the8_shop_dark_header_layout_1_branding', array( $this, 'get_site_branding' ), 10 );
		add_action('the8_shop_dark_header_layout_1_navigation', array( $this, 'get_site_navigation' ), 10 );
		add_action('the8_shop_dark_site_header_icon', array( $this, 'get_site_header_icon' ), 10 );
		add_action('the8_shop_dark_site_header', array( $this, 'site_skip_to_content' ), 5 );
		add_action('the8_shop_dark_site_header', array( $this, 'site_header_wrap_before' ), 10 );
		add_action('the8_shop_dark_site_header', array( $this, 'site_header_layout' ), 30 );
		add_action('the8_shop_dark_site_header', array( $this, 'site_header_wrap_after' ), 999 );
		add_action('the8_shop_dark_site_header', array( $this, 'site_hero_sections' ), 9999 );
	}
	/**
	* @return $html
	*/
	function site_header_wrap_before(){
		
		$html = '<header id="masthead" class="site-header style_1 sticky-mode">';	
		
		echo wp_kses( $html , $this->alowed_tags() );
		
	}
	/**
	* @return $html
	*/
	function site_header_wrap_after(){
		
		$html = '</header>';	
		
		echo wp_kses( $html , $this->alowed_tags() );
		
	}
	/**
	* Container before
	*
	* @return $html
	*/
	function site_skip_to_content(){
		
		echo '<a class="skip-link screen-reader-text" href="#content">'. esc_html__( 'Skip to content', 'the8-shop-dark' ) .'</a>';
	}
	/**
	* Container before
	*
	* @return $html
	*/
	function site_header_layout(){
		?>
		<div class="d-flex responsive_block">
			
				<?php do_action('the8_shop_dark_header_layout_1_branding');?>
				<?php do_action('the8_shop_dark_header_layout_1_navigation'); ?>
				<div class="header_icon_wrap">
				<?php do_action('the8_shop_dark_site_header_icon'); ?>
				</div>
			
		</div>
		<?php		
	}
	/**
	* Get the Site logo
	*
	* @return HTML
	*/
	public function get_site_branding(){
		$html = '<div class="logo-wrap">';
		if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
			$html .= get_custom_logo();
		}else{
			$html .= '<h3><a href="'.esc_url( home_url( '/' ) ).'" rel="home" class="site-title">';
			$html .= get_bloginfo( 'name' );
			$html .= '</a></h3>';
		}
		$html .= '</div>';
		$html = apply_filters( 'get_site_branding_filter', $html );
		echo wp_kses( $html, $this->alowed_tags() );
	}
	
	/**
	* Get the Site Main Menu / Navigation
	*
	* @return HTML
	*/
	public function get_site_navigation (){
	?>
		<nav id="navbar" class="underline">
		<button class="the8-shop-dark-navbar-close"><i class="bi bi-x-lg"></i></button>
		<?php
			wp_nav_menu( array(
				'theme_location'    => 'menu-1',
				'depth'             => 3,
				'menu_class'  		=> 'the8-shop-main-menu navigation-menu',
				'container'			=> 'ul',
				'walker' 			=> new the8_shop_dark_navwalker(),
		        'fallback_cb'       => 'the8_shop_dark_navwalker::fallback',
			) );
		?>
		</nav>
    <?php	
	}
	/**
	* Get the Site Main Menu / Navigation
	*
	* @return HTML
	*/
	public function get_site_header_icon(){
	 ?>
	<ul class="header-icon d-flex justify-content-end">
	<?php if ( class_exists( 'WooCommerce' ) ) :?>
	<li class="box-icon-cart"><?php the8_shop_dark_woocommerce_cart_link();
				$instance = array(
						'title' => '',
					);
				echo '<div class="dropdown-box">';
				the_widget( 'WC_Widget_Cart', $instance );
				echo '</div>';
			 ?>
	</li>
	<?php endif;?>
	<li><button type="button" class="simple-btn search-modal"><i class="bi bi-search"></i></button></li>
	<?php if ( is_active_sidebar( 'fly-sidebar' ) ) :?>
	<li><button type="button" class="simple-btn" id="fly-sidebar-toggle"><i class="bi bi-filter-right"></i></button></li>
	<?php endif;?>
	<?php if ( class_exists( 'WooCommerce' ) ) :?>
	<li>
		<?php if ( is_user_logged_in() ) { ?>
			<button type="button" class="simple-btn login-btn-popup"><i class="bi bi-person-lines-fill"></i></button>
			<ul class="the8-shop-myaccount-endpoint">
			<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<li class="<?php echo esc_attr( wc_get_account_menu_item_classes( $endpoint ) ); ?>">	
			<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
			<span class="btn-animate-y"><span class="btn-animate-y-1"><?php echo esc_html( $label ); ?></span><span class="btn-animate-y-2" aria-hidden="true"><?php echo esc_html( $label ); ?></span></span>
			</a>
			</li>
			<?php endforeach; ?>
			</ul>
		<?php } 
		else { ?>
			<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_attr_e( 'Login / Register', 'the8-shop-dark' ); ?>"><i class="bi bi-person-lines-fill"></i></a>
		<?php } ?>

	</li>
	<?php endif;?>
	<li class="toggle-list"><button class="the8-shop-dark-rd-navbar-toggle" tabindex="0" autofocus="true"><i class="bi bi-toggles"></i></button></li>
	</ul>
	 <?php
	}
	
	public function get_site_breadcrumb (){
		if( function_exists('bcn_display') && ( !is_home() || !is_front_page())  ):?>
        	<div class="the8-shop-dark-breadcrumbs-wrap"><div class="container"><div class="row"><div class="col-md-12">
            <div class="the8-shop-dark-breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
                <?php bcn_display_list();?>
           </div></div></div></div>
            </div>
        <?php
		endif; 
	}
	/**
	* Get the hero sections
	*
	* @return HTML
	*/
	public function site_hero_sections(){
		if( is_404() ) return;
		//if ( (is_front_page()) ||  ) :
		if( ( is_front_page() && ! is_home() ) || ( is_home() && the8_shop_dark_get_option('__replace_blog_home') == true ) ) :
			if( is_active_sidebar( 'slider' ) ){
				dynamic_sidebar( 'slider' );
			}else{
				echo wp_kses( $this->homepage_static_banner() , $this->alowed_tags() );
			}
		else: 
		$header_image = get_header_image();

		if ( has_post_thumbnail() && is_singular() && ( !function_exists('is_product') || !is_product() ) ) :
			$post_thumbnail_id  = get_post_thumbnail_id( get_the_ID() );
			$header_image = wp_get_attachment_url( $post_thumbnail_id );
			
		endif;	
		?>
        	<?php if( !empty( $header_image ) ) : ?>
            <div id="static_header_banner" class="header-img" style="background-image: url(<?php echo esc_url( $header_image );?>); background-attachment: scroll; background-size: cover; background-position: center center;">
             <?php else: ?>
             <div id="static_header_banner">
            <?php endif;?>
		    	<div class="content-text">
		            <div class="container">
		               	<?php 
							echo '<div class="site-header-text-wrap">';
							if ( is_home() ) {
								if ( display_header_text() == true ){
									echo '<h1 class="page-title-text">';
									echo bloginfo( 'name' );
									echo '</h1>';
									echo '<p class="subtitle">';
									echo esc_html(get_bloginfo( 'description', 'display' ));
									echo '</p>';

								}
							}else if ( function_exists('is_shop') && is_shop() ){
								if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
									echo '<h1 class="page-title-text">';
									echo esc_html( woocommerce_page_title() );
									echo '</h1>';
								}
							}else if( function_exists('is_product_category') && is_product_category() ){
								echo '<h1 class="page-title-text">';
								echo esc_html( woocommerce_page_title() );
								echo '</h1>';
								echo '<p class="subtitle">';
								do_action( 'the8_shop_dark_archive_description' );
								echo '</p>';
								
							}elseif ( is_singular() ) {
								echo '<h1 class="page-title-text">';
									echo single_post_title( '', false );
								echo '</h1>';
								if( is_singular('post') ){
									$meta = array( 'avatar', 'author', 'date', 'category', 'comments' );
									do_action( 'the8_shop_dark_meta_info', $meta,' header_meta_info');
								}
							} elseif ( is_archive() ) {
								the_archive_title( '<h1 class="page-title-text">', '</h1>' );
								the_archive_description( '<p class="archive-description subtitle">', '</p>' );
							} elseif ( is_search() ) {
								echo '<h1 class="title">';
									printf( /* translators:straing */ esc_html__( 'Search Results for: %s', 'the8-shop-dark' ),  get_search_query() );
								echo '</h1>';
							} elseif ( is_404() ) {
								echo '<h1 class="display-1">';
									esc_html_e( 'Oops! That page can&rsquo;t be found.', 'the8-shop-dark' );
								echo '</h1>';
							}
							echo '</div>';
		               	?>
		            </div>
		        </div>
		    </div>
		<?php
		endif;
	}
	/**
	 * Add Banner Title.
	 * @since 1.0.0
	 */
	function homepage_static_banner(){
		$img_url = the8_shop_dark_get_option('__media_img_url');
		$html = '';
		if( !empty(the8_shop_dark_get_option('__banner_title')) || the8_shop_dark_get_option('__banner_desc')):
			if( !empty( $img_url ) ) : 
			$html .= '<div id="static_header_banner" class="header-img" style="background-image: url('.esc_url( $img_url ).'); background-attachment: scroll; background-size: cover; background-position: center center;">';
			else: 
			$html .= '<div id="static_header_banner">';
			endif;
				$html .= '<div class="content-text">
					<div class="container"><div class="site-header-text-wrap">';
				
				$html .= !empty(the8_shop_dark_get_option('__banner_title'))? '<h1 class="page-title-text">'.esc_html(the8_shop_dark_get_option('__banner_title')).'</h1>':'';

				$html .= !empty(the8_shop_dark_get_option('__banner_desc'))? '<div class="subtitle">'.esc_html(the8_shop_dark_get_option('__banner_desc')).'</div>':'';
				
				$html .= '</div></div>
				</div>					
			</div>';
			return $html;
		else:
		$header_image = get_header_image();
		if( !empty( $header_image ) ) : ?>
            <div id="static_header_banner" class="header-img" style="background-image: url(<?php echo esc_url( $header_image );?>); background-attachment: scroll; background-size: cover; background-position: center center;">
            <?php else: ?>
            <div id="static_header_banner">
            <?php endif;?>
		    	<div class="content-text">
		            <div class="container">
		               	<?php 
							echo '<div class="site-header-text-wrap">';
							if ( display_header_text() == true ){
								echo '<h1 class="page-title-text">';
								echo bloginfo( 'name' );
								echo '</h1>';
								echo '<p class="subtitle">';
								echo esc_html(get_bloginfo( 'description', 'display' ));
								echo '</p>';
							}
							echo '</div>';
		               	?>
		            </div>
		        </div>
		    </div>
		<?php
		endif;	
	}
	/**
	 * Add Banner Title.
	 *
	 * @since 1.0.0
	 */
	function hero_block_heading() {
		 echo '<div class="site-header-text-wrap">';
		
			if ( is_home() ) {
					echo '<h1 class="page-title-text">';
					echo bloginfo( 'name' );
					echo '</h1>';
					echo '<p class="subtitle">';
					echo esc_html(get_bloginfo( 'description', 'display' ));
					echo '</p>';
			}else if ( function_exists('is_shop') && is_shop() ){
				if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
					echo '<h1 class="page-title-text">';
					echo esc_html( woocommerce_page_title() );
					echo '</h1>';
				}
			}else if( function_exists('is_product_category') && is_product_category() ){
				echo '<h1 class="page-title-text">';
				echo esc_html( woocommerce_page_title() );
				echo '</h1>';
				echo '<p class="subtitle">';
				do_action( 'the8_shop_dark_archive_description' );
				echo '</p>';
				
			}elseif ( is_singular() ) {
				echo '<h1 class="page-title-text">';
					echo single_post_title( '', false );
				echo '</h1>';
			} elseif ( is_archive() ) {
				
				the_archive_title( '<h1 class="page-title-text">', '</h1>' );
				the_archive_description( '<p class="archive-description subtitle">', '</p>' );
				
			} elseif ( is_search() ) {
				echo '<h1 class="title">';
					printf( /* translators:straing */ esc_html__( 'Search Results for: %s', 'the8-shop-dark' ),  get_search_query() );
				echo '</h1>';
			} elseif ( is_404() ) {
				echo '<h1 class="display-1">';
					esc_html_e( 'Oops! That page can&rsquo;t be found.', 'the8-shop-dark' );
				echo '</h1>';
			}
		
		echo '</div>';
	}
	private function alowed_tags(){
		
		if( function_exists('the8_shop_dark_allowed_tags') ){ 
			return the8_shop_dark_allowed_tags(); 
		}else{
			return array();	
		}
		
	}
}



$the8_shop_dark_header_layout = new the8_shop_dark_Header_Layout();