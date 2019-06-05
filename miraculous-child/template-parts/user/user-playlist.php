<?php
   $user_id = get_current_user_id();
   $playlist_key = get_users_playlist($user_id);
?>
<div class="tab-item" id="tab-my-playlist">
   <div class="content-block my-playlist-block">
      <div class="section-header">
         <h2>My Playlist</h2>
         <div class="cell">
            <!-- <div class="sort-by">
               <strong class="ttl">Sort by:</strong>
               <select>
                  <option>Last View</option>
                  <option>Lorem</option>
                  <option>Ipsum</option>
               </select>
            </div> -->
            <form action="" class="search-field" method="get">
               <fieldset>
                  <input type="text" name="playlist" placeholder="Search" value="<?php echo isset($_GET['playlist']) ? $_GET['playlist'] : ''; ?>">
                  <button type="button"><i class="icon-magnify"></i> Search</button>
               </fieldset>
            </form>
         </div>
      </div>
      <ol class="albums-list">
      <?php 
            if( !isset($playlist_key['msg'])):

              if(isset($_GET['playlist']) && $_GET['playlist']!=''){
                $search = strtolower(preg_quote($_GET['playlist'], '~')); // don't forget to quote input string!
                $playlist_key = preg_grep('~' . $search . '~', array_map('strtolower', $playlist_key));
              }

              foreach ($playlist_key as $key => $playlist_val) :
                $playlist_data = explode('_',$playlist_val);
                $playlist_name = str_replace("-"," ",$playlist_data[3]);
                $playlist_songs = get_user_meta($user_id,$playlist_val,true);
      ?>
         <li>
            <div class="title">
               <strong class="name"><?php echo ucwords($playlist_name);?></strong>
               <div class="cell">
                  <span class="number totla_song_<?php echo $playlist_data[3];?>" total-song="<?php echo !empty($playlist_songs) ? count($playlist_songs) : 0;?>"><?php echo !empty($playlist_songs) ? count($playlist_songs) : 0;?>  Songs</span>
                  <!-- <a href="javascript:;" class="button ms_remove_user_playlist" data-list="<?php echo $playlist_data[3];?>">DELETE</a> -->
                  <a href="javascript:;" class="button ms_remove_user_playlist" data-list="<?php echo $playlist_data[3];?>">DELETE</a>
                  <a href="#" class="button opener">VIEW</a>
               </div>
            </div>
            <div class="slide">
               <div class="albums-table">
               <?php if(!empty($playlist_songs)){?>
                  <div class="tr head">
                     <div class="cell">Songs</div>
                     <div class="cell"></div>
                     <div class="cell">TIME</div>
                     <div class="cell"></div>
                  </div>
                  <ol class="row-group">
                  <?php 
                          foreach ($playlist_songs as $song_key => $playlist_song) {

                            $song_image = wp_get_attachment_image_src(get_post_thumbnail_id($playlist_song), 'thumbnail', false );

                            $data_type = '';
                            if('ms-albums' == get_post_type($playlist_song)){
                              $data_type = 'album';
                            }else if('ms-music' == get_post_type($playlist_song)){
                              $data_type = 'music';
                            }else if('ms-artists' == get_post_type($playlist_song)){
                              $data_type = 'artist';
                            }

                          $ms_album_post_meta_option = '';
                          if( function_exists('fw_get_db_post_option') ):
                          $ms_album_post_meta_option = fw_get_db_post_option($playlist_song);
                          endif;
                          

                          $attach_meta = array();
                          $mpurl = get_post_meta($playlist_song, 'fw_option:mp3_full_songs', true);
                          if($mpurl) {
                          $attach_meta = wp_get_attachment_metadata( $mpurl['attachment_id'] );
                          }
                    ?>
                     <li class="tr musicid-<?php echo $playlist_song;?>">
                        <div class="cell cell-title">
                           <div class="ttl">
                              <strong class="name"><?php echo get_the_title($playlist_song);?></strong>
                              <img src="<?php echo $song_image[0];?>" alt="album photo" width="26" height="26">
                           </div>
                        </div>
                        <div class="cell">
                           <a href="javascript:;" class="button delete delete_user_playlist_music" musicid="<?php echo $playlist_song;?>"  data-list="<?php echo $playlist_data[3];?>">DELETE</a>
                        </div>
                        <div class="cell">
                           <span class="time"><?php echo (isset($attach_meta['length_formatted'])) ? $attach_meta['length_formatted'] : " "; ?></span>
                        </div>
                        <div class="cell">
                           <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo $playlist_song;?>" data-musictype="<?php echo $data_type;?>">
                            <span class="play_all btn-play">Play All</span>
                            <span class="pause_all btn-pause">Pause</span>
                           </a>
                        </div>
                     </li>
                     <?php } ?>
                  </ol>
                  <?php }else{?>
                    <p class="no-playlist"><?php echo ucwords($playlist_name);?> Playlist is Empty</p>
                  <?php }?>
               </div>
            </div>
         </li>
      <?php endforeach; else:?>
        <li>
            <div class="title">
               <strong class="name no-playlist">Playlist not available</strong>
            </div>
         </li>
      <?php endif;?>
      </ol>
      <!-- <div class="paging-holder">
         <ul class="paging">
            <li class="prev"><a href="#">&laquo; Prev</a></li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><strong>3</strong></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">6</a></li>
            <li class="next"><a href="#">Next &raquo;</a></li>
         </ul>
      </div> -->
   </div>
</div>