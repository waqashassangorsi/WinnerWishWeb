
        </div>

        <?php $swatch = oxy_get_option('footer_swatch'); ?>
        <?php $upper_swatch = oxy_get_option('upper_footer_swatch'); ?>




        <footer id="footer" role="contentinfo">
        
            <?php if(is_active_sidebar('footer-middle') || is_active_sidebar('footer-right') || is_active_sidebar('footer-left') || is_active_sidebar('footer-middle-left') || is_active_sidebar('footer-middle-right')): ?>
            <div class="section swatch-midnightblue">
                <div class="container">
                    <div class="row-fluid">
                    <?php   $columns = oxy_get_option('footer_columns');
                    $span = $columns == false? 'span12':'span'.(12/3);
                        
                        ?>
                            <div class="<?php echo $span; ?>"><?php dynamic_sidebar("footer-left"); ?></div>
                            <div class="<?php echo $span; ?> text-left"><?php dynamic_sidebar("footer-middle"); ?></div>
                            <div class="<?php echo $span; ?> text-left"><?php dynamic_sidebar("footer-right"); ?></div>
                        
                    </div>
					
					<div class="row-fluid" style='border-top:1px solid gainsboro;margin-top: 30px;padding: 12px 0px;'>
					<div class='span6'>
					 <p> Follow us on 
						 <a href="Www.facebook.com" class="fa fa-facebook"></a> <a href="Www.instagram.com" class="fa fa-instagram"></a></p>
						<p> Developed by <a href="http://sysbitechies.com/" target="_blank" style="color:#ec8783">Sysbi Techies </a></p>
					<!--<a href="#" class="fa fa-instagram"></a></p>-->
					</div>
					<div class='span6 text-right hidden-phone'>
					 <p> Download our Mobile app 
					 <a href="#" class="fa fa-android"></a>
					 <a href="#" class="fa fa-apple"></a>
					 </p>
					</div>
					<div class='span6 visible-phone'>
					 <p> Download our Mobile app 
					 <a href="#" class="fa fa-android"></a>
					 <a href="#" class="fa fa-apple"></a>
					 </p>
					</div>
					</div>
				
				
                </div>
				
				
            </div>
			
			
			
            <?php endif; ?>
        </footer>
		
		

        <!-- Fixing the Back to top button -->
        <?php $swatch = oxy_get_option('back_to_top_swatch'); ?>
        <?php $enable = oxy_get_option('back_to_top');

        if( $enable == 'enable' ){ ?>
            <a href="javascript:void(0)" class="<?php echo $swatch; ?> go-top">
                <i class="fa fa-angle-up">
                </i>
            </a>
                         <?php   } ?>



        <script type="text/javascript">
            //<![CDATA[
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', '<?php echo oxy_get_option( 'google_anal' ) ?>', 'auto');
            ga('send', 'pageview');
            //]]>
        </script>



        <?php wp_footer(); ?>
    </body>
