<?php
/**
 * AnimeFigure Store - inc/order-status.php
 *
 * 1. Đăng ký Custom Order Statuses (Đã xác nhận, Đang giao hàng)
 * 2. Tự động ghi Order Note lịch sử mỗi khi trạng thái thay đổi
 * 3. Hiển thị custom statuses trong WooCommerce admin
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* =========================================================
   1. ĐĂNG KÝ CUSTOM ORDER STATUSES
   ========================================================= */

/**
 * Đăng ký 2 custom statuses:
 *  - wc-confirmed  : Đã xác nhận (sau khi shop duyệt đơn)
 *  - wc-shipping   : Đang giao hàng (đã bàn giao cho đơn vị vận chuyển)
 */
add_action( 'init', 'animefigure_register_custom_order_statuses' );
function animefigure_register_custom_order_statuses() {
    register_post_status( 'wc-confirmed', [
        'label'                     => 'Đã xác nhận',
        'public'                    => true,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'exclude_from_search'       => false,
        /* translators: %s: number of orders */
        'label_count'               => _n_noop( 'Đã xác nhận <span class="count">(%s)</span>', 'Đã xác nhận <span class="count">(%s)</span>' ),
    ] );

    register_post_status( 'wc-shipping', [
        'label'                     => 'Đang giao hàng',
        'public'                    => true,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'exclude_from_search'       => false,
        'label_count'               => _n_noop( 'Đang giao hàng <span class="count">(%s)</span>', 'Đang giao hàng <span class="count">(%s)</span>' ),
    ] );
}

/**
 * Thêm custom statuses vào danh sách statuses của WooCommerce
 */
add_filter( 'wc_order_statuses', 'animefigure_add_custom_wc_order_statuses' );
function animefigure_add_custom_wc_order_statuses( $order_statuses ) {
    // Chèn đúng vị trí: confirmed sau processing, shipping sau confirmed
    $new_statuses = [];
    foreach ( $order_statuses as $key => $status ) {
        $new_statuses[ $key ] = $status;
        if ( 'wc-processing' === $key ) {
            $new_statuses['wc-confirmed'] = 'Đã xác nhận';
            $new_statuses['wc-shipping']  = 'Đang giao hàng';
        }
    }
    return $new_statuses;
}

/**
 * Cho phép bulk action và order filtering với custom status
 */
add_filter( 'woocommerce_valid_order_statuses_for_payment', 'animefigure_valid_order_statuses_for_payment' );
function animefigure_valid_order_statuses_for_payment( $statuses ) {
    $statuses[] = 'confirmed';
    $statuses[] = 'shipping';
    return $statuses;
}

// Các trạng thái được phép "complete" (mark as complete từ customer)
add_filter( 'woocommerce_valid_order_statuses_for_payment_complete', 'animefigure_valid_statuses_for_complete' );
function animefigure_valid_statuses_for_complete( $statuses ) {
    $statuses[] = 'confirmed';
    $statuses[] = 'shipping';
    return $statuses;
}

/* =========================================================
   2. TỰ ĐỘNG GHI ORDER NOTE KHI TRẠNG THÁI THAY ĐỔI
   ========================================================= */

/**
 * Bản đồ nhãn tiếng Việt cho tất cả các trạng thái (kể cả custom)
 */
function animefigure_get_status_label( $status ) {
    $map = [
        'pending'        => 'Chờ thanh toán',
        'processing'     => 'Đang xử lý',
        'confirmed'      => 'Đã xác nhận',
        'shipping'       => 'Đang giao hàng',
        'on-hold'        => 'Tạm giữ',
        'completed'      => 'Đã hoàn thành',
        'cancelled'      => 'Đã hủy',
        'refunded'       => 'Đã hoàn tiền',
        'failed'         => 'Thất bại',
        'checkout-draft' => 'Nháp',
    ];
    return isset( $map[ $status ] ) ? $map[ $status ] : ucfirst( $status );
}

/**
 * Hook vào sự kiện thay đổi trạng thái đơn hàng để ghi log.
 * Tất cả các lần chuyển trạng thái đều được ghi vào Order Notes,
 * tạo thành lịch sử (tracking history) đầy đủ cho đơn hàng.
 *
 * @param int    $order_id
 * @param string $old_status  Không có tiền tố 'wc-'
 * @param string $new_status  Không có tiền tố 'wc-'
 */
add_action( 'woocommerce_order_status_changed', 'animefigure_log_order_status_change', 10, 4 );
function animefigure_log_order_status_change( $order_id, $old_status, $new_status, $order ) {
    $old_label = animefigure_get_status_label( $old_status );
    $new_label = animefigure_get_status_label( $new_status );

    // Icon tương ứng với từng trạng thái mới
    $icons = [
        'processing' => '⚙️',
        'confirmed'  => '✅',
        'shipping'   => '🚚',
        'completed'  => '🎉',
        'cancelled'  => '❌',
        'refunded'   => '↩️',
        'on-hold'    => '⏸️',
        'failed'     => '⚠️',
    ];
    $icon = isset( $icons[ $new_status ] ) ? $icons[ $new_status ] : '📋';

    $note = sprintf(
        '%s <strong>Cập nhật trạng thái:</strong> %s → <strong>%s</strong>',
        $icon,
        $old_label,
        $new_label
    );

    // Ghi note hiển thị cho cả admin & customer (is_customer_note = false → chỉ admin)
    // Để note hiện với customer trên frontend, set is_customer_note = 1
    $is_customer_note = in_array( $new_status, [ 'confirmed', 'shipping', 'completed', 'cancelled', 'refunded' ] ) ? 1 : 0;

    wc_create_order_note( $order_id, $note, $is_customer_note );
}

/**
 * Thêm note khi admin cố tình thêm note thủ công (không trùng lặp với auto note)
 * Ghi thêm người thực hiện nếu là admin
 */
add_action( 'woocommerce_new_order_note_data', 'animefigure_enrich_order_note_data', 10, 2 );
function animefigure_enrich_order_note_data( $data, $args ) {
    // Nếu người ghi note là admin, tag thêm "Admin:" phía trước
    if ( is_admin() && current_user_can( 'manage_woocommerce' ) && ! empty( $args['is_customer_note'] ) ) {
        $current_user = wp_get_current_user();
        $data['comment_content'] = '[Admin: ' . $current_user->display_name . '] ' . $data['comment_content'];
    }
    return $data;
}

/* =========================================================
   3. CUSTOM STATUS COLORS TRONG ADMIN (style inline)
   ========================================================= */

add_action( 'admin_head', 'animefigure_custom_status_admin_styles' );
function animefigure_custom_status_admin_styles() {
    $screen = get_current_screen();
    if ( ! $screen || 'shop_order' !== $screen->post_type ) return;
    ?>
    <style>
        .order-status.status-confirmed {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .order-status.status-shipping {
            background: #e3f2fd;
            color: #1565c0;
        }
    </style>
    <?php
}
