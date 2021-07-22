<?php
/**
 * Loads all theme specific admin backend functionality
 *
 * @package Swatch
 * @subpackage Admin
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.9.2
 */

include OXY_THEME_DIR . 'inc/modules/css-minify/minify-css.php';

function oxy_create_logo_css() {
    // check if we using a logo
    $css = '';
    $header_type = oxy_get_option( 'header_type' );
    $header_height = oxy_get_option( 'header_height' );
    switch( oxy_get_option('logo_type') ) {
        case 'image':
        case 'text_image':
            $img_id = oxy_get_option( 'logo_image' );
            $img = wp_get_attachment_image_src( $img_id, 'full' );
            $logo_width = $img[1];
            $logo_height = $img[2];
            $retina = '';
            // check for retina logo
            if( 'on' == oxy_get_option( 'logo_retina' ) ) {
                // set brand logo to be half width & height
                $retina .= 'width:' . ($logo_width / 2) . 'px;height:' . ($logo_height / 2 )  . 'px;';
                // use half logo height to calculate header size
                $logo_height = $logo_height / 2;
                $logo_width = $logo_width / 2;
            }
            $css = oxy_create_header_css( $header_height, $logo_width, $logo_height, $retina );
        break;
        case 'text':
            $css = oxy_create_header_css( $header_height, 10, 36 );
        break;
    }
    // append body padding rules
    $css .= oxy_create_body_padding_css( $header_type, oxy_get_option('header_position'), $header_height);
    update_option( THEME_SHORT . '-header-css', $css );
}
add_action( 'oxy-options-updated-' . THEME_SHORT . '-general', 'oxy_create_logo_css' );


// Sets the body padding depending on navbar style and height
function oxy_create_body_padding_css( $type, $style, $height ) {
    // set default padding
    $padding = '0px';
    if( $type == 'standard' && $style == 'fixed' ) {
        // add the navbar height as padding top to the body
        $padding = $height.'px';
        return <<< CSS
@media (min-width: 980px){
body{
padding-top:$padding;
}
}
CSS;
    }
    else {
        return <<< CSS
body{
padding-top:$padding;
}
CSS;

    }
}

// Creates the header css.
function oxy_create_header_css( $header_height, $brand_width, $brand_height, $retina = '' ) {
    $min_height         = $header_height.'px';
    $brand_padding      = ( ($header_height - $brand_height ) / 2).'px';
    $navbar_padding     = ( ( $header_height -24 ) /2 ).'px';
    $navbar_margin      = ( $header_height / 2 - 13).'px';
    $brand_text_padding = ( $brand_width + 6).'px';
    $brand_width        = $brand_width.'px';
    $brand_height       = $brand_height.'px';

    return <<< CSS
#masthead .standard.navbar-inner {
min-height: $min_height;
}
#masthead .brand{
min-height:24px;
padding-left:$brand_width;
padding-top: $navbar_padding;
padding-bottom: $navbar_padding;
}
#masthead .brand img{
width:$brand_width;
height:$brand_height;
margin-top: $brand_padding;
}

#masthead .brand.text-image {
padding-left:$brand_text_padding;
}

#masthead .standard.navbar .nav > li > a {
padding-top: $navbar_padding;
padding-bottom: $navbar_padding;
}
#masthead .standard.navbar .btn, .navbar .btn-group {
margin-top: $navbar_margin;
}
#masthead .standard.navbar .sidebar-widget {
padding-top: $navbar_padding;
padding-bottom: $navbar_padding;
}
CSS;
}

function oxy_update_permalinks() {
    //Ensure the $wp_rewrite global is loaded
    global $wp_rewrite;
    //Call flush_rules() as a method of the $wp_rewrite object
    $wp_rewrite->flush_rules();
}
add_action('oxy-options-updated-' . THEME_SHORT . '-post-types', 'oxy_update_permalinks');

/**
 * Saves all swatch css to swatch_css option for injecting into all pages
 *
 * @param int $post_id The ID of the swatch post.
 */
function oxy_save_swatch( $post_id ) {

    // If this isn't a 'swatch' post, don't update it.
    if( isset( $_POST['post_type'] ) ) {
        if( 'oxy_swatch' == $_POST['post_type'] ) {
            // get all swatches
            $swatches = get_posts( array(
                'post_type' => 'oxy_swatch',
                'posts_per_page' => '-1'
            ));

            $swatch_css = '';
            foreach( $swatches as $swatch ) {
                $swatch_css .= oxy_build_swatch_css( $swatch );
            }

            $swatch_css = Minify_CSS_Compressor::Process( $swatch_css );
            update_option( THEME_SHORT . '-swatches', $swatch_css );
        }
    }
}
add_action( 'save_post', 'oxy_save_swatch', 12 );

