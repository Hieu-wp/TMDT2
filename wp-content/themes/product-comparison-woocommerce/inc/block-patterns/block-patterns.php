<?php
/**
 * Product Comparison Woocommerce: Block Patterns
 *
 * @package Product Comparison Woocommerce
 * @since   1.0.0
 */

/**
 * Register Block Pattern Category.
 */
if ( function_exists( 'register_block_pattern_category' ) ) {

	register_block_pattern_category(
		'product-comparison-woocommerce',
		array( 'label' => __( 'Product Comparison Woocommerce', 'product-comparison-woocommerce' ) )
	);
}

/**
 * Register Block Patterns.
 */
if ( function_exists( 'register_block_pattern' ) ) {
	register_block_pattern(
		'product-comparison-woocommerce/banner-section',
		array(
			'title'      => __( 'Banner Section', 'product-comparison-woocommerce' ),
			'categories' => array( 'product-comparison-woocommerce' ),
			'content'    => "<!-- wp:cover {\"url\":\"" . esc_url(get_template_directory_uri()) . "/inc/block-patterns/images/banner.png\",\"id\":1986,\"dimRatio\":50,\"overlayColor\":\"white\",\"minHeight\":600,\"isDark\":false,\"align\":\"full\",\"className\":\"banner-sections\",\"layout\":{\"type\":\"constrained\"}} -->\n<div class=\"wp-block-cover alignfull is-light banner-sections\" style=\"min-height:600px\"><span aria-hidden=\"true\" class=\"wp-block-cover__background has-white-background-color has-background-dim\"></span><img class=\"wp-block-cover__image-background wp-image-1986\" alt=\"\" src=\"" . esc_url(get_template_directory_uri()) . "/inc/block-patterns/images/banner.png\" data-object-fit=\"cover\"/><div class=\"wp-block-cover__inner-container\"><!-- wp:columns {\"className\":\"banner-section\"} -->\n<div class=\"wp-block-columns banner-section\"><!-- wp:column {\"width\":\"66.66%\",\"className\":\"banner-left-section\"} -->\n<div class=\"wp-block-column banner-left-section\" style=\"flex-basis:66.66%\"><!-- wp:columns {\"className\":\"banner-content\"} -->\n<div class=\"wp-block-columns banner-content\"><!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:paragraph {\"style\":{\"typography\":{\"fontSize\":\"40px\"}},\"className\":\"banner-heading\"} -->\n<p class=\"banner-heading\" style=\"font-size:40px\">Compare Price &amp; Product</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph {\"style\":{\"typography\":{\"fontSize\":\"15px\"}},\"className\":\"banner-para\"} -->\n<p class=\"banner-para\" style=\"font-size:15px\">Sell custom on-demand printed product without any up-front investment. from print providers directely to your customers</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button {\"textColor\":\"white\",\"style\":{\"color\":{\"background\":\"#d50000\"},\"typography\":{\"fontSize\":\"15px\"},\"border\":{\"radius\":\"30px\"}},\"className\":\"banner-button is-style-fill\"} -->\n<div class=\"wp-block-button has-custom-font-size banner-button is-style-fill\" style=\"font-size:15px\"><a class=\"wp-block-button__link has-white-color has-text-color has-background wp-element-button\" href=\"#\" style=\"border-radius:30px;background-color:#d50000\">Compare Now</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns -->\n\n<!-- wp:columns {\"className\":\"banner-products\"} -->\n<div class=\"wp-block-columns banner-products\"><!-- wp:column {\"width\":\"66.66%\",\"className\":\"banner-product-section\"} -->\n<div class=\"wp-block-column banner-product-section\" style=\"flex-basis:66.66%\"><!-- wp:woocommerce/product-category {\"rows\":1,\"contentVisibility\":{\"image\":true,\"title\":true,\"price\":true,\"rating\":false,\"button\":false},\"categories\":[211]} /--></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns --></div>\n<!-- /wp:column -->\n\n<!-- wp:column {\"width\":\"33.33%\",\"className\":\"banner-right-section\"} -->\n<div class=\"wp-block-column banner-right-section\" style=\"flex-basis:33.33%\"><!-- wp:image {\"align\":\"center\",\"id\":1982,\"height\":\"350px\",\"sizeSlug\":\"full\",\"linkDestination\":\"none\",\"className\":\"mobile-img\"} -->\n<figure class=\"wp-block-image aligncenter size-full is-resized mobile-img\"><img src=\"" . esc_url(get_template_directory_uri()) . "/inc/block-patterns/images/product.png\" alt=\"\" class=\"wp-image-1982\" style=\"height:350px\"/></figure>\n<!-- /wp:image -->\n\n<!-- wp:columns {\"className\":\"mobile-content\"} -->\n<div class=\"wp-block-columns mobile-content\"><!-- wp:column {\"verticalAlignment\":\"top\",\"className\":\"mobile-heading\"} -->\n<div class=\"wp-block-column is-vertically-aligned-top mobile-heading\"><!-- wp:paragraph {\"style\":{\"typography\":{\"fontSize\":\"22px\"},\"color\":{\"text\":\"#010101\"}}} -->\n<p class=\"has-text-color\" style=\"color:#010101;font-size:22px\">Samsung galaxy s22 ultra</p>\n<!-- /wp:paragraph --></div>\n<!-- /wp:column -->\n\n<!-- wp:column {\"className\":\"mobile-arrow\"} -->\n<div class=\"wp-block-column mobile-arrow\"><!-- wp:image {\"id\":1984,\"sizeSlug\":\"full\",\"linkDestination\":\"none\"} -->\n<figure class=\"wp-block-image size-full\"><img src=\"" . esc_url(get_template_directory_uri()) . "/inc/block-patterns/images/arrow.png\" alt=\"\" class=\"wp-image-1984\"/></figure>\n<!-- /wp:image --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns -->\n\n<!-- wp:columns {\"className\":\"mobile-price-section\"} -->\n<div class=\"wp-block-columns mobile-price-section\"><!-- wp:column {\"width\":\"\",\"className\":\"price-sec1\"} -->\n<div class=\"wp-block-column price-sec1\"><!-- wp:paragraph -->\n<p>$220.00</p>\n<!-- /wp:paragraph --></div>\n<!-- /wp:column -->\n\n<!-- wp:column {\"width\":\"\",\"className\":\"price-sec2\"} -->\n<div class=\"wp-block-column price-sec2\"><!-- wp:buttons {\"layout\":{\"type\":\"flex\",\"justifyContent\":\"right\"}} -->\n<div class=\"wp-block-buttons\"><!-- wp:button {\"textColor\":\"white\",\"style\":{\"color\":{\"background\":\"#d50000\"},\"typography\":{\"fontSize\":\"15px\"},\"border\":{\"radius\":\"30px\"}},\"className\":\"banner-button is-style-fill\"} -->\n<div class=\"wp-block-button has-custom-font-size banner-button is-style-fill\" style=\"font-size:15px\"><a class=\"wp-block-button__link has-white-color has-text-color has-background wp-element-button\" style=\"border-radius:30px;background-color:#d50000\">Compare</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns --></div></div>\n<!-- /wp:cover -->",
		)
	);

	register_block_pattern(
		'product-comparison-woocommerce/best-product-section',
		array(
			'title'      => __( 'Best Product Section', 'product-comparison-woocommerce' ),
			'categories' => array( 'product-comparison-woocommerce' ),
			'content'    => "<!-- wp:columns {\"className\":\"product-sections\"} -->\n<div class=\"wp-block-columns product-sections\"><!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:paragraph {\"style\":{\"typography\":{\"fontSize\":\"25px\"}},\"textColor\":\"black\",\"className\":\"product-section-heading\"} -->\n<p class=\"product-section-heading has-black-color has-text-color\" style=\"font-size:25px\">Popular Products</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph {\"style\":{\"typography\":{\"fontSize\":\"14px\"},\"color\":{\"text\":\"#383839\"}},\"className\":\"product-section-para\"} -->\n<p class=\"product-section-para has-text-color\" style=\"color:#383839;font-size:14px\">Lorem Ipsum Dolor Sit Amet, Consectetuer Adipiscing Elit. Donec Mollis</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:columns {\"className\":\"product-section\"} -->\n<div class=\"wp-block-columns product-section\"><!-- wp:column -->\n<div class=\"wp-block-column\"><!-- wp:woocommerce/product-category {\"columns\":4,\"rows\":1,\"contentVisibility\":{\"image\":true,\"title\":true,\"price\":true,\"rating\":true,\"button\":true},\"categories\":[213]} /--></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns --></div>\n<!-- /wp:column --></div>\n<!-- /wp:columns -->",
		)
	);
}