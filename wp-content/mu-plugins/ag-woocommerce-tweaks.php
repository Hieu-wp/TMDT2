<?php
/*
Plugin Name: AG WooCommerce Tweaks
Description: Customizations for WooCommerce (Pre-order text changes).
Version: 1.0
Author: Antigravity
*/

// Change Add to Cart text for Pre-order products
add_filter( 'woocommerce_product_single_add_to_cart_text', 'ag_custom_preorder_cart_button_text', 10, 2 );
add_filter( 'woocommerce_product_add_to_cart_text', 'ag_custom_preorder_cart_button_text', 10, 2 );

function ag_custom_preorder_cart_button_text( $button_text, $product ) {
    // Check if product has the 'Pre-order' category
    if ( has_term( 'pre-order', 'product_cat', $product->get_id() ) ) {
        return __( 'Pre-order', 'woocommerce' );
    }
    return $button_text;
}
