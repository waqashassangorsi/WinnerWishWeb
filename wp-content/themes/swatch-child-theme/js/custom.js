jQuery(document).ready(function($) {
	
		/*$.ajax({
		    url: "https://ranaentp.net:3020/api/get_all_users",
		    type:'POST',
		    success: function(result){
                console.log(result);
            }
		    
		});*/
		
		$(document).on('click','.btn-add_top_up',function(){
		
			if($('.paymnet_method_balance').is(':checked')){
				$('.balance_error').text('');
				
				if($(this).val() == "balance_from_paypal"){
					
				}
				
			}else{
				
				$('.balance_error').css('color','red').text("Please  Choose topup method!");
			
			}
		
		});
	
		
	  $(document).on('submit','#balance_paypal_form',function(){
	  
		  if($('.amount_topup').val() == ""){
		  		$('.balance_error').css('color','red').text("Please enter topup amount");
			  return false;
		  }else{
		  
			  $(this).submit();
		  
		  }
	  
	  });
	
	 $(document).on('change','amount_topup',function(){
		 if($(this).val()  != ""){
			 $('.balance_error').text();
		 }else{
		 	 $('.balance_error').css('color','red').text("Please enter topup amount");
		 }
		 
	 });
	
	   $(document).on('click','.paymnet_method_balance',function(){
	   
	   if($('.paymnet_method_balance').is(':checked')){
				$('.balance_error').text('');
				if($(this).val() == "balance_from_paypal"){
					$('.balance_form_credit').hide();
				  	$('.btn-add_top_up').remove();
					$('.balance_form').show();
				}else{
					$('.balance_form_credit').show();
					$('.btn-add_top_up').remove();
					$('.balance_form').hide();
				   
				}
			}
		   
	   });
	
	   //var current_page_link = document.location.href;
	   $('.expired').tooltip();
		$('.resetPrice').tooltip();
		//alert(current_page_link.split("/"));
	
	
    $(document).on('click', '.btn_cart', function() {
		var charity = $(this).attr('data-charity');
		var raffle_id = $(this).data('raffle');
        var total_amount = $('.total_amount').attr('data-total');
		console.log(total_amount);
		var bgcolor = $(this).data('color');
        var price = $(this).data('price');
		console.log(price);
        var element_click = $(this);
        var quantity = Number($(this).parents('.cart_buttons').siblings('.qty_buttons').find('.quantity').text());
		if(quantity == 0 || quantity == undefined ){
			 quantity = Number($(this).parents('.cart_buttons').siblings('.qty_section').children('.quantity_section3').find('.quantity').text());
		}
		if(charity == ""){
			 $('#myModal_charity').modal('show');
			$.ajax({
            url: js_data.ajax_url,
            type: "POST",
            data: { 'action': 'get_charities'},
            dataType: "json",
            beforeSend: function() {
                $('.body_charity').html('<i class="fa  fa-spinner fa-spin"></i>');
            },
            success: function(data) {
			if(data.error){
			
			}else{
				var charities_data =  data.charities;
				if(charities_data.length > 0){
				var select_options = "<select  name='charity_op' class='form-control charity_op' style='width: 100%;border: 1px solid gainsboro;'><option value='' selected disabled> Select Charity</option>";
				for(var i = 0;i < charities_data.length ;i++){
					select_options += "<option value='"+charities_data[i].cat_id+"'>"+charities_data[i].cat_name+"</option>";
				}
				select_options += "</select>";
				$('#ok_add_to_cart').attr({'data-raffle_id':raffle_id,'data-total':total_amount,'data-quantity':quantity,'data-bgcolor':bgcolor,'data-price':price});	
				 $('.body_charity').html(select_options);
				}else{
				
				$('.body_charity').html("<p style='color:red'> No Charities Available Yet!</p>");
				}
			}
				
			}
			});
		  
		}else{
		//console.log(typeof(quantity));
        $.ajax({
            url: js_data.ajax_url,
            type: "POST",
            data: { 'action': 'add_to_cart', 'raffle': raffle_id, 'qty': quantity ,'bgcolor':bgcolor,'charity':charity},
            dataType: "json",
            beforeSend: function() {
                element_click.children('.loader').html('<i class="fa  fa-spinner fa-spin"></i>');
            },
            success: function(data) {
                if (!data.error) {
					var total =Number(total_amount) + ( Number(price) * quantity );
                    element_click.children('.loader').html('');
					element_click.text('Added');
					element_click.removeClass('btn_cart');
					element_click.prop('disabled',true);
                    $('.cart_counting').text(data.total_items);
                    $('.total_amount').text( total  + '.00' );
					$('.total_amount').attr('data-total',total);
                } else {
                    console.log('Something went wrong with cart');
                }
            }
        });
		}

    });
	
	
	$(document).on('click','#ok_add_to_cart',function(){
		
		var charity = $(this).attr('data-charity');
		
		if(charity != "" && charity != undefined){
			var raffle_id = $(this).data('raffle_id');
			var total_amount = $('.total_amount').attr('data-total');
			console.log(total_amount);
			var bgcolor = $(this).data('color');
			var price = $(this).data('price');
			var element = $(this);
			var quantity = $(this).data('quantity');
			$.ajax({
				url: js_data.ajax_url,
				type: "POST",
				data: { 'action': 'add_to_cart', 'raffle': raffle_id, 'qty': quantity ,'bgcolor':bgcolor,'charity':charity},
				dataType: "json",
				beforeSend: function() {
					element.html('OK <i class="fa  fa-spinner fa-spin"></i>');
				},
				success: function(data) {
					if (!data.error) {
						var total =Number(total_amount) + ( Number(price) * quantity );
						element.html(' OK ');
						$('.btn_cart[data-raffle|='+raffle_id+']').text('Added');
						$('.btn_cart[data-raffle|='+raffle_id+']').prop('disabled',true);
						$('.btn_cart[data-raffle|='+raffle_id+']').removeClass('btn_cart');
						
						$('.cart_counting').text(data.total_items);
						$('.total_amount').text( total  + '.00' );
						$('.total_amount').attr('data-total',total);
						$('#myModal_charity').modal('hide');
					} else {
						console.log('Something went wrong with cart');
					}
				}
			});
		}else{
			$('<p style="color:red">Please Choose Charity</p>').insertAfter($('.charity_op'));
		}
	
	});
	
	 $(document).on('change', '.charity_op', function() {
		
		 if($(this).val() != ""){
		 	// alert($(this).val());
			 $('.btn_cart').attr('data-charity',$(this).val());
			 $('#ok_add_to_cart').attr('data-charity',$(this).val());
			 
		 }
	 });
	
	$(document).on('click', '.instant_buy', function() {
        var raffle_id = $(this).data('raffle');
        var total_amount = $('.total_amount').attr('data-total');
		console.log(total_amount);
		var bgcolor = $(this).data('color');
        var price = $(this).data('price');
		console.log(price);
        var element_click = $(this);
        var quantity = Number($(this).parents('.cart_buttons').siblings('.qty_buttons').find('.quantity').text());
		if(quantity == 0 || quantity == undefined ){
			 quantity = Number($(this).parents('.cart_buttons').siblings('.qty_section').children('.quantity_section3').find('.quantity').text());
		}
        $.ajax({
            url: js_data.ajax_url,
            type: "POST",
            data: { 'action': 'add_to_cart', 'raffle': raffle_id, 'qty': quantity,'bgcolor':bgcolor },
            dataType: "json",
            beforeSend: function() {
                element_click.children('.loader').html('<i class="fa  fa-spinner fa-spin"></i>');
            },
            success: function(data) {
                if (!data.error) {
					/*var total =Number(total_amount) + ( Number(price) * quantity );
                    element_click.children('.loader').html('');
					element_click.text('Added');
					element_click.removeClass('btn_cart');
					element_click.prop('disabled',true);
                    $('.cart_counting').text(data.total_items);
                    $('.total_amount').text( total  + '.00' );
					$('.total_amount').attr('data-total',total);*/
					window.location.href = "/newcart/";
                } else {
                    console.log('Something went wrong with cart');
                }
            }
        });



    });

	$(document).on('click','.btn-username',function(){
		$('#passwordform').hide();
		$('#userform').show();
		
	});
	$(document).on('click','.btn-password',function(){
		$('#userform').hide();
		$('#passwordform').show();
	});
	
$(document).on('click','.security_quest',function(){

	var ele = $(this).parents('.radio');
	var answer = $(this).val();
	var correct = $(this).parents('.radio').siblings('#correct').val();	
	if(answer == correct){
		ele.siblings('.answer_status').css('color','green').text('');
		
		console.log('corrected')
	}else{
		ele.siblings('.answer_status').css('color','red').text('');
	    
		//console.log('In corrected')
	}


});
	

$(document).on('change','#charity_setting_front',function(){
	if (confirm('Are you sure you want update Charity?')){
		$('#charity_setting_front').submit();
	}else{
		return false;
	}
});
	
$(document).on('change','.quantity',function(){
	var ele = $(this);
	var value = $(this).val();
	if(value == 0){
		    var item_id = ele.find(':selected').attr('data-element');
			if (confirm('Are you sure you want to remove this?')) {
				$.ajax({
					url: js_data.ajax_url,
					type: "POST",
					data: { 'action': 'remove_from_cart', 'raffle': item_id},
					dataType: "json",
					beforeSend: function() {
						ele.siblings('.loader').html('<i class="fa  fa-spinner fa-spin"></i>');
					},
					success: function (data) {
						ele.siblings('.loader').html('');
						location.reload();
						
					}
				});
    		}else{
			
				ele.val($.data(ele, 'val')); //set back
 			    return; 
			
			}
	
	}else{
	   var item_id = ele.find(':selected').attr('data-element');
		$.ajax({
					url: js_data.ajax_url,
					type: "POST",
					data: { 'action': 'add_to_cart', 'raffle': item_id,'qty':value},
					dataType: "json",
					beforeSend: function() {
						ele.siblings('.loader').html('<i class="fa  fa-spinner fa-spin"></i>');
					},
					success: function (data) {
						ele.siblings('.loader').html('');
						location.reload();
						
					}
				});
	
	}


});

$(document).on('click','.expand',function(){
	var lottery = $(this).data('lottery');
	if($(this).hasClass('active_lottery')){
		$(this).text('+');
		$('.tickets_'+lottery).slideUp("slow");
		$(this).removeClass('active_lottery');
	}else{
		$(this).text('-');
		$(this).addClass('active_lottery');
		$('.tickets').slideUp("slow");
		$(this).parents('tr').siblings('.tickets_'+lottery).slideDown("slow");
	}

});

$(document).on('change','.cateogry',function(){
	
		if($(this).val() != ""){
			window.location.href = "https://ranaentp.net/winnerwish/allcompetiton/?page_id=1432&category="+$(this).val();
		}
	
	
	})

$(document).on('click','.paymnet_method,.paymnet_method_subscribe',function(){
	if($(this).val() == 'balance'){
		$('.payment_method_cards').hide();
		$('.payment_method_paypal').hide();
		$('.payment_method_balance').show();
	
	
	}else if($(this).val() == 'paypal'){
		$('.payment_method_cards').hide();
		$('.payment_method_paypal').show();
		$('.payment_method_balance').hide();
	
	}else if($(this).val() == 'cards'){
		$('.payment_method_paypal').hide();
		$('.payment_method_balance').hide();
		$('.payment_method_cards').show();
		/*var userid = $(this).data('userid');
		if( userid  !=""){
		/// Fetching Cards
			$.ajax({
					url: js_data.ajax_url,
					type: "POST",
					data: { 'action': 'get_saved_cards', 'userid': userid},
					dataType: "json",
					beforeSend: function() {
						$('.methods_type').prepend('<i class="fa fa-spinner fa-spin loading"></i>');
					},
					success: function (data) {
						if(data.error){
							$('.loading').remove();
							   $('.new_card_option').show();
							   $('.payment_method_cards').show();
						}else{
							var carddetail = data.cards;
							var html = "";
							for(var i = 0 ; i < carddetail.length; i++){
								var checkcard = "";
								//console.log(datacard[i]);
								if(i == 0){
								 checkcard = "checked";
								}
								var single = carddetail[i];
								if( carddetail[i].brand== "Visa"){
								var img = "<img src='https://cdn.iconscout.com/icon/free/png-512/visa-3-226460.png' width='64px'>"
								}
								//console.log(carddetail[i].brand + "------ " + carddetail[i].last4);
html += "<label class='radio'> <input type='radio' name='optionsRadios' "+checkcard+" class='already_saved' id='optionsRadios"+i+"' value='"+carddetail[i].brand+"' >"+img+"*********"+carddetail[i].last4+"</label>";
										
							}
							html += '<label class="radio"> <input type="radio" name="optionsRadios" class="already_saved" id="addnew" value="add_new_card" >Add new </label>';
							$('.option_cards').html(html);
							$('.loading').remove();
							$('.payment_method_cards').show();
						}
					}	
				});
		}else{
			
			$('.payment_method_cards').show();
		
		}
		*/
	
	
	}

});
	
$(document).on('click','.already_saved',function(){
	
	if($(this).val() == "add_new_card"){
	
			$('.new_card_option').show();
	
	}else{
	
		$('.new_card_option').hide();
	}
	
	
});


$(document).on('change','.voucher_code',function(){
			var code  = $(this).val();
			var ele  = $(this);
			if(code != ""){
			$.ajax({
					url: js_data.ajax_url,
					type: "POST",
					data: { 'action': 'check_voucher', 'code': code},
					dataType: "json",
					beforeSend: function() {
						ele.siblings('.loader_voucher').html('<i class="fa  fa-spinner fa-spin"></i>');
					},
					success: function (data) {
						if(data.error){
							ele.siblings('.loader_voucher').html('');
							ele.siblings('.loader_voucher').css('color','red').text(data.error_msg);
							$('.discounted').remove();
							var old_price = Number( $('#old_price').text());
							$('#old_price').text(old_price);
						}else{
							ele.siblings('.loader_voucher').css('color','green').text(data.success_msg);
							
							var voucher =  data.voucher_detail;
							var vprice = Number(voucher.vprice);
							var old_price = Number( $('#old_price').text());
							
							var discounted_price = old_price - ((old_price*vprice)/100);
							
							var old = '<del>'+old_price+'</del>';
							var new_price  = " <span style='margin-left:10px' class='discounted'><span class='gbpfont'> USD </span> "+discounted_price+"</span>";
							$('#old_price').html(old);
							$('.tot_price').append(new_price);
						
						}
					}	
				});
			}else{
				ele.siblings('.loader_voucher').html('');
				$('.discounted').remove();
				var old_price = Number( $('#old_price').text());
				$('#old_price').text(old_price);
			}

});

	

//// Order Creation //////
$(document).on('click','.checkbtn',function(){

	// Getting the cart items with Quantity
	var lottries = "";
	var security_ans = "";
	var checked =  true;
	var lottries_array = [];
	
	$('.single_item').each(function(key, item){
		var sec_answer = "";
		if( ! $(item).find('.security_quest').is(':checked')){
		
		   $(item).find('.answer_status').css('color','red').text('Please answer the Question');
			checked =  false;
		
		}else if( $(item).find('.security_quest:checked').val() != $(item).find('#correct').val()){
				 
			//$(item).find('.answer_status').css('color','red').text('Incorrect answer');
			sec_answer = "false";
			checked =  true;
				 
		}else if( $(item).find('.security_quest:checked').val() == $(item).find('#correct').val()){
				 
			//$(item).find('.answer_status').css('color','red').text('Incorrect answer');
			sec_answer = "true";
			checked =  true;
				 
		}
		
		
		
		
		
		var single_lottry =  [];
		var lottry_id = $(item).data('itemid');
		var quantity = $(item).find('.quantity').val();
		lottries += lottry_id+",";
		security_ans+= sec_answer+",";
		var obj = {"lottry_id":lottry_id,"quantity" : quantity,"sec_answer":sec_answer}
		
		//single_lottry.push(obj);
		lottries_array.push(obj);
	
	});
	
	if(checked){
		var voucher = $('.voucher_code').val();
		var total = $('#old_price').text();
		var payment_method = $('.paymnet_method:checked').val();
			$.ajax({
					url: js_data.ajax_url,
					type: "POST",
					data: { 'action': 'place_order', 'order_detail': lottries_array,'lottries':lottries,'security_ans':security_ans,'voucher':voucher,'total':total,'payment_method':payment_method},
					dataType: "json",
					beforeSend: function() {
						$.preloader.start({
							modal: true,
							src : js_data.theme_url+"loader.svg"
						});
					},
					success: function (data) {
						if(data.error){
							$.preloader.stop();
							alert(data.error_msg);
						}else{
							//alert(data.success_msg);
							window.location.href=data.payment_url;
							//$.preloader.stop();
						}
						
					}
			});
	}

});

//// End of Order Creation ////
	
//set your publishable key
var stripe = Stripe('pk_test_51H4QdgGmT7c3r5SQV7rLpB2t9BbdIq7yLOxvtielUJC6WrODrynbulG8nrGJ0rBF3XVGhL5LSK5XjJ9yQcixXgiw00edN1Sxa4');
console.log(stripe);
// Create an instance of elements
var elements = stripe.elements();

var style = {
    base: {
        fontWeight: 400,
        fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
        fontSize: '16px',
        lineHeight: '1.4',
        color: '#555',
        backgroundColor: '#fff',
        '::placeholder': {
            color: '#888',
        },
    },
    invalid: {
        color: '#eb1c26',
    }
};

var cardElement = elements.create('cardNumber', {
    style: style
});
cardElement.mount('#card_number');

var exp = elements.create('cardExpiry', {
    'style': style
});
exp.mount('#card_expiry');

var cvc = elements.create('cardCvc', {
    'style': style
});
cvc.mount('#card_cvc');

// Validate input of the card elements
var resultContainer = document.getElementById('paymentResponse');
cardElement.addEventListener('change', function(event) {
    if (event.error) {
        resultContainer.innerHTML = '<p>'+event.error.message+'</p>';
    } else {
        resultContainer.innerHTML = '';
    }
});

// Get payment form element
//var form = document.getElementById('paymentFrm');

// Create a token when the form is submitted.
/*form.addEventListener('submit', function(e) {
    e.preventDefault();
    createToken();
});
*/
// Create single-use token to charge the user
function createToken() {
    
}

// Callback to handle the response from stripe
function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);
	
    // Submit the form
    form.submit();
}

