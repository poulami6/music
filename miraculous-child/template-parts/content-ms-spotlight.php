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



$spotlight_image = wp_get_attachment_image_src( get_post_thumbnail_id($currentpage_id), 'full' );
  
?> 
<div id="content">
   <div class="content-block album-block">
      <div class="block-table block-text">
         <div class="text-holder">
            <div class="text-frame">
              <div class="heading">
                 <div class="title-holder">
                <?php 
                  if(is_singular()){
                    the_title( '<h1>', '</h1>' );
                  }else{
                    the_title( '<h1><a href="'. esc_url( get_permalink() ) .'" >', '</a></h1>' );
                  }
                ?>
                    
                    <strong class="sub-title">
                    <?php  echo get_the_term_list(get_the_id(), 'spotlight-type', '', ', ' );?>
                    </strong>
                 </div>
                 <div class="cell">
                    <a href="<?php echo $previous;?>" class="button button-danger">Go Back</a>
                 </div>
              </div>
            </div>
         </div>
      </div>
   </div>
   <?php if(is_singular()){?>
   <div class="content-block">
      <?php 
         $is_video = get_field('video_display',$currentpage_id);
         $video = get_field('video_link',$currentpage_id);
         if($is_video):
         ?>
      <div class="video-block">

         <?php echo $video;?>

      </div>
      <?php endif;?>
      <?php
         if ( comments_open() || get_comments_number() ) :
         ?>
      <div class="fb-plugin-holder">
         <div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="100%" data-numposts="10" data-order-by="social" data-colorscheme="light"></div>
      </div>
      <?php
         endif;
         ?>
   </div>
  <?php } ?>
</div>