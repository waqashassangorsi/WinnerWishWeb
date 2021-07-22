<?php
/**
 * Removes all html tags
 *
 * @package Swatch
 * @subpackage Core
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */

/**
 * Removes all HTML
 *
 * @package Swatch
 * @since 1.0
 **/
class OxygennaStripHTML
{
    /**
     * Validates the option data
     *
     * @return validated options array
     *                   @since 1.0
     **/
    public function validate($field, $options, $new_options)
    {
        $options[$field['id']] = strip_tags($new_options[$field['id']]);

        return $options;
    }
}
