<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package slviki
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'slviki' ); ?></a>

	<?php
	// Attempt to load the advanced-header pattern
	// WordPress should find 'patterns/advanced-header.php' via its slug 'advanced-header'
	// If the theme uses a prefix for patterns like 'slviki/advanced-header' as seen in the html part,
	// we might need to adjust the slug passed to get_template_part.
	// Let's try with the direct slug first as 'slviki' is the theme's text domain / name.
	// The pattern file is patterns/advanced-header.php. The slug is 'advanced-header'.
	get_template_part( 'patterns/advanced-header' );
	?>

        <div id="content" class="site-content">
                <div id="primary" class="content-area">
                        <main id="main" class="site-main">
