<?php
/**
 * Displays a single post
 *
 * @package Swatch
 * @subpackage Frontend
 * @since 0.1
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version 1.9.2
 */
get_header();
global $post;
global $wpdb;
//print_r(get_post_meta($post->ID));
$custom_fields = get_post_custom($post->ID);
//print_r($custom_fields);
//echo $post->ID;
$sold = $wpdb->get_var("SELECT count(ticket) as sold FROM `PQrlH_order_details` where lottery_id = ".$post->ID);
$get_total = get_post_meta( get_the_ID(), 'total_entries', true );

$get_filled  = ($sold*100)/$get_total;
$diff = abs(time() - strtotime(get_the_date('j F Y', get_the_ID())));
$min = floor($diff / (60*60*24));
?>

<style>
@media screen and (max-width: 764px) and (min-width:340px){
.main_image2{
           width:100%;
       }
	.main_title2{
	width:100%;
	} 
	.detail_description
	{
		margin-top: 28px;
	}
	.quantity_section2{
		width:50%;
	}
	.quantity_section3{
	width:50%;
	}
	.qty_section
	{
	padding:19px;
	}
	.heading_raffle{
	font-size:17px;
	}
	.interested_raffles{
		margin-top:10px;
	}
}
	.margin{
	margin-bottom:43px;
	}
	.selected_charity {   
		border: 1px solid gainsboro;
    	margin: 0px;
		/* -webkit-appearance: menulist-button; */
		-moz-appearance: none;
		appearance: menulist;
		border-radius: 0;
		width: 135px;
	}
	.selected_charity:focus{
	border-color: gainsboro;
	}
</style>	


