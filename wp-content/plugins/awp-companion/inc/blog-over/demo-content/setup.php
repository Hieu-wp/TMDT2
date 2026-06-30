<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Blog Over — Demo Content Setup (OCDI Integration)
 *
 * Registers demos directly for the Blog Over theme, following
 * the same pattern as other themes.
 *
 * @package awp-companion
 * @since   1.5.3
 */

/**
 * Register demo import files for OCDI.
 *
 * @return array
 */
if (!function_exists('blog_over_starter_sites_import_files')) {

    function blog_over_starter_sites_import_files()
    {

        $demo_url = awp_companion_plugin_url;

        return array(
            array(
                'import_file_name' => esc_html__('Blog Over Default', 'awp-companion'),
                'categories' => array('Free Demos'),
                'import_file_url' => $demo_url . 'inc/blog-over/demo-content/default/blog-over.xml',
                'import_widget_file_url' => $demo_url . 'inc/blog-over/demo-content/default/blog-over.wie',
                'import_customizer_file_url' => $demo_url . 'inc/blog-over/demo-content/default/blog-over.dat',
                'preview_url' => 'https://awplife.com/demo/blog-over/',
                'import_preview_image_url' => $demo_url . 'inc/blog-over/demo-content/default/screenshot.png',
            ),
            array(
                'import_file_name' => esc_html__('Blog Over Dark', 'awp-companion'),
                'categories' => array('Free Demos'),
                'import_file_url' => $demo_url . 'inc/blog-over/demo-content/blog-over-dark/blog-over-dark.xml',
                'import_widget_file_url' => $demo_url . 'inc/blog-over/demo-content/blog-over-dark/blog-over-dark.wie',
                'import_customizer_file_url' => $demo_url . 'inc/blog-over/demo-content/blog-over-dark/blog-over-dark.dat',
                'preview_url' => 'https://awplife.com/demo/blog-over-dark/',
                'import_preview_image_url' => $demo_url . 'inc/blog-over/demo-content/blog-over-dark/screenshot.webp',
            ),
            array(
                'import_file_name' => esc_html__('Blog Over Minimal', 'awp-companion'),
                'categories' => array('Free Demos'),
                'import_file_url' => $demo_url . 'inc/blog-over/demo-content/blog-over-minimal/blog-over-minimal.xml',
                'import_widget_file_url' => $demo_url . 'inc/blog-over/demo-content/blog-over-minimal/blog-over-minimal.wie',
                'import_customizer_file_url' => $demo_url . 'inc/blog-over/demo-content/blog-over-minimal/blog-over-minimal.dat',
                'preview_url' => 'https://awplife.com/demo/blog-over-minimal/',
                'import_preview_image_url' => $demo_url . 'inc/blog-over/demo-content/blog-over-minimal/screenshot.webp',
            ),
            array(
                'import_file_name' => esc_html__('Blog Over Magzine', 'awp-companion'),
                'categories' => array('Pro Demos'),
                'import_file_url' => (defined('BLOG_OVER_PRO_URI') ? BLOG_OVER_PRO_URI : content_url('plugins/blog-over-pro/')) . 'assets/demos/blog-over-magzine/blog-over-magzine.xml',
                'import_widget_file_url' => (defined('BLOG_OVER_PRO_URI') ? BLOG_OVER_PRO_URI : content_url('plugins/blog-over-pro/')) . 'assets/demos/blog-over-magzine/blog-over-magzine.wie',
                'import_customizer_file_url' => (defined('BLOG_OVER_PRO_URI') ? BLOG_OVER_PRO_URI : content_url('plugins/blog-over-pro/')) . 'assets/demos/blog-over-magzine/blog-over-magzine.dat',
                'preview_url' => 'https://awplife.com/demo/blog-over-magzine/',
                'import_preview_image_url' => 'https://awplife.com/wp-content/uploads/2026/03/blog-over-magzine.webp',
            ),
            array(
                'import_file_name' => esc_html__('Blog Over Post', 'awp-companion'),
                'categories' => array('Pro Demos'),
                'import_file_url' => (defined('BLOG_OVER_PRO_URI') ? BLOG_OVER_PRO_URI : content_url('plugins/blog-over-pro/')) . 'assets/demos/blog-over-post/blog-over-post.xml',
                'import_widget_file_url' => (defined('BLOG_OVER_PRO_URI') ? BLOG_OVER_PRO_URI : content_url('plugins/blog-over-pro/')) . 'assets/demos/blog-over-post/blog-over-post.wie',
                'import_customizer_file_url' => (defined('BLOG_OVER_PRO_URI') ? BLOG_OVER_PRO_URI : content_url('plugins/blog-over-pro/')) . 'assets/demos/blog-over-post/blog-over-post.dat',
                'preview_url' => 'https://awplife.com/demo/blog-over-post/',
                'import_preview_image_url' => 'https://awplife.com/wp-content/uploads/2026/03/blog-over-post.webp',
            ),
        );
    }
}
add_filter('pt-ocdi/import_files', 'blog_over_starter_sites_import_files');

