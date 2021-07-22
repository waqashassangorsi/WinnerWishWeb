<?php
/**
 * Themes shortcode functions go here
 *
 * @package Swatch
 * @subpackage Core
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */

/**
 * Creates a simple section shortcode
 *
 * @return Section HTML
 **/
function oxy_shortcode_section($atts , $content = '') {
    extract( shortcode_atts( array(
        'id'                    => '',
        'swatch'                => 'swatch-white',
        'title'                 => '',
        'class'                 => '',
        'description'           => '',
        'title_capitalization'  => 'text-caps',
        'disable'               => 'off',
        'padding'               => 'padded',
        'width'                 => 'no-fullwidth',
        'header_size'           => 'h2',
        'background'            => '',
        'background_video'      => '',
        'background_video_webm' => '',
        'opacity'               => 0.2,
        'size'                  => 'cover',
        'repeat'                => 'no-repeat',
        'parallax'              => 'scroll'
    ), $atts ) );

    global $oxy_is_iphone, $oxy_is_ipad, $oxy_is_android;
    $slim = $padding == 'padded'? '':'section-slim';
    $container = $width == 'fullwidth'? 'container-fluid':'container';
    $section_background = "";
    if( $background != '' ){
        $section_background .= '<div class="section-background" style="';
        $section_background .= "background-image:url('".$background."');";
        $section_background .= 'background-attachment:'.$parallax.';opacity:'.$opacity.';background-repeat:'.$repeat.';background-size:'.$size.';"></div>';
    }
    if( !$oxy_is_iphone && !$oxy_is_ipad  && !$oxy_is_android || oxy_get_option( 'mobile_videos' ) === 'on' ) {
        if( !empty( $background_video ) || !empty( $background_video_webm ) ) {
            $section_background .= '<div class="section-background" style="opacity:' . $opacity . ';">';
            $section_background .= '<video autoplay="autoplay" loop="loop" style="width: 100%; height: 100%;" class="section-background-video">';
            if( is_numeric( $background_video ) ) {
                $background_video = wp_get_attachment_url( $background_video );
            }
            if( is_numeric( $background_video_webm ) ) {
                $background_video_webm = wp_get_attachment_url( $background_video_webm );
            }
            $section_background .= !empty($background_video) ? '<source type="video/mp4" src="'.$background_video.'"/>': '';
            $section_background .= !empty($background_video_webm) ? '<source type="video/webm" src="'.$background_video_webm.'"/>': '';
            $section_background .= '</video></div>';
        }
    }

    $section_id = $id === '' ? '' : ' id="' . $id . '"';
    $section_title = ( $title != '' || $description != '' ) ? '<div class="section-header">' : '';
    $section_title .= $title != ''? '<'.$header_size.' class="headline ' . $title_capitalization .'">' . $title . '</'.$header_size.'>' :'';
    $section_title .= $description != ''? '<p>'.$description.'</p>' :'';
    $section_title .= ( $title != '' || $description != '' ) ? '</div>' : '';
    return $disable == 'off'? '<section class="section '. $slim.' ' . $swatch . ' ' . $class . '"'.$section_id.'>'.$section_background.'<div class="'.$container.'">' . $section_title . do_shortcode( $content ) . '</div></section>': do_shortcode( $content );
}
add_shortcode( 'section', 'oxy_shortcode_section' );


/* Services Section */
function oxy_shortcode_services( $atts, $content = '') {
    extract( shortcode_atts( array(
        'image_shape'   => 'box-round',
        'image_size'    => 'box-medium',
        'category'      => '',
        'count'         => 3,
        'columns'       => 3,
        'titles'        => 'show',
        'link_title'    => 'on',
        'link_image'    => 'on',
        'excerpt'       => 'show',
        'readmore'      => 'show',
        'readmore_text' => 'read more',
        'orderby'       => 'none',
        'order'         => 'ASC',
    ), $atts ) );

    $query = array(
        'post_type'   => 'oxy_service',
        'posts_per_page' => $count === '0' ? -1 : $count,
        'orderby'     => $orderby,
        'order'       => $order,
        'suppress_filters' => 0
    );

    if( !empty( $category ) ) {
        $query['tax_query'] = array(
            array(
                'taxonomy' => 'oxy_service_category',
                'field' => 'slug',
                'terms' => $category
            )
        );
    }

    global $post;
    $tmp_post = $post;
    //$readmore = $readmore == 'hide'? true:false;
    $services = get_posts( $query );
    $output = '';
    if (count($services) > 0) {
        $output .= '<ul class="unstyled row-fluid">';

        $services_per_row = $columns;
        $columns = intval($columns);
        $span = $columns > 0 ? floor( 12 / $columns ) : 12;

        $service_num = 1;
        foreach( $services as $post ) {
            setup_postdata($post);
            global $more;    // Declare global $more (before the loop).
            $more = 0;
            $icon           = get_post_meta( $post->ID, THEME_SHORT. '_icon', true );
            $icon_animation = get_post_meta( $post->ID, THEME_SHORT. '_icon_animation', true );
            $service_swatch = get_post_meta( $post->ID, THEME_SHORT. '_swatch', true );
            $image_type     = get_post_meta( $post->ID, THEME_SHORT. '_image_type', true );
            $link           = oxy_get_slide_link( $post );
            $link_target    = get_post_meta( $post->ID, THEME_SHORT. '_link_target', true );
            $image_ref      = $link_image == 'on' ? 'href="'.$link.'"':'';
            $title_ref      = $link_title == 'on' ? 'href="'.$link.'"':'';

            if( $service_num > $services_per_row){
                $output .='</ul><ul class="unstyled row-fluid">';
                $service_num = 1;
            }
            $output .= '<li class="span'.$span.'">';
            $output .= '<div class="'.$image_shape.' '.$image_size.'"><div class="box-dummy"></div>';
            if (!empty($link)) {
                $output .= '<a '.$image_ref.' class="box-inner '.$service_swatch.'" target="'.$link_target.'">';
            }
            else {
                $output .= '<span class="box-inner '.$service_swatch.'">';
            }

            // conditionally render images-icons here
            if( $image_type == 'image' || $image_type == 'both' ) {
                if ($image_shape == 'box-round') {
                    $output .= get_the_post_thumbnail( $post->ID, 'circle-image', array( 'class' => 'img-circle', 'alt' => get_the_title() ) );
                }
                else {
                    $output .= get_the_post_thumbnail( $post->ID, 'circle-image', array( 'alt' => get_the_title() ) );
                }
            }
            if( $icon != '' && ($image_type == 'icon' || $image_type == 'both') ) {
                $output .= oxy_font_awesome_icon($icon, array('data-animation' => $icon_animation));
            }
            if (!empty($link)) {
                $output .= '</a>';
            }
            else {
                $output .= '</span>';
            }
            $output .= '</div>';
            // title and stuff here
            if($titles == 'show'){
                $output .= '<h3 class="text-center">';
                if (!empty($link)) {
                    $output .= '<a '.$title_ref.' target="'.$link_target.'">' . get_the_title() . '</a>';
                }
                else {
                    $output .= '<span>' . get_the_title() . '</span>';
                }
                $output .= '</h3>';
            }
            if($excerpt == 'show'){
                // gets filtered excerpt without the [...]
                $output .= '<p class="text-center">'. get_the_content('') .'</p>';
            }
            if($readmore == 'show' && !empty($link)){
                $output .= '<a href="'.$link.'" class="more-link" target="'.$link_target.'">'.$readmore_text.'</a>';
            }
            $output .= '</li>';
            $service_num++;
        }
        $output .= '</ul>';
    }

    $post = $tmp_post;

    return oxy_shortcode_section( $atts, $output );
}
add_shortcode( 'services', 'oxy_shortcode_services' );

