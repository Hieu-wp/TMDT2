<?php
/**
 * AnimeFigure Store - index.php / Homepage Template
 * Template Name: Trang chủ AnimeFigure
 */

get_header();



<!-- =========================================================
     HERO BANNER
     ========================================================= -->
<section class="hero" id="hero">
  <div class="hero-bg">
    <img class="hero-bg-image" src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?w=1920&h=700&fit=crop&q=60" alt="">
    <div class="hero-bg-gradient"></div>
  </div>
  <div class="hero-shapes">
    <div class="hero-shape hero-shape-1"></div>
    <div class="hero-shape hero-shape-2"></div>
    <div class="hero-shape hero-shape-3"></div>
  </div>

  <div class="container" style="width:100%;">
    <div class="hero-content">

      <div class="hero-text">
        <div class="hero-label">✨ Bộ sưu tập 2025 đã có mặt</div>
        <h1 class="hero-title">
          Thiên Đường<br>
          <span class="highlight">Mô Hình Anime</span><br>
          Chính Hãng
        </h1>
        <p class="hero-desc">
          Khám phá hơn <strong style="color:#74b8f7;">2,000+ sản phẩm</strong> độc quyền từ các thương hiệu hàng đầu Nhật Bản — Good Smile, Max Factory, Bandai Spirits và nhiều hơn nữa.
        </p>
        <div class="hero-cta">
          <a href="<?php echo function_exists('wc_get_page_id') ? get_permalink( wc_get_page_id('shop') ) : '#'; ?>" class="btn btn-primary btn-lg">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            Khám phá ngay
          </a>
          <a href="#new-arrivals" class="btn btn-secondary btn-lg">
            Hàng mới về
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
          </a>
        </div>
        <div class="hero-stats">
          <div class="hero-stat">
            <span class="hero-stat-number">2,000+</span>
            <span class="hero-stat-label">Sản phẩm</span>
          </div>
          <div class="hero-stat">
            <span class="hero-stat-number">50+</span>
            <span class="hero-stat-label">Thương hiệu</span>
          </div>
          <div class="hero-stat">
            <span class="hero-stat-number">15K+</span>
            <span class="hero-stat-label">Khách hàng</span>
          </div>
          <div class="hero-stat">
            <span class="hero-stat-number">4.9★</span>
            <span class="hero-stat-label">Đánh giá</span>
          </div>
        </div>
      </div>

      <!-- Hero Visual -->
      <div class="hero-visual">
        <div class="hero-product-showcase">

          <!-- Main Product Image -->
          <div class="hero-product-main">
            <img src="https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?w=600&h=760&fit=crop&q=80" alt="Featured Figure">
          </div>

          <!-- Floating Card 1 -->
          <div class="hero-product-card hero-product-card-1">
            <div class="hpc-label">🔥 Bán chạy</div>
            <div class="hpc-value">Nendoroid</div>
            <div class="hpc-sub">Nezuko Kamado</div>
            <div style="margin-top:8px;display:flex;align-items:center;gap:6px;">
              <span style="font-size:14px;font-weight:800;color:#74b8f7;">950,000₫</span>
            </div>
          </div>

          <!-- Floating Card 2 -->
          <div class="hero-product-card hero-product-card-2">
            <div class="hpc-label">⭐ Đánh giá</div>
            <div style="display:flex;gap:2px;margin:4px 0;">
              <span style="color:#f5c518;font-size:16px;">★★★★★</span>
            </div>
            <div class="hpc-sub">15,000+ khách hài lòng</div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>



<!-- =========================================================
     DANH MỤC NỔI BẬT
     ========================================================= -->
<!-- =========================================================
     FLASH SALE NỔI BẬT
     ========================================================= -->
