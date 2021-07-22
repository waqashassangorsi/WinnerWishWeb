<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'ewduwpmReviewAsk' ) ) {
/**
 * Class to handle plugin review ask
 *
 * @since 1.0.0
 */
class ewduwpmReviewAsk {

	public function __construct() {
		
		add_action( 'admin_notices', array( $this, 'maybe_add_review_ask' ) );

		add_action( 'wp_ajax_ewd_uwpm_hide_review_ask', array( $this, 'hide_review_ask' ) );
		add_action( 'wp_ajax_ewd_uwpm_send_feedback', array( $this, 'send_feedback' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_review_ask_scripts' ) );
	}

	public function maybe_add_review_ask() { 
		
		$ask_review_time = get_option( 'ewd-uwpm-review-ask-time' );

		$install_time = get_option( 'ewd-uwpm-installation-time' );
		if ( ! $install_time ) { update_option( 'ewd-uwpm-installation-time', time() ); $install_time = time(); }

		$ask_review_time = $ask_review_time != '' ? $ask_review_time : $install_time + 3600*24*4;
		
		if ( $ask_review_time < time() and $install_time != '' and $install_time < time() - 3600*24*4 ) {
			
			global $pagenow;

			if ( $pagenow != 'post.php' && $pagenow != 'post-new.php' ) { ?>
	
				<div class='notice notice-info is-dismissible ewd-uwpm-main-dashboard-review-ask' style='display:none'>
					<div class='ewd-uwpm-review-ask-plugin-icon'></div>
					<div class='ewd-uwpm-review-ask-text'>
						<p class='ewd-uwpm-review-ask-starting-text'>Enjoying using the Ultimate WP Mail?</p>
						<p class='ewd-uwpm-review-ask-feedback-text ewd-uwpm-hidden'>Help us make the plugin better! Please take a minute to rate the plugin. Thanks!</p>
						<p class='ewd-uwpm-review-ask-review-text ewd-uwpm-hidden'>Please let us know what we could do to make the plugin better!<br /><span>(If you would like a response, please include your email address.)</span></p>
						<p class='ewd-uwpm-review-ask-thank-you-text ewd-uwpm-hidden'>Thank you for taking the time to help us!</p>
					</div>
					<div class='ewd-uwpm-review-ask-actions'>
						<div class='ewd-uwpm-review-ask-action ewd-uwpm-review-ask-not-really ewd-uwpm-review-ask-white'>Not Really</div>
						<div class='ewd-uwpm-review-ask-action ewd-uwpm-review-ask-yes ewd-uwpm-review-ask-green'>Yes!</div>
						<div class='ewd-uwpm-review-ask-action ewd-uwpm-review-ask-no-thanks ewd-uwpm-review-ask-white ewd-uwpm-hidden'>No Thanks</div>
						<a href='https://wordpress.org/support/plugin/ultimate-wp-mail/reviews/' target='_blank'>
							<div class='ewd-uwpm-review-ask-action ewd-uwpm-review-ask-review ewd-uwpm-review-ask-green ewd-uwpm-hidden'>OK, Sure</div>
						</a>
					</div>
					<div class='ewd-uwpm-review-ask-feedback-form ewd-uwpm-hidden'>
						<div class='ewd-uwpm-review-ask-feedback-explanation'>
							<textarea></textarea>
							<br>
							<input type="email" name="feedback_email_address" placeholder="<?php _e('Email Address', 'ultimate-wp-mail'); ?>">
						</div>
						<div class='ewd-uwpm-review-ask-send-feedback ewd-uwpm-review-ask-action ewd-uwpm-review-ask-green'>Send Feedback</div>
					</div>
					<div class='ewd-uwpm-clear'></div>
				</div>

			<?php
			}
		}
		else {
			wp_dequeue_script( 'ewd-uwpm-review-ask-js' );
			wp_dequeue_style( 'ewd-uwpm-review-ask-css' );
		}
	}

	public function enqueue_review_ask_scripts() {
		wp_enqueue_style( 'ewd-uwpm-review-ask-css', EWD_UWPM_PLUGIN_URL . '/assets/css/dashboard-review-ask.css' );
		wp_enqueue_script( 'ewd-uwpm-review-ask-js', EWD_UWPM_PLUGIN_URL . '/assets/js/dashboard-review-ask.js', array( 'jquery' ), EWD_UWPM_VERSION, true  );
	}

	public function hide_review_ask() {

		$ask_review_time = sanitize_text_field($_POST['ask_review_time']);

    	if ( get_option( 'ewd-uwpm-review-ask-time' ) < time() + 3600*24 * $ask_review_time ) {
    		update_option( 'ewd-uwpm-review-ask-time', time() + 3600*24 * $ask_review_time );
    	}

    	die();
	}

	public function send_feedback() {
		$headers = 'Content-type: text/html;charset=utf-8' . "\r\n";  
	    $feedback = sanitize_text_field($_POST['feedback']);
 		$feedback .= '<br /><br />Email Address: ';
    	$feedback .= sanitize_text_field($_POST['email_address']);

    	wp_mail('contact@etoilewebdesign.com', 'UWPM Feedback - Dashboard Form', $feedback, $headers);

    	die();
	} 
}

}