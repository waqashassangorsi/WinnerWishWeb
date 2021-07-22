<?php
/**
 * Shows a simple single post
 *
 * @package Swatch
 * @subpackage Frontend
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */
$post_swatch = get_post_meta( $post->ID, THEME_SHORT. '_swatch', true );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-showtype '. $post_swatch ); ?>>
    <div class="post-media overlay">
        <?php
        if( has_post_thumbnail() && !is_search()) {
            $img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
            $img_link = is_single() ? $img[0] : get_permalink();
            $link_class = is_single() ? 'class="magnific hover-animate"' : 'class="hover-animate"';
            // fancybox only in single post with fancybox and categories
            if( !is_single() || ( is_single() && oxy_get_option('blog_fancybox') == 'on' ) ) {
                echo '<a href="' . $img_link . '" ' . $link_class . '>';
            }
            echo '<img class="feature-image" src="'.$img[0].'" alt="'.oxy_post_thumbnail_name($post).'">';
            if( !is_single() || ( is_single() && oxy_get_option('blog_fancybox') == 'on' ) ) {
                $icon_class= is_single() ? 'fa fa-search-plus' : "fa fa-link";
                echo '<i class="'.$icon_class.'"></i>';
                echo '</a>';
            }
        } ?>
    </div>
    <div class="post-head text-center">
        <div class="post-type">
            <i class="fa fa-quote-left"></i>
        </div>
    </div>
    <div class="post-body">
        <?php echo do_shortcode('[blockquote who="'.get_the_title().'" cite=""]'.get_the_content().'[/blockquote]'); ?>
        <?php get_template_part( 'partials/social-links' ); ?>
        <?php oxy_wp_link_pages(array('before' => '<div class="pagination pagination-centered ' . $post_swatch . '">', 'after' => '</div>')); ?>

    </div>
    <?php get_template_part( 'partials/post-extras' ); ?>
</article>