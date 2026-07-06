<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$custom_css .= ':root {';
	if( !empty( the9_store_get_option( '__primary_color' ) ) ):
	   $custom_css .= '--primary-color:'. esc_attr( the9_store_get_option( '__primary_color' ) ).';';
	endif;
	if( !empty( the9_store_get_option( '__secondary_color' ) ) ):
	   $custom_css .= '--secondary-color:'. esc_attr( the9_store_get_option( '__secondary_color' ) ).';';
	   $custom_css .= '--alpha-color:'. esc_attr( __hex2rgba( the9_store_get_option( '__secondary_color' ),0.2) ).';';
	endif;
	if( !empty( the9_store_get_option( '__tertiary_color' ) ) ):
	   $custom_css .= '--tertiary-color:'. esc_attr( the9_store_get_option( '__tertiary_color' ) ).';';
	endif;
	if( !empty( the9_store_get_option( '__quaternary_color' ) ) ):
	   $custom_css .= '--quaternary-color:'. esc_attr( the9_store_get_option( '__quaternary_color' ) ).';';
	endif;

	if( !empty( the9_store_get_option('__navbar_link_color')['color'] ) ):
	   $custom_css .= '--nav-color:'. esc_attr( the9_store_get_option('__navbar_link_color')['color'] ).';';
	endif;
	if( !empty( the9_store_get_option('__navbar_link_color')['hover'] ) ):
	   $custom_css .= '--nav-h-color:'. esc_attr( the9_store_get_option('__navbar_link_color')['hover'] ).';';
	endif;
	if( !empty( the9_store_get_option('__navbar_link_color')['bg'] ) ):
	   $custom_css .= '--nav-h-bg:'. esc_attr( the9_store_get_option('__navbar_link_color')['bg'] ).';';
	endif;
	if( !empty(the9_store_get_option('__res_wrap_bg_color')) ){
		$custom_css .= '--res-nav-wrap-bg:'. esc_attr( the9_store_get_option('__res_wrap_bg_color') ).';';
	}
	if( !empty( the9_store_get_option('__res_navbar_link_color')['color'] ) ):
	   $custom_css .= '--res-nav-color:'. esc_attr( the9_store_get_option('__res_navbar_link_color')['color'] ).';';
	endif;
	if( !empty( the9_store_get_option('__res_navbar_link_color')['hover'] ) ):
	   $custom_css .= '--res-nav-h-color:'. esc_attr( the9_store_get_option('__res_navbar_link_color')['hover'] ).';';
	endif;
	if( !empty( the9_store_get_option('__res_navbar_link_color')['bg'] ) ):
	   $custom_css .= '--res-nav-bg:'. esc_attr( the9_store_get_option('__res_navbar_link_color')['bg'] ).';';
	endif;

$custom_css .= '}';

if( __bg_render(the9_store_get_option('__inx_site_bg_bg')) != '' ){
	$custom_css .= 'body{'.__bg_render(the9_store_get_option('__inx_site_bg_bg')).'!important;}';
}
if( the9_store_get_option('_site_layout') == 'fluid' ){
	$custom_css .= '.container{width: 100%!important; max-width: 100%!important;}';
}

if( !empty(the9_store_get_option('__topbar_bg')) ){
	$custom_css .= '.top-bar-wrap{background:'.esc_attr( the9_store_get_option('__topbar_bg') ).'!important;}';
}

if( !empty( the9_store_get_option('__topbar_color')['color'] ) ){

	$custom_css .= '.top-bar-wrap,.top-bar-wrap .container a,.top-bar-wrap .left-menu,.top-bar-wrap > ul > li:after,.top-bar-wrap .right-menu li ul a{color:'. esc_attr( the9_store_get_option('__topbar_color')['color'] ) .';}';

}
if( !empty( the9_store_get_option('__topbar_color')['hover'] ) ){

	$custom_css .= '.top-bar-wrap,.top-bar-wrap .container a:hover,.top-bar-wrap .right-menu li ul a:hover,.top-bar-wrap .right-menu li ul a:focus{color:'. esc_attr( the9_store_get_option('__topbar_color')['hover'] ) .';}';

}
if( !empty(the9_store_get_option('__navbar_bg_color')) ){
	$custom_css .= '#navbar{background:'.esc_attr( the9_store_get_option('__navbar_bg_color') ).'!important;}';
}
if( !empty(the9_store_get_option('__navbar_dropdown_bg')) ){
	$custom_css .= '#navbar ul ul{background:'.esc_attr( the9_store_get_option('__navbar_dropdown_bg') ).'!important;}';
}
if( !empty( the9_store_get_option('__sub_link_color')['color'] ) ):
	$custom_css .= '#navbar li li a{color:'. esc_attr( the9_store_get_option('__sub_link_color')['color'] ).';}';
