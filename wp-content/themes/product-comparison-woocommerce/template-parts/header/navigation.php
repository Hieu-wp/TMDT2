<?php
/**
 * The template part for header
 *
 * @package Product Comparison Woocommerce
 * @subpackage product-comparison-woocommerce
 * @since product-comparison-woocommerce 1.0
 */
?>

<div id="header">
  <div class="toggle-nav mobile-menu text-lg-end text-md-center text-center">
    <button role="tab" onclick="product_comparison_woocommerce_menu_open_nav()" class="responsivetoggle"><i class="<?php echo esc_attr(get_theme_mod('product_comparison_woocommerce_res_open_menu_icon','fas fa-bars')); ?>"></i><span class="screen-reader-text"><?php esc_html_e('Open Button','product-comparison-woocommerce'); ?></span></button>
  </div>
  <div id="mySidenav" class="nav sidenav">
    <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'product-comparison-woocommerce' ); ?>">
      <?php 
        wp_nav_menu( array( 
          'theme_location' => 'primary',
          'container_class' => 'main-menu clearfix' ,
          'menu_class' => 'clearfix',
          'items_wrap' => '<ul id="%1$s" class="%2$s mobile_nav">%3$s</ul>',
          'fallback_cb' => 'wp_page_menu',
        ) );
      ?>
      <a href="javascript:void(0)" class="closebtn mobile-menu" onclick="product_comparison_woocommerce_menu_close_nav()"><i class="<?php echo esc_attr(get_theme_mod('product_comparison_woocommerce_res_close_menu_icon','fas fa-times')); ?>"></i><span class="screen-reader-text"><?php esc_html_e('Close Button','product-comparison-woocommerce'); ?></span></a>
    </nav>
  </div>
</div>