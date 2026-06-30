<?php
/**
 * Template Name: Trang Blog
 *
 * This template displays the list of blog posts.
 */
get_header();
?>

<main class="site-main">
  <!-- Hero Section cho Blog -->
  <section class="section" style="background:#f8f9fa;padding:60px 0;">
    <div class="container">
      <div class="section-header" style="text-align:center;margin-bottom:0;">
        <div class="section-label" style="justify-content:center;">Tin tức & Review</div>
        <h1 class="section-title" style="font-size:36px;">Kiến Thức Về Mô Hình Anime</h1>
        <p class="section-subtitle" style="margin:0 auto;">Cập nhật những thông tin, review và hướng dẫn mới nhất từ cộng đồng collector</p>
      </div>
    </div>
  </section>

  <!-- Grid Bài Viết -->
  <section class="section">
    <div class="container">
      <div class="blog-grid">
        <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 9,
            'paged'          => $paged,
        );
        $blog_query = new WP_Query($args);

        if ($blog_query->have_posts()) :
          while ($blog_query->have_posts()) : $blog_query->the_post();
        ?>
        <a href="<?php the_permalink(); ?>" class="blog-card reveal">
          <div class="blog-card-image">
            <?php if (has_post_thumbnail()): ?>
              <img src="<?php the_post_thumbnail_url('medium_large'); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
            <?php else: ?>
              <img src="https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?w=600&h=338&fit=crop&q=80" alt="" loading="lazy">
            <?php endif; ?>
            <span class="blog-card-cat">
              <?php 
              $categories = get_the_category();
              if ( ! empty( $categories ) ) {
                  echo esc_html( $categories[0]->name );   
              } else {
                  echo 'Tin tức';
              }
              ?>
            </span>
          </div>
          <div class="blog-card-body">
            <div class="blog-card-meta">
              <span class="blog-meta-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <?php echo get_the_date('d/m/Y'); ?>
              </span>
              <span class="blog-meta-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <?php echo get_the_author(); ?>
              </span>
            </div>
            <h3 class="blog-card-title"><?php echo esc_html(get_the_title()); ?></h3>
            <p class="blog-card-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
          </div>
          <div class="blog-card-footer">
            <span class="blog-read-more">
              Đọc thêm
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </span>
          </div>
        </a>
        <?php 
          endwhile;
        ?>
      </div>
      
      <!-- Phân trang -->
      <div class="pagination" style="margin-top:40px;display:flex;justify-content:center;gap:8px;">
        <?php 
          echo paginate_links(array(
            'total' => $blog_query->max_num_pages,
            'prev_text' => '&laquo; Trước',
            'next_text' => 'Sau &raquo;',
          ));
        ?>
      </div>
      
      <?php
          wp_reset_postdata();
        else :
      ?>
        <div style="grid-column:1/-1;text-align:center;padding:40px;background:#f8f9fa;border-radius:12px;color:#666;">Chưa có bài viết nào.</div>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>
