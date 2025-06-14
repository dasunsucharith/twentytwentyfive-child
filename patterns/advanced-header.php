<?php

/**
 * Title: Simple News Header
 * Slug: slviki/simple-news-header
 * Categories: header
 * Block Types: core/template-part/header
 * Description: Clean news header with WordPress menu integration and mobile optimization
 */

?>

<!-- wp:html -->
<header class="site-header" id="site-header">
	<div class="header-container">
		<!-- Logo Section -->
		<div class="header-logo">
			<?php if (has_custom_logo()): ?>
				<?php the_custom_logo(); ?>
			<?php else: ?>
				<a href="<?php echo esc_url(home_url('/')); ?>" class="site-title">
					<?php bloginfo('name'); ?>
				</a>
			<?php endif; ?>
		</div>

		<!-- Desktop Navigation & Actions -->
		<div class="header-nav-desktop">
			<!-- Main Navigation -->
			<nav class="main-navigation" role="navigation" aria-label="Main navigation">
				<?php
				wp_nav_menu([
					'theme_location' => 'primary',
					'menu_class' => 'nav-menu',
					'container' => false,
					'depth' => 2,
					'fallback_cb' => 'slviki_fallback_nav_menu',
				]);
				?>
			</nav>

			<!-- Search Button -->
			<button class="search-btn" aria-label="Search">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<circle cx="11" cy="11" r="8" />
					<path d="m21 21-4.35-4.35" />
				</svg>
			</button>
		</div>

		<!-- Mobile Menu Toggle -->
		<button class="mobile-menu-toggle" aria-label="Toggle menu" aria-expanded="false">
			<span class="hamburger-line"></span>
			<span class="hamburger-line"></span>
			<span class="hamburger-line"></span>
		</button>
	</div>

	<!-- Full Page Mobile Menu -->
	<div class="mobile-menu-overlay" id="mobile-menu">
		<div class="mobile-menu-container">
			<div class="mobile-menu-header">
				<div class="mobile-menu-logo">
					<?php if (has_custom_logo()): ?>
						<?php the_custom_logo(); ?>
					<?php else: ?>
						<span class="mobile-site-title"><?php bloginfo('name'); ?></span>
					<?php endif; ?>
				</div>
				<button class="mobile-menu-close" aria-label="Close menu">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
						<line x1="18" y1="6" x2="6" y2="18"></line>
						<line x1="6" y1="6" x2="18" y2="18"></line>
					</svg>
				</button>
			</div>
			
			<nav class="mobile-navigation">
				<?php
				wp_nav_menu([
					'theme_location' => 'primary',
					'menu_class' => 'mobile-nav-menu',
					'container' => false,
					'depth' => 2,
					'fallback_cb' => 'slviki_fallback_nav_menu',
				]);
				?>
			</nav>

			<div class="mobile-menu-search">
				<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="mobile-search-form">
					<input type="search" class="mobile-search-input" placeholder="Search..." name="s" value="<?php echo get_search_query(); ?>">
					<button type="submit" class="mobile-search-submit">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<circle cx="11" cy="11" r="8" />
							<path d="m21 21-4.35-4.35" />
						</svg>
					</button>
				</form>
			</div>
		</div>
	</div>
</header>
<!-- /wp:html -->

<?php
/**
 * Simple fallback navigation menu
 */
function slviki_fallback_nav_menu() {
	$pages = get_pages(['sort_column' => 'menu_order']);
	if ($pages) {
		echo '<ul class="main-nav">';
		echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
		foreach ($pages as $page) {
			echo '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html($page->post_title) . '</a></li>';
		}
		echo '</ul>';
	}
}

/**
 * Helper function to get social media icons
 */
function get_social_icon($platform)
{
	$icons = [
		'facebook' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
		'twitter' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
		'instagram' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
		'youtube' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
		'rss' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M6.503 20.752c0 1.794-1.456 3.248-3.251 3.248-1.796 0-3.252-1.454-3.252-3.248 0-1.794 1.456-3.248 3.252-3.248 1.795.001 3.251 1.454 3.251 3.248zm-6.503-12.572v4.811c6.05.062 10.96 4.966 11.022 11.009h4.817c-.062-8.71-7.118-15.758-15.839-15.82zm0-3.368c10.58.046 19.152 8.594 19.183 19.188h4.817c-.03-13.231-10.755-23.954-24-24v4.812z"/></svg>'
	];

	return isset($icons[$platform]) ? $icons[$platform] : '';
}

/**
 * Fallback navigation menu
 */
function fallback_nav_menu()
{
	$pages = get_pages(['sort_column' => 'menu_order']);
	if ($pages) {
		echo '<ul class="nav-menu">';
		echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
		foreach ($pages as $page) {
			echo '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html($page->post_title) . '</a></li>';
		}
		echo '</ul>';
	}
}

function fallback_mobile_menu()
{
	echo fallback_nav_menu();
}
?>