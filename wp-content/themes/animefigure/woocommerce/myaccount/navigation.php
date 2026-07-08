<?php
/**
 * My Account navigation - Shopee Style Custom Design
 * Integrated CSS for Sidebar Navigation
 *
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>

<style type="text/css">
/* Căn chỉnh bố cục chung cho vùng menu trái */
.woocommerce-MyAccount-navigation {
    width: 100% !important;
    max-width: 240px !important;
    background: #ffffff !important;
    padding: 10px 0 !important;
    box-sizing: border-box !important;
    float: left !important;
}

/* Xóa bỏ mọi chấm tròn/định dạng danh sách mặc định của Theme */
.woocommerce-MyAccount-navigation ul {
    list-style: none !important;
    margin: 0 !important;
    padding: 0 !important;
    display: flex !important;
    flex-direction: column !important;
    gap: 4px !important;
}

/* Định dạng cho từng mục dòng menu */
.woocommerce-MyAccount-navigation ul li {
    margin: 0 !important;
    padding: 0 !important;
    list-style: none !important;
    background: none !important;
}

/* Định dạng thẻ liên kết (Nút bấm menu) */
.woocommerce-MyAccount-navigation ul li a {
    display: block !important;
    padding: 12px 18px !important;
    color: #333333 !important;
    font-size: 14px !important;
    font-weight: 500 !important;
    text-decoration: none !important;
    border-radius: 6px !important;
    transition: all 0.2s ease-in-out !important;
    border-left: 3px solid transparent !important;
}

/* Hiệu ứng di chuột vào (Hover) */
.woocommerce-MyAccount-navigation ul li a:hover {
    color: #F28C8C !important;
    background-color: #fff0f2 !important;
    padding-left: 22px !important; /* Đẩy chữ nhẹ sang phải tạo cảm giác mượt mà */
}

/* Trạng thái khi đang ở chính trang đó (Active / Current Page) */
.woocommerce-MyAccount-navigation ul li.is-active a {
    color: #F28C8C !important;
    background-color: #fff0f2 !important;
    font-weight: 700 !important;
    border-left: 3px solid #F28C8C !important; /* Thanh màu hồng dọc bên trái làm điểm nhấn giống Shopee */
}

/* Giao diện tương thích điện thoại (Mobile Responsive) */
@media (max-width: 768px) {
    .woocommerce-MyAccount-navigation {
        max-width: 100% !important;
        float: none !important;
        margin-bottom: 25px !important;
        border-bottom: 1px solid #ECECEC !important;
        padding-bottom: 15px !important;
    }
    .woocommerce-MyAccount-navigation ul {
        flex-direction: row !important; /* Biến menu dọc thành hàng ngang trên điện thoại */
        overflow-x: auto !important; /* Cho phép vuốt ngang nếu menu quá dài */
        white-space: nowrap !important;
        padding-bottom: 5px !important;
    }
    .woocommerce-MyAccount-navigation ul li a {
        padding: 8px 14px !important;
        font-size: 13px !important;
        border-left: none !important;
        border-bottom: 2px solid transparent !important;
    }
    .woocommerce-MyAccount-navigation ul li.is-active a {
        border-bottom: 2px solid #F28C8C !important; /* Đổi thanh dọc thành thanh ngang ở dưới trên Mobile */
        background: none !important;
    }
}
</style>

<nav class="woocommerce-MyAccount-navigation" aria-label="<?php esc_html_e( 'Account pages', 'woocommerce' ); ?>">
    <ul>
        <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
            <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" <?php echo wc_is_current_account_menu_item( $endpoint ) ? 'aria-current="page"' : ''; ?>>
                    <?php echo esc_html( $label ); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>