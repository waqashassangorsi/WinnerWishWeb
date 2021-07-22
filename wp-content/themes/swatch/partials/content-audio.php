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
        $stripteaser = oxy_get_option('blog_stripteaser') == 'on'? true:false;
        $content = is_single()? get_the_content( '', $stripteaser ): get_the_content('');
        // extract source from audio shortcode
        $audio_shortcode = oxy_get_content_shortcode( $post, 'audio' );
        if( $audio_shortcode !== null){
            $audio_src = null;
            if( array_key_exists( 3, $audio_shortcode ) ) {
                if( array_key_exists( 0, $audio_shortcode[3] ) ) {
                    $audio_attrs = shortcode_parse_atts( $audio_shortcode[3][0] );
                    if( array_key_exists( 'src', $audio_attrs) ) {
                        $audio_src =  $audio_attrs['src'];
                    }
                }
            }
            if($audio_src !== null){ ?>
                <audio controls="" preload="auto">
                    <source src="<?php echo $audio_src; ?>">
                </audio>
                <?php
                $content = str_replace( $audio_shortcode[0][0], '', $content );
            }
        }
        ?>
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
            <i class="fa fa-volume-up"></i>
        </div>
    </div>
    <div class="post-body">
        <?php echo apply_filters( 'the_content', $content );
            if( !is_single() && oxy_get_option('blog_show_readmore') == 'on' ){
                oxy_read_more_link();
            }
            get_template_part( 'partials/social-links' );
            oxy_wp_link_pages(array('before' => '<div class="pagination pagination-centered ' . $post_swatch . '">', 'after' => '</div>'));
        ?>
    </div>
    <?php get_template_part( 'partials/post-extras' ); ?>
</article>