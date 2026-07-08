<?php
/**
 * Template Name: Trang Phụ kiện
 * Description: Trang hiển thị danh sách các phụ kiện mô hình giống hệt trang Cửa hàng
 */

get_header();

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = [
    'post_type'      => 'product',
    'posts_per_page' => 12,
    'paged'          => $paged,
    'post_status'    => 'publish',
    'tax_query'      => [
        [
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => 'phu-kien',
        ],
    ],
];
$accessories_query = new WP_Query( $args );
$total = $accessories_query->found_posts;
?>

<div class="container shop-container" style="padding-top: 40px; padding-bottom: 60px; display: flex; gap: 40px; align-items: flex-start;">
    
    <!-- Sidebar -->
    <?php if ( is_active_sidebar( 'sidebar-shop' ) ) : ?>
        <aside class="shop-sidebar" style="flex: 0 0 280px; position: sticky; top: 100px;">
            <?php dynamic_sidebar( 'sidebar-shop' ); ?>
        </aside>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="shop-main-content" style="flex: 1; min-width: 0;">
        <header class="woocommerce-products-header" style="margin-bottom: 24px;">
            <h1 class="woocommerce-products-header__title page-title" style="font-size: 2.5rem; font-weight: 800; color: #333; margin-bottom: 8px;">Phụ kiện</h1>
            
            <?php if ( $total > 0 ) : ?>
                <p class="woocommerce-result-count" style="color: #666; margin: 0 0 24px 0;">
                    Hiển thị tất cả <?php echo $total; ?> kết quả
                </p>
            <?php endif; ?>
        </header>

        <?php if ( $accessories_query->have_posts() ) : ?>
            
            <div class="products-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px;">
                <?php 
                $idx = 0;
                while ( $accessories_query->have_posts() ) : $accessories_query->the_post(); 
                    global $product;
                    if ( function_exists('render_product_card') ) {
                        render_product_card($product, $idx);
                    } else {
                        wc_get_template_part( 'content', 'product' );
                    }
                    $idx++;
                endwhile; 
                ?>
            </div>

            <!-- Phân trang -->
            <div class="af-pagination" style="margin-top: 40px; display: flex; justify-content: flex-start;">
                <?php
                echo paginate_links( [
                    'total'        => $accessories_query->max_num_pages,
                    'current'      => $paged,
                    'format'       => '?paged=%#%',
                    'prev_text'    => '&larr;',
                    'next_text'    => '&rarr;',
                    'type'         => 'list',
                ] );
                ?>
            </div>
            <?php wp_reset_postdata(); ?>

        <?php else : ?>
            
            <div style="text-align: center; padding: 80px 20px; background: #f8f9fa; border-radius: 12px;">
                <div style="font-size: 48px; margin-bottom: 16px;">🛍️</div>
                <h3 style="font-size: 24px; color: #333; margin-bottom: 12px;">Chưa có phụ kiện nào</h3>
                <p style="color: #666; max-width: 400px; margin: 0 auto;">Hiện tại danh mục phụ kiện đang trống.</p>
                <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="btn btn-primary" style="margin-top: 24px;">Trở lại Cửa hàng</a>
            </div>

        <?php endif; ?>
    </div>
</div>

<style>
.af-pagination ul {
    display: flex;
    gap: 8px;
    list-style: none;
    padding: 0;
    margin: 0;
}
.af-pagination ul li a, .af-pagination ul li span {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: #fff;
    border: 1px solid #ddd;
    color: #333;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
}
.af-pagination ul li a:hover {
    background: var(--color-primary);
    color: #fff;
    border-color: var(--color-primary);
}
.af-pagination ul li span.current {
    background: var(--color-primary);
    color: #fff;
    border-color: var(--color-primary);
}
@media (max-width: 991px) {
    .shop-container {
        flex-direction: column !important;
    }
    .shop-sidebar {
        flex: none !important;
        width: 100%;
        position: static !important;
    }
    .products-grid {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}
@media (max-width: 768px) {
    .products-grid {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}
</style>

<?php get_footer(); ?>
