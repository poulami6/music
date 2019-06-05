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
   
   global $wp_query;
   
   $artist_id = get_field('news_of_artist',$post_id);

   
   
   if(!empty($artist_id)){
   $artist_id = $artist_id[0];
   $artist_image = wp_get_attachment_image_src( get_post_thumbnail_id($artist_id), 'thumbnail' );
   }
   
   $all_allbum = get_all_albums_post_name_for_artist($artist_id);
   $all_music = get_all_music_post_name_for_artist($artist_id);
   $photos = get_field('artist_gallery',$artist_id);
   $artist_photo = array();
   if(!empty($photos)){
   foreach ($photos as $key => $photo) {
      $artist_photo[] = $photo['url'];
   }
   }
   
   
   $total_album = isset($all_allbum) ? count($all_allbum) : 0;
   $total_song = isset($all_music) ? count($all_music) : 0;
   $total_photo = isset($artist_photo) ? count($artist_photo) : 0;
   
   $meta_query = array(array('key'=>'news_of_artist','value'=>serialize(strval($artist_id)),'compare'=>'LIKE'));

   $arg = array(
   'posts_per_page'=>-1,
   'post_type'=>'ms-news',
   'post_status' => 'publish',
   'orderby'     => 'modified',
   'order'       => 'DESC',
   'meta_query' => $meta_query,
   
   );
 
   $news_query = new WP_Query($arg);
   $news       = $news_query->posts;

   $news_ids = array();
   if(!empty($news)){
      foreach ($news as $news_key => $news_data) {
         $news_ids[] = $news_data->ID;
      }
   }


$totla_news = count($news_ids);
$news_limit = 1;
   
   $args = array('type'=> 'ms-news','child_of'=> 0,'parent'=> '','orderby'=> 'term_id','order' => 'ASC','hide_empty' => false,'hierarchical' => 1,'taxonomy' => 'news-type','pad_counts'=> false);
   
   $cats = get_categories( $args ); 
   
   
   ?> 
<div id="content">
   <div class="row">
      <div class="col-8">
         <div class="content-block news-subject">
            <h2 class="news-artist-name"><?php echo get_the_title($artist_id);?></h2>
            <div class="back-link">
               <a href="javascript:history.go(-1)" class="button button-danger">Go Back</a>
            </div>
            <?php if(!empty($artist_image)){?>
            <img src="<?php echo $artist_image[0]?>" alt="photo" width="420" height="215">
            <?php } ?>
            <p>For more information on this artist <a href="#">CLICK HERE</a></p>
         </div>
      </div>
      <div class="col-4">
         <section class="feature-section feature-gallery">
            <div class="title-box">
               <h2>Related</h2>
            </div>
            <div class="gmask">
               <div class="slide">
                  <ul class="feature-list">
                     <li>
                        <a href="#">
                           <div class="text-holder">
                              <strong class="name">Pictures</strong>
                              <p><?php echo $total_photo;?></p>
                           </div>
                        </a>
                     </li>
                     <li>
                        <a href="#">
                           <div class="text-holder">
                              <strong class="name">Albums</strong>
                              <p><?php echo $total_album;?></p>
                           </div>
                        </a>
                     </li>
                     <li>
                        <a href="#">
                           <div class="text-holder">
                              <strong class="name">Songs</strong>
                              <p><?php echo $total_song;?></p>
                           </div>
                        </a>
                     </li>
                  </ul>
               </div>
            </div>
         </section>
      </div>
   </div>
   <ul class="spotlight-list news-type-list">
      <li class="active"><a href="<?php echo get_the_permalink(get_the_id());?>"><span>Latest News</span></a></li>
      <?php 
         if(!empty($cats)){
            foreach ($cats as $news_key => $cat_news) {
      ?>
      <li class="newstype" id="<?php echo $cat_news->slug;?>" data-artistid="<?php echo $artist_id;?>"><a href="javascript:;"><span><?php echo $cat_news->name;?></span></a></li>
      <?php
            }
         }
      ?>
   </ul>
   <div class="tab-content">
      <div class="tab-item" id="tab-latest-news">
         <div class="content-block">
            <input type="hidden" name="all_news" id="all_news" value="<?php echo !empty($news_ids) ? json_encode($news_ids) : '';?>" data-page="news-details-page">

            <input type="hidden" name="news_offset" id="news_offset" data-limit="<?php echo $news_limit;?>">
            <div class="events-list" id="tab_result">
               <?php
               $news_ids = !empty($news_ids) ? array_slice($news_ids,0,$news_limit) : array();
                  if (!empty($news_ids)) :
                     foreach ($news_ids as $news_id_key => $news_id) :
                           $image = wp_get_attachment_image_src( get_post_thumbnail_id($news_id), 'thumbnail' );

                           if(empty($image)){
                              $image = wp_get_attachment_image_src( get_post_thumbnail_id($artist_id), 'thumbnail' );
                           }
                  ?>
               <article class="event">
                  <div class="title-holder">
                     <h3><a href="javascript:;"><?php echo get_the_title($news_id);?></a></h3>
                  </div>
                  <div class="visual-box">
                     <?php if(!empty($image)):?>
                     <div class="img-box">
                        <img src="<?php echo $image[0];?>" alt="photo" width="168" height="160">
                     </div>
                     <?php endif;?>
                     <!-- <strong class="title"><?php //echo get_the_title($artist_id);?></strong> -->
                     <em class="date-item"><i class="icon-clock-o"></i> <time datetime="<?php echo get_the_date('Y-m-d');?>"><?php echo get_the_date('M, Y',$news_id);?></time></em>
                  </div>
                  <div class="text-holder">
                     <p class="more"><?php echo get_the_content($news_id);?></p>
                  </div>
               </article>
               <?php 
                  endforeach;
               
                  //wp_reset_postdata();

                  else:
                     echo '<p class="no-found">No News Found.</p>';
                  endif;
               ?>
            </div>
            <?php 
                           
              if(!empty($news_ids) && $totla_news > count($news_ids)):
            ?>
            <div class="paging-holder">
              <ul class="paging news-paging">
                 <li class="prev"><a href="JavaScript:void(0);">&laquo;</a></li>
                 <?php
                    for($ai=1; $ai<= ceil($totla_news/$news_limit); $ai++){
                      
                    
                      if($ai==1){
                        $news_current = 'class="newspagination current"';
                      }else{
                        $news_current = 'class="newspagination"';
                      }
                    
                      $ao = $ai-1;
                      echo '<li><a href="JavaScript:void(0);" '.$news_current.' id="news_pagin_'.$ai.'" data-pagin="'.$ai.'" data-offset="'.$ao*$news_limit.'">'.$ai.'</a><li/>';
                      
                    }
                    ?>
                 <li class="next"><a href="JavaScript:void(0);"> &raquo;</a></li>
              </ul>
            </div>
            <?php endif;?>
         </div>
      </div>
   </div>
</div>