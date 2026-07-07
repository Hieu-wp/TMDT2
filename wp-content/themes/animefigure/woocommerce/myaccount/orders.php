<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.5.0
 */

defined( 'ABSPATH' ) || exit;

// Lấy trạng thái từ URL để lọc, mặc định là hiển thị 'all'
$current_status = isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : 'all';

// Định nghĩa mảng trạng thái chuẩn của hệ thống
$order_statuses = array(
    'all'        => 'Tất cả',
    'pending'    => 'Chờ thanh toán',
    'processing' => 'Đang xử lý',
    'completed'  => 'Đã hoàn thành',
    'cancelled'  => 'Đã hủy',
);

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<div class="af-order-tabs">
    <?php foreach ( $order_statuses as $status_key => $status_name ) : 
        $tab_url = add_query_arg( 'status', $status_key, wc_get_endpoint_url( 'orders' ) );
        $active_class = ( $current_status === $status_key ) ? 'active' : '';
        ?>
        <a href="<?php echo esc_url( $tab_url ); ?>" class="af-tab-item <?php echo $active_class; ?>">
            <?php echo esc_html( $status_name ); ?>
        </a>
    <?php endforeach; ?>
</div>

<?php 
if ( $has_orders ) : 
    
    // Khởi tạo danh sách đơn hàng hiển thị
    $displayed_orders = array();

    // Duyệt qua danh sách đơn hàng gốc của khách để lọc theo Tab
    foreach ( $customer_orders->orders as $customer_order ) {
        $order = wc_get_order( $customer_order );
        if ( ! $order ) continue;

        if ( $current_status === 'all' || 'wc-' . $current_status === $order->get_status() ) {
            $displayed_orders[] = $order;
        }
    }

    // Nếu sau khi lọc có đơn hàng thỏa mãn điều kiện
    if ( ! empty( $displayed_orders ) ) : ?>

        <div class="af-orders-list">
            <?php foreach ( $displayed_orders as $order ) : 
                $order_id = $order->get_id();
                $status_slug = $order->get_status();
                $status_nicename = wc_get_order_status_name( $status_slug );
                $item_count = $order->get_item_count() - $order->get_item_count_refunded();
                ?>
                <div class="af-order-card status-<?php echo esc_attr( $status_slug ); ?>">
                    
                    <div class="af-card-header">
                        <div class="af-header-left">
                            <span class="af-order-number">Mã đơn hàng: #<?php echo $order->get_order_number(); ?></span>
                            <span class="af-order-date">
                                <time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>">
                                    <?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?>
                                </time>
                            </span>
                        </div>
                        <span class="af-order-status af-status-<?php echo esc_attr( $status_slug ); ?>">
                            <?php echo esc_html( $status_nicename ); ?>
                        </span>
                    </div>

                    <div class="af-card-body">
                        <?php foreach ( $order->get_items() as $item_id => $item ) : 
                            $product = $item->get_product();
                            if ( $product ) : ?>
                                <div class="af-product-item">
                                    <div class="af-prod-thumb">
                                        <?php echo $product->get_image( array( 80, 80 ) ); ?>
                                    </div>
                                    <div class="af-prod-info">
                                        <h5 class="af-prod-name"><?php echo esc_html( $item->get_name() ); ?></h5>
                                        <span class="af-prod-qty">Số lượng: x<?php echo esc_html( $item->get_quantity() ); ?></span>
                                    </div>
                                    <div class="af-prod-price">
                                        <?php echo $order->get_formatted_line_subtotal( $item ); ?>
                                    </div>
                                </div>
                            <?php endif; 
                        endforeach; ?>
                    </div>

                    <div class="af-card-footer">
                        <div class="af-total-wrapper">
                            <span class="af-total-label">Tổng số tiền (<?php echo esc_html( $item_count ); ?> sản phẩm):</span>
                            <span class="af-total-amount"><?php echo $order->get_formatted_order_total(); ?></span>
                        </div>
                        <div class="af-order-actions">
                            <?php
                            $actions = wc_get_account_orders_actions( $order );
                            if ( ! empty( $actions ) ) {
                                foreach ( $actions as $key => $action ) {
                                    $action_aria_label = ! empty( $action['aria-label'] ) ? $action['aria-label'] : sprintf( __( '%1$s đơn hàng số %2$s', 'woocommerce' ), $action['name'], $order->get_order_number() );
                                    
                                    // Tạo class nút riêng cho từng loại hành động
                                    $button_custom_class = ( 'view' === $key ) ? 'af-btn-view' : 'af-btn-secondary';
                                    
                                    echo '<a href="' . esc_url( $action['url'] ) . '" class="af-action-btn ' . esc_attr( $button_custom_class ) . ' ' . sanitize_html_class( $key ) . '" aria-label="' . esc_attr( $action_aria_label ) . '">' . esc_html( $action['name'] ) . '</a>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>
        <?php if ( 1 < $customer_orders->max_num_pages ) : ?>
            <div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination af-pagination-wrapper">
                <?php if ( 1 !== $current_page ) : ?>
                    <a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Trước', 'woocommerce' ); ?></a>
                <?php endif; ?>

                <?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
                    <a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Sau', 'woocommerce' ); ?></a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    <?php else : ?>
        <div class="woocommerce-message woocommerce-message--info af-empty-message">
            Không tìm thấy đơn hàng nào thuộc trạng thái này.
        </div>
    <?php endif; ?>

<?php else : ?>
    <div class="woocommerce-message woocommerce-message--info af-empty-message">
        <?php esc_html_e( 'Bạn chưa thực hiện đơn hàng nào.', 'woocommerce' ); ?>
        <a class="woocommerce-Button button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
            <?php esc_html_e( 'Tiếp tục mua sắm', 'woocommerce' ); ?>
        </a>
    </div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>


<style type="text/css">
.af-order-tabs {
    display: flex;
    background: #fff;
    border-bottom: 2px solid #f8f8f8;
    margin-bottom: 25px;
    border-radius: 6px;
    overflow-x: auto;
    box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}
.af-order-tabs .af-tab-item {
    flex: 1;
    text-align: center;
    padding: 15px 10px;
    font-weight: 600;
    font-size: 14px;
    color: #555;
    text-decoration: none !important;
    transition: all 0.25s ease;
    border-bottom: 3px solid transparent;
    white-space: nowrap;
}
.af-order-tabs .af-tab-item.active, 
.af-order-tabs .af-tab-item:hover {
    color: #fca5a5 !important; 
    border-bottom-color: #fca5a5;
}
.af-order-card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    margin-bottom: 22px;
    border: 1px solid #f0f0f0;
    overflow: hidden;
}
.af-order-card .af-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 20px;
    border-bottom: 1px solid #f6f6f6;
    background-color: #fafafa;
}
.af-header-left {
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.af-order-card .af-order-number {
    font-weight: 700;
    color: #2e3238;
}
.af-order-card .af-order-date {
    font-size: 12px;
    color: #999;
}
.af-order-card .af-order-status {
    font-weight: 600;
    font-size: 13px;
    padding: 5px 12px;
    border-radius: 20px;
}
.af-order-status.af-status-pending { background: #ffebeb; color: #ff4d4d; }
.af-order-status.af-status-processing { background: #e6f7ff; color: #1890ff; }
.af-order-status.af-status-completed { background: #f6ffed; color: #52c41a; }
.af-order-status.af-status-cancelled { background: #f5f5f5; color: #8c8c8c; }

.af-order-card .af-card-body {
    padding: 0 20px;
}
.af-product-item {
    display: flex;
    align-items: center;
    padding: 16px 0;
    border-bottom: 1px dashed #eee;
}
.af-product-item:last-child {
    border-bottom: none;
}
.af-product-item .af-prod-thumb img {
    width: 75px;
    height: 75px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #f0f0f0;
}
.af-product-item .af-prod-info {
    flex: 1;
    padding-left: 18px;
}
.af-product-item .af-prod-name {
    font-size: 14.5px;
    margin: 0 0 6px 0;
    color: #2e3238;
    font-weight: 600;
    line-height: 1.4;
}
.af-product-item .af-prod-qty {
    font-size: 12px;
    color: #888;
}
.af-product-item .af-prod-price {
    font-weight: 600;
    color: #2e3238;
}
.af-order-card .af-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    background: #fff;
    border-top: 1px solid #f6f6f6;
}
.af-total-wrapper .af-total-label {
    font-size: 13px;
    color: #666;
    margin-right: 6px;
}
.af-total-wrapper .af-total-amount {
    font-size: 19px;
    font-weight: 700;
    color: #ff4d4d;
}
.af-order-actions {
    display: flex;
    gap: 8px;
}
.af-action-btn {
    display: inline-block;
    padding: 9px 18px;
    font-size: 13px;
    font-weight: 600;
    border-radius: 4px;
    text-decoration: none !important;
    transition: all 0.2s ease;
    text-align: center;
}
.af-btn-view {
    background: #2e3238;
    color: #fff !important;
}
.af-btn-view:hover {
    background: #fca5a5;
}
.af-btn-secondary {
    background: #f5f5f5;
    color: #555 !important;
    border: 1px solid #e0e0e0;
}
.af-btn-secondary:hover {
    background: #2e3238;
    color: #fff !important;
}
.af-empty-message {
    padding: 30px !important;
    text-align: center;
    background: #fff !important;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
}
.af-pagination-wrapper {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 25px;
}

@media (max-width: 768px) {
    .af-order-card .af-card-footer {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    .af-order-actions {
        width: 100%;
    }
    .af-action-btn {
        flex: 1;
    }
}
</style>