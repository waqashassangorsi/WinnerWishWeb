<?php
global $post;
global $ewd_uwpm_controller;

$lists = (array) get_option( 'ewd-uwpm-email-lists' );

?>

<div class='ewd-uwpm-send-options'>

	<?php if ( empty( $post->ID ) ) { _e( 'Save email first to be able to track opens and clicks', 'ultimate-wp-mail' ); } ?>

	<div class='ewd-uwpm-schedule-sending'>

		<select class='ewd-uwpm-delay-send-toggle'>
			<option value='now'><?php _e( 'Send Now', 'ultimate-wp-mail' ); ?></option>
			<option value='later'><?php _e( 'Send Later', 'ultimate-wp-mail' ); ?></option>
		</select>

		<input id="ewd-uwpm-send-datetime" class='ewd-uwpm-hidden' type="datetime-local" />

	</div>

	<hr class=''>

	<div class='ewd-uwpm-email-specific-user'>

		<select id='ewd-uwpm-email-user-select'>

			<?php foreach ( get_users() as $user ) { ?>

				<option value='<?php echo $user->ID; ?>' <?php echo ( get_user_meta($user->ID, 'EWD_UWPM_User_Unsubscribe', true) == 'Yes' ? 'disabled' : '' ); ?>>
					<?php echo $user->user_login; ?> (<?php echo $user->user_email; ?>)
				</option>

			<?php } ?>

		</select>

		<div class='ewd-uwpm-clear'></div>

		<button id='ewd-uwpm-email-specific-user' class='button button-primary button-large' >
			<?php _e( 'Email User', 'ultimate-wp-mail' ); ?>
		</button>

	</div>

	<div class='ewd-uwpm-email-option-separator'></div>

	<div class='ewd-uwpm-email-user-list-div'>

		<select id='ewd-uwpm-email-list-select'>

			<?php foreach ( $lists as $list ) { ?>

				<option value='<?php echo $list->id; ?>'>
					<?php echo esc_html( $list->name ); ?> ( <?php echo sizeOf( $list->user_list ) . ' ' . __(' Users', 'ultimate-wp-mail'); ?> )
				</option>

			<?php } ?>

			<optgroup label='<?php _e( 'Automatically Created Lists', 'ultimate-wp-mail' ); ?>'>
				<option value='-1'><?php _e( 'Select a list...', 'ultimate-wp-mail' ); ?></option>
			</optgroup>

		</select>

		<div class='ewd-uwpm-clear'></div>

		<button id='ewd-uwpm-email-user-list' class='button button-primary button-large'>
			<?php _e( 'Email User List', 'ultimate-wp-mail' ); ?>
		</button>

	</div>

	<div class='ewd-uwpm-email-option-separator'></div>

	<div class='ewd-uwpm-email-all-users-div'>

		<button id='ewd-uwpm-email-all' class='button button-primary button-large'>
			<?php _e( 'Email All Users', 'ultimate-wp-mail' ); ?>
		</button>

	</div>

	<hr/>

	<div id='ewd-uwpm-send-test-button-div'>

		<button id='ewd-uwpm-send-test-button' class='button button-primary button-large'>
			<?php _e( 'Send Test Email', 'ultimate-wp-mail' ); ?>
		</button>

	</div>

</div>

<div class='ewd-uwpm-al-dark-overlay ewd-uwpm-auto-list-overlay ewd-uwpm-hidden'></div>