/**
 * The Gallery shortcode.
 *
 * This implements the functionality of the Gallery Shortcode for displaying
 * images on a post.
 *
 * @param array $attr Attributes of the shortcode.
 * @return string HTML content to display gallery.
 * @since 1.2
 */
function oxy_gallery_shortcode($attr) {
    $post = get_post();

    if ( ! empty( $attr['ids'] ) ) {
        // 'ids' is explicitly ordered, unless you specify otherwise.
        if ( empty( $attr['orderby'] ) )
            $attr['orderby'] = 'post__in';
        $attr['include'] = $attr['ids'];
    }

    // Allow plugins/themes to override the default gallery template.
    $output = apply_filters('post_gallery', '', $attr);
    if ( $output != '' )
        return $output;

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'medium',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby, 'posts_per_page' => -1) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $columns = intval($columns);
    $span_width = $columns > 0 ? floor(12/$columns) : 12;
    $gallery_rel = 'gallery-' . rand(1,100);


    $output = '<ul class="thumbnails">';
    foreach ( $attachments as $id => $attachment ) {
        $thumb = wp_get_attachment_image_src( $id, $size );
        $full = wp_get_attachment_image_src( $id, 'full' );
        $output .= '<li class="span' . $span_width . '">';
        $output .= '<div class="thumbnail">';
        $output .= '<a class="fancybox" rel="' . $gallery_rel . '" href="' . $full[0]  . '">';
        $output .= '<img src="' . $thumb[0] . '">';
        $output .= '</a>';
        if ( $captiontag && trim($attachment->post_excerpt) ) {
            $output .= '<div class="caption">';
            $output .= '<p>' . wptexturize($attachment->post_excerpt) . '</p>';
            $output .= '</div>';
        }
        $output .= '</div>';
        $output .= '</li>';
    }

    $output .= '</ul>';
    return $output;
}
add_shortcode( 'gallery', 'oxy_gallery_shortcode' );

/* ---------- TESTIMONIALS SHORTCODE ---------- */

function oxy_shortcode_testimonials( $atts , $content = '' ) {
    // setup options
    extract( shortcode_atts( array(
        'count'       => 3,
        'group'       => '',
        'title'       => '',
        'description' => '',
        'swatch'      => 'swatch-white',
        'padding'     => 'padded',
        'width'       => 'no-fullwidth',
        'class'       => '',
        'style'       => '',
        'show_image'  => 'off'

    ), $atts ) );

    $query_options = array(
        'post_type'   => 'oxy_testimonial',
        'posts_per_page' => $count === '0' ? -1 : $count,
        'order'      => 'ASC',
        'orderby'     => 'menu_order',
        'suppress_filters' => 0
    );

    if( !empty( $group ) ) {
        $query_options['tax_query'] = array(
            array(
                'taxonomy' => 'oxy_testimonial_group',
                'field' => 'slug',
                'terms' => $group
            )
        );
    }
    // fetch posts
    $items = get_posts( $query_options );
    $items_count = count( $items );
    $output = '';
    if( $items_count > 0):
        $id = 'flexslider-' . rand(1,100);
        $output.= '<div id="' . $id . '" class="flexslider feature-slider" data-flex-animation="slide" data-flex-controls-position="inside" data-flex-directions="hide" data-flex-speed="7000" data-flex-controls="show" data-flex-slideshow="true">';
        $output.= '<ul class="slides">';
        foreach ($items as $item) :
            global $post;
            $post = $item;
            $img    = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'circle-image' );
            setup_postdata($post);
            $custom_fields = get_post_custom($post->ID);
            $cite  = (isset($custom_fields[THEME_SHORT.'_citation']))? $custom_fields[THEME_SHORT.'_citation'][0]:'';
            $output.='<li>';
            $classes = 'fancy-blockquote text-center';
            if($show_image == 'on' && $img ) {
                $classes.= " fancy-blockquote-image";
            }
            $output.='<blockquote class="' . $classes .'"><p>';
            if($show_image == 'on' && $img ) {
                $output.= '<img alt="' . get_the_title() . '" class="img-circle" src="'.$img[0].'">';
            }
            $output.= get_the_content().'</p><small>'.get_the_title().'<cite title="Source Title"> '.$cite.'</cite></small></blockquote>';
        endforeach;
        $output.='</ul>';
        $output.='</div>';

            wp_reset_postdata();
    endif;
    return oxy_shortcode_section( $atts, $output );
}


add_shortcode( 'testimonials', 'oxy_shortcode_testimonials' );


