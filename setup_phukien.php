<?php
require 'wp-load.php';

$term = get_term_by('slug', 'phu-kien', 'product_cat');
if ($term) {
    echo "Phu kien category exists! ID: " . $term->term_id;
} else {
    echo "Phu kien category does NOT exist. Creating it...\n";
    $result = wp_insert_term(
        'Phụ kiện', 
        'product_cat',
        array(
            'description' => 'Các loại phụ kiện mô hình, stand, hộp bảo vệ...',
            'slug'        => 'phu-kien'
        )
    );
    if (!is_wp_error($result)) {
        echo "Created phu-kien category with ID: " . $result['term_id'];
    } else {
        echo "Failed to create category: " . $result->get_error_message();
    }
}
