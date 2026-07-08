<?php
/**
 * Checkout Form
 *
 * Overrides: animefigure/woocommerce/checkout/form-checkout.php
 * Two-column checkout layout inspired by the provided reference.
 *
 * @package WooCommerce\Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



$current_user = wp_get_current_user();
?>

<div class="af-checkout-nav">
	<a class="af-checkout-back" href="<?php echo esc_url( wc_get_cart_url() ); ?>">← Quay lại giỏ hàng</a>
</div>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__( 'Checkout', 'woocommerce' ); ?>">
	<div class="af-checkout-layout">
		<div class="af-checkout-column af-checkout-column--left">
			<section class="af-checkout-card af-checkout-card--account">
				<div class="af-card-head">
					<h3>Tài khoản</h3>
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( wp_logout_url( wc_get_checkout_url() ) ); ?>">Đăng xuất</a>
					<?php endif; ?>
				</div>
				<div class="af-account-summary">
					<div class="af-account-avatar"><?php echo esc_html( function_exists( 'mb_strtoupper' ) ? mb_strtoupper( substr( $current_user->display_name ?: 'A', 0, 2 ) ) : strtoupper( substr( $current_user->display_name ?: 'A', 0, 2 ) ) ); ?></div>
					<div class="af-account-meta">
						<strong><?php echo esc_html( $current_user->display_name ?: 'Khách' ); ?></strong>
						<span><?php echo esc_html( $current_user->user_email ?: 'Đăng nhập để nhận thông báo đơn hàng' ); ?></span>
					</div>
				</div>
			</section>

			<section class="af-checkout-card af-checkout-card--shipping-info">
				<h3>Thông tin nhận hàng</h3>
				<?php if ( $checkout->get_checkout_fields() ) : ?>
					<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
					<div class="af-checkout-fields">
						<?php do_action( 'woocommerce_checkout_billing' ); ?>
					</div>
					<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
				<?php endif; ?>
			</section>

			<section class="af-checkout-card af-checkout-card--shipping-note">
				<h3>Phương thức giao hàng</h3>
				<?php if ( function_exists( 'animefigure_uc3_freeship_notice' ) ) : ?>
					<?php animefigure_uc3_freeship_notice(); ?>
				<?php endif; ?>
			</section>

			<section class="af-checkout-card af-checkout-card--payment-methods">
				<h3>Phương thức thanh toán</h3>
				<?php woocommerce_checkout_payment(); ?>
			</section>
		</div>

		<div class="af-checkout-column af-checkout-column--right">
			<section class="af-checkout-card af-checkout-card--summary">
				<div class="af-card-head">
					<h3>Đơn hàng của bạn</h3>
				</div>
				<div class="af-order-review-wrap">
					<?php woocommerce_order_review(); ?>
				</div>
			</section>

			<section class="af-checkout-card af-checkout-card--coupon">
				<h3>Mã khuyến mãi</h3>
				<?php woocommerce_checkout_coupon_form(); ?>
			</section>

			<section class="af-checkout-card af-checkout-card--place-order">
				<div class="af-order-total-line">
					<span>Tổng thanh toán</span>
					<strong><?php echo wp_kses_post( WC()->cart ? WC()->cart->get_total() : '' ); ?></strong>
				</div>
				<?php echo apply_filters(
					'woocommerce_order_button_html',
					'<button type="submit" class="button alt af-place-order-button" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( apply_filters( 'woocommerce_order_button_text', __( 'Place order', 'woocommerce' ) ) ) . '" data-value="' . esc_attr( apply_filters( 'woocommerce_order_button_text', __( 'Place order', 'woocommerce' ) ) ) . '">' . esc_html( apply_filters( 'woocommerce_order_button_text', __( 'Place order', 'woocommerce' ) ) ) . '</button>'
				); ?>
				<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
			</section>
		</div>
	</div>
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>