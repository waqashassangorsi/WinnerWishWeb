<?php
/**
 * Sets up all theme shortcode options
 *
 * @package Swatch
 * @subpackage Frontend
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.9.2
 */

return array(
    // SECTION
    'section' => array(
        'shortcode'     => 'section',
        'title'         => __('Simple Section', 'swatch-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => true,
        'sections'      => array(
             include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-section-options.php',
             include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-section-background-options.php'
        )
    ),
    'services' =>array(
        'shortcode'     => 'services',
        'title'         => __('Services', 'swatch-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Services', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Choose a category', 'swatch-admin-td'),
                        'desc'    => __('Category of services to show', 'swatch-admin-td'),
                        'id'      => 'category',
                        'default' =>  '',
                        'type'    => 'select',
                        'options' => 'taxonomy',
                        'taxonomy' => 'oxy_service_category',
                        'blank_label' => __('All Categories', 'swatch-admin-td')
                    ),
                    array(
                        'name'    => __('Services Count', 'swatch-admin-td'),
                        'desc'    => __('Number of services to show(set to 0 to show all)', 'swatch-admin-td'),
                        'id'      => 'count',
                        'type'    => 'slider',
                        'default' => 3,
                        'attr'    => array(
                            'max'  => 30,
                            'min'  => 0,
                            'step' => 1
                        )
                    ),
                    array(
                        'name'    => __('Columns', 'swatch-admin-td'),
                        'desc'    => __('Number columns to show the services in', 'swatch-admin-td'),
                        'id'      => 'columns',
                        'type'    => 'radio',
                        'options' => array(
                            2 => __('Two columns', 'swatch-admin-td'),
                            3 => __('Three columns', 'swatch-admin-td'),
                            4 => __('Four columns', 'swatch-admin-td'),
                        ),
                        'default' => 3,
                    ),
                    array(
                        'name'      => __('Show Titles', 'swatch-admin-td'),
                        'id'        => 'titles',
                        'type'      => 'radio',
                        'default'   =>  'show',
                        'options' => array(
                            'hide' => __('Hide', 'swatch-admin-td'),
                            'show' => __('Show', 'swatch-admin-td'),
                            ),
                    ),
                    array(
                        'name'      => __('Link Title', 'swatch-admin-td'),
                        'id'        => 'link_title',
                        'type'      => 'radio',
                        'default'   =>  'on',
                        'options' => array(
                            'on'  => __('On', 'swatch-admin-td'),
                            'off' => __('Off', 'swatch-admin-td'),
                            ),
                    ),
                    array(
                        'name'      => __('Link Image', 'swatch-admin-td'),
                        'id'        => 'link_image',
                        'type'      => 'radio',
                        'default'   =>  'on',
                        'options' => array(
                            'on'  => __('On', 'swatch-admin-td'),
                            'off' => __('Off', 'swatch-admin-td'),
                            ),
                    ),
                    array(
                        'name'      => __('Show Excerpt', 'swatch-admin-td'),
                        'id'        => 'excerpt',
                        'type'      => 'radio',
                        'default'   =>  'show',
                        'options' => array(
                            'hide' => __('Hide', 'swatch-admin-td'),
                            'show' => __('Show', 'swatch-admin-td'),
                            ),
                    ),
                    array(
                        'name'      => __('Show Readmore Link', 'swatch-admin-td'),
                        'id'        => 'readmore',
                        'type'      => 'radio',
                        'default'   =>  'show',
                        'options' => array(
                            'hide' => __('Hide', 'swatch-admin-td'),
                            'show' => __('Show', 'swatch-admin-td'),
                            ),
                    ),
                    array(
                        'name'    => __('Readmore Link Text', 'swatch-admin-td'),
                        'id'      => 'readmore_text',
                        'type'    => 'text',
                        'default' => 'read more',
                        'desc'    => __('Customize your readmore link', 'swatch-admin-td'),
                    ),
                    array(
                        'name'        => __('Order by', 'swatch-admin-td'),
                        'desc'        => __('Choose the way service items will be ordered.', 'swatch-admin-td'),
                        'id'          => 'orderby',
                        'type'        => 'select',
                        'default'     =>  'none',
                        'options'     => array(
                            'none'        => __('None', 'swatch-admin-td'),
                            'title'       => __('Title', 'swatch-admin-td'),
                            'date'        => __('Date', 'swatch-admin-td'),
                            'ID'          => __('ID', 'swatch-admin-td'),
                            'author'      => __('Author', 'swatch-admin-td'),
                            'modified'    => __('Last Modified', 'swatch-admin-td'),
                            'menu_order'  => __('Menu Order', 'swatch-admin-td'),
                            'rand'        => __('Random', 'swatch-admin-td'),
                        )
                    ),
                    array(
                        'name'        => __('Order', 'swatch-admin-td'),
                        'desc'        => __('Choose how services will be ordered.', 'swatch-admin-td'),
                        'id'          => 'order',
                        'type'        => 'select',
                        'default'     =>  'ASC',
                        'options'     => array(
                            'ASC'     => __('Ascending', 'swatch-admin-td'),
                            'DESC'    => __('Descending', 'swatch-admin-td'),
                        )
                    )
                )
            ),
            include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-image-options.php',
            include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-section-options.php',
            include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-section-background-options.php'
        )
    ),
     // TESTIMONIALS SHORTCODE SECTION
    'testimonials' => array(
        'shortcode' => 'testimonials',
        'title'     => __('Testimonials', 'swatch-admin-td'),
        'insert_with' => 'dialog',
        'has_content'   => false,
        'sections'   => array(
            array(
                'title' => __('Testimonials', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Choose a group', 'swatch-admin-td'),
                        'desc'    => __('Group of testimonials to show', 'swatch-admin-td'),
                        'id'      => 'group',
                        'default' =>  '',
                        'type'    => 'select',
                        'options' => 'taxonomy',
                        'taxonomy' => 'oxy_testimonial_group',
                        'blank_label' => __('All Testimonials', 'swatch-admin-td')
                    ),
                    array(
                        'name'    => __('Show avatars', 'swatch-admin-td'),
                        'desc'    => __('Display the feature image as avatar', 'swatch-admin-td'),
                        'id'      => 'show_image',
                        'type'    => 'radio',
                        'default' => 'off',
                        'options' => array(
                            'on'  => __('On', 'swatch-admin-td'),
                            'off' => __('Off', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Number Of Testimonials', 'swatch-admin-td'),
                        'desc'    => __('Number of Testimonials to display(set to 0 to show all)', 'swatch-admin-td'),
                        'id'      => 'count',
                        'type'    => 'slider',
                        'default' => 3,
                        'attr'    => array(
                            'max'   => 10,
                            'min'   => 0,
                            'step'  => 1
                        )
                    ),
                )
            ),
            include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-section-options.php',
            include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-section-background-options.php'
        )
    ),
     /* Staff Shortcodes */
    'staff_list' =>  array(
        'shortcode'     => 'staff_list',
        'title'         => __('Staff members list', 'swatch-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Staff members list', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Choose a department', 'swatch-admin-td'),
                        'desc'    => __('Populate your list from a department', 'swatch-admin-td'),
                        'id'      => 'department',
                        'default' =>  '',
                        'type'    => 'select',
                        'options' => 'taxonomy',
                        'taxonomy' => 'oxy_staff_department',
                        'blank_label' => __('Select a department', 'swatch-admin-td')
                    ),
                    array(
                        'name'    => __('Number Of members', 'swatch-admin-td'),
                        'desc'    => __('Number of members to display(set to 0 to show all)', 'swatch-admin-td'),
                        'id'      => 'count',
                        'type'    => 'slider',
                        'default' => 3,
                        'attr'    => array(
                            'max'  => 30,
                            'min'  => 0,
                            'step' => 1
                        )
                    ),
                    array(
                        'name'    => __('List Columns', 'swatch-admin-td'),
                        'desc'    => __('Number of columns to show staff in', 'swatch-admin-td'),
                        'id'      => 'columns',
                        'type'    => 'radio',
                        'default' => '3',
                        'options' => array(
                            '2' => __('2 Columns', 'swatch-admin-td'),
                            '3' => __('3 Columns', 'swatch-admin-td'),
                            '4' => __('4 Columns', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Show title', 'swatch-admin-td'),
                        'desc'    => __('Display the staff title and position', 'swatch-admin-td'),
                        'id'      => 'show_title',
                        'type'    => 'radio',
                        'default' => 'on',
                        'options' => array(
                            'on'  => __('On', 'swatch-admin-td'),
                            'off' => __('Off', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Link in title', 'swatch-admin-td'),
                        'desc'    => __('Make the title link to the single staff page', 'swatch-admin-td'),
                        'id'      => 'link_title',
                        'type'    => 'radio',
                        'default' => 'on',
                        'options' => array(
                            'on'  => __('On', 'swatch-admin-td'),
                            'off' => __('Off', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Show Description', 'swatch-admin-td'),
                        'desc'    => __('Display the staff description below title', 'swatch-admin-td'),
                        'id'      => 'show_description',
                        'type'    => 'radio',
                        'default' => 'on',
                        'options' => array(
                            'on'  => __('On', 'swatch-admin-td'),
                            'off' => __('Off', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Open Link In', 'swatch-admin-td'),
                        'id'      => 'link_target',
                        'type'    => 'select',
                        'default' => '_self',
                        'options' => array(
                            '_self'   => __('Same page as it was clicked ', 'swatch-admin-td'),
                            '_blank'  => __('Open in new window/tab', 'swatch-admin-td'),
                            '_parent' => __('Open the linked document in the parent frameset', 'swatch-admin-td'),
                            '_top'    => __('Open the linked document in the full body of the window', 'swatch-admin-td')
                        ),
                        'desc'    => __('Where the social links open to', 'swatch-admin-td'),
                    ),
                    array(
                        'name'        => __('Order by', 'swatch-admin-td'),
                        'desc'        => __('Choose the way service items will be ordered.', 'swatch-admin-td'),
                        'id'          => 'orderby',
                        'type'        => 'select',
                        'default'     =>  'none',
                        'options'     => array(
                            'none'        => __('None', 'swatch-admin-td'),
                            'title'       => __('Title', 'swatch-admin-td'),
                            'date'        => __('Date', 'swatch-admin-td'),
                            'ID'          => __('ID', 'swatch-admin-td'),
                            'author'      => __('Author', 'swatch-admin-td'),
                            'modified'    => __('Last Modified', 'swatch-admin-td'),
                            'menu_order'  => __('Menu Order', 'swatch-admin-td'),
                            'rand'        => __('Random', 'swatch-admin-td'),
                        )
                    ),
                    array(
                        'name'        => __('Order', 'swatch-admin-td'),
                        'desc'        => __('Choose how services will be ordered.', 'swatch-admin-td'),
                        'id'          => 'order',
                        'type'        => 'select',
                        'default'     =>  'ASC',
                        'options'     => array(
                            'ASC'     => __('Ascending', 'swatch-admin-td'),
                            'DESC'    => __('Descending', 'swatch-admin-td'),
                        )
                    )
                )
            ),
            include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-section-options.php',
            include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-section-background-options.php'
        ),
    ),
    // PORTFOLIO SHORTCODE OPTIONS
    'portfolio' => array(
        'shortcode'     => 'portfolio',
        'title'         => __('Portfolio', 'swatch-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Portfolio', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Portfolios', 'swatch-admin-td'),
                        'desc'    => __('Portfolios to show (leave blank to show all)', 'swatch-admin-td'),
                        'id'      => 'portfolios',
                        'default' =>  '',
                        'type'    => 'select',
                        'options' => 'taxonomy',
                        'taxonomy' => 'oxy_portfolio_categories',
                        'attr' => array(
                            'multiple' => '',
                            'style' => 'height:100px'
                        )
                    ),
                    array(
                        'name'    => __('Portfolio Columns', 'swatch-admin-td'),
                        'desc'    => __('Number of columns to show the portfolio in', 'swatch-admin-td'),
                        'id'      => 'columns',
                        'type'    => 'slider',
                        'default' => 3,
                        'attr'    => array(
                            'max'   => 4,
                            'min'   => 2,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'    => __('Portfolio Filters', 'swatch-admin-td'),
                        'desc'    => __('Show filter navigation', 'swatch-admin-td'),
                        'id'      => 'filters_cat',
                        'type'      => 'radio',
                        'default'   =>  'show',
                        'options'  => array(
                            'show' => __('Show', 'swatch-admin-td'),
                            'hide' => __('Hide', 'swatch-admin-td'),
                            )

                    ),
                    array(
                        'name'    => __('Number of portfolio items to display  (per page if pagination is on )', 'swatch-admin-td'),
                        'desc'    => __('Number of portfolio items to display', 'swatch-admin-td'),
                        'id'      => 'count',
                        'type'    => 'slider',
                        'default' => 3,
                        'attr'    => array(
                            'max'   => 24,
                            'min'   => 1,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'      =>  __('Link Portfolio', 'swatch-admin-td'),
                        'desc'      => __('Link Portfolio title and overlay', 'swatch-admin-td'),
                        'id'        => 'show_links',
                        'type'      => 'select',
                        'options'   =>  array(
                            'show' => __('Show', 'swatch-admin-td'),
                            'hide' => __('Hide', 'swatch-admin-td'),
                        ),
                        'default'   => 'show',
                    ),
                    array(
                        'name'      => __('Show Excerpt', 'swatch-admin-td'),
                        'desc'      => __('Display the portfolio excerpt', 'swatch-admin-td'),
                        'id'        => 'show_excerpt',
                        'type'      => 'select',
                        'default'   => 'show',
                        'options' => array(
                            'show' => __('Show', 'swatch-admin-td'),
                            'hide' => __('Hide', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'      =>  __('Overlay', 'swatch-admin-td'),
                        'desc'      => __('Show overlay on hover', 'swatch-admin-td'),
                        'id'        => 'show_overlay',
                        'type'      => 'select',
                        'options'   =>  array(
                            'show' => __('Show', 'swatch-admin-td'),
                            'hide' => __('Hide', 'swatch-admin-td'),
                        ),
                        'default'   => 'show',
                    ),
                    array(
                        'name'      =>  __('Magnific on hidden overlay', 'swatch-admin-td'),
                        'desc'      => __('Open portfolio links in Magnific popup when overlay is hidden', 'swatch-admin-td'),
                        'id'        => 'show_magnific',
                        'type'      => 'select',
                        'options'   =>  array(
                            'show'   => __('Show', 'swatch-admin-td'),
                            'hide'   => __('Hide', 'swatch-admin-td'),
                        ),
                        'default'   => 'show',
                    ),
                    array(
                        'name'      => __('Use pagination', 'swatch-admin-td'),
                        'desc'      => __('Number of portfolio items to display', 'swatch-admin-td'),
                        'id'        => 'pagination',
                        'type'      => 'select',
                        'default'   => 'off',
                        'options' => array(
                            'on'  => __('On', 'swatch-admin-td'),
                            'off' => __('Off', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'        => __('Order by', 'swatch-admin-td'),
                        'desc'        => __('Choose the way service items will be ordered.', 'swatch-admin-td'),
                        'id'          => 'orderby',
                        'type'        => 'select',
                        'default'     =>  'none',
                        'options'     => array(
                            'none'        => __('None', 'swatch-admin-td'),
                            'title'       => __('Title', 'swatch-admin-td'),
                            'date'        => __('Date', 'swatch-admin-td'),
                            'ID'          => __('ID', 'swatch-admin-td'),
                            'author'      => __('Author', 'swatch-admin-td'),
                            'modified'    => __('Last Modified', 'swatch-admin-td'),
                            'menu_order'  => __('Menu Order', 'swatch-admin-td'),
                            'rand'        => __('Random', 'swatch-admin-td'),
                        )
                    ),
                    array(
                        'name'        => __('Order', 'swatch-admin-td'),
                        'desc'        => __('Choose how services will be ordered.', 'swatch-admin-td'),
                        'id'          => 'order',
                        'type'        => 'select',
                        'default'     =>  'ASC',
                        'options'     => array(
                            'ASC'     => __('Ascending', 'swatch-admin-td'),
                            'DESC'    => __('Descending', 'swatch-admin-td'),
                        )
                    )
                )
            ),
            include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-section-options.php',
            include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-section-background-options.php'
        )
    ),
     'recent_posts' => array(
        'shortcode' => 'recent_posts',
        'title'     => __('Recent Posts', 'swatch-admin-td'),
        'insert_with' => 'dialog',
        'has_content'   => false,
        'sections'   => array(
            array(
                'title' => __('Recent Posts', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Layout', 'swatch-admin-td'),
                        'desc'    => __('Section Layout', 'swatch-admin-td'),
                        'id'      => 'layout',
                        'type'    => 'select',
                        'default' => 'carousel',
                        'options' => array(
                            'carousel' => __('Carousel', 'swatch-admin-td'),
                            'masonry'  => __('Masonry', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Number of posts', 'swatch-admin-td'),
                        'desc'    => __('Number of posts to display per page', 'swatch-admin-td'),
                        'id'      => 'count',
                        'type'    => 'slider',
                        'default' => 3,
                        'attr'    => array(
                            'max'   => 10,
                            'min'   => 1,
                            'step'  => 1
                        )
                    ),
                     array(
                        'name'    => __('Post category', 'swatch-admin-td'),
                        'desc'    => __('Choose posts from a specific category', 'swatch-admin-td'),
                        'id'      => 'cat',
                        'default' =>  '',
                        'type'    => 'select',
                        'options' => 'categories',
                        'attr' => array(
                            'multiple' => '',
                            'style' => 'height:100px'
                        )
                    ),
                    array(
                        'name'    => __('Columns', 'swatch-admin-td'),
                        'desc'    => __('Number of columns to show posts in', 'swatch-admin-td'),
                        'id'      => 'columns',
                        'type'    => 'select',
                        'default' => '3',
                        'options' => array(
                            '1' => __('1 Column', 'swatch-admin-td'),
                            '2' => __('2 Columns', 'swatch-admin-td'),
                            '3' => __('3 Columns', 'swatch-admin-td'),
                            '4' => __('4 Columns', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Show Filters(Masonry Layout)', 'swatch-admin-td'),
                        'desc'    => __('Show the filters for Masonry Layout', 'swatch-admin-td'),
                        'id'      => 'enable',
                        'type'    => 'radio',
                        'options' => array(
                            'on'    => __('On', 'swatch-admin-td'),
                            'off'   => __('Off', 'swatch-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                )
            ),
            include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-section-options.php',
            include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-section-background-options.php'
        )
    ),
    // MAP SHORTCODE OPTIONS
    'map' => array(
        'shortcode'     => 'map',
        'title'         => __('Google Map', 'swatch-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Map', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Map Type', 'swatch-admin-td'),
                        'id'        => 'map_type',
                        'type'      => 'select',
                        'default'   =>  'ROADMAP',
                        'options' => array(
                            'ROADMAP'   => __('Roadmap', 'swatch-admin-td'),
                            'SATELLITE' => __('Satellite', 'swatch-admin-td'),
                            'TERRAIN'   => __('Terrain', 'swatch-admin-td'),
                            'HYBRID'    => __('Hybrid', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Map Zoom', 'swatch-admin-td'),
                        'id'        => 'map_zoom',
                        'type'      => 'slider',
                        'default' => 15,
                        'attr'    => array(
                            'max'   => 20,
                            'min'   => 1,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'      => __('Map Style', 'swatch-admin-td'),
                        'id'        => 'map_style',
                        'type'      => 'radio',
                        'default'   =>  'flat',
                        'options' => array(
                            'flat'    => __('Flat', 'swatch-admin-td'),
                            'regular' => __('Regular', 'swatch-admin-td'),
                        ),
                    ),
                )
            ),
            array(
                'title' => __('Marker', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Show Markers', 'swatch-admin-td'),
                        'id'        => 'marker',
                        'type'      => 'radio',
                        'default'   =>  'show',
                        'options' => array(
                            'hide' => __('Hide', 'swatch-admin-td'),
                            'show' => __('Show', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Marker Addresses(Divide with pipe character |)', 'swatch-admin-td'),
                        'desc'    => __('Addresses to show markers. Divide addresses with pipe character |', 'swatch-admin-td'),
                        'id'      => 'address',
                        'default' =>  '',
                        'type'    => 'textarea',
                    ),
                    array(
                        'name'    => __('Markers Lat/Lng(Divide with pipe character |, comma separated)', 'swatch-admin-td'),
                        'desc'    => __('Latitude and Longitude of markers(separate with commas), if you dont want to use address. Divide markers with pipe character |', 'swatch-admin-td'),
                        'id'      => 'latlng',
                        'default' =>  '',
                        'type'    => 'textarea',
                    ),
                )
            ),
            array(
                'title' => __('Section', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Map Section Height', 'swatch-admin-td'),
                        'id'        => 'height',
                        'type'      => 'slider',
                        'default' => 500,
                        'attr'    => array(
                            'max'   => 800,
                            'min'   => 50,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'      => __('Show Top Contact Details Box', 'swatch-admin-td'),
                        'id'        => 'top_box',
                        'type'      => 'radio',
                        'default'   =>  'show',
                        'options' => array(
                            'hide' => __('Hide', 'swatch-admin-td'),
                            'show' => __('Show', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Show Bottom Contact Details Box', 'swatch-admin-td'),
                        'id'        => 'bottom_box',
                        'type'      => 'radio',
                        'default'   =>  'show',
                        'options' => array(
                            'hide' => __('Hide', 'swatch-admin-td'),
                            'show' => __('Show', 'swatch-admin-td'),
                        ),
                    ),
                )
            )
        )
    ),
    // PIECHART SHORTCODE
    'pie' => array(
        'shortcode' => 'pie',
        'title'     => __('Pie Chart', 'swatch-admin-td'),
        'insert_with' => 'dialog',
        'has_content'   => false,
        'sections'   => array(
            array(
                'title' => __('Pie Chart', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Track Colour', 'swatch-admin-td'),
                        'desc'    => __('Choose the chart track colour', 'swatch-admin-td'),
                        'id'      => 'track_colour',
                        'default' =>  '',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Bar Colour', 'swatch-admin-td'),
                        'desc'    => __('Choose the chart bar colour', 'swatch-admin-td'),
                        'id'      => 'bar_colour',
                        'default' =>  '',
                        'type'    => 'colour',
                    ),
                    array(
                        'name'    => __('Icon', 'swatch-admin-td'),
                        'desc'    => __('Choose a chart icon', 'swatch-admin-td'),
                        'id'      => 'icon',
                        'default' =>  '',
                        'type'    => 'select',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/fontawesome.php',
                    ),
                    array(
                        'name'    => __('Icon Animation', 'swatch-admin-td'),
                        'desc'    => __('Choose an icon animation', 'swatch-admin-td'),
                        'id'      => 'icon_animation',
                        'type'    => 'select',
                        'default' => '',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-button-animations.php'
                    ),
                    array(
                        'name'    => __('Percentage', 'swatch-admin-td'),
                        'desc'    => __('Percentage of the pie chart', 'swatch-admin-td'),
                        'id'      => 'percentage',
                        'type'    => 'slider',
                        'default' => 50,
                        'attr'    => array(
                            'max'   => 100,
                            'min'   => 1,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'    => __('Size', 'swatch-admin-td'),
                        'desc'    => __('Set the size of the chart', 'swatch-admin-td'),
                        'id'      => 'size',
                        'type'    => 'slider',
                        'default' => 200,
                        'attr'    => array(
                            'max'   => 400,
                            'min'   => 50,
                            'step'  => 1
                        )
                    ),
                    array(
                        'name'    => __('Line Width', 'swatch-admin-td'),
                        'desc'    => __('Set the width of the charts line', 'swatch-admin-td'),
                        'id'      => 'line_width',
                        'type'    => 'slider',
                        'default' => 20,
                        'attr'    => array(
                            'max'   => 30,
                            'min'   => 5,
                            'step'  => 1
                        )
                    ),
                )
            ),
        )
    ),
    'pricing' => array(
        'shortcode'   => 'pricing',
        'insert'      => '[pricing heading="standard" swatch = "swatch-greensea" price="10" currency="dollar" per="month" featured="no"]<ul class="pricing-list"><li>1 project</li><li>5 GB Storage</li></ul>[button icon="" size="btn-large" type="primary" label="Sign Up" link="#"][/pricing]',
        'title'       => __('Pricing Column', 'swatch-admin-td'),
        'insert_with' => 'insert',
        'has_content'   => false,
    ),
    'fancylist' => array(
        'shortcode'   => 'fancylist',
        'title'       => __('Fancylist', 'swatch-admin-td'),
        'insert_with' => 'insert',
        'insert'      => '[fancylist][fancyitem title="fancy title" icon="fa fa-heart" list_swatch="swatch-coral" icon_animation="bounce"][/fancyitem][/fancylist]',
        'has_content'   => false,
    ),
    'socialicons'  => array(
        'shortcode'   => 'socialicons',
        'title'       => __('Social Icons List', 'swatch-admin-td'),
        'insert_with' => 'dialog',
        'has_content'   => false,
        'sections'    => array(
            array(
                'title'   => 'general',
                'fields'  => array(
                    array(
                        'name'      => __('Open links in new window', 'swatch-admin-td'),
                        'id'        => 'window',
                        'type'      => 'select',
                        'default'   => 'on',
                        'options' => array(
                            'on'  => __('On', 'swatch-admin-td'),
                            'off' => __('Off', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Social icons style', 'swatch-admin-td'),
                        'id'        => 'style',
                        'type'      => 'select',
                        'options'   =>  array(
                            'background'   => __('With background', 'swatch-admin-td'),
                            'nobackground' => __('No background', 'swatch-admin-td'),
                        ),
                        'default'   => 'background',
                    ),
                    array(
                        'name'      => __('Social icons size', 'swatch-admin-td'),
                        'id'        => 'size',
                        'type'      => 'select',
                        'options'   =>  array(
                            'normal'  => __('normal', 'swatch-admin-td'),
                            'mini'    => __('mini', 'swatch-admin-td'),
                        ),
                        'default'   => 'normal',
                    ),
                    array(
                        'name'    => __('Social Icons', 'swatch-admin-td'),
                        'desc'    => __('Number of social icons', 'swatch-admin-td'),
                        'id'      => 'number',
                        'type'    => 'slider',
                        'default' => 2,
                        'attr'    => array(
                            'max'  => 10,
                            'min'  => 1,
                            'step' => 1
                        )
                    ),
                )
            )
        )
    ),
    'slideshow' => array(
        'shortcode'     => 'slideshow',
        'title'         => __('Slideshow', 'swatch-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Slideshow', 'swatch-admin-td'),
                'javascripts' => array(
                    array(
                        'handle' => 'header_options_script',
                        'src'    => OXY_THEME_URI . 'inc/options/javascripts/dialogs/slider-options.js',
                        'deps'   => array( 'jquery'),
                        'localize' => array(
                            'object_handle' => 'theme',
                            'data'          => THEME_SHORT
                        ),
                    ),
                ),
                'fields' => array(
                    array(
                        'name'    => __('Choose a Slider', 'swatch-admin-td'),
                        'desc'    => __('Choose a between revolution and flexslider', 'swatch-admin-td'),
                        'id'      => 'type',
                        'default' => 'revolution',
                        'type'    => 'select',
                        'options' => array(
                            'revolution' => __('Revolution Slider', 'swatch-admin-td'),
                            'flexslider' => __('Flexslider', 'swatch-admin-td'),
                            'layerslider'=> __('LayerSLider', 'swatch-admin-td')
                        ),
                    ),
                    array(
                        'name'    => __('Choose a Revolution Slider', 'swatch-admin-td'),
                        'desc'    => __('Populate your slider with one of the Revolution Sliders you created', 'swatch-admin-td'),
                        'id'      => 'revolution',
                        'default' =>  '',
                        'type'    => 'select',
                        'options' => 'revolution',
                    ),
                    array(
                        'name'    => __('Choose a Layerslider', 'swatch-admin-td'),
                        'desc'    => __('Populate your slider with one of the LayerSliders you created', 'swatch-admin-td'),
                        'id'      => 'layerslider',
                        'default' =>  '',
                        'type'    => 'select',
                        'options' => 'layerslider',
                    ),
                    array(
                        'name'    => __('Choose a Flexslider', 'swatch-admin-td'),
                        'desc'    => __('Populate your slider with one of the Flexsliders you created', 'swatch-admin-td'),
                        'id'      => 'flexslider',
                        'default' =>  '',
                        'type'    => 'select',
                        'options' => 'slideshow',
                    ),
                    array(
                        'name'      =>  __('Animation style', 'swatch-admin-td'),
                        'desc'      =>  __('Select how your slider animates', 'swatch-admin-td'),
                        'id'        => 'animation',
                        'type'      => 'select',
                        'options'   =>  array(
                            'slide' => __('Slide', 'swatch-admin-td'),
                            'fade'  => __('Fade', 'swatch-admin-td'),
                        ),
                        'attr'      =>  array(
                            'class'    => 'widefat',
                        ),
                        'default'   => 'slide',
                    ),
                    array(
                        'name'      => __('Speed', 'swatch-admin-td'),
                        'desc'      => __('Set the speed of the slideshow cycling, in milliseconds', 'swatch-admin-td'),
                        'id'        => 'speed',
                        'type'      => 'slider',
                        'default'   => 7000,
                        'attr'      => array(
                            'max'       => 15000,
                            'min'       => 2000,
                            'step'      => 1000
                        )
                    ),
                    array(
                        'name'      => __('Duration', 'swatch-admin-td'),
                        'desc'      => __('Set the speed of animations', 'swatch-admin-td'),
                        'id'        => 'duration',
                        'type'      => 'slider',
                        'default'   => 600,
                        'attr'      => array(
                            'max'       => 1500,
                            'min'       => 200,
                            'step'      => 100
                        )
                    ),
                    array(
                        'name'      => __('Auto start', 'swatch-admin-td'),
                        'id'        => 'autostart',
                        'type'      => 'radio',
                        'default'   =>  'true',
                        'desc'    => __('Start slideshow automatically', 'swatch-admin-td'),
                        'options' => array(
                            'true'  => __('On', 'swatch-admin-td'),
                            'false' => __('Off', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Show navigation arrows', 'swatch-admin-td'),
                        'id'        => 'directionnav',
                        'type'      => 'radio',
                        'default'   =>  'hide',
                        'options' => array(
                            'show' => __('Show', 'swatch-admin-td'),
                            'hide' => __('Hide', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Navigation arrows type', 'swatch-admin-td'),
                        'id'        => 'directionnavtype',
                        'type'      => 'radio',
                        'default'   =>  'simple',
                        'options' => array(
                            'simple' => __('Simple', 'swatch-admin-td'),
                            'fancy'  => __('Fancy', 'swatch-admin-td'),
                        ),
                    ),
                     array(
                        'name'      => __('Item width', 'swatch-admin-td'),
                        'desc'      => __('Set width of the slider items( leave blank for full )', 'swatch-admin-td'),
                        'id'        => 'itemwidth',
                        'type'      => 'text',
                        'default'   => '',
                        'attr'      =>  array(
                            'size'    => 8,
                        ),
                    ),
                    array(
                        'name'      => __('Show controls', 'swatch-admin-td'),
                        'id'        => 'showcontrols',
                        'type'      => 'radio',
                        'default'   =>  'show',
                        'options' => array(
                            'show' => __('Show', 'swatch-admin-td'),
                            'hide' => __('Hide', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Choose the place of the controls', 'swatch-admin-td'),
                        'id'        => 'controlsposition',
                        'type'      => 'radio',
                        'default'   =>  'inside',
                        'options' => array(
                            'inside'    => __('Inside', 'swatch-admin-td'),
                            'outside'   => __('Outside', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'      =>  __('Choose the alignment of the controls', 'swatch-admin-td'),
                        'id'        => 'controlsalign',
                        'type'      => 'radio',
                        'options'   =>  array(
                            'center' => __('Center', 'swatch-admin-td'),
                            'left'   => __('Left', 'swatch-admin-td'),
                            'right'  => __('Right', 'swatch-admin-td'),
                        ),
                        'attr'      =>  array(
                            'class'    => 'widefat',
                        ),
                        'default'   => 'center',
                    ),
                )
            ),
            array(
                'title' => __('Captions', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Show Captions', 'swatch-admin-td'),
                        'id'        => 'captions',
                        'type'      => 'radio',
                        'default'   =>  'show',
                        'options' => array(
                            'show' => __('Show', 'swatch-admin-td'),
                            'hide' => __('Hide', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Captions Vertical Position', 'swatch-admin-td'),
                        'id'        => 'captions_vertical',
                        'type'      => 'radio',
                        'default'   =>  'bottom',
                        'options' => array(
                            'top'    => __('Top', 'swatch-admin-td'),
                            'bottom' => __('Bottom', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Captions Horizontal Position', 'swatch-admin-td'),
                        'desc'      => __('Choose among left, right and alternate positioning', 'swatch-admin-td'),
                        'id'        => 'captions_horizontal',
                        'type'      => 'radio',
                        'default'   =>  'left',
                        'options' => array(
                            'left'      => __('Left', 'swatch-admin-td'),
                            'right'     => __('Right', 'swatch-admin-td'),
                            'alternate' => __('Alternate', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Captions Swatch', 'swatch-admin-td'),
                        'desc'    => __('Choose a color swatch for the captions', 'swatch-admin-td'),
                        'id'      => 'captions_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-white',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'      => __('Show Tooltip', 'swatch-admin-td'),
                        'id'        => 'tooltip',
                        'type'      => 'radio',
                        'default'   =>  'hide',
                        'desc'    => __('Show tooltip', 'swatch-admin-td'),
                        'options' => array(
                            'show'  => __('Show', 'swatch-admin-td'),
                            'hide'  => __('Hide', 'swatch-admin-td'),
                        ),
                    ),
                )
            ),
            include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-section-options.php',
            include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-section-background-options.php'
        )
    ),
    'image' => array(
        'shortcode'     => 'image',
        'title'         => __('Image', 'swatch-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Image', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Image size', 'swatch-admin-td'),
                        'desc'    => __('Choose the size that the image will have', 'swatch-admin-td'),
                        'id'      => 'size',
                        'type'    => 'select',
                        'default' => 'box-medium',
                        'options' => array(
                                'box-mini'   => __('Mini', 'swatch-admin-td'),
                                'box-small'  => __('Small', 'swatch-admin-td'),
                                'box-medium' => __('Medium', 'swatch-admin-td'),
                                'box-big'    => __('Big', 'swatch-admin-td'),
                                'box-huge'   => __('Huge', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Shape', 'swatch-admin-td'),
                        'desc'    => __('Choose if the image will be roundrd or not', 'swatch-admin-td'),
                        'id'      => 'shape',
                        'type'    => 'radio',
                        'default' => 'rounded',
                        'options'    => array(
                            'rounded'       => __('Rounded', 'swatch-admin-td'),
                            'squared'       => __('Squared', 'swatch-admin-td'),
                            'rectangular'  => __('Rectangular', 'swatch-admin-td'),
                        )
                    ),
                    array(
                        'name'    => __('Image Source', 'swatch-admin-td'),
                        'id'      => 'source',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('Place the source path of the image here', 'swatch-admin-td'),
                    ),
                    array(
                        'name'    => __('Image Alt', 'swatch-admin-td'),
                        'id'      => 'alt',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('Place the alt of the image here', 'swatch-admin-td'),
                    ),
                    array(
                        'name'    => __('Link', 'swatch-admin-td'),
                        'id'      => 'link',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('Place a link here', 'swatch-admin-td'),
                    ),
                    array(
                        'name'    => __('Swatch', 'swatch-admin-td'),
                        'desc'    => __('Choose a color swatch', 'swatch-admin-td'),
                        'id'      => 'swatch',
                        'type'    => 'select',
                        'default' => 'swatch-white',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                )
            ),
            array(
                'title'   => 'Icon',
                'fields'  => array(
                    array(
                        'name'    => __('Icon', 'swatch-admin-td'),
                        'desc'    => __('Add an icon to the image', 'swatch-admin-td'),
                        'id'      => 'icon',
                        'type'    => 'select',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/fontawesome.php',
                    ),
                    array(
                        'name'    => __('Icon Animation', 'swatch-admin-td'),
                        'desc'    => __('Choose an icon animation', 'swatch-admin-td'),
                        'id'      => 'icon_animation',
                        'type'    => 'select',
                        'default' => '',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-button-animations.php'
                    ),
                )
            )
        )
    ),
    'staff_featured' => array(
        'shortcode'     => 'staff_featured',
        'title'         => __('Featured staff member', 'swatch-admin-td'),
        'insert_with'   => 'dialog',
        'has_content'   => false,
        'sections'      => array(
            array(
                'title' => __('Staff', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Featured member', 'swatch-admin-td'),
                        'desc'    => __('Select the staff member that will be featured', 'swatch-admin-td'),
                        'id'      => 'member',
                        'default' =>  '',
                        'type'    => 'select',
                        'options' => 'staff_featured',
                    ),
                    array(
                        'name'    => __('Image Position', 'swatch-admin-td'),
                        'desc'    => __('Where the staff photo will be shown', 'swatch-admin-td'),
                        'id'      => 'image_position',
                        'default' =>  'left',
                        'type'    => 'radio',
                        'options' => array(
                            'left'  => __('Left', 'swatch-admin-td'),
                            'right' => __('Right', 'swatch-admin-td')
                        )
                    ),
                )
            ),
            include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-section-options.php',
            include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-section-background-options.php'
        )
    ),
    'row' => array(
        'shortcode' => 'row',
        'insert'    => '[row][/row]',
        'title'     => __('Blank Row', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'span1' =>  array(
        'shortcode' => 'span1',
        'insert'    => '[span1][/span1]',
        'title'     => __('Span1 (1/12th)', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'span2' =>  array(
        'shortcode' => 'span2',
        'insert'    => '[span2][/span2]',
        'title'     => __('Span2 (1/6th)', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'span3' =>  array(
        'shortcode' => 'span3',
        'insert'    => '[span3][/span3]',
        'title'     => __('Span3 (1/4)', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'span4' =>  array(
        'shortcode' => 'span4',
        'insert'    => '[span4][/span4]',
        'title'     => __('Span4 (1/3rd)', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'span5' =>  array(
        'shortcode' => 'span5',
        'insert'    => '[span5][/span5]',
        'title'     => __('Span5 (5/12th)', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'span6' =>  array(
        'shortcode' => 'span6',
        'insert'    => '[span6][/span6]',
        'title'     => __('Span6 (1/2)', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'span7' =>  array(
        'shortcode' => 'span7',
        'insert'    => '[span7][/span7]',
        'title'     => __('Span7 (7/12th)', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'span8' =>  array(
        'shortcode' => 'span8',
        'insert'    => '[span8][/span8]',
        'title'     => __('Span8 (2/3rd)', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'span9' =>  array(
        'shortcode' => 'span9',
        'insert'    => '[span9][/span9]',
        'title'     => __('Span9 (3/4)', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'span10' =>  array(
        'shortcode' => 'span10',
        'insert'    => '[span10][/span10]',
        'title'     => __('Span10 (10/12th)', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'span11' =>  array(
        'shortcode' => 'span11',
        'insert'    => '[span11][/span11]',
        'title'     => __('Span11 (11/12th)', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'span12' =>  array(
        'shortcode' => 'span12',
        'insert'    => '[span12][/span12]',
        'title'     => __('Span12 (one whole row)', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'layout21' => array(
        'shortcode' => 'layout21',
        'insert'    => '[row][span6]Column1[/span6][span6]Column 2[/span6][/row]',
        'title'     => __('1/2 - 1/2', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'layout22' => array(
        'shortcode' => 'layout22',
        'insert'    => '[row][span4]Column1[/span4][span8]Column 2[/span8][/row]',
        'title'     => __('1/3 - 2/3', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'layout23' => array(
        'shortcode' => 'layout',
        'insert'    => '[row][span8]Column1[/span8][span4]Column 2[/span4][/row]',
        'title'     => __('2/3 - 1/3', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'layout24' => array(
        'shortcode' => 'layout',
        'insert'    => '[row][span3]Column1[/span3][span9]Column 2[/span9][/row]',
        'title'     => __('1/4 - 3/4', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'layout25' => array(
        'shortcode' => 'layout',
        'insert'    => '[row][span9]Column1[/span9][span3]Column 2[/span3][/row]',
        'title'     => __('3/4 - 1/4', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'layout3' => array(
        'shortcode' => 'layout',
        'insert'    => '[row][span4]Column1[/span4][span4]Column 2[/span4][span4]Column 3[/span4][/row]',
        'title'     => __('1/3 - 1/3 - 1/3', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'layout4' => array(
        'shortcode' => 'layout',
        'insert'    => '[row][span3]Column1[/span3][span3]Column 2[/span3][span3]Column 3[/span3][span3]Column 4[/span3][/row]',
        'title'     => __('1/4 - 1/4 - 1/4 - 1/4', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'button' =>  array(
        'shortcode'   => 'button',
        'title'       => __('Button', 'swatch-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => 'General',
                'fields'  => array(
                    array(
                        'name'    => __('Button type', 'swatch-admin-td'),
                        'desc'    => __('Type of button to display', 'swatch-admin-td'),
                        'id'      => 'type',
                        'type'    => 'select',
                        'default' => 'default',
                        'options' => array(
                                'default' => __('Default', 'swatch-admin-td'),
                                'primary' => __('Primary', 'swatch-admin-td'),
                                'info'    => __('Info', 'swatch-admin-td'),
                                'success' => __('Success', 'swatch-admin-td'),
                                'warning' => __('Warning', 'swatch-admin-td'),
                                'danger'  => __('Danger', 'swatch-admin-td'),
                                'inverse' => __('Inverse', 'swatch-admin-td'),
                                'link'    => __('Link', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Button size', 'swatch-admin-td'),
                        'desc'    => __('Size of button to display', 'swatch-admin-td'),
                        'id'      => 'size',
                        'type'    => 'select',
                        'default' => '',
                        'options' => array(
                                ''             => __('Default', 'swatch-admin-td'),
                                'btn-large'    => __('Large', 'swatch-admin-td'),
                                'btn-small'    => __('Small', 'swatch-admin-td'),
                                'btn-mini'     => __('Mini', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Text', 'swatch-admin-td'),
                        'id'      => 'label',
                        'type'    => 'text',
                        'default' => __('My button', 'swatch-admin-td'),
                        'desc'    => __('Add a label to the button', 'swatch-admin-td'),
                    ),
                    array(
                        'name'    => __('Link', 'swatch-admin-td'),
                        'id'      => 'link',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('Where the button links to', 'swatch-admin-td'),
                    ),
                    array(
                        'name'    => __('Icon Position', 'swatch-admin-td'),
                        'desc'    => __('The position of the icon on the button', 'swatch-admin-td'),
                        'id'      => 'side',
                        'type'    => 'radio',
                        'default' => 'left',
                        'options' => array(
                                'left'     => __('Left', 'swatch-admin-td'),
                                'right'    => __('Right', 'swatch-admin-td'),
                        ),
                    ),
                )
            ),
            array(
                'title'   => 'Advanced',
                'fields'  => array(
                    array(
                        'name'    => __('Extra classes', 'swatch-admin-td'),
                        'id'      => 'xclass',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('Add an extra class to the button', 'swatch-admin-td'),
                    ),
                    array(
                        'name'    => __('Open Link In', 'swatch-admin-td'),
                        'id'      => 'link_open',
                        'type'    => 'select',
                        'default' => '_self',
                        'options' => array(
                            '_self'   => __('Same page as it was clicked ', 'swatch-admin-td'),
                            '_blank'  => __('Open in new window/tab', 'swatch-admin-td'),
                            '_parent' => __('Open the linked document in the parent frameset', 'swatch-admin-td'),
                            '_top'    => __('Open the linked document in the full body of the window', 'swatch-admin-td')
                        ),
                        'desc'    => __('Where the button link opens to', 'swatch-admin-td'),
                    ),
                )
            ),
            array(
                'title'   => 'Icon',
                'fields'  => array(
                    array(
                        'name'    => __('Icon', 'swatch-admin-td'),
                        'desc'    => __('Type of button to display', 'swatch-admin-td'),
                        'id'      => 'icon',
                        'type'    => 'select',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/fontawesome.php',
                        'default' => ''
                    )
                ),
            ),
        ),
    ),
    'button-fancy' =>  array(
        'shortcode'   => 'button-fancy',
        'title'       => __('Fancy Button', 'swatch-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => 'General',
                'fields'  => array(
                    array(
                        'name'    => __('Button Swatch', 'swatch-admin-td'),
                        'desc'    => __('Choose a color swatch for the button', 'swatch-admin-td'),
                        'id'      => 'button_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-coral',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'    => __('Button Animation', 'swatch-admin-td'),
                        'desc'    => __('Choose a button animation', 'swatch-admin-td'),
                        'id'      => 'button_animation',
                        'type'    => 'select',
                        'default' => '',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-button-animations.php'
                    ),
                    array(
                        'name'    => __('Button size', 'swatch-admin-td'),
                        'desc'    => __('Size of button to display', 'swatch-admin-td'),
                        'id'      => 'size',
                        'type'    => 'select',
                        'default' => '',
                        'options' => array(
                                ''             => __('Default', 'swatch-admin-td'),
                                'btn-large'    => __('Large', 'swatch-admin-td'),
                                'btn-small'    => __('Small', 'swatch-admin-td'),
                                'btn-mini'     => __('Mini', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Text', 'swatch-admin-td'),
                        'id'      => 'label',
                        'type'    => 'text',
                        'default' => __('My button', 'swatch-admin-td'),
                        'desc'    => __('Add a label to the button', 'swatch-admin-td'),
                    ),
                    array(
                        'name'    => __('Link', 'swatch-admin-td'),
                        'id'      => 'link',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('Where the button links to', 'swatch-admin-td'),
                    ),
                )
            ),
            array(
                'title'   => 'Advanced',
                'fields'  => array(
                    array(
                        'name'    => __('Extra classes', 'swatch-admin-td'),
                        'id'      => 'xclass',
                        'type'    => 'text',
                        'default' => '',
                        'desc'    => __('Add an extra class to the button', 'swatch-admin-td'),
                    ),
                    array(
                        'name'    => __('Open Link In', 'swatch-admin-td'),
                        'id'      => 'link_open',
                        'type'    => 'select',
                        'default' => '_self',
                        'options' => array(
                            '_self'   => __('Same page as it was clicked ', 'swatch-admin-td'),
                            '_blank'  => __('Open in new window/tab', 'swatch-admin-td'),
                            '_parent' => __('Open the linked document in the parent frameset', 'swatch-admin-td'),
                            '_top'    => __('Open the linked document in the full body of the window', 'swatch-admin-td')
                        ),
                        'desc'    => __('Where the button link opens to', 'swatch-admin-td'),
                    ),
                )
            ),
            array(
                'title'   => 'Icon',
                'fields'  => array(
                    array(
                        'name'    => __('Icon', 'swatch-admin-td'),
                        'desc'    => __('Type of button to display', 'swatch-admin-td'),
                        'id'      => 'icon',
                        'type'    => 'select',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/fontawesome.php',
                        'default' => '',
                    )
                ),
            ),
        ),
    ),
    'alert' => array(
        'shortcode'   => 'alert',
        'title'       => __('Bootstrap alert', 'swatch-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => 'general',
                'fields'  => array(
                    array(
                        'name'    => __('Alert type', 'swatch-admin-td'),
                        'desc'    => __('Type of alert to display', 'swatch-admin-td'),
                        'id'      => 'type',
                        'type'    => 'select',
                        'default' => 'default',
                        'options' => array(
                                ''              => __('default', 'swatch-admin-td'),
                                'alert-block'   => __('block', 'swatch-admin-td'),
                                'alert-error'   => __('danger', 'swatch-admin-td'),
                                'alert-success' => __('success', 'swatch-admin-td'),
                                'alert-info'    => __('information', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Label', 'swatch-admin-td'),
                        'id'      => 'label',
                        'type'    => 'text',
                        'default' => __('warning!', 'swatch-admin-td'),
                        'desc'    => __('The alert label', 'swatch-admin-td'),
                    ),
                    array(
                        'name'    => __('Description', 'swatch-admin-td'),
                        'id'      => 'Description',
                        'type'    => 'text',
                        'default' => __('something is wrong!', 'swatch-admin-td'),
                        'desc'    => __('Add a description to your warning', 'swatch-admin-td'),
                    )
                )
            ),
        ),
    ),
    'accordions' => array(
        'shortcode' => 'accordions',
        'title'     => __('Accordion', 'swatch-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => 'general',
                'fields'  => array(
                    array(
                        'name'    => __('Button Swatch', 'swatch-admin-td'),
                        'desc'    => __('Choose a color swatch for the button', 'swatch-admin-td'),
                        'id'      => 'accordion_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-white',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'    => __('Accordions', 'swatch-admin-td'),
                        'desc'    => __('Number of accordions', 'swatch-admin-td'),
                        'id'      => 'accordion_details',
                        'type'    => 'slider',
                        'default' => 2,
                        'attr'    => array(
                            'max'  => 10,
                            'min'  => 1,
                            'step' => 1
                        )
                    ),
                )
            )
        )
    ),
    'tabs' => array(
        'shortcode' => 'tabs',
        'insert'    => '[tabs style="top"][tab title="First title"]First content here[/tab][tab title="Second title"]Second content[/tab][/tabs]',
        'title'     => __('Tabs', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'panel' => array(
        'shortcode' => 'panel',
        'insert'    => '[panel header="My header"]This is the content of the panel[/panel]',
        'title'     => __('Panel', 'swatch-admin-td'),
        'insert_with' => 'insert',
    ),
    'progress' =>    array(
        'shortcode'   => 'progress',
        'title'       => __('Progress Bar', 'swatch-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => 'general',
                'fields'  => array(
                    array(
                        'name'    => __('Percentage', 'swatch-admin-td'),
                        'desc'    => __('Percentage of the progress bar', 'swatch-admin-td'),
                        'id'      => 'percentage',
                        'type'    => 'slider',
                        'default' => 50,
                        'attr'    => array(
                            'max'  => 100,
                            'min'  => 1,
                            'step' => 1
                        )
                    ),
                    array(
                        'name'    => __('Bar Type', 'swatch-admin-td'),
                        'desc'    => __('Type of bar to display', 'swatch-admin-td'),
                        'id'      => 'type',
                        'type'    => 'radio',
                        'default' => 'progress',
                        'options' => array(
                            'progress'                        => __('Normal', 'swatch-admin-td'),
                            'progress progress-striped'       => __('Striped', 'swatch-admin-td'),
                            'progress progress-striped active'=> __('Animated', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'    => __('Bar Style', 'swatch-admin-td'),
                        'desc'    => __('Style of bar to display', 'swatch-admin-td'),
                        'id'      => 'style',
                        'type'    => 'select',
                        'default' => 'progress-info',
                        'options' => array(
                            'progress-info'     => __('Info', 'swatch-admin-td'),
                            'progress-success'  => __('Success', 'swatch-admin-td'),
                            'progress-warning'  => __('Warning', 'swatch-admin-td'),
                            'progress-danger'   => __('Danger', 'swatch-admin-td'),
                        ),
                    ),


                )
            ),
        ),
    ),
    'lead_paragraph' => array(
        'shortcode'   => 'lead',
        'title'       => __('Lead Paragraph', 'swatch-admin-td'),
        'insert_with' => 'insert',
        'insert'      => '[lead centered="yes"][/lead]'
    ),
    'blockquote' => array(
        'shortcode'   => 'blockquote',
        'title'       => __('Blockquote', 'swatch-admin-td'),
        'insert_with' => 'insert',
        'insert'      => '[blockquote who="" cite="" align="left"][/blockquote]'
    ),
    'iconlist' => array(
        'shortcode'   => 'iconlist',
        'title'       => __('Iconlist', 'swatch-admin-td'),
        'insert_with' => 'insert',
        'insert'      => '[iconlist][iconitem  icon="fa fa-check"]Some list item[/iconitem][iconitem  icon="fa fa-check"]Some list item[/iconitem][/iconlist]'
    ),
    'icon' => array(
        'shortcode'   => 'icon',
        'title'       => __('Icon', 'swatch-admin-td'),
        'insert_with' => 'dialog',
        'sections'    => array(
            array(
                'title'   => 'General',
                'fields'  => array(
                    array(
                        'name'    => __('Font Size', 'swatch-admin-td'),
                        'desc'    => __('Size of font to use for icon ( set to 0 to inhertit font size from container )', 'swatch-admin-td'),
                        'id'      => 'size',
                        'type'    => 'slider',
                        'default' => 0,
                        'attr'    => array(
                            'max'  => 48,
                            'min'  => 0,
                            'step' => 1
                        )
                    ),
                )
            ),
            array(
                'title'   => 'Icon',
                'fields'  => array(
                    array(
                        'name'    => __('Icon', 'swatch-admin-td'),
                        'desc'    => __('Type of button to display', 'swatch-admin-td'),
                        'id'      => 'content',
                        'type'    => 'select',
                        'options' => include OXY_THEME_DIR . 'inc/options/global-options/fontawesome.php',
                        'default' => 'fa fa-glass'
                    )
                ),
            ),
        ),
    ),
);
