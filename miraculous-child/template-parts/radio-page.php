<?php
   /**
    * Template Name: Radio Page
    *
    * @package WordPress
    * @subpackage Twenty_Sixteen
    * @since Twenty Sixteen 1.0
    */
   
   
   
   $miraculous_page_data = '';
   if (function_exists('fw_get_db_post_option')):  
     $miraculous_page_data = fw_get_db_post_option(); 
   
   endif;
   
   
   get_header();
   
   $args = array(
    'type'                     => 'ms-radio',
    'child_of'                 => 0,
    'parent'                   => '',
    'orderby'                  => 'term_id',
    'order'                    => 'ASC',
    'hide_empty'               => false,
    'hierarchical'             => 1,
    'exclude'                  => '',
    'include'                  => '',
    'number'                   => '',
    'taxonomy'                 => 'genre',
    'pad_counts'               => false
   );
   //$genres = get_categories($args); 
   $genres = get_categories('taxonomy=genre&type=ms-radio');
  

   $artist_arg = array(
   'posts_per_page'=>-1,
   'post_type'=>'ms-radios',
   'post_status' => 'publish',
   'orderby'     => 'rand', 
   'order'       => 'ASC',
   );

   $artist_query = new WP_Query($artist_arg);
   $radios_artists       = $artist_query->posts;

   

