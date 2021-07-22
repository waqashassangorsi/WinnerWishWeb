<?php
/**
 * Registers all theme option pages
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
if( isset($oxy_theme) ) {
    $oxy_theme->register_option_page( array(
        'page_title' => THEME_NAME . ' - ' . __('General', 'swatch-admin-td'),
        'menu_title' => __('General', 'swatch-admin-td'),
        'slug'       => THEME_SHORT . '-general',
        'main_menu'  => true,
        'main_menu_title' => THEME_NAME,
        'main_menu_icon'  => 'dashicons-marker',
        'icon'       => 'tools',
        'javascripts' => array(
            array(
                'handle' => 'header_options_script',
                'src'    => OXY_THEME_URI . 'inc/options/javascripts/pages/header-options.js',
                'deps'   => array( 'jquery'),
                'localize' => array(
                    'object_handle' => 'theme',
                    'data'          => THEME_SHORT
                ),
            ),
        ),
        'sections'   => array(
            'logo-section' => array(
                'title'   => __('Logo', 'swatch-admin-td'),
                'header'  => __('These options allow you to configure the site logo, you can select a logo type and then create a text logo, image logo or both image and text.  There is also an option to use retina sized images.', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Logo Type', 'swatch-admin-td'),
                        'desc'    => __('Select which kind of logo you would like.<br><strong>Text</strong> - Plain text only logo (uses body font)<br><strong>Image</strong> - Image only logo<br><strong>Text & Image</strong> - Text followed by an image (text will use the body font)', 'swatch-admin-td'),
                        'id'      => 'logo_type',
                        'type'    => 'radio',
                        'options' => array(
                            'text'       => __('Text', 'swatch-admin-td'),
                            'image'      => __('Image', 'swatch-admin-td'),
                            'text_image' => __('Text & Image', 'swatch-admin-td'),
                        ),
                        'default' => 'text',
                    ),
                    array(
                        'name'    => __('Logo Text', 'swatch-admin-td'),
                        'desc'    => __('Add your logo text here works with Logo Type (Text, Text & Image)', 'swatch-admin-td'),
                        'id'      => 'logo_text',
                        'type'    => 'text',
                        'default' => 'Swatch',
                    ),
                    array(
                        'name'    => __('Logo Image', 'swatch-admin-td'),
                        'desc'    => __('Upload a logo for your site, works with Logo Type (Image, Text & Image)', 'swatch-admin-td'),
                        'id'      => 'logo_image',
                        'store'   => 'id',
                        'type'    => 'upload',
                        'default' => '',
                    ),
                    array(
                        'name'    => __('Retina Logo', 'swatch-admin-td'),
                        'desc'    => __('Use retina logo (NOTE - you will need to upload a logo that is twice the size intended to display)', 'swatch-admin-td'),
                        'id'      => 'logo_retina',
                        'type'    => 'radio',
                        'options' => array(
                            'on'  => __('Retina Logo', 'swatch-admin-td'),
                            'off' => __('Normal Logo', 'swatch-admin-td'),
                        ),
                        'default' => 'off',
                    ),
                )
            ),
            'header-section' => array(
                'title'   => __('Header Options', 'swatch-admin-td'),
                'header'  => __('This section will allow you to setup your site header.  You can choose from three different types of header to use on your site, and adjust the header height to allow room for your logo.', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Header Type', 'swatch-admin-td'),
                        'desc'    => __("Header menu style <a href='http://themes.oxygenna.com/swatch/headers/'>See how they look here</a>", 'swatch-admin-td'),
                        'id'      => 'header_type',
                        'type'    => 'radio',
                        'options' => array(
                            'standard'    => __('Standard', 'swatch-admin-td'),
                            'top_bar'     => __('Top Bar', 'swatch-admin-td'),
                            'combo'       => __('Combo', 'swatch-admin-td'),
                        ),
                        'default' => 'standard',
                    ),
                    array(
                        'name'    => __('Menu Position', 'swatch-admin-td'),
                        'desc'    => __('Choose between fixed (menu will scroll with the page) and fixed (menu will not scroll) positioning. NOTE - will only work with Standard Header Type', 'swatch-admin-td'),
                        'id'      => 'header_position',
                        'type'    => 'radio',
                        'options' => array(
                            'fixed'  => __('Fixed', 'swatch-admin-td'),
                            'static' => __('Static', 'swatch-admin-td'),
                        ),
                        'default' => 'fixed',
                    ),
                    array(
                        'name'    => __('Hover Menu', 'swatch-admin-td'),
                        'desc'    => __('Choose between menu that will open when you click or hover', 'swatch-admin-td'),
                        'id'      => 'menu',
                        'type'    => 'radio',
                        'options' => array(
                            'standard'  => __('Click', 'swatch-admin-td'),
                            'hover'     => __('Hover', 'swatch-admin-td'),
                        ),
                        'default' => 'standard',
                    ),
                    array(
                        'name'      => __('Header Height', 'swatch-admin-td'),
                        'desc'      => __('Use this slider to adjust the header height.  Ideal if you want to adjust the height to fit your logo.', 'swatch-admin-td'),
                        'id'        => 'header_height',
                        'type'      => 'slider',
                        'default'   => 85,
                        'attr'      => array(
                            'max'       => 300,
                            'min'       => 70,
                            'step'      => 1
                        )
                    ),
                    array(
                        'name'    => __('Header Swatch', 'swatch-admin-td'),
                        'desc'    => __('Choose a color swatch for the header', 'swatch-admin-td'),
                        'id'      => 'header_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-white',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'    => __('Top Bar Swatch', 'swatch-admin-td'),
                        'desc'    => __('Choose a color swatch for the Top Bar when you have a Header Type Top Bar or Combo', 'swatch-admin-td'),
                        'id'      => 'top_bar_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-white',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'    => __('Menu Bar Swatch', 'swatch-admin-td'),
                        'desc'    => __('Choose a color swatch for the Menu when you have a Header Type Combo', 'swatch-admin-td'),
                        'id'      => 'bottom_bar_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-white',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                )
            ),
            'upper-footer-section' => array(
                'title'   => __('Upper Footer', 'swatch-admin-td'),
                'header'  => __('This footer is above the bottom footer of your site.  Here you can set the footer to use 1-4 columns, you can add Widgets to your footer in the Appearance -> Widgets page', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Upper Footer Columns', 'swatch-admin-td'),
                        'desc'    => __('Select how many columns will the upper footer consist of.', 'swatch-admin-td'),
                        'id'      => 'upper_footer_columns',
                        'type'    => 'radio',
                        'options' => array(
                            1  => __('1', 'swatch-admin-td'),
                            2  => __('2', 'swatch-admin-td'),
                            3  => __('3', 'swatch-admin-td'),
                            4  => __('4', 'swatch-admin-td'),
                        ),
                        'default' => 2,
                    ),
                    array(
                        'name'    => __('Upper Footer Swatch', 'swatch-admin-td'),
                        'desc'    => __('Choose a color swatch for the upper footer', 'swatch-admin-td'),
                        'id'      => 'upper_footer_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-white',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                )
            ),
            'footer-section' => array(
                'title'   => __('Footer', 'swatch-admin-td'),
                'header'  => __('The footer is the bottom bar of your site.  Here you can set the footer to use 1-4 columns, you can add Widgets to your footer in the Appearance -> Widgets page', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Footer Columns', 'swatch-admin-td'),
                        'desc'    => __('Select how many columns will the footer consist of.', 'swatch-admin-td'),
                        'id'      => 'footer_columns',
                        'type'    => 'radio',
                        'options' => array(
                            1  => __('1', 'swatch-admin-td'),
                            2  => __('2', 'swatch-admin-td'),
                            3  => __('3', 'swatch-admin-td'),
                            4  => __('4', 'swatch-admin-td'),
                        ),
                        'default' => 2,
                    ),
                    array(
                        'name'    => __('Footer Swatch', 'swatch-admin-td'),
                        'desc'    => __('Choose a color swatch for the footer', 'swatch-admin-td'),
                        'id'      => 'footer_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-white',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'    => __('Back to top', 'swatch-admin-td'),
                        'desc'    => __('Enable the back-to-top button', 'swatch-admin-td'),
                        'id'      => 'back_to_top',
                        'type'    => 'radio',
                        'options' => array(
                            'enable'  => __('Enable', 'swatch-admin-td'),
                            'disable'  => __('Disable', 'swatch-admin-td'),
                        ),
                        'default' => 'enable',
                    ),
                    array(
                        'name'    => __('Back to top Swatch', 'swatch-admin-td'),
                        'desc'    => __('Choose a color swatch for the back to top button', 'swatch-admin-td'),
                        'id'      => 'back_to_top_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-coral',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                )
            ),
            'google-map-section' => array(
                'title'   => __('Google Maps API key', 'swatch-admin-td'),
                'header'  => __('Activates the Google Maps JavaScript API. Create an API key as instructed <a href="https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key" target="_blank">here</a> to enable Google Maps on your pages.', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'     => __('Google Maps API key', 'swatch-admin-td'),
                        'desc'     => __(' <strong>Necessary</strong> for the Google Map shortcode.', 'swatch-admin-td'),
                        'id'       => 'api_key',
                        'type'     => 'text',
                        'default' =>  '',
                    ),
                )
            ),
        )
    ));
    $oxy_theme->register_option_page( array(
        'page_title' => THEME_NAME . ' - ' . __('Blog', 'swatch-admin-td'),
        'menu_title' => __('Blog', 'swatch-admin-td'),
        'slug'       => THEME_SHORT . '-blog',
        'main_menu'  => false,
        'icon'       => 'tools',
        'sections'   => array(
            'blog-section' => array(
                'title'   => __('General Blog Options', 'swatch-admin-td'),
                'header'  => __('Here you can setup the blog options that are used on all the main blog list pages', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name' => __('Blog title', 'swatch-admin-td'),
                        'desc' => __('The title that appears at the top of your blog', 'swatch-admin-td'),
                        'id' => 'blog_title',
                        'type' => 'text',
                        'default' => __('Our Blog', 'swatch-admin-td')
                    ),
                    array(
                        'name' => __('Blog sub title', 'swatch-admin-td'),
                        'desc' => __('The sub title that appears at the top of your blog', 'swatch-admin-td'),
                        'id' => 'blog_subtitle',
                        'type' => 'text',
                        'default' => __('latest news and updates', 'swatch-admin-td')
                    ),
                    array(
                        'name' => __('Show Blog Header', 'swatch-admin-td'),
                        'desc' => __('Show or hide the header with blog title / subtitle at the top of all blog pages', 'swatch-admin-td'),
                        'id' => 'blog_show_header',
                        'type' => 'radio',
                        'options' => array(
                            'show' => __('Show', 'swatch-admin-td'),
                            'hide' => __('Hide', 'swatch-admin-td'),
                        ),
                        'default' => 'show'
                    ),
                    array(
                        'name'    => __('Blog Layout', 'swatch-admin-td'),
                        'desc'    => __('Layout of your blog page. Choose right sidebar, left sidebar, fullwidth layout', 'swatch-admin-td'),
                        'id'      => 'blog_layout',
                        'type'    => 'radio',
                        'options' => array(
                            'sidebar-right' => __('Right Sidebar', 'swatch-admin-td'),
                            'full-width'    => __('Full Width', 'swatch-admin-td'),
                            'sidebar-left'  => __('Left Sidebar', 'swatch-admin-td'),
                        ),
                        'default' => 'sidebar-right',
                    ),
                    array(
                        'name'    => __('Show Comments On', 'swatch-admin-td'),
                        'desc'    => __('Where to allow comments. All (show all), Pages (only on pages), Posts (only on posts), Off (all comments are off)', 'swatch-admin-td'),
                        'id'      => 'site_comments',
                        'type'    => 'radio',
                        'options' => array(
                            'all'   => __('All', 'swatch-admin-td'),
                            'pages' => __('Pages', 'swatch-admin-td'),
                            'posts' => __('Posts', 'swatch-admin-td'),
                            'Off'   => __('Off', 'swatch-admin-td')
                        ),
                        'default' => 'posts',
                    ),
                    array(
                        'name'    => __('Show Read More', 'swatch-admin-td'),
                        'desc'    => __('Show or hide the readmore link in list view', 'swatch-admin-td'),
                        'id'      => 'blog_show_readmore',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'swatch-admin-td'),
                            'off'  => __('Off', 'swatch-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name' => __('Blog read more link', 'swatch-admin-td'),
                        'desc' => __('The text that will be used for your read more links', 'swatch-admin-td'),
                        'id' => 'blog_readmore',
                        'type' => 'text',
                        'default' => 'read more',
                    ),
                    array(
                        'name'    => __('Strip teaser', 'swatch-admin-td'),
                        'desc'    => __('Strip the content before the <--more--> tag in single post view', 'swatch-admin-td'),
                        'id'      => 'blog_stripteaser',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'swatch-admin-td'),
                            'off'  => __('Off', 'swatch-admin-td'),
                        ),
                        'default' => 'off',
                    ),
                    array(
                        'name'    => __('Pagination Style', 'swatch-admin-td'),
                        'desc'    => __('How your pagination will be shown', 'swatch-admin-td'),
                        'id'      => 'blog_pagination',
                        'type'    => 'radio',
                        'options' => array(
                            'pages'     => __('Pages', 'swatch-admin-td'),
                            'next_prev' => __('Next & Previous', 'swatch-admin-td'),
                        ),
                        'default' => 'pages',
                    ),
                )
            ),
            'blog-single-section' => array(
                'title'   => __('Blog Single Page', 'swatch-admin-td'),
                'header'  => __('This section allows you to set up how your single post will look.', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Display categories', 'swatch-admin-td'),
                        'desc'    => __('Toggle categories on/off in post', 'swatch-admin-td'),
                        'id'      => 'blog_categories',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'swatch-admin-td'),
                            'off'  => __('Off', 'swatch-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name'    => __('Display tags', 'swatch-admin-td'),
                        'desc'    => __('Toggle tags on/off in post', 'swatch-admin-td'),
                        'id'      => 'blog_tags',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'swatch-admin-td'),
                            'off'  => __('Off', 'swatch-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name'    => __('Display comment count', 'swatch-admin-td'),
                        'desc'    => __('Toggle comment count on/off in post', 'swatch-admin-td'),
                        'id'      => 'blog_comment_count',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'swatch-admin-td'),
                            'off'  => __('Off', 'swatch-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name'    => __('Show related posts', 'swatch-admin-td'),
                        'desc'    => __('Show Related Posts after the post content', 'swatch-admin-td'),
                        'id'      => 'related_posts',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'swatch-admin-td'),
                            'off'  => __('Off', 'swatch-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name'    => __('Number of related posts', 'swatch-admin-td'),
                        'desc'    => __('Choose how many related posts are displayed in the related posts section after the post content', 'swatch-admin-td'),
                        'id'      => 'related_posts_number',
                        'type'    => 'radio',
                        'options' => array(
                            '3'   => __('3', 'swatch-admin-td'),
                            '4'   => __('4', 'swatch-admin-td'),
                            '6'   => __('6', 'swatch-admin-td'),
                            '8'   => __('8', 'swatch-admin-td'),
                        ),
                        'default' => '3',
                    ),
                    array(
                        'name'    => __('Related posts per slide', 'swatch-admin-td'),
                        'desc'    => __('Choose how many related posts are displayed in each slide', 'swatch-admin-td'),
                        'id'      => 'related_posts_per_slide',
                        'type'    => 'radio',
                        'options' => array(
                            '3'   => __('3', 'swatch-admin-td'),
                            '4'   => __('4', 'swatch-admin-td'),
                        ),
                        'default' => '3',
                    ),
                    array(
                        'name'    => __('Show author bio', 'swatch-admin-td'),
                        'desc'    => __('Display author bio after the post content', 'swatch-admin-td'),
                        'id'      => 'author_bio',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'swatch-admin-td'),
                            'off'  => __('Off', 'swatch-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name'    => __('Display avatar', 'swatch-admin-td'),
                        'desc'    => __('Toggle avatars on/off in Author Bio Section', 'swatch-admin-td'),
                        'id'      => 'site_avatars',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'swatch-admin-td'),
                            'off'  => __('Off', 'swatch-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name'    => __('Open Featured Image in Magnific Popup', 'swatch-admin-td'),
                        'desc'    => __('Featured image in single post view will open in a large preview popup', 'swatch-admin-td'),
                        'id'      => 'blog_fancybox',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'swatch-admin-td'),
                            'off'  => __('Off', 'swatch-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                )
            ),
            'swatches-section' => array(
                'title'   => __('Swatches', 'swatch-admin-td'),
                'header'  => __('All the blog sections can be swatched.  You can choose the colours of your blog header, posts, related posts, author bio even the pagination colours!', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Default Post Swatch', 'swatch-admin-td'),
                        'desc'    => __('This swatch will be used as the default swatch for all new posts', 'swatch-admin-td'),
                        'id'      => 'blog_default_post_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-clouds',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'    => __('Blog header Swatch', 'swatch-admin-td'),
                        'desc'    => __('Choose a color swatch for headers in blog/category/search/archive', 'swatch-admin-td'),
                        'id'      => 'blog_header_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-midnightblue',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'    => __('Blog Page Swatch', 'swatch-admin-td'),
                        'desc'    => __('Choose a color swatch for the Blog page ( Affects Left / Right Sidebar View Only )', 'swatch-admin-td'),
                        'id'      => 'blog_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-clouds',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'    => __('Related Posts Swatch', 'swatch-admin-td'),
                        'desc'    => __('Choose a color swatch for the related posts section below post content', 'swatch-admin-td'),
                        'id'      => 'related_posts_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-greensea',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'    => __('Author Bio section Swatch', 'swatch-admin-td'),
                        'desc'    => __('Choose a color swatch for the author bio section', 'swatch-admin-td'),
                        'id'      => 'author_bio_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-greensea',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'    => __('Pagination Swatch', 'swatch-admin-td'),
                        'desc'    => __('Choose a color swatch for the pagination used in blog list pages.', 'swatch-admin-td'),
                        'id'      => 'pagination_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-white',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                )
            ),
        )
    ));
     $oxy_theme->register_option_page( array(
        'page_title' => THEME_NAME . ' - ' . __('Flexslider Options', 'swatch-admin-td'),
        'menu_title' => __('Flexslider', 'swatch-admin-td'),
        'slug'       => THEME_SHORT . '-flexslider',
        'main_menu'  => false,
        'icon'       => 'tools',
        'sections'   => array(
            'slider-section' => array(
                'title' => __('Slideshow', 'swatch-admin-td'),
                'header'  => __('Setup your global default flexslider options.', 'swatch-admin-td'),
                'fields' => array(
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
                        'desc'    => __('Shows the navigation arrows at the sides of the flexslider.', 'swatch-admin-td'),
                        'default'   =>  'hide',
                        'options' => array(
                            'hide' => __('Hide', 'swatch-admin-td'),
                            'show' => __('Show', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Navigation arrows type', 'swatch-admin-td'),
                        'id'        => 'directionnavtype',
                        'type'      => 'radio',
                        'desc'      => __('Type of the direction arrows, fancy (with bg) or simple.', 'swatch-admin-td'),
                        'default'   =>  'simple',
                        'options' => array(
                            'simple' => __('Simple', 'swatch-admin-td'),
                            'fancy'  => __('Fancy', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Show controls', 'swatch-admin-td'),
                        'id'        => 'showcontrols',
                        'type'      => 'radio',
                        'default'   =>  'show',
                        'desc'    => __('If you choose hide the option below will be ignored', 'swatch-admin-td'),
                        'options' => array(
                            'hide' => __('Hide', 'swatch-admin-td'),
                            'show' => __('Show', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'      => __('Choose the place of the controls', 'swatch-admin-td'),
                        'id'        => 'controlsposition',
                        'type'      => 'radio',
                        'default'   =>  'inside',
                        'desc'    => __('Choose the position of the navigation controls', 'swatch-admin-td'),
                        'options' => array(
                            'inside'    => __('Inside', 'swatch-admin-td'),
                            'outside'   => __('Outside', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                        'name'      =>  __('Choose the alignment of the controls', 'swatch-admin-td'),
                        'id'        => 'controlsalign',
                        'type'      => 'radio',
                        'desc'    => __('Choose the alignment of the navigation controls', 'swatch-admin-td'),
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
                    array(
                        'name'      => __('Show tooltip', 'swatch-admin-td'),
                        'id'        => 'tooltip',
                        'type'      => 'radio',
                        'default'   =>  'hide',
                        'desc'    => __('Display the slide title as tooltip', 'swatch-admin-td'),
                        'options' => array(
                            'hide' => __('Hide', 'swatch-admin-td'),
                            'show' => __('Show', 'swatch-admin-td'),
                        ),
                    ),
                )
            ),
            'captions-section' => array(
                'title' => __('Captions', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Show Captions', 'swatch-admin-td'),
                        'id'        => 'captions',
                        'type'      => 'radio',
                        'default'   =>  'show',
                        'desc'    => __('If you choose hide the options below will be ignored', 'swatch-admin-td'),
                        'options' => array(
                            'hide' => __('Hide', 'swatch-admin-td'),
                            'show' => __('Show', 'swatch-admin-td'),
                            ),
                    ),
                    array(
                        'name'      => __('Captions Vertical Position', 'swatch-admin-td'),
                        'desc'      => __('Choose between bottom and top positioning', 'swatch-admin-td'),
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
                )
            ),
        )
    ));

    $oxy_theme->register_option_page(   array(
        'page_title' => THEME_NAME . ' - ' . __('404 Page Options', 'swatch-admin-td'),
        'menu_title' => __('404', 'swatch-admin-td'),
        'slug'       => THEME_SHORT . '-404',
        'main_menu'  => false,
        'icon'       => 'tools',
        'sections'   => array(
            '404-header-section' => array(
                'title'   => __('Header', 'swatch-admin-td'),
                'header'  => __('If someone goes to a invalid url this 404 page will be shown.  You can change the image, title, text and colour of the 404 page here.', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('404 image', 'swatch-admin-td'),
                        'desc'    => __('Upload an image to show on your 404 page', 'swatch-admin-td'),
                        'id'      => '404_header_image',
                        'type'    => 'upload',
                        'store'   => 'url',
                        'default' => OXY_THEME_URI . 'images/assets/vector/404.png',
                    ),
                    array(
                        'name'    => __('Page Title', 'swatch-admin-td'),
                        'desc'    => __('The title that appears on your 404 page', 'swatch-admin-td'),
                        'id'      => '404_title',
                        'type'    => 'text',
                        'default' => __('Page Not Found', 'swatch-admin-td')
                    ),
                    array(
                        'name'    => __('Page Text', 'swatch-admin-td'),
                        'desc'    => __('The content of your 404 page', 'swatch-admin-td'),
                        'id'      => '404_content',
                        'type'    => 'editor',
                        'settings' => array( 'media_buttons' => false ),
                        'default' => __('The page you requested could not be found.', 'swatch-admin-td')
                    ),
                    array(
                        'name'    => __('Page Swatch', 'swatch-admin-td'),
                        'desc'    => __('Choose a color swatch for the 404 page', 'swatch-admin-td'),
                        'id'      => '404_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-pomegranate',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    )
                )
            ),
        ),
    ));
    $oxy_theme->register_option_page( array(
        'page_title' => THEME_NAME . ' - ' . __('Portfolio Page Options', 'swatch-admin-td'),
        'menu_title' => __('Portfolio', 'swatch-admin-td'),
        'slug'       => THEME_SHORT . '-portfolio',
        'main_menu'  => false,
        'sections'   => array(
            'portfolio-section' => array(
                'title'   => __('Portfolio Single Page', 'swatch-admin-td'),
                'header'  => __('When you click on a portfolio item you will be taken to its single page.  You can change how these pages look here.', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Show Related items', 'swatch-admin-td'),
                        'desc'    => __('Show related portfolio items section', 'swatch-admin-td'),
                        'id'      => 'show_related',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'swatch-admin-td'),
                            'off'  => __('Off', 'swatch-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                    array(
                        'name'    => __('Related items title', 'swatch-admin-td'),
                        'desc'    => __('Related items title that is shown on single portfolio page above releated items', 'swatch-admin-td'),
                        'id'      => 'portfolio_related_title',
                        'type'    => 'text',
                        'default' => __('Related Work', 'swatch-admin-td'),
                    ),
                    array(
                        'name'    => __('Related items Swatch', 'swatch-admin-td'),
                        'desc'    => __('Swatch for the related items in single portfolio page', 'swatch-admin-td'),
                        'id'      => 'portfolio_related_swatch',
                        'type'    => 'select',
                        'default' => 'swatch-white',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                    array(
                        'name'    => __('Strip teaser', 'swatch-admin-td'),
                        'desc'    => __('Strip the content before the <--more--> tag in single portfolio view', 'swatch-admin-td'),
                        'id'      => 'portfolio_stripteaser',
                        'type'    => 'radio',
                        'options' => array(
                            'on'   => __('On', 'swatch-admin-td'),
                            'off'  => __('Off', 'swatch-admin-td'),
                        ),
                        'default' => 'on',
                    )
                )
            ),
            'portfolio-size-section' => array(
                'title'   => __('Portfolio Image Sizes', 'swatch-admin-td'),
                'header'  => __('When your portfolio images are uploaded they will be automatially saved using these dimensions.', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Image Width', 'swatch-admin-td'),
                        'desc'    => __('Width of each portfolio item', 'swatch-admin-td'),
                        'id'      => 'portfolio_item_width',
                        'type'    => 'slider',
                        'default'   => 800,
                        'attr'      => array(
                            'max'       => 1200,
                            'min'       => 50,
                            'step'      => 1
                        )
                    ),
                    array(
                        'name'    => __('Image Height', 'swatch-admin-td'),
                        'desc'    => __('Height of each portfolio item', 'swatch-admin-td'),
                        'id'      => 'portfolio_item_height',
                        'type'    => 'slider',
                        'default'   => 600,
                        'attr'      => array(
                            'max'       => 800,
                            'min'       => 50,
                            'step'      => 1
                        )
                    ),
                    array(
                        'name'      => __('Image Cropping', 'swatch-admin-td'),
                        'id'        => 'portfolio_item_crop',
                        'type'      => 'radio',
                        'default'   =>  'on',
                        'desc'    => __('Crop images to the exact proportions', 'swatch-admin-td'),
                        'options' => array(
                            'on' => __('Crop Images', 'swatch-admin-td'),
                            'off' => __('Do not crop', 'swatch-admin-td'),
                        ),
                    ),
                )
            ),
        )
    ));
    $oxy_theme->register_option_page( array(
        'page_title' => THEME_NAME . ' - ' . __('Contact Page Options', 'swatch-admin-td'),
        'menu_title' => __('Contact', 'swatch-admin-td'),
        'slug'       => THEME_SHORT . '-contact',
        'main_menu'  => false,
        'sections'   => array(
            'contact-top-section' => array(
                'title'   => __('Top Contact Details Box', 'swatch-admin-td'),
                'header'  => __("You can add two boxes above your <a href='http://themes.oxygenna.com/swatch/contact/' target='_blank'>contact page map</a>. These options allow you to set the title, content, icon, animation and swatch for the top box.", 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Title', 'swatch-admin-td'),
                        'desc'    => __('Title that is shown in the top box over a map', 'swatch-admin-td'),
                        'id'      => 'map_overlay_title_1',
                        'type'    => 'text',
                        'default' => 'Address',
                    ),
                    array(
                        'name'    => __('Content', 'swatch-admin-td'),
                        'desc'    => __('Content that is shown in the top box over a map', 'swatch-admin-td'),
                        'id'      => 'map_overlay_content_1',
                        'type'    => 'textarea',
                        'default' => "1234 Some Street,\n Fancytown,\n UK",
                        'attr'   => array(
                            'style' => 'width:400px;height:100px;',
                        )
                    ),
                    array(
                        'name'    => __('Icon', 'swatch-admin-td'),
                        'desc'    => __('Icon that is shown in the top box on map overlay', 'swatch-admin-td'),
                        'id'      => 'map_overlay_icon_1',
                        'type'    => 'select',
                        'options' => 'icons',
                        'default' => 'fa fa-map-marker',
                    ),
                    array(
                        'name'    => __('Icon Animation', 'swatch-admin-td'),
                        'desc'    => __('Choose an icon animation', 'swatch-admin-td'),
                        'id'      => 'map_overlay_icon_animation_1',
                        'type'    => 'select',
                        'default' => 'bounce',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-button-animations.php'
                    ),
                    array(
                        'name'    => __('Swatch', 'swatch-admin-td'),
                        'desc'    => __('Choose a color swatch for the top box over the map', 'swatch-admin-td'),
                        'id'      => 'map_overlay_swatch_1',
                        'type'    => 'select',
                        'default' => 'swatch-pomegranate',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                )
            ),
            'contact-bottom-section' => array(
                'title'   => __('Bottom Contact Details Box', 'swatch-admin-td'),
                'header'  => __("You can add two boxes above your <a href='http://themes.oxygenna.com/swatch/contact/' target='_blank'>contact page map</a>. These options allow you to set the title, content, icon, animation and swatch for the bottom box.", 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Title', 'swatch-admin-td'),
                        'desc'    => __('Title that is shown in the bottom box over a map', 'swatch-admin-td'),
                        'id'      => 'map_overlay_title_2',
                        'type'    => 'text',
                        'default' => 'Contact Details',
                    ),
                    array(
                        'name'    => __('Icon', 'swatch-admin-td'),
                        'desc'    => __('Icon that is shown in the bottom box on map overlay', 'swatch-admin-td'),
                        'id'      => 'map_overlay_icon_2',
                        'type'    => 'select',
                        'options' => 'icons',
                        'default' => 'fa fa-phone',
                    ),
                    array(
                        'name'    => __('Icon Animation', 'swatch-admin-td'),
                        'desc'    => __('Choose an icon animation', 'swatch-admin-td'),
                        'id'      => 'map_overlay_icon_animation_2',
                        'type'    => 'select',
                        'default' => 'shake',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-button-animations.php'
                    ),
                    array(
                        'name'    => __('Content', 'swatch-admin-td'),
                        'desc'    => __('Content that is shown in the bottom box over a map', 'swatch-admin-td'),
                        'id'      => 'map_overlay_content_2',
                        'type'    => 'textarea',
                        'default' => "Phone: 123 456 7890\nFax: +49 123 456 7891\nEmail: info@somecompany.com",
                        'attr'   => array(
                            'style' => 'width:400px;height:100px;',
                        )
                    ),
                    array(
                        'name'    => __('Swatch', 'swatch-admin-td'),
                        'desc'    => __('Choose a color swatch for the bottom box over the map', 'swatch-admin-td'),
                        'id'      => 'map_overlay_swatch_2',
                        'type'    => 'select',
                        'default' => 'swatch-pomegranate',
                        'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                    ),
                )
            ),
        )
    ));
    $oxy_theme->register_option_page( array(
        'page_title' => __('Post Types', 'swatch-admin-td'),
        'menu_title' => __('Post Types', 'swatch-admin-td'),
        'slug'       => THEME_SHORT . '-post-types',
        'main_menu'  => false,
        'sections'   => array(
            'permalinks-section' => array(
                'title'   => __('Configure your permalinks here', 'swatch-admin-td'),
                'header'  => __('Some of the custom single pages ( Portfolios, Services, Staff ) can be configured to use their own special url.  This helps with SEO.  Set your permalinks here, save and then navigate to one of the items and you will see the url in the format below.', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'prefix'  => '<code>' . get_site_url() . '/</code>',
                        'postfix' => '<code>/my-portfolio-item</code>',
                        'name'    => __('Portfolio URL slug', 'swatch-admin-td'),
                        'desc'    => __('Choose the url you would like your portfolios to be shown on', 'swatch-admin-td'),
                        'id'      => 'portfolio_slug',
                        'type'    => 'text',
                        'default' => 'portfolio',
                    ),
                    array(
                        'prefix'  => '<code>' . get_site_url() . '/</code>',
                        'postfix' => '<code>/my-service</code>',
                        'name'    => __('Service URL slug', 'swatch-admin-td'),
                        'desc'    => __('Choose the url you would like your services to use', 'swatch-admin-td'),
                        'id'      => 'services_slug',
                        'type'    => 'text',
                        'default' => 'our-services',
                    ),
                    array(
                        'prefix'  => '<code>' . get_site_url() . '/</code>',
                        'postfix' => '<code>/our-team</code>',
                        'name'    => __('Staff URL slug', 'swatch-admin-td'),
                        'desc'    => __('Choose the url you would like your staff pages to use', 'swatch-admin-td'),
                        'id'      => 'staff_slug',
                        'type'    => 'text',
                        'default' => 'our-team',
                    ),
                )
            ),
            'posttypes-archives-section' => array(
                'title'   => __('Post Types Archive Pages', 'swatch-admin-td'),
                'header'  => __('Set your post types archives pages here', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'      => __('Portfolio Archive Page', 'swatch-admin-td'),
                        'desc'      => __('Set the archive page for the portfolio post type', 'swatch-admin-td'),
                        'id'        => 'portfolio_archive_page',
                        'type'      => 'select',
                        'options'  => 'taxonomy',
                        'taxonomy' => 'pages',
                        'default' =>  '',
                        'blank' => __('None', 'swatch-admin-td'),
                    ),
                    array(
                        'name'      => __('Services Archive Page', 'swatch-admin-td'),
                        'desc'      => __('Set the archive page for the services post type', 'swatch-admin-td'),
                        'id'        => 'services_archive_page',
                        'type'      => 'select',
                        'options'  => 'taxonomy',
                        'taxonomy' => 'pages',
                        'default' =>  '',
                        'blank' => __('None', 'swatch-admin-td'),
                    ),
                    array(
                        'name'      => __('Staff Archive Page', 'swatch-admin-td'),
                        'desc'      => __('Set the archive page for the staff post type', 'swatch-admin-td'),
                        'id'        => 'staff_archive_page',
                        'type'      => 'select',
                        'options'  => 'taxonomy',
                        'taxonomy' => 'pages',
                        'default' =>  '',
                        'blank' => __('None', 'swatch-admin-td'),
                    ),
                )
            )
        )
    ));
    $oxy_theme->register_option_page( array(
        'page_title' => THEME_NAME . ' - ' . __('Advanced Theme Options', 'swatch-admin-td'),
        'menu_title' => __('Advanced', 'swatch-admin-td'),
        'slug'       => THEME_SHORT . '-advanced',
        'main_menu'  => false,
        'sections'   => array(
            'css-section' => array(
                'title'   => __('CSS', 'swatch-admin-td'),
                'header'  => __('Here you can save some custom CSS that will be loaded in the header.  This will allow you to override some of the default styling of the theme.</br> Please ensure that the CSS added here is valid. You can copy / paste your CSS <a href="https://jigsaw.w3.org/css-validator/#validate_by_input" target="_blank">here</a> to validate it.', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Extra CSS (loaded last in the header)', 'swatch-admin-td'),
                        'desc'    => __('Add extra CSS rules to be included in all pages', 'swatch-admin-td'),
                        'id'      => 'extra_css',
                        'type'    => 'textarea',
                        'attr'    => array( 'rows' => '10', 'style' => 'width:100%' ),
                        'default' => '',
                    ),
                )
            ),
            'assets-section' => array(
                'title'   => __('Assets', 'swatch-admin-td'),
                'header'  => __('Here you can choose the type of asset files enqueued by the theme.', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Load Minified CSS and JS Assets', 'swatch-admin-td'),
                        'desc'    => __('Choose between minified and not minified theme CSS and Javascript files. Minified files are smaller and faster to load, while non-minified are easier to edit and mofify because they are more readable. Minified assets are enqueued by default.', 'swatch-admin-td'),
                        'id'      => 'minified_assets',
                        'type'    => 'radio',
                        'options' => array(
                            'on'  => __('On', 'swatch-admin-td'),
                            'off' => __('Off', 'swatch-admin-td'),
                        ),
                        'default' => 'on',
                    ),
                )
            ),
            'favicon-section' => array(
                'title'   => __('Site Fav Icon', 'swatch-admin-td'),
                'header'  => __('The site Fav Icon is the icon that appears in the top corner of the browser tab, it is also used when saving bookmarks.  Upload your own custom Fav Icon here, recommended resolutions are 16x16 or 32x32.', 'swatch-admin-td'),
                'fields' => array(
                    array(
                      'name' => __('Fav Icon', 'swatch-admin-td'),
                      'id'   => 'favicon',
                      'type' => 'upload',
                      'store' => 'url',
                      'desc' => __('Upload a Fav Icon for your site here', 'swatch-admin-td'),
                      'default' => OXY_THEME_URI . 'favicon.ico',
                    ),
                )
            ),
            'apple-section' => array(
                'title'   => __('Apple Icons', 'swatch-admin-td'),
                'header'  => __('If someone saves a bookmark to their desktop on an Apple device this is the icon that will be used.  Here you can upload the icon you would like to be used on the various Apple devices.', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name' => __('iPhone Icon (57x57)', 'swatch-admin-td'),
                        'id'   => 'iphone_icon',
                        'type' => 'upload',
                        'store' => 'url',
                        'desc' => __('Upload an icon to be used by iPhone as a bookmark (57 x 57 pixels)', 'swatch-admin-td'),
                        'default' => OXY_THEME_URI . 'apple-touch-icon-57x57-precomposed.png',
                    ),
                    array(
                        'name'    => __('iPhone -  Apply Apple style', 'swatch-admin-td'),
                        'desc'    => __('Allow device to apply styling to the icon?', 'swatch-admin-td'),
                        'id'      => 'iphone_icon_pre',
                        'type'    => 'radio',
                        'default' => 'apple-touch-icon',
                        'options' => array(
                            'apple-touch-icon'             => __('Allow Styling', 'swatch-admin-td'),
                            'apple-touch-icon-precomposed' => __('Leave It Alone', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                      'name' => __('iPhone Retina Icon (114x114)', 'swatch-admin-td'),
                      'id'   => 'iphone_retina_icon',
                      'type' => 'upload',
                      'store' => 'url',
                      'desc' => __('Upload an icon to be used by iPhone Retina as a bookmark (114 x 114 pixels)', 'swatch-admin-td'),
                      'default' => OXY_THEME_URI . 'apple-touch-icon-114x114-precomposed.png',
                    ),
                    array(
                        'name'    => __('iPhone Retina -  Apply Apple style', 'swatch-admin-td'),
                        'desc'    => __('Allow device to apply styling to the icon?', 'swatch-admin-td'),
                        'id'      => 'iphone_retina_icon_pre',
                        'type'    => 'radio',
                        'default' => 'apple-touch-icon',
                        'options' => array(
                            'apple-touch-icon'             => __('Allow Styling', 'swatch-admin-td'),
                            'apple-touch-icon-precomposed' => __('Leave It Alone', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                      'name' => __('iPad Icon (72x72)', 'swatch-admin-td'),
                      'id'   => 'ipad_icon',
                      'type' => 'upload',
                      'store' => 'url',
                      'desc' => __('Upload an icon to be used by iPad as a bookmark (72 x 72 pixels)', 'swatch-admin-td'),
                      'default' => OXY_THEME_URI . 'apple-touch-icon-72x72-precomposed.png',
                    ),
                    array(
                        'name'    => __('iPad -  Apply Apple style', 'swatch-admin-td'),
                        'desc'    => __('Allow device to apply styling to the icon?', 'swatch-admin-td'),
                        'id'      => 'ipad_icon_pre',
                        'type'    => 'radio',
                        'default' => 'apple-touch-icon',
                        'options' => array(
                            'apple-touch-icon'             => __('Allow Styling', 'swatch-admin-td'),
                            'apple-touch-icon-precomposed' => __('Leave It Alone', 'swatch-admin-td'),
                        ),
                    ),
                    array(
                      'name' => __('iPad Retina Icon (144x144)', 'swatch-admin-td'),
                      'id'   => 'ipad_icon_retina',
                      'type' => 'upload',
                      'store' => 'url',
                      'desc' => __('Upload an icon to be used by iPad Retina as a bookmark (144 x 144 pixels)', 'swatch-admin-td'),
                      'default' => OXY_THEME_URI . 'apple-touch-icon-144x144-precomposed.png',
                    ),
                    array(
                        'name'    => __('iPad -  Apply Apple style', 'swatch-admin-td'),
                        'desc'    => __('Allow device to apply styling to the icon?', 'swatch-admin-td'),
                        'id'      => 'ipad_icon_retina_pre',
                        'type'    => 'radio',
                        'default' => 'apple-touch-icon',
                        'options' => array(
                            'apple-touch-icon'             => __('Allow Styling', 'swatch-admin-td'),
                            'apple-touch-icon-precomposed' => __('Leave It Alone', 'swatch-admin-td'),
                        ),
                    ),
                )
            ),
            'mobile-section' => array(
                'title'   => __('Mobile', 'swatch-admin-td'),
                'header'  => __('Here you can configure settings targeted at mobile devices', 'swatch-admin-td'),
                'fields' => array(
                    array(
                        'name'    => __('Background Videos', 'swatch-admin-td'),
                        'desc'    => __('Here you can enable section background videos for mobile. By default it is set to off in order to save bandwidth. Section background image will be displayed as a fallback', 'swatch-admin-td'),
                        'id'      => 'mobile_videos',
                        'type'    => 'radio',
                        'options' => array(
                            'on'  => __('On', 'swatch-admin-td'),
                            'off' => __('Off', 'swatch-admin-td'),
                        ),
                        'default' => 'off',
                    ),
                )
            ),
            'google-anal-section' => array(
                'title'   => __('Google Analytics', 'swatch-admin-td'),
                'header'  => __('Set your Google Analytics Tracker and keep track of visitors to your site.', 'swatch-admin-td'),
                'fields' => array(
                    'google_anal' => array(
                        'name' => __('Google Analytics', 'swatch-admin-td'),
                        'desc' => __('Paste your google analytics code here', 'swatch-admin-td'),
                        'id' => 'google_anal',
                        'type' => 'text',
                        'default' => 'UA-XXXXX-X',
                    )
                )
            )
        )
    ));
}
$oxy_theme->register_option_page( array(
    'page_title' => THEME_NAME . ' - ' . __('Social Options', 'swatch-admin-td'),
    'menu_title' => __('Social', 'swatch-admin-td'),
    'slug'       => THEME_SHORT . '-social',
    'main_menu'  => false,
    'icon'       => 'tools',
    'sections'   => array(
        'facebook-section' => array(
            'title'   => __('Facebook', 'swatch-admin-td'),
            'header'  => __('Show/hide the facebook button', 'swatch-admin-td'),
            'fields' => array(
                array(
                    'name'    => __('Show Facebook Button', 'swatch-admin-td'),
                    'desc'    => __('Show Facebook button on your single blog pages', 'swatch-admin-td'),
                    'id'      => 'fb_show',
                    'type'    => 'radio',
                    'options' => array(
                        'show' => __('Show', 'swatch-admin-td'),
                        'hide' => __('Hide', 'swatch-admin-td'),
                    ),
                    'default' => 'show',
                ),
            )
        ),
        'twitter-section' => array(
            'title'   => __('Twitter', 'swatch-admin-td'),
            'header'  => __('Show/hide the Twitter button', 'swatch-admin-td'),
            'fields' => array(
                array(
                    'name'    => __('Show Tweet Button', 'swatch-admin-td'),
                    'desc'    => __('Show Tweet button on your single blog pages', 'swatch-admin-td'),
                    'id'      => 'twitter_show',
                    'type'    => 'radio',
                    'options' => array(
                        'show' => __('Show', 'swatch-admin-td'),
                        'hide' => __('Hide', 'swatch-admin-td'),
                    ),
                    'default' => 'show',
                ),
            )
        ),
        'google-section' => array(
            'title'   => __('Google +', 'swatch-admin-td'),
            'header'  => __('Show/hide the Google+ button', 'swatch-admin-td'),
            'fields' => array(
                array(
                    'name'    => __('Show Google+ Button', 'swatch-admin-td'),
                    'desc'    => __('Show G+ button on your single blog pages', 'swatch-admin-td'),
                    'id'      => 'google_show',
                    'type'    => 'radio',
                    'options' => array(
                        'show' => __('Show', 'swatch-admin-td'),
                        'hide' => __('Hide', 'swatch-admin-td'),
                    ),
                    'default' => 'show',
                ),
            )
        ),
        'pinterest-section' => array(
            'title'   => __('Pinterest', 'swatch-admin-td'),
            'header'  => __('Show/hide the Pinterest button', 'swatch-admin-td'),
            'fields' => array(
                array(
                    'name'    => __('Show Pinterest Button', 'swatch-admin-td'),
                    'desc'    => __('Show Pinterest button on your single blog pages', 'swatch-admin-td'),
                    'id'      => 'pinterest_show',
                    'type'    => 'radio',
                    'options' => array(
                        'show' => __('Show', 'swatch-admin-td'),
                        'hide' => __('Hide', 'swatch-admin-td'),
                    ),
                    'default' => 'show',
                ),
            )
        ),
        'linkedin-section' => array(
            'title'   => __('LinkedIn', 'swatch-admin-td'),
            'header'  => __('Show/hide the LinkedIn button', 'swatch-admin-td'),
            'fields' => array(
                array(
                    'name'    => __('Show LinkedIn Button', 'swatch-admin-td'),
                    'desc'    => __('Show LinkedIn button on your single blog pages', 'swatch-admin-td'),
                    'id'      => 'linkedin_show',
                    'type'    => 'radio',
                    'options' => array(
                        'show' => __('Show', 'swatch-admin-td'),
                        'hide' => __('Hide', 'swatch-admin-td'),
                    ),
                    'default' => 'show',
                ),
            )
        )
    )
));

    $oxy_theme->register_option_page(array(
        'page_title' => __('Typography Settings', 'swatch-admin-td'),
        'menu_title' => __('Typography', 'swatch-admin-td'),
        'slug'       => THEME_SHORT . '-typography',
        'main_menu'  => false,
        'icon'       => 'tools',
        'stylesheets' => array(
            array(
                'handle' => 'typography-page',
                'src'    => OXY_THEME_URI . 'vendor/oxygenna/oxygenna-typography/assets/css/typography-page.css',
                'deps'   => array('oxy-typography-select2', 'thickbox'),
            ),
        ),
        'javascripts' => array(
            array(
                'handle' => 'typography-page',
                'src'    => OXY_THEME_URI . 'vendor/oxygenna/oxygenna-typography/assets/javascripts/typography-page.js',
                'deps'   => array('jquery', 'underscore', 'thickbox', 'oxy-typography-select2', 'jquery-ui-dialog'),
                'localize' => array(
                    'object_handle' => 'typographyPage',
                    'data' => array(
                        'ajaxurl' => admin_url('admin-ajax.php'),
                        'listNonce'  => wp_create_nonce('list-fontstack'),
                        'fontModal'  => wp_create_nonce('font-modal'),
                        'updateNonce'  => wp_create_nonce('update-fontstack'),
                        'defaultFontsNonce' => wp_create_nonce('default-fonts'),
                    )
                )
            ),
        ),
        // include a font stack option to enqueue select 2 ok
        'sections'   => array(
            'font-section' => array(
                'title'   => __('Fonts settings section', 'swatch-admin-td'),
                'header'  => __('Setup Fonts settings here.', 'swatch-admin-td'),
                'fields' => array()
            )
        )
    ));

$oxy_theme->register_option_page(array(
    'page_title' => __('Fonts', 'swatch-admin-td'),
    'menu_title' => __('Fonts', 'swatch-admin-td'),
    'slug'       => THEME_SHORT . '-fonts',
    'main_menu'  => false,
    'icon'       => 'tools',
    'sections'   => array(
        'google-fonts-section' => array(
            'title'   => __('Google Fonts', 'swatch-admin-td'),
            // 'header'  => __('Setup Your Google Fonts Here.', 'swatch-admin-td'),
            'fields' => array(
                array(
                    'name'        => __('Fetch Google Fonts', 'swatch-admin-td'),
                    'button-text' => __('Update Fonts', 'swatch-admin-td'),
                    'id'          => 'google_update_fonts_button',
                    'type'        => 'button',
                    'desc'        => __('Click this button to fetch the latest fonts from Google and update your Google Fonts list.', 'swatch-admin-td'),
                    'attr'        => array(
                        'id'    => 'google-update-fonts-button',
                        'class' => 'button button-primary'
                    ),
                    'javascripts' => array(
                        array(
                            'handle' => 'google-font-updater',
                            'src'    => OXY_THEME_URI . 'vendor/oxygenna/oxygenna-typography/assets/javascripts/options/google-font-updater.js',
                            'deps'   => array('jquery'),
                            'localize' => array(
                                'object_handle' => 'googleUpdate',
                                'data' => array(
                                    'ajaxurl'   => admin_url('admin-ajax.php'),
                                    // generate a nonce with a unique ID "myajax-post-comment-nonce"
                                    // so that you can check it later when an AJAX request is sent
                                    'nonce'     => wp_create_nonce('google-fetch-fonts-nonce'),
                                )
                            )
                        ),
                    ),
                )
            )
        ),
        'typekit-provider-options' => array(
            'title'   => __('TypeKit Fonts', 'swatch-admin-td'),
            'header'  => __('If you have a TypeKit account and would like to use it in your site.  Enter your TypeKit API key below and then click the Update your kits button.', 'swatch-admin-td'),
            'fields' => array(
                array(
                    'name' => __('Typekit API Token', 'swatch-admin-td'),
                    'desc' => __('Add your typekit api token here', 'swatch-admin-td'),
                    'id'   => 'typekit_api_token',
                    'type' => 'text',
                    'attr'        => array(
                        'id'    => 'typekit-api-key',
                    )
                ),
                array(
                    'name'        => __('TypeKit Kits', 'swatch-admin-td'),
                    'button-text' => __('Update your kits', 'swatch-admin-td'),
                    'desc' => __('Click this button to update your typography list with the kits available from your TypeKit account.', 'swatch-admin-td'),
                    'id'          => 'typekit_kits_button',
                    'type'        => 'button',
                    'attr'        => array(
                        'id'    => 'typekit-kits-button',
                        'class' => 'button button-primary'
                    ),
                    'javascripts' => array(
                        array(
                            'handle' => 'typekit-kit-updater',
                            'src'    => OXY_THEME_URI . 'vendor/oxygenna/oxygenna-typography/assets/javascripts/options/typekit-updater.js',
                            'deps'   => array('jquery' ),
                            'localize' => array(
                                'object_handle' => 'typekitUpdate',
                                'data' => array(
                                    'ajaxurl'   => admin_url('admin-ajax.php'),
                                    'nonce'     => wp_create_nonce('typekit-kits-nonce'),
                                )
                            )
                        ),
                    ),
                )
            )
        )
    )
));

$oxy_theme->register_option_page( array(
    'page_title' => THEME_NAME . ' - ' . __('WooCommerce', 'swatch-admin-td'),
    'menu_title' => __('WooCommerce', 'swatch-admin-td'),
    'slug'       => THEME_SHORT . '-woocommerce',
    'main_menu'  => false,
    'icon'       => 'tools',
    'sections'   => array(
        'woo-shop-section' => array(
            'title'   => __('Shop Options', 'swatch-admin-td'),
            'header'  => __('Change the way your shop page looks with these options.', 'swatch-admin-td'),
            'fields' => array(
                array(
                    'name'    => __('General Shop Swatch', 'swatch-admin-td'),
                    'desc'    => __('Choose a general colour scheme to use for your WooCommerce site.', 'swatch-admin-td'),
                    'id'      => 'woocom_general_swatch',
                    'type'    => 'select',
                    'default' => 'swatch-white',
                    'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                ),
                array(
                    'name'    => __('Category Header Swatch', 'swatch-admin-td'),
                    'desc'    => __('Choose a swatch to use for your WooCommerce category headers.', 'swatch-admin-td'),
                    'id'      => 'woocom_header_swatch',
                    'type'    => 'select',
                    'default' => 'swatch-coral',
                    'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                ),
                array(
                    'name'    => __('Pagination Swatch', 'swatch-admin-td'),
                    'desc'    => __('Choose a color swatch pagination', 'swatch-admin-td'),
                    'id'      => 'pagination_woo_swatch',
                    'type'    => 'select',
                    'default' => 'swatch-coral',
                    'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                ),
                array(
                    'name'    => __('Checkout Slide Sidebar Swatch', 'swatch-admin-td'),
                    'desc'    => __('Choose a color swatch the cart that slides in from the side.', 'swatch-admin-td'),
                    'id'      => 'pageslide_cart_swatch',
                    'type'    => 'select',
                    'default' => 'swatch-coral',
                    'options' => include OXY_THEME_DIR . 'inc/options/shortcodes/shortcode-swatches-options.php'
                ),
                array(
                    'name'    => __('Shop Layout', 'swatch-admin-td'),
                    'desc'    => __('Layout of your shop page. Choose among right sidebar, left sidebar, fullwidth layout', 'swatch-admin-td'),
                    'id'      => 'shop_layout',
                    'type'    => 'radio',
                    'options' => array(
                        'sidebar-right' => __('Right Sidebar', 'swatch-admin-td'),
                        'full-width'    => __('Full Width', 'swatch-admin-td'),
                        'sidebar-left'  => __('Left Sidebar', 'swatch-admin-td'),
                    ),
                    'default' => 'full-width',
                ),
                array(
                    'name'    => __('Social Icons In Product Details', 'swatch-admin-td'),
                    'desc'    => __('Display social icons in product details page', 'swatch-admin-td'),
                    'id'      => 'product_social_icons',
                    'type'    => 'radio',
                    'options' => array(
                        'on'  => __('On', 'swatch-admin-td'),
                        'off' => __('Off', 'swatch-admin-td'),
                    ),
                    'default' => 'on',
                ),
            )
        ),
    )
));
