<?php

	$product_comparison_woocommerce_custom_css= "";

	/*-------------------- First Highlight Color -------------------*/

	$product_comparison_woocommerce_first_color = get_theme_mod('product_comparison_woocommerce_first_color');

	if($product_comparison_woocommerce_first_color != false){
		$product_comparison_woocommerce_custom_css .='.principle-box:hover .principle-box-inner-img, .more-btn a, #comments input[type="submit"],#comments a.comment-reply-link,input[type="submit"],.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,.pro-button a, .woocommerce a.added_to_cart.wc-forward, #footer input[type="submit"], #footer-2, #footer .wp-block-search .wp-block-search__button, #sidebar .wp-block-search .wp-block-search__button, .scrollup i:hover, #sidebar .custom-social-icons a,#footer .custom-social-icons a, #sidebar h3,  #sidebar .widget_block h3, #sidebar h2, .pagination span, .pagination a, .woocommerce span.onsale, nav.woocommerce-MyAccount-navigation ul li, .scrollup i, .pagination a:hover, .pagination .current, #sidebar .tagcloud a:hover, #main-product button.tablinks.active, .main-product-section .pro-button, .main-product-section:hover .the_timer, nav.woocommerce-MyAccount-navigation ul li:hover, #preloader, .event-btn-1 a, .event-btn-2 a:hover,.wp-block-tag-cloud a:hover,#sidebar h3, #sidebar .widget_block h3, #sidebar h2, #sidebar label.wp-block-search__label, #sidebar .wp-block-heading,.breadcrumbs a, .post-categories li a,.breadcrumbs span,.wp-block-button__link,#sidebar .wp-block-tag-cloud a:hover,#footer .wp-block-tag-cloud a:hover,#footer-2,.read-more a,#banner .slider-nav .slick-slide.slick-current.slick-active,.compare-btn a, .compare-btn-banner a,.main-navigation ul li.current_page_item a:before,.wp-block-woocommerce-cart .wc-block-cart__submit-button, .wc-block-components-checkout-place-order-button, .wc-block-components-totals-coupon__button,.wp-block-woocommerce-cart .wc-block-cart__submit-button:hover, .wc-block-components-checkout-place-order-button:hover,.wc-block-components-order-summary .wc-block-components-order-summary-item__quantity,.breadcrumbs a:hover, .post-categories li a:hover, #footer .tagcloud a:hover{';
			$product_comparison_woocommerce_custom_css .='background: '.esc_attr($product_comparison_woocommerce_first_color).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	if($product_comparison_woocommerce_first_color != false){
		$product_comparison_woocommerce_custom_css .='#sidebar ul li::before,#footer-2,.wc-block-components-order-summary .wc-block-components-order-summary-item__quantity,.wp-block-woocommerce-empty-cart-block .wc-block-grid__product-onsale,.toggle-nav i{';
			$product_comparison_woocommerce_custom_css .='background: '.esc_attr($product_comparison_woocommerce_first_color).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	if($product_comparison_woocommerce_first_color != false){
		$product_comparison_woocommerce_custom_css .='a, .main-header span.donate a:hover, .main-header span.volunteer a:hover, .main-header span.donate i:hover, .main-header span.volunteer i:hover, .box-content h3, .box-content h3 a, .woocommerce-message::before,.woocommerce-info::before,.post-main-box:hover h2 a, .post-main-box:hover .post-info span a, .single-post .post-info:hover a, .middle-bar h6, .main-navigation ul li.current_page_item, .main-navigation li a:hover,.main-navigation ul li.current_page_item a, .main-navigation li a:hover, .main-navigation ul ul li a:hover, .main-navigation li a:focus, .main-navigation ul ul a:focus, .main-navigation ul ul a:hover,p.site-title a:hover, .logo h1 a:hover,.post-main-box:hover h2 a, .post-main-box:hover .post-info span a, .single-post .post-info:hover a, .middle-bar h6, .grid-post-main-box:hover h2 a, .grid-post-main-box:hover .post-info span a,#best-product-section .product-box:hover .product-box-content h3 a,.sticky .post-main-box h2:before,.post-main-box:hover h3 a, #sidebar ul li a:hover, #footer li a:hover, .post-navigation a:hover .post-title, .post-navigation a:focus .post-title, .post-navigation a:hover, .post-navigation a:focus,.wp-block-quote, .wp-block-quote:not(.is-large):not(.is-style-large), .wp-block-pullquote,.post-navigation span.meta-nav:hover{';
			$product_comparison_woocommerce_custom_css .='color: '.esc_attr($product_comparison_woocommerce_first_color).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	if($product_comparison_woocommerce_first_color != false){
		$product_comparison_woocommerce_custom_css .='.home-page-header,.main-navigation ul ul,.wp-block-quote, .wp-block-quote:not(.is-large):not(.is-style-large), .wp-block-pullquote,.wp-block-woocommerce-empty-cart-block .wc-block-grid__product-onsale,#footer .tagcloud a:hover{';
			$product_comparison_woocommerce_custom_css .='border-color: '.esc_attr($product_comparison_woocommerce_first_color).'!important;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	if($product_comparison_woocommerce_first_color != false){
		$product_comparison_woocommerce_custom_css .='.main-navigation ul ul,.main-navigation ul li.current_page_item a,.page-template-custom-home-page .home-page-header{';
			$product_comparison_woocommerce_custom_css .='border-bottom:2px solid '.esc_attr($product_comparison_woocommerce_first_color).'!important;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_custom_css .='}';

	/*---------------------------Width Layout -------------------*/

	$product_comparison_woocommerce_theme_lay = get_theme_mod( 'product_comparison_woocommerce_width_option','Full Width');
    if($product_comparison_woocommerce_theme_lay == 'Boxed'){
		$product_comparison_woocommerce_custom_css .='body{';
			$product_comparison_woocommerce_custom_css .='max-width: 1140px; width: 100%; margin-right: auto; margin-left: auto;';
		$product_comparison_woocommerce_custom_css .='}';
		$product_comparison_woocommerce_custom_css .='.scrollup i{';
			$product_comparison_woocommerce_custom_css .='right: 100px;';
		$product_comparison_woocommerce_custom_css .='}';
		$product_comparison_woocommerce_custom_css .='.row.outer-logo{';
			$product_comparison_woocommerce_custom_css .='margin-left: 0px;';
		$product_comparison_woocommerce_custom_css .='}';
	}else if($product_comparison_woocommerce_theme_lay == 'Wide Width'){
		$product_comparison_woocommerce_custom_css .='body{';
			$product_comparison_woocommerce_custom_css .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';
		$product_comparison_woocommerce_custom_css .='}';
		$product_comparison_woocommerce_custom_css .='.scrollup i{';
			$product_comparison_woocommerce_custom_css .='right: 30px;';
		$product_comparison_woocommerce_custom_css .='}';
		$product_comparison_woocommerce_custom_css .='.row.outer-logo{';
			$product_comparison_woocommerce_custom_css .='margin-left: 0px;';
		$product_comparison_woocommerce_custom_css .='}';
	}else if($product_comparison_woocommerce_theme_lay == 'Full Width'){
		$product_comparison_woocommerce_custom_css .='body{';
			$product_comparison_woocommerce_custom_css .='max-width: 100%;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	/*----------------Responsive Media -----------------------*/

	$product_comparison_woocommerce_resp_slider = get_theme_mod( 'product_comparison_woocommerce_resp_slider_hide_show',false);
	if($product_comparison_woocommerce_resp_slider == true && get_theme_mod( 'product_comparison_woocommerce_slider_hide_show', false) == false){
    	$product_comparison_woocommerce_custom_css .='#slider{';
			$product_comparison_woocommerce_custom_css .='display:none;';
		$product_comparison_woocommerce_custom_css .='} ';
	}
    if($product_comparison_woocommerce_resp_slider == true){
    	$product_comparison_woocommerce_custom_css .='@media screen and (max-width:575px) {';
		$product_comparison_woocommerce_custom_css .='#slider{';
			$product_comparison_woocommerce_custom_css .='display:block;';
		$product_comparison_woocommerce_custom_css .='} }';
	}else if($product_comparison_woocommerce_resp_slider == false){
		$product_comparison_woocommerce_custom_css .='@media screen and (max-width:575px) {';
		$product_comparison_woocommerce_custom_css .='#slider{';
			$product_comparison_woocommerce_custom_css .='display:none;';
		$product_comparison_woocommerce_custom_css .='} }';
		$product_comparison_woocommerce_custom_css .='@media screen and (max-width:575px){';
		$product_comparison_woocommerce_custom_css .='.page-template-custom-home-page.admin-bar .homepageheader{';
			$product_comparison_woocommerce_custom_css .='margin-top: 45px;';
		$product_comparison_woocommerce_custom_css .='} }';
	}

	$product_comparison_woocommerce_resp_sidebar = get_theme_mod( 'product_comparison_woocommerce_sidebar_hide_show',true);
    if($product_comparison_woocommerce_resp_sidebar == true){
    	$product_comparison_woocommerce_custom_css .='@media screen and (max-width:575px) {';
		$product_comparison_woocommerce_custom_css .='#sidebar{';
			$product_comparison_woocommerce_custom_css .='display:block;';
		$product_comparison_woocommerce_custom_css .='} }';
	}else if($product_comparison_woocommerce_resp_sidebar == false){
		$product_comparison_woocommerce_custom_css .='@media screen and (max-width:575px) {';
		$product_comparison_woocommerce_custom_css .='#sidebar{';
			$product_comparison_woocommerce_custom_css .='display:none;';
		$product_comparison_woocommerce_custom_css .='} }';
	}

	$product_comparison_woocommerce_resp_scroll_top = get_theme_mod( 'product_comparison_woocommerce_resp_scroll_top_hide_show',true);
	if($product_comparison_woocommerce_resp_scroll_top == true && get_theme_mod( 'product_comparison_woocommerce_hide_show_scroll',true) == false){
    	$product_comparison_woocommerce_custom_css .='.scrollup i{';
			$product_comparison_woocommerce_custom_css .='visibility:hidden !important;';
		$product_comparison_woocommerce_custom_css .='} ';
	}
    if($product_comparison_woocommerce_resp_scroll_top == true){
    	$product_comparison_woocommerce_custom_css .='@media screen and (max-width:575px) {';
		$product_comparison_woocommerce_custom_css .='.scrollup i{';
			$product_comparison_woocommerce_custom_css .='visibility:visible !important;';
		$product_comparison_woocommerce_custom_css .='} }';
	}else if($product_comparison_woocommerce_resp_scroll_top == false){
		$product_comparison_woocommerce_custom_css .='@media screen and (max-width:575px){';
		$product_comparison_woocommerce_custom_css .='.scrollup i{';
			$product_comparison_woocommerce_custom_css .='visibility:hidden !important;';
		$product_comparison_woocommerce_custom_css .='} }';
	}


	/*------------- Preloader Background Color  -------------------*/

	$product_comparison_woocommerce_preloader_bg_color = get_theme_mod('product_comparison_woocommerce_preloader_bg_color');
	if($product_comparison_woocommerce_preloader_bg_color != false){
		$product_comparison_woocommerce_custom_css .='#preloader{';
			$product_comparison_woocommerce_custom_css .='background-color: '.esc_attr($product_comparison_woocommerce_preloader_bg_color).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_preloader_border_color = get_theme_mod('product_comparison_woocommerce_preloader_border_color');
	if($product_comparison_woocommerce_preloader_border_color != false){
		$product_comparison_woocommerce_custom_css .='.loader-line{';
			$product_comparison_woocommerce_custom_css .='border-color: '.esc_attr($product_comparison_woocommerce_preloader_border_color).'!important;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_preloader_bg_img = get_theme_mod('product_comparison_woocommerce_preloader_bg_img');
	if($product_comparison_woocommerce_preloader_bg_img != false){
		$product_comparison_woocommerce_custom_css .='#preloader{';
			$product_comparison_woocommerce_custom_css .='background: url('.esc_attr($product_comparison_woocommerce_preloader_bg_img).');-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	// banner background img

	$product_comparison_woocommerce_banner_image = get_theme_mod('product_comparison_woocommerce_banner_image');
	if($product_comparison_woocommerce_banner_image != false){
		$product_comparison_woocommerce_custom_css .='#banner{';
			$product_comparison_woocommerce_custom_css .='background: url('.esc_url($product_comparison_woocommerce_banner_image).');';
		$product_comparison_woocommerce_custom_css .='}';
	}

	/*----------------- Banner -----------------*/

	$product_comparison_woocommerce_show_hide_banner = get_theme_mod('product_comparison_woocommerce_show_hide_banner');
	if($product_comparison_woocommerce_show_hide_banner == true){
		$product_comparison_woocommerce_custom_css .='.page-template-custom-home-page .home-page-header{';
			$product_comparison_woocommerce_custom_css .='position: static; border-bottom:2px solid #eb353c; padding: 30px 0;margin-top:0;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	/*-------------- Copyright Alignment ----------------*/

	$product_comparison_woocommerce_copyright_alingment = get_theme_mod('product_comparison_woocommerce_copyright_alingment');
	if($product_comparison_woocommerce_copyright_alingment != false){
		$product_comparison_woocommerce_custom_css .='.copyright p{';
			$product_comparison_woocommerce_custom_css .='text-align: '.esc_attr($product_comparison_woocommerce_copyright_alingment).';';
		$product_comparison_woocommerce_custom_css .='}';
		$product_comparison_woocommerce_custom_css .='
		@media screen and (max-width:720px) {
			.copyright p{';
			$product_comparison_woocommerce_custom_css .='text-align: center;} }';
	}

	$product_comparison_woocommerce_align_footer_social_icon = get_theme_mod('product_comparison_woocommerce_align_footer_social_icon');
	if($product_comparison_woocommerce_align_footer_social_icon != false){
		$product_comparison_woocommerce_custom_css .='.copyright .widget{';
			$product_comparison_woocommerce_custom_css .='text-align: '.esc_attr($product_comparison_woocommerce_align_footer_social_icon).';';
		$product_comparison_woocommerce_custom_css .='}';
		$product_comparison_woocommerce_custom_css .='
		@media screen and (max-width:720px) {
			.copyright .widget{';
			$product_comparison_woocommerce_custom_css .='text-align: center;} }';
	}

	$product_comparison_woocommerce_resp_stickycopyright = get_theme_mod( 'product_comparison_woocommerce_stickycopyright_hide_show',false);
	if($product_comparison_woocommerce_resp_stickycopyright == true && get_theme_mod( 'product_comparison_woocommerce_copyright_sticky',false) != true){
    	$product_comparison_woocommerce_custom_css .='.copyright-sticky{';
			$product_comparison_woocommerce_custom_css .='position:static;';
		$product_comparison_woocommerce_custom_css .='} ';
	}

	$product_comparison_woocommerce_footer_social_icons_font_size = get_theme_mod('product_comparison_woocommerce_footer_social_icons_font_size','16');
	$product_comparison_woocommerce_custom_css .='.copyright .widget i{';
		$product_comparison_woocommerce_custom_css .='font-size: '.esc_attr($product_comparison_woocommerce_footer_social_icons_font_size).'px;';
	$product_comparison_woocommerce_custom_css .='}';

	$product_comparison_woocommerce_copyright_background_color = get_theme_mod('product_comparison_woocommerce_copyright_background_color');
	if($product_comparison_woocommerce_copyright_background_color != false){
		$product_comparison_woocommerce_custom_css .='#footer-2{';
			$product_comparison_woocommerce_custom_css .='background-color: '.esc_attr($product_comparison_woocommerce_copyright_background_color).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_footer_background_color = get_theme_mod('product_comparison_woocommerce_footer_background_color');
	if($product_comparison_woocommerce_footer_background_color != false){
		$product_comparison_woocommerce_custom_css .='#footer{';
			$product_comparison_woocommerce_custom_css .='background-color: '.esc_attr($product_comparison_woocommerce_footer_background_color).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_footer_widgets_heading = get_theme_mod( 'product_comparison_woocommerce_footer_widgets_heading','Left');
    if($product_comparison_woocommerce_footer_widgets_heading == 'Left'){
		$product_comparison_woocommerce_custom_css .='#footer h3, #footer .wp-block-search .wp-block-search__label{';
		$product_comparison_woocommerce_custom_css .='text-align: left;';
		$product_comparison_woocommerce_custom_css .='}';
	}else if($product_comparison_woocommerce_footer_widgets_heading == 'Center'){
		$product_comparison_woocommerce_custom_css .='#footer h3, #footer .wp-block-search .wp-block-search__label{';
			$product_comparison_woocommerce_custom_css .='text-align: center;';
		$product_comparison_woocommerce_custom_css .='}';
	}else if($product_comparison_woocommerce_footer_widgets_heading == 'Right'){
		$product_comparison_woocommerce_custom_css .='#footer h3, #footer .wp-block-search .wp-block-search__label{';
			$product_comparison_woocommerce_custom_css .='text-align: right;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_footer_widgets_content = get_theme_mod( 'product_comparison_woocommerce_footer_widgets_content','Left');
    if($product_comparison_woocommerce_footer_widgets_content == 'Left'){
		$product_comparison_woocommerce_custom_css .='#footer .widget{';
		$product_comparison_woocommerce_custom_css .='text-align: left;';
		$product_comparison_woocommerce_custom_css .='}';
	}else if($product_comparison_woocommerce_footer_widgets_content == 'Center'){
		$product_comparison_woocommerce_custom_css .='#footer .widget{';
			$product_comparison_woocommerce_custom_css .='text-align: center;';
		$product_comparison_woocommerce_custom_css .='}';
	}else if($product_comparison_woocommerce_footer_widgets_content == 'Right'){
		$product_comparison_woocommerce_custom_css .='#footer .widget{';
			$product_comparison_woocommerce_custom_css .='text-align: right;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_copyright_font_size = get_theme_mod('product_comparison_woocommerce_copyright_font_size');
	if($product_comparison_woocommerce_copyright_font_size != false){
		$product_comparison_woocommerce_custom_css .='#footer-2 a, #footer-2 p{';
			$product_comparison_woocommerce_custom_css .='font-size: '.esc_attr($product_comparison_woocommerce_copyright_font_size).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_copyright_padding_top_bottom = get_theme_mod('product_comparison_woocommerce_copyright_padding_top_bottom');
	if($product_comparison_woocommerce_copyright_padding_top_bottom != false){
		$product_comparison_woocommerce_custom_css .='#footer-2{';
			$product_comparison_woocommerce_custom_css .='padding-top: '.esc_attr($product_comparison_woocommerce_copyright_padding_top_bottom).'; padding-bottom: '.esc_attr($product_comparison_woocommerce_copyright_padding_top_bottom).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_footer_padding = get_theme_mod('product_comparison_woocommerce_footer_padding');
	if($product_comparison_woocommerce_footer_padding != false){
		$product_comparison_woocommerce_custom_css .='#footer{';
			$product_comparison_woocommerce_custom_css .='padding: '.esc_attr($product_comparison_woocommerce_footer_padding).' 0;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_footer_background_image = get_theme_mod('product_comparison_woocommerce_footer_background_image');
	if($product_comparison_woocommerce_footer_background_image != false){
		$product_comparison_woocommerce_custom_css .='#footer{';
			$product_comparison_woocommerce_custom_css .='background: url('.esc_attr($product_comparison_woocommerce_footer_background_image).');background-size:cover;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_theme_lay = get_theme_mod( 'product_comparison_woocommerce_img_footer','scroll');
	if($product_comparison_woocommerce_theme_lay == 'fixed'){
		$product_comparison_woocommerce_custom_css .='#footer{';
			$product_comparison_woocommerce_custom_css .='background-attachment: fixed !important; background-position: center !important;';
		$product_comparison_woocommerce_custom_css .='}';
	}elseif ($product_comparison_woocommerce_theme_lay == 'scroll'){
		$product_comparison_woocommerce_custom_css .='#footer{';
			$product_comparison_woocommerce_custom_css .='background-attachment: scroll !important; background-position: center !important;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_footer_img_position = get_theme_mod('product_comparison_woocommerce_footer_img_position','center center');
	if($product_comparison_woocommerce_footer_img_position != false){
		$product_comparison_woocommerce_custom_css .='#footer{';
			$product_comparison_woocommerce_custom_css .='background-position: '.esc_attr($product_comparison_woocommerce_footer_img_position).'!important;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	/*----------------Sroll to top Settings ------------------*/

	$product_comparison_woocommerce_scroll_to_top_font_size = get_theme_mod('product_comparison_woocommerce_scroll_to_top_font_size');
	if($product_comparison_woocommerce_scroll_to_top_font_size != false){
		$product_comparison_woocommerce_custom_css .='.scrollup i{';
			$product_comparison_woocommerce_custom_css .='font-size: '.esc_attr($product_comparison_woocommerce_scroll_to_top_font_size).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_scroll_to_top_padding = get_theme_mod('product_comparison_woocommerce_scroll_to_top_padding');
	$product_comparison_woocommerce_scroll_to_top_padding = get_theme_mod('product_comparison_woocommerce_scroll_to_top_padding');
	if($product_comparison_woocommerce_scroll_to_top_padding != false){
		$product_comparison_woocommerce_custom_css .='.scrollup i{';
			$product_comparison_woocommerce_custom_css .='padding-top: '.esc_attr($product_comparison_woocommerce_scroll_to_top_padding).';padding-bottom: '.esc_attr($product_comparison_woocommerce_scroll_to_top_padding).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_scroll_to_top_width = get_theme_mod('product_comparison_woocommerce_scroll_to_top_width');
	if($product_comparison_woocommerce_scroll_to_top_width != false){
		$product_comparison_woocommerce_custom_css .='.scrollup i{';
			$product_comparison_woocommerce_custom_css .='width: '.esc_attr($product_comparison_woocommerce_scroll_to_top_width).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_scroll_to_top_height = get_theme_mod('product_comparison_woocommerce_scroll_to_top_height');
	if($product_comparison_woocommerce_scroll_to_top_height != false){
		$product_comparison_woocommerce_custom_css .='.scrollup i{';
			$product_comparison_woocommerce_custom_css .='height: '.esc_attr($product_comparison_woocommerce_scroll_to_top_height).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_scroll_to_top_border_radius = get_theme_mod('product_comparison_woocommerce_scroll_to_top_border_radius');
	if($product_comparison_woocommerce_scroll_to_top_border_radius != false){
		$product_comparison_woocommerce_custom_css .='.scrollup i{';
			$product_comparison_woocommerce_custom_css .='border-radius: '.esc_attr($product_comparison_woocommerce_scroll_to_top_border_radius).'px;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	/*------------------ Logo  -------------------*/

	$product_comparison_woocommerce_logo_padding = get_theme_mod('product_comparison_woocommerce_logo_padding');
	if($product_comparison_woocommerce_logo_padding != false){
		$product_comparison_woocommerce_custom_css .='.logo{';
			$product_comparison_woocommerce_custom_css .='padding: '.esc_attr($product_comparison_woocommerce_logo_padding).' !important;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_logo_margin = get_theme_mod('product_comparison_woocommerce_logo_margin');
	if($product_comparison_woocommerce_logo_margin != false){
		$product_comparison_woocommerce_custom_css .='.logo{';
			$product_comparison_woocommerce_custom_css .='margin: '.esc_attr($product_comparison_woocommerce_logo_margin).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	// Site title Font Size
	$product_comparison_woocommerce_site_title_font_size = get_theme_mod('product_comparison_woocommerce_site_title_font_size');
	if($product_comparison_woocommerce_site_title_font_size != false){
		$product_comparison_woocommerce_custom_css .='.logo p.site-title, .logo h1{';
			$product_comparison_woocommerce_custom_css .='font-size: '.esc_attr($product_comparison_woocommerce_site_title_font_size).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	// Site tagline Font Size
	$product_comparison_woocommerce_site_tagline_font_size = get_theme_mod('product_comparison_woocommerce_site_tagline_font_size');
	if($product_comparison_woocommerce_site_tagline_font_size != false){
		$product_comparison_woocommerce_custom_css .='.logo p.site-description{';
			$product_comparison_woocommerce_custom_css .='font-size: '.esc_attr($product_comparison_woocommerce_site_tagline_font_size).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_site_title_color = get_theme_mod('product_comparison_woocommerce_site_title_color');
	if($product_comparison_woocommerce_site_title_color != false){
		$product_comparison_woocommerce_custom_css .='p.site-title a, .logo h1 a{';
			$product_comparison_woocommerce_custom_css .='color: '.esc_attr($product_comparison_woocommerce_site_title_color).'!important;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_site_tagline_color = get_theme_mod('product_comparison_woocommerce_site_tagline_color');
	if($product_comparison_woocommerce_site_tagline_color != false){
		$product_comparison_woocommerce_custom_css .='.logo p.site-description{';
			$product_comparison_woocommerce_custom_css .='color: '.esc_attr($product_comparison_woocommerce_site_tagline_color).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_logo_width = get_theme_mod('product_comparison_woocommerce_logo_width');
	if($product_comparison_woocommerce_logo_width != false){
		$product_comparison_woocommerce_custom_css .='.logo img{';
			$product_comparison_woocommerce_custom_css .='width: '.esc_attr($product_comparison_woocommerce_logo_width).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_logo_height = get_theme_mod('product_comparison_woocommerce_logo_height');
	if($product_comparison_woocommerce_logo_height != false){
		$product_comparison_woocommerce_custom_css .='.logo img{';
			$product_comparison_woocommerce_custom_css .='height: '.esc_attr($product_comparison_woocommerce_logo_height).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	// Header Background Color
	$product_comparison_woocommerce_header_background_color = get_theme_mod('product_comparison_woocommerce_header_background_color');
	if($product_comparison_woocommerce_header_background_color != false){
		$product_comparison_woocommerce_custom_css .='.page-template-custom-home-page .home-page-header, .home-page-header{';
			$product_comparison_woocommerce_custom_css .='background-color: '.esc_attr($product_comparison_woocommerce_header_background_color).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_header_img_position = get_theme_mod('product_comparison_woocommerce_header_img_position','center top');
	if($product_comparison_woocommerce_header_img_position != false){
		$product_comparison_woocommerce_custom_css .='.page-template-custom-home-page .home-page-header, .home-page-header{';
			$product_comparison_woocommerce_custom_css .='background-position: '.esc_attr($product_comparison_woocommerce_header_img_position).'!important;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	/*---------------------------Blog Layout -------------------*/

	$product_comparison_woocommerce_theme_lay = get_theme_mod( 'product_comparison_woocommerce_blog_layout_option','Default');
    if($product_comparison_woocommerce_theme_lay == 'Default'){
		$product_comparison_woocommerce_custom_css .='.post-main-box{';
			$product_comparison_woocommerce_custom_css .='';
		$product_comparison_woocommerce_custom_css .='}';
	}else if($product_comparison_woocommerce_theme_lay == 'Center'){
		$product_comparison_woocommerce_custom_css .='.post-main-box, .post-main-box h2, .post-info, .new-text p, .content-bttn{';
			$product_comparison_woocommerce_custom_css .='text-align:center;';
		$product_comparison_woocommerce_custom_css .='}';
		$product_comparison_woocommerce_custom_css .='.post-info{';
			$product_comparison_woocommerce_custom_css .='margin-top:10px;';
		$product_comparison_woocommerce_custom_css .='}';
		$product_comparison_woocommerce_custom_css .='.post-info hr{';
			$product_comparison_woocommerce_custom_css .='margin:15px auto;';
		$product_comparison_woocommerce_custom_css .='}';
	}else if($product_comparison_woocommerce_theme_lay == 'Left'){
		$product_comparison_woocommerce_custom_css .='.post-main-box, .post-main-box h2, .post-info, .new-text p, .content-bttn, #our-services p{';
			$product_comparison_woocommerce_custom_css .='text-align:Left;';
		$product_comparison_woocommerce_custom_css .='}';
		$product_comparison_woocommerce_custom_css .='.post-info hr{';
			$product_comparison_woocommerce_custom_css .='margin-bottom:10px;';
		$product_comparison_woocommerce_custom_css .='}';
		$product_comparison_woocommerce_custom_css .='.post-main-box h2{';
			$product_comparison_woocommerce_custom_css .='margin-top:10px;';
		$product_comparison_woocommerce_custom_css .='}';
		$product_comparison_woocommerce_custom_css .='.service-text .more-btn{';
			$product_comparison_woocommerce_custom_css .='display:inline-block;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	/*--------------------- Blog Page Posts -------------------*/

	$product_comparison_woocommerce_blog_page_posts_settings = get_theme_mod( 'product_comparison_woocommerce_blog_page_posts_settings','Into Blocks');
    if($product_comparison_woocommerce_blog_page_posts_settings == 'Without Blocks'){
		$product_comparison_woocommerce_custom_css .='.post-main-box{';
			$product_comparison_woocommerce_custom_css .='box-shadow: none; border: none; margin:30px 0;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	// featured image dimention
	$product_comparison_woocommerce_blog_post_featured_image_dimension = get_theme_mod('product_comparison_woocommerce_blog_post_featured_image_dimension', 'default');
	$product_comparison_woocommerce_blog_post_featured_image_custom_width = get_theme_mod('product_comparison_woocommerce_blog_post_featured_image_custom_width',250);
	$product_comparison_woocommerce_blog_post_featured_image_custom_height = get_theme_mod('product_comparison_woocommerce_blog_post_featured_image_custom_height',250);
	if($product_comparison_woocommerce_blog_post_featured_image_dimension == 'custom'){
		$product_comparison_woocommerce_custom_css .='.post-main-box img{';
			$product_comparison_woocommerce_custom_css .='width: '.esc_attr($product_comparison_woocommerce_blog_post_featured_image_custom_width).'!important; height: '.esc_attr($product_comparison_woocommerce_blog_post_featured_image_custom_height).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	/*---------------- Posts Settings ------------------*/

	$product_comparison_woocommerce_featured_image_border_radius = get_theme_mod('product_comparison_woocommerce_featured_image_border_radius', 0);
	if($product_comparison_woocommerce_featured_image_border_radius != false){
		$product_comparison_woocommerce_custom_css .='.box-image img, .feature-box img{';
			$product_comparison_woocommerce_custom_css .='border-radius: '.esc_attr($product_comparison_woocommerce_featured_image_border_radius).'px;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_grid_featured_image_border_radius = get_theme_mod('product_comparison_woocommerce_grid_featured_image_border_radius', 0);
	if($product_comparison_woocommerce_grid_featured_image_border_radius != false){
		$product_comparison_woocommerce_custom_css .='.grid-post-main-box img{';
			$product_comparison_woocommerce_custom_css .='border-radius: '.esc_attr($product_comparison_woocommerce_grid_featured_image_border_radius).'px;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_featured_image_box_shadow = get_theme_mod('product_comparison_woocommerce_featured_image_box_shadow',0);
	if($product_comparison_woocommerce_featured_image_box_shadow != false){
		$product_comparison_woocommerce_custom_css .='.box-image img,  #content-vw img{';
			$product_comparison_woocommerce_custom_css .='box-shadow: '.esc_attr($product_comparison_woocommerce_featured_image_box_shadow).'px '.esc_attr($product_comparison_woocommerce_featured_image_box_shadow).'px '.esc_attr($product_comparison_woocommerce_featured_image_box_shadow).'px #cccccc;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_singlepost_image_box_shadow = get_theme_mod('product_comparison_woocommerce_singlepost_image_box_shadow',0);
	if($product_comparison_woocommerce_singlepost_image_box_shadow != false){
		$product_comparison_woocommerce_custom_css .='.feature-box img{';
			$product_comparison_woocommerce_custom_css .='box-shadow: '.esc_attr($product_comparison_woocommerce_singlepost_image_box_shadow).'px '.esc_attr($product_comparison_woocommerce_singlepost_image_box_shadow).'px '.esc_attr($product_comparison_woocommerce_singlepost_image_box_shadow).'px #cccccc;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_related_image_box_shadow = get_theme_mod('product_comparison_woocommerce_related_image_box_shadow',0);
	if($product_comparison_woocommerce_related_image_box_shadow != false){
		$product_comparison_woocommerce_custom_css .='.related-post .box-image img{';
			$product_comparison_woocommerce_custom_css .='box-shadow: '.esc_attr($product_comparison_woocommerce_related_image_box_shadow).'px '.esc_attr($product_comparison_woocommerce_related_image_box_shadow).'px '.esc_attr($product_comparison_woocommerce_related_image_box_shadow).'px #cccccc;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	/*---------------- Button Settings ------------------*/

	$product_comparison_woocommerce_button_letter_spacing = get_theme_mod('product_comparison_woocommerce_button_letter_spacing');
	$product_comparison_woocommerce_custom_css .='.post-main-box .more-btn{';
		$product_comparison_woocommerce_custom_css .='letter-spacing: '.esc_attr($product_comparison_woocommerce_button_letter_spacing).';';
	$product_comparison_woocommerce_custom_css .='}';

	$product_comparison_woocommerce_button_border_radius = get_theme_mod('product_comparison_woocommerce_button_border_radius');
	if($product_comparison_woocommerce_button_border_radius != false){
		$product_comparison_woocommerce_custom_css .='.post-main-box .more-btn a{';
			$product_comparison_woocommerce_custom_css .='border-radius: '.esc_attr($product_comparison_woocommerce_button_border_radius).'px !important;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_button_top_bottom_padding = get_theme_mod('product_comparison_woocommerce_button_top_bottom_padding');
	$product_comparison_woocommerce_button_left_right_padding = get_theme_mod('product_comparison_woocommerce_button_left_right_padding');
	if($product_comparison_woocommerce_button_top_bottom_padding != false || $product_comparison_woocommerce_button_left_right_padding != false){
		$product_comparison_woocommerce_custom_css .='.post-main-box .more-btn{';
			$product_comparison_woocommerce_custom_css .='padding-top: '.esc_attr($product_comparison_woocommerce_button_top_bottom_padding).'!important; padding-bottom: '.esc_attr($product_comparison_woocommerce_button_top_bottom_padding).'!important;padding-left: '.esc_attr($product_comparison_woocommerce_button_left_right_padding).'!important;padding-right: '.esc_attr($product_comparison_woocommerce_button_left_right_padding).'!important;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_button_font_size = get_theme_mod('product_comparison_woocommerce_button_font_size',14);
	$product_comparison_woocommerce_custom_css .='.post-main-box .more-btn a{';
		$product_comparison_woocommerce_custom_css .='font-size: '.esc_attr($product_comparison_woocommerce_button_font_size).';';
	$product_comparison_woocommerce_custom_css .='}';

	// button font weight
	$product_comparison_woocommerce_button_font_weight = get_theme_mod('product_comparison_woocommerce_button_font_weight');
  	$product_comparison_woocommerce_custom_css .='.more-btn a{';
    $product_comparison_woocommerce_custom_css .='font-weight: '.esc_attr($product_comparison_woocommerce_button_font_weight).'!important;';
  	$product_comparison_woocommerce_custom_css .='}';

	$product_comparison_woocommerce_theme_lay = get_theme_mod( 'product_comparison_woocommerce_button_text_transform','Capitalize');
	if($product_comparison_woocommerce_theme_lay == 'Capitalize'){
		$product_comparison_woocommerce_custom_css .='.post-main-box .more-btn a{';
			$product_comparison_woocommerce_custom_css .='text-transform:Capitalize;';
		$product_comparison_woocommerce_custom_css .='}';
	}
	if($product_comparison_woocommerce_theme_lay == 'Lowercase'){
		$product_comparison_woocommerce_custom_css .='.post-main-box .more-btn a{';
			$product_comparison_woocommerce_custom_css .='text-transform:Lowercase;';
		$product_comparison_woocommerce_custom_css .='}';
	}
	if($product_comparison_woocommerce_theme_lay == 'Uppercase'){
		$product_comparison_woocommerce_custom_css .='.post-main-box .more-btn a{';
			$product_comparison_woocommerce_custom_css .='text-transform:Uppercase;';
		$product_comparison_woocommerce_custom_css .='}';
	}
    
	//Button hover effect
	$product_comparison_woocommerce_button_hover_effect = get_theme_mod('product_comparison_woocommerce_button_hover_effect', 'disable');
	if ($product_comparison_woocommerce_button_hover_effect !== 'disable') {
		$product_comparison_woocommerce_custom_css .= '.more-btn a:hover {';
		switch ($product_comparison_woocommerce_button_hover_effect) {
			case 'pulse':
				$product_comparison_woocommerce_custom_css .= 'animation: pulse 0.5s ease-in-out !important;';
				break;
			case 'rubberBand':
				$product_comparison_woocommerce_custom_css .= 'animation: rubberBand 0.5s ease-in-out !important;';
				break;
			case 'swing':
				$product_comparison_woocommerce_custom_css .= 'animation: swing 0.5s ease-in-out !important;';
				break;
			case 'tada':
				$product_comparison_woocommerce_custom_css .= 'animation: tada 0.5s ease-in-out !important;';
				break;
			case 'jello':
				$product_comparison_woocommerce_custom_css .= 'animation: jello 0.5s ease-in-out!important;';
				break;
		}
		$product_comparison_woocommerce_custom_css .= '}';
	}


	/*---------------- Single Blog Page Settings ------------------*/

	$product_comparison_woocommerce_single_blog_comment_button_text = get_theme_mod('product_comparison_woocommerce_single_blog_comment_button_text', 'Post Comment');
	if($product_comparison_woocommerce_single_blog_comment_button_text == ''){
		$product_comparison_woocommerce_custom_css .='#comments p.form-submit {';
			$product_comparison_woocommerce_custom_css .='display: none;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_comment_width = get_theme_mod('product_comparison_woocommerce_single_blog_comment_width');
	if($product_comparison_woocommerce_comment_width != false){
		$product_comparison_woocommerce_custom_css .='#comments textarea{';
			$product_comparison_woocommerce_custom_css .='width: '.esc_attr($product_comparison_woocommerce_comment_width).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_single_blog_post_navigation_show_hide = get_theme_mod('product_comparison_woocommerce_single_blog_post_navigation_show_hide',true);
	if($product_comparison_woocommerce_single_blog_post_navigation_show_hide != true){
		$product_comparison_woocommerce_custom_css .='.post-navigation{';
			$product_comparison_woocommerce_custom_css .='display: none;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	/*--------------------- Grid Posts Posts -------------------*/

	$product_comparison_woocommerce_display_grid_posts_settings = get_theme_mod( 'product_comparison_woocommerce_display_grid_posts_settings','Into Blocks');
    if($product_comparison_woocommerce_display_grid_posts_settings == 'Without Blocks'){
		$product_comparison_woocommerce_custom_css .='.grid-post-main-box{';
			$product_comparison_woocommerce_custom_css .='box-shadow: none; border: none; margin:30px 0;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	/*----------------Woocommerce Products Settings ------------------*/

	$product_comparison_woocommerce_related_product_show_hide = get_theme_mod('product_comparison_woocommerce_related_product_show_hide',true);
	if($product_comparison_woocommerce_related_product_show_hide != true){
		$product_comparison_woocommerce_custom_css .='.related.products{';
			$product_comparison_woocommerce_custom_css .='display: none;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	/*----------------Woocommerce Products Settings ------------------*/

	$product_comparison_woocommerce_products_padding_top_bottom = get_theme_mod('product_comparison_woocommerce_products_padding_top_bottom');
	if($product_comparison_woocommerce_products_padding_top_bottom != false){
		$product_comparison_woocommerce_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$product_comparison_woocommerce_custom_css .='padding-top: '.esc_attr($product_comparison_woocommerce_products_padding_top_bottom).'!important; padding-bottom: '.esc_attr($product_comparison_woocommerce_products_padding_top_bottom).'!important;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_products_padding_left_right = get_theme_mod('product_comparison_woocommerce_products_padding_left_right');
	if($product_comparison_woocommerce_products_padding_left_right != false){
		$product_comparison_woocommerce_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$product_comparison_woocommerce_custom_css .='padding-left: '.esc_attr($product_comparison_woocommerce_products_padding_left_right).'!important; padding-right: '.esc_attr($product_comparison_woocommerce_products_padding_left_right).'!important;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_products_box_shadow = get_theme_mod('product_comparison_woocommerce_products_box_shadow');
	if($product_comparison_woocommerce_products_box_shadow != false){
		$product_comparison_woocommerce_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
				$product_comparison_woocommerce_custom_css .='box-shadow: '.esc_attr($product_comparison_woocommerce_products_box_shadow).'px '.esc_attr($product_comparison_woocommerce_products_box_shadow).'px '.esc_attr($product_comparison_woocommerce_products_box_shadow).'px #ddd;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_products_border_radius = get_theme_mod('product_comparison_woocommerce_products_border_radius');
	if($product_comparison_woocommerce_products_border_radius != false){
		$product_comparison_woocommerce_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
			$product_comparison_woocommerce_custom_css .='border-radius: '.esc_attr($product_comparison_woocommerce_products_border_radius).'px;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_products_btn_padding_top_bottom = get_theme_mod('product_comparison_woocommerce_products_btn_padding_top_bottom');
	if($product_comparison_woocommerce_products_btn_padding_top_bottom != false){
		$product_comparison_woocommerce_custom_css .='.woocommerce a.button{';
			$product_comparison_woocommerce_custom_css .='padding-top: '.esc_attr($product_comparison_woocommerce_products_btn_padding_top_bottom).' !important; padding-bottom: '.esc_attr($product_comparison_woocommerce_products_btn_padding_top_bottom).' !important;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_products_btn_padding_left_right = get_theme_mod('product_comparison_woocommerce_products_btn_padding_left_right');
	if($product_comparison_woocommerce_products_btn_padding_left_right != false){
		$product_comparison_woocommerce_custom_css .='.woocommerce a.button{';
			$product_comparison_woocommerce_custom_css .='padding-left: '.esc_attr($product_comparison_woocommerce_products_btn_padding_left_right).' !important; padding-right: '.esc_attr($product_comparison_woocommerce_products_btn_padding_left_right).' !important;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_products_button_border_radius = get_theme_mod('product_comparison_woocommerce_products_button_border_radius', 0);
	if($product_comparison_woocommerce_products_button_border_radius != false){
		$product_comparison_woocommerce_custom_css .='.woocommerce ul.products li.product .button, a.checkout-button.button.alt.wc-forward,.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt,.woocommerce a.button{';
			$product_comparison_woocommerce_custom_css .='border-radius: '.esc_attr($product_comparison_woocommerce_products_button_border_radius).'px !important;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_woocommerce_sale_position = get_theme_mod( 'product_comparison_woocommerce_woocommerce_sale_position','right');
    if($product_comparison_woocommerce_woocommerce_sale_position == 'left'){
		$product_comparison_woocommerce_custom_css .='.woocommerce ul.products li.product .onsale{';
			$product_comparison_woocommerce_custom_css .='left: 12px !important; right: auto !important;';
		$product_comparison_woocommerce_custom_css .='}';
	}else if($product_comparison_woocommerce_woocommerce_sale_position == 'right'){
		$product_comparison_woocommerce_custom_css .='.woocommerce ul.products li.product .onsale{';
			$product_comparison_woocommerce_custom_css .='left: auto!important; right: 0 !important;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_woocommerce_sale_font_size = get_theme_mod('product_comparison_woocommerce_woocommerce_sale_font_size');
	if($product_comparison_woocommerce_woocommerce_sale_font_size != false){
		$product_comparison_woocommerce_custom_css .='.woocommerce span.onsale{';
			$product_comparison_woocommerce_custom_css .='font-size: '.esc_attr($product_comparison_woocommerce_woocommerce_sale_font_size).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_woocommerce_sale_padding_top_bottom = get_theme_mod('product_comparison_woocommerce_woocommerce_sale_padding_top_bottom');
	if($product_comparison_woocommerce_woocommerce_sale_padding_top_bottom != false){
		$product_comparison_woocommerce_custom_css .='.woocommerce span.onsale{';
			$product_comparison_woocommerce_custom_css .='padding-top: '.esc_attr($product_comparison_woocommerce_woocommerce_sale_padding_top_bottom).'; padding-bottom: '.esc_attr($product_comparison_woocommerce_woocommerce_sale_padding_top_bottom).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_woocommerce_sale_padding_left_right = get_theme_mod('product_comparison_woocommerce_woocommerce_sale_padding_left_right');
	if($product_comparison_woocommerce_woocommerce_sale_padding_left_right != false){
		$product_comparison_woocommerce_custom_css .='.woocommerce span.onsale{';
			$product_comparison_woocommerce_custom_css .='padding-left: '.esc_attr($product_comparison_woocommerce_woocommerce_sale_padding_left_right).'; padding-right: '.esc_attr($product_comparison_woocommerce_woocommerce_sale_padding_left_right).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_woocommerce_sale_border_radius = get_theme_mod('product_comparison_woocommerce_woocommerce_sale_border_radius', 0);
	if($product_comparison_woocommerce_woocommerce_sale_border_radius != false){
		$product_comparison_woocommerce_custom_css .='.woocommerce span.onsale{';
			$product_comparison_woocommerce_custom_css .='border-radius: '.esc_attr($product_comparison_woocommerce_woocommerce_sale_border_radius).'px;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	/*----------------Social Icons Settings ------------------*/

	$product_comparison_woocommerce_social_icon_font_size = get_theme_mod('product_comparison_woocommerce_social_icon_font_size');
	if($product_comparison_woocommerce_social_icon_font_size != false){
		$product_comparison_woocommerce_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$product_comparison_woocommerce_custom_css .='font-size: '.esc_attr($product_comparison_woocommerce_social_icon_font_size).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_social_icon_padding = get_theme_mod('product_comparison_woocommerce_social_icon_padding');
	if($product_comparison_woocommerce_social_icon_padding != false){
		$product_comparison_woocommerce_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$product_comparison_woocommerce_custom_css .='padding: '.esc_attr($product_comparison_woocommerce_social_icon_padding).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_social_icon_width = get_theme_mod('product_comparison_woocommerce_social_icon_width');
	if($product_comparison_woocommerce_social_icon_width != false){
		$product_comparison_woocommerce_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$product_comparison_woocommerce_custom_css .='width: '.esc_attr($product_comparison_woocommerce_social_icon_width).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_social_icon_height = get_theme_mod('product_comparison_woocommerce_social_icon_height');
	if($product_comparison_woocommerce_social_icon_height != false){
		$product_comparison_woocommerce_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$product_comparison_woocommerce_custom_css .='height: '.esc_attr($product_comparison_woocommerce_social_icon_height).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_social_icon_border_radius = get_theme_mod('product_comparison_woocommerce_social_icon_border_radius');
	if($product_comparison_woocommerce_social_icon_border_radius != false){
		$product_comparison_woocommerce_custom_css .='#sidebar .custom-social-icons i, #footer .custom-social-icons i{';
			$product_comparison_woocommerce_custom_css .='border-radius: '.esc_attr($product_comparison_woocommerce_social_icon_border_radius).'px;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_resp_menu_toggle_btn_bg_color = get_theme_mod('product_comparison_woocommerce_resp_menu_toggle_btn_bg_color');
	if($product_comparison_woocommerce_resp_menu_toggle_btn_bg_color != false){
		$product_comparison_woocommerce_custom_css .='.toggle-nav i,.sidenav .closebtn, .left-menu .closebtn{';
			$product_comparison_woocommerce_custom_css .='background: '.esc_attr($product_comparison_woocommerce_resp_menu_toggle_btn_bg_color).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_grid_featured_image_box_shadow = get_theme_mod('product_comparison_woocommerce_grid_featured_image_box_shadow',0);
	if($product_comparison_woocommerce_grid_featured_image_box_shadow != false){
		$product_comparison_woocommerce_custom_css .='.grid-post-main-box .box-image img, .grid-post-main-box .feature-box img, #content-vw img{';
			$product_comparison_woocommerce_custom_css .='box-shadow: '.esc_attr($product_comparison_woocommerce_grid_featured_image_box_shadow).'px '.esc_attr($product_comparison_woocommerce_grid_featured_image_box_shadow).'px '.esc_attr($product_comparison_woocommerce_grid_featured_image_box_shadow).'px #cccccc;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	// menus
	$product_comparison_woocommerce_topbar_padding_top_bottom = get_theme_mod('product_comparison_woocommerce_topbar_padding_top_bottom');
	if($product_comparison_woocommerce_topbar_padding_top_bottom != false){
		$product_comparison_woocommerce_custom_css .='#topbar{';
			$product_comparison_woocommerce_custom_css .='padding-top: '.esc_attr($product_comparison_woocommerce_topbar_padding_top_bottom).'; padding-bottom: '.esc_attr($product_comparison_woocommerce_topbar_padding_top_bottom).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_navigation_menu_font_size = get_theme_mod('product_comparison_woocommerce_navigation_menu_font_size');
	if($product_comparison_woocommerce_navigation_menu_font_size != false){
		$product_comparison_woocommerce_custom_css .='.main-navigation a{';
			$product_comparison_woocommerce_custom_css .='font-size: '.esc_attr($product_comparison_woocommerce_navigation_menu_font_size).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_navigation_menu_font_weight = get_theme_mod('product_comparison_woocommerce_navigation_menu_font_weight','500');
	if($product_comparison_woocommerce_navigation_menu_font_weight != false){
		$product_comparison_woocommerce_custom_css .='.main-navigation a{';
			$product_comparison_woocommerce_custom_css .='font-weight: '.esc_attr($product_comparison_woocommerce_navigation_menu_font_weight).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_theme_lay = get_theme_mod( 'product_comparison_woocommerce_menu_text_transform','Capitalize');
	if($product_comparison_woocommerce_theme_lay == 'Capitalize'){
		$product_comparison_woocommerce_custom_css .='.main-navigation a{';
			$product_comparison_woocommerce_custom_css .='text-transform:Capitalize;';
		$product_comparison_woocommerce_custom_css .='}';
	}
	if($product_comparison_woocommerce_theme_lay == 'Lowercase'){
		$product_comparison_woocommerce_custom_css .='.main-navigation a{';
			$product_comparison_woocommerce_custom_css .='text-transform:Lowercase;';
		$product_comparison_woocommerce_custom_css .='}';
	}
	if($product_comparison_woocommerce_theme_lay == 'Uppercase'){
		$product_comparison_woocommerce_custom_css .='.main-navigation a{';
			$product_comparison_woocommerce_custom_css .='text-transform:Uppercase;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_header_menus_color = get_theme_mod('product_comparison_woocommerce_header_menus_color');
	if($product_comparison_woocommerce_header_menus_color != false){
		$product_comparison_woocommerce_custom_css .='.main-navigation a{';
			$product_comparison_woocommerce_custom_css .='color: '.esc_attr($product_comparison_woocommerce_header_menus_color).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_header_menus_hover_color = get_theme_mod('product_comparison_woocommerce_header_menus_hover_color');
	if($product_comparison_woocommerce_header_menus_hover_color != false){
		$product_comparison_woocommerce_custom_css .='.main-navigation a:hover{';
			$product_comparison_woocommerce_custom_css .='color: '.esc_attr($product_comparison_woocommerce_header_menus_hover_color).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_header_submenus_color = get_theme_mod('product_comparison_woocommerce_header_submenus_color');
	if($product_comparison_woocommerce_header_submenus_color != false){
		$product_comparison_woocommerce_custom_css .='.main-navigation ul ul a{';
			$product_comparison_woocommerce_custom_css .='color: '.esc_attr($product_comparison_woocommerce_header_submenus_color).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_header_submenus_hover_color = get_theme_mod('product_comparison_woocommerce_header_submenus_hover_color');
	if($product_comparison_woocommerce_header_submenus_hover_color != false){
		$product_comparison_woocommerce_custom_css .='.main-navigation ul.sub-menu a:hover{';
			$product_comparison_woocommerce_custom_css .='color: '.esc_attr($product_comparison_woocommerce_header_submenus_hover_color).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_menus_item = get_theme_mod( 'product_comparison_woocommerce_menus_item_style','None');
    if($product_comparison_woocommerce_menus_item == 'None'){
		$product_comparison_woocommerce_custom_css .='.main-navigation a{';
			$product_comparison_woocommerce_custom_css .='';
		$product_comparison_woocommerce_custom_css .='}';
	}else if($product_comparison_woocommerce_menus_item == 'Zoom In'){
		$product_comparison_woocommerce_custom_css .='.main-navigation a:hover{';
			$product_comparison_woocommerce_custom_css .='transition: all 0.3s ease-in-out !important; transform: scale(1.2) !important;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	/*---------------------------Footer Style -------------------*/

	$product_comparison_woocommerce_theme_lay = get_theme_mod( 'product_comparison_woocommerce_footer_template','product_comparison_woocommerce-footer-one');
    if($product_comparison_woocommerce_theme_lay == 'product_comparison_woocommerce-footer-one'){
		$product_comparison_woocommerce_custom_css .='#footer{';
			$product_comparison_woocommerce_custom_css .='';
		$product_comparison_woocommerce_custom_css .='}';

	}else if($product_comparison_woocommerce_theme_lay == 'product_comparison_woocommerce-footer-two'){
		$product_comparison_woocommerce_custom_css .='#footer{';
			$product_comparison_woocommerce_custom_css .='background: linear-gradient(to right, #f9f8ff, #dedafa);';
		$product_comparison_woocommerce_custom_css .='}';
		$product_comparison_woocommerce_custom_css .='#footer p, #footer li a, #footer, #footer h3, #footer a.rsswidget, #footer #wp-calendar a, .copyright a, #footer .custom_details, #footer ins span, #footer .tagcloud a, .main-inner-box span.entry-date a, nav.woocommerce-MyAccount-navigation ul li:hover a, #footer ul li a, #footer table, #footer th, #footer td, #footer caption, #sidebar caption,#footer nav.wp-calendar-nav a,#footer .search-form .search-field{';
			$product_comparison_woocommerce_custom_css .='color:#000;';
		$product_comparison_woocommerce_custom_css .='}';
		$product_comparison_woocommerce_custom_css .='#footer ul li::before{';
			$product_comparison_woocommerce_custom_css .='background:#000;';
		$product_comparison_woocommerce_custom_css .='}';
		$product_comparison_woocommerce_custom_css .='#footer table, #footer th, #footer td,#footer .search-form .search-field,#footer .tagcloud a{';
			$product_comparison_woocommerce_custom_css .='border: 1px solid #000;';
		$product_comparison_woocommerce_custom_css .='}';

	}else if($product_comparison_woocommerce_theme_lay == 'product_comparison_woocommerce-footer-three'){
		$product_comparison_woocommerce_custom_css .='#footer{';
			$product_comparison_woocommerce_custom_css .='background: #232524;';
		$product_comparison_woocommerce_custom_css .='}';
	}
	else if($product_comparison_woocommerce_theme_lay == 'product_comparison_woocommerce-footer-four'){
		$product_comparison_woocommerce_custom_css .='#footer{';
			$product_comparison_woocommerce_custom_css .='background: #f7f7f7;';
		$product_comparison_woocommerce_custom_css .='}';
		$product_comparison_woocommerce_custom_css .='#footer p, #footer li a, #footer, #footer h3, #footer a.rsswidget, #footer #wp-calendar a, .copyright a, #footer .custom_details, #footer ins span, #footer .tagcloud a, .main-inner-box span.entry-date a, nav.woocommerce-MyAccount-navigation ul li:hover a, #footer ul li a, #footer table, #footer th, #footer td, #footer caption, #sidebar caption,#footer nav.wp-calendar-nav a,#footer .search-form .search-field{';
			$product_comparison_woocommerce_custom_css .='color:#000;';
		$product_comparison_woocommerce_custom_css .='}';
		$product_comparison_woocommerce_custom_css .='#footer ul li::before{';
			$product_comparison_woocommerce_custom_css .='background:#000;';
		$product_comparison_woocommerce_custom_css .='}';
		$product_comparison_woocommerce_custom_css .='#footer table, #footer th, #footer td,#footer .search-form .search-field,#footer .tagcloud a{';
			$product_comparison_woocommerce_custom_css .='border: 1px solid #000;';
		$product_comparison_woocommerce_custom_css .='}';
	}
	else if($product_comparison_woocommerce_theme_lay == 'product_comparison_woocommerce-footer-five'){
		$product_comparison_woocommerce_custom_css .='#footer{';
			$product_comparison_woocommerce_custom_css .='background: linear-gradient(to right, #01093a, #2d0b00);';
		$product_comparison_woocommerce_custom_css .='}';
	}

	/*---------------- Footer Settings ------------------*/

	$product_comparison_woocommerce_button_footer_heading_letter_spacing = get_theme_mod('product_comparison_woocommerce_button_footer_heading_letter_spacing',1);
	$product_comparison_woocommerce_custom_css .='#footer h3, a.rsswidget.rss-widget-title{';
		$product_comparison_woocommerce_custom_css .='letter-spacing: '.esc_attr($product_comparison_woocommerce_button_footer_heading_letter_spacing).'px;';
	$product_comparison_woocommerce_custom_css .='}';

	$product_comparison_woocommerce_button_footer_font_size = get_theme_mod('product_comparison_woocommerce_button_footer_font_size','30');
	$product_comparison_woocommerce_custom_css .='#footer h3, a.rsswidget.rss-widget-title{';
		$product_comparison_woocommerce_custom_css .='font-size: '.esc_attr($product_comparison_woocommerce_button_footer_font_size).'px;';
	$product_comparison_woocommerce_custom_css .='}';

	$product_comparison_woocommerce_theme_lay = get_theme_mod( 'product_comparison_woocommerce_button_footer_text_transform','Capitalize');
	if($product_comparison_woocommerce_theme_lay == 'Capitalize'){
		$product_comparison_woocommerce_custom_css .='#footer h3{';
			$product_comparison_woocommerce_custom_css .='text-transform:Capitalize;';
		$product_comparison_woocommerce_custom_css .='}';
	}
	if($product_comparison_woocommerce_theme_lay == 'Lowercase'){
		$product_comparison_woocommerce_custom_css .='#footer h3, a.rsswidget.rss-widget-title{';
			$product_comparison_woocommerce_custom_css .='text-transform:Lowercase;';
		$product_comparison_woocommerce_custom_css .='}';
	}
	if($product_comparison_woocommerce_theme_lay == 'Uppercase'){
		$product_comparison_woocommerce_custom_css .='#footer h3, a.rsswidget.rss-widget-title{';
			$product_comparison_woocommerce_custom_css .='text-transform:Uppercase;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	$product_comparison_woocommerce_footer_heading_weight = get_theme_mod('product_comparison_woocommerce_footer_heading_weight','600');
	if($product_comparison_woocommerce_footer_heading_weight != false){
		$product_comparison_woocommerce_custom_css .='#footer h3, a.rsswidget.rss-widget-title{';
			$product_comparison_woocommerce_custom_css .='font-weight: '.esc_attr($product_comparison_woocommerce_footer_heading_weight).';';
		$product_comparison_woocommerce_custom_css .='}';
	}

	// top bar show /hide responsive media

	$product_comparison_woocommerce_responsive_topbar_hide = get_theme_mod('product_comparison_woocommerce_responsive_topbar_hide',false);
	if($product_comparison_woocommerce_responsive_topbar_hide == true && get_theme_mod('product_comparison_woocommerce_topbar_hide_show',false) == false){
		$product_comparison_woocommerce_custom_css .='@media screen and (min-width:575px){
			.topbar{';
			$product_comparison_woocommerce_custom_css .='display:none !important;';
		$product_comparison_woocommerce_custom_css .='} }';
	}

	if($product_comparison_woocommerce_responsive_topbar_hide == false){
		$product_comparison_woocommerce_custom_css .='@media screen and (max-width:575px){
			.topbar{';
			$product_comparison_woocommerce_custom_css .='display:none !important;';
		$product_comparison_woocommerce_custom_css .='} }';
	}

	$product_comparison_woocommerce_responsive_preloader_hide = get_theme_mod('product_comparison_woocommerce_responsive_preloader_hide',false);
	if($product_comparison_woocommerce_responsive_preloader_hide == true && get_theme_mod('product_comparison_woocommerce_loader_enable',false) == false){
		$product_comparison_woocommerce_custom_css .='@media screen and (min-width:575px){
			#preloader{';
			$product_comparison_woocommerce_custom_css .='display:none !important;';
		$product_comparison_woocommerce_custom_css .='} }';
	}

	if($product_comparison_woocommerce_responsive_preloader_hide == false){
		$product_comparison_woocommerce_custom_css .='@media screen and (max-width:575px){
			#preloader{';
			$product_comparison_woocommerce_custom_css .='display:none !important;';
		$product_comparison_woocommerce_custom_css .='} }';
	}

	$product_comparison_woocommerce_breadcrumbs_alignment = get_theme_mod( 'product_comparison_woocommerce_breadcrumbs_alignment','Left');
    if($product_comparison_woocommerce_breadcrumbs_alignment == 'Left'){
    	$product_comparison_woocommerce_custom_css .='@media screen and (min-width:768px) {';
		$product_comparison_woocommerce_custom_css .='.breadcrumbs{';
			$product_comparison_woocommerce_custom_css .='text-align:start;';
		$product_comparison_woocommerce_custom_css .='}}';
	}else if($product_comparison_woocommerce_breadcrumbs_alignment == 'Center'){
		$product_comparison_woocommerce_custom_css .='@media screen and (min-width:768px) {';
		$product_comparison_woocommerce_custom_css .='.breadcrumbs{';
			$product_comparison_woocommerce_custom_css .='text-align:center;';
		$product_comparison_woocommerce_custom_css .='}}';
	}else if($product_comparison_woocommerce_breadcrumbs_alignment == 'Right'){
		$product_comparison_woocommerce_custom_css .='@media screen and (min-width:768px) {';
		$product_comparison_woocommerce_custom_css .='.breadcrumbs{';
			$product_comparison_woocommerce_custom_css .='text-align:end;';
		$product_comparison_woocommerce_custom_css .='}}';
	}

	// sticky sidebar
		$product_comparison_woocommerce_resp_stickysidebar = get_theme_mod( 'product_comparison_woocommerce_stickysidebar_hide_show',false);
	if($product_comparison_woocommerce_resp_stickysidebar == true && get_theme_mod( 'product_comparison_woocommerce_sticky_sidebar',false) != true){
		$product_comparison_woocommerce_custom_css .= '@media (min-width: 768px) {';
    	$product_comparison_woocommerce_custom_css .='#sidebar{';
			$product_comparison_woocommerce_custom_css .='position:static;';
		$product_comparison_woocommerce_custom_css .='} ';
		$product_comparison_woocommerce_custom_css .= '}';
	}
    // First Letter Capital
	$product_comparison_woocommerce_show_first_caps = get_theme_mod('product_comparison_woocommerce_show_first_caps', false);
	if ($product_comparison_woocommerce_show_first_caps ) {
	    $product_comparison_woocommerce_custom_css .= '.post-main-box .new-text p:nth-of-type(1)::first-letter {';
	    $product_comparison_woocommerce_custom_css .=' font-size: 55px;font-weight: 600;margin-right: 5px;';
	    $product_comparison_woocommerce_custom_css .='}';
	} else {
		$product_comparison_woocommerce_custom_css .= '.post-main-box .new-text p:nth-of-type(1)::first-letter {';
	    $product_comparison_woocommerce_custom_css .= 'display: none;';
	    $product_comparison_woocommerce_custom_css .='}';
	}

	// Web Frame 
	$product_comparison_woocommerce_web_frame = get_theme_mod('product_comparison_woocommerce_web_frame',false);
	if($product_comparison_woocommerce_web_frame == false && get_theme_mod( 'product_comparison_woocommerce_web_frame',false) != true){
		$product_comparison_woocommerce_custom_css .='.web-frame{';
		$product_comparison_woocommerce_custom_css .='border: 1px !important';
		$product_comparison_woocommerce_custom_css .='}';
	}
	$product_comparison_woocommerce_web_frame_border_color = get_theme_mod('product_comparison_woocommerce_web_frame_border_color');
	if($product_comparison_woocommerce_web_frame_border_color != false){
		$product_comparison_woocommerce_custom_css .='.web-frame{';
			$product_comparison_woocommerce_custom_css .='border-color: '.esc_attr($product_comparison_woocommerce_web_frame_border_color).'!important;';
		$product_comparison_woocommerce_custom_css .='}';
	}
	$product_comparison_woocommerce_web_frame_border_width = get_theme_mod('product_comparison_woocommerce_web_frame_border_width');
	if($product_comparison_woocommerce_web_frame_border_width != false){
		$product_comparison_woocommerce_custom_css .='.web-frame{';
			$product_comparison_woocommerce_custom_css .='border-width: '.esc_attr($product_comparison_woocommerce_web_frame_border_width).'!important;';
		$product_comparison_woocommerce_custom_css .='}';
	}

	// change the Category style //
	$product_comparison_woocommerce_single_post_styling = get_theme_mod( 'product_comparison_woocommerce_single_post_styling','Button');
		if($product_comparison_woocommerce_single_post_styling == 'Underline'){
		$product_comparison_woocommerce_custom_css .='.single-post-category .post-categories li a{';
			$product_comparison_woocommerce_custom_css .='text-decoration: underline; color: #000; background-color: transparent;';
		$product_comparison_woocommerce_custom_css .='}';
	}
	else if($product_comparison_woocommerce_single_post_styling == 'Default'){
		$product_comparison_woocommerce_custom_css .='.single-post-category .post-categories li a{';
			$product_comparison_woocommerce_custom_css .='text-decoration: none; color: #000; background-color: transparent;';
		$product_comparison_woocommerce_custom_css .='}';
	}
	// Featured hover image effect //
	$product_comparison_woocommerce_show_featured = get_theme_mod( 'product_comparison_woocommerce_featured_image_hide_show', 1 );
	$product_comparison_woocommerce_hover_effect  = get_theme_mod( 'product_comparison_woocommerce_featured_image_hover', 'none' );

	if ( $product_comparison_woocommerce_show_featured && $product_comparison_woocommerce_hover_effect !== 'none' ) {

		$product_comparison_woocommerce_custom_css .= '
		.product-comparison-woocommerce-featured-image img{
			transition: all 0.4s ease;
		}';

		if ( $product_comparison_woocommerce_hover_effect === 'zoom-in' ) {
			$product_comparison_woocommerce_custom_css .= '
			.product-comparison-woocommerce-featured-image:hover img{
				transform: scale(1.2);
			}';
		}

		if ( $product_comparison_woocommerce_hover_effect === 'zoom-out' ) {
			$product_comparison_woocommerce_custom_css .= '
			.product-comparison-woocommerce-featured-image img{
				transform: scale(1.2);
			}
			.product-comparison-woocommerce-featured-image:hover img{
				transform: scale(1);
			}';
		}

		if ( $product_comparison_woocommerce_hover_effect === 'grayscale' ) {
			$product_comparison_woocommerce_custom_css .= '
			.product-comparison-woocommerce-featured-image img{
				filter: grayscale(100%);
			}
			.product-comparison-woocommerce-featured-image:hover img{
				filter: grayscale(0);
			}';
		}

		if ( $product_comparison_woocommerce_hover_effect === 'sepia' ) {
			$product_comparison_woocommerce_custom_css .= '
			.product-comparison-woocommerce-featured-image:hover img{
				filter: sepia(100%);
			}';
		}

		if ( $product_comparison_woocommerce_hover_effect === 'blur' ) {
			$product_comparison_woocommerce_custom_css .= '
			.product-comparison-woocommerce-featured-image:hover img{
				filter: blur(3px);
			}';
		}

		if ( $product_comparison_woocommerce_hover_effect === 'bright' ) {
			$product_comparison_woocommerce_custom_css .= '
			.product-comparison-woocommerce-featured-image:hover img{
				filter: brightness(1.3);
			}';
		}

		if ( $product_comparison_woocommerce_hover_effect === 'translate' ) {
			$product_comparison_woocommerce_custom_css .= '
			.product-comparison-woocommerce-featured-image:hover img{
				transform: translateY(-10px);
			}';
		}
	}