/* Staff List */
function oxy_shortcode_staff_list($atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'title'            => '',
        'count'            => 3,
        'columns'          => 3,
        'style'            => '',
        'show_title'       => 'on',
        'link_title'       => 'on',
        'show_description' => 'on',
        'department'       => '',
        'link_target'      => '_self',
        'orderby'           => 'none',
        'order'             => 'ASC'
    ), $atts ) );

    $query_options = array(
        'post_type'   => 'oxy_staff',
        'posts_per_page' => $count === '0' ? -1 : $count,
        'orderby'          => $orderby,
        'order'            => $order,
        'suppress_filters' => 0
    );

    switch( $columns ){
        case '2':
        $span = 'span6';
        break;
        case '3':
        $span = 'span4';
        break;
        case '4':
        $span = 'span3';
        break;
    }

    if( !empty( $department ) ) {
        $query_options['tax_query'] = array(
            array(
                'taxonomy' => 'oxy_staff_department',
                'field' => 'slug',
                'terms' => $department
            )
        );
    }

    // fetch posts
    $members = get_posts( $query_options );
    $members_count = count( $members );
    $output = '';
    if( $members_count > 0):
        $members_per_row = $columns;
        $member_num = 1;

        $output .= '<ul class="unstyled row-fluid">';

        foreach ($members as $member) :
            global $post;
            $post = $member;
            setup_postdata($post);
            global $more;
            $more = 0;
            $custom_fields = get_post_custom($post->ID);
            $position       = (isset($custom_fields[THEME_SHORT . '_position']))? $custom_fields[THEME_SHORT . '_position'][0]:'';
            $moto_title     = (isset($custom_fields[THEME_SHORT . '_moto_title']))? $custom_fields[THEME_SHORT . '_moto_title'][0]:'';
            $moto_text      = (isset($custom_fields[THEME_SHORT . '_moto_text']))? $custom_fields[THEME_SHORT . '_moto_text'][0]:'';
            $link           = oxy_get_slide_link( $post );
            $img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'circle-image' );

            if($member_num > $members_per_row){
                $output.='</ul><ul class="unstyled row-fluid">';
                $member_num = 1;
            }

            $output.='<li class="'.$span.'"><div class="box-round box-big"><div class="box-dummy"></div><figure class="box-inner"><img alt="' . get_the_title() . '" class="img-circle" src="'.$img[0].'">';
            if( '' !== $moto_title && '' !== $moto_text ) {
                $output.='<figcaption class="box-caption"><h4>'.$moto_title.'</h4><p>'.$moto_text.'</p></figcaption>';
            }
            $output.='</figure></div>';
            if($show_title == 'on'){
                $output.= '<h3 class="text-center">';
                if($link_title == 'on'){
                    if ( !empty($link) ) {
                        $output.= '<a href="'.$link.'" target="'.$link_target.'">'.get_the_title().'</a>';
                    }
                    else {
                        $output.= '<span>' .get_the_title(). '</span>';
                    }
                }
                else{
                    $output.= get_the_title();
                }
                $output.= '<small class="block">'.$position.'</small></h3>';
            }
            if($show_description == 'on'){
                $output.='<p class="text-center">'.get_the_content('') .'</p>';
            }
            $output.='<ul class="inline text-center social-icons">';
            // render icons
            for( $i = 0; $i < 5; $i++){
                $icon = (isset($custom_fields[THEME_SHORT . '_icon'.$i]))? $custom_fields[THEME_SHORT . '_icon'.$i][0]:'haha';
                $link = (isset($custom_fields[THEME_SHORT . '_link'.$i]))? $custom_fields[THEME_SHORT . '_link'.$i][0]:'';
                if ($link !== '') {
                    $output .= '<li><a data-iconcolor="'.oxy_get_icon_color($icon).'" href="'. $link.'" target="'.$link_target.'" style="color: rgb(66, 87, 106);">';
                    $output .= oxy_font_awesome_icon($icon);
                    $output .= '</a></li>';
                }
            }
            $output.='</ul>';
            $output.='</li>';
            $member_num++;
        endforeach;
        $output .= '</ul>';
    endif;
    wp_reset_postdata();
    return oxy_shortcode_section( $atts, $output );

}
add_shortcode( 'staff_list', 'oxy_shortcode_staff_list' );



/* ---------------- FEATURED STAFF MEMBER SHORTCODE --------------- */

function oxy_shortcode_staff_featured($atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'member'         => '',
        'image_position' => 'left'
    ), $atts ) );

    $output = '';
    if($member !== '') {
        global $post;
        $post = get_post( $member );
        setup_postdata( $post );
        $custom_fields  = get_post_custom($post->ID);
        $moto_title     = (isset($custom_fields[THEME_SHORT . '_moto_title']))? $custom_fields[THEME_SHORT . '_moto_title'][0]:'';
        $moto_text      = (isset($custom_fields[THEME_SHORT . '_moto_text']))? $custom_fields[THEME_SHORT . '_moto_text'][0]:'';
        $img            = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'circle-image' );
        $position       = (isset($custom_fields[THEME_SHORT.'_position']))? $custom_fields[THEME_SHORT.'_position'][0]:'';
        $skills         = wp_get_post_terms( $post->ID, 'oxy_staff_skills' );

        $image = '<div class="span4"><div class="box-round box-huge"><div class="box-dummy"></div>';
        $image .= '<figure class="box-inner"><img alt="'  . $post->post_title . '" class="img-circle" src="'.$img[0].'">';
        $image .= '<figcaption class="box-caption"><h4>'.$moto_title.'</h4><p>'.$moto_text.'</p></figcaption></figure></div>';
        $image .= '<ul class="inline text-center social-icons">';
        for( $i = 0; $i < 5; $i++){
            $icon = (isset($custom_fields[THEME_SHORT . '_icon'.$i]))? $custom_fields[THEME_SHORT . '_icon'.$i][0]:'';
            $link = (isset($custom_fields[THEME_SHORT . '_link'.$i]))? $custom_fields[THEME_SHORT . '_link'.$i][0]:'';
            if ($link !== '') {
                $image .= '<li><a data-iconcolor="'.oxy_get_icon_color($icon).'" href="'. $link.'" style="color: rgb(66, 87, 106);">';
                $image .= oxy_font_awesome_icon($icon);
                $image .= '</a></li>';
            }
        }
        $image .= '</ul></div>';
        $content = '<div class="span8"><h1>'.$post->post_title.'<small class="block">'.$position.'</small></h1>';
        global $more; $more = 0;
        $content .= '<p class="lead">' . get_the_content('') . '</p>';
        $content .= '</div>';

        $output = $image_position === 'left' ? $image . $content : $content . $image;
        wp_reset_postdata();
    }
    return oxy_shortcode_section( $atts, '<div class="row-fluid">' . $output . '</div>' );
}
add_shortcode( 'staff_featured', 'oxy_shortcode_staff_featured' );

/* --------------------- PORTFOLIO SHORTCODES --------------------- */

function oxy_shortcode_portfolio( $atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'columns'       => 3,
        'filters_cat'   => 'show',
        'count'         => 3,
        'portfolios'    => '',
        'show_links'    => 'show',
        'show_excerpt'  => 'show',
        'show_overlay'  => 'show',
        'show_magnific' => 'show',
        'pagination'    => 'off',
        'orderby'           => 'none',
        'order'             => 'ASC',
    ), $atts ) );

    $query_options = array(
        'post_type'   => 'oxy_portfolio_image',
        'orderby'     => $orderby,
        'order'       => $order,
        'suppress_filters' => 0,
        'posts_per_page' => $count === '0' ? -1 : $count
    );

    global $paged;
    if ($pagination !== 'off') {
        // if pagination, count sets posts per page
        if ( get_query_var('paged') ) {
            $paged = get_query_var('paged');
        }
        elseif ( get_query_var('page') ) {
            $paged = get_query_var('page');
        }
        else {
            $paged = 1;
        }
        $query_options['paged'] = $paged;
        $query_options['posts_per_page'] = $count;
    }

    $filters = get_terms( 'oxy_portfolio_categories', array( 'hide_empty' => 1 ) );

    if( !empty( $portfolios ) ) {
        $selected_portfolios = explode( ',', $portfolios );
        $query_options['tax_query'][] = array(
            'taxonomy' => 'oxy_portfolio_categories',
            'field' => 'slug',
            'terms' => $selected_portfolios
        );
    }
    else {
        // use all portfolios in the filters
        $selected_portfolios = array();
        foreach( $filters as $filter ) {
            $selected_portfolios[] = $filter->slug;
        }
    }

    // fetch posts
    $posts = query_posts( $query_options );
    $output = '';
    if( $count > 0 ) {

        // Show filters for navigation
        if($filters_cat == 'show')
            $output .= oxy_portfolio_filters( $filters, $selected_portfolios );

        $output .= '<div class="row">';
        $output .= '<ul class="portfolio isotope no-transition">';

        foreach( $posts as $post ) {
            $output .= oxy_portfolio_item( $post, $filters, $columns, $show_links, $show_excerpt, $show_overlay, $show_magnific );
        }
        $output .= '</ul>';
        if($pagination == 'on'){
            $output .= oxy_portfolio_pagination();
        }
        $output .= '</div>';
    }

    wp_reset_query();
    wp_reset_postdata();
    return oxy_shortcode_section( $atts, $output );

}
add_shortcode( 'portfolio', 'oxy_shortcode_portfolio' );

