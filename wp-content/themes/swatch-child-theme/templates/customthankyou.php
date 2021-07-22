<?php
/* Template Name: Thankyou Template */
get_header();

// Set your secret key. Remember to switch to your live secret key in production.
// See your keys here: https://dashboard.stripe.com/apikeys
\Stripe\Stripe::setApiKey('sk_test_51H4QdgGmT7c3r5SQbt2GrPhzrLa1WMp7my7B9YsBAS0biYPV5cwYuxuuto5DumbhzfuhTo3WKCBsRDW19tDZJKuY00Xrrsauzm');

// You can find your endpoint's secret in your webhook settings
$endpoint_secret = 'whsec_oaWkyoABiA1SQTePIgQjA6BUl5zg09ZO';

$payload = @file_get_contents('php://input');
if(isset($_SERVER['HTTP_STRIPE_SIGNATURE'])){
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
}else{
	$sig_header = "";
}
$event = null;

try {
  $event = \Stripe\Webhook::constructEvent(
    $payload, $sig_header, $endpoint_secret
  );
} catch(\UnexpectedValueException $e) {
  // Invalid payload
  http_response_code(400);
  echo "Invalid payload";
  exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
  // Invalid signature
  http_response_code(400);
  //echo "Invalid signature";
  //exit();
}

function fulfill_order($session) {
  // TODO: fill me in
 
}

function create_order($session) {
  // TODO fill me in
}

function email_customer_about_failed_payment($session) {
  // TODO fill me in
}

// Handle the checkout.session.completed event
if ($event->type == 'checkout.session.completed') {
  $session = $event->data->object;
  $myfile = fopen("newfileNowUpdatetxt", "w") or die("Unable to open file!");
		$txt = json_encode($session);
        fwrite($myfile, $session);
          $meta = $session->metadata;
				$amount = ($session->amount_total)/100;
				$charity = get_user_meta( $meta->userid, 'charity',true);
                // Insert tansaction data into the database 
				if($meta->type == 'subscription'){
					$type = 'subscription';
				}else{
				    $type = 'order_purchase';
				}
                $transaction = array(
					"trans_id"=> $session->payment_intent,
					"currency"=>'gbp',
					"price"=>$amount,
					'user_id'=>0,
					"payment_method"=>"cards",
					"payment_status"=>$session->payment_status,
					"order_id"=>$meta->order_id,
					"payment_type"=>$type
				);
				$insert_main =$wpdb->insert('PQrlH_transactions',$transaction);
				if($type == 'order_purchase'){					
					 $transaction = array(
						"trans_id"=> $session->payment_intent,
						"currency"=>'gbp',
						"price"=>(5*$amount)/100,
						"payment_method"=>"cards",
						'user_id'=>$meta->userid,
						"payment_status"=>$session->payment_status,
						"order_id"=>$charity,
						"payment_type"=>'charity_fund'
					);
					$insert_charity =$wpdb->insert('PQrlH_transactions',$transaction);
				}else if($type == 'subscription'){
					$lastid = $wpdb->insert_id;
				    $insert_subscription =$wpdb->insert('PQrlH_User_subscriptions',array('user_id'=>$meta->userid,'subsciption_id'=>$meta->order_id,'transaction_id'=>$lastid)); 
				}
}
switch ($event->type) {
  case 'checkout.session.completed':
    $session = $event->data->object;
	$myfile = fopen("newfileNowUpdatetxt", "w") or die("Unable to open file!");
		$txt = json_encode($session);
             fwrite($myfile, $txt);
				
    // Save an order in your database, marked as 'awaiting payment'
    //create_order($session);

    // Check if the order is paid (e.g., from a card payment)
    //
    // A delayed notification payment will have an `unpaid` status, as
    // you're still waiting for funds to be transferred from the customer's
    // account.
    if ($session->payment_status == 'paid') {
      // Fulfill the purchase
      //fulfill_order($session);
    }

    break;

  case 'checkout.session.async_payment_succeeded':
    $session = $event->data->object;

    // Fulfill the purchase
    //fulfill_order($session);

    break;

  case 'checkout.session.async_payment_failed':
    $session = $event->data->object;

    // Send an email to the customer asking them to retry their order
   // email_customer_about_failed_payment($session);

    break;
}


/// stripe end

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
	  </div> 
	</div>

	<div class="row">
  <div class="col-sm-12 image_center">
   <a href="<?php echo site_url()?>" class="btn btn-large btn-primary go_back ">Go Home</a>
  </div> 
</div>

	
</div>
<?php
 get_footer();
?>