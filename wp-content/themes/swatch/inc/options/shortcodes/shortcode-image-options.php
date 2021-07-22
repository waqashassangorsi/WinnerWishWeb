<?php
/**
 * Themes shortcode image options go here
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
        'title' => __('Image options', 'swatch-admin-td'),
        'fields' => array(
            array(
                'name'    => __('Image Shape', 'swatch-admin-td'),
                'desc'    => __('Choose the shape of the image', 'swatch-admin-td'),
                'id'      => 'image_shape',
                'type'    => 'select',
                'options' => array(
                    'box-round'    => __('Round', 'swatch-admin-td'),
                    'box-rect'     => __('Rectangle', 'swatch-admin-td'),
                    'box-square'   => __('Square', 'swatch-admin-td'),
                ),
                'default' => 'box-round',
            ),
            array(
                'name'    => __('Image Size', 'swatch-admin-td'),
                'desc'    => __('Choose the size of the image', 'swatch-admin-td'),
                'id'      => 'image_size',
                'type'    => 'select',
                'options' => array(
                    'box-mini'    => __('Mini', 'swatch-admin-td'),
                    'no-small'    => __('Small', 'swatch-admin-td'),
                    'box-medium'  => __('Medium', 'swatch-admin-td'),
                    'box-big'     => __('Big', 'swatch-admin-td'),
                    'box-huge'    => __('Huge', 'swatch-admin-td'),
                ),
                'default' => 'box-medium',
            ),
        )
);