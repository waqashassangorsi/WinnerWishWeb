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


// get all swatches
$swatches = get_posts( array(
    'post_type' => 'oxy_swatch',
    'order_by' => 'title',
    'posts_per_page' => '-1'
));

$swatch_options = array();
foreach( $swatches as $swatch ) {
    $swatch_options['swatch-' . $swatch->post_name] = $swatch->post_title;
}
$default_swatches = array(
    'swatch-amethyst' => __('Amethyst', 'swatch-admin-td'),
    'swatch-asphalt' => __('Asphalt', 'swatch-admin-td'),
    'swatch-clouds' => __('Clouds', 'swatch-admin-td'),
    'swatch-coral' => __('Coral', 'swatch-admin-td'),
    'swatch-emerald' => __('Emerald', 'swatch-admin-td'),
    'swatch-greensea' => __('Greensea', 'swatch-admin-td'),
    'swatch-midnightblue' => __('Midnightblue', 'swatch-admin-td'),
    'swatch-nephritis' => __('Nephritis', 'swatch-admin-td'),
    'swatch-orange' => __('Orange', 'swatch-admin-td'),
    'swatch-pomegranate' => __('Pomegranate', 'swatch-admin-td'),
    'swatch-river' => __('River', 'swatch-admin-td'),
    'swatch-sunflower' => __('Sunflower', 'swatch-admin-td'),
    'swatch-white' => __('White', 'swatch-admin-td'),
);

return array_merge( $default_swatches, $swatch_options );