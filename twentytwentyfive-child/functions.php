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

// Include navigation walkers - CRITICAL FIX
require_once get_stylesheet_directory() . '/inc/navigation-walkers.php';

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
 * Theme Activation Hook
 */
function twentytwentyfive_child_activation() {
    // Set default theme options
    add_option('show_breaking_news', false);
    add_option('breaking_news_text', '');
    add_option('weather_api_key', '');
    add_option('default_weather_city', 'New York');
    
    // Flush rewrite rules
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'twentytwentyfive_child_activation');

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

	// Header-specific CSS
	wp_enqueue_style(
		'twentytwentyfive-child-header',
		get_stylesheet_directory_uri() . '/assets/css/header.css',
		array('twentytwentyfive-child-style'),
		$theme_version
	);

	// Main JavaScript file
	wp_enqueue_script(
		'twentytwentyfive-child-main',
		get_stylesheet_directory_uri() . '/assets/js/main.js',
		array(),
		$theme_version,
		true // Load in footer for better performance
	);

	// Header-specific JavaScript
	wp_enqueue_script(
		'twentytwentyfive-child-header',
		get_stylesheet_directory_uri() . '/assets/js/header.js',
		array('jquery'),
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
 * Add CSS custom property fallbacks
 */
function twentytwentyfive_child_css_fallbacks() {
    $fallback_css = "
    /* Fallbacks for older browsers */
    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-size: 16px;
        line-height: 1.6;
        color: #111827;
        background-color: #ffffff;
    }
    
    .header-inner, .header-main__content, .header-nav__content {
        max-width: 1400px;
        padding: 0 24px;
    }
    
    .main-nav a {
        padding: 12px 16px;
        font-size: 14px;
    }
    
    .site-main {
        max-width: 800px;
        padding: 32px 24px;
    }
    ";
    
    wp_add_inline_style('twentytwentyfive-child-style', $fallback_css);
}
add_action('wp_enqueue_scripts', 'twentytwentyfive_child_css_fallbacks');

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
 * Register Widget Areas
 */
