<?php
/* Template Name: Myaccount Template */
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
	width:90%;
	padding: 11px !important;
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
	
	.newstreet:focus,.newuser:focus{
	box-shadow:none !important;
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
				   <li class="active-menu"><span class="cart_pic"><i class="fa fa-sliders" aria-hidden="true"></i></span>Settings</li>
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
			  <ul class="rightcard_ul nav nav-tabs">
				  <li class="active"><button type="button" class='btn btn-success btn-username'>User Detail</button></li>
				  <li><button type="button"  class='btn btn-primary btn-password'>User Password</button></li>
				</ul>
			  </div>
			  
			  <div class="row username_div" style="margin-left:0px">
			  <form method="post" id="userform" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
				  	 <input type='hidden' value='update_userdetails' name='action'> 
				  	<input type="hidden" value="<?php echo $current_url;?>" name="return_url">
				  	 <input type='hidden' value='<?php echo $user_details->ID; ?>' name='userid'>
				  	<input type='hidden'  value='<?php echo ($get_other_user_info != "") ? $get_other_user_info->id : "" ; ?>' name='user_detail_id'>
				  <div class='span4'>
					<label>First Name</label>
					<input type="text" value="<?php echo $user_details->first_name; ?>" required name="first_name"  placeholder="Type something…" class="newuser form-control"></div><div class='span4'>
				  <label> SurName</label>
					<input type="text" value="<?php echo $user_details->last_name; ?>" required name="surname"  placeholder="Type something…" class="newuser form-control"></div>
				  <div class='span4'>
				    <label>Email </label>
					<input disabled type="text" value="<?php echo $user_details->user_email; ?>" required name="email" placeholder="Type something…" class="form-control">
				  </div>
				  <div class='span4'>
				    <label>Telephone </label>
					<input  type="text" required value="<?php echo get_user_meta($user_details->ID,'number_datanew2',true); ?>" name="tel_number" placeholder="Type something…" class="form-control">
				  </div>
				  <div class='span4'>
				    <label>Uk Address </label>
					<input  type="text" required value="<?php echo get_user_meta($user_details->ID,'uk_adress',true); ?>" name="uk_address" placeholder="Type something…" class="form-control">
				  </div>
				  <div class='span4'>
				    <label>Postal Code </label>
					<input  type="text" required value="<?php echo $user_details->postal_code; ?>" name="postal_code" placeholder="Type something…" class="form-control">
				  </div>
				  <div class='span12' style='margin-bottom:15px'>
					<button type="submit" class="btn btn-primary">Update Profile</button>
				  </div>
			</form>
				  
			 <form method="post" id="passwordform" style='display:none' action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
				  	 <input type='hidden' value='update_userpassword' name='action'> 
				  	<input type="hidden" value="<?php echo $current_url;?>" name="return_url">
				  	 <input type='hidden' value='<?php echo $user_details->ID; ?>' name='userid'>
				  	<input type='hidden' value='<?php echo ($get_other_user_info != "") ? $get_other_user_info->id : "" ; ?>' name='user_detail_id'>
					 <label>Current Password<span style="color:red">*</span></label>
					<input type="password" value="" name="current_password"  placeholder="Your current password" class="form-control newstreet">
				  
				    <label>New Password<span style="color:red">*</span></label>
					<input type="password" value="" name="new_pass" placeholder="Your new password" class="form-control newstreet">
				  
				  <label>Confirm Password<span style="color:red">*</span></label>
					<input type="password" name="confirm_pass" value='' placeholder="Confirm password" class="form-control newstreet">
					<button type="submit" class="btn btn-primary">Save Password</button>

			</form>
			  
			  </div> 
		     
		</div>
     </div>
	
	</div>
	

	
</div>



<?php
 get_footer();
	}else{
	wp_redirect(home_url('/signin/'));
	exit;
}
?>