<?php
/**
 * Header
 */
return array(
	'title'      => __( 'Header', 'nature21' ),
	'categories' => array( 'nature21' ),
	'blockTypes' => array( 'core/template-part/nature21' ),
	'content'    => '<!-- wp:group {"className":"nature21-header-area","style":{"spacing":{"padding":{"top":"45px","bottom":"0px","left":"0px","right":"0px"},"margin":{"top":"0px"}}},"layout":{"type":"constrained","contentSize":"1170px"}} -->
<div class="wp-block-group nature21-header-area" style="margin-top:0px;padding-top:45px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"18%","className":"nature21-logo","style":{"spacing":{"blockGap":"0"}}} -->
<div class="wp-block-column nature21-logo" style="flex-basis:18%"><!-- wp:group {"className":"nature21-logo","style":{"spacing":{"padding":{"top":"0px","bottom":"15px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group nature21-logo" style="padding-top:0px;padding-bottom:15px"><!-- wp:image {"lightbox":{"enabled":false},"id":1904,"sizeSlug":"full","linkDestination":"custom"} -->
<figure class="wp-block-image size-full"><a href="' . home_url() . '"><img src="' . get_template_directory_uri() . '/assets/images/logo.png" alt="" class="wp-image-1904"/></a></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"16%","className":"nature21-logo","style":{"spacing":{"blockGap":"0"}}} -->
<div class="wp-block-column nature21-logo" style="flex-basis:16%"><!-- wp:group {"className":"nature21-logo","style":{"spacing":{"padding":{"top":"5px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group nature21-logo" style="padding-top:5px"></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"66%","className":"nature21-menu-area"} -->
<div class="wp-block-column nature21-menu-area" style="flex-basis:66%"><!-- wp:group {"className":"nature21-menu","style":{"spacing":{"padding":{"top":"30px","right":"35px","left":"85px","bottom":"0px"}}},"layout":{"type":"constrained","justifyContent":"left"}} -->
<div class="wp-block-group nature21-menu" style="padding-top:30px;padding-right:35px;padding-bottom:0px;padding-left:85px"><!-- wp:navigation {"customTextColor":"#1c3f0f","overlayBackgroundColor":"background","overlayTextColor":"link","style":{"spacing":{"blockGap":"var:preset|spacing|60"}},"layout":{"type":"flex","justifyContent":"left"}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
);