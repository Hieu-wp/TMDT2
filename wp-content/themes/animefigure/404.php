<?php
/**
 * AnimeFigure Store - 404.php
 */
get_header();
?>
<main style="min-height:60vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:80px 20px;">
  <div>
    <div style="font-size:120px;line-height:1;margin-bottom:24px;">🎭</div>
    <h1 style="font-size:3rem;font-weight:900;color:#222;margin-bottom:16px;">404</h1>
    <p style="font-size:18px;color:#666;margin-bottom:32px;">Trang này không tồn tại hoặc đã bị xóa.</p>
    <a href="<?php echo home_url('/'); ?>" style="display:inline-flex;align-items:center;gap:8px;padding:14px 32px;background:#2F80ED;color:#fff;border-radius:99px;font-weight:700;font-size:16px;text-decoration:none;">
      ← Về trang chủ
    </a>
  </div>
</main>
<?php get_footer(); ?>
