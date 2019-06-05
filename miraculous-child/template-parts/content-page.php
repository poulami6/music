<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Miraculous
 */

$miraculous_page_data = '';
	if(function_exists('fw_get_db_post_option')): 
	    $miraculous_page_data = fw_get_db_post_option();   
	endif; 
	$theme_sidebar = '';
	if(!empty($miraculous_page_data['post-sidebar'])):
	    $theme_sidebar = $miraculous_page_data['post-sidebar'];
	else:
	    $theme_sidebar = esc_html__('right','miraculous');
	endif;
	if($theme_sidebar == 'right' || $theme_sidebar == 'left' ):
	    $thumb_w ='800';
	    $thumb_h = '500';
	else:
	    $thumb_w ='1200';
	    $thumb_h = '700';
	endif;
	if(has_post_thumbnail(get_the_ID())):
	    $ms_attachment_url = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()), 'full');
	    $thum_image = miraculous_aq_resize($ms_attachment_url, $thumb_w, $thumb_h,false);
	endif;	

?>
<div id="content">
   <div class="content-block album-block">
      <div class="block-table block-text">
      <?php if(!empty($thum_image)):?>
         <div class="img-box">
            <img src="<?php echo esc_url($thum_image); ?>" alt="<?php the_title_attribute(); ?>" width="168" height="160">
         </div>
        <?php endif;?>
         <div class="text-holder">
            <div class="text-frame">
               <div class="tr">
                  <div class="heading">
                     <div class="title-holder">
                        <?php   the_title( '<h1>', '</h1>' ); ?>
                     </div>
                  </div>
               </div>
               <div class="bottom-panel">
                  <div class="panel-holder">
                     <div class="panel-frame">
                        <?php
							the_content( sprintf(
								wp_kses(
									/* translators: %s: Name of current post. Only visible to screen readers */
									__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'miraculous' ),
									array(
										'span' => array(
											'class' => array(),
										),
									)
								),
								get_the_title()
							) );

						   wp_link_pages( array(
								'before'      => '<div class="page-links">' . __( 'Pages:', 'miraculous' ),
								'after'       => '</div>',
								'link_before' => '<span class="page-number">',
								'link_after'  => '</span>',
							) );
							$thum_image = $entryfooter = '';
							if(is_user_logged_in()):
							    $entryfooter = 'ms-entry-footer';
							else:
							    $entryfooter = '';
							endif;
						?> 
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>