<div class='ewd-uwpm-auto-list-options ewd-uwpm-hidden'>

	<h2 class='ewd-uwpm-al-interests ewd-uwpm-auto-list-tab-active'>
		<?php _e( 'Interest Lists', 'ultimate-wp-mail'); ?>
	</h2>

	<?php if ( $ewd_uwpm_controller->settings->get_setting( 'woocommerce-integration' ) ) { ?>

		<h2 class='ewd-uwpm-al-wc'>
			<?php _e( 'WooCommerce Lists', 'ultimate-wp-mail' ); ?>
		</h2>

	<?php } ?>
			
	<div class='ewd-uwpm-clear'></div>

	<div class='ewd-uwpm-al-interest-groups <?php echo ( $ewd_uwpm_controller->settings->get_setting( 'woocommerce-integration' ) ? 'ewd-uwpm-interest-groups-wc' : '' ); ?>'>

		<div class='ewd-uwpm-al-post-categories'>

			<h4>
				<?php _e( 'Post Categories', 'ultimate-wp-mail'); ?>
			</h4>

			<?php 
				$args = array(
					'taxonomy' => 'category', 
					'hide_empty' => false
				);

				$categories = get_terms( $args );
			?>

			<?php foreach ( $categories as $category ) { ?>
				<input type='checkbox' class='ewd-uwpm-al-post-category' value='<?php echo $category->term_id; ?>' /><span><?php echo esc_html( $category->name ); ?></span><br/>
			<?php } ?>

		</div>

		<div class='ewd-uwpm-al-email-categories'>

			<h4>
				<?php _e( 'Email Categories', 'ultimate-wp-mail'); ?>
			</h4>

			<?php 
				$args = array(
					'taxonomy' => 'uwpm-category', 
					'hide_empty' => false
				);

				$categories = get_terms( $args );
			?>

			<?php foreach ( $categories as $category ) { ?>
				<input type='checkbox' class='ewd-uwpm-al-post-category' value='<?php echo $category->term_id; ?>' /><span><?php echo esc_html( $category->name ); ?></span><br/>
			<?php } ?>

		</div>

		<div class='ewd-uwpm-al-wc-categories'>

			<h4>
				<?php _e( 'WooCommerce Categories', 'ultimate-wp-mail'); ?>
			</h4>

			<?php 
				$args = array(
					'taxonomy' => 'product_cat', 
					'hide_empty' => false
				);

				$categories = get_terms( $args );
			?>

			<?php foreach ( $categories as $category ) { ?>
				<input type='checkbox' class='ewd-uwpm-al-post-category' value='<?php echo $category->term_id; ?>' /><span><?php echo esc_html( $category->name ); ?></span><br/>
			<?php } ?>

		</div>

	</div>
	
	<?php if ( $ewd_uwpm_controller->settings->get_setting( 'woocommerce-integration' ) ) { ?>

		<div class='ewd-uwpm-al-woocommerce-lists ewd-uwpm-hidden'>

			<input type='checkbox' class='ewd-uwpm-al-wc-previous-purchasers' /><span><?php _e( 'All Previous Purchasers', 'ultimate-wp-mail' ); ?></span>

			<div class='ewd-uwpm-clear'></div>

			<input type='checkbox' class='ewd-uwpm-al-wc-previous-products' /><span><?php _e( 'Previous Purchasers of:', 'ultimate-wp-mail' ); ?></span><br />

			<?php 

				$args = array(
					'post_type' 		=> 'product',
					'posts_per_page' 	=> -1,
					'orderby' 			=> 'title',
					'order' 			=> 'ASC'
				);

				$products = get_posts( $args );
			?>

			<select class='ewd-uwpm-al-wc-products' multiple>
				
				<?php foreach ( $products as $product ) { ?>
					<option value='<?php echo $product->ID; ?>'><?php echo esc_html( $product->post_title ); ?></option>
				<?php } ?>

			</select><br/>

			<div class='ewd-uwpm-clear'></div>

			<input type='checkbox' class='ewd-uwpm-al-wc-previous-categories' /><span><?php _e( 'Previous Purchasers of Product in: ', 'ultimate-wp-mail' ); ?></span><br />

			<select class='ewd-uwpm-al-wc-categories' multiple>
			
				<?php foreach ( $categories as $category ) { ?>
					<option value='<?php echo $category->term_id; ?>'><?php echo esc_html( $category->name ); ?></option>
				<?php } ?>
				
			</select>

		</div>

	<?php } ?>

	<button class='ewd-uwpm-submit-al button button-primary button-large'>
		<?php _e( 'Send Email to Selected Groups', 'ultimate-wp-mail' ); ?>
	</button>

</div>