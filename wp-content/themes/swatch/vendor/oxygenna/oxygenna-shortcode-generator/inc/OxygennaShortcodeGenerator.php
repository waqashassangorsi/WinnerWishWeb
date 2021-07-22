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

class OxygennaShortcodeGenerator
{
    private static $instance;

    public $shortcode_options = array();
    public $menu_options = array();

    public static function instance()
    {
        if (! self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Constructor, this should be called first
     */
    public function __construct()
    {
        if (is_admin()) {
            add_action('admin_init', array(&$this, 'admin_init'));
        }
    }

    /**
     * called on admin_init
     *
     * @since 1.0
     */
    public function admin_init()
    {
        require_once OXY_SHORTCODE_GENERATOR_DIR . 'inc/shortcodes/shortcode-admin.php';
        $shortcode_admin = new ShortcodeAdmin($this);
    }

    public function register_shortcode_options($shortcode_options)
    {
        foreach ($shortcode_options as $shortcode => $options) {
            $this->shortcode_options[$shortcode] = $options;
        }
    }

    public function set_menu_options($options)
    {
        $this->menu_options = $options;
    }
}
