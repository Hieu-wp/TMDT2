<?php
/**
 * AnimeFigure Store — woocommerce/myaccount/view-order.php
 *
 * Override mặc định của WooCommerce: templates/myaccount/view-order.php
 * Hiển thị chi tiết đơn hàng với:
 *  - Progress bar 4 bước
 *  - Timeline lịch sử thay đổi trạng thái (từ Order Notes)
 *  - Thông tin đơn hàng + sản phẩm
 *
 * @package WooCommerce\Templates
 */

defined( 'ABSPATH' ) || exit;

/** @var WC_Order $order */
$order   = wc_get_order( $order_id );
$status  = $order ? $order->get_status() : '';
?>

<?php if ( ! $order ) : ?>
    <div class="af-view-order__error">
        <p>Không tìm thấy đơn hàng.</p>
        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">← Quay lại tài khoản</a>
    </div>
    <?php return; ?>
<?php endif; ?>


<div class="af-view-order" id="order-<?php echo esc_attr( $order->get_id() ); ?>">

    <!-- Header -->
    <div class="af-view-order__header">
        <div class="af-view-order__meta">
            <h2 class="af-view-order__number">
                Đơn hàng #<?php echo esc_html( $order->get_order_number() ); ?>
            </h2>
            <span class="af-status-badge af-status-badge--<?php echo esc_attr( $status ); ?>">
                <?php echo esc_html( wc_get_order_status_name( $status ) ); ?>
            </span>
        </div>
        <div class="af-view-order__date">
            Đặt lúc: <?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?>
        </div>
    </div>

    <!-- Progress Steps -->
    <?php
    $steps = [
        'created'   => [ 'icon' => '📝', 'label' => 'Đặt hàng',  'statuses' => [ 'pending', 'on-hold', 'checkout-draft' ] ],
        'confirmed' => [ 'icon' => '✅', 'label' => 'Xác nhận',   'statuses' => [ 'processing', 'confirmed' ] ],
        'shipping'  => [ 'icon' => '🚚', 'label' => 'Đang giao',  'statuses' => [ 'shipping' ] ],
        'completed' => [ 'icon' => '🎉', 'label' => 'Hoàn thành', 'statuses' => [ 'completed' ] ],
    ];

    // Xác định step hiện tại dựa trên status đơn hàng
    $current_step = 0;
    if ( in_array( $status, [ 'processing', 'confirmed' ] ) ) {
        $current_step = 1;
    } elseif ( $status === 'shipping' ) {
        $current_step = 2;
    } elseif ( $status === 'completed' ) {
        $current_step = 3;
    }

    $step_keys = array_keys( $steps );
    ?>
    <div class="af-progress-wrap">
        <div class="af-progress-track">
            <div class="af-progress-fill" style="width: <?php echo esc_attr( ( $current_step / ( count( $steps ) - 1 ) ) * 100 ); ?>%"></div>
        </div>
        <div class="af-progress-steps">
        <?php foreach ( $steps as $idx => $step ) :
            $step_num  = array_search( $idx, $step_keys );
            $is_done   = $step_num < $current_step;
            $is_active = $step_num === $current_step;
            $cls       = $is_done ? 'done' : ( $is_active ? 'active' : 'pending' );
            $cancelled = in_array( $status, [ 'cancelled', 'failed', 'refunded' ] );
            if ( $cancelled ) $cls = 'pending';
        ?>
            <div class="af-progress-step af-progress-step--<?php echo esc_attr( $cls ); ?>">
                <div class="af-progress-step__bubble">
                    <?php if ( $is_done ) : ?>✓<?php else : echo esc_html( $step['icon'] ); endif; ?>
                </div>
                <span class="af-progress-step__label"><?php echo esc_html( $step['label'] ); ?></span>
            </div>
        <?php endforeach; ?>
        </div>
    </div>

    <?php if ( in_array( $status, [ 'cancelled', 'failed', 'refunded' ] ) ) : ?>
    <div class="af-view-order__alert af-view-order__alert--danger">
        <?php
        $alert_msgs = [
            'cancelled' => '❌ Đơn hàng này đã bị hủy.',
            'failed'    => '⚠️ Thanh toán thất bại. Vui lòng liên hệ shop để được hỗ trợ.',
            'refunded'  => '↩️ Đơn hàng này đã được hoàn tiền.',
        ];
        echo esc_html( $alert_msgs[ $status ] ?? 'Đơn hàng có vấn đề.' );
        ?>
    </div>
    <?php endif; ?>

    <!-- Grid thông tin + địa chỉ -->
    <div class="af-view-order__grid">

        <div class="af-view-order__card">
            <h4 class="af-view-order__card-title">📋 Chi tiết đơn hàng</h4>
            <table class="af-info-table">
                <tr>
                    <td>Trạng thái hiện tại</td>
                    <td><span class="af-status-badge af-status-badge--<?php echo esc_attr( $status ); ?>"><?php echo esc_html( wc_get_order_status_name( $status ) ); ?></span></td>
                </tr>
                <tr>
                    <td>Tổng tiền</td>
                    <td><strong class="af-total-price"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></strong></td>
                </tr>
                <tr>
                    <td>Thanh toán</td>
                    <td><?php echo esc_html( $order->get_payment_method_title() ); ?></td>
                </tr>
                <?php if ( $order->get_transaction_id() ) : ?>
                <tr>
                    <td>Mã giao dịch</td>
                    <td><code><?php echo esc_html( $order->get_transaction_id() ); ?></code></td>
                </tr>
                <?php endif; ?>
            </table>
        </div>

        <div class="af-view-order__card">
            <h4 class="af-view-order__card-title">📍 Địa chỉ nhận hàng</h4>
            <address style="font-style:normal; font-size:14px; line-height:1.8; color:#555;">
                <?php echo wp_kses_post( $order->get_formatted_shipping_address() ?: $order->get_formatted_billing_address() ); ?>
            </address>
            <?php if ( $order->get_billing_phone() ) : ?>
                <p style="font-size:14px; margin:8px 0 0;">📞 <?php echo esc_html( $order->get_billing_phone() ); ?></p>
            <?php endif; ?>
        </div>

    </div>

    <!-- Sản phẩm đã đặt -->
    <div class="af-view-order__card af-view-order__items">
        <h4 class="af-view-order__card-title">🛍️ Sản phẩm đã đặt</h4>
        <table class="af-order-items">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th class="af-center">SL</th>
                    <th class="af-right">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $order->get_items() as $item_id => $item ) :
                    $product     = $item->get_product();
                    $thumbnail   = $product ? $product->get_image( [56, 56] ) : '';
                    $product_url = $product ? get_permalink( $product->get_id() ) : '';
                ?>
                <tr>
                    <td class="af-order-item__name">
                        <?php if ( $thumbnail ) : ?>
                            <?php if ( $product_url ) : ?>
                                <a href="<?php echo esc_url( $product_url ); ?>"><?php echo wp_kses_post( $thumbnail ); ?></a>
                            <?php else : ?>
                                <?php echo wp_kses_post( $thumbnail ); ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        <div>
                            <span><?php echo wp_kses_post( $item->get_name() ); ?></span>
                            <?php
                            // Hiển thị biến thể sản phẩm (màu sắc, size...) đúng API cho order item
                            $item_data = $item->get_formatted_meta_data( '_', true );
                            if ( ! empty( $item_data ) ) {
                                echo '<ul class="af-item-meta">';
                                foreach ( $item_data as $meta ) {
                                    printf(
                                        '<li><strong>%s</strong>: %s</li>',
                                        wp_kses_post( $meta->display_key ),
                                        wp_kses_post( $meta->display_value )
                                    );
                                }
                                echo '</ul>';
                            }
                            ?>
                        </div>
                    </td>
                    <td class="af-center">× <?php echo esc_html( $item->get_quantity() ); ?></td>
                    <td class="af-right"><strong><?php echo wp_kses_post( wc_price( $item->get_total() ) ); ?></strong></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <?php foreach ( $order->get_order_item_totals() as $key => $total ) : ?>
                <tr class="<?php echo esc_attr( $key ); ?>">
                    <th colspan="2"><?php echo esc_html( $total['label'] ); ?></th>
                    <td><?php echo wp_kses_post( $total['value'] ); ?></td>
                </tr>
                <?php endforeach; ?>
            </tfoot>
        </table>
    </div>

    <!-- Timeline lịch sử đơn hàng -->
    <div class="af-view-order__card af-view-order__timeline">
        <h4 class="af-view-order__card-title">🕐 Lịch sử theo dõi đơn hàng</h4>

        <?php
        // Lấy tất cả order notes dành cho customer
        $notes = wc_get_order_notes( [
            'order_id' => $order->get_id(),
            'type'     => 'customer', // Chỉ hiện note dành cho customer
        ] );

        // Nếu không có customer note, lấy tất cả note (bao gồm system notes)
        if ( empty( $notes ) ) {
            $notes = wc_get_order_notes( [
                'order_id' => $order->get_id(),
                'type'     => 'all',
            ] );
        }

        $notes = array_reverse( $notes ); // Hiển thị cũ → mới (chronological)
        ?>

        <?php if ( ! empty( $notes ) ) : ?>
        <div class="af-timeline af-timeline--vertical">
            <?php foreach ( $notes as $note ) :
                $date_created = $note->date_created;
                $formatted_date = $date_created instanceof WC_DateTime
                    ? $date_created->date_i18n( 'd/m/Y H:i' )
                    : date_i18n( 'd/m/Y H:i', strtotime( $note->comment_date ) );

                // Xác định icon dựa trên nội dung note
                $icon = '📋';
                $content = $note->content;
                if ( strpos( $content, '📦' ) !== false || strpos( $content, 'tạo' ) !== false ) {
                    $icon = '📦';
                } elseif ( strpos( $content, '✅' ) !== false || strpos( $content, 'xác nhận' ) !== false ) {
                    $icon = '✅';
                } elseif ( strpos( $content, '🚚' ) !== false || strpos( $content, 'giao' ) !== false ) {
                    $icon = '🚚';
                } elseif ( strpos( $content, '💳' ) !== false || strpos( $content, 'thanh toán' ) !== false ) {
                    $icon = '💳';
                } elseif ( strpos( $content, '❌' ) !== false || strpos( $content, 'hủy' ) !== false ) {
                    $icon = '❌';
                } elseif ( strpos( $content, '🎉' ) !== false || strpos( $content, 'hoàn thành' ) !== false ) {
                    $icon = '🎉';
                }
            ?>
            <div class="af-timeline-item">
                <div class="af-timeline-item__dot"><?php echo $icon; ?></div>
                <div class="af-timeline-item__body">
                    <div class="af-timeline-item__content">
                        <?php echo wp_kses_post( $note->content ); ?>
                    </div>
                    <div class="af-timeline-item__time">
                        <?php echo esc_html( $formatted_date ); ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php else : ?>
        <div class="af-timeline-empty">
            <div class="af-timeline-empty__icon">📭</div>
            <p>Chưa có cập nhật nào cho đơn hàng này.</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Action buttons -->
    <div class="af-view-order__footer">
        <a href="<?php echo esc_url( wc_get_endpoint_url( 'orders', '', wc_get_page_permalink( 'myaccount' ) ) ); ?>"
           class="af-btn">
            ← Danh sách đơn hàng
        </a>

        <?php if ( $order->needs_payment() ) : ?>
        <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>"
           class="af-btn af-btn--primary">
            💳 Thanh toán ngay
        </a>
        <?php endif; ?>

        <?php if ( $order->is_editable() ) : ?>
        <a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'cancel_order', 'true', $order->get_cancel_order_url() ), 'woocommerce-cancel_order' ) ); ?>"
           class="af-btn af-btn--danger"
           onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
            ❌ Hủy đơn hàng
        </a>
        <?php endif; ?>
    </div>

