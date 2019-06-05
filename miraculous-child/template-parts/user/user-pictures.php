<div class="tab-item" id="tab-my-lessons">
   <div class="content-block">
            <div class="section-header">
               <h2>Pictures</h2>
            </div>
            <?php 
               
               $author_id = get_current_user_id();

              $args =array( 'post_type' => 'attachment', 'post_status' => 'inheret', 'author' => $author_id,'post_mime_type' => 'image');

              $gallery = new WP_Query( $args );
              $gallery_images =  $gallery->posts;
              $role = '';
              
              $totla_gallery = count($gallery_images);
              $gallery_limit = 3;
              $gallery_images = !empty($gallery_images) ? array_slice($gallery_images,0,$gallery_limit) : array();
               
               ?>
            <input type="hidden" name="gallery_offset" id="gallery_offset" data-limit="<?php echo $gallery_limit;?>">

            <ul class="pictures-list" id="gallry-content">
               <?php if(!empty($gallery_images)):?>
               <?php 
                  foreach ($gallery_images as $key => $gallery_image) {
                   
                   
                  ?>
               <li>
                  <a href="#">
                  <img src="<?php echo $gallery_image->guid; ?>" alt="photo" width="141" height="141">
                  </a>
               </li>
               <?php }  ?>
            </ul>
            <?php

              else:
                echo '<p class="no-found">No pictures found </p>';
               endif;

               if($totla_gallery > $gallery_limit):
               ?>
            <div class="paging-holder">
               <ul class="paging artist-paging">
                  <li class="prev"><a href="javascript:;">&laquo;</a></li>
                  <?php
                     for($gl=1; $gl<= ceil($totla_gallery/$gallery_limit); $gl++){
                       
                     
                       if($gl==1){
                         $current_gallery = 'class="gallery-pagination current"';
                       }else{
                         $current_gallery = 'class="gallery-pagination"';
                       }
                     
                       $go = $gl-1;
                       echo '<li><a href="javascript:;" '.$current_gallery.' id="gallry_pagin_'.$gl.'" data-pagin="'.$gl.'" data-offset="'.$go*$gallery_limit.'" data-postid="'.$author_id.'"  data-role="'.$role.'">'.$gl.'</a><li/>';
                       
                     }
                     ?>
                  <li class="next"><a href="javascript:;"> &raquo;</a></li>
               </ul>
            </div>
            <?php endif;?>
    </div>
</div>