<!-- Latest compiled and minified CSS -->
<div class='section_competition'>
    <div class='col-sm-12' style='padding:0px 12px'>
        <div class='charity m-20'>
			<?php
			if(is_user_logged_in()){ 
				$current_url = home_url(add_query_arg(array($_GET), $wp->request));
			$current_user = wp_get_current_user();
			// User ID
			$userid = $current_user->ID;
				if(isset($_SESSION['message_charity']) &&  $_SESSION['message_charity'] == 'updated'){
			?>
			<div class="alert alert-success"><b> Success! : </b> Charity Updated successfully!</div>
			<?php unset($_SESSION['message_charity']);  } ?>
			<form id="charity_setting_front"  method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
				  			<input type='hidden' value='charity_setting' name='action'> 
				  			<input type="hidden" value="<?php echo $current_url;?>" name="return_url">
			<p style="margin:0px"><img src="<?php echo site_url();?>/wp-content/uploads/2021/02/Group-86.png" style='width:38px;margin-right:6px'> 5% of all tickets purchases go towards your chosen Charity 
				
				<select class="selected_charity" name="charity_category" required>
							  <option value="" >Select Charity</option>
							   <?php
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
						foreach ($all_categories as $cat) {
						if($cat->category_parent == 0 ) {
							
							$category_id = $cat->term_id; 
							if($category_id == get_user_meta( $userid, 'charity',true)){
							$select  = "selected";
							}else{
							$select="";
							}  
							  ?>
							  
							  <option <?php echo $select;?> value="<?php echo $category_id;?>" ><?php echo $cat->name;?></option>
							<?php } } ?>
						  </select> </p>
				</form>
			
			<?php }else{ ?>
			
			<p style="margin:0px"><img src="<?php echo site_url();?>/wp-content/uploads/2021/02/Group-86.png" style='width:38px;margin-right:6px'> 5% of all tickets purchases go towards your chosen Charity <a href='/elementor-1779'> Charity </a> </p>
			
			<?php }
			
			?>
        </div>
    </div>
	
	<div class='product_details'>
	
		<div class='col-sw-6 main_image2'>
		<div class='bg-cloud'>
			<img src='<?php echo wp_get_attachment_url(get_post_meta( get_the_ID(), 'raffle_detail_image', true ));?>' width='100%'>
		</div>
		<div class="">
		  <p style='margin: 12px 0px 0px;'> Entries Sold </p>
		  <div class="progress">
			<div class="progress-bar" style='width:<?php echo round($get_filled) ;?>%'></div>
		  </div>
		  <p> <span style="float:left"> <?php echo ( round($get_filled) > 100 ) ? 0 : round($get_filled) ;?>%  </span>  <span style="float:right">100%</span>  </p>
		</div>

		</div>
		
		<div class='col-sw-4 pt-0 main_title2'>
		
			<h2 class='single_title'> <?php echo get_the_title($post->ID);?> </h2>
			
			<p> <?php echo get_post_meta($post->ID,'short_description',true);?> </p>
			<div class='detail_description'>
			<p><?php echo get_post_meta($post->ID,'long_description',true);?>.</p>
			</div>
			<?php 
			$days = get_post_meta($post->ID,'days',true);
			$remaining = $days - $min;
				if($remaining  <= 0 ){
					$remaining = 0;
				}
			?>
			
			<div class='detail_qty'>
				<div class='col-sw-3'>
					 <img  src ="<?php echo get_template_directory_uri().'/images/Group.png'?>">
                            <p> <?php echo $remaining;?> Days Left</p>
				</div>
				<div class='col-sw-3'>
					 <img  src ="<?php echo get_template_directory_uri().'/images/Path 14.png'?>">
                            <p> <?php echo "£ ".get_post_meta($post->ID,'price_of_single_ticket',true);?> Cost Per Entry </p>
				</div>
				<div class='col-sw-3'>
					 <img  src ="<?php echo get_template_directory_uri().'/images/Group 21.png'?>">
                            <p> Guaranteed Winner </p>
				</div>
			</div>
			
			<div class='qty_section'>
				<div class='col-sw-8 quantity_section2'>
				<p><strong>Quantity </strong></p>
				
				</div>
				<div class='col-sw-2 quantity_section3'>
				  <button class='minus_btn' data-min="<?php echo get_post_meta($post->ID, 'minimum_entry', true ); ?>"> - </button> <span class='quantity'>  <?php echo get_post_meta($post->ID, 'minimum_entry', true ); ?> </span> <button class='add_btn'> + </button>
				</div>
			
			
			</div>
			
			<div class='btn_cart_buy cart_buttons'>
			
                        <button style='background:#1abc9c' class="btn_cart" data-price="<?php echo get_post_meta( $post->ID, 'price_of_single_ticket', true ); ?>" data-raffle='<?php echo $post->ID;?>' id='btn_cart'> Add to cart <span class='loader'></span> </button>
                        <button class='instant_buy' data-price="<?php echo get_post_meta( $post->ID, 'price_of_single_ticket', true ); ?>" data-raffle='<?php echo $post->ID;?>'  <?php //echo $disabled;?> <?php //echo $tittle;?> style='background:#fb8989' > Buy <span class='loader'></span>   </button>
                    
			</div>
			
			
			
		</div>
		
	
	</div>
	
	<div class='interested_raffles'>
	
		<h2 class="heading_raffle"> Raffles You Might be interested in </h2>
		
		<?php
		
			 $i = 1; $i_color_counter = 1; $bgcolor = 1;
		//get the taxonomy terms of custom post type
		 $customTaxonomyTerms = wp_get_object_terms( $post->ID, 'raffle-category', array('fields' => 'ids') );
		
		//query arguments
		$args = array(
			'post_type' => 'raffles',
			'post_status' => 'publish',
			'posts_per_page' => 4,
			'orderby' => 'rand',
			'tax_query' => array(
				array(
					'taxonomy' => 'raffle-category',
					'field' => 'id',
					'terms' => $customTaxonomyTerms
				)
			),
			'post__not_in' => array ($post->ID),
		);

		//the query
		$relatedPosts = new WP_Query( $args );

		//loop through query
		if($relatedPosts->have_posts()){
			
			while($relatedPosts->have_posts()){ 
				
				$diff = abs(time() - strtotime(get_the_date('j F Y', get_the_ID())));
					
	$min = floor($diff / (60*60*24));
				$relatedPosts->the_post();
				if($i > 2 ){
		echo "</div>";
		$i = 1;
		$new_row = "<div class='row' style='margin-bottom:40px'>";
	}else{
		$new_row = "";
		if($i == 1){
			$new_row = " <div class='row' style='margin-bottom:40px'>";
		}
	}
	
	switch($bgcolor){
		case 1 :
		$bg = "style='background:#EC8783'";
		break;
		case 2 :
		$bg = "style='background:#1CD6CD'";
		break;
		case 3 :
		$bg = "style='background:#D5BDA3'";
		break;
		case 4 :
		$bg = "style='background:#2A9DF4'";
		break;
	}
	 if($bgcolor == 4){
		 $bgcolor  = 1;
	 }
	
	if($i_color_counter == 1){
		$margin_left = "";
		$classs = "margin";
		 $i_color_counter++;
	}else{
		$margin_left = "style='margin-left:26px'";
		$i_color_counter = 1;
		$classs = "";
	}
	echo $new_row;
					$qty = "";
	if(isset($_SESSION['cart'])){	
	if(array_key_exists(get_the_ID(), $_SESSION['cart'])){
            $text = "Added";
		    $class = "";
			$qty  = $_SESSION['cart'][get_the_ID()]['quantity'] ;
     }else{
			$text = "Add to cart";
		    $class = "btn_cart";
	}
	}else{
	
		$text = "Add to cart";
		    $class = "btn_cart";
	}
		?>
				<div class='span6 competiton_thumb competiton_thumb2 <?php echo $classs;?>'>
            <div class='inner-section' <?php echo $bg;?>>
                <div class='inner first-child'>
                    <a href="<?php echo get_permalink(get_the_ID());?>"><div class='heading text-center' style='background-image:url(<?php echo get_template_directory_uri().'/images/path9.png'?>);background-position:bottom;background-size:108%'>
                      <h3> <?php the_title(); ?> </h3>
						</div></a>
                    <div class='description text-center'>
                        <p> <b><?php echo get_post_meta( get_the_ID(), 'short_description', true ); ?></b></p>
                    </div>
                    <div class='qty_buttons'>
                        <div class='icon_inner hidden-phone' style='border-right:1px solid #fcafa6'>
                            <img width='32px' src ="<?php echo get_template_directory_uri().'/images/days.png'?>">
                            <p><?php echo ((get_post_meta( get_the_ID(), 'days', true ) - $min) < 0 ) ? 0 : get_post_meta( get_the_ID(), 'days', true ) - $min ; ?> Days </p>
                        </div>
                       <?php if((get_post_meta( get_the_ID(), 'days', true ) - $min) <= 0){
						$tittle = "title='Time Expired.'";
						$disabled = "disabled";
					}else{
						$tittle = "";
						$disabled = "";
					} ?>
                        <div class='icon_inner'>
                            <p> Quantity </p>
                            <button class='minus_btn' <?php echo $disabled;?> data-min="<?php echo get_post_meta( get_the_ID(), 'minimum_entry', true ); ?>"> - </button> <span class='quantity'>  <?php echo ($qty != "" ) ? $qty : get_post_meta( get_the_ID(), 'minimum_entry', true ); ?> </span> <button class='add_btn' <?php echo $disabled;?>> + </button>
                        </div>
                    </div>

                   <div class='cart_buttons'>
                        <button class='<?php echo $class;?>' <?php echo $disabled;?> <?php echo $tittle;?> id='btn_cart' data-price="<?php echo get_post_meta( get_the_ID(), 'price_of_single_ticket', true ); ?>" data-raffle='<?php echo get_the_ID();?>'> <?php echo $text;?> <span class='loader'></span> </button>
                         <button class='instant_buy' data-price="<?php echo get_post_meta( get_the_ID(), 'price_of_single_ticket', true ); ?>" data-raffle='<?php echo get_the_ID();?>'  <?php echo $disabled;?> <?php echo $tittle;?> > Buy <span class='loader'></span></button>
                    </div>
                   
                </div>
                <div class='inner'>
                   <a href="<?php echo get_permalink(get_the_ID());?>"> <img src='<?php echo wp_get_attachment_url(get_post_meta( get_the_ID(), 'raffle_thumbnail_image', true )) ;?>' style='height:100%' width='100%'></a>
                </div>
            </div>
            <?php 
			
			//if( get_post_meta( get_the_ID(), 'days', true ) > 0)
			if((get_post_meta( get_the_ID(), 'days', true ) - $min) == 1 && (get_post_meta( get_the_ID(), 'days', true ) - $min) > 0){
					echo "<div class='conner_section'>
                <p> <span class='min_entry'>Ending today </span> </p>
            </div>";
			}else if((get_post_meta( get_the_ID(), 'days', true ) - $min) <= 7 && (get_post_meta( get_the_ID(), 'days', true ) - $min) > 0){
					echo "<div class='conner_section'>
                <p> <span class='min_entry'> Ending soon </span> </p>
            </div>";
			}
			
			?>
			

        </div>
		<?php
				
			if($i > 2 ){
				$new_row = "</div>";
				$i = 1;
			}else{
				$new_row = "";
				$i++;
			}
			$bgcolor ++;
			 echo $new_row;
			
			
			}
		}else{
			echo  "<h2 class='text-center'> Not Related Raffles Found! </h2>";
		}

		//restore original post data
		wp_reset_postdata();

		?>
		
		

    <!--<div class='row' style='margin-bottom:30px'>
        <div class='span6 competiton_thumb margin'>
            <div class='inner-section' style='background:#d5bda3'>
                <div class='inner first-child'>
                    <div class='heading text-center' style='background-image:url(<?php echo get_template_directory_uri().'/images/path9.png'?>);background-position:bottom;background-size:108%'>
                      <h3> Win a Diamond </h3>
                    </div>
                    <div class='description'>
                        <p> Please select a charity from the members area