endif;
if( !empty( the9_store_get_option('__sub_link_color')['hover'] ) ):
	$custom_css .= '#navbar li li a:hover, #navbar li li a:focus,#navbar li li.current-menu-item > a{color:'. esc_attr( the9_store_get_option('__sub_link_color')['hover'] ).';}';
endif;
if( !empty( the9_store_get_option('__sub_link_color')['bg'] ) ):
	$custom_css .= '#navbar li li a:hover, #navbar li li a:focus,#navbar li li.current-menu-item > a{background:'. esc_attr( the9_store_get_option('__sub_link_color')['bg'] ).';}';
endif;

if( !empty( the9_store_get_option('__navbar_typography') ) ){

	$nav_fonts 		= the9_store_get_option('__navbar_typography');
	$sub_menu		= the9_store_get_option('__navbar_typography');
	$custom_css 	.= '#navbar .navigation-menu > li > a,#navbar .navigation-menu li li > a{'.__font_render( $nav_fonts ).'}';

}
if( !empty(the9_store_get_option('__navbar_link_color')['color']) ){
	$custom_css .= '#masthead.style_1 #navbar ul > li{ border-right: 1px solid '.esc_attr(__hex2rgba(the9_store_get_option('__navbar_link_color')['color'],0.1) ).'!important;}';
}


$option_block  	   = !empty( the9_store_get_option('_page_header_style') ) ? the9_store_get_option('_page_header_style') : 'default';
$option_bg 	  	   = !empty( the9_store_get_option('_page_hero_bg') ) ? the9_store_get_option('_page_hero_bg') : '';
$option_color  	   = !empty( the9_store_get_option('_page_hero_color') ) ? the9_store_get_option('_page_hero_color') : '';
$option_overlay_bg = !empty( the9_store_get_option('__page_overlay_bg') ) ? the9_store_get_option('__page_overlay_bg') : '';
$page_text_align   = !empty( the9_store_get_option('__page_text_align') ) ? the9_store_get_option('__page_text_align') : '';
$page_hero_height  = !empty( the9_store_get_option('_page_hero_height') ) ? the9_store_get_option('_page_hero_height') : '';


$meta 			= get_post_meta( get_the_ID(), '__gs_header_meta', true );

if ( function_exists('is_shop') && is_shop() ){
	$meta 		= get_post_meta( wc_get_page_id('shop'), '__gs_header_meta', true );
}
if( is_home() ){
	global $wp_query;
	$meta = get_post_meta( $wp_query->get_queried_object_id(), '__gs_header_meta', true );
}

if( !empty( get_queried_object()->term_id ) ){

	$meta = get_term_meta( get_queried_object()->term_id, '__gs_common_cat', true );
	if( !empty($meta['_cat_hero_bg']["background-image"]["url"]) ){
		$meta['_meta_page_style'] = 'hero-block';
	}

}

if( !empty($meta) ){
	
	$option_bg 	  	      = ( !empty($meta['_cat_hero_bg']["background-image"]["url"]) || !empty($meta['_cat_hero_bg']["background-color"]) ) ? $meta['_cat_hero_bg'] : $option_bg;
	$option_block  	   = !empty( $meta['_meta_page_style'] ) ? 'hero-block' : 'default';
	$option_bg 	  	      = ( !empty($meta['_page_hero_bg']["background-image"]["url"]) || !empty($meta['_page_hero_bg']["background-color"]) ) ? $meta['_page_hero_bg'] : $option_bg;

	$option_color  	   = !empty( $meta['_page_hero_color'] ) ? $meta['_page_hero_color'] : $option_color;
}

