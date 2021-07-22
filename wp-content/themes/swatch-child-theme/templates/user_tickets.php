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
	.btn{
		outline:none;
	}
</style>
<?php 
    if(isset($_SESSION['gift_send']) && $_SESSION['gift_send'] == 'Yes'){ ?>
    <div class='col-sm-12'>
        <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> Gift Send
         </div>
    </div>
  <?php unset($_SESSION['gift_send']);  } ?>
 <?php
$getuser = get_userdata($_GET['UID']);
    global $wpdb;
	$month = explode(',',$_POST['months']);
	$month_no=$month[0] + 1;
	$year = $month[1];

	$range = explode(' to ',$_POST['date']);
		$from = $range[0];
	    $to = $range[1];

    if($month != "" && $year !=""){
	$mon =	array("January", "February", "March", "April", "May","June", "July", "August", "September", "October", "November","December");
			$wpdb->get_results("SELECT * FROM `PQrlH_orders` Where user_id= ".$_GET['UID']." AND month(date_time) = $month_no AND year(date_time) = $year ORDER BY `ord_id`  DESC");
		$_filter = "<p><b>Filtering on ".$mon[$month_no - 1]." - ".$year."</b></p>";
				$clear = '<button type="button" style="margin-top:8px" class="btn btn-danger" onClick="window.location.reload();">Clear</button>';
	}else if($to!="" && $from !=""){
		$wpdb->get_results("SELECT * FROM `PQrlH_orders` Where user_id= ".$_GET['UID']." AND  (date_time between '$from' AND '$to') ORDER BY `ord_id`  DESC");
		$_filter = "<p><b>Filtering on ".$from." - ".$to."</b></p>";
		$clear = '<button type="button" class="btn btn-danger" onClick="window.location.reload();">Clear</button>';
	}else{
    $getOrders  = $wpdb->get_results("SELECT * FROM `PQrlH_orders` Where user_id= ".$_GET['UID']." ORDER BY `ord_id`  DESC");
	}
    $total = count($getOrders);
	
	
?>

 
    <div class='col-sm-12' style='padding-left:0px'>
           <div class='col-sm-6' style='padding-left:0px'> <h3> <span style="color:#4caf50;"><?php echo ucfirst($getuser->user_nicename);?> </span> All  Tickets </h3>
            <p> <?php echo $total;?> Tickets Found!</p>
            </div>
			<div class="col-sm-6">
				<a href="users.php" class='btn btn-danger pull-right' style="margin-top:28px;margin-left:4px"> Back to Users</a>
				</div>
    </div>
    <div class="col-sm-12" style="padding-left:0px;margin-bottom:15px">
		<input type='hidden' class='page' value='orders'>
		<h4> Filter Tickets </h4>
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
				<select name="months" class="months_option form-control">
			
				</select>
			</form>
		</div>
	</div>
    <div class="row col-md-12 custyle">
    <div class='thumbnail'>
		<?php echo $_filter;?>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Ticket.ID</th>
                <th>Raffle Name</th>
                <th>Ticket Name</th>
                <th>Status</th>
                <th>Time Stamp</th>
            </tr>
        </thead>
        <tbody>
        <?php 
    if($total > 0){
        foreach($getOrders as $order){
			$tickets = $wpdb->get_results("select * from `PQrlH_order_details` where order_id = ".$order->ord_id);
			foreach($tickets as $ticket){
			$title =  get_the_title( $ticket->lottery_id);
				if($ticket->security_question == 'true'){
				  $ticket->security_question  = "Right";
				}else if($ticket->security_question == 'false'){
					$ticket->security_question ='Wrong';
				}
    ?>
      <tr>
        <td><?php echo "#TICKET-".$ticket->id;?></td>
		  <td><span class='label label-success'><?php echo $title;?></span></td>
		  <td><span class='label label-danger'><?php echo ucfirst($ticket->ticket);?></span></td>
       	 <td><?php echo $ticket->security_question ;?></td>
        <td><span class="label label-default"><?php echo date('d , M Y H:i:s A', strtotime( $ticket->date_time));?></span></td>
      </tr>
      
      <?php } } } ?>
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
			   $('#example').DataTable();
		
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