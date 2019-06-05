<?php

/**
 *miraculous woocommerce support
 */
function miraculous_add_woocommerce_support() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'miraculous_add_woocommerce_support' );

/**
 * miraculous woocommerce sidebar
 */ 
function miraculous_woocommerce_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'WooCommerce Sidebar', 'miraculous' ),
		'id'            => 'woocommerce-sidebar-1',
		'description'   => esc_html__( 'Add WooCommerce Sidebar Widgets Here.', 'miraculous' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'miraculous_woocommerce_widgets_init' );
/**
 * define the loop_shop_per_page callback 
 */ 
function miraculous_loop_shop_per_page( $cols ) {
  $cols = 9;
  return $cols;
}
add_filter( 'loop_shop_per_page', 'miraculous_loop_shop_per_page', 20 );
/**
 *miraculous woocommerce remove content wrapper
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart',10);
add_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 20);
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10, 2 ); 
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering',30 ); 
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title',10);
function miraculous_shop_loop_product_title() {
	global $product; 
    $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
	echo '<h3 class="woocommerce-loop-product__title"><a href="' . esc_url( $link ) . '">'. get_the_title().'</a></h3>';
} 
add_action('woocommerce_shop_loop_item_title', 'miraculous_shop_loop_product_title', 10);