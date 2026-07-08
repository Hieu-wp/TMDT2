<?php
require 'wp-load.php';
$terms = get_terms(['taxonomy' => 'product_brand', 'hide_empty' => false]);
if (empty($terms) || is_wp_error($terms)) {
    echo "No product_brand terms found.\n";
} else {
    foreach($terms as $t) {
        $thumb_id = get_term_meta($t->term_id, 'thumbnail_id', true);
        $img_url = wp_get_attachment_url($thumb_id);
        echo "ID: " . $t->term_id . " | Name: " . $t->name . " | Img: " . ($img_url ?: 'none') . "\n";
    }
}
