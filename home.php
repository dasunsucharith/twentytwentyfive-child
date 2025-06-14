<?php
/**
 * The home page template - Enhanced Homepage Layout
 *
 * This template is specifically designed for the homepage with enhanced features
 * including hero section, category highlights, and featured content areas.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package slviki
 */

get_header();
?>

<div class="homepage-layout">
	<div class="homepage-container">
		
		<?php if (have_posts()) : ?>
			
			<!-- Hero Section -->
			<section class="homepage-hero">
				<div class="hero-content">
					<div class="hero-main">
						<?php
						// Get the most recent featured post for hero
						$hero_query = new WP_Query([
							'posts_per_page' => 1,
							'meta_query' => [
								'relation' => 'OR',
								[
									'key' => '_featured_post',
									'value' => '1',
									'compare' => '='
								],
								[
									'key' => '_featured_post',
									'compare' => 'NOT EXISTS'
								]
							]
						]);

						if ($hero_query->have_posts()) :
							while ($hero_query->have_posts()) : $hero_query->the_post();
								?>
								<article class="hero-article">
									<?php if (has_post_thumbnail()) : ?>
										<div class="hero-image">
											<a href="<?php the_permalink(); ?>">
												<?php the_post_thumbnail('full', ['class' => 'hero-img']); ?>
											</a>
											<div class="hero-overlay">
												<div class="hero-content-wrapper">
													<div class="hero-meta">
														<span class="hero-category">
															<?php
															$categories = get_the_category();
															if ($categories) {
																echo esc_html($categories[0]->name);
															}
															?>
														</span>
														<time class="hero-date" datetime="<?php echo get_the_date('c'); ?>">
															<?php echo get_the_date('F j, Y'); ?>
														</time>
													</div>
													<h1 class="hero-title">
														<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
													</h1>
													<div class="hero-excerpt">
														<?php echo wp_trim_words(get_the_excerpt(), 35, '...'); ?>
													</div>
													<div class="hero-author">
														<?php echo get_avatar(get_the_author_meta('ID'), 32, '', '', ['class' => 'hero-avatar']); ?>
														<span class="hero-author-name">By <?php the_author(); ?></span>
													</div>
												</div>
											</div>
										</div>
									<?php endif; ?>
								</article>
								<?php
							endwhile;
							wp_reset_postdata();
						endif;
						?>
					</div>
					
					<!-- Hero Sidebar with trending posts -->
					<div class="hero-sidebar">
						<h3 class="hero-sidebar-title">Trending Now</h3>
						<?php
						$trending_query = new WP_Query([
							'posts_per_page' => 4,
							'offset' => 1,
							'orderby' => 'date',
							'order' => 'DESC'
						]);

						if ($trending_query->have_posts()) :
						?>
							<div class="trending-posts">
								<?php $counter = 1; while ($trending_query->have_posts()) : $trending_query->the_post(); ?>
									<article class="trending-post">
										<span class="trending-number"><?php echo $counter; ?></span>
										<div class="trending-content">
											<h4 class="trending-title">
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</h4>
											<div class="trending-meta">
												<time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('M j'); ?></time>
												<span class="trending-category">
													<?php
													$categories = get_the_category();
													if ($categories) {
														echo esc_html($categories[0]->name);
													}
													?>
												</span>
											</div>
										</div>
									</article>
								<?php $counter++; endwhile; ?>
							</div>
						<?php
						wp_reset_postdata();
						endif;
						?>
					</div>
				</div>
			</section>

			<!-- Category Sections -->
			<section class="homepage-categories">
				<?php
				// Get main categories
				$main_categories = get_categories([
					'orderby' => 'count',
					'order' => 'DESC',
					'number' => 4,
					'hide_empty' => true,
					'exclude' => [1] // Exclude 'Uncategorized'
				]);

				foreach ($main_categories as $category) :
				?>
					<div class="category-section">
						<div class="category-header">
							<h2 class="category-title">
								<a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
									<?php echo esc_html($category->name); ?>
								</a>
							</h2>
							<a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="view-all-link">
								View All <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
							</a>
						</div>
						
						<div class="category-posts">
							<?php
							$category_posts = new WP_Query([
								'posts_per_page' => 3,
								'cat' => $category->term_id,
								'post_status' => 'publish'
							]);

							if ($category_posts->have_posts()) :
								while ($category_posts->have_posts()) : $category_posts->the_post();
								?>
									<article class="category-post-card">
										<?php if (has_post_thumbnail()) : ?>
											<div class="category-post-image">
												<a href="<?php the_permalink(); ?>">
													<?php the_post_thumbnail('medium_large', ['class' => 'category-post-img']); ?>
												</a>
											</div>
										<?php endif; ?>
										<div class="category-post-content">
											<div class="category-post-meta">
												<time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('M j, Y'); ?></time>
											</div>
											<h3 class="category-post-title">
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</h3>
											<div class="category-post-excerpt">
												<?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
											</div>
											<div class="category-post-author">
												<span class="author-name">By <?php the_author(); ?></span>
											</div>
										</div>
									</article>
								<?php
								endwhile;
							endif;
							wp_reset_postdata();
							?>
						</div>
					</div>
				<?php endforeach; ?>
			</section>

			<!-- Newsletter Signup Section -->
			<section class="homepage-newsletter">
				<div class="newsletter-container">
					<div class="newsletter-content">
						<h2 class="newsletter-title">Stay in the Loop</h2>
						<p class="newsletter-description">Get the latest news and updates delivered straight to your inbox.</p>
						<form class="homepage-newsletter-form" action="#" method="post">
							<div class="newsletter-input-wrapper">
								<input type="email" class="newsletter-email-input" placeholder="Enter your email address" required>
								<button type="submit" class="newsletter-submit-btn">
									Subscribe
									<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="m9 18 6-6-6-6"/>
									</svg>
								</button>
							</div>
						</form>
					</div>
					<div class="newsletter-visual">
						<div class="newsletter-icon">
							<svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
								<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
								<polyline points="22,6 12,13 2,6"/>
							</svg>
						</div>
					</div>
				</div>
			</section>

			<!-- Latest Posts Section -->
			<section class="homepage-latest">
				<div class="latest-header">
					<h2 class="latest-title">Latest Stories</h2>
					<a href="<?php echo esc_url(home_url('/blog')); ?>" class="view-all-link">
						View All <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
					</a>
				</div>
				
				<div class="latest-posts-grid">
					<?php
					// Skip the hero post and get next 6 posts
					$latest_posts = new WP_Query([
						'posts_per_page' => 6,
						'offset' => 1,
						'post_status' => 'publish'
					]);

					if ($latest_posts->have_posts()) :
						while ($latest_posts->have_posts()) : $latest_posts->the_post();
						?>
							<article class="latest-post-card">
								<?php if (has_post_thumbnail()) : ?>
									<div class="latest-post-image">
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail('medium_large', ['class' => 'latest-post-img']); ?>
										</a>
									</div>
								<?php endif; ?>
								<div class="latest-post-content">
									<div class="latest-post-meta">
										<span class="latest-post-category">
											<?php
											$categories = get_the_category();
											if ($categories) {
												echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
											}
											?>
										</span>
										<time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('M j, Y'); ?></time>
									</div>
									<h3 class="latest-post-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h3>
									<div class="latest-post-excerpt">
										<?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?>
									</div>
									<div class="latest-post-footer">
										<div class="latest-post-author">
											<?php echo get_avatar(get_the_author_meta('ID'), 24, '', '', ['class' => 'author-avatar-small']); ?>
											<span class="author-name-small">By <?php the_author(); ?></span>
										</div>
										<a href="<?php the_permalink(); ?>" class="read-more-small">
											Read More
										</a>
									</div>
								</div>
							</article>
						<?php
						endwhile;
						wp_reset_postdata();
					endif;
					?>
				</div>
			</section>

		<?php else : ?>
			
			<div class="homepage-no-content">
				<h1>Welcome to <?php bloginfo('name'); ?></h1>
				<p>No posts found. Please add some content to get started.</p>
			</div>
			
		<?php endif; ?>

	</div>
</div>

<?php get_footer(); ?>
