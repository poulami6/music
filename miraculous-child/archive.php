<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Miraculous
 */

get_header();
$miraculous_setting = '';
if(class_exists('Miraculous_setting')):
   $miraculous_setting = new Miraculous_setting();
?> 
<main id="main">
   <div class="container">
      <div id="twocolumns">
      	<div id="content">
      		<div class="section-header">
               <h1><?php echo get_the_archive_title();?></h1>
            </div>

         <?php 

			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					if(is_search()):
					   get_template_part( 'template-parts/content', 'search' );
					 else:
					   //get_template_part( 'template-parts/content', get_post_type() );
					   get_template_part( 'template-parts/content', 'archive');
					 endif;
				 endwhile;
			?>
				<div id="content">
					<div class="archive-pagination">
						<?php child_miraculous_numeric_posts_nav();?>
					</div>
				</div>
			<?php
			 	
			else: 
				get_template_part( 'template-parts/content', 'none' );
			endif;
            // Include the featured songs content template.
            //get_template_part( 'template-parts/content', 'left-side-bar' );
            ?>
        </div> <?php 
                // Include the featured songs content template.
                get_template_part( 'template-parts/content', 'left-side-bar' );
            ?>
      </div>
   </div>
</main>
<?php  
endif;
get_footer();