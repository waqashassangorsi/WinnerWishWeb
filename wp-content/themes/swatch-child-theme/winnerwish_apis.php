<?php
require_once('libs/stripe/init.php');
class WinnerWish{
	public function __construct(){
        global $wpdb;
		add_action( 'rest_api_init',array($this,"WinnerWishRestApiRoutes"));
    }
	
	public function WinnerWishRestApiRoutes(){
		//route Login User
		register_rest_route( 'winnerwish/v1', '/login_user/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'winner_login_user'),
				'args' => array()
			)
		) );
		
		//route Winner Update User
		register_rest_route( 'winnerwish/v1', '/winner_update_user/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'winner_update_user_details'),
				'args' => array()
			)
		) );
		
		//route User Notification
		register_rest_route( 'winnerwish/v1', '/notifications/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'winner_notifications'),
				'args' => array()
			)
		) );
		
		//route User Charity Update
		register_rest_route('winnerwish/v1', '/winner_charity_update/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'winner_charity_update'),
				'args' => array()
			)
		) );
		
		//route User Sign Up
		register_rest_route( 'winnerwish/v1', '/sign_up/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'winner_sign_up'),
				'args' => array()
			)
		) );
		
		//route User Order Details
		register_rest_route( 'winnerwish/v1', '/user_order_details/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'winner_user_order_detail'),
				'args' => array()
			)
		) );
		
		//route Sign Up User
		register_rest_route( 'winnerwish/v1', '/sign_up_kid/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'winner_sign_up_kid'),
				'args' => array()
			)
		) );
		
		/// route Competitions
		register_rest_route( 'winnerwish/v1', '/all_competitions/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'winner_all_competitions'),
				'args' => array()
			)
		) );
		
			register_rest_route( 'winnerwish/v1', '/winnerall_competitions/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'winnerkid_all_competitions'),
				'args' => array()
			)
		) );
		
		/// route Check Voucher
		register_rest_route( 'winnerwish/v1', '/check_voucher/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'winner_check_voucher'),
				'args' => array()
			)
		) );
		
		/// route for TOPUP
		register_rest_route( 'winnerwish/v1', '/top_up/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'top_up'),
				'args' => array()
			)
		) );
		
		/// route Competitions
		register_rest_route( 'winnerwish/v1', '/all_charities/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'winner_all_charities'),
				'args' => array()
			)
		) );
		
		/// route Order Placement
		register_rest_route( 'winnerwish/v1', '/place_order/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'winner_place_order'),
				'args' => array()
			)
		) );
		
		/// route Order Placement For WINNER KID 
		register_rest_route( 'winnerwish/v1', '/place_order_winner_kid/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'winner_place_order_winner_kid'),
				'args' => array()
			)
		) );
		
		/// route Order Transactions For WINNER KID 
		register_rest_route( 'winnerwish/v1', '/transactions_winner_kid/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'winner_transactions_winner_kid'),
				'args' => array()
			)
		) );
		
		/// route Competitions
		register_rest_route( 'winnerwish/v1', '/winners_list/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'winners_list'),
				'args' => array()
			)
		) );
		
		/// route Main Categories
		register_rest_route( 'winnerwish/v1', '/all_main_categories/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'all_main_categories'),
				'args' => array()
			)
		) );
		
		/// route Categories for Winner Kids
		register_rest_route( 'winnerwish/v1', '/all_main_categories_winner_kid/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'all_main_categories_winner_kid'),
				'args' => array()
			)
		) );
		
		/// route Name Change
		register_rest_route( 'winnerwish/v1', '/name_change/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'winner_name_change'),
				'args' => array()
			)
		) );
		
		/// route User Balance
		register_rest_route( 'winnerwish/v1', '/user_balance/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'winner_user_balance'),
				'args' => array()
			)
		) );
		
		/// route Update User Password
		register_rest_route( 'winnerwish/v1', '/change_password/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'winner_change_password'),
				'args' => array()
			)
		) );

		/// route Get Competition ID
		register_rest_route( 'winnerwish/v1', '/competition_detail/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'get_competition_details'),
				'args' => array()
			)
		) );
		
		/// route for ForGet Password
		register_rest_route( 'winnerwish/v1', '/forget_password/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'forget_password'),
				'args' => array()
			)
		) );
		
		/// route for ForGet Password winnerkid
		register_rest_route( 'winnerwish/v1', '/forget_password_winnerkid/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'forget_password_winnerkid'),
				'args' => array()
			)
		) );
		
		/// route for ForGet Password
		register_rest_route( 'winnerwish/v1', '/subscription_packages/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'subscription_packages'),
				'args' => array()
			)
		) );
		
		/// route for ForGet Password
		register_rest_route( 'winnerwish/v1', '/charity_funds/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'charity_funds'),
				'args' => array()
			)
		) );
		
		/// route for Reset Password
		register_rest_route( 'winnerwish/v1', '/reset_password/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'reset_password'),
				'args' => array()
			)
		) );
		
		/// route for Reset Password winnerkid
		register_rest_route( 'winnerwish/v1', '/reset_password_winnerkid/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'reset_password_winnerkid'),
				'args' => array()
			)
		) );
		
		/// route for My Tickets
		register_rest_route( 'winnerwish/v1', '/mytickets/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'mytickets'),
				'args' => array()
			)
		) );
		/// route for Place Subscriptions
		register_rest_route( 'winnerwish/v1', '/place_subscription/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'place_subscription'),
				'args' => array()
			)
		) );
		
		register_rest_route( 'winnerwish/v1', '/winnerkid_payment/', array(
			array(
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => array($this,'winnerkid_payment'),
				'args' => array()
			)
		) );
		
	}
	
	// Winner Update User Method
	public function winner_update_user_details(){
		
		extract($_POST);
		$response = array();
		global $wpdb;
		
		//$update = $wpdb->update('PQrlH_userDetails',array('username'=>$username,'street'=>$street),array('id'=>$user_detail_id));
		if($first_name != "")
			update_user_meta($userid, 'first_name_meta',$first_name );
		if($surname != "")
			update_user_meta($userid, 'last_name_meta',$surname );
		if($uk_address != "")
			update_user_meta($userid, 'uk_adress',$uk_address );
		if($tel_number != "")
			update_user_meta($userid, 'number_datanew',$tel_number );
		if($postal_code != "")
			update_user_meta($userid, 'postal_code',$postal_code );
			
		 	$update = true;
		
		if($update){
				$response['status'] =  true;
				$response['message'] =  "Setting Updated Successfully!";
		}else{
				$response['status'] =  false;
				$response['message'] =  "Setting Updated Successfully!";
	     }
		
		
		return $response;
	
	}	
	
