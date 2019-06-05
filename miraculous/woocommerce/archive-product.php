<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

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
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );
?>
<header class="woocommerce-products-header">
	<?php if ( apply_filters( 'woocommerce_show_page_title', false ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>
</header>
<?php
if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	?>
	<div class="ms_count_ordering" >
	<?php
      woocommerce_result_count();
	  woocommerce_catalog_ordering();
	?>
	</div>
	<?php
	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 *
			 * @hooked WC_Structured_Data::generate_product_data() - 10
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();
    
	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );
 echo " </div>
   </div>";
    if($theme_sidebar == 'left'):
		  echo '<div class="col-lg-4 pull-lg-8">
			  <div class="ms_basic_sidebar">
			   <aside id="secondary" class="widget-area ms_footershdow_widget">';
			    dynamic_sidebar( 'woocommerce-sidebar-1' );
				 /**
                 * Hook: woocommerce_sidebar.
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
                 * Hook: woocommerce_sidebar.
                 *
                 * @hooked woocommerce_get_sidebar - 10
                 */
                do_action( 'woocommerce_sidebar' );
		   echo '</aside></div>
		    </div>';
		endif;
     ?>
   </div>
  </div>
 </div>
</div>
<?php
get_footer( 'shop' );