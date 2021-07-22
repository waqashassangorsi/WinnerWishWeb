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
// calculate page numbers
global $paged;
$results_per_page = get_query_var('posts_per_page');
if( empty( $paged ) ) {
    $paged = 1;
}
if( $paged == 1 ) {
    $real_count = $post_count;
}
else {
    $real_count = $post_count + ( $paged * $results_per_page - $results_per_page);
}
?>

<article id="post-<?php the_ID(); ?>" class="post-results">
    <div class="post-results-order">
        <?php echo $real_count; ?>
    </div>
    <div class="post-head">
        <h2 class="post-title">
            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'swatch-td' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
                <?php the_title(); ?>
            </a>
        </h2>
        <span class="post-author">
            <?php _e( 'by ', 'swatch-td' ); ?>
            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                <?php the_author(); ?>
            </a>
        </span>
        <span class="post-date">
            <?php _e( 'on ', 'swatch-td' ); ?>
            <?php the_time(get_option('date_format')); ?>
        </span>
    </div>
    <div class="post-body">
        <?php the_excerpt(); ?>
    </div>
</article>
<hr>