/// Place Subscription packages
function place_subscription($request){
		extract($_POST);
		$response = array();
		global $wpdb;
		 $auth_header  = $request->get_header('auth');
		$userID =  $wpdb->get_var("Select ID from PQrLH_users where auth = '$auth_header'");
		if($userID != ""){
			if($payment_method == 'paypal'){
				$transaction = array(
					"trans_id"=> $transactionID,
					"currency"=>$paidCurrency,
					"price"=>$paidAmount,
					"payment_method"=>$payment_method,
					'user_id'=>$userID,
					"payment_status"=>$payment_status,
					"order_id"=>$package_id,
					"payment_type"=>'subscription'
				);

				$insert =$wpdb->insert('PQrlH_transactions',$transaction);
				$lastid = $wpdb->insert_id;
				$insert_subscription =$wpdb->insert('PQrlH_User_subscriptions',array('user_id'=>$userID,'subsciption_id'=>$package_id,'transaction_id'=>$lastid)); 
			
			if($insert && $insert_subscription){
				$response['status'] =  true;
				$response['message'] =  "Subscribed successfully!";
			}else{
				$response['status'] =  false;
				$response['message'] =  "Kindly Try later....";
			}
				
			}else{
				
				\Stripe\Stripe::setApiKey(
				  'sk_test_51H4QdgGmT7c3r5SQbt2GrPhzrLa1WMp7my7B9YsBAS0biYPV5cwYuxuuto5DumbhzfuhTo3WKCBsRDW19tDZJKuY00Xrrsauzm'
				);
				try {
						$charge = \Stripe\Charge::create([
						  'amount' => $paidAmount*100,
						  'currency' => 'gbp',
						  'description' => 'Subscription',
						  'source' => $token,
						]);
						$success = 1;
						$trans_id = $charge->id;
						if($charge->status == 'succeeded')
						$payment_status = 'paid';
						else
						$payment_status = $charge->status;
					
					} catch(Stripe_CardError $e) {
					  $error = $e->getMessage();
					} catch (Stripe_InvalidRequestError $e) {
					  // Invalid parameters were supplied to Stripe's API
					  $error = $e->getMessage();
					} catch (Stripe_AuthenticationError $e) {
					  // Authentication with Stripe's API failed
					  $error = $e->getMessage();
					} catch (Stripe_ApiConnectionError $e) {
					  // Network communication with Stripe failed
					  $error = $e->getMessage();
					} catch (Stripe_Error $e) {
					  // Display a very generic error to the user, and maybe send
					  // yourself an email
					  $error = $e->getMessage();
					} catch (Exception $e) {
					  // Something else happened, completely unrelated to Stripe
					  $error = $e->getMessage();
					}
					
				
					if($success == 1){
						$transaction = array(
							"trans_id"=> $trans_id,
							"currency"=>'gbp',
							"price"=>$paidAmount,
							"payment_method"=>$payment_method,
							'user_id'=>$userID,
							"payment_status"=>$payment_status,
							"order_id"=>$package_id,
							"payment_type"=>'subscription'
						);

						$insert =$wpdb->insert('PQrlH_transactions',$transaction);
						$lastid = $wpdb->insert_id;
						$insert_subscription =$wpdb->insert('PQrlH_User_subscriptions',array('user_id'=>$userID,'subsciption_id'=>$package_id,'transaction_id'=>$lastid)); 

						if($insert && $insert_subscription){
							$response['status'] =  true;
							$response['message'] =  "Subscribed successfully!";
						}else{
							$response['status'] =  false;
							$response['message'] =  "Kindly Try later....";
						}
					 
					}else{
						$response['status'] =  false;
						$response['message'] = $error;
						return $response;
						die;
					}
			
			
			
			}
		}else{
			$response['status'] =  false;
			$response['message'] =  "Invalid User";
		}
	
		return $response;
}
	
	/// Winner Charity Update
	public function winner_charity_update($request){
		
		global $wpdb;
		extract($_POST);
		$response = array();
		$auth_header  = $request->get_header('auth');
		$userID =  $wpdb->get_var("Select ID from PQrLH_users where auth = '$auth_header'");
		if($userID != ""){
			if(get_user_meta( $userID, 'charity',true) == ""){
					add_user_meta( $userID, 'charity', $charity_category ,true );
			}else{
					update_user_meta( $userID, 'charity', $charity_category);
			}
			$response['status'] = true;
			$response['message'] = "Update Successfully!";
		}else{
			$response['status'] = false;
			$response['message'] = 'Un authorized User';
		}
		
		return $response;
	}
	
	/// user Order Detail Winner Kids
	public function winner_user_order_detail(){
			global $wpdb;
			extract($_POST);
			$response = array();
			$order_tickets  = $wpdb->get_results("SELECT * from PQrlH_order_details where order_id  = $order and lottery_id = $lottery_id ");
		    if(count($order_tickets) > 0 ){
				   $response['status'] =  true;
				   $response['message'] =  "Tickets found!";
				   $response['data'] = $order_tickets;
			   }else{
						$response['status'] =  false;
						$response['message'] =  "No Tickets Found!";
						$response['data'] = array();
			   }

			   return $response;

	}
	
	/// Method for User Notifications
	public function winner_notifications(){
			global $wpdb;
			extract($_POST);
			$response = array();
			
			$notifications  = $wpdb->get_results("SELECT * FROM `PQrLH_notifications` where user_id = $userid");
		    if(count($notifications) > 0 ){
				   $response['status'] =  true;
				   $response['message'] =  "Notifications found!";
				   $response['data'] = $notifications;
			   }else{
						$response['status'] =  false;
						$response['message'] =  "No Notifications Found!";
						$response['data'] = array();
			   }

			   return $response;
	}
	
	/// subscription packages
	public function subscription_packages(){
			global $wpdb;
			extract($_POST);
			$response = array();
				$args = array(  
				'post_type' => 'winner-subscriptions',
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'orderby' => 'title', 
				'order' => 'DESC', 
			);
				$loop = new WP_Query( $args ); 
			   if($loop->have_posts()) {
				   $subscriptions = array();
				 while ( $loop->have_posts() ) : $loop->the_post(); 

				   $subscriptions['package_id'] = get_the_ID();
				   $subscriptions['package_name'] = get_the_title(get_the_ID());
				    $subscriptions['package_price'] = get_post_meta(get_the_ID(),'subscription_price',true);
				    $subscriptions['package_content'] = get_the_content(get_the_ID());
				   $subscriptions['feature1'] = get_post_meta(get_the_ID(),'feature_1',true);
				   $subscriptions['feature2'] = get_post_meta(get_the_ID(),'feature_2',true);
				   $subscriptions['feature3'] = get_post_meta(get_the_ID(),'feature_3',true);
				   $subscriptions['feature4'] = get_post_meta(get_the_ID(),'feature_4',true);
				   
				   $allSubs[] = $subscriptions;
				   endwhile;
				   $response['status'] =  true;
				   $response['message'] =  "Packges found!";
				   $response['data'] = $allSubs;
			   }else{
						$response['status'] =  false;
						$response['message'] =  "No Packges Found!";
						$response['data'] = array();
			   }

			   return $response;

	}
	/// All Main Categories
	public function all_main_categories(){
		global $wpdb;
		extract($_POST);
		$response = array();	
		$taxonomy     = 'raffle-category';
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
		
		if(count($all_categories)  > 0 ){
			foreach ($all_categories as $cat) {
				if($cat->category_parent == 0 ) {
                    $category_id = $cat->term_id; 
					/*if($id == $category_id){
					  $select = "selected";
					}else{
						$select = "";
					}*/
                   
                    $categories['id'] =  $category_id;
                    $categories['cat_name'] = $cat->name ;
					$response['main_categories'][] = $categories;
                }
			}
			 $response['error'] =  false;
			 $response['success_msg'] = "Categories found!";
		}else{

		 $response['error'] =  true;
		 $response['error_msg'] = "No Categories found!";

		}
		return $response;
		
	}
	
	/// All Main Categories (FOR Winners KID You can new type or edit this API)
	public function all_main_categories_winner_kid(){
		global $wpdb;
		extract($_POST);
		$response = array();	
		$taxonomy     = 'raffle-category';
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
		
		if(count($all_categories)  > 0 ){
			foreach ($all_categories as $cat) {
				if($cat->category_parent == 0 ) {
                    $category_id = $cat->term_id; 
					/*if($id == $category_id){
					  $select = "selected";
					}else{
						$select = "";
					}*/
                   	$dtat=get_option( "taxonomy_$cat->term_id");
                
                         $newdataresultr=$dtat['custom_term_meta'];
                         
				
                    if($newdataresultr=="WINNER KID"){   
                    $categories['id'] =  $category_id;
                    $categories['cat_name'] = $cat->name ;
					$response['main_categories'][] = $categories;
                    }
                }
			}
			 $response['error'] =  false;
			 $response['success_msg'] = "Categories found!";
		}else{

		 $response['error'] =  true;
		 $response['error_msg'] = "No Categories found!";

		}
		return $response;
		
	}
	
	
	
	/// All Winners List
	public function winners_list(){
		global $wpdb;
		extract($_POST);
		$response = array();
			$args = array(  
			'post_type' => 'competition-winners',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'orderby' => 'title', 
			'order' => 'DESC', 
		);
    $loop = new WP_Query( $args ); 
		   if($loop->have_posts()) {
			   $winners = array();
			 while ( $loop->have_posts() ) : $loop->the_post(); 
			   
			   $winner['winner_id'] = get_the_ID();
			   $winner['winner_img'] = get_the_post_thumbnail_url(get_the_ID());
			   $winner['winner_name'] =get_the_title(get_the_ID());
			   $winner['competition_name'] = get_the_title(get_post_meta ( get_the_ID(), 'competitions', true ));
			   $winner['competition_website'] = get_post_meta(get_post_meta ( get_the_ID(), 'competitions', true ),'select_website',true);
			   $winner['competition_id'] = get_post_meta ( get_the_ID(), 'competitions', true );
			   $winner['location'] = get_post_meta (get_the_ID(), 'location', true );
			   $winners[] = $winner;
			 endwhile;
			   $response['status'] =  true;
			   $response['message'] =  "Winners found!";
			   $response['data'] =$winners;
		   }else{
					$response['status'] =  false;
					$response['message'] =  "No Winners Found!";
					$response['data'] = array();
		   }
	
		   return $response;
	}
	
	// Check Voucher
	public function winner_check_voucher(){
		global $wpdb;
		extract($_POST);
		$response = array();
		
		$get_row = $wpdb->get_row("select * from pqrlh_vouchers where vname = '$vcode'");
	    
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
		return $response;
	}
	
	// Sign Up Winner Kid Method
	public function winner_sign_up_kid(){
		global $wpdb;
		extract($_POST);
		
		
		$response = array();
			if(!is_email($useremail)){
    		$response['status'] =  false;
			$response['message'] =  "Invalid Email Address";
			return $response;
    	}

	  if(email_exists($useremail)){
	        $response['status'] =  false;
			$response['message'] =  "Email Already Exists";
			return $response;
	  }
        $fullname = $first_name." ".$last_name;
    	$userdata = array(
    		  'user_login' => $fullname,
    		  'user_pass' => $userpass,
    		  'user_email' => $useremail,
    		  'display_name' => $fullname,
    		  'role' => 'customer'
    		);
        
		 $user_id = wp_insert_user($userdata);
	
		// On success.
		if (!is_wp_error( $user_id )) {
		    
		    add_user_meta( $user_id,'postal_code',$postal_code);
	        add_user_meta( $user_id,'uk_adress',$address);
	        add_user_meta( $user_id,'full_name',$fullname);
			add_user_meta( $user_id,'first_name_meta',$first_name);
			add_user_meta( $user_id,'last_name_meta',$last_name);
			add_user_meta( $user_id,'number_datanew',$phone_number);
			add_user_meta( $user_id,'recv_update',$recv_update);
			add_user_meta( $user_id,'age',$age);
			add_user_meta( $user_id,'sign_type','Winner-Kid');
	
			$message = '<p><b>Hello There</b></p>
			<p> Welcome to Winner Kids</p>';
			// Set content-type header for sending HTML email 
			$headers = "MIME-Version: 1.0" . "\r\n"; 
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
			 
			// Additional headers 
			$headers .= 'From: WinnerKids <info@winnerkids.com>' . "\r\n";
			//$useremail
			if(mail('aounmuhammad135@gmail.com','Welcome to WinnerWish',$message,$headers)){
				$response['status'] =  true;
			    $response['message'] =  "User Registered Successfully!";
			}else{
			    $response['status'] =  false;
		    	$response['message'] =  "User Registered Error in  Mail";
			}
		}else{
		    $response['status'] =  false;
			$response['message'] =  "Sorry Try Later...!";
			$wpdb->print_error();
		}
		return $response;
	}
	
	
	// Sign Up method
	public function winner_sign_up(){
		global $wpdb;
		extract($_POST);
		
		
		$response = array();
			if(!is_email($useremail)){
    		$response['status'] =  false;
			$response['message'] =  "Invalid Email Address";
			return $response;
    	}

	  if(email_exists($useremail)){
	        $response['status'] =  false;
			$response['message'] =  "Email Already Exists";
			return $response;
	  }
        $fullname = $first_name." ".$last_name;
    	$userdata = array(
    		  'user_login' => $fullname,
    		  'user_pass' => $userpass,
    		  'user_email' => $useremail,
    		  'display_name' => $fullname,
    		  'role' => 'customer'
    		);
        
		 $user_id = wp_insert_user($userdata);
	
		// On success.
		if (!is_wp_error( $user_id )) {
		    
		    add_user_meta( $user_id,'postal_code',$postal_code);
	        add_user_meta( $user_id,'uk_adress',$address);
	        add_user_meta( $user_id,'full_name',$fullname);
			add_user_meta( $user_id,'first_name_meta',$first_name);
			add_user_meta( $user_id,'last_name_meta',$last_name);
			add_user_meta( $user_id,'number_datanew',$phone_number);
			add_user_meta( $user_id,'recv_update',$recv_update);
			add_user_meta( $user_id,'age',$age);
			add_user_meta( $user_id,'sign_type','Winner-wish');
	
			$message = '<p><b>Hello There</b></p>
			<p> Welcome to Winner Wish</p>';
			// Set content-type header for sending HTML email 
			$headers = "MIME-Version: 1.0" . "\r\n"; 
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
			 
			// Additional headers 
			$headers .= 'From: WinnerWish <info@winnerwish.com>' . "\r\n";
			//$useremail
			if(mail($useremail,'Welcome to WinnerWish',$message,$headers)){
				$response['status'] =  true;
			    $response['message'] =  "User Registered Successfully!";
			}else{
			    $response['status'] =  false;
		    	$response['message'] =  "User Registered Error in  Mail";
			}
		}else{
		    $response['status'] =  false;
			$response['message'] =  "Sorry Try Later...!";
			$wpdb->print_error();
		}
		return $response;
	}

	// Login User method
	public function winner_login_user(){
		global $wpdb;
		extract($_POST);
		$response = array();
		
		$creds['user_login'] = $username;
		$creds['user_password'] =  $pass;
		$user = wp_signon( $creds, false );

		if ( !is_wp_error($user) ){
			$User = get_current_user_id();
			
			$response['status'] =  true;
			$response['message'] =  "Record Found!";
			$data = $user->data;
			$charity = get_user_meta( $data->ID, 'charity',true);
			$data->first_name = get_user_meta( $data->ID, 'first_name_meta',true);
			$data->last_name = get_user_meta( $data->ID, 'last_name_meta',true);
			$data->address = get_user_meta( $data->ID, 'uk_adress',true);
			$data->phone_no = get_user_meta( $data->ID, 'number_datanew',true);
			$data->age = get_user_meta( $data->ID, 'age',true);
			$data->postal_code = get_user_meta( $data->ID, 'postal_code',true);
			$data->charity = $charity;
			 $subscription_id = $wpdb->get_var("SELECT subsciption_id FROM `PQrlH_User_subscriptions` where user_id =".$data->ID);
			$data->package = $subscription_id;
			$response['data'] = $data;// $user->data;
			
		}else{
			$response['status'] =  false;
			$response['message'] =  "Invalid User";
			$response['data'] = array();
		}
          
		return $response;
	}
	
	public function winner_transactions_winner_kid(){
		global $wpdb;
		extract($_POST);

		$transaction = array(
					"trans_id"=> $trans_id,
					"currency"=>'gbp',
					"price"=>$price,
					'user_id'=>0,
					"payment_method"=>"cards",
					"payment_status"=>$payment_status,
					"order_id"=>$order_id,
					"payment_type"=>$type,
					"status_web"=>"winnerkid"						
		);
		$insert_main =$wpdb->insert('PQrlH_transactions',$transaction);
		
		$transaction = array(
						"trans_id"=> $trans_id,
						"currency"=>'gbp',
						"price"=>$price,
						'user_id'=>$user_id,
						"payment_method"=>"cards",
						"payment_status"=>$payment_status,
						"order_id"=>$order_id,
						"payment_type"=>'charity_fund',
						"status_web"=>"winnerkid"
					);
		$insert_charity =$wpdb->insert('PQrlH_transactions',$transaction);
		if($insert_main && $insert_charity){
			$response['error'] = false;
			$response['message'] = 'inserted succesfully';
		}else{
			$response['error'] = true;
			$response['message'] = 'Try Later';
		
		}
	
	}
	
	//Hanlding Function FOR Place Order ---- WInner KID
	public function winner_place_order_winner_kid($request){
		global $wpdb;
		extract($_POST);
		$details = json_decode(stripslashes($request->get_body()));
		
		$response = array();
		$auth_header  = $request->get_header('auth');
		$userID =  $wpdb->get_var("Select ID from PQrLH_users where auth = '$auth_header'");
		//echo $order_detail;
		$orders_details = json_decode(stripslashes($details->order_detail));
		
		if($userID != ""){
			$order_total = $details->order_total;
			$order_sub_total = $details->order_sub_total;
			$lottries = $details->lottries;
		   	$payment_method = $details->payment_method;
			 $lottires = trim($lottries,',');
			
		   $insert = $wpdb->insert('PQrlH_orders',array(
			   'total_price'=>$order_total,
			   'sub_total'=>$order_sub_total,
			   'user_id'=>$userID,
			   'lotteries'=>$lottires,
			   'payment_method'=>$payment_method,
			   'status'=>'pending',
			   'order_from'=>'winnerkids'
		   ));
			if($insert){
						$lastid = $wpdb->insert_id;

						foreach($orders_details as $order){
							
								$lottry_id = $order->lottry_id;
								$sec_answer = $order->sec_answer;
								$query = "INSERT INTO PQrlH_order_details (`order_id`,`ticket`,`lottery_id`,`security_question`) values";
								for($i = 1 ; $i<= $order->quantity;$i++){
									$ticket = "WW-".$userID.$this->generateRandomString(4);
									$query .="($lastid,'$ticket',$lottry_id,'$sec_answer'),";

								}
						
						}
					 $query = trim($query,',');
					
						if($wpdb->query($query)){
							if($voucher != ""){
							$voucher = $wpdb->get_row("SELECT * FROM `pqrlh_vouchers` where vlimit != voucher_usage AND vexpiry > NOW() AND vname = '$voucher'");
							$voucher_add = $wpdb->insert('PQrlH_voucher_usage',array('voucher_id'=>$voucher->vid,'voucher_price'=>$voucher->vprice,'order_id'=>$lastid,'user_id'=>$userID));
							}else{
							$voucher_add = true;
							}
						}
				
						if($payment_method == 'cards'){
			\Stripe\Stripe::setApiKey('sk_test_51H4QdgGmT7c3r5SQbt2GrPhzrLa1WMp7my7B9YsBAS0biYPV5cwYuxuuto5DumbhzfuhTo3WKCBsRDW19tDZJKuY00Xrrsauzm');
							$checkout_session = \Stripe\Checkout\Session::create([
							  'payment_method_types' => ['card'],
							  'line_items' => [[
								'price_data' => [
								  'currency' => 'gbp',
								  'unit_amount' => $order_total*100,
								  'product_data' => [
									'name' => 'Winner KID Competition',
									'images' => ["<?php echo site_url();?>/wp-content/uploads/2021/06/cropped-newlogog.png"],
								  ],
								],
								'quantity' => 1,
							  ]],
							  'mode' => 'payment',
							  'metadata'=>['order_id'=>$lastid,'userid'=>$userID],
							  'success_url' => '<?php echo site_url();?>/thank-you/',
							  'cancel_url' => '<?php echo site_url();?>',
							]);
							echo json_encode(['id' => $checkout_session->id,"error"=>false]);
							die;
						}
						if($payment_method == "paypal"){

							 $vars = array(
										'cmd' => '_xclick',
										'business' => "winnerwish-business@gmail.com",
										'lc'=>'EN_US',
										'item_name' => "Winner Kids",
										'item_number' => $lastid,
										'userid' => $userID,
										'amount' => $order_total,
										'notify_url' => "<?php echo site_url();?>/?action=winner_IPN",
										'return' => "<?php echo site_url();?>/thank-you/",
										'currency_code' => 'GBP',
										'order_id'=>$lastid,
										'cancel_return' => 'https://ranaentp.net/winnerskid/',
										'paymentaction' => 'sale',
										'no_note' => 0,
										'tax_rate' => 0,
								);
								$response['id'] = "https://www.sandbox.paypal.com/cgi-bin/webscr?" . http_build_query($vars);
								$response['error'] = false; 
								$response['success_msg'] = "Order Placed Successfully......";
								unset ($_SESSION["cart"]);

						}if($payment_method == "balance"){
						
							// Insert tansaction data into the database 
							$transaction = array(
								"trans_id"=> 'txid_balance_'.$lastid,
								"currency"=>'GBP',
								"price"=>"-".$order_total,
								'user_id'=>$userID,
								"payment_method"=>$payment_method,
								"payment_status"=>"paid",
								"order_id"=>$lastid,
								"payment_type"=>'order_purchase'
							);
							$insert =$wpdb->insert('PQrlH_transactions',$transaction);
							$transaction = array(
								"trans_id"=> 'txid_balance_'.$lastid,
								"currency"=>'GBP',
								"price"=>$order_total,
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
								"price"=>(5*$order_total)/100,
								'user_id'=>$userID,
								"payment_method"=>$payment_method,
								"payment_status"=>"paid",
								"order_id"=>$charity,
								"payment_type"=>'charity_fund'
							);

							$insert =$wpdb->insert('PQrlH_transactions',$transaction);
						
						}
				
					
						if($voucher_add){
							$response['status'] =  true;
							$response['message'] =  "Order inserted";	
						}else{
							$response['status'] =  false;
							$response['message'] =  "Error while in Voucher.. Please Try later...".mysqli_error($con);
						}
			}else{
				$response['status'] =  false;
				$response['message'] =  "Error while Order.. Please Try later...".mysqli_error($con);
				$response['data'] = array();
			}
		}else{
		    
			$response['status'] =  false;
			$response['message'] =  "Empty User ID or Unauthorized User";
		   
		}
		
		return $response;
	
		
	}
	
	//Place Order
	public function winner_place_order($request){
		global $wpdb;
		extract($_POST);
		$response = array();
		$auth_header  = $request->get_header('auth');
		$userID =  $wpdb->get_var("Select ID from PQrLH_users where auth = '$auth_header'");
		$orders_details = json_decode(stripslashes($order_detail));
		
		if($userID != ""){
			$order_total = $_POST['order_total'];
			$order_sub_total = $_POST['order_sub_total'];
			$lottries = $_POST['lottries'];
		   	$payment_method = $_POST['payment_method'];
			 $lottires = trim($lottries,',');
			if($payment_method == 'stripe'){
				\Stripe\Stripe::setApiKey(
				  'sk_test_51H4QdgGmT7c3r5SQbt2GrPhzrLa1WMp7my7B9YsBAS0biYPV5cwYuxuuto5DumbhzfuhTo3WKCBsRDW19tDZJKuY00Xrrsauzm'
				);
				try {
						$charge = \Stripe\Charge::create([
						  'amount' => $order_total*100,
						  'currency' => 'usd',
						  'description' => 'Order purchased',
						  'source' => $token,
						]);
						$success = 1;
						$trans_id = $charge->id;
						if($charge->status == 'succeeded')
						$payment_status = 'paid';
						else
						$payment_status = $charge->status;
					
					} catch(Stripe_CardError $e) {
					  $error = $e->getMessage();
					} catch (Stripe_InvalidRequestError $e) {
					  // Invalid parameters were supplied to Stripe's API
					  $error = $e->getMessage();
					} catch (Stripe_AuthenticationError $e) {
					  // Authentication with Stripe's API failed
					  $error = $e->getMessage();
					} catch (Stripe_ApiConnectionError $e) {
					  // Network communication with Stripe failed
					  $error = $e->getMessage();
					} catch (Stripe_Error $e) {
					  // Display a very generic error to the user, and maybe send
					  // yourself an email
					  $error = $e->getMessage();
					} catch (Exception $e) {
					  // Something else happened, completely unrelated to Stripe
					  $error = $e->getMessage();
					}
					
				
					if($success == 1){
						$transaction = array(
							"trans_id"=> $trans_id,
							"currency"=>'GBP',
							"price"=>$order_total,
							"payment_method"=>$payment_method,
							'user_id'=>0,
							"payment_status"=>'paid',
							"order_id"=>0,
							"payment_type"=>'order_purchase'
						);		
					 	$insert =$wpdb->insert('PQrlH_transactions',$transaction);
						
						$transaction = array(
							"trans_id"=> $transactionID,
							"currency"=>"GBP",
							"price"=>(5*$order_total)/100,
							"payment_method"=>"cards",
							'user_id'=>$userID,
							"payment_status"=>'paid',
							"order_id"=>$charity,
							"payment_type"=>'charity_fund'
						);

						$insert =$wpdb->insert('PQrlH_transactions',$transaction);
						
					 
					}else{
						$response['status'] =  false;
						$response['message'] = $error;
						return $response;
						die;
					}
			}
			
		   $insert = $wpdb->insert('PQrlH_orders',array(
			   'total_price'=>$order_total,
			   'sub_total'=>$order_sub_total,
			   'user_id'=>$userID,
			   'lotteries'=>$lottires,
			   'payment_method'=>$payment_method,
			   'status'=>'pending'
		   ));
			if ($insert){
				$lastid = $wpdb->insert_id;
		
				foreach($orders_details as $order){

					 $lottry_id = $order->lottery_id;
					$query = "INSERT INTO PQrlH_order_details (`order_id`,`ticket`,`lottery_id`) values";
					for($i = 1 ; $i<= $order->quantity;$i++){
						$ticket = "WW-".$userID.$this->generateRandomString(4);
						$query .="($lastid,'$ticket',$lottry_id),";

					}
					 $query = trim($query,',');

						if($wpdb->query($query)){
							if($voucher != ""){
							$voucher = $wpdb->get_row("SELECT * FROM `pqrlh_vouchers` where vlimit != voucher_usage AND vexpiry > NOW() AND vname = '$voucher'");
							$voucher_add = $wpdb->insert('PQrlH_voucher_usage',array('voucher_id'=>$voucher->vid,'voucher_price'=>$voucher->vprice,'order_id'=>$lastid,'user_id'=>$userID));
							}else{
							$voucher_add = true;
							}
						}
				}
				
						if($payment_method == "paypal"){

							$transaction = array(
							"trans_id"=> $trans_id,
							"currency"=>'GBP',
							"price"=>$order_total,
							"payment_method"=>$payment_method,
							'user_id'=>0,
							"payment_status"=>'paid',
							"order_id"=>0,
							"payment_type"=>'order_purchase'
						);		
					 	$insert =$wpdb->insert('PQrlH_transactions',$transaction);
						$transaction = array(
							"trans_id"=> $transactionID,
							"currency"=>"GBP",
							"price"=>(5*$order_total)/100,
							"payment_method"=>"cards",
							'user_id'=>$userID,
							"payment_status"=>'paid',
							"order_id"=>$charity,
							"payment_type"=>'charity_fund'
						);

						$insert =$wpdb->insert('PQrlH_transactions',$transaction);

						}if($payment_method == "balance"){
						
							// Insert tansaction data into the database 
							$transaction = array(
								"trans_id"=> 'txid_balance_'.$lastid,
								"currency"=>'GBP',
								"price"=>"-".$order_total,
								'user_id'=>$userID,
								"payment_method"=>$payment_method,
								"payment_status"=>"paid",
								"order_id"=>$lastid,
								"payment_type"=>'order_purchase'
							);
							$insert =$wpdb->insert('PQrlH_transactions',$transaction);
							$transaction = array(
								"trans_id"=> 'txid_balance_'.$lastid,
								"currency"=>'GBP',
								"price"=>$order_total,
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
								"price"=>(5*$order_total)/100,
								'user_id'=>$userID,
								"payment_method"=>$payment_method,
								"payment_status"=>"paid",
								"order_id"=>$charity,
								"payment_type"=>'charity_fund'
							);

							$insert =$wpdb->insert('PQrlH_transactions',$transaction);
						
						}
				
					
						if($voucher_add){
							$response['status'] =  true;
							$response['message'] =  "Order inserted";	
						}else{
							$response['status'] =  false;
							$response['message'] =  "Error while in Voucher.. Please Try later...".mysqli_error($con);
						}
			}else{
				$response['status'] =  false;
				$response['message'] =  "Error while Order.. Please Try later...".mysqli_error($con);
				$response['data'] = array();
			}
		}else{
		    
			$response['status'] =  false;
			$response['message'] =  "Empty User ID or Unauthorized User";
		   
		}
		
		return $response;
	
		
	}
	
	
	
	
	/// ALL competitions method
	public function winner_all_competitions(){
		global $wpdb;
		extract($_POST);
		$response = array();
		
		if($category == "" || $category == 0 ){
			$args = array(  
			'post_type' => 'raffles',
			'post_status' => 'publish',
			'posts_per_page' => -1, 
			'orderby' => 'title', 
			'order' => 'ASC', 
			);
		}else{
			$args = array(  
			'post_type' => 'raffles',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'tax_query' => array(
					array(
						'taxonomy' => 'raffle-category', //double check your taxonomy name in you dd 
						'field'    => 'id',
						'terms'    => $category,
					),
				   ),
			'orderby' => 'title', 
			'order' => 'ASC', 
		);
		
		}
    $loop = new WP_Query( $args ); 
		   if($loop->have_posts()) {
			   $raffle = array();
			 while ( $loop->have_posts() ) : $loop->the_post(); 
			
			   $singleraffle['ID'] = get_the_ID();
				$singleraffle['title'] = get_the_title(get_the_ID());
			   $singleraffle['short_description'] = get_post_meta( get_the_ID(), 'short_description', true );
			   $singleraffle['price'] = get_post_meta( get_the_ID(), 'price_of_single_ticket', true );
			   $singleraffle['min_days'] = get_post_meta( get_the_ID(), 'days', true );
			   $singleraffle['minimum_entry'] = get_post_meta( get_the_ID(), 'minimum_entry', true );
			   $singleraffle['security_question']  =  get_post_meta(get_the_ID(),'add_security_question',true);
				$singleraffle['answer_1']  =  get_post_meta(get_the_ID(),'answer_1',true);
				$singleraffle['answer_2']  =  get_post_meta(get_the_ID(),'answer_2',true);
				$singleraffle['answer_3']  =  get_post_meta(get_the_ID(),'answer_3',true);
			$singleraffle['answer_correct']  =  get_post_meta(get_the_ID(),'answer_correct',true);
			   $singleraffle['image_id']  = get_post_meta( get_the_ID(), 'raffle_thumbnail_image', true );
			   $singleraffle['image'] = wp_get_attachment_url(get_post_meta( get_the_ID(), 'raffle_thumbnail_image', true ));
				$raffle[] = $singleraffle;
			   
			 endwhile;
			   $response['status'] =  true;
			   $response['message'] =  "Raffles found!";
			   $response['data'] =$raffle;
		   }else{

					$response['status'] =  false;
					$response['message'] =  "No Raffles Found!";
					$response['data'] = array();

		   }
	
	return $response;
	}
	
