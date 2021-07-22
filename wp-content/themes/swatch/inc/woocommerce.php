<?php
/**
 * All Woocommerce stuff
 *
 * @package Swatch
 * @subpackage Admin
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.9.2
 */

add_theme_support( 'woocommerce' );

if( oxy_is_woocommerce_active() ) {
     // Dequeue WooCommerce stylesheet(s)
    if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
        // WooCommerce 2.1 or above is active
        add_filter( 'woocommerce_enqueue_styles', '__return_false' );
    } else {
        // WooCommerce is less than 2.1
        define( 'WOOCOMMERCE_USE_CSS', false );
    }

    // Adds support for new gallery since WC 3.0
    function oxy_woo_product_gallery()
    {
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
    }
    add_action('after_setup_theme', 'oxy_woo_product_gallery');

    /**
     * All hooks for the shop page and category list page go here
     *
     * @return void
     **/
    function oxy_shop_and_category_hooks() {
        if( is_shop() || is_product_category() ) {
            function oxy_remove_title() {
                return false;
            }
            add_filter( 'woocommerce_show_page_title', 'oxy_remove_title');

            function oxy_shop_layout_start() {
                switch (oxy_get_option('shop_layout')) {
                    case 'sidebar-left':?>
                        <div class="row-fluid"><div class="span3"> <?php get_sidebar(); ?></div><div class="span9"><?php
                        break;
                    case 'sidebar-right': ?>
                        <div class="row-fluid"><div class="span9"><?php
                        break;
                }
            }
            // remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
            add_action('woocommerce_before_main_content', 'oxy_shop_layout_start', 18);

            function oxy_shop_layout_end(){
                switch (oxy_get_option('shop_layout')) {
                    case 'sidebar-left': ?>
                        </div></div><?php
                        break;
                    case 'sidebar-right': ?>
                        </div><div class="span3"><?php get_sidebar(); ?></div></div><?php
                        break;
                }
            }
            add_action('woocommerce_after_main_content', 'oxy_shop_layout_end', 9);

            function oxy_before_breadcrumbs() {
                echo '<div class="row-fluid"><div class="span6 small-screen-center">';
            }
            // remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
            add_action('woocommerce_before_main_content', 'oxy_before_breadcrumbs', 19);

            function oxy_after_breadcrumbs() {
                echo '</div><div class="span6 text-right">';
            }
            add_action('woocommerce_before_main_content', 'oxy_after_breadcrumbs', 20);

            function oxy_after_orderby() {
              echo '</div></div>';
            }
            add_action('woocommerce_before_shop_loop', 'oxy_after_orderby', 30);

        }

    }

    function oxy_single_product_hooks() {
        if( is_product() ) {
            // we need to reposition the messages before the breadcrumbs
            remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);
            add_action( 'woocommerce_before_main_content', 'woocommerce_output_all_notices', 15 );
        }
    }

    add_action( 'wp', 'oxy_shop_and_category_hooks' );
    add_action( 'wp', 'oxy_single_product_hooks');

    // GLOBAL HOOKS - EFFECT ALL PAGES
    // Removing action that shows in the footer a site-wide note
    remove_action( 'wp_footer', 'woocommerce_demo_store', 10);

    // first unhook the global WooCommerce wrappers. They were adding another <div id=content> around.
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

    function oxy_before_main_content_10() {
        echo '<section class="section section-commerce ' . oxy_get_option( 'woocom_general_swatch' ) . '"><div class="container">';
    }
    add_action('woocommerce_before_main_content', 'oxy_before_main_content_10', 10);

    function oxy_after_main_content_10() {
      echo '</div></section>';
    }
    add_action('woocommerce_after_main_content', 'woocommerce_site_note', 10);
    add_action('woocommerce_after_main_content', 'oxy_after_main_content_10', 11);

    function custom_override_breadcrumb_fields($fields) {
        $fields['wrap_before']='<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">';
        $fields['wrap_after']='</nav>';
        $fields['before']='<span>';
        $fields['after']='</span>';
        $fields['delimiter']=' ';
        return $fields;
    }
    add_filter('woocommerce_breadcrumb_defaults','custom_override_breadcrumb_fields');

    // removing default woocommerce image display. Also affects shortcodes.
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

    function oxy_woocommerce_template_loop_product_thumbnail(){
        global $product;
        $image_ids = $product->get_gallery_image_ids();
        $back_image = array_shift( $image_ids );
        echo '<div class="product-image">';
        echo '<div class="product-image-front">' .woocommerce_get_product_thumbnail() . '</div>';
        if( null != $back_image ){
            $back_image = wp_get_attachment_image_src( $back_image, 'shop_catalog' );
            echo '<div class="product-image-back"><img src="' . $back_image[0] . '"/></div>';
        }
            echo '</div>';
        }
    add_action( 'woocommerce_before_shop_loop_item_title', 'oxy_woocommerce_template_loop_product_thumbnail', 10 );

     // Change number or products per row to based on options
    add_filter( 'oxy_woocommerce_shop_classes', 'oxy_woocommerce_shop_classes' );
    if( !function_exists( 'oxy_woocommerce_shop_classes' ) ) {
        function oxy_woocommerce_shop_classes() {
           return oxy_get_option( 'woocom_general_swatch' );
        }
    }

}

