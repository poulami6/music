<?php
   /**
    * The template used for displaying Featured Songs content
    *
    * @package WordPress
    * @subpackage Twenty_Sixteen
    * @since Twenty Sixteen 1.0
    */
   ?>
<aside id="sidebar">
   <nav class="side-nav">
      <ul>
         <li <?php if(get_the_id() == 2498 || 'ms-news' == get_post_type()){ echo 'class="active"';}?> ><a href="<?php echo esc_url(get_permalink(get_page_by_path('news'))); ?>"><i class="icon-calendar"></i> News</a></li>
         <li <?php if(get_the_id() == 2511){ echo 'class="active"';}?>><a href="<?php echo esc_url(get_permalink(get_page_by_path('artist-of-month'))); ?>"><i class="icon-star"></i> Artist of the month</a></li>
         <!-- <li><a href="#"><i class="icon-stats"></i>Contests</a></li> -->
         <li <?php if(get_the_id() == 2546 || 'ms-radios' == get_post_type()){ echo 'class="active"';}?> ><a href="<?php echo esc_url(get_permalink(get_page_by_path('radio'))); ?>"><i class="icon-equalizer"></i> CGM Radio</a></li>
         <li  <?php if(get_the_id() == 2895 || 'ms-cgmtv' == get_post_type()){ echo 'class="active"';}?> ><a href="<?php echo esc_url(get_permalink(get_page_by_path('cgm-tv'))); ?>"><i class="icon-tv"></i> CGM TV</a></li>
         <?php if(is_user_logged_in()):?>
         <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('profile'))); ?>friends"><i class="icon-user"></i> My Friends</a></li>
         <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('profile'))); ?>favorites"><i class="icon-heart"></i> My Favorites</a></li>
         <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('profile'))); ?>/playlist"><i class="icon-list"></i> My Playlists</a></li>
         <?php endif;?>
      </ul>
   </nav>
   <?php 
      $featured_music_arg = array(
      'post_type'      => 'ms-music',
      'posts_per_page' => 4,
      'post_status'    => 'publish',
      'orderby'   => 'ID',
      'order' => 'DESC',
      'tax_query' => array(
                          array (
                              'taxonomy' => 'music-type',
                              'field' => 'slug',
                              'terms' => 'featured-musics',
                          )
                      ),
      );
      
      $featured_musics_query = new WP_Query($featured_music_arg);
      $featured_musics = $featured_musics_query->posts;
      if(!empty($featured_musics)){
      
      ?>
   <section class="feature-section side-box">
      <div class="title-box">
         <h2>Featured Songs</h2>
      </div>
      <ul class="featured-list">
         <?php
            foreach ($featured_musics as $featured_music_key => $featured_music) {
               $featured_music_image = wp_get_attachment_url( get_post_thumbnail_id($featured_music->ID));
            ?>
         <li>
            <article>
               <img src="<?php echo $featured_music_image;?>" alt="image description" width="63" height="63">
               <div class="text-holder">
                  <h2><a href="<?php echo get_the_permalink($featured_music->ID);?>"><?php echo $featured_music->post_title;?></a></h2>
                  <p><?php echo $featured_music->post_excerpt;?> </p>
                  <time datetime="<?php echo get_the_date('Y-m-d');?>"><?php echo get_the_date('d.m.Y');?></time>
               </div>
            </article>
         </li>
         <?php } ?>
      </ul>
   </section>
   <?php } ?>
   <section class="side-box fans-block">
     <div class="title-box">
        <h2>Fans</h2>
     </div>
     <div class="box-content">
        <div class="fb-like" data-href="https://wordpresssites.dapldevelopment.com/music/" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
     </div>
  </section>
</aside>