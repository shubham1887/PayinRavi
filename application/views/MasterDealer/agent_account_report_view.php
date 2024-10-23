<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MasterDealer::RETAILER ACCOUNT REPORT</title>
      <?php include("files/links.php"); ?>
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
     <script>
	 	
$(document).ready(function(){
document.getElementById("ddlUser").value = '<?php echo $user; ?>';
 $(function() {
            $( "#txtFrom" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
         });
});
	
function startexoprt()
{
		$('.DialogMask').show();
		document.getElementById('trmob').style.display = 'table-row';
		var user = document.getElementById("ddlUser").value;
		var from = document.getElementById("txtFrom").value;
		var to = document.getElementById("txtTo").value;
	$.ajax({
			url:'<?php echo base_url()."MasterDealer/agent_account_report/dataexport"?>?from='+from+'&to='+to+'&user='+user,
			type:'post',
			cache:false,
			success:function(html)
			{
				document.getElementById('trmob').style.display = 'none';
				$('.DialogMask').hide();
				window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html));
    			
			}
			});
}
	
	</script>
<style>
.error
{
	background-color:#D9D9EC;
}
div.DialogMask
{
    padding: 10px;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 50;
    background-color: #606060;
    filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=50);
    -moz-opacity: .5;
    opacity: .5;
}
</style>
</head>

