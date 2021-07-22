<?php
/**
 * Sets up the shortcode editor actions
 *
 * @package Swatch
 * @subpackage Core
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */

class ShortcodeAdmin
{
    private $generator;

    public function __construct($generator)
    {
        $this->generator = $generator;

        // turn off shortcode editor if shortcodes is false
        if ($this->generator->shortcode_options !== false) {
            // Don't bother doing this stuff if the current user lacks permissions
            if (!current_user_can('edit_posts') && ! current_user_can('edit_pages')) {
                return;
            }

            // Add only in Rich Editor mode
            if (get_user_option('rich_editing') == 'true') {
                add_filter('mce_external_plugins', array($this, 'oxy_add_mce_shortcode_plugin'));
                add_filter('mce_buttons', array(&$this, 'oxy_add_mce_shortcode_button'));
            }

            // enqueue scripts & styles
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
            // add tinyMCE shortcode plugin
            add_action('admin_init', array(&$this, 'oxy_add_mce_shortcode'));
            // add action for loading shortcode page
            add_action('wp_ajax_oxy_shortcodes', array(&$this, 'oxy_load_mce_shortcode_page'));
            // add action for loading shortcode page
            add_action('wp_ajax_oxy_shortcode_preview', array(&$this, 'oxy_load_mce_shortcode_preview'));
            // add action for loading menu data
            add_action('wp_ajax_oxy_shortcodes_menu', array(&$this, 'oxy_load_mce_shortcode_menu'));

            // remove wordpress 3.6 action that is undocumented and throws notices.
            if (has_action('admin_enqueue_scripts', 'wp_auth_check_load')) {
                remove_action('admin_enqueue_scripts', 'wp_auth_check_load');
            }
        }
    }

    public function admin_enqueue_scripts()
    {
        global $pagenow;
        if ('post-new.php' == $pagenow || 'post.php' == $pagenow) {
            wp_enqueue_style('oxy-shortcodes-html-menu', OXY_SHORTCODE_GENERATOR_URI . 'inc/css/shortcodes/shortcode-html-menu.css');
            wp_enqueue_script('oxy-shortcodes-html-menu', OXY_SHORTCODE_GENERATOR_URI . 'inc/javascripts/shortcodes/html-menu.js', array('jquery'));
        }
    }

    public function oxy_load_mce_shortcode_page()
    {
        // check for rights
        if (!current_user_can('edit_pages') && !current_user_can('edit_posts')) {
            die(__('You are not allowed to be here', 'PLUGIN_TD'));
        }

        // load shortcodes js
        wp_enqueue_script('oxy-shortcodes', OXY_SHORTCODE_GENERATOR_URI . 'inc/javascripts/shortcodes/shortcodes.js', array('jquery'));
        wp_enqueue_script('oxy-shortcode-options', OXY_SHORTCODE_GENERATOR_URI . 'inc/javascripts/shortcodes/shortcode-options.js', array('jquery', 'jquery-ui-accordion'));
        wp_enqueue_style('oxy-shortcodes', OXY_SHORTCODE_GENERATOR_URI . 'inc/css/shortcodes/shortcode-popup.css', array('jquery-oxygenna-ui-theme'));

        // remove supported plugin hooks from tinymce
        global $woosidebars;
        remove_action('admin_enqueue_scripts', 'woocommerce_admin_scripts');
        remove_action('admin_head', array( $woosidebars, 'add_contextual_help'));

        include_once OXY_SHORTCODE_GENERATOR_DIR . 'inc/shortcodes/shortcode-editor.php';

        die();
    }

    public function oxy_load_mce_shortcode_preview()
    {
        // check for rights
        if (!current_user_can('edit_pages') && !current_user_can('edit_posts')) {
            die(__('You are not allowed to be here', 'PLUGIN_TD'));
        }

        check_ajax_referer('oxy-preview-nonce');

        // load an extra css for for the preview view only
        wp_enqueue_style('shortcode-preview', OXY_SHORTCODE_GENERATOR_URI . 'inc/css/shortcodes/shortcode-preview.css', array('style', 'responsive'));

        include_once OXY_SHORTCODE_GENERATOR_DIR . 'inc/shortcodes/preview.php';

        die();
    }

    public function oxy_load_mce_shortcode_menu()
    {
        // check for rights
        if (!current_user_can('edit_pages') && !current_user_can('edit_posts')) {
            die(__('You are not allowed to be here', 'PLUGIN_TD'));
        }

        $menu = $this->add_shortcode_options($this->generator->menu_options);

        echo json_encode($menu);

        die();
    }

    public function add_shortcode_options($options)
    {
        if (is_array($options)) {
            if (isset($options['members'])) {
                $members = array();
                foreach ($options['members'] as $member) {
                    $members[] = $this->add_shortcode_options($member);
                }
                $new_tree = array(
                    'title' => $options['title'],
                    'members' => $members
                );
            } else {
                // modified in order to parse all the shortcode options arrays
                foreach ($options as $option) {
                    $new_tree[] =  $this->add_shortcode_options($option);
                }
            }
        } else {
            if (isset( $this->generator->shortcode_options[$options])) {
                $new_tree = $this->generator->shortcode_options[$options];
            } else {
                $new_tree = 'No options for ' . $options;
            }
        }
        return $new_tree;
    }

    public function oxy_add_mce_shortcode_button($buttons)
    {
        array_push($buttons, 'shortcodes');
        return $buttons;
    }

    public function oxy_add_mce_shortcode_plugin($plugin_array)
    {
        if (version_compare(get_bloginfo('version'), '3.9', '<')) {
            $plugin_array['shortcodes'] = OXY_SHORTCODE_GENERATOR_URI . 'inc/javascripts/shortcodes/editor_plugin.js';
        } else {
            $plugin_array['shortcodes'] = OXY_SHORTCODE_GENERATOR_URI . 'inc/javascripts/shortcodes/plugin.js';
        }
        
        return $plugin_array;
    }
}
