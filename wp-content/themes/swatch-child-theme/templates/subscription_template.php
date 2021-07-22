<?php
/* Template Name: Subscription Template */
get_header();
global $wpdb;
$user_details = wp_get_current_user();
$userid = $user_details->ID;

//$orders = $wpdb->get_results("SELECT * FROM `PQrlH_orders` Where user_id= $userid ORDER BY `ord_id`  DESC");

?>

<style>

	.columns1 {
  float: left;
  width: 30.3%;
  padding: 8px;
}

.price {
  list-style-type: none;
  border: 1px solid #eee;
  margin: 0;
  padding: 0;
  -webkit-transition: 0.3s;
  transition: 0.3s;
}

.price:hover {
  box-shadow: 0 8px 12px 0 rgba(0,0,0,0.2)
}

.header {
  background-color: #f0ad4e;
  color: white;
  font-size: 25px;
}
	
.header_red{
	background-color:#ec8783;
  color: white;
  font-size: 25px;
}	

.header_pink{
	background-color:#1cd6cd;
  color: white;
  font-size: 25px;
}	
	
	
.price li {
  text-align: center;
}

.subscriptionmenu{
	 padding: 20px;
	margin-top: 22px;
}	

	.newsubscription{
	 padding: 20px;
	}
.price .grey {
  background-color: #eee;
  font-size: 20px;
}

.button {
  border: 1px solid #f0ad4e;
  color: #f0ad4e;
  padding: 10px 25px;
  text-align: center;
  text-decoration: none;
  font-size: 18px;
  border-radius: 5px;
}


}

@media only screen and (max-width: 600px) {
  .columns1 {
    width: 100%;
  }
}

.pricehead{
margin-top: -1px;	
}
	
.subscriptiondetail{
font-size: 17px;
color: grey;
margin-top: -7px;
}	

.amountfont{
	font-size:41px !important;		
}

.signfont{
	font-size:16px !important;		
}

.dollarsign{
  margin-top:10px;
}

	.redbutton{
	border: 1px solid #ec8783;
  color: #ec8783;
  padding: 10px 25px;
  text-align: center;
  text-decoration: none;
  font-size: 18px;
  border-radius: 5px;	
	}
	
.pinkbutton{
	border: 1px solid #1cd6cd;
  color: #1cd6cd;
  padding: 10px 25px;
  text-align: center;
  text-decoration: none;
  font-size: 18px;
  border-radius: 5px;	
	}
	
.subscrip_heading{
	margin-bottom: 11px;
    margin-top: 38px;
}

.package_row{
margin-bottom:23px;
}
</style>
<div class="container">
	<div class="row">
		 <div class="col-sm-12">
			 <h2 class="text-center subscrip_heading">Change your Plan</h2> 
		</div>
	</div>	

	<div class="row package_row">
	<?php
		
		 $User = get_current_user_id();
				  $subscription_id = $wpdb->get_var("SELECT subsciption_id FROM `PQrlH_User_subscriptions` where user_id = $User");
	
	 $args = array(  
        'post_type' => 'winner-subscriptions',
        'post_status' => 'publish',
        'posts_per_page' => 3, 
        'orderby' => 'title', 
        'order' => 'DESC', 
    );

    $loop = new WP_Query( $args ); 
    $i = 1;
    while ( $loop->have_posts() ) : $loop->the_post(); 
		switch($i){
			case '1':
			$class="header";
			$classbtn = "button";
			break;
			case '2':
			$class="header_red";
			$classbtn = "button redbutton";
			break;
			case '3':
			$class="header_pink";
			$classbtn = "button pinkbutton";
			break;
		}
		
		if(get_the_ID() == $subscription_id){
		  $subscribe = "Subscribed";
		}else{
		  $subscribe = "Subscribe";
		}
	?>
   <div class="columns1">
	  <ul class="price">
		<li class="<?php echo $class;?> newsubscription"><?php echo get_the_title(get_the_ID());?></li>
		  <li class="<?php echo $class;?> pricehead newsubscription"><span class="signfont dollarsign">£
 </span><span class="amountfont">
<?php echo get_post_meta(get_the_ID(),'subscription_price',true);?> </span><span  class="signfont">/ mo</span></li>
		<li class="subscriptionmenu">Feature 1</li>
		<li class="subscriptiondetail"><?php echo get_post_meta(get_the_ID(),'feature_1',true); ?></li>
		<li class="subscriptionmenu">Feature 2</li>
		<li class="subscriptiondetail"><?php echo get_post_meta(get_the_ID(),'feature_2',true); ?></li> 
		<li class="subscriptionmenu">Feature 3</li>
		<li class="subscriptiondetail"><?php echo get_post_meta(get_the_ID(),'feature_3',true); ?></li>
		 <li class="subscriptionmenu">Feature 4</li>
		<li class="subscriptiondetail"><?php echo get_post_meta(get_the_ID(),'feature_4',true); ?></li>
		<li class="newsubscription"><a href="<?php echo site_url()?>/newcart?package=<?php echo get_the_ID(); ?>" class="<?php echo $classbtn;?>"><?php echo $subscribe;?></a></li>
	  </ul>
	</div>
	<?php $i++;  endwhile;?>
	</div>	

</div>

<?php
 get_footer();

?>
