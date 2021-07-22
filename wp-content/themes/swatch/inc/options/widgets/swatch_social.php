<?php
/**
 * Oxygenna.com
 *
 * $Template:: *(TEMPLATE_NAME)*
 * $Copyright:: *(COPYRIGHT)*
 * $Licence:: *(LICENCE)*
 */
require_once OXY_TF_DIR . 'inc/OxygennaWidget.php';

/**
 * Adds Caelus_title widget.
 */
class Swatch_social extends OxygennaWidget {


    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_options = array( 'description' => __( 'Social Icons Widget', 'swatch-admin-td') );
        parent::__construct( 'swatch_social-options.php', false, $name = THEME_NAME . ' - ' . __('Social Icons Widget', 'swatch-admin-td'), $widget_options );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );

        $new_window = $this->get_option( 'social_window', $instance, 'on');
        $target = $new_window == 'on' ? 'target="_blank"' : '';
        $extra_class = $this->get_option( 'social_style', $instance, '') == 2 ? ' social-simple ' : '';
        $extra_class .= $this->get_option( 'social_size', $instance, '') == 2 ? ' social-mini ' : '';

        $output = $before_widget;
        $output.= '<ul class="unstyled inline small-screen-center social-icons '.$extra_class.'">';
        for( $i = 0 ; $i < 10 ; $i++ ) {
            $social_url = $this->get_option( 'social' . $i . '_url', $instance, '');
            $social_icon = $this->get_option( 'social' . $i . '_icon', $instance, '');
            if (!empty( $social_icon )) {
                $output .= '<li><a ' . $target . ' data-iconcolor="' . oxy_get_icon_color( $social_icon ) . '" href="' . $social_url . '">';
                $output .= oxy_font_awesome_icon($social_icon);
                $output .= '</a></li>';
            }
            //$output .= empty( $social_icon ) ? '' : '<li><a href="' . $social_url . '"><i class="' . $social_icon . '"></i></a></li>';
        }

        $output.= '</ul>';
        $output.= $after_widget;

        echo $output;
    }

}