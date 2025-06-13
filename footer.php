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

	<footer id="colophon" class="site-footer wp-block-group alignfull has-contrast-background-color has-background has-base-color has-text-color" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)">
		<div class="footer-content-wrapper alignwide" style="display:flex; justify-content:space-between;"> <?php // Added a wrapper for flex styling consistent with block structure ?>
			<p class="has-small-font-size">
				<?php
				/* translators: %1$s: Current year, %2$s: Site name. */
				printf(
					esc_html__( 'Copyright © %1$s %2$s', 'slviki' ),
					esc_html( date_i18n( 'Y' ) ), // Gets the current year.
					esc_html( get_bloginfo( 'name' ) ) // Gets the site name.
				);
				?>
			</p>
			<p class="has-small-font-size">
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'slviki' ) ); ?>" rel="nofollow">
					<?php
					/* translators: %s: CMS name, i.e. WordPress. */
					printf( esc_html__( 'Powered by %s', 'slviki' ), 'WordPress' );
					?>
				</a>
			</p>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
```
