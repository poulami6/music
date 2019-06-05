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
   
global $wpdb;

$arg = array(
   'posts_per_page'=>-1,
   'post_type'=>'ms-news',
   'post_status' => 'publish',
   'orderby'     => 'id',
   'order'       => 'DESC',
   );

   $news_query = new WP_Query($arg);
   $news       = $news_query->posts;

   $artist_ids = array();
   $total_artist_id = array();
   $news_ids = array();
   $unique_artist_id = array();

   if(!empty($news)){
    foreach ($news as $key => $news_data) {
        $artist_ids = get_field('news_of_artist',$news_data->ID);
        foreach ($artist_ids as $artist_key => $artists_id) {
          if(!in_array($artists_id, $total_artist_id)){
            $total_artist_id[] = $artists_id;
            $news_ids[] = $news_data->ID;
          } 
        }
       
    }
    
   }

$totla_news = count($news_ids);
$news_limit = 2;



?>
<main id="main">
   <div class="container">
      <div id="twocolumns">
         <div id="content">
            <div class="section-header">
               <h1>News</h1>
            </div>
            <div class="tab-content">
               <div class="tab-item" id="tab-latest-news">
                  <div class="content-block">
                    <input type="hidden" name="all_news" id="all_news" value="<?php echo !empty($news_ids) ? json_encode($news_ids) : '';?>" data-page="news-page">

                    <input type="hidden" name="news_offset" id="news_offset" data-limit="<?php echo $news_limit;?>">

                     <div class="events-list">
                        <div class="events-list" id="tab_result">
                        <?php
                        $news_ids = !empty($news_ids) ? array_slice($news_ids,0,$news_limit) : array();
                          if(isset($news_ids) && !empty($news_ids)){
                              foreach ($news_ids as $news_key => $news_id) {
                                $image = wp_get_attachment_image_src( get_post_thumbnail_id($news_id), 'thumbnail' );
                                $artist_id_data = get_field('news_of_artist',$news_id);

                                if(empty($image)){
                                    $image = wp_get_attachment_image_src( get_post_thumbnail_id($artist_id_data[0]), 'thumbnail' );
                                 }

                                $content_post = get_post($news_id);
                                $content = $content_post->post_content;
                        ?>
                          <article class="event">
                              <div class="title-holder">
                                 <h3><a href="<?php echo get_the_permalink($news_id);?>"><?php echo get_the_title($news_id);?></a></h3>
                              </div>
                              <div class="visual-box">
                              <?php if(!empty($image)){?>
                                 <div class="img-box">
                                    <a href="<?php echo get_the_permalink($news_id);?>">
                                      <img src="<?php echo $image[0];?>" alt="photo" width="168" height="160">
                                    </a>
                                 </div>
                                <?php } ?>
                                <?php if(!empty($artist_id_data)){?>
                                  <a href="<?php echo get_the_permalink($news_id);?>">
                                    <strong class="title"><?php echo get_the_title($artist_id_data[0]);?></strong>
                                  </a>
                                 <?php } ?>
                                  <em class="date-item"><i class="icon-clock-o"></i> <time datetime="<?php echo get_the_date('Y-m-d',$news_id);?>"><?php echo get_the_date('M, Y',$news_id);?></time></em>
                              </div>
                              <div class="text-holder">
                                 <p class="more"><?php echo $content;?></p>
                              </div>
                           </article>
                        <?php
                              }
                          }
                        ?>
                           
                        </div>
                        <?php 
                           
                          if(!empty($news_ids) && $totla_news > count($news_ids)):
                        ?>
                        <div class="paging-holder">
                          <ul class="paging news-paging">
                             <li class="prev"><a href="JavaScript:void(0);">&laquo;</a></li>
                             <?php
                                for($ai=1; $ai<= ceil($totla_news/$news_limit); $ai++){
                                  
                                
                                  if($ai==1){
                                    $news_current = 'class="newspagination current"';
                                  }else{
                                    $news_current = 'class="newspagination"';
                                  }
                                
                                  $ao = $ai-1;
                                  echo '<li><a href="JavaScript:void(0);" '.$news_current.' id="news_pagin_'.$ai.'" data-pagin="'.$ai.'" data-offset="'.$ao*$news_limit.'">'.$ai.'</a><li/>';
                                  
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