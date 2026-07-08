<?php
/**
 * Custom Cart Totals Template
 * Overrides: animefigure/woocommerce/cart/cart-totals.php
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

    <?php do_action( 'woocommerce_before_cart_totals' ); ?>

    <h2><?php esc_html_e( 'TÓM TẮT ĐƠN HÀNG', 'woocommerce' ); ?></h2>

    <!-- Custom coupon section -->
    <div class="custom-coupon-wrapper">
        <input type="text" class="custom-coupon-input" placeholder="Thêm mã giảm giá" />
        <button type="button" class="custom-coupon-btn">Áp dụng</button>
    </div>

    <table cellspacing="0" class="shop_table shop_table_responsive">

        <!-- Hidden subtotal row as we want it clean like the mockup, but keeping it in DOM for WooCommerce scripts -->
        <tr class="cart-subtotal" style="display: none !important;">
            <th><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
            <td><?php wc_cart_totals_subtotal_html(); ?></td>
        </tr>

        <!-- Coupon discount rows if any coupons are applied -->
        <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
            <tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                <th>
                    <svg class="coupon-icon" viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 6px;">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                        <line x1="7" y1="7" x2="7.01" y2="7"></line>
                    </svg>
                    <?php wc_cart_totals_coupon_label( $coupon ); ?>
                </th>
                <td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
            </tr>
        <?php endforeach; ?>

        <!-- Shipping row with delivery truck SVG -->
        <tr class="shipping-row">
            <th>
                <svg class="truck-icon" viewBox="0 0 24 24" width="20" height="20" stroke="var(--color-primary)" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="3" width="15" height="13"></rect>
                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                </svg>
                <span>Giao hàng:</span>
            </th>
            <td>
                <?php
                if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) {
                    // Output shipping method cleanly
                    $packages = WC()->shipping()->get_packages();
                    $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
                    $is_free = false;
                    
                    if ( ! empty( $chosen_methods ) ) {
                        foreach ( $chosen_methods as $method ) {
                            if ( strpos( strtolower( $method ), 'free_shipping' ) !== false ) {
                                $is_free = true;
                                break;
                            }
                        }
                    }
                    
                    if ( $is_free || WC()->cart->get_shipping_total() == 0 ) {
                        echo 'Miễn phí';
                    } else {
                        echo wc_cart_totals_shipping_html();
                    }
                } else {
                    echo 'Miễn phí';
                }
                ?>
            </td>
        </tr>

        <!-- Fees rows if any -->
        <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
            <tr class="fee">
                <th><?php echo esc_html( $fee->name ); ?></th>
                <td><?php wc_cart_totals_fee_html( $fee ); ?></td>
            </tr>
        <?php endforeach; ?>

        <!-- Taxes rows if any -->
        <?php
        if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
            $taxable_address = WC()->customer->get_taxable_address();
            $estimated_text  = '';

            if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
                $estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
            }

            if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
                foreach ( WC()->cart->get_tax_totals() as $code => $tax ) {
                    ?>
                    <tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                        <th><?php echo esc_html( $tax->label ) . $estimated_text; ?></th>
                        <td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr class="tax-total">
                    <th><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; ?></th>
                    <td><?php wc_cart_totals_taxes_total_html(); ?></td>
                </tr>
                <?php
            }
        }
        ?>

        <?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

        <!-- Order Total / Tổng ước tính row -->
        <tr class="order-total">
            <th>Tổng ước tính:</th>
            <td><?php wc_cart_totals_order_total_html(); ?></td>
        </tr>

        <?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

    </table>

    <div class="wc-proceed-to-checkout">
        <?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
    </div>

    <?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