</div><!-- .af-view-order -->

<style>
/* =====================================================
   VIEW ORDER PAGE STYLES
   ===================================================== */
.af-view-order {
    font-family: 'Outfit', sans-serif;
    max-width: 840px;
    margin: 0 auto;
}

/* Header */
.af-view-order__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 28px;
    padding-bottom: 20px;
    border-bottom: 2px solid #f0f0f0;
}
.af-view-order__meta { display: flex; align-items: center; gap: 12px; }
.af-view-order__number { font-size: 22px; font-weight: 800; color: #1a1a2e; margin: 0; }
.af-view-order__date { font-size: 13px; color: #999; }

/* Progress bar */
.af-progress-wrap { margin-bottom: 32px; padding: 24px 16px; background: #fafafa; border-radius: 16px; }
.af-progress-track {
    height: 4px;
    background: #e0e0e0;
    border-radius: 2px;
    margin-bottom: 16px;
    position: relative;
}
.af-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #7c3aed, #f472b6);
    border-radius: 2px;
    transition: width 0.6s ease;
}
.af-progress-steps {
    display: flex;
    justify-content: space-between;
}
.af-progress-step { text-align: center; flex: 1; }
.af-progress-step__bubble {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    margin: 0 auto 6px;
    background: #f5f5f5;
    border: 2px solid #e0e0e0;
}
.af-progress-step--done .af-progress-step__bubble {
    background: #e8f5e9;
    border-color: #43a047;
    color: #43a047;
    font-size: 20px;
    font-weight: 800;
}
.af-progress-step--active .af-progress-step__bubble {
    background: linear-gradient(135deg, #7c3aed, #f472b6);
    border-color: transparent;
    color: #fff;
    box-shadow: 0 0 0 4px rgba(124,58,237,0.2);
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0%, 100% { box-shadow: 0 0 0 4px rgba(124,58,237,0.2); }
    50%       { box-shadow: 0 0 0 8px rgba(124,58,237,0.05); }
}
.af-progress-step__label { font-size: 12px; font-weight: 600; color: #555; }
.af-progress-step--pending .af-progress-step__label { color: #ccc; }

/* Alert */
.af-view-order__alert {
    padding: 12px 16px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-size: 14px;
    font-weight: 600;
}
.af-view-order__alert--danger { background: #fff5f5; color: #c62828; border-left: 4px solid #e53935; }

/* Grid */
.af-view-order__grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 16px;
}
@media (max-width: 600px) { .af-view-order__grid { grid-template-columns: 1fr; } }

/* Cards */
.af-view-order__card {
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 14px;
    padding: 20px;
    margin-bottom: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.af-view-order__card-title {
    font-size: 15px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0 0 14px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f5f5f5;
}

/* Info table */
.af-info-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.af-info-table td { padding: 7px 4px; border-bottom: 1px solid #fafafa; }
.af-info-table td:first-child { color: #888; width: 45%; }
.af-total-price { font-size: 17px; color: #7c3aed; font-weight: 800; }

/* Status badge */
.af-status-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 600;
}
.af-status-badge--pending     { background: #fff3e0; color: #e65100; }
.af-status-badge--processing  { background: #e3f2fd; color: #1565c0; }
.af-status-badge--confirmed   { background: #e8f5e9; color: #2e7d32; }
.af-status-badge--shipping    { background: #e8eaf6; color: #283593; }
.af-status-badge--completed   { background: #f3e5f5; color: #6a1b9a; }
.af-status-badge--on-hold     { background: #f5f5f5; color: #424242; }
.af-status-badge--cancelled   { background: #ffebee; color: #b71c1c; }
.af-status-badge--refunded    { background: #e8eaf6; color: #4527a0; }
.af-status-badge--failed      { background: #ffebee; color: #b71c1c; }

/* Order items */
.af-view-order__items { margin-bottom: 16px; }
.af-order-items { width: 100%; border-collapse: collapse; font-size: 13px; }
.af-order-items th {
    background: #fafafa;
    padding: 10px 8px;
    text-align: left;
    font-size: 12px;
    color: #888;
    border-bottom: 2px solid #f0f0f0;
}
.af-order-items td { padding: 12px 8px; border-bottom: 1px solid #f7f7f7; vertical-align: middle; }
.af-order-items tfoot th,
.af-order-items tfoot td {
    padding: 9px 8px;
    font-size: 13px;
    border-top: 2px solid #f0f0f0;
    background: transparent;
    border-bottom: 1px solid #f7f7f7;
}
.af-order-items tfoot tr:last-child th,
.af-order-items tfoot tr:last-child td {
    font-size: 15px;
    font-weight: 800;
    color: #7c3aed;
    border-bottom: none;
}
.af-order-item__name { display: flex; align-items: center; gap: 10px; }
.af-order-item__name img { width: 56px; height: 56px; object-fit: cover; border-radius: 8px; flex-shrink: 0; }
.af-center { text-align: center; }
.af-right { text-align: right; }
.af-item-meta { list-style: none; margin: 4px 0 0; padding: 0; font-size: 11px; color: #888; }
.af-item-meta li { display: inline-block; margin-right: 8px; }

/* Timeline vertical */
.af-timeline--vertical { padding: 8px 0; }
.af-timeline-item {
    display: flex;
    gap: 14px;
    padding: 14px 0;
    position: relative;
    border-bottom: 1px dashed #f0f0f0;
}
.af-timeline-item:last-child { border-bottom: none; }
.af-timeline-item__dot {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: linear-gradient(135deg, #ede9fe, #fce7f3);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
    border: 2px solid #e9d5ff;
}
.af-timeline-item__body { flex: 1; }
.af-timeline-item__content {
    font-size: 13.5px;
    color: #333;
    line-height: 1.6;
    margin-bottom: 4px;
}
.af-timeline-item__time { font-size: 11px; color: #aaa; }
.af-timeline-empty { text-align: center; padding: 32px 16px; color: #ccc; }
.af-timeline-empty__icon { font-size: 40px; margin-bottom: 8px; }

/* Footer */
.af-view-order__footer {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 24px;
}
.af-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 22px;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    border: 2px solid #e0e0e0;
    color: #333;
    transition: all 0.2s ease;
    cursor: pointer;
    background: #fff;
}
.af-btn:hover { background: #f5f5f5; text-decoration: none; color: #333; }
.af-btn--primary {
    background: linear-gradient(135deg, #7c3aed, #a855f7);
    border-color: transparent;
    color: #fff;
}
.af-btn--primary:hover { background: linear-gradient(135deg, #6d28d9, #9333ea); color: #fff; transform: translateY(-1px); }
.af-btn--danger { border-color: #ffcdd2; color: #c62828; }
.af-btn--danger:hover { background: #ffebee; color: #b71c1c; }
</style>
