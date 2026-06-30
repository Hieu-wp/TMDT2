<?php
/**
 * @package Product Comparison Woocommerce 
 * Setup the WordPress core custom header feature.
 *
 * @uses product_comparison_woocommerce_header_style()
*/
function product_comparison_woocommerce_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'product_comparison_woocommerce_custom_header_args', array(
		'header-text' 			 =>	false,
		'width'                  => 1200,
		'height'                 => 70,
		'flex-width'    		 => true,
		'flex-height'    		 => true,
		'wp-head-callback'       => 'product_comparison_woocommerce_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'product_comparison_woocommerce_custom_header_setup' );

if ( ! function_exists( 'product_comparison_woocommerce_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see product_comparison_woocommerce_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'product_comparison_woocommerce_header_style' );

function product_comparison_woocommerce_header_style() {
	if ( get_header_image() ) :
	$custom_css = "
        .page-template-custom-home-page .home-page-header, .home-page-header{
			background-image:url('".esc_url(get_header_image())."');
			background-position: center top;
		    background-size: cover;
		}";
	   	wp_add_inline_style( 'product-comparison-woocommerce-basic-style', $custom_css );
	endif;
}
endif;