<body>
<div class="DialogMask" style="display:none"></div>
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
                        <table>
                    <tr id="trmob" style="display:none">
    	<td align="center" colspan="2" >
            <img src="<?php echo base_url()."ajax-loader_bert.gif"; ?>"/>
        </td>
        
    </tr><tr id="trmobmsg" style="display:none">
    	<td align="center" colspan="2">
        	<span id="mobmsg" class="mobmsg"></span>
        </td>
        
    </tr></table>
                           <form action="<?php echo base_url()."MasterDealer/agent_account_report" ?>" method="post" name="frmCallAction" id="frmCallAction">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
 <td style="padding-right:10px;">
                                        	 <label>From Date</label>
                                          <select id="ddlUser" name="ddlUser" class="form-control" style="width:150px;">
     <option>Select</option>
     <?php
	 	$rsl = $this->db->query("select user_id,username,businessname from tblusers where usertype_name = 'Distributor' and parentid =? order by businessname",array($this->session->userdata("MdId")));
		foreach($rsl->result() as $row)
		{
			echo "<option value=".$row->user_id.">".$row->businessname."[".$row->username."]</option>";
		}
	  ?>
     </select>
                                        </td>
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
                                        <input type="button" id="btnExport" name="btnExport" value="Export" class="btn btn-success" onClick="startexoprt()">
                                      
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
                          <?php if($result_mdealer != false){ ?>
 <div  align="right">  
 <table>
 <?php 
 	if($result_mdealer->num_rows() > 0){
  if($flagopenclose == 1){?>
    <tr class="row11"><td ><?php echo "<b>Total Pending Recharge : ".$totalPending."</b>"; ?></td></tr>
     <tr class="row11"><td ><?php echo "<b>Clossing Balance : ".$result_mdealer->row(0)->balance."</b>"; ?></td></tr>
     
     <?php } } ?> 
 </table>
 </div>
 <?php 
 	if($result_mdealer->num_rows() > 0){?>
 <h2>Account report From <?php echo $from; ?> To <?php echo $to; ?></h2>
 <?php } ?>
<table class="table table-striped table-bordered table-hover">
    <tr>
    <th >Payment Date</th>
    <th>Payment / Recharge Id</th>
   
    
    <th>Transaction type</th>
   
    <th >Company Name</th>
    <th >Number</th>
    <th >Amount</th>
<th >Status</th>

   
    <th>Credit Amount</th>
    <th>Debit Amount</th>
    <th>Balance</th>
  
    
    </tr>
      <?php 
	if($result_mdealer->num_rows() > 0){
   
   	$i = 0;foreach($result_mdealer->result() as $result) 	{  ?>
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
            <?php
				$company_name = "";
				$recAmount = "";
				$mobile_no = "";
				$recharge_status = "";
				$operator_id = "";
				$transaction_id = "";
				$today_date = $this->common->getMySqlDate();
				 if($result->payment_id > 0)
				 {
					 $payment_id = $result->payment_id;
					 $payment_info = $this->Common_methods->getPaymentInfo($payment_id);
				//	 print_r($payment_info->result());exit;

					// $payment_from = $payment_info->row(0)->dr_usercode;
					 if($result->transaction_type == "PAYMENT")
					 {
					 	 $payment_from = $payment_info->row(0)->dr_usercode;
						 if($payment_from == 0)
						 {
							 $payment_from = "RenaCyber";
						 }
					 }
					
					 else
					 {
						 $payment_from = "";
					 }
					// $payment_from_usertype = $payment_info->row(0)->dr_usertype_name;
				 }
				 else if($result->transaction_type == "SMSCHARGE")
				 {
				 	 $payment_id = 0;
					 $payment_from = "";
				 }
				  else if($result->transaction_type == "Recharge")
				 {
					 $payment_id = $result->recharge_id;
					 $recinfo = $this->db->query("select tblrecharge.recharge_id,tblrecharge.add_date,tblrecharge.recharge_status,tblrecharge.amount,tblrecharge.transaction_id,tblrecharge.operator_id,tblrecharge.mobile_no,(select company_name from tblcompany where tblcompany.company_id = tblrecharge.company_id) as company_name from tblrecharge where tblrecharge.recharge_id = ?",array($result->recharge_id));
					 $company_name = $recinfo->row(0)->company_name;
					 $recAmount = $recinfo->row(0)->amount;
					 $mobile_no = $recinfo->row(0)->mobile_no;
					 $recharge_date = $recinfo->row(0)->mobile_no;
					  $transaction_id = $recinfo->row(0)->transaction_id;
					   $operator_id = $recinfo->row(0)->operator_id;
					  $recharge_status = $recinfo->row(0)->recharge_status;
					 $payment_from = "";
					 $payment_from_usertype = "";
				 }
				 else
				 {
				 	$payment_id = 0;
					$payment_from = "";
				 }
				  $date = date_create($result->add_date);
				//  echo $payment_info->row(0)->dr_usercode;
				  //					print_r($payment_info->result());exit;
			 ?>
            
<td><?php echo $date->format('Y-M-d H:i:s'); ?></td>
 <td ><?php echo $payment_id."<br>".$operator_id; ?></td>

 
  <td><?php echo $result->transaction_type; ?></td>
<?php if($result->transaction_type != "PAYMENT"){ ?>


  <td ><?php echo $company_name; ?></td>
  <td ><?php echo $mobile_no; ?></td>
  <td ><?php echo $recAmount; ?></td>
   <td >
   <?php 
   			if($recharge_status == "Failure")
			{
   				echo "<font style='color:#f00'>".$recharge_status."</font>"; 
			}
			else if($recharge_status == "Success")
			{
				echo "<font style='color:#00CC00'>".$recharge_status."</font>"; 
			}
			else
			{
				echo $recharge_status;
			}
	?>
    </td>
<?php } else { ?>
<td colspan="4"><?php echo $result->description; ?></td>
<?php } ?>
 <td><?php echo $result->credit_amount; ?></td>
  <td><?php echo $result->debit_amount; ?></td>
  <td><?php echo "<b>".$result->balance."</b>"; ?></td>

 </tr>
		<?php 	
		$i++;} ?>
         <?php if($flagopenclose == 1){?>
      <tr><td><?php 
	  if($result_mdealer->row(1)->openingBalance == "")
	  {
		  echo "<b>Opening Balance : 0</b>";
	 }
	 else
	 {
		  echo "<b>Opening Balance : ".$result_mdealer->row(1)->openingBalance."</b>"; 
	 }
	 ?></td></tr> 
      <?php } ?>
      <?php } else{?>
       <tr>
       <td colspan="10">
       <div class='message'> No Records Found</div>
       </td>
       </tr>
      <?php } ?>
		</table>
       <?php  echo $pagination; ?>
<?php } ?>
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
