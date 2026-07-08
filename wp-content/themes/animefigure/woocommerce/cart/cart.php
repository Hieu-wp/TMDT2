<?php
/**
 * Custom Cart Page Template
 * Overrides: animefigure/woocommerce/cart/cart.php
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<h1 class="cart-page-title">
    <svg class="cart-title-icon" viewBox="0 0 24 24" width="32" height="32" stroke="var(--color-primary)" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="9" cy="21" r="1"></circle>
        <circle cx="20" cy="21" r="1"></circle>
        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
    </svg>
    Giỏ hàng của tôi
</h1>

<div class="cart-page-layout">

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
    <?php do_action( 'woocommerce_before_cart_table' ); ?>

    <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
        <thead>
            <tr>
                <th class="product-name"><?php esc_html_e( 'SẢN PHẨM', 'woocommerce' ); ?></th>
                <th class="product-subtotal"><?php esc_html_e( 'TỔNG', 'woocommerce' ); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php do_action( 'woocommerce_before_cart_contents' ); ?>

            <?php
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                $visible = apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key );

                if ( $_product instanceof WC_Product && $_product->exists() && $cart_item['quantity'] > 0 && $visible ) {
                    $product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
                    $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                    $thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                    ?>
                    <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                        
                        <td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
                            <div class="cart-item-flex">
                                <div class="product-thumbnail">
                                    <?php
                                    if ( ! $product_permalink ) {
                                        echo $thumbnail;
                                    } else {
                                        printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
                                    }
                                    ?>
                                </div>
                                
                                <div class="product-details">
                                    <h3 class="product-title-heading">
                                        <?php
                                        if ( ! $product_permalink ) {
                                            echo wp_kses_post( $product_name );
                                        } else {
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                        }
                                        ?>
                                    </h3>
                                    
                                    <div class="product-prices-wrapper">
                                        <?php
                                        $regular_price = $_product->get_regular_price();
                                        $sale_price = $_product->get_sale_price();
                                        
                                        if ( $_product->is_on_sale() && !empty($sale_price) ) {
                                            echo '<div class="price-original">Giá gốc: <del>' . wc_price($regular_price) . '</del></div>';
                                            echo '<div class="price-current">Giá hiện tại: <span>' . wc_price($sale_price) . '</span></div>';
                                        } else {
                                            echo '<div class="price-regular">' . WC()->cart->get_product_price( $_product ) . '</div>';
                                        }
                                        ?>
                                    </div>
                                    
                                    <div class="product-actions-inline">
                                        <div class="quantity-controller">
                                            <button type="button" class="qty-btn qty-minus" aria-label="Decrease quantity">-</button>
                                            <?php
                                            if ( $_product->is_sold_individually() ) {
                                                $min_quantity = 1;
                                                $max_quantity = 1;
                                            } else {
                                                $min_quantity = 0;
                                                $max_quantity = $_product->get_max_purchase_quantity();
                                            }

                                            $product_quantity = woocommerce_quantity_input(
                                                array(
                                                    'input_name'   => "cart[{$cart_item_key}][qty]",
                                                    'input_value'  => $cart_item['quantity'],
                                                    'max_value'    => $max_quantity,
                                                    'min_value'    => $min_quantity,
                                                    'product_name' => $product_name,
                                                ),
                                                $_product,
                                                false
                                            );

                                            echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
                                            ?>
                                            <button type="button" class="qty-btn qty-plus" aria-label="Increase quantity">+</button>
                                        </div>
                                        
                                        <?php
                                        // SVG trash bin icon removal link
                                        echo apply_filters(
                                            'woocommerce_cart_item_remove_link',
                                            sprintf(
                                                '<a href="%s" class="remove remove-item-btn" aria-label="%s" data-product_id="%s" data-product_sku="%s">
                                                    <svg class="trash-icon" viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                    </svg>
                                                </a>',
                                                esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                                esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
                                                esc_attr( $product_id ),
                                                esc_attr( $_product->get_sku() )
                                            ),
                                            $cart_item_key
                                        );
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
                            <?php
                            echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
                            ?>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>

            <?php do_action( 'woocommerce_cart_contents' ); ?>

            <tr class="cart-actions-row">
                <td colspan="2" class="actions" style="border: none !important; padding: 0 !important;">
                    <div class="coupon" style="display: none !important;">
                        <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" />
                        <button type="submit" name="apply_coupon" value="Apply coupon">Apply</button>
                    </div>
                    
                    <button type="submit" class="button" name="update_cart" value="Update cart" style="display: none !important;">Update</button>

                    <?php do_action( 'woocommerce_cart_actions' ); ?>

                    <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                </td>
            </tr>

            <?php do_action( 'woocommerce_after_cart_contents' ); ?>
        </tbody>
    </table>
    
    <?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<div class="cart-collaterals">
    <?php
        /**
         * Cart collaterals hook.
         *
         * @hooked woocommerce_cross_sell_display
         * @hooked woocommerce_cart_totals - 10
         */
        do_action( 'woocommerce_cart_collaterals' );
    ?>
</div>

</div>

<div class="continue-shopping-wrapper">
    <a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>" class="continue-shopping-link">
        Tiếp tục mua sắm
    </a>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
