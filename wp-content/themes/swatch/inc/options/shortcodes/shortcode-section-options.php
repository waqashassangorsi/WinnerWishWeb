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
    'title' => __('Section options', 'swatch-admin-td'),
    'fields' => array(
         array(
            'name'    => __('Section Title', 'swatch-admin-td'),
            'id'      => 'title',
            'type'    => 'text',
            'default' => '',
            'desc'    => __('Add a title to the section', 'swatch-admin-td'),
        ),
        array(
            'name'    => __('Section Description', 'swatch-admin-td'),
            'id'      => 'description',
            'type'    => 'text',
            'default' => '',
            'desc'    => __('Add a description to the section', 'swatch-admin-td'),
        ),
        array(
            'name'    => __('Title Capitalization', 'swatch-admin-td'),
            'desc'    => __('Sets the case of the section title.', 'swatch-admin-td'),
            'id'      => 'title_capitalization',
            'type'    => 'select',
            'options' => array(
                'text-caps'         => __('Force Uppercase', 'swatch-admin-td'),
                'text-lowercase'    => __('Force Lowercase', 'swatch-admin-td'),
                'text-capitalize'   => __('Force Capitalization', 'swatch-admin-td'),
                'text-none'      => __('Off', 'swatch-admin-td'),
            ),
            'default' => 'text-caps',
        ),
        array(
            'name'    => __('Section Swatch', 'swatch-admin-td'),
            'desc'    => __('Choose a color swatch for the section', 'swatch-admin-td'),
            'id'      => 'swatch',
            'type'    => 'select',
            'default' => 'swatch-white',
            'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
        ),
        //hidden for now
        array(
            'name'    => '',
            'id'      => 'content',
            'type'    => 'hiddentext',
            'default' => '',
            'desc'    => ''
        ),
        array(
            'name'    => __('Disable Section', 'swatch-admin-td'),
            'desc'    => __('Disable this section for shortcodes in a non-fullwidth template', 'swatch-admin-td'),
            'id'      => 'disable',
            'type'    => 'radio',
            'options' => array(
                'off'   => __('Off', 'swatch-admin-td'),
                'on'    => __('On', 'swatch-admin-td'),
            ),
            'default' => 'off',
        ),
        array(
            'name'    => __('Section Padding', 'swatch-admin-td'),
            'desc'    => __('Choose between padded-non padded section', 'swatch-admin-td'),
            'id'      => 'padding',
            'type'    => 'radio',
            'options' => array(
                'padded'    => __('Padded', 'swatch-admin-td'),
                'no-padded' => __('Non-Padded', 'swatch-admin-td'),
            ),
            'default' => 'padded',
        ),
        array(
            'name'    => __('Section Width', 'swatch-admin-td'),
            'desc'    => __('Choose between padded-non padded section', 'swatch-admin-td'),
            'id'      => 'width',
            'type'    => 'radio',
            'options' => array(
                'fullwidth'    => __('Full Width', 'swatch-admin-td'),
                'no-fullwidth' => __('Non-full Width', 'swatch-admin-td'),
            ),
            'default' => 'no-fullwidth',
        ),
        array(
            'name'    => __('Header Size', 'swatch-admin-td'),
            'desc'    => __('Choose between h1 and h2 tags for your section header', 'swatch-admin-td'),
            'id'      => 'header_size',
            'type'    => 'radio',
            'options' => array(
                'h1'    => __('H1', 'swatch-admin-td'),
                'h2' => __('H2', 'swatch-admin-td'),
            ),
            'default' => 'h2',
        ),
        array(
            'name'    => __('Optional class', 'swatch-admin-td'),
            'id'      => 'class',
            'type'    => 'text',
            'default' => '',
            'desc'    => __('Add an optional class to the section', 'swatch-admin-td'),
        ),
        array(
            'name'    => __('Optional id', 'swatch-admin-td'),
            'id'      => 'id',
            'type'    => 'text',
            'default' => '',
            'desc'    => __('Add an optional id to the section', 'swatch-admin-td'),
        )
    )

);