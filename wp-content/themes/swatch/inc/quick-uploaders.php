<?php
/**
 * Stores options for themes quick uploaders
 *
 * @package Swatch
 * @subpackage Admin
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */

return array(
    // slideshoe quick upload
    'oxy_slideshow_image' => array(
        'menu_title' => __('Quick Slideshow', 'swatch-admin-td'),
        'page_title' => __('Quick Slideshow Creator', 'swatch-admin-td'),
        'item_singular'  => __('Slideshow Image', 'swatch-admin-td'),
        'item_plural'  => __('Slideshow Images', 'swatch-admin-td'),
        'taxonomies' => array(
            'oxy_slideshow_categories'
        )
    ),
    // services quick upload
    'oxy_service' => array(
        'menu_title' => __('Quick Services', 'swatch-admin-td'),
        'page_title' => __('Quick Services Creator', 'swatch-admin-td'),
        'item_singular'  => __('Services', 'swatch-admin-td'),
        'item_plural'  => __('Service', 'swatch-admin-td'),
        'show_editor' => true,
    ),
    // portfolio quick upload
    'oxy_portfolio_image' => array(
        'menu_title' => __('Quick Portfolio', 'swatch-admin-td'),
        'page_title' => __('Quick Portfolio Creator', 'swatch-admin-td'),
        'item_singular'  => __('Portfolio Image', 'swatch-admin-td'),
        'item_plural'  => __('Portfolio Images', 'swatch-admin-td'),
        'show_editor' => true,
        'taxonomies' => array(
            'oxy_portfolio_categories'
        )
    ),
    // staff quick upload
    'oxy_staff' => array(
        'menu_title' => __('Quick Staff', 'swatch-admin-td'),
        'page_title' => __('Quick Staff Creator', 'swatch-admin-td'),
        'item_singular'  => __('Staff Member', 'swatch-admin-td'),
        'item_plural'  => __('Staff', 'swatch-admin-td'),
        'show_editor' => true,
        'taxonomies' => array(
            'oxy_staff_skills'
        )
    )
);