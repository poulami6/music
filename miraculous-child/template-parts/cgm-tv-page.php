

<?php
   /**
    * Template Name: CGM TV Page
    *
    * @package WordPress
    * @subpackage Twenty_Sixteen
    * @since Twenty Sixteen 1.0
    */
   get_header();
   

   global $wp_query;


  
  $user_id = get_current_user_id(); 



   ?>
      <main id="main">
         <div class="container">
            <div id="twocolumns">
               <div id="content">
                  <div class="section-header result-header">
                     <h1><?php _e('CGM TV');?></h1>
                  </div>
                  
                 
                     <div class="" id="tab_result">
                        <div class="content-block" id="">
                         
                           <?php

                              $count_query = new WP_Query(array('posts_per_page'=>-1,'post_type'=>'ms-cgmtv','post_status' => 'publish'));
                              $total_cgmtv = $count_query->found_posts;
                              
                              $limit = 2;
                              $page = get_query_var('paged') ? get_query_var('paged') : 1;
                              $arg = array(
                              'posts_per_page'=>$limit,
                              'post_type'=>'ms-cgmtv',
                              'post_status' => 'publish',
                              'orderby'     => 'title', 
                              'order'       => 'ASC',
                              'paged' => $page
                              );

                              $cgmtv_query = new WP_Query($arg);
                              $show_cgmtv = $cgmtv_query->found_posts;
                              $num_pages = $cgmtv_query->max_num_pages;
                              if ( $cgmtv_query->have_posts() ) :
                           ?>
                           <ul class="media-list">
                            <?php  while ( $cgmtv_query->have_posts() ) : $cgmtv_query->the_post();
                                      $tv_links = '';
                                      if( have_rows('cgm_tv') ):
                                        while ( have_rows('cgm_tv') ) : the_row();
                                          if($tv_links=='') $tv_links = get_sub_field('tv_links');
                                        endwhile;
                                        else :
                                      endif;
                                 
                                  $video_id = getYouTubeVideoId($tv_links);
                                  $thumbnail="http://img.youtube.com/vi/".$video_id."/hqdefault.jpg";

                            ?>
                              <li>
                                 <a href="<?php echo get_the_permalink();?>" class="img-box">
                                 <?php if(!empty($thumbnail)):?>
                                    <img src="<?php echo $thumbnail;?>" alt="video image" width="150" height="142">
                                 <?php endif;?>
                                    <span class="btn-play">Play</span>
                                 </a>
                                 <div class="text-holder">
                                    <strong class="title"><a href="<?php echo get_the_permalink();?>"><?php echo get_the_title();?></a></strong>

                                    <strong class="category"><a href="javascript:;"><?php  echo get_the_term_list(get_the_id(), 'cgmtv-categories', '', ', ' );;?></a></strong>
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

