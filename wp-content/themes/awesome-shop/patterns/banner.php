<?php
/**
 * Title: Banner
 * Slug: awesome-shop/banner
 * Categories: awesome-shop
 */
?>

<!-- wp:group -->
<div class="wp-block-group">

    <!-- wp:group {"layout":{"type":"constrained"}} -->
    <div class="wp-block-group">

        <!-- wp:heading {"textAlign":"center"} -->
        <h2 class="has-text-align-center"><?php echo esc_html__( 'Ready to Transform Your Business?', 'awesome-shop' ); ?></h2>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"align":"center"} -->
        <p class="has-text-align-center"><?php echo esc_html__( 'Take the next step toward growth and unlock tools built to elevate your brand.', 'awesome-shop' ); ?></p>
        <!-- /wp:paragraph -->

        <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
        <div class="wp-block-buttons">

            <!-- wp:button {"backgroundColor":"secondary","textColor":"background","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}}}} -->
            <div class="wp-block-button">
                <a class="wp-block-button__link has-background-color has-secondary-background-color has-text-color has-background has-link-color wp-element-button">
                    <?php echo esc_html__( 'Get Started', 'awesome-shop' ); ?>
                </a>
            </div>
            <!-- /wp:button -->

        </div>
        <!-- /wp:buttons -->



    </div>
    <!-- /wp:group -->

</div>
<!-- /wp:group -->
