<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// 1. Register Custom Post Type
function animefigure_register_character_cpt() {
    $labels = array(
        'name'                  => _x( 'Nhân vật', 'Post type general name', 'animefigure' ),
        'singular_name'         => _x( 'Nhân vật', 'Post type singular name', 'animefigure' ),
        'menu_name'             => _x( 'Nhân vật', 'Admin Menu text', 'animefigure' ),
        'name_admin_bar'        => _x( 'Nhân vật', 'Add New on Toolbar', 'animefigure' ),
        'add_new'               => __( 'Thêm mới', 'animefigure' ),
        'add_new_item'          => __( 'Thêm Nhân vật mới', 'animefigure' ),
        'new_item'              => __( 'Nhân vật mới', 'animefigure' ),
        'edit_item'             => __( 'Sửa Nhân vật', 'animefigure' ),
        'view_item'             => __( 'Xem Nhân vật', 'animefigure' ),
        'all_items'             => __( 'Tất cả Nhân vật', 'animefigure' ),
        'search_items'          => __( 'Tìm Nhân vật', 'animefigure' ),
        'not_found'             => __( 'Không tìm thấy.', 'animefigure' ),
        'not_found_in_trash'    => __( 'Không tìm thấy trong thùng rác.', 'animefigure' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'character' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-groups',
        'supports'           => array( 'title', 'thumbnail' ),
    );

    register_post_type( 'character', $args );
}
add_action( 'init', 'animefigure_register_character_cpt' );

// 2. Add Meta Boxes
function animefigure_character_meta_boxes() {
    add_meta_box(
        'character_details',
        __( 'Thông tin chi tiết Nhân vật', 'animefigure' ),
        'animefigure_character_meta_box_callback',
        'character',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'animefigure_character_meta_boxes' );

function animefigure_character_meta_box_callback( $post ) {
    wp_nonce_field( 'animefigure_save_character_meta', 'animefigure_character_meta_nonce' );

    $series = get_post_meta( $post->ID, '_character_series', true );
    $category = get_post_meta( $post->ID, '_character_category', true );
    $alias = get_post_meta( $post->ID, '_character_alias', true );
    $score = get_post_meta( $post->ID, '_character_score', true );

    echo '<table class="form-table">';
    
    // Series
    echo '<tr>';
    echo '<th><label for="character_series">Series</label></th>';
    echo '<td><input type="text" id="character_series" name="character_series" value="' . esc_attr( $series ) . '" size="25" /></td>';
    echo '</tr>';

    // Category
    echo '<tr>';
    echo '<th><label for="character_category">Category</label></th>';
    echo '<td>
        <select id="character_category" name="character_category">
            <option value="ANIME/MANGA" ' . selected( $category, 'ANIME/MANGA', false ) . '>ANIME/MANGA</option>
            <option value="GAME" ' . selected( $category, 'GAME', false ) . '>GAME</option>
        </select>
    </td>';
    echo '</tr>';

    // Alias
    echo '<tr>';
    echo '<th><label for="character_alias">Tên gọi khác (Alias)</label></th>';
    echo '<td><input type="text" id="character_alias" name="character_alias" value="' . esc_attr( $alias ) . '" size="25" /></td>';
    echo '</tr>';

    // Score
    echo '<tr>';
    echo '<th><label for="character_score">Điểm số/Số lượng</label></th>';
    echo '<td><input type="number" id="character_score" name="character_score" value="' . esc_attr( $score ) . '" size="10" /></td>';
    echo '</tr>';

    echo '</table>';
}

// 3. Save Meta Box Data
function animefigure_save_character_meta( $post_id ) {
    if ( ! isset( $_POST['animefigure_character_meta_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['animefigure_character_meta_nonce'], 'animefigure_save_character_meta' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['character_series'] ) ) {
        update_post_meta( $post_id, '_character_series', sanitize_text_field( $_POST['character_series'] ) );
    }
    if ( isset( $_POST['character_category'] ) ) {
        update_post_meta( $post_id, '_character_category', sanitize_text_field( $_POST['character_category'] ) );
    }
    if ( isset( $_POST['character_alias'] ) ) {
        update_post_meta( $post_id, '_character_alias', sanitize_text_field( $_POST['character_alias'] ) );
    }
    if ( isset( $_POST['character_score'] ) ) {
        update_post_meta( $post_id, '_character_score', intval( $_POST['character_score'] ) );
    }
}
add_action( 'save_post', 'animefigure_save_character_meta' );

// 4. Customize Breadcrumb & Title for Character search page
add_filter( 'woocommerce_get_breadcrumb', 'animefigure_custom_char_breadcrumb', 10, 2 );
function animefigure_custom_char_breadcrumb( $crumbs, $breadcrumb ) {
    if ( is_search() && isset( $_GET['from_char'] ) && isset( $_GET['post_type'] ) && $_GET['post_type'] === 'product' ) {
        // Change "Cửa hàng" (Shop) to "Nhân vật"
        if ( isset( $crumbs[1] ) ) {
            $crumbs[1][0] = 'Nhân vật';
            $crumbs[1][1] = home_url( '/nhan-vat/' );
        }
        // Change "Kết quả tìm kiếm cho..." to character name
        if ( isset( $crumbs[2] ) ) {
            $char_name = sanitize_text_field( $_GET['s'] );
            $crumbs[2][0] = $char_name;
        }
    }
    return $crumbs;
}

add_filter( 'woocommerce_page_title', 'animefigure_custom_char_page_title' );
function animefigure_custom_char_page_title( $title ) {
    if ( is_search() && isset( $_GET['from_char'] ) ) {
        $title = 'Nhân vật: ' . sanitize_text_field( $_GET['s'] );
    }
    return $title;
}

// 5. Fix Active Menu Item for Character search page
add_filter( 'nav_menu_css_class', 'animefigure_custom_char_menu_classes', 10, 3 );
function animefigure_custom_char_menu_classes( $classes, $item, $args ) {
    if ( is_search() && isset( $_GET['from_char'] ) && isset( $_GET['post_type'] ) && $_GET['post_type'] === 'product' ) {
        // Remove active class from "Cửa hàng" (Shop page)
        if ( function_exists('wc_get_page_id') && $item->object === 'page' && $item->object_id == wc_get_page_id( 'shop' ) ) {
            $classes = array_diff( $classes, array( 'current_page_parent', 'current-menu-item', 'current-menu-parent', 'current_page_ancestor', 'current-menu-ancestor' ) );
        }
        
        // Add active class to "Nhân vật" page (Page ID 156 or checking title)
        if ( $item->object === 'page' && ($item->object_id == 156 || $item->title === 'Nhân vật' || $item->title === 'Character List') ) {
            $classes[] = 'current-menu-item';
            $classes[] = 'current_page_item';
        }
    }
    return $classes;
}
