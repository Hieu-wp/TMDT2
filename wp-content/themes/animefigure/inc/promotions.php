<?php
/**
 * AnimeFigure Store - inc/promotions.php
 *
 * 3 Use Case Khuyến mãi được triển khai thông qua WooCommerce hooks:
 *
 * UC1 — Coupon giảm % có giới hạn tối đa 50.000đ
 *        Ví dụ: Mã "SALE10" giảm 10% nhưng tối đa chỉ giảm 50.000đ
 *
 * UC2 — Coupon giảm cố định khi đơn hàng đạt tối thiểu 300.000đ
 *        Ví dụ: Mã "GIAM30K" giảm 30.000đ cho đơn ≥ 300.000đ
 *
 * UC3 — Miễn phí vận chuyển tự động khi giỏ hàng ≥ 500.000đ (không cần mã)
 *
 * Ngoài ra:
 *  - Thứ tự ưu tiên áp dụng: UC3 (freeship auto) → UC1/UC2 (coupon)
 *  - Không áp dụng đồng thời 2 coupon (UC1 + UC2)
 *  - Hiển thị thông báo rõ ràng về kết quả khuyến mãi trên cart/checkout
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* =========================================================
   HẰNG SỐ CẤU HÌNH
   ========================================================= */

// UC1: Giảm % có cap
define( 'AF_PROMO_UC1_COUPON_CODE', 'SALE10' );    // Mã coupon (phải tạo trong WC Admin)
define( 'AF_PROMO_UC1_PERCENT',     10 );           // Giảm 10%
define( 'AF_PROMO_UC1_MAX_AMOUNT',  50000 );        // Tối đa giảm 50.000đ

// UC2: Giảm cố định
define( 'AF_PROMO_UC2_COUPON_CODE', 'GIAM30K' );   // Mã coupon (phải tạo trong WC Admin)
define( 'AF_PROMO_UC2_AMOUNT',      30000 );        // Giảm 30.000đ
define( 'AF_PROMO_UC2_MIN_SPEND',   300000 );       // Đơn tối thiểu 300.000đ

// UC3: Freeship
define( 'AF_PROMO_UC3_MIN_SPEND',   500000 );       // Freeship khi giỏ ≥ 500.000đ

/* =========================================================
   UC1 — COUPON GIẢM % CÓ CAP 50.000đ
   ========================================================= */

/**
 * Hook vào quá trình tính discount của coupon để áp dụng giới hạn tối đa.
 * WooCommerce tính discount từng item, ta cộng lại và cap tổng ở 50k.
 *
 * Cách hoạt động:
 *  - WC native tính 10% của từng line item
 *  - Hook này nhận discount đã tính và giảm nếu vượt quá cap
 *
 * @param float      $discount      Số tiền discount đã tính cho item này
 * @param float      $discounting_amount Giá trị item đang tính
 * @param array      $cart_item     Line item trong giỏ
 * @param bool       $single        Tính cho 1 unit hay cả quantity
 * @param WC_Coupon  $coupon        Đối tượng coupon
 * @return float
 */
add_filter( 'woocommerce_coupon_get_discount_amount', 'animefigure_uc1_cap_percent_discount', 10, 5 );
function animefigure_uc1_cap_percent_discount( $discount, $discounting_amount, $cart_item, $single, $coupon ) {
    // Chỉ áp dụng cho mã UC1
    if ( strtoupper( $coupon->get_code() ) !== strtoupper( AF_PROMO_UC1_COUPON_CODE ) ) {
        return $discount;
    }

    // Tính tổng discount đã được áp dụng cho các item trước đó trong session
    $already_discounted = WC()->session->get( 'af_uc1_total_discounted', 0 );
    $remaining_cap      = AF_PROMO_UC1_MAX_AMOUNT - $already_discounted;

    if ( $remaining_cap <= 0 ) {
        return 0; // Đã đạt cap, không giảm thêm
    }

    // Cap discount của item này nếu vượt quá remaining cap
    $capped_discount = min( $discount, $remaining_cap );

    // Cập nhật session để tracking
    WC()->session->set( 'af_uc1_total_discounted', $already_discounted + $capped_discount );

    return $capped_discount;
}

