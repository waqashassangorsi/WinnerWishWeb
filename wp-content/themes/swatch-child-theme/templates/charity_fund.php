<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel='stylesheet' href='https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap.min.css'>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_directory_uri().'/js/daterangepicker.css';?>" />
 
<style>
	
.dbox {
    position: relative;
    background: rgb(255, 86, 65);
    background: -moz-linear-gradient(top, rgba(164 143 140) 0%, rgba(253, 50, 97, 1) 100%);
    background: -webkit-linear-gradient(top, rgba(164 143 140) 0%, rgba(253, 50, 97, 1) 100%);
    background: linear-gradient(to bottom, rgb(164 143 140) 0%, rgba(253, 50, 97, 1) 100%)
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#ff5641', endColorstr='#fd3261', GradientType=0);
    border-radius: 4px;
    text-align: center;
    margin: 60px 0 50px;
}
.dbox__icon {
    position: absolute;
    transform: translateY(-50%) translateX(-50%);
    left: 50%;
}
.dbox__icon:before {
    width: 75px;
    height: 75px;
    position: absolute;
    background: #fda299;
    background: rgba(253, 162, 153, 0.34);
    content: '';
    border-radius: 50%;
    left: -17px;
    top: -17px;
    z-index: -2;
}
.dbox__icon:after {
    width: 60px;
    height: 60px;
    position: absolute;
    background: #f79489;
    background: rgba(247, 148, 137, 0.91);
    content: '';
    border-radius: 50%;
    left: -10px;
    top: -10px;
    z-index: -1;
}
.dbox__icon > i {
    background: #ff5444;
    border-radius: 50%;
    line-height: 40px;
    color: #FFF;
    width: 40px;
    height: 40px;
	font-size:22px;
}
.dbox__body {
    padding: 50px 20px;
}
.dbox__count {
    display: block;
    font-size: 30px;
    color: #FFF;
    font-weight: 300;
}
.dbox__title {
    font-size: 13px;
    color: #FFF;
    color: rgba(255, 255, 255, 0.81);
}
.dbox__action {
    transform: translateY(-50%) translateX(-50%);
    position: absolute;
    left: 50%;
}
.dbox__action__btn {
    border: none;
    background: #FFF;
    border-radius: 19px;
    padding: 7px 16px;
    text-transform: uppercase;
    font-weight: 500;
    font-size: 11px;
    letter-spacing: .5px;
    color: #003e85;
    box-shadow: 0 3px 5px #d4d4d4;
}

	.dbox__action__btn:hover{
		text-decoration:none;
		background: #673ab7;
    	color: white;
	}