function twentytwentyfive_child_widgets_init()
{
	register_sidebar(array(
		'name'          => __('Sidebar', 'twentytwentyfive-child'),
		'id'            => 'sidebar-1',
		'description'   => __('Add widgets here to appear in your sidebar.', 'twentytwentyfive-child'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));

	register_sidebar(array(
		'name'          => __('Footer Widgets', 'twentytwentyfive-child'),
		'id'            => 'footer-widgets',
		'description'   => __('Add widgets here to appear in your footer.', 'twentytwentyfive-child'),
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="footer-widget-title">',
		'after_title'   => '</h4>',
	));
}
add_action('widgets_init', 'twentytwentyfive_child_widgets_init');

/**
 * Performance Optimizations
 */

// Remove unnecessary WordPress features for news site
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
 * Enhanced Header JavaScript Configuration
 */
function twentytwentyfive_child_header_js_vars()
{
    $config = array(
        'ajaxUrl'          => admin_url('admin-ajax.php'),
        'nonce'            => wp_create_nonce('header_nonce'),
        'searchUrl'        => home_url('/'),
        'isUserLoggedIn'   => is_user_logged_in(),
        'showWeather'      => get_theme_mod('show_weather', true),
        'weatherApiKey'    => get_option('weather_api_key', ''),
        'defaultCity'      => get_option('default_weather_city', 'New York'),
        'breakingNews'     => array(
            'text' => get_option('breaking_news_text', ''),
            'show' => get_option('show_breaking_news', false),
        ),
        'strings'          => array(
            'search'         => __('Search...', 'twentytwentyfive-child'),
            'searchResults'  => __('Search Results', 'twentytwentyfive-child'),
            'noResults'      => __('No results found', 'twentytwentyfive-child'),
            'loading'        => __('Loading...', 'twentytwentyfive-child'),
            'close'          => __('Close', 'twentytwentyfive-child'),
            'menu'           => __('Menu', 'twentytwentyfive-child'),
        )
    );

    wp_localize_script('twentytwentyfive-child-main', 'NewsHeaderConfig', $config);
}
add_action('wp_enqueue_scripts', 'twentytwentyfive_child_header_js_vars');

/**
 * AJAX handler for live search with error handling
 */
function twentytwentyfive_child_live_search()
{
    try {
        // Verify nonce
        if (!check_ajax_referer('header_nonce', 'nonce', false)) {
            wp_send_json_error('Invalid security token');
            return;
        }

        $search_query = sanitize_text_field($_POST['query'] ?? '');
        
        if (empty($search_query) || strlen($search_query) < 2) {
            wp_send_json_error('Search query too short');
            return;
        }

        $args = array(
            's'              => $search_query,
            'posts_per_page' => 5,
            'post_status'    => 'publish',
            'meta_query'     => array(
                array(
                    'key'     => '_thumbnail_id',
                    'compare' => 'EXISTS'
                )
            )
        );

        $search_results = new WP_Query($args);
        $results = array();

        if ($search_results->have_posts()) {
            while ($search_results->have_posts()) {
                $search_results->the_post();
                $results[] = array(
                    'title'     => get_the_title(),
                    'url'       => get_permalink(),
                    'excerpt'   => wp_trim_words(get_the_excerpt(), 15),
                    'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),
                    'date'      => get_the_date(),
                    'category'  => get_the_category_list(', ')
                );
            }
            wp_reset_postdata();
        }

        wp_send_json_success($results);
        
    } catch (Exception $e) {
        error_log('Live search error: ' . $e->getMessage());
        wp_send_json_error('Search temporarily unavailable');
    }
}
add_action('wp_ajax_live_search', 'twentytwentyfive_child_live_search');
add_action('wp_ajax_nopriv_live_search', 'twentytwentyfive_child_live_search');

/**
 * Add customizer options for header features
 */
function twentytwentyfive_child_header_customizer($wp_customize)
{
    // Header Section
    $wp_customize->add_section('header_options', array(
        'title'    => __('Header Options', 'twentytwentyfive-child'),
        'priority' => 30,
    ));

    // Breaking News
    $wp_customize->add_setting('breaking_news_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('breaking_news_text', array(
        'label'    => __('Breaking News Text', 'twentytwentyfive-child'),
        'section'  => 'header_options',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('show_breaking_news', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('show_breaking_news', array(
        'label'    => __('Show Breaking News', 'twentytwentyfive-child'),
        'section'  => 'header_options',
        'type'     => 'checkbox',
    ));

    // Weather Widget
    $wp_customize->add_setting('show_weather', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('show_weather', array(
        'label'    => __('Show Weather Widget', 'twentytwentyfive-child'),
        'section'  => 'header_options',
        'type'     => 'checkbox',
    ));

    // Social Media Links
    $social_platforms = array(
        'facebook'  => 'Facebook',
        'twitter'   => 'Twitter',
        'instagram' => 'Instagram',
        'youtube'   => 'YouTube',
        'linkedin'  => 'LinkedIn',
    );

    foreach ($social_platforms as $platform => $label) {
        $wp_customize->add_setting("social_$platform", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("social_$platform", array(
            'label'    => __("$label URL", 'twentytwentyfive-child'),
            'section'  => 'header_options',
            'type'     => 'url',
        ));
    }
}
add_action('customize_register', 'twentytwentyfive_child_header_customizer');

/**
 * Add structured data for navigation
 */
function twentytwentyfive_child_navigation_schema()
{
    if (!is_front_page()) return;

    $menu_locations = get_nav_menu_locations();
    if (!isset($menu_locations['primary'])) return;

    $menu = wp_get_nav_menu_object($menu_locations['primary']);
    if (!$menu) return;

    $menu_items = wp_get_nav_menu_items($menu->term_id);
    if (!$menu_items) return;

    $schema = array(
        '@context' => 'https://schema.org',
        '@type'    => 'SiteNavigationElement',
        'name'     => get_bloginfo('name') . ' Navigation',
        'url'      => array()
    );

    foreach ($menu_items as $item) {
        if ($item->menu_item_parent == 0) { // Top level items only
            $schema['url'][] = array(
                '@type' => 'WebPage',
                'name'  => $item->title,
                'url'   => $item->url
            );
        }
    }

    echo '<script type="application/ld+json">' . wp_json_encode($schema) . '</script>';
}
add_action('wp_head', 'twentytwentyfive_child_navigation_schema');

/**
 * Admin settings page for theme options
 */
function twentytwentyfive_child_admin_menu()
{
    add_theme_page(
        __('Header Settings', 'twentytwentyfive-child'),
        __('Header Settings', 'twentytwentyfive-child'),
        'manage_options',
        'header-settings',
        'twentytwentyfive_child_header_settings_page'
    );
}
add_action('admin_menu', 'twentytwentyfive_child_admin_menu');

/**
 * Header settings page
 */
function twentytwentyfive_child_header_settings_page()
{
    if (isset($_POST['submit'])) {
        check_admin_referer('header_settings_nonce');
        
        update_option('breaking_news_text', sanitize_text_field($_POST['breaking_news_text']));
        update_option('show_breaking_news', isset($_POST['show_breaking_news']));
        update_option('weather_api_key', sanitize_text_field($_POST['weather_api_key']));
        update_option('default_weather_city', sanitize_text_field($_POST['default_weather_city']));

        echo '<div class="notice notice-success"><p>' . __('Settings saved.', 'twentytwentyfive-child') . '</p></div>';
    }

    $breaking_news_text = get_option('breaking_news_text', '');
    $show_breaking_news = get_option('show_breaking_news', false);
    $weather_api_key = get_option('weather_api_key', '');
    $default_weather_city = get_option('default_weather_city', 'New York');
?>

    <div class="wrap">
        <h1><?php _e('Header Settings', 'twentytwentyfive-child'); ?></h1>

        <form method="post" action="">
            <?php wp_nonce_field('header_settings_nonce'); ?>

            <table class="form-table">
                <tr>
                    <th scope="row"><?php _e('Breaking News Text', 'twentytwentyfive-child'); ?></th>
                    <td>
                        <input type="text" name="breaking_news_text" value="<?php echo esc_attr($breaking_news_text); ?>" class="regular-text" />
                        <p class="description"><?php _e('Enter breaking news text to display in the banner.', 'twentytwentyfive-child'); ?></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><?php _e('Show Breaking News', 'twentytwentyfive-child'); ?></th>
                    <td>
                        <label>
                            <input type="checkbox" name="show_breaking_news" value="1" <?php checked($show_breaking_news); ?> />
                            <?php _e('Display breaking news banner', 'twentytwentyfive-child'); ?>
                        </label>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><?php _e('Weather API Key', 'twentytwentyfive-child'); ?></th>
                    <td>
                        <input type="text" name="weather_api_key" value="<?php echo esc_attr($weather_api_key); ?>" class="regular-text" />
                        <p class="description">
                            <?php _e('Get your free API key from', 'twentytwentyfive-child'); ?>
                            <a href="https://openweathermap.org/api" target="_blank">OpenWeatherMap</a>
                        </p>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><?php _e('Default Weather City', 'twentytwentyfive-child'); ?></th>
                    <td>
                        <input type="text" name="default_weather_city" value="<?php echo esc_attr($default_weather_city); ?>" class="regular-text" />
                        <p class="description"><?php _e('Default city for weather widget when location is not available.', 'twentytwentyfive-child'); ?></p>
                    </td>
                </tr>
            </table>

            <?php submit_button(); ?>
        </form>
    </div>

<?php
}

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