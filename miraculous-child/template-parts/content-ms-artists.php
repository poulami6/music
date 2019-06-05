<?php
     $artist_id = get_the_id();
     $play_all = get_template_directory_uri().'/assets/images/svg/play_all.svg';
     $pause_all = get_template_directory_uri().'/assets/images/svg/pause_all.svg';
     $add_to_queue = get_template_directory_uri().'/assets/images/svg/add_q.svg';
     $more_img = get_template_directory_uri().'/assets/images/svg/more.svg';
     $user_id = get_current_user_id();
     $miraculous_theme_data = '';
       if (function_exists('fw_get_db_settings_option')):  
           $miraculous_theme_data = fw_get_db_settings_option();     
       endif; 
       if(!empty($miraculous_theme_data['miraculous_layout']) && $miraculous_theme_data['miraculous_layout'] == '2'):
           $more_img = get_template_directory_uri().'/assets/images/svg/more1.svg';
       endif;
     $currency = '';
       if(!empty($miraculous_theme_data['paypal_currency']) && function_exists('miraculous_currency_symbol')):
           $currency = miraculous_currency_symbol( $miraculous_theme_data['paypal_currency'] );
       endif;
     $musictype = 'artist';
     $list_type = 'music';
     $ms_artist_post_meta_option = '';
    if( function_exists('fw_get_db_post_option') ):
       $ms_artist_post_meta_option = fw_get_db_post_option();
    endif;

   
    $artist_albums = get_all_albums_post_name_for_artist(get_the_id());
    $total_ar_albums = count($artist_albums);

    $ar_albums_limit = 2;
    $artist_albums = !empty($artist_albums) ? array_slice($artist_albums,0,$ar_albums_limit) : array();
   
   $userid = get_current_user_id();
   $fav_artists = get_user_meta($userid, 'favourites_artists_lists'.$userid, true);
    $fav_class = '';
    $fav_title = '';
   if(!empty($fav_artists) && in_array($artist_id, $fav_artists)){
    $fav_class = 'icon_add';
    $fav_title = 'Remove';
   }else{
    $fav_class = 'icon_remove';
    $fav_title = 'Add';
   }
  
   $total_like = 0;
   $total_rate = '';
   $comments = get_approved_comments($artist_id);

    if ( $comments ) {
    $i = 0;
    $total = 0;
        foreach( $comments as $comment ){
            $rate = get_comment_meta( $comment->comment_ID, 'rating', true );
            if( isset( $rate ) && '' !== $rate ) {
                $i++;
                $total += $rate;
            }
        }

        if ( 0 === $i ) {
            
        } else {
            $total_rate =  round( $total / $i, 1 );
            $total_like = $i;
        }
    }
   

   $author_id = get_post_field( 'post_author', $artist_id );
   $author_details = get_user_by( 'id', $author_id );
   $user_roles = $author_details->roles;


   $table_name = $wpdb->prefix . "friends"; 
   $friend_rs = $wpdb->get_row("SELECT * FROM ".$table_name." WHERE FID = ".$author_id. " AND UID=".$userid);

$following_users = get_user_meta($userid, 'following_users'.$userid, true);
$follower_users = get_user_meta($author_id, 'follower_users'.$author_id, true);

    $image_uri = get_the_post_thumbnail_url ( get_the_id() );

      $user_avatar = get_avatar_url( $author_id);

  if($image_uri!=''){
     $artist_profile_img = $image_uri;
  }else{
     $artist_profile_img = $user_avatar;
  }




   ?>
