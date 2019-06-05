<?php

$userid = get_current_user_id();

$free_downloaded = !empty(get_user_meta($userid, 'free_downloaded_songs_by_user_'.$userid, true)) ? get_user_meta($userid, 'free_downloaded_songs_by_user_'.$userid, true) : array();
$premium_downloaded = !empty(get_user_meta($userid, 'premium_downloaded_songs_by_user_'.$userid, true)) ? get_user_meta($userid, 'premium_downloaded_songs_by_user_'.$userid, true) : array();

$downloaded = array_merge($free_downloaded,$premium_downloaded);
$allDownload = 
$totla_download = count($downloaded);
$download_limit = 5;

$downloaded = !empty($downloaded) ? array_slice($downloaded,0,$download_limit) : array();

   $miraculous_theme_data = '';
   if (function_exists('fw_get_db_settings_option')):  
   $miraculous_theme_data = fw_get_db_settings_option();     
   endif;

 $currency = '';
 if(!empty($miraculous_theme_data['paypal_currency']) && function_exists('miraculous_currency_symbol')):
  $currency = miraculous_currency_symbol( $miraculous_theme_data['paypal_currency'] );
 endif;

?>

<div class="tab-item" id="tab-my-downloads">
   <div class="content-block my-downloads-block">
      <div class="section-header">
         <h2>My Downloads</h2>
      </div>
      <div class="albums-table">
         <div class="tr head">
            <div class="cell">TITLE</div>
            <!-- <div class="cell date">DATE</div> -->
            <div class="cell price">PRICE</div>
            <div class="cell">TIME</div>
            <div class="cell"></div>
         </div>
         <?php if(!empty($downloaded)):?>
          <input type="hidden" name="download_offset" id="download_offset" data-limit="<?php echo $download_limit;?>">
         <ol class="row-group" id="download-content">
            <?php
               foreach ($downloaded as $key => $download) :
                  $image = wp_get_attachment_image_src( get_post_thumbnail_id($download), 'thumbnail' );

                  $music_price = '';
                  if(function_exists('fw_get_db_post_option')){
                    $music_price_arr = fw_get_db_post_option($download, 'music_type_options');
                    if( !empty( $music_price_arr['premium']['single_music_price'] ) ){
                        $music_price = $music_price_arr['premium']['single_music_price'];
                    }
                  }

                  $attach_music = array();
                  $mpurl = get_post_meta($download, 'fw_option:mp3_full_songs', true);
                  if($mpurl) {
                    $attach_music = wp_get_attachment_metadata( $mpurl['attachment_id'] );
                  }

                  $music_type = get_post_meta($download, 'fw_option:music_type', true);
            ?>
            <li class="tr">
               <div class="cell cell-title">
                  <div class="ttl">
                     <strong class="name"><?php echo get_the_title($download);?></strong>
                     <?php if(!empty($image)):?>
                     <img src="<?php echo $image[0];?>" alt="album photo" width="26" height="26">
                   <?php endif?>
                  </div>
               </div>
               <!-- <div class="cell">
                  <time datetime="2014-01-12">12.01.2014</time>
               </div> -->
               <div class="cell">
               <?php if(empty($music_price)): ?>
                  <span><?php esc_html_e('Free', 'miraculous'); ?></span>
               <?php else: ?>
                  <span><?php printf( __('%s%s', 'miraculous'), $currency, $music_price ); ?></span>
              <?php endif;?>
               </div>
               <div class="cell">
                  <span class="time"><?php echo (isset($attach_music['length_formatted'])) ? $attach_music['length_formatted'] : " "; ?></span>
               </div>
               <div class="cell">
                  <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo esc_attr($download); ?>" data-musictype="music">
                  <span class="play_all btn-play">Play All</span>
                  <span class="pause_all btn-pause">Pause</span>
                  </a>
               </div>
            </li>
         <?php endforeach;?>
         </ol>
         
   <?php else:?>
   <p class="no-found"> No downloads found.</p>
   <?php endif;?>
      </div>
      <?php if($totla_download > count($downloaded)):?>
         <div class="paging-holder">
           <ul class="paging albums-paging">
           <li class="prev"><a href="javascript:;">&laquo;</a></li>
           <?php

              for($i=1; $i<= ceil($totla_download/$download_limit); $i++){

                if($i==1){
                  $current = 'class="download-pagination current"';
                }else{
                  $current = 'class="download-pagination"';
                }

                $o = $i-1;
                echo '<li><a href="javascript:;" '.$current.' id="download_pagin_'.$i.'" data-pagin="'.$i.'" data-offset="'.$o*$download_limit.'">'.$i.'</a><li/>';
                

              }
           ?>
              <li class="next"><a href="javascript:;"> &raquo;</a></li>
           </ul>
         </div>
         <?php endif;?>
   </div>
</div>