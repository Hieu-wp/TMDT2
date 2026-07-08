<?php
require 'wp-load.php';

// Cập nhật lại đường dẫn slug của trang Shop nếu chưa được cập nhật chính xác
$shop_page_id = get_option('woocommerce_shop_page_id');
if ($shop_page_id) {
    wp_update_post([
        'ID' => $shop_page_id,
        'post_name' => 'mo-hinh'
    ]);
}

// Cập nhật cài đặt đường dẫn tĩnh (permalinks) cho WooCommerce Product Base
// Thường thì base của product cũng cần thiết lập lại nếu muốn đồng bộ
// Nhưng ở đây chỉ cần flush rewrite rules
flush_rewrite_rules(true);
echo 'Permalinks flushed.';
