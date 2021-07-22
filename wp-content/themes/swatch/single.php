<?php
/**
 * Displays a single post
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
global $post;
$custom_fields = get_post_custom($post->ID);
if( 'show' === oxy_get_option('blog_show_header') ) {
    oxy_page_header( oxy_get_option('blog_header_swatch'), oxy_get_option('blog_title'), oxy_get_option('blog_subtitle'), 'left');
}
// if ( isset ($custom_fields[THEME_SHORT.'_thickbox']) ){
//     $img = wp_get_attachment_image_src( $custom_fields[THEME_SHORT.'_thickbox'][0], 'full' );
//     oxy_create_hero_section( $img[0] );
// } else {
//     oxy_create_hero_section();
// }

$allow_comments = oxy_get_option( 'site_comments' );
?>

<section class="section <?php echo oxy_get_option('blog_swatch'); ?>">
    <div class="container">
        <div class="row-fluid">
            <?php if( oxy_get_option('blog_layout') == 'sidebar-left' ): ?>
            <aside class="span3 sidebar">
                <?php get_sidebar(); ?>
            </aside>
            <?php endif; ?>
            <div class="<?php echo oxy_get_option('blog_layout') == 'full-width' ? 'span12':'span9' ; ?>">
                <?php while ( have_posts() ) : the_post(); ?>

                <?php get_template_part( 'partials/content', get_post_format() ); ?>
                <?php if( oxy_get_option('author_bio') == 'on') : ?>
                <?php get_template_part( 'partials/post-author-bio' ); ?>
                <?php endif; ?>

                <nav id="nav-below" class="post-navigation">
                    <ul class="pager">
                        <li class="previous"><?php previous_post_link( '%link', '<i class="fa fa-angle-left"></i> %title' ); ?></li>
                        <li class="next"><?php next_post_link( '%link', '%title <i class="fa fa-angle-right"></i>' ); ?></li>
                    </ul>
                </nav><!-- nav-below -->

                <?php if( $allow_comments == 'posts' || $allow_comments == 'all' ) comments_template( '', true ); ?>

                <?php endwhile; ?>
            </div>
            <?php if( oxy_get_option('blog_layout') == 'sidebar-right' ): ?>
            <aside class="span3 sidebar">
                <?php get_sidebar(); ?>
            </aside>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php if( oxy_get_option('related_posts') == 'on')  get_template_part( 'partials/post-related'); ?>
<?php get_footer();

