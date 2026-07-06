<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package the8-shop-dark
 */
?>
<article data-aos="fade-up" id="post-<?php the_ID(); ?>" <?php post_class( array('the8-shop-dark-post-wrap') ); ?>>
 	<?php
    /**
    * Hook - the8_shop_dark_posts_blog_media.
    *
    * @hooked the8_shop_dark_posts_formats_thumbnail - 10
    */
    do_action( 'the8_shop_dark_posts_blog_media' );
    ?>
    <div class="post">
		<?php
        /**
        * Hook - the8-shop-dark_site_content_type.
        *
		* @hooked site_loop_heading - 10
        * @hooked render_meta_list	- 20
		* @hooked site_content_type - 30
        */
		$meta = array();
		if ( is_singular() ) :
				$meta = array();
		else :
			if( the8_shop_dark_get_option('blog_meta_hide') != true ){
				
				$meta = array( 'avatar', 'author', 'date', 'category', 'comments' );
			}
			$meta  	 = apply_filters( 'the8_shop_dark_blog_meta', $meta);
		 endif;
		 do_action( 'the8_shop_dark_site_content_type', $meta);
        ?>
    </div>
</article><!-- #post-<?php the_ID(); ?> -->