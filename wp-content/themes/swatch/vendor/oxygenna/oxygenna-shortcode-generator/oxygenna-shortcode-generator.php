<?php
/**
 * Main mega menu class
 *
 * @package Swatch
 * @subpackage Admin
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.9.2
 * @author Oxygenna.com
 */

define('OXY_SHORTCODE_GENERATOR_DIR', OXY_THEME_DIR . 'vendor/oxygenna/oxygenna-shortcode-generator/');
define('OXY_SHORTCODE_GENERATOR_URI', OXY_THEME_URI . 'vendor/oxygenna/oxygenna-shortcode-generator/');

if (!class_exists('OxygennaShortcodeGenerator')) {

    require_once(OXY_SHORTCODE_GENERATOR_DIR . 'inc/OxygennaShortcodeGenerator.php');
    OxygennaShortcodeGenerator::instance();
}