// Competiton Api for winnerkid
	
	public function winnerkid_all_competitions(){
		global $wpdb;
		extract($_POST);
		$response = array();
		
		if($category == "" || $category == 0 ){
			$args = array(  
			'post_type' => 'raffles',
			'post_status' => 'publish',
			'posts_per_page' => -1, 
			'orderby' => 'title', 
			'order' => 'ASC', 
			);
		}else{
			$args = array(  
			'post_type' => 'raffles',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'tax_query' => array(
					array(
						'taxonomy' => 'raffle-category', //double check your taxonomy name in you dd 
						'field'    => 'id',
						'terms'    => $category,
					),
				   ),
			'orderby' => 'title', 
			'order' => 'ASC', 
		);
		
		}
    $loop = new WP_Query( $args ); 
		   if($loop->have_posts()) {
			   $raffle = array();
			 while ( $loop->have_posts() ) : $loop->the_post(); 
			     $website=  get_post_meta(get_the_ID(),'select_website',true); 
  	   if($website=="winnerkid")
			   {
				  
			   $singleraffle['ID'] = get_the_ID();
			  $singleraffle['title'] = get_the_title(get_the_ID());
			   $singleraffle['short_description'] = get_post_meta( get_the_ID(), 'short_description', true );
			   $singleraffle['price'] = get_post_meta( get_the_ID(), 'price_of_single_ticket', true );
			   $singleraffle['min_days'] = get_post_meta( get_the_ID(), 'days', true );
			   $singleraffle['minimum_entry'] = get_post_meta( get_the_ID(), 'minimum_entry', true );
			   $singleraffle['security_question']  =  get_post_meta(get_the_ID(),'add_security_question',true);
				$singleraffle['answer_1']  =  get_post_meta(get_the_ID(),'answer_1',true);
				$singleraffle['answer_2']  =  get_post_meta(get_the_ID(),'answer_2',true);
				$singleraffle['answer_3']  =  get_post_meta(get_the_ID(),'answer_3',true);
			   $singleraffle['answer_correct']  =  get_post_meta(get_the_ID(),'answer_correct',true);
			   $singleraffle['image_id']  = get_post_meta( get_the_ID(), 'raffle_thumbnail_image', true );
			   $singleraffle['image'] = wp_get_attachment_url(get_post_meta( get_the_ID(), 'raffle_thumbnail_image', true ));
		      $singleraffle['publish_date']  =  get_the_date('j F Y',get_the_ID());
			   
				$raffle[] = $singleraffle;
			   }
			 endwhile;
			   $response['status'] =  true;
			   $response['message'] =  "Raffles found!";
			   $response['data'] =$raffle;
			   
		     } else{

					$response['status'] =  false;
					$response['message'] =  "No Raffles Found!";
					$response['data'] = array();

		   }
	
	return $response;
	}
	

	// All Charities method
	public function winner_all_charities(){
		global $wpdb;
		extract($_POST);
		$response = array();
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
		if(count($all_categories) > 0){
			foreach ($all_categories as $cat) {
				if($cat->category_parent == 0 ) {

					$singlecat['catid'] = $cat->term_id;
					$singlecat['catname'] = $cat->name;
					
				}
				
				$categories[] = $singlecat;
		  }
			$response['status'] =  true;
			$response['message'] =  "Charity Categories found!";
			$response['data'] =$categories;
		}else{
			$response['status'] =  false;
			$response['message'] =  "No Categories Found!";
			$response['data'] = array();
		}
		return $response;
	  }
	
		// Change User Name
	  public function winner_name_change($request){
		global $wpdb;
		extract($_POST);
		$auth_header  = $request->get_header('auth');
		$userID =  $wpdb->get_var("Select ID from PQrLH_users where auth = '$auth_header'");
		if($userID != "" && $userName !=""){
			
			$update = wp_update_user( array(
						'ID'            => $userID,
						'user_nicename' => $userName
					) );
			if(!is_object($update)){
				$response['status'] =  true;
				$response['message'] =  "User name changed";
			}else{
				$response['status'] =  false;
				$response['message'] =  "Invalid User ID";
			
			}	
			
		}else{
			$response['status'] =  false;
			$response['message'] =  "Empty User ID or Unauthorized User";
		}
		  
		return $response;
	 }
	
		
	//Charity FUnds
	public function charity_funds(){
		global $wpdb;
		extract($_POST);
		
$funds = $wpdb->get_var("SELECT SUM(price) FROM `PQrlH_transactions` WHERE payment_type ='charity_fund'");
		
			$response['status'] =  true;
			$response['message'] =  "Chairty Fund Raised";
			$response['charity_fund']=$funds;
		
		    return $response;
	}	
		
	// User Balance
	public function winner_user_balance($request){
		global $wpdb;
		extract($_POST);
		
		$auth_header  = $request->get_header('auth');
		$userID =  $wpdb->get_var("Select ID from PQrLH_users where auth = '$auth_header'");
			
		if($userID != ""){
			/*$balance = $wpdb->get_var("SELECT SUM(price) FROM `PQrlH_transactions` where ( (payment_type = 'topup_balance' OR payment_type = 'withdraw_amount') OR (payment_type = 'order_purchase' AND currency = 'Balance') ) AND user_id = $userID");*/
			$balance = $wpdb->get_var("SELECT SUM(price) FROM `PQrlH_transactions` WHERE user_id = $userID AND payment_type!='charity_fund' AND payment_type!='subscription'");
		
			$response['status'] =  true;
			$response['message'] =  "User Balance";
			$response['balance']=$balance;
		}else{
			$response['status'] =  false;
			$response['message'] =  "Unauthorized User";
		}
		  
		return $response;
	}
	
	// Change Password
	public function winner_change_password($request){
		global $wpdb;
		extract($_POST);
		$auth_header  = $request->get_header('auth');
		
         $newhashpass=$currentpass;
		
		$userID =  $wpdb->get_var("Select ID from PQrLH_users where auth = '$auth_header'");
		
		$userpass =  $wpdb->get_var("Select user_pass from PQrLH_users where auth = '$auth_header'");
		$check=wp_check_password($newhashpass,$userpass, $userID);
		
	
		if($check==true)
		{
			if($userID != "" && $password !=""){
				wp_set_password($password,$userID);
				$response['status'] =  true;
				$response['message'] =  "Password Updated Succefully!";
			}else{
				$response['status'] =  false;
				$response['message'] =  "Empty User ID or new Password or Unauthorized User";
			}
	  } else{
				$response['status'] =  false;
				$response['message'] =  "Unauthorized User";
			} 
		return $response;
		
	}
	
	//User Top Up
	public function top_up($request){
		global $wpdb;
		extract($_POST);
		$auth_header  = $request->get_header('auth');
		$userID =  $wpdb->get_var("Select ID from PQrLH_users where auth = '$auth_header'");
		$success = 0;
		if($userID != ""){
			if($payment_method == "stripe"){
				\Stripe\Stripe::setApiKey(
				  'sk_test_51H4QdgGmT7c3r5SQbt2GrPhzrLa1WMp7my7B9YsBAS0biYPV5cwYuxuuto5DumbhzfuhTo3WKCBsRDW19tDZJKuY00Xrrsauzm'
				);
				try {
						$charge = \Stripe\Charge::create([
						  'amount' => $amount*100,
						  'currency' => 'usd',
						  'description' => 'Customer Balanace Top Up',
						  'source' => $token,
						]);
						$success = 1;
						$trans_id = $charge->id;
						if($charge->status == 'succeeded')
						$payment_status = 'paid';
						else
						$payment_status = $charge->status;
					
					} catch(Stripe_CardError $e) {
					  $error = $e->getMessage();
					} catch (Stripe_InvalidRequestError $e) {
					  // Invalid parameters were supplied to Stripe's API
					  $error = $e->getMessage();
					} catch (Stripe_AuthenticationError $e) {
					  // Authentication with Stripe's API failed
					  $error = $e->getMessage();
					} catch (Stripe_ApiConnectionError $e) {
					  // Network communication with Stripe failed
					  $error = $e->getMessage();
					} catch (Stripe_Error $e) {
					  // Display a very generic error to the user, and maybe send
					  // yourself an email
					  $error = $e->getMessage();
					} catch (Exception $e) {
					  // Something else happened, completely unrelated to Stripe
					  $error = $e->getMessage();
					}
					
				
					if($success == 1){
							$transaction = array(
							"trans_id"=> $trans_id,
							"currency"=>'GBP',
							"price"=>$amount,
							"payment_method"=>$payment_method,
							'user_id'=>$userID,
							"payment_status"=>$payment_status,
							"order_id"=>0,
							"payment_type"=>'topup_balance'
						);		
					 $insert =$wpdb->insert('PQrlH_transactions',$transaction);
						
					}else{
						$response['status'] =  false;
						$response['message'] = $error;
						return $response;
						die;
					}
			
			}else{
			$transaction = array(
					"trans_id"=> $trans_id,
					"currency"=>$currency,
					"price"=>$amount,
					"payment_method"=>$payment_method,
					'user_id'=>$userID,
					"payment_status"=>$payment_status,
					"order_id"=>0,
					"payment_type"=>'topup_balance'
				);		
             $insert =$wpdb->insert('PQrlH_transactions',$transaction);
			}
			if($insert){
				$response['status'] =  true;
				$response['message'] =  "Topup Succcessfully!";
			}else{
				$response['status'] =  false;
				$response['message'] =  "Please Try Later";
			}
		}else{
			$response['status'] =  false;
			$response['message'] =  "Unauthorized User";
		}
		  
		return $response;
		
	}
	
	// Change Password
	public function reset_password(){
		global $wpdb;
		extract($_POST);
		if($user_email != "" && $newpassword !=""){
			wp_set_password($newpassword,email_exists($user_email));
			$response['status'] =  true;
			$response['message'] =  "Password Updated Succefully!";
		}else{
			$response['status'] =  false;
			$response['message'] =  "Empty User E-mail or new Password";
		}
		  
		return $response;
		
	}
	
