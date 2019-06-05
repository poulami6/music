<?php 
/**
 * Theme Option Setting Class
 */
class Miraculous_setting {
  /**
     * class construct
     */

	public function __construct(){

		/**
         * Get theme setting data
         */

		$miraculous_theme_data = '';
        if (function_exists('fw_get_db_settings_option')):	
            $miraculous_theme_data = fw_get_db_settings_option();     
        endif; 

		/**
         * Get meta setting data
         */
        $miraculous_meta_data = '';
        if (function_exists('fw_get_db_post_option')): 
            $miraculous_meta_data = fw_get_db_post_option();   
        endif; 

	}
	/**
     * Add Class ms_side_wrapper 
     */	 
	public function miraculous_add_class(){
		
		$miraculous_theme_data = '';
        if (function_exists('fw_get_db_settings_option')):	
            $miraculous_theme_data = fw_get_db_settings_option();     
        endif; 
		$header_style = '';
		if(!empty($miraculous_theme_data['header_style'])):
		   $header_style = $miraculous_theme_data['header_style'];
		endif;
		
		if($header_style=='style-one'):
		   echo esc_html__('ms_side_wrapper','miraculous');
		else:
		    
		endif; 
	}
	/**
	 * Header page Setting
     */
	public function miraculous_header_setting(){
		/**
		 * Get theme setting data
		 */
		$miraculous_data = '';
		if (function_exists('fw_get_db_settings_option')):	
			$miraculous_data = fw_get_db_settings_option();     
		endif; 
		if( function_exists('miraculous_theme_loader') ):
		  $loader ='';
		  if(!empty($miraculous_data['loader_switch'])):
			$loader = $miraculous_data['loader_switch'];
		  endif;
		  $loader_img ='';
		  if(!empty($miraculous_data['loader_image'])):
			$loader_img = $miraculous_data['loader_image'];
		  endif;
		  miraculous_theme_loader($loader, $loader_img);
		endif;
		$header_style = '';
		if(!empty($miraculous_data['header_style'])):
		 $header_style =  $miraculous_data['header_style'];
		endif;
		switch ($header_style):
			case 'default':
				get_template_part( 'vendor/header/miraculous-default', 'header' );
				break;
			case 'style-one':
				get_template_part( 'vendor/header/miraculous-header', 'style-one');
				break;
			default:
				get_template_part( 'vendor/header/miraculous-default', 'header' );
		endswitch;
		$addclass_style = '';
		if($header_style =='style-one'):
		   $addclass_style = '';
	    else:
		   $addclass_style = 'ms-default-warapper'; 
	    endif;
		echo '<div id="content" class="site-content '. esc_attr($addclass_style).'">';
	 }
	/**
	 * Breadcrumbs Setting
     */
	public function miraculous_breadcrumbs_setting(){
		/**
		 * Get theme setting data
		 */
		$miraculous_theme_data = '';
		if (function_exists('fw_get_db_settings_option')):	
			$miraculous_theme_data = fw_get_db_settings_option();     
		endif;
		/**
		 * Get meta setting data
		 */
		$miraculous_page_header_data = '';
		if (function_exists('fw_get_db_post_option')): 
			$miraculous_page_header_data = fw_get_db_post_option();   
		endif;
		$breadcrumbs = '';
		if(!empty($miraculous_theme_data['breadcrumbs_switch'])):
		   $breadcrumbs =  $miraculous_theme_data['breadcrumbs_switch'];
		else:
		 $breadcrumbs = 'on';
		endif;
		if( is_page() && !empty($miraculous_page_header_data['page_breadcrumbs_switch']) || is_single() && !empty($miraculous_page_header_data['post_breadcrumbs_switch']) ):
		    if(is_page()):
			   $breadcrumbs =  $miraculous_page_header_data['page_breadcrumbs_switch'];
			else:
			  $breadcrumbs =  $miraculous_page_header_data['post_breadcrumbs_switch']; 
			endif;
		else:
		    $breadcrumbs = 'on';
		endif;
        
        if($breadcrumbs == 'on'):
		  miraculous_theme_breadcrumbs();
		endif;
	}
	/**
	 * Index page Setting
     */	
	public function miraculous_index_blog(){
		
		$miraculous_theme_data = '';
		if (function_exists('fw_get_db_settings_option')):	
			$miraculous_theme_data = fw_get_db_settings_option();     
		endif;
		$theme_sidebar = '';
		if(!empty($miraculous_theme_data['blog_sidebar'])):
		    $theme_sidebar = $miraculous_theme_data['blog_sidebar'];
		else:
			$theme_sidebar = esc_html__('right','miraculous');
		endif;
		if($theme_sidebar == 'full'):
			echo '<div class="col-lg-12 col-md-12">';
		else:
			if($theme_sidebar == 'left'):
				echo '<div class="col-lg-8 col-md-12 push-lg-4">';
			else:
				echo '<div class="col-lg-8 col-md-12">';
			endif;
		endif;
		
		echo '<div class="ms_main_data">';
		      if ( have_posts() ) :
			    while ( have_posts() ) : the_post();
					if(is_search()):
					   get_template_part( 'template-parts/content', 'search' );
					 else:
					   get_template_part( 'template-parts/content', get_post_type() );
					 endif;
				 endwhile;
				 miraculous_numeric_posts_nav();
			  else: 
			    get_template_part( 'template-parts/content', 'none' );
			  endif;
		    
	    echo '</div>
		 </div>';
		if($theme_sidebar == 'left'):
		  echo '<div class="col-lg-4 pull-lg-8">
			  <div class="ms_basic_sidebar">';
				 get_sidebar();
		 echo '</div>
		</div>';
		endif; 
		if($theme_sidebar == 'right'):
		   echo '<div class="col-lg-4">
			     <div class="ms_basic_sidebar">';
				 get_sidebar();
		   echo '</div>
		    </div>';
		endif;
		
	}
	/**
	 * Pages page Setting
     */	
	public function miraculous_pages_setting($pageid){
		/**
		 * Get meta setting data
		 */
		$miraculous_page_data = '';
		if(function_exists('fw_get_db_post_option')): 
			$miraculous_page_data = fw_get_db_post_option($pageid);   
		endif; 
		$theme_sidebar = '';
		if(!empty($miraculous_page_data['page-sidebar'])):
			 $theme_sidebar = $miraculous_page_data['page-sidebar'];
		  else:
			 $theme_sidebar = esc_html__('right','miraculous');
		endif;
		
		if($theme_sidebar == 'full'):
			echo '<div class="col-lg-12 col-md-12">';
		else:
			if($theme_sidebar == 'left'):
				echo ' <div class="col-lg-8 col-md-12 push-lg-4">';
			else:
				echo ' <div class="col-lg-8 col-md-12">';
			endif;
		endif;
		echo '<div class="ms_main_data">';
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
		echo '</div>
		</div>';
		if($theme_sidebar == 'left'):
		  echo '<div class="col-lg-4 pull-lg-8">
			  <div class="ms_basic_sidebar">';
				 get_sidebar();
		 echo '</div>
		</div>';
		endif; 
		if($theme_sidebar == 'right'):
		   echo '<div class="col-lg-4">
			     <div class="ms_basic_sidebar">';
				 get_sidebar();
		   echo '</div>
		    </div>';
		endif;
	}
	/**
	 * Single page Setting
     */	
	public function miraculous_blog_single_setting($blog_id){
		/**
		 * Get meta setting data
		 */
		$miraculous_post_data = '';
		if (function_exists('fw_get_db_post_option')): 
			$miraculous_post_data = fw_get_db_post_option($blog_id);   
		endif;
		$theme_sidebar = '';
		if(!empty($miraculous_post_data['post-sidebar'])):
			$theme_sidebar = $miraculous_post_data['post-sidebar'];
		else:
			$theme_sidebar = esc_html__('right','miraculous');
		endif;
		if($theme_sidebar == 'full'):
			echo '<div class="col-lg-12 col-md-12">';
		else:
			if($theme_sidebar == 'left'):
				echo ' <div class="col-lg-8 col-md-12 push-lg-4">';
			else:
				echo ' <div class="col-lg-8 col-md-12">';
			endif;
		endif;
		echo '<div class="ms_main_data">';
		        while ( have_posts() ) : the_post();
				    if(get_post_type() =='post'):	
						get_template_part( 'template-parts/content','single');
					else:
						get_template_part( 'template-parts/content',get_post_type());
					endif;
					
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					
					if(get_post_type()== 'ms-music' || get_post_type()== 'ms-artists' || get_post_type()== 'ms-albums'):
					    
						$miraculous_core = '';
					    if(class_exists('Miraculouscore')):
						    $miraculous_core = new Miraculouscore();
							$miraculous_core->miraculous_related_posts_data(get_the_ID(), get_post_type());
						endif;
						
					endif;
					
				endwhile;
		echo '</div>
		</div>';
		if($theme_sidebar == 'left'):
		  echo '<div class="col-lg-4 pull-lg-8">
			  <div class="ms_basic_sidebar">';
				 get_sidebar();
		 echo '</div>
		</div>';
		endif; 
		if($theme_sidebar == 'right'):
		   echo '<div class="col-lg-4">
			     <div class="ms_basic_sidebar">';
				 get_sidebar();
		   echo '</div>
		    </div>';
		endif;
	} 
	/**
	 * Miraculous 404 Setting
	 */
	public function miraculous_404_setting(){
		$miraculous_theme_data = '';
		if (function_exists('fw_get_db_settings_option')):	
			$miraculous_theme_data = fw_get_db_settings_option();     
		endif;
		$theme_layout = '';
		if(!empty($miraculous_theme_data['miraculous_layout'])):
		    $theme_layout = $miraculous_theme_data['miraculous_layout'];
		endif;
		$error_404_desc = '';
		if(!empty($miraculous_theme_data['error_404_desc'])):
		   $error_404_desc = $miraculous_theme_data['error_404_desc'];
		else:
		   $error_404_desc = esc_html__("Oh No, there's nothing here. Page not found.","miraculous");
		endif;
		$err_ring_image = '';
		if(!empty($miraculous_theme_data['err_ring']['url'])):
		   $err_ring_image = $miraculous_theme_data['err_ring']['url'];
		else:
		   if($theme_layout == 1):
    		     $err_ring_image = get_template_directory_uri().'/assets/images/err_ring.png';
    		else:
    		    $err_ring_image = get_template_directory_uri().'/assets/images/l_err_ring.png';
    		endif; 
		endif;
		$emptypageimage = '';
		if(!empty($miraculous_theme_data['emptypageimage']['url'])):
		   $emptypageimage = $miraculous_theme_data['emptypageimage']['url'];
		else:
		    if($theme_layout == 1):
		        
    		     $emptypageimage = get_template_directory_uri().'/assets/images/wave.png';
    		else:
    		    
    		    $emptypageimage = get_template_directory_uri().'/assets/images/l_wave.png';
    		endif; 
		endif;
	  	    echo'<div class="container">
				<div class="row">
					<div class="ms_error_div">
						<div class="fd_error">
							<h1><span class="err_text">'.esc_html__('4','miraculous').'</span>
							<span class="err_img">';
							if(!empty($err_ring_image)):
							   echo'<img src="'.esc_url($err_ring_image).'" alt="'.esc_attr__('Error Image','miraculous').'">';
							endif;
							echo'</span><span class="err_text">'.esc_html__('4','miraculous').'</span></h1>
							<p>'.esc_html($error_404_desc).'</p>
							<div class="footer_border"></div>
							<div class="fd_error_btn">
								<a href="'.esc_url(home_url('/')).'">'.esc_html__('go back','miraculous').'</a>
							</div>
						</div>
					</div>
				</div>
			</div>';
			if(!empty($emptypageimage)):
				echo'<div class="ms_wave_img">
					  <img src="'.esc_url($emptypageimage).'" alt="'.esc_attr__('wave image','miraculous').'">
					</div>';
		    endif;
	}
	/** 
     * Footer page Setting
     */ 
    public function miraculous_footer_setting(){
        get_template_part('vendor/footer/miraculous-default', 'footer');
		$miraculous_core = '';
		if(class_exists('Miraculouscore')):
		   $miraculous_core = new Miraculouscore();
			$miraculous_core->miraculous_audio_jplayer();
			$miraculous_core->miraculous_login_register_popup();
			$miraculous_core->miraculous_language_selector(); 
			$miraculous_core->miraculous_create_playlist_popup(); 
			$miraculous_core->miraculous_add_music_in_playlist_popup();
		endif;
    }  
}