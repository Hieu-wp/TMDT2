<?php
require 'wp-load.php';
$locations = get_nav_menu_locations();
if(isset($locations['primary'])) {
    $menu = wp_get_nav_menu_object($locations['primary']);
    $items = wp_get_nav_menu_items($menu->term_id);
    $danh_muc_id = 0;
    
    // Find "Danh mục"
    foreach($items as $item) {
        if(strtolower(trim($item->title)) == 'danh mục' || strtolower(trim($item->title)) == 'danh muc') {
            $danh_muc_id = $item->ID;
            
            // Change its URL to # so it doesn't navigate
            update_post_meta($item->ID, '_menu_item_url', '#');
            break;
        }
    }
    
    if($danh_muc_id > 0) {
        // Add Sub-items
        $sub_items = [
            'Pre order' => home_url('/product-category/pre-order/'),
            'Mô hình' => home_url('/product-category/mo-hinh/'),
            'Phụ kiện' => home_url('/product-category/phu-kien/')
        ];
        
        foreach($sub_items as $title => $url) {
            // Check if it already exists
            $exists = false;
            foreach($items as $existing_item) {
                if($existing_item->menu_item_parent == $danh_muc_id && $existing_item->title == $title) {
                    $exists = true;
                    break;
                }
            }
            if(!$exists) {
                wp_update_nav_menu_item($menu->term_id, 0, array(
                    'menu-item-title' => $title,
                    'menu-item-url' => $url, 
                    'menu-item-status' => 'publish',
                    'menu-item-parent-id' => $danh_muc_id
                ));
            }
        }
        echo "Successfully updated Danh muc menu!\n";
    } else {
        echo "Could not find Danh muc menu item.\n";
    }
}
