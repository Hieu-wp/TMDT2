<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Blog Over — Companion Module
 *
 * Loads demo content integration and demo preview panel for the Blog Over theme.
 * Does NOT add customizer sections or front-page templates
 * because Blog Over handles those natively in the theme.
 *
 * @package awp-companion
 * @since   1.5.3
 */

// Demo content / OCDI integration.
require awp_companion_plugin_dir . 'inc/blog-over/demo-content/setup.php';

// Demo preview panel is handled by Blog Over Pro plugin.
