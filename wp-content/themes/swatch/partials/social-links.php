<?php
/**
 * Social Links for posts
 *
 * @package Swatch
 * @subpackage Frontend
 * @since 1.01
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.9.2
 */
if ( is_single() && (oxy_get_option( 'fb_show' ) == 'show' || oxy_get_option( 'twitter_show' ) == 'show' || oxy_get_option( 'google_show' ) == 'show' || oxy_get_option( 'pinterest_show' ) == 'show' ) ) {
    global $post;
    $permalink = get_permalink($post->ID);
    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
    $featured_image = $featured_image['0'];
    $post_title = rawurlencode(get_the_title($post->ID)); ?>
    <ul class="unstyled inline small-screen-center social-icons">
        <?php
        if( oxy_get_option( 'twitter_show' ) == 'show' ) { ?>
            <li>
                <a href="https://twitter.com/share?url=<?php echo $permalink; ?>" target="_blank" data-toggle="tooltip" title="Share on Twitter" data-iconcolor="<?php echo oxy_get_icon_color( 'fa-twitter' ); ?>">
                    <i class="fa fa-twitter"></i>
                </a>
            </li>
        <?php
        }
        if( oxy_get_option( 'google_show' ) == 'show' ) { ?>
            <li>
                <a href="https://plus.google.com/share?url=<?php echo $permalink; ?>" target="_blank" data-toggle="tooltip" title="Share on Google+" data-iconcolor="<?php echo oxy_get_icon_color( 'fa-google-plus' ); ?>">
                    <i class="fa fa-google-plus"></i>
                </a>
            </li>
        <?php
        }
        if( oxy_get_option( 'fb_show' ) == 'show' ) { ?>
           <li>
                <a href="http://www.facebook.com/sharer.php?u=<?php echo $permalink; ?>&amp;images=<?php echo $featured_image; ?>" target="_blank" data-toggle="tooltip" title="Share on Facebook" data-iconcolor="<?php echo oxy_get_icon_color( 'fa-facebook' ); ?>">
                    <i class="fa fa-facebook"></i>
                </a>
            </li>
        <?php
        }
        if( oxy_get_option('pinterest_show') == 'show' ){ ?>
            <li>
                <a href="//pinterest.com/pin/create/button/?url=<?php echo $permalink; ?>&amp;media=<?php echo $featured_image; ?>&amp;description=<?php echo $post_title; ?>" target="_blank" data-toggle="tooltip" title="Pin on Pinterest" data-iconcolor="<?php echo oxy_get_icon_color( 'fa-pinterest' ); ?>">
                    <i class="fa fa-pinterest"></i>
                </a>
            </li> <?php
        }
        if( oxy_get_option('linkedin_show') == 'show' ){ ?>
            <li>
                <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $permalink; ?>&amp;title=<?php echo $post_title; ?>" target="_blank" data-toggle="tooltip" title="Pin on LinkedIn" data-iconcolor="<?php echo oxy_get_icon_color( 'fa-linkedin' ); ?>">
                    <i class="fa fa-linkedin"></i>
                </a>
            </li> <?php
        } ?>
    </ul><?php
}
