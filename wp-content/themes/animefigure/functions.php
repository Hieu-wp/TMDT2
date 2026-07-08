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
function animefigure_static_page_specs() {
    return [
        'chinh-sach-bao-mat' => [
            'title' => 'Chính sách bảo mật',
            'focus' => 'bảo mật thông tin cá nhân, dữ liệu đơn hàng và quyền riêng tư của khách hàng',
            'audience' => 'khách hàng mua figure, người đăng ký tài khoản và người liên hệ tư vấn',
        ],
        'chinh-sach-doi-tra' => [
            'title' => 'Chính sách đổi trả',
            'focus' => 'điều kiện đổi trả, quy trình tiếp nhận, bằng chứng cần cung cấp và phương án xử lý sản phẩm',
            'audience' => 'khách hàng đã nhận hàng, khách đặt pre-order và người cần hỗ trợ sau mua',
        ],
        'chinh-sach-van-chuyen' => [
            'title' => 'Chính sách vận chuyển',
            'focus' => 'đóng gói, bàn giao vận chuyển, thời gian giao hàng, phí giao hàng và xử lý rủi ro khi giao nhận',
            'audience' => 'khách hàng đặt hàng trên toàn quốc và người nhận hàng thay',
        ],
        'chinh-sach-bao-hanh' => [
            'title' => 'Chính sách bảo hành',
            'focus' => 'phạm vi bảo hành, lỗi sản xuất, hồ sơ tiếp nhận và cách AnimeFigure phối hợp hỗ trợ',
            'audience' => 'người sưu tầm figure chính hãng và khách hàng cần kiểm tra lỗi sau khi nhận sản phẩm',
        ],
        'chinh-sach-thanh-toan' => [
            'title' => 'Chính sách thanh toán',
            'focus' => 'phương thức thanh toán, xác nhận giao dịch, hoàn tiền, đặt cọc và an toàn thanh toán',
            'audience' => 'khách hàng mua trực tiếp, đặt online, đặt cọc pre-order và thanh toán qua đối tác',
        ],
        'dieu-khoan-su-dung' => [
            'title' => 'Điều khoản sử dụng',
            'focus' => 'quy tắc sử dụng website, trách nhiệm của khách hàng, quyền của cửa hàng và giới hạn dịch vụ',
            'audience' => 'mọi người truy cập website AnimeFigure, tạo tài khoản hoặc phát sinh giao dịch',
        ],
        'gioi-thieu' => [
            'title' => 'Giới thiệu',
            'focus' => 'câu chuyện thương hiệu, định hướng kinh doanh figure chính hãng và cam kết phục vụ cộng đồng sưu tầm',
            'audience' => 'người mới sưu tầm, khách hàng thân thiết và cộng đồng yêu thích anime figure',
        ],
        'lien-he' => [
            'title' => 'Liên hệ',
            'focus' => 'kênh liên hệ, thời gian phản hồi, cách gửi yêu cầu hỗ trợ và thông tin cần chuẩn bị',
            'audience' => 'khách hàng cần tư vấn sản phẩm, kiểm tra đơn hàng, bảo hành hoặc hỗ trợ pre-order',
        ],
    ];
}

