<!DOCTYPE html>
<html lang="en">
  <head>
    

   <title>Distributor::RECHARGE REPORT</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
	 	
$(document).ready(function(){
 $(function() {
            $( "#txtFrom" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
         });
});
	

	
	</script>
  </head> 

  <body>
<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>
    <!-- ########## START: LEFT PANEL ########## -->
    
    <?php include("elements/distsidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/distheader.php"); ?><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->
    <!-- ########## END: RIGHT PANEL ########## --->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="<?php echo base_url()."Distributor/dashboard"; ?>">Dashboard</a>
          <a class="breadcrumb-item" href="#">Reports</a>
          <span class="breadcrumb-item active">RECHARGE REPORT</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>RECHARGE REPORT</h4>
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody">
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                  <form action="<?php echo base_url()."Distributor/recharge_history" ?>" method="post" name="frmCallAction" id="frmCallAction">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    <td style="padding-right:10px;">
                                        	 <label>From Date</label>
                                            <input class="form-control" value="<?php echo $from; ?>" id="txtFrom" name="txtFrom" type="text" style="width:120px;" placeholder="Select Date">
                                        </td>
                                    	<td style="padding-right:10px;">
                                        	 <label>To Date</label>
                                            <input class="form-control" id="txtTo" value="<?php echo $to; ?>" name="txtTo" type="text" style="width:120px;" placeholder="Select Date">
                                        </td>
                                        <td valign="bottom">
                                        <input type="submit" id="btnSearch" name="btnSearch" value="Search" class="btn btn-primary">
                                       
                                        </td>
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">RECHARGE REPORT</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                 <?php
	if ($message != ''){echo "<div class='message'>".$message."</div>"; }
	if(isset($result_all))
	{
		if($result_all->num_rows() > 0)
		{
	?>
    <h2 class="h2">Search Result</h2>
    <div id="all_transaction">
<table class="table table-striped table-bordered table-hover" border="0">
    <tr>
    <th>Sr No</th>
   <th >Recharge ID</th>
   <th >Transaction Id</th>
    <th>Recharge Date Time</th> 
   <th>Company Name</th>
    <th>Mobile No</th>
    <th>Commission Per(%)</th>        
   <th>Amount</th>
    <th>Debit Amount</th>        
    <th>Status</th>             
	<th>Complain</th>        
	        
    </tr>
    <?php	$total_amount=0;$total_commission=0;$i = 0;foreach($result_all->result() as $result) 	{  ?>
			<tr id="<?php echo "Print_".$i ?>" class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
 <td><?php echo ($i + 1); ?></td>
  <td><?php echo "<span id='db_ssid".$i."'>".$result->recharge_id."</span>"; ?></td> 
  <td><?php echo "<span id='db_ssid".$i."'>".$result->operator_id."</span>"; ?></td>
 <td><?php echo "<span id='db_date".$i."'>".$result->recharge_date." ".$result->recharge_time."</span>"; ?></td> 
  
 <td><?php echo "<span id='db_company".$i."'>".$result->company_name."</span>"; ?></td> 
 <td><?php echo "<span id='db_mobile".$i."'>".$result->mobile_no."</span>"; ?></td> 
 <td><?php echo "<span id='db_mobile".$i."'>".$result->commission_per."</span>"; ?></td>
 <td><?php echo "<span id='db_amount".$i."'>".$result->amount."</span>"; ?></td>
 	<?php 
	if($result->recharge_status == "Success")
	{
		$total_commission += $result->commission_amount;

		$debit_amount = $result->amount - $result->commission_amount;
	}
	else
	{
		$debit_amount = 0;
	}
	?>
  <td><?php echo "<span id='db_amount".$i."'>".$debit_amount."</span>"; ?></td>
 
  <td>
    <?php if($result->recharge_status == "Pending"){echo "<span id='db_status".$i."' class='orange'>".$result->recharge_status."</span>";} ?>
  <?php if($result->recharge_status == "Success"){echo "<span id='db_status".$i."' class='green'>".$result->recharge_status."</span>";} ?>
  <?php if($result->recharge_status == "Failure"){echo "<span id='db_status".$i."' class='red'>".$result->recharge_status."</span>";} ?>
  </td>
   
  <td align="center"><img src="<?php echo base_url()."images/complain.png" ?>" style="height:15px;width:20px;" onClick="javascript:complainadd('<?php echo $result->recharge_id; ?>')" /></td>
 </tr>
		<?php
		if($result->recharge_status == "Success"){
		$total_amount= $total_amount + $result->amount;}
		$i++;} ?>
		
         <tr class="ColHeader">
    <th></th>
    <th></th>
	<th></th>
    <th></th>
    
   
       <th></th>
    <th></th>
    <th>Total :</th>        
   <th><?php echo $total_amount; ?></th>        
    
    <th><?php echo $total_amount - $total_commission; ?></th>     <th></th>    
	        
	<th></th>
	            
    </tr>        
		</table>
        </div>
       <?php
		}
	   else{
		   echo "<div class='message'>Record Not Found.</div>";
		   }
	   
	   }?>
              </div><!-- card-body -->
            </div>
            
        </div>
        </div>
      </div><!-- br-pagebody -->
  
      <?php include("elements/footer.php"); ?>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

    <script src="<?php echo base_url();?>lib/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>lib/jquery-ui/ui/widgets/datepicker.js"></script>
    <script src="<?php echo base_url();?>lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url();?>lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo base_url();?>lib/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url();?>lib/peity/jquery.peity.min.js"></script>
    <script src="<?php echo base_url();?>lib/highlightjs/highlight.pack.min.js"></script>

    <script src="<?php echo base_url();?>js/bracket.js"></script>
  </body>
</html>
