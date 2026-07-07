<?php
/**
 * AnimeFigure Store - functions.php
 * Khởi tạo theme, enqueue scripts/styles
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'ANIMEFIGURE_VERSION', '1.0.0' );
define( 'ANIMEFIGURE_DIR', get_template_directory() );
define( 'ANIMEFIGURE_URI', get_template_directory_uri() );

/* =========================================================
   THEME SETUP
   ========================================================= */
function animefigure_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
    add_theme_support( 'custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-width'  => true,
        'flex-height' => true,
    ] );

    register_nav_menus( [
        'primary'  => __( 'Menu chính', 'animefigure' ),
        'footer'   => __( 'Menu footer', 'animefigure' ),
        'topbar'   => __( 'Menu topbar', 'animefigure' ),
    ] );

    load_theme_textdomain( 'animefigure', ANIMEFIGURE_DIR . '/languages' );
}
add_action( 'after_setup_theme', 'animefigure_setup' );

/* =========================================================
   ENQUEUE ASSETS
   ========================================================= */
function animefigure_enqueue_assets() {
    // Google Fonts
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap',
        [],
        null
    );

    // Main stylesheet
    wp_enqueue_style(
        'animefigure-style',
        get_stylesheet_uri(),
        [ 'google-fonts' ],
        ANIMEFIGURE_VERSION
    );

    // Swiper for product sliders
    wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], '11.0' );
    wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], '11.0', true );

    // Main JS
    wp_enqueue_script(
        'animefigure-main',
        ANIMEFIGURE_URI . '/assets/js/main.js',
        [ 'jquery', 'swiper-js' ],
        ANIMEFIGURE_VERSION,
        true
    );

    // Localize script
    wp_localize_script( 'animefigure-main', 'animeStore', [
        'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
        'nonce'     => wp_create_nonce( 'animefigure_nonce' ),
        'siteUrl'   => get_site_url(),
        'currency'  => get_woocommerce_currency_symbol(),
    ] );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'animefigure_enqueue_assets' );

/* =========================================================
   WIDGET AREAS
   ========================================================= */
function animefigure_widgets_init() {
    $sidebars = [
        [ 'name' => __( 'Sidebar chính', 'animefigure' ), 'id' => 'sidebar-main' ],
        [ 'name' => __( 'Sidebar Cửa Hàng', 'animefigure' ), 'id' => 'sidebar-shop' ],
        [ 'name' => __( 'Footer Cột 1', 'animefigure' ), 'id' => 'footer-1' ],
        [ 'name' => __( 'Footer Cột 2', 'animefigure' ), 'id' => 'footer-2' ],
        [ 'name' => __( 'Footer Cột 3', 'animefigure' ), 'id' => 'footer-3' ],
        [ 'name' => __( 'Footer Cột 4', 'animefigure' ), 'id' => 'footer-4' ],
    ];

    foreach ( $sidebars as $sidebar ) {
        register_sidebar( [
            'name'          => $sidebar['name'],
            'id'            => $sidebar['id'],
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ] );
    }
}
add_action( 'widgets_init', 'animefigure_widgets_init' );

/* =========================================================
   WOOCOMMERCE LAYOUT
   ========================================================= */
// Remove default WooCommerce wrappers
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
// Remove default WooCommerce sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// Add custom wrappers
add_action( 'woocommerce_before_main_content', 'animefigure_wrapper_start', 10 );
function animefigure_wrapper_start() {
    echo '<div class="container shop-container" style="padding-top: 40px; padding-bottom: 60px; display: flex; gap: 40px; align-items: flex-start;">';
    
    // Print sidebar on the left
    if ( is_active_sidebar( 'sidebar-shop' ) ) {
        echo '<aside class="shop-sidebar" style="flex: 0 0 280px; position: sticky; top: 100px;">';
        dynamic_sidebar( 'sidebar-shop' );
        echo '</aside>';
    }

    echo '<div class="shop-main-content" style="flex: 1; min-width: 0;">';
}

add_action( 'woocommerce_after_main_content', 'animefigure_wrapper_end', 10 );
function animefigure_wrapper_end() {
    echo '</div>'; // End shop-main-content
    echo '</div>'; // End container
}


/* =========================================================
   HELPER FUNCTIONS
   ========================================================= */

/**
 * Render star rating HTML
 */
function animefigure_star_rating( $rating = 4.5, $count = 0 ) {
    $html = '<div class="star-rating">';
    for ( $i = 1; $i <= 5; $i++ ) {
        if ( $rating >= $i ) {
            $html .= '<span class="star">★</span>';
        } elseif ( $rating >= $i - 0.5 ) {
            $html .= '<span class="star">★</span>';
        } else {
            $html .= '<span class="star-empty">★</span>';
        }
    }
    $html .= '</div>';
    if ( $count > 0 ) {
        $html .= '<span class="rating-count">(' . $count . ')</span>';
    }
    return $html;
}

/**
 * Render product badge
 */
