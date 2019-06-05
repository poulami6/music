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
   
   $album_artist_id = get_post_meta($currentpage_id, 'album_artists', true);
   
   $album_image = wp_get_attachment_image_src( get_post_thumbnail_id($currentpage_id), 'full' );
   // echo "<pre>";
   // print_r(get_post_meta(get_the_id()));
   
   $ar_label = '';
   if(!empty($atts['albums_label'])):
   $ar_label = $atts['albums_label'];
   endif;
   
   $ar_style = 'abstyle1';
   if(!empty($atts['albums_style'])):
   $ar_style = $atts['albums_style'];
   endif;
   
   $ar_download = '';
   if(!empty($atts['album_downloadable'])):
   $ar_download = $atts['album_downloadable'];
   endif;
   
   $ar_type = '';
   if(!empty($atts['albums_type'])):
   $ar_type = $atts['albums_type'];
   endif;
   
   $ar_number = 12;
   if(!empty($atts['albums_number'])):
   $ar_number = $atts['albums_number'];
   endif;
   
   $musictype = 'album';
   $list_type = 'music';
   
   $miraculous_theme_data = '';
   if (function_exists('fw_get_db_settings_option')):  
   $miraculous_theme_data = fw_get_db_settings_option();     
   endif;
   
   $currency = '';
   if(!empty($miraculous_theme_data['paypal_currency']) && function_exists('miraculous_currency_symbol')):
    $currency = miraculous_currency_symbol( $miraculous_theme_data['paypal_currency'] );
   endif;
        
   $user_id = get_current_user_id();
   $lang_data = get_option('language_filter_ids_'.$user_id);
   
   $fav_album_ids = '';
   
   if($user_id){
    $fav_album_ids = get_user_meta($user_id, 'favourites_albums_lists'.$user_id, true);
   }
   
   //if(!empty($atts['albums_type'])):
   //echo  $ar_type = $atts['albums_type'];
   //endif;
   
   if(isset($_POST['download_album'])){
      //print_r($_POST);
     // echo get_the_title($_POST['album_id']);
      miraculous_album_download($_POST['album_id']);
   }

   ?> 
