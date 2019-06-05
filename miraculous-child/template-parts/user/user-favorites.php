<?php
   $userid = get_current_user_id();
   
   $artists = get_user_meta($userid, 'favourites_artists_lists'.$userid, true);
   $albums = get_user_meta($userid, 'favourites_albums_lists'.$userid, true);
   $songs = get_user_meta($userid, 'favourites_songs_lists'.$userid, true);
   $radios = get_user_meta($userid, 'favourites_radios_lists'.$userid, true);
   

   $totla_artist = count($artists);
   $totla_album = count($albums);
   $totla_song = count($songs);
   $totla_radio = count($radios);


   $artists_limit = 2;
   if(isset($_GET['t']) && $_GET['t']=='ar'){
     $artists = get_user_meta($userid, 'favourites_artists_lists'.$userid, true);
   }else{
     $artists = !empty($artists) ? array_slice($artists,0,$artists_limit) : array();
   }
   
   
   $albums_limit = 2;
   if(isset($_GET['t']) && $_GET['t']=='al'){
     $albums = get_user_meta($userid, 'favourites_albums_lists'.$userid, true);
   }else{
     $albums = !empty($albums) ? array_slice($albums,0,$albums_limit) : array();
   }
   
   $songs_limit = 2;
   
   if(isset($_GET['t']) && $_GET['t']=='m'){
     $songs = get_user_meta($userid, 'favourites_songs_lists'.$userid, true);
   }else{
     $songs = !empty($songs) ? array_slice($songs,0,$songs_limit) : array();
   }

   $radio_limit = 2;
   
   if(isset($_GET['t']) && $_GET['t']=='r'){
     $radios = get_user_meta($userid, 'favourites_radios_lists'.$userid, true);
   }else{
     $radios = !empty($radios) ? array_slice($radios,0,$radio_limit) : array();
   }
   
   
   if(isset($_GET['t']) && $_GET['t'] == 'ar'){
       $artist_tab = 'active';
       $album_tab = '';
       $song_tab = '';
   }else if(isset($_GET['t']) && $_GET['t'] == 'al'){
     $artist_tab = '';
     $album_tab = 'active';
     $song_tab = '';
   }else if(isset($_GET['t']) && $_GET['t'] == 'm'){
     $artist_tab = '';
     $album_tab = '';
     $song_tab = 'active';
   }else{
     $artist_tab = 'active';
     $album_tab = '';
     $song_tab = '';
   }
   
   ?>
