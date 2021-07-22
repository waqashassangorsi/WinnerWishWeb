<?php
/* Template Name: Charity Template */
get_header();
if(is_user_logged_in()){
global $wpdb;
$user_details = wp_get_current_user();
$userid = $user_details->ID;

$orders = $wpdb->get_results("SELECT * FROM `PQrlH_orders` Where user_id= $userid ORDER BY `ord_id`  DESC");
$current_url = home_url(add_query_arg(array($_GET), $wp->request));
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
	float:left;
		padding-bottom:0px;
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
				    <li><span class="cart_pic"><i class="fa fa-sliders" aria-hidden="true"></i></span>Topup</li>
				</a>	  
				  <a href="<?php echo site_url();?>/tickets">
				   <li><span class="cart_pic"><i class="fa fa-cart-plus" aria-hidden="true"></i></span>My Tickets</li>
				 </a>
				  
				  <a href="<?php echo site_url();?>/notification">
				   <li><span class="cart_pic"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>Notifications</li>
				 </a>	  
				  
				  <a href="<?php echo site_url();?>/newcharity">
				  <li class="active-menu"><span class="cart_pic"><i class="fa fa-money" aria-hidden="true"></i></span>Charity</li>
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
					  <h2 style="text-transform: inherit;">Charity</h2>
				  </div>

				  <div class="col-sm-12 username_div invoicee_detailse_wapr" style="margin-left:0px;min-height:300px">
					  <form id="charity_setting_form"  method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
				  			<input type='hidden' value='charity_setting' name='action'> 
				  			<input type="hidden" value="<?php echo $current_url;?>" name="return_url">
						  <label> Choose Your Charity</label>
						  <select class="charity_category" name="charity_category" required>
							  <option value="" >Select Charity</option>
							   <?php
						$taxonomy     = 'charity_category';
						$orderby      = 'name';  
						$show_count   = 0;      // 1 for yes, 0 for no
						$pad_counts   = 0;      // 1 for yes, 0 for no
						$hierarchical = 1;      // 1 for yes, 0 for no  
						$title        = '';  
						$empty        = 0;

						$args = array(
							'taxonomy'     => $taxonomy,
							'orderby'      => $orderby,
							'show_count'   => $show_count,
							'pad_counts'   => $pad_counts,
							'hierarchical' => $hierarchical,
							'title_li'     => $title,
							'hide_empty'   => $empty
						);
						$all_categories = get_categories( $args );
						foreach ($all_categories as $cat) {
						if($cat->category_parent == 0 ) {
							
							$category_id = $cat->term_id; 
							if($category_id == get_user_meta( $userid, 'charity',true)){
							$select  = "selected";
							}else{
							$select="";
							}  
							  ?>
							  
							  <option <?php echo $select;?> value="<?php echo $category_id;?>" ><?php echo $cat->name;?></option>
							<?php } } ?>
						  </select>
						  <input type="submit" value="Apply" name="apply">
					  </form>
					  
					  <div>
						  <p style="color:red"> <?php echo ( (get_user_meta( $userid, 'charity',true)) == "" ) ? "" : "Applied" ;?></p>
						  
					  </div>
					  
					  
				  </div> 

			</div>
		 </div>	
	</div>
</div>

<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<?php
 get_footer();
}else{
	wp_redirect(home_url('/sign-in/'));
	exit;
}
?>