function animefigure_static_page_sections( $slug ) {
    $shared = [
        'Mục đích và phạm vi áp dụng',
        'Đối tượng được áp dụng',
        'Nguyên tắc xử lý yêu cầu',
        'Thông tin khách hàng cần chuẩn bị',
        'Quy trình tiếp nhận tại AnimeFigure',
        'Thời gian phản hồi dự kiến',
        'Trường hợp cần xác minh thêm',
        'Trách nhiệm của khách hàng',
        'Trách nhiệm của AnimeFigure',
        'Tiêu chuẩn thông tin và bằng chứng',
        'Các tình huống thường gặp',
        'Trường hợp ngoại lệ',
        'Cách ghi nhận và lưu trữ hồ sơ',
        'Phối hợp với đối tác liên quan',
        'Quy định đối với sản phẩm pre-order',
        'Quy định đối với sản phẩm có sẵn',
        'Quy định đối với sản phẩm khuyến mãi',
        'Quy định đối với quà tặng và phụ kiện',
        'Cách xử lý khi phát sinh sai lệch',
        'Cách xử lý khi khách hàng đổi thông tin',
        'Cam kết minh bạch thông tin',
        'Giới hạn trách nhiệm hợp lý',
        'Khuyến nghị trước khi xác nhận giao dịch',
        'Khuyến nghị sau khi hoàn tất giao dịch',
        'Kênh hỗ trợ chính thức',
        'Bảo lưu và cập nhật chính sách',
        'Ví dụ minh họa trong thực tế',
        'Lưu ý dành cho người mới mua figure',
        'Lưu ý dành cho nhà sưu tầm lâu năm',
        'Tóm tắt quyền lợi và nghĩa vụ',
    ];

    $prefixes = [
        'chinh-sach-bao-mat' => [ 'Dữ liệu cá nhân', 'Bảo mật tài khoản', 'Email và số điện thoại', 'Lịch sử đơn hàng', 'Cookie và phiên truy cập' ],
        'chinh-sach-doi-tra' => [ 'Điều kiện đổi trả', 'Tình trạng hộp sản phẩm', 'Video mở kiện', 'Chi phí phát sinh', 'Phương án đổi sản phẩm' ],
        'chinh-sach-van-chuyen' => [ 'Đóng gói figure', 'Bàn giao vận chuyển', 'Theo dõi vận đơn', 'Khu vực giao hàng', 'Xử lý kiện hàng móp vỡ' ],
        'chinh-sach-bao-hanh' => [ 'Lỗi sản xuất', 'Phụ kiện đi kèm', 'Khớp nối và chi tiết nhỏ', 'Tem và hóa đơn', 'Thẩm định tình trạng sản phẩm' ],
        'chinh-sach-thanh-toan' => [ 'COD', 'Chuyển khoản', 'Ví điện tử', 'Đặt cọc pre-order', 'Hoàn tiền' ],
        'dieu-khoan-su-dung' => [ 'Tài khoản website', 'Nội dung hiển thị', 'Quyền truy cập', 'Giao dịch hợp lệ', 'Hành vi không được phép' ],
        'gioi-thieu' => [ 'Câu chuyện AnimeFigure', 'Sản phẩm chính hãng', 'Đội ngũ tư vấn', 'Cộng đồng sưu tầm', 'Tầm nhìn dịch vụ' ],
        'lien-he' => [ 'Hotline', 'Email hỗ trợ', 'Thông tin đơn hàng', 'Yêu cầu bảo hành', 'Tư vấn pre-order' ],
    ];

    $sections = [];
    foreach ( $prefixes[ $slug ] ?? [] as $prefix ) {
        $sections[] = $prefix;
    }

    return array_slice( array_merge( $sections, $shared ), 0, 18 );
}

function animefigure_build_long_static_content( $slug, $page ) {
    $title = $page['title'];
    $focus = $page['focus'];
    $audience = $page['audience'];
    $sections = animefigure_static_page_sections( $slug );
    $html = '<div class="af-static-page">';
    $html .= '<p>' . esc_html( $title ) . ' này được xây dựng để giải thích rõ ' . esc_html( $focus ) . '. Nội dung áp dụng cho ' . esc_html( $audience ) . ', đồng thời giúp khách hàng hiểu trước các bước cần thực hiện khi mua sắm tại AnimeFigure.</p>';
    $html .= '<p>Vì sản phẩm figure thường có hộp sưu tầm, phụ kiện nhỏ, tình trạng pre-order và giá trị trưng bày cao, AnimeFigure trình bày chính sách theo nhiều mục chi tiết để hạn chế hiểu nhầm. Khách hàng nên đọc kỹ từng phần trước khi đặt hàng, thanh toán, gửi yêu cầu hỗ trợ hoặc cung cấp thông tin cá nhân.</p>';

    foreach ( $sections as $index => $section_title ) {
        $number = $index + 1;
        $html .= '<h2>' . esc_html( $number . '. ' . $section_title ) . '</h2>';
        $html .= '<p>Mục ' . esc_html( $section_title ) . ' là một phần quan trọng trong ' . esc_html( strtolower( $title ) ) . '. Khi áp dụng nội dung này, AnimeFigure luôn ưu tiên cách hiểu rõ ràng, có căn cứ và phù hợp với đặc thù của mô hình anime chính hãng. Khách hàng nên xem đây là hướng dẫn tham khảo chính thức để biết quyền lợi của mình, phạm vi hỗ trợ của cửa hàng và những thông tin cần chuẩn bị trước khi gửi yêu cầu.</p>';
        $html .= '<p>Đối với ' . esc_html( $audience ) . ', việc cung cấp thông tin đầy đủ giúp quá trình xử lý nhanh hơn và giảm khả năng phải bổ sung nhiều lần. Các thông tin như mã đơn hàng, tên sản phẩm, thời điểm đặt hàng, hình ảnh thực tế, video mở kiện, email liên hệ hoặc số điện thoại có thể được yêu cầu tùy tình huống. AnimeFigure chỉ sử dụng các thông tin đó cho mục đích kiểm tra, đối chiếu và hỗ trợ đúng yêu cầu.</p>';
        $html .= '<p>Trong quá trình xử lý ' . esc_html( $focus ) . ', AnimeFigure có thể cần kiểm tra lại lịch sử giao dịch, tình trạng tồn kho, thông tin từ đối tác vận chuyển, thông tin từ nhà phân phối hoặc điều kiện cụ thể của từng sản phẩm. Một số trường hợp đơn giản có thể được phản hồi rất nhanh, nhưng các trường hợp cần thẩm định chi tiết có thể mất thêm thời gian để đảm bảo kết quả cuối cùng công bằng và chính xác.</p>';
        $html .= '<p>Ví dụ, nếu nội dung liên quan đến sản phẩm pre-order, thời gian xử lý thường phụ thuộc vào lịch phát hành, đợt hàng về, thông báo của hãng và tiến độ nhập khẩu. Nếu nội dung liên quan đến sản phẩm có sẵn, AnimeFigure sẽ ưu tiên kiểm tra tình trạng đóng gói, hình ảnh bàn giao và thông tin đơn hàng. Với mỗi tình huống, cửa hàng sẽ cố gắng giải thích lý do xử lý để khách hàng có thể theo dõi dễ dàng.</p>';
        $html .= '<p>Khách hàng cần lưu ý rằng chính sách này không thay thế cho thỏa thuận riêng đã được AnimeFigure xác nhận bằng văn bản, email hoặc tin nhắn chính thức trong những trường hợp đặc biệt. Nếu có điểm chưa rõ, khách hàng nên liên hệ trước khi tự thực hiện các thao tác có thể ảnh hưởng đến quyền lợi, chẳng hạn như tự sửa sản phẩm, bỏ hộp, gửi hàng về sai địa chỉ hoặc chuyển khoản thiếu nội dung xác nhận.</p>';
        $html .= '<p>AnimeFigure khuyến khích khách hàng lưu lại hóa đơn, email xác nhận, ảnh chụp màn hình giao dịch và tình trạng sản phẩm khi nhận hàng. Những dữ liệu này không chỉ giúp bảo vệ quyền lợi của khách hàng mà còn giúp cửa hàng cải thiện quy trình vận hành, đóng gói, tư vấn và chăm sóc sau bán. Mọi phản hồi có thiện chí đều được xem là cơ sở để dịch vụ ngày càng rõ ràng, ổn định và đáng tin cậy hơn.</p>';
    }

    $html .= '<h2>Thông tin liên hệ hỗ trợ</h2>';
    $html .= '<p>Nếu cần làm rõ bất kỳ nội dung nào trong trang này, khách hàng có thể liên hệ AnimeFigure qua hotline 1800-9999 hoặc email hello@animefigure.vn. Khi gửi yêu cầu, vui lòng mô tả ngắn gọn vấn đề, đính kèm mã đơn hàng nếu có và cung cấp hình ảnh hoặc tài liệu liên quan để đội ngũ hỗ trợ có thể kiểm tra chính xác.</p>';
    $html .= '</div>';

    return $html;
}