function oxy_build_swatch_css( $swatch ) {
    include_once OXY_THEME_DIR . 'inc/modules/php-sass/literals/SassColour.php';
    include_once OXY_THEME_DIR . 'inc/modules/php-sass/literals/SassNumber.php';
    include_once OXY_THEME_DIR . 'inc/modules/php-sass/literals/SassString.php';
    include_once OXY_THEME_DIR . 'inc/modules/php-sass/SassScriptFunctions.php';

    // get all custom fields
    $background      = new SassColour( get_post_meta( $swatch->ID, THEME_SHORT . '_background', true ) );
    $text            = new SassColour( get_post_meta( $swatch->ID, THEME_SHORT . '_text', true ) );
    $heading         = new SassColour( get_post_meta( $swatch->ID, THEME_SHORT . '_heading', true ) );
    $link            = new SassColour( get_post_meta( $swatch->ID, THEME_SHORT . '_link', true ) );
    $link_hover      = new SassColour( get_post_meta( $swatch->ID, THEME_SHORT . '_link_hover', true ) );
    $link_active     = new SassColour( get_post_meta( $swatch->ID, THEME_SHORT . '_link_active', true ) );
    $heading_links   = new SassColour( get_post_meta( $swatch->ID, THEME_SHORT . '_heading_links', true ) );
    $icons           = new SassColour( get_post_meta( $swatch->ID, THEME_SHORT . '_icons', true ) );
    $overlay         = new SassColour( get_post_meta( $swatch->ID, THEME_SHORT . '_overlay', true ) );
    $form_background = new SassColour( get_post_meta( $swatch->ID, THEME_SHORT . '_form_background', true ) );
    $form            = new SassColour( get_post_meta( $swatch->ID, THEME_SHORT . '_form', true ) );
    $woobutton       = new SassColour( get_post_meta( $swatch->ID, THEME_SHORT . '_woobutton', true ) );
    $woobuttontext   = new SassColour( get_post_meta( $swatch->ID, THEME_SHORT . '_woobuttontext', true ) );
    $wooproducttext  = new SassColour( get_post_meta( $swatch->ID, THEME_SHORT . '_wooproducttext', true ) );
    $wooproductlink  = new SassColour( get_post_meta( $swatch->ID, THEME_SHORT . '_wooproductlink', true ) );

    $lighten_02_background = SassScriptFunctions::lighten( $background, new SassNumber( 2 ) );
    $lighten_50_heading    = SassScriptFunctions::lighten( $heading, new SassNumber( 5 ) );
    $lighten_10_form       = SassScriptFunctions::lighten( $form, new SassNumber( 1 ) );

    $darken_50_link                  = SassScriptFunctions::darken( $form, new SassNumber( 50 ) );
    $darken_10_background            = SassScriptFunctions::darken( $background, new SassNumber( 1 ) );
    $darken_05_overlay               = SassScriptFunctions::darken( $overlay, new SassNumber( 5 ) );

    $darken_10_background_opacity_90 = SassScriptFunctions::darken( $overlay, new SassNumber( 10 ) );
    $darken_10_background_opacity_90 = SassScriptFunctions::transparentize( $darken_10_background_opacity_90, new SassNumber( .1 ) );

    $opacity_80_background = SassScriptFunctions::transparentize( $background, new SassNumber( .2 ) );
    $opacity_70_link = SassScriptFunctions::transparentize( $link, new SassNumber( .3 ) );
    $opacity_90_link = SassScriptFunctions::transparentize( $link, new SassNumber( .1 ) );
    $opacity_90_text = SassScriptFunctions::transparentize( $text, new SassNumber( .1 ) );
    $opacity_80_text = SassScriptFunctions::transparentize( $text, new SassNumber( .2 ) );

    $opacity_80_woobutton = SassScriptFunctions::lighten( $woobutton, new SassNumber( 0 ) );
    $opacity_50_wooproducttext = SassScriptFunctions::lighten( $wooproducttext, new SassNumber( 0 ) );

    $darken_5_woobutton = SassScriptFunctions::darken( $woobutton, new SassNumber( 5 ) );

    $lighten_3_woobutton = SassScriptFunctions::lighten( $woobutton, new SassNumber( 3 ) );
    $lighten_5_woobutton = SassScriptFunctions::lighten( $woobutton, new SassNumber( 5 ) );
    $lighten_7_woobutton = SassScriptFunctions::lighten( $woobutton, new SassNumber( 7 ) );
    $lighten_10_woobutton = SassScriptFunctions::lighten( $woobutton, new SassNumber( 1 ) );
    $lighten_12_woobutton = SassScriptFunctions::lighten( $woobutton, new SassNumber( 12 ) );
    $lighten_15_woobutton = SassScriptFunctions::lighten( $woobutton, new SassNumber( 15 ) );
    $lighten_17_woobutton = SassScriptFunctions::lighten( $woobutton, new SassNumber( 17 ) );
    $lighten_20_woobutton = SassScriptFunctions::lighten( $woobutton, new SassNumber( 2 ) );

return <<<CSS
/* Basic typography */
.swatch-{$swatch->post_name}, [class*="swatch-"] .swatch-{$swatch->post_name} {
  background: {$background->toString()};
  color: {$text->toString()};
}
.swatch-{$swatch->post_name} h1, .swatch-{$swatch->post_name} h2, .swatch-{$swatch->post_name} h3, .swatch-{$swatch->post_name} h4, .swatch-{$swatch->post_name} h5, [class*="swatch-"] .swatch-{$swatch->post_name} h1, [class*="swatch-"] .swatch-{$swatch->post_name} h2, [class*="swatch-"] .swatch-{$swatch->post_name} h3, [class*="swatch-"] .swatch-{$swatch->post_name} h4, [class*="swatch-"] .swatch-{$swatch->post_name} h5 {
  color: {$heading->toString()};
}
.swatch-{$swatch->post_name} h1 a, .swatch-{$swatch->post_name} h2 a, .swatch-{$swatch->post_name} h3 a, .swatch-{$swatch->post_name} h4 a, .swatch-{$swatch->post_name} h5 a, [class*="swatch-"] .swatch-{$swatch->post_name} h1 a, [class*="swatch-"] .swatch-{$swatch->post_name} h2 a, [class*="swatch-"] .swatch-{$swatch->post_name} h3 a, [class*="swatch-"] .swatch-{$swatch->post_name} h4 a, [class*="swatch-"] .swatch-{$swatch->post_name} h5 a {
  color: {$heading_links->toString()};
}
.swatch-{$swatch->post_name} h1 a:hover, .swatch-{$swatch->post_name} h2 a:hover, .swatch-{$swatch->post_name} h3 a:hover, .swatch-{$swatch->post_name} h4 a:hover, .swatch-{$swatch->post_name} h5 a:hover, [class*="swatch-"] .swatch-{$swatch->post_name} h1 a:hover, [class*="swatch-"] .swatch-{$swatch->post_name} h2 a:hover, [class*="swatch-"] .swatch-{$swatch->post_name} h3 a:hover, [class*="swatch-"] .swatch-{$swatch->post_name} h4 a:hover, [class*="swatch-"] .swatch-{$swatch->post_name} h5 a:hover {
  color: {$link->toString()};
}
.swatch-{$swatch->post_name} h1 small, .swatch-{$swatch->post_name} h2 small, .swatch-{$swatch->post_name} h3 small, .swatch-{$swatch->post_name} h4 small, .swatch-{$swatch->post_name} h5 small, [class*="swatch-"] .swatch-{$swatch->post_name} h1 small, [class*="swatch-"] .swatch-{$swatch->post_name} h2 small, [class*="swatch-"] .swatch-{$swatch->post_name} h3 small, [class*="swatch-"] .swatch-{$swatch->post_name} h4 small, [class*="swatch-"] .swatch-{$swatch->post_name} h5 small {
  color: {$lighten_50_heading->toString()};
}
.swatch-{$swatch->post_name} a, [class*="swatch-"] .swatch-{$swatch->post_name} a {
  color: {$link->toString()};
}
.swatch-{$swatch->post_name} a:hover, [class*="swatch-"] .swatch-{$swatch->post_name} a:hover {
  color: {$link_hover};
}
.swatch-{$swatch->post_name} i, [class*="swatch-"] .swatch-{$swatch->post_name} i {
  color: {$icons->toString()};
}
.swatch-{$swatch->post_name} blockquote, [class*="swatch-"] .swatch-{$swatch->post_name} blockquote {
  border-color: {$overlay->toString()};
}
.swatch-{$swatch->post_name} blockquote small, [class*="swatch-"] .swatch-{$swatch->post_name} blockquote small {
  color: {$heading->toString()};
}
.swatch-{$swatch->post_name} .super, .swatch-{$swatch->post_name} .hyper, [class*="swatch-"] .swatch-{$swatch->post_name} .super, [class*="swatch-"] .swatch-{$swatch->post_name} .hyper {
  color: {$text->toString()};
}

/* Other links */
.swatch-{$swatch->post_name} .active, [class*="swatch-"] .swatch-{$swatch->post_name} .active {
  color: {$link_active};
}
.swatch-{$swatch->post_name} .more-link:before, .swatch-{$swatch->post_name} .more-link:after, .swatch-{$swatch->post_name} .isotope-filters a:before, .swatch-{$swatch->post_name} .isotope-filters a:after, [class*="swatch-"] .swatch-{$swatch->post_name} .more-link:before, [class*="swatch-"] .swatch-{$swatch->post_name} .more-link:after, [class*="swatch-"] .swatch-{$swatch->post_name} .isotope-filters a:before, [class*="swatch-"] .swatch-{$swatch->post_name} .isotope-filters a:after {
  background-color: {$link->toString()};
}

/* hr */
.swatch-{$swatch->post_name} hr, [class*="swatch-"] .swatch-{$swatch->post_name} hr {
  border-bottom-color: {$overlay->toString()};
}

/* Pre */
.swatch-{$swatch->post_name} pre, [class*="swatch-"] .swatch-{$swatch->post_name} pre {
  background: {$text->toString()};
  color: {$background->toString()};
}

/* Buttons */
.swatch-{$swatch->post_name}.btn, .swatch-{$swatch->post_name} .btn, .swatch-{$swatch->post_name} .btn i, [class*="swatch-"] .swatch-{$swatch->post_name}.btn, [class*="swatch-"] .swatch-{$swatch->post_name} .btn, [class*="swatch-"] .swatch-{$swatch->post_name} .btn i {
  color: white;
}
.swatch-{$swatch->post_name}.btn:hover, [class*="swatch-"] .swatch-{$swatch->post_name}.btn:hover {
  background: {$lighten_02_background->toString()};
}
.swatch-{$swatch->post_name}.btn-icon-left span, .swatch-{$swatch->post_name}.btn-icon-right span, [class*="swatch-"] .swatch-{$swatch->post_name}.btn-icon-left span, [class*="swatch-"] .swatch-{$swatch->post_name}.btn-icon-right span {
  background-color: {$overlay->toString()};
}
.swatch-{$swatch->post_name}.btn-icon-left span:before, [class*="swatch-"] .swatch-{$swatch->post_name}.btn-icon-left span:before {
  border-left-color: {$overlay->toString()};
}
.swatch-{$swatch->post_name}.btn-icon-right span:before, [class*="swatch-"] .swatch-{$swatch->post_name}.btn-icon-right span:before {
  border-right-color: {$overlay->toString()};
}

/* Forms */
.swatch-{$swatch->post_name} .error .control-label, .swatch-{$swatch->post_name} .warning .control-label, .swatch-{$swatch->post_name} .success .control-label, [class*="swatch-"] .swatch-{$swatch->post_name} .error .control-label, [class*="swatch-"] .swatch-{$swatch->post_name} .warning .control-label, [class*="swatch-"] .swatch-{$swatch->post_name} .success .control-label {
  color: {$text->toString()};
}
.swatch-{$swatch->post_name} .input-append i, [class*="swatch-"] .swatch-{$swatch->post_name} .input-append i {
  background: {$opacity_80_background->toString(true)};
  color: {$icons->toString()} !important;
}
.swatch-{$swatch->post_name} select, .swatch-{$swatch->post_name} textarea, .swatch-{$swatch->post_name} input, .swatch-{$swatch->post_name} .uneditable-input, [class*="swatch-"] .swatch-{$swatch->post_name} select, [class*="swatch-"] .swatch-{$swatch->post_name} textarea, [class*="swatch-"] .swatch-{$swatch->post_name} input, [class*="swatch-"] .swatch-{$swatch->post_name} .uneditable-input {
  background: {$form_background->toString()};
  color: {$form->toString()};
}
.swatch-{$swatch->post_name} select:-moz-placeholder, .swatch-{$swatch->post_name} textarea:-moz-placeholder, .swatch-{$swatch->post_name} input:-moz-placeholder, .swatch-{$swatch->post_name} .uneditable-input:-moz-placeholder, [class*="swatch-"] .swatch-{$swatch->post_name} select:-moz-placeholder, [class*="swatch-"] .swatch-{$swatch->post_name} textarea:-moz-placeholder, [class*="swatch-"] .swatch-{$swatch->post_name} input:-moz-placeholder, [class*="swatch-"] .swatch-{$swatch->post_name} .uneditable-input:-moz-placeholder {
  color: {$lighten_50_heading->toString()};
}
.swatch-{$swatch->post_name} select:-ms-input-placeholder, .swatch-{$swatch->post_name} textarea:-ms-input-placeholder, .swatch-{$swatch->post_name} input:-ms-input-placeholder, .swatch-{$swatch->post_name} .uneditable-input:-ms-input-placeholder, [class*="swatch-"] .swatch-{$swatch->post_name} select:-ms-input-placeholder, [class*="swatch-"] .swatch-{$swatch->post_name} textarea:-ms-input-placeholder, [class*="swatch-"] .swatch-{$swatch->post_name} input:-ms-input-placeholder, [class*="swatch-"] .swatch-{$swatch->post_name} .uneditable-input:-ms-input-placeholder {
  color: {$lighten_50_heading->toString()};
}
.swatch-{$swatch->post_name} select::-webkit-input-placeholder, .swatch-{$swatch->post_name} textarea::-webkit-input-placeholder, .swatch-{$swatch->post_name} input::-webkit-input-placeholder, .swatch-{$swatch->post_name} .uneditable-input::-webkit-input-placeholder, [class*="swatch-"] .swatch-{$swatch->post_name} select::-webkit-input-placeholder, [class*="swatch-"] .swatch-{$swatch->post_name} textarea::-webkit-input-placeholder, [class*="swatch-"] .swatch-{$swatch->post_name} input::-webkit-input-placeholder, [class*="swatch-"] .swatch-{$swatch->post_name} .uneditable-input::-webkit-input-placeholder {
  color: {$lighten_50_heading->toString()};
}
.swatch-{$swatch->post_name} .fancy-select:after, [class*="swatch-"] .swatch-{$swatch->post_name} .fancy-select:after {
    color: {$link->toString()};
}

/* Tables */
.swatch-{$swatch->post_name} .table th, [class*="swatch-"] .swatch-{$swatch->post_name} .table th, .swatch-{$swatch->post_name} .table tfoot td, [class*="swatch-"] .swatch-{$swatch->post_name} .table tfoot td {
  background-color: {$opacity_70_link->toString(true)}
  text-transform: uppercase;
  color: {$background->toString()};
}
.swatch-{$swatch->post_name}.table th, [class*="swatch-"] .swatch-{$swatch->post_name}.table th, .swatch-{$swatch->post_name}.table tfoot td, .swatch-{$swatch->post_name}.table tfoot td a, [class*="swatch-"] .swatch-{$swatch->post_name}.table tfoot td, [class*="swatch-"] .swatch-{$swatch->post_name}.table tfoot td a {
  color: {$background->toString()};
  background-color: {$link->toString()};
}
.swatch-{$swatch->post_name} .table th, .swatch-{$swatch->post_name} .table td, .swatch-{$swatch->post_name} .table-bordered, [class*="swatch-"] .swatch-{$swatch->post_name} .table th, [class*="swatch-"] .swatch-{$swatch->post_name} .table td, [class*="swatch-"] .swatch-{$swatch->post_name} .table-bordered {
  border-color: {$overlay->toString()};
}
.swatch-{$swatch->post_name} .table-striped tbody > tr:nth-child(odd) > td, .swatch-{$swatch->post_name} .table-striped tbody > tr:nth-child(odd) > th, .swatch-{$swatch->post_name} .table-hover tbody tr:hover > td, .swatch-{$swatch->post_name} .table-hover tbody tr:hover > th, [class*="swatch-"] .swatch-{$swatch->post_name} .table-striped tbody > tr:nth-child(odd) > td, [class*="swatch-"] .swatch-{$swatch->post_name} .table-striped tbody > tr:nth-child(odd) > th, [class*="swatch-"] .swatch-{$swatch->post_name} .table-hover tbody tr:hover > td, [class*="swatch-"] .swatch-{$swatch->post_name} .table-hover tbody tr:hover > th {
  background: {$overlay->toString()};
}

/* Navigation menu */
.swatch-{$swatch->post_name} .navbar-inner, .swatch-{$swatch->post_name} .dropdown-menu, [class*="swatch-"] .swatch-{$swatch->post_name} .navbar-inner, [class*="swatch-"] .swatch-{$swatch->post_name} .dropdown-menu {
  background: {$background->toString()};
}
.swatch-{$swatch->post_name} .navbar a, [class*="swatch-"] .swatch-{$swatch->post_name} .navbar a {
  color: {$text->toString()};
}
.swatch-{$swatch->post_name} .navbar a.brand, [class*="swatch-"] .swatch-{$swatch->post_name} .navbar a.brand {
  color: {$text->toString()};
}
.swatch-{$swatch->post_name} .navbar a.brand:hover, [class*="swatch-"] .swatch-{$swatch->post_name} .navbar a.brand:hover {
  color: {$link->toString()};
}
.swatch-{$swatch->post_name} .navbar .nav > li > a, [class*="swatch-"] .swatch-{$swatch->post_name} .navbar .nav > li > a {
  color: {$text->toString()};
}
.swatch-{$swatch->post_name} .navbar .nav > li > a:before, [class*="swatch-"] .swatch-{$swatch->post_name} .navbar .nav > li > a:before {
  background-color: {$link->toString()};
}
.swatch-{$swatch->post_name} .navbar .btn-navbar .icon-bar, [class*="swatch-"] .swatch-{$swatch->post_name} .navbar .btn-navbar .icon-bar {
  background-color: {$link->toString()};
}
.swatch-{$swatch->post_name} .navbar .nav > .current-menu-item > a,
.swatch-{$swatch->post_name} .navbar .nav > .current-menu-item > a:hover,
.swatch-{$swatch->post_name} .navbar .nav > .current-menu-item > a:focus,
.swatch-{$swatch->post_name} .navbar .nav > li > a:focus,
.swatch-{$swatch->post_name} .navbar .nav > li > a:hover,
.swatch-{$swatch->post_name} .navbar .nav li.dropdown.open > .dropdown-toggle,
.swatch-{$swatch->post_name} .navbar .nav li.dropdown.active > .dropdown-toggle,
.swatch-{$swatch->post_name} .navbar .nav li.dropdown.open.active > .dropdown-toggle,
[class*="swatch-"] .swatch-{$swatch->post_name} .navbar .nav > .current-menu-item > a,
[class*="swatch-"] .swatch-{$swatch->post_name} .navbar .nav > .current-menu-item > a:hover,
[class*="swatch-"] .swatch-{$swatch->post_name} .navbar .nav > .current-menu-item > a:focus,
[class*="swatch-"] .swatch-{$swatch->post_name} .navbar .nav > li > a:focus,
[class*="swatch-"] .swatch-{$swatch->post_name} .navbar .nav > li > a:hover,
[class*="swatch-"] .swatch-{$swatch->post_name} .navbar .nav li.dropdown.open > .dropdown-toggle,
[class*="swatch-"] .swatch-{$swatch->post_name} .navbar .nav li.dropdown.active > .dropdown-toggle,
[class*="swatch-"] .swatch-{$swatch->post_name} .navbar .nav li.dropdown.open.active > .dropdown-toggle {
  color: {$link->toString()};
}
.swatch-{$swatch->post_name} .navbar .nav > .current-menu-item > a:before,
.swatch-{$swatch->post_name} .navbar .nav > .current-menu-item > a:hover:before,
.swatch-{$swatch->post_name} .navbar .nav > .current-menu-item > a:focus:before,
.swatch-{$swatch->post_name} .navbar .nav > li > a:focus:before,
.swatch-{$swatch->post_name} .navbar .nav > li > a:hover:before,
.swatch-{$swatch->post_name} .navbar .nav li.dropdown.open > .dropdown-toggle:before,
.swatch-{$swatch->post_name} .navbar .nav li.dropdown.active > .dropdown-toggle:before,
.swatch-{$swatch->post_name} .navbar .nav li.dropdown.open.active > .dropdown-toggle:before,
[class*="swatch-"] .swatch-{$swatch->post_name} .navbar .nav > .current-menu-item > a:before,
[class*="swatch-"] .swatch-{$swatch->post_name} .navbar .nav > .current-menu-item > a:hover:before,
[class*="swatch-"] .swatch-{$swatch->post_name} .navbar .nav > .current-menu-item > a:focus:before,
[class*="swatch-"] .swatch-{$swatch->post_name} .navbar .nav > li > a:focus:before,
[class*="swatch-"] .swatch-{$swatch->post_name} .navbar .nav > li > a:hover:before,
[class*="swatch-"] .swatch-{$swatch->post_name} .navbar .nav li.dropdown.open > .dropdown-toggle:before,
[class*="swatch-"] .swatch-{$swatch->post_name} .navbar .nav li.dropdown.active > .dropdown-toggle:before,
[class*="swatch-"] .swatch-{$swatch->post_name} .navbar .nav li.dropdown.open.active > .dropdown-toggle:before {
  color: {$link->toString()};
}
.swatch-{$swatch->post_name} .dropdown-menu li a:hover, .swatch-{$swatch->post_name} .dropdown-menu li.current_page_item a, .swatch-{$swatch->post_name} .dropdown-submenu:hover a, .swatch-{$swatch->post_name} .dropdown-submenu:focus a,
[class*="swatch-"] .swatch-{$swatch->post_name} .dropdown-menu li a:hover, [class*="swatch-"] .swatch-{$swatch->post_name} .dropdown-menu li.current_page_item a, [class*="swatch-"] .swatch-{$swatch->post_name} .dropdown-submenu:hover a,[class*="swatch-"] .swatch-{$swatch->post_name} .dropdown-submenu:focus a {
  background: {$link->toString()};
  color: {$background->toString()};
}
.swatch-{$swatch->post_name} .top-header, [class*="swatch-"] .swatch-{$swatch->post_name} .top-header {
  border-color: {$overlay->toString()};
}
@media (max-width: 979px) {
  .swatch-{$swatch->post_name}#masthead .dropdown-menu, [class*="swatch-"] .swatch-{$swatch->post_name}#masthead .dropdown-menu {
    background: {$link->toString()};
  }
  .swatch-{$swatch->post_name}#masthead .dropdown-menu a, [class*="swatch-"] .swatch-{$swatch->post_name}#masthead .dropdown-menu a {
    color: {$background->toString()};
  }
  .swatch-{$swatch->post_name}#masthead .dropdown-menu li > a:hover, .swatch-{$swatch->post_name}#masthead .dropdown-menu li > a:focus, .swatch-{$swatch->post_name}#masthead .dropdown-menu li.active > a, [class*="swatch-"] .swatch-{$swatch->post_name}#masthead .dropdown-menu li > a:hover, [class*="swatch-"] .swatch-{$swatch->post_name}#masthead .dropdown-menu li > a:focus, [class*="swatch-"] .swatch-{$swatch->post_name}#masthead .dropdown-menu li.active > a {
    background: {$darken_50_link->toString()};
  }
  .swatch-{$swatch->post_name} .nav-collapse .nav > li > a:hover, .swatch-{$swatch->post_name} .nav-collapse .nav > li > a:focus, .swatch-{$swatch->post_name} .nav-collapse .dropdown-menu a:hover, .swatch-{$swatch->post_name} .nav-collapse .dropdown-menu a:focus, [class*="swatch-"] .swatch-{$swatch->post_name} .nav-collapse .nav > li > a:hover, [class*="swatch-"] .swatch-{$swatch->post_name} .nav-collapse .nav > li > a:focus, [class*="swatch-"] .swatch-{$swatch->post_name} .nav-collapse .dropdown-menu a:hover, [class*="swatch-"] .swatch-{$swatch->post_name} .nav-collapse .dropdown-menu a:focus {
    background: none;
  }
}

