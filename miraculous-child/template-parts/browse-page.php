<?php
   /**
    * Template Name: Browse Page
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
                    
$genres_selection = get_field('genres_selection','option');
$post_selection   = get_field('post_selection','option');
$number_of_post   = get_field('number_of_post','option');

$number_of_new_albums   = get_field('number_of_new_albums','option');
$new_albums_post_per_page = ($number_of_new_albums!='') ? $number_of_new_albums : 10;

$taxonomy_title = isset($genres_selection->name) ? $genres_selection->name : 'Hip Hop';
$taxonomy_name = isset($genres_selection->taxonomy) ? $genres_selection->taxonomy : 'genre';
$taxonomy_slug = isset($genres_selection->slug) ? $genres_selection->slug : 'hip-hop';
$post_per_page = ($number_of_post!='') ? $number_of_post : 5;
//$post_type = ($post_selection!='') ? $post_selection : 'ms-albums';



$user_id = get_current_user_id();
$lang_data = get_option('language_filter_ids_'.$user_id);

$genre_slug = '';

if( isset($_GET['genre']) && $_GET['genre']!='' ) {
  $genre_slug = $_GET['genre'];
}else{
  $genre_slug = $taxonomy_slug;
} 

$genreObj = get_term_by( 'slug', $genre_slug, 'genre');
$genreName = $genreObj->name;

$tax_query = array();
if(isset($genre_slug) && $genre_slug !=''){
  $tax_query[] = array ('taxonomy' => 'genre','field' => 'slug','terms' => $genre_slug);
}




$albums_arg = array(
                    'post_type'      => 'ms-albums',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'order' => 'DESC',
                    'tax_query' => $tax_query,
                    );

$albums_query = new WP_Query($albums_arg);
$albums = $albums_query->posts;


$total_albums =  count($albums);

$new_albums = array();
if($total_albums > $post_per_page+5){
  $new_albums = array_slice($albums,5);
}else{
  $new_albums = $albums;
}

//$singles_albums =  $albums;


$genres = get_categories('taxonomy=genre&type=ms-albums');


?>
<main id="main">
   <div class="container">
      <div id="twocolumns">
         <div id="content">
            <div class="search-panel">
               <div class="panel-holder">
                  <strong class="ttl">Search:</strong>
                  <div class="cell">
                     <form action="" class="form-search" method="get">
                        <fieldset>
                           <div class="form-holder">
                              <div class="field">
                                 <select class="search-sel" name="genre">
                                    <option value="" class="hide">Genre</option>
                                    <?php if(!empty($genres)){
                                      foreach ($genres as $genre_key => $genre) {
                                    ?>
                                       <option value="<?php echo $genre->slug;?>" <?php if(isset($_GET['genre']) && $_GET['genre'] == $genre->slug){echo 'selected';}?>><?php echo $genre->name;?></option>
                                    <?php
                                        }
                                      }
                                    ?>
                                    
                                 </select>
                              </div>
                              
                              <div class="btn-field">
                                 <button type="submit"><i class="icon-magnify"></i> Search</button>
                              </div>
                           </div>
                        </fieldset>
                     </form>
                  </div>
               </div>
            </div>
            <section class="rotate-gallery">
               <div class="section-header">
                  <h1><?php echo $genreName;?> Section</h1>
                  <div class="cell"></div>
               </div>
               <div class="gmask-holder">
                  <div class="gmask">
                  <?php

                    // $hiphop_albums_arg = array(
                    // 'post_type'      => $post_type,
                    // 'posts_per_page' => $post_per_page,
                    // 'post_status'    => 'publish',
                    // 'orderby'   => 'rand',
                    // 'order' => 'DESC',
                    // 'tax_query' => array(
                    //                     array (
                    //                         'taxonomy' => $taxonomy_name,
                    //                         'field' => 'slug',
                    //                         'terms' => $taxonomy_slug,
                    //                     )
                    //                 ),
                    // );

                    // $hiphop_albums_query = new WP_Query($hiphop_albums_arg);
                    // $hiphop_albums = $hiphop_albums_query->posts;

                      if(!empty($albums)){
                        foreach ($albums as $albums_key => $hiphop_album) {
                        $album_image = wp_get_attachment_image_src( get_post_thumbnail_id($hiphop_album->ID), 'full' );
                        if($albums_key >= $post_per_page){
                            break;
                        }
                  ?>
                     <div class="slide">
                        <div class="img-box">
                           <a href="<?php echo esc_url(get_permalink($hiphop_album->ID)); ?>"> 
                              <img src="<?php echo $album_image[0];?>" alt="photo" width="252" height="210">
                            </a>
                        </div>
                        <div class="text-holder">
                           <strong class="name">
                              <a href="<?php echo esc_url(get_permalink($hiphop_album->ID)); ?>"><?php echo $hiphop_album->post_title;?></a>
                            </strong>
                            <?php
                              $artists_name = array(); 
                              $artists_ids = fw_get_db_post_option($hiphop_album->ID, 'album_artists');
                              if(!empty($artists_ids)):
                              foreach ($artists_ids as $artists_id) {
                                   $artists_name[] = get_the_title($artists_id);
                               } 
                            ?>

                           <strong class="title">
                            <?php echo implode(', ', $artists_name); ?>
                           </strong>
                         <?php endif; ?>
                        </div>
                     </div>
                   
                    <?php } }else{ echo '<p class="no-found">No albums found</p>';} ?>

                  </div>
               </div>
            </section>

            <section class="album-gallery buttons-control">
               <div class="section-header">
                  <h2>New Albums</h2>
                  <div class="cell"></div>
               </div>
               <div class="gmask">
               <?php 
                   
                 $new_albums_arg = array(
                                   'post_type'      => 'ms-albums',
                                   'posts_per_page' => $new_albums_post_per_page,
                                   'post_status'    => 'publish',
                                   'orderby'   => 'ID',
                                   'order' => 'DESC',
                                   );

                 $new_albums_query = new WP_Query($new_albums_arg);
                 $new_albums_post = $new_albums_query->posts;

                 if(isset($_GET['genre'])){
                  $new_albums = $new_albums;
                  
                 }else{
                  $new_albums = $new_albums_post;
                  
                 }

                 if(!empty($new_albums)){
                  foreach ($new_albums as $new_album_key => $new_album) {
                   $new_album_image = wp_get_attachment_image_src( get_post_thumbnail_id($new_album->ID), 'full' );
                    
               ?>
                  <article class="slide">
                     <div class="slide-holder">
                        <a href="javascript:;" class="img-box add_to_queue" data-musicid="<?php echo $new_album->ID;?>" data-musictype="album" title="Add To Queue">
                        <img src="<?php echo $new_album_image[0];?>" alt="" width="129" height="126">
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
               <?php } }else{ echo '<p class="no-found">No albums found</p>';} ?>
               </div>
            </section>
            <section class="album-gallery buttons-control">
               <div class="section-header">
                  <h2>New Singles</h2>
                  <div class="cell"></div>
               </div>
               <div class="gmask">
                <?php 
                   
                 $singles_albums_arg = array(
                 'post_type'      => 'ms-albums',
                 'post_status'    => 'publish',
                 'orderby'   => 'ID',
                 'order' => 'DESC',
                 
                 );

                 $singles_albums_query = new WP_Query($new_albums_arg);
                 $singles_albums = $singles_albums_query->posts;

                 if(!empty($singles_albums)){
                  foreach ($singles_albums as $singles_album_key => $singles_album) {
                   $singles_album_image =  wp_get_attachment_image_src( get_post_thumbnail_id($singles_album->ID), 'full' );
                    $album_songs = get_post_meta($singles_album->ID,'fw_options',true);
                        
                        if(!empty($album_songs['album_songs']) && count($album_songs['album_songs']) == 1){
               ?>
                  <article class="slide">
                     <div class="slide-holder">
                        <a href="javascript:;" class="img-box add_to_queue" data-musicid="<?php echo $singles_album->ID;?>" data-musictype="album" title="Add To Queue">
                        <img src="<?php echo $singles_album_image[0];?>" alt="" width="129" height="126">
                        <i class="icon-magnify"></i>
                        </a>
                        <div class="text-holder">
                           <h2>
                             <a href="<?php echo esc_url(get_permalink($singles_album->ID)); ?>">
                                <?php echo $singles_album->post_title;?>
                             </a>
                           </h2>
                           <time datetime="<?php echo get_the_date('Y-m-d');?>"><?php echo get_the_date('d.m.Y');?></time>
                        </div>
                     </div>
                  </article>
                <?php }  } }?>
               </div>
            </section>
            <?php
              $key_prefix     = "admin_playlist_meta_key";
              $admin_user_id  = (get_field('admins_playlist','option')!='') ? get_field('admins_playlist','option') : 1;
              $admin_playlist_meta_key = get_user_meta($admin_user_id, $key_prefix, true);
              $admin_playlist = get_user_meta($admin_user_id, $admin_playlist_meta_key, true);

             
              if(!empty($admin_playlist)){
              ?>
              <section class="album-gallery buttons-control">
               <div class="section-header">
                  <h2>New Playlist</h2>
                  <div class="cell"></div>
               </div>
               <div class="gmask">
                  <?php
                    foreach ($admin_playlist as $key_playlist => $playlist_song_id) {
                      $playlist_image = wp_get_attachment_image_src( get_post_thumbnail_id($playlist_song_id), 'full' );

                      $data_type = '';
                      if('ms-albums' == get_post_type($playlist_song_id)){
                        $data_type = 'album';
                      }else if('ms-music' == get_post_type($playlist_song_id)){
                        $data_type = 'music';
                      }else if('ms-artists' == get_post_type($playlist_song_id)){
                        $data_type = 'artist';
                      }
                    ?>
                    <article class="slide">
                     <div class="slide-holder">
                        <a href="javascript:;" class="img-box add_to_queue" data-musicid="<?php echo $playlist_song_id;?>" data-musictype="<?php echo $data_type;?>" title="Add To Queue">
                        <img src="<?php echo $playlist_image[0];?>" alt="" width="129" height="126">
                        <i class="icon-magnify"></i>
                        </a>
                        <div class="text-holder">
                           <h2>
                             <a href="<?php echo esc_url(get_permalink($playlist_song_id)); ?>">
                                <?php echo get_the_title($playlist_song_id);?>
                             </a>
                           </h2>
                           <time datetime="<?php echo get_the_date('Y-m-d',$playlist_song_id);?>"><?php echo get_the_date('d.m.Y');?></time>
                        </div>
                     </div>
                  </article>
                    <?php
                    }
                  ?>
               </div>
            </section>
              <?php
              }
            ?>
            
         </div>
         <?php 
                // Include the featured songs content template.
                get_template_part( 'template-parts/content', 'left-side-bar' );
            ?>
      </div>
   </div>
</main>
<?php get_footer();?>