<section class="flash-sale-section" id="flash-sale">
  <div class="container">
    <div class="flash-sale-header-container">
      <div class="flash-sale-header-left">
        <div class="flash-sale-badge">⚡ CHỈ HÔM NAY</div>
        <h2 class="flash-sale-title">Flash Sale Figure Giá Sốc</h2>
        <p class="flash-sale-subtitle">Số lượng có hạn, ưu đãi sẽ kết thúc sau:</p>
      </div>
      
      <!-- Countdown Timer -->
      <div class="flash-sale-countdown" id="fs-countdown">
        <div class="countdown-item">
          <span class="countdown-num" id="fs-hours">08</span>
          <span class="countdown-lbl">Giờ</span>
        </div>
        <div class="countdown-divider">:</div>
        <div class="countdown-item">
          <span class="countdown-num" id="fs-minutes">00</span>
          <span class="countdown-lbl">Phút</span>
        </div>
        <div class="countdown-divider">:</div>
        <div class="countdown-item">
          <span class="countdown-num" id="fs-seconds">00</span>
          <span class="countdown-lbl">Giây</span>
        </div>
      </div>
    </div>

    <!-- Products Loop -->
    <div class="flash-sale-grid">
      <?php
      if (function_exists('wc_get_products')) {
          // Fetch on-sale products
          $sale_product_ids = wc_get_product_ids_on_sale();
          if (!empty($sale_product_ids)) {
              $products = wc_get_products([
                  'include' => array_slice($sale_product_ids, 0, 5),
                  'status'  => 'publish'
              ]);
          } else {
              // Fallback to recent products if no sale products exist
              $products = wc_get_products([
                  'limit'  => 5,
                  'status' => 'publish'
              ]);
          }
          
          if (!empty($products)) {
              foreach ($products as $idx => $product) {
                  $regular_price = $product->get_regular_price();
                  $sale_price    = $product->get_sale_price();
                  
                  // Calculate discount percentage
                  if ($product->is_on_sale() && $regular_price > 0 && $sale_price > 0) {
                      $discount_percent = round((($regular_price - $sale_price) / $regular_price) * 100);
                  } else {
                      // Mock discount if not on sale
                      $discount_percent = 30 + (($product->get_id() % 3) * 5); // 30%, 35%, 40%
                      $regular_price = $product->get_price();
                      $sale_price    = $regular_price * (1 - $discount_percent/100);
                  }
                  
                  // Mock a stock status progress
                  $total_stock = 20 + ($product->get_id() % 10);
                  $sold_stock  = 12 + ($product->get_id() % 8);
                  $percent_sold = round(($sold_stock / $total_stock) * 100);
                  
                  $brands = wc_get_product_terms($product->get_id(), 'product_cat', ['fields' => 'names']);
                  $brand_name = !empty($brands) ? $brands[0] : 'Mô hình';
                  ?>
                  <div class="product-card flash-sale-card reveal reveal-delay-<?php echo min($idx + 1, 4); ?>">
                      <div class="product-card-image-wrap">
                          <!-- Discount percentage badge -->
                          <div class="product-badge">
                              <span class="badge badge-sale">-<?php echo intval($discount_percent); ?>%</span>
                          </div>
                          
                          <!-- Wishlist button -->
                          <?php
                          $current_user_wishlist = (array) get_user_meta(get_current_user_id(), '_wishlist', true);
                          $is_fav = in_array($product->get_id(), $current_user_wishlist);
                          ?>
                          <button class="product-wishlist-btn<?php echo $is_fav ? ' active' : ''; ?>" data-id="<?php echo esc_attr($product->get_id()); ?>" aria-label="Thêm vào wishlist">
                              <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                          </button>

                          <!-- Product Image -->
                          <a href="<?php echo esc_url($product->get_permalink()); ?>">
                              <?php 
                              if ($product->get_image_id()) {
                                  echo $product->get_image('woocommerce_thumbnail', ['loading' => 'lazy', 'alt' => esc_attr($product->get_name())]);
                              } else {
                                  echo '<div class="img-placeholder" style="width:100%;height:100%;aspect-ratio:3/4;background:#f0f4f8;display:flex;align-items:center;justify-content:center;font-size:48px;">🎭</div>';
                              }
                              ?>
                          </a>
                          
                          <!-- Quickview overlay actions -->
                          <div class="product-card-overlay">
                              <a href="<?php echo esc_url($product->get_permalink()); ?>" class="btn-quickview" style="display:flex;justify-content:center;text-decoration:none;align-items:center;padding:12px;background:rgba(255,255,255,0.95);border-radius:24px;font-weight:600;font-size:13px;color:#222;margin-bottom:8px;">
                                  👁 Xem chi tiết
                              </a>
                              <a href="?add-to-cart=<?php echo esc_attr($product->get_id()); ?>" data-quantity="1" class="btn-addtocart ajax_add_to_cart" data-product_id="<?php echo esc_attr($product->get_id()); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>">
                                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg>
                                  Thêm vào giỏ
                              </a>
                          </div>
                      </div>
                      
                      <div class="product-card-info">
                          <div class="product-brand"><?php echo esc_html($brand_name); ?></div>
                          <a href="<?php echo esc_url($product->get_permalink()); ?>" class="product-name"><?php echo esc_html($product->get_name()); ?></a>
                          
                          <!-- Rating stars -->
                          <div class="product-rating">
                              <?php 
                              $rating = $product->get_average_rating();
                              $stars = round($rating);
                              for ($s = 1; $s <= 5; $s++) {
                                  echo $s <= $stars ? '<span style="color:#f5c518;font-size:13px;">★</span>' : '<span style="color:#ddd;font-size:13px;">★</span>';
                              }
                              ?>
                              <span class="rating-count">(<?php echo $product->get_review_count(); ?>)</span>
                          </div>
                          
                          <!-- Prices -->
                          <div class="product-price">
                              <span class="price-current" style="font-weight:800;color:var(--color-primary);font-size:18px;"><?php echo wc_price($sale_price); ?></span>
                              <span class="price-original" style="text-decoration:line-through;color:#999;font-size:13px;margin-left:6px;"><?php echo wc_price($regular_price); ?></span>
                          </div>
                          
                          <!-- Stock Sold Progress Bar -->
                          <div class="fs-stock-progress" style="margin-top: 10px;">
                              <div class="fs-progress-bar-wrap">
                                  <div class="fs-progress-bar-fill" style="width: <?php echo intval($percent_sold); ?>%;"></div>
                              </div>
                              <div class="fs-stock-text">
                                  <span>🔥 Đã bán <?php echo intval($sold_stock); ?></span>
                                  <span>Còn lại <?php echo intval($total_stock - $sold_stock); ?></span>
                              </div>
                          </div>
                      </div>
                  </div>
                  <?php
              }
          } else {
              echo '<div style="grid-column:1/-1;text-align:center;padding:40px;background:#f8f9fa;border-radius:12px;color:#666;">Chưa có sản phẩm nào. Vui lòng thêm sản phẩm mới trong Admin WooCommerce.</div>';
          }
      }
      ?>
    </div>
  </div>
