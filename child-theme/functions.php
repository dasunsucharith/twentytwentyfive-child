<?php
/**
 * Enqueue styles for the child theme.
 */
function twentytwentyfive_child_enqueue_styles() {
    wp_enqueue_style( 'twentytwentyfive-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style(
        'twentytwentyfive-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'twentytwentyfive-style' )
    );
}
add_action( 'wp_enqueue_scripts', 'twentytwentyfive_child_enqueue_styles' );
