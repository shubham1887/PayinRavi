<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distributor::RECHARGE REPORT</title>
      <?php include("files/links.php"); ?>
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
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
    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        
        <!-- end navbar top -->

        <!-- navbar side -->
        <?php include("files/distributorheader.php"); ?> 
        <!-- END HEADER SECTION -->



        <!-- MENU SECTION -->
       <?php include("files/distributorsidebar.php"); ?>
        <!-- end navbar side -->
        <!--  page-wrapper -->
          <div id="page-wrapper">
            <div class="row">
                 <!-- page header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Forms</h1>
                </div>
                <!--end page header -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>SEARCH RECHARGE
                            
                        </div>

                        <div class="panel-body">
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
                                        <button type="reset" class="btn btn-success">Reset Button</button>
                                        </td>
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>
                        </div>

                    </div>
                        
                    </div>
                    
                     <!-- End Form Elements -->
                </div>
            </div>
            <div class="row">
                
                <div class="col-lg-12">
                     <!--   Basic Table  -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>RECHARGE LIST
                            
                        </div>

                        <div class="panel-body">
                           <div class="table-responsive">
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
                            </div>
                        </div>

                    </div>
                        
                    </div>
                      <!-- End  Basic Table  -->
                </div>
            </div>
        </div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->

    <!-- Core Scripts - Include with every page -->
   
 
    <script src="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/pace/pace.js"></script>
    <script src="<?php echo base_url();?>assets/scripts/siminta.js"></script>
</body>

</html>
