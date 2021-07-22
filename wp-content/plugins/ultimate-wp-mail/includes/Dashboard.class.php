<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'ewduwpmDashboard' ) ) {
/**
 * Class to handle plugin dashboard
 *
 * @since 1.0.0
 */
class ewduwpmDashboard {

	public $message;
	public $status = true;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_dashboard_to_menu' ), 99 );

		add_action( 'admin_enqueue_scripts',  array( $this, 'enqueue_scripts' ) );

		add_action( 'wp_ajax_ewd_uwpm_hide_upgrade_box', array($this, 'hide_upgrade_box') );
		add_action( 'wp_ajax_ewd_uwpm_display_upgrade_box', array($this, 'display_upgrade_box') );
	}

	public function add_dashboard_to_menu() {
		global $ewd_uwpm_controller;
		global $submenu;

		add_submenu_page( 
			'edit.php?post_type=uwpm_mail_template', 
			'Dashboard', 
			'Dashboard', 
			$ewd_uwpm_controller->settings->get_setting( 'access-role' ), 
			'ewd-uwpm-dashboard', 
			array($this, 'display_dashboard_screen') 
		);

		// Create a new sub-menu in the order that we want
		$new_submenu = array();
		$menu_item_count = 3;

		if ( ! isset( $submenu['edit.php?post_type=uwpm_mail_template'] ) or  ! is_array($submenu['edit.php?post_type=uwpm_mail_template']) ) { return; }
		
		foreach ( $submenu['edit.php?post_type=uwpm_mail_template'] as $key => $sub_item ) {
			
			if ( $sub_item[0] == 'Dashboard' ) { $new_submenu[0] = $sub_item; }
			elseif ( $sub_item[0] == 'Settings' ) { $new_submenu[ sizeof($submenu) ] = $sub_item; }
			else {
				
				$new_submenu[$menu_item_count] = $sub_item;
				$menu_item_count++;
			}
		}

		ksort($new_submenu);
		
		$submenu['edit.php?post_type=uwpm_mail_template'] = $new_submenu;
	}

	// Enqueues the admin script so that our hacky sub-menu opening function can run
	public function enqueue_scripts() {
		global $admin_page_hooks;
		
		$currentScreen = get_current_screen();

		if ( $currentScreen->id == 'uwpm_mail_template_page_ewd-uwpm-dashboard' ) {
			wp_enqueue_style( 'ewd-uwpm-admin-css', EWD_UWPM_PLUGIN_URL . '/assets/css/ewd-uwpm-admin.css', array(), EWD_UWPM_VERSION );
			wp_enqueue_script( 'ewd-uwpm-admin-js', EWD_UWPM_PLUGIN_URL . '/assets/js/ewd-uwpm-admin.js', array( 'jquery', 'jquery-ui-sortable' ), EWD_UWPM_VERSION, true );
		}
	}

	public function display_dashboard_screen() { 
		global $ewd_uwpm_controller;

		$args = array(
			'post_type' => EWD_UWPM_EMAIL_POST_TYPE,
			'posts_per_page' => 10
		);
		
		$emails = get_posts( $args );

		?>

		<div id="ewd-uwpm-dashboard-content-area">

			<div id="ewd-uwpm-dashboard-content-left">
		
		
				<div class="ewd-uwpm-dashboard-new-widget-box ewd-widget-box-full" id="ewd-uwpm-dashboard-support-widget-box">
					<div class="ewd-uwpm-dashboard-new-widget-box-top"><?php _e('Get Support', 'ultimate-wp-mail'); ?><span id="ewd-uwpm-dash-mobile-support-down-caret">&nbsp;&nbsp;&#9660;</span><span id="ewd-uwpm-dash-mobile-support-up-caret">&nbsp;&nbsp;&#9650;</span></div>
					<div class="ewd-uwpm-dashboard-new-widget-box-bottom">
						<ul class="ewd-uwpm-dashboard-support-widgets">
							<li>
								<a href="https://www.youtube.com/channel/UCZPuaoetCJB1vZOmpnMxJNw/videos" target="_blank">
									<img src="<?php echo plugins_url( '../assets/img/ewd-support-icon-youtube.png', __FILE__ ); ?>">
									<div class="ewd-uwpm-dashboard-support-widgets-text"><?php _e('YouTube Tutorials', 'ultimate-wp-mail'); ?></div>
								</a>
							</li>
							<li>
								<a href="https://wordpress.org/plugins/ultimate-wp-mail/#faq" target="_blank">
									<img src="<?php echo plugins_url( '../assets/img/ewd-support-icon-faqs.png', __FILE__ ); ?>">
									<div class="ewd-uwpm-dashboard-support-widgets-text"><?php _e('Plugin FAQs', 'ultimate-wp-mail'); ?></div>
								</a>
							</li>
							<li>
								<a href="https://www.etoilewebdesign.com/support-center/?Plugin=OTP&Type=FAQs" target="_blank">
									<img src="<?php echo plugins_url( '../assets/img/ewd-support-icon-documentation.png', __FILE__ ); ?>">
									<div class="ewd-uwpm-dashboard-support-widgets-text"><?php _e('Documentation', 'ultimate-wp-mail'); ?></div>
								</a>
							</li>
							<li>
								<a href="https://www.etoilewebdesign.com/support-center/" target="_blank">
									<img src="<?php echo plugins_url( '../assets/img/ewd-support-icon-forum.png', __FILE__ ); ?>">
									<div class="ewd-uwpm-dashboard-support-widgets-text"><?php _e('Get Support', 'ultimate-wp-mail'); ?></div>
								</a>
							</li>
						</ul>
					</div>
				</div>
		
				<div class="ewd-uwpm-dashboard-new-widget-box ewd-widget-box-full" id="ewd-uwpm-dashboard-optional-table">
					<div class="ewd-uwpm-dashboard-new-widget-box-top"><?php _e('Emails', 'ultimate-wp-mail'); ?><span id="ewd-uwpm-dash-optional-table-down-caret">&nbsp;&nbsp;&#9660;</span><span id="ewd-uwpm-dash-optional-table-up-caret">&nbsp;&nbsp;&#9650;</span></div>
					<div class="ewd-uwpm-dashboard-new-widget-box-bottom">
						<table class='ewd-uwpm-overview-table wp-list-table widefat fixed striped posts'>
							<thead>
								<tr>
									<th><?php _e("Title", 'ultimate-wp-mail'); ?></th>
									<th><?php _e("Created Date", 'ultimate-wp-mail'); ?></th>
									<th><?php _e("Emails Sent", 'ultimate-wp-mail'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
									if ( empty( $emails ) ) {echo "<tr><td colspan='3'>" . __("No emails to display yet. Create an email for it to be displayed here.", 'ultimate-wp-mail') . "</td></tr>";}
									else {
										foreach ( $emails as $email ) { ?>
											<tr>
												<td>
													<a href='<?php echo esc_attr( 'post.php?action=edit&post=' ) . $email->ID; ?>'>
														<?php echo $email->post_title; ?>
													</a>
												</td>
												<td><?php echo $email->post_date; ?></td>
												<td><?php echo sizeof( $ewd_uwpm_controller->database_manager->get_emails_sent( $email->ID ) ); ?></td>
											</tr>
										<?php }
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
		
				<div class="ewd-uwpm-dashboard-new-widget-box <?php echo ( ($hideReview != 'Yes' and $Ask_Review_Date < time()) ? 'ewd-widget-box-two-thirds' : 'ewd-widget-box-full' ); ?>">
					<div class="ewd-uwpm-dashboard-new-widget-box-top">What People Are Saying</div>
					<div class="ewd-uwpm-dashboard-new-widget-box-bottom">
						<ul class="ewd-uwpm-dashboard-testimonials">
							<?php $randomTestimonial = rand(0,2);
							if($randomTestimonial == 0){ ?>
								<li id="ewd-uwpm-dashboard-testimonial-one">
									<img src="<?php echo plugins_url( '../assets/img/dash-asset-stars.png', __FILE__ ); ?>">
									<div class="ewd-uwpm-dashboard-testimonial-title">"Easy to use"</div>
									<div class="ewd-uwpm-dashboard-testimonial-author">- @marktielemans</div>
									<div class="ewd-uwpm-dashboard-testimonial-text">and very helpful! <a href="https://wordpress.org/support/topic/easy-to-use-3710/" target="_blank">read more</a></div>
								</li>
							<?php }
							if($randomTestimonial == 1){ ?>
								<li id="ewd-uwpm-dashboard-testimonial-two">
									<img src="<?php echo plugins_url( '../assets/img/dash-asset-stars.png', __FILE__ ); ?>">
									<div class="ewd-uwpm-dashboard-testimonial-title">"Very helpful"</div>
									<div class="ewd-uwpm-dashboard-testimonial-author">- @lebrija</div>
									<div class="ewd-uwpm-dashboard-testimonial-text">This plugin really helps to ease the burden of communicating with all subscribers to the page. <a href="https://wordpress.org/support/topic/very-helpful-1018/" target="_blank">read more</a></div>
								</li>
							<?php }
							if($randomTestimonial == 2){ ?>
								<li id="ewd-uwpm-dashboard-testimonial-three">
									<img src="<?php echo plugins_url( '../assets/img/dash-asset-stars.png', __FILE__ ); ?>">
									<div class="ewd-uwpm-dashboard-testimonial-title">"Great plugin"</div>
									<div class="ewd-uwpm-dashboard-testimonial-author">- @healthplaza</div>
									<div class="ewd-uwpm-dashboard-testimonial-text">As always etoile have made a great plugin. Easy to set up. Easy to use. And the best service ever. <a href="https://wordpress.org/support/topic/great-plugin-28857/" target="_blank">read more</a></div>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
		
			</div> <!-- left -->
		
			<div id="ewd-uwpm-dashboard-content-right">
		
				<div class="ewd-uwpm-dashboard-new-widget-box ewd-widget-box-full">
					<div class="ewd-uwpm-dashboard-new-widget-box-top">Other Plugins by Etoile</div>
					<div class="ewd-uwpm-dashboard-new-widget-box-bottom">
						<ul class="ewd-uwpm-dashboard-other-plugins">
							<li>
								<a href="https://wordpress.org/plugins/ultimate-faqs/" target="_blank"><img src="<?php echo plugins_url( '../assets/img/ewd-ufaq-icon.png', __FILE__ ); ?>"></a>
								<div class="ewd-uwpm-dashboard-other-plugins-text">
									<div class="ewd-uwpm-dashboard-other-plugins-title">Ultimate FAQs</div>
									<div class="ewd-uwpm-dashboard-other-plugins-blurb">An easy-to-use FAQ plugin that lets you create, order and publicize FAQs, with many styles and options!</div>
								</div>
							</li>
							<li>
								<a href="https://wordpress.org/plugins/ultimate-product-catalogue/" target="_blank"><img src="<?php echo plugins_url( '../assets/img/ewd-upcp-icon.png', __FILE__ ); ?>"></a>
								<div class="ewd-uwpm-dashboard-other-plugins-text">
									<div class="ewd-uwpm-dashboard-other-plugins-title">Product Catalog</div>
									<div class="ewd-uwpm-dashboard-other-plugins-blurb">Enables you to display your business's products in a clean and efficient manner.</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
		
			</div> <!-- right -->	
		
		</div> <!-- us-dashboard-content-area -->
		
		<div id="ewd-uwpm-dashboard-new-footer-two">
			<div class="ewd-uwpm-dashboard-new-footer-two-inside">
				<img src="<?php echo plugins_url( '../assets/img/ewd-logo-white.png', __FILE__ ); ?>" class="ewd-uwpm-dashboard-new-footer-two-icon">
				<div class="ewd-uwpm-dashboard-new-footer-two-blurb">
					At Etoile Web Design, we build reliable, easy-to-use WordPress plugins with a modern look. Rich in features, highly customizable and responsive, plugins by Etoile Web Design can be used as out-of-the-box solutions and can also be adapted to your specific requirements.
				</div>
				<ul class="ewd-uwpm-dashboard-new-footer-two-menu">
					<li>SOCIAL</li>
					<li><a href="https://www.facebook.com/EtoileWebDesign/" target="_blank">Facebook</a></li>
					<li><a href="https://twitter.com/EtoileWebDesign" target="_blank">Twitter</a></li>
					<li><a href="https://www.etoilewebdesign.com/blog/" target="_blank">Blog</a></li>
				</ul>
				<ul class="ewd-uwpm-dashboard-new-footer-two-menu">
					<li>SUPPORT</li>
					<li><a href="https://www.youtube.com/channel/UCZPuaoetCJB1vZOmpnMxJNw/videos" target="_blank">YouTube Tutorials</a></li>
					<li><a href="https://www.etoilewebdesign.com/support-center/?Plugin=UWPM&Type=FAQs" target="_blank">Documentation</a></li>
					<li><a href="https://www.etoilewebdesign.com/support-center/" target="_blank">Get Support</a></li>
					<li><a href="https://wordpress.org/plugins/ultimate-wp-mail/#faq" target="_blank">FAQs</a></li>
				</ul>
			</div>
		</div> <!-- ewd-uwpm-dashboard-new-footer-two -->
		
	<?php }

	public function display_notice() {
		if ( $this->status ) {
			echo "<div class='updated'><p>" . $this->message . "</p></div>";
		}
		else {
			echo "<div class='error'><p>" . $this->message . "</p></div>";
		}
	}
}
} // endif