<div id="content">
   <div class="section-header">
      <?php 
          if(is_singular()){
            the_title( '<h1>', '</h1>' );
          }else{
            the_title( '<h1><a href="'. esc_url( get_permalink() ) .'" >', '</a></h1>' );
          }
        ?>
      <div class="cell">
         <div class="rating-item">
            <div class="item-holder">
               <ol class="star-rating">
               <?php
               $rating_class = '';
                  for($i=1;$i<=5;$i++){
                    switch ($i) {
                      case 1:
                        $class="one-star";
                        break;
                      case 2:
                        $class="two-stars";
                        break;
                      case 3:
                        $class="three-stars";
                        break;
                      case 4:
                        $class="four-stars";
                        break;
                      case 5:
                        $class="five-stars";
                        break;
                      
                      default:
                        $class="";
                        break;
                    }
                    if($i <= $total_rate){
                      $rating_class = 'active';
                    }else{
                      $rating_class = '';
                    }
                    echo '<li class="'.$rating_class.'"><a href="javascript:;" class="'.$class.' give-rating" data-star="'.$i.'" data-postid="'.$artist_id.'">'.$i.'</a></li>';
                  }
               ?>
               </ol>
               <div class="info-popup">
                  <span class="overall"><?php echo $total_rate;?></span>
                  <span class="like-text"><i class="icon-star"></i><?php echo $total_like;?> Liked this</span>
               </div>
            </div>
         </div>
         <a href="javascript:;" class="btn-icon add_to_queue" data-musicid="<?php esc_html_e(get_the_id()); ?>" data-musictype="<?php esc_html_e($musictype); ?>" title="Add to queue"><i class="icon-wifi"></i></a>
         <a href="javascript:;" class="btn btn-danger favourite_artist" data-artistid="<?php echo esc_attr(get_the_id()); ?>" title="<?php echo esc_attr($fav_title); ?>">
         <span class="opt_icon">
         <span class="icon <?php echo esc_attr($fav_class); ?>"></span>
         </span>
         <?php  esc_html_e('Add to Favotires', 'miraculous'); ?>
         </a>

        <?php if($author_id!= $user_id){?>
         <?php if(isset($following_users) && !empty($following_users) && in_array($author_id, $following_users)  ): ?>
          <a href="javascript:;" class="btn btn-danger icon_unfollow" id="user-follow" data-follow="<?php echo $author_id;?>">UNFOLLOW</a>
        <?php else:?>
          <a href="javascript:;" class="btn btn-danger icon_follow" id="user-follow" data-follow="<?php echo $author_id;?>">FOLLOW</a>
        <?php endif;?>
        <?php } ?>

      </div>
   </div>
  
   <div class="row">
      <div class="col-8">
         <div class="content-block preview-block">
            <div class="preview-holder">
               <div class="image-holder">
                  <img src="<?php echo $artist_profile_img;?>" alt="photo" width="160" height="192">
               </div>
               <div class="text-holder">
                  <h2><?php echo $total_ar_albums;?> Albums</h2>
                  <?php the_excerpt(); ?>
                  <a href="javascript:;" class="artist-biography">View Full biography</a>
               </div>
            </div>
            <?php 

              if (!in_array( 'administrator', $user_roles, true ) ) { 

                if(is_user_logged_in()){ 

                  if($userid != $author_id){ 

              ?>
                  <a href="javascript:;" class="button send-message" data-receiver="<?php echo $author_id;?>" >Message</a>
              <?php 
                    }
                  }else{
              ?>
                 <a href="javascript:;" class="button" data-toggle="modal" data-target="#myModal1" >Message</a>
              <?php 
               
                  } 
                } 
              ?>

            <?php 
            if($author_details->user_login!='' && $author_id != $userid ){
              if(isset($friend_rs) && $friend_rs->status == 'Pending'){
                  $type = 'remove';
                  $class = 'remove-icon';
                  $text = 'Request Sent';
                }else if(isset($friend_rs) && $friend_rs->status == 'Confirmed'){
                  $type = 'remove';
                  $class = 'remove-icon';
                  $text = 'Remove Friend';
                }else if(isset($friend_rs) && $friend_rs->status == 'Denied'){
                  $type = 'remove';
                  $class = 'remove-icon';
                  $text = 'Remove Request';
                }else{
                  $type = 'add';
                  $class = 'add-icon';
                  $text = 'Add Friend';
                }
          ?>
          <a href="javascript:;" class="btn btn-danger <?php echo $class;?> add-remove-friend"  data-page="user" data-type="<?php echo $type;?>" data-fid="<?php echo $author_id;?>"><?php echo $text;?></a>
         <?php } ?>
            <div class="share-holder">
               <ul class="social-list">
                  <li class="facebook">
                     <a href="javascript:void(0);" class="ms_share_facebook" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(get_permalink(get_the_id())); ?>', 'Share', width='200', height='150' )">
                     <i class="icon-facebook"></i> Facebook
                     </a>
                  </li>
                  <li class="twitter">
                     <a href="javascript:void(0);" class="ms_share_twitter" onclick="window.open('https://twitter.com/intent/tweet?text=<?php echo get_the_title(); ?>&amp;url=<?php echo esc_url(get_permalink(get_the_id())); ?>&amp;via=<?php echo get_bloginfo( 'name' ); ?>' , 'Share', width='200', height='150' )">
                     <i class="icon-twitter"></i> Twitter
                     </a>
                  </li>
                  <li class="linkedin">
                     <a href="javascript:void(0);" class="ms_share_linkedin" onclick="window.open('https://www.linkedin.com/cws/share?url=<?php echo esc_url(get_permalink(get_the_id())); ?>', 'Share', width='200', height='150' )">
                     <i class="icon-linkedin"></i> LinkedIn
                     </a>
                  </li>
                  <li class="google-plus">
                     <a href="javascript:void(0);" class="ms_share_googleplus" onclick="window.open('https://plus.google.com/share?url=<?php echo esc_url(get_permalink(get_the_id())); ?>', 'Share', width='200', height='150' )">
                     <i class="icon-google-plus"></i> Google+
                     </a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
    <?php 
    
      if(is_singular()){ 

         $top_music_arg = array(
         'post_type'      => 'ms-music',
         'posts_per_page' => -1,
         'post_status'    => 'publish',
         'tax_query' => array(
                             array (
                                 'taxonomy' => 'music-type',
                                 'field' => 'slug',
                                 'terms' => 'top-musics',
                             )
                         ),
                          
         
         );
         
         $top_musics_query = new WP_Query($top_music_arg);
         $top_musics = $top_musics_query->posts;
         
         
         
         
         if(!empty($top_musics)){
         $musics_count = end($top_musics);
         ?>
      <div class="col-4">
         <section class="feature-section feature-gallery">
            <div class="title-box">
               <h2>Top Songs</h2>
            </div>
            <div class="gmask">
                
               <?php
               $i=0;
                  foreach ($top_musics as $music_key => $top_music) {
                  $music_artist_id = get_post_meta($top_music->ID, 'fw_option:music_artists', true);
                  if(isset($music_artist_id) && $music_artist_id!==''){
                    if(in_array($artist_id, $music_artist_id)){
                      $count = $i++;
                    if($count%5 == 0){
                  ?>
              <div class="slide">
                  <ol class="feature-list">
                  <?php } ?>
                     <li>
                        <a href="javascript:;" class="play_music" data-musicid="<?php echo $top_music->ID;?>" data-musictype="music" title="Add To Queue">
                           <div class="text-holder">
                              <strong class="name"><?php echo $top_music->post_title;?></strong>
                           </div>
                        </a>
                     </li>
                <?php if($count%5 == 4){?>
                </ol>
               </div>
                <?php }?>
               <?php  } }?>
               <?php } ?>
               
            </div>
         </section>
      </div>
      <?php  } } //wp_reset_postdata(); ?>
     

   </div>
  <?php if(is_singular()){ ?>
   <ul class="tabs-list">
      <li class="active"><a href="#tab-albums"><span>Top Albums</span></a></li>
      <li><a href="#tab-biography"><span>Biography</span></a></li>
      <li><a href="#tab-events"><span>Events</span></a></li>
      <li><a href="#tab-pictures"><span>Pictures</span></a></li>
   </ul>
   <div class="tab-content">
      <div class="tab-item" id="tab-albums">
         <div class="content-block">
            <section class="albums-section">
               <div class="section-header">
                  <h2>Albums</h2>
               </div>
               <input type="hidden" name="ar_albums_offset" id="ar_albums_offset" data-limit="<?php echo $ar_albums_limit;?>">
               <div id="ar_albums-content">
               <?php 
                  if(!empty($artist_albums)):
                    foreach ($artist_albums as $album_key => $artist_album) {
                    $album_image = wp_get_attachment_image_src( get_post_thumbnail_id($artist_album), 'thumbnail' );

                    $al_comments = get_approved_comments($artist_album);
                    $total_al_rate = '';
                    if ( $al_comments ) {
                    $i = 0;
                    $al_total = 0;
                        foreach( $al_comments as $al_comment ){
                            $al_rate = get_comment_meta( $al_comment->comment_ID, 'rating', true );
                            if( isset( $al_rate ) && '' !== $al_rate ) {
                                $i++;
                                $al_total += $al_rate;
                            }
                        }

                        if ( 0 === $i ) {
                            
                        } else {
                            $total_al_rate =  round( $al_total / $i, 1 );
                            
                        }
                    }

                  ?>
                
               <div class="album-item">
                  <div class="head-holder">
                     <h3><?php echo get_the_title($artist_album)?></h3>
                     <div class="cell">
                        <div class="menu-box">
                           <a href="#" class="btn-round btn-add"><i class="icon-star"></i> Open "add to" menu</a>
                           <div class="menu-drop">
                              <div class="drop-holder">
                                 <ul class="drop-list">
                                 <li><a href="javascript:;" class="favourite_albums" data-albumid="<?php echo $artist_album;?>">Add To Favorite</a></li>
                                 <li>
                                    <a href="javascript:;" class="ms_add_playlist" data-msmusic="<?php echo $artist_album;?>">Add To Playlist</a>
                                 </li>
                              </div>
                           </div>
                        </div>
                        <a href="#" class="button button-buy">BUY</a>
                     </div>
                  </div>
                  <div class="item-holder">
                     <div class="visual-holder">
                        <div class="img-box">
                           <img src="<?php echo $album_image[0];?>" alt="album image" width="168" height="160">
                        </div>
                        <div class="info">
                           <em class="date"><i class="icon-clock-o"></i> <?php echo get_the_date('Y',$artist_album);?></em>
                           <ol class="star-rating">
                           <?php
                              for($ali=1;$ali<=5;$ali++){
                                switch ($ali) {
                                  case 1:
                                    $al_class="one-star";
                                    break;
                                  case 2:
                                    $al_class="two-stars";
                                    break;
                                  case 3:
                                    $al_class="three-stars";
                                    break;
                                  case 4:
                                    $al_class="four-stars";
                                    break;
                                  case 5:
                                    $al_class="five-stars";
                                    break;
                                  
                                  default:
                                    $al_class="";
                                    break;
                                }

                                if($ali <= $total_al_rate){
                                  $al_rating_class = 'setted';
                                }else{
                                  $al_rating_class = '';
                                }

                                //echo '<li><a href="#" class="'.$al_class.'">'.$ali.'</a></li>';
                                echo '<li class="'.$al_rating_class.'"><a href="javascript:;" class="'.$al_class.' give-rating" data-star="'.$ali.'" data-postid="'.$artist_album.'">'.$ali.'</a></li>';
                              }
                           ?>
                              
                           </ol>
                        </div>
                     </div>
                     <ol class="playlist-item">
                        <?php
                           $ms_album_post_meta_option = '';
                           $length = 00;
                           $sec = 00;
                           
                           if( function_exists('fw_get_db_post_option') ):
                              $ms_album_post_meta_option = fw_get_db_post_option($artist_album);
                           endif;
                           
                           $album_songs = $ms_album_post_meta_option['album_songs'];
                           
                           if(!empty($album_songs)):
                           $i = 1;
                                    foreach($album_songs as $mst_music_option): 
                                      $attach_meta = array();
                                          $mpurl = get_post_meta($mst_music_option, 'fw_option:mp3_full_songs', true);
                                      if($mpurl) {
                                        $attach_meta = wp_get_attachment_metadata( $mpurl['attachment_id'] );
                                      }
                                      
                                      $music_image = wp_get_attachment_image_src( get_post_thumbnail_id($mst_music_option), 'full' );
                           
                                      $music_price = '';
                                        if(function_exists('fw_get_db_post_option')){
                                            $music_price_arr = fw_get_db_post_option($mst_music_option, 'music_type_options');
                                            if( !empty( $music_price_arr['premium']['single_music_price'] ) ){
                                                $music_price = $music_price_arr['premium']['single_music_price'];
                                            }
                                        }
                           
                              $artists_ids = $ms_album_post_meta_option['album_artists'];
                               $music_type = get_post_meta($mst_music_option, 'fw_option:music_type', true);
                               //echo '<pre>'; print_r(get_post_meta($mst_music_option));
                           
                               $am_comments = get_approved_comments($mst_music_option);
                                $total_am_rate = '';
                                if ( $am_comments ) {
                                $i = 0;
                                $am_total = 0;
                                    foreach( $am_comments as $am_comment ){
                                        $am_rate = get_comment_meta( $am_comment->comment_ID, 'rating', true );
                                        if( isset( $am_rate ) && '' !== $am_rate ) {
                                            $i++;
                                            $am_total += $am_rate;
                                        }
                                    }

                                    if ( 0 === $i ) {
                                        
                                    } else {
                                        $total_am_rate =  round( $am_total / $i, 1 );
                                        
                                    }
                                }
                           
                           ?>
                        <li>
                           <strong class="item-name"><a href="#"><?php echo get_the_title( $mst_music_option ); ?></a></strong>
                           <div class="cell">
                              <ol class="star-rating">

                                <?php
                                  for($ami=1;$ami<=5;$ami++){
                                    switch ($ami) {
                                      case 1:
                                        $am_class="one-star";
                                        break;
                                      case 2:
                                        $am_class="two-stars";
                                        break;
                                      case 3:
                                        $am_class="three-stars";
                                        break;
                                      case 4:
                                        $am_class="four-stars";
                                        break;
                                      case 5:
                                        $am_class="five-stars";
                                        break;
                                      
                                      default:
                                        $am_class="";
                                        break;
                                    }

                                    if($ami <= $total_am_rate){
                                      $am_rating_class = 'setted';
                                    }else{
                                      $am_rating_class = '';
                                    }
                                    echo '<li class="'.$am_rating_class.'"><a href="javascript:;" class="'.$am_class.' give-rating" data-star="'.$ami.'" data-postid="'.$mst_music_option.'">'.$ami.'</a></li>';
                                  }
                               ?>
                              </ol>
                              <!-- <a href="#" class="btn-round btn-edit"><i class="icon-pencil"></i> Edit</a> -->
                              <span class="time"><?php echo (isset($attach_meta['length_formatted'])) ? $attach_meta['length_formatted'] : " "; ?></span>
                              <div class="menu-box">
                                 <a href="#" class="btn-round btn-add"><i class="icon-star"></i> Open "add to" menu</a>
                                 <div class="menu-drop">
                                    <div class="drop-holder">
                                       <ul class="drop-list">
                                          <li>
                                             <a href="javascript:;" class="favourite_music" data-musicid="<?php echo $mst_music_option;?>">Add To Favorite</a>
                                          </li>
                                          <li>
                                             <a href="javascript:;" class="ms_add_playlist" data-msmusic="<?php echo $mst_music_option;?>">Add To Playlist</a>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                              <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo esc_attr($mst_music_option); ?>" data-musictype="music">
                              <span class="play_all btn-play">Play All</span>
                              <span class="pause_all btn-pause">Pause</span>
                              </a>
                           </div>
                        </li>
                        <?php 
                           $i++; 
                           endforeach; 
                           endif;
                           ?>
                     </ol>
                  </div>
               </div>
               <?php } endif;?>
               </div>
            </section>
            <?php 
               if($total_ar_albums > $ar_albums_limit):
               ?>
            <div class="paging-holder">
              <ul class="paging albums-paging">
               <li class="prev"><a href="javascript:;">&laquo;</a></li>
               <?php
                  for($ali=1; $ali<= ceil($total_ar_albums/$ar_albums_limit); $ali++){
                  
                    if($ali==1){
                      $albums_current = 'class="ar-albums-pagination current"';
                    }else{
                      $albums_current = 'class="ar-albums-pagination"';
                    }
                  
                    $alo = $ali-1;
                    echo '<li><a href="javascript:;" '.$albums_current.' id="ar_album_pagin_'.$ali.'" data-pagin="'.$ali.'" data-offset="'.$alo*$ar_albums_limit.'" data-postid="'.$artist_id.'">'.$ali.'</a><li/>';
                    
                  
                  }
                  ?>
               <li class="next"><a href="javascript:;"> &raquo;</a></li>
            </ul>
            </div>
            <?php endif;?>
         </div>
      </div>
      <div class="tab-item" id="tab-biography">
         <div class="content-block">
            <div class="biography-block">
               <div class="section-header">
                  <h2>Biography</h2>
               </div>
               <?php the_content(); ?>
            </div>
         </div>
      </div>
      <div class="tab-item" id="tab-events">
         <div class="content-block">
            <div class="section-header">
               <h2>Events</h2>
            </div>
            <div class="events-items">

            <?php

             
              
              
              $arg = array(
              'posts_per_page'=>-1,
              'post_type'=>'event',
              'post_status' => 'publish',
              'orderby'     => 'title', 
              'order'       => 'ASC',
              'meta_query' => array(
                                  array(
                                          'key'     => 'event_artist',
                                          'value'   => serialize(strval($artist_id)),
                                          'compare' => 'LIKE'
                                      )
                                  ),
              
              );

              $event_query = new WP_Query($arg);
              $events = $event_query->posts;

              $event_ids = array();
              if(!empty($events)){
                foreach ($events as $event_key => $event) {
                  $event_ids[] = $event->ID;
                }
              }

              $all_events = $event_ids;

              $total_events = count($all_events);
              $event_limit = 1;
              $event_ids = !empty($event_ids) ? array_slice($event_ids,0,$event_limit) : array();
              
                   
           ?>
           <input type="hidden" name="all_events" id="all_events" value="<?php echo !empty($all_events) ? json_encode($all_events) : '';?>" >
            <input type="hidden" name="event_offset" id="event_offset" data-limit="<?php echo $event_limit;?>">

           <div id="tab_result">

             <?php 
             if(!empty($event_ids)){
                foreach ($event_ids as $key => $event_id) {
                 $event_image = wp_get_attachment_image_src( get_post_thumbnail_id($event_id), 'thumbnail' );
                  $content_post = get_post($event_id);
                  $content = $content_post->post_content;
                  $date = $content_post->post_date;
             ?>
             <div class="event-item">
                <div class="title-holder">
                   <h3><a href="<?php echo get_the_permalink($event_id);?>"><?php echo get_the_title($event_id);?></a></h3>
                   <em class="date-item"><i class="icon-clock-o"></i> <time datetime="<?php echo $date;?>"><?php echo get_timeago($date);?> </time></em>
                </div>
                <div class="img-box">
                <?php if(!empty($event_image)){?>
                   <img src="<?php echo $event_image[0];?>" alt="photo" width="168" height="160">
                  <?php } ?>
                </div>
                <div class="text-holder">
                 <p><?php echo wp_trim_words($content, 40, '...' ); ?></p>
                   <a href="<?php echo get_the_permalink($event_id);?>" class="button">View Event</a>
                </div>
             </div>
             <?php

                }
              }else{
                echo '<p class="no-found">No events found.</p>';;
              }  
            ?>

           </div>
               <?php 
                           
              if(!empty($event_ids) && $total_events > count($event_ids)):
            ?>
            <div class="paging-holder">
              <ul class="paging news-paging">
                 <li class="prev"><a href="JavaScript:void(0);">&laquo;</a></li>
                 <?php
                    for($ei=1; $ei<= ceil($total_events/$event_limit); $ei++){
                      
                    
                      if($ei==1){
                        $event_current = 'class="eventpagination current"';
                      }else{
                        $event_current = 'class="eventpagination"';
                      }
                    
                      $eo = $ei-1;
                      echo '<li><a href="JavaScript:void(0);" '.$event_current.' id="event_pagin_'.$ei.'" data-pagin="'.$ei.'" data-offset="'.$eo*$event_limit.'">'.$ei.'</a><li/>';
                      
                    }
                    ?>
                 <li class="next"><a href="JavaScript:void(0);"> &raquo;</a></li>
              </ul>
            </div>
            <?php endif;?>
              
            </div>
            
         </div>
      </div>
      <div class="tab-item" id="tab-pictures">
         <div class="content-block">
            <div class="section-header">
               <h2>Pictures</h2>
            </div>
            <?php 

              $post_author_id = get_post_field( 'post_author', get_the_id());

              $user_meta=get_userdata($post_author_id);
              $user_roles = $user_meta->roles;
              

              if(isset($user_roles) && in_array('administrator', $user_roles)){
                 $gallery_images =  get_field('artist_gallery',get_the_id());
                 $author_id = get_the_id();
                 $role="administrator";
              }else{

                $author_id = $post_author_id;
                $args =array( 'post_type' => 'attachment', 'post_status' => 'inheret', 'author' => $author_id);
                $gallery = new WP_Query( $args );
                $gallery_images =  $gallery->posts;
                $role="";
              }

              
               $totla_gallery = count($gallery_images);
               $gallery_limit = 3;
               $gallery_images = !empty($gallery_images) ? array_slice($gallery_images,0,$gallery_limit) : array();
               
            ?>
            <input type="hidden" name="gallery_offset" id="gallery_offset" data-limit="<?php echo $gallery_limit;?>">
            <ul class="pictures-list" id="gallry-content">
               <?php if(!empty($gallery_images)):?>
               <?php 
                  foreach ($gallery_images as $key => $gallery_image) {

                    if(isset($user_roles) && in_array('administrator', $user_roles)){
                       $image_url = $gallery_image['url'];
                    }else{

                      $image_url = $gallery_image->guid;
                    }

                  ?>
               <li>
                  <a href="#">
                  <img src="<?php echo $image_url;?>" alt="photo" width="141" height="141">
                  </a>
               </li>
               <?php } ?>
            </ul>
            <?php 
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
   </div>
  <?php } ?>
</div>