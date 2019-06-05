<?php 
$miraculous_theme_data = '';
if (function_exists('fw_get_db_settings_option')):	
	$miraculous_theme_data = fw_get_db_settings_option();     
endif;
$thumb_w = '';
if(!empty($miraculous_theme_data['logo_width'])):
   $thumb_w = $miraculous_theme_data['logo_width'];
endif;
$thumb_h = '';
if(!empty($miraculous_theme_data['logo_height'])):
   $thumb_h = $miraculous_theme_data['logo_height'];
endif;
$logo_svgcode = '';
if(!empty($miraculous_theme_data['logo_svgcode'])):
   $logo_svgcode = $miraculous_theme_data['logo_svgcode'];
else:
	$logo_image = '';
	if(!empty($miraculous_theme_data['logo_image']['url'])):
	   $attachment_id = $miraculous_theme_data['logo_image']['attachment_id'];
	   $logoimage_url = wp_get_attachment_url($attachment_id, 'full');
	   $logo_image = miraculous_aq_resize($logoimage_url, $thumb_w, $thumb_h , true); 
	else:
	   $theme_layout = '';
		if(!empty($miraculous_theme_data['miraculous_layout'])):
		   $theme_layout = $miraculous_theme_data['miraculous_layout'];
		endif;
		if($theme_layout == 1):
		     $logo_image = get_template_directory_uri().'/assets/images/logo.png';
		else:
		     $logo_image = get_template_directory_uri().'/assets/images/logo_red.png';
		endif;  
	endif;
endif;  
?>
<div class="ms_basic_header">
	<div class="container">
		<div class="row">
			<div class="col-lg-2 col-md-2">
				<div class="ms_basic_logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="<?php esc_attr_e('home','miraculous'); ?>">
					<?php
					if(!empty($logo_svgcode)):
						printf($logo_svgcode);
					else:
					if(!empty($logo_image)):
					?>
					<img src="<?php echo esc_url($logo_image); ?>" alt="<?php esc_attr_e('Logo Image','miraculous');?>">
					<?php endif; 
					endif;
					?>
					</a>
				</div>
			</div>  
			<div class="col-lg-10 col-md-10">
				<div class="ms_menu_bar">
					<i class="fa fa-bars" aria-hidden="true"></i>
				</div>
				<div class="ms_basic_menu">
					<nav>
						<?php 
						wp_nav_menu( array(
								'theme_location' => 'primary',
								'menu_class'     => 'primary-menu',
								'fallback_cb'=> 'miraculous_menu_editor'
							) ); 
						?>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>