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
			$get_vouchers  = $wpdb->get_results("SELECT * FROM `PQrlH_user_gifts` where userid=".$_GET['UID']."  AND month(date_time) = $month_no AND year(date_time) = $year  ORDER BY `id`  DESC"); 
		$_filter = "<p><b>Filtering on ".$mon[$month_no - 1]." - ".$year."</b></p>";
				$clear = '<button type="button" style="margin-top:8px" class="btn btn-danger" onClick="window.location.reload();">Clear</button>';
	}else if($to!="" && $from !=""){
		echo "SELECT * FROM `PQrlH_user_gifts` where userid=".$_GET['UID']."  AND  (date_time between '$from' AND '$to')  ORDER BY `id`  DESC";
		$get_vouchers  = $wpdb->get_results("SELECT * FROM `PQrlH_user_gifts` where userid=".$_GET['UID']."  AND  (date_time between '$from' AND '$to')  ORDER BY `id`  DESC"); 
		$_filter = "<p><b>Filtering on ".$from." - ".$to."</b></p>";
		$clear = '<button type="button" class="btn btn-danger" onClick="window.location.reload();">Clear</button>';
	}else{
    $get_vouchers  = $wpdb->get_results('SELECT * FROM `PQrlH_user_gifts` where userid='.$_GET['UID'].'   ORDER BY `id`  DESC'); 
	}
    $total = count($get_vouchers);
	
	
?>

 
    <div class='col-sm-12' style='padding-left:0px'>
           <div class='col-sm-6' style='padding-left:0px'> <h3> <span style="color:#4caf50;"><?php echo ucfirst($getuser->user_nicename);?> </span> All  Gifts </h3>
            <p> <?php echo $total;?> previous gifts!</p>
            </div>
			<div class="col-sm-6">
				<a href="users.php" class='btn btn-danger pull-right' style="margin-top:28px;margin-left:4px"> Back to Users</a>
				<button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#give_gift" style="margin-top:28px"> Give him a New Gift </button>
				</div>
    </div>
    <div class="col-sm-12" style="padding-left:0px;margin-bottom:15px">
		<input type='hidden' class='page' value='orders'>
		<h4> Filter Gifts </h4>
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
                <th>Gift.ID</th>
                <th>Gift Type</th>
                <th>Gift Amount</th>
                <th>Gift Tickets</th>
                <th>Competition</th>
                <th>Description</th>
                <th>Time Stamp</th>
            </tr>
        </thead>
        <tbody>
        <?php 
    if($total > 0){
        foreach($get_vouchers as $order){
			$title =  get_the_title( $order->raffle_id);
    ?>
      <tr>
        <td><?php echo "#WGFIT-".$order->id;?></td>
		  <td><span class='label label-success'><?php echo ucfirst($order->gift_type);?></span></td>
		  <td><b><?php echo "£ ".$order->amount;?></b></td>
        <td><?php echo $order->tickets;?></td>
        <td> <?php echo ucfirst($title);?> </td>
		  <td><?php echo $order->description;?></td>
        <td><span class="label label-default"><?php echo date('d , M Y H:i:s A', strtotime( $order->date_time));?></span></td>
      </tr>
      
      <?php } } ?>
        </tbody>
    </table>
    </div>
    </div>

        <!-- Modal -->
        <div class="modal fade" id="give_gift" role="dialog">
            <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Choose Gift Type</h4>
                </div>
			<form action='<?php echo esc_url( admin_url('admin-post.php') ); ?>'  id="gift_form" method="post">
                <div class="modal-body">
                   <div class="row">
					   <div class="col-sm-12">
							<input type='hidden' name='userid' value="<?php echo $_GET['UID'];?>">
							 <input type="hidden" name="action" value="send_gift">
							<label class="radio-inline">
							  <input type="radio" name="gifttype" class="gifttype" value='balance'>Balance
							</label>
							<label class="radio-inline">
							  <input type="radio" name="gifttype" class="gifttype" value='tickets'>Tickets
							</label>
							<p class="error_uncheck"></p>
							<div class="balance" style="display:none">
								<div class="form-group">
									<input type="number" name='amount' class="form-control gift_amount" placeholder='Enter Amount...'> 
								</div>
								<div class="form-group">
									<textarea rows="3" name='optional_desc' class='form-control optional_description' placeholder='Optional....'></textarea>
								</div>
							</div>
							
							<div class="tickets" style="display:none">
								<div class="form-group">
									<select name='raffle'  class='form-control' id='raf'>
										<option value=""> Select Raffle </option>
										<?php 
										   $args = array(  
												'post_type' => 'raffles',
												'post_status' => 'publish',
												'posts_per_page' => -1, 
												'orderby' => 'title', 
												'order' => 'DESC', 
											);

										$loop = new WP_Query( $args );
										if($loop->have_posts()) {
										while ( $loop->have_posts() ){ 
											$loop->the_post(); 
												$diff = abs(time() - strtotime(get_the_date('j F Y', get_the_ID())));

												 $min = floor($diff / (60*60*24));
											global $wpdb;
											$sold =   $wpdb->get_var("SELECT count(ticket) as sold FROM `PQrlH_order_details` where lottery_id = ".get_the_ID());
											if( (get_post_meta( get_the_ID(), 'days', true ) - $min) > 0){		
											?>
										
										<option value='<?php echo get_the_ID();?>'>  <?php the_title();?> </option>
										
										<?php } } } ?>
									</select>
								</div>
								<div class="form-group">
									<input type="number" class="form-control tickets" name='tickets'  placeholder='Enter tickets...'> 
								</div>
								<div class="form-group">
									<textarea rows="3" class='form-control' name='optional_desc' placeholder='Optional....'></textarea>
								</div>
							</div>
							
						 
					   </div>
					</div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-success pull-right btn-gift_sender">Send</button>
                	</div>
				</form>
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