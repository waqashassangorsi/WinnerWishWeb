<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel='stylesheet' href='https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap.min.css'>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_directory_uri().'/js/daterangepicker.css';?>" />

<style>
.custab{
    border: 1px solid #ccc;
    padding: 5px;
    box-shadow: 3px 3px 2px #ccc;
    transition: 0.5s;
    }
.custab:hover{
    box-shadow: 3px 3px 0px transparent;
    transition: 0.5s;
    }
.my-label{	background: gainsboro;
    padding: 6px 18px;
    border-radius: 5px;
    margin-right: 4px;
    display: inline-block;
    margin-bottom: 6px;
    width: 128px;
	}
</style>

 <?php
    global $wpdb;
	$month = explode(',',$_POST['months']);
	$month_no=$month[0] + 1;
	$year = $month[1];

	$range = explode(' to ',$_POST['date']);
		$from = $range[0];
	    $to = $range[1];
    $website_option = $_POST['website_option'];
	
		if($website_option == 'all'){
		 	$query = "";
		 }else if($website_option == 'winnerwish'){
		 	$query = "AND order_from = 'winnerwish'";
		 }else{
		 	$query = "AND order_from = 'winnerkid'";
		 }

    if($month != "" && $year !=""){
	$mon =	array("January", "February", "March", "April", "May","June", "July", "August", "September", "October", "November","December");
			$get_orders  = $wpdb->get_results("SELECT * FROM `PQrlH_orders` where  month(date_time) = $month_no AND year(date_time) = $year $query  ORDER BY `ord_id`  DESC"); 
		$_filter = "<p><b>Filtering on ".$mon[$month_no - 1]." - ".$year."</b></p>";
				$clear = '<button type="button" style="margin-top:8px" class="btn btn-danger" onClick="window.location.reload();">Clear</button>';
	}else if($to!="" && $from !=""){
		$get_orders  = $wpdb->get_results("SELECT * FROM `PQrlH_orders` where  (date_time between '$from' AND '$to') $query  ORDER BY `ord_id`  DESC"); 
		$_filter = "<p><b>Filtering on ".$from." - ".$to."</b></p>";
		$clear = '<button type="button" class="btn btn-danger" onClick="window.location.reload();">Clear</button>';
	}else{
    	$get_orders  = $wpdb->get_results('SELECT * FROM `PQrlH_orders`   ORDER BY `ord_id`  DESC'); 
	}
   		$total = count($get_orders);
?>

 
    <div class='col-sm-12' style='padding-left:0px'>
           <div class='col-sm-6' style='padding-left:0px'> <h3> All Orders <?php echo $website_option;?> </h3>
            <p> <?php echo $total;?> Orders Found!</p>
            </div>
    </div>
    <div class="col-sm-12" style="padding-left:0px;margin-bottom:15px">
		<input type='hidden' class='page' value='orders'>
		<h4> Filter Orders </h4>
		<div class="col-sm-3" style="padding-left:0px">
		<select name="filtering_option" class="form-control" id="filtering_option">
			<option value="" selected disabled> Select Filtering Type</option>
			<option value='monthly'> Monthly</option>
			<option value='custom'> Custom</option>
			</select>
		<?php echo $clear;?>
		</div>

		<div class="col-sm-3 dates_range" style="display:none">
			<form method='post' action="" id='my_order_form_custom'>
			<div class='form-group'>
					<select name="website_option" class="form-control" id="website_option">
						<option value="all"> All </option>
						<option value='winnerwish'> Winners Wish</option>
						<option value='winnerkid'> Winners Kid</option>
					</select>
			</div>
			<div class="input-group date" data-provide="datepicker">
				<input type="text" id='filter_charity_funds' name='date' class="form-control">
				<div class="input-group-addon" style="padding: 0px 12px;">
					<button type='button' class="btn btn-success filter_custom" style="padding: 2px 10px;outline: none;"> Filter </button>
				</div>
			</div>
			</form>
		</div>
		<div class="col-sm-3 months" style="display:none">
			<form method='post' action="" id='my_order_form'>
				<div class='form-group'>
					<select name="website_option" class="form-control" id="website_option">
						<option value="all"> All </option>
						<option value='winnerwish'> Winners Wish</option>
						<option value='winnerkid'> Winners Kid</option>
					</select>
				</div>
				<div class='form-group'>
					<select name="months" class="months_option form-control">

					</select>
				</div>
			</form>
		</div>
	</div>
    <div class="row col-md-12 custyle">
    <div class='thumbnail'>
		<?php echo $_filter;?>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Order.ID</th>
                <th>Competition Name</th>
                <th>Order Price</th>
                <th>Customer Name</th>
                <th>Payment Method</th>
                <th>Payment Status</th>
				<th>Order From</th>
                <th>Order Time</th>
				 <th>Views Ticket</th>
            </tr>
        </thead>
        <tbody>
        <?php 
    if($total > 0){
        foreach($get_orders as $order){
			$competition = "";
			$user = get_userdata( $order->user_id );
			$lottery = explode(",",$order->lotteries);
			foreach($lottery as $lot){
			$record_ticket = $wpdb->get_results("SELECT * FROM `PQrlH_order_details` WHERE order_id = ".$order->ord_id." and lottery_id = $lot");
				if(count($record_ticket) > 0 ){
					$comp_title = get_the_title($lot);
					$competition .= "<span class='label label-danger' style='margin-right:12px'>".$comp_title."</span>";
					if($order->status == 'paid'){
						$label = "label-success";
					}else{
						$label = "label-warning";
					}
				}else{
				continue;
				}
		}
    ?>
      <tr>
        <td><?php echo "#WW-".$order->ord_id;?></td>
        <td><?php echo $competition;?></td>
        <td><?php echo "£ ".$order->total_price;?></td>
        <td><?php echo ucfirst($user->user_nicename);?></td>
        <td> <?php echo ucfirst($order->payment_method);?> </td>
		  <td><span class='label <?php echo $label;?>'> <?php echo ucfirst($order->status);?> </span></td>
		  <td><span class='label label-success'><?php echo ($order->order_from == 'winnerwish')? "Winners Wish" : "Winners Kid" ;?></span></td>
        <td><span class="label label-default"><?php echo date('d , M Y H:i:s A', strtotime( $order->date_time));?></span></td>
		  <td><button type="button" data-orderid='<?php echo $order->ord_id;?>' class='btn btn-info btn_tickets_Details'>Order Tickets </button></td>
      </tr>
      
      <?php } } ?>
        </tbody>
    </table>
    </div>
    </div>

        <!-- Modal -->
        <div class="modal fade" id="myModaltickets" role="dialog">
            <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Order (#WW-<span id="orderId"></span>)</h4>
                </div>
                <div class="modal-body">
                   <div class="row body_tickets">
                   
					</div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
                </div>
            </div>
            
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
      } );
    </script>