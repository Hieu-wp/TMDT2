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
require_once ANIMEFIGURE_DIR . '/inc/characters.php';

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
        'myAccountUrl' => wc_get_page_permalink( 'myaccount' ),
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
    $user_id = get_current_user_id();

    if ( ! $user_id ) {
        wp_send_json_error( [ 'message' => 'login_required' ], 401 );
    }

    $wishlist = (array) ( get_user_meta( $user_id, '_wishlist', true ) ?: [] );

    if ( in_array( $product_id, $wishlist ) ) {
        $wishlist = array_values( array_diff( $wishlist, [ $product_id ] ) );
        $action   = 'removed';
    } else {
        $wishlist[] = $product_id;
        $action     = 'added';
    }

    update_user_meta( $user_id, '_wishlist', $wishlist );
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

add_filter( 'woocommerce_registration_generate_username', '__return_true' );
add_filter( 'woocommerce_registration_generate_password', '__return_false' );
add_filter( 'woocommerce_login_redirect', 'animefigure_login_redirect_home' );
add_filter( 'login_redirect', 'animefigure_wp_login_redirect_home', 10, 3 );
add_filter( 'woocommerce_registration_redirect', 'animefigure_registration_redirect' );
add_action( 'woocommerce_created_customer', 'animefigure_store_registration_username', 10, 3 );

function animefigure_login_redirect_home( $redirect ) {
    return home_url( '/' );
}

function animefigure_wp_login_redirect_home( $redirect_to, $requested_redirect_to, $user ) {
    if ( $user instanceof WP_User && user_can( $user, 'manage_options' ) ) {
        return $redirect_to;
    }

    return home_url( '/' );
}

function animefigure_store_registration_username( $customer_id, $new_customer_data, $password_generated ) {
    $user = get_userdata( $customer_id );
    if ( $user ) {
        $GLOBALS['animefigure_registered_username'] = $user->user_login;
    }
}

function animefigure_registration_redirect( $redirect ) {
    $user_login = isset( $GLOBALS['animefigure_registered_username'] ) ? $GLOBALS['animefigure_registered_username'] : '';
    $redirect_url = wc_get_page_permalink( 'myaccount' ) . '?action=login';
    if ( $user_login ) {
        $redirect_url = add_query_arg( 'registered_user', urlencode( $user_login ), $redirect_url );
    }
    return $redirect_url;
}

add_filter( 'authenticate', 'animefigure_allow_email_login', 20, 3 );
function animefigure_allow_email_login( $user, $username, $password ) {
    if ( is_wp_error( $user ) && ! empty( $username ) && is_email( $username ) ) {
        $user_data = get_user_by( 'email', $username );
        if ( $user_data ) {
            $user = wp_authenticate_username_password( null, $user_data->user_login, $password );
        }
    }
    return $user;
}

/**
 * Make sure an entered password is applied when a customer registers.
 * This prevents WooCommerce from generating a different temporary password.
 */
add_action( 'woocommerce_created_customer', 'animefigure_apply_posted_password_to_customer', 10, 3 );
function animefigure_apply_posted_password_to_customer( $customer_id, $new_customer_data, $password_generated ) {
    if ( empty( $_POST['password'] ) ) {
        return;
    }

    $nonce = isset( $_POST['woocommerce-register-nonce'] ) ? wp_unslash( $_POST['woocommerce-register-nonce'] ) : '';
    if ( empty( $nonce ) || ! wp_verify_nonce( $nonce, 'woocommerce-register' ) ) {
        return;
    }

    $password = wp_unslash( $_POST['password'] );
    wp_set_password( $password, intval( $customer_id ) );
}


/**
 * Ensure a Wishlist page exists at /wishlist and uses the `page-wishlist.php` template.
 * This prevents 404 when header links point to /wishlist.
 */