<!-- The Modal -->
  <div class="modal signupmodalmain" id="myModalsignup" style="display:none">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
       
        <!-- Modal body -->
        <div class="modal-body modalbodypart1">
            <div class="col-sw-6" id="myDiv1">
               <div class="col-sw-12">
                   <img src="http://localhost/wwish/wp-content/themes/swatch/images/image (8).png" style="width: 12%">
               </div>
               <div class="col-sw-12 mainpagesignup">
                   <h3 class="signintext1 signintextcenter">Sign in to WinnerWish</h3>
               </div>

               <div class="col-sw-12 signintextcenter">
                   <i class="fa fa-facebook modalmainfacebook" aria-hidden="true"></i>
                    <i class="fa fa-google-plus modalmainfacebook" aria-hidden="true"></i>
                    <i class="fa fa-linkedin modalmainfacebook" aria-hidden="true"></i>
               </div>
               
               <div class="col-sw-12 signintextcenter">
                <p>or use your email account:</p>
                </div>

                <div class="col-sw-12">
                   <form>
                      <div class="form-group mainmodalcontact">
                        <input type="text" class="form-control controlform cartfomrwidth" id="cardnumber" placeholder="Email">
                      </div>
                      <div class="form-group mainmodalcontact">
                        <input type="text" class="form-control controlform cartfomrwidth" id="cardholdername" placeholder="Password">
                      </div>

                      <div class="col-sw-12 signintextcenter">
                          <p>Forgot Your Password?</p>
                      </div>
                      
                      <div class="col-sw-12 signintextcenter">
                        <button type="button" class="btn btn-default signinmodalbtn2 signinmodalbtn3">SIGN IN</button>
                     </div>
                 </form>
              </div>

            </div>
              
              <div class="col-sw-4 modalbgpart1 modalbgpart3" id="myDiv2">
               <div class="col-sw-12 modalbgpart2">
                   <h3 class="whitetextmain">HELLO,FRIEND!</h3>
                   <p class="whitetextmain">Enter Your Personal deatils and start journey with us </p>
                    <button type="button" class="btn btn-default signinmodalbtn2 signinmodalbtn5 ">SIGN UP</button>
               </div>
              </div>
        </div>
        
        <!-- Modal footer -->
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div> -->
        
      </div>
    </div>
  </div>
</html>
<script type="text/javascript" src="<?php echo  get_stylesheet_directory_uri()."/js/slick.min.js"; ?>"></script>



<script src="https://kenwheeler.github.io/slick/slick/slick.js"></script>

