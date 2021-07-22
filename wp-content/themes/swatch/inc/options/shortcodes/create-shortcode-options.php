<?php
/**
 * Creates theme shortcode options
 *
 * @package Swatch
 * @subpackage Admin
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.9.2
 */

if( class_exists('OxygennaShortcodeGenerator') ) {
    $shortcode_options = include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-options.php';
    // add options to accordion shortcode
    foreach( $shortcode_options as &$shortcode ) {
        if( isset($shortcode['shortcode']) && $shortcode['shortcode'] == 'socialicons') {
            for( $i = 0 ; $i < 10 ; $i++ ) {
                $shortcode['sections'][0]['fields'][] =  array(
                    'name'    => sprintf( __('Social Icon %s', 'swatch-admin-td'), $i+1 ),
                    'id'      => sprintf( __('social_icon_%s', 'swatch-admin-td'), $i+1 ),
                    'type'    => 'select',
                    'options' => 'icons',
                    'default' => '',
                    'blank'   => __('Choose a social network icon', 'swatch-admin-td'),
                    'attr'    =>  array(
                        'class'    => 'widefat',
                    ),
                );
                $shortcode['sections'][0]['fields'][] =  array(
                    'name'    => sprintf( __('Social Icon %s URL', 'swatch-admin-td'), $i+1 ),
                    'id'      => sprintf( __('social_icon_%s_url', 'swatch-admin-td'), $i+1 ),
                    'type'    => 'text',
                    'default' => '',
                    'attr'    =>  array(
                        'class'    => 'widefat',
                    ),
                );
            }
        }
        if( isset($shortcode['shortcode']) && $shortcode['shortcode'] == 'accordions'){
            for( $i = 0 ; $i < 10 ; $i++ ){
                $shortcode['sections'][0]['fields'][] =  array(
                    'name'    => sprintf( __('Accordion %s title', 'swatch-admin-td'), $i+1 ),
                    'id'      => sprintf( __('accordion_%s_title', 'swatch-admin-td'), $i+1 ),
                    'type'    => 'text',
                    'default' => '',
                    'desc'    => __('Add text to the accordion', 'swatch-admin-td'),
                );
                $shortcode['sections'][0]['fields'][] =  array(
                    'name'    => sprintf( __('Accordion %s content', 'swatch-admin-td'), $i+1 ),
                    'id'      => sprintf( __('accordion_%s_content', 'swatch-admin-td'), $i+1 ),
                    'type'    => 'textarea',
                    'default' => '',
                    'desc'    => __('Add text to the accordion', 'swatch-admin-td'),
                );
            }
        }
    }

    OxygennaShortcodeGenerator::instance()->register_shortcode_options($shortcode_options);
}