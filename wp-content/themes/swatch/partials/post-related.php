<?php
/**
 * Shows related posts
 *
 * @package Swatch
 * @subpackage Frontend
 * @since 1.3
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.9.2
 */
?>

<?php
    $tags = wp_get_post_tags(get_the_ID());
    $span = oxy_get_option('related_posts_per_slide') == 4? 'span3':'span4';
    if ($tags) {
        $tag_ids = array();
        foreach($tags as $individual_tag)
            $tag_ids[] = $individual_tag->term_id;

        $args=array(
            'tag__in'        => $tag_ids,
            'post__not_in'   => array(get_the_ID()),
            'posts_per_page' => oxy_get_option('related_posts_number'),
        );
        global $post;
        global $wp_query;
        $saved_query = $wp_query;
        $saved_post = $post;
        $id = 'related' . rand(1,100);
        // is_single needs global wp_query object , so we overwrite it.
        $wp_query = new wp_query( $args );
        if( $wp_query->have_posts() ) {
            // calculate the total ammount of indicators needed
            $total_indicators = ceil( $wp_query->post_count/oxy_get_option('related_posts_per_slide') ); ?>
            <section class="section <?php echo oxy_get_option('related_posts_swatch'); ?>">
                <div class="container">
                    <div class="section-header">
                        <h1 class="headline"><?php echo esc_attr( sprintf(__('Related Posts', 'swatch-td' ))); ?></h1>
                    </div>
                    <div class="carousel slide" id="<?php echo $id; ?>">
                        <ol class="carousel-indicators">
                        <?php  $indicator = 0; ?>
                        <?php while( $indicator < $total_indicators): ?>
                            <li data-target="#<?php echo $id; ?>" data-slide-to="<?php echo $indicator++; ?>"></li>
                        <?php endwhile; ?>
                        </ol>
                        <div class="carousel-inner">
                        <?php $posts_per_slide = oxy_get_option('related_posts_per_slide'); ?>
                        <?php $index = 1; ?>
                            <div class="item active">
                                <div class="row-fluid">
                        <?php while( $wp_query->have_posts() ) : ?>
                        <?php $wp_query->the_post(); ?>
                        <?php setup_postdata( $post ); ?>
                            <?php if($index++ > $posts_per_slide): ?>
                                </div></div><div class="item"><div class="row-fluid">
                            <?php $index = 1; ?>
                            <?php endif; ?>
                                    <div class="<?php echo $span; ?>">
                                    <?php
                                        global $more;    // Declare global $more (before the loop).
                                        $more = 0;
                                    ?>
                                    <?php get_template_part( 'partials/content', get_post_format() ); ?>
                                    </div>
                        <?php endwhile; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php
        }
        $post = $saved_post;
        $wp_query = $saved_query;
        wp_reset_query();
    }
