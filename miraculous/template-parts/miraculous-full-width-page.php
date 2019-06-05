<?php 
/*
Template Name: Full Width page
*/
get_header();
$miraculous_page_data = '';
if (function_exists('fw_get_db_post_option')):	
	$miraculous_page_data = fw_get_db_post_option();     
endif;
if(!empty($miraculous_page_data['rev_slider'])):
  echo do_shortcode('[rev_slider alias="'.$miraculous_page_data['rev_slider'].'"]'); 
endif;
?>
<div class="ms_content_wrapper">
	<?php
	while ( have_posts() ) : the_post();

		get_template_part( 'template-parts/content', 'full' );

	endwhile; // End of the loop.
	?>
</div>
<?php
get_footer();