if($option_block == 'hero-block'){
	if( !empty( __bg_render( $option_bg ) ) ){
		$custom_css .= '#static_header_banner{'. __bg_render( $option_bg ).'}';
	}
	if( !empty( $option_color['_primary'] ) ){
		$custom_css .= '#static_header_banner .content-text h1{ color:'.esc_attr( $option_color['_primary'] ).'}';
	}
	if( !empty( $option_color['_secondary'] ) ){
		$custom_css .= '#static_header_banner .post-meta-wrap, #static_header_banner .post-meta-wrap a, #static_header_banner .post-meta-wrap li, #static_header_banner .content-text{ color:'.esc_attr( $option_color['_secondary'] ).'}#static_header_banner ul.post-meta li::before{background:'.esc_attr( $option_color['_secondary'] ).'}';
	}
	if( !empty( $option_overlay_bg ) ){
		$custom_css .= '#static_header_banner:after{ background-color:'.esc_attr( $option_overlay_bg ).'}';
	}
	if( !empty( $page_text_align ) ){
		$custom_css .= '#static_header_banner .site-header-text-wrap,#static_header_banner .content-text{ text-align:'.esc_attr( $page_text_align ).'}';
	}
	if( !empty( $page_hero_height ) ){
		$custom_css .= '#static_header_banner{height:'. $page_hero_height .'vh;}';
	}
	if( !empty( $option_overlay_bg ) ){
		$custom_css .= '#static_header_banner:before{background:'. $option_overlay_bg .';}';
	}
}

if( !empty( the9_store_get_option('__hero_text_color')['heading'] ) ):
	$custom_css .= '#be-home-slider h1, #gs-home-page-hero .content-text h1{color:'. esc_attr( the9_store_get_option('__hero_text_color')['heading'] ).';}';
endif;

if( !empty( the9_store_get_option('__hero_text_color')['text'] ) ):
	$custom_css .= '#be-home-slider .sub-heading-text{color:'. esc_attr( the9_store_get_option('__hero_text_color')['text'] ).';}';
endif;

if( !empty( the9_store_get_option('__hero_overlay_bg') ) ):
	$custom_css .= '#home-slider .slide-wrap{background:'. esc_attr( the9_store_get_option('__hero_overlay_bg') ).';}';
endif;

if( !empty( the9_store_get_option('__navbar_typography') ) ){
	$custom_css 	.= '#be-home-slider h1, #gs-home-page-hero .content-text h1{'.__font_render( the9_store_get_option('__slider_typography') ).'}';
}
if( !empty( the9_store_get_option('__heading_font') ) ){
	$custom_css 	.= '#static_header_banner .content-text h1{'.__font_render( the9_store_get_option('__heading_font') ).'}';

}
if( !empty( the9_store_get_option( '__home_hero_height' ) ) ):
   $custom_css .= '#be-home-slider .owl-item, #be-home-slider .slider-item, #gs-home-page-hero, #gs-home-page-hero .content-text,#gs-home-page-hero .content-text,#gs-home-page-hero,#home-slider,#home-slider .slide-item{height:'. esc_attr( the9_store_get_option( '__home_hero_height' ) ).'vh;}';
