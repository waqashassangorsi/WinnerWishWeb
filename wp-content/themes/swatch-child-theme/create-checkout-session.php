<?php
session_start();
require_once('libs/stripe/init.php');
\Stripe\Stripe::setApiKey('sk_test_51H4QdgGmT7c3r5SQbt2GrPhzrLa1WMp7my7B9YsBAS0biYPV5cwYuxuuto5DumbhzfuhTo3WKCBsRDW19tDZJKuY00Xrrsauzm');

header('Content-Type: application/json');

$YOUR_DOMAIN = 'https://winnerswish.com/';
$data = json_decode(file_get_contents('php://input'), true);
$lottires = $data['lottries'];
$security_ans = $data['security_ans'];
$voucher = $data['voucher'];
$total = $data['total'];
$order_detail = $data['order_detail'];

$payment_method = $data['payment_method'];
global $wpdb;
$userdetails = wp_get_current_user();
//$user =  $userdetails->ID;
//$user_email =  $userdetails->user_email;
	print_r($lottires);
	die;
	//$user  =  get_current_user_id();
	
	$single_price = 0;
	foreach($_SESSION['cart'] as $key=>$val){
		$single =  get_post_meta($key,'price_of_single_ticket',true);
		$single_price += $single*$val['quantity'];
		$charity = $val['charity'];
	}
	
	if(get_user_meta( $user, 'charity',true) == ""){
	add_user_meta( $user, 'charity', $charity ,true );
	}
	
	if($voucher == ""){
		$subtotal = $single_price;
	    $total = $single_price;
	}else{
		
		$subtotal  = $single_price;
		$voucher = $wpdb->get_row("SELECT * FROM `pqrlh_vouchers` where vlimit != voucher_usage AND vexpiry > NOW() AND vname = '$voucher'");
		$total =  $subtotal - ($subtotal * $voucher->vprice) / 100 ;
		
		$update = $wpdb->update("Update pqrlh_vouchers SET voucher_usage = voucher_usage + 1 WHERE vname='$voucher'");
		
	}
	   $lottires = trim($lottries,',');
	   $security_ans = trim($security_ans,',');
	   $insert = $wpdb->insert('PQrlH_orders',array(
		   'total_price'=>$total,
		   'sub_total'=>$subtotal,
		   'user_id'=>$user,
		   'lotteries'=>$lottires,
		   'lotteries_answers'=>$security_ans,
		   'payment_method'=>$payment_method,
		   'status'=>'pending'
	   ));
	if($insert){
		
		$lastid = $wpdb->insert_id;
		
		foreach($order_detail as $order){
			
			$lottry_id = $order['lottry_id'];
			$sec_answer = $order['sec_answer'];
			$query = "INSERT INTO PQrlH_order_details (`order_id`,`ticket`,`lottery_id`,`security_question`) values";
			for($i = 1 ; $i<= $order['quantity'];$i++){
				
				$ticket = "WW-".$user.generateRandomString(4);
				$query .="($lastid,'$ticket',$lottry_id,'$sec_answer'),";
				
			}
			 $query = trim($query,',');
			
			if($wpdb->query($query)){
				
				if($voucher != ""){
					
					$wpdb->insert('PQrlH_voucher_usage',array('voucher_id'=>$voucher->vid,'voucher_price'=>$voucher->vprice,'order_id'=>$lastid,'user_id'=>$user));
				}
				
				$status = true;
			}else{
				$status = false;
			}

		}
	}
	
$checkout_session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'line_items' => [[
    'price_data' => [
      'currency' => 'usd',
      'unit_amount' => 2000,
      'product_data' => [
        'name' => 'Stubborn Attachments',
        'images' => ["https://i.imgur.com/EHyR2nP.png"],
      ],
    ],
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . '/success.html',
  'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
]);

echo json_encode(['id' => $checkout_session->id]);