<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Miraculous
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
<div id="comments" class="comments-area">
   <?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<div class="ms_heading">
			<h1 class="comments-title">
				<?php
				$miraculous_comment_count = get_comments_number();
				if ( '1' === $miraculous_comment_count ) {
					/* translators: 1: title. */
					echo esc_html__( 'Comment (1)', 'miraculous' );
				} else {
					printf( // WPCS: XSS OK.
						/* translators: 1: comment count number, 2: title. */
						esc_html__( 'Comments (%1$s)', 'miraculous' ),
						number_format_i18n( $miraculous_comment_count )
					);
				}
				?>
			</h1><!-- .comments-title -->
		</div>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size' => 80,
				'callback'   => 'miraculous_comment_callback',
			) );
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'miraculous' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().
     ?>
     <!----Blog Comment Form---->
	<div class="blog_comments_forms">
	<?php
		$args = array(
		    'fields' => apply_filters(
		        'comment_form_default_fields', array(
                    'author' =>
		             '<div class="col-lg-6 col-md-6">
					   <div class="comment_input_wrapper">' .
		               '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
		               '" size="30" placeholder="'.esc_attr__('Your Name','miraculous').'" class="cmnt_field" />
					    </div>
					   </div>',
                    'email' =>
		              '<div class="col-lg-6 col-md-6">
					   <div class="comment_input_wrapper">' .
		              '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
		              '" size="30" placeholder="'.esc_attr__('Your Email','miraculous').'" class="cmnt_field" />
					   </div>
					  </div>'

		        )
		    ),
		    'comment_field' =>'<div class="col-lg-12 col-md-12">
		       <div class="comment_input_wrapper">'.
		    '<textarea id="comment" name="comment" class="cmnt_field" placeholder="'.esc_attr('Your Comment', 'miraculous').'" cols="45" rows="8" aria-required="true"></textarea>'.
		    '</div></div>',
		    'id_submit'	=> 'comment-submit',
			'class_submit'	=> 'submit ms_btn',
			'name_submit'	=> 'submit',
		   );
         comment_form($args);
        ?>
    </div>
</div><!-- #comments -->