</section>

<!-- Countdown Timer JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var countdownDuration = 8 * 60 * 60 * 1000; // 8 hours duration
    var fsTargetTime = localStorage.getItem('fs_countdown_target');
    var now = new Date().getTime();
    
    if (!fsTargetTime || parseInt(fsTargetTime) < now) {
        fsTargetTime = now + countdownDuration;
        localStorage.setItem('fs_countdown_target', fsTargetTime);
    } else {
        fsTargetTime = parseInt(fsTargetTime);
    }
    
    var hoursEl = document.getElementById('fs-hours');
    var minutesEl = document.getElementById('fs-minutes');
    var secondsEl = document.getElementById('fs-seconds');
    
    function updateCountdown() {
        var currentTime = new Date().getTime();
        var distance = fsTargetTime - currentTime;
        
        if (distance < 0) {
            fsTargetTime = currentTime + countdownDuration;
            localStorage.setItem('fs_countdown_target', fsTargetTime);
            distance = countdownDuration;
        }
        
        var hours = Math.floor(distance / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        if (hoursEl) hoursEl.innerText = hours < 10 ? '0' + hours : hours;
        if (minutesEl) minutesEl.innerText = minutes < 10 ? '0' + minutes : minutes;
        if (secondsEl) secondsEl.innerText = seconds < 10 ? '0' + seconds : seconds;
    }
    
    updateCountdown();
    setInterval(updateCountdown, 1000);
});
</script>

<!-- =========================================================
     SẢN PHẨM MỚI
     ========================================================= -->
<section class="section section-alt" id="new-arrivals">
  <div class="container">
    <div class="section-header">
      <div class="section-header-left">
        <div class="section-label">Mới nhất</div>
        <h2 class="section-title">Hàng Mới Về</h2>
        <p class="section-subtitle">Cập nhật liên tục từ các hãng sản xuất hàng đầu</p>
      </div>
      <a href="#" class="view-all-link">
        Xem tất cả
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
      </a>
    </div>

    <div class="products-grid products-grid-5">
      <?php
      if (function_exists('wc_get_products')) {
        $products = wc_get_products(['limit' => 10, 'status' => 'publish', 'orderby' => 'date', 'order' => 'DESC']);
        if (!empty($products)) {
          foreach ($products as $idx => $product) {
            render_product_card($product, $idx);
          }
        } else {
          echo '<div style="grid-column:1/-1;text-align:center;padding:40px;background:#f8f9fa;border-radius:12px;color:#666;">Chưa có sản phẩm nào. Vui lòng thêm sản phẩm mới trong Admin WooCommerce.</div>';
        }
      }
      ?>
    </div>
  </div>
</section>

<!-- =========================================================
     SẢN PHẨM BÁN CHẠY
     ========================================================= -->
