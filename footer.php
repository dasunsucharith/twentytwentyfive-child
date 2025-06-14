<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package slviki
 */

?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- #content -->

	<footer class="site-footer">
		<div class="footer-container">
			<!-- Footer Main Content -->
			<div class="footer-main">
				<!-- Footer Brand -->
				<div class="footer-brand">
					<?php if (has_custom_logo()): ?>
						<div class="footer-logo">
							<?php the_custom_logo(); ?>
						</div>
					<?php else: ?>
						<h3 class="footer-site-title">
							<a href="<?php echo esc_url(home_url('/')); ?>">
								<?php bloginfo('name'); ?>
							</a>
						</h3>
					<?php endif; ?>
					
					<?php
					$description = get_bloginfo('description', 'display');
					if ($description):
					?>
						<p class="footer-description"><?php echo esc_html($description); ?></p>
					<?php endif; ?>
				</div>

				<!-- Footer Navigation -->
				<div class="footer-navigation">
					<h4 class="footer-nav-title">Quick Links</h4>
					<?php
					wp_nav_menu([
						'theme_location' => 'footer',
						'menu_class' => 'footer-nav-menu',
						'container' => false,
						'depth' => 1,
						'fallback_cb' => function() {
							// Fallback to show some default links
							echo '<ul class="footer-nav-menu">';
							echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
							echo '<li><a href="' . esc_url(home_url('/about')) . '">About</a></li>';
							echo '<li><a href="' . esc_url(home_url('/contact')) . '">Contact</a></li>';
							echo '<li><a href="' . esc_url(home_url('/privacy-policy')) . '">Privacy Policy</a></li>';
							echo '</ul>';
						}
					]);
					?>
				</div>

				<!-- Footer Contact/Info -->
				<div class="footer-info">
					<h4 class="footer-info-title">Contact</h4>
					<div class="footer-contact">
						<p>Email: info@<?php echo esc_html(str_replace(['http://', 'https://', 'www.'], '', home_url())); ?></p>
						<p>Phone: +1 (555) 123-4567</p>
					</div>
					
					<!-- Social Links -->
					<div class="footer-social">
						<?php
						$social_links = [
							'facebook' => get_theme_mod('social_facebook', ''),
							'twitter' => get_theme_mod('social_twitter', ''),
							'instagram' => get_theme_mod('social_instagram', ''),
							'youtube' => get_theme_mod('social_youtube', ''),
						];

						foreach ($social_links as $platform => $url):
							if (!empty($url)):
						?>
							<a href="<?php echo esc_url($url); ?>" class="footer-social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php echo ucfirst($platform); ?>">
								<?php echo get_social_icon($platform); ?>
							</a>
						<?php
							endif;
						endforeach;
						?>
					</div>
				</div>
			</div>

			<!-- Footer Bottom -->
			<div class="footer-bottom">
				<div class="footer-copyright">
					<p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
				</div>
				<div class="footer-credits">
					<p>Powered by <a href="https://wordpress.org/" target="_blank" rel="noopener">WordPress</a></p>
				</div>
			</div>
		</div>
	</footer><!-- .site-footer -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
