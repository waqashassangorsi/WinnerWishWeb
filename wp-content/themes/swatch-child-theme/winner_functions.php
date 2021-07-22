<?php
/* This files contains all functions about the winner wish */

class Winner_Wish{
	public function __construct(){
        global $wpdb;
		add_action("init",array($this,'winnerwish_adminmenu'));
		add_action("init",array($this,'winner_wish_categories'));
		add_filter( 'manage_raffles_posts_columns', array($this,'raffle_columns'));
		add_filter( 'manage_winner-subscriptions_posts_columns', array($this,'subscribe_columns'));
		add_filter( 'manage_competition-winners_posts_columns', array($this,'winners_columns'));
		
		add_shortcode('subscription_package',array($this,'subscription_packages'));
		add_shortcode('winner_list',array($this,'winners_shortcode'));
		add_shortcode('all_winner_list',array($this,'all_winners_shortcode'));
		add_filter( 'manage_raffles_posts_custom_column', array($this,'raffle_columns_data'),10,2);	
		add_filter( 'manage_competition-winners_posts_custom_column', array($this,'winners_columns_data'),10,2);
		add_filter( 'manage_winner-subscriptions_posts_custom_column', array($this,'subcribe_columns_data'),10,2);
		add_action( 'admin_enqueue_scripts', array($this,'enqueue_style_script'));
	    add_action("wp_ajax_sent_notification",array($this,'get_ticket_data'));
		add_action("wp_ajax_get_order_tickets",array($this,'get_order_tickets'));
		
		add_action("wp_ajax_get_funds_filter",array($this,'get_funds_filter'));
		
	}
	
	
	// Get get_funds_filter
	public function get_funds_filter(){
		extract($_POST);
		$response = array();
		global $wpdb;
		if($type == 'months'){
			$month = explode(',',$month);
			$month_no=$month[0] + 1;
			$year = $month[1];
			$terms = get_terms('charity_category');
			if ( $terms && !is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				$charity_funds = $wpdb->get_var("select sum(price) as sum from PQrlH_transactions where payment_type = 'charity_fund' AND payment_status = 'paid' AND month(date_time) = $month_no AND year(date_time) = $year AND order_id=".$term->term_id); 
				$single_charity['charity_id']=$term->term_id;
				if($charity_funds ==  null){
					$charity_funds = 0;
				}
				$single_charity['charity_funds']=$charity_funds;
				$response['total_funds_with_id'][] = $single_charity;
				}
			}
		}else if($type == 'custom'){
		$range = explode(' to ',$range);
		$from = $range[0];
	    $to = $range[1];
		$terms = get_terms('charity_category');
			if ( $terms && !is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
		
				$charity_funds = $wpdb->get_var("select sum(price) as sum from PQrlH_transactions where payment_type = 'charity_fund' AND payment_status = 'paid' AND (date_time between '$from' AND '$to') AND order_id=".$term->term_id); 
				$single_charity['charity_id']=$term->term_id;
				if($charity_funds ==  null){
					$charity_funds = 0;
				}
				$single_charity['charity_funds']=$charity_funds;
				$response['total_funds_with_id'][] = $single_charity;
				}
			}
		}
		
		echo json_encode($response);
		die;
	}

	// Get ticket Details or ORder on ID
	public function get_order_tickets(){
		extract($_POST);
		$response = array();
		global $wpdb;
		
		$lotteries = $wpdb->get_var("select lotteries from PQrlH_orders where  ord_id = $order_id ");
		
		if(!empty($lotteries)){
		    $lotteries =  explode(",",$lotteries);
			foreach($lotteries as $lot){
				$single_comp['title'] = get_the_title($lot);
				$get_details_tickets = $wpdb->get_results("SELECT * FROM `PQrlH_order_details` where order_id = $order_id AND lottery_id = $lot");
				$single_comp['details'] = $get_details_tickets;
				$response['order_data'][] = $single_comp;
			}
			
			$response['error'] =  false;
   			$response['message'] = "Details Found!";
		}else{
		
			$response['error'] =  true;
   			$response['message'] = "Invalid Ticket Name";
		
		}
		echo json_encode($response);
		die;
	}
	
	// Get ticket Details
	public function get_ticket_data(){
		extract($_POST);
		$response = array();
		global $wpdb;
		
		$get_details = $wpdb->get_row("SELECT * FROM `PQrlH_order_details` where ticket = '$ticket_name'");
		if(!empty($get_details)){
		
			$response['comp_name'] = get_the_title($get_details->lottery_id);
			
			$get_userID = $wpdb->get_var('select user_id from PQrlH_orders where ord_id = '.$get_details->order_id);
			$userDetails = get_userdata($get_userID);
			$response['winner_name'] = $userDetails->user_nicename;
			$response['winner_email']= $userDetails->user_email;
			$response['winner_id']= $get_userID;
			$response['error'] =  false;
   			$response['message'] = "Details Found!";
		}else{
		
			$response['error'] =  true;
   			$response['message'] = "Invalid Ticket Name";
		
		}
		echo json_encode($response);
		die;
	}
	/// winner wish admin scripts and style
	public function enqueue_style_script(){
		
		wp_enqueue_style('admin-fontawesome', 'https://pro.fontawesome.com/releases/v5.10.0/css/all.css', array(), false, 'all');
		wp_enqueue_script('admin-custom-js', get_stylesheet_directory_uri() . '/js/custom-admin.js', array(), false, 'all');
		$arrayData = array(
        "ajax_url" => admin_url("admin-ajax.php")
      );
       wp_localize_script("admin-custom-js","js_admin_data", $arrayData);
		 
		   
	}
	
	// winner wish admin menu
	public function winnerwish_adminmenu(){
		/*
		* Creating a function to create our CPT
		*/
		// Set UI labels for Custom Post Type
			$labels = array(
				'name'                => _x( 'Raffles', 'Post Type General Name', 'twentytwenty' ),
				'singular_name'       => _x( 'Raffles', 'Post Type Singular Name', 'twentytwenty' ),
				'menu_name'           => __( 'Raffles', 'twentytwenty' ),
				'parent_item_colon'   => __( 'Parent Raffles', 'twentytwenty' ),
				'all_items'           => __( 'All Raffles', 'twentytwenty' ),
				'view_item'           => __( 'View Raffles', 'twentytwenty' ),
				'add_new_item'        => __( 'Add New Raffle', 'twentytwenty' ),
				'add_new'             => __( 'Add New', 'twentytwenty' ),
				'edit_item'           => __( 'Edit Raffle', 'twentytwenty' ),
				'update_item'         => __( 'Update Raffle', 'twentytwenty' ),
				'search_items'        => __( 'Search Raffles', 'twentytwenty' ),
				'not_found'           => __( 'Not Found', 'twentytwenty' ),
				'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwenty' ),
			);
			 
		// Set other options for Custom Post Type
			 
			$args = array(
				'label'               => __( 'raffles', 'twentytwenty' ),
				'description'         => __( 'Competitions', 'twentytwenty' ),
				'labels'              => $labels,
				// Features this CPT supports in Post Editor
				'supports'            => array( 'title'),
				// You can associate this CPT with a taxonomy or custom taxonomy. 
				'taxonomies'          => array( 'raffle-category' ),
				/* A hierarchical CPT is like Pages and can have
				* Parent and child items. A non-hierarchical CPT
				* is like Posts.
				*/ 
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => 5,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				'show_in_rest' => true,
		 
			);
			 
			// Registering your Custom Post Type
			register_post_type( 'raffles', $args );

	}
	
	public function winner_wish_categories() {
		register_taxonomy(
			'raffle-category',
			'raffles',
			array(
				'label' => __( 'Categories' ),
				'rewrite' => array( 'slug' => 'raffle-category' ),
				'hierarchical' => true,
			)
		);
	}
	
	
	public function raffle_columns( $columns ) {
		  $columns = array(
		  'cb' => $columns['cb'],
		  'title' => __( 'Title' ),
		  'category' => __( 'Categories' ),
		  'website' => __( 'Website'),
		  'price' => __( 'Price'),
		  'entry' => __( 'Entry Ticket'),
		  'sold_ticket' => __( 'Sold Tickets'),
		  'total' => __( 'Total Entries'),
		  'days_left'=>__('Days Left'),
		  'days' => __( 'Total Days'),
		  'date_of_draw' => __( 'Draw Date'),
		  'image' => __( 'Images' ),
		  'date' => Date
		);
		  return $columns;
	}
	
	public function winners_columns( $columns ) {
		  $columns = array(
		  'cb' => $columns['cb'],
		  'title' => __( 'Winner Name' ),
		  'competitions' => __( 'Competition Name'),
		   'location' => __( 'Location'),
		  'image' => __( 'Images' ),
		  'date' => Date
		);
		  return $columns;
	}
	public function winners_columns_data($column,$post_id){
		
		// Image column
		 if ( 'image' === $column ) {
			echo '<img src="'.get_the_post_thumbnail_url($post_id).'" width="80px" >';
		  }
		
		
		 
		  
		 if ( 'competitions' === $column ) {
			echo get_the_title(get_post_meta ( $post_id, 'competitions', true ))." ( ".get_post_meta ( get_post_meta ( $post_id, 'competitions', true ), 'select_website', true )." )";
		  }
		
		if ( 'location' === $column ) {
			echo get_post_meta ( $post_id, 'location', true );
		  }
		 
	}
	
	public function subscribe_columns( $columns ) {
		  $columns = array(
		  'cb' => $columns['cb'],
		  'title' => __( 'Subscription Name' ),
		  'price' => __( 'Price'),
		  'feature_1' => __( 'Feature 1'),
		  'feature_2' => __( 'Feature 2' ),
		  'feature_3' => __( 'Feature 3'),
		  'feature_4' => __( 'Feature 4' ),
		  //'content' => __( 'Content' ),
 		  'date' => Date
		);
		  return $columns;
	}
	public function subcribe_columns_data($column,$post_id){
		
		// Image column
		 if ( 'price' === $column ) {
			echo get_post_meta( $post_id, 'subscription_price', true ) ;
		  }
		
		 if ( 'feature_1' === $column ) {
			echo get_post_meta( $post_id, 'feature_1', true ) ;
		  }
		if ( 'feature_2' === $column ) {
			echo get_post_meta( $post_id, 'feature_2', true ) ;
		  }
		if ( 'feature_3' === $column ) {
			echo get_post_meta( $post_id, 'feature_3', true ) ;
		  }
		if ( 'feature_4' === $column ) {
			echo get_post_meta( $post_id, 'feature_4', true ) ;
		  }
		
		/*if ( 'content' === $column ) {
			echo "<p>".get_post_meta( $post_id, 'subscription_content', true )."</p>" ;
		  }*/
		 
	}
	
	
	public function raffle_columns_data($column,$post_id){
		
		// Image column
		 if ( 'image' === $column ) {
			echo '<img src="'.wp_get_attachment_url(get_post_meta ( $post_id, 'raffle_thumbnail_image', true )).'" width="40">'.'<img src="'.wp_get_attachment_url(get_post_meta ( $post_id, 'raffle_detail_image', true )).'" width="40">';
		  }
		  
		 if ( 'website' === $column ) {
			 if(get_post_meta ( $post_id, 'select_website', true ) == 'winnerwish'){
				echo "<p style='color:green'><b>Winners Wish</b></p>";
			 }else{
			 	echo "<p style='color:blue'><b> Winners Kid </b></p>";
			 }
		  }
		 if ( 'price' === $column ) {
			echo get_post_meta ( $post_id, 'price_of_single_ticket', true );
		  }
		 if ( 'date_of_draw' === $column ) {
			echo  date('F j, Y',strtotime(get_post_meta($post_id,'date_of_draw',true)));
		  }
		 if ( 'sold_ticket' === $column ) {
			 global $wpdb;
			 echo $wpdb->get_var("SELECT count(ticket) as sold FROM `PQrlH_order_details` where lottery_id = ".$post_id);
		  }
		  
		if ( 'days_left' === $column ) {
			$diff = abs(time() - strtotime(get_the_date('j F Y', $post_id)));		
			$min = floor($diff / (60*60*24));
			echo ((get_post_meta( $post_id, 'days', true ) -$min) <= 0 )? "Expired" :  get_post_meta( $post_id, 'days', true ) -$min . " Remaining" ;
		  }
		  
		if ( 'days' === $column ) {
			echo get_post_meta ( $post_id, 'days', true );
		  }
		  
		if ( 'entry' === $column ) {
			echo get_post_meta ( $post_id, 'minimum_entry', true );
		  }
		  
		if ( 'total' === $column ) {
			echo get_post_meta ( $post_id, 'total_entries', true );
		  }
		  
		if ( 'category' === $column ) {
			        $terms = get_the_terms( $post_id, 'raffle-category' );

        /* If terms were found. */
        if ( !empty( $terms ) ) {

            $out = array();

            /* Loop through each term, linking to the 'edit posts' page for the specific term. */
            foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => 'raffles', 'category' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'category', 'display' ) )
					);
				}

				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}

			/* If no terms were found, output a default message. */
			else {
				_e( 'No Category' );
			}
			
		  }
		
		
	}
	
	public function subscription_packages(){
		global $wpdb;
		$html = '<section class="section  swatch-white"><div class="container">
			<h1 id="winnerheading2">Choose your Plan</h1><div class="row-fluid">';
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
$html .= '<div class="columns1 newcoldata">
	<ul class="price">
		<li class="'.$class.' newsubscription"><?php echo get_the_title(get_the_ID());?></li>
		<li class="'.$class.' pricehead newsubscription"><span class="signfont dollarsign">£
			</span><span class="amountfont">
			'. get_post_meta(get_the_ID(),'subscription_price',true).' </span><span  class="signfont">/ mo</span></li>
		<li class="subscriptionmenu">Feature 1</li>
		<li class="subscriptiondetail">'.get_post_meta(get_the_ID(),'feature_1',true).'</li>
		<li class="subscriptionmenu">Feature 2</li>
		<li class="subscriptiondetail">'.get_post_meta(get_the_ID(),'feature_2',true).'</li> 
		<li class="subscriptionmenu">Feature 3</li>
		<li class="subscriptiondetail">'.get_post_meta(get_the_ID(),'feature_3',true).'</li>
		<li class="subscriptionmenu">Feature 4</li>
		<li class="subscriptiondetail">'.get_post_meta(get_the_ID(),'feature_4',true).'</li>
		<li class="newsubscription"><a href="'.site_url().'/newcart?package='.get_the_ID().'" class="'.$classbtn.'">'.$subscribe.'</a></li>
	</ul>
</div>';
		$i++; endwhile;
		$html .= "</div></section>";
		return $html;
	
	}
	
	
	public function winners_shortcode(){
		$html = '<section class="section  swatch-white " id="winnersection"><div class="container">
			<h1 id="winnerheading2">Recent winners</h1><div class="row-fluid">';
		$args = array(  
        'post_type' => 'competition-winners',
        'post_status' => 'publish',
        'posts_per_page' => 3, 
        'order' => 'DESC', 
    );
		
    $loop = new WP_Query( $args ); 
	 if($loop->have_posts()) {
		 
		while ( $loop->have_posts() ){ 
			 $loop->the_post();
			
			$html .= '<div class="span4">
			<div class="card text-center">
			<div class="card-body card_image">
			<h5 class="card-title">'.get_the_title(get_post_meta(get_the_ID(),'competitions',true)).'</h5>
			<p><img src="'.get_the_post_thumbnail_url(get_the_ID()).'"></p>
			</div>
			<p>&nbsp;</p>
			<h3 style="color: #ec8783;">'.get_the_title(get_the_ID()).'</h3>
			<h3 style="color: #ec8783;">'.get_post_meta(get_the_ID(),'location',true).'</h3>
			</div>
			</div>';
		}
	 }
		
		
		
		$html.='<div class="text-center" style="100%;clear:both"><a class="btn btn-info" style="padding: 8px 47px; border-radius: 26px;" href="'.site_url().'/allwinners/">View All Winners</a></div>
			</div></div></section>';
		return $html;
	
	}

	public function all_winners_shortcode(){
		$html = '<section class="section  swatch-white " id="winnersection"><div class="container">
			<h1 id="winnerheading2">List of All winners</h1><div class="row-fluid">';
		$args = array(  
        'post_type' => 'competition-winners',
        'post_status' => 'publish',
        'posts_per_page' => -1, 
        'order' => 'DESC', 
    );
		
    $loop = new WP_Query( $args ); 
	 if($loop->have_posts()) {
		 
		while ( $loop->have_posts() ){ 
			 $loop->the_post();
			
			$html .= '<div class="span4 winner-user">
			<div class="card text-center">
			<div class="card-body card_image">
			<!--<h5 class="card-title">'.get_the_title(get_post_meta(get_the_ID(),'competitions',true)).'</h5>-->
			<p><a href="'.site_url().'/winnerblog/?winner='.get_the_ID().'"><img src="'.get_the_post_thumbnail_url(get_the_ID()).'"></a></p>
			</div>
			<p>&nbsp;</p>
			<h3 style="color: #ec8783;"><a href="'.site_url().'/winnerblog/?winner='.get_the_ID().'">'.get_the_title(get_the_ID()).'</a></h3>
			<h3 style="color: #ec8783;">'.get_post_meta(get_the_ID(),'location',true).'</h3>
			</div>
			</div>';
		}
	 }
		
		
		
		$html.='
			</div></div></section>';
		return $html;
	
	}


	 
}
?>