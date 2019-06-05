<?php 


   $userid = get_current_user_id();

   $genres = get_categories('taxonomy=genre&type=ms-albums');
   $album_type = get_categories('taxonomy=album-type&type=ms-albums');

  $currency = '';
   if(!empty($miraculous_theme_data['paypal_currency']) && function_exists('miraculous_currency_symbol')):
    $currency = miraculous_currency_symbol( $miraculous_theme_data['paypal_currency'] );
   endif;

?>


<div class="tab-item" id="tab-my-albums">
   <div class="content-block my-albums-block">
      <div class="section-header">
         <h2>My Albums</h2>
         <div class="cell">
            
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('profile'))); ?>/add-albums" class="button button-danger">
                <?php echo esc_html__('UPLOAD ALBUM', 'miraculous'); ?>
            </a>
         </div>
      </div>
      <?php

         //send_notification_to_admin_for_create_albums_by_artist(2949,$userid);

         $count_query = new WP_Query(array('posts_per_page'=>-1,'post_type'=>'ms-albums','post_status' => array('publish', 'draft'),'author' => $userid));
         $total_albums = $count_query->found_posts;
         
         $limit = 3;
         $page = get_query_var('paged') ? get_query_var('paged') : 1;
         $arg = array(
         'posts_per_page'=>$limit,
         'post_type'=>'ms-albums',
         'author' => $userid,
         'orderby'     => 'title', 
         'order'       => 'ASC',
         'post_status' => array('publish', 'draft'),
         'paged' => $page
         );

         $albums_query = new WP_Query($arg);
         $show_albums = $albums_query->found_posts;
         $num_pages = $albums_query->max_num_pages;
         if ( $albums_query->have_posts() ) :
      ?>
      <ol class="albums-list">
       <?php

            while ( $albums_query->have_posts() ) : $albums_query->the_post();
                                  $image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_id()), 'thumbnail' );

         if( function_exists('fw_get_db_post_option') ):
         $ms_album_post_meta_option = fw_get_db_post_option(get_the_id());
         endif;

         $album_songs = $ms_album_post_meta_option['album_songs'];

         // echo "<pre>";
         // print_r(get_post_meta(get_the_id()));
      ?>

       
         <li class="albumsid-<?php echo get_the_id();?>">
            <div class="title">
               <strong class="name"><?php echo get_the_title();?></strong>
               <div class="cell">
                  <span class="number"><?php echo count($album_songs);?>  Songs</span>
                  <a href="javascript:;" class="button delete_artists_albums" albumsid="<?php echo get_the_id();?>">DELETE</a>
                  <a href="#" class="button opener">VIEW</a>
               </div>
            </div>
            <div class="slide">
               <div class="albums-table">
                  <div class="tr head">
                     <div class="cell">Songs</div>
                     <div class="cell price">Price</div>
                     <div class="cell">TIME</div>
                     <div class="cell"></div>
                  </div>

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
                                 
                  ?>
                  <ol class="row-group">
                  <?php

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


                  ?>
                     <li class="tr">
                        <div class="cell cell-title">
                           <div class="ttl">
                              <strong class="name"><?php echo get_the_title( $mst_music_option ); ?></strong>

                           <?php if(!empty($music_image)):?>
                              <img src="<?php echo $music_image[0];?>" alt="<?php echo get_the_title( $mst_music_option ); ?>" width="26" height="26">
                           <?php endif;?>

                              
                           </div>
                        </div>
                        <div class="cell">
                           <span><?php printf( __('%s%s', 'miraculous'), $currency, $music_price ); ?></span>
                        </div>
                        <div class="cell">
                           <span class="time"><?php 
                         echo (isset($attach_meta['length_formatted'])) ? $attach_meta['length_formatted'] : "0.00"; 
                         ?></a></span>
                        </div>
                        <div class="cell">
                           <a href="#" class="btn-round btn-play">Play</a>
                        </div>
                     </li>
                     <?php 
                        $i++; 
                        endforeach; 
                     ?>
                  </ol>
               <?php endif; ?>
               </div>
            </div>
         </li>
         <?php endwhile;?>
         
      </ol>
      <?php

            else:
               echo '<p class="no-found">No Albums Found.</p>';
            endif;
         ?>
      <?php

            $links = paginate_links( array(
               'base' => get_pagenum_link(1) . '%_%',
               'format' => 'page/%#%/',
               'prev_text' => __('&laquo; Prev'), // text for previous page
               'next_text' => __('Next &raquo;'), // text for next page
               'current' => max( 1, get_query_var('paged') ),
               'total' => $num_pages,
               'type' => 'array'
               ) );
            
            if(!empty($links)):
         ?>
            <div class="paging-holder">
               <?php
                  if( is_array( $links ) ) {
                  echo '<ul class="paging ajax-page-paging">';
                    foreach ( $links as $link ) {
                            echo "<li>$link</li>";
                    }
                     echo '</ul>';
                 }
               ?>
            </div>
   <?php endif; wp_reset_postdata(); ?>
   </div>
</div>




  