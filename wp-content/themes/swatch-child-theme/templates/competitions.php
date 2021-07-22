<?php
/* Template Name: Competitions Template */

get_header();

$user_details = wp_get_current_user();
$userid = $user_details->ID;
$selected_charity = get_user_meta( $userid, 'charity',true);
$chrtiy ="";
?>
<style>
	
	@media screen and (max-width: 764px) and (min-width:340px){
 .margin{
              margin-bottom: 37px;
       }
   .container{
	   padding:0px; 
	}  
}

	.min_entry{
		font-weight: bolder;
	}
</style>	

<div class=' section_competition'>
    <div class='col-sm-12 text-center'>
        <div class='m-20'>
        <h1>  ON GOING COMPETITIONS </h1>
        </div>
    </div>
	
	<div class='compettions'>
	
<?php

/**
 * Setup query to show the ‘services’ post type with ‘8’ posts.
 * Output the title with an excerpt.
 */
  $i = 1; $i_color_counter = 1; $bgcolor = 1;
    $args = array(  
        'post_type' => 'raffles',
        'post_status' => 'publish',
        'posts_per_page' => 4, 
        'orderby' => 'title', 
        'order' => 'DESC', 
    );

    $loop = new WP_Query( $args ); 
   
    while ( $loop->have_posts() ) : $loop->the_post(); 
		
	//print_r(get_post_meta( get_the_ID()));
	
	$diff = abs(time() - strtotime(get_the_date('j F Y', get_the_ID())));
					
	$min = floor($diff / (60*60*24));
		
		
	//echo $i ;
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
		$bgcolor_raffle = "#EC8783";
		break;
		case 2 :
		$bg = "style='background:#1CD6CD'";
			$bgcolor_raffle = "#1CD6CD";
		break;
		case 3 :
		$bg = "style='background:#D5BDA3'";
			$bgcolor_raffle = "#D5BDA3";
		break;
		case 4 :
		$bg = "style='background:#2A9DF4'";
		$bgcolor_raffle = "#2A9DF4";
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
			$chrtiy =  $_SESSION['cart'][get_the_ID()]['charity'] ;
		    
     }else{
			$text = "Add to cart";
		    $class = "btn_cart";
		$exp ="instant_buy";
	}
	}else{
	
		$text = "Add to cart";
		    $class = "btn_cart";
		$exp ="instant_buy";
	}
		
		
?>
		
        <div class='span6 competiton_thumb competiton_thumb2 <?php echo $classs;?>'>
            <div class='inner-section' <?php echo $bg;?>>
                <div class='inner first-child'>
                    <a href="<?php echo get_permalink(get_the_ID());?>"><div class='heading text-center' style='background-image:url(<?php echo get_template_directory_uri().'/images/path9.png'?>);background-position:bottom;background-size:108%'>
                      <h3> <?php the_title(); ?> </h3>
						</div></a>
                    <div class='description'>
                        <p style="font-weight: bold;text-align:center"> <?php echo get_post_meta( get_the_ID(), 'short_description', true ); ?></p>
                    </div>
                    <div class='qty_buttons'>
                        <div class='icon_inner hidden-phone' style='border-right:1px solid #fcafa6'>
                            <img width='32px' src ="<?php echo get_template_directory_uri().'/images/days.png'?>">
                            <p> <?php echo ((get_post_meta( get_the_ID(), 'days', true ) - $min) < 0 ) ? 0 : get_post_meta( get_the_ID(), 'days', true ) - $min ; ?> Days </p>
                        </div>
						<?php if((get_post_meta( get_the_ID(), 'days', true ) - $min) <= 0){
						$tittle = 'title="Expired"  data-placement="top"';
					
						$class = "expired";

	                    $exp = "expired";
						$disabled = "disabled";
					}else{
						$tittle = "";
						$disabled = "";
						
						$exp = "instant_buy";
					} ?>
                        <div class='icon_inner'>
                            <p> Quantity </p>
                            <button class='minus_btn' <?php echo $disabled;?> data-min="<?php echo get_post_meta( get_the_ID(), 'minimum_entry', true ); ?>"> - </button> <span class='quantity'>  <?php echo ($qty != "" ) ? $qty : get_post_meta( get_the_ID(), 'minimum_entry', true ); ?> </span> <button class='add_btn' <?php echo $disabled;?>> + </button>
                        </div>
                    </div>
					
                    <div class='cart_buttons'>
                        <button class='<?php echo $class;?>' <?php //echo $disable;?> <?php echo $tittle;?> id='btn_cart' data-price="<?php echo get_post_meta( get_the_ID(), 'price_of_single_ticket', true ); ?>" data-color="<?php echo $bgcolor_raffle;?>" data-charity='<?php echo ($selected_charity == "")? $chrtiy : $selected_charity ;?>' data-raffle='<?php echo get_the_ID();?>'> <?php echo $text;?> <span class='loader'></span> </button>
                        <button class='<?php echo $exp;?>' data-color="<?php echo $bgcolor_raffle;?>" data-price="<?php echo get_post_meta( get_the_ID(), 'price_of_single_ticket', true ); ?>" data-raffle='<?php echo get_the_ID();?>'  <?php //echo $disable;?> <?php echo $tittle;?> > Buy <span class='loader'></span></button>
                    </div>
                   
                </div>
                <div class='inner'>
                   <a href="<?php echo get_permalink(get_the_ID());?>"> <img src='<?php echo wp_get_attachment_url(get_post_meta( get_the_ID(), 'raffle_thumbnail_image', true )) ;?>' style='height:100%' width='100%'></a>
                </div>
            </div>
			<?php 
			
			//if( get_post_meta( get_the_ID(), 'days', true ) > 0)
			/*if( (get_post_meta( get_the_ID(), 'days', true ) - $min) <= 0){
				echo  "<div class='conner_section'>
                <p> <span class='min_entry'> Awaiting withdrawal </span> </p>
            </div>";
			}else*/
				
				if((get_post_meta( get_the_ID(), 'days', true ) - $min) <= 7 && (get_post_meta( get_the_ID(), 'days', true ) - $min) > 0){
					echo "<div class='conner_section'>
                <p> <span class='min_entry'>Ending Soon </span> </p>
            </div>";
			}else if((get_post_meta( get_the_ID(), 'days', true ) - $min) == 1 && (get_post_meta( get_the_ID(), 'days', true ) - $min) > 0){
					echo "<div class='conner_section'>
                <p> <span class='min_entry'>Ending today </span> </p>
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
	
	endwhile; wp_reset_postdata();  ?>

	</div>

    <div class='row' style='margin-top:40px'>
        <div class='text-center'>
            <a href='<?php echo site_url()?>/allcompetiton' class='btn-custom'>View All</a>
        </div>
    </div>



  

</div>
</div>

<div class='page_content'>
<?php while(have_posts()): the_post(); ?>
       <?php the_content(); ?>
   <?php endwhile; ?>
</div>


<!-- Modal -->
  <div class="modal fade modalwidth" id="myModal_charity" role="dialog">
    <div class="modal-dialog modal-sm">
     <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Choose Charity</h3>
	  </div>
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
			<p> 5% of all tickets purchases go towards your chosen  Charity </p>
			<div class="body_charity" style='text-align:center'>
				
			</div>	
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
		  <button type="button"  class="btn btn-success   pull-right" id='ok_add_to_cart'>Ok</button>
        </div>
      </div>
      
    </div>
  </div>

<?php get_footer();?>