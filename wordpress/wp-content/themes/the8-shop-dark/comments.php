<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package the8-shop-dark
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<div class="clearfix"></div>
<div id="comments" class="comments-area clearfix" >

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
        <div class="details-page-inner-box comment-meta">
		<h4 class="comments-title widget-title">
			<?php
			$the8_shop_dark_comment_count = get_comments_number();
			if ( '1' === $the8_shop_dark_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'the8-shop-dark' ),
					'<span>' . esc_html(  get_the_title() ) . '</span>'
				);
			} else {
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				printf( // WPCS: XSS OK.
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $the8_shop_dark_comment_count, 'comments title', 'the8-shop-dark' ) ),
					number_format_i18n( $the8_shop_dark_comment_count ),
					'<span>' . get_the_title() . '</span>'
				);
			}
			?>
		</h4><!-- .comments-title -->
		<?php the_comments_navigation(); ?>
		<ul class="comment-list">
			<?php
			wp_list_comments( array(
				'style'      => 'ul',
				'short_ping' => true,
				'callback' => 'the8_shop_dark_walker_comment',
			) );
			?>
		</ul><!-- .comment-list -->
		<?php
		the_comments_navigation();
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'the8-shop-dark' ); ?></p>
			<?php
		endif;
	?>
    </div>
    <?php
	endif; // Check for have_comments().
	$commenter = wp_get_current_commenter();
	$consent   = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
	$args = array(
	'fields' => apply_filters(
		'comment_form_default_fields', array(
			'author' =>'<div class="col-xl-4 col-lg-6 col-md-4 col-12">' . '<input id="author" placeholder="' . esc_attr__( 'Your Name', 'the8-shop-dark'  ) . '" name="author" type="text" value="' .
				esc_attr( $commenter['comment_author'] ) . '" size="30" />'.
				( $req ? '<span class="required">*</span>' : '' )  .
				'</div>'
				,
			'email'  => '<div class="col-xl-4 col-lg-6 col-md-4 col-12">' . '<input id="email" placeholder="' . esc_attr__( 'Your Email', 'the8-shop-dark'  ) . '" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
				'" size="30" />'  .
				( $req ? '<span class="required">*</span>' : '' ) 
				 .
				'</div>',
			'url'    => '<div class="col-xl-4 col-lg-6 col-md-4 col-12">' .
			 '<input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'the8-shop-dark' ) . '" type="text" value="' . esc_url( $commenter['comment_author_url'] ) . '" size="30" /> ' .
			
	           '</div>',
			'cookies'    =>  '<p class="comment-form-cookies-consent col-12"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" class="fas fa-check" type="checkbox" value="yes"' . $consent . ' />' . '<label for="wp-comment-cookies-consent">'.esc_html__( 'Save my name, email, and website in this browser for the next time I comment.','the8-shop-dark' ) .'</label></p>',
		)
	),
		'comment_field' =>  '<div class="col-12"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"  placeholder="' . esc_attr__( 'Comment', 'the8-shop-dark' ) . '">' .
		'</textarea></div>',
		'class_form'      => 'row',
		'submit_button' => '<button type="submit" class="btn theme-btn" id="submit-new"><span>'. esc_html__( 'Post Comment', 'the8-shop-dark' ) .'</span></button>',
		'title_reply_before'   => ' <h4 class="widget-title">',
		'title_reply_after'    => '</h4>',
		'comment_notes_before' => '<p class="comment-notes col-12">' . esc_html__( 'Your email address will not be published. Required fields are marked *.','the8-shop-dark' ) . '</p>',
		'comment_notes_after'  => '<div class="form-allowed-tags col-12"><div class="text-wrp">' ./* translators: 1: title. */ sprintf( esc_html__( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'the8-shop-dark' ), ' <code>' . allowed_tags() . '</code>' ) . '</div></div>',
		
);
	?>
    <div class="details-page-inner-box comment-form" >
    
    <?php comment_form( $args );?>
  
    </div>

</div><!-- #comments -->