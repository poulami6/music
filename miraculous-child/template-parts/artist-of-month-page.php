<?php
   /**
    * Template Name: Artist of Month Page
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
   
   $currentpage_id = get_the_id();
   $user_id = get_current_user_id();
   $post_id = get_post($currentpage_id);
   
   
   $title        = $post_id->post_title;
   $content      = $post_id->post_content;
   
   $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_id()), 'thumbnail' );
   
   
   $artist_for_month_arg = array(
   'post_type'      => 'ms-artist-month',
   'posts_per_page' => 1,
   'post_status'    => 'publish',
   'tax_query' => array(
                       array (
                           'taxonomy' => 'artist-month',
                           'field' => 'slug',
                           'terms' => strtolower(date('F')),
                       ),
                       array (
                           'taxonomy' => 'artist-year',
                           'field' => 'slug',
                           'terms' => date('Y'),
                       )
                   ),
                    

   );

   $artist_for_month_query = new WP_Query($artist_for_month_arg);
   $artist_for_month = $artist_for_month_query->posts;
   
   
   $artist_month = array();
   $artist_year = array();
   $artist_id = array();
   $is_artist_image = array();
   $image = array();
   if(!empty($artist_for_month)){
      $artist_month = get_the_terms($artist_for_month[0]->ID, 'artist-month');
      $artist_year = get_the_terms($artist_for_month[0]->ID, 'artist-year');
      $artist_id = get_field('artist_for_month',$artist_for_month[0]->ID);

      $is_artist_image = get_field('artist_for_month',$artist_for_month[0]->ID);
      $image = wp_get_attachment_image_src( get_post_thumbnail_id($artist_for_month[0]->ID), 'thumbnail' );

      if($is_artist_image){
         $image = wp_get_attachment_image_src( get_post_thumbnail_id($artist_id[0]), 'thumbnail' );
      } 
   }

   
   
   
   

$all_month = get_categories('taxonomy=artist-month&type=ms-artist-month');
$all_year = get_categories('taxonomy=artist-year&type=ms-artist-month');

   ?>
<main id="main">
   <div class="container">
      <div id="twocolumns">
         <div id="content">
            <div class="section-header">
               <h1><?php echo !empty($artist_for_month)? get_the_title($artist_for_month[0]->ID) : '';?></h1>
            </div>
            <div class="row">
               <div class="col-8">
               <?php if(isset($artist_for_month) && !empty($artist_for_month)){?>
                  <div class="content-block preview-block">
                     <div class="preview-holder">
                        <div class="image-holder">
                           <img src="<?php echo $image[0];?>" alt="photo" width="160" height="192">
                        </div>
                        <div class="text-holder">
                           <h2><a href="<?php echo esc_url(get_permalink($artist_id[0])); ?>"><?php echo get_the_title($artist_id[0]);?></a></h2>
                           <?php echo $artist_for_month[0]->post_content; ?>
                           
                        </div>
                         <strong class="month-year"><?php echo $artist_month[0]->name.' '.$artist_year[0]->name;?> </strong>
                     </div>
                     <div class="share-holder">
                        <ul class="social-list">
                           <li class="facebook">
                              <a href="javascript:void(0);" class="ms_share_facebook" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(get_permalink($artist_for_month[0]->ID)); ?>', 'Share', width='200', height='150' )">
                              <i class="icon-facebook"></i> Facebook
                              </a>
                           </li>
                           <li class="twitter">
                              <a href="javascript:void(0);" class="ms_share_twitter" onclick="window.open('https://twitter.com/intent/tweet?text=<?php echo get_the_title($artist_for_month[0]->ID); ?>&amp;url=<?php echo esc_url(get_permalink($artist_for_month[0]->ID)); ?>&amp;via=<?php echo get_bloginfo( 'name' ); ?>' , 'Share', width='200', height='150' )">
                              <i class="icon-twitter"></i> Twitter
                              </a>
                           </li>
                           <li class="linkedin">
                              <a href="javascript:void(0);" class="ms_share_linkedin" onclick="window.open('https://www.linkedin.com/cws/share?url=<?php echo esc_url(get_permalink($artist_for_month[0]->ID)); ?>', 'Share', width='200', height='150' )">
                              <i class="icon-linkedin"></i> LinkedIn
                              </a>
                           </li>
                           <li class="google-plus">
                              <a href="javascript:void(0);" class="ms_share_googleplus" onclick="window.open('https://plus.google.com/share?url=<?php echo esc_url(get_permalink($artist_for_month[0]->ID)); ?>', 'Share', width='200', height='150' )">
                              <i class="icon-google-plus"></i> Google+
                              </a>
                           </li>
                        </ul>
                     </div>
                     <?php 
               $is_video = get_field('video_display',$artist_for_month[0]->ID);
               $video = get_field('video_link',$artist_for_month[0]->ID);
               if($is_video):
               ?>
            <div class="video-block">
               <!-- <img src="<?php //echo get_stylesheet_directory_uri();?>/images/img-video.jpg" alt=""> -->
               <?php echo $video;?>
            </div>
            <?php endif;?>
                  </div>
               <?php }else{?>
               <div class="content-block preview-block">
                     <!-- <div class="preview-holder"> -->
                        <div class="text-holder">
                           <h2><a href="javascript:;">No artist found for this month</a></h2>
                        </div>
                     <!-- </div> -->
                     
                  </div>
               <?php }?>
               </div>
               <?php 
                  $artist_m_arg = array(
                  'post_type'      => 'ms-artist-month',
                  'posts_per_page' => -1,
                  'post_status'    => 'publish',
                  
                  );
                  
                  $artist_m_query = new WP_Query($artist_m_arg);
                  $artistofmonths = $artist_m_query->posts;
                  
                  
                  
                  
                  if(!empty($artistofmonths)){
                  
                  ?>
               <div class="col-4">
                  <section class="feature-section feature-gallery">
                     <div class="title-box">
                        <h2><?php _e('Previous Artists');?></h2>
                     </div>
                     <div class="gmask">
                        <?php
                           $i=0;
                              foreach ($artistofmonths as $artist_key => $artistofmont) {
                                 $artist_month = get_the_terms($artistofmont->ID, 'artist-month');
                                 $artist_year = get_the_terms($artistofmont->ID, 'artist-year');
                                 $month = date("m", strtotime($artist_month[0]->slug));
                                 $year = $artist_year[0]->name;

                                 $current_month = date("m", strtotime(strtolower(date('F'))));
                                 
                              // if(isset($music_artist_id) && $music_artist_id!==''){
                                 if($month<$current_month && $year<=date('Y')){
                              $count = $i++;
                                if($count%5 == 0){
                              ?>
                        <div class="slide">
                           <ol class="feature-list">
                              <?php } ?>
                              <ul>
                                 <a href="javascript:;">
                                    <div class="text-holder">
                                       <strong class="name"><?php echo $artistofmont->post_title;?></strong>
                                       <span class="month-year"><?php echo $artist_month[0]->name.' '.$year;?> </span>
                                    </div>
                                 </a>
                              </ul>
                              <?php if($count%5 == 4){?>
                           </ol>
                        </div>
                        <?php }?>
                        <?php  } ?>
                        
                        <?php } ?>
                     </div>
                  </section>
               </div>
               <?php  } //wp_reset_postdata(); ?>
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