function oxy_portfolio_filters( $filters, $selected_portfolios ) {
    // remove portfolios from filters
    foreach( $filters as $key => $filter ) {
        // remove portfolio from filter if not needed
        if( !in_array( $filter->slug, $selected_portfolios ) ) {
            unset( $filters[$key] );
        }
    }

    $output = '<ul class="isotope-filters small-screen-center">';
    // add all link
    $output .= '<li class="active"><a class="pseudo-border active" data-filter="*" href="#">' . __('all', 'swatch-td' ) . '</a></li>';
    foreach( $filters as $filter ) {
        $output .= '<li><a class="pseudo-border" data-filter=".filter-' . $filter->slug . '" href="#">' . $filter->name . '</a></li>';
    }
    $output .= '</ul>';
    return $output;
}

function oxy_portfolio_item( $item, $filters, $columns, $show_links, $show_excerpt, $show_overlay, $show_magnific ) {
    global $post;
    $post = $item;
    $thumbnail_id = get_post_thumbnail_id( $post->ID );
    $full_image_url = wp_get_attachment_image_src( $thumbnail_id, 'full' );
    $title = get_the_title();
    setup_postdata($post);
    $item_link = oxy_get_slide_link( $post );
    $item_data = oxy_get_portfolio_item_data( $item );

    $classes = array( 'span' . 12 / $columns );
    $filter_tags = get_the_terms( $post->ID, 'oxy_portfolio_categories' );
    if( $filter_tags && ! is_wp_error( $filter_tags ) ) {
        foreach( $filter_tags as $tag ) {
              $classes[] = 'filter-' .$tag->slug;
        }
    }
    $gallery_images = $item_data->isGallery == true ? 'data-links="'.$item_data->gallery_links.'"':'';

    $output = '<li class="portfolio-item isotope-item ' . implode( ' ', $classes ) . '" >';
    if( $show_magnific == 'show' && $show_overlay == 'hide'){
        $output .= '<a class="' . $item_data->popup_class . '" href="' . $item_data->popup_link . '" title="' . $item_data->title . '" '.$gallery_images.'>';
    }
    $output .= '<figure class="portfolio-figure">';
    $output .= get_the_post_thumbnail( $post->ID, 'portfolio-thumb', array( 'alt' => $item_data->title ) );
    if( $show_overlay == 'show'){
        $output .= '<figcaption class="'. get_post_meta( $item->ID, THEME_SHORT. '_swatch', true ) .'">';
        $output .= '<h4>';
        if($show_links == 'show'){
            if ( !empty($item_link) ) {
                $output .= '<a href="' . $item_link . '">';
            }
            // when an item has link type of no-link
            else {
                $output .= '<span>';
            }
        }
        $output .= $item_data->title;
        if($show_links == 'show'){
            if ( !empty($item_link) ) {
                $output .= '</a>';
            }
            else {
                $output .= '</span>';
            }
        }
        $output .= '</h4>';
        if($show_excerpt == 'show'){
            $output .=  strip_shortcodes( get_the_content('', true) );
        }
        $output .= '<div class="more overlay">';
        $output .= '<a class="' . $item_data->popup_class . ' pull-left" href="' . $item_data->popup_link . '" title="' . $item_data->title . '" '.$gallery_images.'>';
        $output .= oxy_font_awesome_icon($item_data->icon);
        $output .= '</a>';
        if($show_links == 'show'){
            $output .= '<a class="pull-right" href="' . $item_link . '"><i class="fa fa-link"></i></a>';
        }
        $output .= '</div>';
        $output .= '</figcaption>';
    }
    if( $show_magnific == 'show' && $show_overlay == 'hide'){
        $output .= '</a>';
    }
    $output .= '</figure>';
    $output .= '</li>';
    wp_reset_postdata();
    return $output;
}

function oxy_get_portfolio_item_data( $item ) {
    // setup post data
    global $post;
    $post = $item;
    setup_postdata($post);
    global $more;    // Declare global $more (before the loop).
    $more = 0;

    // grab the featured image
    $full_image_id = get_post_thumbnail_id( $post->ID );
    $full_image_src = wp_get_attachment_image_src( $full_image_id, 'full' );

    // create info data structure
    $info = new stdClass();
    $info->title = get_the_title( $post->ID );
    if( false !== $full_image_src ) {
        $info->full_image_url = $full_image_src[0];
    }
    else {
        $info->full_image_url = '';
    }
    // set default popup link
    $info->popup_link = $info->full_image_url;
    $info->isGallery = false;
    // post format specific data
    $format = get_post_format( $post->ID );
    if( false === $format ) {
        $format = 'standard';
    }
    switch( $format ) {
        case 'standard':
            $info->icon = 'fa fa-search-plus';
            $info->popup_class = 'magnific';
        break;
        case 'video':
            $info->icon = 'fa fa-play';
            $info->popup_class = 'magnific-vimeo';
            $video_shortcode = oxy_get_content_shortcode( $post, 'embed' );
            if( $video_shortcode !== null ) {
                if( isset( $video_shortcode[5] ) ) {
                    $video_shortcode = $video_shortcode[5];
                    if( isset( $video_shortcode[0] ) ) {
                        $info->popup_link = $video_shortcode[0];
                    }
                }
            }
        break;
        case 'gallery':
            $info->icon = 'fa fa-search-plus';
            $info->popup_class = 'magnific-gallery';
            $info->isGallery = true;
            $gallery_ids = oxy_get_content_gallery( $post );
            if( $gallery_ids !== null ) {
                if( count( $gallery_ids ) > 0 ) {
                    // ok lets create a gallery
                    $gallery_rel = 'rel="gallery' . $post->ID . '"';
                    $gallery_images = array();
                    foreach( $gallery_ids as $gallery_image_id ) {
                        $gallery_image = wp_get_attachment_image_src( $gallery_image_id, 'full');
                        $gallery_images[] = $gallery_image[0] ;
                    }
                    $info->gallery_links = implode(",", $gallery_images);
                }
            }
        break;

    }

    $info->item_link = get_permalink( $post->ID );
    return $info;
}


/* ---------------------- PIE CHART SHORTCODE -----------------  */

