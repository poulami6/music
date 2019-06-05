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
   
   $image = wp_get_attachment_image_src( get_post_thumbnail_id($currentpage_id), 'full' );
  
  $page_link = 'javascript:;';
  if('ms-playlist' == get_post_type()){
   $page_link = esc_url(get_permalink(2350));
  }else{
   $page_link = esc_url(get_permalink());
  }
  
?> 

   <div class="content-block album-block">
      <div class="block-table block-text">
         <div class="img-box">
         <?php if(!empty($image)){?>
            <img src="<?php echo $image[0];?>" alt="<?php echo $title;?>" width="168" height="160">
            <?php } ?>
         </div>
         <div class="text-holder">
            <div class="text-frame">
               <div class="tr">
                  <div class="heading">
                     <div class="title-holder">
                        <?php 
                               the_title( '<h1><a href="'.$page_link.'" >', '</a></h1>' );
                           ?>
                     </div>
                  </div>
               </div>
               <div class="bottom-panel">
                  <div class="panel-holder">
                     <div class="panel-frame">
                        <?php echo $content;?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
