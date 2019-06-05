<?php
   /**
    * The template for displaying all single posts
    *
    * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
    *
    * @package Miraculous
    */
   
   get_header();
   
   ?>
<main id="main">
   <div class="container">
      <div id="twocolumns">
         <?php 
            while ( have_posts() ) : the_post();
                  if(get_post_type() =='post'): 
                    get_template_part( 'template-parts/content','single');
                     if ( comments_open() || get_comments_number() ) :
                       comments_template();
                     endif;
                     else:

                       $file = get_stylesheet_directory() . '/template-parts/content-'.get_post_type().'.php';
                      if (file_exists($file)) {
                        get_template_part( 'template-parts/content',get_post_type());
                      }else{
                        get_template_part( 'template-parts/content','handles');
                      }
                  endif;
                endwhile;

            // Include the featured songs content template.
             get_template_part( 'template-parts/content', 'left-side-bar' );
         ?>
        
      </div>
   </div>
</main>
<?php

get_footer();