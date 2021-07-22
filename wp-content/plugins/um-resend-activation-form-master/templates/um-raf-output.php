<?php
/**
 * Output the form
 *
 * @link https://www.trestian.com
 * @since 1.0.0
 *
 * @package Um_Resend_Activation_Form
 * @subpackage Um_Resend_Activation_Form/public/partials
 */

defined( 'ABSPATH' ) || exit;
?>

<?php do_action( 'um_raf_before_alert' ); ?>
<div id="um-raf-success" class="<?php echo esc_attr( apply_filters( 'um_raf_alert_class', 'um-raf-alert' ) ); ?> <?php echo esc_attr( apply_filters( 'um_raf_alert_success_class', 'um-raf-alert-success' ) ); ?>"></div>

<div id="um-raf-error" class="<?php echo esc_attr( apply_filters( 'um_raf_alert_class', 'um-raf-alert' ) ); ?> <?php echo esc_attr( apply_filters( 'um_raf_alert_error_class', 'um-raf-alert-error' ) ); ?>"></div>
<?php do_action( 'um_raf_after_alert' ); ?>

<?php do_action( 'um_raf_before_form' ); ?>
<form id="um-raf-form" class="<?php echo esc_attr( apply_filters( 'um_raf_form_class', 'um-raf-form' ) ); ?>">
	<?php do_action( 'um_raf_before_label' ); ?>
	<label for="um-raf-email" class="<?php echo esc_attr( apply_filters( 'um_raf_label_class', 'um-raf-label' ) ); ?>">
		<?php echo esc_html( apply_filters( 'um_raf_email_label', __( 'Re Enter Your Email', 'um_raf' ) ) ); ?>:
	</label>
	<?php do_action( 'um_raf_after_label' ); ?>

	<?php do_action( 'um_raf_before_field' ); ?>
	<input id="um-raf-email" type="email" name="email" placeholder="<?php esc_attr_e( 'Enter your email', 'um_raf' ); ?>" class="<?php echo esc_attr( apply_filters( 'um_raf_field_class', 'um-raf-field' ) ); ?>" required />
	<?php do_action( 'um_raf_after_field' ); ?>

	<?php do_action( 'um_raf_before_button' ); ?>
	<button type="submit" class="<?php echo esc_attr( apply_filters( 'um_raf_button_class', 'um-raf-button' ) ); ?>"><?php echo esc_html( apply_filters( 'um_raf_button_text', __( 'Resend', 'um_raf' ) ) ); ?><span id="um-raf-loader"><span class="<?php echo esc_attr( apply_filters( 'um_raf_loader_class', 'um-raf-loader' ) ); ?>"></span></span></button>
	<?php do_action( 'um_raf_after_button' ); ?>
</form>
<?php do_action( 'um_raf_before_form' ); ?>
