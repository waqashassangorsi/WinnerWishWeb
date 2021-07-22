<?php
/* Template Name: Sign Up Template */
get_header();
?>
<style>
	.column-swatch{
		width:50%;
		float:left;
	}
	.sign_up_text{
	text-align:center;
	font-weight:600;
	font-size:24px;
	line-height: 57px;
	}
	.side-div{
	    justify-content: center;
	    align-items: center;
		min-height:520px;
		max-height:800px;
		padding:9%;
		color:white;
		text-align:center;
		box-sizing:border-box;
  		align-items: center;
		padding-top: 25%;
	}
	
	@media screen and (max-width: 764px) and (min-width:340px){
		.column-swatch
		{
		width:100%;
		}
		.side-div{
		min-height: 208px;
		margin-top: 20px;
		}
		.container{
		padding: 8px;
		}	
		
		.createdata{
		padding: 2px;
		}
		
}

</style>
<div class="container" style="margin-top:60px;margin-bottom:60px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);background:rgba(58,179,151,1) 0%">
   
	
	<div class='column-swatch side-div'>
	
	
		<p class='sign_up_text'>Create an Account <br> and be part of a community of winners</p>
	
	
	</div>
	
	<div class='column-swatch createdata' style='padding-top:20px;background:white;'>
		<div class="text-center">
	   <h2 style="color:#3ab19b"> Create Account </h2>
	</div>
<?php   echo do_shortcode('[ultimatemember form_id="1104"]');?>

	</div>




</div>
<?php
 get_footer();
?>
<script>
	