/* Pagination */
.swatch-{$swatch->post_name}.pagination ul > li > a, [class*="swatch-"] .swatch-{$swatch->post_name}.pagination ul > li > a {
  background: {$background->toString()};
  color: {$text->toString()};
}
.swatch-{$swatch->post_name}.pagination ul > .active > a, .swatch-{$swatch->post_name}.pagination ul > .active > span, .swatch-{$swatch->post_name}.pagination ul > li > a:hover, .swatch-{$swatch->post_name}.pagination ul > li > .current, [class*="swatch-"] .swatch-{$swatch->post_name}.pagination ul > .active > a, [class*="swatch-"] .swatch-{$swatch->post_name}.pagination ul > .active > span, [class*="swatch-"] .swatch-{$swatch->post_name}.pagination ul > li > a:hover, [class*="swatch-"] .swatch-{$swatch->post_name}.pagination ul > li > .current {
  background: {$text->toString()};
  color: {$background->toString()};
}
.swatch-{$swatch->post_name}.pagination ul > .active > a i, .swatch-{$swatch->post_name}.pagination ul > .active > span i, .swatch-{$swatch->post_name}.pagination ul > li > a:hover i, [class*="swatch-"] .swatch-{$swatch->post_name}.pagination ul > .active > a i, [class*="swatch-"] .swatch-{$swatch->post_name}.pagination ul > .active > span i, [class*="swatch-"] .swatch-{$swatch->post_name}.pagination ul > li > a:hover i {
  color: {$background->toString()};
}
.swatch-{$swatch->post_name}.pagination ul > li > a:hover, [class*="swatch-"] .swatch-{$swatch->post_name}.pagination ul > li > a:hover {
  background: {$overlay->toString()};
  color: {$background->toString()};
}

