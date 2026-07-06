<?php
require 'wp-load.php';

$page_title = '_CHARACTER_LIST';
$page_check = get_page_by_title($page_title);
$page_id = 0;

if (!isset($page_check->ID)) {
    $page_args = array(
        'post_type'    => 'page',
        'post_title'   => $page_title,
        'post_status'  => 'publish',
        'post_author'  => 1,
    );
    $page_id = wp_insert_post($page_args);
    if (!is_wp_error($page_id)) {
        update_post_meta($page_id, '_wp_page_template', 'page-characters.php');
        echo "Created page with ID: $page_id\n";
    } else {
        echo "Failed to create page\n";
        exit;
    }
} else {
    $page_id = $page_check->ID;
    update_post_meta($page_id, '_wp_page_template', 'page-characters.php');
    echo "Page already exists, ID: $page_id\n";
}
