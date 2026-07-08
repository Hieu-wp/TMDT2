<?php
/**
 * AnimeFigure Store - inc/order-flow.php
 *
 * 1. Hooks vào checkout flow (nút đặt hàng, tạo đơn, hoàn tất thanh toán)
 * 2. Xử lý Payment Webhook / Callback từ cổng thanh toán bên thứ ba
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* =========================================================
   1. CHECKOUT FLOW HOOKS
   ========================================================= */

/**
 * Đổi text nút đặt hàng thành "Đặt hàng ngay"
 */
add_filter( 'woocommerce_order_button_text', function() {
    return 'Đặt hàng ngay';
} );

/**
 * Ghi Order Note ngay khi đơn hàng mới được tạo thành công.
 * Hook này chạy SAU khi order đã được insert vào DB,
 * cho phép ghi log thời điểm khách đặt hàng chính xác.
 *
 * @param WC_Order $order
 */
add_action( 'woocommerce_checkout_order_created', 'animefigure_on_order_created', 10, 1 );
function animefigure_on_order_created( $order ) {
    $payment_method_title = $order->get_payment_method_title();
    $note = sprintf(
        '📦 Đơn hàng được tạo lúc %s. Phương thức thanh toán: <strong>%s</strong>.',
        wp_date( 'd/m/Y H:i:s' ),
        esc_html( $payment_method_title )
    );
    // is_customer_note = 0 → chỉ admin thấy trong backend
    wc_create_order_note( $order->get_id(), $note, 0 );
}

/**
 * Xử lý khi thanh toán online hoàn tất thành công (COD không kích hoạt hook này).
 * Logic:
 *  1. Ghi customer note xác nhận thanh toán thành công
 *  2. Trừ tồn kho (wc_reduce_stock_levels)
 *  3. Chuyển trạng thái → processing
 *
 * @param int $order_id
 */
add_action( 'woocommerce_payment_complete', 'animefigure_on_payment_complete', 10, 1 );
function animefigure_on_payment_complete( $order_id ) {
    $order = wc_get_order( $order_id );
    if ( ! $order ) return;

    // 1. Ghi note xác nhận thanh toán — hiển thị cho customer
    $note = sprintf(
        '💳 Thanh toán xác nhận thành công lúc %s. Mã giao dịch: <strong>%s</strong>.',
        wp_date( 'd/m/Y H:i:s' ),
        esc_html( $order->get_transaction_id() ?: 'N/A' )
    );
    wc_create_order_note( $order_id, $note, 1 ); // customer_note = 1

    // 2. Trừ tồn kho (WooCommerce sẽ bỏ qua nếu đã trừ rồi)
    wc_reduce_stock_levels( $order_id );

    // 3. Chuyển status → processing (nếu còn ở pending)
    if ( $order->get_status() === 'pending' ) {
        $order->update_status( 'processing', 'Thanh toán online xác nhận thành công.' );
    }
}

/* =========================================================
   2. PAYMENT GATEWAY WEBHOOK / CALLBACK HANDLER
   ========================================================= */

/**
 * Đăng ký WC API endpoint cho payment callback.
 * URL: https://yoursite.com/?wc-api=animefigure_payment_callback
 *
 * Để tích hợp cổng thanh toán cụ thể (VNPAY, MoMo, ZaloPay...):
 *  - Thay thế animefigure_verify_payment_signature() với logic xác thực của từng cổng
 *  - Cấu hình URL callback trên dashboard của cổng thanh toán
 */
