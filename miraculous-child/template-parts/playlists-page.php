<?php
   /**
    * Template Name: Playlists Page
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
                    

$moods = get_categories('taxonomy=playlist-mood&type=ms-playlist');

?>
      <main id="main">
         <div class="container">
            <div id="twocolumns">
               <div id="content">
                  <div class="sorting-panel">
                     <div class="panel-holder">
                        <strong class="ttl"><?php //_e('Search');?></strong>
                        <div class="cell">
                           <form action="" method="get" class="sorting-form">
                              <fieldset>
                                 <div class="form-holder">
                                    <div class="field">
                                       <select name="m">
                                          <option class="hide"><?php _e('Mood');?></option>
                                          <?php 
                                             if(!empty($moods)){
                                                foreach ($moods as $moodkey => $moods) {?>
                                                   <option value="<?php echo $moods->slug;?>" <?php if(isset($_GET['m']) && $_GET['m'] == $moods->slug){ echo 'selected';} ?>><?php echo $moods->name;?></option>
                                          <?php } }?>
                                       </select>
                                    </div>
                                    <div class="btn-field">
                                       <button type="submit" class="button"><?php _e('Search');?></button>
                                    </div>
                                 </div>
                              </fieldset>
                           </form>
                        </div>
                     </div>
                  </div>
                  <div id="tab_result">
                  <?php

                     $tax_query = array();
                     if(isset($_GET['m']) && $_GET['m'] !=''){
                       $tax_query[] = array ('taxonomy' => 'playlist-mood','field' => 'slug','terms' => $_GET['m']);
                     }

                     $count_query = new WP_Query(array('posts_per_page'=>-1,'post_type'=>'ms-playlist','tax_query' => $tax_query,'post_status' => 'publish'));
                     $total_spotlight = $count_query->found_posts;
                     
                     $limit = 3;
                     $page = get_query_var('paged') ? get_query_var('paged') : 1;
                     $arg = array(
                     'posts_per_page'=>$limit,
                     'post_type'=>'ms-playlist',
                     'post_status' => 'publish',
                     'orderby'     => 'title', 
                     'order'       => 'ASC',
                     'tax_query' => $tax_query,
                     'paged' => $page
                     );

                     $playlist_query = new WP_Query($arg);
                     $show_playlist = $playlist_query->found_posts;
                     $num_pages = $playlist_query->max_num_pages;
                     if ( $playlist_query->have_posts() ) :
                        while ( $playlist_query->have_posts() ) : 
                           $playlist_query->the_post();
                           
                           $image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_id()), 'thumbnail' );

                           $playlists = get_field('add_playlist',get_the_id());

                  ?>
                  <section class="album-gallery buttons-control">
                     <div class="section-header">
                        <h2><?php echo get_the_title();?></h2>
                        <div class="cell"></div>
                     </div>
                     <div class="gmask">
                     <?php
                        if(!empty($playlists)){
                           foreach ($playlists as $playlist_key => $playlist) {
                              $playlist_image = wp_get_attachment_image_src( get_post_thumbnail_id($playlist), 'thumbnail' );
                        ?>
                           <article class="slide">
                           <div class="slide-holder">
                              <a class="img-box" href="javascript:;">
                              <?php if(!empty($playlist_image)){?>
                                 <img src="<?php echo $playlist_image[0];?>" alt="" width="129" height="126">
                                 <i class="icon-magnify"></i>
                                 <?php } ?>
                              </a>
                              <div class="text-holder">
                                 <h2><a href="javascript:;"><?php echo get_the_title($playlist);?></a></h2>
                                 <time datetime="<?php echo get_the_date('Y.m.d',$playlist);?>"><?php echo get_the_date('Y.m.d',$playlist);?></time>
                              </div>
                           </div>
                        </article>
                        <?php
                           }
                        }
                     ?>
                        
                        
                     </div>
                  </section>

               <?php endwhile; endif;?>
               
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