jQuery(function($){
	
	//postal code verification
	$('#postal_code-1104').after('<p id="postal_error" style="color:red"></p>');
	$("#postal_code-1104").change(function(){
		
		var response = getTestData($(this).val());
		if($(this).val() == ""){
		$('#postal_error').text('');
			$(this).attr('style', 'border-color: #ddd !important');
			return;
		}
		console.log(response);
		if(response.error_code != undefined && response.error_code != ""){
			
			$(this).attr('style', 'border-color: red !important');
			switch(response.error_code){
				case '0001':
					var mesaage = 'No postal code found';
				break;
				case '0002':
					var mesaage = 'Invalid postcode format';
				break;
				case '0006':
					var mesaage = 'Too many postcodes requested';
				break;
				case '1001':
					var mesaage = 'JSON syntax error';
				break;
			}
			$('#postal_error').text(mesaage);
		}else{
			$('#postal_error').text('');
			$(this).attr('style', 'border-color: #ddd !important');
		}
	});
	
	/// check password
	$("#user_password-1104").after('<p id="strength" style="color:red"></p>');
	$("#user_password-1104").keyup(function(){
	 var passlength=$(this).val().length;
		//$(".password_show").insertAfter("#user_password-1455").show();
		//$(".password_show").show();
		//$(".password_show").attr("id","strength");	
		if(passlength>1)
		{
		 var strength = document.getElementById('strength');
			var strongRegex = new RegExp("^(?=.{14,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
			var mediumRegex = new RegExp("^(?=.{10,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
			var enoughRegex = new RegExp("(?=.{8,}).*", "g");
			var pwd = document.getElementById("user_password-1104");
			if (pwd.value.length == 0) {
				strength.innerHTML = 'Type Password';
			} else if (false == enoughRegex.test(pwd.value)) {
				strength.innerHTML = 'Weak!';
			} else if (strongRegex.test(pwd.value)) {
				strength.innerHTML = '<span style="color:green">Strong!</span>';
			} else if (mediumRegex.test(pwd.value)) {
				strength.innerHTML = '<span style="color:orange">Medium!</span>';
			} else {
				strength.innerHTML = '<span style="color:red">Weak!</span>';
			}
		
		}else
		{
			$(".strength").hide();
		}
		
	});
	
	$(document).on('submit','.um-1455 form',function(e){
		e.stopPropagation();
		
	var firstname=$('#first_name-1455').val();
	var lastname=$('#last_name-1455').val();		
	var phone=$('#number_datanew-1455').val();
	var email=$('#user_email-1455').val();
	var password=$('#user_password-1455').val();
	var confrimpass=$('#confirm_user_password-1455').val();
	$('.um-field-error').remove();
	if((firstname.length==0) || (lastname.length==0) ||  (phone.length==0) || (email.length==0) || (password.length==0)  ||           (confrimpass.length==0))
	{
	  if((firstname.length==0)){
		  jQuery('<div class="um-field-error"><span class="um-field-arrow"><i class="um-faicon-caret-up"></i></span>First Name is required</div>').appendTo("#um_field_1455_first_name");
	  
	  }
		
		if(($('#uk_adress-1455').val().length==0)){
		  jQuery('<div class="um-field-error"><span class="um-field-arrow"><i class="um-faicon-caret-up"></i></span>Uk Address is required</div>').appendTo("#um_field_1455_uk_adress");
	  
	  }
		
		if(($('#postal_code-1455').val().length==0)){
		  jQuery('<div class="um-field-error"><span class="um-field-arrow"><i class="um-faicon-caret-up"></i></span>Postal Code is required</div>').appendTo("#um_field_1455_postal_code");
	  
	  }
		
		
	if((lastname.length==0))
	{
	
		jQuery('<div class="um-field-error"><span class="um-field-arrow"><i class="um-faicon-caret-up"></i></span>Last Name is required</div>').appendTo("#um_field_1455_last_name");
		 
	
	}
		
   
	if ((phone.length==0))
	{
	
		jQuery('<div class="um-field-error"><span class="um-field-arrow"><i class="um-faicon-caret-up"></i></span>Phone Number Name is required</div>').appendTo("#um_field_1455_number_datanew");
	
	}
		
	if((email.length==0))
	{
	
		jQuery('<div class="um-field-error"><span class="um-field-arrow"><i class="um-faicon-caret-up"></i></span>Email Name is required</div>').appendTo("#um_field_1455_user_email");
		
	}
	if((password.length==0))
	{
	
		jQuery('<div class="um-field-error"><span class="um-field-arrow"><i class="um-faicon-caret-up"></i></span>Password is required</div>').appendTo("#um_field_1455_user_password");
		
	}
	if ((confrimpass.length==0))
	{
	
		jQuery('<div class="um-field-error"><span class="um-field-arrow"><i class="um-faicon-caret-up"></i></span>Confirm Password is required</div>').appendTo("#um_field_1455_confirm_user_password");
		
	}
	
		if(jQuery('input[name="news_update[]"]').is(':checked') == false)
		{
			jQuery('<div class="um-field-error"><span class="um-field-arrow"><i class="um-faicon-caret-up"></i></span>This Checkbox is required</div>').appendTo("#um_field_1455_news_update");
			
		}
		
		if(jQuery('input[name="term_condition[]"]').is(':checked') == false)
		{
			jQuery('<div class="um-field-error"><span class="um-field-arrow"><i class="um-faicon-caret-up"></i></span>Accept Terms & Conditions</div>').appendTo("#um_field_1455_term_condition");
			
		}
		$('#um-submit-btn').prop('disabled',false);
		return false;
	}
		
	 
		
	
		
			
	});
	
	//// Postal Code Verification
	
	function getTestData(postal){
		// Pass parameters via JSON
		var parameters = {
			key: "a59df-e8f03-6392f-06e8d",
			postcode: postal,
			response: "data_formatted"
		};
		var url = "https://pcls1.craftyclicks.co.uk/json/rapidaddress";
		// or via GET parameters
		// var url = "http://pcls1.craftyclicks.co.uk/json/rapidaddress?key=xxxxx-xxxxx-xxxxx-xxxxx&postcode=aa11aa&response=data_formatted";

		request = new XMLHttpRequest();
		request.open('POST', url, false);
		// Only needed for the JSON parameter pass
		request.setRequestHeader('Content-Type', 'application/json');
		// Wait for change and then either JSON parse response text or throw exception for HTTP error
		request.onreadystatechange = function() {
			if (this.readyState === 4){
				if (this.status >= 200 && this.status < 400){
					// Success!
					data = JSON.parse(this.responseText);
				} else {
					throw 'HTTP Request Error';
				}
			}
		};
		// Send request
		request.send(JSON.stringify(parameters));
		return data;
	}
	
});
</script>