<?php
   /**
    * Template Name: Artists Page
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
   
   
   ?>
<main id="main">
   <div class="container">
      <div id="twocolumns">
         <div id="content">
            <div class="section-header">
               <h1>Artists</h1>
            </div>
            <div class="tab-content">
               <div class="tab-item" id="tab-all">
                  <div class="content-block">
                     
                     <form action="" class="search-feature" method="get">
                        <fieldset>
                           <div class="text-field">
                              <input type="text" name="ar" id="artist_name" autocomplete="off" value="<?php echo isset($_GET['ar']) ? $_GET['ar'] : '';?>">
                           </div>
                           <input type="submit" value="SEARCH" class="button">
                        </fieldset>
                     </form>
                     <div class="alphabet-list">
                        <strong class="ttl">Popular Artists:</strong>
                        <div class="list-holder">
                           <ul>
                           <li class="link-arists active" id="search_id"><a href="<?php echo get_the_permalink(get_the_id());?>" data-search="All">All</a></li>
                          <li class="link-arists show-arists" id="search_id_0-9"><a href="javascript:;" data-search="0-9">0-9</a></li>
                              <?php
                                 $a_z = range('A', 'Z');

                                 foreach ($a_z as $a_key => $column){
                                      
                                       echo '<li class="link-arists show-arists" id="search_id_'.$a_key.'"><a href="javascript:;" data-search="'.$column.'">'.$column.'</a></li>';
                                 } 
                                 
                              ?>
                           </ul>
                        </div>
                     </div>
                     
                     <div class="search-result search_result" id="tab_result">
                     <?php

                     if( isset($_GET['ar']) && $_GET['ar'] !=''){
                        $artist_limit = -1;
                        $page = '';
                        $search_term = $_GET['ar'];
                     }else{
                        $artist_limit = 3;
                        $page = get_query_var('paged') ? get_query_var('paged') : 1;
                        $search_term = '';
                     }
                        
                        
                        $arg = array(
                           'posts_per_page'=>$artist_limit,
                           'post_type'=>'ms-artists',
                           's' => $search_term,
                           'post_status' => 'publish',
                           'orderby'     => 'title', 
                           'order'       => 'ASC',
                           'paged' => $page
                        );
                        $artist_query = new WP_Query($arg);
                        $num_pages = $artist_query->max_num_pages;

                        if ( $artist_query->have_posts() ) :
                     ?>

                        <ul>
                        <?php  while ( $artist_query->have_posts() ) : $artist_query->the_post();?>
                           <li><a href="<?php the_permalink(); ?>"><span><?php echo get_the_title(); ?></span></a></li>
                        <?php endwhile;?>
                        </ul>
                     <?php

                        else:
                           echo '<p class="no-found">No Artist Found.</p>';
                        endif;
                        
                     ?>
                     </div>
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