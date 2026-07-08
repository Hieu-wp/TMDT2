<?php
require 'wp-load.php';
$terms = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
if (empty($terms) || is_wp_error($terms)) {
    echo "No product_cat terms found.\n";
} else {
    foreach($terms as $t) {
        echo "ID: " . $t->term_id . " | Name: " . $t->name . " | Parent: " . $t->parent . "\n";
    }
}

