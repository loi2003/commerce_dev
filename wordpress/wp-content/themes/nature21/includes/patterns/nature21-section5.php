<?php
/**
 * Latest Blog
 */
return array(
	'title'      => __( 'Latest Blog', 'nature21' ),
	'categories' => array( 'nature21' ),
	'blockTypes' => array( 'core/template-part/nature21' ),
	'content'    => '<!-- wp:group {"className":"nature21-blog-section","style":{"spacing":{"padding":{"top":"80px","bottom":"50px","left":"15px","right":"15px"}}},"backgroundColor":"background","layout":{"type":"constrained","contentSize":"1170px"}} -->
<div class="wp-block-group nature21-blog-section has-background-background-color has-background" style="padding-top:80px;padding-right:15px;padding-bottom:50px;padding-left:15px"><!-- wp:heading {"textAlign":"center","level":4,"style":{"color":{"text":"#66b406"},"typography":{"fontStyle":"normal","fontWeight":"600","fontSize":"18px"},"spacing":{"padding":{"bottom":"10px"}}},"fontFamily":"poppins"} -->
<h4 class="wp-block-heading has-text-align-center has-text-color has-poppins-font-family" style="color:#66b406;padding-bottom:10px;font-size:18px;font-style:normal;font-weight:600">Latest Blog</h4>
<!-- /wp:heading -->

<!-- wp:heading {"textAlign":"center","style":{"color":{"text":"#000b14"},"elements":{"link":{"color":{"text":"#000b14"}}},"typography":{"fontStyle":"normal","fontWeight":"600","fontSize":"41px"},"spacing":{"padding":{"bottom":"35px"}}},"fontFamily":"poppins"} -->
<h2 class="wp-block-heading has-text-align-center has-text-color has-link-color has-poppins-font-family" style="color:#000b14;padding-bottom:35px;font-size:41px;font-style:normal;font-weight:600">Exploring the Nature of Life <br>Blog &amp; Articles</h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"nature21-post-list","layout":{"type":"constrained"}} -->
<div class="wp-block-group nature21-post-list"><!-- wp:latest-posts {"postsToShow":2,"excerptLength":15,"displayPostDate":true,"displayFeaturedImage":true,"featuredImageAlign":"left","featuredImageSizeSlug":"large","addLinkToFeaturedImage":true,"style":{"typography":{"fontSize":"17px"}}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->',
);