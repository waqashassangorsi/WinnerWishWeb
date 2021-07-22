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
    <?php
    $link_shortcode = oxy_get_content_shortcode( $post, 'link' );
    $img_link = '';
    $title = get_the_title();
    if( $link_shortcode !== null ) {
        $remove = $link_shortcode[0];
        if( isset( $link_shortcode[5] ) ) {
            $link_shortcode = $link_shortcode[5];
            if( isset( $link_shortcode[0] ) ) {
                $img_link = $link_shortcode[0];
                $title = '<a href="' . $link_shortcode[0] . '">' . get_the_title( $post->ID ) . '</a>';
                $content = str_replace( $remove, '', get_the_content() );
            }
        }
    }
    ?>
    <div class="post-media overlay">
        <?php
        if( has_post_thumbnail() && !is_search()) {
            $img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
            $link_class = 'class="hover-animate"';
            echo '<a href="' . $img_link . '" ' . $link_class . '>';
            echo '<img class="feature-image" src="'.$img[0].'" alt="'.oxy_post_thumbnail_name($post).'">';
            $icon_class = 'fa fa-link';
            echo '<i class="'.$icon_class.'"></i>';
            echo '</a>';

        } ?>
    </div>
    <div class="post-head text-center">
        <h2 class="post-title">
            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'swatch-td' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
                <?php echo $title; ?>
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
            <i class="fa fa-link"></i>
        </div>
    </div>
    <div class="post-body">
        <?php echo empty($content)? the_content(): $content; ?>
        <?php oxy_wp_link_pages(array('before' => '<div class="pagination pagination-centered ' . $post_swatch . '">', 'after' => '</div>')); ?>
    </div>
    <?php get_template_part( 'partials/post-extras' ); ?>
</article>