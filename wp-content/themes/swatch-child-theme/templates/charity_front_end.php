<?php
/* Template Name: Charity Raffle Template */

get_header();

?>
<style>
	.fund_circle{
		width: 20%;
		margin: auto;
	}
	.fund_circle p{
		border-bottom:1px solid gainsboro;
	}
	.how_to_help{
		width: 80%;
		margin: 50px auto;
	}
	.chairty_total_fund{
		 background: #4caf50;
		border-radius: 50%;
		height: 170px;
		width: 170px;
		border: 8px solid gainsboro;
		margin: 16px auto;
			display: flex;
	  justify-content: center;
	  align-content: center;
	  flex-direction: column;
	}

	.chairty_total_fund h4{
	    color: white;
    	font-size: 24px;
	}
	.main_charity_box{
		display: grid;
		align-items: center;
		padding: 0px 35px 0px 65px;
		-webkit-border-radius: 2px;
		-moz-border-radius: 2px;
		border-radius: 2px;
		background-color: #FFFFFF;
		box-shadow: 0 2px 6px 0 rgb(120 120 120 / 50%);
		grid-template-columns: auto 1fr auto;
		margin-bottom: 25px;
		margin-top: 20px;
		position: relative;	
	}
	.charity-logo {
		margin-right: 45px;
		padding-right: 45px;
		border-right: 1px solid #D4D4D4;
		grid-column: 1 / 2;
	}
	.charity-desc {
		padding: 35px 0;
		grid-column: 2 / 3;
	}
	
	.jumbotrondata
	{
		min-height:400px;
		padding:40px
	}

	
	@media screen and (max-width: 764px) and (min-width:340px){
.main_charity_box{
           display:block;
	       padding: 0px 31px 2px 15px;
       }
		
		.jumbotrondata{
		padding:34px 4px; 
		}
		
		.charity-logo{
		margin:0px;
			border-right:none;
			width:100%;
			padding-top:8px;
		}
		
		.charity-desc{
		text-align: justify !important;	
		}
    
}
	#loading {
  width: 170px;
  height: 170px;
  margin: 30px auto;
  position: relative;
}
.outer-shadow,
.inner-shadow {
  z-index: 4;
  position: absolute;
  width: 100%;
  height: 100%;
  border-radius: 100%;
  
}
.inner-shadow {
 	top: 18%;
    left: 18%;
    width: 150px;
    height: 150px;
    margin-left: -20px;
    margin-top: -20px;
    border-radius: 100%;
    background-color: #1cd6cd;
	display: flex;
	  justify-content: center;
	  align-content: center;
	  flex-direction: column;
}
.hold {
  position: absolute;
  width: 100%;
  height: 100%;
  clip: rect(0px, 170px, 170px, 85px);
  border-radius: 100%;
  background-color: #fff;
}
.fill,
.dot span {
  background-color: #d5bda3;
}
.fill {
  position: absolute;
  width: 100%;
  height: 100%;
  border-radius: 100%;
  clip: rect(0px, 85px, 170px, 0px);
}
.left .fill {
  z-index: 1;
  -webkit-animation: left 1s linear;
  -moz-animation: left 1s linear;
  animation: left 1s linear both;
}
@keyframes left {
  0% {
    -webkit-transform: rotate(0deg);
  }
  100% {
    transform: rotate(180deg);
  }
}
@-webkit-keyframes left {
  0% {
    -webkit-transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(180deg);
  }
}
.right {
  z-index: 3;
  -webkit-transform: rotate(180deg);
  -moz-transform: rotate(180deg);
  transform: rotate(180deg);
}
.right .fill {
  z-index: 3;
  -webkit-animation: right 1s linear;
  -moz-animation: right 1s linear;
  animation: right 1s linear both;
}
@keyframes right {
  0% {
    -webkit-transform: rotate(0deg);
  }
  100% {
    transform: rotate(180deg);
  }
}
@-webkit-keyframes right {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(180deg);
  }
}
.inner-shadow img {
  margin-left: 8px;
  margin-top: 7px;
}
</style>
<section class="jumbotron text-center jumbotrondata">
    <div class="container">
		<h1 class="jumbotron-heading">Charities</h1>
		<div class="fund_circle">
			
			<div id='loading'>
			  <div class='outer-shadow'>
			  </div>
			  <div class='inner-shadow'>
				  <h4 style='color:white'>£ <span class='count'>  <?php  global $wpdb;
		echo $get_other_user_info = round($wpdb->get_var("select sum(price) as sum from PQrlH_transactions where payment_type = 'charity_funds'")); ?></span> </h4>
			  </div>
			  <div class='hold left'>
				<div class='fill'></div>
			  </div>
			  <div class='hold right'>
				<div class='fill'></div>
			  </div>

			</div>
			
			
			<!--<div class="chairty_total_fund">
				<h4>£ <span class='count'> <?php global $wpdb;
		echo $get_other_user_info = round($wpdb->get_var("select sum(price) as sum from PQrlH_transactions where payment_type = 'charity_funds'")); ?></span> </h4>
			</div>-->
			<p><b> Total raised for charity </b></p>
		</div>
		
		<div class="how_to_help">
			<h4> How we help each other donate: </h4>
			<p>Here at winners wish charity is entwined with everything that we do.
That is why we donate 5% of each competition entry sold to charity. And you decide where that
money goes by selecting one of our charity partners in our members area, and change your cause
				any time you like.</p>
			<p>By going this, winners wish and our members work together to give back and support charitable
organisations. Check out our charity page to see the organisations we support and the latest
				donation updates.</p>
			<p> Below are the charitable organisations that we work with. </p>
		</div>
		
		<h1 class="jumbotron-heading">The wonderful charities we support</h1>
		<p>Learn more about the valuable work that our partner charities carry out.</p>
		<?php 
		$args = array(
			'post_type'=> 'charity',
			'post_per_page'    => -1,
			'order'    => 'DESC'
		);              

		$the_query = new WP_Query( $args );
		if($the_query->have_posts() ) : 
			while ( $the_query->have_posts() ) : 
			  $the_query->the_post();
		
		?>     
	<div class="main_charity_box">
		<div class="charity-logo"><img class="img-fluid" src="<?php echo get_the_post_thumbnail_url(get_the_ID());?>" alt="Alzheimer's Society" width="180" height="180"></div>
		<div class="charity-desc" style='text-align:left'>
                    <h3><?php echo the_title();?></h3>
                    <p><?php echo get_the_content(get_the_ID());?></p>
					
				</div>
	</div>
		
	<?php  endwhile; 
    wp_reset_postdata(); 
else: 
endif; ?>	
		
</div>
</section>






<?php 
get_footer();
?>

<script>
jQuery(function($){

  $('.count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 2000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
        }
    });
  });
  
});	
	
</script>