$(document).on('click','.balance_stripe',function(e){
	stripe.createToken(cardElement).then(function(result) {
			if (result.error) {
				// Inform the user if there was an error
				console.log(result.error);
				resultContainer.innerHTML = '<p>'+result.error.message+'</p>';
			} else {
				var obj =  result.token;
				var token_id = obj.id;
				var amount_topup_stripe = $('.amount_topup_stripe').val();
				$.ajax({
							url: js_data.ajax_url,
							type: "POST",
							data: { 'action': 'topup','token_id':token_id,'amount':amount_topup_stripe},
							dataType: "json",
							beforeSend: function() {
								$.preloader.start({
									modal: true,
									src : js_data.theme_url+"loader.svg"
								});
							},
							success: function (data) {
								
								$.preloader.stop();
								if(data.error){
									alert(data.$total);
								}else{
									window.location.href="https://winnerswish.com/?page_id=1752";
								}

							}
					});
				
			}
	
	
	});
});

// From balance 


$(document).on('click','.btn-balance',function(e){
		
			var balance = $(this).attr('data-balance');
			
			var lottries = "";var security_ans = "";
			var checked =  true;
			var lottries_array = [];

			$('.single_item').each(function(key, item){
				var sec_answer ="";
				if( ! $(item).find('.security_quest').is(':checked')){

				   $(item).find('.answer_status').css('color','red').text('Please answer the Question');
					checked =  false;

				}else if( $(item).find('.security_quest:checked').val() != $(item).find('#correct').val()){
				 
					//$(item).find('.answer_status').css('color','red').text('Incorrect answer');
					sec_answer = "false";
					checked =  true;

				}else if( $(item).find('.security_quest:checked').val() == $(item).find('#correct').val()){

					//$(item).find('.answer_status').css('color','red').text('Incorrect answer');
					sec_answer = "true";
					checked =  true;

				}





				var single_lottry =  [];
				var lottry_id = $(item).data('itemid');
				var quantity = $(item).find('.quantity').val();
				lottries += lottry_id+",";
				security_ans += sec_answer+",";

				var obj = {"lottry_id":lottry_id,"quantity" : quantity,"sec_answer":sec_answer}

				//single_lottry.push(obj);
				lottries_array.push(obj);

			});
			var total = $('#old_price').text();
	
			if(Number(total) > Number(balance)){
			
					$('.error_balance').css('color','red').html("<span>Sorry! Insufficient Balance. </span> <a href='?page_id=1792'> Add Balance </a>");
					checked = false;
					return false;
			}
	
			if(checked){
				var voucher = $('.voucher_code').val();
				
				var payment_method = $('.paymnet_method:checked').val();
					$.ajax({
							url: js_data.ajax_url,
							type: "POST",
							data: { 'action': 'place_order', 'order_detail': 					lottries_array,'lottries':lottries,'voucher':voucher,'total':total,'payment_method':payment_method},
							dataType: "json",
							beforeSend: function() {
								$.preloader.start({
									modal: true,
									src : js_data.theme_url+"loader.svg"
								});
							},
							success: function (data) {
								$.preloader.stop();
								if(data.error){
									$('.error_balance').css('color','red').html("<span>Sorry! "+data.error_msg+"</span> <a href='?page_id=1792'> Add Balance </a>");
								}else{
									window.location.href="https://winnerswish.com/?page_id=1752";
								}

							}
					});
				}
	
	
		
	
	
});


