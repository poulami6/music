<?php
   /**
    * Template Name: Home Page
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

//$playlist = get_users_playlist();



?>


<main id="main">
   <div class="container">
      <div id="twocolumns">
         <div id="content">
            <section class="gallery">
               <div class="section-header">
                  <h1>New releases</h1>
                  <div class="cell">
                  </div>
               </div>
               <div class="gmask">
               <?php

                $release_arg = array(
                    'post_type'      => 'new-releases',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'orderby'   => 'ID',
                    'order' => 'DESC',
                    
                    );

                    $release_query = new WP_Query($release_arg);
                    $releases = $release_query->posts;
                    if(!empty($releases)):
                      foreach ($releases as $release_key => $release) :
                        
                    $release_title = $release->post_title;
                    $releases_excerpt = $release->post_excerpt;
                    
                    $releases_image = wp_get_attachment_image_src(get_post_thumbnail_id($release->ID), 'full', false );

                    $link = array();
                    switch (get_field('promote',$release->ID)) {
                      case 'music':
                        $link = get_field('promote_musics',$release->ID);
                        break;
                        case 'album':
                        $link = get_field('promote_album',$release->ID);
                        break;
                        case 'artist':
                        $link = get_field('promote_artist',$release->ID);
                        break;
                      
                      default:
                        $link = array('javascript:;');
                        break;
                    }


               ?>
                  <article class="slide">
                     <img src="<?php echo $releases_image[0];?>" alt="" width="710" height="316">
                     <div class="title-box">
                        <div class="box-holder">
                           <h2><strong><?php echo $release_title;?></strong> <?php echo $releases_excerpt;?></h2>
                           <div class="cell">
                              <a href="<?php echo get_permalink($link[0]);?>" class="button">Details</a>
                           </div>
                        </div>
                     </div>
                  </article>
                <?php endforeach; endif;  wp_reset_postdata(); ?>
               </div>
            </section>
            <section class="album-gallery dots-control">
               <div class="section-header">
                  <h2>Featured Albums</h2>
                  <div class="cell"></div>
               </div>
               <div class="gmask">
               <?php
                   
                    $featured_albums_arg = array(
                    'post_type'      => 'ms-albums',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'tax_query' => array(
                                        array (
                                            'taxonomy' => 'album-type',
                                            'field' => 'slug',
                                            'terms' => 'featured-albums',
                                        )
                                    ),
                    );

                    $featured_albums_query = new WP_Query($featured_albums_arg);
                    if ( $featured_albums_query->have_posts() ) { 
                    while ( $featured_albums_query->have_posts() ) { $featured_albums_query->the_post();
                        $albums_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_id()));
                        $album_songs = get_post_meta(get_the_id(),'fw_options',true);
                        
                        if(!empty($album_songs['album_songs'])){
               ?>
                  <article class="slide">
                     <div class="slide-holder">
                        <!-- <a href="javascript:;" class="img-box add_to_queue" data-musicid="<?php echo get_the_ID();?>" data-musictype="album" title="Add To Queue"> -->
                        <a href="javascript:;" class="img-box add_to_popup" data-albumid="<?php echo get_the_ID();?>">
                        <img src="<?php echo $albums_image;?>" alt="<?php echo get_the_title();?>" width="129" height="126">
                        <i class="icon-magnify"></i>
                        </a>
                        <div class="text-holder">
                           <h2>
                             <a href="<?php echo esc_url(get_permalink(get_the_id())); ?>">
                              <?php echo get_the_title();?>
                             </a>
                           </h2>
                           <time datetime="<?php echo get_the_date('Y-m-d');?>"><?php echo get_the_date('d.m.Y');?></time>
                        </div>
                     </div>
                  </article>
                  <?php }} }  wp_reset_postdata(); ?>
               </div>
            </section>
            <?php 
                   
                    $new_albums_arg = array(
                    'post_type'      => 'ms-albums',
                    'posts_per_page' => 20,
                    'post_status'    => 'publish',
                    'orderby'   => 'ID',
                    'order' => 'DESC',
                    
                    );

                    $new_albums_query = new WP_Query($new_albums_arg);
                    $new_albums = $new_albums_query->posts;

                    if(!empty($new_albums)){
                    
               ?>
            <section class="album-gallery dots-control">
               <div class="section-header">
                  <h2>Latest Additions</h2>
                  <div class="cell"></div>
               </div>
               <div class="gmask">
               <?php 
                foreach ($new_albums as $new_album_key => $new_album) {
                   $new_album_image = wp_get_attachment_url( get_post_thumbnail_id($new_album->ID));
               ?>
                  <article class="slide">
                     <div class="slide-holder">
                        <a href="javascript:;" class="img-box add_to_queue" data-musicid="<?php echo $new_album->ID;?>" data-musictype="album" title="Add To Queue">

                        <img src="<?php echo $new_album_image;?>" alt="" width="129" height="126">
                        <i class="icon-magnify"></i>
                        </a>

                        <div class="text-holder">
                           <h2>
                             <a href="<?php echo esc_url(get_permalink($new_album->ID)); ?>">
                                <?php echo $new_album->post_title;?>
                             </a>
                           </h2>
                           <time datetime="<?php echo get_the_date('Y-m-d');?>"><?php echo get_the_date('d.m.Y');?></time>
                        </div>
                     </div>
                  </article>
                <?php } ?>
               </div>
            </section>
            <?php } ?>
            <div class="row features-area">
            <?php
                   
                    $top_artists_arg = array(
                    'post_type'      => 'ms-artists',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'tax_query' => array(
                                        array (
                                            'taxonomy' => 'artist-type',
                                            'field' => 'slug',
                                            'terms' => 'top-artists',
                                        )
                                    ),
                    );

                    $top_artists_query = new WP_Query($top_artists_arg);
                    $top_artists = $top_artists_query->posts;
                    if(!empty($top_artists)){
                      
                       
                       
               ?>
               <div class="col-4">
                  <section class="feature-section feature-gallery">
                     <div class="title-box">
                        <h2>Top Artists</h2>
                     </div>
                     <div class="gmask">
                     <?php
                        
                        foreach ($top_artists as $artists_key => $top_artist) {
                           // $albums = get_all_album_post_name_for_artist($top_artist->ID);
                           // echo "<pre>";
                           // print_r($albums);
                          $albums = get_all_albums_post_name_for_artist($top_artist->ID);

                     ?>
                     <?php if($artists_key % 5 == 0){?>
                        <div class="slide">
                           <ol class="feature-list">
                           <?php } ?>
                           	<li>
              								<div class="text-holder">
              									<a href="<?php echo get_permalink($top_artist->ID);?>"><strong class="name"><?php echo $top_artist->post_title;?></strong></a>
              									<p><?php echo count($albums);?> Album(s)</p>
              								</div>
              								<a href="javascript:;" class="play-btn play_music" data-musicid="<?php echo $top_artist->ID;?>" data-musictype="artist" title="Add To Queue"></a>
              							</li>
                      <?php if($artists_key % 5 == 4 || $artists_key == count( $top_artists ) -1){?>
                             </ol>
                          </div>
                      <?php } ?>

                      <?php } //die();?>

                     </div>
                  </section>
               </div>
               <?php  }  //wp_reset_postdata(); ?>

               <?php 
                   
                    $top_albums_arg = array(
                    'post_type'      => 'ms-albums',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'tax_query' => array(
                                        array (
                                            'taxonomy' => 'album-type',
                                            'field' => 'slug',
                                            'terms' => 'top-albums',
                                        )
                                    ),
                    );

                    $top_albums_query = new WP_Query($top_albums_arg);
                    $top_albums = $top_albums_query->posts;

                    if(!empty($top_albums)){
                    $albums_count = end($top_albums);
               ?>
               <div class="col-4">
                  <section class="feature-section feature-gallery">
                     <div class="title-box">
                        <h2>Top Albums</h2>
                     </div>
                     <div class="gmask">
                     <?php
                        foreach ($top_albums as $album_key => $top_album) {

                        $album_artist_id = get_post_meta($top_album->ID, 'album_artists', true);



                     ?>
                     <?php if($album_key % 5 == 0){?>
                        <div class="slide">
                           <ol class="feature-list">
                           <?php } ?>

                              <li>
                              <div class="text-holder">
                                <a href="<?php echo get_permalink($top_album->ID);?>">
                                <strong class="name"><?php echo $top_album->post_title;?></strong>
                                 <p>
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
                                     
                                 </p>
                                </a>
                              </div>
                              
                              <a href="javascript:;" class="play-btn play_music" data-musicid="<?php echo $top_album->ID;?>" data-musictype="album" title="Add To Queue"></a>
                            </li>

                    <?php if($album_key % 5 == 4 || $album_key == count( $top_albums ) -1){?>
                           </ol>
                        </div>
                    <?php } ?>

                    <?php }?>
                     </div>
                  </section>
               </div>
               <?php  }  //wp_reset_postdata(); ?>

               <?php 
                   
                    $top_music_arg = array(
                    'post_type'      => 'ms-music',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'tax_query' => array(
                                        array (
                                            'taxonomy' => 'music-type',
                                            'field' => 'slug',
                                            'terms' => 'top-musics',
                                        )
                                    ),
                    );

                    $top_musics_query = new WP_Query($top_music_arg);
                    $top_musics = $top_musics_query->posts;
                    if(!empty($top_musics)){
                    $musics_count = end($top_musics);
               ?>
               <div class="col-4">
                  <section class="feature-section feature-gallery">
                     <div class="title-box">
                        <h2>Top Songs</h2>
                     </div>
                     <div class="gmask">
                     <?php
                        foreach ($top_musics as $music_key => $top_music) {
                        $music_artist_id = get_post_meta($top_music->ID, 'fw_option:music_artists', true);

                     ?>
                     <?php if($music_key % 5 == 0){?>
                        <div class="slide">
                           <ol class="feature-list">
                           <?php } ?>

                              
                              <li>
                              <div class="text-holder">
                                <a href="<?php echo get_permalink($top_music->ID);?>">
                                <strong class="name"><?php echo $top_music->post_title;?></strong>
                                     <p>
                                      <?php 
                                      if(!empty($music_artist_id)){


                                          foreach ($music_artist_id as $music_artist_id_key => $music_artist_ids) {
                                              echo get_the_title($music_artist_ids);
                                              if($music_artist_id_key != count( $music_artist_id ) -1){
                                                echo ', ';
                                              }
                                          }
                                      }
                                     ?>
                                     </p>
                                </a>
                              </div>
                              
                              <a href="javascript:;" class="play-btn play_music" data-musicid="<?php echo $top_music->ID;?>" data-musictype="music" title="Add To Queue"></a>
                            </li>

                    <?php if($music_key % 5 == 4 || $music_key == count( $top_musics ) -1){?>
                           </ol>
                        </div>
                    <?php } ?>

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