/* Pagers */
.swatch-{$swatch->post_name} .pager li > a, .swatch-{$swatch->post_name} .pager li > span, [class*="swatch-"] .swatch-{$swatch->post_name} .pager li > a, [class*="swatch-"] .swatch-{$swatch->post_name} .pager li > span {
  background: {$text->toString()};
  color: {$background->toString()};
}
.swatch-{$swatch->post_name} .pager li > a i, .swatch-{$swatch->post_name} .pager li > span i, [class*="swatch-"] .swatch-{$swatch->post_name} .pager li > a i, [class*="swatch-"] .swatch-{$swatch->post_name} .pager li > span i {
  color: {$background->toString()};
}
.swatch-{$swatch->post_name} .pager li > a:hover, .swatch-{$swatch->post_name} .pager li > span:hover, [class*="swatch-"] .swatch-{$swatch->post_name} .pager li > a:hover, [class*="swatch-"] .swatch-{$swatch->post_name} .pager li > span:hover {
  background: {$opacity_90_text->toString(true)};
}

/* Tooltips */
.swatch-{$swatch->post_name} .tooltip-inner, [class*="swatch-"] .swatch-{$swatch->post_name} .tooltip-inner {
  background-color: {$darken_10_background_opacity_90->toString(true)};
  color: {$text->toString()};
}
.swatch-{$swatch->post_name} .tooltip.in, [class*="swatch-"] .swatch-{$swatch->post_name} .tooltip.in {
  opacity: 1;
}
.swatch-{$swatch->post_name} .tooltip.top .tooltip-arrow, [class*="swatch-"] .swatch-{$swatch->post_name} .tooltip.top .tooltip-arrow {
  border-top-color: {$darken_10_background_opacity_90->toString(true)};
}
.swatch-{$swatch->post_name} .tooltip.right .tooltip-arrow, [class*="swatch-"] .swatch-{$swatch->post_name} .tooltip.right .tooltip-arrow {
  border-right-color: {$darken_10_background_opacity_90->toString(true)};
}
.swatch-{$swatch->post_name} .tooltip.left .tooltip-arrow, [class*="swatch-"] .swatch-{$swatch->post_name} .tooltip.left .tooltip-arrow {
  border-left-color: {$darken_10_background_opacity_90->toString(true)};
}
.swatch-{$swatch->post_name} .tooltip.bottom .tooltip-arrow, [class*="swatch-"] .swatch-{$swatch->post_name} .tooltip.bottom .tooltip-arrow {
  border-bottom-color: {$darken_10_background_opacity_90->toString(true)};
}

