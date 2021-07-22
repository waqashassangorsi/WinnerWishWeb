<?php
/**
 * Displays the head section of the theme
 *
 * @package Swatch
 * @subpackage Frontend
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */
?><!DOCTYPE html>
<!--[if IE 8 ]> <html <?php language_attributes(); ?> class="ie8"> <![endif]-->
<!--[if IE 9 ]> <html <?php language_attributes(); ?> class="ie9"> <![endif]-->
<!--[if gt IE 9]> <html <?php language_attributes(); ?>> <![endif]-->
<!--[if !IE]> <!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <title><?php wp_title( '|', true, 'right' ); ?></title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <link href="<?php echo oxy_get_option( 'favicon' ); ?>" rel="shortcut icon" />
        <meta name="google-site-verification" content="<?php echo oxy_get_option('google_webmaster'); ?>" />

        <?php oxy_add_apple_icons( 'iphone_icon' ); ?>
        <?php oxy_add_apple_icons( 'iphone_retina_icon', 'sizes="114x114"' ); ?>
        <?php oxy_add_apple_icons( 'ipad_icon', 'sizes="72x72"' ); ?>
        <?php oxy_add_apple_icons( 'ipad_retina_icon', 'sizes="144x144"' ); ?>

        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <script src="<?php echo OXY_THEME_URI .'javascripts/excanvas.min.js'; ?>"></script>
        <script src="<?php echo OXY_THEME_URI .'javascripts/PIE.js'; ?>"></script>
        <![endif]-->
         <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <?php if (  ( is_active_sidebar( 'above-nav-right' ) || is_active_sidebar( 'above-nav-left' ) ) && (oxy_get_option('header_type') == 'top_bar' || oxy_get_option('header_type') == 'combo') ) : ?>
        <?php oxy_top_bar_nav(); ?>
        <?php endif; ?>
        <!-- Page Header -->
        <header id="masthead" class="<?php echo oxy_get_option('header_type')!='combo'? oxy_get_option('header_swatch'): ""; ?>">
            <?php if( oxy_get_option('header_type')!='combo' ): ?>
            <?php oxy_standard_nav(); ?>
            <?php else: ?>
            <?php oxy_combo_nav() ?>
            <?php endif; ?>
        </header>
        <div id="content" role="main">