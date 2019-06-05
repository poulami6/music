<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Miraculous
 */

wp_head();
$miraculous_setting = '';
if(class_exists('Miraculous_setting')):
   $miraculous_setting = new Miraculous_setting();
?>  
<main id="main" class="site-main">
    <div class="fd_error_wrapper">
		<div class="ms_error_inner">
			<?php 
			$miraculous_setting->miraculous_404_setting();
			?>
		</div>
	</div>
</main> 
<?php  
endif;
wp_footer(); 