/* Tabs & Pills */
.swatch-{$swatch->post_name} .tab-content, .swatch-{$swatch->post_name} .nav-tabs .active a, .swatch-{$swatch->post_name} .nav-tabs .active a:hover, [class*="swatch-"] .swatch-{$swatch->post_name} .tab-content, [class*="swatch-"] .swatch-{$swatch->post_name} .nav-tabs .active a, [class*="swatch-"] .swatch-{$swatch->post_name} .tab-content, [class*="swatch-"] .swatch-{$swatch->post_name} .nav-tabs .active a:hover {
  background: {$overlay->toString()};
}
.swatch-{$swatch->post_name} .nav-tabs > li > a:hover, .swatch-{$swatch->post_name} .nav-tabs > li > a:focus, [class*="swatch-"] .swatch-{$swatch->post_name} .nav-tabs > li > a:hover, [class*="swatch-"] .swatch-{$swatch->post_name} .nav-tabs > li > a:focus {
  background-color: {$overlay->toString()};
}
.swatch-{$swatch->post_name} .nav-tabs .active a, [class*="swatch-"] .swatch-{$swatch->post_name} .nav-tabs .active a {
  color: {$text->toString()};
  box-shadow: 0px 4px 0px {$link->toString()} inset;
}
.swatch-{$swatch->post_name} .nav-pills > li > a , class*="swatch-"] .swatch-{$swatch->post_name} .nav-pills > li > a {
  color: {$text->toString()};
}
.swatch-{$swatch->post_name} .nav-pills > .active > a, .swatch-{$swatch->post_name} .nav-pills > .active > a:hover, .swatch-{$swatch->post_name} .nav-pills > li > a:hover, [class*="swatch-"] .swatch-{$swatch->post_name} .nav-pills > .active > a, [class*="swatch-"] .swatch-{$swatch->post_name} .nav-pills > .active > a:hover, [class*="swatch-"] .swatch-{$swatch->post_name} .nav-pills > li > a:hover {
  background: {$link->toString()};
  color: {$background->toString()};
}

