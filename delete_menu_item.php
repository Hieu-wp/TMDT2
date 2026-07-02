<?php
require 'wp-load.php';
$menus = wp_get_nav_menus();
foreach($menus as $menu) {
    $items = wp_get_nav_menu_items($menu->term_id);
    foreach($items as $item) {
        if ($item->title == 'Trang mẫu') {
            wp_delete_post($item->ID, true);
            echo "Deleted Trang mau from menu " . $menu->name . "\n";
        }
    }
}
echo "Done";
