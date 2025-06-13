<?php
/**
 * Archive template
 *
 * @package slviki
 */

get_header();
?>

<main id="primary" class="site-main">
        <?php if ( have_posts() ) : ?>
                <header class="page-header">
                        <?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
                        <?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
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