//// For Subscription

$(document).on('click','.checkoutbtnSubscription',function(e){

		var package_id = $('#package_id').val();
		var payment_method = $('.paymnet_method:checked').val();
		$.ajax({
			url: js_data.ajax_url,
			type: "POST",
			data: { 'action': 'place_subscription', 'package_id': 				package_id,payment_method:payment_method},
			dataType: "json", 
			beforeSend: function() {
				$.preloader.start({
					modal: true,
					src : js_data.theme_url+"loader.svg"
				});
			},
			success: function (data) {
				$.preloader.stop();
				if(data.error){
					alert(data.$total);
				}else{
					return stripe.redirectToCheckout({ sessionId: data.id });
				}
			}
		});
});

	

////// end of subscription from Cards

/// Stripe New
	$(document).on('click','.checkbtncards-new',function(){
			var lottries = "";var security_ans  = "";
			var checked =  true;
			var lottries_array = [];

			$('.single_item').each(function(key, item){
				var sec_answer = "";
				if( ! $(item).find('.security_quest').is(':checked')){

				   $(item).find('.answer_status').css('color','red').text('Please answer the Question');
					checked =  false;

				}else if( $(item).find('.security_quest:checked').val() != $(item).find('#correct').val()){
				 
					//$(item).find('.answer_status').css('color','red').text('Incorrect answer');
					sec_answer = "false";
					checked =  true;

				}else if( $(item).find('.security_quest:checked').val() == $(item).find('#correct').val()){

					//$(item).find('.answer_status').css('color','red').text('Incorrect answer');
					sec_answer = "true";
					checked =  true;

				}

				var single_lottry =  [];
				var lottry_id = $(item).data('itemid');
				var quantity = $(item).find('.quantity').val();
				lottries += lottry_id+",";
				security_ans += sec_answer+",";
				var obj = {"lottry_id":lottry_id,"quantity" : quantity,"sec_answer":sec_answer}

				//single_lottry.push(obj);
				lottries_array.push(obj);

			});
		
		if(checked){
			var voucher = $('.voucher_code').val();
			var total = $('#old_price').text();
			var payment_method = $('.paymnet_method:checked').val();
			var dataOrder = { 'action': 'place_order', 'order_detail': 					lottries_array,'lottries':lottries,'security_ans':security_ans,'voucher':voucher,'total':total,'payment_method':payment_method};		
			fetch("https://winnerswish.com/wp-content/themes/swatch-child-theme/create-checkout-session.php", {
				method: "POST",
				headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json'
			  },//make sure to serialize your JSON body
			  body: JSON.stringify(dataOrder)
			  })
			.then(function (response) {
			  return response.json();
			})
			.then(function (session) {
			  return stripe.redirectToCheckout({ sessionId: session.id });
			})
			.then(function (result) {
			  // If redirectToCheckout fails due to a browser or network
			  // error, you should display the localized error message to your
			  // customer using error.message.
			  if (result.error) {
				alert(result.error.message);
			  }
			})
			.catch(function (error) {
			  console.error("Error:", error);
			});
		}
	
	});
