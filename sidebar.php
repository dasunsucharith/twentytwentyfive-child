<?php
/**
 * The sidebar containing the main widget area - News Enhanced
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package slviki
 */

?>

<aside id="secondary" class="widget-area news-sidebar-content">
	
	<!-- Latest Posts Widget -->
	<div class="widget latest-posts-widget">
		<h3 class="widget-title">Latest Posts</h3>
		<?php
		$latest_posts = new WP_Query([
			'posts_per_page' => 5,
			'post_status' => 'publish',
			'ignore_sticky_posts' => true
		]);

		if ($latest_posts->have_posts()) :
		?>
			<ul class="latest-posts-list">
				<?php while ($latest_posts->have_posts()) : $latest_posts->the_post(); ?>
					<li class="latest-post-item">
						<?php if (has_post_thumbnail()) : ?>
							<div class="latest-post-thumb">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail('thumbnail', ['class' => 'latest-post-img']); ?>
								</a>
							</div>
						<?php endif; ?>
						<div class="latest-post-content">
							<h4 class="latest-post-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h4>
							<div class="latest-post-meta">
								<time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('M j'); ?></time>
								<span class="meta-separator">•</span>
								<span class="latest-post-category">
									<?php
									$categories = get_the_category();
									if ($categories) {
										echo esc_html($categories[0]->name);
									}
									?>
								</span>
							</div>
						</div>
					</li>
				<?php endwhile; ?>
			</ul>
		<?php
		wp_reset_postdata();
		endif;
		?>
	</div>

	<!-- Categories Widget -->
	<div class="widget categories-widget">
		<h3 class="widget-title">Categories</h3>
		<?php
		$categories = get_categories([
			'orderby' => 'count',
			'order' => 'DESC',
			'number' => 8,
			'hide_empty' => true
		]);

		if ($categories) :
		?>
			<ul class="categories-list">
				<?php foreach ($categories as $category) : ?>
					<li class="category-item">
						<a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="category-link">
							<span class="category-name"><?php echo esc_html($category->name); ?></span>
							<span class="category-count"><?php echo $category->count; ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>

	<!-- Popular Posts Widget -->
	<div class="widget popular-posts-widget">
		<h3 class="widget-title">Popular Posts</h3>
		<?php
		$popular_posts = new WP_Query([
			'posts_per_page' => 4,
			'meta_key' => 'post_views_count',
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			'post_status' => 'publish',
			'ignore_sticky_posts' => true
		]);

		// Fallback to recent posts if no view count meta exists
		if (!$popular_posts->have_posts()) {
			$popular_posts = new WP_Query([
				'posts_per_page' => 4,
				'orderby' => 'comment_count',
				'order' => 'DESC',
				'post_status' => 'publish',
				'ignore_sticky_posts' => true
			]);
		}

		if ($popular_posts->have_posts()) :
		?>
			<ul class="popular-posts-list">
				<?php $counter = 1; while ($popular_posts->have_posts()) : $popular_posts->the_post(); ?>
					<li class="popular-post-item">
						<span class="popular-post-number"><?php echo $counter; ?></span>
						<div class="popular-post-content">
							<h4 class="popular-post-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h4>
							<div class="popular-post-meta">
								<time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('M j'); ?></time>
								<?php if (get_comments_number() > 0) : ?>
									<span class="meta-separator">•</span>
									<span class="popular-post-comments"><?php echo get_comments_number(); ?> comments</span>
								<?php endif; ?>
							</div>
						</div>
					</li>
				<?php $counter++; endwhile; ?>
			</ul>
		<?php
		wp_reset_postdata();
		endif;
		?>
	</div>

	<!-- Tags Widget -->
	<div class="widget tags-widget">
		<h3 class="widget-title">Popular Tags</h3>
		<?php
		$tags = get_tags([
			'orderby' => 'count',
			'order' => 'DESC',
			'number' => 15,
			'hide_empty' => true
		]);

		if ($tags) :
		?>
			<div class="tags-cloud">
				<?php foreach ($tags as $tag) : ?>
					<a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag-link" title="<?php echo $tag->count; ?> posts">
						<?php echo esc_html($tag->name); ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

	<!-- Newsletter Widget (if using a newsletter plugin) -->
	<div class="widget newsletter-widget">
		<h3 class="widget-title">Stay Updated</h3>
		<div class="newsletter-content">
			<p>Subscribe to our newsletter and never miss the latest news.</p>
			<?php
			// You can replace this with your actual newsletter form
			// For example, if using Mailchimp, Contact Form 7, etc.
			?>
			<form class="newsletter-form" action="#" method="post">
				<div class="newsletter-input-group">
					<input type="email" class="newsletter-input" placeholder="Enter your email" required>
					<button type="submit" class="newsletter-button">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="m9 18 6-6-6-6"/>
						</svg>
					</button>
				</div>
			</form>
		</div>
	</div>

	<!-- Archive Widget -->
	<div class="widget archive-widget">
		<h3 class="widget-title">Archives</h3>
		<?php
		$archives = wp_get_archives([
			'type' => 'monthly',
			'format' => 'option',
			'show_post_count' => true,
			'limit' => 12,
			'echo' => false
		]);

		if ($archives) :
		?>
			<ul class="archive-list">
				<?php echo $archives; ?>
			</ul>
		<?php endif; ?>
	</div>

	<?php
	// Load dynamic sidebar if widgets are added
	if (is_active_sidebar('sidebar-1')) {
		dynamic_sidebar('sidebar-1');
	}
	?>

</aside><!-- #secondary -->
