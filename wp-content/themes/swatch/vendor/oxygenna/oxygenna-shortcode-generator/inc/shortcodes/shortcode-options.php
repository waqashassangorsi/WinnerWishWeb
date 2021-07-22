<?php
/**
 * Builds the shortcode option accordion
 *
 * @package Swatch
 * @subpackage Core
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */


class OxyShortcodeOptions
{
    private $shortcode;
    private $options;
    private $show_preview;

    public function __construct()
    {
        $this->shortcode = $_GET['shortcode'];
        $this->options = apply_filters('oxy-shortcode-options-' . $this->shortcode, OxygennaShortcodeGenerator::instance()->shortcode_options[$this->shortcode]);

        // add action to enqueue scripts for each option
        add_action('admin_enqueue_scripts', array(&$this, 'enqueue_scripts'));
    }

    public function enqueue_scripts($hook)
    {
        if ($this->options !== null) {
            foreach ($this->options['sections'] as $section) {
                // each section can now have it's own js
                if (isset($section['javascripts'])) {
                    foreach ($section['javascripts'] as $js) {
                        wp_enqueue_script($js['handle'], $js['src'], $js['deps']);
                        if (isset( $js['localize'])) {
                            wp_localize_script($js['handle'], $js['localize']['object_handle'], $js['localize']['data']);
                        }
                    }
                }
                foreach ($section['fields'] as $field) {
                    $option = OxygennaOptions::create_option($field);
                    if ($option != false) {
                        $option->enqueue();
                    }
                }
            }
        }
    }

    private function render_options()
    {
        if ($this->options !== null) {
            echo '<div id="accordion" class="accordion">';
            foreach ($this->options['sections'] as $section) {
                echo '<h3 name="accordion-header-'.$section['title'].'"><a href="#">'. $section['title'] .'</a></h3>';
                echo '<div name="accordion-content-'.$section['title'].'">';
                foreach ($section['fields'] as $field) {
                    $attr = array();
                    $attr = isset($field['attr'])? $field['attr'] : null;
                    // prefix name with shortcode so shortcode generator can work
                    $attr['name'] = $this->shortcode . '_' . $field['id'];
                    if (isset($field['desc'])) {
                        $attr['desc'] = $field['desc'];
                    }
                    if (isset( $field['id'])) {
                        $attr['id'] = $field['id'];
                    }
                    $value = '';
                    if (isset( $field['default'])) {
                        // set value to default
                        $value =  $field['default'];
                        // also set data-default for shortcode generator ;)
                        $attr['data-default'] = $field['default'];
                    }
                    $option = OxygennaOptions::create_option($field, $value, $attr);
                    if ($option !== false) {
                        echo '<div class="option">';
                        echo '<label for="' . $field['id'] . '">'. $field['name'] . '</label>';
                        $option->render();
                        echo '</div>';
                    }
                }
                echo '</div>';
            }
            echo '</div>';
        }
    }

    public function display()
    { ?>
        <form id="shortcode_form" action="#">
            <input type="hidden" id="shortcode" value="<?php echo $this->shortcode; ?>" />

            <div id="preview_panel">
                <iframe id="preview">
                </iframe>
            </div>
            <div id="options_panel">
                <?php $this->render_options(); ?>
                <div id="buttons_panel">
                    <input  class="button button-primary" type="submit" id="insert" name="insert" value="<?php _e('Insert', 'PLUGIN_TD'); ?>" />
                    <input  class="button button-right" type="button" id="cancel" name="cancel" value="<?php _e('Close', 'PLUGIN_TD'); ?>" />
                </div>
            </div>
        </form>
    <?php
    }
}
return new OxyShortcodeOptions();