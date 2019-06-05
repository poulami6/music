<?php
/**
 * miraculous comment form msg field below
 */
function miraculous_move_comment_form_below( $fields ) { 
    $comment_field = $fields['comment']; 
    unset( $fields['comment'] ); 
    $fields['comment'] = $comment_field; 
    return $fields; 
} 
add_filter( 'comment_form_fields', 'miraculous_move_comment_form_below' ); 

/**
 * miraculous comment list style
 */
function miraculous_comment_callback($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
	 
	switch( $comment->comment_type ) :
	
		case 'pingback' :
        case 'trackback' : ?>
            <li <?php comment_class(); ?> id="comment<?php comment_ID(); ?>">
            <div class="back-link"><?php comment_author_link(); ?></div>
        <?php break;
        default : 
		if ( 'div' === $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
			
		}
	   
		?>
         <<?php echo esc_html($tag); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID() ?>"><?php 

			if ( 'div' != $args['style'] ) { ?>

				<div id="div-comment-<?php comment_ID() ?>" class="comment-body ms_comment_section"><?php

			} ?>

				<div class="comment-author vcard comment_img"><?php 
					if ( $args['avatar_size'] != 0 ) {
						echo get_avatar( $comment, $args['avatar_size'] ); 
					} 
					?>

				</div><?php 

				if ( $comment->comment_approved == '0' ) { ?>
					<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.','miraculous'); ?></em><br/><?php 
				} ?>

				<div class="comment-meta commentmetadata comment_info">

					<div class="comment_head">
						<h3><?php printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>', 'miraculous' ), get_comment_author_link() ); ?></h3>

						<p><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><?php
						/* translators: 1: date, 2: time */
						printf( 

							esc_html__('%1$s at %2$s', 'miraculous'), 

							get_comment_date(),  

							get_comment_time() 

						); ?>

						</a><?php 

						edit_comment_link( esc_html__('(Edit)', 'miraculous'), '  ', '' ); ?></p>
					</div>

					<?php comment_text(); ?>
					<div class="reply comment_reply"><?php 

							comment_reply_link( 
								array_merge( 
									$args, 
									array( 
										'add_below' => $add_below, 
										'depth'     => $depth, 
										'max_depth' => $args['max_depth'] 
									) 
								) 
							); ?>
					</div>

				</div><?php 

			if ( 'div' != $args['style'] ) : ?>
				</div><?php 
			endif;
		break;
	endswitch;
}