/**
 * Post-import actions: assign menus, set static front page, etc.
 *
 * @param array $selected_import Data about the selected demo.
 */
if (!function_exists('blog_over_starter_sites_after_import')) {

    function blog_over_starter_sites_after_import($selected_import)
    {

        // Assign primary menu if it exists.
        $main_menu = get_term_by('name', 'Blog Over Menu', 'nav_menu');
        if (!$main_menu) {
            $main_menu = get_term_by('name', 'Primary Menu', 'nav_menu');
        }
        if ($main_menu) {
            set_theme_mod(
                'nav_menu_locations',
                array(
                    'blog-over-main-menu' => $main_menu->term_id,
                )
            );
        }

        // Blog Over is a blog theme — let's forcefully set "Your homepage displays"
        // as "Your latest posts".
        update_option( 'show_on_front', 'posts' );
        update_option( 'page_on_front', 0 );
        update_option( 'page_for_posts', 0 );
    }
}
add_action('pt-ocdi/after_import', 'blog_over_starter_sites_after_import');


function blog_over_starter_sites_ocdi_css() {
    // Check if the current screen is not the customizer
    if ( is_admin() && !is_customize_preview() ) { 
        $hide_pro_buttons = !defined('BLOG_OVER_PRO_VERSION');
        ?>
        <style>
            <?php if ( $hide_pro_buttons ) : ?>
            .ocdi__gl-item:nth-child(n+4) .ocdi__gl-item-buttons .button-primary {
                display: none !important;
            }
            <?php endif; ?>
            .ocdi .ocdi__theme-about, .ocdi__intro-text {
                display: none;
            }
            .ocdi__gl-item-image-container::after {
                padding-top: 75% !important;
            }
        </style>
    <?php }
}
add_action( 'admin_head', 'blog_over_starter_sites_ocdi_css' );

/**
 * Customize the OCDI admin page for Blog Over.
 *
 * @param array $default_settings OCDI page settings.
 * @return array
 */
if (!function_exists('blog_over_starter_sites_page_setup')) {

    function blog_over_starter_sites_page_setup($default_settings)
    {

        $default_settings['parent_slug'] = 'themes.php';
        $default_settings['page_title'] = esc_html__('Blog Over Demo Import', 'awp-companion');
        $default_settings['menu_title'] = esc_html__('Blog Over Starter Sites', 'awp-companion');
        $default_settings['capability'] = 'import';
        $default_settings['menu_slug'] = 'one-click-demo-import';

        return $default_settings;
    }
}
add_filter('ocdi/plugin_page_setup', 'blog_over_starter_sites_page_setup');

/**
 * Register required plugins for Blog Over demos.
 *
 * @param array $plugins Existing plugin list.
 * @return array
 */
if (!function_exists('blog_over_starter_sites_register_plugins')) {

    function blog_over_starter_sites_register_plugins($plugins)
    {

        $theme_plugins = array(
            array(
                'name' => 'A WP Life Themes Companion',
                'slug' => 'awp-companion',
                'required' => true,
            ),
        );

        return array_merge($plugins, $theme_plugins);
    }
}
add_filter('ocdi/register_plugins', 'blog_over_starter_sites_register_plugins');


