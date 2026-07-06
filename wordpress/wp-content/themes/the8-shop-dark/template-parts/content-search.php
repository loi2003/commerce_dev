<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package the8-shop-dark
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( array('the8-shop-dark-post-wrap') ); ?>>

 	 <?php
    /**
    * Hook - the8_shop_dark_posts_blog_media.
    *
    * @hooked the8_shop_dark_posts_formats_thumbnail - 10
    */
    //do_action( 'the8_shop_dark_posts_blog_media' );
    ?>
    <div class="post search-page">
               
		<?php
        /**
        * Hook - the8-shop-dark_site_content_type.
        *
		* @hooked site_loop_heading - 10
        * @hooked render_meta_list	- 20
		* @hooked site_content_type - 30
        */
        do_action( 'the8_shop_dark_site_content_type', array( 'date', 'category' ) );
        ?>
      
       
    </div>
    
</article><!-- #post-<?php the_ID(); ?> -->