function oxy_shortcode_pie( $atts , $content = '' ){
    // setup options
    extract( shortcode_atts( array(
        'icon'          => '',
        'icon_animation'=> '',
        'bar_colour'    => '',
        'track_colour'  => '',
        'line_width'    => 20,
        'size'          => 200,
        'percentage'    => 50,
    ), $atts ) );

    $output = '<div class="chart easyPieChart" data-track-color="'.$track_colour.'" data-bar-color="'.$bar_colour.'" data-line-width="'.$line_width.'" data-percent="'.$percentage.'" data-size="'.$size.'">';
    $output.= '<span>'.$percentage.'</span>';
    $icon_atts = array();
    if (!empty($icon_animation)) {
        $icon_atts['data-animation'] = $icon_animation;
    }
    $output .= oxy_font_awesome_icon($icon, $icon_atts);
    $output .= '</div>';

    return $output;
}

add_shortcode( 'pie', 'oxy_shortcode_pie' );


/* --------------------- PRICING SHORTCODE ---------------------- */

function oxy_shortcode_pricing($atts , $content=''){
    extract( shortcode_atts( array(
        'heading'     => '',
        'swatch'      => 'swatch-greensea',
        'price'       =>  10,
        'per'         => '',
        'featured'    => 'no',
        'currency'    => '',
    ), $atts ) );

    switch ( $currency ) {
        case 'dollar':
            $currency = "&#36;";
        break;
        case 'euro':
            $currency = "&#128;";
        break;
        case 'pound':
            $currency = "&#163;";
        break;
        case 'yen':
            $currency = "&#165;";
        break;
        case '':
            $currency = "";
    }
    // In case of 'feature == yes' we add an extra class 'pricing-featured'
    $featured_class = ($featured == 'yes')? $output ='<div class="pricing-col ' .$swatch.' pricing-featured">' :
    $output ='<div class="pricing-col ' .$swatch.'">';

    if($heading != ""){
        $output .= '<h2 class="pricing-head">'.$heading.'</h2>';
    }
    $output.= '<h4 class="pricing-price">';
    if($currency != ""){
        $output .= '<small>'.$currency.'</small>';
    }
    $output .= $price;
    if($per != ""){
        $output .= '<span>'.$per.'</span>';
    }
    $output .='</h4>';

    return $output .do_shortcode($content) . '</div>' ;
}

add_shortcode( 'pricing' , 'oxy_shortcode_pricing');

/**
 * Fancy List Shortcode
 *
 * @return Fancy List
 **/
function oxy_shortcode_fancylist( $atts, $content = null ) {
    $output = '<ul class="fancy-icons-ul">';
    $output .= do_shortcode( $content );
    $output .= '</ul>';
    return $output;
}
add_shortcode( 'fancylist', 'oxy_shortcode_fancylist' );

/**
 * Fancy Item Shortcode - for use inside a fancylist shortcode
 *
 * @return Fancy Item HTML
 **/
function oxy_shortcode_fancyitem( $atts, $content = null) {
    extract( shortcode_atts( array(
        'list_swatch'     => 'swatch-coral',
        'icon_animation'  => '',
        'title'       => '',
        'icon'        => '',
    ), $atts ) );

    $output = '<li class="' . $list_swatch . '">';
    $icon_atts = array();
    if ($icon_animation != "") {
        $icon_atts['data-animation'] = $icon_animation;
    }
    $output .= oxy_font_awesome_icon($icon, $icon_atts);
    $output .= '<h4>';
    $output .= $title;
    $output .= '</h4>';
    $output .= '<p>';
    $output .= $content;
    $output .= '</p>';
    $output .= '</li>';
    return $output;
}
add_shortcode( 'fancyitem', 'oxy_shortcode_fancyitem' );



/*----------------- RECENT NEWS SECTION SHORTCODE AND HELPER FUNCTIONS --------------------*/

function oxy_get_recent_posts( $count, $categories, $authors = null , $post_formats = null ) {
    $query = array();
    // set post count
    global $paged;
    if ( get_query_var('paged') ) {
        $paged = get_query_var('paged');
    }
    elseif ( get_query_var('page') ) {
        $paged = get_query_var('page');
    }
    else {
        $paged = 1;
    }
    $query['paged'] = $paged;
    $query['posts_per_page'] = $count;
    // set category if selected
    if( !empty( $categories ) ) {
        $query['category_name'] = implode( ',', $categories );
    }
    // set author if selected
    if( !empty( $authors ) ) {
        $query['author'] = implode( ',', $authors );
    }
    // set post format if selected
    if( !empty( $post_formats ) ) {
        foreach( $post_formats as $key => $value ) {
            $post_formats[$key] = 'post-format-' . $value;
        }
        $query['tax_query'] = array();
        $query['tax_query'][] = array(
            'taxonomy' => 'post_format',
            'field'    => 'slug',
            'terms'    => $post_formats
        );
    }
    // fetch posts
    return query_posts( $query );
}


function oxy_shortcode_recent($atts , $content = '' ) {
    // setup options
    extract( shortcode_atts( array(
        'count'     => 3,
        'cat'       => null,
        'layout'    => 'carousel',
        'columns'   => 3,
        'enable'    => 'on',
    ), $atts ) );

    $cat = ( null === $cat ) ? null : explode( ',', $cat );

    $posts = oxy_get_recent_posts( $count, $cat );

    $output = '';
    if( !empty( $posts ) ) {
        $span = $columns == false? 'span12':'span'.(12/$columns);
        global $post;
        if( $layout == 'carousel'){
            $total_indicators = ceil( count( $posts )/$columns );
            $indicator = 0;
            $index = 1;
            $id = 'news'. rand(1,100);
            $output .= '<div class="carousel slide" id="'.$id.'"><ol class="carousel-indicators">';
            $active = 'class="active"';
            while( $indicator < $total_indicators):
                $output .= '<li data-target="#'.$id.'" data-slide-to="'. $indicator++ .'" '.$active.'></li>';
                $active = '';
            endwhile;
            $output .= '</ol>';
            $output .= '<div class="carousel-inner">';
            $output .= '<div class="item active"><div class="row-fluid">';
            foreach( $posts as $post ) {
                setup_postdata( $post );
                if($index++ > $columns):
                    $output .= '</div></div><div class="item"><div class="row-fluid">';
                    $index = 2;
                endif;
                $output .= '<div class="'.$span.'">';
                global $more;    // Declare global $more (before the loop).
                $more = 0;
                // use output buffering in order to append the results of get_template_part rendering
                ob_start();
                get_template_part( 'partials/content', get_post_format() );
                $output .= ob_get_contents();
                ob_end_clean();
                $output .= '</div>';
            }
            $output .= '</div></div></div></div>';
        }
        else{ // layout = masonry
            if ($enable == 'on') {
                $output .= '<ul class="isotope-filters small-screen-center">';
                $output .= '<li><a class="pseudo-border active" data-filter="*" href="#">' . __('all', 'swatch-td' ) . '</a></li>';
                // render category filters.
                $category_filters = ( $cat == null )? get_categories() : $cat;
                foreach ( $category_filters as $filter ){
                    $name = isset($filter->name)? $filter->name: $filter;
                    $slug = isset($filter->slug)? $filter->slug: $filter;
                    $output .= '<li><a class="pseudo-border" data-filter=".filter-'.$slug.'" href="#">'.$name.'</a></li>';
                }
                $output .= '</ul>'; //  /filters
            }
            $output .= '<div class="row"><ul class="unstyled isotope no-transition">';
            foreach( $posts as $post ) {
                setup_postdata( $post );
                $output .= '<li class="'.$span.' post-item ';
                // get the post categories in order to set up the filters
                $post_categories = get_the_category();
                if($post_categories){
                    $post_filters = array();
                    foreach($post_categories as $category) {
                        $post_filters[] = 'filter-'.$category->slug;
                    }
                    $output .= implode( ' ', $post_filters );
                }
                $output .= '">';
                global $more;    // Declare global $more (before the loop).
                $more = 0;
                ob_start();
                get_template_part( 'partials/content', get_post_format() );
                $output .= ob_get_contents();
                ob_end_clean();
                $output .= '</li>';
            }
            $output .= '</ul>'.oxy_pagination('',2,false).'</div>';
        }
    }
    // reset post data

    wp_reset_postdata();wp_reset_query();

    return oxy_shortcode_section( $atts, $output );
}