// Change Password For Winners Kids
	public function reset_password_winnerkid(){
		global $wpdb;
		extract($_POST);
		$code=$verify_code;
		

		if($newpassword !=""){
			
		  $userEmail =  $wpdb->get_var("Select user_email from PQrLH_users where verify_code = '$code'");
				if($userEmail != ""){

					wp_set_password($newpassword,email_exists($userEmail));

				}
			$response['status'] =  true;
			$response['message'] =  "Password Updated Succefully!";
		}else{
			$response['status'] =  false;
			$response['message'] =  "Empty User E-mail or new Password";
		}
		  
		return $response;
		
	}
	
	// ForGet Password --- Send email to Verify
	public function forget_password(){
		global $wpdb;
		extract($_POST);
		
		if(email_exists($user_email)){
			
			$to  = $user_email;
			// subject
			$code = $this->generateRandomString();
			$subject = 'Winnerswish Code Verfication';

			// message
			$message = ' <html> 
				<head> 
					<title>Winnerswish Code Verfication</title> 
				</head> 
				<body> 
					<h1>Hello Dear,</h1> 
					<p> <b>Verfication Code:</b> '.$code.' </p>
					<br>
					<p> In case any issue or query, Feel free to contact US </p>
					<p> Thanks ( Team Winnerswish ) </p>
				</body> 
				</html>'; 

			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

			// Additional headers
			$headers .= 'From: Winnerswish <winnerswish@support.com>' . "\r\n";
			
			
			if(mail($to, $subject, $message, $headers)){
				$response['status'] =  true;
				$response['verification_code'] =  $code;
				$response['message'] =  "Please verfiy the Code!";
			}
		}else{
			$response['status'] =  false;
			$response['message'] =  "Sorry Invalid Email or not exists";
		}
		  
		return $response;
	}
	
	
					
	// ForGet Password --- Send email to winnerkid Verify
	public function forget_password_winnerkid(){
		global $wpdb;
		extract($_POST);
		
		if(email_exists($user_email)){
		    $beforecode = $this->generateRandomString();
			$after = $this->generateRandomString();
			$to  = $user_email;
			// subject
			
			$subject = 'Winnerkid Code Verfication';
            
			$userID =  $wpdb->get_var("Select ID from PQrLH_users where user_email = '$user_email'");
			$code ='https://ranaentp.net/winnerskid/changepass/?code='.$beforecode.$userID.$after;
			
			
		if($userID != ""){
			
			$wpdb->update("PQrLH_users",array("verify_code"=>$beforecode.$userID.$after),array("ID"=>$userID));
		 
		}
			
		// message
			$message = ' <html> 
				<head> 
					<title>Winnerkid Code Verfication</title> 
				</head> 
				<body> 
					<h1>Hello Dear,</h1> 
					<p> <b>Verfication Code:</b></p>
					<a style="background:#00C4CC ;padding-left: 31px;padding-top: 9px;padding-right: 36px;padding-bottom: 12px;color: white;text-decoration: none;"  href='.$code.'>Verify</a>
					<br>
					<p> In case any issue or query, Feel free to contact US </p>
					<p> Thanks ( Team Winnerkid ) </p>
				</body> 
				</html>'; 

			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

			// Additional headers
			$headers .= 'From: Winnerkid <winnerkid@ranaentp.net>' . "\r\n";
			
			
			if(mail($to, $subject, $message, $headers)){
				$response['status'] =  true;
				$response['verification_code'] = $newcode;
				$response['message'] =  "Please verfiy the Code!";
			}
		}else{
			$response['status'] =  false;
			$response['message'] =  "Sorry Invalid Email or not exists";
		}
		  
		return $response;
		
	}
				
				
	// Competition Details
	public function get_competition_details(){
		global $wpdb;
		extract($_POST);
		$postID = $competition_id;
		if($postID != ""){
			if( ! is_null(get_post($postID))){
			$data['ID']  =  $postID;
			$data['sold'] = $wpdb->get_var("SELECT count(ticket) as sold FROM `PQrlH_order_details` where lottery_id = ".$postID);
			$data['title']  =  get_the_title($postID);
			$data['price']  =  get_post_meta($postID,'price_of_single_ticket',true);
			$data['short_desc']  =  get_post_meta($postID,'short_description',true);
			$data['long_desc']  =  get_post_meta($postID,'long_description',true);
			$data['total_entries']  =  get_post_meta($postID,'total_entries',true);
			$data['minimum_entry']  =  get_post_meta($postID,'minimum_entry',true);
			$data['security_question']  =  get_post_meta($postID,'add_security_question',true);
			$data['answer_1']  =  get_post_meta($postID,'answer_1',true);
			$data['answer_2']  =  get_post_meta($postID,'answer_2',true);
			$data['answer_3']  =  get_post_meta($postID,'answer_3',true);
			$data['answer_correct']  =  get_post_meta($postID,'answer_correct',true);
			$data['thumbnail_img']  =  wp_get_attachment_url(get_post_meta($postID, 'raffle_thumbnail_image', true ));
			$data['detail_img']  =  wp_get_attachment_url(get_post_meta($postID, 'raffle_detail_image', true )) ;
				$response['status'] =  true;
				$response['message'] =  "Competition Details";
				$response['data'] =  $data;
			}else{
				$response['status'] =  false;
				$response['message'] =  "Invalid Competition ID";
			}
		}else{
			$response['status'] =  false;
			$response['message'] =  "Invalid Competition ID";
		}
		  
		return $response;
		
	}
	
	// Mytickets
	public function mytickets($request){
		global $wpdb;
		extract($_POST);
		$auth_header  = $request->get_header('auth');
		$userID =  $wpdb->get_var("Select ID from PQrLH_users where auth = '$auth_header'");
		if($userID != ""){
			$orders = $wpdb->get_results("SELECT * FROM `PQrlH_orders` Where user_id= $userID ORDER BY `ord_id`  DESC");
					if(count($orders) > 0){
						foreach($orders as $ord){
							$lottery = explode(",",$ord->lotteries);
							$order  = $ord->ord_id;
							$data_single['order_id'] = $order;
							$data_single['competition_name'] = get_the_title($order);
							$data_single['date_purchased']  = date("d , M Y H:i A",strtotime($ord->date_time));
							
							foreach($lottery as $lot){
								//echo $lot;
								$order_tickets  = $wpdb->get_results("SELECT * from PQrlH_order_details where order_id  = $order and lottery_id = $lot ");						
								$data_single['date_draw'] = date('F j, Y',strtotime(get_post_meta($lot,'date_of_draw',true)));
								$competition = get_the_title($lot);
								$data_single['single_ticket_price'] = get_post_meta($lot,'price_of_single_ticket',true);
								if(count($order_tickets) > 0 ){
									
									foreach($order_tickets as $ticket){
										$tickets[]= $ticket->ticket;
									}
								}else{
									$tickets =  array();

								}
							}
							$data_single['competition_name'] = $competition;
							$data_single['tickets'] = $tickets;
							$data[] = $data_single;
						}
						$response['status'] =  true;
						$response['message'] =  "Order Details";
						$response['data'] =  $data;
					}else{
						$data =  array();
						$response['status'] =  true;
						$response['message'] =  "No orders yet!";
						$response['data'] =  $data;
					}
				
			
		}else{
			$response['status'] =  false;
			$response['message'] =  "Unauthorized User";
		}
		  
		return $response;
		
	}
	

	public function winnerkid_payment($request){
		
		global $wpdb;
		extract($_POST);
		$auth_header  = $request->get_header('auth');
		$userID =  $wpdb->get_var("Select ID from PQrLH_users where auth = '$auth_header'");
	
		$balance = $wpdb->get_var("SELECT SUM(price) FROM `PQrlH_transactions` WHERE user_id = $userID AND payment_type!='charity_fund' AND payment_type!='subscription'");
		
		if(empty($balance)){
		  $balance=0;
		}

	if($amount<$balance)
	{


				$transaction = array(
						"amount"=> $amount,
						"email"=>$email,
						"paymentgateway"=>$paymentgateway,
						"status"=>"Pending",
						"u_id"=>$userID,
					);		


				 $insert =$wpdb->insert('payment',$transaction);

				if($insert){
					$response['status'] =  true;
					$response['message'] =  "Payment done Succcessfully!";
				}else{
					$response['status'] =  false;
					$response['message'] =  "Please Try Later";
				}

	}else{
				$response['status'] =  false;
					$response['message'] =  " Withdrawal Amount cannot be greater than your balance";
	}
		
	return $response;

	}
	
	//// Function for Random String
	
	public  function generateRandomString($length = 6) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
}
?>