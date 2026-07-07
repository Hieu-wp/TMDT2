<?php
require 'wp-load.php';
$pages = get_pages();
foreach($pages as $p) {
    if(stripos($p->post_title, 'Character') !== false) {
        $template = get_post_meta($p->ID, '_wp_page_template', true);
        echo "Page ID: {$p->ID} - Title: {$p->post_title} - Template: {$template}\n";
    }
}
