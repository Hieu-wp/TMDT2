<?php
require 'wp-load.php';

$page_id = 161; // from earlier check
wp_update_post([
    'ID' => $page_id,
    'post_title' => 'Phụ kiện',
    'post_name' => 'phu-kien'
]);

update_post_meta($page_id, '_wp_page_template', 'page-phu-kien.php');

echo "Page 161 renamed to Phụ kiện (slug: phu-kien) and assigned template page-phu-kien.php.\n";
flush_rewrite_rules(true);