<div class="tab-item" id="tab-my-favorites">
   <div class="content-block my-favorites-block">
      <div class="section-header">
         <h2>My Favorites</h2>
        
      </div>
      <ul class="inner-tabset">
         <li class="current_tb <?php echo $artist_tab;?>"><a href="#tab-favorites-artist">artists</a></li>
         <li class="current_tb <?php echo $album_tab;?>"><a href="#tab-favorites-albums">albums</a></li>
         <li class="current_tb <?php echo $song_tab;?>"><a href="#tab-favorites-tracks">tracks</a></li>
         <li class="current_tb"><a href="#tab-favorites-radio">radios</a></li>
      </ul>
      <div class="inner-tab-item" id="tab-favorites-artist">
        
         <?php if(!empty($artists)):?>
         <input type="hidden" name="artist_offset" id="artist_offset" data-limit="<?php echo $artists_limit;?>">
         <ol class="albums-list" id="artist-content">
            <?php
               foreach ($artists as $artist_key => $artist) :
               
                 $artist_music = get_all_music_post_name_for_artist($artist);
               ?>
            <li class="artist-<?php echo $artist;?>">
               <div class="title">
                  <strong class="name"><?php echo get_the_title($artist);?></strong>
                  <div class="cell">
                     <span class="number"><?php echo count($artist_music);?>  Songs</span>
                     <a href="#" class="button delete_favourite_artist" artistid="<?php echo $artist;?>">DELETE</a>
                     <a href="#" class="button opener">VIEW</a>
                  </div>
               </div>
               <?php if(!empty($artist_music)):?>
               <div class="slide">
                  <div class="albums-table">
                     <ol class="row-group">
                        <?php 
                           foreach ($artist_music as $music_key => $music) {
                              $attach_music = array();
                                 $mpurl = get_post_meta($music, 'fw_option:mp3_full_songs', true);
                             if($mpurl) {
                               $attach_music = wp_get_attachment_metadata( $mpurl['attachment_id'] );
                             }
                             
                             $music_image = wp_get_attachment_image_src( get_post_thumbnail_id($music), 'thumbnails' );
                           ?>
                        <li class="tr">
                           <div class="cell cell-title">
                              <div class="ttl">
                                 <strong class="name"><?php echo get_the_title($music);?></strong>
                                 <?php if($music_image!=''){?>
                                 <img src="<?php echo $music_image[0];?>" alt="album photo" width="26" height="26">
                                 <?php } ?>
                              </div>
                           </div>
                           <!-- <div class="cell">
                              <a href="#" class="del-link">DELETE</a>
                              </div> -->
                           <div class="cell">
                              <span class="time"><?php echo (isset($attach_music['length_formatted'])) ? $attach_music['length_formatted'] : " "; ?></span>
                           </div>
                           <div class="cell">
                              <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo esc_attr($music); ?>" data-musictype="music">
                              <span class="play_all btn-play">Play All</span>
                              <span class="pause_all btn-pause">Pause</span>
                              </a>
                           </div>
                        </li>
                        <?php }?>
                     </ol>
                  </div>
               </div>
               <?php endif;?>
            </li>
            <?php endforeach;?>
         </ol>
         <?php else:?>
         <p class="no-found">Artist Not Found</p>
         <?php 
            endif;
            if(!empty($artists) && $totla_artist > count($artists)):
          ?>
         <div class="paging-holder">
            <ul class="paging artist-paging">
               <li class="prev"><a href="javascript:;">&laquo;</a></li>
               <?php
                  for($ai=1; $ai<= ceil($totla_artist/$artists_limit); $ai++){
                    
                  
                    if($ai==1){
                      $artist_current = 'class="artist-pagination current"';
                    }else{
                      $artist_current = 'class="artist-pagination"';
                    }
                  
                    $ao = $ai-1;
                    echo '<li><a href="javascript:;" '.$artist_current.' id="artist_pagin_'.$ai.'" data-pagin="'.$ai.'" data-offset="'.$ao*$artists_limit.'">'.$ai.'</a><li/>';
                    
                  }
                  ?>
               <li class="next"><a href="javascript:;"> &raquo;</a></li>
            </ul>
         </div>
         <?php endif;?>
      </div>
      <div class="inner-tab-item" id="tab-favorites-albums">
         
         <?php if(!empty($albums)):?>
         <input type="hidden" name="albums_offset" id="albums_offset" data-limit="<?php echo $albums_limit;?>">
         <ol class="albums-list" id="albums-content">
            <?php
               foreach ($albums as $album_key => $album) :
                if( function_exists('fw_get_db_post_option') ):
                   $ms_album_post_meta_option = fw_get_db_post_option($album);
                endif;
                
                $album_songs = $ms_album_post_meta_option['album_songs'];
               
               
               
               ?>
            <li class="albums-<?php echo $album;?>">
               <div class="title">
                  <strong class="name"><?php echo get_the_title($album);?></strong>
                  <div class="cell">
                     <span class="number"><?php echo count($album_songs);?>  Songs</span>
                     <a href="javascript:;" class="button delete_favourite_albums" albumsid="<?php echo $album;?>">DELETE</a>
                     <a href="#" class="button opener">VIEW</a>
                  </div>
               </div>
               <?php if(!empty($album_songs)):?>
               <div class="slide">
                  <div class="albums-table">
                     <div class="tr head">
                        <div class="cell">Songs</div>
                        <div class="cell"></div>
                        <div class="cell">TIME</div>
                        <div class="cell"></div>
                     </div>
                     <ol class="row-group">
                        <?php
                           //$i = 1;
                           foreach($album_songs as $mst_music_option): 
                             $attach_song = array();
                                 $mpurl = get_post_meta($mst_music_option, 'fw_option:mp3_full_songs', true);
                             if($mpurl) {
                               $attach_song = wp_get_attachment_metadata( $mpurl['attachment_id'] );
                             }
                             
                             $music_images = wp_get_attachment_image_src( get_post_thumbnail_id($mst_music_option), 'thumbnails' );
                           
                           
                           ?>
                        <li class="tr">
                           <div class="cell cell-title">
                              <div class="ttl">
                                 <strong class="name"><?php echo get_the_title($mst_music_option);?></strong>
                                 <?php if($music_images!=''){?>
                                 <img src="<?php echo $music_images[0];?>" alt="album photo" width="26" height="26">
                                 <?php } ?>
                              </div>
                           </div>
                           <!-- <div class="cell">
                              <a href="#" class="del-link">DELETE</a>
                              </div> -->
                           <div class="cell">
                              <span class="time"><?php echo (isset($attach_song['length_formatted'])) ? $attach_song['length_formatted'] : " "; ?></span>
                           </div>
                           <div class="cell">
                              <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo esc_attr($mst_music_option); ?>" data-musictype="music">
                              <span class="play_all btn-play">Play All</span>
                              <span class="pause_all btn-pause">Pause</span>
                              </a>
                           </div>
                        </li>
                        <?php 
                           //$i++; 
                           endforeach; 
                           
                           ?>
                     </ol>
                  </div>
               </div>
               <?php endif; ?>
            </li>
            <?php endforeach;?>
         </ol>
         <?php else:?>
         <p class="no-found">Album Not Found</p>
         <?php 
            endif;
            if(!empty($albums) && $totla_album > count($albums)):
            
            ?>
         <div class="paging-holder">
            <ul class="paging albums-paging">
               <li class="prev"><a href="javascript:;">&laquo;</a></li>
               <?php
                  for($ali=1; $ali<= ceil($totla_album/$albums_limit); $ali++){
                  
                    if($ali==1){
                      $albums_current = 'class="albums-pagination current"';
                    }else{
                      $albums_current = 'class="albums-pagination"';
                    }
                  
                    $alo = $ali-1;
                    echo '<li><a href="javascript:;" '.$albums_current.' id="album_pagin_'.$ali.'" data-pagin="'.$ali.'" data-offset="'.$alo*$albums_limit.'">'.$ali.'</a><li/>';
                    
                  
                  }
                  ?>
               <li class="next"><a href="javascript:;"> &raquo;</a></li>
            </ul>
         </div>
         <?php endif;?>
      </div>
      <div class="inner-tab-item" id="tab-favorites-tracks">
         
         <?php if(!empty($songs)): ?>
         <input type="hidden" name="song_offset" id="song_offset" data-limit="<?php echo $songs_limit;?>">
         <ol class="albums-list" id="song-content">
            <?php
               foreach ($songs as $song_key => $song) :
                 $ms_album_post_meta_option = '';
                 if( function_exists('fw_get_db_post_option') ):
                   $ms_album_post_meta_option = fw_get_db_post_option($song);
                 endif;
               
               
                 $attach_meta = array();
                 $mpurl = get_post_meta($song, 'fw_option:mp3_full_songs', true);
                 if($mpurl) {
                   $attach_meta = wp_get_attachment_metadata( $mpurl['attachment_id'] );
                 }
               ?>
            <li class="fav_music_<?php echo $song;?>">
               <div class="title">
                  <!-- <img src="<?php echo get_stylesheet_directory_uri();?>/images/img-album-01.jpg" alt="album photo" width="26" height="26"> -->
                  <strong class="name"><?php echo get_the_title($song);?></strong>
                  <div class="cell">
                     <span class="time"><?php echo (isset($attach_meta['length_formatted'])) ? $attach_meta['length_formatted'] : " "; ?></span>
                     <a href="javascript:;" class="button delete_favourite_music" musicid="<?php echo $song;?>">DELETE</a>
                     <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo $song;?>" data-musictype="music">
                     <span class="play_all btn-play">Play All</span>
                     <span class="pause_all btn-pause">Pause</span>
                     </a>
                  </div>
               </div>
            </li>
            <?php endforeach;?>
         </ol>
         <?php else:?>
         <p class="no-found">Song Not Found</p>
         <?php 
            endif;
            if(!empty($songs) && $totla_song > count($songs)):
            ?>
         <div class="paging-holder">
            <ul class="paging">
               <li class="prev"><a href="javascript:;">&laquo;</a></li>
               <?php
                  for($i=1; $i<= ceil($totla_song/$songs_limit); $i++){
                    if($i==1){
                      $current = 'class="song-pagination current"';
                    }else{
                      $current = 'class="song-pagination"';
                    }
                    $o = $i-1;
                    echo '<li><a href="javascript:;" '.$current.' id="song_pagin_'.$i.'" data-pagin="'.$i.'" data-offset="'.$o*$songs_limit.'">'.$i.'</a><li/>';
                    
                  
                  }
                  ?>
               <li class="next"><a href="javascript:;"> &raquo;</a></li>
            </ul>
         </div>
         <?php endif;?>
      </div>
      <div class="inner-tab-item" id="tab-favorites-radio">
         
         <?php if(!empty($radios)): ?>
         <input type="hidden" name="radio_offset" id="radio_offset" data-limit="<?php echo $radio_limit;?>">
         <ol class="albums-list" id="radio-content">
            <?php
               foreach ($radios as $radio_key => $radio) :
                
               ?>
            <li class="fav_music_<?php echo $radio;?>">
               <div class="title">
                  <!-- <img src="<?php echo get_stylesheet_directory_uri();?>/images/img-album-01.jpg" alt="album photo" width="26" height="26"> -->
                  <strong class="name"><?php echo get_the_title($radio);?></strong>
                  <div class="cell">
                     
                     <a href="javascript:;" class="button delete_favourite_radio" musicid="<?php echo $radio;?>">DELETE</a>
                     <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo $radio;?>" data-musictype="radio">
                     <span class="play_all btn-play">Play All</span>
                     <span class="pause_all btn-pause">Pause</span>
                     </a>
                  </div>
               </div>
            </li>
            <?php endforeach;?>
         </ol>
         <?php else:?>
         <p class="no-found">Radio Not Found</p>
         <?php 
            endif;
            if(!empty($radios) && $totla_radio > count($radios)):
            ?>
         <div class="paging-holder">
            <ul class="paging">
               <li class="prev"><a href="javascript:;">&laquo;</a></li>
               <?php
                  for($ri=1; $ri<= ceil($totla_radio/$radio_limit); $ri++){
                    if($ri==1){
                      $radio_current = 'class="radio-pagination current"';
                    }else{
                      $radio_current = 'class="radio-pagination"';
                    }
                    $ro = $ri-1;
                    echo '<li><a href="javascript:;" '.$radio_current.' id="radio_pagin_'.$ri.'" data-pagin="'.$ri.'" data-offset="'.$ro*$radio_limit.'">'.$ri.'</a><li/>';
                    
                  
                  }
                  ?>
               <li class="next"><a href="javascript:;"> &raquo;</a></li>
            </ul>
         </div>
         <?php endif;?>
      </div>
   </div>
</div>