/*
 *
 * Set default image sizes on activation hook
 *
 */
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) add_action( 'init', 'woocommerce_default_image_dimensions', 1 );
/**
 * Define image sizes
 */
function woocommerce_default_image_dimensions() {
    $catalog = array(
        'width'     => '500',
        'height'    => '500',
        'crop'      => 1
    );

    $single = array(
        'width'     => '700',
        'height'    => '700',
        'crop'      => 1
    );

    $thumbnail = array(
        'width'     => '90',
        'height'    => '90',
        'crop'      => 1
    );

    // Image sizes
    update_option( 'shop_catalog_image_size', $catalog );       // Product category thumbs
    update_option( 'shop_single_image_size', $single );         // Single product image
    update_option( 'shop_thumbnail_image_size', $thumbnail );   // Image gallery thumbs
}

remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description' );
add_action( 'woocommerce_before_main_content', 'woocommerce_taxonomy_archive_description', 11 );

function woocommerce_taxonomy_archive_description() {
    if ( is_tax( array( 'product_cat', 'product_tag' ) ) && get_query_var( 'paged' ) == 0 ) {
        $description = apply_filters( 'the_content', term_description() );
        if ( $description ) {
            echo '<div class="term-description lead">' . $description . '</div>';
        }
    }
}

// Remove redundant Procceed to checkout button in cart page
remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 10 );

// Deregistering styles that override the + and - buttons of cart quantity products
add_action('wp_enqueue_scripts', 'oxy_load_woo_scripts');

function oxy_load_woo_scripts() {
    if (wp_style_is('wcqi-css', 'registered')) {
        wp_deregister_style('wcqi-css');
    }
}

if ( ! function_exists( 'woocommerce_site_note' ) ) {

    /**
     * Adds a demo store banner to the site if enabled
     *
     */
    function woocommerce_site_note() {

        if ( ! is_store_notice_showing() ) {
            return;
        }

        $notice = get_option( 'woocommerce_demo_store_notice' );

        if ( empty( $notice ) ) {
            $notice = __( 'This is a demo store for testing purposes &mdash; no orders shall be fulfilled.', 'woocommerce' );
        }
        echo '<div class="alert alert-info">' . wp_kses_post( $notice ) . '</div>';

    }
}

if ( ! function_exists( 'oxy_woocommerce_review_display_gravatar' ) ) {
    // Avatar on review tab of single product gets called by a hook since v4.6
    function oxy_woocommerce_review_display_gravatar($comment)
    {
        echo get_avatar($comment, apply_filters('woocommerce_review_gravatar_size', '48'), '', get_comment_author());
    }

    // Removing action that shows the review avatar on single product page(as of v4.6)
    remove_action( 'woocommerce_review_before', 'woocommerce_review_display_gravatar', 10);
    add_action('woocommerce_review_before', 'oxy_woocommerce_review_display_gravatar', 10);
}

// Places the cross-sells section below the cart details on the cart page.
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' );

// Change number or products shown in cross sells
add_filter('woocommerce_cross_sells_columns', 'oxy_woocommerce_cross_sells_columns');
if (!function_exists('oxy_woocommerce_cross_sells_columns')) {
    function oxy_woocommerce_cross_sells_columns($columns)
    {
        return 4;
    }
}

// Removing action that shows the woocommerce navigation on top of account page(as of v4.6)
remove_action( 'woocommerce_account_navigation', 'woocommerce_account_navigation');
