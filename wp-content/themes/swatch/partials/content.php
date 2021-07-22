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
<article id="post-<?php the_ID(); ?>" <?php post_class('post-showtype ' . $post_swatch ); ?>>
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
            echo '<img class="feature-image aligncenter" src="'.$img[0].'" alt="'.oxy_post_thumbnail_name($post).'">';
            if( !is_single() || ( is_single() && oxy_get_option('blog_fancybox') == 'on' ) ) {
                $icon_class= is_single() ? 'fa fa-search-plus' : 'fa fa-link';
                echo '<i class="'.$icon_class.'"></i>';
                echo '</a>';
            }
        } ?>
    </div>
    <div class="post-head text-center">
        <h2 class="post-title">
            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'swatch-td' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
                <?php the_title(); ?>
            </a>
        </h2>
        <span class="post-author">
            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                <?php the_author(); ?>
            </a>
        </span>
        <span class="post-date">
            <?php the_time(get_option('date_format')); ?>
        </span>
        <div class="post-type">
            <?php echo has_post_thumbnail()? '<i class="fa fa-camera"></i>':'<i class="fa fa-file-text"></i>'; ?>
        </div>
    </div>
    <div class="post-body">
        <?php $stripteaser = oxy_get_option('blog_stripteaser') == 'on'? true:false; ?>
        <?php if( is_single() ) {
            the_content( '', $stripteaser );
        }
        else {
            the_content('');
            // show up to readmore tag and conditionally render the readmore
            if( oxy_get_option('blog_show_readmore') == 'on' ) {
                oxy_read_more_link();
            }
        }
        get_template_part( 'partials/social-links' );
        oxy_wp_link_pages(array('before' => '<div class="pagination pagination-centered ' . $post_swatch . '">', 'after' => '</div>'));
        ?>
    </div>
    <?php get_template_part( 'partials/post-extras' ); ?>
</article>
