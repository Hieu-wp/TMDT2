<?php
/**
 * The template part for header
 *
 * @package Product Comparison Woocommerce 
 * @subpackage product-comparison-woocommerce
 * @since product-comparison-woocommerce 1.0
 */
?>

<div class="middle-header">
	<div class="container">
		<div class="row">
			<div class="col-lg-2 col-md-3 col-6 align-self-center py-3 py-lg-0 py-md-0">
				<div class="logo">
          <?php if ( has_custom_logo() ) : ?>
            <div class="site-logo"><?php the_custom_logo(); ?></div>
              <?php endif; ?>
              <?php $blog_info = get_bloginfo( 'name' ); ?>
                <?php if ( ! empty( $blog_info ) ) : ?>
                  <?php if ( is_front_page() && is_home() ) : ?>
                    <?php if( get_theme_mod('product_comparison_woocommerce_logo_title_hide_show',true) == 1){ ?>
                      <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                    <?php } ?>
                  <?php else : ?>
                    <?php if( get_theme_mod('product_comparison_woocommerce_logo_title_hide_show',true) == 1){ ?>
                      <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                    <?php } ?>
                  <?php endif; ?>
                <?php endif; ?>
                <?php
                  $description = get_bloginfo( 'description', 'display' );
                  if ( $description || is_customize_preview() ) :
                ?>
                <?php if( get_theme_mod('product_comparison_woocommerce_tagline_hide_show',false) == 1){ ?>
                  <p class="site-description mb-0">
                    <?php echo esc_html($description); ?>
                  </p>
                <?php } ?>
            <?php endif; ?>
    		</div>
			</div>
			<div class="col-lg-6 col-md-3 col-6 align-self-center menu-section-sec">
				<div class="menu-section">
          <?php get_template_part('template-parts/header/navigation'); ?>
        </div>
			</div>
			<div class="col-lg-2 col-md-3 col-6 py-3 py-lg-0 py-md-0 align-self-center myaccount text-lg-end text-md-end text-end">
        <?php if(class_exists('woocommerce')){ ?>
          <?php if ( is_user_logged_in() ) { ?>
            <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>"><i class="<?php echo esc_attr(get_theme_mod('product_comparison_woocommerce_myaccount_icon','fas fa-sign-in-alt')); ?> mx-2"></i><?php esc_html_e('Login','product-comparison-woocommerce'); ?><span class="screen-reader-text"><?php esc_html_e( 'Login','product-comparison-woocommerce' );?></span></a>
          <?php }
          else { ?>
            <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_attr_e('Login / Register','product-comparison-woocommerce'); ?>"><?php esc_html_e('Login / Register','product-comparison-woocommerce'); ?><span class="screen-reader-text"><?php esc_html_e( 'Login / Register','product-comparison-woocommerce' );?></span></a>
          <?php } ?>
        <?php }?>
			</div>
			<div class="col-lg-2 col-md-3 col-6 py-3 py-lg-0 py-md-0 align-self-center search-box-sec text-lg-end text-md-end text-start">
				<?php if( get_theme_mod( 'product_comparison_woocommerce_header_search',true) == 1) { ?>
					<div class="search-box">
				    <span><a href="#"><i class='<?php echo esc_attr(get_theme_mod('product_comparison_woocommerce_openicon_icon','fas fa-search')); ?> mx-2'></i><?php esc_html_e('Search','product-comparison-woocommerce'); ?></a></span>
					</div>
				<?php }?>
        <div class="serach_outer align-self-center text-center text-lg-start text-md-start py-lg-0 py-md-0 py-3r">
          <div class="closepop"><a href="#maincontent"><i class='<?php echo esc_attr(get_theme_mod('product_comparison_woocommerce_closeicon_icon','fa fa-window-close')); ?> me-2'></i></a></div>
          <div class="serach_inner">
            <?php get_search_form(); ?>
          </div>
        </div>
			</div>
		</div>
	</div>
</div>

