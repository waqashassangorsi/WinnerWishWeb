<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'ewduwpmAJAX' ) ) {
	/**
	 * Class to handle AJAX interactions for Ultimate WP Mail
	 *
	 * @since 1.0.0
	 */
	class ewduwpmAJAX {

		public function __construct() { 

			add_action( 'wp_ajax_ewd_uwpm_ajax_preview_email', array( $this, 'get_email_preview' ) );

			add_action( 'wp_ajax_ewd_uwpm_send_test_email', array( $this, 'send_test_email' ) );

			add_action( 'wp_ajax_ewd_uwpm_email_all_users', array( $this, 'email_all_users' ) );

			add_action( 'wp_ajax_ewd_uwpm_email_user_list', array( $this, 'email_user_list' ) );

			add_action( 'wp_ajax_ewd_uwpm_email_specific_user', array( $this, 'email_specific_user' ) );

			add_action( 'wp_ajax_ewd_uwpm_interests_sign_up', array( $this, 'save_user_interests' ) );
		}

		/**
		 * Returns the output for a single email
		 * @since 1.0.0
		 */
		public function get_email_preview() {
			global $ewd_uwpm_controller;

			$email_content = $_POST['email_content'];

			$args = array(
				'email_id'	=> intval( $_POST['email_id'] )
			);
		
			$email_content = $ewd_uwpm_controller->notifications->process_email_content( $email_content, $args, wp_get_current_user() );
		
			echo $email_content;
		
			die();
		}
		
		/**
		 * Sends a test email to a specified email address
		 * @since 1.0.0
		 */
		public function send_test_email() {
			global $ewd_uwpm_controller;

			$email_address = sanitize_email( $_POST['email_address'] );
			$email_title = sanitize_text_field( $_POST['email_title'] );
			$email_content = $_POST['email_content'];
			
			$args = array(
				'email_id'	=> intval( $_POST['email_id'] )
			);
			
			$success = $ewd_uwpm_controller->notifications->send_email( $email_address, $email_title, $email_content, $args );

			echo $success ? __( 'Email successfully sent to ', 'ultimate-wp-mail') . $email_address : __( 'Email failed to send', 'ultimate-wp-mail' );
		
			die();
		}
		
		/**
		 * Sends an email to all of the users of the website
		 * @since 1.0.0
		 */
		public function email_all_users() {
			global $ewd_uwpm_controller;

			$params = array(
				'email_id' 		=> empty( $_POST['email_id'] ) ? 0 : intval( $_POST['email_id'] ),
				'email_title' 	=> empty( $_POST['email_title'] ) ? 0 : sanitize_text_field( $_POST['email_title'] ),
				'email_content' => empty( $_POST['email_content'] ) ? 0 : $_POST['email_content'],
				'send_time' 	=> empty( $_POST['send_time'] ) ? 'now' : sanitize_text_field( $_POST['send_time'] ),
				'send_type'		=> 'all'
			);
		
			if ( $params['send_time'] == 'now' ) { echo $ewd_uwpm_controller->notifications->email_all_users( $params ); }
			else { $ewd_uwpm_controller->notifications->schedule_email_send( $params ); }
		
			die();
		}
		
		/**
		 * Sends an email to a specific list of users, either auto-generated or created via the admin page 
		 * @since 1.0.0
		 */
		public function email_user_list() {
			global $ewd_uwpm_controller;

			$params = array(
				'email_id' 		=> empty( $_POST['email_id'] ) ? 0 : intval( $_POST['email_id'] ),
				'email_title' 	=> empty( $_POST['email_title'] ) ? 0 : sanitize_text_field( $_POST['email_title'] ),
				'email_content' => empty( $_POST['email_content'] ) ? '' : $_POST['email_content'],
				'list_id' 		=> empty( $_POST['list_id'] ) ? 0 : intval( $_POST['list_id'] ),
				'send_time' 	=> empty( $_POST['send_time'] ) ? 'now' : sanitize_text_field( $_POST['send_time'] ),
				'send_type'		=> 'user',
				'interests'		=> array(
					'post_categories' 	=> empty( $_POST['post_categories'] ) ? array() : explode( ',', $_POST['post_categories'] ),
					'uwpm_categories' 	=> empty( $_POST['uwpm_categories'] ) ? array() : explode( ',', $_POST['uwpm_categories'] ),
					'wc_categories' 	=> empty( $_POST['wc_categories'] ) ? array() : explode( ',', $_POST['wc_categories'] ),
				),
				'woocommerce'	=> array(
					'previous_purchasers' 		=> empty( $_POST['previous_purchasers'] ) ? '' : sanitize_text_field( $_POST['previous_purchasers'] ),
					'product_purchasers' 		=> empty( $_POST['product_purchasers'] ) ? '' : sanitize_text_field( $_POST['product_purchasers'] ),
					'previous_wc_products' 		=> empty( $_POST['previous_wc_products'] ) ? '' : sanitize_text_field( $_POST['previous_wc_products'] ),
					'category_purchasers' 		=> empty( $_POST['category_purchasers'] ) ? '' : sanitize_text_field( $_POST['category_purchasers'] ),
					'previous_wc_categories' 	=> empty( $_POST['previous_wc_categories'] ) ? '' : sanitize_text_field( $_POST['previous_wc_categories'] ),
				)
			);
		
			if ( $params['send_time'] == 'now' ) {echo $ewd_uwpm_controller->notifications->email_user_list( $params );}
			else { $ewd_uwpm_controller->notifications->schedule_email_send( $params ); }
		
			die();
		}
		
		/**
		 * Sends an email to a specific user
		 * @since 1.0.0
		 */
		public function email_specific_user() {
			global $ewd_uwpm_controller;

			$params = array(
				'email_id' 		=> empty( $_POST['email_id'] ) ? 0 : intval( $_POST['email_id'] ),
				'email_title' 	=> empty( $_POST['email_title'] ) ? 0 : sanitize_text_field( $_POST['email_title'] ),
				'email_content' => empty( $_POST['email_content'] ) ? 0 : $_POST['email_content'],
				'user_id' 		=> empty( $_POST['user_id'] ) ? 0 : intval( $_POST['user_id'] ),
				'send_time' 	=> empty( $_POST['send_time'] ) ? 'now' : sanitize_text_field( $_POST['send_time'] ),
				'send_type'		=> 'user'
			);
		
			if ( $params['send_time'] == 'now' ) { echo $ewd_uwpm_controller->notifications->email_user( $params ); }
			else { $ewd_uwpm_controller->notifications->schedule_email_send( $params ); }
		
			die();
		}
		
		/**
		 * Saves a user's interest topics so they can be automatically emailed later
		 * @since 1.0.0
		 */
		public function save_user_interests() {

			$post_categories = ! empty( $_POST['post_categories'] ) ? explode( ',', sanitize_text_field( $_POST['post_categories'] ) ) : array();
			$uwpm_categories = ! empty( $_POST['uwpm_categories'] ) ? explode( ',', sanitize_text_field( $_POST['uwpm_categories'] ) ) : array();
			$wc_categories = ! empty( $_POST['wc_categories'] ) ? explode( ',', sanitize_text_field( $_POST['wc_categories'] ) ) : array();
		
			$possible_post_categories = ! empty( $_POST['possible_post_categories'] ) ? explode( ',', sanitize_text_field( $_POST['possible_post_categories'] ) ) : array();
			$possible_uwpm_categories = ! empty( $_POST['possible_uwpm_categories'] ) ? explode( ',', sanitize_text_field( $_POST['possible_uwpm_categories'] ) ) : array();
			$possible_wc_categories = ! empty( $_POST['possible_wc_categories'] ) ? explode( ',', sanitize_text_field( $_POST['possible_wc_categories'] ) ) : array();
		
			$user_id = get_current_user_id();
			
			$current_post_categories = (array) get_user_meta( $user_id, 'EWD_UWPM_Post_Interests', true ); 
			$current_uwpm_categories = (array) get_user_meta( $user_id, 'EWD_UWPM_UWPM_Interests', true );
			$current_wc_categories = (array) get_user_meta( $user_id, 'EWD_UWPM_WC_Interests', true );
			
			$updated_post_categories = array_unique( array_merge( $post_categories, array_diff( $current_post_categories, $possible_post_categories ) ) );
			$updated_uwpm_categories = array_unique( array_merge( $uwpm_categories, array_diff( $current_uwpm_categories, $possible_uwpm_categories ) ) );
			$updated_wc_categories = array_unique( array_merge( $wc_categories, array_diff( $current_wc_categories, $possible_wc_categories ) ) );

			update_user_meta( $user_id, 'EWD_UWPM_Post_Interests', $updated_post_categories );
			update_user_meta( $user_id, 'EWD_UWPM_UWPM_Interests', $updated_uwpm_categories );
			update_user_meta( $user_id, 'EWD_UWPM_WC_Interests', $updated_wc_categories );
	
			return __( 'Interests successfully updated.', 'ultimate-wp-mail' );
		
			die();
		}
	}
}