<div id="content">
   <div class="content-block album-block">
      <div class="block-table block-text">
         <div class="img-box">
            <img src="<?php echo $album_image[0];?>" alt="<?php echo $title;?>" width="168" height="160">
         </div>
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
                        <strong class="sub-title">
                        <?php 
                           if(!empty($album_artist_id)){
                                foreach ($album_artist_id as $artist_id_key => $artist_id) {
                                    echo get_the_title($artist_id);
                                    if($artist_id_key != count( $album_artist_id ) -1){
                                      echo ', ';
                                    }
                                }
                            }
                           ?>
                        </strong>
                     </div>
                     <div class="cell">
                        <a href="<?php echo $previous;?>" class="button button-danger">Go Back</a>
                     </div>
                  </div>
               </div>
               <div class="bottom-panel">
                  <div class="panel-holder">
                     <div class="panel-frame">
                        <?php echo $content;?>
                        <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo get_the_id();?>" data-musictype="album">
                        <span class="play_all btn-play">Play All</span>
                        <span class="pause_all btn-pause">Pause</span>
                        </a>
                        <div class="menu-box">
                           <a href="#" class="btn-round btn-add"><i class="icon-star"></i> Open "add to" menu</a>
                           <div class="menu-drop">
                              <div class="drop-holder">
                                 <ul class="drop-list">
                                    <li><a href="javascript:;" class="favourite_albums" data-albumid="<?php echo get_the_id();?>">Add To Favorite</a></li>
                                    <li>
                                       <a href="javascript:;" class="ms_add_playlist" data-msmusic="<?php echo get_the_id();?>">Add To Playlist</a>

                           
                                      
                                       <!-- <ul>
                                          <li><a href="#"><i class="icon-note"></i> My Playlists</a></li>
                                          <li><a href="#"><i class="icon-note"></i> New Songs</a></li>
                                       </ul> -->
                                    </li>
                                 </ul>
                              </div>
                           </div>
                        </div>
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
            </div>
         </div>
      </div>
   </div>
   <div class="content-block">
      <div class="items-table">
         <div class="tr head">
            <div class="cell title"><?php esc_html_e('Title', 'miraculous'); ?></div>
            <div class="cell sub-title"><?php esc_html_e('Artist', 'miraculous'); ?></div>
            <div class="cell"></div>
            <div class="cell"><?php esc_html_e('Price', 'miraculous'); ?></div>
            <div class="cell"></div>
            <div class="cell"></div>
         </div>
         <div class="row-group">
            <?php
               $ms_album_post_meta_option = '';
               $length = 00;
               $sec = 00;
               
               if( function_exists('fw_get_db_post_option') ):
                  $ms_album_post_meta_option = fw_get_db_post_option(get_the_id());
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
               
                     ?>
            <div class="tr main-row expanded">
               <div class="cell title">
                  <a href="#" class="fake-opener">
                  <?php echo get_the_title( $mst_music_option ); ?>
                  </a>
               </div>
               <div class="cell sub-title">
                  <?php 
                     if(!empty($artists_ids)){
                          foreach ($artists_ids as $aid_key => $artists_id) {
                              echo get_the_title($artists_id);
                              if($aid_key != count( $artists_ids ) -1){
                                echo ', ';
                              }
                          }
                      }
                     ?>
               </div>
               <div class="cell">
                  <div class="menu-box">
                     <a href="#" class="btn-round btn-add"><i class="icon-star"></i> Open "add to" menu</a>
                     <div class="menu-drop">
                        <div class="drop-holder">
                           <ul class="drop-list">
                                    <li><a href="javascript:;" class="favourite_music" data-musicid="<?php echo $mst_music_option;?>">Add To Favorite</a></li>
                                    <li>
                                       <a href="javascript:;" class="ms_add_playlist" data-msmusic="<?php echo $mst_music_option;?>">Add To Playlist</a>
                                       <!-- <ul>
                                          <li><a href="#"><i class="icon-note"></i> My Playlists</a></li>
                                          <li><a href="#"><i class="icon-note"></i> New Songs</a></li>
                                       </ul> -->
                                    </li>
                                 </ul>
                        </div>
                     </div>
                  </div>
               </div>
               <?php if(empty($music_price)): ?>
               <div class="cell">
                  <strong class="price"><?php esc_html_e('Free', 'miraculous'); ?></strong>
               </div>
               <?php else: ?>
               <div class="cell">
                  <strong class="price"><?php printf( __('%s%s', 'miraculous'), $currency, $music_price ); ?>
                  </strong>
               </div>
               <?php endif; ?>
               <div class="cell">
                  <?php //if($music_type == 'free'):?>

                  <a href="javascript:;" class="ms_download button button-danger" data-msmusic="<?php echo esc_attr($mst_music_option); ?>">
                  Download
                  </a>
                  <?php //else:?>
                 <!--  <a href="#" class="button button-danger">
                  Buy Now
                  </a> -->
                  <?php //endif;?>
               </div>
               <div class="cell">
                  <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo esc_attr($mst_music_option); ?>" data-musictype="music">
                  <span class="play_all btn-play">Play All</span>
                  <span class="pause_all btn-pause">Pause</span>
                  </a>
               </div>
            </div>
            <div class="tr slide-row">
               <div class="cell">
                  <a href="#" class="slide-opener">Open info</a>
                  <div class="slide">
                     <div class="item-info">
                        <div class="holder-table">
                           <?php if(!empty($music_image)):?>
                           <div class="img-box">
                              <img src="<?php echo $music_image[0];?>" alt="<?php echo get_the_title( $mst_music_option ); ?>" width="168" height="160">
                           </div>
                           <?php endif;?>
                           <div class="text-holder">
                              <div class="text-frame">
                                 <div class="tr">
                                    <ul class="download-list">
                                       <li>
                                          <div class="cell">
                                             <dl>
                                                <dt>Song:</dt>
                                                <dd><?php echo get_the_title( $mst_music_option ); ?></dd>
                                             </dl>
                                          </div>
                                          <?php if(!empty($music_price)): ?>
                                          <div class="btn-cell">
                                             <strong class="price"><?php printf( __('%s%s', 'miraculous'), $currency, $music_price ); ?>
                                             </strong>
                                             <a href="#" class="button button-danger">Buy Song</a>
                                          </div>
                                          <?php endif; ?>
                                       </li>
                                       <li>
                                          <div class="cell">
                                             <dl>
                                                <dt>Album:</dt>
                                                <dd><?php echo get_the_title(); ?></dd>
                                             </dl>
                                          </div>
                                          <?php
                                             if($ar_type!='free'){
                                             ?>
                                          <div class="btn-cell">
                                          <form method="post">
                                             <!-- <strong class="price">$0.99</strong> -->
                                             <button type="sumbit" class="download_album button button-danger" name="download_album">
                                             Download Album
                                             </button>
                                             <input type="hidden" name="album_id" value="<?php echo get_the_id(); ?>">
                                           </form>
                                          </div>
                                          <?php } ?>
                                       </li>
                                    </ul>
                                 </div>
                                 <div class="bottom-panel">
                                    <div class="panel-holder">
                                       <div class="panel-frame">
                                          <!-- <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo esc_attr($mst_music_option); ?>" data-musictype="music">
                                          <span class="play_all btn-play">Play All</span>
                                          <span class="pause_all btn-pause">Pause</span>
                                          </a> -->
                                          
                                          <ul class="social-list">
                                             <li class="facebook">
                                                <a href="javascript:void(0);" class="ms_share_facebook" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(get_permalink($mst_music_option)); ?>', 'Share', width='200', height='150' )">
                                                <i class="icon-facebook"></i> Facebook
                                                </a>
                                             </li>
                                             <li class="twitter">
                                                <a href="javascript:void(0);" class="ms_share_twitter" onclick="window.open('https://twitter.com/intent/tweet?text=<?php echo get_the_title($mst_music_option); ?>&amp;url=<?php echo esc_url(get_permalink($mst_music_option)); ?>&amp;via=<?php echo get_bloginfo( 'name' ); ?>' , 'Share', width='200', height='150' )">
                                                <i class="icon-twitter"></i> Twitter
                                                </a>
                                             </li>
                                             <li class="linkedin">
                                                <a href="javascript:void(0);" class="ms_share_linkedin" onclick="window.open('https://www.linkedin.com/cws/share?url=<?php echo esc_url(get_permalink($mst_music_option)); ?>', 'Share', width='200', height='150' )">
                                                <i class="icon-linkedin"></i> LinkedIn
                                                </a>
                                             </li>
                                             <li class="google-plus">
                                                <a href="javascript:void(0);" class="ms_share_googleplus" onclick="window.open('https://plus.google.com/share?url=<?php echo esc_url(get_permalink($mst_music_option)); ?>', 'Share', width='200', height='150' )">
                                                <i class="icon-google-plus"></i> Google+
                                                </a>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="video-iframe">
                           <?php
                                 $is_music_video = get_field('video_display',$mst_music_option);
                                 if($is_music_video!=''){
                                    echo $music_video = get_field('video_link',$mst_music_option);
                                 }
                           ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php 
               $i++; 
               endforeach; 
               endif;
               ?>
         </div>
      </div>
      <?php 
         $is_video = get_field('video_display',$currentpage_id);
         $video = get_field('video_link',$currentpage_id);
         if($is_video):
         ?>
      <div class="video-block">
         <!-- <img src="<?php //echo get_stylesheet_directory_uri();?>/images/img-video.jpg" alt=""> -->
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
</div>