function animefigure_product_badge( $product ) {
    $html = '<div class="product-badge">';
    if ( $product->is_on_sale() ) {
        $html .= '<span class="badge badge-sale">Sale</span>';
    }
    if ( 'new' === get_post_meta( $product->get_id(), '_product_status', true ) ) {
        $html .= '<span class="badge badge-new">New</span>';
    }
    if ( 'preorder' === get_post_meta( $product->get_id(), '_product_status', true ) ) {
        $html .= '<span class="badge badge-preorder">Pre-order</span>';
    }
    if ( 'limited' === get_post_meta( $product->get_id(), '_product_status', true ) ) {
        $html .= '<span class="badge badge-limited">Limited</span>';
    }
    $html .= '</div>';
    return $html;
}

/**
 * Format VND price
 */
function animefigure_format_price( $price ) {
    return number_format( $price, 0, ',', '.' ) . '₫';
}

/**
 * Get featured products
 */
function animefigure_get_featured_products( $limit = 10, $category = '' ) {
    $args = [
        'post_type'      => 'product',
        'posts_per_page' => $limit,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];
    if ( $category ) {
        $args['tax_query'] = [[
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $category,
        ]];
    }
    return new WP_Query( $args );
}

/**
 * Get best sellers
 */
function animefigure_get_bestsellers( $limit = 10 ) {
    $args = [
        'post_type'      => 'product',
        'posts_per_page' => $limit,
        'post_status'    => 'publish',
        'meta_key'       => 'total_sales',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
    ];
    return new WP_Query( $args );
}

/* =========================================================
   AJAX WISHLIST
   ========================================================= */
function animefigure_toggle_wishlist() {
    check_ajax_referer( 'animefigure_nonce', 'nonce' );
    $product_id = intval( $_POST['product_id'] ?? 0 );
    $wishlist   = (array) ( get_user_meta( get_current_user_id(), '_wishlist', true ) ?: [] );

    if ( in_array( $product_id, $wishlist ) ) {
        $wishlist = array_diff( $wishlist, [ $product_id ] );
        $action   = 'removed';
    } else {
        $wishlist[] = $product_id;
        $action     = 'added';
    }

    update_user_meta( get_current_user_id(), '_wishlist', $wishlist );
    wp_send_json_success( [ 'action' => $action, 'count' => count( $wishlist ) ] );
}
add_action( 'wp_ajax_animefigure_wishlist', 'animefigure_toggle_wishlist' );
add_action( 'wp_ajax_nopriv_animefigure_wishlist', 'animefigure_toggle_wishlist' );

/* =========================================================
   CUSTOM EXCERPT LENGTH
   ========================================================= */
function animefigure_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'animefigure_excerpt_length' );

/* =========================================================
   WOOCOMMERCE TWEAKS
   ========================================================= */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

add_action( 'woocommerce_before_main_content', function() {
    echo '<main class="wc-main"><div class="container">';
}, 10 );

add_action( 'woocommerce_after_main_content', function() {
    echo '</div></main>';
}, 10 );

// Custom loop columns
add_filter( 'loop_shop_columns', function() { return 4; } );

// Change products per page
add_filter( 'loop_shop_per_page', function() { return 20; } );

/* =========================================================
   ADD "BUY NOW" BUTTON TO SINGLE PRODUCT
   ========================================================= */
add_action( 'woocommerce_after_add_to_cart_button', 'animefigure_add_buy_now_button' );
function animefigure_add_buy_now_button() {
    global $product;
    if ( ! $product || ! $product->is_in_stock() ) return;
    echo '<button type="submit" name="buy_now" value="true" class="button buy-now-btn">Mua ngay</button>';
}

add_filter( 'woocommerce_add_to_cart_redirect', 'animefigure_buy_now_redirect' );
function animefigure_buy_now_redirect( $url ) {
    if ( isset( $_REQUEST['buy_now'] ) && $_REQUEST['buy_now'] ) {
        return wc_get_checkout_url();
    }
    return $url;
}

/* =========================================================
   PRIMARY MENU FALLBACK & AUTO CATEGORY DROPDOWN
   ========================================================= */

/**
 * Fallback menu when no Primary Menu is assigned in WP Admin
 */
function animefigure_primary_menu_fallback() {
    echo '<ul class="navbar-nav">';
    echo '<li class="menu-item"><a href="' . esc_url( home_url( '/' ) ) . '">Trang chủ</a></li>';
    
    $shop_url = function_exists( 'wc_get_page_id' ) && wc_get_page_id( 'shop' ) > 0 ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop' );
    echo '<li class="menu-item"><a href="' . esc_url( $shop_url ) . '">Cửa hàng</a></li>';
    
    echo '<li class="menu-item menu-item-has-children">';
    echo '<a href="' . esc_url( $shop_url ) . '">Danh mục</a>';
    echo '<ul class="sub-menu">';
    
    $product_categories = get_terms( [
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
    ] );
    
    if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
        foreach ( $product_categories as $cat ) {
            if ( $cat->slug === 'uncategorized' || $cat->name === 'Chưa phân loại' ) {
                continue;
            }
            echo '<li class="menu-item"><a href="' . esc_url( get_term_link( $cat ) ) . '">' . esc_html( $cat->name ) . '</a></li>';
        }
    }
    echo '</ul>';
    echo '</li>';

    if ( $about_page = get_page_by_title( 'Giới thiệu' ) ) {
        echo '<li class="menu-item"><a href="' . esc_url( get_permalink( $about_page ) ) . '">Giới thiệu</a></li>';
    }
    if ( $shipping_page = get_page_by_title( 'Chính sách vận chuyển' ) ) {
        echo '<li class="menu-item"><a href="' . esc_url( get_permalink( $shipping_page ) ) . '">Chính sách vận chuyển</a></li>';
    }
    echo '</ul>';
}

