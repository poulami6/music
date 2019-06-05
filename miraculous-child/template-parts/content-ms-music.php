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
                        <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo get_the_id();?>" data-musictype="music">
                        <span class="play_all btn-play">Play</span>
                        <span class="pause_all btn-pause">Pause</span>
                        </a>
                        <div class="menu-box">
                           <a href="#" class="btn-round btn-add"><i class="icon-star"></i> Open "add to" menu</a>
                           <div class="menu-drop">
                              <div class="drop-holder">
                                 <ul class="drop-list">
                                    <li><a href="javascript:;" class="favourite_music" data-albumid="<?php echo get_the_id();?>">Add To Favorite</a></li>
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

<?php 
	 $is_video = get_field('video_display',$currentpage_id);
	 $video = get_field('video_link',$currentpage_id);
	 if($is_video):
?>
   <div class="content-block">
      
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
   </div>

   <?php
         endif;
    ?>
</div>