<?php
   // $miraculous_core = '';
   // if(class_exists('Miraculouscore')):
   //    $miraculous_core = new Miraculouscore();
   //    $miraculous_core->miraculous_albums();
     
   // endif;
   
   $previous = "javascript:history.go(-1)";
   if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
   }
   
   $currentpage_id = get_the_id();
   $user_id = get_current_user_id();
   $post_id = get_post($currentpage_id);
   
   
   $title        = $post_id->post_title;
   $content      = $post_id->post_content;
   
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
                        <?php 
                             if(is_singular()){
                               the_title( '<h1>', '</h1>' );
                             }else{
                               the_title( '<h1><a href="'. esc_url( get_permalink() ) .'" >', '</a></h1>' );
                             }
                           ?>
                        <strong class="sub-title"> <?php  ?> </strong>
                     </div>
                     <div class="cell">
                        <a href="<?php echo $previous;?>" class="button button-danger">Go Back</a>
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