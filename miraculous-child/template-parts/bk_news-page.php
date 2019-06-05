<?php
   /**
    * Template Name: News Page
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

global $wp_query;


$news_type = isset($wp_query->query_vars['type']) ? $wp_query->query_vars['type'] : '';;  
$tax_query = array();
if(isset($news_type) && $news_type !=''){
  $tax_query[] = array ('taxonomy' => 'news-type','field' => 'slug','terms' => $news_type);
}

   $count_news = new WP_Query(array('posts_per_page'=>-1,'post_type'=>'ms-news','tax_query' => $tax_query,'post_status' => 'publish'));
   $total_news = $count_news->found_posts;
   
   $limit = 3;
   $page = get_query_var('paged') ? get_query_var('paged') : 1;
   $arg = array(
   'posts_per_page'=>$limit,
   'post_type'=>'ms-news',
   'post_status' => 'publish',
   'orderby'     => 'modified',
   'order'       => 'DESC',
   'tax_query' => $tax_query,
   'paged' => $page
   );

   $news_query = new WP_Query($arg);
   $news       = $news_query->posts;
   $show_news = $news_query->found_posts;
   $num_pages = $news_query->max_num_pages;
   
   $first_artist_id = '';
   $artist_name = '';
   $artist_image = '';
   if(!empty($news)){
      $first_artist_id = get_field('news_of_artist',$news[0]->ID);
      $artist_name = get_the_title($first_artist_id[0]);
      $artist_image = wp_get_attachment_image_src( get_post_thumbnail_id($first_artist_id[0]), 'thumbnail' );

      $all_allbum = get_all_albums_post_name_for_artist($first_artist_id[0]);
      $all_music = get_all_music_post_name_for_artist($first_artist_id[0]);
      $photos = get_field('artist_gallery',$first_artist_id[0]);
      $artist_photo = array();
      if(!empty($photos)){
         foreach ($photos as $key => $photo) {
            $artist_photo[] = $photo['url'];
         }
      }
      
   }


   $total_album = isset($all_allbum) ? count($all_allbum) : 0;
   $total_song = isset($all_music) ? count($all_music) : 0;
   $total_photo = isset($artist_photo) ? count($artist_photo) : 0;

   $args = array(
                'type'                     => 'ms-news',
                'child_of'                 => 0,
                'parent'                   => '',
                'orderby'                  => 'term_id',
                'order'                    => 'ASC',
                'hide_empty'               => false,
                'hierarchical'             => 1,
                'exclude'                  => '',
                'include'                  => '',
                'number'                   => '',
                'taxonomy'                 => 'news-type',
                'pad_counts'               => false
            );

   $cats = get_categories( $args );

   
?>
<main id="main">
   <div class="container">
      <div id="twocolumns">
         <div id="content">
            <div class="section-header">
               <h1>News</h1>
            </div>
            <?php if($artist_name!=''){?>
            <div class="row">
               <div class="col-8">
                  <div class="content-block news-subject">
                     <h2><?php echo $artist_name;?></h2>
                     <?php if(!empty($artist_image)){?>
                     <img src="<?php echo $artist_image[0];?>" alt="<?php echo $artist_name;?>" width="420" height="215">
                     <?php } ?>
                     <p>For more information on this artist <a href="<?php echo get_the_permalink($news[0]->ID);?>">CLICK HERE</a></p>
                  </div>
               </div>
               <div class="col-4">
                  <section class="feature-section feature-gallery">
                     <div class="title-box">
                        <h2>Related</h2>
                     </div>
                     <div class="gmask">
                        <div class="slide">
                           <ul class="feature-list">
                              <li>
                                 <a href="#">
                                    <div class="text-holder">
                                       <strong class="name">Pictures</strong>
                                       <p><?php echo $total_photo;?></p>
                                    </div>
                                 </a>
                              </li>
                              <li>
                                 <a href="#">
                                    <div class="text-holder">
                                       <strong class="name">Albums</strong>
                                       <p><?php echo $total_album;?></p>
                                    </div>
                                 </a>
                              </li>
                              <li>
                                 <a href="#">
                                    <div class="text-holder">
                                       <strong class="name">Songs</strong>
                                       <p><?php echo $total_song;?></p>
                                    </div>
                                 </a>
                              </li>
                              <!-- <li>
                                 <a href="#">
                                    <div class="text-holder">
                                       <strong class="name">Radio</strong>
                                       <p>174</p>
                                    </div>
                                 </a>
                              </li> -->
                           </ul>
                        </div>
                     </div>
                  </section>
               </div>
            </div>
            <?php }?>
            <ul class="spotlight-list">
               <li class="<?php if(!isset($wp_query->query_vars['type']) || $wp_query->query_vars['type'] == ''){echo 'active';}?>"><a href="<?php echo get_the_permalink(get_the_id());?>"><span>Latest News</span></a></li>
               <?php if(!empty($cats)){
                 foreach ($cats as $news_key => $cat_news) {
               ?>
               <li class="<?php if(isset($wp_query->query_vars['type']) && $wp_query->query_vars['type'] == $cat_news->slug){echo 'active';}?>"><a href="<?php echo get_the_permalink(get_the_id()).'/'.$cat_news->slug;?>" data-spotlight="<?php echo $cat_news->slug;?>"><span><?php echo $cat_news->name;?></span></a></li>
              <?php
                   }
                 }
               ?>
            </ul>
            <div class="tab-content">
               <div class="tab-item" id="tab-latest-news">
                  <div class="content-block">
                     <!-- <div class="section-header">
                        <h2>Lady Gaga News</h2>
                     </div> -->
                     <div class="events-list" id="tab_result">
                     <?php
                        if ( $news_query->have_posts() ) :
                           while ( $news_query->have_posts() ) : $news_query->the_post();
                                 $image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_id()), 'thumbnail' );

                                 $artist_id = get_field('news_of_artist',get_the_id());

                                 if(empty($image)){
                                    $image = wp_get_attachment_image_src( get_post_thumbnail_id($artist_id[0]), 'thumbnail' );
                                 }
                     ?>
                        <article class="event">
                           <div class="title-holder">
                              <h3><a href="<?php echo get_the_permalink();?>"><?php echo get_the_title();?></a></h3>
                           </div>
                           <div class="visual-box">
                              
                              <?php if(!empty($image)):?>
                                 <div class="img-box">
                                    <img src="<?php echo $image[0];?>" alt="photo" width="168" height="160">
                                 </div>
                              <?php endif;?>
                              
                              <strong class="title"><?php echo get_the_title($artist_id[0]);?></strong>
                              <em class="date-item"><i class="icon-clock-o"></i> <time datetime="<?php echo get_the_date('Y-m-d');?>"><?php echo get_the_date('M, Y');?></time></em>
                           </div>
                           <div class="text-holder">
                              <p><?php echo wp_trim_words(get_the_content(), 76, ' ... <a href="'.get_the_permalink(get_the_id()).'" class="more">Read More</a>' );?></p>
                              
                           </div>
                        </article>
                     <?php 
                        endwhile;
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
                                    echo '<ul class="paging">';
                                      foreach ( $links as $link ) {
                                              echo "<li>$link</li>";
                                      }
                                       echo '</ul>';
                                   }
                                 ?>
                              </div>
                     <?php endif; wp_reset_postdata(); ?>
                     <?php
                        else:
                           echo '<p class="no-found">No News Found.</p>';
                        endif;
                     ?>
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