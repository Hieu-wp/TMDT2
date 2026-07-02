<?php
/**
 * The sidebar for WooCommerce shop page
 */

if ( ! is_active_sidebar( 'sidebar-shop' ) ) {
    return;
}
?>
<aside id="secondary" class="widget-area shop-sidebar" role="complementary">
    <?php dynamic_sidebar( 'sidebar-shop' ); ?>
</aside>