/**
 * Automatically inject "Danh mục" dropdown with product categories into WP Nav Menu if needed
 */
add_filter( 'wp_nav_menu_objects', 'animefigure_auto_category_dropdown', 10, 2 );
function animefigure_auto_category_dropdown( $sorted_menu_items, $args ) {
    if ( ! isset( $args->theme_location ) || $args->theme_location !== 'primary' ) {
        return $sorted_menu_items;
    }

    $found_danh_muc = false;
    $danh_muc_id    = 0;

    foreach ( $sorted_menu_items as $item ) {
        if ( stripos( $item->title, 'Danh mục' ) !== false || stripos( $item->title, 'Sản phẩm' ) !== false || stripos( $item->title, 'Mô hình' ) !== false ) {
            $found_danh_muc  = true;
            $danh_muc_id     = $item->ID;
            if ( ! in_array( 'menu-item-has-children', (array) $item->classes ) ) {
                $item->classes[] = 'menu-item-has-children';
            }
            break;
        }
    }

    // If no "Danh mục" item exists in the primary menu, inject one after position 1
    if ( ! $found_danh_muc ) {
        $danh_muc_id   = -9999;
        $shop_url      = function_exists( 'wc_get_page_id' ) && wc_get_page_id( 'shop' ) > 0 ? get_permalink( wc_get_page_id( 'shop' ) ) : '#';
        $danh_muc_item = (object) [
            'ID'                    => $danh_muc_id,
            'db_id'                 => $danh_muc_id,
            'menu_item_parent'      => 0,
            'object_id'             => $danh_muc_id,
            'post_parent'           => 0,
            'type'                  => 'custom',
            'object'                => 'custom',
            'type_label'            => 'Custom Link',
            'title'                 => 'Danh mục',
            'url'                   => $shop_url,
            'target'                => '',
            'attr_title'            => '',
            'description'           => '',
            'classes'               => [ 'menu-item', 'menu-item-has-children' ],
            'xfn'                   => '',
            'status'                => 'publish',
            'current'               => false,
            'current_item_ancestor' => false,
            'current_item_parent'   => false,
        ];

        $new_items = [];
        $inserted  = false;
        $pos       = 0;
        foreach ( $sorted_menu_items as $item ) {
            $new_items[] = $item;
            if ( $item->menu_item_parent == 0 ) {
                $pos++;
            }
            if ( $pos === 2 && ! $inserted && $item->menu_item_parent == 0 ) {
                $new_items[] = $danh_muc_item;
                $inserted    = true;
            }
        }
        if ( ! $inserted ) {
            $new_items[] = $danh_muc_item;
        }
        $sorted_menu_items = $new_items;
    }

    // Check if $danh_muc_id already has children in the menu
    $has_existing_children = false;
    foreach ( $sorted_menu_items as $item ) {
        if ( $item->menu_item_parent == $danh_muc_id ) {
            $has_existing_children = true;
            break;
        }
    }

    // If it doesn't have children yet, automatically attach all WooCommerce product categories!
    if ( ! $has_existing_children ) {
        $product_categories = get_terms( [
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
        ] );

        if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
            $cat_id_counter = -10000;
            foreach ( $product_categories as $cat ) {
                if ( $cat->slug === 'uncategorized' || $cat->name === 'Chưa phân loại' ) {
                    continue;
                }

                $cat_item = (object) [
                    'ID'                    => $cat_id_counter,
                    'db_id'                 => $cat_id_counter,
                    'menu_item_parent'      => $danh_muc_id,
                    'object_id'             => $cat->term_id,
                    'post_parent'           => 0,
                    'type'                  => 'taxonomy',
                    'object'                => 'product_cat',
                    'type_label'            => 'Category',
                    'title'                 => $cat->name,
                    'url'                   => get_term_link( $cat ),
                    'target'                => '',
                    'attr_title'            => '',
                    'description'           => '',
                    'classes'               => [ 'menu-item', 'menu-item-type-taxonomy', 'menu-item-object-product_cat' ],
                    'xfn'                   => '',
                    'status'                => 'publish',
                    'current'               => ( is_tax( 'product_cat', $cat->term_id ) ),
                    'current_item_ancestor' => false,
                    'current_item_parent'   => false,
                ];
                $sorted_menu_items[] = $cat_item;
                $cat_id_counter--;
            }
        }
    }

    return $sorted_menu_items;
}
