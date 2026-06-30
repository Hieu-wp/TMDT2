<?php
/**
 * The template part for Top Header
 *
 * @package Product Comparison Woocommerce 
 * @subpackage product-comparison-woocommerce
 * @since product-comparison-woocommerce 1.0
 */
?>
<!-- Top Header -->
<?php if( get_theme_mod( 'product_comparison_woocommerce_header_topbar',true) == 1 || get_theme_mod('product_comparison_woocommerce_responsive_topbar_hide',true)) { ?>
  <div class="topbar">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-3 align-self-center text-lg-start text-md-start text-center">
          <?php if( get_theme_mod( 'product_comparison_woocommerce_reviews_link') != '' || get_theme_mod( 'product_comparison_woocommerce_reviews_text') != ''){ ?>
            <a href="<?php echo esc_html(get_theme_mod('product_comparison_woocommerce_reviews_link',''));?>" ><?php echo esc_html(get_theme_mod('product_comparison_woocommerce_reviews_text',''));?></a>
          <?php } ?>
          <span class="meta-sec mx-2"><?php echo esc_html(get_theme_mod('product_comparison_woocommerce_meta_field_separator_topheader', ''));?></span>
          <?php if( get_theme_mod( 'product_comparison_woocommerce_supports_link') != '' || get_theme_mod( 'product_comparison_woocommerce_supports_text') != ''){ ?>
            <a href="<?php echo esc_html(get_theme_mod('product_comparison_woocommerce_supports_link',''));?>" ><?php echo esc_html(get_theme_mod('product_comparison_woocommerce_supports_text',''));?></a>
          <?php } ?>
        </div>
        <div class="col-lg-5 col-md-5 align-self-center text-lg-end text-md-start text-center" >
          <?php if(get_theme_mod('product_comparison_woocommerce_total_order') != ''){ ?>
            <p class="topbar-text mb-lg-0 mb-md-0 mt-2 mt-md-0"><?php echo esc_html(get_theme_mod('product_comparison_woocommerce_total_order')); ?></p>
          <?php }?>
        </div>
        <div class="col-lg-4 col-md-4 align-self-center text-lg-end text-md-start text-center">
          <?php if(get_theme_mod('product_comparison_woocommerce_phone_number') != ''){ ?>
            <span class="phone-number me-3 me-md-0 md-lg-0"><span class="calling-text"><i class="<?php echo esc_attr(get_theme_mod('product_comparison_woocommerce_phone_icon','fas fa-mobile-alt')); ?> me-2"></i></span><a href="tel:<?php echo esc_attr( get_theme_mod('product_comparison_woocommerce_phone_number','') ); ?>"><?php echo esc_html(get_theme_mod('product_comparison_woocommerce_phone_number',''));?></a></span>
          <?php }?>
          <span class="meta-sec"><?php echo esc_html(get_theme_mod('product_comparison_woocommerce_meta_field_separator_topheader', ''));?></span>
          <?php if( get_theme_mod( 'product_comparison_woocommerce_lite_email','' ) != '') { ?>
            <span class="email"><i class="<?php echo esc_attr(get_theme_mod('product_comparison_woocommerce_email_icon','fas fa-paper-plane')); ?> mail-icon mx-2"></i><a href="mailto:<?php echo esc_attr(get_theme_mod('product_comparison_woocommerce_lite_email',''));?>"><?php echo esc_html(get_theme_mod('product_comparison_woocommerce_lite_email',''));?></a></span>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
<?php }?>