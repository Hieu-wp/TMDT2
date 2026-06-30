<?php
/**
 * Template Name: Custom Home Page
 */

get_header(); ?>

<main id="maincontent" role="main">
  <?php if( get_theme_mod( 'product_comparison_woocommerce_show_hide_banner',true) == 1) { ?>
    <section id="banner" class="wow bounceInDown delay-1000" data-wow-duration="3s">
      <div class="container">
        <div class="row">
          <div class="col-lg-7 col-md-6 col-12 banner-main-text">
            <div class="banner-caption">
              <div class="inner_carousel">
                <?php if(get_theme_mod('product_comparison_woocommerce_tagline_title') != '') {?>
                  <h1><?php echo esc_html(get_theme_mod('product_comparison_woocommerce_tagline_title')) ?></h1>
                <?php }?>
                <?php if(get_theme_mod('product_comparison_woocommerce_designation_text') != '') {?>
                  <p><?php echo esc_html(get_theme_mod('product_comparison_woocommerce_designation_text')) ?></p>
                <?php }?>
                <?php if ( get_theme_mod('product_comparison_woocommerce_banner_button_label','Compare Now') != '' ) {?>
                  <div class ="read-more mt-md-4 mt-0">
                    <a href="<?php echo esc_url(get_theme_mod('product_comparison_woocommerce_top_button_url',false));?>"><?php echo esc_html(get_theme_mod('product_comparison_woocommerce_banner_button_label','Compare Now'));?><span class="screen-reader-text"><?php esc_html_e( 'Compare Now','product-comparison-woocommerce');?></span></a>
                  </div>
                <?php }?>
              </div>
            </div>
            <!-- product cat -->
            <?php if( get_theme_mod( 'product_comparison_woocommerce_show_hide_product',true) == 1) { ?>
              <div class="slider-nav d-flex">
                <?php if ( class_exists( 'WooCommerce' ) ) {
                  $args = array(
                    'post_type' => 'product',
                    'product_cat' => get_theme_mod('product_comparison_woocommerce_product_category'),
                    'order' => 'ASC'
                  );
                  $loop = new WP_Query( $args );
                  while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
                    <div class="product-box">
                      <div class="slider-nav-box-inner d-flex align-items-center">
                       <div class="slider-nav-image">
                          <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.esc_url(woocommerce_placeholder_img_src()).'" />'; ?>
                        </div>
                        <div class="slider-price ps-3">
                         <h2 class="slider-nav-title">
                          <a href="<?php echo esc_url(get_permalink( $loop->post->ID )); ?>"><?php the_title(); ?></a>
                        </h2>
                         <p class="product-rating mb-0 <?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php echo $product->get_price_html(); ?></p>
                        </div>
                      </div>
                    </div>
                  <?php endwhile; wp_reset_query(); ?>
                <?php } ?>
              </div>
            <?php }?>
              <!-- end -->
            </div>
          <div class="col-lg-5 col-md-6 col-12">
            <!-- product cat -->
            <?php if( get_theme_mod( 'product_comparison_woocommerce_show_hide_product',true) == 1) { ?>
              <div class="banner-next">
                <div class="slider-for pt-4">
                  <?php if ( class_exists( 'WooCommerce' ) ) {
                  $args = array(
                    'post_type' => 'product',
                    'product_cat' => get_theme_mod('product_comparison_woocommerce_product_category'),
                    'order' => 'ASC'
                  );
                  $loop = new WP_Query( $args );
                  while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
                    <div class="product-box-next">
                      <div class="slider-nav-box-inner-sec">
                        <div class="slider-nav-image-sec text-center">
                          <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.esc_url(woocommerce_placeholder_img_src()).'" />'; ?>
                          <div class="text-end arrow-img"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/arrow.png" alt="" /></div>
                        </div>
                        <div class="slider-price">
                          <h2><a href="<?php echo esc_url(get_permalink( $loop->post->ID )); ?>"><?php the_title(); ?></a></h2>
                          <div class="slider-price-inner-content">
                            <p class="product-rating mt-2 <?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php echo $product->get_price_html(); ?></p>
                            <span class="compare-btn-banner">
                              <?php if ( defined( 'YITH_WOOCOMPARE' ) ) {
                                echo do_shortcode('[yith_compare_button]');
                               } ?>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endwhile; wp_reset_query(); ?>
                <?php } ?>
                </div>
              </div>
            <?php }?>
            <!-- end -->
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </section>
  <?php }?>

<?php do_action( 'product_comparison_woocommerce_after_slider' ); ?>

<!-- best-product Section -->
  <?php if( get_theme_mod( 'product_comparison_woocommerce_best_product_heading')|| get_theme_mod( 'product_comparison_woocommerce_best_product_small_title') || get_theme_mod( 'product_comparison_woocommerce_best_product_category')) { ?>
    <section id="best-product-section" class="wow bounceInDown delay-1000 py-5" data-wow-duration="3s">
      <div class="container">
        <div class="best-product-head">
          <?php if( get_theme_mod('product_comparison_woocommerce_best_product_heading') != '' ){ ?>
            <h3 class="heading-text"><?php echo esc_html(get_theme_mod('product_comparison_woocommerce_best_product_heading',''));?></h3>
          <?php }?>
          <?php if( get_theme_mod('product_comparison_woocommerce_best_product_small_title') != '' ){ ?>
            <p class="small-text"><?php echo esc_html(get_theme_mod('product_comparison_woocommerce_best_product_small_title',''));?></p>
          <?php }?>
        </div>
        <div class="slick">
          <?php if ( class_exists( 'WooCommerce' ) ) {
            $args = array( 
              'post_type' => 'product',
              'product_cat' => get_theme_mod('product_comparison_woocommerce_best_product_category'),
              'order' => 'ASC'
            );
            $loop = new WP_Query( $args );
            while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
              <div class="product-box">
                <div class="product-box-img">
                  <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.esc_url(woocommerce_placeholder_img_src()).'" />'; ?>
                </div>
                <div class="product-box-content">
                  <span><?php if( $product->is_type( 'simple' ) ){ woocommerce_template_loop_rating( $loop->post, $product ); } ?></span>
                    <h3><a href="<?php echo esc_url(get_permalink( $loop->post->ID )); ?>"><?php the_title(); ?></a></h3>
                    <p class="product-rating mb-lg-3 mb-0 d-3 mb-5 <?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php echo $product->get_price_html(); ?></p>
                  <span class="compare-btn-banner">
                    <?php if ( defined( 'YITH_WOOCOMPARE' ) ) {
                      echo do_shortcode('[yith_compare_button]');
                     } ?>
                  </span>
                </div>
              </div>
            <?php endwhile; wp_reset_query(); ?>
          <?php } ?>
        </div>
      </div>
    </section>
  <?php }?>
<?php do_action( 'product_comparison_woocommerce_after_best_product_section' ); ?>

  <div id="content-vw" class="entry-content py-3">
    <div class="container">
      <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; // end of the loop. ?>
    </div>
  </div>
</main>

<?php get_footer(); ?>
