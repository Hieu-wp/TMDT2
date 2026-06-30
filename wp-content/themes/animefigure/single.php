<?php
/**
 * AnimeFigure Store - single.php
 * Single post/product template
 */
get_header();
?>
<main class="site-main">
  <div class="container" style="padding-top:40px;padding-bottom:80px;">
    <?php while (have_posts()): the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <h1 style="font-size:2rem;font-weight:800;margin-bottom:24px;"><?php the_title(); ?></h1>
      <?php if (has_post_thumbnail()): ?>
        <div style="margin-bottom:32px;border-radius:16px;overflow:hidden;">
          <?php the_post_thumbnail('large', ['style' => 'width:100%;max-height:500px;object-fit:cover;']); ?>
        </div>
      <?php endif; ?>
      <div class="entry-content" style="max-width:800px;line-height:1.8;font-size:16px;color:#444;">
        <?php the_content(); ?>
      </div>
    </article>
    <?php endwhile; ?>
  </div>
</main>
<?php get_footer(); ?>
