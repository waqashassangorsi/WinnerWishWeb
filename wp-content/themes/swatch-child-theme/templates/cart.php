<?php
/* Template Name: Cart Raffle Template */


get_header();
$userdetails = wp_get_current_user();
$user =  $userdetails->ID;
?>
<style>

	.cart_main_detail
	{
		overflow:hidden;
		margin:50px
	}	
@media screen and (max-width: 764px) and (min-width:340px){

.item_quantity
	{
	width:100%;
	margin-top: 10px;	
	}   
	.cart_main_detail{
	margin: 2px;
	margin-top: 24px;	
	}
	
	.radiodata{
	margin-left:0px;
	}
}
@media screen and (max-width: 410px) and (min-width:340px){

.item_price
	{
	width:100%;
	}   
}	
	
</style>
<!--<button id="checkout-button">Checkout</button>-->
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    // Create an instance of the Stripe object with your publishable API key
    var stripe = Stripe("pk_test_51H4QdgGmT7c3r5SQV7rLpB2t9BbdIq7yLOxvtielUJC6WrODrynbulG8nrGJ0rBF3XVGhL5LSK5XjJ9yQcixXgiw00edN1Sxa4");
    var checkoutButton = document.getElementById("checkout-button");

    checkoutButton.addEventListener("click", function () {
      fetch("<?php echo get_stylesheet_directory_uri()?>/create-checkout-session.php", {
        method: "POST",
      })
        .then(function (response) {
          return response.json();
        })
        .then(function (session) {
          return stripe.redirectToCheckout({ sessionId: session.id });
        })
        .then(function (result) {
          // If redirectToCheckout fails due to a browser or network
          // error, you should display the localized error message to your
          // customer using error.message.
          if (result.error) {
            alert(result.error.message);
          }
        })
        .catch(function (error) {
          console.error("Error:", error);
        });
    });
  </script>
 
