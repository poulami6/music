<?php
/***
 * Template Name:blog
 * 
 * Miraculous Blog Template
 * @package Miraculous
 */
get_header();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="ms_main_wrapper ms_blog_temp">
			<div class="container">
			   <div class="row">
            	 <?php
            	 /**
                  * Get meta setting data
                  */
        		$miraculous_page_data = '';
        		if(function_exists('fw_get_db_post_option')): 
        			$miraculous_page_data = fw_get_db_post_option();   
        		endif; 
        		$theme_sidebar = '';
        		if(!empty($miraculous_page_data['page-sidebar'])):
        			 $theme_sidebar = $miraculous_page_data['page-sidebar'];
        		  else:
        			 $theme_sidebar = esc_html__('right','miraculous');
        		endif;
        		if($theme_sidebar == 'full'):
        			echo '<div class="col-lg-12 col-md-12">';
        		else:
        			if($theme_sidebar == 'left'):
        				echo ' <div class="col-lg-8 col-md-12 push-lg-4">';
        			else:
        				echo ' <div class="col-lg-8 col-md-12">';
        			endif;
        		endif;
                echo '<div class="ms_main_data">';
                            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                		    $args = array(
                                   'post_type' =>'post',
                				   'paged' => $paged,
                				   'post_status' =>'publish',
                                  );
                            $ms_query = new WP_Query($args);
            		        if ( $ms_query->have_posts() ) :
            			    while ($ms_query->have_posts() ) : $ms_query->the_post();
            			    ?>
            			    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <?php 
                            $miraculous_page_data = '';
                            if(function_exists('fw_get_db_post_option')): 
                                $miraculous_page_data = fw_get_db_post_option();   
                            endif; 
                            $theme_sidebar = '';
                            if(!empty($miraculous_page_data['page-sidebar'])):
                                $theme_sidebar = $miraculous_page_data['page-sidebar'];
                            else:
                                $theme_sidebar = esc_html__('right','miraculous');
                            endif;
                            if($theme_sidebar == 'right' || $theme_sidebar == 'left' ):
                                 $thumb_w ='800';
                                 $thumb_h = '500';
                            else:
                               $thumb_w ='1200';
                               $thumb_h = '700';
                            endif;
                            if(has_post_thumbnail(get_the_ID())):
                                $ms_attachment_url = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()), 'full');
                                $thum_image = miraculous_aq_resize($ms_attachment_url, $thumb_w, $thumb_h,false);
                        	endif;	
                        	if(!empty($thum_image)):
                        	?>
                        	 <a href="<?php echo esc_url(get_the_permalink(get_the_ID())); ?>">
                        	    <span class="ms_blog_date"><?php echo get_the_date(); ?></span>
                           	   <img src="<?php echo esc_url($thum_image); ?>" alt="<?php the_title_attribute(); ?>" />
                        	  </a> 
                        	 <?php endif; ?>
                                   <header class="entry-header">
                                		<?php
                                		if ('post' === get_post_type()):
                                		?>
                                		<div class="entry-meta">
                                		<?php
                                		 miraculous_posted_on();
                                		 miraculous_posted_by();
                                		?>
                                		</div><!-- .entry-meta -->
                                		<?php 
                                		endif;
                                		echo '<h3 class="entry-title">';
                                		if(is_sticky() && is_home() ) :
                                		  echo '<div class="sticky-post">
                                			  <i class="fa fa-thumb-tack" aria-hidden="true"></i></div>';
                                		endif;
                                		echo '<a href="'.esc_url( get_permalink() ).'" rel="bookmark">'.get_the_title().'</a></h3>';
                                		?>
                                	</header><!-- .entry-header -->
                                    <div class="entry-content">
                                		<?php
                                		if(function_exists('miraculous_the_excerpt')):
                                	         miraculous_the_excerpt(350);
                                        endif; 
                                		wp_link_pages( array(
                                			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'miraculous' ),
                                			'after'  => '</div>',
                                		) );
                                		?>
                                	</div>
                                    <a href="<?php echo esc_url(get_the_permalink(get_the_ID())); ?>" class="ms_blog_temp_readmore" >
                                      <?php esc_html_e('Read More','miraculous'); ?></a>
                                </article>
                			    <?php
                			    $thum_image = '';
                				endwhile;
                				$GLOBALS['wp_query']->max_num_pages = $ms_query->max_num_pages;
                				miraculous_blogtemp_pagination();
                			    wp_reset_postdata();
                			   else: 
                			      get_template_part( 'template-parts/content', 'none' );
                			   endif;
                		   echo '</div>
                		 </div>';
                		if($theme_sidebar == 'left'):
                		  echo '<div class="col-lg-4 pull-lg-8">
                			  <div class="ms_basic_sidebar">';
                				 get_sidebar();
                		 echo '</div>
                		</div>';
                		endif; 
                		if($theme_sidebar == 'right'):
                		   echo '<div class="col-lg-4">
                			     <div class="ms_basic_sidebar">';
                				 get_sidebar();
                		   echo '</div>
                		    </div>';
                		endif;
                	 ?>
            	</div>
             </div>
        </div>
    </main>
</div>
<?php
get_footer();