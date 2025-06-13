<?php

/**
 * Title: Advanced News Header
 * Slug: slviki/advanced-news-header
 * Categories: header
 * Block Types: core/template-part/header
 * Description: Modern news header with smart navigation, search, and breaking news ticker
 */

// Get current date for header
$current_date = date('l, F j, Y');
$current_time = date('g:i A T');

// Check for breaking news (you can customize this logic)
$breaking_news = get_option('breaking_news_text', '');
$show_breaking_news = !empty($breaking_news) && get_option('show_breaking_news', false);

?>

<!-- Breaking News Ticker (conditionally shown) -->
<?php if ($show_breaking_news): ?>
	<!-- wp:html -->
	<div class="breaking-news-banner" role="alert" aria-live="assertive">
		<div class="breaking-news-banner__content">
			<span class="breaking-news-banner__label">Breaking</span>
			<div class="breaking-news-banner__text"><?php echo esc_html($breaking_news); ?></div>
			<button class="breaking-news-banner__close" aria-label="Close breaking news">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<line x1="18" y1="6" x2="6" y2="18"></line>
					<line x1="6" y1="6" x2="18" y2="18"></line>
				</svg>
			</button>
		</div>
	</div>
	<!-- /wp:html -->
<?php endif; ?>

<!-- Main Header -->
<!-- wp:html -->
<header class="news-header" id="site-header">
	<!-- Skip Link for Accessibility -->
	<a class="skip-link sr-only focus:not-sr-only" href="#main">Skip to main content</a>

	<!-- Top Bar with Date/Time and Social -->
	<div class="header-top-bar">
		<div class="header-top-bar__content">
			<div class="header-date-time">
				<time datetime="<?php echo date('c'); ?>" class="header-date">
					<?php echo $current_date; ?>
				</time>
				<span class="header-time"><?php echo $current_time; ?></span>
			</div>

			<div class="header-social">
				<?php
				// Get social media links from customizer
				$social_links = [
					'facebook' => get_theme_mod('social_facebook', ''),
					'twitter' => get_theme_mod('social_twitter', ''),
					'instagram' => get_theme_mod('social_instagram', ''),
					'youtube' => get_theme_mod('social_youtube', ''),
					'rss' => get_bloginfo('rss2_url')
				];

				foreach ($social_links as $platform => $url):
					if (!empty($url)):
				?>
						<a href="<?php echo esc_url($url); ?>"
							class="social-link social-link--<?php echo $platform; ?>"
							target="<?php echo $platform === 'rss' ? '_self' : '_blank'; ?>"
							rel="<?php echo $platform === 'rss' ? '' : 'noopener noreferrer'; ?>"
							aria-label="Follow us on <?php echo ucfirst($platform); ?>">
							<?php echo get_social_icon($platform); ?>
						</a>
				<?php
					endif;
				endforeach;
				?>
			</div>
		</div>
	</div>

	<!-- Main Header Content -->
	<div class="header-main">
		<div class="header-main__content">
			<!-- Logo & Site Title Section -->
			<div class="header-brand">
				<?php if (has_custom_logo()): ?>
					<div class="header-logo">
						<?php the_custom_logo(); ?>
					</div>
				<?php endif; ?>

				<div class="header-text">
					<h1 class="site-title">
						<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
							<?php bloginfo('name'); ?>
						</a>
					</h1>
					<?php
					$description = get_bloginfo('description', 'display');
					if ($description || is_customize_preview()):
					?>
						<p class="site-description"><?php echo $description; ?></p>
					<?php endif; ?>
				</div>
			</div>

			<!-- Weather Widget (Optional) -->
			<div class="header-weather" id="weather-widget">
				<!-- Weather will be loaded via JavaScript -->
			</div>

			<!-- Header Actions -->
			<div class="header-actions">
				<!-- Search -->
				<div class="header-search">
					<button class="search-toggle" aria-label="Open search" aria-expanded="false" aria-controls="search-form">
						<svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<circle cx="11" cy="11" r="8" />
							<path d="m21 21-4.35-4.35" />
						</svg>
						<svg class="close-icon hidden" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<line x1="18" y1="6" x2="6" y2="18" />
							<line x1="6" y1="6" x2="18" y2="18" />
						</svg>
					</button>

					<div class="search-form-container" id="search-form">
						<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
							<label class="sr-only" for="search-input">Search for:</label>
							<input type="search"
								id="search-input"
								class="search-input"
								placeholder="Search news..."
								value="<?php echo get_search_query(); ?>"
								name="s"
								autocomplete="off"
								spellcheck="false">
							<button type="submit" class="search-submit" aria-label="Submit search">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
									<circle cx="11" cy="11" r="8" />
									<path d="m21 21-4.35-4.35" />
								</svg>
							</button>
						</form>

						<!-- Quick Search Suggestions -->
						<div class="search-suggestions" id="search-suggestions">
							<div class="search-suggestions__header">Popular searches</div>
							<div class="search-suggestions__list">
								<?php
								// Get popular search terms or categories
								$popular_searches = ['Politics', 'Technology', 'Business', 'Sports', 'Health'];
								foreach ($popular_searches as $term):
								?>
									<a href="<?php echo esc_url(home_url('/?s=' . urlencode($term))); ?>" class="search-suggestion">
										<?php echo esc_html($term); ?>
									</a>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>

				<!-- Dark Mode Toggle -->
				<button class="theme-toggle" aria-label="Toggle dark mode" id="theme-toggle">
					<svg class="sun-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
						<circle cx="12" cy="12" r="5" />
						<line x1="12" y1="1" x2="12" y2="3" />
						<line x1="12" y1="21" x2="12" y2="23" />
						<line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
						<line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
						<line x1="1" y1="12" x2="3" y2="12" />
						<line x1="21" y1="12" x2="23" y2="12" />
						<line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
						<line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
					</svg>
					<svg class="moon-icon hidden" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
						<path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
					</svg>
				</button>

				<!-- Newsletter Signup -->
				<a href="<?php echo esc_url(home_url('/newsletter')); ?>" class="newsletter-btn">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
						<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
						<polyline points="22,6 12,13 2,6" />
					</svg>
					<span>Newsletter</span>
				</a>
			</div>
		</div>
	</div>

	<!-- Navigation -->
	<nav class="header-nav" role="navigation" aria-label="Main navigation">
		<div class="header-nav__content">
			<!-- Primary Navigation -->
			<div class="nav-primary">
				<?php
				wp_nav_menu([
					'theme_location' => 'primary',
					'menu_class' => 'nav-menu',
					'container' => false,
					'depth' => 2,
					'fallback_cb' => 'fallback_nav_menu',
					'walker' => new Custom_Nav_Walker(),
				]);
				?>
			</div>

			<!-- Secondary Navigation -->
			<div class="nav-secondary">
				<?php
				wp_nav_menu([
					'theme_location' => 'secondary',
					'menu_class' => 'nav-secondary-menu',
					'container' => false,
					'depth' => 1,
					'fallback_cb' => false,
				]);
				?>
			</div>

			<!-- Mobile Menu Toggle -->
			<button class="mobile-menu-toggle"
				aria-label="Toggle mobile menu"
				aria-expanded="false"
				aria-controls="mobile-menu"
				id="mobile-toggle">
				<span class="hamburger-line"></span>
				<span class="hamburger-line"></span>
				<span class="hamburger-line"></span>
				<span class="sr-only">Menu</span>
			</button>
		</div>
	</nav>

	<!-- Mobile Navigation -->
	<div class="mobile-nav" id="mobile-menu" aria-hidden="true">
		<div class="mobile-nav__header">
			<div class="mobile-nav__title">Menu</div>
			<button class="mobile-nav__close" aria-label="Close mobile menu">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
					<line x1="18" y1="6" x2="6" y2="18" />
					<line x1="6" y1="6" x2="18" y2="18" />
				</svg>
			</button>
		</div>

		<div class="mobile-nav__content">
			<!-- Mobile Search -->
			<div class="mobile-search">
				<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
					<input type="search"
						class="mobile-search__input"
						placeholder="Search..."
						name="s"
						value="<?php echo get_search_query(); ?>">
					<button type="submit" class="mobile-search__submit">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<circle cx="11" cy="11" r="8" />
							<path d="m21 21-4.35-4.35" />
						</svg>
					</button>
				</form>
			</div>

			<!-- Mobile Menu -->
			<div class="mobile-nav__menu">
				<?php
				wp_nav_menu([
					'theme_location' => 'primary',
					'menu_class' => 'mobile-menu-list',
					'container' => false,
					'depth' => 2,
					'fallback_cb' => 'fallback_mobile_menu',
					'walker' => new Mobile_Nav_Walker(),
				]);
				?>
			</div>

			<!-- Mobile Social Links -->
			<div class="mobile-nav__social">
				<?php foreach ($social_links as $platform => $url): ?>
					<?php if (!empty($url)): ?>
						<a href="<?php echo esc_url($url); ?>"
							class="mobile-social-link"
							target="<?php echo $platform === 'rss' ? '_self' : '_blank'; ?>"
							rel="<?php echo $platform === 'rss' ? '' : 'noopener noreferrer'; ?>"
							aria-label="<?php echo ucfirst($platform); ?>">
							<?php echo get_social_icon($platform); ?>
						</a>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<!-- Mobile Overlay -->
	<div class="mobile-overlay" id="mobile-overlay"></div>
</header>
<!-- /wp:html -->

<?php
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