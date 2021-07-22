<?php
/* Template Name: TopUp Template */
get_header();
if(is_user_logged_in()){
global $wpdb;
$user_details = wp_get_current_user();
$userid = $user_details->ID;

//$orders = $wpdb->get_results("SELECT * FROM `PQrlH_orders` Where user_id= $userid ORDER BY `ord_id`  DESC");

?>

<link href="https://maxcdtrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" rel="stylesheet">

<link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet">

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
	.balance_form_credit{
	position:relative;display:none;min-height:300px;width:100%;
	}
    .cart_pic{
	  margin-right:11px;
	}
	.col-sm-4
	{
	width: 20%;
    float: left;
	}
	.col-sm-8 {
	width:80%;
	padding:26px;
		padding-top:0px;
	box-sizing:border-box;
	float:left
	}

	.expand{
	cursor: pointer;
background: green;
border-radius: 25px;
padding: 2px 6px;
color: white;
font-weight: 600;
	}
	
	.leftcard_ul
	{
		list-style-type:none;
		background: #e9ecef;
   		 margin: 0px;
		min-height:300px;
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
     .col-sm-4,.balance_form_credit{
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
		padding-top: 12px;
		}	
}
	

	.container_margintop{
	margin-top:27px;
	}
	a{
	color:black;
	}
	.container{
	padding:5px;
	}
	@media screen and (max-width: 978px) and (min-width:340px){
.invoicee_detailse_wapr{
        overflow-x: auto!important;
        width: 93%!important;
    }
    .invoicee_detailse{
        width: 517px!important;
        overflow-x: auto!important;
    }
    
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
.strippay
		{
		width: 96% !important;
		}
    
}
	
	.paypalamount:focus,.newamount:focus,.newpaymentgatewaydropdown:focus,.newemail:focus{
	box-shadow:none !important;
	}
</style>

<div class="container" style="margin-top:23px">
<div class="row heading_margin" style="margin-top:23px">
		<div class="col-sm-12">
			<h1 class="heading_center">My Account</h1>
		</div>
	</div>
</div>	

<div class="container container_margintop newcontainer">
     <div class="row" style="background:white;padding:30px;padding-bottom:0px;padding-top:0px"> 	
	<div class="col-sm-4" style="margin-right:0px">
       <div class="cardwrapper"> 
		    
		   <div class="col-sm-12">
			  <ul class="leftcard_ul">
				  <a href="<?php echo site_url();?>/mybuyerdashboard">
				   <li ><span class="cart_pic"><i class="fa fa-dashboard" aria-hidden="true"></i></span>My Dashboard</li>
					</a>
				  <a href="<?php echo site_url();?>/topup">
				    <li class="active-menu"><span class="cart_pic"><i class="fa fa-sliders" aria-hidden="true"></i></span>Topup</li>
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
				  	  <li><span class="cart_pic"><i class="fa fa-money" aria-hidden="true"></i></span>Withdrawal</li>
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

				  <div class="col-sm-12 username_div">
					  <h2 style="text-transform: initial;">Add Top Up</h2>
				  </div>

				  <div class="col-sm-12 username_div invoicee_detailse_wapr" style="margin-left:0px;min-height:300px;position:relative">
					  
					     <label class="radio inline"> 
							  <input type="radio" id="balance" class="paymnet_method_balance" name="balance"  value="balance_from_paypal"> Paypal
						 </label>
					  	<label class="radio inline"> 
							  <input type="radio" id="balance" class="paymnet_method_balance" name="balance"  value="balance_from_card"> Credit Card
						 </label>
					  		<p class='balance_error'><p>
						  <div class="balance_form" style="position:relative;display:none;min-height:300px">
								<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="balance_paypal_form">
									<input type="text" class="form-control amount_topup paypalamount" name='amount' placeholder="Enter top up price...." style="border:1px solid gainsboro">
								<input type="hidden" class='amount_topup' name="item_number" value="<?php echo $userid;?>">
									<input type='hidden' name='item_name' value='Topup Amount'> 
									<input type='hidden' name='$userid' value='<?php echo $userid;?>'> 
									<input type="hidden" name="currency_code" value="GBP">
									<input type="hidden" name="business" value="winnerwish-business@gmail.com">
									<input type="hidden" name="cancel_url" value="<?php echo site_url();?>">
									 <input type="hidden" name="cmd" value="_xclick"> 
									<input type="hidden" name="return" value="<?php echo site_url();?>/confirmation">
									<input type="hidden" name="notify_url" value="<?php echo site_url();?>/?action=winner_IPN">
							  	      <button type="submit" class="checkoutbtncart form-group btn btn-success" style="position:absolute;bottom: 30px;left: 20px;width:95% !important"> Top Up </button>
							  </form>
						  </div>
					  <div class="balance_form_credit">
						   <div class="">
								<h6>Enter Amount</h6>
				 <input type="text" class="form-control amount_topup_stripe paypalamount strippay" name='amount_topup_stripe' placeholder="Enter top up price...." style="border:1px solid gainsboro;width: 98%;">
							</div>
						  
						  <div class="">
								<h6>Card Number</h6>
								<div id="card_number" class="form-control" style="
border: 1px solid gainsboro;padding: 6px;
"></div> 
							</div>
						  
						  

							<div class="">
								<h6>Expiration Date</h6>
								<div id="card_expiry" style="
border: 1px solid gainsboro;padding: 6px;
"  class="form-control"></div>
							</div>
							<div class="">
								<h6>Security Code</h6>
								<div id="card_cvc" lass="form-control" style="
border: 1px solid gainsboro;padding: 6px;
"></div>
							</div>
						  <button type="button" class="balance_stripe form-group btn btn-success" style="/* left: 20px; */width:95% !important;margin-top: 9px;background: #ec8783 !important;"> Top Up </button>
					  </div>
					  <br><br>
					  <button type="button" class="checkoutbtncart  form-group btn btn-success btn-add_top_up" style="bottom: 30px;left: 20px;position: absolute;width:95% !important;margin-top: 9px;background: #ec8783 !important"> Top Up </button>
				  </div> 

			</div>
		 </div>	
	</div>
</div>

<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

<script>
jQuery(document).ready(function($) {
	$(function(){
  $(".paypalamount").on('input', function (e) {
    $(this).val($(this).val().replace(/[^0-9]/g, ''));
  });
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