add_action( 'woocommerce_api_animefigure_payment_callback', 'animefigure_handle_payment_callback' );
function animefigure_handle_payment_callback() {
    // ── Bước 1: Thu thập dữ liệu từ cổng thanh toán ──────────────────────────
    // Các cổng thanh toán gửi dữ liệu qua GET hoặc POST tuỳ nhà cung cấp
    $raw_data = array_merge( $_GET, $_POST );

    // Log raw callback để debug (bỏ comment khi cần troubleshoot)
    // error_log( 'Payment Callback: ' . wp_json_encode( $raw_data ) );

    // ── Bước 2: Xác thực chữ ký (Signature Verification) ─────────────────────
    // ** QUAN TRỌNG **: Luôn phải verify signature trước, bỏ qua bước này
    // sẽ khiến hacker có thể giả mạo callback để kích hoạt đơn hàng giả.
    if ( ! animefigure_verify_payment_signature( $raw_data ) ) {
        wp_die( 'Invalid signature', 'Payment Error', [ 'response' => 400 ] );
    }

    // ── Bước 3: Lấy Order ID từ dữ liệu callback ─────────────────────────────
    // Mỗi cổng thanh toán có key khác nhau; ví dụ VNPAY dùng 'vnp_TxnRef'
    $order_id      = isset( $raw_data['order_id'] ) ? absint( $raw_data['order_id'] ) : 0;
    $txn_id        = isset( $raw_data['transaction_id'] ) ? sanitize_text_field( $raw_data['transaction_id'] ) : '';
    $payment_status = isset( $raw_data['status'] ) ? sanitize_text_field( $raw_data['status'] ) : '';

    if ( ! $order_id ) {
        wp_die( 'Invalid order ID', 'Payment Error', [ 'response' => 400 ] );
    }

    $order = wc_get_order( $order_id );
    if ( ! $order ) {
        wp_die( 'Order not found', 'Payment Error', [ 'response' => 404 ] );
    }

    // ── Bước 4: Xử lý theo kết quả thanh toán ────────────────────────────────
    if ( 'success' === strtolower( $payment_status ) ) {
        // Kiểm tra đơn chưa được xử lý (tránh duplicate callback)
        if ( ! $order->is_paid() ) {
            // Lưu transaction ID vào order meta
            $order->set_transaction_id( $txn_id );
            $order->save();

            // Ghi note cho admin
            $note = sprintf(
                '✅ Callback thanh toán thành công nhận lúc %s. Mã giao dịch: <strong>%s</strong>.',
                wp_date( 'd/m/Y H:i:s' ),
                esc_html( $txn_id )
            );
            wc_create_order_note( $order_id, $note, 0 );

            // Kích hoạt payment_complete → sẽ tự trừ tồn kho + ghi customer note
            // (xem animefigure_on_payment_complete ở trên)
            $order->payment_complete( $txn_id );
        }

        // Trả về HTTP 200 cho cổng thanh toán biết đã nhận
        status_header( 200 );
        echo 'OK';
        exit;

    } else {
        // Thanh toán thất bại
        $note = sprintf(
            '❌ Callback thanh toán thất bại nhận lúc %s. Mã giao dịch: <strong>%s</strong>.',
            wp_date( 'd/m/Y H:i:s' ),
            esc_html( $txn_id )
        );
        wc_create_order_note( $order_id, $note, 0 );
        $order->update_status( 'failed', 'Thanh toán thất bại theo callback.' );

        status_header( 200 );
        echo 'FAILED';
        exit;
    }
}

/**
 * Xác thực chữ ký từ cổng thanh toán.
 *
 * ** Đây là hàm placeholder — cần implement theo tài liệu của từng cổng. **
 *
 * Ví dụ VNPAY:
 *   $vnp_SecureHash = $raw_data['vnp_SecureHash'];
 *   // Build chuỗi ký theo VNPAY spec, so sánh với hash($secretKey + $queryString)
 *
 * Ví dụ MoMo:
 *   $signature = hash_hmac('sha256', $rawSignatureStr, $secretKey);
 *   return hash_equals($signature, $raw_data['signature']);
 *
 * @param  array $data  Dữ liệu raw từ GET/POST
 * @return bool
 */
function animefigure_verify_payment_signature( $data ) {
    // TODO: Thay thế bằng logic xác thực chữ ký thực tế của cổng thanh toán
    // Trong môi trường phát triển, tạm return true để test flow
    // KHÔNG BAO GIỜ để true trong production!

    $secret_key = defined( 'ANIMEFIGURE_PAYMENT_SECRET' ) ? ANIMEFIGURE_PAYMENT_SECRET : '';

    // Nếu chưa cấu hình secret key, từ chối tất cả (an toàn nhất)
    if ( empty( $secret_key ) ) {
        return false;
    }

    // Ví dụ generic: so sánh hmac-sha256
    $received_sig = isset( $data['signature'] ) ? $data['signature'] : '';
    $data_to_sign = $data;
    unset( $data_to_sign['signature'] );
    ksort( $data_to_sign );
    $query_string    = http_build_query( $data_to_sign );
    $expected_sig    = hash_hmac( 'sha256', $query_string, $secret_key );

    return hash_equals( $expected_sig, $received_sig );
}

/* =========================================================
   3. AUTO CHUYỂN TRẠNG THÁI CHO COD
   ========================================================= */

/**
 * COD: Sau khi đặt hàng, WC mặc định set trạng thái on-hold.
 * Override để set về "processing" ngay → admin biết cần xử lý đơn.
 *
 * Hook woocommerce_cod_process_payment_order_status chỉ áp dụng riêng cho COD,
 * không ảnh hưởng đến các phương thức thanh toán khác.
 */
add_filter( 'woocommerce_cod_process_payment_order_status', 'animefigure_cod_order_status', 10, 2 );
function animefigure_cod_order_status( $status, $order ) {
    // COD → chuyển ngay về "processing" thay vì "on-hold"
    return 'processing';
}