/**
 * Reset session tracking UC1 mỗi khi cart được tính lại (tránh state cũ)
 */
add_action( 'woocommerce_before_calculate_totals', 'animefigure_uc1_reset_discount_session' );
function animefigure_uc1_reset_discount_session() {
    if ( WC()->session ) {
        WC()->session->set( 'af_uc1_total_discounted', 0 );
    }
}

/**
 * Thêm thông báo tiết kiệm khi áp dụng UC1 thành công
 */
add_action( 'woocommerce_applied_coupon', 'animefigure_uc1_show_savings_notice' );
function animefigure_uc1_show_savings_notice( $coupon_code ) {
    if ( strtoupper( $coupon_code ) !== strtoupper( AF_PROMO_UC1_COUPON_CODE ) ) {
        return;
    }

    $cart_total = WC()->cart->get_subtotal();
    $would_discount = $cart_total * ( AF_PROMO_UC1_PERCENT / 100 );
    $actual_discount = min( $would_discount, AF_PROMO_UC1_MAX_AMOUNT );

    if ( $would_discount > AF_PROMO_UC1_MAX_AMOUNT ) {
        wc_add_notice(
            sprintf(
                '🎉 Mã giảm giá áp dụng thành công! Bạn tiết kiệm được <strong>%s</strong> (đã đạt mức giảm tối đa %s).',
                wc_price( AF_PROMO_UC1_MAX_AMOUNT ),
                wc_price( AF_PROMO_UC1_MAX_AMOUNT )
            ),
            'success'
        );
    }
}

/* =========================================================
   UC2 — COUPON GIẢM CỐ ĐỊNH KHI ĐƠN ≥ 300.000đ
   ========================================================= */

/**
 * Kiểm tra điều kiện tối thiểu đơn hàng cho UC2 trước khi apply coupon.
 * WooCommerce native đã có minimum_amount, ta validate thêm với message tiếng Việt.
 *
 * @param bool      $valid
 * @param WC_Coupon $coupon
 * @return bool
 */
add_filter( 'woocommerce_coupon_is_valid', 'animefigure_uc2_validate_minimum_spend', 10, 2 );
function animefigure_uc2_validate_minimum_spend( $valid, $coupon ) {
    if ( strtoupper( $coupon->get_code() ) !== strtoupper( AF_PROMO_UC2_COUPON_CODE ) ) {
        return $valid;
    }

    $cart_total = WC()->cart->get_subtotal();

    if ( $cart_total < AF_PROMO_UC2_MIN_SPEND ) {
        $still_needed = AF_PROMO_UC2_MIN_SPEND - $cart_total;
        // Throw WooCommerce exception để hiện error message đúng cách
        throw new Exception(
            sprintf(
                '⚠️ Mã <strong>%s</strong> chỉ áp dụng cho đơn hàng từ %s. Thêm %s nữa để sử dụng mã này.',
                strtoupper( AF_PROMO_UC2_COUPON_CODE ),
                wc_price( AF_PROMO_UC2_MIN_SPEND ),
                wc_price( $still_needed )
            )
        );
    }

    return $valid;
}

/**
 * Không cho phép áp dụng đồng thời UC1 và UC2
 */
add_filter( 'woocommerce_coupon_is_valid', 'animefigure_prevent_combining_uc1_uc2', 20, 2 );
function animefigure_prevent_combining_uc1_uc2( $valid, $coupon ) {
    $uc1_code = strtoupper( AF_PROMO_UC1_COUPON_CODE );
    $uc2_code = strtoupper( AF_PROMO_UC2_COUPON_CODE );
    $current  = strtoupper( $coupon->get_code() );

    $applied_coupons = array_map( 'strtoupper', WC()->cart->get_applied_coupons() );

    if ( $current === $uc1_code && in_array( $uc2_code, $applied_coupons ) ) {
        throw new Exception( '❌ Không thể dùng đồng thời hai mã khuyến mãi. Vui lòng chỉ chọn một mã.' );
    }
    if ( $current === $uc2_code && in_array( $uc1_code, $applied_coupons ) ) {
        throw new Exception( '❌ Không thể dùng đồng thời hai mã khuyến mãi. Vui lòng chỉ chọn một mã.' );
    }

    return $valid;
}

