<?php
/**
 * Portfolio single template
 *
 * @package Swatch
 * @subpackage Frontend
 * @since 1.3
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */

if ( have_posts() ):
    the_post();
    // create content for post
    $stripteaser = oxy_get_option('portfolio_stripteaser') == 'on'? true:false;
    $layout = get_post_meta( $post->ID, THEME_SHORT. '_template', true );
    $content = get_the_content('', $stripteaser);
    // strip video embed from content if video post
    switch( get_post_format() ) {
        case 'video':
            $video_shortcode = oxy_get_content_shortcode( $post, 'embed' );
            if( $video_shortcode !== null ) {
                if( isset( $video_shortcode[0] ) ) {
                    $video_shortcode = $video_shortcode[0];
                    if( isset( $video_shortcode[0] ) ) {
                        $content = str_replace( $video_shortcode[0], '', $content );
                    }
                }
            }
        break;
        case 'gallery':
            $gallery_shortcode = oxy_get_content_shortcode( $post, 'gallery' );
            if( $gallery_shortcode !== null ) {
                if( isset( $gallery_shortcode[0] ) ) {
                    // show gallery
                    $gallery_ids = null;
                    if( array_key_exists( 3, $gallery_shortcode ) ) {
                        if( array_key_exists( 0, $gallery_shortcode[3] ) ) {
                            $gallery_attrs = shortcode_parse_atts( $gallery_shortcode[3][0] );
                            if( array_key_exists( 'ids', $gallery_attrs) ) {
                                $gallery_ids = explode( ',', $gallery_attrs['ids'] );
                            }
                        }
                    }
                    // strip shortcode from the content
                    $gallery_shortcode = $gallery_shortcode[0];
                    if( isset( $gallery_shortcode[0] ) ) {
                        $content = str_replace( $gallery_shortcode[0], '', $content );
                    }
                }
            }
        break;
    }
?>
<section class="section <?php echo get_post_meta( $post->ID, THEME_SHORT. '_swatch', true ); ?>">
    <div class="container">
        <div class="section-header portfolio-header">
            <h1 class="headline">
               <?php the_title(); ?>
            </h1>
            <?php if( get_previous_post(true, '', 'oxy_portfolio_categories') ) : ?>
            <a class="prev-portfolio-item" data-original-title="<?php echo __('Previous', 'swatch-td' ); ?>" data-toggle="tooltip" href="<?php echo get_permalink(get_previous_post(true, '', 'oxy_portfolio_categories')); ?>">
                <i class="fa fa-angle-left"></i>
            </a>
            <?php endif; ?>
            <?php if( get_next_post(true, '', 'oxy_portfolio_categories') ) : ?>
            <a class="next-portfolio-item" data-original-title="<?php echo __('Next', 'swatch-td' ); ?>" data-toggle="tooltip" href="<?php echo get_permalink(get_next_post(true, '', 'oxy_portfolio_categories')); ?>">
                <i class="fa fa-angle-right"></i>
            </a>
            <?php endif; ?>
        </div>
        <?php
        if( $layout == 'small' ) { ?>
            <div class="row-fluid">
                <div class="span9"><?php
        }
        switch( get_post_format() ) {
            case '':
                if( has_post_thumbnail( $post->ID ) ) { ?>
                    <figure class="portfolio-figure">
                        <?php $img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
                        <a class="magnific hover-animate" href="<?php echo $img[0]; ?>">
                            <?php the_post_thumbnail( 'full'); ?>
                            <i class="fa fa-search-plus"></i>
                        </a>
                    </figure>
                <?php }
            break;
            case 'gallery':
                if( $gallery_ids !== null ) {?>
                    <div class="portfolio-gallery">
                    <?php oxy_create_flexslider( $gallery_ids ); ?>
                    </div><?php
                }
            break;
            case 'video':
                // get video embed shortcpde
                if( isset( $video_shortcode[0] ) ) {
                    // use the video in the archives ?>
                    <figure class="portfolio-figure"> <?php
                    global $wp_embed;
                    echo do_shortcode($wp_embed->run_shortcode( $video_shortcode[0] ));
                    $content = str_replace( $video_shortcode[0], '', $content ); ?>
                    </figure> <?php
                }
            break;
        }
        if($layout == 'big') {?>
            <div class="row-fluid">
                <div class="span9"><?php
                if( get_post_meta( $post->ID, THEME_SHORT. '_description_title', true ) != '' ) {
                    echo '<h2>' . get_post_meta( $post->ID, THEME_SHORT. '_description_title', true ) . '</h2>';
                }
                if( get_post_meta( $post->ID, THEME_SHORT. '_description', true ) != '' ) {
                    echo '<p class="lead">'.get_post_meta( $post->ID, THEME_SHORT. '_description', true ) .'</p>';
                }
        }
                echo apply_filters( 'the_content', $content );
                get_template_part( 'partials/social-links' ); ?>
            </div>
            <div class="span3">
                <!-- skills section -->
                <?php
                if( $layout == 'small' ) {
                    if( get_post_meta( $post->ID, THEME_SHORT. '_description_title', true ) != '' ) {
                        echo '<h2>' . get_post_meta( $post->ID, THEME_SHORT. '_description_title', true ) . '</h2>';
                    }
                    if( get_post_meta( $post->ID, THEME_SHORT. '_description', true ) != '' ) {
                        echo '<p>'.get_post_meta( $post->ID, THEME_SHORT. '_description', true ) .'</p>';
                    }
                }
                $skills = wp_get_post_terms( $post->ID, 'oxy_portfolio_skills' );
                $link   = get_post_meta( $post->ID, THEME_SHORT. '_link', true );
                if ( !empty($skills) ) : ?>
                    <ul class="portfolio-list icons-ul overlay">
                    <?php foreach ($skills as $skill) : ?>
                        <li><i class="fa fa-li fa fa-ok"></i><?php echo $skill->name ?></li>
                    <?php endforeach; ?>
                    </ul>
                <?php endif;
                if( $link !=  '' ) : ?>
                    <a class="btn btn-large btn-url btn-icon-left block text-left overlay <?php echo get_post_meta( $post->ID, THEME_SHORT. '_swatch', true ); ?>" href="<?php echo $link; ?>">
                        <?php echo $link; ?>
                        <span><i class="fa fa-link"></i></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

    </div>
</section>
<?php endif;
$show_related = oxy_get_option( 'show_related' );
if ( $show_related == 'on' ) {
    // get related posts excluding this one.
    $cats = wp_get_post_terms( $post->ID, 'oxy_portfolio_categories' );
    if( !empty( $cats ) ) {
        $args = array(  'post_type' => 'oxy_portfolio_image' ,
                        'numberposts' => 3 ,
                        'post__not_in' => array($post->ID) ,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'oxy_portfolio_categories',
                                'field' => 'slug',
                                'terms' => $cats[0]->slug
                            )
                        )
                    );

        $related = get_posts($args);
        if( $related ) : ?>
            <section class="section <?php echo oxy_get_option( 'portfolio_related_swatch' ); ?>">
                <div class="container">
                    <div class="section-header">
                        <h2 class="headline">
                            <?php echo oxy_filter_title( oxy_get_option( 'portfolio_related_title' ) ); ?>
                        </h2>
                    </div>
                    <div class="row">
                        <ul class="portfolio">
                            <?php foreach( $related as $post ) {
                                echo oxy_portfolio_item($post, '', 3, 'show', 'show', 'show', 'show');
                            } ?>
                        </ul>
                    </div>
                </div>
            </section>
        <?php
        endif;
        wp_reset_postdata();
    }
}