function animefigure_ensure_static_pages() {
    $created_page = false;
    $content_version = '2026-07-long-static-pages-v2';
    $should_refresh_content = get_option( 'animefigure_static_pages_content_version' ) !== $content_version;
    $pages = animefigure_static_page_specs();

    foreach ( $pages as $slug => $page ) {
        $page['content'] = animefigure_build_long_static_content( $slug, $page );
        $existing_page = get_page_by_path( $slug );

        if ( $existing_page ) {
            $page_update = [ 'ID' => $existing_page->ID ];

            if ( 'publish' !== $existing_page->post_status ) {
                $page_update['post_status'] = 'publish';
            }

            if ( $should_refresh_content || '' === trim( $existing_page->post_content ) ) {
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

    if ( $should_refresh_content ) {
        update_option( 'animefigure_static_pages_content_version', $content_version );
    }
}
add_action( 'init', 'animefigure_ensure_static_pages', 30 );

/* =========================================================
   CUSTOM CHECKOUT FLOW LOGIC
   ========================================================= */

// Dynamically change checkout page title on order-received and order-pay pages to "Thanh toán đơn hàng"
add_filter( 'the_title', 'animefigure_custom_checkout_endpoint_titles', 10, 2 );
function animefigure_custom_checkout_endpoint_titles( $title, $id ) {
    if ( is_admin() ) {
        return $title;
    }
    if ( function_exists( 'is_checkout' ) && is_checkout() && $id === (int) get_option( 'woocommerce_checkout_page_id' ) ) {
        if ( is_wc_endpoint_url( 'order-received' ) ) {
            return 'Thanh toán đơn hàng';
        }
        if ( is_wc_endpoint_url( 'order-pay' ) ) {
            return 'Thanh toán đơn hàng';
        }
    }
    return $title;
}

// Translate "Proceed to checkout" button text to "Tiến hành đặt hàng"
add_filter( 'gettext', 'animefigure_custom_cart_checkout_button_text', 20, 3 );
function animefigure_custom_cart_checkout_button_text( $translated_text, $text, $domain ) {
    if ( 'woocommerce' === $domain ) {
        if ( strcasecmp( $text, 'Proceed to checkout' ) === 0 ) {
            return 'Tiến hành đặt hàng';
        }
    }
    return $translated_text;
}

