<?php
/**
 * AnimeFigure Store — woocommerce/checkout/thankyou.php
 *
 * Override mặc định của WooCommerce: templates/checkout/thankyou.php
 * Hiển thị trang xác nhận đặt hàng với Timeline trạng thái ban đầu.
 *
 * @package WooCommerce\Templates
 */

defined( 'ABSPATH' ) || exit;

/** @var WC_Order|false $order */
?>

<div class="af-thankyou">

    <?php if ( ! $order ) : ?>
        <div class="af-thankyou__error">
            <div class="af-icon">❌</div>
            <h2>Đơn hàng không tìm thấy</h2>
            <p>Đã có lỗi xảy ra, vui lòng liên hệ shop để được hỗ trợ.</p>
            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="af-btn">
                Quay lại cửa hàng
            </a>
        </div>

    <?php elseif ( $order->has_status( 'failed' ) ) : ?>

        <div class="af-thankyou__failed">
            <div class="af-icon">⚠️</div>
            <h2>Thanh toán thất bại</h2>
            <p>Rất tiếc, đơn hàng #<?php echo esc_html( $order->get_order_number() ); ?> của bạn chưa được xử lý.</p>
            <div class="af-thankyou__actions">
                <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="af-btn af-btn--primary">
                    Thử lại thanh toán
                </a>
                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="af-btn">
                    Quay lại cửa hàng
                </a>
            </div>
        </div>

    <?php elseif ( $order->needs_payment() ) : ?>

        <div class="af-thankyou__hero af-thankyou__hero--pending">
            <div class="af-thankyou__hero-icon">💳</div>
            <h1 class="af-thankyou__title">Chờ thanh toán</h1>
            <p class="af-thankyou__subtitle">
                Đơn hàng của bạn đã được ghi nhận. Vui lòng hoàn tất thanh toán để hệ thống xử lý đơn.
            </p>
            <div class="af-thankyou__order-badge">
                Đơn hàng: <strong>#<?php echo esc_html( $order->get_order_number() ); ?></strong>
            </div>
        </div>

        <div class="af-thankyou__grid">

            <div class="af-thankyou__info-card">
                <h3 class="af-card-title">📋 Thông tin đơn hàng</h3>
                <table class="af-info-table">
                    <tr>
                        <td>Ngày đặt hàng</td>
                        <td><strong><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></strong></td>
                    </tr>
                    <tr>
                        <td>Trạng thái</td>
                        <td>
                            <span class="af-status-badge af-status-badge--<?php echo esc_attr( $order->get_status() ); ?>">
                                <?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Tổng tiền</td>
                        <td><strong class="af-total-amount"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></strong></td>
                    </tr>
                    <tr>
                        <td>Phương thức thanh toán</td>
                        <td><strong><?php echo esc_html( $order->get_payment_method_title() ); ?></strong></td>
                    </tr>
                </table>
            </div>

            <div class="af-thankyou__info-card">
                <h3 class="af-card-title">📍 Địa chỉ nhận hàng</h3>
                <address class="af-address">
                    <?php echo wp_kses_post( $order->get_formatted_shipping_address() ?: $order->get_formatted_billing_address() ); ?>
                </address>
                <?php if ( $order->get_billing_phone() ) : ?>
                    <p class="af-phone">📞 <?php echo esc_html( $order->get_billing_phone() ); ?></p>
                <?php endif; ?>
                <?php if ( $order->get_billing_email() ) : ?>
                    <p class="af-email">✉️ <?php echo esc_html( $order->get_billing_email() ); ?></p>
                <?php endif; ?>
            </div>

        </div>

        <div class="af-thankyou__products">
            <h3 class="af-card-title">🛍️ Sản phẩm đã đặt</h3>
            <table class="af-order-items">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $order->get_items() as $item_id => $item ) :
                        $product = $item->get_product();
                    ?>
                    <tr>
                        <td class="af-product-name">
                            <?php if ( $product ) : ?>
                                <?php echo wp_kses_post( $product->get_image( [48, 48] ) ); ?>
                            <?php endif; ?>
                            <span><?php echo wp_kses_post( $item->get_name() ); ?></span>
                        </td>
                        <td class="af-product-qty">× <?php echo esc_html( $item->get_quantity() ); ?></td>
                        <td><?php echo wp_kses_post( wc_price( $item->get_subtotal() / $item->get_quantity() ) ); ?></td>
                        <td><strong><?php echo wp_kses_post( wc_price( $item->get_total() ) ); ?></strong></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <?php foreach ( $order->get_order_item_totals() as $key => $total ) : ?>
                    <tr>
                        <th colspan="3"><?php echo esc_html( $total['label'] ); ?></th>
                        <td><?php echo wp_kses_post( $total['value'] ); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tfoot>
            </table>
        </div>

        <div class="af-thankyou__payment-box">
            <div class="af-thankyou__payment-head">
                <span class="af-thankyou__payment-badge">Chờ thanh toán</span>
                <strong><?php echo esc_html( $order->get_payment_method_title() ); ?></strong>
            </div>
            <div class="af-thankyou__payment-actions">
                <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="af-btn af-btn--primary">Thanh toán</a>
            </div>
            <div class="af-thankyou__bacs-notice">
                <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
            </div>
        </div>

    <?php else : ?>

        <?php if ( 'bacs' === $order->get_payment_method() ) : ?>
            
            <!-- Custom Sacombank QR Payment layout -->
            <div class="af-qr-payment-layout">
                
                <!-- 1. Account Box -->
                <div class="af-box af-account-box">
                    <h4 class="af-box-title">Tài khoản</h4>
                    <div class="af-account-content">
                        <div class="af-avatar"><?php 
                            $name = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
                            $initials = '';
                            $words = explode(' ', $name);
                            foreach ($words as $word) {
                                $initials .= strtoupper(substr($word, 0, 1));
                            }
                            echo esc_html(substr($initials, 0, 2) ?: 'KH');
                        ?></div>
                        <div class="af-account-details">
                            <div class="af-account-name"><?php echo esc_html($name); ?></div>
                            <div class="af-account-contact"><?php echo esc_html($order->get_billing_email() . ' | ' . $order->get_billing_phone()); ?></div>
                        </div>
                    </div>
                </div>

                <!-- 2. Status Card (Chờ thanh toán) -->
                <div class="af-box af-status-box">
                    <div class="af-status-header">
                        <div class="af-status-badge">
                            <span class="status-dot"></span>
                            Chờ thanh toán
                        </div>
                        <div class="af-order-number-wrap">
                            Đơn hàng #<?php echo esc_html($order->get_order_number()); ?>
                            <button type="button" class="copy-btn" data-copy="<?php echo esc_attr($order->get_order_number()); ?>" title="Copy mã đơn hàng">
                                <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                            </button>
                        </div>
                    </div>
                    <div class="af-status-timeline">
                        <div class="af-timeline-item">
                            <span class="timeline-icon pink-tick">✓</span>
                            <div class="timeline-details">
                                <div class="timeline-title">Đặt hàng thành công</div>
                                <div class="timeline-time">vài giây trước</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Main Payment details Box -->
                <div class="af-box af-payment-details-box">
                    <div class="payment-badge-row">
                        <span class="payment-badge">🪙 Chờ thanh toán</span>
                    </div>
                    
                    <div class="payment-totals-row">
                        <div class="totals-item">
                            <span class="label">Tổng đơn</span>
                            <span class="value"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></span>
                        </div>
                        <div class="totals-item payment-due">
                            <span class="label">Cần thanh toán</span>
                            <span class="value"><?php echo wp_kses_post($order->get_formatted_order_total()); ?></span>
                        </div>
                    </div>

                    <div class="payment-method-row">
                        <span class="label">Phương thức</span>
                        <span class="value"><?php echo esc_html($order->get_payment_method_title()); ?></span>
                    </div>

                    <div class="payment-action-row">
                        <button type="button" class="pay-trigger-btn">Thanh toán</button>
                    </div>

                    <!-- Transfer info and QR block -->
                    <div class="transfer-info-block">
                        <div class="transfer-left">
                            <div class="transfer-section-title">Nội dung chuyển khoản</div>
                            
                            <div class="transfer-detail-row">
                                <span class="label">Tài khoản</span>
                                <span class="value-wrap">
                                    <span class="value">HO KINH DOANH JH FIGURE</span>
                                </span>
                            </div>
                            
                            <div class="transfer-detail-row">
                                <span class="label">Ngân hàng</span>
                                <span class="value-wrap">
                                    <span class="value">SACOMBANK</span>
                                </span>
                            </div>
                            
                            <div class="transfer-detail-row">
                                <span class="label">Số tài khoản</span>
                                <span class="value-wrap">
                                    <span class="value font-mono">060343269652</span>
                                    <button type="button" class="copy-btn" data-copy="060343269652" title="Copy số tài khoản">
                                        <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                    </button>
                                </span>
                            </div>
                            
                            <div class="transfer-detail-row">
                                <span class="label">Nội dung</span>
                                <span class="value-wrap">
                                    <?php $memo_text = 'DH.' . $order->get_order_number() . '.H06'; ?>
                                    <span class="value font-mono"><?php echo esc_html($memo_text); ?></span>
                                    <button type="button" class="copy-btn" data-copy="<?php echo esc_attr($memo_text); ?>" title="Copy nội dung">
                                        <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                    </button>
                                </span>
                            </div>
                            
                            <div class="transfer-detail-row">
                                <span class="label">Số tiền</span>
                                <span class="value-wrap">
                                    <span class="value font-mono"><?php echo number_format($order->get_total(), 0, ',', '.') . 'đ'; ?></span>
                                    <button type="button" class="copy-btn" data-copy="<?php echo esc_attr($order->get_total()); ?>" title="Copy số tiền">
                                        <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                    </button>
                                </span>
                            </div>
                        </div>
                        
                        <div class="transfer-right">
                            <?php 
                            $qr_url = sprintf(
                                'https://img.vietqr.io/image/sacombank-060343269652-print.png?amount=%d&addInfo=%s&accountName=HO%%20KINH%%20DOANH%%20JH%%20FIGURE',
                                $order->get_total(),
                                urlencode($memo_text)
                            );
                            ?>
                            <img class="vietqr-image" src="<?php echo esc_url($qr_url); ?>" alt="Sacombank QR Code" />
                            <div class="vietqr-branding">
                                <span class="brand-haravan">haravan</span>
                                <span class="brand-napas">napas <span class="napas-color">247</span></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- File receipt upload -->
                    <div class="receipt-upload-section">
                        <div class="section-title">Hình ảnh chuyển khoản</div>
                        <p class="section-desc">Tải lên ảnh chụp màn hình chuyển khoản để cửa hàng dễ dàng xác minh giao dịch bạn nhé</p>
                        <div class="upload-trigger-wrap">
                            <input type="file" id="af-receipt-file-input" style="display: none;" accept="image/*" />
                            <button type="button" class="upload-btn" onclick="document.getElementById('af-receipt-file-input').click();">
                                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" style="vertical-align: middle; margin-right: 6px;"><path d="M21 15v4a2 2 0 0 1-2-2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                Tải lên
                            </button>
                            <span class="uploaded-filename-feedback" style="margin-left: 10px; font-size: 13px; color: var(--color-text-muted);"></span>
                        </div>
                    </div>
                </div>

                <!-- 4. Combined Shipping, Recipient, and Invoice Box -->
                <div class="af-box af-combined-shipping-recipient-box">
                    <div class="shipping-status-header">
                        <span class="shipping-status-badge">
                            <span class="status-badge-icon">🚚</span>
                            Đang chuẩn bị hàng
                        </span>
                        <span class="shipping-status-desc">Ship thường, miễn phí cho đơn hàng trên 400K</span>
                    </div>
                    
                    <div class="card-divider"></div>
                    
                    <h4 class="af-box-title-inline">Địa chỉ nhận hàng</h4>
                    <div class="recipient-details">
                        <div class="recipient-name-phone">
                            <strong><?php echo esc_html($order->get_shipping_first_name() . ' ' . $order->get_shipping_last_name() ?: $order->get_billing_first_name() . ' ' . $order->get_billing_last_name()); ?></strong>
                            <span class="divider">|</span>
                            <span><?php echo esc_html($order->get_billing_phone()); ?></span>
                        </div>
                        <div class="recipient-email"><?php echo esc_html($order->get_billing_email()); ?></div>
                        <div class="recipient-address">
                            <?php 
                            $address = $order->get_shipping_address_1() . ', ' . $order->get_shipping_city() . ', ' . $order->get_shipping_state();
                            if (!$order->get_shipping_address_1()) {
                                $address = $order->get_billing_address_1() . ', ' . $order->get_billing_city() . ', ' . $order->get_billing_state();
                            }
                            echo esc_html($address); 
                            ?>
                        </div>
                    </div>
                    
                    <div class="card-divider"></div>
                    
                    <div class="einvoice-row">
                        <span class="title">Hoá đơn điện tử</span>
                        <a href="#" class="request-link" onclick="alert('Yêu cầu xuất hoá đơn của bạn đã được gửi!'); return false;">Yêu cầu xuất &gt;</a>
                    </div>
                </div>
                
            </div>

            <!-- Inline BACS Payment JS interactions -->
            <script>
            jQuery(document).ready(function($) {
                // Copy button handler
                $(document).on('click', '.copy-btn', function(e) {
                    e.preventDefault();
                    var $btn = $(this);
                    var text = $btn.attr('data-copy');
                    
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(text).then(function() {
                            showFeedback($btn);
                        });
                    } else {
                        // Fallback copy logic
                        var $temp = $('<input>');
                        $('body').append($temp);
                        $temp.val(text).select();
                        document.execCommand('copy');
                        $temp.remove();
                        showFeedback($btn);
                    }
                });
                
                function showFeedback($btn) {
                    var originalHTML = $btn.html();
                    $btn.html('<span style="font-size: 11px; font-weight: bold; color: var(--color-primary);">Đã sao chép</span>');
                    setTimeout(function() {
                        $btn.html(originalHTML);
                    }, 1500);
                }

                // File upload feedback
                $('#af-receipt-file-input').on('change', function() {
                    var filename = $(this).val().split('\\').pop();
                    if (filename) {
                        $('.uploaded-filename-feedback').text('Đã chọn: ' + filename + ' (Đang gửi xác minh...)');
                    }
                });

                // Order status polling logic
                var orderId = <?php echo intval( $order->get_id() ); ?>;
                var currentStatus = "<?php echo esc_js( $order->get_status() ); ?>";
                var pollInterval = setInterval(function() {
                    $.ajax({
                        url: "<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>",
                        type: "GET",
                        data: {
                            action: "af_get_order_status",
                            order_id: orderId
                        },
                        success: function(response) {
                            if (response.success && response.data) {
                                var newStatus = response.data.status;
                                var statusName = response.data.status_name;
                                
                                if (newStatus !== currentStatus) {
                                    currentStatus = newStatus;
                                    
                                    // Update the status badge in status box
                                    $('.af-status-badge').text(statusName);
                                    
                                    // Update the status timeline item or add notification
                                    showStatusNotification(statusName, newStatus);
                                }
                            }
                        }
                    });
                }, 4000); // Check every 4 seconds

                function showStatusNotification(statusName, statusCode) {
                    var message = "Trạng thái đơn hàng đã được cập nhật thành: <strong>" + statusName + "</strong>";
                    var isSuccess = (statusCode === 'processing' || statusCode === 'completed');
                    
                    var icon = isSuccess ? "🎉" : "ℹ️";
                    if (statusCode === 'cancelled' || statusCode === 'failed') {
                        icon = "⚠️";
                    }
                    
                    var html = '<div class="af-floating-toast" style="' +
                        'position: fixed; bottom: 24px; right: 24px; z-index: 9999; ' +
                        'background: #ffffff; border-left: 4px solid ' + (isSuccess ? '#10B981' : '#3B82F6') + '; ' +
                        'box-shadow: 0 10px 25px rgba(0,0,0,0.15); border-radius: 12px; ' +
                        'padding: 16px 20px; display: flex; align-items: center; gap: 12px; ' +
                        'font-family: var(--font-primary); animation: afSlideIn 0.3s ease-out;">' +
                        '<span style="font-size: 20px;">' + icon + '</span>' +
                        '<div style="font-size: 14px; color: var(--color-text);">' + message + '</div>' +
                        '</div>';
                    
                    var $toast = $(html).appendTo('body');
                    
                    if (isSuccess) {
                        $('.af-status-badge').css({
                            'background': '#F0FDF4',
                            'border-color': '#BBF7D0',
                            'color': '#166534'
                        }).html('<span class="status-dot" style="background: #22C55E;"></span>' + statusName);
                        
                        // Hide QR and instructions since payment is received!
                        $('.transfer-info-block, .receipt-upload-section, .pay-trigger-btn, .payment-badge-row').slideUp(500);
                        
                        // Update payment details box badge to green paid badge
                        $('.af-payment-details-box').prepend(
                            '<div class="payment-badge-row" id="paid-badge-row">' +
                            '<span class="payment-badge" style="background: #F0FDF4; border-color: #BBF7D0; color: #166534;">🎉 Đã thanh toán</span>' +
                            '</div>'
                        );
                    } else if (statusCode === 'cancelled' || statusCode === 'failed') {
                        $('.af-status-badge').css({
                            'background': '#FEF2F2',
                            'border-color': '#FCA5A5',
                            'color': '#991B1B'
                        }).html('<span class="status-dot" style="background: #EF4444;"></span>' + statusName);
                        
                        $('.transfer-info-block, .receipt-upload-section, .pay-trigger-btn').slideUp(500);
                    }
                    
                    setTimeout(function() {
                        $toast.fadeOut(500, function() {
                            $(this).remove();
                        });
                    }, 5000);
                }
            });
            </script>

        <?php else : ?>

            <?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

            <!-- Hero Banner -->
            <div class="af-thankyou__hero">
                <div class="af-thankyou__hero-icon">🎉</div>
                <h1 class="af-thankyou__title">Đặt hàng thành công!</h1>
                <p class="af-thankyou__subtitle">
                    <?php echo wp_kses_post( apply_filters( 'woocommerce_thankyou_order_received_text',
                        'Cảm ơn bạn. Đơn hàng của bạn đã được đặt thành công và đang chờ xử lý.',
                        $order
                    ) ); ?>
                </p>
                <div class="af-thankyou__order-badge">
                    Mã đơn hàng: <strong>#<?php echo esc_html( $order->get_order_number() ); ?></strong>
                </div>
            </div>

            <!-- Order Summary Grid -->
            <div class="af-thankyou__grid">

                <!-- Cột trái: Thông tin đơn hàng -->
                <div class="af-thankyou__info-card">
                    <h3 class="af-card-title">📋 Thông tin đơn hàng</h3>
                    <table class="af-info-table">
                        <tr>
                            <td>Ngày đặt hàng</td>
                            <td><strong><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></strong></td>
                        </tr>
                        <tr>
                            <td>Trạng thái</td>
                            <td>
                                <span class="af-status-badge af-status-badge--<?php echo esc_attr( $order->get_status() ); ?>">
                                    <?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Tổng tiền</td>
                            <td><strong class="af-total-amount"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></strong></td>
                        </tr>
                        <tr>
                            <td>Phương thức thanh toán</td>
                            <td><strong><?php echo esc_html( $order->get_payment_method_title() ); ?></strong></td>
                        </tr>
                        <?php if ( $order->get_shipping_method() ) : ?>
                        <tr>
                            <td>Phương thức giao hàng</td>
                            <td><strong><?php echo esc_html( $order->get_shipping_method() ); ?></strong></td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>

                <!-- Cột phải: Địa chỉ giao hàng -->
                <div class="af-thankyou__info-card">
                    <h3 class="af-card-title">📍 Địa chỉ giao hàng</h3>
                    <address class="af-address">
                        <?php echo wp_kses_post( $order->get_formatted_shipping_address() ?: $order->get_formatted_billing_address() ); ?>
                    </address>
                    <?php if ( $order->get_billing_phone() ) : ?>
                        <p class="af-phone">📞 <?php echo esc_html( $order->get_billing_phone() ); ?></p>
                    <?php endif; ?>
                    <?php if ( $order->get_billing_email() ) : ?>
                        <p class="af-email">✉️ <?php echo esc_html( $order->get_billing_email() ); ?></p>
                    <?php endif; ?>
                </div>

            </div>

            <!-- Sản phẩm đã đặt -->
            <div class="af-thankyou__products">
                <h3 class="af-card-title">🛍️ Sản phẩm đã đặt</h3>
                <table class="af-order-items">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $order->get_items() as $item_id => $item ) :
                            $product = $item->get_product();
                        ?>
                        <tr>
                            <td class="af-product-name">
                                <?php if ( $product ) : ?>
                                    <?php echo wp_kses_post( $product->get_image( [48, 48] ) ); ?>
                                <?php endif; ?>
                                <span><?php echo wp_kses_post( $item->get_name() ); ?></span>
                            </td>
                            <td class="af-product-qty">× <?php echo esc_html( $item->get_quantity() ); ?></td>
                            <td><?php echo wp_kses_post( wc_price( $item->get_subtotal() / $item->get_quantity() ) ); ?></td>
                            <td><strong><?php echo wp_kses_post( wc_price( $item->get_total() ) ); ?></strong></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <?php foreach ( $order->get_order_item_totals() as $key => $total ) : ?>
                        <tr>
                            <th colspan="3"><?php echo esc_html( $total['label'] ); ?></th>
                            <td><?php echo wp_kses_post( $total['value'] ); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tfoot>
                </table>
            </div>

            <!-- Timeline trạng thái ban đầu -->
            <div class="af-thankyou__timeline-wrap">
                <h3 class="af-card-title">📦 Trạng thái đơn hàng</h3>
                <?php
                $steps = [
                    'created'   => [ 'icon' => '📝', 'label' => 'Đặt hàng',    'desc' => 'Đơn hàng đã được tiếp nhận' ],
                    'confirmed' => [ 'icon' => '✅', 'label' => 'Xác nhận',     'desc' => 'Shop đã xác nhận đơn hàng' ],
                    'shipping'  => [ 'icon' => '🚚', 'label' => 'Đang giao',    'desc' => 'Đơn hàng đang trên đường giao' ],
                    'completed' => [ 'icon' => '🎉', 'label' => 'Hoàn thành',   'desc' => 'Bạn đã nhận được hàng' ],
                ];

                $order_status = $order->get_status();
                $status_order = array_keys( $steps );
                $current_idx  = 0; // Mới đặt → step 0 (created) đang active

                echo '<div class="af-timeline af-timeline--horizontal">';
                foreach ( $steps as $step_key => $step ) {
                    $idx      = array_search( $step_key, $status_order );
                    $is_done  = ( $idx < $current_idx );
                    $is_active = ( $idx === $current_idx );
                    $class    = $is_done ? 'done' : ( $is_active ? 'active' : 'pending' );
                    echo '<div class="af-timeline-step af-timeline-step--' . esc_attr( $class ) . '">';
                    echo '  <div class="af-timeline-step__icon">' . esc_html( $step['icon'] ) . '</div>';
                    echo '  <div class="af-timeline-step__label">' . esc_html( $step['label'] ) . '</div>';
                    echo '  <div class="af-timeline-step__desc">' . esc_html( $step['desc'] ) . '</div>';
                    echo '</div>';
                }
                echo '</div>';
                ?>
            </div>

            <!-- Action Buttons -->
            <div class="af-thankyou__footer">
                <?php if ( is_user_logged_in() ) : ?>
                    <a href="<?php echo esc_url( wc_get_endpoint_url( 'view-order', $order->get_id(), wc_get_page_permalink( 'myaccount' ) ) ); ?>"
                       class="af-btn af-btn--primary">
                        📋 Xem chi tiết đơn hàng
                    </a>
                <?php endif; ?>
                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="af-btn">
                    🛒 Tiếp tục mua sắm
                </a>
            </div>

            <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
            <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

        <?php endif; ?>

    <?php endif; ?>

