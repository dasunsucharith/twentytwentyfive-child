<?php

/**
 * Custom Navigation Walker Classes
 * Enhanced navigation with modern features
 */

/**
 * Custom Navigation Walker for Desktop Menu
 */
class Custom_Nav_Walker extends Walker_Nav_Menu
{

    /**
     * Start the list before the elements are added
     */
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu sub-menu--level-$depth\">\n";
    }

    /**
     * End the list after the elements are added
     */
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    /**
     * Start the element output
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Add special classes
        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'current';
        }

        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'has-dropdown';
        }

        // Category-based styling
        if (!empty($item->object) && $item->object === 'category') {
            $category = get_category($item->object_id);
            if ($category) {
                $classes[] = 'menu-category';
                $classes[] = 'menu-category--' . $category->slug;
            }
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names . '>';

        // Link attributes
        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) . '"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url) . '"' : '';

        // Add aria attributes for accessibility
        if (in_array('menu-item-has-children', $classes)) {
            $attributes .= ' aria-haspopup="true" aria-expanded="false"';
        }

        // Build the link
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes . '>';

        // Add icon if specified in menu item description
        if (!empty($item->description) && strpos($item->description, 'icon:') === 0) {
            $icon = str_replace('icon:', '', $item->description);
            $item_output .= '<span class="menu-icon menu-icon--' . esc_attr($icon) . '">' . get_menu_icon($icon) . '</span>';
        }

        $item_output .= '<span class="menu-text">';
        $item_output .= isset($args->link_before) ? $args->link_before : '';
        $item_output .= apply_filters('the_title', $item->title, $item->ID);
        $item_output .= isset($args->link_after) ? $args->link_after : '';
        $item_output .= '</span>';

        // Add dropdown indicator
        if (in_array('menu-item-has-children', $classes)) {
            $item_output .= '<span class="dropdown-indicator" aria-hidden="true">';
            $item_output .= '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">';
            $item_output .= '<polyline points="6,9 12,15 18,9"></polyline>';
            $item_output .= '</svg>';
            $item_output .= '</span>';
        }

        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * End the element output
     */
    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $output .= "</li>\n";
    }
}

/**
 * Mobile Navigation Walker
 */
class Mobile_Nav_Walker extends Walker_Nav_Menu
{

    /**
     * Start the list before the elements are added
     */
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"mobile-sub-menu mobile-sub-menu--level-$depth\">\n";
    }

    /**
     * End the list after the elements are added
     */
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    /**
     * Start the element output
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'mobile-menu-item';
        $classes[] = 'mobile-menu-item-' . $item->ID;
        $classes[] = 'mobile-menu-item--level-' . $depth;

        // Add special classes
        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'current';
        }

        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'has-children';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'mobile-menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names . '>';

        // Link attributes
        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) . '"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url) . '"' : '';

        // Build the link
        $item_output = isset($args->before) ? $args->before : '';

        // Mobile menu item wrapper
        $item_output .= '<div class="mobile-menu-item__wrapper">';
        $item_output .= '<a' . $attributes . ' class="mobile-menu-item__link">';

        // Add icon if specified
        if (!empty($item->description) && strpos($item->description, 'icon:') === 0) {
            $icon = str_replace('icon:', '', $item->description);
            $item_output .= '<span class="mobile-menu-icon">' . get_menu_icon($icon) . '</span>';
        }

        $item_output .= '<span class="mobile-menu-text">';
        $item_output .= isset($args->link_before) ? $args->link_before : '';
        $item_output .= apply_filters('the_title', $item->title, $item->ID);
        $item_output .= isset($args->link_after) ? $args->link_after : '';
        $item_output .= '</span>';
        $item_output .= '</a>';

        // Add submenu toggle for items with children
        if (in_array('menu-item-has-children', $classes)) {
            $item_output .= '<button class="mobile-submenu-toggle" aria-expanded="false" aria-label="Toggle ' . esc_attr($item->title) . ' submenu">';
            $item_output .= '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">';
            $item_output .= '<polyline points="6,9 12,15 18,9"></polyline>';
            $item_output .= '</svg>';
            $item_output .= '</button>';
        }

        $item_output .= '</div>';
        $item_output .= isset($args->after) ? $args->after : '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * End the element output
     */
    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $output .= "</li>\n";
    }
}

/**
 * Get menu icon SVG
 */
