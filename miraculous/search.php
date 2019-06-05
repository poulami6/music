<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Miraculous
 */

get_header();
$miraculous_setting = '';
if(class_exists('Miraculous_setting')):
   $miraculous_setting = new Miraculous_setting();
?> 
<section id="primary" class="content-area">
		<main id="main" class="site-main">
            <div class="ms_main_wrapper <?php echo esc_attr($miraculous_setting->miraculous_add_class()); ?>"> 
				<div class="container">
					<div class="row">
					<?php 
					  $miraculous_setting->miraculous_index_blog();
					?>
					</div> 
				</div>
			</div>
        </main>
</section>
<?php 
endif;
get_footer();