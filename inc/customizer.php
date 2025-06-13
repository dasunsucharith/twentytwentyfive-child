<?php
/**
 * Theme Customizer settings
 */

if ( ! defined( 'ABSPATH' ) ) {
        exit;
}

function slviki_customize_register( $wp_customize ) {
        // Add customizer settings here.
}
add_action( 'customize_register', 'slviki_customize_register' );

