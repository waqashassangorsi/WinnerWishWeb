<?php
/**
 * Template Name: Right Sidebar
 *
 * @package Swatch
 * @subpackage Frontend
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */

get_header();
oxy_page_header();
$allow_comments = oxy_get_option( 'site_comments' );
?>
<section class="section <?php echo get_post_meta( $post->ID, THEME_SHORT. '_swatch', true ); ?>">
    <div class="container">
        <div class="row">
            <div class="span9">
                <?php while ( have_posts() ) : the_post(); ?>

                <?php get_template_part( 'partials/content', 'page' ); ?>

                <?php if( $allow_comments == 'pages' || $allow_comments == 'all' ) comments_template( '', true ); ?>

                <?php endwhile; ?>
            </div>
            <aside class="span3 sidebar">
                <?php get_sidebar(); ?>
            </aside>
        </div>
    </div>
</section>
<?php get_footer();