<?php 
require_once("../../../wp-load.php");
/* 
 * Read POST data 
 * reading posted data directly from $_POST causes serialization 
 * issues with array data in POST. 
 * Reading raw POST data from input stream instead. 
 */         
$raw_post_data = file_get_contents('php://input'); 
$raw_post_array = explode('&', $raw_post_data); 
$myPost = array(); 
foreach ($raw_post_array as $keyval) { 
    $keyval = explode ('=', $keyval); 
    if (count($keyval) == 2) 
        $myPost[$keyval[0]] = urldecode($keyval[1]); 
} 

 
// Read the post from PayPal system and add 'cmd' 
$req = 'cmd=_notify-validate'; 
if(function_exists('get_magic_quotes_gpc')) { 
    $get_magic_quotes_exists = true; 
} 
foreach ($myPost as $key => $value) { 
    if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
        $value = urlencode(stripslashes($value)); 
    } else { 
        $value = urlencode($value); 
    } 
    $req .= "&$key=$value"; 
} 
 
/* 
 * Post IPN data back to PayPal to validate the IPN data is genuine 
 * Without this step anyone can fake IPN data 
 */ 
$paypalURL = PAYPAL_URL; 
$ch = curl_init($paypalURL); 
if ($ch == FALSE) { 
    return FALSE; 
} 
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1); 
curl_setopt($ch, CURLOPT_POST, 1); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $req); 
curl_setopt($ch, CURLOPT_SSLVERSION, 6); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1); 
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); 
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1); 
 
// Set TCP timeout to 30 seconds 
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: company-name')); 
$res = curl_exec($ch); 
 
/* 
 * Inspect IPN validation result and act accordingly 
 * Split response headers and payload, a better way for strcmp 
 */  
$tokens = explode("\r\n\r\n", trim($res)); 
$res = trim(end($tokens)); 
if (strcmp($res, "VERIFIED") == 0 || strcasecmp($res, "VERIFIED") == 0) { 
     $myfile = fopen("newfileUpdate.txt", "w") or die("Unable to open file!");
                        $txt = json_encode($_POST);
                        fwrite($myfile, $txt);
    // Retrieve transaction info from PayPal 
    $item_number    = $_POST['item_number']; 
    $txn_id         = $_POST['txn_id']; 
    $payment_gross     = $_POST['mc_gross']; 
    $currency_code     = $_POST['mc_currency']; 
    $payment_status = $_POST['payment_status']; 

	$item_name = $_POST['item_name'];
	$user = $_POST['userid'];
	if($item_name == 'Topup Amount'){
		$item_name = "topup_balance";
		$item_number  = 0 ;
	}else{
		$item_name = "order_purchase";
		 $amount = "";
		 $user = 0;
	}
     global $wpdb;
    // Check if transaction data exists with the same TXN ID 
    $prevPayment = $wpdb->get_results("SELECT trans_id FROM PQrlH_transactions WHERE trans_id = '".$txn_id."'"); 
    if(count($prevPayment) > 0){ 
        exit(); 
    }else{ 
		if($payment_status == 'Completed'){
			$payment_status = 'paid';
		}
		
        // Insert transaction data into the database 
       $insert = $wpdb->query("INSERT INTO PQrlH_transactions(trans_id,user_id,currency,price,payment_method,payment_status,order_id,payment_type) 		VALUES('".$txn_id."',$user,'".$currency_code."',$payment_gross ,'paypal','".$payment_status."',$item_number,'".$item_name."')"); 
		if($item_name ==  'order_purchase'){
		$charity =  get_user_meta($user,'charity',true);
		$insert = $wpdb->query("INSERT INTO PQrlH_transactions(trans_id,user_id,currency,price,payment_method,payment_status,order_id,payment_type) 		VALUES('".$txn_id."',$user,'".$currency_code."',(5*$payment_gross)/100,'paypal','".$payment_status."',$charity,'charity_fund')"); 
    } 
 
}
}
?>