</div><!-- .af-thankyou -->

<style>
/* =====================================================
   THANK YOU PAGE STYLES
   ===================================================== */
.af-thankyou {
    max-width: 900px;
    margin: 0 auto;
    padding: 24px 20px 60px;
    font-family: 'Outfit', sans-serif;
}

/* Hero */
.af-thankyou__hero {
    text-align: center;
    padding: 48px 24px;
    background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
    border-radius: 20px;
    color: #fff;
    margin-bottom: 32px;
}
.af-thankyou__hero--pending {
    background: linear-gradient(135deg, #fff8e6, #fff3cf);
    color: #8a5a00;
    border: 1px solid #ffd56a;
}
.af-thankyou__hero--pending .af-thankyou__title {
    color: #b45309;
    background: none;
    -webkit-text-fill-color: initial;
}
.af-thankyou__hero-icon { font-size: 64px; margin-bottom: 16px; }
.af-thankyou__title {
    font-size: 32px;
    font-weight: 800;
    margin: 0 0 12px;
    background: linear-gradient(90deg, #a78bfa, #f472b6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.af-thankyou__subtitle { font-size: 16px; opacity: 0.85; margin-bottom: 20px; }
.af-thankyou__order-badge {
    display: inline-block;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 100px;
    padding: 8px 24px;
    font-size: 15px;
}
.af-thankyou__hero--pending .af-thankyou__order-badge {
    background: rgba(255,255,255,0.55);
    border-color: rgba(255, 213, 106, 0.6);
    color: #8a5a00;
}

.af-thankyou__payment-box {
    background: #fff;
    border: 1px solid #ebedf0;
    border-radius: 18px;
    padding: 20px;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    margin-bottom: 24px;
}
.af-thankyou__payment-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 14px;
}
.af-thankyou__payment-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 10px;
    border-radius: 999px;
    background: #fef3c7;
    color: #b45309;
    font-size: 12px;
    font-weight: 800;
}
.af-thankyou__payment-actions {
    margin-bottom: 12px;
}

/* Grid */
.af-thankyou__grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 24px;
}
@media (max-width: 640px) { .af-thankyou__grid { grid-template-columns: 1fr; } }

