<?php
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
      <div class="block-table block-text eventpage-custom">
      <?php if(!empty($thum_image)):?>
        
            <img class="event-img" src="<?php echo esc_url($thum_image); ?>" alt="<?php the_title_attribute(); ?>" width="168" height="160">
        
        <?php endif;?>
         

        <?php 
             if(is_singular()){
               the_title( '<h1>', '</h1>' );
             }else{
               the_title( '<h1><a href="'. esc_url( get_permalink() ) .'" >', '</a></h1>' );
             }
           ?>
           <a href="<?php echo $previous;?>" class="button button-danger">Go Back</a>
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

		<?php
		$book_now_link = get_field('book_now_link',get_the_id());
			if($book_now_link!=''){
		?>
		<a href="<?php echo $book_now_link;?>" class="button button-danger">Book Now</a>
		<?php }?>
      </div>
   </div>
</div>