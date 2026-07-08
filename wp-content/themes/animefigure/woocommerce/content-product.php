<?php
/**
 * The template for displaying product content within loops
 *
 * This template overrides the default WooCommerce template to use our custom design.
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( '', $product ); ?>>
	<?php 
	if ( function_exists( 'render_product_card' ) ) {
		render_product_card( $product );
	}
	?>
</li>
