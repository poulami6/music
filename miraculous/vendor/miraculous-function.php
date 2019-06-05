<?php
/**
 * miraculous plugins
 */
require get_template_directory() . '/vendor/theme-plugins/miraculous-plugin-activate-config.php';
/**
 * miraculous Enqueue
 */
require get_template_directory() . '/vendor/include/miraculous-enqueue.php';
/**
 * miraculous Aq Resizer
 */
require get_template_directory() . '/vendor/include/miraculous-aq-resizer.php'; 
/**
 * miraculous comments
 */  
require get_template_directory() . '/vendor/include/miraculous-comment.php'; 

/**
 * miraculous WooCommerce
 */  
require get_template_directory() . '/vendor/include/miraculous-woocommerce.php'; 

/**
 * miraculous Post Navigation
 */
function miraculous_numeric_posts_nav() {
 
    if( is_singular() )
        return;
 
    global $wp_query;
 
    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;
 
    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );
 
    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;
 
    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }
   
    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }
 
    echo '<div class="navigation"><ul>' . "\n";
 
       /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li>%s</li>' . "\n", get_previous_posts_link('<span><i class="fa fa-long-arrow-left"></i></span>') );
 
    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';
 
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
 
        if ( ! in_array( 2, $links ) )
            echo '<li>'.esc_html__('...','miraculous').'</li>';
    }
 
    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }
 
    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>'.esc_html__('...','miraculous').'</li>' . "\n";
 
        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }
 
    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li>%s</li>' . "\n", get_next_posts_link('<span><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>') );
    echo '</ul></div>' . "\n";
 
}  

/**
 * Miraculous Theme Breadcrumbs
 */

function miraculous_theme_breadcrumbs() {

    $header_breadcrumb_data = '';
    if (function_exists('fw_get_db_settings_option')):  
        $header_breadcrumb_data = fw_get_db_settings_option();     
    endif; 
    if (!empty($header_breadcrumb_data['breadcrumbs_image']['url'])):  
        $bread_image = $header_breadcrumb_data['breadcrumbs_image']['url'];     
    endif; 
	$top_header_login_bar = '';
    if(!empty($header_breadcrumb_data['themeloginbar_switch'])):
        $top_header_login_bar =  $header_breadcrumb_data['themeloginbar_switch']['loginbar_switch_value'];
    endif;
   if($top_header_login_bar == 'on'):
      $top_header_login_bar = 'ms_top_breadcrumb';
   else:
      $top_header_login_bar = '';
   endif;
    $bg_image = '';
    if(!empty($bread_image)):
        $bg_image = 'background-image:url(' .$bread_image. ');';
    endif;
    $background = '';
    $background   = ($bg_image) ? 'style=' . esc_attr($bg_image) . '' : '';
  ?>
  <div class="breadcrumbs_wrapper <?php echo esc_attr($top_header_login_bar); ?>" <?php echo esc_attr($background); ?>>
     <div class="ms_banner">
            <div class="container">
                <div class="row">
                    <div class="ms_banner_title">
           <?php 
            echo '<h1>';
                if(is_home() && have_posts()) :
                  esc_html_e('Blog','miraculous');
                endif;
                if(is_page()):
                    the_title();
                endif;
                if(is_single()): 
                    single_post_title();
                endif;
                if(class_exists( 'WooCommerce' ) ):
                    if(is_shop()):
                        esc_html_e('Shop','miraculous');
                    else:
                        if(is_archive()):
                            the_archive_title();
                        endif;
                   endif;
                else:
                  if(is_archive()):
                    the_archive_title();
                  endif; 
                endif;
                if(is_search()):
                    printf( esc_html__( 'Search Results for: %s', 'miraculous' ), '<span>'.get_search_query().'</span>' );
                endif;
               echo '</h1>
                    <div class="ms_breadcrumb">';
                        if(function_exists('fw_ext_breadcrumbs')) { 
						 echo fw_ext_breadcrumbs(); }
            echo '</div>';
          ?>
            </div>
          </div>
        </div>
      </div>
  </div>
<?php 
 $bread_color = $bread_image = '';
}  

/**
 *miraculous function to allow svg files
 */
function miraculous_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'miraculous_mime_types');

/**
 *miraculous function for get all Songs of album
 */
if( ! function_exists('miraculous_list_all_pages') ):
    function miraculous_list_all_pages(){
        $all_pages = get_pages();
        $pages = array('' => 'Select page');

        if($all_pages):
            foreach ( $all_pages as $all_page ): 
                $pages[$all_page->ID] = $all_page->post_title;
            endforeach; 
        endif;

        return $pages;
    }
