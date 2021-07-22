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
		 	$query = "AND status_web = 'winnerwish'";
		 }else{
		 	$query = "AND status_web = 'winnerkid'";
		 }
	
	 if($month != "" && $year !=""){
		 $mon =	array("January", "February", "March", "April", "May","June", "July", "August", "September", "October", "November","December");
		$get_transactions  = $wpdb->get_results("SELECT * FROM `PQrlH_transactions` where month(date_time) = $month_no AND year(date_time) = $year $query ORDER BY `id`  DESC");
		$totalAdminbalance =  $wpdb->get_var("SELECT sum(price) as total_balance FROM `PQrlH_transactions` WHERE (user_id = 0 AND payment_status='paid') AND month(date_time) = $month_no AND year(date_time) = $year $query");
		$balance_topups = $wpdb->get_var("SELECT sum(price) as total_balance FROM `PQrlH_transactions` WHERE user_id != 0 AND payment_status='paid' AND payment_type != 'charity_fund' AND (month(date_time) = $month_no AND year(date_time) = $year $query)");
		$total = count($get_transactions);
		$balance_charity = $wpdb->get_var("SELECT sum(price) as total_balance FROM `PQrlH_transactions` WHERE payment_type = 'charity_fund' AND payment_status='paid' AND month(date_time) = $month_no AND year(date_time) = $year $query");
		$balance_overall  = $wpdb->get_var("SELECT sum(price) as total_balance FROM `PQrlH_transactions` where  payment_status='paid' AND payment_type != 'charity_fund' AND month(date_time) = $month_no AND year(date_time) = $year $query");
		  $gifts  =  abs($wpdb->get_var("SELECT sum(price) as total_balance FROM `PQrlH_transactions` where  payment_status='paid' AND user_id = 0 AND payment_type = 'gift' AND month(date_time) = $month_no AND year(date_time) = $year $query"));
		 $_filter = "<p><b>Filtering on ".$mon[$month_no - 1]." - ".$year."</b></p>";
				$clear = '<button type="button" style="margin-top:8px" class="btn btn-danger" onClick="window.location.reload();">Clear</button>';
	 }else if($to!="" && $from !=""){
		 $get_transactions  = $wpdb->get_results("SELECT * FROM `PQrlH_transactions` where (date_time between '$from' AND '$to') $query ORDER BY `id`  DESC");
		$totalAdminbalance =  $wpdb->get_var("SELECT sum(price) as total_balance FROM `PQrlH_transactions` WHERE (user_id = 0 AND payment_status='paid') AND (date_time between '$from' AND '$to') $query ");
		$balance_topups = $wpdb->get_var("SELECT sum(price) as total_balance FROM `PQrlH_transactions` WHERE user_id != 0 AND payment_status='paid' AND payment_type != 'charity_fund' AND (date_time between '$from' AND '$to') $query");
		$total = count($get_transactions);
		$balance_charity = $wpdb->get_var("SELECT sum(price) as total_balance FROM `PQrlH_transactions` WHERE payment_type = 'charity_fund' AND payment_status='paid' AND (date_time between '$from' AND '$to') $query");
		$balance_overall  = $wpdb->get_var("SELECT sum(price) as total_balance FROM `PQrlH_transactions` where  payment_status='paid' AND payment_type != 'charity_fund' AND (date_time between '$from' AND '$to') $query");
		  $gifts  =  abs($wpdb->get_var("SELECT sum(price) as total_balance FROM `PQrlH_transactions` where  payment_status='paid' AND user_id = 0 AND payment_type = 'gift' AND (date_time between '$from' AND '$to') $query"));
		  $_filter = "<p><b>Filtering on ".$to." - ".$from."</b></p>";
		$clear = '<button type="button" style="margin-top:8px" class="btn btn-danger" onClick="window.location.reload();">Clear</button>';
	 }else{
	 	$get_transactions  = $wpdb->get_results('SELECT * FROM `PQrlH_transactions` ORDER BY `id`  DESC');
		$totalAdminbalance =  $wpdb->get_var('SELECT sum(price) as total_balance FROM `PQrlH_transactions` WHERE (user_id = 0 AND payment_status="paid") ');
		$balance_topups = $wpdb->get_var('SELECT sum(price) as total_balance FROM `PQrlH_transactions` WHERE user_id != 0 AND payment_status="paid" AND payment_type != "charity_fund"');
		$total = count($get_transactions);
		$balance_charity = $wpdb->get_var('SELECT sum(price) as total_balance FROM `PQrlH_transactions` WHERE payment_type = "charity_fund" AND payment_status="paid"');
		$balance_overall  = $wpdb->get_var('SELECT sum(price) as total_balance FROM `PQrlH_transactions` where  payment_status="paid" AND payment_type != "charity_fund"');
		 
		 $gifts  =  abs($wpdb->get_var('SELECT sum(price) as total_balance FROM `PQrlH_transactions` where  payment_status="paid" AND user_id = 0 AND payment_type = "gift"'));
	 
	 }

$totalAdminbalance = $totalAdminbalance - $balance_charity;
?>
<div class='col-sm-12' style='padding-left:0px'>
           <div class='col-sm-6' style='padding-left:0px'> <h3> Transactions </h3>
            <p> <?php echo $total;?> Transactions Found!</p>
            </div>
    </div>
