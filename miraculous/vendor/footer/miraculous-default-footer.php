<?php 
$miraculous_theme_data = $miraculous_footer_class = '';
if (function_exists('fw_get_db_settings_option')):  
    $miraculous_theme_data = fw_get_db_settings_option(); 
else:
 $miraculous_footer_class = 'ms_footershdow_widget';   
endif;
$shadow_switch = '';
if(! empty( $miraculous_theme_data['shadow_switch'] )):
   $shadow_switch = $miraculous_theme_data['shadow_switch'];
endif;
if($shadow_switch == 'on'):
  $miraculous_footer_class = 'ms_footershdow_widget';
else:
  $miraculous_footer_class = '';   
endif;
$bg_image = '';
if ( ! empty( $miraculous_theme_data['footer_bg_image'] ) && ! empty( $miraculous_theme_data['footer_bg_image']['url']) ):
	$bg_image = 'style='.'background-image:url(' . $miraculous_theme_data['footer_bg_image']['url'] . ');';
endif;
?>
<div class="ms_footer ms_footer_wrapper" <?php echo esc_attr($bg_image); ?>>
    <?php 
	$footer_logo_switch ='';
	if(!empty($miraculous_theme_data['footer_logo'])):
	   $footer_logo_switch = $miraculous_theme_data['footer_logo'];
	endif;
	$thumb_w = '';
	if(!empty($miraculous_theme_data['flogo_width'])):
	   $thumb_w = $miraculous_theme_data['flogo_width'];
	endif;
	$thumb_h = '';
	if(!empty($miraculous_theme_data['flogo_height'])):
	   $thumb_h = $miraculous_theme_data['flogo_height'];
	endif;
	$logo_svgcode = '';
	if(!empty($miraculous_theme_data['flogo_svgcode'])):
	   $logo_svgcode = $miraculous_theme_data['flogo_svgcode'];
	else:
		$logo_image = '';
		if(!empty($miraculous_theme_data['flogo_image']['url'])):
		   $footer_logo_image = $miraculous_theme_data['flogo_image']['attachment_id'];
		   $logoimage_url = wp_get_attachment_url($footer_logo_image, 'full');
		   $logo_image = miraculous_aq_resize($logoimage_url, $thumb_w, $thumb_h , false); 
		else:  
		   $logo_image = get_template_directory_uri().'/assets/images/open_logo.png';
		endif;
	endif; 
	$header_style = '';
	if(!empty($miraculous_theme_data['header_style'])):
		$header_style =  $miraculous_theme_data['header_style'];
	endif;
	if($header_style == 'style-one'):
	   $containerclass='container-fluid';
	   $inerclass = 'ms_footer_inner';
	else:
	   $containerclass='container';
	   $inerclass = '';
	endif;
	$footer_copyrigth ='';
	if(!empty($miraculous_theme_data['footer_copyrigth'])):
	   $footer_copyrigth = $miraculous_theme_data['footer_copyrigth'];
	endif;
    if($footer_logo_switch == 'on'): ?>
        <div class="ms_footer_logo">
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
    <?php endif; ?>
    <?php if( is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4') ): ?>
        <div class="<?php echo esc_attr($containerclass); ?>">
			<div class="<?php echo esc_attr($inerclass); ?>">
            <div class="row <?php echo esc_attr($miraculous_footer_class); ?>">
                <div class="col-lg-3 col-md-6">
                    <div class="footer_box">
                        <?php dynamic_sidebar('footer-1');  ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer_box">
                        <?php dynamic_sidebar('footer-2');  ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer_box">
                        <?php dynamic_sidebar('footer-3');  ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer_box">
                        <?php dynamic_sidebar('footer-4');  ?>
                    </div>
                </div>
            </div>
			</div>
        </div>
    <?php endif; ?>
    <div class="col-lg-12">
        <div class="ms_copyright">
            <div class="footer_border"></div>
            <div class="site-info">
                <?php if(!empty($footer_copyrigth)): ?>
                    <p><?php esc_html($footer_copyrigth); ?></p>
                <?php else: ?>
                   <p><?php esc_html_e('&copy; Copyright 2018, All Rights Reserved','miraculous'); ?><a href="<?php echo esc_url('https://themeforest.net/user/kamleshyadav'); ?>">
				    <?php esc_html_e('Miraculous','miraculous'); ?></a></p>
                <?php endif; ?>
            </div>
        </div> 
    </div>
</div>