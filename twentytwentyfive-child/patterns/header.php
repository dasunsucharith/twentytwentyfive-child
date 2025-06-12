<?php

/**
 * Title: Custom News Header
 * Slug: twentytwentyfive-child/custom-news-header
 * Categories: header
 * Block Types: core/template-part/header
 */
?>
<!-- wp:html -->
<header class="custom-news-header">
	<div class="header-inner">
		<!-- Logo and Site Title Section -->
		<div class="header-logo-section">
			<a href="<?php echo esc_url(home_url('/')); ?>" class="header-logo">
				<?php
				$custom_logo_id = get_theme_mod('custom_logo');
				if ($custom_logo_id) {
					echo wp_get_attachment_image($custom_logo_id, 'full', false, array('alt' => get_bloginfo('name')));
				}
				?>
			</a>
			<a href="<?php echo esc_url(home_url('/')); ?>" class="header-site-title">
				<?php bloginfo('name'); ?>
			</a>
		</div>

		<!-- Navigation Section -->
		<nav class="header-navigation">
			<ul class="main-nav">
				<li><a href="<?php echo esc_url(home_url('/')); ?>" <?php echo is_home() ? 'class="current"' : ''; ?>>Home</a></li>
				<li><a href="<?php echo esc_url(home_url('/news')); ?>" <?php echo is_category('news') ? 'class="current"' : ''; ?>>News</a></li>
				<li><a href="<?php echo esc_url(home_url('/politics')); ?>" <?php echo is_category('politics') ? 'class="current"' : ''; ?>>Politics</a></li>
				<li><a href="<?php echo esc_url(home_url('/business')); ?>" <?php echo is_category('business') ? 'class="current"' : ''; ?>>Business</a></li>
				<li><a href="<?php echo esc_url(home_url('/technology')); ?>" <?php echo is_category('technology') ? 'class="current"' : ''; ?>>Technology</a></li>
				<li><a href="<?php echo esc_url(home_url('/sports')); ?>" <?php echo is_category('sports') ? 'class="current"' : ''; ?>>Sports</a></li>
				<li><a href="<?php echo esc_url(home_url('/about')); ?>" <?php echo is_page('about') ? 'class="current"' : ''; ?>>About</a></li>
			</ul>

			<!-- Header Actions -->
			<div class="header-actions">
				<button class="search-toggle" aria-label="Search">
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
						<circle cx="11" cy="11" r="8" />
						<path d="m21 21-4.35-4.35" />
					</svg>
				</button>
				<a href="<?php echo esc_url(home_url('/subscribe')); ?>" class="subscribe-btn">Subscribe</a>
			</div>

			<!-- Mobile Menu Toggle -->
			<button class="mobile-menu-toggle" aria-label="Menu">
				<span></span>
				<span></span>
				<span></span>
			</button>
		</nav>
	</div>

	<!-- Mobile Navigation -->
	<nav class="mobile-nav">
		<ul>
			<li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
			<li><a href="<?php echo esc_url(home_url('/news')); ?>">News</a></li>
			<li><a href="<?php echo esc_url(home_url('/politics')); ?>">Politics</a></li>
			<li><a href="<?php echo esc_url(home_url('/business')); ?>">Business</a></li>
			<li><a href="<?php echo esc_url(home_url('/technology')); ?>">Technology</a></li>
			<li><a href="<?php echo esc_url(home_url('/sports')); ?>">Sports</a></li>
			<li><a href="<?php echo esc_url(home_url('/about')); ?>">About</a></li>
		</ul>
	</nav>
</header>

<script>
	// Mobile menu toggle
	document.addEventListener('DOMContentLoaded', function() {
		const mobileToggle = document.querySelector('.mobile-menu-toggle');
		const mobileNav = document.querySelector('.mobile-nav');

		if (mobileToggle && mobileNav) {
			mobileToggle.addEventListener('click', function() {
				mobileNav.classList.toggle('active');
				this.classList.toggle('active');
			});
		}

		// Search toggle functionality (you can expand this)
		const searchToggle = document.querySelector('.search-toggle');
		if (searchToggle) {
			searchToggle.addEventListener('click', function() {
				// Add your search functionality here
				console.log('Search clicked');
			});
		}
	});
</script>
<!-- /wp:html -->