<?php
require 'wp-load.php';

$dummy_chars = [
    [
        'name' => 'Accelerator',
        'series' => 'A Certain Magical Index',
        'category' => 'ANIME/MANGA',
        'alias' => '',
        'score' => 90,
    ],
    [
        'name' => 'Aerith Gainsborough',
        'series' => 'Final Fantasy VII',
        'category' => 'GAME',
        'alias' => 'Aeris',
        'score' => 97,
    ],
    [
        'name' => 'Agir',
        'series' => 'Azur Lane',
        'category' => 'GAME',
        'alias' => '',
        'score' => 82,
    ],
    [
        'name' => 'Agnes Tachyon',
        'series' => 'Umamusume Pretty Derby',
        'category' => 'GAME',
        'alias' => '',
        'score' => 85,
    ],
    [
        'name' => 'Ahri',
        'series' => 'League of Legends',
        'category' => 'GAME',
        'alias' => 'Ahri',
        'score' => 90,
    ],
    [
        'name' => 'Ai Hayasaka',
        'series' => 'Kaguya-sama: Love Is War',
        'category' => 'ANIME/MANGA',
        'alias' => 'Hayasaka',
        'score' => 85,
    ],
    [
        'name' => 'Batman',
        'series' => 'DC Comics',
        'category' => 'GAME',
        'alias' => 'Bruce Wayne',
        'score' => 99,
    ]
];

foreach ($dummy_chars as $char) {
    // check if exists
    $existing = get_page_by_title($char['name'], OBJECT, 'character');
    if (!$existing) {
        $post_id = wp_insert_post(array(
            'post_type' => 'character',
            'post_title' => $char['name'],
            'post_status' => 'publish',
        ));
        if ($post_id && !is_wp_error($post_id)) {
            update_post_meta($post_id, '_character_series', $char['series']);
            update_post_meta($post_id, '_character_category', $char['category']);
            update_post_meta($post_id, '_character_alias', $char['alias']);
            update_post_meta($post_id, '_character_score', $char['score']);
            echo "Created char: " . $char['name'] . "\n";
        }
    } else {
        echo "Char already exists: " . $char['name'] . "\n";
    }
}
