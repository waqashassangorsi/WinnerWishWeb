<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel='stylesheet' href='https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap.min.css'>
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
    if(isset($_SESSION['email_notified']) && $_SESSION['email_notified'] == 'yes'){ ?>
    <div class='col-sm-12'>
        <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> Notified Successfully! Mail Sent to Winner
         </div>
    </div>
  <?php unset($_SESSION['email_notified']);  } ?>
 <?php
    global $wpdb;
    
    $get_vouchers  = $wpdb->get_results('Select * from pqrlh_vouchers');
    
    $total = count($get_vouchers);
?>

 
    <div class='col-sm-12'>
           <div class='col-sm-6' style='padding-left:0px'> <h3> Say Congrats to Winner </h3>
            <p> Notify Winner</p>
            </div>
    </div>
    
    <div class="col-md-12 custyle">
		<div class='thumbnail'>
			<form action='<?php echo esc_url( admin_url('admin-post.php') ); ?>' method="post">
				 <input type="hidden" name="action" value="notify_comp_winner">
				<input type="hidden" name="user_id" class='comp_winner_id' value="">
				<div class="row">
				<div class="col-sm-6">
				<div class="form-group">
				  <label for="ticket_name">Enter Won Ticket:</label>
				  <input type="text" class="form-control" required  id="ticket_name" placeholder="Enter won ticket ..." name="ticket_name">
					</div></div>
				<div class="col-sm-6">
				<div class="form-group">
				  <label for="winner_name">Winner Name :</label>
				  <input type="text" class="form-control" required readonly id="winner_name" placeholder="Winner Name" name="winner_name">
					</div></div>
				<div class="col-sm-6">
				<div class="form-group">
				  <label for="winner_email">Winner Email:</label>
				  <input type="email" class="form-control" required readonly id="winner_email" placeholder="Winner Email" name="winner_email">
				</div>
				</div>
				<div class="col-sm-6">
				<div class="form-group">
				  <label for="comp_name">Competition Name:</label>
				  <input type="text" class="form-control" id="comp_name" readonly required placeholder="Competition Name..." name="comp_name">
					</div></div>
				<div class="col-sm-12">
				<div class="form-group">
				  <label for="additional">Addition Message/ Congrats Message:</label>
					<textarea rows="7" class="form-control" name="additional" placeholder='Say Congrats to Winner'></textarea>
				</div>
					
				</div>
				<div class="col-sm-12">
				<button type="submit" disabled  title="Please enter Ticket Name" class="btn btn-success btn-notify"><i class="fa fa-envelope"></i> Notify</button> <span class='data_status'></span>
					</div></div>
			  </form>
		</div>
    </div>


 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