/* Affix */
.swatch-{$swatch->post_name} .docs-sidebar-nav, .swatch-{$swatch->post_name}.docs-sidebar-nav, [class*="swatch-"] .swatch-{$swatch->post_name} .docs-sidebar-nav, [class*="swatch-"] .swatch-{$swatch->post_name}.docs-sidebar-nav {
  background: none;
}
.swatch-{$swatch->post_name} .docs-sidebar-nav li a, .swatch-{$swatch->post_name}.docs-sidebar-nav li a, [class*="swatch-"] .swatch-{$swatch->post_name} .docs-sidebar-nav li a, [class*="swatch-"] .swatch-{$swatch->post_name}.docs-sidebar-nav li a {
  background: {$overlay->toString()};
}
.swatch-{$swatch->post_name} .docs-sidebar-nav li.active a, .swatch-{$swatch->post_name}.docs-sidebar-nav li.active a, [class*="swatch-"] .swatch-{$swatch->post_name} .docs-sidebar-nav li.active a, [class*="swatch-"] .swatch-{$swatch->post_name}.docs-sidebar-nav li.active a {
  background: {$link->toString()};
  color: {$background->toString()};
}

/* Badges */
.swatch-{$swatch->post_name} .badge, [class*="swatch-"] .swatch-{$swatch->post_name} .badge {
    background: {$text->toString()};
    color: {$background->toString()};
}

/* Accordion */
.swatch-{$swatch->post_name} .accordion-heading, [class*="swatch-"] .swatch-{$swatch->post_name} .accordion-heading {
  background: {$overlay->toString()};
}
.swatch-{$swatch->post_name} .accordion-body, [class*="swatch-"] .swatch-{$swatch->post_name} .accordion-body {
  background: {$background->toString()};
}

