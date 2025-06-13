<?php

/**
 * slviki Theme functions and definitions
 *
 * @package slviki
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}

// Include navigation walkers from the child theme directory
require_once get_stylesheet_directory() . '/inc/navigation-walkers.php';

// Define content width
$content_width = 800;

/**
 * Theme Setup
 */
function slviki_setup()
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

	// Editor Color Palette
	add_theme_support('editor-color-palette', array(
		array(
			'name'  => __('Base', 'slviki'),
			'slug'  => 'base',
			'color' => '#ffffff',
		),
		array(
			'name'  => __('Contrast', 'slviki'),
			'slug'  => 'contrast',
			'color' => '#111111',
		),
		array(
			'name'  => __('Primary', 'slviki'),
			'slug'  => 'primary',
			'color' => '#0066cc',
		),
		array(
			'name'  => __('Secondary', 'slviki'),
			'slug'  => 'secondary',
			'color' => '#ff4444',
		),
		array(
			'name'  => __('Accent', 'slviki'),
			'slug'  => 'accent',
			'color' => '#f8fafc',
		),
		array(
			'name'  => __('Neutral', 'slviki'),
			'slug'  => 'neutral',
			'color' => '#64748b',
		),
		array(
			'name'  => __('Success', 'slviki'),
			'slug'  => 'success',
			'color' => '#22c55e',
		),
	));

	// Editor Font Sizes
	add_theme_support('editor-font-sizes', array(
		array(
			'name' => __('Small', 'slviki'),
			'size' => '0.875rem',
			'slug' => 'small',
		),
		array(
			'name' => __('Medium', 'slviki'),
			'size' => '1rem',
			'slug' => 'medium',
		),
		array(
			'name' => __('Large', 'slviki'),
			'size' => '1.125rem',
			'slug' => 'large',
		),
		array(
			'name' => __('Extra Large', 'slviki'),
			'size' => '1.25rem',
			'slug' => 'x-large',
		),
		array(
			'name' => __('XX Large', 'slviki'),
			'size' => '1.5rem',
			'slug' => 'xx-large',
		),
		array(
			'name' => __('XXX Large', 'slviki'),
			'size' => '2rem',
			'slug' => 'xxx-large',
		),
	));

	// Editor Font Families
	add_theme_support('editor-font-families', array(
		array(
			'name'          => __('Poppins', 'slviki'),
			'slug'          => 'poppins',
			'fontFamily'    => "Poppins, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif",
		),
		array(
			'name'          => __('Serif', 'slviki'),
			'slug'          => 'serif',
			'fontFamily'    => "Georgia, 'Times New Roman', serif",
		),
	));

	// Editor Styles
	add_editor_style('assets/css/editor-style.css');
}
add_action('after_setup_theme', 'slviki_setup');

/**
 * Enqueue Scripts and Styles - Performance Optimized
 */
function slviki_enqueue_assets()
{
	$theme_version = wp_get_theme()->get('Version');

	// Theme main styles
	wp_enqueue_style(
		'slviki-style',
		get_stylesheet_directory_uri() . '/style.css',
		array(),
		$theme_version
	);

	// Theme header style
	wp_enqueue_style(
		'slviki-header-style',
		get_stylesheet_directory_uri() . '/assets/css/header.css',
		array('slviki-style'),
		$theme_version
	);

	// Google Fonts - Optimized loading with display=swap
	wp_enqueue_style(
		'google-fonts-poppins',
		'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap',
		array(),
		null
	);

	// Main JavaScript file (we'll create this)
	wp_enqueue_script(
		'slviki-main',
		get_stylesheet_directory_uri() . '/assets/js/main.js',
		array(),
		$theme_version,
		true // Load in footer for better performance
	);

	// Theme header script
	wp_enqueue_script(
		'slviki-header-script',
		get_stylesheet_directory_uri() . '/assets/js/header.js',
		array(),
		$theme_version,
		true // Load in footer
	);

	// Localize script for AJAX if needed
	wp_localize_script('slviki-main', 'newsTheme', array(
		'ajaxUrl' => admin_url('admin-ajax.php'),
		'nonce'   => wp_create_nonce('news_theme_nonce')
	));
}
add_action('wp_enqueue_scripts', 'slviki_enqueue_assets');

/**
 * Register Navigation Menus
 */
function slviki_register_menus()
{
	register_nav_menus(array(
		'primary'   => __('Primary Navigation', 'slviki'),
		'secondary' => __('Secondary Navigation', 'slviki'),
		'footer'    => __('Footer Navigation', 'slviki'),
	));
}
add_action('init', 'slviki_register_menus');

/**
 * Register Widget Areas
 */
function slviki_widgets_init()
{
	register_sidebar(array(
		'name'          => __('Sidebar', 'slviki'),
		'id'            => 'sidebar-1',
		'description'   => __('Add widgets here to appear in your sidebar.', 'slviki'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));

	register_sidebar(array(
		'name'          => __('Footer Widgets', 'slviki'),
		'id'            => 'footer-widgets',
		'description'   => __('Add widgets here to appear in your footer.', 'slviki'),
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="footer-widget-title">',
		'after_title'   => '</h4>',
	));
}
add_action('widgets_init', 'slviki_widgets_init');

/**
 * Performance Optimizations
 */

// Remove unnecessary WordPress features for news site
function slviki_performance_optimizations()
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
add_action('init', 'slviki_performance_optimizations');

// Optimize excerpt length for news cards
function slviki_excerpt_length($length)
{
	return 25;
}
add_filter('excerpt_length', 'slviki_excerpt_length');

// Custom excerpt more text
function slviki_excerpt_more($more)
{
	return '...';
}
add_filter('excerpt_more', 'slviki_excerpt_more');

/**
 * Custom Functions for News Site
 */

// Get reading time estimate
function get_reading_time($post_id = null)
{
	if (!$post_id) {
		$post_id = get_the_ID();
	}

	$content = get_post_field('post_content', $post_id);
	$word_count = str_word_count(strip_tags($content));
	$reading_time = ceil($word_count / 200); // Average 200 words per minute

	return $reading_time;
}

// Get post views (simple implementation)
function get_post_views($post_id = null)
{
	if (!$post_id) {
		$post_id = get_the_ID();
	}

	$views = get_post_meta($post_id, 'post_views', true);
	return $views ? $views : 0;
}

// Track post views
function track_post_views($post_id)
{
	if (!is_single()) return;
	if (empty($post_id)) {
		global $post;
		$post_id = $post->ID;
	}

	$views = get_post_meta($post_id, 'post_views', true);
	$views = $views ? $views + 1 : 1;
	update_post_meta($post_id, 'post_views', $views);
}
add_action('wp_head', function () {
	if (is_single()) {
		track_post_views(get_the_ID());
	}
});

/**
 * Security Enhancements
 */

// Hide WordPress version
function slviki_remove_version()
{
	return '';
}
add_filter('the_generator', 'slviki_remove_version');

// Disable file editing from admin
if (!defined('DISALLOW_FILE_EDIT')) {
	define('DISALLOW_FILE_EDIT', true);
}