/* =========================================================
   UC3 — FREESHIP TỰ ĐỘNG KHI GIỎ HÀNG ≥ 500.000đ
   ========================================================= */

/**
 * Ẩn toàn bộ phí shipping khi subtotal đạt ngưỡng UC3.
 * Hook woocommerce_package_rates cho phép modify từng shipping rate trước khi hiển thị.
 *
 * @param array $rates    Mảng các shipping rates khả dụng
 * @param array $package  Package hiện tại
 * @return array
 */
add_filter( 'woocommerce_package_rates', 'animefigure_uc3_auto_freeship', 10, 2 );
function animefigure_uc3_auto_freeship( $rates, $package ) {
    if ( ! WC()->cart ) return $rates;

    $cart_subtotal = WC()->cart->get_subtotal();

    if ( $cart_subtotal >= AF_PROMO_UC3_MIN_SPEND ) {
        // Set cost = 0 cho tất cả shipping methods (free ship tự động)
        foreach ( $rates as $rate_id => $rate ) {
            $rates[ $rate_id ]->cost = 0;
            $rates[ $rate_id ]->taxes = [];
        }
        // Thêm thông báo (chỉ hiện 1 lần)
        $notice_key = 'af_freeship_notice';
        if ( ! wc_has_notice( '', 'success' ) ) {
            // Do nothing — notice sẽ hiện qua hook riêng bên dưới
        }
    }

    return $rates;
}

/**
 * Hiển thị thông báo freeship và tiến trình cho khách hàng trên trang Cart
 */
add_action( 'woocommerce_before_cart_totals', 'animefigure_uc3_freeship_notice' );
add_action( 'woocommerce_before_checkout_form', 'animefigure_uc3_freeship_notice' );
function animefigure_uc3_freeship_notice() {
    if ( ! WC()->cart ) return;

    $cart_subtotal = WC()->cart->get_subtotal();
    $threshold     = AF_PROMO_UC3_MIN_SPEND;

    if ( $cart_subtotal >= $threshold ) {
        echo '<div class="af-promo-notice af-promo-notice--success">';
        echo '🚚 <strong>Tuyệt vời!</strong> Đơn hàng của bạn được <strong>MIỄN PHÍ VẬN CHUYỂN</strong>!';
        echo '</div>';
    } else {
        $needed     = $threshold - $cart_subtotal;
        $progress   = round( ( $cart_subtotal / $threshold ) * 100 );
        echo '<div class="af-promo-notice af-promo-notice--info">';
        printf(
            '🚚 Mua thêm <strong>%s</strong> để được <strong>MIỄN PHÍ VẬN CHUYỂN</strong>!',
            wc_price( $needed )
        );
        printf(
            '<div class="af-promo-bar"><div class="af-promo-bar__fill" style="width: %d%%"></div></div>',
            $progress
        );
        echo '</div>';
    }
}

/* =========================================================
   STYLES CHO PROMO NOTICES (INLINE VÀO FRONTEND)
   ========================================================= */

add_action( 'wp_head', 'animefigure_promo_notice_styles' );
function animefigure_promo_notice_styles() {
    if ( ! is_cart() && ! is_checkout() ) return;
    ?>
    <style>
    .af-promo-notice {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 16px;
        font-size: 14px;
        line-height: 1.5;
    }
    .af-promo-notice--success {
        background: linear-gradient(135deg, #e8f5e9, #f1f8e9);
        border-left: 4px solid #43a047;
        color: #2e7d32;
    }
    .af-promo-notice--info {
        background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
        border-left: 4px solid #1e88e5;
        color: #1565c0;
    }
    .af-promo-bar {
        height: 6px;
        background: rgba(0,0,0,0.1);
        border-radius: 3px;
        margin-top: 8px;
        overflow: hidden;
    }
    .af-promo-bar__fill {
        height: 100%;
        background: linear-gradient(90deg, #1e88e5, #7b1fa2);
        border-radius: 3px;
        transition: width 0.5s ease;
    }
    </style>
    <?php
}
