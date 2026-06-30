<?php
/**
 * AnimeFigure Store - page.php
 * Standard page template
 */
get_header();
?>
<main class="site-main">
  <div class="container" style="padding-top:40px;padding-bottom:80px;max-width:900px;">
    <?php while (have_posts()): the_post(); ?>
    <article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
      <h1 style="font-size:2rem;font-weight:800;margin-bottom:24px;color:#222;"><?php the_title(); ?></h1>
      <div class="entry-content" style="line-height:1.8;font-size:16px;color:#444;">
        <?php the_content(); ?>
      </div>
    </article>
    <?php endwhile; ?>
  </div>
</main>
<?php get_footer(); ?>
