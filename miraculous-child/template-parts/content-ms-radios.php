<?php


$previous = "javascript:history.go(-1)";
   if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
   }
   
   $currentpage_id = get_the_id();
   $user_id = get_current_user_id();
   $post_id = get_post($currentpage_id);
   
   
   $title        = $post_id->post_title;
   $content      = $post_id->post_content;
$radio_image = wp_get_attachment_image_src( get_post_thumbnail_id($currentpage_id), 'full' );

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
  $musictype = 'radio';
  $list_type = 'music';
  $ms_radio_post_meta_option = '';
  if( function_exists('fw_get_db_post_option') ):
  $ms_radio_post_meta_option = fw_get_db_post_option(get_the_ID());
    endif;
    if($ms_radio_post_meta_option['radio_artists']):
    foreach ($ms_radio_post_meta_option['radio_artists'] as $artists_id):
      $artists_name[] = get_the_title($artists_id);
    endforeach; 
  endif; 

  $genres = get_the_terms( get_the_ID(), 'genre' );
  $genre_id = array();
  $genre_slug = array();
  if(!empty($genres)){
  	foreach ($genres as $key => $genre) {
  		$genre_id[] = $genre->term_id;
  		$genre_slug[] = $genre->slug;
  	}
  }
  $tax_query = array();
	if(isset($genres) && !empty($genres)){
	  $tax_query[] = array ('taxonomy' => 'genre','field'  => 'slug','terms'  => $genre_slug,'operator' => 'IN');
	}


