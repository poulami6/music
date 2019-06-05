<?php
   /**
    * Template Name: Spotlight Page
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
    'type'                     => 'ms-spotlight',
    'child_of'                 => 0,
    'parent'                   => '',
    'orderby'                  => 'term_id',
    'order'                    => 'ASC',
    'hide_empty'               => false,
    'hierarchical'             => 1,
    'exclude'                  => '',
    'include'                  => '',
    'number'                   => '',
    'taxonomy'                 => 'spotlight-type',
    'pad_counts'               => false
);

$cats = get_categories( $args );


?>
      <main id="main">
         <div class="container">
            <div id="twocolumns">
               <div id="content">
                  <div class="section-header result-header">
                     <h1>Spotlight</h1>
                  </div>
                  <ul class="spotlight-list">
                     <li class="active"><a href="<?php echo get_the_permalink(get_the_id());?>"><span>All Videos</span></a></li> 
                     <!-- <li class="spotlight_link active" id="all-tab"><a href="javascript:;" data-spotlight="All"><span>All Videos</span></a></li> -->
                     <?php if(!empty($cats)){
                       foreach ($cats as $spotlight_key => $cat_spotlight) {
                     ?>
                     <li class="spotlight_link" id="<?php echo $cat_spotlight->slug;?>"><a href="javascript:;" data-spotlight="<?php echo $cat_spotlight->slug;?>"><span><?php echo $cat_spotlight->name;?></span></a></li>
                    <?php
                         }
                       }
                     ?>
                  </ul>
                  
                     <div class="" id="tab_result">
                        <div class="content-block" id="tab_result">
                           <div class="section-header">
                              <h2>Music</h2>
                           </div>
                           <?php

                              $count_query = new WP_Query(array('posts_per_page'=>-1,'post_type'=>'ms-spotlight','post_status' => 'publish'));
                              $total_spotlight = $count_query->found_posts;
                              
                              $limit = 3;
                              $page = get_query_var('paged') ? get_query_var('paged') : 1;
                              $arg = array(
                              'posts_per_page'=>$limit,
                              'post_type'=>'ms-spotlight',
                              'post_status' => 'publish',
                              'orderby'     => 'title', 
                              'order'       => 'ASC',
                              'paged' => $page
                              );

                              $spotlight_query = new WP_Query($arg);
                              $show_spotlight = $spotlight_query->found_posts;
                              $num_pages = $spotlight_query->max_num_pages;
                              if ( $spotlight_query->have_posts() ) :
                           ?>
                           <ul class="media-list">
                            <?php  while ( $spotlight_query->have_posts() ) : $spotlight_query->the_post();
                                  $image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_id()), 'thumbnail' );
                                 
                            ?>
                              <li>
                                 <a href="<?php echo get_the_permalink();?>" class="img-box">
                                 <?php if(!empty($image)):?>
                                    <img src="<?php echo $image[0];?>" alt="video image" width="150" height="142">
                                 <?php endif;?>
                                    <span class="btn-play">Play</span>
                                 </a>
                                 <div class="text-holder">
                                    <strong class="title"><a href="<?php echo get_the_permalink();?>"><?php echo get_the_title();?></a></strong>

                                    <strong class="category"><a href="javascript:;"><?php  echo get_the_term_list(get_the_id(), 'spotlight-type', '', ', ' );;?></a></strong>
                                 </div>
                              </li>
                           <?php endwhile;?>
                           </ul>
                           <?php

                              else:
                                 echo '<p class="no-found">No spotlight Found.</p>';
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
                    
                  
               </div>
               <?php 
                  // Include the featured songs content template.
                  get_template_part( 'template-parts/content', 'left-side-bar' );
               ?>
            </div>
         </div>
      </main>
<?php get_footer();?>



