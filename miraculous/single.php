<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Miraculous
 */

get_header();
$miraculous_setting = '';
if(class_exists('Miraculous_setting')):
  $miraculous_setting = new Miraculous_setting();
    $miraculous_theme_data = '';
	if (function_exists('fw_get_db_settings_option')):	
			$miraculous_theme_data = fw_get_db_settings_option();     
    endif;
	$theme_layout = '';
	if(!empty($miraculous_theme_data['miraculous_layout'])):
		$theme_layout = $miraculous_theme_data['miraculous_layout'];
   endif;
   
    if($theme_layout == 1):
        
    $miraculous_page_data = '';
    if(function_exists('fw_get_db_post_option')): 
        $miraculous_page_data = fw_get_db_post_option();   
    endif;
    
    $post_bgimages_switch = '';
    if(!empty($miraculous_page_data['post_bgimages_switch'])):
      $post_bgimages_switch = $miraculous_page_data['post_bgimages_switch'];
    endif;
    $bgimage_style = '';
   if($post_bgimages_switch == 'on'):
       
        $single_bg_images = '';
        if(!empty($miraculous_page_data['single_bg_images'])):
          $single_bg_images = $miraculous_page_data['single_bg_images'];
        endif;
        
        if(!empty($single_bg_images)):
           $bg_imag = $single_bg_images;
        else:
            $bg_imag = get_template_directory_uri().'/assets/images/bg.jpg';
        endif;
        $bg_image = 'background-image:url(' . $bg_imag. ');';
        $bgimage_style = ($bg_imag) ? 'style="' . esc_attr($bg_image) . '"' : ''; 
     endif;
    else:
       $bgimage_style = '';
    endif;
?>
<div id="primary" class="content-area" <?php printf($bgimage_style); ?>>
	<main id="main" class="site-main">
        <div class="ms_main_wrapper ms_main_wrapper_single">
		       <?php 
				 if(get_post_type() == 'post'):
					  echo '<div class="container">';
				  else:
					  echo '<div class="container-fluid">'; 
				  endif;
			    ?>
				<div class="row">
				<?php 
				 $miraculous_setting->miraculous_blog_single_setting(get_the_ID());
				?> 
				</div>
			</div>
		</div>
	</main> 
</div>
<?php
endif;
get_footer(); 