.dbox--color-2 {
    background: rgb(252, 190, 27);
    background: -moz-linear-gradient(top, rgba(252, 190, 27, 1) 1%, rgba(248, 86, 72, 1) 99%);
    background: -webkit-linear-gradient(top, rgba(252, 190, 27, 1) 1%, rgba(248, 86, 72, 1) 99%);
    background: linear-gradient(to bottom, rgba(252, 190, 27, 1) 1%, rgba(248, 86, 72, 1) 99%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#fcbe1b', endColorstr='#f85648', GradientType=0);
}
.dbox--color-2 .dbox__icon:after {
    background: #fee036;
    background: rgba(254, 224, 54, 0.81);
}
.dbox--color-2 .dbox__icon:before {
    background: #fee036;
    background: rgba(254, 224, 54, 0.64);
}
.dbox--color-2 .dbox__icon > i {
    background: #fb9f28;
}

.dbox--color-3 {
    background: rgb(183,71,247);
    background: -moz-linear-gradient(top, rgba(183,71,247,1) 0%, rgba(108,83,220,1) 100%);
    background: -webkit-linear-gradient(top, rgba(183,71,247,1) 0%,rgba(108,83,220,1) 100%);
    background: linear-gradient(to bottom, rgba(183,71,247,1) 0%,rgba(108,83,220,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b747f7', endColorstr='#6c53dc',GradientType=0 );
}
.dbox--color-3 .dbox__icon:after {
    background: #b446f5;
    background: rgba(180, 70, 245, 0.76);
}
.dbox--color-3 .dbox__icon:before {
    background: #e284ff;
    background: rgba(226, 132, 255, 0.66);
}
.dbox--color-3 .dbox__icon > i {
    background: #8150e4;
}
</style>
 
<?php 

$taxonomy = 'charity_category';
$terms = get_terms($taxonomy); // Get all terms of a taxonomy

?>
 

    <div class='col-sm-12' >
		<div class='col-sm-6' style='padding-left:0px'> <h3>All Charity Funds <small>List of Main Charities with amount</small></h3>
           <!-- <p> <?php echo $total;?> Withdrawal Found!</p> -->
            </div>
    </div>
    <div class="col-sm-12">
		<h4> Filter Funds </h4>
		<input type='hidden' class='page' value='charity'>
		<div class="col-sm-3" style="padding-left:0px">
		<select name="filtering_option" class="form-control" id="filtering_option">
			<option value="" selected disabled> Select Filtering Type</option>
			<option value='monthly'> Monthly</option>
			<option value='custom'> Custom</option>
			</select></div>
		<div class="col-sm-3 dates_range" style="display:none">
			<div class="input-group date" data-provide="datepicker">
				<input type="text" id='filter_charity_funds' class="form-control">
				<div class="input-group-addon" style="padding: 0px 12px;">
					<button type='button' class="btn btn-success filter_custom" style="padding: 2px 10px;outline: none;"> Filter </button>
				</div>
			</div>
		</div>
		<div class="col-sm-3 months" style="display:none">
			<select name="months" class="months_option form-control">
				
			</select>
		</div>
	</div>
    <div class="row col-md-12 custyle">
		<?php
		if ( $terms && !is_wp_error( $terms ) ) :
		$i = 1;
		foreach ( $terms as $term ) {
		
		if($i > 3)
			$i = 1;
 		global $wpdb;
		$get_other_user_info = $wpdb->get_var("select sum(price) as sum from PQrlH_transactions where payment_type = 'charity_fund' AND payment_status = 'paid' AND order_id=".$term->term_id); 
		?>
		  
		<div class="col-md-3">
			<div class="dbox dbox--color-<?php echo $i;?>">
				<div class="dbox__icon">
					<i class="glyphicon glyphicon-gift"></i>
				</div>
				<div class="dbox__body">
					<span class="dbox__count">£ <span class="charity_fun charity_<?php echo $term->term_id;?>"> <?php echo ($get_other_user_info == "")? 0 : $get_other_user_info;?></span></span>
					<span class="dbox__title"><?php echo $term->name;?></span>
				</div>
				
				<div class="dbox__action">
					<a href="<?php echo site_url();?>/wp-admin/admin.php?page=charity_trans&trans_id=<?php echo $term->term_id;?>" class="dbox__action__btn">More Info</a>
				</div>				
			</div>
		</div>

		<?php $i++; } ?>
		
<?php endif;?>
		
		
    </div>


  <div class="row col-md-12 custyle" style="display:none;margin-top:15px">
	  <div class="col-sm-12">
		  <h2 style="text-align:center" class="charityname"></h2>	  
	  </div>  
    <div class='thumbnail'>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Sr.no</th>
                <th>Date</th>
                <th>Raffle</th>
                <th>Amount</th>
            </tr>
        </thead>
        
	 <tbody>
  
	
	  <tr>
        <td>1</td>
        <td>20-07-2021</td>
        <td>Raffle</td>
        <td>$10</td>
      </tr>
        </tbody>
    </table>
    </div>
    </div>



  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src='https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js'></script>
    <script src='https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap.min.js'></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri().'/js/daterangepicker.js';?>"></script>
    <script>
    jQuery(document).ready(function($) {
       $('#example').DataTable({
        "order": [[ 0, "desc" ]]
    });
		
		$(document).on('click','.charitname',function(){
			$('.custyle').show();
		 	var useremail= $(this).find("h3").html();
			$('.charityname').html(useremail);
		});
		var options = {format:'YYYY-MM-DD'};
		/*options.ranges = {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days': [moment().subtract(6, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            };*/
		$('#filter_charity_funds').daterangepicker({locale: {
                format: 'YYYY-MM-DD',
				separator: " to "
			}});
});
    </script>