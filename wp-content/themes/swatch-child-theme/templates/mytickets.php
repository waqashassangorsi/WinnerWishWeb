<?php
/* Template Name: Mytickets Template */
get_header();
if(is_user_logged_in()){
global $wpdb;
$user_details = wp_get_current_user();
$userid = $user_details->ID;

$orders = $wpdb->get_results("SELECT * FROM `PQrlH_orders` Where user_id= $userid ORDER BY `ord_id`  DESC");

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
	.my-label{
	background: gainsboro;
    padding: 6px 18px;
    border-radius: 5px;
    margin-right: 4px;
    display: inline-block;
    margin-bottom: 6px;
    width: 97px;
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
	
	.invoicee_detailse td{
	text-align: center;
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
				   <li class="active-menu"><span class="cart_pic"><i class="fa fa-cart-plus" aria-hidden="true"></i></span>My Tickets</li>
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
					  <h2 style="text-transform: inherit;">Tickets Purchased</h2>
				  </div>

				  <div class="col-sm-12 username_div invoicee_detailse_wapr" style="margin-left:0px">
					     <table id="example" align="center" class="table text-center table-hover invoicee_detailse" style="width:100%">
						<thead>
							<tr>
								<th></th>
								<th>Competition Name</th>
								<th>#ID</th>
								<th>Tickets Purchased</th>
								<th>Date Purchased</th>
								<th>Date of Draw</th> 
								<th>Cost Per Ticket</th> 
							</tr>
							
						</thead>
						<tbody>
							<?php 
							
							if(count($orders) > 0){
							foreach($orders as $ord){
								
								$lottery = explode(",",$ord->lotteries);
								$order  = $ord->ord_id;
								foreach($lottery as $lot){
									//echo "SELECT * from PQrlH_order_details where order_id  = $order and lottery_id = $lot";
								  $order_tickets  = $wpdb->get_results("SELECT * from PQrlH_order_details where order_id  = $order and lottery_id = $lot ");
								  $tickets = "";	
								  $purchase_tick = 0;
								 if(count($order_tickets) > 0 ){
									
									 foreach($order_tickets as $ticket){
										$purchase_tick +=1; 
								 		$tickets .= "<span class='my-label'>".$ticket->ticket."</span>";
									}
								 }else{
								 
								 	$tickets = "No tickets awarded";
								 }
									//echo $tickets;
							?>
							<tr>
								
								<td> <span class="expand" data-lottery="<?php echo $ord->ord_id.$lot;?>"> + </span></td>
								<td><?php echo get_the_title($lot);?> </td>
								<td>#LOT_<?php echo $ord->ord_id;?></td>
								<td><?php echo $purchase_tick;?></td>
								<td><?php echo date("d , M Y H:i A",strtotime($ord->date_time));?></td>
								<td><?php echo date('F j, Y',strtotime(get_post_meta($lot,'date_of_draw',true)));?> </td>
								 <td><?php echo "£ ".get_post_meta($lot,'price_of_single_ticket',true);?></td>

							</tr>
							
							
							<tr class="tickets_<?php echo $ord->ord_id.$lot;?>" style="display:none"><td colspan="7"><?php echo $tickets;?></td></tr>
							
							<?php } } }else{ ?>
							<tr><td colspan="7">No Orders Yet!</td></tr>
							<?php } ?>
						</tbody>
					</table>

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
