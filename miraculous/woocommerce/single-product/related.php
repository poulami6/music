<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
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
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>
<div class="ms_fea_album_slider">
       <div class="ms_heading">
		 <h1><?php esc_html_e( 'Related products', 'miraculous' ); ?></h1>
       </div>
       <div class="ms_relative_inner">
        <div class="ms_woocommerce_slider swiper-container swiper-container-horizontal">
            <div class="swiper-wrapper">
                <?php
                foreach ( $related_products as $related_product ) :
                    $post_object = get_post( $related_product->get_id());
                    setup_postdata( $GLOBALS['post'] =& $post_object );
                ?>
                <div class="swiper-slide">
                    <div class="ms_store_img">  
                    	<?php
                    	/**
                    	 * Hook: woocommerce_before_shop_loop_item.
                    	 *
                    	 * @hooked woocommerce_template_loop_product_link_open - 10
                    	 */
                    	 do_action( 'woocommerce_before_shop_loop_item' );
                        /**
                    	 * Hook: woocommerce_before_shop_loop_item_title.
                    	 *
                    	 * @hooked woocommerce_show_product_loop_sale_flash - 10
                    	 * @hooked woocommerce_template_loop_product_thumbnail - 10
                    	 */
                    	 do_action( 'woocommerce_before_shop_loop_item_title' );
                    	 ?>
                    	</div>
                        <?php
                    	/**
                    	 * Hook: woocommerce_shop_loop_item_title.
                    	 *
                    	 * @hooked woocommerce_template_loop_product_title - 10
                    	 */
                    	do_action( 'woocommerce_shop_loop_item_title' );
                        /**
                    	 * Hook: woocommerce_after_shop_loop_item_title.
                    	 *
                    	 * @hooked woocommerce_template_loop_rating - 5
                    	 * @hooked woocommerce_template_loop_price - 10
                    	 */
                    	do_action( 'woocommerce_after_shop_loop_item_title' );
                    
                    	/**
                    	 * Hook: woocommerce_after_shop_loop_item.
                    	 *
                    	 * @hooked woocommerce_template_loop_product_link_close - 5
                    	 * @hooked woocommerce_template_loop_add_to_cart - 10
                    	 */
                    	do_action( 'woocommerce_after_shop_loop_item' );
                    	?>    
                   </div>
                <?php  endforeach; ?>
            </div>
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
		</div>
		<div class="swiper-button-next1 slider_nav_next" tabindex="0" role="button" aria-label="<?php esc_attr_e('Next slide','miraculous'); ?>"></div>
        <div class="swiper-button-prev1 slider_nav_prev" tabindex="0" role="button" aria-label="<?php esc_attr_e('Previous slide','miraculous'); ?>"></div>
      </div>
</div>
<?php endif;
wp_reset_postdata();