<section class="section" id="bestsellers">
  <div class="container">
    <div class="section-header">
      <div class="section-header-left">
        <div class="section-label">🔥 Trending</div>
        <h2 class="section-title">Bán Chạy Nhất</h2>
        <p class="section-subtitle">Những sản phẩm được yêu thích nhất cộng đồng collector</p>
      </div>
      <div style="display:flex;align-items:center;gap:16px;">

        <a href="#" class="view-all-link">
          Xem thêm
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
      </div>
    </div>

    <div class="products-grid products-grid-5" id="bestsellers-grid">
      <?php
      if (function_exists('wc_get_products')) {
        $bestsellers = wc_get_products(['limit' => 10, 'status' => 'publish', 'meta_key' => 'total_sales', 'orderby' => 'meta_value_num', 'order' => 'DESC']);
        if (!empty($bestsellers)) {
          foreach ($bestsellers as $idx => $product) {
            render_product_card($product, $idx);
          }
        } else {
          echo '<div style="grid-column:1/-1;text-align:center;padding:40px;background:#f8f9fa;border-radius:12px;color:#666;">Chưa có sản phẩm nào. Vui lòng thêm sản phẩm mới trong Admin WooCommerce.</div>';
        }
      }
      ?>
    </div>
  </div>
</section>

<!-- =========================================================
     BLOG MỚI NHẤT
     ========================================================= -->
<section class="section section-alt">
  <div class="container">
    <div class="section-header">
      <div class="section-header-left">
        <div class="section-label">Blog & Tin tức</div>
        <h2 class="section-title">Kiến Thức Về Mô Hình Anime</h2>
        <p class="section-subtitle">Review, unboxing, hướng dẫn bảo quản và tin tức mới nhất</p>
      </div>
      <a href="<?php echo esc_url( home_url( '/index.php/blog/' ) ); ?>" class="view-all-link">
        Xem tất cả bài viết
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
      </a>
    </div>

    <div class="blog-grid">
      <?php
      $blog_posts = get_posts(['numberposts' => 3, 'post_status' => 'publish']);
      if (!empty($blog_posts)):
        foreach ($blog_posts as $post):
          setup_postdata($post);
      ?>
      <a href="<?php echo get_permalink($post->ID); ?>" class="blog-card reveal">
        <div class="blog-card-image">
          <?php if (has_post_thumbnail($post->ID)): ?>
            <img src="<?php echo get_the_post_thumbnail_url($post->ID, 'medium_large'); ?>" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>" loading="lazy">
          <?php else: ?>
            <img src="https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?w=600&h=338&fit=crop&q=80" alt="" loading="lazy">
          <?php endif; ?>
          <span class="blog-card-cat">Tin tức</span>
        </div>
        <div class="blog-card-body">
          <div class="blog-card-meta">
            <span class="blog-meta-item">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              <?php echo get_the_date('d/m/Y', $post->ID); ?>
            </span>
            <span class="blog-meta-item">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              <?php echo get_the_author_meta('display_name', $post->post_author); ?>
            </span>
          </div>
          <h3 class="blog-card-title"><?php echo esc_html(get_the_title($post->ID)); ?></h3>
          <p class="blog-card-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt($post->ID), 20)); ?></p>
        </div>
        <div class="blog-card-footer">
          <span class="blog-read-more">
            Đọc thêm
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
          </span>
        </div>
      </a>
      <?php endforeach; wp_reset_postdata();
      else: ?>
        <div style="grid-column:1/-1;text-align:center;padding:40px;background:#f8f9fa;border-radius:12px;color:#666;">Chưa có bài viết nào. Vui lòng thêm bài viết mới trong Admin.</div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- =========================================================
     NEWSLETTER
     ========================================================= -->
<section class="newsletter">
  <div class="container">
    <div class="newsletter-inner">
      <div class="newsletter-text">
        <h2>Đăng Ký Nhận Thông Tin</h2>
        <p>Cập nhật sản phẩm mới, hàng pre-order và tin tức anime mới nhất. Không spam, chỉ nội dung chất lượng!</p>
        <div style="display:flex;gap:24px;margin-top:24px;">
          <div style="display:flex;align-items:center;gap:8px;color:rgba(255,255,255,0.8);font-size:14px;">
            <span style="font-size:20px;">🎁</span> Tặng 50K khi đăng ký lần đầu
          </div>
          <div style="display:flex;align-items:center;gap:8px;color:rgba(255,255,255,0.8);font-size:14px;">
            <span style="font-size:20px;">📢</span> Thông báo pre-order sớm nhất
          </div>
        </div>
      </div>
      <div>
        <form class="newsletter-form" id="newsletterForm">
          <div class="newsletter-input-group">
            <input type="email" placeholder="Nhập địa chỉ email của bạn..." required id="newsletter-email">
            <button type="submit" class="newsletter-submit">Đăng ký ngay ✨</button>
          </div>
          <p class="newsletter-note">
            🔒 Email của bạn hoàn toàn được bảo mật. Hủy đăng ký bất kỳ lúc nào.
          </p>
        </form>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
