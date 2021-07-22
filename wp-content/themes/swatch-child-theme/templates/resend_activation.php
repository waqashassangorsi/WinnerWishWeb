<?php
/* Template Name: Resend Activation Template */
get_header();

?>

<div class="container" style="padding:40px 0px">
   
	<div class='column-swatch form_paddingtop'>
		<div class="text-center">
	   <h2 style="color:#3ab19b"> Resend Activation link to your email </h2>
	</div>
	</div>
	<div class="resend_code">
		<?php   echo do_shortcode('[um_resend_activation_form]');?>
	</div>
</div>
<?php
 get_footer();
?>