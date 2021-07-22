<?php
/**
 * Test Options Page
 *
 * @package Swatch
 * @subpackage options-pages
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */


$options = array(
    'sections'   => array(
        'social-section' => array(
            'fields' => array()
        )
    )
);

$options['sections']['social-section']['fields'][] =  array(
    'name' => __('Open links in new window', 'swatch-admin-td'),
    'id' => 'social_window',
    'type' => 'checkbox',
    'default' => 'on'
);

$options['sections']['social-section']['fields'][] =  array(
    'name' => __('Social icons style', 'swatch-admin-td'),
    'id' => 'social_style',
    'type' => 'select',
    'options'    =>  array(
              1  => 'With background',
              2  => 'No background'
    ),
    'default'   => 1,
);

$options['sections']['social-section']['fields'][] =  array(
    'name' => __('Social icons size', 'swatch-admin-td'),
    'id' => 'social_size',
    'type' => 'select',
    'options'    =>  array(
              1  => 'normal',
              2  => 'mini'
    ),
    'default'   => 1,
);


for( $i = 0 ; $i < 10 ; $i++ ) {

    $options['sections']['social-section']['fields'][] = array(
        'name'    => sprintf( __('Social %s Icon', 'swatch-admin-td'), $i+1 ),
        'id'      => 'social' . $i . '_icon',
        'type'    => 'select',
        'options' => 'icons',
        'default' => '',
        'blank'   => __('Choose a social network icon', 'swatch-admin-td'),
        'attr'    =>  array(
            'class'    => 'widefat',
        ),
    );
    $options['sections']['social-section']['fields'][] = array(
        'name'    => sprintf( __('Social %s URL ', 'swatch-admin-td'), $i+1 ),
        'id'      => 'social' . $i . '_url',
        'type'    => 'text',
        'default' => '',
        'attr'    =>  array(
            'class'    => 'widefat',
        ),
    );
}

return $options;