<div class="col-sm-12" style="padding-left:0px;margin-bottom:15px">
		<input type='hidden' class='page' value='orders'>
		<h4> Filter Transactions </h4>
		<div class="col-sm-3" style="padding-left:0px">
		<select name="filtering_option" class="form-control" id="filtering_option">
			<option value="" selected disabled> Select Filtering Type</option>
			<option value='monthly'> Monthly</option>
			<option value='custom'> Custom</option>
			</select>
		<?php echo $clear;?>
		</div>
		<div class="col-sm-9 dates_range" style="display:none">
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
		<div class="col-sm-9 months" style="display:none">
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
	<?php echo $_filter;?>
	</div>

 	<input type='hidden' class='page' value='orders'>
    
<div class="col-sm-2" style='padding-left:0px;margin-bottom:30px;margin-right:8px'>
		<div class="card" style="width: 18rem;background:#e91e63;color:white">
		  <div class="card-body">
			<h5 class="card-title">All Total Balance </h5>
			<h6 class="card-subtitle mb-2 ">Overall Amount in your Account</h6>
			  <p class="card-text"><b>£ <?php echo ( $balance_overall == "" )? 0 : $balance_overall ;?></b></p>
		  </div>
		</div>
		
		</div>
    <div class="col-sm-2" style='padding-left:0px;margin-bottom:30px;margin-right:8px'>
		<div class="card" style="width: 18rem;background:#73b175;color:white">
		  <div class="card-body">
			<h5 class="card-title">Total Available Balance</h5>
			<h6 class="card-subtitle mb-2 ">Amount in your Account</h6>
			  <p class="card-text"><b>£ <?php echo ($totalAdminbalance == "")? 0 : $totalAdminbalance ;?></b></p>
		  </div>
		</div>
		
		</div>
<div class="col-sm-2" style='padding-left:0px;margin-bottom:30px;margin-right:8px'>
		<div class="card" style="width: 18rem;background:#009688;color:white">
		  <div class="card-body">
			<h5 class="card-title">Total Charity Fund</h5>
			<h6 class="card-subtitle mb-2">Charity Fund in your Account</h6>
			  <p class="card-text"><b>£  <?php echo ($balance_charity == "") ? 0 : $balance_charity ;?></b></p>
		  </div>
		</div>
		
		</div>
<div class="col-sm-2" style='padding-left:0px;margin-bottom:30px; margin-right:8px'>
		<div class="card" style="width: 18rem;background:#f44336;color:white">
		  <div class="card-body">
			<h5 class="card-title">Customer Top Ups </h5>
			<h6 class="card-subtitle mb-2 ">Customer Balance in your Account</h6>
			  <p class="card-text"><b>£ <?php echo ($balance_topups == "")? 0 : $balance_topups ;?></b></p>
		  </div>
		</div>
		
		</div>
<div class="col-sm-2" style='padding-left:0px;margin-bottom:30px;margin-right:8px'>
		<div class="card" style="width: 18rem;background:#29482a;color:white">
		  <div class="card-body">
			<h5 class="card-title">Gifts </h5>
			<h6 class="card-subtitle mb-2 ">Spend on gifts</h6>
			  <p class="card-text"><b>£ <?php echo ($gifts == "")? 0 : $gifts ;?></b></p>
		  </div>
		</div>
		
		</div>

    <div class="row col-md-12 custyle">
		
    <div class='thumbnail'>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Trx-ID</th>
                <th>Customer Name</th>
                <th>Currency</th>
                <th>Amount</th>
			    <th>Payment Status</th>
                <th>Payment Method</th>
                <th>Payment Type</th>
				<th>Date</th>
            </tr>
        </thead>
        <tbody>
        <?php 
    if($total > 0){
        foreach($get_transactions as $transaction){
            
            if($transaction->payment_status == 'paid' || $transaction->payment_status == 'succeeded'){
                $label = "label-success";
				$transaction->payment_status = "Amount Paid";
            }else{
                $label = "label-warning";
            }
			$user = get_userdata($transaction->user_id);
			
		
			
			if($transaction->price > 0){
				$color = "#4caf50";
			}else{
				$color = "red";
			}
    
			
			?>
      <tr>
        <td><?php echo $transaction->trans_id;?></td>
        <td><?php echo $user->user_nicename;?></td>
		  <td><span class="label label-default"><?php echo $transaction->currency;?></span></td>
		  <td><span style="color:<?php echo $color;?>"><b><?php echo "£ " . $transaction->price;?></b></td>
		  <td> <span class='label <?php echo $label;?>'><?php echo ucfirst($transaction->payment_status);?></span> </td>
		  <td><span class="label label-info"> <?php echo ucfirst($transaction->payment_method);?> </span></td>
        <td><?php echo $transaction->payment_type;?></td>
		  <td><span class="label label-default"><?php echo date('d , M Y H:i:s A',strtotime($transaction->date_time));?></span></td>
      </tr>
      
      <?php } } ?>
        </tbody>
    </table>
    </div>
    </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Voucher</h4>
                </div>
                <div class="modal-body">
                <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method='post'>
                    <input type='hidden' value='save_voucher' name='action'>
                    <div class="form-group">
                        <label for="text">Voucher Name:</label>
                        <input type="text" class="form-control" required name='vname' id="vname">
                    </div>
                    <div class="form-group">
                        <label for="vprice">Voucher Price (%):</label>
                        <input type="text" class="form-control" required name='vprice' id="vprice">
                    </div>
                    <div class="form-group">
                        <label for="vlimit">Voucher Limit:</label>
                        <input type="text" class="form-control" required name='vlimit' id="vlimit">
                    </div>
                    <div class="form-group">
                        <label for="vexpiry">Voucher Expiry:</label>
                        <input type="date" class="form-control" required name='vexpiry' id="vexpiry">
                    </div>
                   
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary pull-right">Submit</button>
                </form>
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