?> 
<div id="content">
   <div class="content-block album-block">
      <div class="block-table block-text">
         <div class="img-box">
            <img src="<?php echo $radio_image[0];?>" alt="<?php echo $title;?>" width="168" height="160">
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
                        <?php printf( __('By - %s', 'miraculous'), implode(', ', $artists_name) ) ?>
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
                        <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo get_the_id();?>" data-musictype="radio">
                        <span class="play_all btn-play">Play All</span>
                        <span class="pause_all btn-pause">Pause</span>
                        </a>
                        <div class="menu-box">
                           <a href="#" class="btn-round btn-add"><i class="icon-star"></i> Open "add to" menu</a>
                           <div class="menu-drop">
                              <div class="drop-holder">
                                 <ul class="drop-list">
                                    <li><a href="javascript:;" class="favourite_radios" data-radioid="<?php echo get_the_id();?>">Add To Favorite</a></li>
                                    <li>
                                       <a href="javascript:;" class="ms_add_playlist" data-msmusic="<?php echo get_the_id();?>">Add To Playlist</a>
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
   <?php if(is_singular()){?>
   <div class="content-block">
      <div class="items-table">
	   <div class="tr head">
	      <div class="cell title">Title</div>
	      <div class="cell sub-title">Artist</div>
	      <div class="cell"></div>
	      <div class="cell">Price</div>
	      <div class="cell"></div>
	      <div class="cell"></div>
	   </div>
	   <div class="row-group">
	   <?php
	   		if( $ms_radio_post_meta_option['radio_songs'] ):  
            $i = 1;
            foreach($ms_radio_post_meta_option['radio_songs'] as $mst_music_option): 
              $attach_meta = array();
                  $mpurl = get_post_meta($mst_music_option, 'fw_option:mp3_full_songs', true);
              if($mpurl) {
                $attach_meta = wp_get_attachment_metadata( $mpurl['attachment_id'] );
              }
              $image_uri = get_the_post_thumbnail_url ( $mst_music_option );
              $music_price = '';
                if(function_exists('fw_get_db_post_option')){
                    $music_price_arr = fw_get_db_post_option($mst_music_option, 'music_type_options');
                    if( !empty( $music_price_arr['premium']['single_music_price'] ) ){
                        $music_price = $music_price_arr['premium']['single_music_price'];
                    }
                }
              $music_type = get_post_meta($mst_music_option, 'fw_option:music_type', true);
	   ?>
	      <div class="tr main-row expanded">
               <div class="cell title">
                  <a href="#" class="fake-opener">
                  <?php echo get_the_title( $mst_music_option ); ?>
                  </a>
               </div>
               <div class="cell sub-title"><?php echo implode(', ', $artists_name); ?></div>
               <div class="cell">
                  <div class="menu-box">
                     <a href="#" class="btn-round btn-add"><i class="icon-star"></i> Open "add to" menu</a>
                     <div class="menu-drop">
                        <div class="drop-holder">
                           <ul class="drop-list">
                                    <li><a href="javascript:;" class="favourite_radios" data-radioid="<?php echo $mst_music_option;?>">Add To Favorite</a></li>
                                    <li>
                                       <a href="javascript:;" class="ms_add_playlist" data-msmusic="<?php echo $mst_music_option;?>">Add To Playlist</a>
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
                  <?php /*else:?>
                  <a href="#" class="button button-danger">
                  Buy Now
                  </a>
                  <?php endif;*/?>
               </div>
               <div class="cell">
                  <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo esc_attr($mst_music_option); ?>" data-musictype="music">
                  <span class="play_all btn-play">Play All</span>
                  <span class="pause_all btn-pause">Pause</span>
                  </a>
               </div>
          </div>
        <?php 
              $i++; 
              endforeach; 
              endif;
        ?> 
	   </div>
	</div>
	</div>
	<?php } ?>
	<?php if(is_singular()){?>
	<section class="album-gallery buttons-control">
	   <div class="section-header">
	      <h2><?php _e('Similar Artists');?></h2>
	      <div class="cell"></div>
	   </div>
	   <div class="gmask">
	   <?php
	      $radio_arg = array(
	      'posts_per_page'=>-1,
	      'post_type'=>'ms-radios',
	      'post_status' => 'publish',
	      'orderby'     => 'rand', 
	      'order'       => 'ASC',
	      'tax_query' => $tax_query,
	      'post__not_in' => array(get_the_id()),
	      );

	      $radios_query = new WP_Query($radio_arg);
	      $radios_rs       = $radios_query->posts;
	      if(!empty($radios_rs)){
	         foreach ($radios_rs as $r_key => $radios_data) {
	            $similar_artists  = get_post_meta($radios_data->ID,'radio_artists',true);
		            
		            $similar_radio_ids = array();
		            $similar_artists_ids = array();
		            if(!empty($similar_artists)){
		            	foreach ($similar_artists as $akey => $similar_artist) {
		            		if(!in_array($similar_artist, $similar_artists_ids)){
		            			$similar_artists_ids[] = $similar_artist;
		            			$similar_radio_ids[] = $radios_data->ID;
		            		}
		            	}
		            }


		         }

		      }
		      

		    if(!empty($similar_radio_ids)){
	            	foreach ($similar_artists_ids as $aikey => $similar_artists_id) {
	            		$artist_image = wp_get_attachment_image_src( get_post_thumbnail_id($similar_artists_id), 'thumbnail' );
	            		
	      ?>
	       <article class="slide">
	         <div class="slide-holder">
	            
	            <!-- <a href="javascript:;" class="img-box play_music" data-musicid="<?php echo $similar_radio_ids[$aikey];?>" data-musictype="radio" title="Add to Queue"> -->
	            <a href="<?php echo get_the_permalink($similar_radio_ids[$aikey]);?>" class="img-box">
	            <?php if(!empty($artist_image)){?>
	            <img src="<?php echo $artist_image[0];?>" alt="" width="129" height="126">
	            <?php } ?>
	            <i class="icon-magnify"></i>
	            </a>
	            <div class="text-holder">
	               <h2><a href="<?php echo get_the_permalink($similar_radio_ids[$aikey]);?>"><?php echo get_the_title($similar_artists_id);?></a></h2>
	               <strong><?php //echo get_the_title($similar_radio_ids[$aikey]);?></strong>
	            </div>
	         </div>
	      </article>
	      <?php
	         }

	      }
	   ?>
	     
	      
	   </div>
	</section>
   <?php } ?>
</div>