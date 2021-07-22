<?php
/* Template Name: MyBuyerDashboard Template */
get_header();
$user_details = wp_get_current_user();
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
		background: #e9ecef;
   		 margin: 0px;
		min-height:300px;
	}
    .cart_pic{
	  margin-right:11px;
	}
	.col-sm-4
	{
	width: 20%;
    float: left;
    margin-right: 11%;
	}
	.col-sm-8 {
	width: 60%;
    padding: 26px;
    float: left;
	}
	
	@media (max-width: 767px){
		.col-sm-8 {
			
			padding: 0px;
			
		}
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
        padding-top: 16px; 
		}
		
		.container{
	padding:5px;
	}
}
	.package_info{
    background: #ec8783;
    padding: 6px 18px;
    color: white;
	}

	.container_margintop{
	margin-top:27px;
	}
	a{
	color:black;
	}
	
	.desc{
	font-size:18px;
	}
.username_div1
	{
	padding:10px;
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
<div class="row heading_margin" style="margin-top:23px">
		<div class="col-sm-12">
			<h1 class="heading_center">My Account</h1>
		</div>
	</div>
</div>	
<?php 
if(isset($_GET['account']) && $_GET['account'] == 'activated'){
	?>
	
<div class='container' style='margin-top:40px;'>
	<div class="alert alert-success" style='color:#fff'>
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>Brilliant</strong>  your all activated and ready to go </div>
</div><?php } ?>
<div class="container container_margintop" style="margin-bottom:60px">
     <div class="row" style="background:white;padding:30px;padding-bottom:0px;padding-top:0px"> 	
		
	<div class="col-sm-4" style="margin-right:0px">
       <div class="cardwrapper"> 
		    
		  <div class="col-sm-12">
			  <ul class="leftcard_ul">
				  <a href="<?php echo site_url();?>/mybuyerdashboard">
				   <li class="active-menu"><span class="cart_pic"><i class="fa fa-dashboard" aria-hidden="true"></i></span>My Dashboard</li>
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

				  <h2> Welcome <span style="color:#ec8783"> <?php echo $user_details->display_name;?> </span> </h2>				 

				 
					  <p class="desc">From your account dashboard,you can easily manage your tickets and account details.</p>
				  <?php
				  $User = get_current_user_id();
				  $subscription_id = $wpdb->get_var("SELECT subsciption_id FROM `PQrlH_User_subscriptions` where user_id = $User order by id desc limit 1");
				  if(empty($subscription_id)){
				      $getTitle = "None";
				  }else{
				      $getTitle = get_the_title($subscription_id);
				  }
				  
				  
				  
				  ?>
				  <p> <b> Your Current Package : </b> <span class='package_info'> <?php echo $getTitle;?> </span> <a href="<?php echo site_url()?>/subscription" style='margin-left:8px;color:#ec8783'> Upgrade ? </a> </p>

			</div>
		 </div>
	
	</div>
</div>



<?php
 get_footer();
?>
