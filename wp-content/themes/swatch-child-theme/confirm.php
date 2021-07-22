<?php

$payment_id ="";
$payment_status = "";
$userdetails = wp_get_current_user();
$user =  $userdetails->ID;




// If transaction data is available in the URL 
if(!empty($_GET['tx']) && !empty($_GET['amt']) && !empty($_GET['cc']) && !empty($_GET['st'])){ 
	$txn_id = $_GET['tx']; 
	    // Init cURL
		$request = curl_init();
		// Set request options
		curl_setopt_array($request, array
		(
		  CURLOPT_URL => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
		  CURLOPT_POST => TRUE,
		  CURLOPT_POSTFIELDS => http_build_query(array
			(
			  'cmd' => '_notify-synch',
			  'tx' => $txn_id,
			  'at' => '-b-ubQ7wluddFl3p1zSFXsfWic-2dZ18-0XHgumN5aj-P_cVxHyy_Shapva',
			)),
		  CURLOPT_RETURNTRANSFER => TRUE,
		  CURLOPT_HEADER => FALSE,
		  // CURLOPT_SSL_VERIFYPEER => TRUE,
		  // CURLOPT_CAINFO => 'cacert.pem',
		));

		// Execute request and get response and status code
		$response = curl_exec($request);
		$status   = curl_getinfo($request, CURLINFO_HTTP_CODE);
		// Close connection
		curl_close($request);
	
		if(!$response){
			//HTTP ERROR
		}else{
			 // parse the data
			$lines = explode("\n", trim($response));
			$keyarray = array();
			if (strcmp ($lines[0], "SUCCESS") == 0) {
				for ($i = 1; $i < count($lines); $i++) {
					$temp = explode("=", $lines[$i],2);
					$keyarray[urldecode($temp[0])] = urldecode($temp[1]);
				}
			// check the payment_status is Completed
			// check that txn_id has not been previously processed
			// check that receiver_email is your Primary PayPal email
			// check that payment_amount/payment_currency are correct
			// process payment
			 $item_name = $keyarray['item_name'];
			 $item_number = $keyarray['item_number'];
			 $cc = $_GET['cc'];
			 $payment_gross = $_GET['amt'];
			 $payment_status = $_GET['st']; 
				
				if($item_name == 'Topup Amount'){
					$item_name = "topup_balance";
					$item_number  = 0 ;
					$amount = "<p><b>Amount is added to your balance</b></p>";
				}else if($item_name == 'subscription'){
					$item_name = "subscription";
					$amount = "<p><b>Congrats You're now member of Winners Wish</b></p>";
				}else{
					$item_name = "order_purchase";
					 $amount = "";
					 $user = 0;
				}
				
				global $wpdb;
			// Check if transaction data exists with the same TXN ID.
		$prevPaymentResult  = $wpdb->get_results("SELECT * FROM PQrlH_transactions WHERE trans_id = '".$txn_id."'"); 

		if(count($prevPaymentResult) > 0){ 

		}else{
			// Get Order Details
			$order_from = $wpdb->get_var("select order_from from PQrlH_orders where ord_id = $item_number ");
			
			// Insert transaction data into the database 
			if($payment_status == 'Completed'){
				$payment_status = 'paid';
			}
			$insert = $wpdb->query("INSERT INTO PQrlH_transactions(trans_id,user_id,currency,price,payment_method,payment_status,order_id,payment_type,status_web) 		VALUES('".$txn_id."',$user,'".$currency_code."',$payment_gross,'paypal','".$payment_status."',$item_number,'".$item_name."','".$order_from."')"); 
			if($item_name ==  'subscription'){
				$insert_subscription = $wpdb->insert('PQrlH_User_subscriptions',array('user_id'=>$userdetails->ID,'subscription_id'=>$item_number,'transaction_id'=>$wpdb->insert_id));
			}
			if($item_name ==  'order_purchase'){
				$user =  $userdetails->ID;
			$charity =  get_user_meta($user,'charity',true);
			$insert = $wpdb->query("INSERT INTO PQrlH_transactions(trans_id,user_id,currency,price,payment_method,payment_status,order_id,payment_type,status_web) 		VALUES('".$txn_id."',$user,'".$currency_code."',(5*$payment_gross)/100,'paypal','".$payment_status."',$charity,'charity_fund',,'".$order_from."')"); 
			}

			$payment_id = $wpdb->insert_id; 
			$wpdb->update('PQrlH_orders',array("status" => "paid"),array("ord_id"=>$item_number));

		} 
				
				
				
			}
		}
}

get_header();
?>

<style>
	.image_center{
	text-align:center;
	}
	.container_margintop{
	min-height:500px;
	background:#94d9d9;	
		padding-top:50px;
		padding-bottom:50px
	}	
	.thankyou_row{
	margin-top:45px;
	}
	.go_back{
	background: white !important;
    border: 2px solid #fff;
    padding-left: 40px;
    padding-right: 40px;
    color: #ec8783 !important;
    border-radius: 12px;
    margin-top: 45px;
    padding-top: 8px;
    padding-bottom: 8px;
	}
	.thankyou_text
	{
	color:#fff;
	}
	.image_row{
	margin-top: 44px;
	}
	.envolope_image{
	/*height:200px;*/
	}
</style>
<div class="container-fluid container_margintop">

<div class="row image_row">
  <div class="col-sm-12 image_center">
    <img class="envolope_image" src="<?php echo site_url();?>/wp-content/uploads/2021/02/Group-85.svg">	
  </div> 
</div>

	<div class="row">
	  <div class="col-sm-12 image_center">
		  <p class="thankyou_text"><b>for being an important member <br> of Winners Wish Family</b></p>
		  <?php echo $amount; ?>
	  </div> 
	</div>

	<div class="row">
  <div class="col-sm-12 image_center">
   <a href="?page_id=1432" class="btn btn-large btn-primary go_back ">Go Home</a>
  </div> 
</div>

	
</div>

<?php 
get_footer();

?>