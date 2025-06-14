<?php
/**
 * Debug Menu Integration
 * Temporary file to help test WordPress menu functionality
 */

// Only allow access to logged-in users with proper permissions
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    wp_die('Access denied');
}

get_header(); ?>

<div style="padding: 20px; max-width: 1200px; margin: 0 auto;">
    <h2>Menu Debug Information</h2>
    
    <h3>Registered Menu Locations:</h3>
    <pre><?php print_r(get_registered_nav_menus()); ?></pre>
    
    <h3>Menu Locations:</h3>
    <pre><?php print_r(get_nav_menu_locations()); ?></pre>
    
    <h3>Available Menus:</h3>
    <?php
    $menus = wp_get_nav_menus();
    if ($menus) {
        foreach ($menus as $menu) {
            echo '<p><strong>' . esc_html($menu->name) . '</strong> (ID: ' . $menu->term_id . ')</p>';
        }
    } else {
        echo '<p>No menus found. Please create a menu in WordPress Admin → Appearance → Menus</p>';
    }
    ?>
    
    <h3>Primary Menu Output (if assigned):</h3>
    <div style="border: 1px solid #ddd; padding: 10px; background: #f9f9f9;">
        <?php
        wp_nav_menu([
            'theme_location' => 'primary',
            'menu_class' => 'debug-menu',
            'container' => false,
            'fallback_cb' => function() {
                echo '<p>No primary menu assigned. Please go to WordPress Admin → Appearance → Menus and assign a menu to the "Primary Navigation" location.</p>';
            }
        ]);
        ?>
    </div>
    
    <h3>Instructions:</h3>
    <ol>
        <li>Go to WordPress Admin → Appearance → Menus</li>
        <li>Create a new menu or edit an existing one</li>
        <li>Add pages/posts/custom links to your menu</li>
        <li>In the "Menu Settings" section, check "Primary Navigation"</li>
        <li>Save the menu</li>
        <li>Refresh this page to see the menu output</li>
    </ol>
</div>

<?php get_footer(); ?>