/* Info cards */
.af-thankyou__info-card,
.af-thankyou__products,
.af-thankyou__timeline-wrap,
.af-thankyou__bacs-notice {
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
}
.af-card-title {
    font-size: 16px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0 0 16px;
    padding-bottom: 12px;
    border-bottom: 2px solid #f0f0f0;
}
.af-info-table { width: 100%; border-collapse: collapse; font-size: 14px; }
.af-info-table td { padding: 8px 4px; border-bottom: 1px solid #f9f9f9; }
.af-info-table td:first-child { color: #666; width: 50%; }
.af-address { font-style: normal; font-size: 14px; line-height: 1.7; color: #333; }
.af-phone, .af-email { font-size: 14px; color: #555; margin: 4px 0; }
.af-total-amount { color: #7c3aed; font-size: 16px; }

/* Status badge */
.af-status-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 600;
}
.af-status-badge--pending     { background: #fff3e0; color: #e65100; }
.af-status-badge--processing  { background: #e3f2fd; color: #1565c0; }
.af-status-badge--confirmed   { background: #e8f5e9; color: #2e7d32; }
.af-status-badge--shipping    { background: #e8eaf6; color: #283593; }
.af-status-badge--completed   { background: #f3e5f5; color: #6a1b9a; }
.af-status-badge--on-hold     { background: #fafafa; color: #424242; }
.af-status-badge--cancelled   { background: #ffebee; color: #b71c1c; }

/* Order items table */
.af-order-items { width: 100%; border-collapse: collapse; font-size: 14px; }
.af-order-items th {
    background: #fafafa;
    padding: 10px 12px;
    text-align: left;
    font-size: 13px;
    color: #666;
    border-bottom: 2px solid #f0f0f0;
}
.af-order-items td { padding: 12px; border-bottom: 1px solid #f5f5f5; vertical-align: middle; }
.af-order-items tfoot th,
.af-order-items tfoot td {
    padding: 10px 12px;
    font-size: 14px;
    border-top: 2px solid #f0f0f0;
    background: transparent;
}
.af-order-items tfoot tr:last-child th,
.af-order-items tfoot tr:last-child td { font-size: 16px; font-weight: 800; color: #7c3aed; }
.af-product-name { display: flex; align-items: center; gap: 10px; }
.af-product-name img { width: 48px; height: 48px; object-fit: cover; border-radius: 8px; }

/* Timeline horizontal */
.af-timeline--horizontal {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    position: relative;
    padding: 0 12px;
    margin-top: 8px;
}
.af-timeline--horizontal::before {
    content: '';
    position: absolute;
    top: 28px;
    left: 12%;
    right: 12%;
    height: 2px;
    background: #e0e0e0;
}
.af-timeline-step {
    flex: 1;
    text-align: center;
    position: relative;
    z-index: 1;
}
.af-timeline-step__icon {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin: 0 auto 8px;
    background: #f5f5f5;
    border: 3px solid #e0e0e0;
    transition: all 0.3s ease;
}
.af-timeline-step--done .af-timeline-step__icon {
    background: #e8f5e9;
    border-color: #43a047;
}
.af-timeline-step--active .af-timeline-step__icon {
    background: linear-gradient(135deg, #7c3aed, #f472b6);
    border-color: #7c3aed;
    box-shadow: 0 0 0 4px rgba(124,58,237,0.2);
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0%, 100% { box-shadow: 0 0 0 4px rgba(124,58,237,0.2); }
    50%       { box-shadow: 0 0 0 8px rgba(124,58,237,0.1); }
}
.af-timeline-step__label {
    font-size: 13px;
    font-weight: 700;
    color: #333;
    margin-bottom: 4px;
}
.af-timeline-step__desc {
    font-size: 11px;
    color: #999;
    line-height: 1.4;
}
.af-timeline-step--pending .af-timeline-step__label,
.af-timeline-step--pending .af-timeline-step__desc { color: #bbb; }

/* Buttons */
.af-thankyou__footer {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 32px;
}
.af-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    border-radius: 100px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    border: 2px solid #e0e0e0;
    color: #333;
    transition: all 0.25s ease;
    cursor: pointer;
}
.af-btn:hover { background: #f5f5f5; text-decoration: none; }
.af-btn--primary {
    background: linear-gradient(135deg, #7c3aed, #a855f7);
    border-color: transparent;
    color: #fff;
}
.af-btn--primary:hover {
    background: linear-gradient(135deg, #6d28d9, #9333ea);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 20px rgba(124,58,237,0.4);
}

/* BACS notice */
.af-thankyou__bacs-notice h3 { font-size: 16px; font-weight: 700; margin: 0 0 12px; }
.af-thankyou__failed,
.af-thankyou__error {
    text-align: center;
    padding: 60px 24px;
}
.af-icon { font-size: 64px; margin-bottom: 16px; }
</style>
