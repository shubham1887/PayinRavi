<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DISTRIBUTOR::FOS LIST</title>
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
	
function startexoprt()
{
		$('.DialogMask').show();
		document.getElementById('trmob').style.display = 'table-row';
	
		
	$.ajax({
			url:'<?php echo base_url()."Distributor/fos_list/dataexport"?>',
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
        <?php include("files/distributorheader.php"); ?>  
        <!-- END HEADER SECTION -->

        <!-- MENU SECTION -->
       <?php include("files/distributorsidebar.php"); ?>
        <!-- end navbar side -->
<?php 
$dt = $this->common->getmySqlDate();
$rsltopening = $this->db->query("select IFNULL(Sum(balance),0) as balance from tblewallet where Date(add_date) < ? and user_id = ? order by Id desc limit 1",array($dt,$this->session->userdata("DistId")));
$commission_totalrslt = $this->db->query("select IFNULL(Sum(DComm),0) as totalcommission from tblrecharge where tblrecharge.recharge_status = 'Success' and Date(add_date) >=? and Date(add_date) <= ? and tblrecharge.DId = ?",array($dt,$dt,$this->session->userdata("DistId")));
$strpurchase = "select IFNULL(Sum(credit_amount),0) as totalpurchase from tblewallet where tblewallet.transaction_type = 'PAYMENT' and Date(add_date) >=? and Date(add_date) <= ? and tblewallet.user_id = ?  ";
$purchase_totalrslt = $this->db->query($strpurchase,array($dt,$dt,$this->session->userdata("DistId")));
$strtransfer = $this->db->query("SELECT Sum(debit_amount) as totaltransfer FROM `tblewallet` where user_id = ? and transaction_type = 'PAYMENT' and Date(add_date) = ? ",array($this->session->userdata("DistId"),$dt));
		
		
		
		
		
		
		$rsltref = $this->db->query("select IFNULL(Sum(credit_amount),0) as total from tblewallet where transaction_type = 'Recharge_Refund' and Date(tblewallet.add_date) = ? and tblewallet.user_id = ? and tblewallet.recharge_id  NOT IN (select recharge_id from tblrecharge where Date(tblrecharge.add_date) =?)",array($dt,$this->session->userdata("DistId"),$dt));
		
	
		
		
?>
        <!--  page-wrapper -->
          <div id="page-wrapper">
            <div class="row">
                 <!-- page header -->
                <div class="col-lg-12">
                    <div class="page-header">
                     <br>
</div>
                </div>
                <!--end page header -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>SEARCH FOS
                            
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
                           <form action="<?php echo base_url()."Distributor/fos_list" ?>" method="post" name="frmCallAction" id="frmCallAction">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    	<td style="padding-right:10px;">
                                        	 <label>FOS NAME</label>
                                            <input class="form-control" id="txtAGENTName" name="txtAGENTName" type="text" style="width:120px;" placeholder="FOS NAME">
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <label>FOS ID</label>
                                            <input class="form-control" id="txtDistId" name="txtDistId" type="text" style="width:120px;" placeholder="FOS UserName">
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <label>MOBILE NO</label>
                                             <input class="form-control" id="txtMOBILENo" name="txtMOBILENo" type="text" style="width:120px;" placeholder="FOS PASSWORD">
                                        </td>
                                        <td valign="bottom">
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" class="btn btn-primary">
                                        <input type="button" id="btnExport" name="btnExport" value="Export To Excel" class="btn btn-success" onClick="startexoprt()">
                                      
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
                    <div> 
                     <?php
	if ($message != ''){echo "<div class='message'>".$message."</div>"; }
	//echo $this->session->flashdata("message");exit;
	if ($this->session->flashdata("message") != '')
	{?>
	<div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4>	<i class="icon fa fa-check"></i> <?php echo $this->session->flashdata("message"); ?>!</h4>
                  
                  </div>
	 <?php } ?>
                    </div>
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>FOS LIST
                            
                        </div>
                        <div class="panel-body">
                           <div class="table-responsive">
								 
	<table class="table">
    <tr>
  
   <th>Sr No</th>
      <th>FOS Id</th>
    <th >FOS Name</th>
  
    <th>Mobile</th>
   	<th>State</th>   
	<th>City</th> 
    <th>Balance</th> 
    
	<th>
    Login
    </th>
	<th >Action</th>                 
    </tr>
  
                      
       
     <?php 	 $i = 0;foreach($result_dealer->result() as $result) 	{  
    
   
    	
    	
	$balance = $this->Common_methods->getAgentBalance($result->user_id);
	?>
	
    
		<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
 <td><?php echo $i+1; ?></td>
 <td ><?php echo $result->username; ?></td>
<td ><?php echo $result->businessname; ?></td>
  <td ><?php echo $result->mobile_no; ?></td>
 <td ><?php echo $result->state_name; ?></td>
 <td ><?php echo $result->city_name; ?></td>
 <td><?php echo $balance; ?></td>
<td><?php if($result->status == 0){echo "<span class='red'><a href='#' onclick='actionDeactivate(".$result->user_id.",1)'>Deactive</a></span>";}else{echo "<span class='green'><a href='#' onclick='actionDeactivate(".$result->user_id.",0)'>Active</a></span>";} ?>
<script language="javascript">
function actionDeactivate(id,status)
{
	document.getElementById("hiduserid").value = id;
	document.getElementById("hidstatus").value = status;
	document.getElementById("hidaction").value = "Set";
	document.getElementById("frmstatuschange").submit();
}
</script>
<form id="frmstatuschange" action="<?php echo base_url()."Distributor/fos_list"; ?>" method="post">
<input type="hidden" id="hiduserid" name="hiduserid">
<input type="hidden" id="hidstatus" name="hidstatus">
<input type="hidden" id="hidaction" name="hidaction">
</form>
</td>
 <td width="180px">
 
 <a href="<?php echo base_url()."Distributor/fos_edit/process/".$this->Common_methods->encrypt($result->user_id); ?>" title="Edit Franchise"><img src="<?php echo base_url()."images/Edit.PNG"; ?>" border="0" title="Edit Dealer" /></a>   |       
 <?php echo '<a title="Transfer Money" href="'.base_url().'Distributor/add_balance/process/'.$this->Common_methods->encrypt($result->user_id).'/'.$this->Common_methods->encrypt('fos_list').'/'.$this->Common_methods->encrypt('Add').'" class="paging"><img src="'.base_url().'images/money_icon.jpg" style="width:20px;"/></a> | <a title="Revert Transaction" href="'.base_url().'Distributor/add_balance/process/'.$this->Common_methods->encrypt($result->user_id).'/'.$this->Common_methods->encrypt('fos_list').'/'.$this->Common_methods->encrypt('Revert').' " class="paging"><img src="'.base_url().'images/Revert.png" style="width:20px;height:15px;"/></a> |';
	
	
echo '<a title="Transfer Money" href="'.base_url().'Distributor/add_balance2?encrid='.$this->Common_methods->encrypt($result->user_id).'" class="paging"><img src="'.base_url().'files/rupee.png" style="width:20px;"/></a> | ';		
 ?>
 </td>
 </tr>
		<?php 	
		$i++;} ?>
		</table>
       <?php  echo $pagination; ?>
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
