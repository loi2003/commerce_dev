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
class the8_shop_dark_Footer_Layout{
	/**
	 * Function that is run after instantiation.
	 *
	 * @return void
	 */
	public function __construct() {
		
		add_action('the8_shop_dark_site_footer', array( $this, 'site_footer_container_before' ), 5);
		add_action('the8_shop_dark_site_footer', array( $this, 'site_footer_widgets' ), 10);
		add_action('the8_shop_dark_site_footer', array( $this, 'site_footer_info' ), 80);
		add_action('the8_shop_dark_site_footer', array( $this, 'site_footer_container_after' ), 998);
		

		add_action('wp_footer', array($this,'search_bar_load_footer'),9999 );
		add_action('wp_footer', array($this,'pine_push_sidebar'),9999 );
		add_action('wp_footer', array($this,'the8_shop_site_preloader'),9999 ); 
	}
	
	/**
	* the8-shop-dark foter conteinr before
	*
	* @return $html
	*/
	public function site_footer_container_before (){
		
		$html = ' <footer id="colophon" class="site-footer">';
						
		$html = apply_filters( 'the8_shop_dark_footer_container_before_filter',$html);		
				
		echo wp_kses( $html, $this->alowed_tags() );
		
						
	}
	
	/**
	* Footer Container before
	*
	* @return $html
	*/
	function site_footer_widgets(){
		if ( is_active_sidebar( 'footer-1' ) ) { ?>
         <div class="footer_widget_wrap">
         <div class="container">
            <div class="row the8-shop-dark-flex">
                <?php dynamic_sidebar( 'footer-1' ); ?>
            </div>
         </div>  
         </div>
        <?php }
	}
	
	
	/**
	* the8-shop-dark foter conteinr after
	*
	* @return $html
	*/
	public function site_footer_info (){
		$text ='';
		$html = '<div class="site_info"><div class="container">
					<div class="row">';
			$html .= '<div class="col-6">';
			
			if( get_theme_mod('copyright_text') != '' ) 
			{
				$text .= esc_html(  get_theme_mod('copyright_text') );
			}else
			{
				/* translators: 1: Current Year, 2: Blog Name  */
				$text .= sprintf( esc_html__( 'Copyright &copy; %1$s %2$s. All Right Reserved.', 'the8-shop-dark' ), date_i18n( _x( 'Y', 'copyright date format', 'the8-shop-dark' ) ), esc_html( get_bloginfo( 'name' ) ) );
			}
			$html  .= apply_filters( 'the8_shop_dark_footer_copywrite_filter', $text );

			$html .= apply_filters(
			    'the8_shop_dark_dev_info',
			    '<span class="dev_info">' . sprintf(
			    	/* translators: 1: developer website, 2: WordPress url  */
			        esc_html__( '%1$s by %2$s.', 'the8-shop-dark' ),
			        '<a href="' . esc_url( 'https://athemeart.com/downloads/the8-shop-pro/' ) . '" target="_blank">' . esc_html_x( 'The8 Shop Dark', 'credit - theme', 'the8-shop-dark' ) . '</a>',
			        '<a href="' . esc_url( __( 'https://athemeart.com', 'the8-shop-dark' ) ) . '" target="_blank" rel="nofollow">' . esc_html_x( 'aThemeArt', 'credit to developer', 'the8-shop-dark' ) . '</a>'
			    ) . '</span>'
			);

			$html .= '</div><div class="col-6 text-end">';
			$social = get_theme_mod( 'the8_shop_social', array() );
			
			if ( ! empty( $social ) && is_array( $social ) ) {
				 $html .= '<ul class="social-links">';
			    foreach ( $social as $icon => $url ) {
			        if ( ! empty( $url ) ) {
			            $html .= '<li><a href="' . esc_url( $url ) . '" target="_blank" rel="nofollow">';
			            $html .= '<i class="bi ' . esc_attr( $icon ) . '"></i>';
			            $html .= '</a></li>';
			        }
			    }
			    $html .= '</ul>';
			}
			$html .= '</div>';
		$html .= '</dev></div>
		  		</div>';
		echo wp_kses( $html, $this->alowed_tags() );
	}
	
	/**
	* the8-shop-dark foter conteinr after
	*
	* @return $html
	*/
	public function site_footer_container_after (){
		
		$html = '</footer>';
						
		$html = apply_filters( 'the8_shop_dark_footer_container_after_filter',$html);		
				
		echo wp_kses( $html, $this->alowed_tags() );
	
	}
	
	
	/**
	* the8-shop-dark foter conteinr after
	*
	* @return $html
	*/
	public function site_footer_back_top (){		
		$html = '<a id="backToTop" class="ui-to-top">'.esc_html__( 'BACK TO TOP', 'the8-shop-dark' ).'<i class="bi bi-arrow-right"></i></a>';				
		$html = apply_filters( 'the8_shop_dark_site_footer_back_top_filter',$html);		
				
		echo wp_kses( $html, $this->alowed_tags() );
	
	}
	
	function search_bar_load_footer(){
		echo '<div class="search-bar-modal" id="search-bar">
		<div class="search-bar-modal-inner">

		<button class="button appw-modal-close-button" type="button"><i class="bi bi-x"></i></button>';
			if( class_exists('APSW_Product_Search_Finale_Class_Pro') && class_exists( 'WooCommerce' ) ){

				do_action('apsw_search_bar_preview');
				
			}else if( class_exists('APSW_Product_Search_Finale_Class') && class_exists( 'WooCommerce' ) ){
				do_action('apsw_search_bar_preview');
			}else{
				get_search_form();
			}
		echo	'
		</div>
		</div>';
	}
	public function pine_push_sidebar(){
		if ( is_active_sidebar( 'fly-sidebar' ) ) {
		?>
		<div class="pine-push-sidebar">
			<button type="button" class="sidebar-close"><i class="bi bi-x-lg"></i></button><div class="wrap">
	      <?php dynamic_sidebar( 'fly-sidebar' ); ?></div>
		</div>
		<?php
		}
	}

	/**
	 * Output site preloader markup.
	 *
	 * - Displays preloader animation if enabled in theme options.
	 * - Shows custom loading text from settings.
	 * - Intended to be hooked into wp_body_open or header area.
	 */
	public function the8_shop_site_preloader() {
	    ?>
	    <div id="the8_preloader">
	        <div class="preloader-animation">
	            <div class="spinner"></div>
	            <div class="loading-text">
	                <?php echo esc_html__('Loading, please wait…','the8-shop-dark'); ?>
	            </div>
	        </div>

	        <div class="loader">
	            <div class="loader-section"><div class="bg"></div></div>
	            <div class="loader-section"><div class="bg"></div></div>
	            <div class="loader-section"><div class="bg"></div></div>
	            <div class="loader-section"><div class="bg"></div></div>
	        </div>
	    </div>
	    <?php
	}
	private function alowed_tags(){
		
		if( function_exists('the8_shop_dark_allowed_tags') ){ 
			return the8_shop_dark_allowed_tags(); 
		}else{
			return array();	
		}
		
	}
}

$the8_shop_dark_footer_layout = new the8_shop_dark_Footer_Layout();