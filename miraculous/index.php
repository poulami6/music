<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Miraculous
 */
get_header();
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main">
	<?php 
	/**
	 * Miraculous blog content area
	 */
	$miraculous_setting = '';
	if(class_exists('Miraculous_setting')):
		$miraculous_setting = new Miraculous_setting();
	?>
	  <div class="ms_main_wrapper <?php echo esc_attr($miraculous_setting->miraculous_add_class()); ?>"> 
			<div class="container">
			   <div class="row">
					<?php 
					 $miraculous_setting->miraculous_index_blog();
					?>
				</div>
			</div>
		</div>
	<?php endif;  ?>
	</main>
</div> 
<?php get_footer(); ?>