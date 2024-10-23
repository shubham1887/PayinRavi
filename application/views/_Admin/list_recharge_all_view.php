<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
   <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>List Recharges</title>
    <!-- Bootstrap Core CSS -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="../css/colors/blue.css" id="theme" rel="stylesheet">
    <script src="<?php echo base_url(); ?>js/jquery-1.4.4.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
.ui-datepicker { position: relative; z-index: 10000 !important; }
</style>
 <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
     
          <script>
	 	
$(document).ready(function(){
document.getElementById("ddlstatus").value = '<?php echo $ddlstatus; ?>';
document.getElementById("ddloperator").value = '<?php echo $ddloperator; ?>';
document.getElementById("ddlapi").value = '<?php echo $ddlapi; ?>';

 $(function() {
            $( "#txtFromDate" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtToDate" ).datepicker({dateFormat:'yy-mm-dd'});
         });
		 
		 
	
		 
	setTimeout(function(){window.location.reload(1);}, 50000);	 
		 
		 
		 
		 
		 
		 
		 
});
	
function startexoprt()
{
		$('.DialogMask').show();
		document.getElementById('trmob').style.display = 'table-row';
	
		var from = document.getElementById("txtFromDate").value;
		var to = document.getElementById("txtToDate").value;
	$.ajax({
			url:'<?php echo base_url()."_Admin/list_recharge_all/dataexport"?>?from='+from+'&to='+to,
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
<script type="text/javascript">
    
	function ActionSubmit(value,name)
	{
		if(document.getElementById('action_'+value).selectedIndex != 0)
		{
			var isstatus;
			if(document.getElementById('action_'+value).value == "Success")
			{isstatus = 'Success';}
			else if(document.getElementById('action_'+value).value == "Failure")
			{isstatus='Failure';}
			else if(document.getElementById('action_'+value).value == "Pending")
			{isstatus='Pending';}
			
			if(confirm('Are you sure?\n you want to '+isstatus+' rechrge for - ['+name+']')){
				document.getElementById('hidstatus').value= document.getElementById('action_'+value).value;
				document.getElementById('hidrechargeid').value= value;	
				document.getElementById('hidid').value= "req to get";
							
				document.getElementById('frmCallAction').submit();
				}
		}
	}
	
</script>
</head>
<body class="fix-header card-no-border logo-center">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!--<div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>-->
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php include("files/header.php"); ?>
        
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php include("files/sidebar.php"); ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">PENDING RECHARGES</h3>
                        
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>Total Payment</small></h6>
                                    <h4 class="m-t-0 text-info">58,356</h4></div>
                                
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>Payment Revert</small></h6>
                                    <h4 class="m-t-0 text-primary">100</h4></div>
                                
                            </div>
                            <div class="">
                                <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                
               <div class="row">
                    
                    <!-- column -->
                    <div class="col-12">
                    	<div class="card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">SEARCH REPORT</h4>
                                <div class="table-responsive">
                                    
                                    <form action="<?php echo base_url()."_Admin/list_recharge_all" ?>" method="post" name="frmsubmit" id="frmsubmit">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    <td style="padding-right:10px;">
                                        	 <label>From Date</label>
                                            <input class="form-control-sm" id="txtFromDate" name="txtFromDate" type="text" value="<?php echo $from; ?>" style="width:120px;" placeholder="Select Date">
                                        </td>
                                    	<td style="padding-right:10px;">
                                        	 <label>To Date</label>
                                            <input class="form-control-sm" id="txtToDate" name="txtToDate" type="text" value="<?php echo $to; ?>" style="width:120px;" placeholder="Select Date">
                                        </td>
                                        
                                        <td style="padding-right:10px;">
                                        	 <label>Status</label>
                                           <select id="ddlstatus" name="ddlstatus" class="form-control-sm">
                                           	<option value="ALL">ALL</option>
                                            <option value="Success">Success</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Failure">Failure</option>
                                            
                                           </select>
                                        </td>
                                         <td style="padding-right:10px;">
                                        	 <label>API</label>
                                           <select id="ddlapi" name="ddlapi" class="form-control-sm">
                                           	<option value="ALL">ALL</option>
                                            <?php $rsltapi = $this->db->query("select * from tblapi order by api_name");
											foreach($rsltapi->result() as $r)
											{ ?>
                                            <option value="<?php echo $r->api_name; ?>"><?php echo $r->api_name; ?></option>
                                            <?php } ?>
                                           </select>
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <label>Operator</label>
                                           <select id="ddloperator" name="ddloperator" class="form-control-sm">
                                           	<option value="ALL">ALL</option>
                                            <?php $rsltcompany = $this->db->query("select * from tblcompany order by company_name");
											foreach($rsltcompany->result() as $r)
											{ ?>
                                            <option value="<?php echo $r->company_id; ?>"><?php echo $r->company_name; ?></option>
                                            <?php } ?>
                                           </select>
                                        </td>
                                        
                                        
                                        <td valign="bottom">
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" class="btn btn-primary">
                                       
                                        </td>
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                    
                    
           
                    </div>
                    <!-- column -->
                
                 </div>
                 
                 <div class="row">
                
                </div>
                <div class="row">
                    
                    <!-- column -->
                    
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Recharge List</h4>
                                <div class="table-responsive">
                                    <table class="table  table-striped table-bordered mytable-border" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
    <tr>  
    
    <th>Rec.Id</th>
    <th>Ew.Id</th>
     <th>Transaction Id</th>  
     <th >Rec. Date</th>
     <!--<th >Update. Time</th>-->
     <th  >Agent Name</th>
      
     <th >Company Name</th>
	 <th >Mobile No</th>    
	 <th style="width: 70px">Amt</th>  
     <th >Balance</th>    
   	 <th style="width: 80px;">API</th>    
	 <th >Rec.By</th>
   	 <th>Status</th> 
                    
    </tr>
    <?php $totalRecharge = 0;	$i = count($result_recharge->result());foreach($result_recharge->result() as $result) 	{  ?>
    
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>" style="border-top: 1px solid #000;">
           
 <td ><a href="<?php echo base_url()."recharge_detail/index/".$this->Common_methods->encrypt($result->recharge_id); ?>" target="_blank"><?php echo $result->recharge_id; ?></a></td>
 <td ><a href="<?php echo base_url()."_Admin/check_transaction/index/".$result->recharge_id; ?>" target="_blank"><?php echo $result->ewallet_id; ?></a></td>
 
  
  
  
  <td><?php echo $result->transaction_id."<br>".$result->operator_id; ?></td>
  
  
  
 <td><?php echo $result->add_date; ?></td>
 <!-- <td><?php echo $result->update_time; ?></td>-->
 <td><?php echo $result->businessname."<br>".$result->username; ?></td>

 <td><?php echo $result->company_name; ?></td>
 <td><?php echo $result->mobile_no; ?></td>
 <td><?php echo $result->amount; ?></td>
 <td><?php echo $result->balance; ?></td>
 <td>
 <?php 
 	if($result->ExecuteBy == "test")
 	{
 		echo "Payworld";
 	}
 	else
 	{
 		echo $result->ExecuteBy;
 	} 
 ?>
 </td>
 <td><?php echo $result->recharge_by; ?></td>
 <td>
 <?php if($result->recharge_status == 'Pending'){echo "<span class='btn btn-warning'>Pending</span>";}
 if($result->recharge_status == 'Success')
 {
 	$totalRecharge += $result->amount;echo "<span class='btn btn-success'>Success</span>";
 }
 if($result->recharge_status == 'Failure')
 {
 	echo "<span class='btn btn-danger'>
 Failure</span>";
 }
 
 
 ?></td>
  
  
 </tr>
		<?php 	
		$i--;} ?>
        <tr class="ColHeader" style="background-color:#CCCCCC;">  
    
    <th></th>  
      <th></th>  
      <th > </th>
     <th  > </th>
     <th > </th>
      <!--<th > </th>-->
      <th > </th>
       
	 <th >Total </th>    
	 <th ><?php echo $totalRecharge; ?></th>    
   	 <th></th>   
			<th > </th>
	 <th > </th>
   	 
         <th></th>                   
    </tr>
		</table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <?php include("files/rightbar.php"); ?>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">
                © 2019 TULSYANRECHARGE.COM
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
        <!-- end wrapper -->
    <input type="hidden" id="hidgetlogurl" value="<?php echo base_url()."_Admin/getutils"; ?>">
    <!-- Core Scripts - Include with every page -->
   <form id="frmexport" name="frmexport" action="<?php echo base_url()."_Admin/list_recharge/dataexport" ?>" method="get">
                                    <input type="hidden" id="hidfrm" name="from">
                                    <input type="hidden" id="hidto" name="to">
                                    <input type="hidden" id="hiddb" name="db">
                                    
                                    </form>
 
	
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
   <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/plugins/popper/popper.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="../js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="../assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="../js/custom.min.js"></script>
    <!-- jQuery peity -->
    <script src="../assets/plugins/peity/jquery.peity.min.js"></script>
    <script src="../assets/plugins/peity/jquery.peity.init.js"></script>
   
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="../assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
    <style>
	 
	  
	.divsmcontainer {
    padding: 10px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 5px;
}  
	  
.alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
}
.message
{
	padding: 20px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
}
.alert.success {background-color: #4CAF50;}
.alert.info {background-color: #2196F3;}
.alert.warning {background-color: #ff9800;}
.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}
.closebtn:hover {
    color: black;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}
</style>
</body>
</html>