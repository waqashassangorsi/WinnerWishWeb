jQuery.noConflict();
jQuery(document).ready(function($){

$(document).on('change','.subscription_options',function(){
	$('#subscription_filter').submit();
});
// Month FIltering Call
$(document).on('change','.months_option',function(){
		var month = $(this).val();
		if($('.page').val() == 'charity'){
		$.ajax({
				url: js_admin_data.ajax_url,
				type: "POST",
				data: { 'action': 'get_funds_filter',month:month,type:'months'},
				dataType: "json",
				beforeSend: function() {
					$('.charity_fun').html('<i class="fa  fa-spinner fa-spin"></i>');
				},
				success: function(data) {
					$('.charity_fun').html('');
					var details =  data.total_funds_with_id;
					for(var i  = 0;i < details.length ; i++){
						var single = details[i];
						$('.charity_'+single.charity_id).html(single.charity_funds);
					}
				}
			});
		}else if($('.page').val() == 'orders'){
			$('#my_order_form').submit();
		
		
		}else if($('.page').val() == 'transaction'){
			$('#my_order_form').submit();
		
		
		}
	

});
	/// select box gift type
	$(document).on('submit','#gift_form',function(){
		if($('.gifttype').is(':checked')){
			if($('.gifttype:checked').val() == 'balance'){
				if($('.gift_amount').val() == "" ){
					alert('please enter amount')
					return false;
				}
			}else{
				if($('#raf').val() == "" || $('.tickets').val() == "" ){
					alert('please fill fields')
					return false;
				}
			}
			$('#gift_form').submit();
		}else{
			$('.error_uncheck').css('color','red').text('Please select Gift Type');
			return false;
		}
	
	})
	
	$(document).on('click','.gifttype',function(){
		$('.error_uncheck').text('');
		if( $(this).val() == 'balance'){
			$('.balance').show();
		    $('.tickets').hide();
		}else{
			$('.balance').hide();
		    $('.tickets').show();
		}
	
	})
	
	
	/// Custom FIltering Call
$(document).on('click','.filter_custom',function(){
		var range = $('#filter_charity_funds').val();
		if($('.page').val() == 'charity'){
		$.ajax({
				url: js_admin_data.ajax_url,
				type: "POST",
				data: { 'action': 'get_funds_filter',range:range,type:'custom'},
				dataType: "json",
				beforeSend: function() {
					$('.charity_fun').html('<i class="fa  fa-spinner fa-spin"></i>');
				},
				success: function(data) {
					$('.charity_fun').html('');
					var details =  data.total_funds_with_id;
					for(var i  = 0;i < details.length ; i++){
						var single = details[i];
						$('.charity_'+single.charity_id).html(single.charity_funds);
					}
				}
			});
		}else if($('.page').val() == 'orders'){
			$('#my_order_form_custom').submit();
		
		
		}else if($('.page').val() == 'transaction'){
			$('#my_order_form').submit();
		
		
		}
});

$(document).on('change','#filtering_option',function(){
	if($(this).val() == 'monthly'){
		var now = new Date();
		var options = "<option>Select Month</option>";
			var months = new Array( "January", "February", "March", "April", "May","June", "July", "August", "September", "October", "November","December");
		 options += "<option value='"+now.getMonth()+','+now.getFullYear()+"'>This Month</option>";
		for(var i=0; i<=11;i++){
		   now.setMonth(now.getMonth() - 1);
		   //console.log(months[now.getMonth()]+' '+now.getFullYear());
			options += "<option value='"+now.getMonth()+','+now.getFullYear()+"'>"+months[now.getMonth()]+' '+now.getFullYear()+"</option>";
		}
		$('.months_option').html(options);
		$('.dates_range').hide();
		$('.months').show();
	}else if($(this).val() == 'custom'){
		$('.months').hide();
		$('.dates_range').show();
	
	}
});	
	
	
$(document).on('change','#ticket_name',function(){
	var ticket = $(this).val();
	if(ticket != ""  && ticket.length > 4){
			$.ajax({
				url: js_admin_data.ajax_url,
				type: "POST",
				data: { 'action': 'sent_notification','ticket_name':ticket},
				dataType: "json",
				beforeSend: function() {
					$('.btn-notify').prop('disabled',true);
					$('.data_status').css('color','green').html('Processing.... <i class="fa  fa-spinner fa-spin"></i>');
				},
				success: function(data) {
					if(data.error){
						$('.data_status').css('color','red').html(data.message);
					}else{
						$('#comp_name').val(data.comp_name);
						$('#winner_name').val(data.winner_name);
						$('#winner_email').val(data.winner_email);
						$('.comp_winner_id').val(data.winner_id);
						$('.btn-notify').prop('disabled',false);
						$('.data_status').html('');
					}
				}
			});
	
	}else{
		alert('Please Enter valid Ticket Name');
	}
	
})
	

$(document).on('click','.btn_tickets_Details',function(){
		var order_id = $(this).attr('data-orderid');
		 var ele =  $(this);
			$.ajax({
				url: js_admin_data.ajax_url,
				type: "POST",
				data: { 'action': 'get_order_tickets','order_id':order_id},
				dataType: "json",
				beforeSend: function() {
					ele.html('Fetching.... <i class="fa  fa-spinner fa-spin"></i>');
				},
				success: function(data) {
					if(data.error){
						alert('No record Found!');
					}else{
						$('#orderId').text(order_id);
						ele.html('Order Tickets');
						var order_details = data.order_data;
						var html_tickets = "";
						for(var i = 0 ;i < order_details.length; i++ ){
							var single_order_detail = order_details[i];
							var get_title = single_order_detail.title;
							var details_tickets = single_order_detail.details;
							var tickets = "";
							//if(details_tickets.lentgh > 0){
								for(j=0 ; j < details_tickets.length ; j++){
									single_ticket  = details_tickets[j];
									tickets += "<span class='my-label' style='margin-right:4px'>"+single_ticket.ticket+"</span>";
								}
								html_tickets += "<div class='col-sm-12'><h3>Competition : "+get_title+"</h3>"+tickets+"</div>"
							//}
						}
						$('.body_tickets').html(html_tickets);
						$("#myModaltickets").modal('show');
					}
					
				}
			});

})	
	
	
$(document).on('click','.open_congrat',function(){
	if(confirm('Are you Sure!')){
		var userID = $(this).attr('data-user');
		 var ele =  $(this);
			$.ajax({
				url: js_admin_data.ajax_url,
				type: "POST",
				data: { 'action': 'sent_notification'},
				dataType: "json",
				beforeSend: function() {
					ele.html('Processing.... <i class="fa  fa-spinner fa-spin"></i>');
				},
				success: function(data) {
					ele.html('Notified');
					
				}
			});

		}	
})








});