<script>
     jQuery(document).ready(function($){
		 
		 $('.scroll-men').slick({
		 	infinite: true,
		    slidesToShow: 10,
		    slidesToScroll: 3,
			prevArrow: $('#left-arrow'),
			nextArrow: $('#right-arrow'),
			 responsive: [
				{
				  breakpoint: 1024,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 3,
					infinite: true,
					dots: true
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 2
				  }
				},
				{
				  breakpoint: 480,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 2
				  }
				}
			  ]
		 });
		 
		 
        $('.signinmodalbtn3').click(function(){
      
      //$("#myDiv1").css({"float": "right"});
      
          $("#myDiv1").animate({left: '250px'});
          $('#myDiv2').animate({right: '250px'});
        });
     
     $('.signinmodalbtn5').click(function(){
 
        // $("#myDiv1").css({"float": "left"});
   
      
          $("#myDiv2").animate({left: '250px'});
          $('#myDiv1').animate({right: '250px'});
     });
	 
	 $(document).on('click','.add_btn',function(){
		
		 var quantity = $(this).siblings('.quantity').text();
		  
	
		 var min  = Number($(this).siblings('button').data('min'));
		 $(this).siblings('.quantity').text( Number(quantity) + min );
		 $(this).parents('.qty_buttons').siblings('.cart_buttons').find('#btn_cart').addClass('btn_cart').text('Add To Cart');
		 $(this).parents('.qty_section').siblings('.cart_buttons').find('#btn_cart').addClass('btn_cart').prop('disabled',false).text('Add To Cart');
		 
	 });
	 
	 $(document).on('click','.minus_btn',function(){
		 
		 var quantity = $(this).siblings('.quantity').text();
	     var min = $(this).data('min');
		 var single_price = $(this).parents('.qty_buttons').siblings('.cart_buttons').find('#btn_cart').attr('data-price');
		 //alert(single_price);
		 if(single_price == undefined || single_price == ""){
		 	single_price = $(this).parents('.qty_section').siblings('.cart_buttons').find('#btn_cart').attr('data-price');
		 }
		 var q = Number(quantity) - Number(min);
		 if( q <= Number(min)){
			 q = Number(min);//(name === 'true') ? 'Y' :'N'
			 
			 var existing_qty = $('.cart_counting:last').text();
			 //alert(existing_qty);
			 //alert(Number(existing_qty) - 1)
			 if( (Number(existing_qty) - 1 ) <= 0){
			 	$('.cart_counting').text(0);
			 }else{
				// alert('asdfsdfkl')
			 	$('.cart_counting').text(Number($('.cart_counting').text()) - 1);
			 }
			  
			  /*var total_amount = $('.total_amount').attr('data-total');
			  $('.total_amount').text(total_amount + ".00");
			 $('.total_amount').attr('data-total',total);*/
			 var total_amount = $('.total_amount').attr('data-total');
			 var total = Number(total_amount) - Number(single_price);
			 if(total <= 0)
				 total = 0;
			  $('.total_amount').text(total + ".00");
			 $('.total_amount').attr('data-total',total);
		 }else{
			 var total_amount = $('.total_amount').attr('data-total');
			 var total = Number(total_amount) - Number(single_price);
			 if(total <= 0)
				 total = 0;
			  $('.total_amount').text(total + ".00");
			 $('.total_amount').attr('data-total',total);
		 }
		 $(this).siblings('.quantity').text(q);
		  $(this).parents('.qty_buttons').siblings('.cart_buttons').find('#btn_cart').addClass('btn_cart').prop('disabled',false).text('Add To Cart');
		 $(this).parents('.qty_section').siblings('.cart_buttons').find('#btn_cart').addClass('btn_cart').prop('disabled',false).text('Add To Cart');
		 
	 });
	 
	 
	 //// Instant Buy Button
	 
	 $(document).on('click','.instant_buyddd',function(){
		 
		 var imgscr = $(this).parents('.inner').siblings('.inner').find('img').attr('src');
		 var heading = $(this).parents('.cart_buttons').siblings('.heading').find('h3').text(); 
		 var instant_data = '<div class="col-sw-12 modalheadercompet"><div class="col-sw-4"> <img src="'+imgscr+'" style="width: 51%"></div><div class="col-sw-5 imagetextcompet"><h3 class="modal-title winadiamond">'+heading+'</h3></div></div><div class="security_question2"><div class="question"><p> This is the Question</p></div><div class="answer"> <label class="radio radiobtn"> <input type="radio" id="inlineCheckbox1" name="answer" value="option1"> <strong>$55</strong> </label> <label class="radio radiobtn"> <input type="radio" id="inlineCheckbox2" name="answer" value="option2"> <strong>$55</strong> </label><label class="radio radiobtn"> <input type="radio" id="inlineCheckbox3" name="answer" value="option3"> <strong>$55</strong> </label></div></div><div class="item_quantity2"> <label><strong> Quantity </strong> </label> <select><option selected></option><option>0</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option> </select></div><div class="col-sw-12 totalcompt totalcompt2"><div class="col-sw-5"><strong>Total</strong></div><div class="col-sw-5"><strong>$900</strong></div></div><div class="col-sw-12 totalcompt"><div class="col-sw-5"><strong>Voucher Code<span class="ifanywinner">(if any)</span></strong></div><div class="col-sw-5"><u>underline</u></div></div><div class="col-sw-12 totalcompt"><div class="col-sw-5"><strong>Pay With</strong></div><div class="col-sw-5"><div class="answer"> <label class="radio"> <input type="radio" id="inlineCheckbox1" name="answer" value="option1">Balance </label><label class="radio"> <input type="radio" id="inlineCheckbox2" name="answer" value="option2"> Saved Card </label><label class="radio"> <input type="radio" id="inlineCheckbox3" name="answer" value="option3"> New Card </label><label class="radio"> <input type="radio" id="inlineCheckbox3" name="answer" value="option3"> Via PayPal </label></div></div></div><div class="col-sm-12"> <button type="submit" class="checkoutbtncart btn btn-default checkbtn">Enter Now</button></div>';
		 
		 $('.modal-body').html(instant_data);
		 
		 $('#myModal').modal('show');
		 
		 
	 });
	 
	 
	 
	 
	 
	 
	 
	 //// Instant Buy Button
	 
	 
	 
	 
	 
    });
</script>