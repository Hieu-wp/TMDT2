<?php
require 'wp-load.php';

$page = get_page_by_path('danh-muc');
if ($page) {
    echo "It is a page with ID: " . $page->ID . "\n";
} else {
    echo "No page found with slug 'danh-muc'\n";
}

$category_base = get_option('woocommerce_prepend_category_to_source'); // Not standard
$permalinks = get_option('woocommerce_permalinks');
echo "WooCommerce Permalinks: \n";
print_r($permalinks);

$term = get_term_by('slug', 'danh-muc', 'product_cat');
if ($term) {
    echo "It is a product category term with ID: " . $term->term_id . "\n";
}
