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
   $auther_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_id()), 'thumbnail' );
?> 
<div id="content">
   <div class="content-block">
      <?php 
        $tv_links = array();
         if( have_rows('cgm_tv') ):
                while ( have_rows('cgm_tv') ) : the_row();
                   $tv_links[] = get_sub_field('tv_links');
                endwhile;
            else :
         endif;
         if(!empty($tv_links)){
            $video_id = getYouTubeVideoId($tv_links[0]);
         }
      ?>
      <div class="video-block" id="video-link">
      <?php if($video_id!=''){?>
         <iframe width="640" height="360" src="https://www.youtube.com/embed/<?php echo $video_id;?>?rel=0;&autoplay=1&mute=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen include></iframe>
      <?php } ?>
        
         
      </div>
      
         <div class="items-table">
            <div class="row-group">
               <div class="tr main-row expanded">
                  <div class="title-cell">
                     <a href="javascript:;" class="fake-opener"> <?php the_title(); ?> <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                  </div>
               </div>
               <div class="tr slide-row">
                  <div class="cell">
                     <a href="#" class="slide-opener">Open info</a>
                     <div class="slide">
                        <div class="item-info">
                           <div class="holder-table">
                              <div class="img-box">
                                 <img src="<?php echo $auther_image[0];?>" alt="<?php the_title(); ?>" width="50" height="50">
                              </div>
                              <div class="text-holder">
                                 <div class="text-frame">
                                   <p class="more"><?php echo $content;?></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
     
      <div>
      <?php
         if(!empty($tv_links)){
            echo ' <ul class="media-list">';
            foreach ($tv_links as $key => $tv_link) {
               $videoid = getYouTubeVideoId($tv_link);
               $thumbnail="http://img.youtube.com/vi/".$videoid."/mqdefault.jpg";
         ?>
            <li id="<?php echo $videoid;?>">
               <a href="javascript:;" class="img-box showCgmTv" data-url="<?php echo $videoid;?>">
               <?php if(!empty($thumbnail)):?>
                  <img src="<?php echo $thumbnail;?>" alt="video image" width="150" height="142">
               <?php endif;?>
                  <span class="btn-play">Play</span>
               </a>
            </li>
         <?php
            }
          echo ' </ul>';  
         }
         
      ?>
         
      </div>
      
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
</div>