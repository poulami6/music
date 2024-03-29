<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Miraculous
 */
get_header();
$miraculous_setting = '';
if(class_exists('Miraculous_setting')):
   $miraculous_setting = new Miraculous_setting();

//$current_balance = woo_wallet()->wallet->get_wallet_balance( get_current_user_id() );

?>
<!-- <div id="primary" class="content-area">
		<main id="main" class="site-main">
            <div class="ms_main_wrapper <?php echo esc_attr($miraculous_setting->miraculous_add_class()); ?>"> 
				<div class="container">
				   <div class="row"> 
					<?php 
					//$miraculous_setting->miraculous_pages_setting(get_the_ID());
					?>
					</div>
				</div>
			</div>
     </main>
</div> -->
<main id="main">
   <div class="container">
      <div id="twocolumns">
         <?php 
           
         	if ( have_posts() ) :
			    while ( have_posts() ) : the_post();
				
					get_template_part( 'template-parts/content', 'page'); 
					
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;  
					
				endwhile;
				miraculous_numeric_posts_nav();
			  else: 
			    get_template_part( 'template-parts/content', 'none' );
			  endif;
            // Include the featured songs content template.
             get_template_part( 'template-parts/content', 'left-side-bar' );
         ?>
        
      </div>
   </div>
</main>
<?php  
endif;
get_footer();