/* Misc elements */
.swatch-{$swatch->post_name} .overlay, [class*="swatch-"] .swatch-{$swatch->post_name} .overlay {
  background-color: {$overlay->toString()};
}
.swatch-{$swatch->post_name} .overlay:before, .swatch-{$swatch->post_name} .overlay:after, [class*="swatch-"] .swatch-{$swatch->post_name} .overlay:before, [class*="swatch-"] .swatch-{$swatch->post_name} .overlay:after {
  border-bottom-color: {$overlay->toString()};
}
.swatch-{$swatch->post_name} .audioplayer, [class*="swatch-"] .swatch-{$swatch->post_name} .audioplayer {
  background-color: {$overlay->toString()};
  color: {$link->toString()};
}
.swatch-{$swatch->post_name} .box-caption, [class*="swatch-"] .swatch-{$swatch->post_name} .box-caption {
  background-color: {$opacity_80_background->toString(true)};
}
.swatch-{$swatch->post_name} .social-icons li a, [class*="swatch-"] .swatch-{$swatch->post_name} .social-icons li a {
  background-color: {$darken_05_overlay->toString()};
}
.swatch-{$swatch->post_name} .social-icons li a i , [class*="swatch-"] .swatch-{$swatch->post_name} .social-icons li a i {
  color: {$background->toString()};
}
.swatch-{$swatch->post_name} .social-simple li a i , [class*="swatch-"] .swatch-{$swatch->post_name} .social-simple li a i {
  color: {$link->toString()};
}
.swatch-{$swatch->post_name} .post-extras, [class*="swatch-"] .swatch-{$swatch->post_name} .post-extras {
  color: {$text->toString()};
}
.swatch-{$swatch->post_name} .post-extras i, [class*="swatch-"] .swatch-{$swatch->post_name} .post-extras i, .swatch-{$swatch->post_name} .post-extras a, [class*="swatch-"] .swatch-{$swatch->post_name} .post-extras a {
  color: {$text->toString()};
  color: {$opacity_80_text->toString(true)};
}
.swatch-{$swatch->post_name} .post-extras a:hover, [class*="swatch-"] .swatch-{$swatch->post_name} .post-extras a:hover {
  color: {$link->toString()};
}
.swatch-{$swatch->post_name} .post-type, [class*="swatch-"] .swatch-{$swatch->post_name} .post-type {
  background: {$background->toString()};
}
.swatch-{$swatch->post_name} .post-results-order, [class*="swatch-"] .swatch-{$swatch->post_name} .post-results-order {
    color: {$background->toString()};
    background: {$link->toString()};
}
.fancy-icons-ul .swatch-{$swatch->post_name}:before, .fancy-icons-ul [class*="swatch-"] .swatch-{$swatch->post_name}:before {
  background: {$overlay->toString()};
}
.swatch-{$swatch->post_name} .wp-caption, [class*="swatch-"] .swatch-{$swatch->post_name} .wp-caption {
  background: {$background->toString()};
}

/* Pricing tables */
.swatch-{$swatch->post_name} .pricing-price, [class*="swatch-"] .swatch-{$swatch->post_name} .pricing-price {
  background: {$overlay->toString()};
  color: {$text->toString()};
}
.swatch-{$swatch->post_name} .pricing-list li, [class*="swatch-"] .swatch-{$swatch->post_name} .pricing-list li {
  border-color: {$overlay->toString()};
}

/* Flexslider Controls */
.swatch-{$swatch->post_name} .flex-direction-nav a, [class*="swatch-"] .swatch-{$swatch->post_name} .flex-direction-nav a {
  color: {$text->toString()};
}
.swatch-{$swatch->post_name} .flex-directions-fancy .flex-direction-nav a, [class*="swatch-"] .swatch-{$swatch->post_name} .flex-directions-fancy .flex-direction-nav a {
  background: {$overlay->toString()};
  color: {$link->toString()};
}

/* Widgets */
.swatch-{$swatch->post_name} .widget_tag_cloud ul a, [class*="swatch-"] .swatch-{$swatch->post_name} .widget_tag_cloud ul a {
  background: {$text->toString()};
  color: {$background->toString()};
}
.swatch-{$swatch->post_name} .widget_tag_cloud ul a:hover, [class*="swatch-"] .swatch-{$swatch->post_name} .widget_tag_cloud ul a:hover {
  background: {$opacity_90_link->toString(true)};
}
-
.widget_calendar .swatch-{$swatch->post_name} caption {
  background-color: {$background->toString()};
  color: {$link->toString()};
}
.widget_calendar .swatch-{$swatch->post_name}.table tbody a {
  color: {$background->toString()};
}
.widget_calendar .swatch-{$swatch->post_name}.table tbody a:before {
  background-color: {$link->toString()};
}

/* WOOCOMMERCE */

/* Buttons styling */
.swatch-{$swatch->post_name} .btn-primary, .swatch-{$swatch->post_name} .button {
    background: {$woobutton->toString()} !important;
    color: {$woobuttontext->toString()} !important;
}
.swatch-{$swatch->post_name} .btn-primary:hover, .swatch-{$swatch->post_name} .button:hover {
    background: {$opacity_80_woobutton->toString(true)} !important;
}
/* Product list */
.swatch-{$swatch->post_name} .products .product {
    box-shadow: 0px 4px 0px {$overlay->toString()};
    color: {$wooproducttext->toString()};
}
.swatch-{$swatch->post_name} .products .product:hover {
    box-shadow: 0px 4px 0px {$link->toString()};
}
.swatch-{$swatch->post_name} .products .product h1,
.swatch-{$swatch->post_name} .products .product h2,
.swatch-{$swatch->post_name} .products .product h3,
.swatch-{$swatch->post_name} .products .product h4,
.swatch-{$swatch->post_name} .products .product h5,
.swatch-{$swatch->post_name} .products .product a,
.swatch-{$swatch->post_name} .products .product .price {
    color: {$wooproductlink->toString()};
}
.swatch-{$swatch->post_name} .products .product .price del {
    color: {$opacity_50_wooproducttext->toString(true)};
}

/* Star rating */
.swatch-{$swatch->post_name} .star-rating:before {
    color: {$woobutton->toString()};
}
.swatch-{$swatch->post_name} .single-product-extras .star-rating:before {
    color: {$text->toString()};
}
.swatch-{$swatch->post_name} .star-rating span:before {
    color: {$wooproductlink->toString()};
}
.swatch-{$swatch->post_name} .single-product-extras .star-rating span:before {
    color: {$link->toString()};
}

