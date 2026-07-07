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
          <div class="wishlist-item card" style="background:#fff;padding:12px;border-radius:12px;border:1px solid #eee;display:flex;flex-direction:column;gap:12px;">
            <a href="<?php echo get_permalink( $product_id ); ?>" style="display:block;aspect-ratio:3/4;overflow:hidden;border-radius:8px;">
              <img src="<?php echo esc_url( get_the_post_thumbnail_url( $product_id, 'medium' ) ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>" style="width:100%;height:100%;object-fit:cover;"/>
            </a>
            <div style="flex:1;">
              <a href="<?php echo get_permalink( $product_id ); ?>" style="font-weight:700;color:var(--color-text);display:block;margin-bottom:6px;"><?php echo esc_html( $product->get_name() ); ?></a>
              <div style="font-weight:800;color:#2F80ED;font-size:1.05rem;"><?php echo $product->get_price_html(); ?></div>
            </div>

            <div style="display:flex;gap:8px;align-items:center;">
              <?php if ( $product->is_purchasable() && $product->is_in_stock() ) : ?>
                <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="btn btn-primary" style="flex:1;text-align:center;">Thêm vào giỏ</a>
              <?php else : ?>
                <a href="<?php echo get_permalink( $product_id ); ?>" class="btn btn-outline" style="flex:1;text-align:center;">Xem chi tiết</a>
              <?php endif; ?>

              <button class="product-wishlist-btn active" data-id="<?php echo esc_attr( $product_id ); ?>" aria-label="Xóa khỏi wishlist" title="Xóa" style="width:48px;height:48px;border-radius:12px;">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 6 4 4 6.5 4c1.74 0 3.41.81 4.5 2.09C12.09 4.81 13.76 4 15.5 4 18 4 20 6 20 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
              </button>
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
