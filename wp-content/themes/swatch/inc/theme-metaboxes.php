<?php
/**
 * Creates all theme metaboxes
 *
 * @package Swatch
 * @subpackage Admin
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.9.2
 */

global $oxy_theme;
$oxy_theme->register_metabox( array(
    'id' => 'Citation',
    'title' => __('Citation', 'swatch-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'pages' => array('oxy_testimonial'),
    'fields' => array(
        array(
            'name'    => __('Citation', 'swatch-admin-td'),
            'desc'    => __('Reference to the source of the quote', 'swatch-admin-td'),
            'id'      => 'citation',
            'type'    => 'text'
        ),
    )
));
$oxy_theme->register_metabox( array(
    'id' => 'swatch_metabox',
    'title' => __('Swatch', 'swatch-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'pages' => array('oxy_service', 'oxy_portfolio_image', 'page', 'oxy_staff'),
    'fields' => array(
        array(
            'name'    => __('Swatch', 'swatch-admin-td'),
            'desc'    => __('Set the colour scheme that will be used for this item.', 'swatch-admin-td'),
            'id'      => 'swatch',
            'type' => 'select',
            'default' => 'swatch-clouds',
            'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
        ),
    )
));
$oxy_theme->register_metabox( array(
    'id' => 'post_swatch_metabox',
    'title' => __('Swatch', 'swatch-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'pages' => array('post'),
    'fields' => array(
        array(
            'name'    => __('Swatch', 'swatch-admin-td'),
            'desc'    => __('Set the colour scheme that will be used for post.', 'swatch-admin-td'),
            'id'      => 'swatch',
            'type' => 'select',
            'default' => oxy_get_option( 'blog_default_post_swatch' ),
            'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
        ),
    )
));
$oxy_theme->register_metabox( array(
    'id' => 'services_icon_metabox',
    'title' => __('Service Image & Icon', 'swatch-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'pages' => array('oxy_service'),
    'fields' => array(
        array(
            'name' => __('Image Type', 'swatch-admin-td'),
            'id'   => 'image_type',
            'desc'    => __('Services can show an uploaded Image, or an Icon or Both Image and Icon.', 'swatch-admin-td'),
            'type' => 'select',
            'options' => array(
                'image'       => __('Featured Image', 'swatch-admin-td'),
                'icon'        => __('Icon', 'swatch-admin-td'),
                'both'        => __('Featured Image & Icon', 'swatch-admin-td'),
                'nothing'     => __('Nothing', 'swatch-admin-td'),
            )
        ),
        array(
            'name'    => __('Icon', 'swatch-admin-td'),
            'desc'    => __('If you select Icon or Featured Image & Icon Image Type this is the icon that will be used.', 'swatch-admin-td'),
            'id'      => 'icon',
            'type'    => 'select',
            'options' => 'icons',
        ),
        array(
            'name'    => __('Icon Animation', 'swatch-admin-td'),
            'desc'    => __('If you select Icon or Featured Image & Icon Image Type this is the animation that will be used when you hover over it.', 'swatch-admin-td'),
            'id'      => 'icon_animation',
            'type'    => 'select',
            'default' => 'bounce',
            'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-button-animations.php'
        ),
    )
));
$oxy_theme->register_metabox( array(
    'id' => 'site_header',
    'title' => __('Site Header', 'swatch-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'pages' => array('page'),
    'fields' => array(
        array(
            'name' => __('Show Site Header', 'swatch-admin-td'),
            'id'   => 'show_site_header',
            'type' => 'select',
            'desc' => __('Removes the whole site header (logo and menu) - useful for landing pages', 'swatch-admin-td'),
            'default' => 'show',
            'options' => array(
                'hide'      => __('Hide', 'swatch-admin-td'),
                'show'      => __('Show', 'swatch-admin-td'),
            ),
        ),
    )
));
$oxy_theme->register_metabox( array(
    'id' => 'metabox_header',
    'title' => __('Header Options', 'swatch-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'pages' => array('page', 'oxy_service'),
    'javascripts' => array(
        array(
            'handle' => 'header_options_script',
            'src'    => OXY_THEME_URI . 'inc/options/javascripts/metaboxes/header-options.js',
            'deps'   => array( 'jquery'),
            'localize' => array(
                'object_handle' => 'theme',
                'data'          => THEME_SHORT
            ),
        ),
    ),
    'fields' => array(
        array(
            'name' => __('Page Header', 'swatch-admin-td'),
            'desc' => __('Show or hide the header at the top of the page.', 'swatch-admin-td'),
            'id'   => 'show_header',
            'type' => 'select',
            'default' => 'hide',
            'options' => array(
                'hide' => __('Hide', 'swatch-admin-td'),
                'show' => __('Show', 'swatch-admin-td'),
            ),
        ),
        array(
            'name'    => __('Header Title Capitalisation', 'swatch-admin-td'),
            'desc'    => __('Sets the case of the page header title.', 'swatch-admin-td'),
            'id'      => 'header_capitalisation',
            'type'    => 'select',
            'options' => array(
                'text-caps'         => __('Force Uppercase', 'swatch-admin-td'),
                'text-lowercase'    => __('Force Lowercase', 'swatch-admin-td'),
                'text-capitalize'   => __('Force Capitalization', 'swatch-admin-td'),
                'text-no-caps'      => __('Off', 'swatch-admin-td'),
            ),
            'default' => 'text-caps',
        ),
        array(
            'name' => __('Page Header Alignment', 'swatch-admin-td'),
            'desc' => __('Align the text shown in the header left right or center.', 'swatch-admin-td'),
            'id'   => 'align_header',
            'type' => 'select',
            'default' => 'left',
            'options' => array(
                'left'   => __('Left', 'swatch-admin-td'),
                'center' => __('Center', 'swatch-admin-td'),
                'right'  => __('Right', 'swatch-admin-td'),
                'justify'  => __('Justify', 'swatch-admin-td')
            ),
        ),
        array(
             'name'    => __('Page Header Subtitle', 'swatch-admin-td'),
             'desc'    => __('Add a subtitle to be used in the page header after the main title.', 'swatch-admin-td'),
             'id'      => 'header_subtitle',
             'default' => '',
             'type' => 'text',
        ),
        array(
            'name'    => __('Swatch', 'swatch-admin-td'),
            'desc'    => __('Select the colour scheme to use for the header on this page.', 'swatch-admin-td'),
            'id'      => 'header_swatch',
            'type' => 'select',
            'default' => 'swatch-white',
            'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
        ),
    )
));
$link_options = array(
    'id'    => 'link_metabox',
    'title' => __('Link', 'swatch-admin-td'),
    'priority' => 'default',
    'context'  => 'advanced',
    'pages'    => array('oxy_service', 'oxy_staff', 'oxy_portfolio_image'),
    'javascripts' => array(
        array(
            'handle' => 'slider_links_options_script',
            'src'    => OXY_THEME_URI . 'inc/options/javascripts/metaboxes/slider-links-options.js',
            'deps'   => array( 'jquery'),
            'localize' => array(
                'object_handle' => 'theme',
                'data'          => THEME_SHORT
            ),
        ),
    ),
    'fields'  => array(
        array(
            'name' => __('Link Type', 'swatch-admin-td'),
            'desc' => __('Make this post link to something.  Default link will link to the single item page.', 'swatch-admin-td'),
            'id'   => 'link_type',
            'type' => 'select',
            'options' => array(
                'default'   => __('Default Link', 'swatch-admin-td'),
                'page'      => __('Page', 'swatch-admin-td'),
                'post'      => __('Post', 'swatch-admin-td'),
                'portfolio' => __('Portfolio', 'swatch-admin-td'),
                'category'  => __('Category', 'swatch-admin-td'),
                'url'       => __('URL', 'swatch-admin-td'),
                'none'      => __('No Link', 'swatch-admin-td')
            ),
            'default' => 'default',
        ),
        array(
            'name'     => __('Page Link', 'swatch-admin-td'),
            'desc'     => __('Choose a page to link this item to', 'swatch-admin-td'),
            'id'       => 'page_link',
            'type'     => 'select',
            'options'  => 'taxonomy',
            'taxonomy' => 'pages',
            'default' =>  '',
        ),
        array(
            'name'     => __('Post Link', 'swatch-admin-td'),
            'desc'     => __('Choose a post to link this item to', 'swatch-admin-td'),
            'id'       => 'post_link',
            'type'     => 'select',
            'options'  => 'taxonomy',
            'taxonomy' => 'posts',
            'default' =>  '',
        ),
        array(
            'name'     => __('Portfolio Link', 'swatch-admin-td'),
            'desc'     => __('Choose a portfolio item to link this item to', 'swatch-admin-td'),
            'id'       => 'portfolio_link',
            'type'     => 'select',
            'options'  => 'taxonomy',
            'taxonomy' => 'oxy_portfolio_image',
            'default' =>  '',
        ),
        array(
            'name'     => __('Category Link', 'swatch-admin-td'),
            'desc'     => __('Choose a category list to link this item to', 'swatch-admin-td'),
            'id'       => 'category_link',
            'type'     => 'select',
            'options'  => 'categories',
            'default' =>  '',
        ),
        array(
            'name'    => __('URL Link', 'swatch-admin-td'),
            'desc'     => __('Choose a URL to link this item to', 'swatch-admin-td'),
            'id'      => 'url_link',
            'type'    => 'text',
            'default' =>  '',
        ),
    ),
);

$oxy_theme->register_metabox( $link_options );

// modify link options metabox for slideshow image before registering
unset($link_options['fields'][0]['options']['default']);
$link_options['fields'][0]['options']['none'] = __('No Link', 'swatch-admin-td');
$link_options['fields'][0]['default'] = 'none';
$link_options['pages'] = array('oxy_slideshow_image');
$link_options['id'] = 'slide_link_metabox';

$oxy_theme->register_metabox( $link_options );

$oxy_theme->register_metabox( array(
    'id' => 'services_link_metabox',
    'title' => __('Link target', 'swatch-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'pages' => array('oxy_service'),
    'fields' => array(
        array(
            'name' => __('Link Target', 'swatch-admin-td'),
            'desc'     => __('Choose how this item will be opened up in the browser.  In a new window / tab or ths same window.', 'swatch-admin-td'),
            'id'   => 'link_target',
            'type' => 'select',
            'options' => array(
                '_self'   => __('Same page as it was clicked ', 'swatch-admin-td'),
                '_blank'  => __('Open in new window/tab', 'swatch-admin-td'),
                '_parent' => __('Open in the parent frameset', 'swatch-admin-td'),
                '_top'    => __('Open in the full body of the window', 'swatch-admin-td')
            ),
            'default' =>  '_self'
        ),
    )
));
// STAFF METABOXES
$oxy_theme->register_metabox( array(
    'id' => 'staff_info',
    'title' => __('Personal Details', 'swatch-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'pages' => array('oxy_staff'),
    'fields' => array(
        array(
            'name'    => __('Job Title', 'swatch-admin-td'),
            'desc'    => __('Sub header that is shown below the staff members name.', 'swatch-admin-td'),
            'id'      => 'position',
            'type'    => 'text',
        ),
        array(
            'name'    => __('Personal Moto Title', 'swatch-admin-td'),
            'desc'    => __('The cheeky title that pops up when a staff member image is hovered over.', 'swatch-admin-td'),
            'id'      => 'moto_title',
            'type'    => 'text',
        ),
        array(
            'name'    => __('Personal Moto Text', 'swatch-admin-td'),
            'desc'    => __('The cheeky text that pops up when a staff member image is hovered over.', 'swatch-admin-td'),
            'id'      => 'moto_text',
            'type'    => 'text',
        ),
    )
));

$staff_social = array();
for( $i = 0 ; $i < 5 ; $i++ ) {
    $staff_social[] =
        array(
            'name' => __('Social Icon', 'swatch-admin-td') . ' ' . ($i+1),
            'desc' => __('Social Network Icon to show for this Staff Member', 'swatch-admin-td'),
            'id'   => 'icon' . $i,
            'type' => 'select',
            'options' => 'icons',
        );
    $staff_social[] =
        array(
            'name'  => __('Social Link', 'swatch-admin-td'). ' ' . ($i+1),
            'desc' => __('Add the url to the staff members social network here.', 'swatch-admin-td'),
            'id'    => 'link' . $i,
            'type'  => 'text',
            'std'   => '',
        );
}

$oxy_theme->register_metabox( array(
    'id' => 'staff_social',
    'title' => __('Social', 'swatch-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'pages' => array('oxy_staff'),
    'fields' => $staff_social,
));

$oxy_theme->register_metabox( array(
    'id' => 'portfolio_template_metabox',
    'title' => __('Portfolio Header Options', 'swatch-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'pages' => array('oxy_portfolio_image'),
    'fields' => array(
        array(
            'name' => __('Portfolio Header Type', 'swatch-admin-td'),
            'id'   => 'template',
            'desc'    => __("Select a header to use for this portfolio item single page.<br><strong>Big Image</strong> - Will add a full width header to the top of the page which will contain the featured image, Header Title & Description with the skill list on the right side <a href='http://themes.oxygenna.com/swatch/?oxy_portfolio_image=vimeo-video' target='_blank'>like this</a>.<br><strong>Smaller Image</strong> - Will create a header with a smaller image and Header Title, Description and link on the right side of the image <a href='http://themes.oxygenna.com/swatch/?oxy_portfolio_image=integer-sollicitudin' target='_blank'>like this</a>.<br><strong>Full Width Page</strong> Allows you to create your own page using sections, just like a regular full width page.", 'swatch-admin-td'),
            'type' => 'select',
            'options' => array(
                'big'     => __('Big Image', 'swatch-admin-td'),
                'small'   => __('Smaller Image', 'swatch-admin-td'),
                'page.php'=> __('Full Width Page', 'swatch-admin-td'),
            )
        ),
        array(
            'name'  => __('Header Title', 'swatch-admin-td'),
            'id'    => 'description_title',
            'type'  => 'text',
            'desc'  => __('Title that will be shown above your header description.', 'swatch-admin-td'),
            'std'   => __('Project Desscription', 'swatch-admin-td'),
        ),
        array(
            'name'  => __('Header Description', 'swatch-admin-td'),
            'id'    => 'description',
            'type'  => 'textarea',
            'attr'  => array( 'rows' => '10', 'style' => 'width:100%' ),
            'desc'  => __('Description will appear in single portfolio header before the content', 'swatch-admin-td'),
            'std'   => '',
        ),
        array(
            'name'  => __('Header Item Link', 'swatch-admin-td'),
            'desc'  => __('Link will appear in the single portfolio item underneath the skills list.', 'swatch-admin-td'),
            'id'    => 'link',
            'type'  => 'text',
            'std'   => '',
        ),
    )
));

$oxy_theme->register_metabox( array(
    'id'       => 'service_template_metabox',
    'title'    => __('Service Template', 'swatch-admin-td'),
    'priority' => 'default',
    'context'  => 'advanced',
    'pages'    => array('oxy_service'),
    'fields'   => array(
        array(
            'name'    => __('Service Page Template', 'swatch-admin-td'),
            'id'      => 'template',
            'desc'    => __('Select a page template to use for this service', 'swatch-admin-td'),
            'type'    => 'select',
            'options' => array(
                'page.php'                  => __('Full Width', 'swatch-admin-td'),
                'template-leftsidebar.php'  => __('Left Sidebar', 'swatch-admin-td'),
                'template-rightsidebar.php' => __('Right Sidebar', 'swatch-admin-td'),
            ),
            'default' => 'page.php',
        ),
    )
));

/* SWATCH METABOX */
$oxy_theme->register_metabox( array(
    'id'       => 'swatch_colours_metabox',
    'title'    => __('Swatch Colours', 'swatch-admin-td'),
    'priority' => 'default',
    'context'  => 'advanced',
    'pages'    => array('oxy_swatch'),
    'fields'   => array(
        array(
            'name'    => __('Background', 'swatch-admin-td'),
            'id'      => 'background',
            'desc'    => __('Background colour of the swatch', 'swatch-admin-td'),
            'default' => '#FFFFFF',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Heading', 'swatch-admin-td'),
            'id'      => 'heading',
            'desc'    => __('Text headings colour', 'swatch-admin-td'),
            'default' => '#FFFFFF',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Heading Links', 'swatch-admin-td'),
            'id'      => 'heading_links',
            'desc'    => __('Link colour after link has been clicked', 'swatch-admin-td'),
            'default' => '#FFFFFF',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Text', 'swatch-admin-td'),
            'id'      => 'text',
            'desc'    => __('Text colour', 'swatch-admin-td'),
            'default' => '#FFFFFF',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Link', 'swatch-admin-td'),
            'id'      => 'link',
            'desc'    => __('Text links colour', 'swatch-admin-td'),
            'default' => '#FFFFFF',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Link Hover', 'swatch-admin-td'),
            'id'      => 'link_hover',
            'desc'    => __('Link colour when hovered over', 'swatch-admin-td'),
            'default' => '#FFFFFF',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Link Active', 'swatch-admin-td'),
            'id'      => 'link_active',
            'desc'    => __('Link colour after link has been clicked', 'swatch-admin-td'),
            'default' => '#FFFFFF',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Icons', 'swatch-admin-td'),
            'id'      => 'icons',
            'desc'    => __('Colour of all icons', 'swatch-admin-td'),
            'default' => '#FFFFFF',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Overlay', 'swatch-admin-td'),
            'id'      => 'overlay',
            'desc'    => __('Colour for overlay areas (see bottom footer stripe)', 'swatch-admin-td'),
            'default' => '#FFFFFF',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Form Background', 'swatch-admin-td'),
            'id'      => 'form_background',
            'desc'    => __('Form elements background colour', 'swatch-admin-td'),
            'default' => '#FFFFFF',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Form Text Colour', 'swatch-admin-td'),
            'id'      => 'form',
            'desc'    => __('Colour of text inside form elements', 'swatch-admin-td'),
            'default' => '#FFFFFF',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Woocommerce button Colour', 'swatch-admin-td'),
            'id'      => 'woobutton',
            'desc'    => __('Background Colour of woocommerce buttons', 'swatch-admin-td'),
            'default' => '#FFFFFF',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Woocommerce text Colour', 'swatch-admin-td'),
            'id'      => 'woobuttontext',
            'desc'    => __('Text Colour of woocommerce buttons', 'swatch-admin-td'),
            'default' => '#FFFFFF',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Woocommerce product Colour', 'swatch-admin-td'),
            'id'      => 'wooproducttext',
            'desc'    => __('Text Colour on woocommerce product lists', 'swatch-admin-td'),
            'default' => '#FFFFFF',
            'type'    => 'colour',
        ),
        array(
            'name'    => __('Woocommerce link Colour', 'swatch-admin-td'),
            'id'      => 'wooproductlink',
            'desc'    => __('Link Colour on woocommerce product lists', 'swatch-admin-td'),
            'default' => '#FFFFFF',
            'type'    => 'colour',
        ),
    )
));

$oxy_theme->register_metabox( array(
    'id' => 'category_header',
    'title' => __('Category Header Type', 'swatch-admin-td'),
    'priority' => 'default',
    'context' => 'advanced',
    'taxonomies' => array('product_cat'),
    'javascripts' => array(
        array(
            'handle' => 'woo_product_categories_script',
            'src'    => OXY_THEME_URI . 'inc/options/javascripts/categories/product-category-options.js',
            'deps'   => array( 'jquery'),
            'localize' => array(
                'object_handle' => 'theme',
                'data'          => THEME_SHORT
            ),
        ),
    ),
    'fields' => array(
       array(
            'name' => __('Category Header Type', 'swatch-admin-td'),
            'desc' => __('Select the type of header to be displayed in your category page', 'swatch-admin-td'),
            'id'   => 'category_header_type',
            'type' => 'select',
            'default' => 'left',
            'options' => array(
                'none'      => __('No Header', 'swatch-admin-td'),
                'text'      => __('Text', 'swatch-admin-td'),
                'slideshow' => __('Slideshow', 'swatch-admin-td'),
            ),
        ),
        array(
            'name'  => __('Category Header subtitle', 'swatch-admin-td'),
            'id'    => 'category_header_subtitle',
            'type'  => 'text',
            'desc'  => __('Subtitle that will be shown next to your header title.', 'swatch-admin-td'),
            'std'   => __('category subtitle', 'swatch-admin-td'),
            'default' => '',
        ),
        array(
            'name'    => __('Choose a Revolution Slider', 'swatch-admin-td'),
            'desc'    => __('Choose the revolution slider that you want to display in the category page', 'swatch-admin-td'),
            'id'      => 'category_revolution',
            'default' =>  '',
            'type'    => 'select',
            'options' => 'revolution',
        ),
    )
));
