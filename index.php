<?php
/**
 * The main template file - Modern News Article Layout
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package slviki
 */

get_header();
?>

<div class="news-layout">
	<div class="news-container">
		
		<?php if (have_posts()) : ?>
			
			<!-- Featured Posts Section -->
			<?php if (is_home() && !is_paged()) : ?>
				<section class="featured-posts-section">
					<div class="featured-posts-grid">
						<?php
						// Get featured posts (first 3 posts)
						$featured_query = new WP_Query([
							'posts_per_page' => 3,
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

						$featured_count = 0;
						if ($featured_query->have_posts()) :
							while ($featured_query->have_posts() && $featured_count < 3) :
								$featured_query->the_post();
								$featured_count++;
								?>
								<article class="featured-post featured-post-<?php echo $featured_count; ?>">
									<?php if (has_post_thumbnail()) : ?>
										<div class="featured-post-image">
											<a href="<?php the_permalink(); ?>">
												<?php the_post_thumbnail('large', ['class' => 'featured-img']); ?>
											</a>
											<div class="featured-post-overlay">
												<div class="featured-post-meta">
													<span class="featured-post-category">
														<?php
														$categories = get_the_category();
														if ($categories) {
															echo esc_html($categories[0]->name);
														}
														?>
													</span>
													<time class="featured-post-date" datetime="<?php echo get_the_date('c'); ?>">
														<?php echo get_the_date(); ?>
													</time>
												</div>
												<h2 class="featured-post-title">
													<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
												</h2>
												<?php if ($featured_count === 1) : ?>
													<div class="featured-post-excerpt">
														<?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
													</div>
												<?php endif; ?>
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
				</section>
			<?php endif; ?>

			<!-- Main Content Area -->
			<div class="news-main-content">
				
				<!-- Main Articles Column -->
				<main id="primary" class="news-articles-main">

					<div class="news-articles-grid">
						<?php
						// Skip featured posts on first page
						if (is_home() && !is_paged()) {
							$skip_posts = $featured_count > 0 ? $featured_count : 0;
							$current_post = 0;
						}

						while (have_posts()) :
							the_post();
							
							// Skip featured posts on home page
							if (is_home() && !is_paged() && $current_post < $skip_posts) {
								$current_post++;
								continue;
							}
							?>
							
							<article id="post-<?php the_ID(); ?>" <?php post_class('news-article-card'); ?>>
								<?php if (has_post_thumbnail()) : ?>
									<div class="article-card-image">
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail('medium_large', ['class' => 'article-img']); ?>
										</a>
									</div>
								<?php endif; ?>
								
								<div class="article-card-content">
									<div class="article-card-meta">
										<span class="article-category">
											<?php
											$categories = get_the_category();
											if ($categories) {
												echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
											}
											?>
										</span>
										<time class="article-date" datetime="<?php echo get_the_date('c'); ?>">
											<?php echo get_the_date(); ?>
										</time>
									</div>
									
									<h2 class="article-card-title">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h2>
									
									<div class="article-card-excerpt">
										<?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
									</div>
									
									<div class="article-card-footer">
										<div class="article-author">
											<?php echo get_avatar(get_the_author_meta('ID'), 24, '', '', ['class' => 'author-avatar']); ?>
											<span class="author-name">By <?php the_author(); ?></span>
										</div>
										<a href="<?php the_permalink(); ?>" class="read-more-link">
											Read More <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
										</a>
									</div>
								</div>
							</article>
							
						<?php endwhile; ?>
					</div>

					<!-- Pagination -->
					<div class="news-pagination">
						<?php
						the_posts_pagination([
							'prev_text' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg> Previous',
							'next_text' => 'Next <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>',
							'mid_size' => 2,
							'type' => 'list',
							'class' => 'news-pagination-list'
						]);
						?>
					</div>

				</main>

				<!-- Sidebar -->
				<aside class="news-sidebar">
					<?php get_sidebar(); ?>
				</aside>

			</div>

		<?php else : ?>
			
			<main id="primary" class="news-articles-main">
				<?php get_template_part('template-parts/content', 'none'); ?>
			</main>
			
		<?php endif; ?>

	</div>
</div>

<?php get_footer();
