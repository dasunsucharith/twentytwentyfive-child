<?php

/**
 * Twenty Twenty-Five Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Twenty Twenty-Five Child
 */

/**
 * Enqueue scripts and styles.
 */
function twentytwentyfive_child_enqueue_styles()
{
	wp_enqueue_style(
		'twentytwentyfive-parent-style',
		get_template_directory_uri() . '/style.css'
	);
	wp_enqueue_style(
		'twentytwentyfive-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array('twentytwentyfive-parent-style'),
		wp_get_theme()->get('Version')
	);
}
add_action('wp_enqueue_scripts', 'twentytwentyfive_child_enqueue_styles');

/**
 * Add custom logo support.
 */
function twentytwentyfive_child_add_custom_logo_support()
{
	add_theme_support('custom-logo');
}
add_action('after_setup_theme', 'twentytwentyfive_child_add_custom_logo_support');

/**
 * Enqueue custom Google Fonts for entire theme.
 */
function twentytwentyfive_child_enqueue_custom_fonts()
{
	// Load Poppins font with multiple weights for clean, modern typography
	wp_enqueue_style(
		'poppins-font',
		'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap',
		array(),
		null
	);
}
add_action('wp_enqueue_scripts', 'twentytwentyfive_child_enqueue_custom_fonts');
