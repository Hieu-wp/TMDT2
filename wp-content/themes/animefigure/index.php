<?php
/**
 * AnimeFigure Store - index.php / Homepage Template
 * Template Name: Trang chủ AnimeFigure
 */

get_header();

/**
 * Render product card for WooCommerce
 */
function render_product_card($product, $idx = 0) {
  if (!$product || !is_a($product, 'WC_Product')) return;
  $delay_class = 'reveal-delay-' . min($idx + 1, 4);
  ?>
  <div class="product-card reveal <?php echo $delay_class; ?>">
    <div class="product-card-image-wrap">

      <!-- Badge -->
      <div class="product-badge">
        <?php if ($product->is_on_sale()): ?>
          <span class="badge badge-sale">Sale</span>
        <?php endif; ?>
        <?php 
        $created_days = (time() - strtotime($product->get_date_created())) / (60 * 60 * 24);
        if ($created_days < 14): ?>
          <span class="badge badge-new">New</span>
        <?php endif; ?>
      </div>

      <!-- Wishlist -->
      <button class="product-wishlist-btn" aria-label="Thêm vào wishlist">
        <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
      </button>

      <!-- Image -->
      <a href="<?php echo esc_url($product->get_permalink()); ?>">
        <?php 
        if ($product->get_image_id()) {
          echo $product->get_image('woocommerce_thumbnail', ['loading' => 'lazy', 'alt' => esc_attr($product->get_name())]);
        } else {
          echo '<div class="img-placeholder" style="width:100%;height:100%;aspect-ratio:3/4;background:#f0f4f8;display:flex;align-items:center;justify-content:center;font-size:48px;">🎭</div>';
        }
        ?>
      </a>

      <!-- Overlay actions -->
      <div class="product-card-overlay">
        <a href="<?php echo esc_url($product->get_permalink()); ?>" class="btn-quickview" style="display:flex;justify-content:center;text-decoration:none;align-items:center;padding:12px;background:rgba(255,255,255,0.95);border-radius:24px;font-weight:600;font-size:13px;color:#222;margin-bottom:8px;">
          👁 Xem chi tiết
        </a>
        <a href="?add-to-cart=<?php echo esc_attr($product->get_id()); ?>" data-quantity="1" class="btn-addtocart ajax_add_to_cart" data-product_id="<?php echo esc_attr($product->get_id()); ?>" data-product_sku="<?php echo esc_attr($product->get_sku()); ?>" aria-label="Thêm vào giỏ">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg>
          Thêm vào giỏ
        </a>
      </div>
    </div>

    <div class="product-card-info">
      <?php 
      $brands = wc_get_product_terms( $product->get_id(), 'product_cat', ['fields' => 'names'] );
      $brand_name = !empty($brands) ? $brands[0] : 'Mô hình';
      ?>
      <div class="product-brand"><?php echo esc_html($brand_name); ?></div>
      <a href="<?php echo esc_url($product->get_permalink()); ?>" class="product-name"><?php echo esc_html($product->get_name()); ?></a>
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
      <div class="product-price">
        <span class="price-current" style="font-weight:800;color:var(--color-primary);font-size:18px;"><?php echo wc_price(wc_get_price_to_display($product)); ?></span>
        <?php if ($product->is_on_sale() && $product->get_regular_price()): ?>
          <span class="price-original" style="text-decoration:line-through;color:#999;font-size:13px;margin-left:6px;"><?php echo wc_price(wc_get_price_to_display($product, ['price' => $product->get_regular_price()])); ?></span>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php
}
?>

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
     TRUST STRIP
     ========================================================= -->
<div class="trust-strip">
  <div class="container">
    <div class="trust-grid">
      <div class="trust-item">
        <div class="trust-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <div class="trust-text">
          <h4>Hàng Chính Hãng 100%</h4>
          <p>Cam kết nguồn gốc rõ ràng</p>
        </div>
      </div>
      <div class="trust-item">
        <div class="trust-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </div>
        <div class="trust-text">
          <h4>Giao Hàng Toàn Quốc</h4>
          <p>Đóng gói cẩn thận, nhanh chóng</p>
        </div>
      </div>
      <div class="trust-item">
        <div class="trust-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
        </div>
        <div class="trust-text">
          <h4>Đổi Trả 30 Ngày</h4>
          <p>Không hài lòng, hoàn tiền ngay</p>
        </div>
      </div>
      <div class="trust-item">
        <div class="trust-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013 13.81a19.79 19.79 0 01-3.07-8.68A2 2 0 011.91 3h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 10.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 17.92z"/></svg>
        </div>
        <div class="trust-text">
          <h4>Hỗ Trợ 7/7</h4>
          <p>Hotline: 1800-9999 miễn phí</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- =========================================================
     DANH MỤC NỔI BẬT
     ========================================================= -->
