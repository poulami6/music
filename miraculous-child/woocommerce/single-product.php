<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );

$miraculous_theme_data = '';
if (function_exists('fw_get_db_settings_option')):	
	$miraculous_theme_data = fw_get_db_settings_option();     
endif;
$theme_sidebar = '';
if(!empty($miraculous_theme_data['woocommerce_sidebar'])):
	$theme_sidebar = $miraculous_theme_data['woocommerce_sidebar'];
else:
	$theme_sidebar = esc_html__('right','miraculous');
endif;

?>
<div id="primary" class="content-area">
    <div class="ms_main_wrapper">
       <div class="container">
		  <div class="row">
	<?php
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
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>
    </div>
    </div>
    <?php
	if($theme_sidebar == 'left'):
		  echo '<div class="col-lg-4 pull-lg-8">
			  <div class="ms_basic_sidebar">
			  <aside id="secondary" class="widget-area ms_footershdow_widget">';
			    dynamic_sidebar( 'woocommerce-sidebar-1' );
				/**
        		 * woocommerce_sidebar hook.
        		 *
        		 * @hooked woocommerce_get_sidebar - 10
        		 */
        		do_action( 'woocommerce_sidebar' );
		 echo '</aside>
		    </div>
		</div>';
		endif; 
		if($theme_sidebar == 'right'):
		   echo '<div class="col-lg-4">
			     <div class="ms_basic_sidebar">
			     <aside id="secondary" class="widget-area ms_footershdow_widget">';
			     dynamic_sidebar( 'woocommerce-sidebar-1' );
				 /**
        		  * woocommerce_sidebar hook.
        		  *
        		  * @hooked woocommerce_get_sidebar - 10
        		  */
        		do_action( 'woocommerce_sidebar' );
		   echo '</aside>
		      </div>
		    </div>';
		endif;
	?>
  </div>
 </div>
</div>
</div>
<?php get_footer( 'shop' );
/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */