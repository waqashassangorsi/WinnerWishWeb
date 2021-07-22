<?php
/* Template Name: Sign In Template */
get_header();

?>
<style>
	.column-swatch{
		width:50%;
		float:left;
	}
	.side-div{
	    justify-content: center;
	    align-items: center;
		min-height:520px;
		max-height:800px;
		padding:3%;
		color:white;
		text-align:center;
		box-sizing:border-box;
       background:rgba(58,179,151,1) 0%;
	}
	
	.form_paddingtop
	{
		padding-top: 8%;
	}
		@media screen and (max-width: 764px) and (min-width:340px){
		.column-swatch
		{
		width:100%;
		}
		.side-div{
		min-height: 208px;
		margin-top: 2px;
		margin-bottom: 20px;	
		}
			
		.container{
		padding: 8px;
		}		
		
    }
  .alert-success
	{
		background:rgba(58,179,151,1) 0%;
		border:none; 
	}
</style>

	<?php 
$margin = "60px";
if(isset($_GET['status']) && $_GET['status'] == 'registered'){
	$margin = "10px";
	?>
	
<div class='container' style='margin-top:40px;'>
	<div class="alert alert-success" style='color:#fff;background-color:rgba(58,179,151,1) 0%'>
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>Well done!</strong> Account Created successfully! <span style='color:#bb0404db'> Kindly Activate Your E-mail.</span>
		<span style="float:right">Didn't get email? <button href="#myModal" data-toggle="modal" class="btn btn-primary" style="margin-top: -4px;" >Resend</button></span>
	</div>
</div><?php } ?>

<div class="container" style="margin-top:<?php echo $margin;?>;margin-bottom:60px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
   
	<div class='column-swatch form_paddingtop'>
		<div class="text-center">
	   <h2 style="color:#3ab19b"> SIGN IN TO WINNERSWISH </h2>
	</div>
		
<?php   echo do_shortcode('[ultimatemember form_id="1105"]');?>

	</div>

		
	<div class='column-swatch side-div form_paddingtop' style="padding-top: 16%;">
		
		<h2 style='color:white'> Hello Friend! </h2>
		<p style='font-size:18px;text-align:center;'>Sign in and let’s get winning.</p>
	
	</div>
	

</div>

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">To Resend Activation Link Email</h3>
  </div>
  <div class="modal-body">
    <?php   echo do_shortcode('[um_resend_activation_form]');?>
  </div>
</div>
<?php
 get_footer();
?>