<?php
require 'wp-load.php';
$page = get_post(156);
if($page) {
    $page->post_title = 'Nhân vật';
    $page->post_name = 'nhan-vat';
    wp_update_post($page);
    echo "Updated page 156 title and slug.\n";
} else {
    echo "Page not found.\n";
}