add_shortcode( 'recent_posts', 'oxy_shortcode_recent' );


/*------------------------ SLIDESHOW SHORTCODE -----------------------*/

function oxy_shortcode_slideshow($atts , $content = '' ){
    $params = shortcode_atts( array(
        'type'               => 'revolution',
        'revolution'         => '',
        'flexslider'         => '',
        'layerslider'        => '',
        'animation'          => 'slide',
        'speed'              => 7000,
        'duration'           => 600,
        'directionnav'       => 'hide',
        'directionnavtype'   => 'simple',
        'itemwidth'          => '',
        'showcontrols'       => 'show',
        'controlsposition'   => 'inside',
        'controlsalign'      => 'center',
        'captions'           => 'show',
        'captions_vertical'  => 'bottom',
        'captions_horizontal'=> 'left',
        'captions_swatch'    => 'swatch-white',
        'autostart'          => 'true',
        'tooltip'            => 'hide'
    ), $atts );

    $output = "";
    if( $params['type'] == 'revolution'){

        $output .= ( $params['revolution'] == "" )? '' : '[rev_slider '.$params['revolution'].']';
    }
    else if( $params['type'] == 'layerslider'){

        $output .= ( $params['layerslider'] == "" )? '' : '[layerslider id='.$params['layerslider'].']';
    }
    else{
        $output .= oxy_create_flexslider($params['flexslider'], $params , false);
    }

    return oxy_shortcode_section( $atts, $output );
}

add_shortcode( 'slideshow', 'oxy_shortcode_slideshow');



/* ------------ IMAGE SHORTCODE ------------- */

function oxy_shortcode_image($atts , $content = ''){
    // setup options
    extract( shortcode_atts( array(
        'size'          => 'box-medium',
        'shape'         => 'rounded',
        'source'        => '',
        'alt'           => '',
        'icon'          => '',
        'icon_animation'=> '',
        'link'          => '',
        'swatch'        => 'swatch-white',
    ), $atts ) );
    $icon_atts = array();
    if (!empty($icon_animation)) {
        $icon_atts['data-animation'] = $icon_animation;
    }
    $icon_tag = empty($icon) ? '' : oxy_font_awesome_icon($icon, $icon_atts);
    $shapeclass = '';
    $roundclass = '';
    switch ($shape) {
        case 'rounded':
            $shapeclass = 'box-round';
            $roundclass = 'img-circle';
            break;
        case 'squared':
            $shapeclass = 'box-square';
            break;
        case 'rectangular':
            $shapeclass = 'box-rect';
            break;
    }
    $tag = ($link != '')?'a':'span';
    $ref = ($tag == 'a')?' href="'.$link.'"':'';

    $output = '<div class="'.$shapeclass.' '.$size.'"><div class="box-dummy"></div><'.$tag.' class="box-inner '.$swatch.'"'.$ref.'>';
    if($source != ""){
        $output.= '<img class="'.$roundclass.'" src="'.$source.'" alt="'.$alt.'">';
    }
    $output .= $icon_tag . '</'.$tag.'></div>';

    return $output;
}

add_shortcode( 'image' , 'oxy_shortcode_image');

// just register the link shortcode
function oxy_shortcode_donothing() {
    return '';
}
add_shortcode( 'link', 'oxy_shortcode_donothing' );
add_shortcode( 'audio', 'oxy_shortcode_donothing' );


function oxy_shortcode_social_icons_list( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'size'     => 'normal',
        'style'    => 'background',
    ), $atts ) );
    $extra_class = ($style == 'nobackground')?' social-simple':'';
    $extra_class.= ($size == 'mini')? ' social-mini':'';
    $output = '<ul class="unstyled inline small-screen-center social-icons '.$extra_class.'">';
    $output .= do_shortcode( $content );
    $output .= '</ul>';
    return $output;
}
add_shortcode( 'socialicons', 'oxy_shortcode_social_icons_list' );

/**
 * Icon Item Shortcode - for use inside an iconlist shortcode
 *
 * @return Icon Item HTML
 **/
function oxy_shortcode_social_icon( $atts, $content = null) {
    extract( shortcode_atts( array(
        'url'       => '',
        'icon'      => '',
        'target'    => '_blank',
    ), $atts ) );

    $target = ( $target == '_blank')?'target="_blank"':'';
    $output = '<li>';
    $output .= '<a data-iconcolor="'.oxy_get_icon_color( $icon ).'" href="'.$url.'" '.$target.'>';
    $output .= oxy_font_awesome_icon($icon);
    $output .= '</a></li>';
    return $output;
}
add_shortcode( 'socialicon', 'oxy_shortcode_social_icon' );

/**
 * Google Map Shortcode
 *
 * @return Map HTML
 **/
