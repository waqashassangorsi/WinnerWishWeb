<?php
/**
 * Template Name: Woocommerce account template
 *
 * @package Swatch
 * @subpackage Frontend
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */

get_header();
oxy_page_header();
while( have_posts() ) {
    the_post();
    get_template_part('partials/content', 'account');
}

get_footer();