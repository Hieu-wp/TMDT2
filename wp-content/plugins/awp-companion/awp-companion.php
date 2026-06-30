<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Plugin Name:          A WP Life Themes Companion
 * Plugin URI:           https://wordpress.org/plugins/awp-companion
 * Description:          A WP Life Themes Companion plugin provides awordpresslife themes extra settings for front page.
 * Version:              1.6.0
 * Author:               A WP Life
 * Author URI:           https://awplife.com/
 * Tested up to:         7.0
 * Requires:             4.6 or higher
 * License:              GPLv3 or later
 * License URI:          http://www.gnu.org/licenses/gpl-3.0.html
 * Requires PHP:         5.6
 * Text Domain:          awp-companion
 * Domain Path:          /languages
 */

/*
AWP Companion is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

AWP Companion is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with AWP Companion. If not, see http://www.gnu.org/licenses/gpl-3.0.html.
*/

define('awp_companion_plugin_url', plugin_dir_url(__FILE__));
define('awp_companion_plugin_dir', plugin_dir_path(__FILE__));

if (!function_exists('awp_companion_init')) {
	function awp_companion_init()
	{

		$activate_theme_data = wp_get_theme(); // getting current theme data.
		$activate_theme = $activate_theme_data->name;

		if (
			'AwpBusinessPress' == $activate_theme || 'Coin Market' == $activate_theme
			|| 'Hospital Health Care' == $activate_theme || 'Home Interior' == $activate_theme
			|| 'Business Campaign' == $activate_theme || 'Awp Marketing Agency' == $activate_theme
		) {
			require 'inc/awpbusinesspress/awpbusinesspress.php';
		}
		if (
			'Formula' == $activate_theme || 'Formula Dark' == $activate_theme || 'Formula Light' == $activate_theme ||
			'Metaverse' == $activate_theme || 'Medical Formula' == $activate_theme || 'Education Formula' == $activate_theme ||
			'Nature Formula' == $activate_theme || 'Blog Formula' == $activate_theme
		) {
			require 'inc/formula/formula.php';
		}
		if (
			'Neom Blog' == $activate_theme || 'Neom City' == $activate_theme || 'Neom Blogger' == $activate_theme ||
			'Neom Business' == $activate_theme || 'Neom Dark' == $activate_theme
		) {
			require 'inc/neom/neom.php';
		}

	}
	add_action('init', 'awp_companion_init');
}

// Blog Over: load early on after_setup_theme (priority 5)
// so demo filters are registered before OCDI reads them at priority 10.
if (!function_exists('awp_companion_blog_over_init')) {
	function awp_companion_blog_over_init()
	{
		$activate_theme_data = wp_get_theme();
		$activate_theme = $activate_theme_data->name;

		if ('Blog Over' == $activate_theme || 'Blog Over Dark' == $activate_theme || 'Blog Over Minimal' == $activate_theme) {
			require 'inc/blog-over/blog-over.php';
		}
	}
	add_action('after_setup_theme', 'awp_companion_blog_over_init', 5);
}

// on plugin activation.
function awp_companion_activate()
{
	$activate_theme_data = wp_get_theme(); // getting current theme data.
	$activate_theme = $activate_theme_data->name;

	if ( 'Nature Formula' === $activate_theme || 'Blog Over' === $activate_theme || 'Blog Over Dark' === $activate_theme || 'Blog Over Minimal' === $activate_theme ) {
		return;
	}
	 else {
		require_once plugin_dir_path(__FILE__) . 'inc/awp-companion-activator.php';
		awp_companion_plugin_activator::activate();
	}
}
register_activation_hook(__FILE__, 'awp_companion_activate');
