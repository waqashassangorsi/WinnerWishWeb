<?php
/**
 * Themes shortcode options go here
 *
 * @package Swatch
 * @subpackage Core
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */


return array(
    'title' => __('Section Background options', 'swatch-admin-td'),
    'fields' => array(
        array(
            'name'    => __('Section Background Image', 'swatch-admin-td'),
            'id'      => 'background',
            'type'    => 'text',
            'default' => '',
            'desc'    => __('Add a background to the section', 'swatch-admin-td'),
        ),
        array(
            'name'    => __('Background Video mp4', 'swatch-admin-td'),
            'id'      => 'background_video',
            'type'    => 'text',
            'default' => '',
            'desc'    => __('Enter url of a h.264 (mp4) video to use for this rows background.', 'swatch-admin-td'),
        ),
        array(
            'name'    => __('Background Video webm', 'swatch-admin-td'),
            'id'      => 'background_video_webm',
            'type'    => 'text',
            'default' => '',
            'desc'    => __('Enter url of a webm video to use for this rows background.', 'swatch-admin-td'),
        ),
        array(
            'name'      => __('Opacity', 'swatch-admin-td'),
            'desc'      => __('Set the opacity of the image and video backgrounds', 'swatch-admin-td'),
            'id'        => 'opacity',
            'type'      => 'slider',
            'default'   => 0.2,
            'attr'      => array(
                'max'       => 0.9,
                'min'       => 0.1,
                'step'      => 0.1,
            )
        ),
        array(
            'name'    => __('Background Size', 'swatch-admin-td'),
            'desc'    => __('Choose the image size', 'swatch-admin-td'),
            'id'      => 'size',
            'type'    => 'radio',
            'options' => array(
                'cover' => __('Cover', 'swatch-admin-td'),
                'auto'  => __('Auto', 'swatch-admin-td'),
            ),
            'default' => 'cover',
        ),
        array(
            'name'    => __('Background Repeat', 'swatch-admin-td'),
            'id'      => 'repeat',
            'type'    => 'select',
            'default' => 'no-repeat',
            'options' => array(
                'no-repeat' => __('No repeat', 'swatch-admin-td'),
                'repeat-x'  => __('Repeat horizontally', 'swatch-admin-td'),
                'repeat-y'  => __('Repeat vertically', 'swatch-admin-td'),
                'repeat'    => __('Repeat horizontally and vertically', 'swatch-admin-td')
            ),
            'desc'    => __('Set if/how the image will be repeated', 'swatch-admin-td'),
        ),
        array(
        'name'    => __('Image Background Parallax', 'swatch-admin-td'),
        'id'      => 'parallax',
        'type'    => 'select',
        'default' => 'scroll',
        'options' => array(
            'scroll' => __('Scroll', 'swatch-admin-td'),
            'fixed'  => __('Fixed', 'swatch-admin-td'),
        ),
        'desc'    => __('Set the way the background scrolls with the page. Scroll = normal Fixed = Parallax effect.', 'swatch-admin-td'),
    ),
    ),
);