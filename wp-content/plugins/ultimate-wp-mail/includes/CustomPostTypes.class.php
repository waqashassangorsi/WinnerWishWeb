<?php
/**
 * Class to handle all custom post type definitions for Ultimate WP Mail
 */

if ( !defined( 'ABSPATH' ) )
	exit;

if ( !class_exists( 'ewduwpmCustomPostTypes' ) ) {
class ewduwpmCustomPostTypes {

	public function __construct() {

		// Call when plugin is initialized on every page load
		add_action( 'admin_init', 		array( $this, 'create_nonce' ) );
		add_action( 'init', 			array( $this, 'load_cpts' ) );

		// Handle metaboxes
		add_action( 'add_meta_boxes', 	array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', 		array( $this, 'save_meta' ) );

		add_filter( 'gettext', 			array( $this, 'change_post_page_translations' ), 10, 3 );
	}

	/**
	 * Initialize custom post types
	 * @since 3.0.0
	 */
	public function load_cpts() {
		global $ewd_uwpm_controller;

		// Define the email custom post type
		$args = array(
			'labels' => array(
				'name' 					=> __( 'Emails',           			'ultimate-wp-mail' ),
				'singular_name' 		=> __( 'Email',                   	'ultimate-wp-mail' ),
				'menu_name'         	=> __( 'Emails',          			'ultimate-wp-mail' ),
				'name_admin_bar'    	=> __( 'Emails',                  	'ultimate-wp-mail' ),
				'add_new'           	=> __( 'Add New',                 	'ultimate-wp-mail' ),
				'add_new_item' 			=> __( 'Add New Email',           	'ultimate-wp-mail' ),
				'edit_item'         	=> __( 'Edit Email',               	'ultimate-wp-mail' ),
				'new_item'          	=> __( 'New Email',                	'ultimate-wp-mail' ),
				'view_item'         	=> __( 'View Email',               	'ultimate-wp-mail' ),
				'search_items'      	=> __( 'Search Emails',           	'ultimate-wp-mail' ),
				'not_found'         	=> __( 'No Emails found',          	'ultimate-wp-mail' ),
				'not_found_in_trash'	=> __( 'No Emails found in trash', 	'ultimate-wp-mail' ),
				'all_items'         	=> __( 'All Emails',              	'ultimate-wp-mail' ),
			),
			'public' 				=> true,
			'publicly_queryable' 	=> false,
			'exclude_from_search' 	=> true,
			'has_archive' 			=> true,
			'menu_icon' 			=> 'dashicons-email',
			'capability_type' 		=> 'post',
			'rewrite' 				=> array(
				'slug' 					=> 'email'
			),
			'supports' 				=> array(
				'title', 
			),
			'show_in_rest' 			=> true,
		);

		// Create filter so addons can modify the arguments
		$args = apply_filters( 'ewd_uwpm_emails_args', $args );

		// Add an action so addons can hook in before the post type is registered
		do_action( 'ewd_uwpm_emails_pre_register' );

		// Register the post type
		register_post_type( EWD_UWPM_EMAIL_POST_TYPE, $args );

		// Add an action so addons can hook in after the post type is registered
		do_action( 'ewd_uwpm_emails_post_register' );

		// Define the review category taxonomy
		$args = array(
			'labels' => array(
				'name' 				=> __( 'Email Categories',			'ultimate-wp-mail' ),
				'singular_name' 	=> __( 'Email Category',				'ultimate-wp-mail' ),
				'search_items' 		=> __( 'Search Email Categories', 	'ultimate-wp-mail' ),
				'all_items' 		=> __( 'All Email Categories', 		'ultimate-wp-mail' ),
				'parent_item' 		=> __( 'Parent Email Category', 		'ultimate-wp-mail' ),
				'parent_item_colon' => __( 'Parent Email Category:', 		'ultimate-wp-mail' ),
				'edit_item' 		=> __( 'Edit Email Category', 		'ultimate-wp-mail' ),
				'update_item' 		=> __( 'Update Email Category', 		'ultimate-wp-mail' ),
				'add_new_item' 		=> __( 'Add New Email Category', 		'ultimate-wp-mail' ),
				'new_item_name' 	=> __( 'New Email Category Name', 	'ultimate-wp-mail' ),
				'menu_name' 		=> __( 'Email Categories', 			'ultimate-wp-mail' ),
            ),
			'query_var'		=> false,
		);

		// Create filter so addons can modify the arguments
		$args = apply_filters( 'ewd_uwpm_category_args', $args );

		register_taxonomy( EWD_UWPM_EMAIL_CATEGORY_TAXONOMY, EWD_UWPM_EMAIL_POST_TYPE, $args );
	}

	/**
	 * Generate a nonce for secure saving of metadata
	 * @since 3.0.0
	 */
	public function create_nonce() {

		$this->nonce = wp_create_nonce( basename( __FILE__ ) );
	}

	/**
	 * Add in new columns for the uwpm_email type
	 * @since 3.0.0
	 */
	public function add_meta_boxes() {

		$meta_boxes = array(

			// Add in the Email builder
			'email_builder' => array (
				'id'		=> 'ewd-uwpm-build-email',
				'title'		=> esc_html__( 'Build Email', 'ultimate-wp-mail' ),
				'callback'	=> array( $this, 'add_email_builder' ),
				'post_type'	=> EWD_UWPM_EMAIL_POST_TYPE,
				'context'	=> 'normal',
				'priority'	=> 'high'
			),

			// Add in the Email builder
			'send_events' => array (
				'id'		=> 'ewd-uwpm-send-events',
				'title'		=> esc_html__( 'Send Events', 'ultimate-wp-mail' ),
				'callback'	=> array( $this, 'show_email_statistics' ),
				'post_type'	=> EWD_UWPM_EMAIL_POST_TYPE,
				'context'	=> 'normal',
				'priority'	=> 'high'
			),

			// Add in a link to the documentation for the plugin
			'ewd_uwpm_meta_need_help' => array (
				'id'		=> 'ewd-uwpm-meta-need-help',
				'title'		=> esc_html__( 'Need Help?', 'ultimate-wp-mail' ),
				'callback'	=> array( $this, 'show_need_help_meta' ),
				'post_type'	=> EWD_UWPM_EMAIL_POST_TYPE,
				'context'	=> 'side',
				'priority'	=> 'high'
			),

			// Add in a box that allows the email to be sent
			'send_emails' => array (
				'id'		=> 'ewd-uwpm-send-mail-meta-box',
				'title'		=> esc_html__( 'Send Email', 'ultimate-wp-mail' ),
				'callback'	=> array( $this, 'add_send_mail' ),
				'post_type'	=> EWD_UWPM_EMAIL_POST_TYPE,
				'context'	=> 'side',
				'priority'	=> 'high'
			),
		);

		// Create filter so addons can modify the metaboxes
		$meta_boxes = apply_filters( 'ewd_uwpm_meta_boxes', $meta_boxes );

		// Create the metaboxes
		foreach ( $meta_boxes as $meta_box ) {
			add_meta_box(
				$meta_box['id'],
				$meta_box['title'],
				$meta_box['callback'],
				$meta_box['post_type'],
				$meta_box['context'],
				$meta_box['priority']
			);
		}
	}

	/**
	 * Add in a link to the plugin documentation
	 * @since 3.0.0
	 */
	public function add_email_builder( $post ) { 
		global $ewd_uwpm_controller;

		ewd_uwpm_load_view_files();

		$args = array(
			'post'	=> $post,
			'nonce'	=> $this->nonce
		);

		$email_builder_view = new ewduwpmAdminEmailBuilderView( $args );

		echo $email_builder_view->render();

	} 

	/**
	 * Shows statistics related to the number of times an email has been sent
	 * @since 3.0.0
	 */
	public function show_email_statistics( $post ) {
		global $ewd_uwpm_controller;

		$previous_sends = is_array( get_post_meta( $post->ID, 'EWD_UWPM_Send_Events', true ) ) ? get_post_meta( $post->ID, 'EWD_UWPM_Send_Events', true ) : array();

		?>

		<div class='ewd-uwpm-sent-events'>

			<h3><?php _e("Previous Email Sends", 'ultimate-wp-mail'); ?></h3>
		
			<table>

				<thead>

					<tr>
						<th><?php _e( 'Send Time', 'ultimate-wp-mail' ); ?></th>
						<th><?php _e( 'Send Type', 'ultimate-wp-mail' ); ?></th>
						<th><?php _e( 'Recipient(s)', 'ultimate-wp-mail' ); ?></th>
						<th><?php _e( 'Successful Sends', 'ultimate-wp-mail' ); ?></th>
						<?php if ( $ewd_uwpm_controller->settings->get_setting( 'track-opens' ) ) { ?> <th><?php _e( 'Number of Opens', 'ultimate-wp-mail' ); ?></th><?php } ?>
						<?php if ( $ewd_uwpm_controller->settings->get_setting( 'track-clicks' ) ) { ?> <th><?php _e( 'Number of Links Clicked', 'ultimate-wp-mail' ); ?></th><?php } ?>
					</tr>

				</thead>

				<tbody>

					<?php foreach ( $previous_sends as $previous_send ) { ?>

						<tr>
							<td><?php echo $previous_send['Send_Time']; ?></td>
							<td><?php echo $previous_send['Send_Type']; ?></td>
							<td>
								<?php  
									if ( $previous_send['Send_Type'] == 'List' ) { echo esc_html( $this->get_list_name_from_id( $previous_send['List_ID'] ) ); }
									elseif ( $previous_send['Send_Type'] == 'User' ) { $user = get_userdata( $previous_send['User_ID'] ); echo esc_html( $user->display_name ); }
									else { _e( 'All Users', 'ultimate-wp-mail' ); }
								?>
							</td>
							<td><?php echo $previous_send['Emails_Sent']; ?></td>
							<?php if ( $ewd_uwpm_controller->settings->get_setting( 'track-opens' ) ) { ?><td><?php echo sizeOf( $ewd_uwpm_controller->database_manager->get_email_opens( array( 'email_send_id' => $previous_send['ID'] ) ) ); ?></td><?php } ?>
							<?php if ( $ewd_uwpm_controller->settings->get_setting( 'track-clicks' ) ) { ?><td><?php echo sizeOf( $ewd_uwpm_controller->database_manager->get_email_links_clicked( array( 'email_send_id' => $previous_send['ID'] ) ) ); ?></td><?php } ?>
						</tr>

					<?php } ?>

				</tbody>

			</table>

		</div>

		<?php 
	}

	/**
	 * Add in a link to the plugin documentation
	 * @since 3.0.0
	 */
	public function show_need_help_meta() { ?>
    
    	<div class='ewd-uwpm-need-help-box'>
    		<div class='ewd-uwpm-need-help-text'>Visit our Support Center for documentation and tutorials</div>
    	    <a class='ewd-uwpm-need-help-button' href='https://www.etoilewebdesign.com/support-center/?Plugin=UWPM' target='_blank'>GET SUPPORT</a>
    	</div>

	<?php }

	/**
	 * Adds in the send email box
	 * @since 3.0.0
	 */
	public function add_send_mail( $post ) {

		include( EWD_UWPM_PLUGIN_DIR . '/' . EWD_UWPM_TEMPLATE_DIR . '/admin-send-mail.php' );
	}

	/**
	 * Save the metabox data for each review
	 * @since 3.0.0
	 */
	public function save_meta( $post_id ) {
		global $ewd_uwpm_controller;

		// Verify nonce
		if ( ! isset( $_POST['ewd_uwpm_nonce'] ) || ! wp_verify_nonce( $_POST['ewd_uwpm_nonce'], basename( __FILE__ ) ) ) {

			return $post_id;
		}

		// Check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

			return $post_id;
		}

		if ( get_post_type( $post_id ) != EWD_UWPM_EMAIL_POST_TYPE ) { 

			return $post_id; 
		}

		// Check permissions
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		} elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		if ( isset( $_POST['ewd_uwpm_email_content'] ) ) 			{ update_post_meta( $post_id, 'EWD_UWPM_Mail_Content', $_POST['ewd_uwpm_email_content'] ); }
		if ( isset( $_POST['ewd_uwpm_plain_text_email'] ) ) 		{ update_post_meta( $post_id, 'EWD_UWPM_Plain_Text_Mail_Content', sanitize_text_field( $_POST['ewd_uwpm_plain_text_email'] ) ); }

		if ( isset( $_POST['ewd_uwpm_content_alignment'] ) )		{ update_post_meta( $post_id, 'EWD_UWPM_Content_Alignment', sanitize_text_field( $_POST['ewd_uwpm_content_alignment'] ) ); }
		if ( isset( $_POST['ewd_uwpm_max_width'] ) ) 				{ update_post_meta( $post_id, 'EWD_UWPM_Max_Width', sanitize_text_field( $_POST['ewd_uwpm_max_width'] ) ); }
		if ( isset( $_POST['ewd_uwpm_background_color'] ) ) 		{ update_post_meta( $post_id, 'EWD_UWPM_Email_Background_Color', sanitize_text_field( $_POST['ewd_uwpm_background_color'] ) ); }
		if ( isset( $_POST['ewd_uwpm_body_background_color'] ) ) 	{ update_post_meta( $post_id, 'EWD_UWPM_Body_Background_Color', sanitize_text_field( $_POST['ewd_uwpm_body_background_color'] ) ); }
		if ( isset( $_POST['ewd_uwpm_block_background_color'] ) ) 	{ update_post_meta( $post_id, 'EWD_UWPM_Block_Background_Color', sanitize_text_field( $_POST['ewd_uwpm_block_background_color'] ) ); }
		if ( isset( $_POST['ewd_uwpm_block_border'] ) ) 			{ update_post_meta( $post_id, 'EWD_UWPM_Block_Border', sanitize_text_field( $_POST['ewd_uwpm_block_border'] ) ); }
	}

	/**
	 * Returns the name of an email list given its ID
	 * @since 3.0.0
	 */
	public function get_list_name_from_id( $list_id ) {
		global $ewd_uwpm_controller;

		$lists = ewd_uwpm_decode_infinite_table_setting( $ewd_uwpm_controller->settings->get_setting( 'lists' ) );

		foreach ( $lists as $list ) {

			if ( $list->id == $list_id ) { return $list->name; }
		}

		return false;
	}

	/**
	 * Replace 'Publish', 'Update' and 'Save' for the email post type
	 * @since 3.0.0
	 */
	public function change_post_page_translations( $translated, $original, $domain ) {
		global $post_type;

		if ( empty( $post_type ) or $post_type != EWD_UWPM_EMAIL_POST_TYPE ) { return $translated; }

		$replacements = array(
			'Publish' 	=> 'Save',
            'Published' => 'Saved',
            'Update' 	=> 'Save'
		);

        return strtr( $original, $replacements );
	}
}
} // endif;