function animefigure_ensure_wishlist_page() {
    // Only run on init in admin or front, cheap checks
    $slug = 'wishlist';
    $page = get_page_by_path( $slug );

    if ( $page ) {
        // If page exists but doesn't have our template, set it
        $current_template = get_post_meta( $page->ID, '_wp_page_template', true );
        if ( 'page-wishlist.php' !== $current_template ) {
            update_post_meta( $page->ID, '_wp_page_template', 'page-wishlist.php' );
        }
        return;
    }

    // Create the page programmatically
    $page_id = wp_insert_post( [
        'post_title'   => 'Wishlist',
        'post_name'    => $slug,
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_content' => '',
    ] );

    if ( ! is_wp_error( $page_id ) && $page_id ) {
        update_post_meta( $page_id, '_wp_page_template', 'page-wishlist.php' );
    }
}
add_action( 'init', 'animefigure_ensure_wishlist_page' );

/**
 * Ensure rewrite rule for /wishlist exists so direct URL resolves even if
 * the Page entry is missing or permalinks behave strangely on local setups.
 * Flush rewrite rules once after adding the rule to apply it.
 */
function animefigure_register_wishlist_rewrite() {
    add_rewrite_rule( '^wishlist/?$', 'index.php?pagename=wishlist', 'top' );

    // Flush rewrite rules once after registering the rule to avoid 404s on fresh installs.
    if ( get_option( 'animefigure_wishlist_rewrite_applied' ) !== '1' ) {
        flush_rewrite_rules( false );
        update_option( 'animefigure_wishlist_rewrite_applied', '1' );
    }
}
add_action( 'init', 'animefigure_register_wishlist_rewrite', 20 );

function animefigure_get_page_url( $slug ) {
    $page = get_page_by_path( $slug );

    if ( $page ) {
        return get_permalink( $page );
    }

    return home_url( '/' . ltrim( $slug, '/' ) . '/' );
}

/**
 * Create core store policy pages with useful starter content.
 */