/// Stripe end

$(document).on('click','.checkbtncard',function(e){
	
	var token_id;
	var obj;
	//// check already_card 
	/*if(($('.option_cards').children().length <= 0) || $('.already_saved:checked').val() == 'add_new_card'){*/
	if(false){
		stripe.createToken(cardElement).then(function(result) {
			if (result.error) {
				// Inform the user if there was an error
				console.log(result.error);
				resultContainer.innerHTML = '<p>'+result.error.message+'</p>';
			} else {
				// Send the token to your server
				//console.log(result.token)
				obj =  result.token;
				console.log("obj");

				token_id = obj.id;

				console.log(token_id);
				//return;
				// Getting the cart items with Quantity
			var lottries = "";var security_ans  = "";
			var checked =  true;
			var lottries_array = [];

			$('.single_item').each(function(key, item){
				var sec_answer = "";
				if( ! $(item).find('.security_quest').is(':checked')){

				   $(item).find('.answer_status').css('color','red').text('Please answer the Question');
					checked =  false;

				}else if( $(item).find('.security_quest:checked').val() != $(item).find('#correct').val()){
				 
					//$(item).find('.answer_status').css('color','red').text('Incorrect answer');
					sec_answer = "false";
					checked =  true;

				}else if( $(item).find('.security_quest:checked').val() == $(item).find('#correct').val()){

					//$(item).find('.answer_status').css('color','red').text('Incorrect answer');
					sec_answer = "true";
					checked =  true;

				}





				var single_lottry =  [];
				var lottry_id = $(item).data('itemid');
				var quantity = $(item).find('.quantity').val();
				lottries += lottry_id+",";
				security_ans += sec_answer+",";
				var obj = {"lottry_id":lottry_id,"quantity" : quantity,"sec_answer":sec_answer}

				//single_lottry.push(obj);
				lottries_array.push(obj);

			});

			if(checked){
				var voucher = $('.voucher_code').val();
				var total = $('#old_price').text();
				var payment_method = $('.paymnet_method:checked').val();
					$.ajax({
							url: js_data.ajax_url,
							type: "POST",
							data: { 'action': 'place_order', 'order_detail': 					lottries_array,'lottries':lottries,'security_ans':security_ans,'voucher':voucher,'total':total,'payment_method':payment_method,'token_id':token_id},
							dataType: "json",
							beforeSend: function() {
								$.preloader.start({
									modal: true,
									src : js_data.theme_url+"loader.svg"
								});
							},
							success: function (data) {
								$.preloader.stop();
								if(data.error){
									alert(data.$total);
								}else{
									return stripe.redirectToCheckout({ sessionId: data.id });
									//window.location.href="https://winnerswish.com/?page_id=1752";
								}

							}
					});
				}
			}
		});
	}else{
	
		///// already saved card
		
		var already = $('.already_saved:checked').val();

		// Getting the cart items with Quantity
			var lottries = ""; var security_ans="";
			var checked =  true;
			var lottries_array = [];

			$('.single_item').each(function(key, item){
				var sec_answer = "";
				if( ! $(item).find('.security_quest').is(':checked')){

				   $(item).find('.answer_status').css('color','red').text('Please answer the Question');
					checked =  false;

				}else if( $(item).find('.security_quest:checked').val() != $(item).find('#correct').val()){
				 
					//$(item).find('.answer_status').css('color','red').text('Incorrect answer');
					sec_answer = "false";
					checked =  true;

				}else if( $(item).find('.security_quest:checked').val() == $(item).find('#correct').val()){

					//$(item).find('.answer_status').css('color','red').text('Incorrect answer');
					sec_answer = "true";
					checked =  true;

				}

				var single_lottry =  [];
				var lottry_id = $(item).data('itemid');
				var quantity = $(item).find('.quantity').val();
				lottries += lottry_id+",";
				security_ans += sec_answer+",";
				var obj = {"lottry_id":lottry_id,"quantity" : quantity,"sec_answer":sec_answer}

				//single_lottry.push(obj);
				lottries_array.push(obj);

			});

			if(checked){
				var voucher = $('.voucher_code').val();
				var total = $('#old_price').text();
				var payment_method = $('.paymnet_method:checked').val();
					$.ajax({
							url: js_data.ajax_url,
							type: "POST",
							data: { 'action': 'place_order', 'order_detail': 					lottries_array,'lottries':lottries,'security_ans':security_ans,'voucher':voucher,'total':total,'payment_method':payment_method,'already_saved':already},
							dataType: "json",
							beforeSend: function() {
								$.preloader.start({
									modal: true,
									src : js_data.theme_url+"loader.svg"
								});
							},
							success: function (data) {
								$.preloader.stop();
								if(data.error){
									alert(data.$total);
								}else{
									return stripe.redirectToCheckout({ sessionId: data.id });
									//window.location.href="https://winnerswish.com/?page_id=1752";
								}

							}
					});
				}
			
	
	
	}
    
});
	
	/* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Full name:</td>'+
            '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Extension number:</td>'+
            '<td>'+d.extn+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Extra info:</td>'+
            '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
    '</table>';
}
 

    var table = $('#example').DataTable( {
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            }
        ],
        "order": [[1, 'asc']]
    } );
     

$(document).ready(function() {
	var showChar = 10;
	var ellipsestext = "...";
	var moretext = "more";
	var lesstext = "less";
	$('.more').each(function() {
		var content = $(this).html();

		if(content.length > showChar) {

			var c = content.substr(0, showChar);
			var h = content.substr(showChar-1, content.length - showChar);

			var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

			$(this).html(html);
		}

	});

	$(".morelink").click(function(){
		if($(this).hasClass("less")) {
			$(this).removeClass("less");
			$(this).html(moretext);
		} else {
			$(this).addClass("less");
			$(this).html(lesstext);
		}
		$(this).parent().prev().toggle();
		$(this).prev().toggle();
		return false;
	});
});	
	

		//$('.leftcard_ul li a[href="' + location.pathname.split("/")[location.pathname.split("/").length-1] + '"]').parent().addClass('active-menu');
	

});