<?php
/**
 * Auto Setup Script for TMDT2
 */

// Load WordPress
require_once( dirname( __FILE__ ) . '/wp-load.php' );
require_once( ABSPATH . 'wp-admin/includes/taxonomy.php');

$messages = [];

// 1. Create Pages
$pages_to_create = [
    'Chính sách thanh toán' => 'Thông tin về các hình thức thanh toán (COD, Chuyển khoản, v.v.)',
    'Chính sách vận chuyển' => 'Quy định giao hàng, thời gian và biểu phí vận chuyển.',
    'Điều khoản sử dụng' => 'Quy định sử dụng website.',
    'Giới thiệu' => 'Giới thiệu về cửa hàng và sứ mệnh (về chúng tôi).'
];

$page_ids = [];

foreach ($pages_to_create as $title => $content) {
    $page = get_page_by_title($title);
    if (!$page) {
        $page_id = wp_insert_post([
            'post_title'    => $title,
            'post_content'  => $content,
            'post_status'   => 'publish',
            'post_type'     => 'page',
        ]);
        $messages[] = "Đã tạo trang: " . $title;
        $page_ids[$title] = $page_id;
    } else {
        $messages[] = "Trang đã tồn tại: " . $title;
        $page_ids[$title] = $page->ID;
    }
}

// 2. Create WooCommerce Categories
$categories = ['Chưa phân loại', 'Figma', 'Nendoroid', 'Pop Up Parade', 'Scale Figure', 'Pre-order'];

foreach ($categories as $cat) {
    if (!term_exists($cat, 'product_cat')) {
        wp_insert_term(
            $cat,
            'product_cat',
            [
                'description'=> 'Danh mục ' . $cat,
                'slug' => sanitize_title($cat)
            ]
        );
        $messages[] = "Đã tạo danh mục sản phẩm: " . $cat;
    } else {
        $messages[] = "Danh mục đã tồn tại: " . $cat;
    }
}

// 3. Create Footer Menu
$menu_name = 'Footer Menu';
$menu_exists = wp_get_nav_menu_object($menu_name);

if (!$menu_exists) {
    $menu_id = wp_create_nav_menu($menu_name);
    $messages[] = "Đã tạo Menu: " . $menu_name;

    // Add policy pages to the menu
    $menu_pages = ['Chính sách thanh toán', 'Chính sách vận chuyển', 'Điều khoản sử dụng'];
    foreach ($menu_pages as $mp) {
        if (isset($page_ids[$mp])) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' =>  $mp,
                'menu-item-object-id' => $page_ids[$mp],
                'menu-item-object' => 'page',
                'menu-item-status' => 'publish',
                'menu-item-type' => 'post_type',
            ));
        }
    }
    $messages[] = "Đã thêm các trang chính sách vào Footer Menu.";
} else {
    $messages[] = "Menu đã tồn tại: " . $menu_name;
}

// 4. Create Primary Menu (Menu chính)
$primary_menu_name = 'Menu chính';
$primary_menu_exists = wp_get_nav_menu_object($primary_menu_name);

if (!$primary_menu_exists) {
    $primary_menu_id = wp_create_nav_menu($primary_menu_name);
    $messages[] = "Đã tạo Menu: " . $primary_menu_name;

    // Trang chủ
    wp_update_nav_menu_item($primary_menu_id, 0, [
        'menu-item-title'  => 'Trang chủ',
        'menu-item-url'    => home_url('/'),
        'menu-item-status' => 'publish',
        'menu-item-type'   => 'custom',
    ]);

    // Cửa hàng
    $shop_page_id = function_exists('wc_get_page_id') ? wc_get_page_id('shop') : 0;
    $shop_url = ($shop_page_id > 0) ? get_permalink($shop_page_id) : home_url('/shop');
    wp_update_nav_menu_item($primary_menu_id, 0, [
        'menu-item-title'  => 'Cửa hàng',
        'menu-item-url'    => $shop_url,
        'menu-item-status' => 'publish',
        'menu-item-type'   => 'custom',
    ]);

    // Danh mục
    $danh_muc_item_id = wp_update_nav_menu_item($primary_menu_id, 0, [
        'menu-item-title'  => 'Danh mục',
        'menu-item-url'    => $shop_url,
        'menu-item-status' => 'publish',
        'menu-item-type'   => 'custom',
    ]);

    // Add WooCommerce categories under Danh mục
    $prod_cats = get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
    ]);
    if (!is_wp_error($prod_cats) && !empty($prod_cats)) {
        foreach ($prod_cats as $cat) {
            if ($cat->slug === 'uncategorized' || $cat->name === 'Chưa phân loại') continue;
            wp_update_nav_menu_item($primary_menu_id, 0, [
                'menu-item-title'     => $cat->name,
                'menu-item-object-id' => $cat->term_id,
                'menu-item-object'    => 'product_cat',
                'menu-item-parent-id' => $danh_muc_item_id,
                'menu-item-status'    => 'publish',
                'menu-item-type'      => 'taxonomy',
            ]);
        }
    }
    $messages[] = "Đã thêm danh mục sản phẩm vào Menu chính.";

    // Giới thiệu
    if (isset($page_ids['Giới thiệu'])) {
        wp_update_nav_menu_item($primary_menu_id, 0, [
            'menu-item-title'     => 'Giới thiệu',
            'menu-item-object-id' => $page_ids['Giới thiệu'],
            'menu-item-object'    => 'page',
            'menu-item-status'    => 'publish',
            'menu-item-type'      => 'post_type',
        ]);
    }

    // Assign to primary location
    $locations = get_theme_mod('nav_menu_locations', []);
    $locations['primary'] = $primary_menu_id;
    set_theme_mod('nav_menu_locations', $locations);
    $messages[] = "Đã gán Menu chính vào vị trí primary.";
} else {
    $messages[] = "Menu đã tồn tại: " . $primary_menu_name;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Setup Hoàn Tất</title>
    <style>body { font-family: sans-serif; padding: 20px; } .msg { margin-bottom: 5px; color: #2c3e50; } </style>
</head>
<body>
    <h2>Quá trình thiết lập dữ liệu thành công!</h2>
    <div style="background:#ecf0f1; padding: 15px; border-radius: 5px;">
        <?php foreach($messages as $msg) { echo "<div class='msg'>✓ $msg</div>"; } ?>
    </div>
    <p style="color:red; margin-top:20px;"><strong>Lưu ý:</strong> Hãy xoá file <code>ag-setup.php</code> này để bảo mật.</p>
</body>
</html>
