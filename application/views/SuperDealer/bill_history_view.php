<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MasterDealer::BILL PAYMENT REPORT</title>
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
        <?php include("files/mdheader.php"); ?>  
        <!-- END HEADER SECTION -->



        <!-- MENU SECTION -->
       <?php include("files/mdsidebar.php"); ?>
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
                           <form action="<?php echo base_url()."SuperDealer/bill_history" ?>" method="post" name="frmCallAction" id="frmCallAction">
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
                            <i class="fa fa-fw"></i>BILL LIST
                            
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
<table class="table table-striped table-bordered table-hover">
    <tr>
    <th>Sr No</th>
   <th >Bill ID</th>
   <th >Add Datetime</th>
    <th>Update Date Time</th> 
   <th>Company Name</th>
    <th>Cust Name</th>
    <th>Cust Mob No :</th>            <th>Cust Account No :</th>        
   <th>Amount</th>
    
    <th>Status</th>    
	<th>Response</th>            
        
	        
    </tr>
    <?php	$total_amount=0;$total_commission=0;$i = 0;foreach($result_all->result() as $result) 	{  ?>
			<tr id="<?php echo "Print_".$i ?>" class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
 <td><?php echo ($i + 1); ?></td>
  <td><?php echo "<span id='db_ssid".$i."'>".$result->Id."</span>"; ?></td> 
  <td><?php echo "<span id='db_ssid".$i."'>".$result->add_date."</span>"; ?></td>
 <td><?php echo "<span id='db_date".$i."'>".$result->bilpaydate."</span>"; ?></td> 
  
 <td><?php echo "<span id='db_company".$i."'>".$result->company_name."</span>"; ?></td> 
 <td><?php echo "<span id='db_mobile".$i."'>".$result->cust_name."</span>"; ?></td> 
 <td><?php echo "<span id='db_mobile".$i."'>".$result->cust_mob_no."</span>"; ?></td>
 <td><?php echo "<span id='db_amount".$i."'>".$result->cust_acc_no."</span>"; ?></td>
 	
  <td><?php echo "<span id='db_amount".$i."'>".$result->amount."</span>"; ?></td>
 
  <td>
   <?php echo $result->status; ?>
  </td>
  <td>
   <?php echo $result->admin_remark; ?>
  </td>
 
  
 </tr>
		<?php
		
		$i++;} ?>
		
         <tr class="ColHeader">
    <th></th>
    <th></th>
	<th></th>
    <th></th>
    
   
       <th></th>
    <th></th>
    <th></th>        
   <th></th>        
    
    <th></th>     <th></th>    
	<th></th>          
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