function animefigure_ensure_static_pages() {
    $created_page = false;
    $pages = [
        'chinh-sach-bao-mat' => [
            'title'   => 'Chính sách bảo mật',
            'content' => '<div class="af-static-page"><p>AnimeFigure cam kết bảo vệ thông tin cá nhân của khách hàng khi mua sắm và sử dụng dịch vụ tại website.</p><h2>Thông tin thu thập</h2><p>Chúng tôi có thể thu thập họ tên, số điện thoại, email, địa chỉ giao hàng và thông tin đơn hàng để xử lý giao dịch, chăm sóc khách hàng và cải thiện dịch vụ.</p><h2>Mục đích sử dụng</h2><p>Thông tin được dùng để xác nhận đơn hàng, giao hàng, bảo hành, gửi thông báo liên quan đến giao dịch và các ưu đãi khi khách hàng đồng ý nhận tin.</p><h2>Bảo mật dữ liệu</h2><p>Dữ liệu khách hàng được lưu trữ trong hệ thống quản trị website và chỉ được truy cập bởi nhân sự có trách nhiệm xử lý đơn hàng hoặc hỗ trợ khách hàng.</p><h2>Quyền của khách hàng</h2><p>Khách hàng có thể yêu cầu kiểm tra, cập nhật hoặc xóa thông tin cá nhân bằng cách liên hệ hello@animefigure.vn.</p></div>',
        ],
        'chinh-sach-doi-tra' => [
            'title'   => 'Chính sách đổi trả',
            'content' => '<div class="af-static-page"><p>AnimeFigure hỗ trợ đổi trả nhằm đảm bảo khách hàng nhận đúng sản phẩm và tình trạng đã cam kết.</p><h2>Điều kiện đổi trả</h2><p>Sản phẩm được hỗ trợ đổi trả trong vòng 30 ngày kể từ ngày nhận hàng nếu giao sai mẫu, thiếu phụ kiện, lỗi sản xuất hoặc hư hỏng do vận chuyển.</p><h2>Trường hợp không áp dụng</h2><p>Không áp dụng đổi trả với sản phẩm đã qua sử dụng, mất hộp/phụ kiện, tem bảo hành bị rách hoặc lỗi phát sinh do bảo quản không đúng hướng dẫn.</p><h2>Quy trình xử lý</h2><p>Khách hàng vui lòng gửi mã đơn hàng, hình ảnh/video tình trạng sản phẩm và thông tin liên hệ. AnimeFigure sẽ phản hồi hướng xử lý trong 24-48 giờ làm việc.</p></div>',
        ],
        'chinh-sach-van-chuyen' => [
            'title'   => 'Chính sách vận chuyển',
            'content' => '<div class="af-static-page"><p>AnimeFigure giao hàng toàn quốc thông qua các đối tác vận chuyển uy tín, ưu tiên đóng gói an toàn cho figure và hộp sưu tầm.</p><h2>Thời gian giao hàng</h2><p>Nội thành TP.HCM thường từ 1-2 ngày làm việc. Các tỉnh thành khác thường từ 2-5 ngày làm việc tùy khu vực và điều kiện vận chuyển.</p><h2>Phí vận chuyển</h2><p>Phí vận chuyển được hiển thị khi đặt hàng và có thể thay đổi theo địa chỉ, kích thước sản phẩm hoặc chương trình ưu đãi tại thời điểm mua.</p><h2>Kiểm tra khi nhận hàng</h2><p>Khách hàng nên quay video khi mở kiện hàng để AnimeFigure có cơ sở hỗ trợ nhanh trong trường hợp sản phẩm bị ảnh hưởng trong quá trình vận chuyển.</p></div>',
        ],
        'chinh-sach-bao-hanh' => [
            'title'   => 'Chính sách bảo hành',
            'content' => '<div class="af-static-page"><p>AnimeFigure hỗ trợ bảo hành cho các sản phẩm chính hãng theo điều kiện của nhà sản xuất và tình trạng thực tế của sản phẩm.</p><h2>Phạm vi bảo hành</h2><p>Bảo hành áp dụng cho lỗi sản xuất như thiếu chi tiết, lỗi khớp nối, lỗi sơn nghiêm trọng hoặc phụ kiện không đúng mô tả khi nhận hàng.</p><h2>Thời hạn hỗ trợ</h2><p>Khách hàng nên liên hệ trong vòng 7 ngày sau khi nhận hàng đối với lỗi ngoại quan và trong thời hạn bảo hành được công bố đối với từng sản phẩm cụ thể.</p><h2>Hồ sơ cần cung cấp</h2><p>Vui lòng cung cấp mã đơn hàng, hình ảnh/video lỗi, hộp sản phẩm và phụ kiện liên quan để đội ngũ hỗ trợ kiểm tra.</p></div>',
        ],
        'chinh-sach-thanh-toan' => [
            'title'   => 'Chính sách thanh toán',
            'content' => '<div class="af-static-page"><p>AnimeFigure hỗ trợ nhiều phương thức thanh toán để khách hàng mua sắm thuận tiện và an toàn.</p><h2>Phương thức thanh toán</h2><p>Khách hàng có thể thanh toán khi nhận hàng (COD), chuyển khoản ngân hàng, ví điện tử hoặc cổng thanh toán trực tuyến tùy thời điểm hệ thống hỗ trợ.</p><h2>Xác nhận thanh toán</h2><p>Với đơn chuyển khoản, đơn hàng sẽ được xử lý sau khi AnimeFigure xác nhận giao dịch thành công. Nội dung chuyển khoản nên bao gồm mã đơn hàng hoặc số điện thoại đặt hàng.</p><h2>Hoàn tiền</h2><p>Trường hợp đơn hàng đủ điều kiện hoàn tiền, thời gian xử lý thường từ 3-7 ngày làm việc tùy phương thức thanh toán.</p></div>',
        ],
        'dieu-khoan-su-dung' => [
            'title'   => 'Điều khoản sử dụng',
            'content' => '<div class="af-static-page"><p>Khi truy cập và mua sắm tại AnimeFigure, khách hàng đồng ý tuân thủ các điều khoản sử dụng được công bố trên website.</p><h2>Thông tin sản phẩm</h2><p>AnimeFigure cố gắng hiển thị thông tin, hình ảnh, giá bán và tình trạng hàng chính xác nhất. Một số chi tiết có thể thay đổi theo cập nhật từ nhà sản xuất hoặc nhà phân phối.</p><h2>Đặt hàng và xác nhận</h2><p>Đơn hàng chỉ được xem là hợp lệ sau khi hệ thống ghi nhận thông tin và AnimeFigure xác nhận khả năng cung ứng sản phẩm.</p><h2>Trách nhiệm khách hàng</h2><p>Khách hàng cần cung cấp thông tin liên hệ, địa chỉ giao hàng và thông tin thanh toán chính xác để quá trình xử lý đơn hàng diễn ra thuận lợi.</p><h2>Thay đổi điều khoản</h2><p>AnimeFigure có thể cập nhật điều khoản sử dụng để phù hợp với hoạt động kinh doanh và quy định hiện hành. Phiên bản mới sẽ có hiệu lực khi được đăng tải trên website.</p></div>',
        ],
        'gioi-thieu' => [
            'title'   => 'Giới thiệu',
            'content' => '<div class="af-static-page"><p>AnimeFigure là cửa hàng mô hình anime chính hãng dành cho người sưu tầm tại Việt Nam.</p><h2>Chúng tôi bán gì?</h2><p>Cửa hàng tập trung vào Nendoroid, Scale Figure, Figma, Pop Up Parade, Plushie, Statue và các sản phẩm pre-order từ những thương hiệu uy tín.</p><h2>Cam kết</h2><p>AnimeFigure ưu tiên nguồn hàng rõ ràng, đóng gói cẩn thận, tư vấn đúng nhu cầu và hỗ trợ khách hàng sau mua.</p><h2>Dành cho cộng đồng sưu tầm</h2><p>Chúng tôi mong muốn tạo một nơi mua sắm dễ tin cậy, dễ hỏi và đủ chỉn chu cho cả người mới bắt đầu lẫn nhà sưu tầm lâu năm.</p></div>',
        ],
        'lien-he' => [
            'title'   => 'Liên hệ',
            'content' => '<div class="af-static-page af-contact-page"><p>AnimeFigure luôn sẵn sàng hỗ trợ bạn về đơn hàng, bảo hành, pre-order và tư vấn sản phẩm.</p><div class="af-contact-grid"><div><h2>Thông tin cửa hàng</h2><p><strong>Địa chỉ:</strong> 123 Nguyễn Huệ, Quận 1, TP.HCM, Việt Nam</p><p><strong>Hotline:</strong> 1800-9999</p><p><strong>Email:</strong> hello@animefigure.vn</p><p><strong>Thời gian:</strong> Thứ 2 - Thứ 7: 8:00 - 20:00, Chủ nhật: 9:00 - 17:00</p></div><div><h2>Gửi yêu cầu hỗ trợ</h2><p>Vui lòng gửi email kèm mã đơn hàng nếu bạn cần hỗ trợ đổi trả, bảo hành hoặc kiểm tra trạng thái pre-order.</p><p>Đội ngũ AnimeFigure thường phản hồi trong 24-48 giờ làm việc.</p></div></div></div>',
        ],
    ];

    foreach ( $pages as $slug => $page ) {
        $existing_page = get_page_by_path( $slug );

        if ( $existing_page ) {
            $page_update = [ 'ID' => $existing_page->ID ];

            if ( 'publish' !== $existing_page->post_status ) {
                $page_update['post_status'] = 'publish';
            }

            if ( '' === trim( $existing_page->post_content ) ) {
                $page_update['post_content'] = $page['content'];
            }

            if ( count( $page_update ) > 1 ) {
                wp_update_post( $page_update );
            }
            continue;
        }

        $page_id = wp_insert_post( [
            'post_title'   => $page['title'],
            'post_name'    => $slug,
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => $page['content'],
        ] );

        if ( ! is_wp_error( $page_id ) && $page_id ) {
            $created_page = true;

            if ( 'chinh-sach-bao-mat' === $slug ) {
                update_option( 'wp_page_for_privacy_policy', $page_id );
            }
        }
    }

    if ( $created_page || get_option( 'animefigure_static_pages_rewrite_applied' ) !== '1' ) {
        flush_rewrite_rules( false );
        update_option( 'animefigure_static_pages_rewrite_applied', '1' );
    }
}
add_action( 'init', 'animefigure_ensure_static_pages', 30 );