endif;
if( !empty( the9_store_get_option('__woo_loop_column_sm') ) && the9_store_get_option('__woo_loop_column_sm') != 1 ){
		$col_width = (100 / absint( the9_store_get_option('__woo_loop_column_sm') ) ) - 4 ;
		$custom_css .= '@media only screen and (min-width: 601px) and (max-width: 1024px){ .woocommerce ul.products li.product, .woocommerce-page ul.products li.product{width: '.absint($col_width).'% !important; float: left!important; clear: none!important; margin:2%!important;}}';
}
if( !empty( the9_store_get_option('__woo_loop_column') ) && the9_store_get_option('__woo_loop_column') != 1 ){
		$col_width_P = (100 / absint( the9_store_get_option('__woo_loop_column') ) ) - 3 ;

		$custom_css .= '@media screen and (max-width: 600px) {
			.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{
				width: '.absint($col_width_P).'% !important;
				clear: none!important;
				margin:1%!important;
				display: inline-block!important;
				vertical-align: top!important;
			}
		}';
}
if( the9_store_get_option('__woo_product_thumbnail') == 'right' ){
	$custom_css 	.= '@media only screen and (min-width: 800px){.woocommerce #content div.product div.images, .woocommerce div.product div.images, .woocommerce-page #content div.product div.images, .woocommerce-page div.product div.images{ float: right!important;}.woocommerce #content div.product div.summary, .woocommerce div.product div.summary, .woocommerce-page #content div.product div.summary, .woocommerce-page div.product div.summary{float: left!important;}}';
}
if( the9_store_get_option('__woo_product_thumbnail') == 'block' ){
	$custom_css 	.= '@media only screen and (min-width: 800px){.woocommerce #content div.product div.images, .woocommerce div.product div.images, .woocommerce-page #content div.product div.images, .woocommerce-page div.product div.images{ float: none!important; width: 100%!important;}.woocommerce #content div.product div.summary, .woocommerce div.product div.summary, .woocommerce-page #content div.product div.summary, .woocommerce-page div.product div.summary{float: none!important; width: 100%!important;}}';
}
if( the9_store_get_option('__woo_product_thumbnail') == 'hide' ){
	$custom_css 	.= '@media only screen and (min-width: 800px){.woocommerce #content div.product div.summary, .woocommerce div.product div.summary, .woocommerce-page #content div.product div.summary, .woocommerce-page div.product div.summary{float: none!important; width: 100%!important;}}';
}
if( !empty( the9_store_get_option('__footer_bg') ) ){
	$custom_css .= '#colophon.site-footer{'. __bg_render( the9_store_get_option('__footer_bg') ).'}';
}

if( !empty( the9_store_get_option('__footer_color') ) ){
	$custom_css .= '#colophon.site-footer .widget-title,#footer h3.widget-title span{color:'. the9_store_get_option('__footer_color') .'!important;}';

}
if( !empty( the9_store_get_option('__footer_link')['color'] ) ){
	$custom_css .= '#colophon.site-footer a,#colophon.site-footer,#colophon.site-footer .site_info,#colophon.site-footer .social-links a:focus{color:'. esc_attr( the9_store_get_option('__footer_link')['color'] ) .'!important;}';
}
if( !empty( the9_store_get_option('__footer_link')['hover'] ) ){

	$custom_css .= '#colophon.site-footer a:hover,#colophon.site-footer a:focus,#colophon.site-footer li:before,#colophon.site-footer .social-links a{color:'. esc_attr( the9_store_get_option('__footer_link')['hover'] ) .'!important;}';
	$custom_css .='#colophon.site-footer .social-links a:hover,#colophon.site-footer .social-links a:focus{background:'. esc_attr( the9_store_get_option('__footer_link')['hover'] ) .'!important;}';
}
if( !empty( the9_store_get_option('__widgets_heading_font') ) ){
	$custom_css .='.wp-block-heading,.widget-title,#secondary .wp-block-group__inner-container h2{'.__font_render( the9_store_get_option('__widgets_heading_font') ).'}';
}

if( !empty( the9_store_get_option('__content_font') ) ):
	$custom_css .= 'body,#colophon.site-footer{'.  __font_render( the9_store_get_option('__content_font') ).'!important;};';
endif;
if( !empty( the9_store_get_option('__heading_tags') ) ):
   $custom_css .= 'h1,h2,h3,h4,h5,h6,#review_form .comment-reply-title{'.  __font_render( the9_store_get_option('__heading_tags')).';}';
endif;

if( !empty( the9_store_get_option('_copyrights_bg') ) ):
   $custom_css .= '#colophon.site-footer .site_info{background:'. the9_store_get_option('_copyrights_bg').';}';
endif;

if( !empty( the9_store_get_option('__site_container_width') ) ):
   $custom_css .= '.container-xl, .container-lg, .container-md, .container-sm, .container, .elementor-section.elementor-section-boxed > .elementor-container,.elementor-container{max-width:'. the9_store_get_option('__site_container_width').'px!important;}';
endif;


