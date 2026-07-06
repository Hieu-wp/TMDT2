<?php
/**
 * AnimeFigure Store - header.php
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php bloginfo('description'); ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- NAVBAR -->
<header class="navbar" id="navbar">
  <div class="container">
    <nav class="navbar-inner">

      <!-- Logo -->
      <a class="navbar-logo" href="<?php echo home_url('/'); ?>">
        <div class="logo-icon">
          <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
        </div>
        <div class="logo-text">
          <div class="logo-name">Anime<span>Figure</span></div>
          <div class="logo-tagline">Premium Anime Figures</div>
        </div>
      </a>

      <?php
      if ( has_nav_menu( 'primary' ) ) {
          wp_nav_menu( [
              'theme_location'  => 'primary',
              'container'       => false,
              'menu_class'      => 'navbar-nav',
              'fallback_cb'     => false,
          ] );
      } else {
          echo '<ul class="navbar-nav"><li class="nav-item"><a class="nav-link" href="' . admin_url('nav-menus.php') . '">Vui lòng tạo Menu</a></li></ul>';
      }
      ?>

      <!-- Search -->
      <div class="navbar-search">
        <form role="search" method="get" action="<?php echo home_url('/'); ?>">
          <input type="search" name="s" placeholder="Tìm kiếm figure..." value="<?php echo get_search_query(); ?>" autocomplete="off">
          <input type="hidden" name="post_type" value="product">
          <button type="submit" class="search-btn" aria-label="Tìm kiếm">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
          </button>
        </form>
      </div>

      <!-- Actions -->
      <div class="navbar-actions">

        <!-- Wishlist -->
        <a class="action-btn" href="<?php echo home_url('/wishlist'); ?>" aria-label="Danh sách yêu thích" title="Wishlist">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
          <span class="action-badge" id="wishlist-count">0</span>
        </a>

        <!-- Cart -->
        <div class="action-btn" style="position:relative" aria-label="Giỏ hàng">
          <a href="<?php echo wc_get_cart_url(); ?>" aria-label="Giỏ hàng">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg>
            <span class="action-badge" id="cart-count"><?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?></span>
          </a>
          <!-- Mini cart -->
          <div class="cart-dropdown">
            <?php if ( WC()->cart && WC()->cart->get_cart_contents_count() > 0 ) :
              foreach ( WC()->cart->get_cart() as $item ) :
                $product = $item['data'];
            ?>
            <div style="display:flex;gap:12px;padding:8px 0;border-bottom:1px solid #ececec;">
              <img src="<?php echo get_the_post_thumbnail_url($product->get_id(), 'thumbnail'); ?>" style="width:52px;height:52px;object-fit:cover;border-radius:8px;">
              <div>
                <div style="font-size:13px;font-weight:600;"><?php echo $product->get_name(); ?></div>
                <div style="font-size:12px;color:#666;">x<?php echo $item['quantity']; ?></div>
                <div style="font-size:13px;font-weight:700;color:#2F80ED;"><?php echo wc_price($product->get_price()); ?></div>
              </div>
            </div>
            <?php endforeach;
            else: ?>
            <div class="cart-empty">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg>
              <p>Giỏ hàng trống</p>
            </div>
            <?php endif; ?>
            <?php if ( WC()->cart && WC()->cart->get_cart_contents_count() > 0 ) : ?>
            <div style="padding-top:12px;display:flex;flex-direction:column;gap:8px;">
              <div style="display:flex;justify-content:space-between;font-weight:700;margin-bottom:4px;">
                <span>Tổng cộng:</span>
                <span style="color:#2F80ED;"><?php echo WC()->cart->get_cart_total(); ?></span>
              </div>
              <a href="<?php echo wc_get_cart_url(); ?>" class="btn btn-primary btn-sm" style="text-align:center;">Xem giỏ hàng</a>
              <a href="<?php echo wc_get_checkout_url(); ?>" class="btn btn-accent btn-sm" style="text-align:center;">Thanh toán</a>
            </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Account -->
        <div class="action-btn" style="position:relative">
          <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" aria-label="Tài khoản">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </a>
          <div class="user-dropdown">
            <?php if ( is_user_logged_in() ) : 
              $current_user = wp_get_current_user();
            ?>
              <div class="user-info">
                <strong>Xin chào, <?php echo esc_html( $current_user->display_name ); ?></strong>
              </div>
              <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">Bảng điều khiển</a>
              <a href="<?php echo wc_get_account_endpoint_url( 'orders' ); ?>">Đơn hàng của tôi</a>
              <a href="<?php echo wp_logout_url( home_url() ); ?>" style="color:#EB5757; border-top:1px solid #eee; margin-top:8px; padding-top:12px;">Đăng xuất</a>
            <?php else : ?>
              <div class="user-info">
                <strong>Khách truy cập</strong>
                <p style="font-size:12px;color:#666;margin:4px 0 0;line-height:1.4;">Đăng nhập để tích điểm & nhận ưu đãi</p>
              </div>
              <div style="display:flex; flex-direction:column; gap:8px; margin-top:12px;">
                <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="btn btn-primary btn-sm" style="display:block;text-align:center;">Đăng nhập</a>
                <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="btn btn-outline btn-sm" style="display:block;text-align:center;">Đăng ký ngay</a>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Hamburger -->
        <button class="hamburger" id="hamburger" aria-label="Menu">
          <span></span><span></span><span></span>
        </button>
      </div>

    </nav>
  </div>
</header>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">
  <?php
  if ( has_nav_menu( 'primary' ) ) {
      wp_nav_menu( [
          'theme_location'  => 'primary',
          'container'       => false,
          'menu_class'      => 'mobile-nav-list',
          'fallback_cb'     => false,
      ] );
  } else {
      echo '<a class="mobile-nav-link" href="' . admin_url('nav-menus.php') . '">Vui lòng tạo Menu</a>';
  }
  ?>
  <div style="padding:16px 0;">
    <form role="search" method="get" action="<?php echo home_url('/'); ?>">
      <div style="position:relative;">
        <input type="search" name="s" placeholder="Tìm kiếm figure..." style="width:100%;height:44px;padding:0 44px 0 16px;border:1.5px solid #ececec;border-radius:22px;font-size:14px;">
        <input type="hidden" name="post_type" value="product">
        <button type="submit" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        </button>
      </div>
    </form>
  </div>
</div>

<!-- =========================================================
     COMPACT TRUST STRIP
     ========================================================= -->
<div class="compact-trust-strip" style="background:#f8f9fa; border-bottom:1px solid #ececec; padding:12px 0;">
  <div class="container">
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
      
      <!-- Item 1 -->
      <div style="display:flex; align-items:center; gap:12px;">
        <div style="background:#ffcccb; color:#f28c8c; width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <div>
          <div style="font-size:13px; font-weight:700; color:#333;">Hàng Chính Hãng 100%</div>
          <div style="font-size:11px; color:#777;">Cam kết nguồn gốc rõ ràng</div>
        </div>
      </div>

      <!-- Item 2 -->
      <div style="display:flex; align-items:center; gap:12px;">
        <div style="background:#ffcccb; color:#f28c8c; width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </div>
        <div>
          <div style="font-size:13px; font-weight:700; color:#333;">Giao Hàng Toàn Quốc</div>
          <div style="font-size:11px; color:#777;">Đóng gói cẩn thận, nhanh chóng</div>
        </div>
      </div>

      <!-- Item 3 -->
      <div style="display:flex; align-items:center; gap:12px;">
        <div style="background:#ffcccb; color:#f28c8c; width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
        </div>
        <div>
          <div style="font-size:13px; font-weight:700; color:#333;">Đổi Trả 30 Ngày</div>
          <div style="font-size:11px; color:#777;">Không hài lòng, hoàn tiền ngay</div>
        </div>
      </div>

      <!-- Item 4 -->
      <div style="display:flex; align-items:center; gap:12px;">
        <div style="background:#ffcccb; color:#f28c8c; width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013 13.81a19.79 19.79 0 01-3.07-8.68A2 2 0 011.91 3h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 10.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 17.92z"/></svg>
        </div>
        <div>
          <div style="font-size:13px; font-weight:700; color:#333;">Hỗ Trợ 7/7</div>
          <div style="font-size:11px; color:#777;">Hotline: 1800-9999 miễn phí</div>
        </div>
      </div>

    </div>
  </div>
</div>
