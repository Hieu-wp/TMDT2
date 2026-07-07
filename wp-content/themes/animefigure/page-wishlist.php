<?php
/**
 * Template Name: Wishlist
 * Page template to display user wishlist saved in user meta (_wishlist).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<div class="container" style="padding:48px 20px;">
  <h1 class="section-title" style="color:var(--color-primary);font-weight:900;">Danh sách yêu thích</h1>

  <div class="wishlist-wrapper" style="margin-top:24px;">
    <?php if ( ! is_user_logged_in() ) : ?>
      <div class="notice notice-info" style="padding:20px;border-radius:12px;background:#fff;">Bạn cần <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>">đăng nhập</a> để xem danh sách yêu thích.</div>
    <?php else :
      $user_id  = get_current_user_id();
      $wishlist = (array) get_user_meta( $user_id, '_wishlist', true );

      if ( empty( $wishlist ) ) : ?>
        <div class="wishlist-empty" style="padding:28px;border-radius:12px;background:#fff;text-align:center;">
          <p style="font-size:18px;margin-bottom:12px;">Bạn chưa có sản phẩm yêu thích nào.</p>
          <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn-primary">Mua sắm ngay</a>
        </div>
      <?php else : ?>
        <div class="wishlist-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:18px;">
          <?php foreach ( $wishlist as $product_id ) :
            $product = wc_get_product( $product_id );
            if ( ! $product ) continue;
          ?>
          <div class="product-card reveal">
            <div class="product-card-image-wrap">

              <!-- Badge -->
              <div class="product-badge">
                <?php if ( $product->is_on_sale() ): ?>
                  <span class="badge badge-sale">Sale</span>
                <?php endif; ?>
                <?php 
                $created_days = ( time() - strtotime( $product->get_date_created() ) ) / ( 60 * 60 * 24 );
                if ( $created_days < 14 ): ?>
                  <span class="badge badge-new">New</span>
                <?php endif; ?>
              </div>

              <!-- Wishlist -->
              <button class="product-wishlist-btn active" data-id="<?php echo esc_attr( $product->get_id() ); ?>" aria-label="Xóa khỏi wishlist">
                <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
              </button>

              <!-- Image -->
              <a href="<?php echo esc_url( $product->get_permalink() ); ?>">
                <?php 
                if ( $product->get_image_id() ) {
                  echo $product->get_image( 'woocommerce_thumbnail', [ 'loading' => 'lazy', 'alt' => esc_attr( $product->get_name() ) ] );
                } else {
                  echo '<div class="img-placeholder" style="width:100%;height:100%;aspect-ratio:3/4;background:#f0f4f8;display:flex;align-items:center;justify-content:center;font-size:48px;">🎭</div>';
                }
                ?>
              </a>

              <!-- Overlay actions -->
              <div class="product-card-overlay">
                <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="btn-quickview" style="display:flex;justify-content:center;text-decoration:none;align-items:center;padding:12px;background:rgba(255,255,255,0.95);border-radius:24px;font-weight:600;font-size:13px;color:#222;margin-bottom:8px;">
                  👁 Xem chi tiết
                </a>
                <a href="?add-to-cart=<?php echo esc_attr( $product->get_id() ); ?>" data-quantity="1" class="btn-addtocart ajax_add_to_cart" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>" data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>" aria-label="Thêm vào giỏ">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg>
                  Thêm vào giỏ
                </a>
              </div>
            </div>

            <div class="product-card-info">
              <?php 
              $brands = wc_get_product_terms( $product->get_id(), 'product_cat', [ 'fields' => 'names' ] );
              $brand_name = ! empty( $brands ) ? $brands[0] : 'Mô hình';
              ?>
              <div class="product-brand"><?php echo esc_html( $brand_name ); ?></div>
              <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="product-name"><?php echo esc_html( $product->get_name() ); ?></a>
              <div class="product-rating">
                <?php 
                $rating = $product->get_average_rating();
                $stars = round( $rating );
                for ( $s = 1; $s <= 5; $s++ ) {
                  echo $s <= $stars ? '<span style="color:#f5c518;font-size:13px;">★</span>' : '<span style="color:#ddd;font-size:13px;">★</span>';
                }
                ?>
                <span class="rating-count">(<?php echo $product->get_review_count(); ?>)</span>
              </div>
              <div class="product-price">
                <span class="price-current" style="font-weight:800;color:var(--color-primary);font-size:18px;"><?php echo wc_price( wc_get_price_to_display( $product ) ); ?></span>
                <?php if ( $product->is_on_sale() && $product->get_regular_price() ): ?>
                  <span class="price-original" style="text-decoration:line-through;color:#999;font-size:13px;margin-left:6px;"><?php echo wc_price( wc_get_price_to_display( $product, [ 'price' => $product->get_regular_price() ] ) ); ?></span>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      <?php endif; // end wishlist empty check
    endif; // end is_user_logged_in
    ?>
  </div>
</div>

<?php get_footer();