function get_menu_icon($icon)
{
    $icons = [
        'home' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg>',
        'news' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>',
        'politics' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 2v4l-5 2v4l5-2v4l5-2V8l5 2V6l-5-2V2l-5 2Z"/></svg>',
        'business' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18"/><path d="M5 21V7l8-4v18"/><path d="M19 21V9l-6-4"/></svg>',
        'technology' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>',
        'sports' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>',
        'culture' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4"/><path d="M21 12c-1 0-3-1-3-3s2-3 3-3 3 1 3 3-2 3-3 3"/><path d="M3 12c1 0 3-1 3-3s-2-3-3-3-3 1-3 3 2 3 3 3"/><path d="M12 21c0-1-1-3-3-3s-3 2-3 3 1 3 3 3 3-2 3-3"/><path d="M12 3c0 1 1 3 3 3s3-2 3-3-1-3-3-3-3 2-3 3"/></svg>',
        'about' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>',
        'contact' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>',
        'search' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>',
        'user' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
        'arrow-right' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12,5 19,12 12,19"/></svg>',
        'external' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15,3 21,3 21,9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>'
    ];

    return isset($icons[$icon]) ? $icons[$icon] : '';
}

/**
 * Enhanced functions for header functionality
 */

/**
 * Add customizer options for header
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

    // Header Style Options
    $wp_customize->add_setting('header_style', array(
        'default'           => 'default',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('header_style', array(
        'label'    => __('Header Style', 'twentytwentyfive-child'),
        'section'  => 'header_options',
        'type'     => 'select',
        'choices'  => array(
            'default'  => __('Default', 'twentytwentyfive-child'),
            'minimal'  => __('Minimal', 'twentytwentyfive-child'),
            'magazine' => __('Magazine Style', 'twentytwentyfive-child'),
        ),
    ));

    // Show/Hide Elements
    $header_elements = array(
        'show_date_time' => __('Show Date & Time', 'twentytwentyfive-child'),
        'show_weather'   => __('Show Weather Widget', 'twentytwentyfive-child'),
        'show_social'    => __('Show Social Links', 'twentytwentyfive-child'),
        'show_search'    => __('Show Search', 'twentytwentyfive-child'),
        'show_dark_mode' => __('Show Dark Mode Toggle', 'twentytwentyfive-child'),
    );

    foreach ($header_elements as $setting => $label) {
        $wp_customize->add_setting($setting, array(
            'default'           => true,
            'sanitize_callback' => 'wp_validate_boolean',
        ));

        $wp_customize->add_control($setting, array(
            'label'    => $label,
            'section'  => 'header_options',
            'type'     => 'checkbox',
        ));
    }
}
add_action('customize_register', 'twentytwentyfive_child_header_customizer');

/**
 * Add header classes based on customizer settings
 */
function twentytwentyfive_child_header_classes()
{
    $classes = array('news-header');

    // Add style class
    $header_style = get_theme_mod('header_style', 'default');
    $classes[] = "header-style--$header_style";

    // Add conditional classes
    if (!get_theme_mod('show_date_time', true)) {
        $classes[] = 'hide-date-time';
    }

    if (!get_theme_mod('show_weather', true)) {
        $classes[] = 'hide-weather';
    }

    if (!get_theme_mod('show_social', true)) {
        $classes[] = 'hide-social';
    }

    return implode(' ', $classes);
}

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
 * Add preload hints for header assets
 */
function twentytwentyfive_child_preload_header_assets()
{
    // Preload critical CSS
    echo '<link rel="preload" href="' . get_stylesheet_directory_uri() . '/assets/css/header.css" as="style">';

    // Preload header JavaScript
    echo '<link rel="preload" href="' . get_stylesheet_directory_uri() . '/assets/js/header.js" as="script">';

    // Preload Google Fonts
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
}
add_action('wp_head', 'twentytwentyfive_child_preload_header_assets', 1);

/**
 * Add header JavaScript variables
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
 * AJAX handler for live search
 */
function twentytwentyfive_child_live_search()
{
    check_ajax_referer('header_nonce', 'nonce');

    $search_query = sanitize_text_field($_POST['query']);
    if (empty($search_query) || strlen($search_query) < 2) {
        wp_die();
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

    $search_query = new WP_Query($args);
    $results = array();

    if ($search_query->have_posts()) {
        while ($search_query->have_posts()) {
            $search_query->the_post();
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
}
add_action('wp_ajax_live_search', 'twentytwentyfive_child_live_search');
add_action('wp_ajax_nopriv_live_search', 'twentytwentyfive_child_live_search');

/**
 * Add admin settings for header
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
 * Register header-specific styles and scripts
 */
function twentytwentyfive_child_header_assets()
{
    // Header-specific CSS
    wp_enqueue_style(
        'twentytwentyfive-child-header',
        get_stylesheet_directory_uri() . '/assets/css/header.css',
        array(),
        wp_get_theme()->get('Version')
    );

    // Header-specific JavaScript
    wp_enqueue_script(
        'twentytwentyfive-child-header',
        get_stylesheet_directory_uri() . '/assets/js/header.js',
        array('jquery'),
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('wp_enqueue_scripts', 'twentytwentyfive_child_header_assets');
?>