?>
<main id="main">
   <div class="container">
      <div id="twocolumns">
         <div id="content">
         <?php if(!empty($radios_artists)){ ?>
            <section class="drop-gallery">
               <div class="section-header">
                  <h2 class="radio_artist_name">Radio <span></span></h2>
                  <div class="cell"></div>
               </div>
               <div class="gallery-block">
                  <div class="gmask-holder">
                     <div class="gmask" dir="rtl">
                     <?php

                        foreach ($radios_artists as $artist_key => $radios_artist) {
                           $image_url = wp_get_attachment_image_src( get_post_thumbnail_id($radios_artist->ID), 'thumbnail' );
                           $radio_artists  = get_post_meta($radios_artist->ID,'radio_artists',true);
                           $artists_name = array();
                           if(!empty($radio_artists)){
                              foreach ($radio_artists as $key => $radio_artist) {
                                 $artists_name[] = get_the_title($radio_artist);
                              }
                           }
                     ?>
                        <div class="slide">
                           <div class="img-box">
                              <a href="javascript:;" class="play_radio" data-musicid="<?php echo $radios_artist->ID;?>" data-musictype="radio" data-href="<?php echo get_the_permalink($radios_artist->ID);?>" >
                              <?php if(!empty($image_url)){?>
                              <img src="<?php echo $image_url[0];?>" alt="photo" width="161" height="161">

                              <img src="<?php echo get_template_directory_uri();?>/assets/images/svg/play.svg" alt="play icone" class="play_btn hide">
                                                
                              <?php } ?>
                              </a>
                           </div>
                           <div class="text-holder">
                              <strong class="name">
                              <a href="javascript:;" class="radio_url">
                                 <?php echo $radios_artist->post_title;?>
                              </a> 
                              </strong>
                              <strong class="title"><?php echo  !empty($artists_name) ? implode(',', $artists_name) : ''; ?></strong>
                           </div>
                        </div>

                     <?php } ?>   
                     </div>
                  </div>
                  <button type="button" class="btn-move">Move radio</button>
               </div>
            </section>
         <?php } ?>
            <section class="album-gallery buttons-control">
               <div class="section-header">
                  <h2><?php _e('Radios By Artist');?></h2>
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
                  );

                  $radios_query = new WP_Query($radio_arg);
                  $radios_rs       = $radios_query->posts;
                  if(!empty($radios_rs)){
                     foreach ($radios_rs as $r_key => $radios_data) {
                        $radio_image = wp_get_attachment_image_src( get_post_thumbnail_id($radios_data->ID), 'thumbnail' );
                  ?>
                   <article class="slide">
                     <div class="slide-holder">
                        
                        <a href="javascript:;" class="img-box play_music" data-musicid="<?php echo $radios_data->ID;?>" data-musictype="radio" title="Add to Queue">
                        <?php if(!empty($radio_image)){?>
                        <img src="<?php echo $radio_image[0];?>" alt="" width="129" height="126">
                        <?php } ?>
                        <i class="icon-magnify"></i>
                        </a>
                        <div class="text-holder">
                           <h2><a href="<?php echo get_the_permalink($radios_data->ID);?>"><?php echo $radios_data->post_title;?></a></h2>
                           <time datetime="<?php echo get_the_date('Y-m-d',$radios_data->ID);?>"><?php echo get_the_date('Y-m-d',$radios_data->ID);?></time>
                        </div>
                     </div>
                  </article>
                  <?php
                     }

                  }
               ?>
                 
                  
               </div>
            </section>
            <nav class="sub-nav radio-list-panel">
               <button type="button" class="btn-prev">Previous</button>
               <button type="button" class="btn-next">Next</button>
               <div class="mask">
                  <ul class="spotlight-list radio_gerne_menu">
                     <?php if(!empty($genres)){
                        foreach ($genres as $genres_key => $genre) {
                        ?>
                     <li class="radio_link  <?php if($genres_key == 0){echo 'active';}?>" id="<?php echo $genre->slug;?>"><a href="javascript:;" data-radio="<?php echo $genre->slug;?>"><span><?php echo $genre->name;?></span></a></li>
                     <?php
                        }
                        }
                        ?>
                  </ul>
               </div>
            </nav>
            <div class="tab-content">
               <div class="tab-item" id="tab-genre-1">
                  <div class="content-block">
                     <div class="section-header">
                        <h2><?php _e('Radio By Genre');?></h2>
                     </div>
                     <div class="radio-section" id="tab_result">
                        <?php
                           $tax_query = array();
                           if(isset($genres) && !empty($genres)){
                              $tax_query[] = array ('taxonomy' => 'genre','field' => 'slug','terms' => $genres[0]->slug);
                           }
                           
                           
                           
                           $arg = array(
                           'posts_per_page'=>-1,
                           'post_type'=>'ms-radios',
                           'post_status' => 'publish',
                           'orderby'     => 'title', 
                           'order'       => 'ASC',
                           'tax_query' => $tax_query,
                           
                           );
                           
                           $radio_query = new WP_Query($arg);
                           $radios       = $radio_query->posts;
                           
                           $radio_ids = array();
                           if(!empty($radios)){
                              foreach ($radios as $radio_key => $radio) {
                                 $radio_ids[] = $radio->ID;
                              }
                           }
                           
                           
                           $total_radio = count($radio_ids);
                           $radio_limit = 1;
                           
                           
                           
                           
                           ?>
                        <input type="hidden" name="all_radio" id="all_radio" value="<?php echo !empty($radio_ids) ? json_encode($radio_ids) : '';?>" data-page="news-details-page">
                        <input type="hidden" name="radio_offset" id="radio_offset" data-limit="<?php echo $radio_limit;?>">
                        <div id="radio_pagin_result">
                           <?php
                              $radio_ids = !empty($radio_ids) ? array_slice($radio_ids,0,$radio_limit) : array();
                              if(!empty($radio_ids)){
                                 $i = 0;
                                 $len = count($radio_ids);
                                 foreach ($radio_ids as $radio_key => $radio_id) {
                                    $image = wp_get_attachment_image_src( get_post_thumbnail_id($radio_id), 'thumbnail' );
                                 $radio_artists  = get_post_meta($radio_id,'radio_artists',true);
                              ?>
                           <?php if($i%2 == 0){?>
                           <div class="section-row">
                              <?php }?>
                              <div class="item">
                                 <div class="visual-box">
                                    <div class="img-box">
                                       <?php if(!empty($image)){?>
                                       <a href="<?php echo get_the_permalink($radio_id);?>">
                                       <img src="<?php echo $image[0];?>" alt="photo" width="142" height="135">
                                       </a>
                                       <?php }?>
                                    </div>
                                    <a href="javascript:;" class="btn-round btn-play play_music" data-musicid="<?php echo $radio_id;?>" data-musictype="radio">
                                    <span class="play_all btn-play">Play All</span>
                                    <span class="pause_all btn-pause">Pause</span>
                                    </a>
                                    <strong class="title"><?php echo get_the_title($radio_id);?></strong>
                                    <em class="date-item"><i class="icon-clock-o"></i> <time datetime="<?php echo get_the_date('Y-m-d',$radio_id);?>"><?php echo get_the_date('Y',$radio_id);?></time></em>
                                 </div>
                                 <div class="text-holder">
                                    <h3>Artists</h3>
                                    <?php if(!empty($radio_artists)){?>
                                    <ol>
                                       <?php foreach ($radio_artists as $key => $radio_artist) { ?>
                                       <li><a href="<?php echo get_the_permalink($radio_artist);?>"><?php echo get_the_title($radio_artist);?></a></li>
                                       <?php } ?>
                                    </ol>
                                    <?php }else{?>
                                    <p class="no-found no-artist">No artist found</p>
                                    <?php }?>
                                 </div>
                              </div>
                              <?php if($i%2 == 1 || $i == $len - 1){?>
                           </div>
                           <?php }?>
                           <?php
                              $i++;
                              }
                              }else{
                              echo '<p class="no-found">No radio Found.</p>';
                              }
                              ?>
                        </div>
                        <?php 
                           if(!empty($radio_ids) && $total_radio > count($radio_ids)):
                           ?>
                        <div class="paging-holder">
                           <ul class="paging news-paging">
                              <li class="prev"><a href="JavaScript:void(0);">&laquo;</a></li>
                              <?php
                                 for($ai=1; $ai<= ceil($total_radio/$radio_limit); $ai++){
                                   
                                 
                                   if($ai==1){
                                     $radio_current = 'class="radio_genre_pagin current"';
                                   }else{
                                     $radio_current = 'class="radio_genre_pagin"';
                                   }
                                 
                                   $ao = $ai-1;
                                   echo '<li><a href="JavaScript:void(0);" '.$radio_current.' id="radio_pagin_'.$ai.'" data-pagin="'.$ai.'" data-offset="'.$ao*$radio_limit.'">'.$ai.'</a><li/>';
                                   
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
         </div>
         <?php 
            // Include the featured songs content template.
            get_template_part( 'template-parts/content', 'left-side-bar' );
            ?>
      </div>
   </div>
</main>
<?php get_footer();?>