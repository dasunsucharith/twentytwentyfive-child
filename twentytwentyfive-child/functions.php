<?php

/**
 * Twenty Twenty-Five Child Theme functions and definitions
 * Modern News Website - Optimized for Performance
 *
 * @package Twenty Twenty-Five Child
 * @version 2.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}

// TEMPORARY: Comment out the navigation walkers include to test
// require_once get_stylesheet_directory() . '/inc/navigation-walkers.php';

/**
 * Theme Setup
 */
function twentytwentyfive_child_setup()
{
	// Add theme support
	add_theme_support('custom-logo', array(
		'height'      => 60,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	));

	add_theme_support('post-thumbnails');
	add_theme_support('responsive-embeds');
	add_theme_support('wp-block-styles');
	add_theme_support('align-wide');

	// Add custom image sizes for news content
	add_image_size('news-featured', 800, 450, true);
	add_image_size('news-thumbnail', 300, 200, true);
	add_image_size('news-card', 400, 250, true);
}
add_action('after_setup_theme', 'twentytwentyfive_child_setup');

/**
 * Enqueue Scripts and Styles - Performance Optimized
 */
function twentytwentyfive_child_enqueue_assets()
{
	$theme_version = wp_get_theme()->get('Version');

	// Parent theme style
	wp_enqueue_style(
		'twentytwentyfive-parent-style',
		get_template_directory_uri() . '/style.css',
		array(),
		$theme_version
	);

	// Child theme main styles
	wp_enqueue_style(
		'twentytwentyfive-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array('twentytwentyfive-parent-style'),
		$theme_version
	);

	// Google Fonts - Optimized loading with display=swap
	wp_enqueue_style(
		'google-fonts-poppins',
		'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap',
		array(),
		null
	);

	// Main JavaScript file
	wp_enqueue_script(
		'twentytwentyfive-child-main',
		get_stylesheet_directory_uri() . '/assets/js/main.js',
		array(),
		$theme_version,
		true
	);

	// Localize script for AJAX
	wp_localize_script('twentytwentyfive-child-main', 'newsTheme', array(
		'ajaxUrl' => admin_url('admin-ajax.php'),
		'nonce'   => wp_create_nonce('news_theme_nonce')
	));
}
add_action('wp_enqueue_scripts', 'twentytwentyfive_child_enqueue_assets');

/**
 * Register Navigation Menus
 */
function twentytwentyfive_child_register_menus()
{
	register_nav_menus(array(
		'primary'   => __('Primary Navigation', 'twentytwentyfive-child'),
		'secondary' => __('Secondary Navigation', 'twentytwentyfive-child'),
		'footer'    => __('Footer Navigation', 'twentytwentyfive-child'),
	));
}
add_action('init', 'twentytwentyfive_child_register_menus');

/**
 * Performance Optimizations
 */
function twentytwentyfive_child_performance_optimizations()
{
	// Remove emoji scripts and styles
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('admin_print_styles', 'print_emoji_styles');

	// Remove unnecessary generator meta tags
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'rsd_link');

	// Remove unnecessary feeds
	remove_action('wp_head', 'feed_links_extra', 3);
}
add_action('init', 'twentytwentyfive_child_performance_optimizations');

// Optimize excerpt length for news cards
function twentytwentyfive_child_excerpt_length($length)
{
	return 25;
}
add_filter('excerpt_length', 'twentytwentyfive_child_excerpt_length');

// Custom excerpt more text
function twentytwentyfive_child_excerpt_more($more)
{
	return '...';
}
add_filter('excerpt_more', 'twentytwentyfive_child_excerpt_more');

/**
 * Security Enhancements
 */

// Hide WordPress version
function twentytwentyfive_child_remove_version()
{
	return '';
}
add_filter('the_generator', 'twentytwentyfive_child_remove_version');

// Disable file editing from admin
if (!defined('DISALLOW_FILE_EDIT')) {
	define('DISALLOW_FILE_EDIT', true);
}
