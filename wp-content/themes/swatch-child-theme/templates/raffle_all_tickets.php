<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel='stylesheet' href='https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap.min.css'>
<style>
.my-label{	background: gainsboro;
    padding: 6px 18px;
    border-radius: 5px;
    margin-right: 4px;
    display: inline-block;
    margin-bottom: 6px;
    width: 128px;
	}
</style>
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
    if(isset($_SESSION['ticket_deleted']) && $_SESSION['ticket_deleted'] == 'yes'){ ?>
    <div class='col-sm-12'>
        <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> Ticket Deleted successfully!
         </div>
    </div>
  <?php  unset($_SESSION['ticket_deleted']); } ?>
<?php 
    if(isset($_SESSION['ticket_deleted']) && $_SESSION['ticket_deleted'] == 'no'){ ?>
    <div class='col-sm-12'>
        <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Error!</strong> Please try later!
         </div>
    </div>
  <?php unset($_SESSION['ticket_deleted']); } ?>
<?php 
    if(isset($_SESSION['ticket_deleted_mail']) && $_SESSION['ticket_deleted_mail'] == 'no'){ ?>
    <div class='col-sm-12'>
        <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Error!</strong> Ticket Deleted and amount refunded but Problem in sending mail!
         </div>
    </div>
  <?php unset($_SESSION['ticket_deleted']); } ?>

<?php 

if(!isset($_GET['Raff']) || $_GET['Raff'] == "" ){

wp_redirect(get_option('siteurl') . '/wp-admin/index.php');
	exist;

}else{
	$raffle =$_GET['Raff'];
	global $wpdb;
	 $get_All_tickets  = $wpdb->get_results('Select * from PQrlH_order_details where lottery_id = '.$raffle.' Order by id ASC');
	$sold =   $wpdb->get_var("SELECT count(ticket) as sold FROM `PQrlH_order_details` where order_id != 0 AND lottery_id = ".$raffle);
?>
 	
		<div class="col-md-4">
			<div class="dbox dbox--color-1">
				<div class="dbox__icon">
					<i class="glyphicon glyphicon-list"></i>
				</div>
				<div class="dbox__body">
					<span class="dbox__count"> <?php echo get_post_meta($raffle,'total_entries',true);?> </span>
					<span class="dbox__title"><?php echo "Total Tickets";?></span>
				</div>		
				<div class="dbox__action">
					<span class="dbox__action__btn">More Info Below</span>
				</div>				
			</div>
		</div>	
<div class="col-md-4">
			<div class="dbox dbox--color-2">
				<div class="dbox__icon">
					<i class="glyphicon glyphicon-list"></i>
				</div>
				<div class="dbox__body">
					<span class="dbox__count"><?php echo $sold;?></span>
					<span class="dbox__title"><?php echo "Sold Tickets";?></span>
				</div>
				
				<div class="dbox__action">
					<span class="dbox__action__btn">More Info Below</span>
				</div>				
			</div>
		</div>	
<div class="col-md-4">
			<div class="dbox dbox--color-3">
				<div class="dbox__icon">
					<i class="glyphicon glyphicon-list"></i>
				</div>
				<div class="dbox__body">
					<span class="dbox__count"> <?php echo ( (get_post_meta($raffle,'total_entries',true) - $sold) <= 0) ? 0  : get_post_meta($raffle,'total_entries',true) - $sold ;?> </span>
					<span class="dbox__title"><?php echo "Left Tickets";?></span>
				</div>
				
				<div class="dbox__action">
					<span class="dbox__action__btn">More Info Below</span>
				</div>				
			</div>
		</div>	
	

    <div class='col-sm-12' >
		<div class='col-sm-6' style='padding-left:0px'> <h3>Raffle (<?php echo get_the_title($raffle);?>) Tickets  <small>List of all sold tickets</small></h3>
            </div>
		<div class='col-sm-6 text-right' style="padding-top: 14px;">
			<a href='<?php echo site_url();?>/wp-admin/admin.php?page=raffle_tickets' class='btn btn-primary'> Back To Raffles </a>
		</div>
    </div>
  
  <div class="col-sm-12" style='margin-top:14px'>
	 
	  <div class='thumbnail'>
    <table id="example" class="table  table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Ticket.ID</th>
                <th>Ticket Name</th>
				<th>Ticket Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
	 <?php
	  foreach($get_All_tickets as $ticket){
		  $bg = "";
		  if($ticket->security_question == "true"){
			  $security  = "Right answer";
		  }else if($ticket->security_question == "false"){
			$bg = "style='font-weight:bold'";
		  	$security  = "<span style='color:#FF0A00'>Wrong answer</span>";
		  }else{
		  	$security  = "<span style='color:#2361F5'>Not Assigned</span>";
		  }
	  ?>
	
	  <tr <?php echo $bg;?>>
        <td><?php echo $ticket->id;?></td>
        <td><?php echo $ticket->ticket;?></td>
		<td><?php echo $security;?></td>
        <td>
         <form onSubmit="if(!confirm('Are you sure you want to delete this ticket?')){return false;}" style='display:inline-block'  action='<?php echo esc_url( admin_url('admin-post.php') ); ?>'  method='post'>
             <input type="hidden" name="action" value="delete_ticket">
             <input type='hidden' name='ticketid' value="<?php echo $ticket->id;?>">
             <button type='submit' style='background:#EC8783;border:1px solid #EC8783' name='delete_ticket' class='btn btn-danger'>  Delete </button>
         </form>
        </td>
      </tr>
      
      <?php }  ?>
        </tbody>
    </table>
    </div>
 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src='https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js'></script>
    <script src='https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap.min.js'></script>
    <script>
    jQuery(document).ready(function($) {
       $('#example').DataTable();
		
      });
    </script>
<?php } ?>