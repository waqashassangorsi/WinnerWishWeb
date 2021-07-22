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

return array(
    'sections'   => array(
        'twitter-section' => array(
            'fields' => array(
                array(
                    'name' => __('Show language as', 'swatch-admin-td'),
                    'id' => 'display',
                    'type' => 'select',
                    'default' => 'name',
                    'options' => array(
                        'name'     => __('Name', 'swatch-admin-td'),
                        'flag'     => __('Flag', 'swatch-admin-td'),
                        'nameflag' => __('Name & Flag', 'swatch-admin-td')
                    )
                ),
                array(
                    'name' => __('Order languages by', 'swatch-admin-td'),
                    'id' => 'order',
                    'type' => 'select',
                    'default' => 'id',
                    'options' => array(
                        'id'   => __('ID', 'swatch-admin-td'),
                        'code' => __('Code', 'swatch-admin-td'),
                        'name' => __('Name', 'swatch-admin-td')
                    ),
                ),
                array(
                    'name' => __('Order direction', 'swatch-admin-td'),
                    'id' => 'orderby',
                    'type' => 'select',
                    'default' => 'id',
                    'options' => array(
                        'asc'   => __('Ascending', 'swatch-admin-td'),
                        'desc' => __('Decending', 'swatch-admin-td'),
                    ),
                ),
                array(
                    'name' => __('Skip Missing Languages', 'swatch-admin-td'),
                    'id' => 'skip_missing',
                    'type' => 'select',
                    'default' => '1',
                    'options' => array(
                        '1' => __('Skip', 'swatch-admin-td'),
                        '0' => __('Dont Skip', 'swatch-admin-td'),
                    ),
                    'desc' => __('Skip languages with no translations.', 'swatch-admin-td')
                ),
            )//fields
        )//section
    )//sections
);//array