endif;
/**
 * Miraculous Menu Editor Funcation
 */
 if(!function_exists('miraculous_menu_editor')){

	function miraculous_menu_editor($args){
       
	   if ( ! current_user_can( 'manage_options' ) ){
           return;
        }
        /* see wp-includes/nav-menu-template.php for available arguments */
        extract( $args );
        $link = $link_before
             . '<a href="' .admin_url( 'nav-menus.php' ) . '">'.$before.esc_html__('Add a menu','miraculous').$after.'</a>'
            . $link_after;
        /* We have a list */
        if ( FALSE !== stripos( $items_wrap, '<ul' )

			or FALSE !== stripos( $items_wrap, '<ol' )

		) {
        $link = "<li>$link</li>";
        }
        $output = sprintf( $items_wrap, $menu_id, $menu_class, $link );
        if ( ! empty ( $container ) ){
           $output  = "<$container class='$container_class' id='$container_id'>$output</$container>";
        }
        if ( $echo ){
           echo "$output";
        }
        return $output;

	}

}
/**
 *Customize widget
 */
function miraculous_widget_customizer() {
	
    /**
	 *miraculous unregister widget customizer
	 */
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Tag_Cloud');
	
    /**
	 *miraculous register widget customizer
	 */
    register_widget('Miraculous_Recent_Posts_Widget');
    register_widget( 'Miraculous_WP_Widget_Tag_Cloud' );
}
/**
 * Extend Recent Posts Widget 
 *
 * Adds different formatting to the default WordPress Recent Posts Widget
 */
Class Miraculous_Recent_Posts_Widget extends WP_Widget_Recent_Posts {

    function widget($args, $instance) {
    
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? esc_html__('Recent Posts','miraculous') : $instance['title'], $instance, $this->id_base);
        if( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
            $number = 10;
        $r = new WP_Query( apply_filters( 'widget_posts_args',
						array( 'posts_per_page' => $number, 
							   'no_found_rows' => true,
							   'post_status' => 'publish', 
							   'ignore_sticky_posts' => true ) ) );
        if($r->have_posts() ) :
            $result ='';
            $result .=$before_widget;
            if( $title )
				$result .=$before_title . $title . $after_title; ?>
            <ul>
                <?php while( $r->have_posts() ) : $r->the_post(); ?>  
				<li>
                    <div class="recent_cmnt_img">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <div class="recent_cmnt_data">
                        <h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
                        <span><?php get_the_date( 'd F Y'); ?></span>
                    </div>
                </li>
				<?php endwhile; ?>
            </ul>
             
            <?php
           $result .=$after_widget;
           return $result;
        wp_reset_postdata();
        endif;
    }
}

class Miraculous_WP_Widget_Tag_Cloud extends WP_Widget_Tag_Cloud {

    function widget( $args, $instance ) {
            $current_taxonomy = $this->_get_current_taxonomy( $instance );
            if ( ! empty( $instance['title'] ) ) {
                $title = $instance['title'];
            } else {
                if ( 'post_tag' === $current_taxonomy ) {
                    $title = esc_html__( 'Tags','miraculous');
                } else {
                    $tax   = get_taxonomy( $current_taxonomy );
                    $title = $tax->labels->name;
                }
            }
            $show_count = ! empty( $instance['count'] );
            
            $tag_cloud = wp_tag_cloud(
                apply_filters(
                    'widget_tag_cloud_args', array(
                        'taxonomy'   => $current_taxonomy,
                        'echo'       => false,
                        'show_count' => $show_count,
                    ), $instance
                )
            );
            if ( empty( $tag_cloud ) ) {
                return;
            }
			$result ='';
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
			$result .= $args['before_widget'];
			if ( $title ):
				$result .= $args['before_title'] . $title . $args['after_title'];
			endif;
			$result .='<ul class="tagcloud">';
			$result .= $tag_cloud;
			$result .= "</ul>\n";
			$result .=$args['after_widget'];
			return $result; 
			
        }
} 
remove_action('shutdown', 'wp_ob_end_flush_all', 1);

/**  
 * miraculous the excerpt
 */ 
 function miraculous_the_excerpt($charlength) {
	 $excerpt = get_the_excerpt();
	 $charlength++;
     if ( mb_strlen( $excerpt ) > $charlength ):
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ):
			 echo mb_substr( $subex, 0, $excut );
		else :
		  echo esc_html($subex);
	    endif;
		  echo esc_html__('...','miraculous');
	    else :
		   echo esc_html($excerpt) ;
	  endif;
} 