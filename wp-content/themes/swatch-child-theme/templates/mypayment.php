<?php
/* Template Name: MyPayment Template */
get_header();
if(is_user_logged_in()){
$user_details = wp_get_current_user();
global $wpdb;global $wp;
$get_other_user_info = $wpdb->get_row("select * from PQrlH_userDetails where user_id=".$user_details->ID); 

$current_url = home_url(add_query_arg(array($_GET), $wp->request));
//print_r($get_other_user_info);
?>
<style>
	.heading_margin
	{
		margin-top:10px;
	}
	.heading_center
	{
		text-align:center
	}	
	.leftcard_ul
	{
		list-style-type:none;
		
	}
    .cart_pic{
	  margin-right:11px;
	}
	.col-sm-4
	{
	width: 20%;
    float: left;
    
	}
	.leftcard_ul
	{
		list-style-type:none;
		background: #e9ecef;
   		 margin: 0px;
		min-height:300px;
	}
	.col-sm-8 {
	width:80%;
	float:left;
	padding:30px;
	padding-top:0px;
	box-sizing:border-box;
	padding-bottom:5px;	
	}
	.rightcard_ul
	{
		list-style-type:none;
		display:flex;
	}
	.rightcard_ul li{
	margin-right:10px;
		padding-bottom:15px;
	}
	.form-control{
	border:1px solid #eee !important;
	border-radius:7px !important;	
	width:93%;
	padding: 4px !important;
	}
	
	.leftcard_ul li
	{
		padding-bottom:26px
	}
	.username_div
	{
		border: 1px solid #8080802b;
    padding: 9px;
    padding-bottom: 0px;
	}
	
	@media screen and (max-width: 764px) and (min-width:340px){
     .col-sm-4{
		width:100%;
		}
	.col-sm-8
		{
		width:100%;
			padding:0px;
			margin-top: 13px;
		padding-bottom: 15px;	
		}
		.cardwrapper{
		width: 100%;
        padding: 0px;
        padding-top: 22px;
		}	
.container{
	padding:5px;
	}
		
	}
	
	a{
		color:black
	}
	.container_margintop{
	margin-top:27px;
	}
	
	.balanceamount:focus,.newamount:focus,.newpaymentgatewaydropdown:focus,.newemail:focus{
	box-shadow:none !important;
	}
	
	.newcontainer
	{
	background:#e9ecef;
	margin-bottom:60px;
	padding:0px
	}
	
	@media screen and (max-width: 764px) and (min-width:340px){
.newcontainer{
         	margin-top:0px;
       }
    
}

</style>


<div class="container" style="margin-top:23px">
<div class="row heading_margin"  style="margin-top:23px">
		<div class="col-sm-12">
			<h1 class="heading_center">My Account</h1>
		</div>
	</div>
</div>	

<div class="container container_margintop newcontainer">
	<?php 
	if(isset($_SESSION['update_status'])){
		if($_SESSION['update_status'] == 'updated'){
	?>
	<div class="result">
			<div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>Well done!</strong> <?php echo $_SESSION['update_status_msg'];?>
            </div>
	</div>
	<?php }else{ ?> 
	
	<div class="result">
			<div class="alert alert-danger">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>Opps!</strong> <?php echo $_SESSION['update_status_msg'];?>
            </div>
	</div>
	
	<?php } 
	unset($_SESSION['update_status']);
	} ?>
	
     <div class="row" style="background:white;padding:30px;padding-bottom:0px;padding-top:0px"> 	
		
	<div class="col-sm-4" style="margin-right:0px">
       <div class="cardwrapper"> 
		    
		   <div class="col-sm-12">
			 <ul class="leftcard_ul">
				  <a href="<?php echo site_url();?>/mybuyerdashboard">
				   <li ><span class="cart_pic"><i class="fa fa-dashboard" aria-hidden="true"></i></span>My Dashboard</li>
					</a>
				  <a href="<?php echo site_url();?>/topup">
				    <li><span class="cart_pic"><i class="fa fa-sliders" aria-hidden="true"></i></span>Topup</li>
				</a>	  
				  <a href="<?php echo site_url();?>/tickets">
				   <li ><span class="cart_pic"><i class="fa fa-cart-plus" aria-hidden="true"></i></span>My Tickets</li>
				 </a>
				  
				  <a href="<?php echo site_url();?>/notification">
				   <li><span class="cart_pic"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>Notifications</li>
				 </a>	  
				  
				  <a href="<?php echo site_url();?>/newcharity">
				  <li><span class="cart_pic"><i class="fa fa-money" aria-hidden="true"></i></span>Charity</li>
				</a>	  
			      
				  <a href="<?php echo site_url();?>/myaccountnew">
				   <li ><span class="cart_pic"><i class="fa fa-sliders" aria-hidden="true"></i></span>Settings</li>
				</a>
				  <a href="<?php echo site_url();?>/withdrawal">
				  	  <li class="active-menu"><span class="cart_pic"><i class="fa fa-money" aria-hidden="true"></i></span>Withdrawal</li>
					</a>  
				 <a href="<?php echo site_url();?>/logout">
				   <li><span class="cart_pic"><i class="fa fa-lock" aria-hidden="true"></i></span>Logout</li>
				</a>	 
			   </ul>
			 
		   </div>
             
		</div> 
	</div>
			 <!----center container--->
	<div class="col-sm-8 ">
          <div class="maincontainer_wrapper">
			
			  
			  <div class="col-sm-12 username_div" style="margin-left:0px">
			  <form method="post" id="userform" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
				  	 <input type='hidden' value='my_simple_form' name='action'> 
				  	<input type="hidden" value="<?php echo $current_url;?>" name="return_url">
				  	 <input type='hidden' value='<?php echo $user_details->ID; ?>' name='userid'>
				  	<input type='hidden' value='<?php echo ($get_other_user_info != "") ? $get_other_user_info->id : "" ; ?>'> 
				  <?php
				  global $wpdb;
					$userdetails = wp_get_current_user();

					 $user =  $userdetails->ID;
							
				  $balance = $wpdb->get_var("SELECT SUM(price) as balance FROM `PQrlH_transactions` where user_id = $user");
				  
				  $myusereamil2=$wpdb->get_row("SELECT * FROM `payment` where u_id = $user");
				  
				
				  $balance;
				  ?>
				
				  <label>Balance in your Account</label>
				<input type="text" value="<?php echo number_format($balance,2);?>" name="balanceamount"  class="form-control balanceamount" readonly>
				  <input type="hidden" value="<?php echo $user ?>" name="myuserid">    
				  
					<label>Enter Withdrawal Amount</label>
					<input type="text" value="" name="amount"  placeholder="Enter Amount" class="form-control newamount">
				  
				   <label for="exampleFormControlSelect1">Payment gateway</label>
					<select class="form-control newpaymentgatewaydropdown" name="gatewaymethod">
					  <option value="">Select Payment gateway</option>
					   <option value="Payoneer" <?php if($myusereamil2->paymentgateway=="Payoneer"){ echo "selected"; } ?> >Payoneer</option>
					  <option value="Paypal" <?php if($myusereamil2->paymentgateway=="Paypal"){ echo "selected"; } ?>>Paypal</option>
					  <option value="Stripe" <?php if($myusereamil2->paymentgateway=="Stripe"){ echo "selected"; } ?>>Stripe</option>
					</select>
				  
				  <div class="emailsection" style="display:none">
				  <label>Enter Email</label>
					<input type="email" value="<?php echo $myusereamil2->email ?>" name="email"  placeholder="Enter Email" class="form-control newemail">
				  </div>
			
					<button type="submit" class="btn btn-primary">Submit</button>

			</form>
		
			  
			  </div> 
		     
		</div>
     </div>
	
	</div>
	

	
</div>

<script>
jQuery(document).ready(function($) {
$(document).ready(function(){
	 $('.newpaymentgatewaydropdown').change(function(){
	   var paymetgateway=$('.newpaymentgatewaydropdown').val();
		if(paymetgateway!="")
		{
			 $('.emailsection').show();
		}else
		{
		 $('.emailsection').hide();	
		}
	 });
	});
	
 $(document).on('submit','#userform',function(){
	 var balanceamount=Number($('.balanceamount').val());
	 // alert(typeof(balanceamount));
	 var newamount=Number($('.newamount').val());
	 //alert(typeof(newamount));
	 var newemail=$('.newemail').val();
	var newpaymentgatewaydropdown=$('.newpaymentgatewaydropdown').val(); 
	 if(newamount>balanceamount)
	 {
		 alert("Withdrawal Amount cannot be greater than available balance ");
		 return false;
	 }else if(newemail=="" || newpaymentgatewaydropdown=="" || newamount=="")
	 {
		alert("Please Enter Correct Data");
		 return false; 
	 }else{
	  $(this).submit();
	 }
	 
	 
 });	
	
});
</script>	

<?php
 get_footer();
						   }else{
	wp_redirect(home_url('/sign-in/'));
	exit;
}
?>