to ensure your ticket purchases are donated.</p>
                    </div>
                    <div class='qty_buttons'>
                        <div class='icon_inner' style='border-right:1px solid #fcafa6'>
                            <img width='32px' src ="<?php echo get_template_directory_uri().'/images/days.png'?>">
                            <p> 3 Days </p>
                        </div>
                        <div class='icon_inner'>
                            <p> Quantity </p>
                            <button> - </button> <span> 1 </span> <button> + </button>
                        </div>
                    </div>

                    <div class='cart_buttons'>
                        <button> Add to cart </button>
                        <button> Buy </button>
                    </div>
                   
                </div>
                <div class='inner'>
                    <img src='<?php echo get_template_directory_uri()."/images/image (8).png"?>' style='height:100%' width='100%'>
                </div>
            </div>
            <div class='conner_section'>
                <p> 1 ticket entry </p>
            </div>

        </div>

        <div class='span6 competiton_thumb ' >
            <div class='inner-section' style="background:#2a9df4">
                <div class='inner first-child'>
                    <div class='heading text-center' style='background-image:url(<?php echo get_template_directory_uri().'/images/path9.png'?>);background-position:bottom;background-size:108%'>
                      <h3> Win a Diamond </h3>
                    </div>
                    <div class='description'>
                        <p> Please select a charity from the members area
to ensure your ticket purchases are donated.</p>
                    </div>
                    <div class='qty_buttons'>
                        <div class='icon_inner' style='border-right:1px solid #fcafa6'>
                            <img width='32px' src ="<?php echo get_template_directory_uri().'/images/days.png'?>">
                            <p> 3 Days </p>
                        </div>
                        <div class='icon_inner'>
                            <p> Quantity </p>
                            <button> - </button> <span> 5 </span> <button> + </button>
                        </div>
                    </div>

                    <div class='cart_buttons'>
                        <button> Add to cart </button>
                        <button> Buy </button>
                    </div>
                   
                </div>
                <div class='inner'>
                    <img src='<?php echo get_template_directory_uri()."/images/image (8).png"?>' style='height:100%' width='100%'>
                </div>
            </div>
            <div class='conner_section'>
                <p> 5 ticket entry </p>
            </div>
        </div>

    </div>-->
	
	</div>
	
	

</div>
<?php get_footer();?>

