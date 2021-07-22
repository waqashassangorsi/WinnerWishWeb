<?php
/**
 * Test Options Page
 *
 * @package Swatch
 * @subpackage options-pages
 * @since 1.0
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */

return array(
    'sections'   => array(
        'twitter-section' => array(
            'title'   => __('Twitter', 'swatch-admin-td'),
            'header'  => __('Twitter feed options','swatch-admin-td'),
            'fields' => array(
                'account' => array(
                    'name' => __('Twitter username', 'swatch-admin-td'),
                    'id' => 'account',
                    'type' => 'text',
                    'default' => "envato",
                    'attr'      =>  array(
                        'class'    => 'widefat',
                    ),
                ),
                'consumer_key' => array(
                    'name' => __('Consumer Key', 'swatch-admin-td'),
                    'id' => 'consumer_key',
                    'type' => 'text',
                    'default' => "",
                    'attr'      =>  array(
                        'class'    => 'widefat',
                    ),
                ),
                'consumer_secret' => array(
                    'name' => __('Consumer Secret', 'swatch-admin-td'),
                    'id' => 'consumer_secret',
                    'type' => 'text',
                    'default' => "",
                    'attr'      =>  array(
                        'class'    => 'widefat',
                    ),
                ),
                'access_token' => array(
                    'name' => __('Access Token', 'swatch-admin-td'),
                    'id' => 'access_token',
                    'type' => 'text',
                    'default' => "",
                    'attr'      =>  array(
                        'class'    => 'widefat',
                    ),
                ),
                'access_token_secret' => array(
                    'name' => __('Access Token Secret', 'swatch-admin-td'),
                    'id' => 'access_token_secret',
                    'type' => 'text',
                    'default' => "",
                    'attr'      =>  array(
                        'class'    => 'widefat',
                    ),
                ),

                'show'   => array(
                    'name'       =>  __('Maximum number of tweets to show', 'swatch-admin-td'),
                    'id'         => 'show',
                    'type'       => 'select',
                    'options'    =>  array(
                              1  => 1,
                              2  => 2,
                              3  => 3,
                              4  => 4,
                              5  => 5,
                              6  => 6,
                              7  => 7,
                              8  => 8,
                              9  => 9,
                              10 => 10
                    ),
                    'attr'      =>  array(
                        'class'    => 'widefat',
                    ),
                    'default'   => 5,
                ),


                'hidereplies' => array(
                    'name'      => __('Hide replies', 'swatch-admin-td'),
                    'id'        => 'hidereplies',
                    'type'      => 'radio',
                    'default'   =>  'on',
                    'options' => array(
                        'on'   => __('Hide', 'swatch-admin-td'),
                        'off'  => __('Show', 'swatch-admin-td'),
                    ),
                ),

                'hidepublicized' => array(
                    'name'      => __('Hide Tweets pushed by Publicize', 'swatch-admin-td'),
                    'id'        => 'hidepublicized',
                    'type'      => 'radio',
                    'default'   =>  'on',
                    'options' => array(
                        'on'   => __('Hide', 'swatch-admin-td'),
                        'off'  => __('Show', 'swatch-admin-td'),
                    ),
                ),

                'includeretweets' => array(
                    'name'      => __('Include retweets', 'swatch-admin-td'),
                    'id'        => 'include_retweets',
                    'type'      => 'radio',
                    'default'   =>  'on',
                    'options' => array(
                        'off' => __('No', 'swatch-admin-td'),
                        'on'  => __('Yes', 'swatch-admin-td'),
                    ),
                ),

                'followbutton' => array(
                    'name'      => __('Display Follow Button', 'swatch-admin-td'),
                    'id'        => 'follow_button',
                    'type'      => 'radio',
                    'default'   =>  'on',
                    'options' => array(
                        'off' => __('Hide', 'swatch-admin-td'),
                        'on'  => __('Show', 'swatch-admin-td'),
                    ),
                ),

                'beforetimesince' => array(
                    'name' => __('Text to display between Tweet and timestamp:', 'swatch-admin-td'),
                    'id' => 'beforetimesince',
                    'type' => 'text',
                    'default' => "",
                    'attr'      =>  array(
                        'class'    => 'widefat',
                    ),
                ),

            )//fields
        )//section
    )//sections
);//array
