<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'ewduwpmSettings' ) ) {
/**
 * Class to handle configurable settings for Ultimate WP Mail
 * @since 1.0.0
 */
class ewduwpmSettings {

	public $action_type_options = array();

	public $include_options = array();

	public $email_options = array();

	public $count_options = array();

	/**
	 * Default values for settings
	 * @since 1.0.0
	 */
	public $defaults = array();

	/**
	 * Stored values for settings
	 * @since 1.0.0
	 */
	public $settings = array();

	public function __construct() {

		add_action( 'init', array( $this, 'set_defaults' ) );

		add_action( 'init', array( $this, 'set_field_options' ) );

		add_action( 'init', array( $this, 'load_settings_panel' ) );
	}

	/**
	 * Load the plugin's default settings
	 * @since 1.0.0
	 */
	public function set_defaults() {

		$this->defaults = array(

			'access-role'				=> __( 'manage_options', 'ultimate-wp-mail' ),

			'send-actions'				=> json_encode( array() ),

			'unsubscribe-label'			=> __( 'Unsubscribe', 'ultimate-wp-mail' ),
		);

		$this->defaults = apply_filters( 'ewd_uwpm_defaults', $this->defaults );
	}

	/**
	 * Put all of the available possible select options into key => value arrays
	 * @since 1.0.0
	 */
	public function set_field_options() {
		global $ewd_uwpm_controller;

		$this->action_type_options = array(
			'User Events'			=> array(
				'user_registers'					=> __( 'On Registration', 'ultimate-wp-mail' ),
				'user_profile_updated'				=> __( 'When Profile Updated', 'ultimate-wp-mail' ),
				'user_role_changed'					=> __( 'When Role Changes', 'ultimate-wp-mail' ),
				'user_password_reset'				=> __( 'Password is Reset', 'ultimate-wp-mail' ),
				'user_x_time_since_login'			=> __( 'X Time Since Last Login', 'ultimate-wp-mail' ),
			),
			'Site Events'			=> array(
				'post_published_interest'			=> __( 'Post Published in Interest', 'ultimate-wp-mail' ),
				'new_comment_on_post'				=> __( 'New Comment after Commenting', 'ultimate-wp-mail' ),
			),
			'WooCommerce Events'	=> array(
				'wc_x_time_since_cart_abandoned'	=> __( 'X Time after Cart Abandoned', 'ultimate-wp-mail' ),
				'wc_x_time_after_purchase'			=> __( 'X Time after Purchase', 'ultimate-wp-mail' ),
				'product_added'						=> __( 'Product Added', 'ultimate-wp-mail' ),
				'product_purchased'					=> __( 'Product Purchased', 'ultimate-wp-mail' ),
			),
		);

		$this->include_options = array(
			'any'						=> __( 'Any Product', 'ultimate-wp-mail' ),
			'WooCommerce Categories'	=> array(),
			'Products'					=> array(),
		);

		if ( taxonomy_exists( 'product_cat' ) ) {

			$args = array(
				'hide_empty' 	=> false, 
				'taxonomy' 		=> 'product_cat'
			);
	
			$wc_categories = get_terms( $args );
	
			foreach ( $wc_categories as $wc_category ) {
	
				$this->include_options['WooCommerce Categories'][ 'c_' . $wc_category->term_id ] = $wc_category->name;
			}
		}

		if ( post_type_exists( 'product' ) ) {

			$args = array(
				'post_type' 		=> 'product', 
				'posts_per_page' 	=> -1, 
				'orderby' 			=> 'title', 
				'order' 			=> 'ASC'
			);
	
			$products = get_posts( $args );
	
			foreach ( $products as $product ) {
	
				$this->include_options['Products'][ 'p_' . $product->ID ] = $product->post_title;
			}
		}

		$args = array(
			'post_type'		=> EWD_UWPM_EMAIL_POST_TYPE,
			'numberposts'	=> -1
		);

		$emails = get_posts( $args );

		foreach ( $emails as $email ) { 

			$this->email_options[ $email->ID ] = $email->post_title;
		}

		for ( $i = 0; $i <= 60; $i++ ) {

			$this->count_options[ $i ] = $i;
		}
	}

	/**
	 * Get a setting's value or fallback to a default if one exists
	 * @since 1.0.0
	 */
	public function get_setting( $setting ) { 

		if ( empty( $this->settings ) ) {
			$this->settings = get_option( 'ewd-uwpm-settings' );
		}
		
		if ( ! empty( $this->settings[ $setting ] ) ) {
			return apply_filters( 'ewd-uwpm-settings-' . $setting, $this->settings[ $setting ] );
		}

		if ( ! empty( $this->defaults[ $setting ] ) ) { 
			return apply_filters( 'ewd-uwpm-settings-' . $setting, $this->defaults[ $setting ] );
		}

		return apply_filters( 'ewd-uwpm-settings-' . $setting, null );
	}

	/**
	 * Set a setting to a particular value
	 * @since 1.0.0
	 */
	public function set_setting( $setting, $value ) {

		$this->settings[ $setting ] = $value;
	}

	/**
	 * Save all settings, to be used with set_setting
	 * @since 1.0.0
	 */
	public function save_settings() {
		
		update_option( 'ewd-uwpm-settings', $this->settings );
	}

	/**
	 * Load the admin settings page
	 * @since 1.0.0
	 * @sa https://github.com/NateWr/simple-admin-pages
	 */
	public function load_settings_panel() {
		
		require_once( EWD_UWPM_PLUGIN_DIR . '/lib/simple-admin-pages/simple-admin-pages.php' );
		$sap = sap_initialize_library(
			$args = array(
				'version'       => '2.5.3',
				'lib_url'       => EWD_UWPM_PLUGIN_URL . '/lib/simple-admin-pages/',
			)
		);
		
		$sap->add_page(
			'submenu',
			array(
				'id'            => 'ewd-uwpm-settings',
				'title'         => __( 'Settings', 'ultimate-wp-mail' ),
				'menu_title'    => __( 'Settings', 'ultimate-wp-mail' ),
				'parent_menu'	=> 'edit.php?post_type=uwpm_mail_template',
				'description'   => '',
				'capability'    => $this->get_setting( 'access-role' ),
				'default_tab'   => 'ewd-uwpm-basic-tab',
			)
		);

		$sap->add_section(
			'ewd-uwpm-settings',
			array(
				'id'            => 'ewd-uwpm-basic-tab',
				'title'         => __( 'Basic', 'ultimate-wp-mail' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'ewd-uwpm-settings',
			array(
				'id'            => 'ewd-uwpm-general',
				'title'         => __( 'General', 'ultimate-wp-mail' ),
				'tab'	        => 'ewd-uwpm-basic-tab',
			)
		);

		$sap->add_setting(
			'ewd-uwpm-settings',
			'ewd-uwpm-general',
			'textarea',
			array(
				'id'			=> 'custom-css',
				'title'			=> __( 'Custom CSS', 'ultimate-wp-mail' ),
				'description'	=> __( 'You can add custom CSS styles to your appointment booking page in the box above.', 'ultimate-wp-mail' ),			
			)
		);

		$sap->add_setting(
			'ewd-uwpm-settings',
			'ewd-uwpm-general',
			'toggle',
			array(
				'id'			=> 'add-unsubscribe-link',
				'title'			=> __( 'Add Unsubscribe Link', 'ultimate-wp-mail' ),
				'description'	=> __( 'Should an unsubscribe link be added to the bottom of your emails?', 'ultimate-wp-mail' )
			)
		);

		$sap->add_setting(
			'ewd-uwpm-settings',
			'ewd-uwpm-general',
			'text',
			array(
				'id'            => 'unsubscribe-redirect-url',
				'title'         => __( 'Unsubscribe Redirect URL', 'ultimate-wp-mail' ),
				'description'	=> __( 'What URL should someone be redirected to when they unsubscribe?', 'ultimate-wp-mail' )
			)
		);

		$sap->add_setting(
			'ewd-uwpm-settings',
			'ewd-uwpm-general',
			'toggle',
			array(
				'id'			=> 'add-subscribe-checkbox',
				'title'			=> __( 'Add Subscribe Checkbox', 'ultimate-wp-mail' ),
				'description'	=> __( 'Should a subscribe checkbox be added to the bottom of WordPress registration forms and the edit profile page? (This can be used to email only those users who specifically sign up for emails)', 'ultimate-wp-mail' )
			)
		);

		$sap->add_setting(
			'ewd-uwpm-settings',
			'ewd-uwpm-general',
			'toggle',
			array(
				'id'			=> 'add-unsubscribe-checkbox',
				'title'			=> __( 'Add Unsubscribe Checkbox', 'ultimate-wp-mail' ),
				'description'	=> __( 'Should an unsubscribe checkbox be added to the bottom of WordPress registration forms and the edit profile page?', 'ultimate-wp-mail' )
			)
		);

		$sap->add_setting(
			'ewd-uwpm-settings',
			'ewd-uwpm-general',
			'toggle',
			array(
				'id'			=> 'track-opens',
				'title'			=> __( 'Track Opens', 'ultimate-wp-mail' ),
				'description'	=> __( 'Should the number of users who open each email be tracked?', 'ultimate-wp-mail' )
			)
		);

		$sap->add_setting(
			'ewd-uwpm-settings',
			'ewd-uwpm-general',
			'toggle',
			array(
				'id'			=> 'track-clicks',
				'title'			=> __( 'Track Clicks', 'ultimate-wp-mail' ),
				'description'	=> __( 'Should the number of clicks and the which links have been clicked be tracked?', 'ultimate-wp-mail' )
			)
		);

		$sap->add_setting(
			'ewd-uwpm-settings',
			'ewd-uwpm-general',
			'toggle',
			array(
				'id'			=> 'woocommerce-integration',
				'title'			=> __( 'WooCommerce Integration', 'ultimate-wp-mail' ),
				'description'	=> __( 'Should automatic lists based on WooCommerce purchases be added to the plugin?', 'ultimate-wp-mail' )
			)
		);

		$sap->add_setting(
			'ewd-uwpm-settings',
			'ewd-uwpm-general',
			'checkbox',
			array(
				'id'            => 'display-interests',
				'title'         => __( 'Listed in Interests', 'ultimate-wp-mail' ),
				'description'   => __( 'What interest options should be displayed by default when using the "Subcribe to Interests" shortcode or widget?', 'ultimate-wp-mail' ), 
				'options'       => array(
					'post_categories'			=> __( 'Post Categories', 'ultimate-wp-mail' ),
					'uwpm_categories'			=> __( 'Ultimate WP Mail Categories', 'ultimate-wp-mail' ),
					'woocommerce_categories'	=> __( 'WooCommerce Categories', 'ultimate-wp-mail' ),
				)
			)
		);

		$sap->add_setting(
			'ewd-uwpm-settings',
			'ewd-uwpm-general',
			'radio',
			array(
				'id'			=> 'display-post-interests',
				'title'			=> __( 'Display Post Interests', 'ultimate-wp-mail' ),
				'description'	=> __( 'Should an interests sign-up box be added to all posts, with the specific categories of that post as options?<br/>NOTE: You need to make sure at least one box is checked for the previous option (Listed in Interests) in order for this to have anything in it.', 'ultimate-wp-mail' ),
				'options'		=> array(
					'before'		=> __( 'Before', 'ultimate-wp-mail' ),
					'after'			=> __( 'After', 'ultimate-wp-mail' ),
					'none'			=> __( 'None', 'ultimate-wp-mail' ),
				)
			)
		);

		$sap->add_setting(
			'ewd-uwpm-settings',
			'ewd-uwpm-general',
			'text',
			array(
				'id'            => 'email-from-name',
				'title'         => __( 'Email "From" Name', 'ultimate-wp-mail' ),
				'description'	=> __( 'Who should the emails be sent from? Leave blank to use the default "From" address for your site.', 'ultimate-wp-mail' )
			)
		);

		$sap->add_setting(
			'ewd-uwpm-settings',
			'ewd-uwpm-general',
			'text',
			array(
				'id'            => 'email-from-email',
				'title'         => __( 'Email "From" Email Address', 'ultimate-wp-mail' ),
				'description'	=> __( 'What email address should the emails be sent from? Leave blank to use the default "From" address for your site.', 'ultimate-wp-mail' )
			)
		);

		$sap->add_section(
			'ewd-uwpm-settings',
			array(
				'id'            => 'ewd-uwpm-send-events-tab',
				'title'         => __( 'Send Events', 'ultimate-wp-mail' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'ewd-uwpm-settings',
			array(
				'id'            => 'ewd-uwpm-send-events',
				'title'         => __( 'Send Events', 'ultimate-wp-mail' ),
				'tab'	        => 'ewd-uwpm-send-events-tab',
			)
		);

		$send_events_description = '';
		
		$sap->add_setting(
			'ewd-uwpm-settings',
			'ewd-uwpm-send-events',
			'infinite_table',
			array(
				'id'			=> 'send-actions',
				'title'			=> __( 'Send Events', 'ultimate-wp-mail' ),
				'add_label'		=> __( '&plus; ADD', 'ultimate-wp-mail' ),
				'del_label'		=> __( 'Delete', 'ultimate-wp-mail' ),
				'description'	=> $send_events_description,
				'fields'		=> array(
					'id' 	=> array(
						'type' 		=> 'hidden',
						'label' 	=> 'ID',
					),
					'enabled' => array(
						'type' 		=> 'toggle',
						'label' 	=> 'Enabled',
						'required' 	=> true
					),
					'action_type' => array(
						'type' 			=> 'select',
						'label' 		=> __( 'Action Type', 'ultimate-wp-mail' ),
						'options' 		=> $this->action_type_options
					),
					'includes' => array(
						'type' 			=> 'select',
						'label' 		=> __( 'Include', 'ultimate-wp-mail' ),
						'options' 		=> $this->include_options
					),
					'email_id' => array(
						'type' 			=> 'select',
						'label' 		=> __( 'Email', 'ultimate-wp-mail' ),
						'options' 		=> $this->email_options
					),
					'interval_count' => array(
						'type' 		=> 'select',
						'label' 	=> __( 'Delay', 'ultimate-wp-mail' ),
						'options' 	=> $this->count_options
					),
					'interval_unit' => array(
						'type' 		=> 'select',
						'label' 	=> __( '', 'ultimate-wp-mail' ),
						'options' 	=> array(
							'Minutes'	=> __( 'Minute(s)', 'ultimate-wp-mail' ),
							'Hours'		=> __( 'Hour(s)', 'ultimate-wp-mail' ),
							'Days'		=> __( 'Day(s)', 'ultimate-wp-mail' ),
							'Weeks'		=> __( 'Week(s)', 'ultimate-wp-mail' ),
						)
					)
				)
			)
		);

		$sap->add_section(
			'ewd-uwpm-settings',
			array(
				'id'            => 'ewd-uwpm-labelling-tab',
				'title'         => __( 'Labelling', 'ultimate-wp-mail' ),
				'is_tab'		=> true,
			)
		);

		$sap->add_section(
			'ewd-uwpm-settings',
			array(
				'id'            => 'ewd-uwpm-labelling-subscriptions',
				'title'         => __( 'Subscriptions', 'ultimate-wp-mail' ),
				'tab'	        => 'ewd-uwpm-labelling-tab',
			)
		);

		$sap->add_setting(
			'ewd-uwpm-settings',
			'ewd-uwpm-labelling-subscriptions',
			'text',
			array(
				'id'            => 'label-subscribe',
				'title'         => __( 'Subscribe', 'ultimate-wp-mail' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-uwpm-settings',
			'ewd-uwpm-labelling-subscriptions',
			'text',
			array(
				'id'            => 'label-unsubscribe',
				'title'         => __( 'Unsubscribe', 'ultimate-wp-mail' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-uwpm-settings',
			'ewd-uwpm-labelling-subscriptions',
			'text',
			array(
				'id'            => 'label-login-select-topics',
				'title'         => __( 'Log in to your account so that you can subscribe to topics you\'re interested in!', 'ultimate-wp-mail' ),
				'description'	=> ''
			)
		);

		$sap->add_setting(
			'ewd-uwpm-settings',
			'ewd-uwpm-labelling-subscriptions',
			'text',
			array(
				'id'            => 'label-select-topics',
				'title'         => __( 'Select topics you\'re interested in below to receive emails when new items are posted!', 'ultimate-wp-mail' ),
				'description'	=> ''
			)
		);

		$sap = apply_filters( 'ewd_uwpm_settings_page', $sap );

		$sap->add_admin_menus();

	}
}
} // endif;