<section class="section">
  <div class="container">
    <div class="section-header">
      <div class="section-header-left">
        <div class="section-label">Danh mục</div>
        <h2 class="section-title">Khám Phá Loại Mô Hình</h2>
        <p class="section-subtitle">Đa dạng từ chibi dễ thương đến statue tỉ lệ thật</p>
      </div>
      <a href="<?php echo function_exists('wc_get_page_id') ? get_permalink( wc_get_page_id('shop') ) : '#'; ?>" class="view-all-link">
        Tất cả danh mục
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
      </a>
    </div>

    <div class="categories-grid">
      <?php
      $categories = [
        ['name' => 'Nendoroid',    'emoji' => '🎭', 'count' => '240+', 'bg' => '#EBF3FD', 'slug' => 'nendoroid'],
        ['name' => 'Scale Figure', 'emoji' => '⚔️', 'count' => '180+', 'bg' => '#FEF6EE', 'slug' => 'scale-figure'],
        ['name' => 'Figma',        'emoji' => '🤸', 'count' => '120+', 'bg' => '#F0FFF4', 'slug' => 'figma'],
        ['name' => 'Pop Up Parade','emoji' => '🌟', 'count' => '95+',  'bg' => '#FDF4FF', 'slug' => 'pop-up-parade'],
        ['name' => 'Plushie',      'emoji' => '🧸', 'count' => '60+',  'bg' => '#FFFBEB', 'slug' => 'plushie'],
      ];
      foreach ($categories as $cat):
        $term = function_exists('get_term_by') ? get_term_by('slug', $cat['slug'], 'product_cat') : null;
        $url  = $term ? get_term_link($term) : '#';
      ?>
      <a href="<?php echo esc_url($url); ?>" class="category-card reveal">
        <div class="category-icon" style="background:<?php echo $cat['bg']; ?>;">
          <?php echo $cat['emoji']; ?>
        </div>
        <div class="category-name"><?php echo $cat['name']; ?></div>
        <div class="category-count"><?php echo $cat['count']; ?> sản phẩm</div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

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

    <div class="products-grid products-grid-4">
      <?php
      if (function_exists('wc_get_products')) {
        $products = wc_get_products(['limit' => 8, 'status' => 'publish', 'orderby' => 'date', 'order' => 'DESC']);
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
        <!-- Tab Filter -->
        <div class="tab-nav">
          <button class="tab-btn active" data-tab="all">Tất cả</button>
          <button class="tab-btn" data-tab="nendoroid">Nendoroid</button>
          <button class="tab-btn" data-tab="scale">Scale</button>
          <button class="tab-btn" data-tab="figma">Figma</button>
        </div>
        <a href="#" class="view-all-link">
          Xem thêm
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
      </div>
    </div>

    <div class="products-grid products-grid-4" id="bestsellers-grid">
      <?php
      if (function_exists('wc_get_products')) {
        $bestsellers = wc_get_products(['limit' => 8, 'status' => 'publish', 'meta_key' => 'total_sales', 'orderby' => 'meta_value_num', 'order' => 'DESC']);
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
     BỘ SƯU TẬP SERIES ANIME
     ========================================================= -->
<section class="section section-alt">
  <div class="container">
    <div class="section-header">
      <div class="section-header-left">
        <div class="section-label">Collections</div>
        <h2 class="section-title">Theo Nhân Vật & Series</h2>
        <p class="section-subtitle">Sưu tầm đủ bộ theo anime yêu thích của bạn</p>
      </div>
      <a href="#" class="view-all-link">
        Tất cả series
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
      </a>
    </div>

    <div class="series-grid">
      <?php
      $series_collections = [
        [
          'name'  => 'Demon Slayer',
          'count' => '48 sản phẩm',
          'badge' => 'hot',
          'img'   => 'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?w=600&h=450&fit=crop&q=80',
          'color' => '#e74c3c',
        ],
        [
          'name'  => 'One Piece',
          'count' => '62 sản phẩm',
          'badge' => '',
          'img'   => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=600&h=450&fit=crop&q=80',
          'color' => '#f39c12',
        ],
        [
          'name'  => 'Jujutsu Kaisen',
          'count' => '35 sản phẩm',
          'badge' => 'new',
          'img'   => 'https://images.unsplash.com/photo-1601850494422-3cf14624b0b3?w=600&h=450&fit=crop&q=80',
          'color' => '#9b59b6',
        ],
        [
          'name'  => 'Attack on Titan',
          'count' => '41 sản phẩm',
          'badge' => '',
          'img'   => 'https://images.unsplash.com/photo-1619855544858-e8e275c3b31a?w=600&h=450&fit=crop&q=80',
          'color' => '#2ecc71',
        ],
      ];
      foreach ($series_collections as $s):
      ?>
      <a href="#" class="series-card reveal">
        <img src="<?php echo esc_url($s['img']); ?>" alt="<?php echo esc_attr($s['name']); ?>" loading="lazy">
        <div class="series-card-overlay">
          <div class="series-name"><?php echo esc_html($s['name']); ?></div>
          <div class="series-count"><?php echo esc_html($s['count']); ?></div>
        </div>
        <?php if ($s['badge'] === 'hot'): ?>
        <div class="series-card-badge">
          <span class="badge badge-hot">🔥 Hot</span>
        </div>
        <?php elseif ($s['badge'] === 'new'): ?>
        <div class="series-card-badge">
          <span class="badge badge-new">New</span>
        </div>
        <?php endif; ?>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- =========================================================
     BỘ SƯU TẬP THEO HÃNG SẢN XUẤT
     ========================================================= -->
<section class="section">
  <div class="container">
    <div class="section-header">
      <div class="section-header-left">
        <div class="section-label">Thương hiệu</div>
        <h2 class="section-title">Hãng Sản Xuất Uy Tín</h2>
        <p class="section-subtitle">Chúng tôi là đại lý chính thức của các thương hiệu hàng đầu Nhật Bản</p>
      </div>
    </div>

    <div class="brands-grid">
      <?php
      $brands = [
        ['name' => 'Good Smile Company', 'short' => 'GSC',     'emoji' => '🌈', 'count' => '450+ sp', 'bg' => '#EBF3FD'],
        ['name' => 'Max Factory',        'short' => 'MAX',     'emoji' => '🏭', 'count' => '280+ sp', 'bg' => '#FEF6EE'],
        ['name' => 'Bandai Spirits',     'short' => 'BANDAI',  'emoji' => '🎮', 'count' => '620+ sp', 'bg' => '#F0FFF4'],
        ['name' => 'Kotobukiya',         'short' => 'KOTO',    'emoji' => '🎌', 'count' => '180+ sp', 'bg' => '#FDF4FF'],
        ['name' => 'Alter',              'short' => 'ALTER',   'emoji' => '✨', 'count' => '120+ sp', 'bg' => '#FFFBEB'],
        ['name' => 'Megahouse',          'short' => 'MEGA',    'emoji' => '🏠', 'count' => '95+ sp',  'bg' => '#F0F9FF'],
      ];
      foreach ($brands as $brand):
      ?>
      <a href="#" class="brand-card reveal">
        <div class="brand-logo" style="font-size:13px;font-weight:900;letter-spacing:0.04em;background:<?php echo $brand['bg']; ?>;width:80px;height:48px;display:flex;align-items:center;justify-content:center;border-radius:8px;">
          <?php echo $brand['emoji'] . ' ' . $brand['short']; ?>
        </div>
        <div style="text-align:center;">
          <div style="font-size:12px;font-weight:700;color:#333;margin-bottom:2px;"><?php echo $brand['name']; ?></div>
          <div class="brand-name"><?php echo $brand['count']; ?></div>
        </div>
      </a>
      <?php endforeach; ?>
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
      <a href="<?php echo home_url('/blog'); ?>" class="view-all-link">
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