<?php 
if(isset($_GET['package']) && $_GET['package'] != "" && is_numeric($_GET['package'])) {
	$subscription_package =  $_GET['package']; ?>
<div class='cart_details cart_main_detail'>
<input type='hidden' name='package_id' id='package_id' value="<?php echo $subscription_package; ?>">
	<div class='col-sw-6 cartmaincon'>
		<div class='cart_items'>
			
			<div class='single_item' data-itemid="<?php echo $subscription_package;?>">
				<div class='single_item_detail'>
					
					<div class='item_detail' style="width:100%">
						<h3><?php echo get_the_title($subscription_package);?> </h3>
						<div class='price_quantity'>
							<div class='item_price'>
								<p><b>  Price </b></p>
							</div>
							<div class='item_quantity'>
								<p style='margin-top:3px;font-size:24px'> £ <?php echo get_post_meta($subscription_package,'subscription_price',true);?> </p>
							</div>
						</div>
						
						<div class='security_question' style='margin-top:12px'>
							<p><?php echo get_post_meta($subscription_package,'subscription_content',true);?> </p>
							<p><b>Feature 1 </b></p>
							<p><?php echo get_post_meta($subscription_package,'feature_1',true);?> </p>
							<p><b>Feature 2 </b></p>
							<p><?php echo get_post_meta($subscription_package,'feature_2',true);?> </p>
							<p><b>Feature 3 </b></p>
							<p><?php echo get_post_meta($subscription_package,'feature_3',true);?> </p>
							<p><b>Feature 4 </b></p>
							<p><?php echo get_post_meta($subscription_package,'feature_4',true);?> </p>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class='col-sw-4 cartmaincon'>
		<div class='col-sw-12'>
		  <div class="cartpayment">
			<div class="col-sw-5">
			   <h4 class="font_white"> Order:OSE9N</h4>
				<!--<p>	<small>Payment Fee : <?php echo $percent;?> </small> </p>-->
			 </div>
			<div class="col-sw-5 cartpayment1">
			   <h4 class="font_white tot_price"><?php   get_post_meta($subscription_package,'subscription_price',true);?>      <span class="gbpfont"> GBP </span><span id="old_price"><?php echo  get_post_meta($subscription_package,'subscription_price',true);?></span></h4>
			 </div>
		  </div>
		  
		  <div class="form_display">
							<!--<div class="voucher_div">
							
								<label><strong>Voucher Code <small style="color:red">( if any )</small></strong></label>
								<input type="text" class='voucher_code' placeholder="Enter Voucher code..." style="border:1px solid gainsboro">
								<span class="loader_voucher"></span>

						    </div>-->
			  
			  				<div class='methods'>
			 				 <p> Choose payment option</p>
			  				<!--<label class="radio inline"> 
							  <input type="radio" id="balance" class='paymnet_method_subscribe' name='answer' data-userid="<?php echo $user;?>" value="balance"> Balance
							</label>-->
			  				<label class="radio inline">
							  <input type="radio" id="paypal" class='paymnet_method_subscribe' name='answer' data-userid="<?php echo $user;?>" value="paypal"> Paypal
							</label>
			  				<label class="radio inline">
							  <input type="radio" id="cards" class='paymnet_method_subscribe' data-userid="<?php echo $user;?>" name='answer' value="cards"> Cards
							</label>
			  				</div>
			  <?php
			  if ( is_user_logged_in() ) {
				   // your code for logged in user 
			  ?>
			 <div class="methods_type">
			 <div class="payment_method_cards" style="display:none"> 
				 <?php
	
				//echo apply_filters( 'simpay_form_1507_amount', $total );
	
				//echo do_shortcode('[simpay id="1507"]');
				 
				 
				 ?>
				 <div class="option_cards">
					 
				 </div>
				 
				 <div class = "new_card_option" style="display:none">
				 <div id="error-message" style="color:red"></div>
				
                    <div class="col-sm-4 col-xs-12">
                        <h6>Card Number</h6>
                        <div id="card_number" class="form-control"></div> 
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <h6>Expiration Date</h6>
                        <div id="card_expiry" class="form-control"></div>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <h6>Security Code</h6>
                        <div id="card_cvc" lass="form-control"></div>
                    </div>
				 	<br>
				 </div>
				 <button type="submit" class="checkoutbtncart btn btn-default checkoutbtnSubscription">Checkout</button>
			  </div>
			  <div class="payment_method_paypal" style="display:none">
				 <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="balance_paypal_form">
					<input type="hidden" name="item_number" value="<?php echo $subscription_package;?>">
									<input type='hidden' name='item_name' value='subscription'> 
									<input type='hidden' name='userid' value='<?php echo $user;?>'> 
									<input type="hidden" name="currency_code" value="GBP">
					 				<input type="hidden" name="amount" value="<?php echo  get_post_meta($subscription_package,'subscription_price',true);?>">
									<input type="hidden" name="business" value="winnerwish-business@gmail.com">
									<input type="hidden" name="cancel_url" value="<?php echo site_url();?>">
									 <input type="hidden" name="cmd" value="_xclick"> 
									<input type="hidden" name="return" value="<?php echo site_url();?>/confirmation">
									<input type="hidden" name="notify_url" value="<?php echo site_url();?>/?action=winner_IPN">
				  <button type="submit" class="checkoutbtncart btn btn-default">Checkout</button>
				  </form>
			  </div>
			  <div class="payment_method_balance" style="display:none">
				  <?php
				  if(is_user_logged_in()){
				  	global $wpdb;
					$userdetails = wp_get_current_user();

					 $user =  $userdetails->ID;
							
				  	$balance = $wpdb->get_var("SELECT SUM(price) as balance FROM `PQrlH_transactions` where user_id = $user");
				  }else{
				  
					  $balance = 0;
				  
				  }
				  
				  ?>
				  
				  <button type="button" data-balance="<?php echo $balance;?>" class="checkoutbtncart btn btn-default btn-balance">Checkout</button>
				  <p class='error_balance'> </p>
			  </div>
			  
			</div>
			  <?php }else{ ?>
			  
			  <a href="/signin/" class="btn btn-primary"> Please Login to Proceed</a>
			  
			  <?php } ?>
		  </div>

		</div>
	</div>

	


</div>
	
<?php	
}else{

if(isset($_SESSION['cart'])){
	
	if(count($_SESSION['cart']) <= 0  ) {   ?>

<section class="jumbotron text-center" style='min-height:400px;padding:40px'>
    <div class="container">
        <h1 class="jumbotron-heading">Your - CART</h1>
		<br>
		<h4> Cart is empty! Go to <a href="<?php echo site_url();?>" style='color:#ec8783'> Competitions </a> </h4>
     </div>
</section>

<?php }else{  ?>
<div class='cart_details cart_main_detail'>

	<div class='col-sw-6 cartmaincon'>
		<div class='cart_items'>
			<?php 
			$total_order = 0 ;
			$j = 1;
		      foreach($_SESSION['cart'] as $key=>$item){
				 // echo get_post_meta($key,'price_of_single_ticket',true);
				  //print_r(get_post_meta($key));
				  
				  $total_order += $item['quantity'] * get_post_meta($key,'price_of_single_ticket',true);
				  
				  if($j > 4){
					  $j = 1;
				  }
			?>
			<div class='single_item' data-itemid="<?php echo $key;?>">
				<div class='single_item_detail'>
					<div class='item_img'>
					  	<div class='img-box-<?php echo $j; ?>'> 
						 <p class='img_heading' style="background:#2a9df4;"> <?php echo get_the_title($key);?> </p>
						 <img src ='<?php echo wp_get_attachment_url(get_post_meta($key,'raffle_thumbnail_image',true));?>' width='100%'>
						
						</div>
					</div>
					<div class='item_detail'>
					
						<div class='price_quantity'>
							<div class='item_price'>
								<p><strong> £ <?php echo get_post_meta($key,'price_of_single_ticket',true);?>  </strong></p>
							</div>
							<div class='item_quantity'>
								<label><strong> Quantity </strong>  </label> 
								<select name='quantity' class='quantity'>
								<option  data-element="<?php echo $key;?>" value"0">0</option>
									<?php 
				  					
				  
									$mn = get_post_meta($key,'minimum_entry',true);
				  					$total = get_post_meta($key,'total_entries',true);
									for($i = 1 ;$i <= 10; $i++){
										$v = $mn*$i;
										if($v == $item['quantity']){
											$select = "selected";
										}else{
											$select= "";
										}
										?>
								    <option data-element="<?php echo $key;?>" <?php echo $select;?> value='<?php echo $v;?>'><?php echo $v;?></option>
									<?php } ?>
								</select>
								<span class="loader"></span>
							</div>
						</div>
						
						<div class='security_question'>
							<div class='question'>
								<p> <?php echo get_post_meta($key,'add_security_question',true);?> </p>
							</div>
							<div class='answer'>
							<?php
				  			for($i = 1;$i<=3;$i++){
				  			?>
							<label class="radio inline radiodata" style="margin-left:0 !important;">
							  <input type="radio" id="inlineCheckbox<?php echo $i;?>" class='security_quest' name='answer-<?php echo $key;?>' value="<?php echo get_post_meta($key,'answer_'.$i,true);?>"> <?php echo get_post_meta($key,'answer_'.$i,true);?>
							</label>
							<?php } ?>
							<input type='hidden' value='<?php echo get_post_meta($key,'answer_correct',true);?>' id='correct'>
								<p class='answer_status'></p>
							</div>
						</div>
						
					</div>
				</div>
			</div>
			<?php 
			$j++;
			  }
			
			?>
		</div>
	</div>

	<div class='col-sw-4 cartmaincon'>
		<div class='col-sw-12'>
		<?php 
			//$percent = (5*$total_order/100);
			//$total_order_with_fee = $total_order + (5*$total_order/100);
			
		?>
		  <div class="cartpayment">
			<div class="col-sw-5">
			   <h4 class="font_white"> Order:OSE9N</h4>
				<!--<p>	<small>Payment Fee : <?php echo $percent;?> </small> </p>-->
			 </div>
			<div class="col-sw-5 cartpayment1">
			   <h4 class="font_white tot_price"><?php   $total_order;?>      <span class="gbpfont"> GBP </span><span id="old_price"><?php echo  $total_order; ?></span></h4>
			 </div>
		  </div>
		  
		  <div class="form_display">
							<div class="voucher_div">
							
								<label><strong>Voucher Code <small style="color:red">( if any )</small></strong></label>
								<input type="text" class='voucher_code' placeholder="Enter Voucher code..." style="border:1px solid gainsboro">
								<span class="loader_voucher"></span>

						    </div>
			  
			  				<div class='methods'>
			 				 <p> Choose payment option</p>
			  				<label class="radio inline"> 
							  <input type="radio" id="balance" class='paymnet_method' name='answer' data-userid="<?php echo $user;?>" value="balance"> Balance
							</label>
			  				<label class="radio inline">
							  <input type="radio" id="paypal" class='paymnet_method' name='answer' data-userid="<?php echo $user;?>" value="paypal"> Paypal
							</label>
			  				<label class="radio inline">
							  <input type="radio" id="cards" class='paymnet_method' data-userid="<?php echo $user;?>" name='answer' value="cards"> Cards
							</label>
			  </div>
			  <?php
			  if ( is_user_logged_in() ) {
				   // your code for logged in user 
			  ?>
			 <div class="methods_type">
			 <div class="payment_method_cards" style="display:none"> 
				 <?php
	
				//echo apply_filters( 'simpay_form_1507_amount', $total );
	
				//echo do_shortcode('[simpay id="1507"]');
				 
				 
				 ?>
				 <div class="option_cards">
					 
				 </div>
				 
				 <div class = "new_card_option" style="display:none">
				 <div id="error-message" style="color:red"></div>
				
                    <div class="col-sm-4 col-xs-12">
                        <h6>Card Number</h6>
                        <div id="card_number" class="form-control"></div> 
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <h6>Expiration Date</h6>
                        <div id="card_expiry" class="form-control"></div>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <h6>Security Code</h6>
                        <div id="card_cvc" lass="form-control"></div>
                    </div>
				 	<br>
				 </div>
				 <button type="submit" class="checkoutbtncart btn btn-default checkbtncard">Checkout</button>
			  </div>
			  <div class="payment_method_paypal" style="display:none">
				  <?php //echo do_shortcode('[wpecpp name="ab" price="'.$total.'" align="left"]');?>
				  <button type="submit" class="checkoutbtncart btn btn-default checkbtn">Checkout</button>
			  </div>
			  <div class="payment_method_balance" style="display:none">
				  <?php
				  if(is_user_logged_in()){
				  	global $wpdb;
					$userdetails = wp_get_current_user();

					 $user =  $userdetails->ID;
							
				  	$balance = $wpdb->get_var("SELECT SUM(price) as balance FROM `PQrlH_transactions` where user_id = $user");
				  }else{
				  
					  $balance = 0;
				  
				  }
				  
				  ?>
				  
				  <button type="button" data-balance="<?php echo $balance;?>" class="checkoutbtncart btn btn-default btn-balance">Checkout</button>
				  <p class='error_balance'> </p>
			  </div>
			  
			</div>
			  <?php }else{ ?>
			  
			  <a href="/signin/" class="btn btn-primary"> Please Login to Proceed</a>
			  
			  <?php } ?>
		  </div>

		</div>
	</div>

	


</div>


<?php 
} }else{ ?>
<section class="jumbotron text-center" style='min-height:400px;padding:40px'>
    <div class="container">
        <h1 class="jumbotron-heading">Your - CART</h1>
		<br>
		<h4> Cart is empty! Go to <a href="<?php echo site_url();?>" style='color:#ec8783'> Competitions </a> </h4>
     </div>
</section>
<?php } }
get_footer();

?>