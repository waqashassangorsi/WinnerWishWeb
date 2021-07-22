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
    global $post;
    $custom_fields  = get_post_custom($post->ID);
    $moto_title     = (isset($custom_fields[THEME_SHORT . '_moto_title']))? $custom_fields[THEME_SHORT . '_moto_title'][0]:'';
    $moto_text      = (isset($custom_fields[THEME_SHORT . '_moto_text']))? $custom_fields[THEME_SHORT . '_moto_text'][0]:'';
    $img            = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full' );
    $position       = (isset($custom_fields[THEME_SHORT.'_position']))? $custom_fields[THEME_SHORT.'_position'][0]:'';
    $swatch         = (isset($custom_fields[THEME_SHORT.'_swatch']))? $custom_fields[THEME_SHORT.'_swatch'][0]:'';
    $skills         = wp_get_post_terms( $post->ID, 'oxy_staff_skills' );
    global $more; $more = 0;
    $intro = get_the_content('');
    $more = 1; ?>
    <section class="section <?php echo $swatch; ?>">
        <div class="container">
            <div class="row-fluid">
                <div class="span4">
                    <div class="box-round box-huge">
                        <div class="box-dummy">
                        </div>
                        <figure class="box-inner">
                            <img alt="<?php echo $post->post_title; ?>" class="img-circle" src="<?php echo $img[0]; ?>">
                            <figcaption class="box-caption">
                                <h4>
                                    <?php echo $moto_title; ?>
                                </h4>
                                <p>
                                    <?php echo $moto_text; ?>
                                </p>
                            </figcaption>
                        </figure>
                    </div>
                    <ul class="inline text-center social-icons">
                    <?php
                    for( $i = 0; $i < 5; $i++){
                        $icon = (isset($custom_fields[THEME_SHORT . '_icon'.$i]))? $custom_fields[THEME_SHORT . '_icon'.$i][0]:'';
                        $link = (isset($custom_fields[THEME_SHORT . '_link'.$i]))? $custom_fields[THEME_SHORT . '_link'.$i][0]:'';
                        if( $link != ""){?>
                            <li>
                                <a data-iconcolor="<?php echo oxy_get_icon_color($icon); ?>" href="<?php echo $link; ?>" style="color: rgb(66, 87, 106);">
                                    <i class="fa fa-<?php echo $icon; ?>"></i>
                                </a>
                            </li>
                        <?php }
                    }?>
                    </ul>
                </div>
                <div class="span8">
                    <h1>
                        <?php echo $post->post_title; ?>
                        <small class="block">
                            <?php echo $position; ?>
                        </small>
                    </h1>
                    <p class="lead">
                        <?php echo $intro; ?>
                    </p>
                </div>
            </div>
        </div>
    </section><?php
    // Removing the <p></p> tags WP adds by default
    $the_content = get_the_content('', true);
    // in php < 5.5 expressions inside empty() are not allowed
    $stripped_content = strip_tags($the_content);
    if ( !empty($stripped_content) ) {
        echo apply_filters('the_content', $the_content);
    }
endif;