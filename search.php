<?php
/**
 * Search results template
 *
 * @package slviki
 */

get_header();
?>

<main id="primary" class="site-main">
        <?php if ( have_posts() ) : ?>
                <header class="page-header">
                        <h1 class="page-title">
                                <?php
                                /* translators: %s: search query. */
                                printf( esc_html__( 'Search Results for: %s', 'slviki' ), '<span>' . get_search_query() . '</span>' );
                                ?>
                        </h1>
                </header><!-- .page-header -->

                <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'template-parts/content', get_post_type() ); ?>
                <?php endwhile; ?>

                <?php the_posts_navigation(); ?>
        <?php else : ?>
                <?php get_template_part( 'template-parts/content', 'none' ); ?>
        <?php endif; ?>
</main><!-- #main -->

<?php
get_sidebar();
get_footer();