function oxy_shortcode_google_map( $atts, $content = null) {
    extract( shortcode_atts( array(
        'map_type'   => 'ROADMAP',
        'map_zoom'   => 15,
        'map_style'  => 'flat',
        'marker'     => 'show',
        'latlng'     => '51.5171,0.1062',
        'address'    => '',
        'height'     => 500,
        'top_box'    => 'show',
        'bottom_box' => 'show',
    ), $atts ) );

    $map_data = array(
        'mapType'   => $map_type,
        'mapZoom'   => $map_zoom,
        'mapStyle'  => $map_style,
        'marker'    => $marker,
        'markerURL' => OXY_THEME_URI . 'images/marker.png'
    );

    $atts['latlng'] = explode('|', $latlng);
    if ($address !== '') {
        $atts['address'] = explode('|', $address);
    }
    else {
        $atts['address'] = '';
    }
    if( !empty( $atts ) ) {
        $map_data = array_merge( $map_data, $atts );
    }

    //Grabing the Google API key set in General section of the theme options
    $api_key = oxy_get_option('api_key');
    $api_key = !empty($api_key) ? 'key=' . $api_key : '';
    $api_key = esc_attr($api_key);

    $map_id = 'map' . rand(1,1000);

    wp_enqueue_script( 'google-map-api', 'https://maps.googleapis.com/maps/api/js?' . $api_key . '&v=3.35' );
    wp_enqueue_script( 'google-map', OXY_THEME_URI . 'assets/js/map.min.js', array( 'jquery', 'google-map-api' ) );
    wp_localize_script( 'google-map', $map_id, $map_data );


    $output = '<section class="section section-slim">';
    $output .= '<div id="' . $map_id . '" class="google-map" style="height:' . $height . 'px"></div>';
    if( $top_box === 'show' || $bottom_box === 'show' ) {
        $output .= '<div class="map-overlay">';
        $output .= '<div class="container">';
        $output .= '<div class="contact-details">';
        $output .= '<ul class="fancy-icons-ul">';
        if( $top_box === 'show' ) {
            $output .= oxy_contact_form_box( '1' );
        }
        if( $bottom_box === 'show' ) {
            $output .= oxy_contact_form_box( '2' );
        }
        $output .= '</ul>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
    }
    $output .= '</section>';
    return $output;
}
add_shortcode( 'map', 'oxy_shortcode_google_map' );

function oxy_contact_form_box( $option_postfix ) {
    $output = '<li class="' . oxy_get_option( 'map_overlay_swatch_' . $option_postfix ) . '">';
    $icon_animation = array(
        'data-animation' => oxy_get_option( 'map_overlay_icon_animation_' . $option_postfix )
    );
    $output .= oxy_font_awesome_icon( oxy_get_option( 'map_overlay_icon_' . $option_postfix ), $icon_animation );
    $output .= '<h4>' . oxy_get_option( 'map_overlay_title_' . $option_postfix ) . '</h4>';
    $output .= '<p>' . nl2br( oxy_get_option( 'map_overlay_content_' . $option_postfix ) ) . '</p>';
    $output .= '</li>';
    return $output;
}

/* ---------- LEAD SHORTCODE ---------- */
function oxy_shortcode_lead( $atts, $content ) {
    extract( shortcode_atts( array(
        'centered'  => 'yes'
    ), $atts ) );
    $extraclass = ( $centered == 'yes')? ' text-center':'';
    return '<p class="lead'.$extraclass.'">' . do_shortcode($content) . '</p>';
}
add_shortcode( 'lead', 'oxy_shortcode_lead' );

/* ------------------ LAYOUT SHORTCODES ------------------- */

/* ------------------ COLUMNS SHORTCODES ------------------- */
// unregister plugin hooks if old plugin is still here.
global $oxy_bootstrap;
if($oxy_bootstrap != null){
    remove_action('init', array($oxy_bootstrap, 'init'));
}

function oxy_shortcode_row( $atts, $content = null, $code ) {
    return '<div class="row-fluid">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'row', 'oxy_shortcode_row' );

function oxy_shortcode_layout( $atts, $content = null, $code ) {
    return '<div class="' . $code . '">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'span1', 'oxy_shortcode_layout' );
add_shortcode( 'span2', 'oxy_shortcode_layout' );
add_shortcode( 'span3', 'oxy_shortcode_layout' );
add_shortcode( 'span4', 'oxy_shortcode_layout' );
add_shortcode( 'span5', 'oxy_shortcode_layout' );
add_shortcode( 'span6', 'oxy_shortcode_layout' );
add_shortcode( 'span7', 'oxy_shortcode_layout' );
add_shortcode( 'span8', 'oxy_shortcode_layout' );
add_shortcode( 'span9', 'oxy_shortcode_layout' );
add_shortcode( 'span10', 'oxy_shortcode_layout' );
add_shortcode( 'span11', 'oxy_shortcode_layout' );
add_shortcode( 'span12', 'oxy_shortcode_layout' );


/* ---------------------- COMPONENTS SHORTCODES --------------------- */

/* ---- BOOTSTRAP BUTTON SHORTCODE ----- */

function oxy_shortcode_button($atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'type'        => 'default',
        'size'        => '',
        'side'        => 'left',
        'xclass'      => '',
        'link'        => '',
        'label'       => 'My button',
        'icon'        => '',
        'link_open'   => '_self'
    ), $atts ) );

    switch ($side){
        case 'left':
            if($icon != '')
                return '<a href="'. $link .'" class="btn btn-'. $type . ' '. $size.' '. $xclass . '" target="' . $link_open . '">' . oxy_font_awesome_icon($icon) . '   '. $label . '</a>';
            else
                return '<a href="'. $link .'" class="btn btn-'. $type . ' '. $size.' '. $xclass . '" target="' . $link_open . '">'. $label . '</a>';
        break;
        case 'right':
            if($icon != '')
                return '<a href="'. $link .'" class="btn btn-'. $type . ' '. $size.' '. $xclass . '" target="' . $link_open . '">'. $label . '   ' . oxy_font_awesome_icon($icon) . '</a>';
            else
                return '<a href="'. $link .'" class="btn btn-'. $type . ' '. $size.' '. $xclass . '" target="' . $link_open . '">'. $label . '</a>';
        break;

    }
}


add_shortcode( 'button', 'oxy_shortcode_button' );


/* ---- BOOTSTRAP FANCY BUTTON SHORTCODE ----- */

function oxy_shortcode_button_fancy($atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'button_swatch'     => 'swatch-coral',
        'button_animation'  => '',
        'size'              => 'default',
        'xclass'            => '',
        'link'              => '',
        'label'             => 'My button',
        'icon'              => '',
        'link_open'         => '_self',
        'rel'               => ''
    ), $atts ) );

    $animation = ( $button_animation != "") ? ' data-animation="'.$button_animation.'"' :"";
    return '<a href="'. $link .'" class="btn '. $size.' btn-icon-right '. $xclass . ' '. $button_swatch .'" target="' . $link_open . '" rel="' . $rel . '"> '. $label . '<span>' . oxy_font_awesome_icon($icon, array('data-animation' => $animation)) . '</span></a>';

}


add_shortcode( 'button-fancy', 'oxy_shortcode_button_fancy' );



/* ---- BOOTSTRAP ALERT SHORTCODE ----- */

function oxy_shortcode_alert($atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'type'        => 'default',
        'label'       => 'Warning!',
        'description' => 'Something is wrong!',

    ), $atts ) );

    return '<div class="alert ' . $type . '"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>'.$label.' </strong>'. $description .'</div>';
}


add_shortcode( 'alert', 'oxy_shortcode_alert' );

/* ----------------- BOOTSTRAP ACCORDION SHORTCODES ---------------*/