/* Product list ordering */
.swatch-{$swatch->post_name} .woocommerce-ordering select {
    background: {$woobutton->toString()};
    color: {$woobuttontext->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-ordering:after {
    color: {$woobuttontext->toString()};
}

/* Product onsale */
.swatch-{$swatch->post_name} .onsale {
    background: {$woobutton->toString()};
    color: {$woobuttontext->toString()};
}

/* Single product */
.swatch-{$swatch->post_name} .single-product & .product-images .flex-control-thumbs li .flex-active, .swatch-{$swatch->post_name} .single-product & .product-images .flex-control-thumbs li img:hover {
    box-shadow: 0px 4px 0px {$woobutton->toString()};
}
.swatch-{$swatch->post_name} .product-title-big:after {
    background: {$woobutton->toString()};
}
.swatch-{$swatch->post_name} .product-nav i {
    background: {$woobutton->toString()};
    color: {$woobuttontext->toString()};
}
.swatch-{$swatch->post_name} .quantity input:first-child, .swatch-{$swatch->post_name} .quantity input:last-child {
    background: {$woobutton->toString()};
    color: {$woobuttontext->toString()};
}
.swatch-{$swatch->post_name} .product-images figcaption {
    background: {$woobutton->toString()};
}
.swatch-{$swatch->post_name} .product-images figcaption i {
    color: {$woobuttontext->toString()};
}
.swatch-{$swatch->post_name} .product-share i {
    background: {$woobutton->toString()};
    color: {$woobuttontext->toString()};
}


/* Breadcrumbs */
.swatch-{$swatch->post_name} .woocommerce-breadcrumb {
    color: {$woobuttontext->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb  a {
    color: {$woobuttontext->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb  a:hover {
    color: {$woobuttontext->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb span:nth-child(1) {
    background: {$woobutton->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb span:nth-child(1):after {
    border-left-color: {$woobutton->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb span:nth-child(1):hover {
    background: {$darken_5_woobutton->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb span:nth-child(1):hover:after {
    border-left-color: {$darken_5_woobutton->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb span:nth-child(2) {
    background: {$lighten_5_woobutton->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb span:nth-child(2):after {
    border-left-color: {$lighten_5_woobutton->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb span:nth-child(2):hover {
    background: {$lighten_3_woobutton->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb span:nth-child(2):hover:after {
    border-left-color: {$lighten_3_woobutton->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb span:nth-child(3) {
    background: {$lighten_10_woobutton->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb span:nth-child(3):after {
    border-left-color: {$lighten_10_woobutton->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb span:nth-child(3):hover {
    background: {$lighten_7_woobutton->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb span:nth-child(3):hover:after {
    border-left-color: {$lighten_7_woobutton->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb span:nth-child(4) {
    background: {$lighten_15_woobutton->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb span:nth-child(4):after {
    border-left-color: {$lighten_15_woobutton->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb span:nth-child(4):hover {
    background: {$lighten_12_woobutton->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb span:nth-child(4):hover:after {
    border-left-color: {$lighten_12_woobutton->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb span:nth-child(5) {
    background: {$lighten_20_woobutton->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb span:nth-child(5):after {
    border-left-color: {$lighten_20_woobutton->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb span:nth-child(5):hover {
    background: {$lighten_17_woobutton->toString()};
}
.swatch-{$swatch->post_name} .woocommerce-breadcrumb span:nth-child(5):hover:after {
    border-left-color: {$lighten_17_woobutton->toString()};
}

/* Messages */
.swatch-{$swatch->post_name} .alert-cart {
    background: {$overlay->toString()};
    color: {$text->toString()};
    border-color: transparent;
    z-index: 1;
}

/* Mini cart */
.swatch-{$swatch->post_name} .widget_shopping_cart_content:before {
    background-color: {$overlay->toString()};
}
.swatch-{$swatch->post_name} .mini-cart-overview a {
    background: {$text->toString()};
    color: {$background->toString()} !important;
}
.swatch-{$swatch->post_name} .mini-cart-overview a i {
    color: {$background->toString()} !important;
}
.swatch-{$swatch->post_name}  .product_list_widget li {
    border-bottom: 1px solid {$overlay->toString()};
}
.swatch-{$swatch->post_name} .mini-cart-container {
    background: {$background->toString()};
}

/* Woocommerce Tables */
.woocommerce .swatch-{$swatch->post_name} .table {
    color: {$wooproducttext->toString()};
}
.woocommerce .swatch-{$swatch->post_name} .table a {
      color: {$wooproductlink->toString()};
}
.woocommerce .swatch-{$swatch->post_name} .table th {
    background: {$woobutton->toString()};
    color: {$woobuttontext->toString()};
}
.woocommerce .swatch-{$swatch->post_name} .table tfoot td {
      background: {$lighten_7_woobutton->toString()};
      color: {$woobuttontext->toString()};
}

/* Categories */
.swatch-{$swatch->post_name}  .products .product-category h3 {
    background-color: {$opacity_80_woobutton->toString(true)};
    color: {$woobuttontext->toString()};
}
.swatch-{$swatch->post_name} .product-category:hover h3{
    background-color: {$woobutton->toString()};
}
.swatch-{$swatch->post_name} .product-category mark {
    color: {$woobuttontext->toString()};
}
.swatch-{$swatch->post_name} .term-description:after {
    background: {$woobutton->toString()};
}

/* Checkout */
.swatch-{$swatch->post_name} .order_details li {
  border-bottom-color: {$overlay->toString()};
}

/* Widgets */
.swatch-{$swatch->post_name} .widget_product_tag_cloud ul a {
    background: {$text->toString()};
    color: {$background->toString()};
}
.swatch-{$swatch->post_name} .widget_product_tag_cloud ul a:hover {
    background: {$opacity_90_link->toString(true)};
}
.swatch-{$swatch->post_name} .widget_price_filter .ui-slider .ui-slider-handle {
    background: {$link->toString()};
    box-shadow: 0px 0px 0px 2px {$background->toString()};
}
.swatch-{$swatch->post_name} .widget_price_filter .ui-slider .ui-slider-range {
    background-color: {$link->toString()};
}
CSS;
}

// remove permalink slug box from swatch edit pages
function oxy_hide_permalink_from_swatch_edit() {
    global $post_type;
    if( $post_type == 'oxy_swatch' ) {
        echo '<style type="text/css">#edit-slug-box,#view-post-btn,#post-preview,.updated p a{display: none;}</style>';
    }
}
add_action('admin_print_styles-post-new.php', 'oxy_hide_permalink_from_swatch_edit');
// Style action for the post editting page
add_action('admin_print_styles-post.php', 'oxy_hide_permalink_from_swatch_edit');

function add_custom_mime_types($mimes){
    return array_merge($mimes,array (
        'webm' => 'video/webm',
    ));
}
add_filter('upload_mimes','add_custom_mime_types');


function add_theme_plugin_nag() { ?>
  <div class="error">
      <p><?php _e('Looks like you have the <strong>Oxygenna Bootstrap Plugin</strong> Installed - this is no longer needed please delete it <a href="' . admin_url('plugins.php') . '">here on your plugins page</a>', 'swatch-admin-td'); ?></p>
  </div>
<?php
}

function admin_init() {
  // check if old bootstrap plugin is on
  $type_plugin_url = 'oxygenna-boots/oxygenna-boots.php';
  $installed_plugins = get_plugins();
  if (array_key_exists($type_plugin_url, $installed_plugins)) {
      deactivate_plugins($type_plugin_url);
      add_action('admin_notices','add_theme_plugin_nag');
  }
}
add_action('admin_init','admin_init');