function oxy_shortcode_accordions($atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'accordion_swatch' => 'swatch-white',
    ), $atts ) );

    $id = 'accordion_'.rand(100,999);
    $pattern = get_shortcode_regex();
    $count = preg_match_all( '/'. $pattern .'/s', $content, $matches );
    //var_dump($matches);
    $lis = array();
    if( is_array( $matches ) && array_key_exists( 2, $matches ) && in_array( 'accordion', $matches[2] ) ) {
        for( $i = 0; $i < $count; $i++ ) {
            $group_id = 'group_'.rand(100,999);
            // is it a tab?
            if( 'accordion' == $matches[2][$i] ) {
                $accordion_atts = shortcode_parse_atts( $matches[3][$i] );
                $open_close_class = 'collapse';
                if( isset( $accordion_atts['state'] ) ) {
                    $open_close_class = 'open' == $accordion_atts['state'] ? 'collapse in' : 'collapse';
                }
                $lis[] = '<div class="accordion-heading">';
                $lis[] .= '<a class="accordion-toggle collapsed" data-parent="#'.$id.'" data-toggle="collapse" href="#'.$group_id.'">';
                $lis[] .= $accordion_atts['title'] .'</a></div>';
                $lis[] .= '<div class="accordion-body ' . $open_close_class . '" id="'.$group_id.'"><div class="accordion-inner">' .do_shortcode( $matches[5][$i] ) .'</div></div>';
            }
        }
    }

    return '<div class="accordion '.$accordion_swatch.'" id="'.$id.'"><div class="accordion-group">' . implode( $lis ) . '</div></div>';
}

add_shortcode( 'accordions', 'oxy_shortcode_accordions' );


function oxy_shortcode_accordion($atts , $content=''){

    return do_shortcode($content);
}

add_shortcode( 'accordion' , 'oxy_shortcode_accordion');


function oxy_shortcode_panel($atts , $content = '' ) {
    extract( shortcode_atts( array(
        'header'        => 'My header',
        'swatch'        => 'swatch-white',

    ), $atts ) );
    return '<div class="panel '.$swatch.'"><div class="panel-header overlay"><h3 class="panel-title">'.$header.'</h3></div><div class="panel-body text-center"><p>'.$content.'</p></div></div>';
}

add_shortcode( 'panel' , 'oxy_shortcode_panel');

/* ----------- BOOTSTRAP TABS AND TAB PANES SHORTCODES --------- */


function oxy_shortcode_tab($atts , $content = '' ) {
    extract( shortcode_atts( array(
        'style'        => 'top',

    ), $atts ) );
    $pattern = get_shortcode_regex();
    $count = preg_match_all( '/'. $pattern .'/s', $content, $matches );
    if( is_array( $matches ) && array_key_exists( 2, $matches ) && in_array( 'tab', $matches[2] ) ) {
        $lis  = array();
        $divs = array();
        $extraclass = ' active';
        for( $i = 0; $i < $count; $i++ ) {
            $pane_id = 'group_'.rand(100,999);
            // is it a tab?
            if( 'tab' == $matches[2][$i] ) {
                $tab_atts = wp_parse_args( $matches[3][$i] );
                $lis[] ='<li class="'.$extraclass.'"><a data-toggle="tab" href="#'.$pane_id.'">'.substr( $tab_atts['title'], 1, -1 ) .'</a></li>';
                $divs[] ='<div class="tab-pane'.$extraclass.'" id="'.$pane_id.'">'.do_shortcode( $matches[5][$i] ).'</div>';
                $extraclass = '';
            }
        }
    }
    switch ($style) {
        case 'top':
            $position = '';
            break;
        case 'bottom':
            $position = 'tabs-below';
            break;
        case 'left':
            $position = 'tabs-left';
            break;
        case 'right':
            $position = 'tabs-right';
            break;
        default:
            $position = '';
            break;
    }
    if($style == 'bottom'){
        return '<div class="tabbable '.$position.'"><div class="tab-content">'.implode( $divs ).'</div><ul class="nav nav-tabs" data-tabs="tabs">' . implode( $lis ) . '</ul></div>';
   }
    else{
        return '<div class="tabbable '.$position.'"><ul class="nav nav-tabs" data-tabs="tabs">' . implode( $lis ) . '</ul><div class="tab-content">'.implode( $divs ).'</div></div>';
    }
}

add_shortcode( 'tabs', 'oxy_shortcode_tab' );


function oxy_shortcode_tab_pane($atts , $content=''){

    return do_shortcode($content);
}

add_shortcode( 'tab' , 'oxy_shortcode_tab_pane');


/* ------------------ PROGRESS BAR SHORTCODE -------------------- */

function oxy_shortcode_progress_bar($atts , $content = '' ) {
     // setup options
    extract( shortcode_atts( array(
        'percentage'  =>  50,
        'type'        => 'progress',
        'style'       => 'progress-info',

    ), $atts ) );

    return '<div class="'. $type .' '.$style.'"><div class="bar" style="width: '.$percentage.'%"></div></div>';
}


add_shortcode( 'progress', 'oxy_shortcode_progress_bar' );

/**
 * Icon shortcode - for showing an icon
 *
 * @return Icon html
 **/
function oxy_shortcode_icon( $atts, $content = null) {
    extract( shortcode_atts( array(
        'size'       => 0,
    ), $atts ) );

    $icon_atts = array();

    if( $size !== 0 ) {
        $icon_atts['style'] = 'font-size:' . $size . 'px';
    }

    return oxy_font_awesome_icon($content, $icon_atts);
}
add_shortcode( 'icon', 'oxy_shortcode_icon' );


/**
 * Blockquote Shortcode
 *
 * @return Icon Item HTML
 **/
function oxy_shortcode_blockquote( $atts, $content ) {
    extract( shortcode_atts( array(
        'who'   => '',
        'cite'  => '',
        'align'  => 'left',
    ), $atts ) );
    $output = '<blockquote ';
    if($align == 'right')
        {
        $output .= 'class = "pull-right"';
        }
    $output .='><p>' . do_shortcode($content) .'</p>';
    if( !empty( $who ) ) {
        $output .= '<small>' . $who;
        if( !empty( $cite ) ) {
            $output .= ' <cite title="source title">' . $cite . '</cite>';
        }
        $output .= '</small>';
    }
    $output .= '</blockquote>';

    return $output;
}add_shortcode( 'blockquote', 'oxy_shortcode_blockquote' );


/**
 * Icon List Shortcode
 *
 * @return Icon List
 **/
function oxy_shortcode_iconlist( $atts, $content = null ) {
    $output = '<ul class="icons-ul">';
    $output .= do_shortcode( $content );
    $output .= '</ul>';
    return $output;
}
add_shortcode( 'iconlist', 'oxy_shortcode_iconlist' );

/**
 * Icon Item Shortcode - for use inside an iconlist shortcode
 *
 * @return Icon Item HTML
 **/
function oxy_shortcode_iconitem( $atts, $content = null) {
    extract( shortcode_atts( array(
        'icon'          => ''
    ), $atts ) );

    $output = '<li>';
    $output .= oxy_font_awesome_icon($icon);
    $output .= $content.' </li>';
    return $output;
}
add_shortcode( 'iconitem', 'oxy_shortcode_iconitem' );
